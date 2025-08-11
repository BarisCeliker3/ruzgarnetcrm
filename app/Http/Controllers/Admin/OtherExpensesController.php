<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Carbon;

use App\Http\Controllers\Controller;
use App\Models\OtherExpense;
use App\Models\Spending;
use App\Models\Subscription;
use Illuminate\Http\Request;

class OtherExpensesController extends Controller
// class OtherSalesController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.otherexpense.list', [
            'otherexpenses' => OtherExpense::orderBy('id', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.otherexpense.add',[
            'subscriptions' => Subscription::where('status', 1)->get()
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
        $validated["date"] = Carbon::now()->startOfMonth()->format('Y-m-15');
        if (OtherExpense::create($validated)) {
            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.otherexpenses')
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
    public function edit(OtherExpense $otherexpense)
    {
        return view('admin.otherexpense.edit', [
            'otherexpense' => $otherexpense,
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
    public function update(Request $request, OtherExpense $otherexpense)
    {
        $validated = $request->validate($this->rules());
        $validated["subscription_id"] = $request["subscription_id"];

        if ($otherexpense->update($validated)) {


            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.edit.success')
                ],
                'redirect' => relative_route('admin.otherexpenses')
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
        return view('admin.otherexpense.report', [
            'date' => $newdate,
            'yakit' => OtherExpense::selectRaw("SUM(price) AS price")->where('date', $newdate)->where('expense_name',1)->get(),
            'mutfakgiderleri' => OtherExpense::selectRaw("SUM(price) AS price")->where('date', $newdate)->where('expense_name',2)->get(),
            'digergiderler' => OtherExpense::selectRaw("SUM(price) AS price")->where('date', $newdate)->where('expense_name',3)->get(),
            'pos' => OtherExpense::selectRaw("SUM(price) AS price")->where('date', $newdate)->where('expense_name',4)->get(),
            'dekont' => OtherExpense::selectRaw("SUM(price) AS price")->where('date', $newdate)->where('expense_name',5)->get(),
            'giderler' => OtherExpense::selectRaw("SUM(price) AS price")->where('date', $newdate)->get()
        ]);
    }
/**/
 public function expenselist(Request $request)
    {
        $date = Carbon::parse($request->input('date') ?? 'now');
        $newdate = $date->setDay('15')->toDateString();


        return view('admin.otherexpense.expenselist', [
            'date' => $newdate,
            'otherexpenses' => OtherExpense::where('date',$newdate)->orderBy('id', 'desc')->get()
        ]);
    }


/**/

    private function rules()
    {
        return [
            'price' => 'required',
            'expense_name' => 'required',
            'description' => 'required'

        ];
    }

}
