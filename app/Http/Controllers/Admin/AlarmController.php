<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AlarmController extends Controller
{
    public function sendAlert(Request $request)
    {
        // 1. Flutter'dan gelen kullanıcılar
        $triggerUserId = $request->input('trigger_user_id');
        $targetUserId = $request->input('target_user_id') ?? $request->input('user_id');
        if (!$triggerUserId || !$targetUserId) {
            return response()->json([
                'success' => false,
                'message' => 'trigger_user_id ve target_user_id zorunlu!'
            ], 400);
        }

        // --- Firestore'da hedef kullanıcıyı bul ---
        $serviceAccountPath = storage_path('app/firebase-adminsdk.json');
        if (!file_exists($serviceAccountPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Firebase servis hesabı dosyası bulunamadı!'
            ], 500);
        }
        $serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);
        $projectId = $serviceAccount['project_id'];
        $collection = 'users';

        // --- JWT ile access token alınacak ---
        $client_email = $serviceAccount['client_email'];
        $private_key = $serviceAccount['private_key'];
        $jwtHeader = ['alg' => 'RS256', 'typ' => 'JWT'];
        $now = time();
        $jwtClaim = [
            'iss' => $client_email,
            'scope' => 'https://www.googleapis.com/auth/datastore https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $now + 3600,
        ];

        $jwtHeaderEncoded = rtrim(strtr(base64_encode(json_encode($jwtHeader)), '+/', '-_'), '=');
        $jwtClaimEncoded = rtrim(strtr(base64_encode(json_encode($jwtClaim)), '+/', '-_'), '=');
        $jwtUnsigned = $jwtHeaderEncoded . '.' . $jwtClaimEncoded;

        openssl_sign($jwtUnsigned, $signature, $private_key, 'sha256');
        $jwtSigned = $jwtUnsigned . '.' . rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

        // --- access_token al ---
        $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwtSigned,
        ]);
        if (!$tokenResponse->ok()) {
            return response()->json([
                'success' => false,
                'message' => 'Token alınamadı',
                'detail' => $tokenResponse->body()
            ], 500);
        }
        $accessToken = $tokenResponse->json()['access_token'];

        // --- Firestore'da hedef kullanıcıyı bul ---
        $query = [
            "structuredQuery" => [
                "from" => [
                    ["collectionId" => $collection]
                ],
                "where" => [
                    "fieldFilter" => [
                        "field" => ["fieldPath" => "user_id"],
                        "op" => "EQUAL",
                        "value" => is_numeric($targetUserId)
                            ? ["integerValue" => intval($targetUserId)]
                            : ["stringValue" => $targetUserId]
                    ]
                ],
                "limit" => 1
            ]
        ];

        // !!! access_token ile Firestore sorgusu yap !!!
        $firestoreResp = Http::withToken($accessToken)
            ->post(
                "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents:runQuery",
                $query
            );

        if (!$firestoreResp->ok()) {
            return response()->json([
                'success' => false,
                'message' => 'Firestore API hatası',
                'detail' => $firestoreResp->body()
            ], 500);
        }

        $firestoreData = $firestoreResp->json();
        $doc = null;
        foreach ($firestoreData as $result) {
            if (isset($result['document'])) {
                $doc = $result['document'];
                break;
            }
        }
        if (!$doc) {
            return response()->json([
                'success' => false,
                'message' => 'Kullanıcı bulunamadı!'
            ], 404);
        }

        $fields = $doc['fields'];
        $fcmToken = isset($fields['fcm_token']['stringValue']) ? $fields['fcm_token']['stringValue'] : null;

        if (!$fcmToken) {
            return response()->json([
                'success' => false,
                'message' => 'FCM token yok!'
            ], 404);
        }

        // --- FCM HTTP v1 ile gönder ---
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";
        $title = 'Acil Durum Alarmı!';
        $body = 'Acil durum bildirimi geldi! Hemen kontrol etmelisin.';

        $message = [
            'message' => [
                'token' => $fcmToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => [
                    'type' => 'alarm',
                    'trigger_user_id' => (string)$triggerUserId,
                    'target_user_id' => (string)$targetUserId
                ],
                'android' => [
                    'notification' => [
                        'sound' => 'alarm.mp3',
                    ],
                ],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'sound' => 'alarm.mp3',
                        ],
                    ],
                ],
            ]
        ];

        $fcmResponse = Http::withToken($accessToken)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, $message);

        if ($fcmResponse->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'Alarm bildirimi gönderildi!',
                'trigger_user_id' => $triggerUserId,
                'target_user_id' => $targetUserId
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'FCM hatası: ' . $fcmResponse->body()
            ], 500);
        }
    }
}