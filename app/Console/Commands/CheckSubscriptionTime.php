<?php

namespace App\Console\Commands;
use App\Classes\Messages;
use App\Classes\SMS_Api;
use App\Classes\SMS;
use App\Classes\Telegram;
use App\Models\Message;
use App\Models\Subscription;
use App\Models\SubscriptionRenewal;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;



class CheckSubscriptionTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ruzgarnet:checkSubscriptionTime';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return void
     * TAAHHÜTSÜZ ABONELER İÇİN HER 3 AYDA BİR 70 TL EKLEME YAPILACAK
     * %3 => 3 AY ARAYLA ANLAMINA GELİYOR 
     */
    public function handle()
    {
        try{
            $sms = new SMS();
            $messages = [];
            $diff_in_months = [];
            $now = Carbon::now();
            $subscriptions = Subscription::whereNull('end_date')->get();
            foreach($subscriptions as $subscription){
                if(Carbon::parse($subscription->start_date)->diffInMonths($now)!=0){
                    if(Carbon::parse($subscription->start_date)->diffInMonths($now)%3 == 0){
                        $diff_in_months [] = $subscription->id;

                        $subscription->price = $subscription->price + 70.00;
                        $subscription->save();

                        $messages[] = [
                            $subscription->customer->telephone,
                            'Değerli abonemiz yeni tarife tutarınız '.$subscription->price.'TL olmuştur. Bilgilerinize RUZGARNET'
                        ];

                    }
                }
            }

            $sms->submitMulti(
                "RUZGARNET",
                $messages
            );
            Telegram::send('Test', 'CheckSubscriptionTime Command - Başarılı');
        }catch (Exception $e) {
            Telegram::send('Test', 'CheckSubscriptionTime Command - ' . $e->getMessage());
        }
        $this->info('Added payment penalty warning messages.');
    }
}
