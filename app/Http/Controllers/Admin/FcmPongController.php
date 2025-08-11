<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class FcmPongController extends Controller
{
    public function pong(Request $request)
    {
        // Flutter'dan şu şekilde POST bekleniyor:
        // { "user_id": "1", "requestId": "...", "timestamp": "..." }
        $userId = $request->input('user_id');
        $requestId = $request->input('requestId');
        $timestamp = $request->input('timestamp'); // Flutter göndermiyorsa null olur

        $serviceAccount = json_decode(file_get_contents(storage_path('app/firebase-adminsdk.json')), true);
        $projectId = $serviceAccount['project_id'];
        $clientEmail = $serviceAccount['client_email'];
        $privateKey = $serviceAccount['private_key'];

        $jwt = $this->createJwt($clientEmail, $privateKey, [
            "https://www.googleapis.com/auth/firebase.messaging",
            "https://www.googleapis.com/auth/datastore"
        ]);
        $accessToken = $this->fetchAccessToken($jwt);

        // Firestore'un beklediği timestamp formatı
        $now = $timestamp ?: gmdate('Y-m-d\TH:i:s.u\Z');

        // Doküman ID: userId (ör: 1)
        $docId = $userId;
        $docUrl = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/users/{$docId}?updateMask.fieldPaths=last_online&updateMask.fieldPaths=last_pong_request_id&updateMask.fieldPaths=user_id";

        // SADECE DOLU ALANLARI EKLE!
        $fields = [
            "user_id" => [ "stringValue" => $userId ],
            "last_online" => [ "timestampValue" => $now ],
        ];
        if ($requestId !== null && $requestId !== '') {
            $fields["last_pong_request_id"] = [ "stringValue" => $requestId ];
        }

        $firestorePayload = [ "fields" => $fields ];

        // Log ile hata takibi için (opsiyonel, istersen kaldır)
        \Log::info('Pong Request:', [
            'input' => $request->all(),
            'payload' => $firestorePayload,
            'docUrl' => $docUrl,
        ]);

        $response = Http::withToken($accessToken)->patch($docUrl, $firestorePayload);

        if (!$response->successful()) {
            \Log::error('Firestore PATCH error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'payload' => $firestorePayload,
                'docUrl' => $docUrl,
            ]);
            return response()->json([
                'status' => 'firestore_error',
                'firestore_response' => $response->body(),
            ], 500);
        }

        return response()->json(['status' => 'ok', 'firestore_response' => $response->json()]);
    }

    // JWT fonksiyonları
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