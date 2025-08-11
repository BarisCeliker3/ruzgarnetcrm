<?php

namespace App\Console\Commands;

use App\Classes\Moka;
use App\Classes\Telegram;
use App\Models\MokaAutoPayment;
use App\Models\MokaSale;
use Exception;
use Illuminate\Console\Command;
use Storage;


class MokaTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ruzgarnet:mokaTest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create moka  test plans.';

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
            $moka = new Moka();

            $moka_sales = MokaSale::where("id", 13465)->get();
            foreach ($moka_sales as $sale) {
                if($sale->subscription->status == 1)
                {
                    if($sale->subscription->lastUnpaidPayment()!= null){
                        $payment = $sale->subscription->lastUnpaidPayment();
                        if ($payment) {
                            //if (!$payment->isPaid() && !$payment->mokaAutoPayment()->count()) {
                            if (!$payment->isPaid()) {
                                $result = $moka->add_payment_plan(
                                    $sale->moka_sale_id,
                                    //date('Ym15'),
                                    date('Ym05'),
                                    $payment->price
                                );

                                if (isset($result->Data->DealerPaymentPlanId)) {
                                    MokaAutoPayment::create([
                                        'sale_id' => $sale->id,
                                        'payment_id' => $payment->id,
                                        'moka_plan_id' => $result->Data->DealerPaymentPlanId
                                    ]);
                                }else{

                                }

                            }
                        }
                    }
                }
                //$payment = $sale->subscription->currentPayment();
            Storage::disk("local")->append("createMokaPlan.txt", "Calistim");
            }
            Telegram::send(
                'Test',
                'Command - Create Auto Payment : başarılı '
            );
            
            
        } catch (Exception $e) {
            Telegram::send(
                'Test',
                'Command - Create Moka Plan : ' . $e->getMessage()
            );
            Storage::disk('local')->append("createMokaPlanExc.txt", $e->getMessage());
        }

        $this->info('Added moka plans.');
    }
}
