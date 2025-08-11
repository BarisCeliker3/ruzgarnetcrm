<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppNotiController extends Controller
{
    protected $serviceAccount;
    protected $projectId;
    protected $clientEmail;
    protected $privateKey;

    public function __construct()
    {
        // Artık dosyadan okuma YOK, doğrudan diziyle veriyoruz:
        $this->serviceAccount = [
            'project_id' => 'ruzgarplus-2a597',
            'client_email' => 'firebase-adminsdk-fbsvc@ruzgarplus-2a597.iam.gserviceaccount.com',
            'private_key' => "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC9Kqhdn9LX+IiM\n2jc4yZBfOtaj/+tDBefbkxcZSNPYLjcilJFUJfiocNE6sak1CXFiPR+gExEqKY6/\nETAZ2QfuZlCCExLRcCU9QgSSmHvBmW0xpKzZV1pSUbU+OEEQDfBEmTTCLahwIIde\nKOtJXqZWn2/q48saCb0pgS10r7tBbfbbqODj1FnNsAWT7KmDhnrrR04goKhQFcl+\nX3DoKSq2o/GETwP0PXMcsljmsyUHeV23Oua2AvCjX0QV1eXV6MwyMFIpEB3ZM18o\nU9HrpvL2peDNbZrXiiWNLiLXh/KwL2n/+94CuSlaabd4afzCxbTCUjDKYOVpdVZe\nhm8zGqDhAgMBAAECggEAGVQH3RlUOtStO+bP9AuRCB8xtB3FG2FEDTNhqWIF83Ek\nsr2fw9udsrgAW9KD7HUKOHQksuM6riGIWm7ruNpFZJdQekohf+d7JPuc7x/5mg93\n/milOCipEFKeaOlRVNv46sZ0uPcyEWlZlrL15goFTZ3ld1buz9qz+EWyl2gcM4NR\nyVrajXtwqwbmVeFbkP0lZWaTZ6NPaoyfOiSkQS9lMJCnrwLcug5gIP2s1/5+wlMn\nqhwtwnGK8gsl91/8A7lyJG6tQEBR2Cdq/nQOnR+Rd8XMnTt2BC0qX2ZGML3xkZrI\nMvCqmGxRIqsIGdsYk4+mz3xQo97GxisURnPBHn+dDQKBgQDlq1gjYoR0fpCa5tGB\nmBc8NLae6+ohtkEDVBUuLLhhChCv7FCT9H4nLlDwBLpkZ7O372VPIJlce8LxAgVu\n9qctz2ci0cixsl0sXMsZjS6R4V61k62tTvl1JCQT2zZjBol9kKRF8F9kXuIwjnB8\nBgOvSIqGctv5+R6sdi6NNRUTgwKBgQDS2pWI5R2ncm+EcWzqwuQxA8KE1t6FfxPi\nLct1tC+/nD4PvtZjuB9jwWZ2KprC/hBzEZ6S/DZHpNnaDJwdffo7/HqKqDDAa8RI\nCY5ZSVBdXjveB+O3g6EoAaDmJE/cK2clthA4JUl5ZMiXXwsVAi9TIeAq7z1s04Eo\nL3fXMMq4ywKBgQCvAPsuK1mmsvJZNlyaFVxPIhOt0TIc8hVkBeQFxUnRl6vTgYx8\n0SZ3kJFX8yJcc7C8DYzy2HJDyIJoxxOA1C3beFisbZIx5SmeLi8Mj0nXGxXh4l/K\n2Yy4OAvNnZI5rreBmH+0U0882hgcy8zmlGamX+4+OLNqLOu0mnEqZDJlJQKBgQCz\nZrnOZSrK+un5ZUyHnlTrg0hxICTqrsnrKo2vUyVBQZ3oZbYh2FoU1UvphKxy9hpm\n3Xnvk9pXMOMOzKXTzgkoGtTkvt/kCI1TwZW1UFSpbHFBo7LTxJJM6L3Ostyj9uXn\nRzYbn1YZjG/Do2FZeadscyk5Pp8jxf1hhKnRlTkW6wKBgFiQSE46zoRkvBmpw+dZ\nH9V9JLMamX+Ynd3tUqIEZQDZLVA2hgLrIADHayROIHLsdotW4XYBRmM/ueixSIpR\nTtcqxKDKca09pHa58LPyhz38cMiiWW7PS562+cgHqvrx2IDSc8lF72JyfJXttFAp\n2Awjf0BEVUh6fBGEv4zPlSEG\n-----END PRIVATE KEY-----\n"
        ];
        $this->projectId = $this->serviceAccount['project_id'];
        $this->clientEmail = $this->serviceAccount['client_email'];
        $this->privateKey = $this->serviceAccount['private_key'];
    }

    // Formu gösterir
    public function showForm()
    {
        return view('admin.appnotifications.appnoti_form');
    }

    // Form submit işlemi ve bildirim gönderme - Sonucu HTML olarak direkt döndür
    public function submitForm(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255',
        ]);

        $html = '<!DOCTYPE html><html><head>
        <meta charset="utf-8">
        <title>Bildirim Sonucu</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        </head><body class="p-5"><div class="container">';

        try {
            // 1. Veritabanına kaydet
            $notiId = DB::table('app_noti')->insertGetId([
                'title' => $request->title,
                'body' => $request->body,
                'sent' => 0,
                'created_at' => now()
            ]);
    
            // 2. Kaydı al, bildirimi gönder
            $noti = DB::table('app_noti')->where('id', $notiId)->first();
            $accessToken = $this->getAccessToken();
            $documents = $this->getUsersWithFcmToken($accessToken);
    
            $sentCount = 0;
            $errors = [];
            foreach ($documents as $doc) {
                $nameParts = explode('/', $doc['name']);
                $userId = end($nameParts);
                $fields = $doc['fields'] ?? [];
                $fcmToken = isset($fields['fcm_token']['stringValue']) ? $fields['fcm_token']['stringValue'] : null;
                if (!$fcmToken) continue;
    
                $data = [
                    'noti_id' => (string)$noti->id,
                    'extra_info' => 'AppNoti tablosundan form ile gönderildi',
                ];
                $result = $this->sendFcmNotification($fcmToken, $accessToken, $noti->title, $noti->body, $data);
    
                if ($result['success']) {
                    $this->setPushStatusInFirestore($userId, $accessToken, "active");
                    $sentCount++;
                } else {
                    $errorMsg = "KullanıcıID: $userId, Hata: " . htmlspecialchars($result['error']);
                    $errors[] = $errorMsg;
                    if (
                        stripos($result['error'], 'UNREGISTERED') !== false ||
                        stripos($result['error'], 'INVALID_ARGUMENT') !== false ||
                        stripos($result['error'], 'Requested entity was not found') !== false
                    ) {
                        $this->setPushStatusInFirestore($userId, $accessToken, "inactive");
                    }
                }
            }
            // 3. Bildirim gönderildi olarak işaretle
            DB::table('app_noti')->where('id', $notiId)->update(['sent' => 1]);
    
            $html .= "<div class='alert alert-success'>$sentCount kullanıcıya bildirim gönderildi!</div>";
            if (count($errors) > 0) {
                $html .= "<div class='alert alert-danger mt-2'><b>Bazı hatalar oluştu:</b><br>" . implode('<br>', $errors) . "</div>";
            }
        } catch (\Exception $e) {
            $html .= "<div class='alert alert-danger'>Bildirim gönderilirken hata oluştu: " . htmlspecialchars($e->getMessage()) . "</div>";
        }

        $html .= '<a href="' . route('admin.appnoti.form') . '" class="btn btn-primary mt-4">Yeni Bildirim Gönder</a>';
        $html .= '</div></body></html>';

        return response($html);
    }

    // --- Yardımcı fonksiyonlar ---
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

        $jwt = $this->createJWT($payload, $this->privateKey);

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

    private function createJWT($payload, $privateKey)
    {
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        $segments = [
            $this->base64url_encode(json_encode($header)),
            $this->base64url_encode(json_encode($payload))
        ];
        $signing_input = implode('.', $segments);
        openssl_sign($signing_input, $signature, $privateKey, 'SHA256');
        return $signing_input . '.' . $this->base64url_encode($signature);
    }

    private function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function getUsersWithFcmToken($accessToken)
    {
        $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/users";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken"
        ]);
        $response = curl_exec($ch);
        if ($response === false) return [];
        $data = json_decode($response, true);
        curl_close($ch);

        return isset($data['documents']) ? $data['documents'] : [];
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
                    "priority" => "high"
                ],
                "data" => $data
            ]
        ];

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

    private function setPushStatusInFirestore($userId, $accessToken, $status)
    {
        $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/users/{$userId}?updateMask.fieldPaths=push_status";
        $fields = [
            "fields" => [
                "push_status" => [
                    "stringValue" => $status
                ]
            ]
        ];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json"
        ]);
        curl_exec($ch);
        curl_close($ch);
    }
}