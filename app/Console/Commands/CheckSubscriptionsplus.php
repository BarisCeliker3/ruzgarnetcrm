<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class CheckSubscriptionsplus extends Command
{
    protected $signature = 'ruzgarnet:CheckSubscriptionsplus';
    protected $description = 'Check Google Play subscriptions and delete expired users';

    // GOOGLE PLAY SERVICE ACCOUNT
    protected $googlePlayServiceAccount = [
        'project_id' => 'ruzgarplus-2a597-468508',
        'client_email' => 'ruzgarplus-2a597@ruzgarplus-2a597-468508.iam.gserviceaccount.com',
        'private_key' => "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDbZuYXjF9XAPOq\nSSftcrQtBKzX+dku5nOjd6ypJBvuIbXm4sTIhbo/fd1YAqu8li7QjXCCnDsvqkAJ\nDELeRfk3DgY4DHVLpWQSl/do/dz58MjYW6pYoujDXgMfmPkYx1ywlNtPk9ViV6uW\nbmJ3gRq1mGPTCB2G6XqNKP6UCkAtbQP2NBEqTUhxUhfvi6TJoXmOheCfC2NBUx2d\nG0vVQs3ZV2KdgD6o7uWj6OGcLs8kRrljE0gT91FGhBTE1kxw2Oi7MEuFRjpZ8dq9\nzFQ/UbTKc67mosrcjLwUctpSBRROdjm+OQTZo7cra74i6JoQwLaeOjJoAF1ynk28\nxStqBJkxAgMBAAECggEAHdIr4pYADG+S7vmQDYBqeHb69kUdrbgBjj2xMHE5waF/\n27DFbfrtMH2PVQvR42lnVg3vdbU9/zHND93EhfktUTwdAMfCtqQ1iKhypqjgvPEr\nH2tAKVmFOS7BTm1oqCNK2C53a6bMmVgQuLrqs9MOuhGLOe8PsltwPpkMlzsYc4Pt\n+B6Jwcmjs5cKBdKVe6Z2uZ/JSrzfuJpZ7OPfOmTUwcgCPsWSOLkBfeiWlQDEKiD0\nW6LthfxG2qT9OQ5wp3/BHkUdFSEw6o1aHtSsoyQVCHCaZlalpkepROZpov9rk+Rd\nV2MQKPfbMlxCg9wnQsNngvIl/1z/KA9SPqhHp1gAZQKBgQD8nYK1f4xUIfWt62GZ\nEZUAb9NezNA7/9yC/fSTTwCgaS2RACkDOG+qjb/lQbdRBrFIQndIfqly76hU1Cup\n/OLHX0UWXxtdwBkZ8dW12uXMasTVhTeR99IvyjevfE9so5ioHWKu9F3Nz32SMUF/\nzjtZgEPoQugVkOs68LYXTkE01QKBgQDeV3bIyXFa0MQQumUyPnodtoLGJcVIDC+u\nteO/kKc0hrkYr3HF2jxVpqwFhpQN7brYm1acUF9IIxbtXjUzbb/PaLchKyGkcfMA\nUa9KFaCPTcDNIAHqZvGGO0C8BQxdl0C2Nob0/nDZoB1sFC2Gn2pDGvf3HhcCLkLJ\n26uwqSPw7QKBgHcZA7DyS4S25g9zM/ZotakZD7xYL6y5+oq/lHmG+7KlI9iDDNL5\n3pu4bMp3aygGUbrRq09AeD86AlDMHzHrijeZEQd1G3/du3fh7nHonAL+K4LHZeWp\nwyzI1+wiXYfIsYZBJG97wmXv9zHfixPodU7DDEEKmkTgqCaHqjHesRtpAoGBALZU\nRU2MnA9cKZyKLhhQ0bVyCLXTHX/itmtwL07VobhaTommvgcA2v9mCaUSYnE1pUah\nxBm1cx1l4RRQcBI3itbcSWjCxPjklOCLG9MF/z/lBBlyiP+e4asxBfnpreVF9sQ1\n3OAlk4dzXQ1XUqoWKn7TK8sTeszIAO8l3Bqn6ZhVAoGAQDs7Q04q3yKObu2Zs+0E\nmdDVvA9De22B0tDJVmzgL8upeAumapwcOQefvKYgAk6+leYZhklJF7JrD7MAOvFR\nJ0JRx9QCTjh3+fwRZEjHHXj9YjgTqTIuijQLqF/21hlu800Ke+ioObzqL/zaP01l\nvJVqQh7lDGLsVChjspYpPlI=\n-----END PRIVATE KEY-----\n",
        'client_id' => '112707845955786988320',
        'token_uri' => 'https://oauth2.googleapis.com/token'
    ];

    // FIREBASE SERVICE ACCOUNT
    protected $firebaseServiceAccount = [
        'project_id' => 'ruzgarplus-2a597',
        'client_email' => 'firebase-adminsdk-fbsvc@ruzgarplus-2a597.iam.gserviceaccount.com',
        'private_key' => "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC9Kqhdn9LX+IiM\n2jc4yZBfOtaj/+tDBefbkxcZSNPYLjcilJFUJfiocNE6sak1CXFiPR+gExEqKY6/\nETAZ2QfuZlCCExLRcCU9QgSSmHvBmW0xpKzZV1pSUbU+OEEQDfBEmTTCLahwIIde\nKOtJXqZWn2/q48saCb0pgS10r7tBbfbbqODj1FnNsAWT7KmDhnrrR04goKhQFcl+\nX3DoKSq2o/GETwP0PXMcsljmsyUHeV23Oua2AvCjX0QV1eXV6MwyMFIpEB3ZM18o\nU9HrpvL2peDNbZrXiiWNLiLXh/KwL2n/+94CuSlaabd4afzCxbTCUjDKYOVpdVZe\nhm8zGqDhAgMBAAECggEAGVQH3RlUOtStO+bP9AuRCB8xtB3FG2FEDTNhqWIF83Ek\nsr2fw9udsrgAW9KD7HUKOHQksuM6riGIWm7ruNpFZJdQekohf+d7JPuc7x/5mg93\n/milOCipEFKeaOlRVNv46sZ0uPcyEWlZlrL15goFTZ3ld1buz9qz+EWyl2gcM4NR\nyVrajXtwqwbmVeFbkP0lZWaTZ6NPaoyfOiSkQS9lMJCnrwLcug5gIP2s1/5+wlMn\nqhwtwnGK8gsl91/8A7lyJG6tQEBR2Cdq/nQOnR+Rd8XMnTt2BC0qX2ZGML3xkZrI\nMvCqmGxRIqsIGdsYk4+mz3xQo97GxisURnPBHn+dDQKBgQDlq1gjYoR0fpCa5tGB\nmBc8NLae6+ohtkEDVBUuLLhhChCv7FCT9H4nLlDwBLpkZ7O372VPIJlce8LxAgVu\n9qctz2ci0cixsl0sXMsZjS6R4V61k62tTvl1JCQT2zZjBol9kKRF8F9kXuIwjnB8\nBgOvSIqGctv5+R6sdi6NNRUTgwKBgQDS2pWI5R2ncm+EcWzqwuQxA8KE1t6FfxPi\nLct1tC+/nD4PvtZjuB9jwWZ2KprC/hBzEZ6S/DZHpNnaDJwdffo7/HqKqDDAa8RI\nCY5ZSVBdXjveB+O3g6EoAaDmJE/cK2clthA4JUl5ZMiXXwsVAi9TIeAq7z1s04Eo\nL3fXMMq4ywKBgQCvAPsuK1mmsvJZNlyaFVxPIhOt0TIc8hVkBeQFxUnRl6vTgYx8\n0SZ3kJFX8yJcc7C8DYzy2HJDyIJoxxOA1C3beFisbZIx5SmeLi8Mj0nXGxXh4l/K\n2Yy4OAvNnZI5rreBmH+0U0882hgcy8zmlGamX+4+OLNqLOu0mnEqZDJlJQKBgQCz\nZrnOZSrK+un5ZUyHnlTrg0hxICTqrsnrKo2vUyVBQZ3oZbYh2FoU1UvphKxy9hpm\n3Xnvk9pXMOMOzKXTzgkoGtTkvt/kCI1TwZW1UFSpbHFBo7LTxJJM6L3Ostyj9uXn\nRzYbn1YZjG/Do2FZeadscyk5Pp8jxf1hhKnRlTkW6wKBgFiQSE46zoRkvBmpw+dZ\nH9V9JLMamX+Ynd3tUqIEZQDZLVA2hgLrIADHayROIHLsdotW4XYBRmM/ueixSIpR\nTtcqxKDKca09pHa58LPyhz38cMiiWW7PS562+cgHqvrx2IDSc8lF72JyfJXttFAp\n2Awjf0BEVUh6fBGEv4zPlSEG\n-----END PRIVATE KEY-----\n"
    ];
    protected $firestoreApiKey = 'AIzaSyB7oTftHAdQRLad9XuV0dnWgCG5-bPp6o0';
    protected $packageName = 'com.ruzgarnet.ruzgarplus';

    private function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function createJWT($payload, $privateKeyString)
    {
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        $segments = [
            $this->base64url_encode(json_encode($header)),
            $this->base64url_encode(json_encode($payload))
        ];
        $signing_input = implode('.', $segments);

        $privateKeyResource = openssl_pkey_get_private($privateKeyString);
        if (!$privateKeyResource) throw new \Exception("Private key alınamadı!");
        $ok = openssl_sign($signing_input, $signature, $privateKeyResource, OPENSSL_ALGO_SHA256);
        openssl_free_key($privateKeyResource);

        if (!$ok) throw new \Exception("JWT imzalanamadı!");

        return $signing_input . '.' . $this->base64url_encode($signature);
    }

    // Google Play için access token
    private function getGooglePlayAccessToken()
    {
        $now = time();
        $payload = [
            "iss" => $this->googlePlayServiceAccount['client_email'],
            "scope" => "https://www.googleapis.com/auth/androidpublisher",
            "aud" => "https://oauth2.googleapis.com/token",
            "iat" => $now,
            "exp" => $now + 3600,
        ];
        $this->info("[DEBUG] Server Time: " . date('Y-m-d H:i:s', $now) . " (Timestamp: $now)");
        $this->info("[DEBUG] JWT Payload: " . json_encode($payload));
        $jwt = $this->createJWT($payload, $this->googlePlayServiceAccount['private_key']);
        $this->info("[DEBUG] JWT Created: " . $jwt);

        // JWT decode
        $parts = explode('.', $jwt);
        $header = json_decode(base64_decode(strtr($parts[0], '-_', '+/')), true);
        $body = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);
        $this->info("[DEBUG] JWT Header: " . json_encode($header));
        $this->info("[DEBUG] JWT Body: " . json_encode($body));

        $postFields = http_build_query([
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);
        $this->info("[DEBUG] Token Request Fields: " . $postFields);

        $ch = curl_init("https://oauth2.googleapis.com/token");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);
        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            $this->error("[ERROR] Google Play access token alınamadı: $error");
            throw new \Exception("Google Play access token alınamadı: " . $error);
        }
        $result = json_decode($response, true);
        curl_close($ch);

        $this->info("[DEBUG] Token API Response: " . $response);

        if (isset($result['access_token'])) {
            $this->info("[DEBUG] Google Play Access Token başarıyla alındı.");
            $this->info("[DEBUG] Access Token: " . $result['access_token']);
            return $result['access_token'];
        }
        $this->error("[ERROR] Google Play access token alınamadı: " . $response);
        throw new \Exception("Google Play access token alınamadı: " . $response);
    }

    // Firebase için access token (Auth API için)
    private function getFirebaseAccessToken()
    {
        $now = time();
        $payload = [
            "iss" => $this->firebaseServiceAccount['client_email'],
            "scope" => "https://www.googleapis.com/auth/identitytoolkit",
            "aud" => "https://oauth2.googleapis.com/token",
            "iat" => $now,
            "exp" => $now + 3600,
        ];
        $this->info("[DEBUG] Firebase JWT Payload: " . json_encode($payload));
        $jwt = $this->createJWT($payload, $this->firebaseServiceAccount['private_key']);
        $this->info("[DEBUG] Firebase JWT: " . $jwt);

        $postFields = http_build_query([
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);
        $this->info("[DEBUG] Firebase Token Request Fields: " . $postFields);

        $ch = curl_init("https://oauth2.googleapis.com/token");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);
        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            $this->error("[ERROR] Firebase access token alınamadı: $error");
            throw new \Exception("Firebase access token alınamadı: " . $error);
        }
        $result = json_decode($response, true);
        curl_close($ch);

        $this->info("[DEBUG] Firebase Token API Response: " . $response);

        if (isset($result['access_token'])) {
            $this->info("[DEBUG] Firebase Access Token başarıyla alındı.");
            $this->info("[DEBUG] Firebase Access Token: " . $result['access_token']);
            return $result['access_token'];
        }
        $this->error("[ERROR] Firebase access token alınamadı: " . $response);
        throw new \Exception("Firebase access token alınamadı: " . $response);
    }

    protected function getFirestoreSubscriptions()
    {
        $url = "https://firestore.googleapis.com/v1/projects/{$this->firebaseServiceAccount['project_id']}/databases/(default)/documents/subscriptions?key={$this->firestoreApiKey}";
        $this->info("[DEBUG] Firestore Subscriptions URL: $url");
        $resp = Http::get($url);
        $this->info("[DEBUG] Firestore Response Status: " . $resp->status());
        $this->info("[DEBUG] Firestore Response Body: " . $resp->body());
        if (!$resp->ok()) {
            $this->error("[ERROR] Firestore subscriptions çekilemedi! Status: " . $resp->status());
            return [];
        }
        $subs = [];
        if (isset($resp['documents'])) {
            foreach ($resp['documents'] as $doc) {
                $fields = $doc['fields'] ?? [];
                $subs[] = [
                    'productID' => $fields['productID']['stringValue'] ?? null,
                    'purchaseToken' => $fields['purchaseToken']['stringValue'] ?? null,
                    'user_id' => $fields['user_id']['integerValue'] ?? $fields['user_id']['stringValue'] ?? null,
                ];
            }
            $this->info("[DEBUG] Toplam Firestore subscription sayısı: " . count($subs));
        } else {
            $this->warn("[DEBUG] Firestore yanıtında 'documents' yok!");
        }
        return $subs;
    }

    protected function isGooglePlaySubscriptionExpired($accessToken, $packageName, $productId, $purchaseToken)
    {
        $url = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/$packageName/purchases/subscriptions/$productId/tokens/$purchaseToken";
        $this->info("[DEBUG] Google Play abonelik sorgu URL: $url");
        $this->info("[DEBUG] PackageName: $packageName, ProductID: $productId, PurchaseToken: $purchaseToken");
        $this->info("[DEBUG] Kullanılan Access Token: $accessToken");

        $resp = Http::withToken($accessToken)->get($url);

        $this->info("[DEBUG] Google Play API HTTP Status: " . $resp->status());
        $this->info("[DEBUG] Google Play API yanıtı: " . $resp->body());

        $body = $resp->json();

        if (isset($body['error'])) {
            $this->error("[ERROR] Google Play API Error: " . json_encode($body['error']));
            if (isset($body['error']['message'])) {
                $this->warn("[DEBUG] Error Message: " . $body['error']['message']);
            }
            if (isset($body['error']['domain'])) {
                $this->warn("[DEBUG] Error Domain: " . $body['error']['domain']);
            }
            if (isset($body['error']['reason'])) {
                $this->warn("[DEBUG] Error Reason: " . $body['error']['reason']);
            }
        }

        if (isset($body['paymentState'])) {
            $this->info("[DEBUG] Abonelik paymentState: " . $body['paymentState']);
        } else {
            $this->info("[DEBUG] Abonelik paymentState alanı YOK.");
        }

        if (isset($body['autoRenewing'])) {
            $this->info("[DEBUG] Abonelik autoRenewing: " . ($body['autoRenewing'] ? "YES" : "NO"));
        }

        if (isset($body['cancelReason'])) {
            $this->warn("[DEBUG] Abonelik cancelReason: " . $body['cancelReason']);
        }

        if ($resp->failed()) {
            $this->error("[ERROR] Google Play API isteği başarısız! Status: " . $resp->status() . " - Body: " . $resp->body());
            $this->warn("[DEBUG] Google Play isteği başarısız olduğu için abonelik SÜRESİ DOLMUŞ kabul ediliyor ve kullanıcı siliniyor.");
            return true;
        }

        if (isset($body['expiryTimeMillis'])) {
            $expiry = Carbon::createFromTimestamp($body['expiryTimeMillis'] / 1000);
            $this->info("[DEBUG] expiryTimeMillis: " . $body['expiryTimeMillis']);
            $this->info("[DEBUG] Abonelik bitiş zamanı: " . $expiry->toDateTimeString());

            if (isset($body['paymentState']) && $body['paymentState'] == 0) {
                $this->warn("[DEBUG] Abonelik PENDING durumda (paymentState=0), kullanıcı silinmeyecek!");
                return false;
            }

            if ($expiry->isPast()) {
                $this->warn("[DEBUG] Abonelik SÜRESİ DOLMUŞ! Kullanıcı silinecek.");
                return true;
            } else {
                $this->info("[DEBUG] Abonelik hala AKTİF! Kullanıcı silinmeyecek.");
                return false;
            }
        }

        if (isset($body['paymentState']) && $body['paymentState'] == 0) {
            $this->warn("[DEBUG] expiryTimeMillis yok ama paymentState=PENDING! Kullanıcı silinmeyecek.");
            return false;
        }

        $this->warn("[DEBUG] Google Play API yanıtında expiryTimeMillis YOK! Yanıt: " . json_encode($body));
        $this->warn("[DEBUG] expiryTimeMillis yoksa genellikle token hatalı, abonelik bitmiş veya yanlış parametre. Kullanıcı SİLİNECEK!");
        return true;
    }

    protected function deleteFirestoreUser($userId)
    {
        $url = "https://firestore.googleapis.com/v1/projects/{$this->firebaseServiceAccount['project_id']}/databases/(default)/documents/users/$userId?key={$this->firestoreApiKey}";
        $this->info("[DEBUG] Firestore Kullanıcı Silme URL: $url");
        $resp = Http::delete($url);
        $this->info("[DEBUG] Firestore Delete Status: " . $resp->status());
        $this->info("[DEBUG] Firestore Delete Body: " . $resp->body());
        if ($resp->ok()) {
            $this->info("[DEBUG] Firestore'dan kullanıcı silindi: $userId");
        } else {
            $this->error("[ERROR] Firestore'dan kullanıcı silinemedi: $userId - Status: " . $resp->status());
        }
    }

    protected function deleteFirebaseAuthUser($uid)
    {
        $accessToken = $this->getFirebaseAccessToken();
        $url = "https://identitytoolkit.googleapis.com/v1/accounts:delete";
        $this->info("[DEBUG] Firebase Auth Silme URL: $url");
        $this->info("[DEBUG] Silinecek UID: $uid");
        $resp = Http::withToken($accessToken)->post($url, [
            'localId' => $uid
        ]);
        $this->info("[DEBUG] Firebase Auth Delete Status: " . $resp->status());
        $this->info("[DEBUG] Firebase Auth Delete Body: " . $resp->body());
        if ($resp->ok()) {
            $this->info("[DEBUG] Firebase Auth'dan kullanıcı silindi: $uid");
        } else {
            $this->error("[ERROR] Firebase Auth'dan kullanıcı silinemedi: $uid - Status: " . $resp->status() . " - Body: " . $resp->body());
        }
        return $resp->ok();
    }

    public function handle()
    {
        $this->info("[DEBUG] Sunucu Environment: " . json_encode($_ENV));
        $this->info("[DEBUG] PHP Version: " . phpversion());
        $this->info("[DEBUG] check:subscriptions başladı...");
        try {
            $googlePlayAccessToken = $this->getGooglePlayAccessToken();
        } catch (\Exception $e) {
            $this->error("[ERROR] Google Play Access token alınamadı: " . $e->getMessage());
            return;
        }

        $subscriptions = $this->getFirestoreSubscriptions();

        foreach ($subscriptions as $sub) {
            $productId = $sub['productID'] ?? null;
            $purchaseToken = $sub['purchaseToken'] ?? null;
            $userId = $sub['user_id'] ?? null;

            $this->info("[DEBUG] Kullanıcı: $userId, ProductID: $productId, PurchaseToken: $purchaseToken");

            if (!$productId || !$purchaseToken || !$userId) {
                $this->warn("[DEBUG] Eksik alanlar! Atlanıyor.");
                continue;
            }

            $isExpired = $this->isGooglePlaySubscriptionExpired($googlePlayAccessToken, $this->packageName, $productId, $purchaseToken);

            if ($isExpired) {
                $this->info("[DEBUG] Abonelik bitmiş, kullanıcı siliniyor: $userId");
                $this->deleteFirestoreUser($userId);

                $userDoc = $this->getFirestoreUserDoc($userId);
                $firebaseUid = $userDoc['fields']['firebase_uid']['stringValue'] ?? null;
                if ($firebaseUid) {
                    $this->deleteFirebaseAuthUser($firebaseUid);
                } else {
                    $this->warn("[DEBUG] Kullanıcı dokümanında firebase_uid yok: $userId");
                }

                $this->info("Kullanıcı silindi: $userId");
            } else {
                $this->info("[DEBUG] Abonelik aktif, kullanıcı silinmedi: $userId");
            }
        }
        $this->info("[DEBUG] check:subscriptions tamamlandı.");
    }

    protected function getFirestoreUserDoc($userId)
    {
        $url = "https://firestore.googleapis.com/v1/projects/{$this->firebaseServiceAccount['project_id']}/databases/(default)/documents/users/$userId?key={$this->firestoreApiKey}";
        $this->info("[DEBUG] Firestore UserDoc URL: $url");
        $resp = Http::get($url);
        $this->info("[DEBUG] Firestore UserDoc Status: " . $resp->status());
        $this->info("[DEBUG] Firestore UserDoc Body: " . $resp->body());
        if ($resp->ok()) {
            $this->info("[DEBUG] Firestore kullanıcı dokümanı alındı: $userId");
            return $resp->json();
        }
        $this->error("[ERROR] Firestore kullanıcı dokümanı alınamadı: $userId - Status: " . $resp->status());
        return [];
    }
}