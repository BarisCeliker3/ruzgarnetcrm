<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriberCounter;
use App\Models\Payment;
use App\Classes\Telegram;
use App\Classes\Moka;
use App\Models\MokaAutoPayment;
use App\Models\MokaSale;
use App\Classes\Messages;
use App\Classes\SMS;
use App\Models\SentMessage;
use App\Models\Message;
use App\Models\CommitmentNote;
use App\Models\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use SoapClient;
use App\Models\Subscription;
use Carbon\Carbon;
use DateTime;

class CommitmentNoteControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SubscriberCounter $subscribercounter)
    {




        // $moka = new Moka();
        // $count = 0;
        // $moka_sales = MokaSale::whereNull("disabled_at")->get();
        // foreach ($moka_sales as $sale) {
        //     if($sale->subscription->status == 1)
        //     {

        //         $payment = $sale->subscription->lastUnpaidPayment();
        //         if ($payment) {
        //             if (!$payment->isPaid()) {
        //                 $count++;
        //             }
        //         }


        //     }

        // }
        // dd($count);


        // $moka = new Moka;
        // $sonuc = $moka->get_payment_plan_report();
        // $plan = [];
        // $iptal = [];
        // if($sonuc->Data!= null){
        //     foreach($sonuc->Data->PaymentPlanList as $planlist){
        //         if($planlist->PlanStatus == 0)
        //         {
        //             $plan [] = $planlist->DealerPaymentPlanId;
        //         }

        //     }
        //     //$plan = [59542,59555,59640,59653,59735,59768,59849,59961,59985,60012,60053,60054,60123,60135,60142,60149,61043];
        //     //dd($plan);
        //     foreach($plan as $plans){
        //         $moka_auto_payments [] = DB::table('moka_auto_payments')
        //         ->join('payments', 'moka_auto_payments.payment_id', '=', 'payments.id')
        //         ->where('moka_plan_id',$plans)

        //         ->select('payments.*','moka_auto_payments.moka_plan_id')
        //         ->first();
        //     }
        //     //dd($moka_auto_payments);
        //     //  $moka_auto_payments = DB::table('moka_auto_payments')
        //     //  ->join('payments', 'moka_auto_payments.payment_id', '=', 'payments.id')
        //     //  ->whereIn('moka_plan_id',$plan)
        //     //  ->whereNotNull('paid_at')
        //     //  ->select('payments.*','moka_auto_payments.moka_plan_id')
        //     //  ->get();
        //     //dd($moka_auto_payments);
        //     foreach($moka_auto_payments as $payments){
        //         if($payments->status == 2){
        //         $iptal [] = $moka->delete_payment_plan($payments->moka_plan_id);
        //         }
        //     }
        //   dd($iptal);
        // }


        // $moka = new Moka;
        // $sonuc = $moka->get_payment_plan_report();

        // $plan = [];
        // $idler = [];
        // if($sonuc->Data!= null){
        //     foreach($sonuc->Data->PaymentPlanList as $planlist){
        //         if($planlist->PlanStatus == 1 )
        //         {
        //             $plan [] = $planlist->DealerPaymentPlanId;
        //         }
        //     }

        //     dd($plan);
        //     $moka_auto_payments = DB::table('moka_auto_payments')
        //     ->join('payments', 'moka_auto_payments.payment_id', '=', 'payments.id')
        //     ->whereIn('moka_plan_id',$plan)
        //     ->select('payments.*')
        //     ->get();

        //     //dd($moka_auto_payments);
        //     foreach($moka_auto_payments as $payments){
        //         if($payments->status == 1){
        //             $idler [] = $payments->subscription_id;
        //                $payment = Payment::find($payments->id);
        //                $payment->receive([
        //                'type' => 5
        //               ]);
        //         }
        //     }

        //     dd($idler);
        // }

       return view('admin.commitment-notes.list',[
            'subscribercounter' => $subscribercounter,
            'commitmentNotes' => CommitmentNote::where('customer_id',$subscribercounter->id)->
       
            orderby('id','desc')
            ->get()
        ]);

    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
   
    public function sms_list(Customer $customer)
    {
        return view('admin.customer-sms.list',[
            'customer' => $customer,
            'customerSms' => DB::table('customer_sms')->where('customer_id',$customer->id)
            ->orderby('id','desc')
            ->get()
        ]);

    }
  */
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(SubscriberCounter $subscribercounter)
    {
        return view('admin.commitment-notes.add', [
            'subscribercounter' => $subscribercounter
        ]);
    }


       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriberCounter $subscribercounter , Request $request)
    {
        $validated = $request->validate($this->rules());
        $validated["staff_id"] = $request->user()->staff_id;
        $validated["customer_id"] = $subscribercounter->id;

        if ($message = CommitmentNote::create($validated)) {

            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.subscribercounter.notes',$subscribercounter->id)
            ]);
        }

        return response()->json([
            'error' => true,
            'toastr' => [
                'type' => 'error',
                'title' => trans('response.title.error'),
                'message' => trans('response.insert.error')
            ]
        ]);
    }

    private function rules()
    {
        return [
            'note' => 'required|string'
        ];
    }

}
