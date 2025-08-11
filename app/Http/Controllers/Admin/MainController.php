<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\FaultRecord;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionCancellation;
use App\Models\SubscriptionChange;
use App\Models\SubscriptionFreeze;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    /**
     * Dashboard page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $dateofnot = Carbon::now()->format('d-m-Y');
        $dataNotReady = [
            'subsupgradesalti' => DB::table('subscriptions')
                ->join('services', 'subscriptions.service_id', '=', 'services.id')
                ->join('customers', 'customers.id', '=', 'subscriptions.customer_id')
                ->join('customer_staff', 'customers.id', '=', 'customer_staff.customer_id')
                ->join('staff', 'staff.id', '=', 'customer_staff.staff_id')
               
                ->whereDate('subscriptions.created_at', '=', today()) // Bugünkü veriler
                ->orderBy(DB::raw("subscriptions.created_at"), 'ASC')
                ->select(DB::raw('
                    customers.id AS customer_id,
                    CONCAT(customers.first_name, " ", customers.last_name) AS isim,
                    staff.first_name AS first_name,
                    staff.last_name AS last_name,
                    services.name AS name,
                    subscriptions.created_at AS created_at,
                    subscriptions.options AS Options,
                    subscriptions.status AS status,
                    subscriptions.price AS price,
                    subscriptions.id AS id,
                    subscriptions.staff_id AS staff_id,
                    staff.first_name AS temsilci
                '))
                ->get(),
        
        ];
            $cancelApplications = SubscriptionCancellation::whereDate('created_at', Carbon::today())->count();
           $subscriptionCount = Subscription::where('status', 1)
    ->whereRaw("DATE_FORMAT(approved_at, '%Y-%m-%d') = ?", [date('Y-m-d')])
    ->count();
        // Sayıyı hesapla
        $data = [
            'total' => [
                'nowdate' => $dateofnot,
                'cancelApp'=>$cancelApplications,
                'subsCount'=>$subscriptionCount,
                'newapplications' => $dataNotReady['subsupgradesalti']->count(),
                'customer' => Customer::whereDate('created_at', date('Y-m-d'))->count(),

                'subscription' => Subscription::where('status',1)->count(),
                'faultRecord' => FaultRecord::whereNotIn('status', [2,5, 3,6])->count(),
                'payment' => Payment::where('status', '2')
                    ->where('type', '<>', 6)
                    ->whereBetween('date', [date('Y-m-01'), date('Y-m-t')])
                    ->sum('price'),
                'notpaid' => Payment::where('status', '1')
                    ->where('date', date('Y-m-15'))
                    ->sum('price'),
                'notpaidcount' => Payment::where('status', '1')
                    ->where('date', date('Y-m-15'))
                    ->count(),
            ],
          'subscriptions' => Subscription::whereDate('created_at', date('Y-m-d'))
    ->orderByDesc('approved_at')
    ->limit(10)
    ->get()
        ];
        return view('admin.dashboard',$data,compact('dataNotReady'));

    }

    /**
     * Infrastructure page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function infrastructure()
    {
        return view('admin.infrastructure');
    }

    /**
     * Searchs customer
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function search(Request $request)
    {
        $search = $request->input("q");

        $customer = new Customer();
        $fields = $customer->getFields();
        $fields[] = DB::raw("CONCAT(`first_name`, ' ', `last_name`)");
        $rows = $customer->where(function ($query) use ($fields, $search) {
            foreach ($fields as $field) {
                $query->orWhere($field, 'LIKE', "%{$search}%");
            }
        })->limit(10)->get();

        $data = [];

        if (count($rows)) {
            foreach ($rows as $row) {
                $data[] = [
                    'title' => $row->select_print,
                    'link' => route('admin.customer.show', $row)
                ];
            }
        }

        return $data;
    }

    /**
     * Not permission page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function cant()
    {
        return view('admin.cant');
    }

    /**
     * Report Page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
 public function report(Request $request)
    {
        $date = Carbon::parse($request->input('date') ?? 'now');
        $date_string = $date->toDateString();
        $start_date = $date->startOfMonth()->toDateString();
        $newdate = $date->setDay('15')->toDateString();
        $end_date = $date->endOfMonth()->toDateString();
        $dates = [$start_date, $end_date];

        $nakit = Payment::selectRaw("SUM(price) AS price")->where('date',$newdate)->where('type',1)->get();
        $pos = Payment::selectRaw("SUM(price) AS price")->where('date',$newdate)->where('type',2)->get();
        $havale = Payment::selectRaw("SUM(price) AS price")->where('date',$newdate)->where('type',3)->get();

        $online = Payment::selectRaw("SUM(price) AS price")->where('date',$newdate)->where('type',4)->get();
        $otomatik = Payment::selectRaw("SUM(price) AS price")->where('date',$newdate)->where('type',5)->get();



        $payments = Payment::whereBetween('date', $dates)
            ->orderBy('type')
            ->get();


        $totals = [
            'price' => 0,
            'paided' => 0,
            'not_paided' => 0,
            'auto' => 0,
            'no_auto' => 0,
            'penalty_price' => 0,
            'penalty_price_paided' => 0,
            'penalty_price_not_paided' => 0,
        ];

        $subscriptions = [
            'customers' => Customer::count(),
            'subscriptions' => Subscription::count(),
        ];

        $statusKeys = [
            0 => 'unapproved',
            1 => 'active',
            2 => 'changed',
            3 => 'canceled',
            4 => 'freezed'
        ];

        $subscriptionStatus = array_merge([0], Subscription::getStatus());
        foreach ($subscriptionStatus as $status) {
            $subscriptions[$statusKeys[$status]] = Subscription::where('status', $status)->count();
        }

        $subscriptions_monthly = [
            'customers' => Customer::whereBetween('created_at', $dates)->count(),
            'subscriptions' => Subscription::whereBetween('created_at', $dates)->count(),
            'unapproved' => Subscription::whereBetween('created_at', $dates)->where('status', 0)->count(),
            'active' => Subscription::whereBetween('created_at', $dates)->where('status', 1)->count(),
            'changed' => SubscriptionChange::whereBetween('created_at', $dates)->count(),
            'canceled' => SubscriptionCancellation::whereBetween('created_at', $dates)->count(),
            'freezed' => SubscriptionFreeze::whereBetween('created_at', $dates)->count()
        ];

        $counts = [
            'payments' => 0,
            'auto' => 0,
            'paided' => 0,
            'not_paided' => 0,
            'penalty' => 0,
            'penalty_paided' => 0,
            'penalty_not_paided' => 0
            //'penalty_paided2' => 0
        ];

       $types = [
    0 => 0,
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0,
    7 => 0
];

$type_counts = [
    0 => 0,
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0,
    7 => 0
];

        $categoryTemp = [
            'totals' => [
                'price' => 0,
                'paided' => 0,
                'not_paided' => 0,
                'auto' => 0,
                'no_auto' => 0,
                'penalty_price' => 0,
                'penalty_price_paided' => 0,
                'penalty_price_not_paided' => 0,
            ],
            'counts' => [
                'payments' => 0,
                'auto' => 0,
                'paided' => 0,
                'not_paided' => 0,
                'penalty' => 0,
                'penalty_paided' => 0,
                'penalty_not_paided' => 0
                //'penalty_paided2' => 0,
            ],
            'types' => [
    0 => 0,
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0,
    7 => 0
],
'type_counts' => [
    0 => 0,
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0,
    7 => 0
]
        ];

        foreach ($payments as $payment) {
            $price = $payment->price;
            $category = $payment->category;
            $type = $payment->type ?? 0;

            if (!isset($categories[$category])) {
                $categories[$category] = $categoryTemp;
            }

            if ($payment->isPaid()) {
                
            if ($type != 6 && $type != 7) { // Exclude type 6 and type 7
                    $totals['paided'] += $price;
                    $counts['paided']++;
                    $categories[$category]['totals']['paided'] += $price;
                    $categories[$category]['counts']['paided']++;
                }

                if ($payment->isPenalty()) {
                    
                    $totals['penalty_price_paided'] += $payment->penalty->penalty_price;
                    $counts['penalty_paided']++;
                    $categories[$category]['totals']['penalty_price_paided'] += $payment->penalty->penalty_price;
                    $categories[$category]['counts']['penalty_paided']++;
                /*
                else if($payment->penalty->penalty_price==270.00){
                     $totals['penalty_price_paided'] += $payment->penalty->penalty_price;
                    $counts['penalty_paided2']++;
                    $categories[$category]['totals']['penalty_price_paided'] += $payment->penalty->penalty_price;
                    $categories[$category]['counts']['penalty_paided2']++;
                }
                 */   
                }
                
                
            } else {
                $totals['not_paided'] += $price;
                $counts['not_paided']++;
                $categories[$category]['totals']['not_paided'] += $price;
                $categories[$category]['counts']['not_paided']++;

                if ($payment->isPenalty()) {
                    $totals['penalty_price_not_paided'] += $payment->penalty->penalty_price;
                    $counts['penalty_not_paided']++;
                    $categories[$category]['totals']['penalty_price_not_paided'] += $payment->penalty->penalty_price;
                    $categories[$category]['counts']['penalty_not_paided']++;
                }
            }

            if ($payment->subscription->isAuto()) {
                $totals['auto'] += $price;
                $counts['auto']++;
                $categories[$category]['totals']['auto'] += $price;
                $categories[$category]['counts']['auto']++;
            } else {
                $totals['no_auto'] += $price;
                $categories[$category]['totals']['no_auto'] += $price;
            }


            if ($payment->isPenalty()) {
                $totals['penalty_price'] += $payment->penalty->penalty_price;
                $counts['penalty']++;
                $categories[$category]['totals']['penalty_price'] += $payment->penalty->penalty_price;
                $categories[$category]['counts']['penalty']++;
            }

            $types[$type] += $price;
        if ($type != 6 ) { // Exclude type 6 and type 7
                $totals['price'] += $price;
                $counts['payments']++;
            }

            $categories[$category]['types'][$type] += $price;
           if ($type != 6 ) { // Exclude type 6 and type 7
                $categories[$category]['totals']['price'] += $price;
                $categories[$category]['counts']['payments']++;
            }

            $type_counts[$type]++;
            $categories[$category]['type_counts'][$type]++;
        }

        foreach ($categories as $categoryKey => $values) {
            $category = Category::where('key', $categoryKey)->first();

            $service_ids = $category->services()->pluck('id')->toArray();
            $sub_ids = Subscription::whereIn('service_id', $service_ids)->pluck('id')->toArray();

            $categories[$categoryKey]['subscriptions']['subscriptions'] = Subscription::whereIn('service_id', $service_ids)->count();

            foreach ($subscriptionStatus as $status) {
                $categories[$categoryKey]['subscriptions'][$statusKeys[$status]] = Subscription::whereIn('service_id', $service_ids)->where('status', $status)->count();
            }

            $categories[$categoryKey]['subscriptions_monthly'] = [
                'subscriptions' => Subscription::whereIn('service_id', $service_ids)->whereBetween('created_at', $dates)->count(),
                'unapproved' => Subscription::whereIn('service_id', $service_ids)->whereBetween('created_at', $dates)->where('status', 0)->count(),
                'active' => Subscription::whereIn('service_id', $service_ids)->whereBetween('created_at', $dates)->where('status', 1)->count(),
                'changed' => SubscriptionChange::whereBetween('created_at', $dates)->count(),
                'canceled' => SubscriptionCancellation::whereBetween('created_at', $dates)->count(),
                'freezed' => SubscriptionFreeze::whereBetween('created_at', $dates)->count()
            ];
        }

        $totals['avarage'] = $totals['price'] / $subscriptions['active'];

        foreach ($categories as $key => $category) {
            $categories[$key]['totals']['avarage'] = $category['totals']['price'] / $category['subscriptions']['active'];
        }

        $totals['no_auto'] = $nakit[0]["price"]+$pos[0]["price"]+$havale[0]["price"];
        $totals['auto'] = $online[0]["price"]+$otomatik[0]["price"];
        return view('admin.report', [
            'reports' => compact('totals', 'counts', 'types', 'type_counts', 'subscriptions', 'subscriptions_monthly'),
            'categories' => $categories,
            'date' => $date_string
        ]);
    }


    public function cayma_bedeli(Subscription $subscription)
    {
        $now = date('Y-m-d');
        $commitment =  $subscription->commitment;
        $end_date = $subscription->end_date;

        $diff_time = Carbon::parse($end_date)->diffInMonths($now)-1;
        $used_time = $commitment-$diff_time;
        $phone = $subscription->customer->telephone;

        return view('admin.cayma_bedeli',[
            'used_time' => $used_time,
            'diff_time' => $diff_time,
            'phone' => $phone
        ]);
    }

}
