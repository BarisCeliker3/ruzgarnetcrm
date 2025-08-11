<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class WifiStatusController extends Controller
{
    // FLUTTER'DAN GELEN PONG'U FIRESTORE'A KAYDEDER (ALANLAR YOKSA EKLER)
    public function store(Request $request)
    {
        $deviceId  = $request->input('device_id');
        $requestId = $request->input('requestId');
        $timestamp = $request->input('timestamp');

        if (!$deviceId || !$requestId || !$timestamp) {
            return response()->json(['error' => 'Eksik parametre!'], 400);
        }

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

        $jwt = $this->createJwt($clientEmail, $privateKey, [
            "https://www.googleapis.com/auth/firebase.messaging",
            "https://www.googleapis.com/auth/datastore"
        ]);
        $accessToken = $this->fetchAccessToken($jwt);

        if (!$accessToken) {
            return response()->json(['error' => 'Google Access Token alınamadı!'], 500);
        }

        $payload = [
            "fields" => [
                "last_pong_request_id" => ["stringValue" => (string)$requestId],
                "last_pong_at"         => ["timestampValue" => (string)$timestamp],
            ]
        ];

        // PATCH ile güncelle (varsa ekler, yoksa hata döner)
        $docUrl = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/users/{$deviceId}?updateMask.fieldPaths=last_pong_request_id&updateMask.fieldPaths=last_pong_at";
        $resp = Http::withToken($accessToken)->patch($docUrl, $payload);

        // Eğer doküman yoksa (404), POST ile oluştur
        if ($resp->status() == 404) {
            $docUrl = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/users?documentId={$deviceId}";
            $resp = Http::withToken($accessToken)->post($docUrl, $payload);
        }

        // Hata veya başarı durumunda Firestore cevabını göster
        if ($resp->successful()) {
            return response()->json([
                'ok' => true,
                'firebase_response' => $resp->json(),
                'sent_payload' => $payload,
                'doc_url' => $docUrl
            ]);
        } else {
            return response()->json([
                'error' => 'Firestore güncellenemedi!',
                'firebase_error' => $resp->body(),
                'sent_payload' => $payload,
                'doc_url' => $docUrl,
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