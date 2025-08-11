<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LivebroadcastController extends Controller
{
    public function sendAgoraCall(Request $request)
    {
        // Gerekli parametreler
        $request->validate([
            'sender_id' => 'required',
            'receiver_id' => 'required',
            'room_id' => 'required',
            'role' => 'required',
            
        ]);

        $senderId   = (string)$request->input('sender_id');
        $receiverId = (string)$request->input('receiver_id');
        $roomId     = (string)$request->input('room_id');
        $role       = (string)$request->input('role');
        $userType   = (string)$request->input('userType', 'Çocuk');

        Log::debug("[AGORA] İstek alındı", [
            'senderId' => $senderId,
            'receiverId' => $receiverId,
            'roomId' => $roomId,
           'role'        => 'broadcaster',
            'userType' => $userType,
        ]);

        // Firebase servis hesabı dosyası
        $serviceAccountPath = storage_path('app/firebase-adminsdk.json');
        if (!file_exists($serviceAccountPath)) {
            Log::error("[AGORA] Firebase servis hesabı bulunamadı! Path: $serviceAccountPath");
            return response()->json(['success'=>false, 'message'=>'Firebase servis hesabı bulunamadı!'], 500);
        }
        $serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);
        $projectId = $serviceAccount['project_id'];

        // 2) JWT Üret
        $client_email = $serviceAccount['client_email'];
        $private_key  = $serviceAccount['private_key'];
        $jwtHeader = ['alg' => 'RS256', 'typ' => 'JWT'];
        $now = time();
        $jwtClaim = [
            'iss'   => $client_email,
            'scope' => 'https://www.googleapis.com/auth/datastore https://www.googleapis.com/auth/firebase.messaging',
            'aud'   => 'https://oauth2.googleapis.com/token',
            'iat'   => $now,
            'exp'   => $now + 3600,
        ];

        $jwtHeaderEncoded = rtrim(strtr(base64_encode(json_encode($jwtHeader)), '+/', '-_'), '=');
        $jwtClaimEncoded  = rtrim(strtr(base64_encode(json_encode($jwtClaim)), '+/', '-_'), '=');
        $jwtUnsigned      = $jwtHeaderEncoded . '.' . $jwtClaimEncoded;
        $signature = '';
        if (!openssl_sign($jwtUnsigned, $signature, $private_key, 'sha256')) {
            Log::error("[AGORA] JWT imzalanamadı!");
            return response()->json(['success'=>false, 'step'=>'jwt', 'message'=>'JWT imzalanamadı!'], 500);
        }
        $jwtSigned = $jwtUnsigned . '.' . rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

        Log::debug("[AGORA] JWT oluşturuldu");

        // 3) Access Token al
        $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion'  => $jwtSigned,
        ]);
        Log::debug("[AGORA] Access token yanıtı", [
            'http_code' => $tokenResponse->status(),
            'body' => $tokenResponse->body(),
        ]);
        if (!$tokenResponse->ok()) {
            Log::error("[AGORA] Access token alınamadı", ['response' => $tokenResponse->body()]);
            return response()->json(['success'=>false, 'step'=>'token', 'message'=>'Token alınamadı'], 500);
        }
        $accessToken = $tokenResponse->json()['access_token'];

        // 1) Firestore'dan receiver'ın FCM token'ını bul (AccessToken ile!)
        $query = [
            "structuredQuery" => [
                "from" => [["collectionId" => "users"]],
                "where" => [
                    "fieldFilter" => [
                        "field" => ["fieldPath" => "user_id"],
                        "op"    => "EQUAL",
                        "value" => is_numeric($receiverId)
                            ? ["integerValue" => intval($receiverId)]
                            : ["stringValue" => $receiverId]
                    ]
                ],
                "limit" => 1
            ]
        ];

        Log::debug("[AGORA] Firestore'a sorgu gönderiliyor", [
            'query' => $query,
            'projectId' => $projectId,
        ]);

        $firestoreResp = Http::withToken($accessToken)
            ->post("https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents:runQuery", $query);

        Log::debug("[AGORA] Firestore yanıtı", [
            'http_code' => $firestoreResp->status(),
            'body' => $firestoreResp->body(),
        ]);

        if (!$firestoreResp->ok()) {
            Log::error("[AGORA] Firestore API hatası", ['response' => $firestoreResp->body()]);
            return response()->json(['success'=>false, 'step'=>'firestore', 'message'=>'Firestore API hatası'], 500);
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
            Log::warning("[AGORA] Kullanıcı Firestore'da bulunamadı", ['firestoreData' => $firestoreData]);
            return response()->json(['success'=>false, 'step'=>'firestore-user', 'message'=>'Kullanıcı bulunamadı!'], 404);
        }
        $fields = $doc['fields'];
        $fcmToken = isset($fields['fcm_token']['stringValue']) ? $fields['fcm_token']['stringValue'] : null;
        if (!$fcmToken) {
            Log::warning("[AGORA] Kullanıcının FCM tokenı yok!", ['fields' => $fields]);
            return response()->json(['success'=>false, 'step'=>'fcm-token', 'message'=>'Kullanıcının FCM tokenı yok!'], 404);
        }

        Log::debug("[AGORA] Alıcı FCM tokenı bulundu", ['fcmToken' => $fcmToken]);

        // 4) FCM Data mesajı hazırla ve gönder
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";
        $data = [
            'type'        => 'agora_start',
            'roomId'      => $roomId,
            'userId'      => $senderId,
            'role'        => 'broadcaster',
            'otherUserId' => $receiverId,
            'userType'    => $userType,
        ];
        $notification = [
            'message' => [
                'token'        => $fcmToken,
                'notification' => [
                    'title' => 'Canlı Yayın Başlıyor',
                    'body'  => 'Bir oda başlatıldı, canlı yayına katılmak için tıkla.',
                ],
                'data' => $data,
                'android' => [
                    'notification' => ['sound' => 'default'],
                ],
                'apns' => [
                    'payload' => [
                        'aps' => ['sound' => 'default'],
                    ],
                ],
            ]
        ];

        Log::debug("[AGORA] FCM mesajı gönderiliyor", [
            'url' => $url,
            'notification' => $notification,
        ]);

        $fcmResponse = Http::withToken($accessToken)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, $notification);

        Log::debug("[AGORA] FCM yanıtı", [
            'http_code' => $fcmResponse->status(),
            'body' => $fcmResponse->body(),
        ]);

        if ($fcmResponse->successful()) {
            Log::info("[AGORA] Bildirim başarıyla gönderildi!", [
                'fcmToken'   => $fcmToken,
                'receiverId' => $receiverId,
                'response'   => $fcmResponse->body(),
            ]);
            return response()->json([
                'success'    => true,
                'message'    => 'Bildirim gönderildi!',
                'fcmToken'   => $fcmToken,
                'receiverId' => $receiverId,
                'fcm_response' => $fcmResponse->body(),
            ]);
        } else {
            Log::error("[AGORA] FCM gönderilemedi!", [
                'fcmToken'   => $fcmToken,
                'receiverId' => $receiverId,
                'response'   => $fcmResponse->body()
            ]);
            return response()->json([
                'success'    => false,
                'step'       => 'fcm-send',
                'message'    => 'FCM gönderilemedi!',
                'fcmToken'   => $fcmToken,
                'receiverId' => $receiverId,
                'fcm_response' => $fcmResponse->body(),
            ], 500);
        }
    }
}