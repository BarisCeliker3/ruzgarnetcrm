<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AppMessageController extends Controller
{
    public function sendMessageNotification(Request $request)
    {
        try {
            Log::info('sendMessageNotification çağrıldı', ['request' => $request->all()]);

            $senderId = $request->input('sender_id');
            $receiverId = $request->input('receiver_id');
            $senderName = $request->input('sender_name') ?? 'Yeni Mesaj';
            $text = $request->input('text') ?? '';

            // Firestore'dan alıcının FCM token'ını bul (live_users koleksiyonu)
            $serviceAccountPath = storage_path('app/firebase-adminsdk.json');
            if (!file_exists($serviceAccountPath)) {
                Log::error('Firebase servis hesabı dosyası bulunamadı!', ['path' => $serviceAccountPath]);
                return response()->json([
                    'success' => false,
                    'message' => 'Firebase servis hesabı dosyası bulunamadı!'
                ], 500);
            }
            $serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);
            $projectId = $serviceAccount['project_id'];
            $collection = 'users';

            // JWT ve access token işlemleri
            $client_email = $serviceAccount['client_email'];
            $private_key = $serviceAccount['private_key'];
            $project_id = $serviceAccount['project_id'];

            // JWT oluşturuluyor
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

            $signature = '';
            if (!openssl_sign($jwtUnsigned, $signature, $private_key, 'sha256')) {
                Log::error('JWT imzalanamadı', ['jwtUnsigned' => $jwtUnsigned]);
                return response()->json(['success' => false, 'message' => 'JWT imzalanamadı!'], 500);
            }
            $jwtSigned = $jwtUnsigned . '.' . rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

            Log::info('JWT oluşturuldu');

            // access_token alınıyor
            $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwtSigned,
            ]);
            Log::info('Token yanıtı', [
                'status' => $tokenResponse->status(),
                'body' => $tokenResponse->body(),
            ]);
            if (!$tokenResponse->ok()) {
                Log::error('Token alınamadı', ['response' => $tokenResponse->body()]);
                return response()->json(['success' => false, 'message' => 'Token alınamadı'], 500);
            }
            $accessToken = $tokenResponse->json()['access_token'];

            // Firestore kullanıcı sorgusunu access_token ile yap!
            $query = [
                "structuredQuery" => [
                    "from" => [
                        ["collectionId" => $collection]
                    ],
                    "where" => [
                        "fieldFilter" => [
                            "field" => ["fieldPath" => "user_id"],
                            "op" => "EQUAL",
                            "value" => is_numeric($receiverId)
                                ? ["integerValue" => intval($receiverId)]
                                : ["stringValue" => $receiverId]
                        ]
                    ],
                    "limit" => 1
                ]
            ];

            Log::info('Firestore sorgusu hazırlanıyor', ['query' => $query]);

            $firestoreResp = Http::withToken($accessToken)
                ->post(
                    "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents:runQuery",
                    $query
                );

            Log::info('Firestore yanıtı', [
                'status' => $firestoreResp->status(),
                'body' => $firestoreResp->body(),
            ]);

            if (!$firestoreResp->ok()) {
                Log::error('Firestore API hatası', ['response' => $firestoreResp->body()]);
                return response()->json(['success' => false, 'message' => 'Firestore API hatası'], 500);
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
                Log::warning('Kullanıcı bulunamadı!', ['receiver_id' => $receiverId, 'firestoreData' => $firestoreData]);
                return response()->json(['success' => false, 'message' => 'Kullanıcı bulunamadı!'], 404);
            }
            $fields = $doc['fields'];
            $fcmToken = isset($fields['fcm_token']['stringValue']) ? $fields['fcm_token']['stringValue'] : null;
            if (!$fcmToken) {
                Log::warning('FCM token yok', ['fields' => $fields]);
                return response()->json(['success' => false, 'message' => 'FCM token yok!'], 404);
            }

            // FCM HTTP v1 ile gönder
            $url = "https://fcm.googleapis.com/v1/projects/{$project_id}/messages:send";

            $notification = [
                'message' => [
                    'token' => $fcmToken,
                    'notification' => [
                        'title' => "$senderName: Yeni Mesaj",
                        'body' => $text,
                    ],
                    'data' => [
                        'type' => 'chat',
                        'sender_id' => (string)$senderId,
                        'sender_name' => $senderName,
                        'text' => $text,
                    ],
                    'android' => [
                        'notification' => [
                            'sound' => 'default',
                        ],
                    ],
                    'apns' => [
                        'payload' => [
                            'aps' => [
                                'sound' => 'default',
                            ],
                        ],
                    ],
                ]
            ];

            Log::info('FCM bildirimi gönderiliyor', [
                'url' => $url,
                'notification' => $notification
            ]);

            $fcmResponse = Http::withToken($accessToken)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, $notification);

            Log::info('FCM yanıtı', [
                'status' => $fcmResponse->status(),
                'body' => $fcmResponse->body(),
            ]);

            if ($fcmResponse->successful()) {
                return response()->json(['success' => true, 'message' => 'Bildirim gönderildi!']);
            } else {
                Log::error('FCM hatası', ['response' => $fcmResponse->body()]);
                return response()->json(['success' => false, 'message' => 'FCM hatası', 'fcm_response' => $fcmResponse->body()], 500);
            }
        } catch (\Throwable $e) {
            Log::error('sendMessageNotification genel hata', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Beklenmeyen hata: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}