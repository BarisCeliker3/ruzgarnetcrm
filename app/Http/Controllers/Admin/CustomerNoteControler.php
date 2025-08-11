<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use App\Classes\Telegram;
use App\Classes\Moka;
use App\Models\MokaAutoPayment;
use App\Models\MokaSale;
use App\Classes\Messages;
use App\Classes\SMS;
use App\Models\SentMessage;
use App\Models\Message;
use App\Models\CustomerNote;
use App\Models\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use SoapClient;
use App\Models\Subscription;
use Carbon\Carbon;
use DateTime;

class CustomerNoteControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {




/* HER AYIN 15'İNDE SAAT 11:00 DA ÇALIŞTIRILACAK */
/*
         $moka = new Moka();
         $count = 0;
         $moka_sales = MokaSale::whereNull("disabled_at")->get();
         foreach ($moka_sales as $sale) {
             if($sale->subscription->status == 1)
             {

                 $payment = $sale->subscription->lastUnpaidPayment();
                 if ($payment) {
                     if (!$payment->isPaid()) {
                         $count++;
                     }
                 }


             }

         }
         dd($count);


         $moka = new Moka;
         $sonuc = $moka->get_payment_plan_report();
         $plan = [];
         $iptal = [];
         if($sonuc->Data!= null){
             foreach($sonuc->Data->PaymentPlanList as $planlist){
                 if($planlist->PlanStatus == 0)
                 {
                     $plan [] = $planlist->DealerPaymentPlanId;
                 }

             }
             //$plan = [59542,59555,59640,59653,59735,59768,59849,59961,59985,60012,60053,60054,60123,60135,60142,60149,61043];
             //dd($plan);
             foreach($plan as $plans){
                 $moka_auto_payments [] = DB::table('moka_auto_payments')
                 ->join('payments', 'moka_auto_payments.payment_id', '=', 'payments.id')
                 ->where('moka_plan_id',$plans)

                 ->select('payments.*','moka_auto_payments.moka_plan_id')
                 ->first();
             }
             //dd($moka_auto_payments);
             //  $moka_auto_payments = DB::table('moka_auto_payments')
             //  ->join('payments', 'moka_auto_payments.payment_id', '=', 'payments.id')
             //  ->whereIn('moka_plan_id',$plan)
             //  ->whereNotNull('paid_at')
             //  ->select('payments.*','moka_auto_payments.moka_plan_id')
             //  ->get();
             //dd($moka_auto_payments);
             foreach($moka_auto_payments as $payments){
                 if($payments->status == 2){
                 $iptal [] = $moka->delete_payment_plan($payments->moka_plan_id);
                 }
             }
           dd($iptal);
         }


         $moka = new Moka;
         $sonuc = $moka->get_payment_plan_report();

         $plan = [];
         $idler = [];
         if($sonuc->Data!= null){
             foreach($sonuc->Data->PaymentPlanList as $planlist){
                 if($planlist->PlanStatus == 1 )
                 {
                     $plan [] = $planlist->DealerPaymentPlanId;
                 }
             }

             dd($plan);
             $moka_auto_payments = DB::table('moka_auto_payments')
             ->join('payments', 'moka_auto_payments.payment_id', '=', 'payments.id')
             ->whereIn('moka_plan_id',$plan)
             ->select('payments.*')
             ->get();

             //dd($moka_auto_payments);
             foreach($moka_auto_payments as $payments){
                 if($payments->status == 1){
                     $idler [] = $payments->subscription_id;
                        $payment = Payment::find($payments->id);
                        $payment->receive([
                        'type' => 5
                       ]);
                 }
             }

             dd($idler);
         }
*/
/* -- HER AYIN 15'İNDE SAAT 11:00 DA ÇALIŞTIRILACAK */



       return view('admin.customer-notes.list',[
            'customer' => $customer,
            'customerNotes' => CustomerNote::where('customer_id',$customer->id)->
            orderby('id','desc')
            ->get()
        ]);

    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sms_list(Customer $customer)
    {
        return view('admin.customer-sms.list',[
            'customer' => $customer,      
            'customerSms' => DB::table('customer_sms')->where('customer_id',$customer->id)->orderby('created_at','desc')->get(),
            'customerSms2' => DB::table('sent_messages')->join('messages','sent_messages.message_id','=','messages.id')
                                                        ->where('sent_messages.type',2)
                                                        ->where('customer_id',$customer->id)
                                                        ->select('sent_messages.created_at as created_at', 'messages.title as title', 'messages.message as message')
                                                        ->orderBy('sent_messages.id', 'DESC')
                                                        ->get(),
                                                        
            'customerSms3'=>SentMessage::where('customer_id',$customer->id)
                                          ->where('message_id',NULL)
                                         ->orderBy('sent_messages.id', 'DESC')
                                         ->get()                                            
        ]);

    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer)
    {
        return view('admin.customer-notes.add', [
            'customer' => $customer
        ]);
    }


       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Customer $customer , Request $request)
    {
        $validated = $request->validate($this->rules());
        $validated["staff_id"] = $request->user()->staff_id;
        $validated["customer_id"] = $customer->id;

        if ($message = CustomerNote::create($validated)) {

            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.customer.notes',$customer->id)
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
