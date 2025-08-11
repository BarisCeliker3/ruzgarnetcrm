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

class NewSubscriberSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ruzgarnet:newSubscriberSms';

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


            $newsubscriber = Message::find(64)->message;

            $messages = [];

            $subscriptions = Subscription::where('status', 1)->whereRaw('DATEDIFF(`approved_at`, NOW()) = -1')->get();
            foreach ($subscriptions as $subscription) {
                 
                 
                 
                 $message_text = [
                  $subscription->customer->telephone,
                  $message_formatter->generate($newsubscriber, [
                        'ad_soyad' => $subscription->customer->full_name,
                        'pilatin' => $subscription->customer->staff->first_name,
                        'platin_telefon' => $subscription->customer->staff->fixed_line
                    ])
              ];

              SentMessage::create([
                  'phone' => $message_text[0],
                  'message' => $message_text[1],
                  'delivery_date' => date('Y-m-d 14:19')
              ]);

                Telegram::send(
                    'DondurulupSuresiUzayanAboneler',
                     trans('telegram.new_subscribers_sms', [
                         'full_name' => $subscription->customer->full_name,
                         'destek' => $subscription->customer->staff->fixed_line,
                         'staff' => $subscription->customer->staff->first_name
                     ])
                 );
            }
            $sms->submitMulti(
                "RUZGARNET",
                $messages
            );
        } catch (Exception $e) {
            Telegram::send('Test', 'NewSubscriberSms Command - ' . $e->getMessage());
        }
    }
}
