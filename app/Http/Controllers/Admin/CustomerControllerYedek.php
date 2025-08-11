<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Classes\Mutator;
use App\Classes\Messages;
use app\Models\SentMessage;
use App\Models\City;
use App\Models\Customer;
use App\Models\MokaPayment;
use App\Models\CustomerDocument;
use App\Models\Subscription;
use App\Models\Payment;
use App\Models\Staff;
use App\Rules\AvailableDistrict;
use App\Rules\TCNo;
use App\Rules\Telephone;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.customer.list', ['customers' => Customer::orderBy('id', 'DESC')->get()]);
    }
     
     
    public function mochacontrols()
    {    
        
        //$date = Carbon::parse('now');
        
        $bugun = Carbon::now()->subMonth(1);
        $yil = $bugun->year;
        $ay = $bugun->format('m');

        return view('admin.mokacontrol.mochacontrols',
                    ['customers' => Customer::
                         join('subscriptions','customers.id','=','subscriptions.customer_id')
                        ->join('payments','subscriptions.id','=','payments.subscription_id')
                        ->join('moka_payments','payments.id','=','moka_payments.payment_id')
                        
                         ->whereYear('moka_payments.created_at', '=', $yil)
                         ->whereMonth('moka_payments.created_at', '=', $ay)
                         //->whereMonth('moka_payments.created_at', '=', date('m', strtotime($date)))
                         ->where('payments.status','=',2)
                         ->where('payments.type','>=',4)

                         
                         ->orderBy(DB::raw("moka_payments.created_at"), 'DESC')
                        ->select(DB::raw('
                          customers.id as id,
                          moka_payments.created_at as created_at,
                          payments.price as price,
                          moka_payments.trx_code as trx_code ,
                          customers.first_name as first_name,
                          customers.last_name as last_name
                          '))->get()
                    ],

                    ['trxcodes' => MokaPayment::
                         join('payments','moka_payments.payment_id','=','payments.id')
                        ->join('subscriptions','payments.subscription_id','=','subscriptions.id')
                        ->join('customers','subscriptions.customer_id','=','customers.id')
                        
                         ->whereYear('moka_payments.created_at', '=', $yil)
                         ->whereMonth('moka_payments.created_at', '=', $ay)
                         //->whereMonth('moka_payments.created_at', '=', date('m', strtotime($date)))
                         ->where('payments.status','=',2)
                         ->where('payments.type','>=',4)

                         
                         ->orderBy(DB::raw("moka_payments.created_at"), 'DESC')
                        ->select(DB::raw('
                          customers.id as id,
                          moka_payments.created_at as created_at,
                          payments.price as price,
                          moka_payments.trx_code as trx_code ,
                          customers.first_name as first_name,
                          customers.last_name as last_name
                          '))->get() 
                    ]
              );
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
        $search = $request->input('search');

        if ($search["value"]) {
            $customers = Customer::where("first_name", "LIKE", $search["value"] . "%")->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();
            $no = Customer::where("first_name", "LIKE", $search["value"] . "%")->orderBy('id', 'desc')->get();
        } else {
            $customers = Customer::offset($offset)->limit($limit)->orderBy('id', 'desc')->get();
            $no = Customer::orderBy('id', 'desc')->get();
        }

        $data = [];
        foreach ($customers as $customer) {
            $data[] = [
                0 => $customer->id,
                1 => $customer->identification_number,
                2 => $customer->full_name,
                3 => $customer->telephone,
                4 => $customer->customerInfo->city->name,
                5 => $customer->staff->full_name,
                6 => '<div class="buttons">
                    <a href="' . route('admin.customer.edit', $customer) . '"
                        class="btn btn-primary" title="' . trans('title.edit') . '">
                        <i class="fas fa-edit"></i>
                    </a>

                    <a href="' . route('admin.customer.show', $customer) . '"
                        class="btn btn-primary" title="' . trans('title.show') . '">
                        <i class="fas fa-file"></i>
                    </a>
                </div>'
            ];
        }

        $data = [
            'draw' => $draw,
            'recordsTotal' => Customer::all()->count(),
            'recordsFiltered' => $no->count(),
            'data' => $data
        ];

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.customer.add', ['cities' => City::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->input('telephone')) {
            $request->merge([
                'telephone' => Mutator::phone($request->input('telephone'))
            ]);
        }

        if ($request->input('secondary_telephone')) {
            $request->merge([
                'secondary_telephone' => Mutator::phone($request->input('secondary_telephone'))
            ]);
        }


        $validated = $request->validate($this->rules());

        if ($customer = Customer::add_data($validated)) {
            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.customers')
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
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Customer $customer)
    {
        $data = [
            'paymentTypes' => Payment::getTypes(),
            'customer' => $customer,
            'subscriptions'=>Subscription::orderBy('id', 'DESC')->get(),
            "customer_documents" => CustomerDocument::join('customers','customer_documents.customer_id','=','customers.id')->where('customer_id')->get(),
            'statuses' => Payment::getStatus()
        ];
        
        return view('admin.customer.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Customer $customer)
    {
        return view('admin.customer.edit', ['customer' => $customer, 'cities' => City::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Customer $customer)
    {
        if ($request->input('telephone')) {
            $request->merge([
                'telephone' => Mutator::phone($request->input('telephone'))
            ]);
        }

        if ($request->input('secondary_telephone')) {
            $request->merge([
                'secondary_telephone' => Mutator::phone($request->input('secondary_telephone'))
            ]);
        }

        $rules = $this->rules();

        // Ignored uniques
        //$rules['email']['unique']                 = Rule::unique('customers', 'email')->ignore($customer->id);
        $rules['telephone']['unique']             = Rule::unique('customers', 'telephone')->ignore($customer->id);
        $rules['secondary_telephone']['unique']   = Rule::unique('customer_info', 'secondary_telephone')->ignore($customer->customerInfo->id);
        $rules['identification_number']['unique'] = Rule::unique('customers', 'identification_number')->ignore($customer->id);

        $validated = $request->validate($rules);

        if ($customer->update_data($validated)) {
            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.edit.success')
                ],
                'redirect' => relative_route('admin.customers')
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
     * Rules for validation
     *
     * @return array
     */
    private function rules()
    {
        return [
            'first_name' => 'required|max:63',
            'last_name' => 'required|max:63',
            'gender' => 'required',
            'birthday' => 'required|date',
            'address' => 'required|max:255',
            'email' => 'required',
            'city_id' => 'required|exists:cities,id',
            'district_id' => [
                'required',
                new AvailableDistrict('city_id')
            ],

            'identification_number' => [
                'required',
                new TCNo,
                'unique' => Rule::unique('customers', 'identification_number')
            ],
            'telephone' => [
                'required',
                new Telephone,
                'unique' => Rule::unique('customers', 'telephone')
            ],
            'secondary_telephone' => [
                'required',
                new Telephone
            ]
        ];
    }

    /**
     * Update customer's type to approve
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function approve(Customer $customer)
    {
        if ($customer->approve()) {
            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.approve.customer'),
                    'message' => trans('response.approve.customer.success')
                ],
                'reload' => true
            ]);
        }

        return response()->json([
            'error' => true,
            'toastr' => [
                'type' => 'error',
                'title' => trans('response.title.approve.customer'),
                'message' => trans('response.approve.customer.error')
            ]
        ]);
    }
}
