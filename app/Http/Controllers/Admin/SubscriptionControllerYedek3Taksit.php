<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Generator as Generator;
use App\Classes\Moka;
use App\Classes\Telegram;
use App\Classes\Messages;
use App\Http\Controllers\Controller;
use App\Models\SubscriptionCancellation;
use App\Models\Category;
use App\Models\SubscriptionChange;
use App\Models\Customer;
use App\Models\Message;
use App\Models\MokaAutoPaymentDisable;
use App\Models\Payment;
use App\Models\Reference;
use App\Models\SentMessage;
use App\Models\Service;
use App\Models\Subscription;
use App\Models\SubscriptionFreeze;
use App\Models\SubscriptionPriceEdit;
use App\Models\SubscriptionRenewal;
use App\Models\SubscriptionUpgrade;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Storage;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(int $status = null)
    {
        return view('admin.subscription.list', [
            'subscriptions' => Subscription::where('status', $status)->orderBy('id', 'DESC')->get(),
            'statuses' => trans('subscription.status'),
            'services' => Service::select('id', 'name')->get(),
            'status' => $status
        ]);
    }
    
    
        public function hazirlik()
    {
       
        $huriyes=DB::select("
        SELECT COUNT(subscriptions.id) as id FROM customers
		INNER JOIN subscriptions ON customers.id = subscriptions.customer_id
        INNER JOIN customer_staff ON customer_staff.customer_id = customers.id
        
        WHERE customer_staff.staff_id = '44'
        AND subscriptions.status = '0'
         ");
         
        $fatmas=DB::select("
        SELECT COUNT(subscriptions.id) as id FROM customers
		INNER JOIN subscriptions ON customers.id = subscriptions.customer_id
        INNER JOIN customer_staff ON customer_staff.customer_id = customers.id
        
        WHERE customer_staff.staff_id = '49'
        AND subscriptions.status = '0'
         ");
         
        $yunuss=DB::select("
        SELECT COUNT(subscriptions.id) as id FROM customers
		INNER JOIN subscriptions ON customers.id = subscriptions.customer_id
        INNER JOIN customer_staff ON customer_staff.customer_id = customers.id
        
        WHERE customer_staff.staff_id = '41'
        AND subscriptions.status = '0'
         ");
         
        $serkans=DB::select("
        SELECT COUNT(subscriptions.id) as id FROM customers
		INNER JOIN subscriptions ON customers.id = subscriptions.customer_id
        INNER JOIN customer_staff ON customer_staff.customer_id = customers.id
        
        WHERE customer_staff.staff_id = '53'
        AND subscriptions.status = '0'
         ");
         
        $gizems=DB::select("
        SELECT COUNT(subscriptions.id) as id FROM customers
		INNER JOIN subscriptions ON customers.id = subscriptions.customer_id
        INNER JOIN customer_staff ON customer_staff.customer_id = customers.id
        
        WHERE customer_staff.staff_id = '54'
        AND subscriptions.status = '0'
         ");
     
         $date = Carbon::parse('now');
        
        return view('admin.subscription.hazirlik', [

       // START 15 GÜN GÜNCELL        
            'subsupgradesalti' => DB::table('subscriptions')
          
            ->join('services','subscriptions.service_id','=','services.id')
            ->join('customers','customers.id','=','subscriptions.customer_id')
            ->join('customer_staff','customers.id','=','customer_staff.customer_id')
            ->join('staff','staff.id','=','customer_staff.staff_id')

             ->where('subscriptions.status','=',0)  
            //->where('subscriptions.id','=',8175)
           // ->where('subscriptions.end_date', 'like', "%2023-03-03%")
             // ->where('subscriptions.end_date', '=', date('Y-m-d',strtotime($date. ' +15 days')))
            //  ->where('subscriptions.end_date', '>=', date('Y-m-d',strtotime($date. ' +14 days')))
            //  ->where('subscription_renewals.created_at', '>=', date('Y-m-d',strtotime($date. '-32 days')))

               
              
             

               // ->whereNotNull('subscriptions.options','=','')

         
            ->orderBy(DB::raw("subscriptions.created_at"), 'ASC')
            // ->orderBy(DB::raw("staff.first_name"), 'DESC')->distinct()
            
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
            subscriptions.created_at AS created_at,
            subscriptions.options AS Options,
            subscriptions.status AS status,
            subscriptions.price AS price,
            
             subscriptions.id AS id,
             subscriptions.staff_id AS staff_id,
            staff.first_name AS temsilci'))
            ->get()
            
            
// END  15 GÜN GÜNCELLENEN 
        ],compact('huriyes','fatmas','yunuss','serkans','gizems'));
    }

    /**
     * Get a listing of the resource.
     *
     * @return array
     */
    public function list(Request $request)
    {
        $offset = $request->input('start');
        $limit = $request->input('length');
        $draw = $request->input('draw');
        $status = $request->input('columns.3.search.value');

        if ($status == "") {
            $subscriptions = Subscription::offset($offset)->limit($limit)->orderBy('id', 'desc')->get();
            $no = Subscription::orderBy('id', 'desc')->get();
        }
        else if ($status == "5") {
            $subscriptions = Subscription::offset($offset)->where("status", 1)->whereRaw('DATEDIFF(end_date,CURRENT_DATE()) <= 45')->limit($limit)->orderBy('id', 'desc')->get();
            $no = Subscription::where("status", $status)->orderBy('id', 'desc')->get();
        }
        else {
            $subscriptions = Subscription::offset($offset)->where("status", $status)->limit($limit)->orderBy('id', 'desc')->get();
            $no = Subscription::where("status", $status)->orderBy('id', 'desc')->get();
        }

        $data = [];
        foreach ($subscriptions as $subscription) {
            $html = '<div class="buttons">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button"
                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    ' . trans('fields.actions') . '
                </button>
                <div class="dropdown-menu dropdown-menu-right"
                    aria-labelledby="dropdownMenuButton">';

            if ($subscription->status == 0) {
                $html .= ' <a href="' . route('admin.subscription.edit', $subscription) . '"
                        class="dropdown-item">
                        <i class="dropdown-icon fas fa-edit"></i>
                        ' . trans('titles.edit') . '
                    </a>

                    <a target="_blank" class="dropdown-item"
                        href="' . route('admin.subscription.contract', $subscription) . '">
                        <i class="dropdown-icon fas fa-file-contract"></i>
                        ' . trans('fields.contract_preview') . '
                    </a>

                    <button type="button"
                        class="dropdown-item confirm-modal-btn"
                        data-action="' . relative_route('admin.subscription.approve.post', $subscription) . '"
                        data-modal="#approveSubscription">
                        <i class="dropdown-icon fas fa-check"></i>
                        ' . trans('titles.approve') . '
                    </button>

                    <button type="button"
                        class="dropdown-item confirm-modal-btn"
                        data-action="' . relative_route('admin.subscription.delete', $subscription) . '"
                        data-modal="#delete">
                        <i class="dropdown-icon fas fa-trash"></i>
                        ' . trans('titles.delete') . '
                    </button>';
            }
            if ($subscription->approved_at) {
                $html .= '<a href="' . route('admin.subscription.payments', $subscription) . '"
                    class="dropdown-item">
                    <i class="dropdown-icon fas fa-file-invoice"></i>
                    ' . trans('tables.payment.title') . '
                </a>';
            }

            if (!$subscription->isChangedNew()) {
                $html .= '<a target="_blank" class="dropdown-item"
                    href="/contracts/' . $subscription->contract_path . '">
                    <i class="dropdown-icon fas fa-file-contract"></i>
                    ' . trans('fields.contract') . '
                </a>';
            }

            $html .= '</div>
                </div>
            </div>';

            $status_html = '<div class="buttons">';
            if ($subscription->isCanceled()) {
                $status_html .= '<button type="button" class="btn btn-danger btn-sm"
                data-toggle="popover" data-html="true"
                data-content="<b>Tarih:</b>' . convert_date($subscription->cancellation->created_at, 'large') . '<br>
                <b>Personel</b>: ' . $subscription->cancellation->staff->full_name . '<br>
                <b>Sebep</b>: ' . $subscription->cancellation->description . '">
                ' . trans('titles.cancel') . '
                </button>';
            }

            if ($subscription->isChanged()) {
                $status_html .= '<a class="btn btn-info btn-sm" title="' . trans('fields.changed_service') . '"
                    href="' . route('admin.subscription.payments', $subscription->getChanged()) . '">
                    ' . $subscription->getChanged()->service->name . '
                </a>';
            }

            if ($subscription->isFreezed()) {
                $status_html .= '<button type="button" class="btn btn-warning btn-sm"
                    data-toggle="popover" data-html="true"
                    data-content="<b>Tarih:</b>' . convert_date($subscription->freeze->created_at, 'large') . '<br>
                    <b>Personel</b>: {{ $subscription->freeze->staff->full_name }} <br>
                    <b>Sebep</b>: {{ $subscription->freeze->description }}">
                    ' . trans('titles.freezed') . '
                </button>';
            }

            if (!$subscription->approved_at) {
                $status_html .= '<button type="button" class="btn btn-secondary">
                    ' . trans('titles.unapproved') . '
                </button>';
            }

            if ($subscription->isChangedNew()) {
                $status_html .= '<button type="button" class="btn btn-info">
                    ' . trans('fields.changed_service') . '
                </button>';
            }

            $status_html .= '</div>';

            $data[] = [
                0 => $subscription->id,
                1 => '<a href="' . route('admin.customer.show', $subscription->customer_id) . '">' . $subscription->customer->full_name . '</a>',
                2 => $subscription->service->name,
                3 => $status_html,
                4 => print_money($subscription->price),
                5 => convert_date($subscription->start_date, 'medium') . "-" . convert_date($subscription->end_date, 'medium'),
                6 => $subscription->staff->full_name ?? "-",
                7 => $html
            ];
        }

        $data = array(
            'draw' => $draw,
            'recordsTotal' => Subscription::all()->count(),
            'recordsFiltered' => $no->count(),
            'data' => $data
        );

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.subscription.add', $this->viewData());
    }

    /**
     * Undocumented function
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function preview(Subscription $subscription)
    {
        if(in_array($subscription->commitment, [0, 12]))
            $subscription->service->price += 10;

        $devices = $subscription->getOption("devices") ?? null;
        if (!$subscription->approved_at)
            $subscription->generatePayments();
        $array = (array) $subscription;
        
        

        $pdf = Pdf::loadView("pdf.contract.{$subscription->service->category->contractType->view}", [
            'subscription' => $subscription,
            'barcode' => Generator::barcode($subscription->subscription_no),
            'devices' => $devices
        ]);
        return $pdf->stream();
    }
    
    
    public function preview1(Subscription $subscription)
    {
        if(in_array($subscription->commitment, [0, 12]))
            $subscription->service->price += 10;

           $devices = $subscription->getOption("devices") ?? null;
        if (!$subscription->approved_at)
            $subscription->generatePayments();

        $pdf = Pdf::loadView("pdf.contract.{$subscription->service->category->contractType->view}", [
            'subscription' => $subscription,
            'barcode'      => Generator::barcode($subscription->subscription_no),
            'devices'      => $devices
        ]);
        return $pdf->stream();
    } 
    
    
    
    public function generatePDF(Subscription $subscription)
    {
        
          if(in_array($subscription->commitment, [0, 12]))
            $subscription->service->price += 10;

           $devices = $subscription->getOption("devices") ?? null;
        if (!$subscription->approved_at)
            $subscription->generatePayments();

        $pdf = Pdf::loadView("pdf.contract.ruzgarfiber_churn", [
            'subscription' => $subscription,
            'barcode'      => Generator::barcode($subscription->subscription_no),
            'devices'      => $devices
        ]);
         $firstname = "mnt_8856_churn_". $subscription->customer->first_name.'_'.$subscription->customer->last_name;
         return $pdf->stream($firstname.'.pdf');

    }
    
     public function generatePDF2(Subscription $subscription)
    {
        
          if(in_array($subscription->commitment, [0, 12]))
            $subscription->service->price += 10;

           $devices = $subscription->getOption("devices") ?? null;
        if (!$subscription->approved_at)
            $subscription->generatePayments();

        $pdf = Pdf::loadView("pdf.contract.ruzgarfiber_nakil", [
            'subscription' => $subscription,
            'barcode'      => Generator::barcode($subscription->subscription_no),
            'devices'      => $devices
        ]);
        $firstname = "nakil_". $subscription->customer->first_name.'_'.$subscription->customer->last_name.'.pdf';
         return $pdf->stream($firstname);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $rules = array_merge($this->rules(), $this->optionRules());
        $validated = $request->validate($rules);
        //$validated['options']['il_disi']= $request['options']['il_disi'];



        

/* MODEM KİRA BEDELİ */
// TAAHHÜT SÜRESİ 3 AY OLANLAR MODEM KİRA BEDELİ 50TL
// TAAHHÜT SÜRESİ 3 AY'A EŞİT OLMAYAN MODEM KİRA BEDELİ 40TL
// 1=>YOK - 2=>ADSL - 3=>VDSL - 4=>Fiber - 5=>Uydu Modemi - 6=>3G veya 4.5G Modem - 7=>Kendi Modemi
        if($validated['commitment'] == 3 || $validated['commitment'] == 4 ){
              if($validated['options']['modem'] == 2 || $validated['options']['modem'] == 3){
                $validated['options']['modem_price'] = 50;
            }else if($validated['options']['modem'] == 4){
                $validated['options']['modem_price'] = 60;
            }else if($validated['options']['modem'] == 5){
                $validated['options']['modem_price'] = 50;
            }
            else if($validated['options']['modem'] == 6){
                $validated['options']['modem_price'] = 50;
            }
            else if($validated['options']['modem'] == 7){
                $validated['options']['modem_price'] = 0;
            }else if($validated['options']['modem'] == 1){
                $validated['options']['modem_price'] = 0;
            }  
        }
        elseif($validated['commitment'] == 12){
            if($validated['options']['modem'] == 2 || $validated['options']['modem'] == 3){
                $validated['options']['modem_price'] = 50;
            }else if($validated['options']['modem'] == 4){
                $validated['options']['modem_price'] = 60;
            }else if($validated['options']['modem'] == 5){
                $validated['options']['modem_price'] = 50;
            }
            else if($validated['options']['modem'] == 6){
                $validated['options']['modem_price'] = 50;
            }
            else if($validated['options']['modem'] == 7){
                $validated['options']['modem_price'] = 0;
            }else if($validated['options']['modem'] == 1){
                $validated['options']['modem_price'] = 0;
            } 
        }
        else{
            if($validated['options']['modem'] == 2 || $validated['options']['modem'] == 3){
                $validated['options']['modem_price'] = 50;
            }else if($validated['options']['modem'] == 4){
                $validated['options']['modem_price'] = 60;
            }else if($validated['options']['modem'] == 5){
                $validated['options']['modem_price'] = 50;
            }
            else if($validated['options']['modem'] == 6){
                $validated['options']['modem_price'] = 50;
            }
            else if($validated['options']['modem'] == 7){
                $validated['options']['modem_price'] = 0;
            }else if($validated['options']['modem'] == 1){
                $validated['options']['modem_price'] = 0;
            }
        }

/* --MODEM KİRA BEDELİ */

        if($validated["service_id"] == 183 || $validated["service_id"] == 184 ){
            //$validated['options']['modem_price'] = $validated['options']['modem_price'] + 10 ;
            if($validated['options']['modem'] == 4){
                $validated['options']['modem_price'] = 25;
            }
        }
        
        if($validated["service_id"] == 189 || $validated["service_id"] == 190 ){
            //$validated['options']['modem_price'] = $validated['options']['modem_price'] + 10 ;
            if($validated['options']['modem'] == 4){
                $validated['options']['modem_price'] = 60;
            }
        }
        
        if($validated["service_id"] == 187 || $validated["service_id"] == 188 ){
            //$validated['options']['modem_price'] = $validated['options']['modem_price'] + 10 ;
            if($validated['options']['modem'] == 4){
                $validated['options']['modem_price'] = 60;
            }
        }
        
         if($validated["service_id"] == 185 || $validated["service_id"] == 186 ){
            //$validated['options']['modem_price'] = $validated['options']['modem_price'] + 10 ;
            if($validated['options']['modem'] == 4){
                $validated['options']['modem_price'] = 60;
            }
        }
        
        if($validated["service_id"] == 66 || $validated["service_id"] == 80 ){
            $validated['options']['modem_price'] = $validated['options']['modem_price'] + 10 ;
            if($validated['options']['modem'] == 1 || $validated['options']['modem'] == 7){
                $validated['options']['modem_price'] = 0;
            }
        }

        if($validated["service_id"] == 81 ){
            $validated['options']['modem_price'] = $validated['options']['modem_price'] + 5 ;
            if($validated['options']['modem'] == 1 || $validated['options']['modem'] == 7){
                $validated['options']['modem_price'] = 0;
            }
        }
        if($validated["service_id"] == 82 ){
            $validated['options']['modem_price'] = 50;
            if($validated['options']['modem'] == 1 || $validated['options']['modem'] == 7){
                $validated['options']['modem_price'] = 0;
            }
        }
        if($validated['service_id'] == 72 || $validated['service_id'] == 73){
            if($validated['options']['modem'] == 5)
            {
                $validated['options']['modem_price'] = 50;
            }
        }
        /*
            
        */

        $validated['staff_id'] = $request->user()->staff_id;

        if ($validated["commitment"] == 0 ) {
            $validated["price"] += 10;
        }
        if ($validated["commitment"] == 6  ) {
            if($validated["service_id"] == 67 || $validated["service_id"] == 69 || $validated["service_id"] == 80 ){
                $validated["price"] = $validated["price"];
            }else{
                $validated["price"] += 0;
            }
        }
        if ($validated['commitment'] > 0) {
            $date = new DateTime($validated['start_date']);
            $date->modify("+{$validated['commitment']} month");
            $validated['end_date'] = $date->format('Y-m-d');
        } else {
            $validated['end_date'] = null;
        }

        $reference_id = null;
        if (isset($validated['reference_id']) && $validated['reference_id'] != null) {
            $reference_id = $validated['reference_id'];
        }
        unset($validated['reference_id']);

        $validated["subscription_no"] = Generator::subscriptionNo();

        if ($subscription = Subscription::create($validated)) {

            $data_upgrade = [
                'subscription_id' => $subscription->id,
                'status' => 0
            ];
            SubscriptionUpgrade::create($data_upgrade);

            if ($reference_id) {
                $data = [
                    'reference_id' => $reference_id,
                    'referenced_id' => $subscription->id
                ];

                Reference::create($data);

            }

            $staff = DB::table('customer_staff')->select('staff_id')->where('customer_id',$subscription->customer->id)->get();

            $staff_id = $staff[0]->staff_id;
            $role_id = DB::table('users')->select('role_id')->where('staff_id',$staff_id)->get();

            if ($role_id[0]->role_id != 3) {
                $staff_id = DB::table('customer_staff')
                ->selectRaw('COUNT(*) AS count, staff_id')->whereRaw("staff_id IN (SELECT staff_id FROM users WHERE role_id = 3)")->groupBy('staff_id')->orderByRaw('COUNT(*)')->first()->staff_id;

                DB::table('customer_staff')->where('customer_id',$subscription->customer->id)
            ->update(['staff_id' => $staff_id]);
            }

            Telegram::send(
                'AboneTamamlanan',
                trans(
                    'telegram.add_subscription',
                    [
                        'full_name' => $subscription->customer->full_name,
                        'id_no' => $subscription->customer->identification_number,
                        'username' => $subscription->staff->full_name,
                        'customer_staff' => $subscription->customer->staff->full_name,
                        'service' => $subscription->service->name
                    ]
                )
            );

            return response()->json([
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.subscriptions')
            ]);
        }
  
        return response()->json([
            'toastr' => [
                'type' => 'error',
                'title' => trans('response.title.error'),
                'message' => trans('response.insert.error')
            ]
        ]);
    }

    /**
     * Cancel auto payment
     *
     * @param \App\Models\Subscription $subscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel_auto_payment(Subscription $subscription)
    {
        $auto_payment = $subscription->getAuto();
        $auto_payment->disabled_at = DB::raw('current_timestamp()');

        $moka = new Moka();
        $moka->remove_card($auto_payment->moka_card_token);

        if ($auto_payment->save()) {
            if (!$subscription->isAutoPenalty()) {
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

            return response()->json([
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.edit.success')
                ],
                'reload' => true
            ]);
        }

        return response()->json([
            'toastr' => [
                'type' => 'error',
                'title' => trans('response.title.error'),
                'message' => trans('response.edit.error')
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Subscription $subscription)
    {
        $devices = $subscription->getOption("devices") ?? [];
        $data = array_merge(
            $this->viewData(),
            [
                'subscription' => $subscription,
                'devices' => $devices
            ]
        );

        return view('admin.subscription.edit', $data);
    }
    
    
    public function edit1(Subscription $subscription)
    {
        $devices = $subscription->getOption("devices") ?? [];
        $data = array_merge(
            $this->viewData(),
            [
                'subscription' => $subscription,
                'devices' => $devices
            ]
        );

        return view('admin.subscription.edit1', $data);
    }
    
    public function edit2(Subscription $subscription)
    {
        $devices = $subscription->getOption("devices") ?? [];
        $data = array_merge(
            $this->viewData(),
            [
                'subscription' => $subscription,
                'devices' => $devices
            ]
        );

        return view('admin.subscription.edit2', $data);
    }
    
    public function hizmetno(Subscription $subscription)
    {
        $devices = $subscription->getOption("devices") ?? [];
        $data = array_merge(
            $this->viewData(),
            [
                'subscription' => $subscription,
                'devices' => $devices
            ]
        );

        return view('admin.subscription.hizmetno', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Subscription $subscription)
    {
        if ($subscription->approved_at) {
            return response()->json([
                'error' => true,
                'toastr' => [
                    'type' => 'error',
                    'title' => trans('response.title.error'),
                    'message' => trans('warnings.approved.subscription')
                ]
            ]);
        }

        $rules = array_merge($this->rules(), $this->optionRules());
        $validated = $request->validate($rules);
  //$validated['options']['il_disi']= $request['options']['il_disi'];

        if ($validated['commitment'] > 0) {
            $date = new DateTime($validated['start_date']);
            $date->modify("+{$validated['commitment']} month");
            $validated['end_date'] = $date->format('Y-m-d');
        } else {
            $validated['end_date'] = null;
        }

        if (
            !in_array($subscription->commitment, [0, 12]) &&
            in_array($validated["commitment"], [0, 12])
        ) {
            $validated["price"] += 10;
        } else if (
            in_array($subscription->commitment, [0, 12]) &&
            !in_array($validated["commitment"], [0, 12])
        ) {
            $validated["price"] -= 10;
        }

        $reference_id = null;
        if (isset($validated['reference_id']) && $validated['reference_id'] != null) {
            $reference_id = $validated['reference_id'];
        }
        unset($validated['reference_id']);

        if ($subscription->update($validated)) {
            if ($reference_id != null) {
                Reference::where('referenced_id', $subscription->id)->delete();

                $data = [
                    'reference_id' => $reference_id,
                    'referenced_id' => $subscription->id
                ];

                Reference::create($data);
            }

            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.edit.success')
                ],
                'redirect' => relative_route('admin.subscriptions')
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
    

    
     public function update1(Request $request, $subscription)
  {
       
       $subscription= Subscription::findOrFail($subscription);

       $subscription->service_id=$request->service_id;
       $subscription->customer_id=$request->customer_id;
       
       $subscription->start_date=$request->start_date;
       $subscription->price=$request->price;
       
       $subscription->payment=$request->payment;

      
       $subscription->verici=$request->verici;
       $subscription->alici=$request->alici;
       
       $subscription->xdsl_tel=$request->xdsl_tel;
       $subscription->xdsl_hizmet=$request->xdsl_hizmet;
       
      

        $subscription->save();
       // alert()->success('Başarılı!', 'Sayfanız Başarılı Bir Şekilde Güncellendi.');
         // return redirect()->route('admin.task.edit');
         
         
          return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.edit.success')
                ],
                  'redirect' => relative_route('admin.customer.show', $subscription->customer)
            ]);
            
  }
  
       public function update2(Request $request, $subscription)
  {
       
       $subscription= Subscription::findOrFail($subscription);

       $subscription->service_id=$request->service_id;
       $subscription->customer_id=$request->customer_id;
       
       $subscription->start_date=$request->start_date;
       $subscription->price=$request->price;
       
       $subscription->payment=$request->payment;

      
       $subscription->nakil_yeni_adres=$request->nakil_yeni_adres;
       $subscription->nakil_eski_adres=$request->nakil_yeni_adres;
       
       $subscription->nakil_tasima_tarih=$request->nakil_tasima_tarih;

       
      

        $subscription->save();
       // alert()->success('Başarılı!', 'Sayfanız Başarılı Bir Şekilde Güncellendi.');
         // return redirect()->route('admin.task.edit');
         
         
          return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.edit.success')
                ],
                 'redirect' => relative_route('admin.customer.show', $subscription->customer)
            ]);
            
  }
  
  
    public function hizmetnoupdate(Request $request, $subscription)
  {
       
       $subscription= Subscription::findOrFail($subscription);

       $subscription->service_id=$request->service_id;
       $subscription->customer_id=$request->customer_id;
       
       $subscription->start_date=$request->start_date;
       $subscription->price=$request->price;
       
       $subscription->payment=$request->payment;

      
       $subscription->hizmet_no=$request->hizmet_no;


        $subscription->save();
       // alert()->success('Başarılı!', 'Sayfanız Başarılı Bir Şekilde Güncellendi.');
         // return redirect()->route('admin.task.edit');
         
         
          return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.edit.success')
                ],
                 'redirect' => relative_route('admin.customer.show', $subscription->customer)
            ]);
            
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Subscription $subscription) // sonradan eklenen Request $request,
    {  
        //sonradan eklenen  start
       // $validated = $request->validate([
          //  'description' => 'required|string|max:511',
       // ]);
        //sonradan eklenen end
        
        
        if ($subscription->approved_at) {
            return response()->json([
                'error' => true,
                'toastr' => [
                    'type' => 'error',
                    'title' => trans('response.title.error'),
                    'message' => trans('warnings.approved.subscription')
                ]
            ]);
        }


        if ($subscription->delete()) {

            Telegram::send(
                'İptalİşlemler',
                trans(
                    "telegram.delete_subscription",
                    [
                        'full_name' => $subscription->customer->full_name,
                        'tarife' => $subscription->service->name,
                       // 'description' => $validated["description"], //sonradan eklenen description
                        'user_name' => request()->user()->username
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
     * Approve subscription
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function approve(Subscription $subscription)
    {
        if ($subscription->approved_at) {
            return response()->json([
                'error' => true,
                'toastr' => [
                    'type' => 'error',
                    'title' => trans('response.title.error'),
                    'message' => trans('warnings.approved.subscription')
                ]
            ]);
        }

        if ($subscription->approve_subscription()) {
            SentMessage::insert([
                [
                    'customer_id' => $subscription->customer->id,
                    'message_id' => 10
                ],
                [
                    'customer_id' => $subscription->customer->id,
                    'message_id' => 11
                ]
            ]);

            SentMessage::insert([
                /* 1 Gün Sobra REFERANS KODU MESAJI
                [
                    'customer_id' => $subscription->customer->id,
                    'message_id' => 12,
                    'delivery_date' => date('Y-m-d 11:00', strtotime(' +1 day '))
                ],
                */
                [
                    'customer_id' => $subscription->customer->id,
                    'message_id' => 13,
                    'delivery_date' => date('Y-m-d 11:00', strtotime(' +1 week '))
                ]
            ]);

            $pdf = Pdf::loadView("pdf.contract.{$subscription->service->category->contractType->view}", [
                'subscription' => $subscription,
                'device_brand' => 'Huawei',
                'device_model' => 'HGS',
                'barcode' => Generator::barcode($subscription->subscription_no),
                'devices' => $subscription->getOption("devices") ?? []
            ]);
            $path = "contracts/" . $subscription->contract_path;
            if (!file_exists(public_path('contracts'))) {
                mkdir(public_path('contracts'), 0755, true);
            }
            $pdf->save($path);

            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.approve.subscription'),
                    'message' => trans('response.approve.subscription.success')
                ],
                'reload' => true
            ]);
        }

        return response()->json([
            'error' => true,
            'toastr' => [
                'type' => 'error',
                'title' => trans('response.title.approve.subscription'),
                'message' => trans('response.approve.subscription.error')
            ]
        ]);
    }

    /**
     * Approve subscription
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function unApprove(Subscription $subscription)
    {
        if ($subscription->unapprove_subscription()) {
            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.approve.subscription'),
                    'message' => trans('response.approve.subscription.success')
                ],
                'reload' => true
            ]);
        }
    }

    /**
     * Show subscription payments
     *
     * @param Subscription $subscription
     * @return \Illuminate\Contracts\View\View
     */
    public function payments(Subscription $subscription)
    {
        $data = [
            'paymentTypes' => Payment::getTypes(),
            'subscription' => $subscription,
            'statuses' => trans('tables.payment.status'),
            'types' => trans('tables.payment.types')
        ];
        return view('admin.subscription.payment', $data);
    }

    /**
     * Show payments
     *
     * @param Payment $payment
     * @return \Illuminate\Contracts\View\View
     */
    public function get_payments(Payment $payment)
    {
        $data = [
            'paymentTypes' => Payment::getTypes(),
            'subscription' => $payment->subscription,
            'statuses' => trans('tables.payment.status'),
            'types' => trans('tables.payment.types')
        ];
        return view('admin.subscription.payment', $data);
    }

    /**
     * Update price
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function price(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:511',
            'end_date' => 'required|after:today'
        ]);

        $data = [
            'subscription_id' => $subscription->id,
            'staff_id' => $request->user()->staff_id,
            'old_price' => $subscription->price,
            'new_price' => $validated['price'],
            'end_date' => $validated['end_date'],
            'description' => $validated['description']
        ];

        if (SubscriptionPriceEdit::edit_price($subscription, $data)) {
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Contracts\View\View
     */
    public function change(Subscription $subscription)
    {
        $data = [
            'subscription' => $subscription,
            'services' => Service::where('status', 1)->get()
        ];

        return view('admin.subscription.change', $data);
    }

    /**
     * Change service
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function upgrade(Request $request, Subscription $subscription)
    {

        $service=Service::where('id',$request['service_id'])->get();
        $pricecontrol = $service[0]["price"];


        $validated = $request->validate([
            'service_id' => [
                'required',
                Rule::exists('services', 'id')->where(function ($query) {
                    return $query->where('status', 1);
                })
            ],
            'date' => 'required|date',
            'end_date' => 'required|date',
            'price' => "required|numeric|min:$pricecontrol",
            'payment' => 'required|numeric|min:0',
        ]);

        $error = null;

        if ($subscription->approved_at == null)
            $error = trans('warnings.subscription.not_approved');
        if ($subscription->isCanceled())
            $error = trans('warnings.subscription.already_canceled');
        if ($subscription->isChanged())
            $error = trans('warnings.subscription.changed');
        if ($subscription->isEnded())
            $error = trans('warnings.subscription.ended');
        if ($subscription->isFreezed())
            $error = trans('warnings.subscription.freezed');
        if ($validated['service_id'] == $subscription->service_id)
            $error = trans('warnings.subscription.cant_change_same_service');

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

        if (SubscriptionChange::change($subscription, $validated)) {

            $changedSubs = Subscription::orderByDesc("id")->first();

            $message = Message::find(46);
                $message->message = $message->message;

                SentMessage::insert(
                    [
                        'customer_id' => $subscription->customer->id,
                        'message' => (new Messages)->generate(
                            $message->message,
                            [
                                'service' => $changedSubs->service->name,
                                'price' => $changedSubs->price
                            ]
                        )
                    ]
                );

            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.subscription.change.success')
                ],
                'redirect' => relative_route('admin.customer.show', $subscription->customer)
            ]);
        }

        return response()->json([
            'error' => true,
            'toastr' => [
                'type' => 'error',
                'title' => trans('response.title.error'),
                'message' => trans('response.subscription.change.error')
            ]
        ]);
    }

    /**
     * Cancel subscription
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:511',
        ]);

        $error = null;

        if ($subscription->approved_at == null)
            $error = trans('warnings.subscription.not_approved');
        if ($subscription->isCanceled())
            $error = trans('warnings.subscription.already_canceled');
        if ($subscription->isChanged())
            $error = trans('warnings.subscription.changed');
        if ($subscription->isEnded())
            $error = trans('warnings.subscription.ended');

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
        $validated['subscription_id'] = $subscription->id;

        if (SubscriptionCancellation::cancel($subscription, $validated)) {
            // TODO Change group for production
            // FIXME Named groups
            Telegram::send(
                'İptalİşlemler',
                trans(
                    "telegram.cancel_subscription",
                    [
                        'full_name' => $subscription->customer->full_name,
                        'id_no' => $subscription->customer->identification_number,
                        'description' => $validated["description"],
                        'username' => $request->user()->username
                    ]
                )
            );

            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.subscription.cancel.success')
                ],
                'reload' => true
            ]);
        }

        return response()->json([
            'error' => true,
            'toastr' => [
                'type' => 'error',
                'title' => trans('response.title.error'),
                'message' => trans('response.subscription.cancel.error')
            ]
        ]);
    }

    /**
     * Freeze subscription
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function freeze(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:511',
        ]);

        $error = null;

        if ($subscription->approved_at == null)
            $error = trans('warnings.subscription.not_approved');
        if ($subscription->isCanceled())
            $error = trans('warnings.subscription.canceled');
        if ($subscription->isChanged())
            $error = trans('warnings.subscription.changed');
        if ($subscription->isEnded())
            $error = trans('warnings.subscription.ended');
        if ($subscription->isFreezed())
            $error = trans('warnings.subscription.already_freezed');

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
        $validated['subscription_id'] = $subscription->id;

        if (SubscriptionFreeze::freeze($subscription, $validated)) {
            Telegram::send(
                'İptalİşlemler',
                trans('telegram.add_freeze', [
                    'full_name' => $subscription->customer->full_name,
                    'subscription' => $subscription->service->name,
                    'username' => $request->user()->staff->full_name
                ])
            );

            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.subscription.cancel.success')
                ],
                'reload' => true
            ]);
        }

        return response()->json([
            'error' => true,
            'toastr' => [
                'type' => 'error',
                'title' => trans('response.title.error'),
                'message' => trans('response.subscription.cancel.error')
            ]
        ]);
    }

    /**
     * Unfreeze subscription
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function unFreeze(Request $request, Subscription $subscription)
    {
        $error = null;

        if ($subscription->approved_at == null)
            $error = trans('warnings.subscription.not_approved');
        if ($subscription->isCanceled())
            $error = trans('warnings.subscription.canceled');
        if ($subscription->isChanged())
            $error = trans('warnings.subscription.changed');
        if ($subscription->isEnded())
            $error = trans('warnings.subscription.ended');
        if (!$subscription->isFreezed())
            $error = trans('warnings.subscription.not_freezed');

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

        $staff_id = $request->user()->staff_id;

        if (SubscriptionFreeze::unFreeze($subscription, $staff_id)) {
            Telegram::send(
                'İptalİşlemler',
                trans('telegram.unfreeze', [
                    'full_name' => $subscription->customer->full_name,
                    'subscription' => $subscription->service->name,
                    'username' => $request->user()->staff->full_name
                ])
            );

            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.subscription.cancel.success')
                ],
                'reload' => true
            ]);
        }

        return response()->json([
            'error' => true,
            'toastr' => [
                'type' => 'error',
                'title' => trans('response.title.error'),
                'message' => trans('response.subscription.cancel.error')
            ]
        ]);
    }

    /**
     * Data for view
     *
     * @return array
     */
    private function viewData()
    {
        $categories = Category::where('status', 1)->where('type', 2)->get();

        $option_fields = [];
        foreach ($categories as $category) {
            $option_fields[$category->key] = $category->option_fields;
        }

        $services = Service::where('status', 1)->get();

        $service_props = [];
        foreach ($services as $service) {
            $service_props[$service->id] = [
                'price' => $service->price,
                'category' => $service->category->key
            ];
        }

        $data = [
            'services' => Service::where('status', 1)->orderByRaw('name * 1')->get(),
            'customers' => Customer::where('type', '<>', 1)->orderBy('id', 'DESC')->get(),
            'subscriptions' => Subscription::whereIn('status',[0,1,2])->orderBy('id', 'DESC')->get(),
            'option_fields' => $option_fields,
            'service_props' => $service_props
        ];

        return $data;
    }

    /**
     * Renewal subscription
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function renewal(Request $request, Subscription $subscription)
    {
        $error = null;

        if ($subscription->approved_at == null)
            $error = trans('warnings.subscription.not_approved');
        if ($subscription->isCanceled())
            $error = trans('warnings.subscription.canceled');
        if ($subscription->isChanged())
            $error = trans('warnings.subscription.changed');
        if ($subscription->isEnded())
            $error = trans('warnings.subscription.ended');

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

        $price = $request->validate(['price' => 'required|numeric'])['price'];
        $new_commitment = $request->validate(['new_commitment' => 'required'])['new_commitment'];
        $staff_id = $request->user()->staff_id;

        if (SubscriptionRenewal::renewal($subscription, $staff_id, $new_commitment, $price)) {
            Telegram::send(
                'SözleşmesiSonaErecekler',
                trans('telegram.subscription_renewal_price', [
                    'full_name' => $subscription->customer->full_name,
                    'id_no' => $subscription->customer->identification_number,
                    'subscription' => $subscription->service->name,
                    'staff' => $request->user()->staff->full_name,
                    'price' => $price
                ])
            );

            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.subscription.renewal.success')
                ],
                'reload' => true
            ]);
        }

        return response()->json([
            'error' => true,
            'toastr' => [
                'type' => 'error',
                'title' => trans('response.title.error'),
                'message' => trans('response.subscription.renewal.error')
            ]
        ]);
    }

    /**
     * End commitment of subscription
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function end_commitment(Request $request, Subscription $subscription)
    {
        $error = null;

        if ($subscription->approved_at == null)
            $error = trans('warnings.subscription.not_approved');
        if ($subscription->isCanceled())
            $error = trans('warnings.subscription.canceled');
        if ($subscription->isChanged())
            $error = trans('warnings.subscription.changed');
        if ($subscription->isEnded())
            $error = trans('warnings.subscription.ended');
        if ($subscription->isEnding() > 10)
            $error = trans('warnings.subscription.commitment_end_last_ten_day');

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

        $subscription->status = 5;

        if ($subscription->save()) {
            $subscription->payments()->where('type', '!=', 2)->delete();
            SubscriptionRenewal::where('status', 0)->where('subscription_id', $subscription->id)->update(['status' => 3]);
            Telegram::send(
                'SözleşmesiSonaErecekler',
                trans('telegram.subscription_end_commitment', [
                    'full_name' => $subscription->customer->full_name,
                    'id_no' => $subscription->customer->identification_number,
                    'subscription' => $subscription->service->name,
                    'staff' => $request->user()->staff->full_name
                ])
            );

            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.subscription.end_commitment.success')
                ],
                'reload' => true
            ]);
        }

        return response()->json([
            'error' => true,
            'toastr' => [
                'type' => 'error',
                'title' => trans('response.title.error'),
                'message' => trans('response.subscription.end_commitment.error')
            ]
        ]);
    }
    
    public function extendSubscribersEndDate(Request $request)
    {
        $date = $request->input('date') ? Carbon::createFromFormat('Y-m-d', $request->input('date'))->startOfDay() : Carbon::now();
        $convertedDate = date('Y-m-d', strtotime($date));
        
        //Girilen tarihte aboneliği bitenler
        
        $missedSubscribers = DB::table('subscriptions')
        ->join('customers', 'subscriptions.customer_id', '=', 'customers.id')
        ->join('services', 'subscriptions.service_id', '=', 'services.id')
        ->where('subscriptions.status', '=', 1)
        ->where('subscriptions.end_date', '=', $convertedDate)
        ->select(DB::raw('
                  subscriptions.id as subscription_id,    
                  customers.id as customer_id,    
                  customers.first_name as customer_first_name,
                  customers.last_name as customer_last_name,
                  customers.telephone as customer_tel,
                  services.name as service_name,
                  subscriptions.commitment as commitment,
                  subscriptions.end_date as end_date
        '))        
        ->get();
        //print_r($left30days);
        

        return view('admin.subscription.check_for_extendibles', ['missedSubscribers'=> $missedSubscribers, 'convertedDate' => $convertedDate]);    
    }
    
    public function updateSubscribersEndDate(Request $request)
    {
        //echo $request->updateDate." ".$request->subscription_id;
        $convertedDate = date('Y-m-d', strtotime($request->updateDate));
        $affected = DB::table('subscriptions')
              ->where('id', $request->subscription_id)
              ->update(['end_date' => $convertedDate]);
        $nextMonth = Carbon::now()->addMonth()->format('Y-m-15');
        $doesExistNextMonth = DB::table('payments')->select(DB::raw("*"))->where('payments.subscription_id', '=', $request->subscription_id)->where('payments.date', '=', $nextMonth)->get();
        $price = DB::table('subscriptions')
              ->select(DB::raw("price"))->where('id', $request->subscription_id)->get()->toArray();
        $currentPrice = $price[0]->price;

        if(count($doesExistNextMonth) == 0)
        {
            DB::table('payments')->insert([
                'subscription_id' => $request->subscription_id,
                'date' => $nextMonth,
                'price' => $currentPrice,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        return redirect()->route('admin.subscription.extend_subscribers_end_date', ['date' => $request->previous_date]);

    }
    
    public function subscriberStatistics(Request $request)
    {
        /*
        SELECT first_name, last_name, telephone, `subscriptions`.`approved_at` FROM `customers` 
        INNER JOIN `subscriptions` ON `customers`.`id`=`subscriptions`.`customer_id` WHERE `subscriptions`.`status`=1 
        AND `subscriptions`.`approved_at` >= '2023-08-15 00:00:00' AND `subscriptions`.`approved_at` <= '2023-09-30 23:59:00';
        */
        if(!$request->has('first_date') && !$request->has('end_date'))
        {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now();
            //DB transactions can be started from there.
            //$startDate = Carbon::parse('2023-08-15 00:00:00');
            //$endDate = Carbon::parse('2023-09-30 23:59:00');
            $subscribers = DB::table('customers')->join('subscriptions', 'subscriptions.customer_id', '=', 'customers.id')
                       ->join('services', 'services.id', '=', 'subscriptions.service_id')   
                       ->join('staff', 'subscriptions.staff_id', '=', 'staff.id')
            ->select(
                DB::raw('customers.first_name AS first_name,
                         customers.last_name AS last_name,
                         customers.telephone AS telephone,
                         services.name AS service_name,
                         subscriptions.approved_at AS approved_at,
                         CONCAT(staff.first_name, " ", staff.last_name) AS staffs_full_name
            '))
            ->where('subscriptions.status', '=', 1)
            ->where('subscriptions.approved_at', '>=', $startDate)
            ->where('subscriptions.approved_at', '<=', $endDate)
            ->get();
            //print_r($results);
            //echo count($results);
            $staffIds =  DB::table('customers')->join('subscriptions', 'subscriptions.customer_id', '=', 'customers.id')
                       ->join('services', 'services.id', '=', 'subscriptions.service_id')   
                       ->join('staff', 'subscriptions.staff_id', '=', 'staff.id')
            ->select('staff.id')
            ->distinct()
            ->where('subscriptions.status', '=', 1)
            ->where('subscriptions.approved_at', '>=', $startDate)
            ->where('subscriptions.approved_at', '<=', $endDate)
            ->get()->toArray();
            \DB::statement("SET SQL_MODE=''");
            $staffs = DB::table('customers')->join('subscriptions', 'subscriptions.customer_id', '=', 'customers.id')
                                       ->join('services', 'services.id', '=', 'subscriptions.service_id')   
                                       ->join('staff', 'subscriptions.staff_id', '=', 'staff.id')
                                        ->select(
            DB::raw('customers.first_name AS first_name,
                                     customers.last_name AS last_name,
                                     customers.telephone AS telephone,
                                     services.name AS service_name,
                                     subscriptions.approved_at AS approved_at,
                                     CONCAT(staff.first_name, " ", staff.last_name) AS staffs_full_name,
                                     staff.id as staff_id
                        '))
            ->where('subscriptions.status', '=', 1)
            ->where('subscriptions.approved_at', '>=', $startDate)
            ->where('subscriptions.approved_at', '<=', $endDate)
            ->groupBy('staff.id')
            ->get();            
                        
                                    $nameArray = array();
                                    foreach($staffs as $staff)
                                    {
                                        // Tarih aralığını gelince ayarla...
                                         $groupedSubsNumber = DB::table('subscriptions')
                                         ->select('subscriptions.approved_at', DB::raw('count(*)'))
                                         ->where('subscriptions.staff_id', '=', $staff->staff_id)
                                         ->where('subscriptions.approved_at', '>=', $startDate)
                                         ->where('subscriptions.approved_at', '<=', $endDate)
                                         ->groupBy('subscriptions.start_date')
                                         ->get();
                                         
                                        Storage::disk('local')->append("grouped.txt", print_r($groupedSubsNumber, true));
                                    }               
            
            

            
            
            
            
            
            
            
            //$staffIds= json_decode( json_encode($staffIds), true);
            DB::disconnect(DB::connection()->getDatabaseName());
            return view('admin.subscription.statistics', ['subscribers' => $subscribers,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'numberOfSubscribers' => $subscribers->count(),
                'staff' => $staffs,
                'nameArray' => $nameArray
            ]);
        }
        else
        {
            //$request->input('date') ? Carbon::createFromFormat('Y-m-d', $request->input('date'))->startOfDay()->toDateString()
            //$startDate = Carbon::parse('2023-08-15 00:00:00');
            //$endDate = Carbon::parse('2023-09-30 23:59:00');
            //$startDate = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('first_date'))->startOfDay()->toDateString();
            //$endDate = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('end_date'))->endOfDay()->toDateString();
         
            $startDate = Carbon::parse($request->input('first_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
            $diffInDays = $startDate->diffInDays($endDate);
            //echo $diffInDays;
            
            
            if($diffInDays < 100)
            {
            $subscribers = DB::table('customers')->join('subscriptions', 'subscriptions.customer_id', '=', 'customers.id')
                       ->join('services', 'services.id', '=', 'subscriptions.service_id')   
                       ->join('staff', 'subscriptions.staff_id', '=', 'staff.id')
                        ->select(
                            DB::raw('customers.first_name AS first_name,
                                     customers.last_name AS last_name,
                                     customers.telephone AS telephone,
                                     services.name AS service_name,
                                     subscriptions.approved_at AS approved_at,
                                     CONCAT(staff.first_name, " ", staff.last_name) AS staffs_full_name
                        '))
                        ->where('subscriptions.status', '=', 1)
                        ->where('subscriptions.approved_at', '>=', $startDate)
                        ->where('subscriptions.approved_at', '<=', $endDate)
                        ->get();
                            //print_r($results);
                            //echo count($results);
                            
                            \DB::statement("SET SQL_MODE=''");
                            $staffs = DB::table('customers')->join('subscriptions', 'subscriptions.customer_id', '=', 'customers.id')
                                       ->join('services', 'services.id', '=', 'subscriptions.service_id')   
                                       ->join('staff', 'subscriptions.staff_id', '=', 'staff.id')
                                        ->select(
                            DB::raw('customers.first_name AS first_name,
                                     customers.last_name AS last_name,
                                     customers.telephone AS telephone,
                                     services.name AS service_name,
                                     subscriptions.approved_at AS approved_at,
                                     CONCAT(staff.first_name, " ", staff.last_name) AS staffs_full_name,
                                     staff.id as staff_id
                                     
                        '))
                        ->where('subscriptions.status', '=', 1)
                        ->where('subscriptions.approved_at', '>=', $startDate)
                        ->where('subscriptions.approved_at', '<=', $endDate)
                        ->groupBy('staff.id')
                        ->get();
                                    $nameArray = array();
                                    foreach($staffs as $staff)
                                    {
                                        // Tarih aralığını gelince ayarla...
                                         $groupedSubsNumber = DB::table('subscriptions')
                                         ->select('subscriptions.approved_at', DB::raw('count(*)'))
                                         ->where('subscriptions.staff_id', '=', $staff->staff_id)
                                         ->where('subscriptions.approved_at', '>=', $startDate)
                                         ->where('subscriptions.approved_at', '<=', $endDate)
                                         ->groupBy('subscriptions.start_date')
                                         ->get();
                                         
                                        Storage::disk('local')->append("grouped.txt", print_r($groupedSubsNumber, true));
                                    }               
                                    
                                                                        
                    
                
                    DB::disconnect(DB::connection()->getDatabaseName());
                    return view('admin.subscription.statistics', ['subscribers' => $subscribers,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                        'numberOfSubscribers' => $subscribers->count(),
                        "staff" => $staffs,
                        'nameArray' => $nameArray
                    ]);
            }
            
        }
            
    }

    /**
     * Rules for validation
     *
     * @return array
     */
    private function rules()
    {
        return [
            'service_id' => [
                'required',
                Rule::exists('services', 'id')->where(function ($query) {
                    return $query->where('status', 1);
                })
            ],
            'customer_id' => [
                'required',
                Rule::exists('customers', 'id')->where(function ($query) {
                    return $query->where('type', '<>', 1);
                })
            ],
            'start_date' => 'required|date',
            'price' => 'required|numeric',
            'options.address' => 'nullable|string|max:255',
            'reference_id' => [
                'nullable',
                Rule::exists('subscriptions', 'id')
            ],
        ];
    }

    /**
     * Rules for service's options
     *
     * @return array
     */
    private function optionRules()
    {
        $optionRules = [];

        if (request()->input('service_id')) {
            $service = Service::find(request()->input('service_id'));
            $options = $service->category->options;

            if (request()->input('options.modem') && in_array(request()->input('options.modem'), [2, 3, 4])) {
                $optionRules['bbk_code'] = [
                    'required',
                    'string',
                    'max:255'
                ];
            } else {
                $optionRules['bbk_code'] = [
                    'nullable',
                    'string',
                    'max:255'
                ];
            }

            foreach ($options as $key => $value) {
                if ($key == 'modem_serial') {
                    if (request()->input('options.modem') && in_array(request()->input('options.modem'), [2, 3, 5, 6, 7])) {
                        $optionRules['options.devices.modem_brand.*'] = [
                            'nullable',
                            'string',
                            'max:255'
                        ];
                        $optionRules['options.devices.modem_serial.*'] = [
                            'nullable',
                            'string',
                            'max:255'
                        ];
                        $optionRules['options.devices.modem_model.*'] = [
                            'nullable',
                            'string',
                            'max:255'
                        ];
                    }
                }else if ($key == 'il_disi') {
                    $optionRules['options.il_disi'] = [
                        'nullable',
                        'boolean'
                    ];
                } else if ($key == 'pre_payment') {
                    $optionRules['options.pre_payment'] = [
                        'nullable',
                        'boolean'
                    ];
                }else if ($key == 'modem_price' && request()->input("options.modem") != 1) {
                    $optionRules["options.modem_price"] = [
                        'required',
                        'numeric'
                    ];
                } else if ($key == 'modem_model') {
                    if (in_array(request()->input("options.modem"), [2, 3, 5,7])) {
                        $values = json_decode(setting("service.modems"), true);
                        $data = [];
                        foreach ($values as $item) {
                            $data[] = $item["value"];
                        }
                        $optionRules["options.modem_model"] = [
                            'required',
                            Rule::in($data)
                        ];
                    }
                } else if (is_array($value)) {
                    $option = (string)Str::of($key)->singular();
                    if ($option != 'commitment') {
                        $option = "options.{$option}";
                    }

                    $optionRules[$option] = [
                        'required',
                        Rule::in($value)
                    ];
                }
            }
        }

        return $optionRules;
    }
}
