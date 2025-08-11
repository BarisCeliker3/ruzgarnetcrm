<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FcmPingUsers extends Command
{
    protected $signature = 'fcm:ping-users';
    protected $description = "FCM ile tüm kullanıcılara ping atar ve Firestore'a request_id yazar.";

    public function handle()
    {
        $this->info('Başlıyor...');
        $serviceAccountPath = storage_path('app/firebase-adminsdk.json');
        if (!file_exists($serviceAccountPath)) {
            $this->error('firebase-adminsdk.json bulunamadı: ' . $serviceAccountPath);
            return 1;
        }
        $serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);
        $projectId = $serviceAccount['project_id'] ?? null;
        $clientEmail = $serviceAccount['client_email'] ?? null;
        $privateKey = $serviceAccount['private_key'] ?? null;
        if (!$projectId || !$clientEmail || !$privateKey) {
            $this->error('firebase-adminsdk.json eksik veya hatalı!');
            return 1;
        }

        $jwt = $this->createJwt($clientEmail, $privateKey, [
            "https://www.googleapis.com/auth/firebase.messaging",
            "https://www.googleapis.com/auth/datastore"
        ]);
        $accessToken = $this->fetchAccessToken($jwt);
        if (!$accessToken) {
            $this->error('Google Access Token alınamadı!');
            return 1;
        }

        // 1. Firestore users koleksiyonu endpoint
        $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents/users";
        $response = Http::withToken($accessToken)->get($url);
        if (!$response->successful()) {
            $this->error('Firestore users çekilemedi: ' . $response->body());
            return 1;
        }
        $users = $response->json('documents') ?? [];
        $this->info('Toplam Firestore dokümanı: ' . count($users));

        foreach ($users as $user) {
            $fields = $user['fields'] ?? [];
            $docId = basename($user['name']);

            // docId doğrudan user_id (sadece rakamlar)
            if (!preg_match('/^\d+$/', $docId)) {
                $this->warn("docId formatı beklenmedik: $docId (Atlandı)");
                continue;
            }
            $userId = $docId;

            // Kullanıcıya özel rastgele requestId üret
            $requestId = (string) Str::uuid();

            // Firestore'a PING yaz
            $patchUrl = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/users/{$docId}?updateMask.fieldPaths=last_ping_sent_at&updateMask.fieldPaths=last_ping_request_id";
            $payload = [
                "fields" => [
                    "last_ping_sent_at" => [ "timestampValue" => Carbon::now()->toIso8601ZuluString() ],
                    "last_ping_request_id" => [ "stringValue" => $requestId ]
                ]
            ];
            $patchResp = Http::withToken($accessToken)->patch($patchUrl, $payload);
            if ($patchResp->successful()) {
                $this->info("Ping yazıldı: $docId, requestId: $requestId");
            } else {
                $this->error("Ping Firestore güncellenemedi: $docId, response: " . $patchResp->body());
                continue;
            }

            // FCM tokenı varsa kullanıcıya ping at
            if (empty($fields['fcm_token']['stringValue'])) {
                $this->warn("FCM Token yok: $docId");
                continue;
            }
            $fcmToken = $fields['fcm_token']['stringValue'];
            $fcmPayload = [
                'to' => $fcmToken,
                'data' => [
                    'type' => 'ping',
                    'requestId' => $requestId,
                    'user_id' => $userId,
                ],
            ];
            $fcmResp = Http::withToken($accessToken)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post('https://fcm.googleapis.com/v1/projects/'.$projectId.'/messages:send', [
                    'message' => [
                        'token' => $fcmToken,
                        'data' => [
                            'type' => 'ping',
                            'requestId' => $requestId,
                            'user_id' => $userId,
                        ]
                    ]
                ]);
            if ($fcmResp->successful()) {
                $this->info("FCM ping gönderildi: $docId, requestId: $requestId");
            } else {
                $this->error("FCM HATA: $docId, response: " . $fcmResp->body());
            }
        }
        $this->info("İşlem tamamlandı.");
    }

    // JWT fonksiyonları aynı
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
            $this->error('Access token alınamadı! Status: '.$resp->status().' Body: '.$resp->body());
            return null;
        }
        return $resp->json('access_token');
    }
}