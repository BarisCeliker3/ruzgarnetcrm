<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Generator;
use App\Classes\Messages;
use App\Classes\Telegram;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\FaultRecord;
use App\Models\FaultType;
use App\Models\Message;
use App\Models\SentMessage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class FaultRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $faultRecords = DB::table('fault_records')->join('customers', 'fault_records.customer_id', '=', 'customers.id')
                                  ->join('customer_staff', 'customer_staff.customer_id', '=', 'customers.id')
                                  ->join('customer_info', 'customer_info.customer_id', '=', 'customers.id')
                                  ->join('cities', 'cities.id', '=', 'customer_info.city_id')
                                  ->join('staff', 'customer_staff.staff_id', '=', 'staff.id')
                                  ->join('fault_types', 'fault_records.fault_type_id', '=', 'fault_types.id')
                                  ->select(DB::raw(
                                      'fault_records.id as id,
                                       customers.id as customer_id,
                                       CONCAT(customers.first_name, " ", customers.last_name) as customer_full_name,
                                       CONCAT(staff.first_name, " ", staff.last_name) as staff_full_name,
                                       fault_types.title as title,
                                       fault_records.description as description,
                                       fault_records.status as status,
                                       cities.name as city_name,
                                       fault_records.updated_at as updated_at,
                                       customers.id as customer_id
                                      '
                                      ))->get();
        
        
        return view('admin.fault-record.list', [
            'faultRecords' => $faultRecords
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.fault-record.add', [
            'customers' => Customer::where('customers.type', '!=', 0)->join('subscriptions', 'subscriptions.customer_id', 'customers.id')->distinct()->get('customers.*'),
            'faultTypes' => FaultType::where('status', 1)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
     public function actives (){
           $faultRecords = DB::table('fault_records')
        ->join('customers', 'fault_records.customer_id', '=', 'customers.id')
        ->join('customer_staff', 'customer_staff.customer_id', '=', 'customers.id')
        ->join('customer_info', 'customer_info.customer_id', '=', 'customers.id')
        ->join('cities', 'cities.id', '=', 'customer_info.city_id')
        ->join('staff', 'customer_staff.staff_id', '=', 'staff.id')
        ->join('fault_types', 'fault_records.fault_type_id', '=', 'fault_types.id')
        ->select(DB::raw('
            fault_records.id as id,
            customers.id as customer_id,
            CONCAT(customers.first_name, " ", customers.last_name) as customer_full_name,
            CONCAT(staff.first_name, " ", staff.last_name) as staff_full_name,
            fault_types.title as title,
            fault_records.description as description,
            fault_records.status as status,
            cities.name as city_name,
            fault_records.updated_at as updated_at,
            customers.id as customer_id
        '))
         ->whereNotIn('fault_records.status', [2, 3, 5, 6])
        ->orderBy('fault_records.updated_at', 'desc') // Güncelden eskiye doğru sıralama
        ->limit(100) // 100 kayıtla sınırlı
        ->get();
        
        
        return view('admin.fault-record.list', [
            'faultRecords' => $faultRecords
        ]);
     }
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules() + ['files.*' => 'required|file|image', 'description' => 'required|string']);
        $files = [];
        $validated["serial_number"] = Generator::serialNumber();

        if ($request->input('files')) {
            foreach ($request->input('files') as $key => $file) {
                $files[] = str_replace("public/", "", $request->file('files.' . $key)->store('public/files'));
            }
        }

        $customer = Customer::find($validated["customer_id"]);

        Telegram::send(
            "R端zgarTeknik",
            trans(
                'telegram.add_fault_record',
                [
                    'id_no' => $customer->identification_number,
                    'full_name' => $customer->full_name,
                    'telephone' => $customer->telephone,
                    'customer_staff' => $customer->staff->full_name
                ]
            )
        );

        if (!empty($files)) {
            Telegram::send_photo(
                "R端zgarTeknik",
                "storage/" . $files[0]
            );
        }

        Telegram::send(
            "R端zgarTeknik",
            trans(
                'telegram.add_fault_record_description',
                [
                    'description' => $validated["description"]
                ]
            )
        );

        $validated["files"] = $files;
        $validated["solution_detail"] = "";
        if ($fault_record = FaultRecord::create($validated)) {
            $message = Message::where("id", 20)->get();
            SentMessage::insert(
                [
                    'customer_id' => $customer->id,
                    'message' => (new Messages)->generate(
                        $message[0]->message,
                        [
                            'seri_numarasi' => $fault_record->serial_number
                        ]
                    ),
                    'staff_id' => $customer->staff->id
                ]
            );

            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.fault.records')
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FaultRecord  $faultRecord
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($faultRecordId)
    {
        //$faultRecord = FaultRecord::find($faultRecordId);
        //echo $faultRecord;
        
        $faultRecord = FaultRecord::find($faultRecordId);
        return view('admin.fault-record.edit', [
            'customers' => Customer::where('type', '!=', 0)->get(),
            'faultTypes' => FaultType::where('status', 1)->get(),
            'faultRecord' => $faultRecord,
            'statuses' => trans(
                'tables.fault.record.status'
            )
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FaultRecord  $faultRecord
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, FaultRecord $faultRecord)
    {
        $rules = $this->rules();
        $rules["status"] = 'required';
        $rules['solution_detail'] = 'required|string';
        $validated = $request->validate($rules);
        $old_status = $faultRecord->status;
        if ($faultRecord->update($validated)) {
            if ($old_status != $faultRecord->status) {
                Telegram::send(
                    "R端zgarTeknik",
                    trans(
                        'telegram.edit_fault_record',
                        [
                            'id_no' => $faultRecord->customer->identification_number,
                            'full_name' => $faultRecord->customer->full_name,
                            'serial_number' => $faultRecord->serial_number,
                            'status' => trans('tables.fault.record.status.' . $validated["status"]),
                            'description' => $validated["solution_detail"],
                            'username' => $request->user()->username
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
                'redirect' => relative_route('admin.fault.records')
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
     * Return rules for validation
     *
     * @return array
     */
    private function rules()
    {
        return [
            'customer_id' => [
                'required',
                Rule::exists('customers', 'id')->where(function ($query) {
                    return $query->where('type', '!=', 0);
                })
            ],
            'fault_type_id' => [
                'required',
                Rule::exists('fault_types', 'id')->where(function ($query) {
                    return $query->where('status', 1);
                })
            ]
        ];
    }
}
