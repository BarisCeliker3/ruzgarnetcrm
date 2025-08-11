<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ContentCreatorController extends Controller
{
    protected $serviceAccount;
    protected $projectId;
    protected $accessToken;
    protected $categories = ['Aile', 'Çocuk']; // Kategoriler burada

    public function __construct()
    {
        $serviceAccountPath = storage_path('app/firebase-adminsdk.json');
        $this->serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);
        $this->projectId = $this->serviceAccount['project_id'];
        $this->accessToken = $this->getAccessToken();
    }

    public function index(Request $request)
    {
        $selectedCategory = $request->get('category');
        $url = $this->firestoreUrl('content_creators');
        $response = Http::withToken($this->accessToken)->get($url);

        $contents = [];
        if ($response->successful()) {
            $docs = $response->json()['documents'] ?? [];
            foreach ($docs as $doc) {
                $fields = $this->decodeFirestoreFields($doc['fields']);
                $fields['id'] = basename($doc['name']);
                $fields = (object)$fields;
                if ($selectedCategory) {
                    if (isset($fields->category) && $fields->category === $selectedCategory) {
                        $contents[] = $fields;
                    }
                } else {
                    $contents[] = $fields;
                }
            }
        }
        return view('admin.content_creator.index', [
            'contents'   => $contents,
            'categories' => $this->categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    public function create()
    {
        return view('admin.content_creator.create', [
            'categories' => $this->categories
        ]);
    }

public function store(Request $request)
{
    $request->validate([
        'title'    => 'required|string|max:255',
        'content'  => 'required|string',
        'image'    => 'nullable|image|max:4096',
        'category' => 'required|string|in:Aile,Çocuk',
    ]);

    $imageUrl = null;
    if ($request->hasFile('image')) {
        $imageUrl = $this->uploadToCloudinary($request->file('image'));
    }

    $fields = [
        'fields' => [
            'title'      => ['stringValue' => $request->title],
            'content'    => ['stringValue' => $request->content],
            'image_url'  => ['stringValue' => $imageUrl ?? ''],
            'created_at' => ['stringValue' => now()->toDateTimeString()],
            'category'   => ['stringValue' => $request->category],
        ]
    ];

    // Her zaman yeni içerik ekle: POST ile koleksiyona gönder
    $url = $this->firestoreUrl("content_creators");
    $response = Http::withToken($this->accessToken)->post($url, $fields);

    return redirect()->route('admin.content_creator.index')->with('success', 'İçerik eklendi!');
}

    public function edit($id)
    {
        $url = $this->firestoreUrl("content_creators/$id");
        $response = Http::withToken($this->accessToken)->get($url);

        if (!$response->successful()) {
            abort(404, 'Kayıt bulunamadı');
        }

        $doc = $response->json();
        $content = $this->decodeFirestoreFields($doc['fields']);
        $content['id'] = $id;
        $content = (object)$content;

        return view('admin.content_creator.edit', [
            'content' => $content,
            'categories' => $this->categories
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'image'    => 'nullable|image|max:4096',
            'category' => 'required|string|in:Aile,Çocuk',
        ]);

        // id doğrudan kategori slug'ı olacak!
        $docId = Str::slug($request->category);

        // Mevcut veriyi çek
        $url = $this->firestoreUrl("content_creators/$docId");
        $response = Http::withToken($this->accessToken)->get($url);
        if (!$response->successful()) {
            abort(404, 'Kayıt bulunamadı');
        }
        $oldData = $this->decodeFirestoreFields($response->json()['fields']);
        $imageUrl = $oldData['image_url'] ?? null;

        if ($request->hasFile('image')) {
            $imageUrl = $this->uploadToCloudinary($request->file('image'));
        }

        $fields = [
            'fields' => [
                'title'      => ['stringValue' => $request->title],
                'content'    => ['stringValue' => $request->content],
                'image_url'  => ['stringValue' => $imageUrl ?? ''],
                'updated_at' => ['stringValue' => now()->toDateTimeString()],
                'category'   => ['stringValue' => $request->category],
            ]
        ];

        $patchUrl = $url . '?updateMask.fieldPaths=title&updateMask.fieldPaths=content&updateMask.fieldPaths=image_url&updateMask.fieldPaths=updated_at&updateMask.fieldPaths=category';
        $patchResponse = Http::withToken($this->accessToken)->patch($patchUrl, $fields);

        return redirect()->route('admin.content_creator.index')->with('success', 'İçerik güncellendi!');
    }

    public function destroy($id)
    {
        $url = $this->firestoreUrl("content_creators/$id");
        $response = Http::withToken($this->accessToken)->delete($url);

        return redirect()->route('admin.content_creator.index')->with('success', 'İçerik silindi!');
    }

    // Firestore yardımcıları
    private function decodeFirestoreFields($fields)
    {
        $result = [];
        foreach ($fields as $key => $v) {
            if (isset($v['stringValue'])) $result[$key] = $v['stringValue'];
            elseif (isset($v['integerValue'])) $result[$key] = (int)$v['integerValue'];
            elseif (isset($v['doubleValue'])) $result[$key] = (float)$v['doubleValue'];
            elseif (isset($v['booleanValue'])) $result[$key] = (bool)$v['booleanValue'];
            elseif (isset($v['timestampValue'])) $result[$key] = $v['timestampValue'];
            elseif (isset($v['arrayValue'])) $result[$key] = $v['arrayValue']['values'] ?? [];
            elseif (isset($v['mapValue'])) $result[$key] = $v['mapValue']['fields'] ?? [];
            else $result[$key] = null;
        }
        return $result;
    }

    protected function getAccessToken()
    {
        $now = time();
        $jwtHeader = [
            'alg' => 'RS256',
            'typ' => 'JWT'
        ];
        $jwtClaimSet = [
            'iss' => $this->serviceAccount['client_email'],
            'scope' => 'https://www.googleapis.com/auth/datastore',
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $now + 3600
        ];

        $base64UrlHeader = rtrim(strtr(base64_encode(json_encode($jwtHeader)), '+/', '-_'), '=');
        $base64UrlPayload = rtrim(strtr(base64_encode(json_encode($jwtClaimSet)), '+/', '-_'), '=');
        $data = $base64UrlHeader . '.' . $base64UrlPayload;

        // İmzala
        $privateKey = openssl_pkey_get_private($this->serviceAccount['private_key']);
        openssl_sign($data, $signature, $privateKey, 'SHA256');
        $base64UrlSignature = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

        $jwt = $data . '.' . $base64UrlSignature;

        // Google OAuth2 ile access_token al
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt
        ]);
        if ($response->successful()) {
            return $response['access_token'];
        }
        abort(500, 'Google OAuth2 access token alınamadı!');
    }

    protected function firestoreUrl($path = '')
    {
        return "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/$path";
    }

    private function uploadToCloudinary($image)
    {
        $cloud_name = "ddee2vtaf";
        $api_key    ="665941223935463";
        $api_secret = "XDn_id0s_ep0S6UHw0cXkhFZKuw";

        $timestamp = time();
        $signature = sha1("timestamp={$timestamp}{$api_secret}");

        $file = new \CURLFile($image->getRealPath(), $image->getMimeType(), $image->getClientOriginalName());

        $post = [
            'file' => $file,
            'api_key' => $api_key,
            'timestamp' => $timestamp,
            'signature' => $signature
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.cloudinary.com/v1_1/{$cloud_name}/image/upload");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $result = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($result, true);

        if (isset($json['secure_url'])) {
            return $json['secure_url'];
        }
        return null;
    }
}