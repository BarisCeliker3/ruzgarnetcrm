<?php


namespace App\Console\Commands;
use App\Models\ServiceUpdater;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Service;
use App\Models\Subscription;
use App\Models\Customer;
use App\Models\SubscriptionRenewal;
use Illuminate\Console\Command;
use App\Models\TestedUser;

class ScheduleAutoSave extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ruzgarnet:autoSave';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically saves data at regular intervals';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $date = now();
        $staffId = 88;
        $ServiceUpdater = ServiceUpdater::all();
        
        // 2. Abonelik yenileme işlemleri
        $subscriptions = Subscription::whereBetween('end_date', [
            $date->copy()->addDays(40)->format('Y-m-d'), // 40 gün sonrası
            $date->copy()->addDays(45)->format('Y-m-d')  // 45 gün sonrası
        ])
        ->where('status', 1)
        ->with('service')
        ->get();
    
        $updatedSubscriptions = [];
        $testedUserCount = 0;
        
        foreach ($subscriptions as $subscription) {
            // First, check if the user has already been tested and if their status is 0
            $testedUser = TestedUser::where('subscription_id', $subscription->id)
                ->where('customer_id', $subscription->customer_id)
                ->first();
            if (!$testedUser || $testedUser->status == 0) {
                // 📌 Son 5 gün içinde yenileme varsa atla
                $recentRenewal = SubscriptionRenewal::where('subscription_id', $subscription->id)
                    ->where('created_at', '>=', $date->copy()->subDays(5)->format('Y-m-d'))
                    ->first();
    
                if ($recentRenewal) {
                    continue; // Skip if renewal happened in the last 5 days
                }
    
                // SQL sorgusuna uyan abonelikleri kontrol et
                    // Eğer sonuç varsa, count ile kaç tane abonelik olduğunu öğrenebilirsiniz
                   // $price = round($subscription->price);
                   
                    $price = intval($subscription->price);
                // `price` değerini tam sayıya çevir
                if ($price >= 800 && $subscription->service && $subscription->service->category_id == 2) {

                    $serviceUpdateZero = $ServiceUpdater->where('service_id', 0)->first();
    
                    if ($serviceUpdateZero) {
                        // ServiceUpdater'dan yeni fiyatı al
                        $newPrice = $serviceUpdateZero->new_price;
    
                        // Yüzdelik artış yapılacak
                        $priceToUse = $subscription->price + ($subscription->price * ($newPrice / 100));
    
                        // Fiyatı güncelle
                        $updatedSubscriptions[] = $subscription;
                        $subscription->price = $priceToUse;
                        $subscription->save();
    
                        SubscriptionRenewal::renewal($subscription, $staffId, $serviceUpdateZero->new_commitment, $priceToUse);
    
                        TestedUser::updateOrCreate(
                            [
                                'subscription_id' => $subscription->id,
                                'customer_id' => $subscription->customer_id,
                            ],
                            [
                                'status' => 1
                            ]
                        );
    
                        $testedUserCount++;
                    }
                } else {

                    // SQL koşuluna uymayan aboneliklerde service_id kontrolü yapılır
                    foreach ($ServiceUpdater as $ServiceUpdate) {
                        if ($subscription->service_id == $ServiceUpdate->service_id) {
                            // Eğer category_id 6 ise, eski fiyatın üzerine 300 TL ekle
                            if ($subscription->service->category_id == 6) {
                                // Son ödeme miktarını al
                                echo $subscription->service->category_id;
                                $lastPayment = $subscription->payments()->latest()->first();  // Payment ilişkisi kullanılıyor
                                if ($lastPayment) {
                                    $priceToUse = $lastPayment->price + $ServiceUpdate->new_price;  // Son ödeme miktarına 300 TL ekle
                                } else {
                                    $priceToUse = $ServiceUpdate->new_price;  // Eğer son ödeme yoksa, yeni fiyatı kullan
                                }
                            } else {
                                $priceToUse = $ServiceUpdate->new_price;  // Aksi takdirde, yeni fiyatı kullan
                            }
    
    
                            // Güncellenen aboneliği kaydet
                            $updatedSubscriptions[] = $subscription;
                            $subscription->price = $priceToUse;
                            $subscription->save();
    
                            // Yenileme işlemini gerçekleştir
                            SubscriptionRenewal::renewal($subscription, $staffId, $ServiceUpdate->new_commitment, $priceToUse);
    
                            // Kullanıcıyı güncelle
                            TestedUser::updateOrCreate(
                                [
                                    'subscription_id' => $subscription->id,
                                    'customer_id' => $subscription->customer_id,
                                ],
                                [
                                    'status' => 1
                                ]
                            );
    
                            $testedUserCount++;
                        }
                    }
                }
            }
        }
    
        // Output the number of updated subscriptions
        echo "Number of updated subscriptions: " . $testedUserCount;
    }
    
    
    public static function renewal(Subscription $subscription, int $staff_id, int $new_commitment, float $price)

    {

        self::where('status', 0)->where('subscription_id', $subscription->id)->update(['status' => 2]);


   
        return self::create([

            'subscription_id' => $subscription->id,

            'staff_id' => $staff_id,

            'new_commitment' => $new_commitment,

            'new_price' => $price,

            'status' => 0

        ]);

    }

}
