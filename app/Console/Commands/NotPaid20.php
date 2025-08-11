<?php

namespace App\Console\Commands;

use App\Classes\Messages;
use App\Classes\SMS_Api;
use App\Classes\SMS;
use App\Models\Message;
use App\Classes\Telegram;
use App\Models\Payment;
use Exception;
use Illuminate\Console\Command;

class NotPaid20 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ruzgarnet:NotPaid20';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send warning messages for not paided payments.';

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
     */
    public function handle()
    {
        try {
            $sms = new SMS();

            $message = Message::find(2);

            $messages = [];
            $message_formatter = new Messages();

            $payments = Payment::where('status', '<>', 2)->where('date', date('Y-m-15'))->get();
            foreach ($payments as $payment) {
                $messages[] = [
                    $payment->subscription->customer->telephone,
                    $message_formatter->generate(
                        $message->message,
                        [
                            'ad_soyad' => $payment->subscription->customer->full_name,
                            'ay' => date('m'),
                            'yil' => date('Y')
                        ]
                    )
                ];
            }

            $sms->submitMulti(
                "RUZGARNET",
                $messages
            );
        } catch (Exception $e) {
            Telegram::send('Test', 'SendNotPaid20 Command - ' . $e->getMessage());
        }

        $this->info('Added payment penalty warning messages.');
    }
}
