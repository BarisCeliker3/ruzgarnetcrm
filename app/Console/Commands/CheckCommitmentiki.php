<?php

namespace App\Console\Commands;

use App\Classes\Messages;
use App\Classes\Moka;
use App\Classes\SMS_Api;
use App\Classes\SMS;
use App\Classes\Telegram;
use App\Models\Message;
use App\Models\MokaSale;
use App\Models\SentMessage;
use App\Models\Subscription;
use App\Models\SubscriptionRenewal;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CheckCommitmentiki extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ruzgarnet:checkCommitmentiki';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check subscription\'s commitment date.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            
            $moka = new Moka();
            $sms = new SMS();
            $message_formatter = new Messages();

         //   $message_45 = Message::find(40)->message;
            $message_30 = Message::find(80)->message;
            $message_15 = Message::find(42)->message;
            $message_renewal = Message::find(43)->message;

            $messages = [];
//
//           $subscriptions = Subscription::where('status', 1)->whereRaw('DATEDIFF(`end_date`, NOW()) = 1')->get();
//            $date = Carbon::now()->addMonth(13)->format('Ymd');
//
//            foreach ($subscriptions as $subscription) {
//                $moka_sales = MokaSale::where('subscription_id',$subscription->id)->orderBy('created_at','desc')->first();
//                if($moka_sales!=null){
//                    $sonuc = $moka->update_sale_end_date($moka_sales->moka_sale_id,$date) ;
//                }
//                $new_price = $subscription->price;
//                if ($renewal = $subscription->renewal()) {
//                    $new_price = $renewal->new_price;
//                    $new_commitment = $renewal->new_commitment;
//                    $renewal->status = 1;
//                    $renewal->save();
//                } else {
//                    SubscriptionRenewal::create([
//                        'subscription_id' => $subscription->id,
//                        'new_commitment' => $subscription->commitment,
//                        'new_price' => $subscription->price,
//                        'status' => 1
//                    ]);
//                }
//                if($new_commitment != null){
//                    $subscription->end_date = Carbon::parse($subscription->end_date)->addMonth($new_commitment)->toDateString();
//                    $subscription->commitment = $new_commitment;
//                }else{
//                    $subscription->end_date = Carbon::parse($subscription->end_date)->addMonth($subscription->commitment)->toDateString();
//                }
//
//                $subscription->price = $new_price;
//                $subscription->save();
//
//                $messages[] = [
//                    $subscription->customer->telephone,
//                    $message_formatter->generate($message_renewal, [
//                        'ad_soyad' => $subscription->customer->full_name,
//                        'tarife' => $subscription->service->name,
//                        'taahhut' => $subscription->commitment,
//                        'tutar' => $new_price
//                    ])
//                ];
//
//                try {
//                    Telegram::send(
//                        'SözleşmesiSonaErecekler',
//                        trans('telegram.subscription_renewaled', [
//                            'full_name' => $subscription->customer->full_name,
//                            'id_no' => $subscription->customer->identification_number,
//                            'subscription' => $subscription->service->name,
//                            'month' => $subscription->commitment,
//                            'price' => $new_price
//                        ])
//                    );
//                }catch(Exception $e)
//                {
//                    Telegram::send('Test', 'CheckCommitment Command - ' . $e->getMessage());
//                }
//
//            }
//
            $subscriptions = Subscription::where('status', 1)->whereRaw('DATEDIFF(`end_date`, NOW()) = 45')->get();
            foreach ($subscriptions as $subscription) {
                // $messages[] = [
                //     $subscription->customer->telephone,
                //     $message_formatter->generate($message_45, [
                //         'ad_soyad' => $subscription->customer->full_name,
                //         'tarife' => $subscription->service->name
                //     ])
                // ];

                Telegram::send(
                  'SözleşmesiSonaErecekler',
                     trans('telegram.subscription_ending_day', [
                         'full_name' => $subscription->customer->full_name,
                         'id_no' => $subscription->customer->identification_number,
                         'subscription' => $subscription->service->name,
                         'price' => $subscription->price,
                         'day' => '45',
                         'staff' => $subscription->customer->staff->full_name
                     ])
                 );
            }

//            $subscriptions = Subscription::where('status', 1)->whereRaw('DATEDIFF(`end_date`, NOW()) = 30')->get();
//          foreach ($subscriptions as $subscription) {
//              $messages[] = [
//                  $subscription->customer->telephone,
//                  $message_formatter->generate($message_30, [
//                      'ad_soyad' => $subscription->customer->full_name,
//                      'tarife' => $subscription->service->name
//                  ])
//              ];
//              try {
//                  Telegram::send(
//                      'SözleşmesiSonaErecekler',
//                      trans('telegram.subscription_ending_day', [
//                          'full_name' => $subscription->customer->full_name,
//                         'id_no' => $subscription->customer->identification_number,
//                          'subscription' => $subscription->service->name,
//                          'price' => $subscription->price,
//                          'day' => '30',
//                          'staff' => $subscription->customer->staff->full_name
//                      ])
//                  );
//              }catch(Exception $e)
//              {
//                  Telegram::send('Test', 'CheckCommitmentiki Command - ' . $e->getMessage());
//              }
//          }
//
//            $subscriptions = Subscription::where('status', 1)->whereRaw('DATEDIFF(`end_date`, NOW()) = 15')->get();
//          foreach ($subscriptions as $subscription) {
//              $new_price = $subscription->price;
//              if ($renewal = $subscription->renewal()) {
//                  $new_price = $renewal->new_price;
//              }
//
//              $message_text = [
//                  $subscription->customer->telephone,
//                  $message_formatter->generate($message_15, [
//                      'ad_soyad' => $subscription->customer->full_name,
//                      'tarife' => $subscription->service->name,
//                      'tutar' => $new_price
//                    ])
//              ];
//
//              SentMessage::create([
//                  'phone' => $message_text[0],
//                  'message' => $message_text[1],
//                  'delivery_date' => date('Y-m-d 15:30')
//              ]);
//
//              try{
//                  Telegram::send(
//                      'SözleşmesiSonaErecekler',
//                      trans('telegram.subscription_ending_day', [
//                          'full_name' => $subscription->customer->full_name,
//                         'id_no' => $subscription->customer->identification_number,
//                          'subscription' => $subscription->service->name,
//                          'price' => $subscription->price,
//                         'day' => '15',
//                          'staff' => $subscription->customer->staff->full_name
//                      ])
//                  );
//              }catch(Exception $e)
//              {
//                  Telegram::send('Test', 'CheckCommitmentiki Command - ' . $e->getMessage());
//              }
//
//          }
//


            $sms->submitMulti(
                "RUZGARNET",
                $messages
            );
        } catch (Exception $e) {
            Telegram::send('Test', 'CheckCommitmentiki Command - ' . $e->getMessage());
            
        }
    }
}
