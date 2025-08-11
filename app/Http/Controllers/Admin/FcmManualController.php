<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class FcmManualController extends Controller
{
    public function send(Request $request)
    {
        $fcmToken = $request->input('fcm_token');
        $title = $request->input('title', 'Test Bildirim');
        $body = $request->input('body', 'Bu bir testtir.');
        $data = $request->input('data', []);

        $serviceAccountPath = storage_path('app/firebase-adminsdk.json');
        if (!file_exists($serviceAccountPath)) {
            return response()->json(['error' => 'firebase-adminsdk.json bulunamadı!'], 500);
        }
        $serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);
        $projectId = $serviceAccount['project_id'] ?? null;
        $clientEmail = $serviceAccount['client_email'] ?? null;
        $privateKey = $serviceAccount['private_key'] ?? null;

        if (!$projectId || !$clientEmail || !$privateKey) {
            return response()->json(['error' => 'firebase-adminsdk.json eksik veya hatalı!'], 500);
        }

        // 1) JWT oluştur
        $jwt = $this->createJwt($clientEmail, $privateKey, [
            "https://www.googleapis.com/auth/firebase.messaging"
        ]);
        // 2) Access token al
        $accessToken = $this->fetchAccessToken($jwt);

        if (!$accessToken) {
            return response()->json(['error' => 'Google Access Token alınamadı!'], 500);
        }

        // 3) FCM HTTP v1 endpoint ve payload hazırla
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";
        $payload = [
            "message" => [
                "token" => $fcmToken,
                "notification" => [
                    "title" => $title,
                    "body"  => $body,
                ],
                "data" => $data,
            ]
        ];

        // 4) Bildirim gönder
        $resp = Http::withToken($accessToken)->post($url, $payload);

        if ($resp->successful()) {
            return response()->json([
                'ok' => true,
                'firebase_response' => $resp->json(),
                'sent_payload' => $payload
            ]);
        } else {
            return response()->json([
                'error' => 'FCM bildirimi gönderilemedi!',
                'firebase_error' => $resp->body(),
                'sent_payload' => $payload,
                'http_status' => $resp->status()
            ], 500);
        }
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
            return null;
        }

        return $resp->json('access_token');
    }
}