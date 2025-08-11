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
use Carbon\Carbon;

class PortPenalty extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ruzgarnet:portPenalty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add port penalty prices to unpaided payments.';

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
        $date = Carbon::parse(date('Y-m-15'));



        $penalty = 4500.00;
        $payments = Payment::where("status", "!=", 2)->where('date', $date)->get();
    try{
        foreach ($payments as $payment) {
            $new_price = $payment->price + 4500.00;

            PaymentPriceEdit::create([
                'payment_id' => $payment->id,
                'staff_id' => null,
                'old_price' => $payment->price,
                'new_price' => $new_price,
                'description' => trans('response.system.penalty', ['price' => 4500.00])
            ]);

            DB::table('payment_penalties')->insert([
                'payment_id' => $payment->id,
                'penalty_price' => $penalty,
                'old_price' => $payment->price,
                'new_price' => $new_price
            ]);

            $payment->price = $new_price;
            $payment->save();


        }
        Telegram::send(
            "Test",
            "Payment Controller - PORT : TAMAM \n"
        );
    }catch (Exception $e) {
            Telegram::send(
                "Test",
                "Payment Controller - PORT : \n" . $e->getMessage()
            );
        }
        $this->info('Added port penalty prices.');
    }
}
