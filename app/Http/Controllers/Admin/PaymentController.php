<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Moka;
use App\Classes\Mutator;
use App\Classes\Telegram;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CustomerNote;
use App\Models\Message;
use App\Models\Promotion;
use App\Models\MokaAutoPayment;
use App\Models\MokaAutoPaymentDisable;
use App\Models\MokaLog;
use App\Models\MokaPayment;
use App\Models\MokaRefund;
use App\Models\MokaSale;
use App\Models\Payment;
use App\Models\PaymentCancellation;
use App\Models\PaymentCreate;
use App\Models\PaymentDelete;
use App\Models\SentMessage;
use App\Models\Subscription;
use App\Models\PaymentPenalty;
use App\Models\Gift;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Storage;
use App\Jobs\ProcessPaymentAutoResult;
class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view(
            'admin.payment.list',
            [
                'statuses' => trans('tables.payment.status'),
                'categories' => Category::all()
            ]
        );
    }
    
         public function hediye()
    {
       
        //$ikinciFiyat = Payment::get()->groupBy('subscription_id');
       // $ikinciFiyat = Payment::groupBy('subscription_id')->get();	 
     //   $ikinciFiyat = $ikinciFiyat[1]->first();
        
        $paymentGifts = DB::table('subscriptions')
                        ->join('services','subscriptions.service_id','=','services.id')
                        ->join('customers','customers.id','=','subscriptions.customer_id')
                        ->join('customer_staff','customers.id','=','customer_staff.customer_id')
                        ->join('staff','staff.id','=','customer_staff.staff_id')
                        ->join('payments','subscriptions.id','=','payments.subscription_id')
                        ->leftJoin('gifts','subscriptions.id','=','gifts.subscription_id')
                         
                        ->where('subscriptions.status','=',1)         
                        ->where('subscriptions.approved_at', '>=', '2023-05-01 00:00:00')

                        ->where(function($query) {
                            $query->where('services.id','=',122)
                                  ->orWhere('services.id','=',123);
                        })
                        
                        ->where('payments.date','=','2023-07-15') 
                       
                    //   ->where('payments.subscription_id',$ikinciFiyat)
                        ->where('payments.status','=',2)  
                        ->where('gifts.id')    
                        ->orderBy(DB::raw("subscriptions.approved_at"), 'DESC')
                        
                        ->select(DB::raw('
                         customers.id AS customer_id,
                        CONCAT(
                           
                            customers.first_name,
                            " ",
                            customers.last_name
                        ) AS isim, 
                     
                        staff.first_name AS first_name,
                        staff.last_name AS last_name,
                        
                        services.name AS name,
                        gifts.status AS statusGift,
                        subscriptions.approved_at AS approved_at,
                        subscriptions.options AS Options,
                        subscriptions.status AS status,
                        subscriptions.price AS price,
                        
                         subscriptions.id AS id,
                         subscriptions.staff_id AS staff_id,
                        staff.first_name AS temsilci'))
                        ->get();
            
             $paymentGift2 = DB::table('subscriptions')
                        ->join('services','subscriptions.service_id','=','services.id')
                        ->join('customers','customers.id','=','subscriptions.customer_id')
                        ->join('customer_staff','customers.id','=','customer_staff.customer_id')
                        ->join('staff','staff.id','=','customer_staff.staff_id')
                        ->join('payments','subscriptions.id','=','payments.subscription_id')
                        ->join('gifts','subscriptions.id','=','gifts.subscription_id')
                         
                        ->where('subscriptions.status','=',1)         
                        ->where('subscriptions.approved_at', '>=', '2023-05-01 00:00:00')

                        ->where(function($query) {
                            $query->where('services.id','=',59)
                                  ->orWhere('services.id','=',64)
                                  ->orWhere('services.id','=',65)
                                  ->orWhere('services.id','=',111);
                        })
                        
                        ->where('payments.date','=','2023-07-15') 
                       
                    //   ->where('payments.subscription_id',$ikinciFiyat)
                        ->where('payments.status','=',2)  
                        ->where('gifts.status','=',1)  
                        ->orderBy(DB::raw("subscriptions.approved_at"), 'DESC')
                        
                        ->select(DB::raw('
                         customers.id AS customer_id,
                        CONCAT(
                           
                            customers.first_name,
                            " ",
                            customers.last_name
                        ) AS isim, 
                     
                        staff.first_name AS first_name,
                        staff.last_name AS last_name,
                        
                        services.name AS name,
                        gifts.status AS statusGift,
                        gifts.note AS note,
                        subscriptions.approved_at AS approved_at,
                        subscriptions.options AS Options,
                        subscriptions.status AS status,
                        subscriptions.price AS price,
                        
                         subscriptions.id AS id,
                         subscriptions.staff_id AS staff_id,
                        staff.first_name AS temsilci'))
                        ->get();
            
            
        return view('admin.gift.hediye', compact('paymentGifts','paymentGift2'));
    }
    
    
       public function hediyeGonder(Request $request,$id)
    {
        $paymentGift  = Subscription::join('services','subscriptions.service_id','=','services.id')
                        ->join('customers','customers.id','=','subscriptions.customer_id')->select(DB::raw('
                         customers.id AS customer_id,
                        CONCAT(
                           
                            customers.first_name,
                            " ",
                            customers.last_name
                        ) AS isim, 
                     

                        
                        services.name AS name,
                        
            
                         subscriptions.id AS id,
                         subscriptions.staff_id AS staff_id
                        '))
                        ->findOrFail($id);
        $paymentGifts = Subscription::all();

        return view('admin.gift.hediyeGonder',compact('paymentGifts','paymentGift'));
       
    }
    
        
    public function hediyeGonderPost(Request $request,Gift $paymentGift)
    {
       $paymentGift  = new Gift;

       $paymentGift->staff_id=$request->staff_id;
       $paymentGift->subscription_id=$request->subscription_id;
       $paymentGift->note=$request->note;

       $paymentGift->save();

        return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.hediyes')
            ]);
       
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function listMonthly(Request $request)
    {
        /** Tüm Verileri Çekiyor -ESKİ KOD */
        $date = Carbon::parse($request->input('date') ?? 'now');
        $start_date = $date->startOfMonth()->format('Y-m-d');//->toDateString();
        $end_date = $date->endOfMonth()->format('Y-m-d');//->toDateString();
        $dates = [$start_date, $end_date];
        $startOfMonth = $date->startOfMonth()->format('Y-m-d');
        $endOfMonth = $date->endOfMonth()->format('Y-m-d');
        
        
        $start_date_test = Carbon::parse('2023-07-01 00:00:00');
        $end_date_test = Carbon::parse('2023-07-31 00:00:00');
        
        
        //$startDate = Carbon::createFromFormat('d/m/Y', '01/07/2023')->format('Y-m-d');
        //$endDate = Carbon::now()->format('Y-m-d');
        //$datesTest = [$startDate, $endDate];
        
        //$startDate = Carbon::parse($request->input('date') ?? 'now')->startOfMonth()->format('Y-m-d');
        //$endDate = Carbon::parse($request->input('date') ?? 'now')->endOfMonth()->format('Y-m-d');
        $startDate = $request->input('date') ? Carbon::createFromFormat('Y-m-d', $request->input('date'))->startOfMonth() : Carbon::now()->startOfMonth();
        $endDate = $request->input('date') ? Carbon::createFromFormat('Y-m-d', $request->input('date'))->endOfMonth() : Carbon::now()->endOfMonth();
        $datesTest = [$start_date, $end_date];
        
        $payments = DB::table('payments')->join('subscriptions', 'payments.subscription_id', '=', 'subscriptions.id')
        ->join('customers', 'customers.id', '=', 'subscriptions.customer_id')
        ->join('services', 'services.id', '=', 'subscriptions.service_id')
        ->join('categories', 'services.category_id', '=', 'categories.id')
        ->join('customer_info', 'customers.id', '=', 'customer_info.customer_id')
        ->join('cities', 'customer_info.city_id', '=', 'cities.id')
        ->join('customer_staff', 'customer_staff.customer_id', '=', 'customers.id')
        ->join('staff', 'customer_staff.staff_id', '=', 'staff.id' )
        ->select(DB::raw('categories.name as category_name,
                          customers.identification_number as TCKN,
                          customers.first_name as customer_first_name,
                          customers.last_name as customer_last_name,
                          customers.telephone as customer_tel,
                          customer_info.address as address,
                          customer_info.secondary_telephone as customer_secondary_tel,
                          services.name as service_name,
                          payments.price as payment_cost,
                          payments.status as payment_status,
                          payments.paid_at as payment_paid_at,
                          cities.name as city_name,
                          payments.type as payment_type,
                          staff.first_name as staffs_first_name
                         '))->whereDate('payments.date','>=',$startDate)->whereDate('payments.date','<=',$endDate)->get();
                         //->where('payments.paid_at', '=', '2020-07-20 14:11:06')->get();
                   
        //echo $payments;
        //echo $dates[0]."  ".$dates[1];
        return view('admin.payment.monthly', [
            'payments' => $payments,
            'date' => $date->toDateString()
        ]);
        
       
         /* SON 30 Günün Verisini Çekiyor 
        $date = Carbon::parse($request->input('date') ?? 'now');
$end_date = $date->endOfDay()->toDateString();
$start_date = $date->subDays(31)->startOfDay()->toDateString();

$dates = [$start_date, $end_date];

return view('admin.payment.monthly', [
    'payments' => Payment::whereBetween('date', $dates)->get(),
    'date' => $date->toDateString()
]);
 --SON 30 Günün Verisini Çekiyor */       
        
    }
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
     
    public function listDaily(Request $request)
    {
        //$startDate = $request->input('date') ? Carbon::createFromFormat('Y-m-d', $request->input('date'))->startOfDay()->toDateTimeString() : Carbon::now()->startOfDay()->toDateTimeString();
        $startDate = $request->input('date') ? Carbon::createFromFormat('Y-m-d', $request->input('date'))->startOfDay()->toDateString() : Carbon::now()->startOfDay()->toDateString();
        //$endDate = $request->input('date') ? Carbon::createFromFormat('Y-m-d', $request->input('date'))->endOfDay()->toDateString() : Carbon::now()->endOfDay()->toDateString();
        //echo $startDate." ".$endDate;
        
        
        
        
        $payments = DB::table('payments')->join('subscriptions', 'payments.subscription_id', '=', 'subscriptions.id')
        ->join('customers', 'customers.id', '=', 'subscriptions.customer_id')
        ->join('services', 'services.id', '=', 'subscriptions.service_id')
        ->join('categories', 'services.category_id', '=', 'categories.id')
        ->join('customer_info', 'customers.id', '=', 'customer_info.customer_id')
        ->join('cities', 'customer_info.city_id', '=', 'cities.id')
        ->join('customer_staff', 'customer_staff.customer_id', '=', 'customers.id')
        ->join('staff', 'customer_staff.staff_id', '=', 'staff.id' )
        ->select(DB::raw('categories.name as category_name,
                          customers.identification_number as TCKN,
                          customers.first_name as customer_first_name,
                          customers.last_name as customer_last_name,
                          customers.telephone as customer_tel,
                          customer_info.address as address,
                          customer_info.secondary_telephone as customer_secondary_tel,
                          services.name as service_name,
                          payments.price as payment_cost,
                          payments.status as payment_status,
                          payments.paid_at as payment_paid_at,
                          cities.name as city_name,
                          payments.type as payment_type,
                          staff.first_name as staffs_first_name
                         '))//->where('payments.paid_at', '=', $startDate)->get();
                         ->whereDate('payments.paid_at', $startDate)->get();
        //echo $payments;
        DB::disconnect(DB::connection()->getDatabaseName());
        
        return view('admin.payment.daily', [
            'payments' => $payments,
            'date' => $startDate
        ]);
        
    }
    
    
    public function listInvoice(Request $request)
    {


        $date = Carbon::parse($request->input('date') ?? 'now')->subMonth(1);
        $start_date = $date->startOfMonth()->toDateString();
        $end_date = $date->endOfMonth()->addDay()->toDateString();

        $dates = [$start_date, $end_date];



        return view('admin.payment.invoice', [
            'subscriptions' => Subscription::whereBetween('approved_at', $dates)->orderBy('approved_at','ASC')->get(),
            'date' => $request->input('date')
        ]);
    }

    /**
     * Get a listing of the resource.
     *
     * @return array
     */
    public function list(Request $request)
{
    $data = [];
    $offset = $request->input('start');
    $limit = $request->input('length');
    $draw = $request->input('draw');
    $date = str_replace("\\", "", $request->input('columns.4.search.value'));
    $status = $request->input('columns.5.search.value');
    $type = $request->input('columns.6.search.value');
    $category_id = $request->input('columns.2.search.value');

    // Başlangıç sorgusu
    $payments = Payment::select('payments.*')->orderBy('payments.id', 'desc');
    $no = Payment::select('payments.*')->orderBy('payments.id', 'desc');

    // Kategoriyi filtrele
    if ($category_id != "") {
        $payments = $payments
            ->join('subscriptions', 'subscriptions.id', '=', 'payments.subscription_id')
            ->whereRaw("subscriptions.service_id IN (SELECT id FROM services WHERE category_id = ?)", [$category_id]);

        $no = $no
            ->join('subscriptions', 'subscriptions.id', '=', 'payments.subscription_id')
            ->whereRaw("subscriptions.service_id IN (SELECT id FROM services WHERE category_id = ?)", [$category_id]);
    }

    // Tarih filtresi
    if ($date != "") {
        $payments = $payments->where("payments.date", $date);
        $no = $no->where("payments.date", $date);
    }

    // Durum filtresi
    if ($status != "") {
        $payments = $payments->where("payments.status", $status);
        $no = $no->where("payments.status", $status);
    }

    // Tür filtresi
    if ($type != "") {
        $payments = $payments->where("payments.type", $type);
        $no = $no->where("payments.type", $type);
    }

    // Sayfalama işlemi
    $payments = $payments->offset($offset)->limit($limit)->get();
    $total = $no->count(); // Tüm kayıt sayısını al

    // Verileri hazırlamak
    foreach ($payments as $payment) {
        if ($payment->type) {
            $type = trans('tables.payment.types.' . $payment->type);
        } else {
            $type = "";
        }

        $data[] = [
            0 => $payment->id,
            1 => '<a href="' . route('admin.customer.show', $payment->subscription->customer_id) . '">' . $payment->subscription->customer->full_name . '</a>',
            2 => $payment->subscription->service->name,
            3 => print_money($payment->price),
            4 => convert_date($payment->date, "mask"),
            5 => trans('tables.payment.status.' . $payment->status),
            6 => $type
        ];
    }

    // DataTables JSON formatında döndürme
    return response()->json([
        'draw' => intval($draw),
        'recordsTotal' => Payment::count(), // Tüm kayıt sayısı
        'recordsFiltered' => $total, // Filtrelenmiş kayıt sayısı
        'data' => $data
    ]);
}


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function listPenalties(Request $request)
    {
        $dateStart;
        $dateEnd;
        if($request->has('date'))
        {
           $dateStart = Carbon::createFromFormat('Y-m-d', $request->input('date'))->startOfMonth();
           $dateEnd = Carbon::createFromFormat('Y-m-d', $request->input('date'))->endOfMonth();
        }
        else if(!$request->has('date'))
        {
            $now = Carbon::parse('now');
            if($now->day < 20)
            {
              //Storage::disk('local')->append("lastMonth.txt", $now->day, "\n");  
              $dateStart = Carbon::now()->subMonth()->startOfMonth();
              $dateEnd = Carbon::now()->subMonth()->endOfMonth();
                      
            }
            else
            {
                //Storage::disk('local')->append("thisMonth.txt", $now->day, "\n");
                $dateStart = Carbon::now()->startOfMonth();
                $dateEnd = Carbon::now()->endOfMonth();
            }            
        }
        
        //$startDate = $request->input('date') ? Carbon::createFromFormat('Y-m-d', $request->input('date'))->startOfMonth() : Carbon::now()->startOfMonth();
        //$endDate = $request->input('date') ? Carbon::createFromFormat('Y-m-d', $request->input('date'))->endOfMonth() : Carbon::now()->endOfMonth();
        
        

        
        
        $punishmentRecords = DB::table('payment_penalties')->join('payments', 'payment_penalties.payment_id', '=', 'payments.id')
                             ->join('subscriptions', 'payments.subscription_id', '=', 'subscriptions.id')
                             ->join('customers', 'subscriptions.customer_id', '=', 'customers.id')
                             ->join('services', 'subscriptions.service_id', '=', 'services.id')
                             ->join('customer_info', 'customers.id', '=', 'customer_info.customer_id')
                             ->join('categories', 'services.category_id', '=', 'categories.id')
                             ->select(DB::raw('customers.identification_number as identification_number,
                                               customers.first_name as first_name,
                                               customers.last_name as last_name,
                                               customers.telephone as telephone,
                                               customer_info.secondary_telephone as secondary_telephone,
                                               categories.name as category_name,
                                               payment_penalties.old_price as old_price,
                                               payment_penalties.new_price as new_price,
                                               payments.status as payment_status,
                                               payments.created_at as payment_created_at,   
                                               payment_penalties.created_at as penalty_created_at,
                                               payments.price as payment_price
                                               
                              '))
                              //->where('payments.status', '=', 1)
                              ->whereDate('payment_penalties.created_at','>=',$dateStart)->whereDate('payment_penalties.created_at','<=',$dateEnd)
                             ->get()->toArray();
            
        //Storage::disk('local')->append("allpunishes.txt", print_r($punishmentRecords, true), "\n");  
        // Border Price is currently equals to 99 TL. (06.09.2023 15:05)
        $paymentPenalties = array();
        $portPenalties = array();
        for($i=0; $i<count($punishmentRecords); $i++)
        {
            $array = json_decode(json_encode($punishmentRecords[$i]), true);
            if(($array['payment_status'] == 2) && ($array['payment_price'] < $array['new_price'])) continue;
            //Storage::disk('local')->append("diff.txt", $array['identification_number']);
            if($array['new_price'] - $array['old_price'] <= 120) //without make   
            {
                array_push($paymentPenalties, $array);
            }
            else
            {
                array_push($portPenalties, $array);
            }
        }
        
        //Storage::disk('local')->append("tyre.txt", count($belowBorderPrice)." ".count($aboveBorderPrice), "\n");
        //Disconnect
        //u9239524_ruzgarnet
        DB::disconnect(DB::connection()->getDatabaseName());
        //$databaseName = DB::connection()->getDatabaseName();
        //Storage::disk('local')->append("deletePer.txt", $databaseName, "\n");
        return view('admin.payment.penalties', [
            'paymentPenalties' => (object) $paymentPenalties,
            'portPenalties' => (object) $portPenalties,
            'startDate' => $dateStart,
            'endDate' => $dateEnd
        ]);
        //Storage::disk('local')->append("sunwukong.txt", $now->day, "\n");
        
        /*
        $payments = Payment::whereDate('date', date('Y-m-15'))
            ->whereRaw('`id` IN (SELECT `payment_id` FROM `payment_penalties`)')
            ->get();

        return view('admin.payment.penalties', [
            'payments' => $payments
        ]);
        */
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function listPaid()
    {
        $payments = Payment::whereDate('date', date('Y-m-15'))
            ->where('status',2)
            ->get();

        return view('admin.payment.paid', [
            'payments' => $payments
        ]);
    }

          /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function listNotPaid()
    {
        $payments = Payment::whereDate('date', date('Y-m-15'))
            ->where('status',1)
            ->get();
            /*
             @foreach ($payments as $payment)
                                    <tr data-id="{{ $payment->id }}">
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $payment->subscription->customer->identification_number }}</td>
                                        <td>
                                            <a href="{{ route('admin.customer.show', $payment->subscription->customer) }}"
                                                >{{ $payment->subscription->customer->full_name }}</a>
                                        </td>
                                        <td>{{ $payment->subscription->customer->telephone_print }}</td>
                                        <td>{{ $payment->subscription->customer->customerInfo->secondary_telephone_print }}</td>
                                        <td>{{ $payment->subscription->service->category->name }}</td>
                                        <td data-sort="{{ $payment->price }}">{{ print_money($payment->price) }}</td>
                                        <td @if ($payment->isPaid()) title="@lang("tables.payment.types.{$payment->type}") &#013;{{ $payment->paid_at_print }}" @endif>
                                            @lang("tables.payment.penalty_status.{$payment->status}")
                                        </td>
                                    </tr>
                                @endforeach
            */
        /*
        */

        $notPaids = DB::table('payments')
                    ->join('subscriptions', 'subscriptions.id', '=', 'payments.subscription_id')
                    ->join('customers', 'subscriptions.customer_id', '=', 'customers.id')
                    ->join('services', 'subscriptions.service_id', '=', 'services.id')
                    ->join('categories', 'services.category_id', '=', 'categories.id')
                    ->join('customer_info', 'customer_info.customer_id', '=', 'customers.id')
                    ->whereDate('date', date('Y-m-15'))
                    ->where('payments.status', '=', 1)
                    ->select(DB::raw('
                        payments.id AS id,
                        customers.id AS customer_id,
                        customers.identification_number AS identification_number,
                        CONCAT(customers.first_name," ",customers.last_name) AS full_name,
                        customers.telephone AS telephone,
                        customer_info.secondary_telephone AS secondary_telephone,
                        categories.name AS category_name,
                        payments.price AS price,
                        services.name AS service_name
                    '))
                    ->get();
        //Storage::disk('local')->append('notPaid1710202311111.txt', print_r($notPaids, true), "\n");
        DB::disconnect(DB::connection()->getDatabaseName());

        return view('admin.payment.notpaid', [
            'payments' => $notPaids
        ]);
    }


    /**
     * Receives payment
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function received(Request $request, Payment $payment)
    {
        if (!$payment->isPaid()) {
            $rules = $this->rules();

            $subscription = $payment->subscription;

            if ($subscription->isAuto() && $request->input('type') != 5 && !$subscription->isAutoPenalty()) {
                $next_payment = $subscription->nextMonthPayment();
                $new_price = $next_payment->price + 0;

                $data = [
                    'payment_id' => $next_payment->id,
                    'staff_id' => null,
                    'old_price' => $next_payment->price,
                    'new_price' => $new_price,
                    'description' => trans('response.system.auto_payment_penalty', ['price' => 0])
                ];

                MokaAutoPaymentDisable::create([
                    'subscription_id' => $subscription->id,
                    'payment_id' => $next_payment->id,
                    'old_price' => $next_payment->price,
                    'new_price' => $new_price
                ]);

                $next_payment->edit_price($data);
            }
                   if ($request->input('type') == 7) {
                $payment_type = 7;
            
                $moka = new Moka();
                $payment_detail2 = $moka->get_all_payment_detail_by_other_trx();

                    $cardId=$request->cardId;
                    $dateOfPay=$request->dateOfPay;
                    $startDate = Carbon::parse($dateOfPay);  // $dateOfPay'ı Carbon nesnesine dönüştür
                    $price=$request->new_price;
                    // Tarih formatını 'Y-m-d H:i' şeklinde yap
                    $formattedStartDate = $startDate->format('Y-m-d H:i');
                      // Kullanıcıdan aldığınız başlangıç tarihi ve saati
                    $payment_detail3 = $moka->get_all_payment_detail_by_other_trx_and_last_four($cardId, $formattedStartDate);
                    if (!empty($payment_detail3) && isset($payment_detail3[0])) {
                        if (
                            $payment_detail3[0]->PaymentStatus == 2 &&
                            $payment_detail3[0]->TrxStatus == 1
                        ) {
                            // Ödeme başarılıysa veritabanında güncelleme yapılıyor
                            $payment->update([
                                'price' => $price,
                                'type' => 7,
                                'status' => 2,
                                'paid_at' => Carbon::parse($request->input('dateOfPay'))
                            ]);
                    
                            $newDate = Carbon::parse($payment->date)->addMonth();
                    
                            $temporary = [
                                'subscription_id' => $subscription->id,
                                'price' => $price,
                                'date' => $newDate,
                                'status' => 1,
                                'type' => null
                            ];
                    
                            Payment::create($temporary);
                    
                            return response()->json([
                                'success' => true,
                                'reload' => true
                            ]);
                        } else {
                            // Ödeme başarısızsa
                            return response()->json([
                                'error' => true,
                                'toastr' => [
                                    'type' => 'error',
                                    'title' => 'Hata',
                                    'message' => 'Moka üzerinden ödeme alınamamış.'
                                ]
                            ]);
                        }
                    } else {
                        // $payment_detail3 boş veya geçersizse
                        return response()->json([
                            'error' => true,
                            'toastr' => [
                                'type' => 'error',
                                'title' => 'Hata',
                                'message' => 'Moka ödeme detayı bulunamadı.'
                            ]
                        ]);
                    }
                    
                // Eğer moka ödemesi başarısızsa ya da yoksa buraya düşer, dilersen hata döndürebilirsin:
            }
            
            if (in_array($request->input('type'), [4, 5])) {
               

                $rules["card.number"] = [
                    'required',
                    'numeric'
                ];
                $rules["card.full_name"] = [
                    'required',
                    'string',
                    'max:255'
                ];
                $rules["card.expire_date"] = [
                    'required',
                    'string'
                ];
                $rules["card.security_code"] = [
                    'required',
                    'string'
                ];
            }

            $moka = new Moka();
            if ($payment->mokaPayment) {

                $payment_detail = $moka->get_payment_detail_by_other_trx($payment->mokaPayment->trx_code);
                 
                if (
                    $payment_detail->Data->PaymentDetail->PaymentStatus == 2 &&
                    $payment_detail->Data->PaymentDetail->TrxStatus == 1
                ) {
                    $payment->receive([
                        'type' => 4
                    ]);

                    return response()->json([
                        'success' => true,
                        'reload' => true
                    ]);
                }
            }
            MokaPayment::where('payment_id', $payment->id)->delete();


            $validated = $request->validate($rules);

            $date = Carbon::parse($payment->date);
            $month = Carbon::now()->format("m");

            if (env('APP_ENV') == 'production') {
                if ($request->input('type') == 4) {
                    $expire = Mutator::expire_date($validated["card"]["expire_date"]);

                    $card = [
                        'full_name' => $validated["card"]['full_name'],
                        'number' => $validated["card"]['number'],
                        'expire_month' => $expire[0],
                        'expire_year' => $expire[1],
                        'security_code' => $validated["card"]['security_code'],
                        'amount' => $payment->price
                    ];

                    $hash = [
                        'subscription_no' => $payment->subscription->subscription_no,
                        'payment_created_at' => $payment->created_at
                    ];

                    $response = $moka->pay(
                        $card,
                        route('payment.result', $payment),
                        $hash
                    );

                    if ($response->Data != null) {
                        MokaPayment::create([
                            'payment_id' => $payment->id,
                            'trx_code' => $moka->trx_code
                        ]);

                        MokaLog::create([
                            'payment_id' => $payment->id,
                            'ip' => $request->ip(),
                            'response' => ['init' => $response],
                            'trx_code' => $moka->trx_code
                        ]);

                        if ($request->input('auto_payment')) {
                            $this->define_auto_payment($payment, $validated);
                        }

                        return response()->json([
                            'success' => true,
                            'payment' => [
                                'frame' => $response->Data->Url
                            ]
                        ]);
                    }

                    MokaLog::create([
                        'payment_id' => $payment->id,
                        'ip' => $request->ip(),
                        'response' => $response,
                        'trx_code' => $moka->trx_code
                    ]);

                    return response()->json([
                        'error' => true,
                        'toastr' => [
                            'type' => 'error',
                            'title' => trans('response.title.error'),
                            'message' => trans('moka.' . str_replace('.', '_', $response->ResultCode))
                        ]
                    ]);
                } else if ($request->input('type') == 5) {
                    return $this->define_auto_payment($payment, $validated);
                }
             else if ($request->input('type') == 7) {
                // type 7 için sadece kayıt işlemi yapılıyor, kart bilgisi olmadan
                $trx_code = uniqid('order_'); // Örnek bir trx_code üret
        
                MokaPayment::create([
                    'payment_id' => $payment->id,
                    'trx_code' => $trx_code
                ]);
        
                MokaLog::create([
                    'payment_id' => $payment->id,
                    'ip' => $request->ip(),
                    'response' => ['info' => 'type_7_manual_payment'],
                    'trx_code' => $trx_code
                ]);
        
                return response()->json([
                    'success' => true,
                    'toastr' => [
                        'type' => 'success',
                        'title' => trans('response.title.success'),
                        'message' => 'Kart bilgisi olmadan manuel ödeme işlemi kaydedildi.'
                    ],
                    'reload' => true
                ]);
            }

                if ($payment->receive($validated)) {
                    return response()->json([
                        'success' => true,
                        'toastr' => [
                            'type' => 'success',
                            'title' => trans('response.title.success'),
                            'message' => trans('warnings.payment.successful')
                        ],
                        'reload' => true
                    ]);
                }

                return response()->json([
                    'error' => true,
                    'toastr' => [
                        'type' => 'error',
                        'title' => trans('response.title.error'),
                        'message' => trans('response.edit.error')
                    ]
                ]);
            }

            return response()->json([
                'error' => true,
                'toastr' => [
                    'type' => 'error',
                    'title' => trans('response.title.error'),
                    'message' => trans('warnings.payment.not_allowed_received_date')
                ]
            ]);
        }
    }

public function fineresult() {
$subscriptions = Subscription::where('status', 1)
    ->whereHas('payments', function($query) {
        $query->where('status', 2)
            ->whereIn('date', function($subquery) {
                $subquery->select(DB::raw('MAX(p2.date)'))
                    ->from('payments as p2')
                    ->whereColumn('p2.subscription_id', 'payments.subscription_id')
                    ->where('p2.status', 2);
            });
    })
    ->with(['payments' => function($query) {
        $query->where('status', 2)
            ->whereIn('date', function($subquery) {
                $subquery->select(DB::raw('MAX(p2.date)'))
                    ->from('payments as p2')
                    ->whereColumn('p2.subscription_id', 'payments.subscription_id')
                    ->where('p2.status', 2);
            });
    }])
    ->get();
    return $subscriptions;

}

    /**
     * Receives payment
     *
     * @param  \App\Models\Payment $payment
     * @param  array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function define_auto_payment(Payment $payment, array $data)
    {
        $expire = Mutator::expire_date($data["card"]["expire_date"]);

        $card = [
            'full_name' => $data["card"]['full_name'],
            'number' => $data["card"]['number'],
            'expire_month' => $expire[0],
            'expire_year' => $expire[1],
            'amount' => $payment->subscription->price
        ];

        $sale = MokaSale::where("subscription_id", $payment->subscription->id)->orderByDesc('id')->first();
        $moka = new Moka();

        if ($sale) {
            $moka->remove_card($sale->moka_card_token);

            $customer_id = $sale->moka_customer_id;
            $result = $moka->add_card(
                $customer_id,
                $card["full_name"],
                $card["number"],
                $expire[0],
                $expire[1]
            );

            if ($result->Data != null) {
                $card_token = $result->Data->CardList[0]->CardToken;

                $moka->update_sale(
                    $sale->moka_sale_id,
                    [
                        'card_token' => $card_token
                    ]
                );
            } else {
                $error = str_replace('.', '_', $result->ResultCode);
                $message = trans("moka.{$error}");

                return response()->json([
                    'error' => true,
                    'toastr' => [
                        'type' => 'error',
                        'title' => trans('response.title.error'),
                        'message' => $message
                    ]
                ]);
            }
        } else {
            $results = $moka->create_customer(
                [
                    'id' => md5($payment->subscription->subscription_no),
                    'first_name' => $payment->subscription->customer->first_name,
                    'last_name' => $payment->subscription->customer->last_name,
                    'telephone' => $payment->subscription->customer->telephone
                ],
                [
                    'full_name' => $card["full_name"],
                    'number' => $card["number"],
                    'expire_month' => $expire[0],
                    'expire_year' => $expire[1]
                ]
            );

            if ($results->Data != null) {
                $customer_id = $results->Data->DealerCustomer->DealerCustomerId;
                $card_token = $results->Data->CardList[0]->CardToken;
            } else {
                return response()->json([
                    'error' => true,
                    'toastr' => [
                        'type' => 'error',
                        'title' => trans('response.title.error'),
                        'message' => trans('warnings.payment.add_customer_failure')
                    ]
                ]);
            }
        }

        if ($customer_id && $card_token) {
            if ($sale) {
                $sale_id = $sale->moka_sale_id;
            } else {
                $dates = [
                    'start' => date('Ymd')
                ];

                if ($payment->subscription->end_date)
                    $dates["end"] = date('Ymd', strtotime($payment->subscription->end_date));
                else
                    $dates["end"] = "";

                $sale_response = $moka->add_sale(
                    [
                        'moka_id' => $customer_id,
                        'card_token' => $card_token
                    ],
                    [
                        'service_code' => $payment->subscription->service->model,
                        'amount' => $payment->subscription->price
                    ],
                    $dates
                );

                $sale_id = $sale_response->Data->DealerSaleId;
            }

            MokaSale::where("subscription_id", $payment->subscription->id)
                ->whereNull("disabled_at")
                ->update([
                    'disabled_at' => DB::raw('current_timestamp()')
                ]);
        }

        if (!$payment->subscription->isPreAuto()) {
            $next_payment = $payment->subscription->nextMonthPayment();

            $auto_discount = 0;
            $new_price = $next_payment->price - $auto_discount;
            if ($new_price <= 25)
                $new_price = $next_payment->price;

            $data = [
                'payment_id' => $next_payment->id,
                'staff_id' => null,
                'old_price' => $next_payment->price,
                'new_price' => $new_price,
                'description' => trans('response.system.auto_payment_discount', ['price' => $auto_discount])
            ];

            $next_payment->edit_price($data);
        }

        MokaSale::create([
            'subscription_id' => $payment->subscription->id,
            'moka_customer_id' => $customer_id,
            'moka_sale_id' => $sale_id,
            'moka_card_token' => $card_token
        ]);

        SentMessage::insert(
            [
                'customer_id' => $payment->subscription->customer->id,
                'message_id' => 15
            ]
        );

        return response()->json([
            'success' => true,
            'toastr' => [
                'type' => 'success',
                'title' => trans('response.title.success'),
                'message' => "Otomatik Ödeme"
            ],
            'reload' => true
        ]);
    }

    /** ibrahim */
    
    
    public function payment_auto_result(Request $request)
{
    echo 'OK';

    $moka = new Moka();
    $odemeSonuc = $moka->get_payment_plan_report();

    $paymentPlans = $odemeSonuc->Data->PaymentPlanList;
    $paymentPlansCount = count($paymentPlans);

    // Parçalama büyüklüğü (örneğin her seferinde 100 öğe işleme)
    $chunkSize = 200;

    // Dış döngü: Veriyi parçalar halinde işlemek
    for ($i = 0; $i < $paymentPlansCount; $i += $chunkSize) {

        // İç döngü: Her parçayı işlemek
        $chunk = array_slice($paymentPlans, $i, $chunkSize);  // $chunkSize kadar öğeyi al

        foreach ($chunk as $paymentPlan) {
            $DealerPaymentPlanId = $paymentPlan->DealerPaymentPlanId;
            $planStatus = $paymentPlan->PlanStatus;

            if ($paymentPlan->PlanStatus == 1) {
                echo $DealerPaymentPlanId . "<br>";

                try {
                    $plan_id = (int)$paymentPlan->DealerPaymentPlanId;
                    $plan = MokaAutoPayment::where("moka_plan_id", $plan_id)->first();

                    if ($plan) {
                        $moka = new Moka();
                        $payment_detail = $moka->get_payment_detail($paymentPlan->DealerPaymentId);

                        if (
                            $plan->payment->status == 2 &&
                            $plan->payment->type != 5 //&&                            !$plan->isRefund()
                        ) {
                            if (
                                isset($payment_detail->Data->PaymentDetail->OtherTrxCode) &&
                                !empty($payment_detail->Data->PaymentDetail->OtherTrxCode)
                            ) {
                                $refundType = 1;

                                $result = $moka->do_void(
                                    $payment_detail->Data->PaymentDetail->OtherTrxCode
                                );

                                if ($result->Data == null) {
                                    $refundType = 2;
                                    $result = $moka->refund($payment_detail->Data->PaymentDetail->OtherTrxCode);
                                }

                                $success = false;
                                if ($result->Data != null && isset($result->Data->IsSuccessful) && (bool)$result->Data->IsSuccessful)
                                    $success = true;

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
                            if (
                                $payment_detail->Data->PaymentDetail->PaymentStatus == 2 &&
                                $payment_detail->Data->PaymentDetail->TrxStatus == 1
                            ) {
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

                    // DB::table('auto_results')->insert([
                    //     'response' => json_encode($data),
                    // ]);
                } catch (Exception $e) {
                    Telegram::send(
                        "Test",
                        "Payment Controller - Payment Auto Result Method : \n" . $e->getMessage()
                    );
                }
            }
        }

        // Verilerin işlenmesi arasında bir süre beklemek
        sleep(1); // 1 saniye bekleyerek her parçayı işledikten sonra zaman aşımından kaçınabilirsiniz
    }
}

    
    
//      public function payment_auto_result(Request $request)
// {
//     echo 'OK';

//     $moka = new Moka();
//     $odemeSonuc = $moka->get_payment_plan_report();

//     $paymentPlans = $odemeSonuc->Data->PaymentPlanList;
//     //$paymentPlansCount = count($paymentPlans);

//     for ($i = 0; $i < 200; $i++) {
//         $paymentPlan = $paymentPlans[$i];
        
//         $DealerPaymentPlanId = $paymentPlan->DealerPaymentPlanId;
//         $planStatus = $paymentPlan->PlanStatus;
        
//         echo $DealerPaymentPlanId . "\n";

//         if ($paymentPlan->PlanStatus == 1) {
//             echo $DealerPaymentPlanId . "<br>";

//             try {

//                 $plan_id = (int)$paymentPlan->DealerPaymentPlanId;
//                 $plan = MokaAutoPayment::where("moka_plan_id", $plan_id)->first();

//                 //$plan = MokaAutoPayment::where("moka_plan_id", 165586)->first();

//                 if ($plan) {
                    
//                     Telegram::send("Test", "Payment Controller - Payment Auto Result Method : \n" . json_encode($plan, JSON_PRETTY_PRINT));

//                     //$moka = new Moka();
//                     $payment_detail = $moka->get_payment_detail($paymentPlan->DealerPaymentId);

//                     //$payment_detail = $moka->get_payment_detail(82739308);

//                     if ($plan->payment->status == 2 && $plan->payment->type != 5 && !$plan->isRefund() ) {
//                         if ( isset($payment_detail->Data->PaymentDetail->OtherTrxCode) && !empty($payment_detail->Data->PaymentDetail->OtherTrxCode)) {
//                             $refundType = 1;

//                             $result = $moka->do_void($payment_detail->Data->PaymentDetail->OtherTrxCode);

//                             if ($result->Data == null) {
//                                 $refundType = 2;
//                                 $result = $moka->refund($payment_detail->Data->PaymentDetail->OtherTrxCode);
//                             }

//                             $success = false;
//                             if ($result->Data != null && isset($result->Data->IsSuccessful) && (bool)$result->Data->IsSuccessful)
//                                 $success = true;

//                             $plan->status = 5;
//                             $plan->save();

//                             MokaRefund::updateOrCreate(
//                                 [
//                                     'auto_payment_id' => $plan->id
//                                 ],
//                                 [
//                                     'payment_id' => $plan->payment->id,
//                                     'auto_payment_id' => $plan->id,
//                                     'price' => $plan->payment->price,
//                                     'status' => $success,
//                                     'type' => $refundType
//                                 ]
//                             );
//                         }
//                     } else {
//                         if ($payment_detail->Data->PaymentDetail->PaymentStatus == 2 && $payment_detail->Data->PaymentDetail->TrxStatus == 1 ) {
//                             $plan->status = 1;
//                             $plan->save();

//                             $plan->payment->receive([
//                                 'type' => 5
//                             ]);
//                         } else {
//                             $plan->status = 4;
//                             $plan->save();
//                         }
//                     }
//                 }

//                 //DB::table('auto_results')->insert([ 'response' => json_encode($data),]);
//             } catch (Exception $e) {
//                 Telegram::send(
//                     "Test",
//                     "Payment Controller - Payment Auto Result Method : \n" . $e->getMessage()
//                 );
//             }
//         }
//     }
// }

        
    /** /ibrahim */
    /**
     * Get plan payment info from Moka
     *
     * @param Request $request
     * @return void
     */
    // public function payment_auto_result(Request $request)
    // {
        
    //      //Telegram::send("Test","çalıştı");
    //      //Telegram::send("Test", "Payment Controller - Payment Auto Result Method : \n" . json_encode($request, JSON_PRETTY_PRINT));
    //      //Telegram::send("Test","bitti");       
    //     echo 'OK';
    //     //echo json_encode($request, JSON_PRETTY_PRINT);
        
    //      // Tüm request verilerini almak (form verisi, JSON verisi, vb.)
    //     // $allData = $request->all();  // Form verilerini alır
    //     // $ip = $request->ip();         // IP adresini alır
    //     // $method = $request->method(); // HTTP method (POST, GET, vb.)
    //     // $headers = $request->header(); // HTTP header bilgilerini alır
    //     // $cookies = $request->cookie(); // Cookie bilgilerini alır

    //     // // JSON verisi varsa almak
    //     // $jsonData = $request->json()->all(); // Eğer JSON verisi gelirse
        
    //     // Tüm verileri birleştiriyoruz
    //     // $requestData = [
    //     //     'method' => $method,
    //     //     'ip' => $ip,
    //     //     'headers' => $headers,
    //     //     'cookies' => $cookies,
    //     //     'form_data' => $allData,
    //     //     'json_data' => $jsonData,  // JSON verisi varsa
    //     //     'time' => now(),  // İstek zamanı
    //     // ];
        
    //      //$jsonRequestData = json_encode($requestData, JSON_PRETTY_PRINT);
    //      //Storage::disk('local')->append('json.txt', $jsonRequestData . "\n");

    //     $moka = new Moka();
    //     $odemeSonuc= $moka->get_payment_plan_report();
    //     //echo json_encode($odemeSonuc);
        
    //     // $paymentPlans = $odemeSonuc['Data']['PaymentPlanList'];
        
    //     $paymentPlans = $odemeSonuc->Data->PaymentPlanList;
        
    //     foreach ($paymentPlans as $paymentPlan) {
            
    //         $DealerPaymentPlanId=$paymentPlan->DealerPaymentPlanId;
    //         $planStatus=$paymentPlan->PlanStatus;
            
    //         if ($paymentPlan->PlanStatus==1){
    //         echo $DealerPaymentPlanId . "<br>";
            
        
    //     try {
            
    //         $plan_id = (int)$paymentPlan->DealerPaymentPlanId;
    //         $plan = MokaAutoPayment::where("moka_plan_id", $plan_id)->first();
            
    //         //$plan = MokaAutoPayment::where("moka_plan_id", 165586)->first();
            
    //         if ($plan) {
    //             //echo 'plan1';
    //             //$moka = new Moka();
    //             //$payment_detail = $moka->get_payment_detail($request->input('DealerPaymentId'));
    //             $moka = new Moka();
    //             $payment_detail = $moka->get_payment_detail($paymentPlan->DealerPaymentId);
                
    //             //$payment_detail = $moka->get_payment_detail(82739308);

    //             if (
    //                 $plan->payment->status == 2 &&
    //                 $plan->payment->type != 5 &&
    //                 !$plan->isRefund()
    //             ) {
    //                 if (
    //                     isset($payment_detail->Data->PaymentDetail->OtherTrxCode) &&
    //                     !empty($payment_detail->Data->PaymentDetail->OtherTrxCode)
    //                 ) {
    //                     $refundType = 1;

    //                     $result = $moka->do_void(
    //                         $payment_detail->Data->PaymentDetail->OtherTrxCode
    //                     );

    //                     if ($result->Data == null) {
    //                         $refundType = 2;
    //                         $result = $moka->refund($payment_detail->Data->PaymentDetail->OtherTrxCode);
    //                     }

    //                     $success = false;
    //                     if ($result->Data != null && isset($result->Data->IsSuccessful) && (bool)$result->Data->IsSuccessful)
    //                         $success = true;

    //                     $plan->status = 5;
    //                     $plan->save();

    //                     MokaRefund::updateOrCreate(
    //                         [
    //                             'auto_payment_id' => $plan->id
    //                         ],
    //                         [
    //                             'payment_id' => $plan->payment->id,
    //                             'auto_payment_id' => $plan->id,
    //                             'price' => $plan->payment->price,
    //                             'status' => $success,
    //                             'type' => $refundType
    //                         ]
    //                     );
    //                 }
    //             } else {
    //                 if (
    //                     $payment_detail->Data->PaymentDetail->PaymentStatus == 2 &&
    //                     $payment_detail->Data->PaymentDetail->TrxStatus == 1
    //                 ) {
    //                     $plan->status = 1;
    //                     $plan->save();

    //                     $plan->payment->receive([
    //                         'type' => 5
    //                     ]);
    //                 } else {
    //                     $plan->status = 4;
    //                     $plan->save();
    //                 }
    //             }
    //         }

    //         DB::table('auto_results')->insert([
    //             'response' => json_encode($data),
    //         ]);
    //     } catch (Exception $e) {
    //         Telegram::send(
    //             "Test",
    //             "Payment Controller - Payment Auto Result Method : \n" . $e->getMessage()
    //         );
    //     }
    //         }
    //     }
    // }

    /**
     * Gets Moka payment result
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Payment $payment
     * @return \Illuminate\Contracts\View\View
     */
    public function payment_result(Request $request, Payment $payment)
    {
        try {
            $success = false;

            $data = $request->all();
        
            $trx_code = $data["trxCode"];
            
            $moka_transaction = $payment->mokaPayment;
            $moka_transaction->moka_trx_code = $trx_code;
            
            $moka_transaction->save();

            $moka_log = MokaLog::where('trx_code', $moka_transaction->trx_code)->first();
            $moka_log->moka_trx_code = $trx_code;
            $init_response = $moka_log->response['init'];
            $moka_log->response = [
                'init' => $init_response,
                'result' => $data
            ];
            
            $moka_log->save();

            if ($moka_transaction) {
                $moka = new Moka();
                $result = $moka->get_payment_detail_by_other_trx($moka_transaction->trx_code);

                $moka_log->response = [
                    'init' => $init_response,
                    'result' => $data,
                    'control' => $result
                ];
                $moka_log->save();
                
                if (
                    $result->Data->PaymentDetail->PaymentStatus == 2 &&
                    $result->Data->PaymentDetail->TrxStatus == 1
                ) {
                    $payment->receive([
                        'type' => 4
                    ]);

                    Telegram::send(
                        'RüzgarNETÖdeme',
                        trans('telegram.payment_received', [
                            'id_no' => $payment->subscription->customer->identification_number,
                            'full_name' => $payment->subscription->customer->full_name,
                            'price' => $payment->price,
                            'category' => $payment->subscription->service->category->name
                        ])
                    );



                    $success = true;
                }
               
            }

            return view('admin.response', ['response' => $success]);
        } catch (Exception $e) {
            Telegram::send(
                'Test',
                "Payment Controller - Payment Result Method : \n" . $e->getMessage()
            );
            echo "çıkmadı";
            return view('admin.response', ['response' => false]);
        }

    }

    /**
     * Create Moka payment instance for pre auth
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Payment $payment
     * @return \Illuminate\Http\JsonResponse
     */
    public function create_pre_auth(Request $request, Payment $payment)
    {
        $rules["card.number"] = [
            'required',
            'numeric'
        ];
        $rules["card.full_name"] = [
            'required',
            'string',
            'max:255'
        ];
        $rules["card.expire_date"] = [
            'required',
            'string'
        ];
        $rules["card.security_code"] = [
            'required',
            'string'
        ];

        $validated = $request->validate($rules);

        $expire = Mutator::expire_date($validated["card"]["expire_date"]);

        $card = [
            'full_name' => $validated["card"]['full_name'],
            'number' => $validated["card"]['number'],
            'expire_month' => $expire[0],
            'expire_year' => $expire[1],
            'security_code' => $validated['card']["security_code"],
            'amount' => 1
        ];

        $hash = [
            'subscription_no' => $payment->subscription->subscription_no,
            'payment_created_at' => $payment->created_at
        ];

        $moka_log = MokaLog::create([
            'payment_id' => $payment->id,
            'ip' => $request->ip(),
            'type' => 7,
            'response' => null,
            'trx_code' => null
        ]);

        $moka = new Moka();
        $response = $moka->pay(
            $card,
            route('payment.pre.auth.result', $moka_log),
            $hash,
            [
                'is_pre_auth' => 1,
                'pre_auth_price' => 1
            ]
        );

        if ($response->Data != null) {
            $moka_log->update([
                'response' => $response,
                'trx_code' => $moka->trx_code
            ]);

            return response()->json([
                'success' => true,
                'payment' => [
                    'frame' => $response->Data->Url
                ]
            ]);
        } else {
            return response()->json([
                'error' => true,
                'toastr' => [
                    'type' => 'error',
                    'title' => trans('response.title.error'),
                    'message' => $response->ResultCode
                ]
            ]);
        }
    }

    /**
     * Gets Moka payment result
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Payment $payment
     * @return void
     */
    public function payment_pre_auth_result(Request $request, MokaLog $moka_log)
    {
        // TODO Print result response
        $data = $request->all();

        if (isset($data["hashValue"])) {
            if (
                Moka::check_hash(
                    $data["hashValue"],
                    $moka_log->response["Data"]["CodeForHash"]
                )
            ) {
                return "Başarılı";
            }
            return "Başarısız";
        } else {
            return "Başarısız";
        }
    }

    /**
     * Update price
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Payment $payment
     * @return \Illuminate\Http\JsonResponse
     */
    public function price(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:511'
        ]);

        $data = [
            'payment_id' => $payment->id,
            'staff_id' => $request->user()->staff_id,
            'old_price' => $payment->price,
            'new_price' => $validated['price'],
            'description' => $validated['description']
        ];

        if ($payment->paid_at == null && $payment->edit_price($data)) {
            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.edit.success')
                ],
                'reload' => true
            ]);
        }

        return response()->json([
            'error' => true,
            'toastr' => [
                'type' => 'error',
                'title' => trans('response.title.error'),
                'message' => trans('response.edit.error')
            ]
        ]);
    }

    /**
     * Creates a new payment
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Subscription $subscription)
    {
        if ($request->input('is_lump_sum') != null) {
            $validated = $request->validate([
                'price' => 'required|numeric',
                'date' => 'required',
                'is_lump_sum' => 'required',
                'lump_sum_value' => 'required',
                'status' => 'required',
                'description' => 'required|string|max:511'
            ]);


            $customer_note=[
                'note' => $validated["lump_sum_value"].' adet toplu fatura oluşturuldu. Açıklama:  '.$validated["description"],
                'staff_id' => $request->user()->staff_id,
                'customer_id' => $subscription->customer_id
            ];
            CustomerNote::create($customer_note);

            $iteration = 0;
            for ($iteration = 0; $iteration < $validated["lump_sum_value"]; $iteration++) {
                $temporary = [
                    'subscription_id' => $subscription->id,
                    'price' => $validated['price'],
                    'date' => date('Y-m-15', strtotime($validated['date'] . ' + ' . ($iteration + 1) . ' month')),
                    'status' => $validated["status"],
                    'type' => null
                ];

                Payment::create($temporary);
            }

            return response()->json([
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'reload' => true
            ]);
        } else {
            $validated = $request->validate([
                'price' => 'required|numeric',
                'date' => 'required|date',
                'description' => 'required|string|max:511'
            ]);

            $validated['subscription_id'] = $subscription->id;
            $validated['staff_id'] = $request->user()->staff_id;

            if (PaymentCreate::createPayment($validated)) {
                return response()->json([
                    'success' => true,
                    'toastr' => [
                        'type' => 'success',
                        'title' => trans('response.title.success'),
                        'message' => trans('response.insert.success')
                    ],
                    'reload' => true
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
    }

    /**
     * Deletes a payment
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:511'
        ]);

        $error = null;
        $subscription = $payment->subscription;
        if ($subscription->approved_at == null)
            $error = trans('warnings.subscription.not_approved');

        if ($error) {
            return response()->json([
                'error' => true,
                'toastr' => [
                    'type' => 'error',
                    'title' => trans('response.title.error'),
                    'message' => $error
                ]
            ]);
        }

        $validated['staff_id'] = $request->user()->staff_id;

        if (PaymentDelete::deletePayment($payment, $validated)) {
            Telegram::send(
                "İptalİşlemler",
                trans(
                    "telegram.delete_payment",
                    [
                        "full_name" => $payment->subscription->customer->full_name,
                        "id_no" => $payment->subscription->customer->identification_number,
                        "payment_id" => $payment->id,
                        "description" => $validated["description"],
                        "username" => $request->user()->username
                    ]
                )
            );

            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.delete.success')
                ],
                'reload' => true
            ]);
        }

        return response()->json([
            'error' => true,
            'toastr' => [
                'type' => 'error',
                'title' => trans('response.title.error'),
                'message' => trans('response.delete.error')
            ]
        ]);
    }

    /**
     * Creates a new payment
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:511'
        ]);

        $validated['payment_id'] = $payment->id;
        $validated['staff_id'] = $request->user()->staff_id;

        if (PaymentCancellation::cancel($payment, $validated)) {
            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'reload' => true
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

    /**
     * Rules for validation
     *
     * @return array
     */
    private function rules()
    {
        return [
            'type' => [
                'required',
                Rule::in(Payment::getTypes())
            ]
        ];
    }
}
