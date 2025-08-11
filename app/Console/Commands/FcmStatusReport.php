<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class FcmStatusReport extends Command
{
    protected $signature = 'fcm:status-report';
    protected $description = "Aile tipindeki kullanıcılara, kendi çocuklarının internet ve uygulama durumunun özetini toplu bildirim olarak iletir.";

    private $projectId;

    public function handle()
    {
        $serviceAccountPath = storage_path('app/firebase-adminsdk.json');
        if (!file_exists($serviceAccountPath)) {
            $this->error('[DEBUG] firebase-adminsdk.json bulunamadı: ' . $serviceAccountPath);
            return 1;
        }

        $serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);
        $this->projectId = $serviceAccount['project_id'] ?? null;
        $clientEmail = $serviceAccount['client_email'] ?? null;
        $privateKey = $serviceAccount['private_key'] ?? null;

        if (!$this->projectId || !$clientEmail || !$privateKey) {
            $this->error('[DEBUG] firebase-adminsdk.json eksik veya hatalı!');
            return 1;
        }

        $this->info('[DEBUG] Service account yüklendi. Project: ' . $this->projectId);

        $jwt = $this->createJwt($clientEmail, $privateKey, [
            "https://www.googleapis.com/auth/firebase.messaging",
            "https://www.googleapis.com/auth/datastore"
        ]);
        $accessToken = $this->fetchAccessToken($jwt);

        if (!$accessToken) {
            $this->error('[DEBUG] Google Access Token alınamadı!');
            return 1;
        }

        // USERS KOLEKSİYONU
        $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/users";
        $response = Http::withToken($accessToken)->get($url);
        $users = $response->json('documents') ?? [];

        $this->info('[DEBUG] Toplam kullanıcı sayısı: ' . count($users));

        $allUsers = [];
        foreach ($users as $user) {
            $fields = $user['fields'] ?? [];
            $userId = basename($user['name']);
            $parentId = $fields['parent_id']['integerValue'] ?? $fields['parent_id']['stringValue'] ?? null;
            $userType = $fields['user_type']['stringValue'] ?? null;
            $customerName = $fields['appcustomer_name']['stringValue'] ?? null;
            $fcmToken = $fields['fcm_token']['stringValue'] ?? null;
            $firestoreNamePath = $user['name'] ?? null; // Firestore doküman yolunu sakla

            $this->info("[DEBUG] User: $userId | parentId: $parentId | user_type: $userType | fcm_token: " . ($fcmToken ? 'Var' : 'Yok') . " | appcustomer_name: " . ($customerName ?? 'Yok'));

            $allUsers[] = [
                'userId' => $userId,
                'parentId' => $parentId,
                'fields' => $fields,
                'user_type' => $userType,
                'appcustomer_name' => $customerName,
                'fcm_token' => $fcmToken,
                'firestore_path' => $firestoreNamePath
            ];
        }

        // 1. Aile kullanıcılarını bul
        $parents = array_filter($allUsers, function($user) {
            return isset($user['user_type']) && $user['user_type'] === 'Aile';
        });

        $this->info('[DEBUG] Aile kullanıcı sayısı: ' . count($parents));

        foreach ($parents as $parent) {
            $parentId = $parent['userId'];
            $parentFcmToken = $parent['fields']['fcm_token']['stringValue'] ?? null;
            $parentName = $parent['appcustomer_name'] ?? $parentId;

            $this->info("[DEBUG] --- Aile kullanıcısı: $parentName ($parentId) ---");

            $children = array_filter($allUsers, function($user) use ($parentId) {
                return isset($user['parentId']) && $user['parentId'] == $parentId;
            });

            $this->info("[DEBUG] $parentName ($parentId) ailesine bağlı çocuk sayısı: " . count($children));

            $statusList = [];
            foreach ($children as $child) {
                $childName = $child['appcustomer_name'] ?? $child['userId'];
                $lastPingSentAt = $child['fields']['last_ping_sent_at']['timestampValue'] ?? null;
                $lastOnline = $child['fields']['last_online']['timestampValue'] ?? null;
                $lastPingRequestId = $child['fields']['last_ping_request_id']['stringValue'] ?? null;
                $lastPongRequestId = $child['fields']['last_pong_request_id']['stringValue'] ?? null;
                $isAppOpen = $child['fields']['is_app_open']['booleanValue'] ?? null;
                $fcmTokenChild = $child['fcm_token'] ?? null;
                $firestorePath = $child['firestore_path'];

                // 1. INTERNET DURUMU: ping-pong ile belirle
                $internetVar = false;
                if ($lastPingSentAt && $lastOnline && $lastPingRequestId && $lastPongRequestId) {
                    if ($lastPingRequestId === $lastPongRequestId) {
                        $pingTime = Carbon::parse($lastPingSentAt);
                        $pongTime = Carbon::parse($lastOnline);
                        $diff = $pongTime->diffInSeconds($pingTime);
                        if ($diff <= 60) $internetVar = true;
                    }
                }
                $this->updateFirestoreOnlineStatus($firestorePath, $internetVar, $accessToken);

                // 2. UYGULAMA YÜKLÜ MÜ: FCM bildirimi ile belirle
                $appUninstalled = null;
                if ($fcmTokenChild) {
                    $testResult = $this->sendFcmNotification($fcmTokenChild, $accessToken, "Durum Testi", "Ping", ["test" => "app_uninstall_check"]);
                    if (!empty($testResult['unregistered'])) {
                        $appUninstalled = true;
                    } else {
                        $appUninstalled = false;
                    }
                    $this->updateFirestoreAppUninstalled($firestorePath, $appUninstalled, $accessToken);
                } else {
                    $appUninstalled = true;
                    $this->updateFirestoreAppUninstalled($firestorePath, true, $accessToken);
                }

                // Sonuçları alt alta düzenle
                $statusLines = [];
                $statusLines[] = $childName . " :";
                $statusLines[] = $internetVar ? " - internet açık" : " - internet kapalı";
                if ($appUninstalled === true) {
                    $statusLines[] = " - uygulama kaldırılmış";
                } else {
                    $statusLines[] = " - uygulama yüklü";
                }
                if ($isAppOpen !== null) {
                    $statusLines[] = $isAppOpen ? " - uygulama açık" : " - uygulama kapalı";
                }

                $comboStatus = implode("\n", $statusLines);
                $statusList[] = $comboStatus;
            }

            // Bildirimde alt alta göstermek için "\n\n" ile birleştir:
            if ($parentFcmToken && count($statusList)) {
                $title = "Çocukların Durumu";
                $body = implode("\n\n", $statusList);
                $data = [
                    "notification_type" => "internet_status_summary",
                    "type" => "pong_status_report",
                    "user_id" => $parentId,
                    "status_summary" => $body,
                    "title" => $title
                ];
                $this->info("[DEBUG] Bildirim -> $parentName ($parentId): $body");
                $result = $this->sendFcmNotification($parentFcmToken, $accessToken, $title, $body, $data);
                $this->info("[DEBUG] FCM Sonuç: " . json_encode($result));
            } else if (!$parentFcmToken) {
                $this->info("[DEBUG] $parentName ($parentId) için fcm_token YOK, bildirim gönderilmedi!");
            } else if (!count($statusList)) {
                $this->info("[DEBUG] $parentName ($parentId) için bağlı çocuk YOK, bildirim gönderilmedi!");
            }
        }

        $this->info('[DEBUG] Rapor tamamlandı.');
        return 0;
    }

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
                    "priority" => "high",
                    "notification" => [
                        "sound" => "noti"
                    ]
                ],
                "data" => $data
            ]
        ];

        $this->info("[DEBUG] FCM gönderim datası: " . json_encode($message, JSON_UNESCAPED_UNICODE));

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
            $this->error('[DEBUG] FCM göndermede cURL hatası: ' . curl_error($ch));
            return ['success' => false, 'error' => curl_error($ch)];
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $json = json_decode($response, true);
        curl_close($ch);

        $this->info("[DEBUG] FCM HTTP code: $httpCode | response: $response");

        // Gelişmiş uninstall hatası yakalama:
        $unregistered = false;
        if (isset($json['error'])) {
            $errMsg = $json['error']['message'] ?? '';
            $errorDetails = $json['error']['details'] ?? [];

            // 1. Eski yöntem (NotRegistered, InvalidRegistration)
            if (
                stripos($errMsg, 'NotRegistered') !== false ||
                stripos($errMsg, 'InvalidRegistration') !== false
            ) {
                $unregistered = true;
            }

            // 2. Yeni yöntem (errorCode: UNREGISTERED)
            foreach ($errorDetails as $detail) {
                if (
                    isset($detail['errorCode']) &&
                    strtoupper($detail['errorCode']) === 'UNREGISTERED'
                ) {
                    $unregistered = true;
                }
            }

            if ($unregistered) {
                $this->error("[UNREGISTERED TOKEN] Kullanıcıya ait FCM token geçersiz veya kayıtlı değil! Hata: $errMsg | Token: $fcmToken");
            }
        }

        if ($httpCode >= 200 && $httpCode < 300) {
            return ['success' => true, 'error' => null, 'raw' => $response, 'unregistered' => $unregistered];
        } else {
            $error = $json['error']['message'] ?? $response;
            $this->error('[DEBUG] FCM gönderim hatası: ' . $error);
            return ['success' => false, 'error' => $error, 'raw' => $response, 'unregistered' => $unregistered];
        }
    }

    // Firestore'a app_uninstalled alanı güncelleme fonksiyonu
    private function updateFirestoreAppUninstalled($firestorePath, $uninstalled, $accessToken)
    {
        $url = "https://firestore.googleapis.com/v1/$firestorePath?updateMask.fieldPaths=app_uninstalled";
        $body = [
            "fields" => [
                "app_uninstalled" => [
                    "booleanValue" => $uninstalled ? true : false
                ]
            ]
        ];
        $response = Http::withToken($accessToken)->patch($url, $body);
        $this->info("[DEBUG] Firestore app_uninstalled güncelleme response: " . $response->body());
        $this->info("[DEBUG] Firestore güncelleme HTTP code: " . $response->status());
        return $response->successful();
    }

    // Firestore'a online alanı güncelleme fonksiyonu
    private function updateFirestoreOnlineStatus($firestorePath, $online, $accessToken)
    {
        $url = "https://firestore.googleapis.com/v1/$firestorePath?updateMask.fieldPaths=online";
        $body = [
            "fields" => [
                "online" => [
                    "booleanValue" => $online ? true : false
                ]
            ]
        ];
        $response = Http::withToken($accessToken)->patch($url, $body);
        $this->info("[DEBUG] Firestore online güncelleme response: " . $response->body());
        $this->info("[DEBUG] Firestore güncelleme HTTP code: " . $response->status());
        return $response->successful();
    }

    private function createJwt($clientEmail, $privateKey, $scopes = [])
    {
        $now = time();
        $exp = $now + 3600;
        $payload = [
            "iss" => $clientEmail,
            "scope" => implode(' ', $scopes),
            "aud" => "https://oauth2.googleapis.com/token",
            "iat" => $now,
            "exp" => $exp,
        ];
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        $base64UrlHeader = rtrim(strtr(base64_encode(json_encode($header)), '+/', '-_'), '=');
        $base64UrlPayload = rtrim(strtr(base64_encode(json_encode($payload)), '+/', '-_'), '=');

        $data = $base64UrlHeader . '.' . $base64UrlPayload;
        if (strpos($privateKey, "-----BEGIN PRIVATE KEY-----") === false) {
            $privateKey = "-----BEGIN PRIVATE KEY-----\n" . chunk_split($privateKey, 64, "\n") . "-----END PRIVATE KEY-----";
        }
        openssl_sign($data, $signature, $privateKey, 'sha256');
        $base64UrlSignature = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

        return $data . '.' . $base64UrlSignature;
    }

    private function fetchAccessToken($jwt)
    {
        $resp = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);
        if (!$resp->successful()) {
            $this->error('[DEBUG] Google Token alma hatası: ' . $resp->body());
            return null;
        }
        return $resp->json('access_token');
    }
}