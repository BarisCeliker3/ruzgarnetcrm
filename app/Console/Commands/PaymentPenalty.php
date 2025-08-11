<?php

namespace App\Console\Commands;
use Exception;
use App\Classes\Messages;
use App\Classes\SMS_Api;
use App\Classes\SMS;
use App\Classes\Telegram;
use App\Models\Message;
use App\Models\Payment;
use App\Models\PaymentPriceEdit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PaymentPenalty extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ruzgarnet:paymentPenalty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add penalty prices to unpaided payments.';

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

        $messages = [];
        $message_formatter = new Messages();
        $sms = new SMS();
        $message = Message::find(7);
        $penalty = 300;
        $payments = Payment::where("status", "!=", 2)->where('date', date('Y-m-15'))->get();
    try{
        foreach ($payments as $payment) {
            $new_price = $payment->price + 300;

            PaymentPriceEdit::create([
                'payment_id' => $payment->id,
                'staff_id' => null,
                'old_price' => $payment->price,
                'new_price' => $new_price,
                'description' => trans('response.system.penalty', ['price' => 300])
            ]);

            DB::table('payment_penalties')->insert([
                'payment_id' => $payment->id,
                'penalty_price' => $penalty,
                'old_price' => $payment->price,
                'new_price' => $new_price
            ]);

            $payment->price = $new_price;
            $payment->save();

            $messages[] = [
                $payment->subscription->customer->telephone,
                $message_formatter->generate(
                    $message->message,
                    [
                        'ay' => date('m'),
                        'yil' => date('Y'),
                        'ad_soyad' => $payment->subscription->customer->full_name,
                        'tarih' => date('d/m/Y', strtotime($payment->date))
                    ]
                )
            ];
        }
        Telegram::send(
            "Test",
            "Payment Controller - 150 : TAMAm \n"
        );
    }catch (Exception $e) {
            Telegram::send(
                "Test",
                "Payment Controller - 150 : \n" . $e->getMessage()
            );
        }


        $sms->submitMulti(
            "RUZGARNET",
            $messages
        );

        $this->info('Added penalty prices.');
    }
}
