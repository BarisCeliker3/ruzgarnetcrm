<?php

namespace App\Http\Controllers;

use App\Classes\Generator;
use App\Classes\Messages;
use App\Classes\Moka;
use App\Classes\SMS_Api;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\AppCustomerApp;
use Illuminate\Support\Facades\Crypt;

use App\Classes\SMS;
use App\Classes\Telegram;
use App\Http\Controllers\Admin\PaymentController;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Content;

use App\Models\CustomerApplication;
use App\Models\FaultRecord;
use App\Models\Message;
use App\Models\Appnoti;
use App\Models\MokaLog;
use App\Models\Passreset;
use App\Models\MokaPayment;
use App\Models\MokaAutoPaymentDisable;
use App\Models\MokaSale;
use App\Models\Payment;
use App\Models\SentMessage;
use App\Models\Staff;
use App\Models\Subscription;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class APIController extends Controller
{
    
    public function get_fault_with_serial_number(Request $request)
    {
        if (
            $request->input('serial_number') != null
        ) {
            $serial_number = $request->input('serial_number');

            $data = FaultRecord::selectRaw(
                'customers.identification_number,
                fault_types.title AS type_title,
                CONCAT(customers.first_name, \' \', customers.last_name) AS full_name,
                fault_records.description,
                fault_records.status'
            )
                ->join('customers', 'customers.id', 'fault_records.customer_id')
                ->join('fault_types', 'fault_types.id', 'fault_records.fault_type_id')
                ->where("fault_records.serial_number", $serial_number)->get();
            if ($data->count() > 0) {
                return response()->json([
                    'error' => false,
                    'is_null' => false,
                    'data' => $data[0]
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => "Arıza kaydı bulunamadı."
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'message' => "Lütfen geçerli değerler gönderiniz."
            ]);
        }
    }
public function applicationFaults(Request $request){
 $myphone = $request->phone;

        // Telefon numarasının '90' ile başlayıp başlamadığını kontrol et
        // ve başlıyorsa ilk iki karakteri (90) sil
        if (str_starts_with($myphone, '90')) {
            $myphone = substr($myphone, 2); // İlk 2 karakteri sil
        }
    // Find the user by phone number
    // BURAYI KESİNLİKLE KONTROL ET: 'telephone' yerine veritabanındaki doğru sütun adını kullanın.
    $user = Customer::where('telephone', $myphone)->first(); // Veya 'telefon' ya da 'phone'
    // Check if a user was found

    if ($user) {
        // Check for fault records with status 1
        $hasFaultRecord = $user->faultRecords()->where('status', 1)->exists();

        if ($hasFaultRecord) {
            return response()->json([
                'status' => 'error',
                'message' => 'Aktif kaydınız bulunmaktadır.'
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'arıza kaydı bulunmamakta'
            ]);
        }
    } else {
        // KULLANICI BULUNAMADIĞINDA BURADAN MUTLAKA BİR YANIT DÖNMELİ!
      return response()->json([
                'status' => 'success',
                'message' => 'Kullanıcı bulunamadı ancak yeni bir kayıt oluşturulabilir.'
            ]);
    }
}


public function appnotis(Request $request)
{
      $yesterday = now()->subDay();

    // notify_time son 1 gün içindekiler
    return response()->json(
        Appnoti::where('notify_time', '>=', $yesterday)
                ->orderBy('notify_time')
                ->get()
    );
}
    public function getcontents(Request $request)
    {

        $category = $request->input('category');
        if (!in_array($category, ['Aile', 'Çocuk'])) {
            return response()->json(['error' => 'Geçersiz kategori'], 400);
        }

        $contents = Content::where('category', $category)->get();

        return response()->json($contents);
        
    }
public function filtercheck(Request $request)
{
    $userId = $request->input('user_id');
    $password = $request->input('password');

    if (!$userId || !$password) {
        return response()->json([
            'success' => false,
            'message' => 'Eksik parametre'
        ], 400);
    }

    $user = AppCustomerApp::where('id', $userId)->first();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Kullanıcı bulunamadı'
        ], 404);
    }

    // Şifreyi çöz ve karşılaştır
    try {
        $decryptedPassword = Crypt::decryptString($user->password);

        if ($password === $decryptedPassword) {
            return response()->json(['success' => true], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Şifre yanlış',
            'gelen_password' => $password,
            'db_password' => $decryptedPassword
        ], 401);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Şifre çözülemedi: ' . $e->getMessage()
        ], 500);
    }
}



public function appstorecustomer(Request $request) {
    // 1. Validator ile manuel doğrulama
    $validator = Validator::make($request->all(), [
        'appcustomer_name' => 'required|string|max:255',
        'appcustomer_email' => 'required|email|max:255|unique:appcustomer_app,appcustomer_email',
        'appcustomer_tc' => 'required|string|max:255|unique:appcustomer_app,appcustomer_tc',
        'app_phone' => 'required|string|max:255',
       
        'password' => 'required|string|min:6',
    ]);

    // 2. Hataları kontrol et
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $validated = $validator->validated();
        $validated['appcustomer_begin'] = now()->toDateString();

        // Şifreyi encrypt ile şifrele
        $validated['password'] = Crypt::encryptString($validated['password']);

        // Tokeni otomatik oluştur ve hashle
        $token = Str::random(60);
        $validated['api_token'] = hash('sha256', $token);

        AppCustomerApp::create($validated);

        return response()->json([
            'success' => true,
            'token' => $token
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Kayıt sırasında bir hata oluştu.',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function sendResetCode(Request $request)
{
    $request->validate(['phone' => 'required']);

    $user = AppCustomerApp::where('app_phone', $request->phone)->first();
    if (!$user) {
        return response()->json(['success' => false, 'message' => 'Kullanıcı bulunamadı'], 404);
    }
    $phone = $user->app_phone;
    $code = rand(100000, 999999);

    if (strpos($phone, '0') !== 0 && strpos($phone, '90') !== 0 && strpos($phone, '+90') !== 0) {
        $phone = '+90' . $phone;
    }

    // Son gönderim kontrolü (created_at Carbon objesi olmalı)
    $lastReset = Passreset::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
    if ($lastReset && $lastReset->created_at) {
        $lastCreatedAt = Carbon::parse($lastReset->created_at);
        if ($lastCreatedAt->diffInMinutes(now()) < 30) {
            return response()->json([
                'success' => false,
                'message' => 'Son 30 dakika içinde SMS kodu gönderdiniz. Lütfen daha sonra tekrar deneyin.'
            ], 429);
        }
    }

    Passreset::updateOrCreate(
        ['user_id' => $user->id],
        [
            'phone' => $phone,
            'token' => $code,
            'created_at' => now()
        ]
    );

    $sms = new SMS();
    $result = $sms->submit(
        "RUZGARNET",
        "RüzgarPlus kodunuz :" . $code,
        array($phone)
    );

    if ($result === true) {
        return response()->json(['success' => true, 'message' => 'Kod gönderildi']);
    } else {
        return response()->json(['success' => false, 'message' => 'SMS gönderilemedi', 'error' => $result], 500);
    }
}

    // 2. Kod ve yeni şifre ile sıfırla
    public function resetWithCode(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'code' => 'required',
            'new_password' => 'required|max:7',
        ]);
        $user = AppCustomerApp::where('app_phone', $request->phone)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Kullanıcı bulunamadı'], 404);
        }
        $reset = Passreset::where('user_id', $user->id)->where('token', $request->code)->first();
        if (!$reset) {
            return response()->json(['success' => false, 'message' => 'Kod hatalı'], 400);
        }
        // Kodun süresi geçti mi kontrol (10dk)
        if (Carbon::parse($reset->created_at)->addMinutes(10)->isPast()) {
            return response()->json(['success' => false, 'message' => 'Kodun süresi dolmuş'], 400);
        }
        // Şifreyi değiştir (örnek: Crypt ile şifrelenmiş)
        $user->password = Crypt::encryptString($request->new_password);
        $user->save();
        $reset->delete();

        return response()->json(['success' => true, 'message' => 'Şifreniz değiştirildi']);
    }
 public function changePassword(Request $request)
    {
        $userId = $request->input('user_id');
        $oldPassword = $request->input('old_password');
        $newPassword = $request->input('new_password');

        if (!$userId || !$oldPassword || !$newPassword) {
            return response()->json([
                'success' => false,
                'message' => 'Eksik parametre'
            ], 400);
        }

        $user = AppCustomerApp::where('id', $userId)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Kullanıcı bulunamadı'
            ], 404);
        }

        try {
            $decryptedPassword = Crypt::decryptString($user->password);

            if ($oldPassword !== $decryptedPassword) {
                return response()->json([
                    'success' => false,
                    'message' => 'Eski şifre yanlış'
                ], 401);
            }

            // Yeni şifreyi şifrele ve kaydet
            $user->password = Crypt::encryptString($newPassword);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Şifre başarıyla değiştirildi'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Şifre değiştirilemedi: ' . $e->getMessage()
            ], 500);
        }
    }
public function customercheck(Request $request){
    $request->validate([
        'phone' => 'required|string',
    ]);

    // Telefona göre müşteri arıyoruz
    $customer = Customer::where('telephone', $request->phone)->first();

    if (!$customer) {
        return response()->json(['message' => 'Müşteri bulunamadı.'], 404);
    }
    $tc = $customer->tc ?? $customer->identification_number;

    // TC alıyoruz
  if (!$tc || strlen($tc) < 4) {
    return response()->json(['message' => 'TC numarası geçersiz.'], 400);
}
// TC'nin son 4 rakamını al
$shortTc = substr($tc, -4);

// Rastgele bir UUID
$randomSalt = substr(Str::uuid()->toString(), 0, 12); // UUID'yi kısalt

$payload = $shortTc . '' . $randomSalt;
$encryptedPassword = Crypt::encryptString($payload);


$decryptedPayload = Crypt::decryptString($encryptedPassword);

// Geri çözmek istersen:

    // Daha önce appcustomer_tc ile kayıt var mı kontrol et
    $appCustomer = AppCustomerApp::where('appcustomer_tc', $tc)->first();

    if ($appCustomer) {
        // Kayıt varsa güncelle
        $appCustomer->password = $encryptedPassword;
        $appCustomer->appcustomer_name  = trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''));
        $appCustomer->appcustomer_email = $customer->email ?? $appCustomer->appcustomer_email;
        $appCustomer->app_phone         = $customer->telephone;
        $appCustomer->appcustomer_begin = now();
        
        $saved = $appCustomer->save();

        if ($saved) {
$phoneno = $customer->telephone;
if (!str_starts_with($phoneno, '90')) {
    $phoneno = '90' . ltrim($phoneno, '0');  // $phoneno güncellendi
}

/*
$sms = new SMS();

$result = $sms->submit(
        "RUZGARNET",
        "RüzgarPlus tek kullanımlık şifreniz:".$decryptedPayload,
        array($phoneno)
    );
	
// Mesaj içeriğini loglayabilir veya response’a ekleyebilirsin:
if ($result === true) {
        return $result;

    return response()->json([
        'message' => 'Şifre başarıyla gönderildi.'.$decryptedPayload,
        'sms_icerigi' => $decryptedPayload,
        'telefon' => $phoneno,
        'result' => $result
    ]);
} else {
    return response()->json([
        'message' => 'Şifre gönderilemedii.',
        'sms_icerigi' => $decryptedPayload,
        'telefon' => $phoneno,
        'error' => $result['error'] ?? ('Netgsm hata kodu: ' . ($result['code'] ?? 'Bilinmiyor')),
    ], 500);
}
*/
            return response()->json([
                'message'  => 'Kayıt güncellendi.'.$decryptedPayload,
                'password' => '5456'.$decryptedPayload,
            ]);

        } else {
            return response()->json(['message' => 'Kayıt güncellenemedi.'], 500);
        }

    } else {
        // Yeni kayıt oluştur

        $newAppCustomer = new AppCustomerApp();
        $newAppCustomer->appcustomer_name  = trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''));
        $newAppCustomer->appcustomer_email = $customer->email ?? '';
        $newAppCustomer->appcustomer_tc    = $tc;
        $newAppCustomer->appcustomer_begin = now();
        $newAppCustomer->app_phone         = $customer->telephone;
        $newAppCustomer->password          = $encryptedPassword;

        $saved = $newAppCustomer->save();
    
            $sms = new SMS();


$result = $sms->submit('RUZGARNET',"yeni şifreniz: " . $decryptedPayload,[$phoneno]);
if ($result === true) {
    return response()->json([
        'message' => 'Şifre başarıyla gönderildi.',
    ]);
} else {
    // $result hata mesajı içeriyorsa loglayabilir veya kullanıcıya gösterebilirsin
    return response()->json([
        'message' => 'Şifre gönderilemedi.',
        'error'   => $result,
    ], 500);
}
        if ($saved) {
            return response()->json([
                'message'  => 'Kayıt başarıyla oluşturuldu.',
                'password' => 'burası'.$decryptedPayload,
            ]);
        } else {
            return response()->json(['message' => 'Kayıt oluşturulamadı.'], 500);
        }
    }
}

public function checnumber(Request $request){
        $phone = "5375720297";

$message = "sifrebu";

$messages = [
    ['905375720297', 'test']
];
$sms = new SMS();

$result = $sms->submit(
        "RUZGARNET",
        "Türkiye'nin interneti e başvurunuz alınmıştır.Bilgi vermek ve Abonelik için 02162050606 numaralı telefondan size ulaşacağız RUZGARNET",
        array($phone)
    );
    }
    public function add_application(Request $request)
    {
 
        if ( $request->input('application_type_id') != null) 
        {
            
            $application_type_id = $request->input('application_type_id');
            
            if ($application_type_id == 6) 
            {
                
              
                    if (
                        $request->input('kimlikOn') != null &&
                        $request->input('kimlikArka') != null
                    )
                    {
                        
                        $kimlikOn = $request->input('kimlikOn');
                        $kimlikArka = $request->input('kimlikArka');
    
                        
                    
                        $kimlikOn = str_replace(" ", "+", $kimlikOn);
                        $kimlikArka = str_replace(" ", "+", $kimlikArka);
                        
                        $data = base64_decode($kimlikOn);
                        $data2 = base64_decode($kimlikArka);

                        $file = 'files/kimlik/' . str_shuffle(substr("abcdefghijklmnoprstuvyzwxqABCDEFGHIJKLMNOPRSTUVYZWXQ0123456789", 0, 32)) . ".jpeg";
                        $success  = file_put_contents($file, $data);
                        
                        $file2 = 'files/kimlik/' . str_shuffle(substr("abcdefghijklmnoprstuvyzwxqABCDEFGHIJKLMNOPRSTUVYZWXQ0123456789", 0, 32)) . ".jpeg";
                        $success2  = file_put_contents($file2, $data2);

            
                        if($success){
                       
                           Telegram::send_photo(
                                    "evrakYukleme",
                                    $file
                                );
                                
                                   Telegram::send_photo(
                                    "evrakYukleme",
                                    $file2
                                );
                                
                               
                                 return response()->json([
                            'error' => false,
                            'message' => 'Evraklarınız şirketimize iletilmiştir. En kısa sürede sizlere dönüş sağlayacağız'
                        ]);
                            
                            
                        
            
                        }
                         else
                        {
                            return response()->json([
                                'error' => true,
                                'message' => 'Kimlik resimleri gönderilirken bir hata oluştu.z'
                            ]);
                        }
            
                    }
                        
              
            } else if ($application_type_id == 3) {
                if (
                    $request->input('address') != null &&
                    $request->input('phone') != null &&
                    $request->input('full_name') != null
                ) {
                    $address = $request->input('address');
                    $phone = $request->input('phone');
                    $tariff_id = $request->input('tariff_id');
                    $full_name = $request->input('full_name');

                    $first_name = "";
                    $last_name = "";

                    $full_name = explode(" ", $full_name);
                    $last_name = $full_name[count($full_name) - 1];
                    foreach ($full_name as $index => $item) {
                        if ($index >= (count($full_name) - 1))
                            break;
                        $first_name .= " " . $item;
                    }

                    $information = [
                        'address' => $address,
                        'telephone' => $phone,
                        'first_name' => $first_name,
                        'last_name' => $last_name
                    ];

                    if (CustomerApplication::create([
                        'customer_application_type_id' => $application_type_id,
                        'description' => "Rüzgar Destek",
                        'information' => $information
                    ])) {
                        
                        Telegram::send(
                            "BizSiziArayalım",
                            $first_name . " " . $last_name . " adlı bir kullanıcı RüzgarFIBER hakkında bilgi almak istiyor. Telefon Numarası : " . $phone
                        );
                        
                        SentMessage::create([
                            'phone' => $phone,
                            'message' => Message::find(39)->message
                        ]);

                        return response()->json([
                            'error' => false,
                            'message' => "Başvuru kaydınız başarılı bir şekilde alınmıştır."
                        ]);
                    } else {
                        return response()->json([
                            'error' => true,
                            'message' => "Beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyiniz."
                        ]);
                    }
                } else {
                    return response()->json([
                        'error' => true,
                        'message' => "Lütfen geçerli değerler gönderiniz."
                    ]);
                }
            } else if ($application_type_id == 1) {
                if (
                    $request->input('identification_number') != null &&
                    $request->input('image') != null
                ) {
                    $identification_number = $request->input('identification_number');
                    $image = $request->input('image');

                    $customer = Customer::where("identification_number", $identification_number)->get();
                    if ($customer->count() > 0) {

                        $basvuru_count = CustomerApplication::where('customer_id',$customer[0]->id)->where('customer_application_type_id',1)->where('status', 1)->count();
                        if($basvuru_count < 1){
                            $files = [];
                            $image = str_replace(" ", "+", $image);
                            $data = base64_decode($image);

                            $file = 'files/' . str_shuffle(substr("abcdefghijklmnoprstuvyzwxqABCDEFGHIJKLMNOPRSTUVYZWXQ0123456789", 0, 32)) . ".jpeg";
                            file_put_contents($file, $data);

                            $files[] = $file;

                            if (CustomerApplication::create([
                                'staff_id' => $customer[0]->staff->id,
                                'customer_application_type_id' => $application_type_id,
                                'customer_id' => $customer[0]->id,
                                'description' => "Rüzgar Destek",
                                'information' => json_encode([]),
                                'files' => json_encode($files)
                            ])) {
                                Telegram::send(
                                    "İptal Başvuru",
                                    trans(
                                        'telegram.application_cancel',
                                        [
                                            'full_name' => $customer[0]->full_name,
                                            'telephone' => $customer[0]->telephone,
                                            'staff_name' => $customer[0]->staff->first_name
                                        ]
                                    )
                                );
                                Telegram::send_photo(
                                    "İptal Başvuru",
                                    $files[0]
                                );

                                return response()->json([
                                    'error' => false,
                                    'message' => "İptal başvurunuz başarılı bir şekilde oluşturulmuştur."
                                ]);
                            } else {
                                return response()->json([
                                    'error' => true,
                                    'message' => "Beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyiniz."
                                ]);
                            }
                        }else{
                            return response()->json([
                                    'error' => true,
                                    'message' => "Aktif başvurunuz bulunmaktadır. Lütfen daha sonra tekrar deneyiniz."
                                ]);
                        }
                    } else {
                        return response()->json([
                            'error' => true,
                            'message' => "Bu kimlik numarasına ait bir kayıt bulunamadı."
                        ]);
                    }
                }
            } else if ($application_type_id == 5) {
                if (
                    $request->input('identification_number') != null &&
                    $request->input('image') != null
                ) {
                    $identification_number = $request->input('identification_number');
                    $image = $request->input('image');

                    $customer = Customer::where("identification_number", $identification_number)->get();
                    if ($customer->count() > 0) {

                        $basvuru_count = CustomerApplication::where('customer_id',$customer[0]->id)->where('customer_application_type_id',5)->where('status', 1)->count();
                        if($basvuru_count < 1){
                            $files = [];
                            $image = str_replace(" ", "+", $image);
                            $data = base64_decode($image);

                            $file = 'files/' . str_shuffle(substr("abcdefghijklmnoprstuvyzwxqABCDEFGHIJKLMNOPRSTUVYZWXQ0123456789", 0, 32)) . ".jpeg";
                            file_put_contents($file, $data);



                            $files[] = $file;

                            if (CustomerApplication::create([
                                'staff_id' => $customer[0]->staff->id,
                                'customer_application_type_id' => $application_type_id,
                                'customer_id' => $customer[0]->id,
                                'description' => "Rüzgar Destek",
                                'information' => json_encode([]),
                                'files' => json_encode($files)
                            ])) {
                                Telegram::send(
                                    "İptal Başvuru",
                                    trans(
                                        'telegram.hizmet_numrasi_tlg',
                                        [
                                            'full_name' => $customer[0]->full_name,
                                            'telephone' => $customer[0]->telephone,
                                            'staff_name' => $customer[0]->staff->first_name
                                        ]
                                    )
                                );
                                Telegram::send_photo(
                                    "İptal Başvuru",
                                    $files[0]
                                );

                                return response()->json([
                                    'error' => false,
                                    'message' => "Hizmet numaras öğrenmebaşvurusu başarılı bir şekilde oluşturulmuştur."
                                ]);
                            } else {
                                return response()->json([
                                    'error' => true,
                                    'message' => "Beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyiniz."
                                ]);
                            }
                        }else{
                            return response()->json([
                                    'error' => true,
                                    'message' => "Aktif başvurunuz bulunmaktadır. Lütfen daha sonra tekrar deneyiniz."
                                ]);
                        }
                    } else {
                        return response()->json([
                            'error' => true,
                            'message' => "Bu kimlik numarasına ait bir kayıt bulunamadı."
                        ]);
                    }
                }
            } else if ($application_type_id == 2) {
                if (
                    $request->input('identification_number') != null &&
                    $request->input('description') != null
                ) {
                    $identification_number = $request->input('identification_number');
                    $description = $request->input('description');
                    $application_type_id = $request->input('application_type_id');

                    $customer = Customer::where("identification_number", $identification_number)->get();
                    if ($customer->count() > 0) {
                        if (CustomerApplication::create([
                            'staff_id' => $customer[0]->staff->id,
                            'customer_application_type_id' => $application_type_id,
                            'customer_id' => $customer[0]->id,
                            'description' => $description,
                            'information' => json_encode([])
                        ])) {
                            Telegram::send(
                                "KaliteKontrolEkibi",
                                "[TARİFE YÜKSELTME] \nAdı Soyadı : " . $customer[0]->full_name . "\nTelefon Numarası : " . $customer[0]->telephone . "\nMüşteri Temsilcisi : " . $customer[0]->staff->full_name
                            );

                            return response()->json([
                                'error' => false,
                                'message' => "Tarife yükseltme başvurunuz başarılı bir şekilde oluşturuldu."
                            ]);
                        } else {
                            return response()->json([
                                'error' => true,
                                'message' => "Beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyiniz."
                            ]);
                        }
                    } else {
                        return response()->json([
                            'error' => true,
                            'message' => "Bu kimlik numarasına ait bir kayıt bulunamadı."
                        ]);
                    }
                } else {
                    return response()->json([
                        'error' => true,
                        'message' => "Lütfen geçerli değerler gönderiniz.1"
                    ]);
                }
            } else {
                return response()->json([
                    'error' => true,
                    'message' => "Lütfen geçerli değerler gönderiniz."
                ]);
            }
        }
         else {
                return response()->json([
                    'error' => true,
                    'message' => "Lütfen geçerli değerler gönderiniz."
                ]);
            }
    }

    public function get_reference_code(Request $request)
    {
        if (
            $request->input('identification_number') != null
        ) {
            $validated = [
                'identification_number' => $request->input('identification_number')
            ];

            $customer = Customer::select('reference_code')->where('identification_number', $validated["identification_number"])->get();

            if ($customer->count() > 0) {
                return response()->json([
                    'error' => false,
                    'is_null' => false,
                    'reference_code' => $customer[0]->reference_code
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'is_null' => true,
                    'message' => "Bu kimlik numarasına ait bir kayıt bulunamadı."
                ]);
            }
        }
    }

    public function add_decont(Request $request)
    {
        $result_json = array();
        if (
            $request->input('image') != null &&
            $request->input('title') != null
        )
        {

            $values = [
                'title' => $request->input('title'),
                'image' => $request->input('image')
            ];

            $image = str_replace(" ", "+", $values['image']);
            $data = base64_decode($image);

            $file = 'files/deconts/' . str_shuffle(substr("abcdefghijklmnoprstuvyzwxqABCDEFGHIJKLMNOPRSTUVYZWXQ0123456789", 0, 32)) . ".jpeg";
            $success = file_put_contents($file, $data);

            if($success){
                if (!empty($file)) {
                    Telegram::send_photo(
                        "Dekont yükleme",
                        $file
                    );
                }

                Telegram::send(
                    "Dekont yükleme",
                    $values['title']
                );

                return response()->json([
                    'error' => false,
                    'message' => 'Dekont başarılı şekilde gönderildi.'
                ]);

            }else{
                return response()->json([
                    'error' => true,
                    'message' => 'Dekont gönderilirken bir hata oluştu.'
                ]);
            }

        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Lütfen geçerli değerler giriniz.'
            ]);
        }

    }
    public function add_fault(Request $request)
    {
        if (
            $request->input('identification_number') != null &&
            $request->input('token') != null &&
            $request->input('image') != null &&
            $request->input('latitude') != null &&
            $request->input('longitude') != null &&
            $request->input('fault_title_id') != null
        ) {

            $values = [
                'identification_number' => $request->input('identification_number'),
                'token' => $request->input('token'),
                'image' => $request->input('image'),
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'fault_title_id' => $request->input('fault_title_id')
            ];

            $customer = Customer::where('identification_number', $values["identification_number"])->get();
            $is_black_list = DB::table('black_list')->where('identification_number',$values["identification_number"])->count();

            $subs_count = DB::table('subscriptions')
            ->where('customer_id',$customer[0]->id)->where('status',1)->count();

            if ($customer->count() > 0) {
                if($subs_count > 0){
                    if($is_black_list==0){
                        $files = [];

                        $validated["serial_number"] = Generator::serialNumber();
                        $validated["files"] = $files;
                        $validated["solution_detail"] = "";

                        $validated = $validated + [
                            'customer_id' => $customer[0]->id,
                            'fault_type_id' => $values["fault_title_id"],
                            'status' => 1,
                            'description' => ''
                        ];

                        $image = str_replace(" ", "+", $values['image']);
                        $data = base64_decode($image);

                        $file = 'files/' . str_shuffle(substr("abcdefghijklmnoprstuvyzwxqABCDEFGHIJKLMNOPRSTUVYZWXQ0123456789", 0, 32)) . ".jpeg";
                        file_put_contents($file, $data);

                        $files[] = $file;

                        $validated["files"] = $files;

                        $message = Message::where("id", 20)->get();

                        $fault_count = FaultRecord::where('customer_id',$customer[0]->id)->whereNotIn('status', [2,5,6])->count();

                        if($fault_count == 0){
                            if ($fault_record = FaultRecord::create($validated)) {
                                SentMessage::insert(
                                    [
                                        'customer_id' => $customer[0]->id,
                                        'message' => (new Messages)->generate(
                                            $message[0]->message,
                                            [
                                                'seri_numarasi' => $fault_record->serial_number
                                            ]
                                        ),
                                        'staff_id' => $customer[0]->staff->id
                                    ]
                                );

                                Telegram::send(
                                    "RüzgarTeknik",
                                    trans(
                                        'telegram.add_fault_record',
                                        [
                                            'id_no' => $customer[0]->identification_number,
                                            'full_name' => $customer[0]->full_name,
                                            'telephone' => $customer[0]->telephone,
                                            'customer_staff' => $customer[0]->staff->full_name
                                        ]
                                    )
                                );

                                if (!empty($files)) {
                                    Telegram::send_photo(
                                        "RüzgarTeknik",
                                        $files[0]
                                    );
                                }

                                return response()->json([
                                    'error' => false,
                                    'message' => "",
                                    'serial_number' => Generator::serialNumber()
                                ]);
                            }
                        }else{
                            return response()->json([
                                'error' => true,
                                'message' => "Aktif arıza kaydınız bulunurken yeni arıza kaydı açamazsınız."
                            ]);
                        }

                    } else{
                        return response()->json([
                            'error' => true,
                            'message' => 'Arıza kaydı oluşturken beklenmedik bir hata oluştu. 02162050606 nolu hattan ulaşmayı deneyebilirsiniz.'
                        ]);
                    }
                }else{
                    return response()->json([
                        'error' => true,
                        'message' =>  'Aktif aboneliğiniz yoksa arıza kaydı açamazsınız.'
                    ]);
                }

            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Arıza kaydı oluşturabilmek için abone olmanız gerekmektedir.'
                ]);
            }
        }
    }
// Hizmet No Öğrenme

// --------------
    public function get_faults(Request $request)
    {
        if ($request->input("status_id") == 0) {
            $data = FaultRecord::selectRaw('fault_records.id, fault_records.status, fault_records.description, CONCAT(customers.first_name, \' \', customers.last_name) AS full_name, CONCAT(staff.first_name, \' \', staff.last_name) AS staff_full_name, fault_records.created_at AS created_date')->join('customers', 'customers.id', 'fault_records.customer_id')->join('customer_staff', 'customers.id', 'customer_staff.customer_id')->join('staff', 'staff.id', 'customer_staff.staff_id')->LIMIT (200)->orderBy('id', 'desc')->get();
        } else {
            $data = FaultRecord::selectRaw('fault_records.id, fault_records.status, fault_records.description, CONCAT(customers.first_name, \' \', customers.last_name) AS full_name, CONCAT(staff.first_name, \' \', staff.last_name) AS staff_full_name, fault_records.created_at AS created_date')->join('customers', 'customers.id', 'fault_records.customer_id')->join('customer_staff', 'customers.id', 'customer_staff.customer_id')->join('staff', 'staff.id', 'customer_staff.staff_id')->where('status', $request->input("status_id"))->get();
        }

        return response()->json([
            'error' => false,
            'data' => $data
        ]);
    }

    public function search_fault(Request $request)
    {
        if (
            $request->input('status_id') != null &&
            $request->input('search_string') != null
        ) {
            if ($request->input("status_id") == 0) {
                $data = FaultRecord::selectRaw('fault_records.id, fault_records.status, fault_records.description, CONCAT(customers.first_name, \' \', customers.last_name) AS full_name, CONCAT(staff.first_name, \' \', staff.last_name) AS staff_full_name, fault_records.created_at AS created_date')->join('customers', 'customers.id', 'fault_records.customer_id')->join('customer_staff', 'customers.id', 'customer_staff.customer_id')->join('staff', 'staff.id', 'customer_staff.staff_id')->whereRaw('CONCAT(customers.first_name, \' \', customers.last_name) LIKE \'%' . $request->input('search_string') . '%\'')->get();
            } else {
                $data = FaultRecord::selectRaw('fault_records.id, fault_records.status, fault_records.description, CONCAT(customers.first_name, \' \', customers.last_name) AS full_name, CONCAT(staff.first_name, \' \', staff.last_name) AS staff_full_name, fault_records.created_at AS created_date')->join('customers', 'customers.id', 'fault_records.customer_id')->join('customer_staff', 'customers.id', 'customer_staff.customer_id')->join('staff', 'staff.id', 'customer_staff.staff_id')->whereRaw('CONCAT(customers.first_name, \' \', customers.last_name) LIKE \'%' . $request->input('search_string') . '%\'')->where('status', $request->input("status_id"))->get();
            }

            if ($data->count() > 0) {
                return response()->json([
                    'error' => false,
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => "Arıza bulunamadı."
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'message' => "Lütfen geçerli değerler gönderiniz."
            ]);
        }
    }

    public function get_fault(Request $request)
    {
        $data = FaultRecord::selectRaw('customers.identification_number, fault_types.title AS type_title, CONCAT(customers.first_name, \' \', customers.last_name) AS full_name, fault_records.description AS detail, fault_records.status, fault_records.solution_detail')->join('fault_types', 'fault_types.id', 'fault_records.fault_type_id')->join('customers', 'customers.id', 'fault_records.customer_id')->where('fault_records.id', $request->input('fault_id'))->get();
        return response()->json([
            'error' => false,
            'data' => $data[0]
        ]);
    }

    public function edit_fault(Request $request)
    {
        if (
            $request->input('fault_id') != null &&
            $request->input('status_id') != null &&
            $request->input('username') != null
        ) {
            $fault_id = $request->input('fault_id');
            $status_id = $request->input('status_id');
            $detail = $request->input('detail');
            if (!$detail) {
                return response()->json([
                    'error' => true,
                    'message' => "NOT"
                ]);
            }
            $username = $request->input('username');
            $explode_detail = explode (":",$detail);

            if($explode_detail[0]=="SMS" || $explode_detail[0]=="sms" || $explode_detail[0]=="Sms"){
                $fault_sms = $explode_detail[1];
            }else{
                $fault_sms = " ";
            }
            $fault_record = FaultRecord::find($fault_id);

            $fault_record->status = $status_id;
            $fault_record->solution_detail = $detail;

            if ($fault_record->save()) {
                Telegram::send(
                    "RüzgarTeknik",
                    trans('telegram.edit_fault', ['full_name' => $fault_record->customer->full_name, 'serial_number' => $fault_record->serial_number, 'status' => trans('tables.fault.record.status.' . $status_id), 'detail' => $fault_record->solution_detail, 'username' => $username])
                );
                if($status_id == "5"){
                    $message = Message::find(54);
                }
                else if($status_id == "6"){
                    $message = Message::find(55);
                }else if($status_id == "2"){
                    $message = Message::find(57);
                }
                else{
                    $message = Message::find(38);
                }


                $message->message = $message->message." ".$fault_sms;
                SentMessage::insert(
                    [
                        'customer_id' => $fault_record->customer->id,
                        'message' => (new Messages)->generate(
                            $message->message,
                            [
                                'durum' => trans('tables.fault.record.status.' . $status_id)
                            ]
                        )
                    ]
                );

                return response()->json([
                    'error' => false,
                    'message' => "Başarılı bir şekilde güncellendi."
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => "Beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyiniz."
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'message' => "Lütfen geçerli değerler gönderiniz."
            ]);
        }
    }
public function loginapp(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Auth guard olarak default guard'ı kullanıyorsan ama modeli değiştirmek istiyorsan,
        // Auth::attempt() ile login yapmazsan, kendi model ile manuel kontrol yapman gerekebilir.
        // Eğer 'AppCustomerApp' modelini kullanacak şekilde guard yapılandırmadıysan, şöyle yapabilirsin:
    $user = AppCustomerApp::where('appcustomer_email', $request->email)->first();


    if (!$user) {
        return response()->json([
            'message' => 'E-posta bulunamadı',
            'email' => $request->email,
        ], 401);
    }

    try {
        $decryptedPassword = Crypt::decryptString($user->password);

        if ($request->password !== $decryptedPassword) {
            return response()->json([
                'message' => 'Şifre hatalı',
                'email' => $request->email,
                'password' => $request->password,
            ], 401);
        }
    } catch (DecryptException $e) {
        return response()->json([
            'message' => 'Şifre çözülemedi',
        ], 401);
    }



        // Sanctum token üret
        $token = Str::random(60);
$user->api_token = hash('sha256', $token);
$user->save();
        

        return response()->json([
            'message' => 'Giriş başarılı',
            'user' => $user,
            'id' => $user->id,
            
            'token' => $token,
        ]);
    }
    public function login(Request $request)
    {
        if (
            $request->input('username') != null &&
            $request->input('password') != null
        ) {
            $validated = [
                'username' => $request->input('username'),
                'password' => $request->input('password')
            ];

            $user = User::where(['username' => $validated["username"]])->get();
            if ($user->count() > 0) {
                $result = Hash::check($validated["password"], $user[0]->password);
                if ($result) {
                    return response()->json([
                        'error' => false,
                        'message' => "Başarılı bir şekilde giriş yaptınız."
                    ]);
                } else {
                    return response()->json([
                        'error' => true,
                        'message' => "Kullanıcı adı veya şifre yanlış."
                    ]);
                }
            } else {
                return response()->json([
                    'error' => true,
                    'message' => "Kullanıcı adı veya şifre yanlış."
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'message' => "Lütfen geçerli değerler gönderiniz."
            ]);
        }
    }
public function check_customer_ariza(Request $request)
    {
 
         
     $tc = $request->identification_number;
     
     $customer = Customer::where('identification_number', $tc)
    ->with(['subscriptions' => function ($query) {
        // sadece status = 1 olan abonelikleri alıyoruz
        $query->where('status', 1);
    }])
    ->first();
       
         if (!$customer) {
             
        return response()->json(['success' => false, 'message' => 'Kullanıcı bulunamadı']);
    }
   

    $subscription = $customer->subscriptions->first();
    if (!$subscription) {
        return response()->json(['success' => false, 'message' => 'Aktif abonelik bulunamadı']);
    } 
        // Aktif (status = 1) abonelik varsa, ilkini alıyoruz

        
        
        // En son ödemeyi alıyoruz
  $targetDate = Carbon::now()->format('Y-m-15'); // Bu ayın 15'i

$latestPayment = $subscription->payments()
    ->whereDate('date', $targetDate)
    ->first();
        
        $now = Carbon::now('Europe/Istanbul');
        $gun = $now->day;
        $saatDakika = (int) $now->format('Hi');
      
        // Eğer ödeme varsa ve ödemesi açık (status = 1) ise ve 12'sinin 23:50'den sonrasındaysa
        if ($latestPayment && $latestPayment->status === "1") {
            
            // Eğer bugün 12. günse, saat 23:50 ve sonrasını kontrol et
            if ($gun === 12 && $saatDakika >= 2350) {
                return response()->json([
                    'success' => false,
                    
                    'message' => '
                     <div class="max-w-sm mx-auto bg-white rounded-3xl shadow-xl ring-1 ring-gray-200 overflow-hidden hover:shadow-2xl transition-shadow duration-300">
  <!-- Başlık Alanı -->

  <!-- İçerik Alanı -->
  <div class="p-6 space-y-4">
    <p class="text-gray-700">
     Değerli Abonemiz ödenmemiş faturanız <span class="font-semibold text-red-600">bulunmakta olup</span> talebinizin değerlendirmeye alınabilmesi için
     lütfen ödemenizi gerçekleştiriniz.
     Hızlıca ödeme yapmak için lütfen tıklayınız.
    </p>
   
  </div>

  <!-- Buton Alanı -->
 <div class="flex flex-col items-center">
   <a href="https://www.ruzgarnet.com.tr/fatura" 
   class="inline-block px-6 py-3 bg-gradient-to-r text-decoration-none from-green-400 to-blue-500 text-white text-lg font-semibold rounded-lg shadow-md hover:from-green-500 hover:to-blue-600 transition duration-300 ease-in-out">
   <h4 style="    justify-self: center;" class="buttonPay text-lg font-semibold text-gray-800">Hızlıca Ödeme</h4></a>
    <div class="arrow-container">

    <div class="arrow-container">
      <svg
        class="arrow-icon"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
      >
        <!-- Düz çizgi -->
        <line x1="12" y1="4" x2="12" y2="14" stroke-linecap="round" />
        <!-- Ok ucu -->
        <polyline points="6 10 12 16 18 10" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </div>

  </div>
    <div class="mt-4 text-center md:text-left">
    <a style="font-weight: 700;"
      href="https://www.ruzgarnet.com.tr/fatura"
      class="text-blue-600 underline hover:text-blue-800 break-all"
      target="_blank"
    >
      https://www.ruzgarnet.com.tr/fatura
    </a>
  </div>
</div>'
                ]);
            }
        
            // Eğer bugün 13 veya sonrasındaysa, arıza kaydı oluşturulamaz
            
            if ($gun > 12) {
                return response()->json([
                    'success' => false,
                    
                    'message' => '
                <div class="max-w-sm mx-auto bg-white rounded-3xl shadow-xl ring-1 ring-gray-200 overflow-hidden hover:shadow-2xl transition-shadow duration-300">
  <!-- Başlık Alanı -->

  <!-- İçerik Alanı -->
  <div class="p-6 space-y-4">
    <p class="text-gray-700">
     Değerli Abonemiz ödenmemiş faturanız <span class="font-semibold text-red-600">bulunmakta olup</span> talebinizin değerlendirmeye alınabilmesi için
     lütfen ödemenizi gerçekleştiriniz.
     Hızlıca ödeme yapmak için lütfen tıklayınız.
    </p>
   
  </div>

  <!-- Buton Alanı -->
 <div class="flex flex-col items-center">
    <a href="https://www.ruzgarnet.com.tr/fatura" 
   class="inline-block px-6 py-3 bg-gradient-to-r text-decoration-none from-green-400 to-blue-500 text-white text-lg font-semibold rounded-lg shadow-md hover:from-green-500 hover:to-blue-600 transition duration-300 ease-in-out">
   <h4 style="    justify-self: center;" class="buttonPay text-lg font-semibold text-gray-800">Hızlıca Ödeme</h4></a>

    <div class="arrow-container">
      <svg
        class="arrow-icon"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
      >
        <!-- Düz çizgi -->
        <line x1="12" y1="4" x2="12" y2="14" stroke-linecap="round" />
        <!-- Ok ucu -->
        <polyline points="6 10 12 16 18 10" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </div>

  </div>
    <div class="mt-4 text-center md:text-left">
    <a style="font-weight: 700;"
      href="https://www.ruzgarnet.com.tr/fatura"
      class="text-blue-600 underline hover:text-blue-800 break-all"
      target="_blank"
    >
      https://www.ruzgarnet.com.tr/fatura
    </a>
  </div>
</div>'
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Arıza kaydı oluşturulabilir.'
                ]);
            }
        }
       
        return response()->json([
            'success' => true,
            'message' => 'Arıza kaydı oluşturulabilir.'
        ]);
        
        
    } 
    public function check_customer(Request $request)
    {
 

        $tc = $request->identification_number;
       
        $customer = Customer::where('identification_number', $tc)
            ->with(['subscriptions' => function ($query) {
                // sadece status = 1 olan abonelikleri alıyoruz
                $query->where('status', 1);
            }])
            ->first();
       
         if (!$customer) {
        return response()->json(['success' => false, 'message' => 'Kullanıcı bulunamadı']);
    }
    
    
 $subscription = $customer->subscriptions()->latest()->first();

if (!$subscription) {
    return response()->json(['success' => false, 'message' => 'Aktif abonelik bulunamadı']);
}

// En son ödemeyi alıyoruz
$now = Carbon::now('Europe/Istanbul');

$currentMonth = $now->month;
$currentYear = $now->year;

$latestPayment = $subscription->payments()
    ->whereMonth('date', $currentMonth)
    ->whereYear('date', $currentYear)
    ->first();
         // payments ilişkisinden ilk ödeme
        $gun = $now->day;
        $saatDakika = (int) $now->format('Hi');
     
        // Eğer ödeme varsa ve ödemesi açık (status = 1) ise ve 12'sinin 23:50'den sonrasındaysa
        if ($latestPayment->status === "1") {
            
            // Eğer bugün 12. günse, saat 23:50 ve sonrasını kontrol et
                return response()->json([
                    'success' => false,
                    
                    'message' => '
                 <div class="max-w-sm mx-auto bg-white rounded-3xl shadow-xl ring-1 ring-gray-200 overflow-hidden hover:shadow-2xl transition-shadow duration-300">
  <!-- Başlık Alanı -->

  <!-- İçerik Alanı -->
  <div class="p-6 space-y-4">
    <p class="text-gray-700">
     Değerli Abonemiz ödenmemiş faturanız <span class="font-semibold text-red-600">bulunmakta olup</span> talebinizin değerlendirmeye alınabilmesi için
     lütfen ödemenizi gerçekleştiriniz.
     Hızlıca ödeme yapmak için lütfen tıklayınız.
    </p>
   
  </div>

  <!-- Buton Alanı -->
 <div class="flex flex-col items-center">
       <a href="https://www.ruzgarnet.com.tr/fatura" 
   class="inline-block px-6 py-3 bg-gradient-to-r text-decoration-none from-green-400 to-blue-500 text-white text-lg font-semibold rounded-lg shadow-md hover:from-green-500 hover:to-blue-600 transition duration-300 ease-in-out">  <h4 style="    justify-self: center;" class="buttonPay text-lg font-semibold text-gray-800">Hızlıca Ödeme</h4></a>
    <div class="arrow-container">

    <div class="arrow-container">
      <svg
        class="arrow-icon"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
      >
        <!-- Düz çizgi -->
        <line x1="12" y1="4" x2="12" y2="14" stroke-linecap="round" />
        <!-- Ok ucu -->
        <polyline points="6 10 12 16 18 10" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </div>

  </div>
    <div class="mt-4 text-center md:text-left">
    <a style="font-weight: 700;"
      href="https://www.ruzgarnet.com.tr/fatura"
      class="text-blue-600 underline hover:text-blue-800 break-all"
      target="_blank"
    >
      www.ruzgardestek.com/fatura_ode.php
    </a>
  </div>
</div>'
                ]);
        
            } else {
               
                return response()->json([
                    'success' => true,
                    'message' => 'Arıza kaydı oluşturulabilir.'
                ]);
            }
        
        return response()->json([
            
            'success' => true,
            'message' => 'Arıza kaydı oluşturulabilir.'
        ]);
        
        
    }
    public function send_sms(Request $request)
    {
        if (
            $request->input('content') != null &&
            $request->input('category_id') != null
        ) {
            $content = $request->input('content');
            $category_id = $request->input('category_id');

            $messages = new Messages();

            $numbers = [];

            if ($category_id == 0) {
                $subscriptions = Subscription::where("status", 1)->get();
            } else {
                $category = Category::find($category_id);
                $subscriptions = Subscription::whereIn("service_id", $category->services->pluck('id'))->where("status", 1)->get();
            }

            if ($subscriptions->count() > 0) {
                foreach ($subscriptions as $subscription) {
                    $numbers[] = $subscription->customer->telephone;
                }

                $messages = $messages->multiMessage(
                    $content,
                    $subscriptions
                );
            } else {
                $messages = [];
            }

            $sms = new SMS();
            $result = $sms->submitMulti(
                "RUZGARNET",
                $messages
            );

            if ($result) {
                return response()->json([
                    'error' => false,
                    'message' => "SMS'ler başarılı bir şekilde gönderildi."
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => "SMS'ler gönderilirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz."
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'message' => "Lütfen geçerli değerler gönderiniz."
            ]);
        }
    }

    public function pay(Request $request)
    {
        $rules = [];
        $rules["credit_card_holder_name"] = [
            'required',
            'numeric'
        ];
        $rules["credit_card_number"] = [
            'required',
            'string',
            'max:255'
        ];
        $rules["month"] = [
            'required',
            'string'
        ];
        $rules["year"] = [
            'required',
            'string'
        ];
        $rules["security_code"] = [
            'required',
            'numeric',
            'between:100,999'
        ];
        $rules["payment_id"] = ['required'];

        if (
            $request->input('credit_card_holder_name') != null &&
            $request->input('credit_card_number') != null &&
            $request->input('month') != null &&
            $request->input('year') != null &&
            $request->input('security_code') != null &&
            $request->input('payment_id') != null &&
            $request->input('is_automatic') != null
        ) {
            $validated = [
                'credit_card_holder_name' => $request->input('credit_card_holder_name'),
                'credit_card_number' => $request->input('credit_card_number'),
                'month' => $request->input('month'),
                'year' => $request->input('year'),
                'security_code' => $request->input('security_code'),
                'payment_id' => $request->input('payment_id'),
                'is_automatic' => $request->input('is_automatic')
            ];

            $payment = Payment::find($validated["payment_id"]);

            $moka = new Moka();

            if ($payment->mokaPayment) {
                $payment_detail = $moka->get_payment_detail_by_other_trx($payment->mokaPayment->trx_code);

                if (
                    $payment_detail->Data->PaymentDetail->PaymentStatus == 2 &&
                    $payment_detail->Data->PaymentDetail->TrxStatus == 1
                ) {
                    $payment->receive([
                        'type' => 4
                    ]);

                    return response()->json([
                        'error' => true,
                        'message' => "Lütfen ödemenizi tekrar sorgulayınız."
                    ]);
                }
            }

            MokaPayment::where('payment_id', $payment->id)->delete();

            $card = [
                'full_name' => $validated['credit_card_holder_name'],
                'number' => $validated['credit_card_number'],
                'expire_month' => $validated['month'],
                'expire_year' => $validated['year'],
                'security_code' => $validated['security_code'],
                'amount' => $payment->price
            ];

            $hash = [
                'subscription_no' => $payment->subscription->subscription_no,
                'payment_created_at' => $payment->created_at
            ];

            $moka = new Moka();
            $response = $moka->pay(
                $card,
                "https://crm.ruzgarnet.site/payment/result/" . $payment->id,
                $hash
            );

            if ($response->Data != null) {
                MokaPayment::create([
                    'payment_id' => $payment->id,
                    'trx_code' => $moka->trx_code
                ]);

                MokaLog::create([
                    'payment_id' => $payment->id,
                    'ip' => $request->ip(),
                    'response' => ['init' => $response],
                    'trx_code' => $moka->trx_code
                ]);

                if (($validated["is_automatic"] == true) && (!$payment->subscription->isAuto())) {
                    $auto_data = [
                        'card' => [
                            'full_name' => $validated['credit_card_holder_name'],
                            'number' => $validated['credit_card_number'],
                            'expire_date' =>  $validated['month'] . '/' . $validated['year'],
                            'amount' => $payment->subscription->price
                        ]
                    ];



                    (new PaymentController)->define_auto_payment($payment, $auto_data);
                }else{


                    $subscription = $payment->subscription;

                    if ($subscription->isAuto() && $payment->type != 5 && !$subscription->isAutoPenalty()) {
                        $next_payment = $subscription->nextMonthPayment();
                        $new_price = $next_payment->price + 0;

                        $data = [
                            'payment_id' => $next_payment->id,
                            'staff_id' => null,
                            'old_price' => $next_payment->price,
                            'new_price' => $new_price,
                            'description' => trans('response.system.auto_payment_penalty', ['price' => 0])
                        ];

                        MokaAutoPaymentDisable::create([
                            'subscription_id' => $subscription->id,
                            'payment_id' => $next_payment->id,
                            'old_price' => $next_payment->price,
                            'new_price' => $new_price
                        ]);

                        $next_payment->edit_price($data);
                    }
                }

                return response()->json([
                    'error' => false,
                    'frame' => $response->Data->Url
                ]);
            }

            MokaLog::create([
                'payment_id' => $payment->id,
                'ip' => $request->ip(),
                'response' => $response,
                'trx_code' => $moka->trx_code
            ]);

            return response()->json([
                'error' => true,
                'message' => "Ödeme oluşturulurken hata oluştu. Lütfen kart bilgilerinizi kontrol ediniz."
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => "Lütfen kart bilgilerinizi kontrol edin."
            ]);
        }
    }

     public function get_payment_list(Request $request)
    {
        $validated = $request->validate([
            'identification_number' => 'string|numeric'
        ]);

        $identification_number = $request->input('identification_number');
        $customer = Customer::where("identification_number", $identification_number)->first();
        
        if (!$customer || $customer->subscriptions()->where("status", 1)->count() == 0) {
            $payment_list["error"] = true;
            $payment_list["title"] = 'Kullanıcı Bulunamadı';
            
            $payment_list["message"] = "Bu TC Kimlik numarasına ait aktif bir abonelik <u style='font-size: 16px; font-weight: bold; text-decoration: underline; text-decoration-color: black; text-decoration-thickness: 3px; '>bulunmamaktadır</u>.";

        } else {
            $customer = Customer::where('identification_number', $identification_number)->first();
            $moka = new Moka();
            foreach ($customer->subscriptions as $subscription) {
                if ($payment = $subscription->currentPayment()) {
                    if (!$payment->isPaid() && $payment->mokaPayment) {

                        $payment_detail = $moka->get_payment_detail_by_other_trx(
                            $payment->mokaPayment->trx_code
                        );

                        if (
                            $payment_detail->Data->PaymentDetail->PaymentStatus == 2 &&
                            $payment_detail->Data->PaymentDetail->TrxStatus == 1
                        ) {
                            $payment->receive([
                                'type' => 4
                            ]);

                            Telegram::send(
                                'RüzgarNETÖdeme',
                                trans('telegram.payment_received', [
                                    'id_no' => $payment->subscription->customer->identification_number,
                                    'full_name' => $payment->subscription->customer->full_name,
                                    'price' => $payment->price,
                                    'category' => $payment->subscription->service->category->name
                                ])
                            );
                        }
                    }
                }
            }

           $payments = Payment::select('payments.id', 'payments.subscription_id', 'payments.price', 'payments.date', 'customers.first_name', 'customers.last_name', 'customers.telephone')
    ->join('subscriptions', 'subscriptions.id', '=', 'payments.subscription_id')
    ->join('customers', 'customers.id', '=', 'subscriptions.customer_id')
    ->where('payments.date', '<=', date('Y-m-15'))
    ->where('customers.identification_number', $identification_number)
    ->whereNull('payments.paid_at')
    ->get();

            $payment_list = [];

            if (count($payments) > 0) {
                $payment_list["error"] = false;
            } else {
                $payment_list["error"] = true;
                
                //$payment_list["message"] = $identification_number;
                $payment_list["title"] = '
<div style="display: flex; width:100%; justify-content: center; align-items: center;">
  <img src="static/images/mone.png" alt="icon" style="width:60px; height:60px; ">
</div>';

                $payment_list["message"] = "<div style='margin-top: 5vh;'>Ödenmemiş faturanız <u style='font-size: 16px; font-weight: bold; text-decoration: underline; text-decoration-color: black; text-decoration-thickness: 3px;'>bulunmamaktadır</u>.</div>";

         

            }

            foreach ($payments as $payment) {
                $payment_list["invoices_list"][] = [
                    'full_name' => $payment->first_name . " " . $payment->last_name,
                    'invoice_id' => $payment->id,
                    'customer_id' => $payment->subscription_id,
                    'amount' => $payment->price,
                    'invoice_date' => $payment->date,
                    'phone' => $payment->telephone
                ];
            }
        }

        return response()->json($payment_list);
    }
}
