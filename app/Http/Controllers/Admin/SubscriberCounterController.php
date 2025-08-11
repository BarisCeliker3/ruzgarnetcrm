<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Carbon;
use App\Models\Staff;
use App\Http\Controllers\Controller;
use App\Models\SubscriberCounter;
use App\Models\Spending;
use App\Models\Subscription;
use App\Rules\Telephone;
use Illuminate\Http\Request;


class SubscriberCounterController extends Controller
// class OtherSalesController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.subscriber-counter.list', [
            'subscribercounters' => SubscriberCounter::orderBy('id', 'desc')->get()
        ]);
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subscriber-counter.add',[
            'subscriptions' => Subscription::where('status', 1)->get(),
            'staffs' => Staff::whereNull('released_at')->get()
        ]);
    }

       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

/**/
public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $validated["date"] = Carbon::now()->startOfMonth()->format('Y-m-d');
        if (SubscriberCounter::create($validated)) {
            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
            
                'redirect' => relative_route('admin.subscribercounters')
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
     * @param  \App\Models\OtherSale  $requestMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(SubscriberCounter $subscribercounter)
    {
        return view('admin.subscribercounter.edit', [
            'subscribercounter' => $subscribercounter,
            'subscriptions' => Subscription::where('status', 1)->get()
        ]);
    }


           /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotion  $requestMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubscriberCounter $subscribercounter)
    {
        $validated = $request->validate($this->rules());
        $validated["subscription_id"] = $request["subscription_id"];

        if ($subscribercounter->update($validated)) {


            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.edit.success')
                ],
                'redirect' => relative_route('admin.subscribercounters')
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
     * Report Page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
   
/**/
 public function expenselist(Request $request)
    {
        $date = Carbon::parse($request->input('date') ?? 'now');
        $newdate = $date->setDay('15')->toDateString();


        return view('admin.subscribercounter.expenselist', [
            'date' => $newdate,
            'subscribercounters' => SubscriberCounter::where('date',$newdate)->orderBy('id', 'desc')->get()
        ]);
    }


/**/

    private function rules()
    {
        return [
            'name_surname' => 'required',
            'bitistarihi' => 'required',
            'staff_id' => 'required',
            'telephone' => 'required',
            'company' => 'required'

        ];
    }

}
