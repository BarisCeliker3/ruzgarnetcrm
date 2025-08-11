<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class WifiControl extends Command
{
    protected $signature = 'ruzgarnet:wifi-control';
    protected $description = "Firestore'daki FCM token'lara mesaj göndererek (cron ile) internet var/yok kontrolü yapar.";

    public function handle()
    {
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

        // Google OAuth2 access token al
        $jwt = $this->createJwt($clientEmail, $privateKey, [
            "https://www.googleapis.com/auth/firebase.messaging",
            "https://www.googleapis.com/auth/datastore"
        ]);
        $accessToken = $this->fetchAccessToken($jwt);

        if (!$accessToken) {
            $this->error('Google Access Token alınamadı!');
            return 1;
        }

        // Firestore users koleksiyonu endpoint
        $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents/users";
        $response = Http::withToken($accessToken)->get($url);

        if (!$response->successful()) {
            $this->error('Firestore users çekilemedi: ' . $response->body());
            return 1;
        }

        $users = $response->json('documents');
        if (!$users) {
            $this->info('Kullanıcı yok.');
            return 0;
        }

        foreach ($users as $user) {
            $fields = $user['fields'] ?? [];
            $userId = basename($user['name']); // doküman id
            $fcmToken = $fields['fcm_token']['stringValue'] ?? null;

            if ($fcmToken) {
                $result = $this->sendFcmTestMessage($accessToken, $projectId, $fcmToken)
                    ? "internet var"
                    : "internet yok";
                $this->line("Kullanıcı: $userId -> $result");
            } else {
                $this->line("Kullanıcı: $userId -> FCM Token bulunamadı.");
            }
        }
        return 0;
    }

    /**
     * FCM token'a test mesajı gönder.
     * Başarılı olursa true, hata olursa false döner.
     */
    private function sendFcmTestMessage($accessToken, $projectId, $fcmToken)
    {
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";
        $payload = [
            "message" => [
                "token" => $fcmToken,
                "notification" => [
                    "title" => "Bağlantı Testi",
                    "body" => "Bu bir internet testi mesajıdır."
                ],
                // "data" => ["control" => "ping"] // opsiyonel
            ]
        ];

        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->post($url, $payload);

        return $response->successful();
    }

    // JWT oluştur
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
            return null;
        }

        return $resp->json('access_token');
    }
}