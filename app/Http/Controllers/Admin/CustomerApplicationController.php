<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Telegram;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\CustomerApplication;
use App\Models\Subscription;
use App\Models\SubscriptionCancellation;
use App\Models\CustomerApplicationType;
use App\Models\Staff;
use Illuminate\Http\Request;

class CustomerApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $date = Carbon::parse('now');
        return view('admin.customer-application.list', ['customer_applications' => CustomerApplication::
            where('customer_applications.created_at', '>=', date('Y-m-d',strtotime($date. ' -60 days')))
            ->orderBy('customer_applications.id','DESC')
            ->get()]);
    }
    
       public function index1()
    {
        $date = Carbon::parse('now');
        return view('admin.customer-application.iptal', ['customer_applications' => CustomerApplication::
            
            where(function ($query) {
                $query->where('customer_applications.customer_application_type_id', '=' ,'1')
                      ->orWhere('customer_applications.customer_application_type_id', '=' ,'5');
            }) ->where('customer_applications.status', '=' ,'1')
                ->orderBy('customer_applications.id','DESC')
                ->where('customer_applications.created_at', '>=', date('Y-m-d',strtotime($date. ' -8 days')))->get()]); 
    }
  public function cancelapp(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $startDate = $startDate ? Carbon::parse($startDate) : Carbon::today()->startOfDay();
    $endDate = $endDate ? Carbon::parse($endDate) : Carbon::today()->endOfDay();

    $query = SubscriptionCancellation::with([
        'subscription' => function($query) {
            $query->orderBy('created_at', 'desc');
        },
        'subscription.service',
        'subscription.customer',
        'subscription.customer.staffs',
        'staff'
    ])
    ->whereBetween('subscription_cancellations.created_at', [$startDate, $endDate])
    ->orderBy('id', 'DESC');

    // AJAX isteği ise JSON olarak paginated veriyi döndür
    if ($request->ajax()) {
        $cancelApplications = $query->paginate(100); // her sayfada 10 kayıt
        return response()->json($cancelApplications);
    }

    // Normal view dönüşü (sayfa yüklendiğinde ilk hali)
    $cancelApplications = $query->paginate(100); // ilk yüklemede de paginate lazım
    return view('admin.cancel.appcancel', compact('cancelApplications', 'startDate', 'endDate'));
}
    
    public function subsentercompany(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $startDate = $startDate ? Carbon::parse($startDate) : Carbon::today()->startOfDay();
    $endDate = $endDate ? Carbon::parse($endDate) : Carbon::today()->endOfDay();

    $query = Subscription::with([
        'customer' => function ($q) {
            $q->with('staffs');
        },
        'service'
    ])
      ->where('status', 1)
    ->whereBetween('subscriptions.approved_at', [$startDate, $endDate])
    ->orderBy('id', 'DESC');

    if ($request->ajax()) {
        $subscriptions = $query->paginate(100);

        // Her subscription için customer, customer.staffs ve services bilgilerini formatla
        $formatted = $subscriptions->map(function ($sub) {
            return [
                'id' => $sub->id,
                'created_at' => $sub->created_at->toDateTimeString(),
                'cus_id' => $sub->customer_id,
                'stat' => $sub->status,
                'customer_name' => $sub->customer ? $sub->customer->first_name . ' ' . $sub->customer->last_name : null,
              'staff_names' => $sub->customer && $sub->customer->staffs
    ? $sub->customer->staffs->map(function ($s) {
        return $s->first_name . ' ' . $s->last_name;
    })->toArray()
    : [],
               'service_name' => optional($sub->service)->name
            ];
        });

        return response()->json([
            'data' => $formatted,
            'pagination' => [
                'total' => $subscriptions->total(),
                'per_page' => $subscriptions->perPage(),
                'current_page' => $subscriptions->currentPage(),
                'last_page' => $subscriptions->lastPage(),
            ]
        ]);
    }

    $subscriptions = $query->paginate(100);
    return view('admin.newcus.newcustable', compact('subscriptions', 'startDate', 'endDate'));
}

    
      public function index2()
    {
        $date = Carbon::parse('now');
        return view('admin.customer-application.yonlendirme', ['customer_applications' => CustomerApplication::where('customer_applications.customer_application_type_id', '=' ,'1')
            ->where('customer_applications.status', '=' ,'5')
            ->orderBy('customer_applications.id','DESC')
            ->where('customer_applications.updated_at', '>=', date('Y-m-d',strtotime($date. ' -8 days')))->get()]); 
    }
    
      public function index3()
    {
        $date = Carbon::parse('now');
        return view('admin.customer-application.yonlendirme2', ['customer_applications' => CustomerApplication::where('customer_applications.customer_application_type_id', '=' ,'1')
            ->where('customer_applications.status', '=' ,'3')
            ->orderBy('customer_applications.id','DESC')
            ->where('customer_applications.updated_at', '>=', date('Y-m-d',strtotime($date. ' -8 days')))->get()]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customer-application.add', [
            'staffs' => Staff::all(),
            'statuses' => trans(
                'tables.customer_application.status'
            ),
            'customer_application_types' => CustomerApplicationType::all(),
            'customers' => Customer::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->rules();
        $customer_id = $request->input('customer_id');
        if (!$request->input('customer_id')) {
            $rules['first_name'] = 'required';
            $rules['last_name'] = 'required';
            $rules['telephone'] = 'required';
            $customer_id = null;
        } else {
            $rules['customer_id'] = 'required';
        }

        $validated = $request->validate($rules);
        $request = [];
        if ($customer_id == null) {
            $request["information"] = [
                'first_name' => $validated["first_name"],
                'last_name' => $validated["last_name"],
                'telephone' => $validated["telephone"]
            ];
            $validated["customer_id"] = null;
        } else {
            $request["information"] = json_encode([]);
        }

        $request["staff_id"] = $validated["staff_id"];
        $request["customer_id"] = $validated["customer_id"];
        $request["status"] = $validated["status"];
        $request["customer_application_type_id"] = $validated["customer_application_type_id"];
        $request["description"] = $validated["description"];
        $request["staff_id"] = $validated["staff_id"];
        $request["files"] = "[]";

        if ($customer_application = CustomerApplication::create($request)) {
            if ($validated["customer_application_type_id"] == 1) {
                if ($validated["customer_id"] == null) {
                    Telegram::send(
                        "İptal Başvuru",
                        trans(
                            'telegram.application_cancel',
                            [
                                'full_name' => $customer_application->information["first_name"] . " " . $customer_application->information["last_name"],
                                'telephone' => $customer_application->information["telephone"]
                            ]
                        )
                    );
                } else {
                    Telegram::send(
                        "İptal Başvuru",
                        trans(
                            'telegram.application_cancel',
                            [
                                'full_name' => $customer_application->customer->full_name,
                                'telephone' => $customer_application->customer->telephone
                            ]
                        )
                    );
                }
            } else if ($validated["customer_application_type_id"] == 2) {
                if ($validated["customer_id"] == null) {
                    Telegram::send(
                        "KaliteKontrolEkibi",
                        "[TARİFE YÜKSELTME] \nAdı Soyadı : " . $customer_application->information["first_name"] . " " . $customer_application->information["last_name"] . "\nTelefon Numarası : " . $customer_application->information["telephone"]
                    );
                } else {
                    Telegram::send(
                        "KaliteKontrolEkibi",
                        "[TARİFE YÜKSELTME] \nAdı Soyadı : " . $customer_application->customer->full_name . "\nTelefon Numarası : " . $customer_application->customer->telephone
                    );
                }
            } else if ($validated["customer_application_type_id"] == 3) {
                if ($validated["customer_id"] == null) {
                    Telegram::send(
                        "BizSiziArayalım",
                        trans(
                            'telegram.application_subscription',
                            [
                                'full_name' => $customer_application->information["first_name"] . " " . $customer_application->information["last_name"],
                                'telephone' => $customer_application->information["telephone"],
                                'username' => $customer_application->staff->full_name
                            ]
                        )
                    );
                } else {
                    Telegram::send(
                        "BizSiziArayalım",
                        trans(
                            'telegram.application_subscription',
                            [
                                'full_name' => $customer_application->customer->full_name,
                                'telephone' => $customer_application->customer->telephone,
                                'username' => $customer_application->staff->full_name
                            ]
                        )
                    );
                }
            }
            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.customer.applications')
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
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerApplication  $customerApplication
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerApplication $customerApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerApplication  $customerApplication
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerApplication $customerApplication)
    {
        return view('admin.customer-application.edit', [
            'customer_application' => $customerApplication,
            'staffs' => Staff::all(),
            'statuses' => trans(
                'tables.customer_application.status'
            ),
            'customer_application_types' => CustomerApplicationType::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerApplication  $customerApplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerApplication $customerApplication)
    {
        $rules = $this->rules();
        $rules["status"] = 'required';
        $validated = $request->validate($rules);

        if ($customerApplication->update($validated)) {
            if ($validated["customer_application_type_id"] == 1)
            {


                Telegram::send(
                    "İptal Başvuru",
                    trans(
                        'telegram.application_cancel_update',
                        [
                            'full_name' => $customerApplication->customer->first_name . " " . $customerApplication->customer->last_name,
                            'telephone' => $customerApplication->customer->telephone,
                            'status' =>  trans('tables.customer_application.status.' . $customerApplication->status) ,
                            'staff_name' => $customerApplication->staff->first_name,
                            'description' => $customerApplication->description
                        ]
                    )
                );

            }
            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.edit.success')
                ],
                'redirect' => relative_route('admin.customer.applications')
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerApplication  $customerApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerApplication $customerApplication)
    {
        //
    }

    public function rules()
    {
        return [
            'staff_id' => 'required',
            'customer_application_type_id' => 'required',
            'status' => 'required',
            'description' => 'required|max:512',
            'customer_application_type_id' => 'required',  
            'searchStatus' => 'required', //<!-- searchStatus  -->
        ];
    }
}
