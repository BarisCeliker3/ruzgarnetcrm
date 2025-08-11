<?php

namespace App\Jobs;

use App\Models\MokaAutoPayment;
use App\Models\MokaRefund;
use App\Services\Moka;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Telegram;

class ProcessPaymentAutoResult implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue, SerializesModels;

    protected $request;
    protected $paymentDetails;

    public function __construct($request, $paymentDetails)
    {
        $this->request = $request;
        $this->paymentDetails = $paymentDetails;
    }

    public function handle()
    {
        try {
            $moka = new Moka();
            $odemeSonuc = $moka->get_payment_plan_report();  // Ödeme planlarını al
            $paymentPlans = $odemeSonuc->Data->PaymentPlanList;  // Ödeme planlarını döngüye al

            // İşlem detayları ve ödeme planı üzerinde işlevi burada çalıştırıyoruz
            foreach ($paymentPlans as $paymentPlan) {
                $DealerPaymentPlanId = $paymentPlan->DealerPaymentPlanId;
                $planStatus = $paymentPlan->PlanStatus;

                if ($planStatus == 1) {
                    $plan_id = (int) $paymentPlan->DealerPaymentPlanId;
                    $plan = MokaAutoPayment::where("moka_plan_id", $plan_id)->first();

                    if ($plan) {
                        $payment_detail = $moka->get_payment_detail($paymentPlan->DealerPaymentId);

                        // Refund işlemleri ve ödeme durumları kontrol ediliyor
                        if ($plan->payment->status == 2 && $plan->payment->type != 5 && !$plan->isRefund()) {
                            if (isset($payment_detail->Data->PaymentDetail->OtherTrxCode) && !empty($payment_detail->Data->PaymentDetail->OtherTrxCode)) {
                                $refundType = 1;
                                $result = $moka->do_void($payment_detail->Data->PaymentDetail->OtherTrxCode);

                                if ($result->Data == null) {
                                    $refundType = 2;
                                    $result = $moka->refund($payment_detail->Data->PaymentDetail->OtherTrxCode);
                                }

                                $success = false;
                                if ($result->Data != null && isset($result->Data->IsSuccessful) && (bool) $result->Data->IsSuccessful) {
                                    $success = true;
                                }

                                $plan->status = 5;
                                $plan->save();

                                MokaRefund::updateOrCreate(
                                    [
                                        'auto_payment_id' => $plan->id
                                    ],
                                    [
                                        'payment_id' => $plan->payment->id,
                                        'auto_payment_id' => $plan->id,
                                        'price' => $plan->payment->price,
                                        'status' => $success,
                                        'type' => $refundType
                                    ]
                                );
                            }
                        } else {
                            if ($payment_detail->Data->PaymentDetail->PaymentStatus == 2 && $payment_detail->Data->PaymentDetail->TrxStatus == 1) {
                                $plan->status = 1;
                                $plan->save();

                                $plan->payment->receive([
                                    'type' => 5
                                ]);
                            } else {
                                $plan->status = 4;
                                $plan->save();
                            }
                        }
                    }
                }
            }

            Log::info("Payment Auto Result Job completed successfully.");
        } catch (Exception $e) {
            Telegram::send("Error", "ProcessPaymentAutoResult Job failed: " . $e->getMessage());
            Log::error("ProcessPaymentAutoResult Job failed: " . $e->getMessage());
        }
    }
}

