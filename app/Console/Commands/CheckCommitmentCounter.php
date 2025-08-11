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
use App\Models\SubscriberCounter;
use App\Models\SubscriptionRenewal;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CheckCommitmentCounter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ruzgarnet:checkCommitmentCounter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check subscribercounter\'s commitment date.';

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

            $message_1 = Message::find(68)->message;
            $message_5 = Message::find(71)->message;
            $message_15 = Message::find(70)->message;
            $message_30 = Message::find(69)->message;
            
            

            $messages = [];
// 30 GÜN
            $subscriptions = SubscriberCounter::where('status', 2)->whereRaw('DATEDIFF(`bitistarihi`, NOW()) = 30')->get();
          foreach ($subscriptions as $subscription) {
                $messages[] = [
                  $subscription->telephone,
                  $message_formatter->generate($message_30, [
                      'ad_soyad' => $subscription->name_surname
                  ])
                  
                ];
             
          }
// 15 GÜN
            $subscriptions = SubscriberCounter::where('status',2)->whereRaw('DATEDIFF(`bitistarihi`, NOW()) = 15')->get();
            foreach ($subscriptions as $subscription) {
                 $messages[] = [
                     $subscription->telephone,
                     $message_formatter->generate($message_15, [
                         'ad_soyad' => $subscription->name_surname
                     ])
                 ];

                Telegram::send(
                      'TaahhutSayar',
                      trans('telegram.subscribercounter', [
                          'and_date' => $subscription->bitistarihi,
                          'customer_name' => $subscription->name_surname,
                          'day' => '15',
                          'companys' => $subscription->company,
                          'staff' => $subscription->staff_id
                          
                      ])
                  );
            }
    
// 5 GÜN
            $subscriptions = SubscriberCounter::where('status',2)->whereRaw('DATEDIFF(`bitistarihi`, NOW()) = 5')->get();
            foreach ($subscriptions as $subscription) {
                 $messages[] = [
                     $subscription->telephone,
                     $message_formatter->generate($message_5, [
                         'ad_soyad' => $subscription->name_surname
                     ])
                 ];

                Telegram::send(
                      'TaahhutSayar',
                      trans('telegram.subscribercounter', [
                          'and_date' => $subscription->bitistarihi,
                          'customer_name' => $subscription->name_surname,
                          'day' => '5',
                          'companys' => $subscription->company,
                          'staff' => $subscription->staff_id
                          
                      ])
                  );
            }

// 1 GÜN
            $subscriptions = SubscriberCounter::where('status',2)->whereRaw('DATEDIFF(`created_at`, NOW()) = -1')->get();
            foreach ($subscriptions as $subscription) {
                 $messages[] = [
                     $subscription->telephone,
                     $message_formatter->generate($message_1, [
                         'ad_soyad' => $subscription->name_surname
                     ])
                 ];

//                Telegram::send(
//                      'TaahhutSayar',
//                      trans('telegram.subscribercounter', [
//                          'and_date' => $subscription->bitistarihi,
//                         'customer_name' => $subscription->name_surname,
//                         'day' => '30',
//                          'companys' => $subscription->company,
//                          'staff' => $subscription->staff_id
//                          
//                      ])
//                 );
            }

         



            $sms->submitMulti(
                "RUZGARNET",
                $messages
            );
        } catch (Exception $e) {
            Telegram::send('Test', 'CheckCommitmentiki Command - ' . $e->getMessage());
        }
    }
}
