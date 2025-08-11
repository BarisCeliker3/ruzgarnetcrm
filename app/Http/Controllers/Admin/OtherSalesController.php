<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Carbon;

use App\Http\Controllers\Controller;
use App\Models\OtherSale;
use App\Models\Spending;
use App\Models\Subscription;
use Illuminate\Http\Request;

class OtherSalesController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.othersale.list', [
            'othersales' => OtherSale::orderBy('id', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.othersale.add',[
            'subscriptions' => Subscription::where('status', 1)->get()
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
        $validated = $request->validate($this->rules());
        $validated["subscription_id"] = $request["subscription_id"];
        $validated["date"] = Carbon::now()->startOfMonth()->format('Y-m-15');
        if (OtherSale::create($validated)) {

            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.othersales')
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
    public function edit(OtherSale $othersale)
    {
        return view('admin.othersale.edit', [
            'othersale' => $othersale,
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
    public function update(Request $request, OtherSale $othersale)
    {
        $validated = $request->validate($this->rules());
        $validated["subscription_id"] = $request["subscription_id"];

        if ($othersale->update($validated)) {


            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.edit.success')
                ],
                'redirect' => relative_route('admin.othersales')
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
    public function report(Request $request)
    {
        $date = Carbon::parse($request->input('date') ?? 'now');

        $newdate = $date->setDay('15')->toDateString();
        return view('admin.othersale.report', [
            'date' => $newdate,
            'nakit' => OtherSale::selectRaw("SUM(price) AS price")->where('date', $newdate)->where('type',1)->get(),
            'pos' => OtherSale::selectRaw("SUM(price) AS price")->where('date', $newdate)->where('type',2)->get(),
            'havale' => OtherSale::selectRaw("SUM(price) AS price")->where('date', $newdate)->where('type',3)->get(),
            'moka' => OtherSale::selectRaw("SUM(price) AS price")->where('date', $newdate)->where('type',4)->get(),
            'harcamalar' => Spending::selectRaw("SUM(price) AS price")->where('date', $newdate)->get()
        ]);
    }

    private function rules()
    {
        return [
            'price' => 'required',
            'product_name' => 'required',
            'type' => 'required',
            'description' => 'required'

        ];
    }

}
