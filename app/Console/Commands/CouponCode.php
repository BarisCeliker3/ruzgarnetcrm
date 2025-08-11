<?php

namespace App\Console\Commands;

use App\Classes\Messages;
use App\Classes\Moka;
use App\Classes\SMS_Api;
use App\Classes\SMS;
use App\Classes\Telegram;
use App\Models\Message;
use App\Models\Code;
use App\Models\SentMessage;
use App\Models\Subscription;
use App\Models\SubscriptionRenewal;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CouponCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ruzgarnet:couponCode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Coupon Codes.';

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

            $sms = new SMS();
            $message_formatter = new Messages();
            $messages = [];

            $subscriptions = Subscription::where('status', 1)->whereRaw('DATEDIFF(`end_date`, NOW()) = 30')->get();


            $code_message = DB::table('code_message')->first();
            $codes = Code::where('type',$code_message->type)->where('status',1)->get();
            if($subscriptions->count()>0){
                $i = 0;
                $codes = Code::where('type',$code_message->type)->where('status',1)->get();
                if($codes->count()<10){
                    Telegram::send('KalanKod', 'Kod 10 dan az kalmıstır.');
                }
                if($codes->count()>0){
                    foreach ($subscriptions as $subscription) {
                        if($i < ($codes->count())){
                            $messages[] = [
                                $subscription->customer->telephone,
                                $message_formatter->generate($code_message->message, [
                                    'ad_soyad' => $subscription->customer->full_name,
                                    'code' => $codes[$i]->code
                                ])
                            ];
                            DB::table('codes')->where('id',$codes[$i]->id)->update(['status' => 2 ,'subscription_name' => $subscription->customer->full_name ]);
                        }else{
                            // $messages[] = [
                            //     $subscription->customer->telephone,
                            //     $message_formatter->generate('Değerli Abonemiz {ad_soyad}; Sizlerle beraber büyüyoruz. Sizler için çalışıyoruz. Bizden size 2 ay Bein Connect Eğlence paketi hediye. En fazla 3 gün içinde bizimle irtibata geçmeniz gerekmektedir. İyi eğlenceler. RüzgarNET 02162050606 ', [
                            //         'ad_soyad' => $subscription->customer->full_name

                            //     ])
                            // ];
                        }
                        $i++;
                    }
                }
            }

            $sms->submitMulti(
                "RUZGARNET",
                $messages
            );



        } catch (Exception $e) {
            Telegram::send('Test', 'Coupon Code Command - ' . $e->getMessage());
        }
    }
}
