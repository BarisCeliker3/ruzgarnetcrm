<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\MokaAutoPayment;
use App\Models\Payment;
use App\Models\Subscription;
use App\Classes\Moka;
use App\Classes\Mutator;
use App\Classes\Telegram;

class CheckMokaPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ruzgarnet:mokapayments';

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
     * @return int
     */
  public function handle()
{
    $now = Carbon::now();

    // 1. Ödeme ID'lerini çek
    $paymentIds = DB::table('payments')
        ->join('subscriptions', 'payments.subscription_id', '=', 'subscriptions.id')
        ->join('moka_sales', function ($join) {
            $join->on('subscriptions.id', '=', 'moka_sales.subscription_id')
                 ->whereNull('moka_sales.disabled_at');
        })
        ->where('payments.status', 1)
        ->whereMonth('payments.date', $now->month)
        ->whereYear('payments.date', $now->year)
        ->distinct()
        ->pluck('payments.id')
        ->toArray();

    if (empty($paymentIds)) {
        $this->info('İşlenecek ödeme bulunamadı.');
        return 0;
    }

    // 2. İlgili satışları çek
    $relatedSales = DB::table('moka_sales')
        ->join('moka_auto_payments', 'moka_sales.id', '=', 'moka_auto_payments.sale_id')
        ->join('subscriptions', 'moka_sales.subscription_id', '=', 'subscriptions.id')
        ->join('customers', 'subscriptions.customer_id', '=', 'customers.id')
        ->whereIn('moka_auto_payments.payment_id', $paymentIds)
        ->select(
            'moka_sales.id as sale_id',
            'moka_auto_payments.moka_plan_id',
            'moka_auto_payments.payment_id as data_payment_id',
            DB::raw("CONCAT(customers.first_name, ' ', customers.last_name) as customer_name"),
            'customers.identification_number as customer_tc'
        )
        ->get();

    $mokas = new Moka();
    $successPayments = [];

    // 3. Satışları dolaş ve başarılı ödeme detaylarını al
    foreach ($relatedSales as $sale) {
        $paymentPlan = $mokas->get_payment_plan($sale->moka_plan_id);
        $paymentId = $paymentPlan->Data->DealerPaymentId ?? null;

        if ($paymentId === null) {
            continue;
        }

        $response = $mokas->get_payment_detail($paymentId);
        $paymentDetail = $response->Data->PaymentDetail ?? null;

        if ($paymentDetail && $paymentDetail->PaymentStatus == 2 && $paymentDetail->TrxStatus == 1) {
            $successPayments[] = [
                'sale_id' => $sale->sale_id,
                'payment_id' => $paymentId,
                'data_payment_id' => $sale->data_payment_id,
                'amount' => $paymentDetail->Amount ?? null,
                'card_holder' => $paymentDetail->CardHolderFullName ?? null,
                'date' => $paymentDetail->PaymentDate ?? null,
            ];
        }
    }

    if (empty($successPayments)) {
        $this->info('Başarılı ödeme bulunamadı.');
        return 0;
    }

    // 4. Başarılı ödemelerin detaylarını çek
    $paymentDataIds = collect($successPayments)->pluck('data_payment_id')->toArray();
    $paymentsWithSubs = DB::table('payments')
        ->join('subscriptions', 'payments.subscription_id', '=', 'subscriptions.id')
        ->whereIn('payments.id', $paymentDataIds)
        ->where('payments.status', 1)
        ->whereNull('payments.paid_at')
        ->select('payments.id as payment_id', 'payments.subscription_id', 'subscriptions.price')
        ->get()
        ->keyBy('payment_id');

    $updatedPayments = [];
    $newPayments = [];

    foreach ($successPayments as $payment) {
        $paymentRecord = $paymentsWithSubs->get($payment['data_payment_id']);
        if (!$paymentRecord) {
            continue;
        }

        // Ödeme güncelle
        $updated = DB::table('payments')
            ->where('id', $payment['data_payment_id'])
            ->where('status', 1)
            ->whereNull('paid_at')
            ->update([
                'paid_at' => $payment['date'],
                'status' => 2,
                'type' => 5,
                'price' => $payment['amount'],
                'updated_at' => now(),
            ]);

        if ($updated) {
            $updatedPayments[] = [
                'payment_id' => $payment['data_payment_id'],
                'paid_at' => $payment['date'],
                'status' => 2,
                'type' => 5,
            ];
        }

        // Yeni ödeme oluşturma
        $subscriptionId = $paymentRecord->subscription_id;
        $price = $paymentRecord->price;

        if ($price !== null) {
            $nextMonthDate = Carbon::now()->addMonth()->startOfMonth()->addDays(14)->toDateString();

            $exists = DB::table('payments')
                ->where('subscription_id', $subscriptionId)
                ->where('date', $nextMonthDate)
                ->exists();

            if (!$exists) {
                $newPaymentData = [
                    'subscription_id' => $subscriptionId,
                    'price' => $price,
                    'date' => $nextMonthDate,
                    'status' => 1,
                    'type' => null,
                    'paid_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                try {
                    DB::table('payments')->insert($newPaymentData);
                    $newPayments[] = $newPaymentData;
                } catch (\Exception $e) {
                    $this->error('Yeni ödeme eklenemedi: ' . $e->getMessage());
                }
            } else {
                $this->info("{$subscriptionId} aboneliği için {$nextMonthDate} tarihinde zaten ödeme kaydı var.");
            }
        }
    }

    $this->info('İşlem tamamlandı.');
    return 0;
}


}
