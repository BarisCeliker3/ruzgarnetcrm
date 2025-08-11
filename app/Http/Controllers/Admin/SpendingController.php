<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Carbon;

use App\Http\Controllers\Controller;
use App\Models\Spending;
use Illuminate\Http\Request;

class SpendingController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = Carbon::parse($request->input('date') ?? 'now');
        $newdate = $date->setDay('15')->toDateString();


        return view('admin.spending.list', [
            'date' => $newdate,
            'spendings' => Spending::where('date',$newdate)->orderBy('id', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.spending.add');
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
        $validated["date"] = Carbon::now()->startOfMonth()->format('Y-m-15');


        if (Spending::create($validated)) {

            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.spendings')
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
     * @param  \App\Models\Spending $spending
     * @return \Illuminate\Http\Response
     */
    public function edit(Spending $spending)
    {
        return view('admin.spending.edit', [
            'spending' => $spending,
        ]);
    }


           /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Spending $spending
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Spending $spending)
    {
        $validated = $request->validate($this->rules());

        if ($spending->update($validated)) {


            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.edit.success')
                ],
                'redirect' => relative_route('admin.spendings')
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


    private function rules()
    {
        return [
            'price' => 'required',
            'title' => 'required',
            'description' => 'required'
        ];
    }

}
