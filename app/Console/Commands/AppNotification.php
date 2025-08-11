<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AppNotification extends Command
{
    protected $signature = 'ruzgarnet:AppNotification';
    protected $description = 'Check subscription\'s AppNotification date.';

    protected $serviceAccount;
    protected $projectId;
    protected $clientEmail;
    protected $privateKey;

    public function __construct()
    {
        parent::__construct();

        $this->serviceAccount = [
            'project_id' => 'ruzgarplus-2a597',
            'client_email' => 'firebase-adminsdk-fbsvc@ruzgarplus-2a597.iam.gserviceaccount.com',
            'private_key' => "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC9Kqhdn9LX+IiM\n2jc4yZBfOtaj/+tDBefbkxcZSNPYLjcilJFUJfiocNE6sak1CXFiPR+gExEqKY6/\nETAZ2QfuZlCCExLRcCU9QgSSmHvBmW0xpKzZV1pSUbU+OEEQDfBEmTTCLahwIIde\nKOtJXqZWn2/q48saCb0pgS10r7tBbfbbqODj1FnNsAWT7KmDhnrrR04goKhQFcl+\nX3DoKSq2o/GETwP0PXMcsljmsyUHeV23Oua2AvCjX0QV1eXV6MwyMFIpEB3ZM18o\nU9HrpvL2peDNbZrXiiWNLiLXh/KwL2n/+94CuSlaabd4afzCxbTCUjDKYOVpdVZe\nhm8zGqDhAgMBAAECggEAGVQH3RlUOtStO+bP9AuRCB8xtB3FG2FEDTNhqWIF83Ek\nsr2fw9udsrgAW9KD7HUKOHQksuM6riGIWm7ruNpFZJdQekohf+d7JPuc7x/5mg93\n/milOCipEFKeaOlRVNv46sZ0uPcyEWlZlrL15goFTZ3ld1buz9qz+EWyl2gcM4NR\nyVrajXtwqwbmVeFbkP0lZWaTZ6NPaoyfOiSkQS9lMJCnrwLcug5gIP2s1/5+wlMn\nqhwtwnGK8gsl91/8A7lyJG6tQEBR2Cdq/nQOnR+Rd8XMnTt2BC0qX2ZGML3xkZrI\nMvCqmGxRIqsIGdsYk4+mz3xQo97GxisURnPBHn+dDQKBgQDlq1gjYoR0fpCa5tGB\nmBc8NLae6+ohtkEDVBUuLLhhChCv7FCT9H4nLlDwBLpkZ7O372VPIJlce8LxAgVu\n9qctz2ci0cixsl0sXMsZjS6R4V61k62tTvl1JCQT2zZjBol9kKRF8F9kXuIwjnB8\nBgOvSIqGctv5+R6sdi6NNRUTgwKBgQDS2pWI5R2ncm+EcWzqwuQxA8KE1t6FfxPi\nLct1tC+/nD4PvtZjuB9jwWZ2KprC/hBzEZ6S/DZHpNnaDJwdffo7/HqKqDDAa8RI\nCY5ZSVBdXjveB+O3g6EoAaDmJE/cK2clthA4JUl5ZMiXXwsVAi9TIeAq7z1s04Eo\nL3fXMMq4ywKBgQCvAPsuK1mmsvJZNlyaFVxPIhOt0TIc8hVkBeQFxUnRl6vTgYx8\n0SZ3kJFX8yJcc7C8DYzy2HJDyIJoxxOA1C3beFisbZIx5SmeLi8Mj0nXGxXh4l/K\n2Yy4OAvNnZI5rreBmH+0U0882hgcy8zmlGamX+4+OLNqLOu0mnEqZDJlJQKBgQCz\nZrnOZSrK+un5ZUyHnlTrg0hxICTqrsnrKo2vUyVBQZ3oZbYh2FoU1UvphKxy9hpm\n3Xnvk9pXMOMOzKXTzgkoGtTkvt/kCI1TwZW1UFSpbHFBo7LTxJJM6L3Ostyj9uXn\nRzYbn1YZjG/Do2FZeadscyk5Pp8jxf1hhKnRlTkW6wKBgFiQSE46zoRkvBmpw+dZ\nH9V9JLMamX+Ynd3tUqIEZQDZLVA2hgLrIADHayROIHLsdotW4XYBRmM/ueixSIpR\nTtcqxKDKca09pHa58LPyhz38cMiiWW7PS562+cgHqvrx2IDSc8lF72JyfJXttFAp\n2Awjf0BEVUh6fBGEv4zPlSEG\n-----END PRIVATE KEY-----\n"
        ];
        $this->projectId = $this->serviceAccount['project_id'];
        $this->clientEmail = $this->serviceAccount['client_email'];
        $this->privateKey = $this->serviceAccount['private_key'];
    }

    // Base64Url encode
    private function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    // JWT oluşturma (saf PHP ile, RS256)
    private function createJWT($payload)
    {
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        $segments = [
            $this->base64url_encode(json_encode($header)),
            $this->base64url_encode(json_encode($payload))
        ];
        $signing_input = implode('.', $segments);
        openssl_sign($signing_input, $signature, $this->privateKey, 'SHA256');
        return $signing_input . '.' . $this->base64url_encode($signature);
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
        $jwt = $this->createJWT($payload);

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

    // Firestore users koleksiyonundan fcm_token'ı olan kullanıcıları getir
    private function getUsersWithFcmToken($accessToken)
    {
        $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents:runQuery";
        $query = [
            "structuredQuery" => [
                "from" => [
                    ["collectionId" => "users"]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($query));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json"
        ]);
        $response = curl_exec($ch);

        file_put_contents(storage_path('logs/firestore_last_response.json'), $response);
        $this->info("[DEBUG] Firestore yanıtı: $response");

        if ($response === false) {
            throw new \Exception("Firestore isteği başarısız: " . curl_error($ch));
        }
        curl_close($ch);

        $documents = [];
        $arr = json_decode($response, true);
        if (!is_array($arr)) {
            $this->warn("[DEBUG] Yanıt array değil!");
            return [];
        }
        foreach ($arr as $obj) {
            if (isset($obj['document'])) {
                $fields = $obj['document']['fields'] ?? [];
                if (isset($fields['fcm_token']['stringValue']) && !empty($fields['fcm_token']['stringValue'])) {
                    $documents[] = $obj['document'];
                }
            }
        }
        $this->info("[DEBUG] Firestore'dan dönen belge sayısı: " . count($documents));
        if (count($documents) > 0) {
            $this->info("[DEBUG] İlk belge örneği: " . json_encode($documents[0]));
        }
        return $documents;
    }

    // FCM HTTP v1 ile bildirim gönder
    private function sendFcmNotification($fcmToken, $accessToken, $title, $body)
    {
        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";
        $payload = [
            "message" => [
                "token" => $fcmToken,
                "notification" => [
                    "title" => $title,
                    "body" => $body,
                ],
                "android" => [
                    "priority" => "high"
                ],
                "data" => []
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
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

    // Firestore'da kullanıcının push_status'unu güncelle
    private function setPushStatusInFirestore($userId, $accessToken, $status)
    {
        $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/users/{$userId}?updateMask.fieldPaths=push_status&updateMask.fieldPaths=uninstalled_at";
        $body = [
            "fields" => [
                "push_status" => ["stringValue" => $status],
                "uninstalled_at" => ["timestampValue" => gmdate('Y-m-d\TH:i:s\Z')],
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json"
        ]);
        $response = curl_exec($ch);
        if ($response === false) {
            $this->warn("Firestore güncelleme hatası: $userId - " . curl_error($ch));
        }
        curl_close($ch);
    }

    public function handle()
    {
        $this->info("[DEBUG] Komut çalıştırıldı, access token alınmaya çalışılıyor...");
        $accessToken = $this->getAccessToken();
        $this->info("[DEBUG] Access token başarıyla alındı.");

        // Bildirim gönderilecek Appnoti kayıtlarını çek
        $now = date('Y-m-d H:i:s');
        $pendingNotifications = DB::table('app_noti')
            ->where('sent', 0)
            ->where('notify_time', '<=', $now)
            ->get();

        $this->info("[DEBUG] Gönderilecek bildirim sayısı: " . $pendingNotifications->count());

        if ($pendingNotifications->count() === 0) {
            $this->info("[DEBUG] Gönderilecek bildirim yok.");
            return self::SUCCESS;
        }

        // Kullanıcıları çek
        $documents = $this->getUsersWithFcmToken($accessToken);

        foreach ($pendingNotifications as $notification) {
            $title = $notification->title;
            $body = $notification->body;
            $notificationId = $notification->id;

            $count = 0;
            foreach ($documents as $doc) {
                $fields = $doc['fields'] ?? [];
                $fcmToken = isset($fields['fcm_token']['stringValue']) ? $fields['fcm_token']['stringValue'] : null;
                $nameParts = explode('/', $doc['name']);
                $userId = end($nameParts);

                if (!$fcmToken) continue;

                $result = $this->sendFcmNotification($fcmToken, $accessToken, $title, $body);

                if (!$result['success']) {
                    if (
                        stripos($result['error'], 'UNREGISTERED') !== false ||
                        stripos($result['error'], 'INVALID_ARGUMENT') !== false ||
                        stripos($result['error'], 'Requested entity was not found') !== false
                    ) {
                        $this->setPushStatusInFirestore($userId, $accessToken, "inactive");
                    }
                } else {
                    $this->setPushStatusInFirestore($userId, $accessToken, "active");
                }
                $count++;
            }

            // Bildirim gönderildiyse sent=1 yap
            DB::table('app_noti')->where('id', $notificationId)->update(['sent' => 1]);
            $this->info("[DEBUG] Bildirim gönderildi ve sent=1 olarak işaretlendi. Bildirim başlığı: $title");
        }

        $this->info("[DEBUG] Tüm uygun kullanıcılara bildirimler gönderildi.");
        return self::SUCCESS;
    }
}