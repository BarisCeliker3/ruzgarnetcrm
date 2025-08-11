<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;
use App\Classes\Telegram;
use App\Models\Notification;
use App\Models\Role;
use App\Models\Staff;
use App\Models\Subscription;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PromotionController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.promotion.list', [
            'promotions' => Promotion::orderBy('id', 'desc')->get()
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.promotion.add',[
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
        $subscription = Subscription::find($validated["subscription_id"]);
        $username = $request->user()->full_name;
        $validated["staff_id"] = $subscription->customer->staff->id;



        if ($promotion = Promotion::create($validated)) {

            $subscription = Subscription::find($validated["subscription_id"]);

            $durum = trans('tables.promotion.status.1');

            Notification::insert([
                'target_route' => 'promotion/edit/' . $promotion->id,
                'target_id' => $promotion->id,
                'description' => $username . ' tarafından bir promosyon tanımlandı.',
                'status' => 1
            ]);

            Telegram::send(
                "Promosyon Takip",
                trans(
                    'telegram.add_promotion',
                    [
                        'username' => $username,
                        'customer' => $subscription->customer->full_name,
                        'promotion'=>$promotion->promotion_name,
                        'staff' => $subscription->customer->staff->full_name,
                        'description' => $promotion->promotion_description,
                        'status' => $durum
                    ]
                )
            );

            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.promotions')
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
     * @param  \App\Models\Promotion  $requestMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promotion)
    {
        return view('admin.promotion.edit', [
            'promotion' => $promotion
        ]);
    }


        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotion  $requestMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promotion $promotion)
    {
        $rules["promotion_description"] = 'required';
        $rules["status"] = 'required';
        $validated = $request->validate($rules);
        $username = $request->user()->staff->full_name;

        $subscription = Subscription::find($promotion->subscription_id);
        $validated["staff_id"] = $subscription->customer->staff->id;

        if ($promotion->update($validated)) {



            $durum = trans('tables.promotion.status.'.$validated["status"]);

            Telegram::send(
                "Promosyon Takip",
                trans(
                    'telegram.edit_promotion',
                    [
                        'username' => $username,
                        'customer' => $subscription->customer->full_name,
                        'promotion'=>$promotion->promotion_name,
                        'staff' => $subscription->customer->staff->full_name,
                        'description' => $promotion->promotion_description,
                        'status' => $durum
                    ]
                )
            );

            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.edit.success')
                ],
                'redirect' => relative_route('admin.promotions')
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
            'subscription_id' => 'required',
            'promotion_name' => 'required',
            'promotion_description' => 'required'

        ];
    }
}
