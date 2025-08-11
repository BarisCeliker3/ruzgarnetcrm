<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PushNotification extends Command
{
    protected $signature = 'ruzgarnet:PushNotification';
    protected $description = "Check subscription's AppNotification date.";

    protected $serviceAccount;
    protected $projectId;
    protected $clientEmail;
    protected $privateKey;

    public function __construct()
    {
        parent::__construct();

        $serviceAccountPath = storage_path('app/firebase-adminsdk.json');
        $this->serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);
        $this->projectId = $this->serviceAccount['project_id'];
        $this->clientEmail = $this->serviceAccount['client_email'];
        $this->privateKey = $this->serviceAccount['private_key'];
    }

    // FCM HTTP v1 ile gerçek bildirim gönder
    private function sendFcmNotification($fcmToken, $accessToken, $title, $body, $data = [])
    {
        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";
        $message = [
            "message" => [
                "token" => $fcmToken,
                "notification" => [
                    "title" => $title,
                    "body" => $body
                ],
                "android" => [
                    "priority" => "high"
                ],
                "data" => $data
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json"
        ]);
        $response = curl_exec($ch);

        if ($response === false) {
            return ['success' => false, 'error' => curl_error($ch)];
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $json = json_decode($response, true);
        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            return ['success' => true, 'error' => null];
        } else {
            $error = $json['error']['message'] ?? $response;
            return ['success' => false, 'error' => $error];
        }
    }

    // Sessiz bildirim gönder (data-only)
    private function sendFcmSilentNotification($fcmToken, $accessToken, $data = [])
    {
        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";
        $message = [
            "message" => [
                "token" => $fcmToken,
                "android" => [
                    "priority" => "high"
                ],
                "data" => $data
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json"
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
    }

    // Firestore'dan FCM tokenlara sahip kullanıcıları çek
    private function getUsersWithFcmToken($accessToken)
    {
        $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/users";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken"
        ]);
        $response = curl_exec($ch);
        if ($response === false) return [];
        $data = json_decode($response, true);
        curl_close($ch);

        return isset($data['documents']) ? $data['documents'] : [];
    }

    // Firestore'a push status kaydet
    private function setPushStatusInFirestore($userId, $accessToken, $status)
    {
        $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/users/{$userId}?updateMask.fieldPaths=push_status";
        $fields = [
            "fields" => [
                "push_status" => [
                    "stringValue" => $status
                ]
            ]
        ];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json"
        ]);
        curl_exec($ch);
        curl_close($ch);
    }

    // Google access token alımı
    private function getAccessToken()
    {
        $now = time();
        $payload = [
            "iss" => $this->clientEmail,
            "scope" => "https://www.googleapis.com/auth/datastore https://www.googleapis.com/auth/firebase.messaging",
            "aud" => "https://oauth2.googleapis.com/token",
            "iat" => $now,
            "exp" => $now + 3600,
        ];

        $jwt = $this->createJWT($payload, $this->privateKey);

        $postFields = http_build_query([
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        $ch = curl_init("https://oauth2.googleapis.com/token");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);
        $response = curl_exec($ch);

        if ($response === false) {
            throw new \Exception("Google access token alınamadı: " . curl_error($ch));
        }
        $result = json_decode($response, true);
        curl_close($ch);

        if (isset($result['access_token'])) {
            return $result['access_token'];
        }

        throw new \Exception("Google access token alınamadı: " . $response);
    }

    // JWT oluşturma fonksiyonu (RS256)
    private function createJWT($payload, $privateKey)
    {
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        $segments = [
            $this->base64url_encode(json_encode($header)),
            $this->base64url_encode(json_encode($payload))
        ];
        $signing_input = implode('.', $segments);
        openssl_sign($signing_input, $signature, $privateKey, 'SHA256');
        return $signing_input . '.' . $this->base64url_encode($signature);
    }

    // base64url encode fonksiyonu
    private function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function handle()
    {
        $accessToken = $this->getAccessToken();
        $documents = $this->getUsersWithFcmToken($accessToken);

        $count = 0;
        foreach ($documents as $doc) {
            $nameParts = explode('/', $doc['name']);
            $userId = end($nameParts);
            $fields = $doc['fields'] ?? [];
            $fcmToken = isset($fields['fcm_token']['stringValue']) ? $fields['fcm_token']['stringValue'] : null;
            if (!$fcmToken) continue;

            // Sessiz bildirim gönder (dilersen kaldırabilirsin)
            $this->sendFcmSilentNotification($fcmToken, $accessToken);

            // GERÇEK BİLDİRİM GÖNDER
            $title = 'Duyuru!';
            $body = 'Uygulamanız başarıyla kontrol edildi. Her şey yolunda.';
            $data = [
                'extra_info' => 'İsteğe bağlı data alanı'
            ];
            $result = $this->sendFcmNotification($fcmToken, $accessToken, $title, $body, $data);

            if (!$result['success']) {
                if (
                    stripos($result['error'], 'UNREGISTERED') !== false ||
                    stripos($result['error'], 'INVALID_ARGUMENT') !== false ||
                    stripos($result['error'], 'Requested entity was not found') !== false
                ) {
                    $this->info("Firestore'da token geçersiz veya uygulama kaldırıldı: Kullanıcı ID: {$userId}");
                    $this->setPushStatusInFirestore($userId, $accessToken, "inactive");
                } else {
                    $this->warn("Bilinmeyen FCM Hatası: Kullanıcı ID: {$userId} - Hata: " . $result['error']);
                }
            } else {
                $this->info("Gerçek bildirim gönderildi: Kullanıcı ID: {$userId}");
                $this->setPushStatusInFirestore($userId, $accessToken, "active");
            }
            $count++;
        }
        $this->info("Firestore'da $count kullanıcıya bildirim gönderildi ve kontrol edildi.");
        return self::SUCCESS;
    }
}