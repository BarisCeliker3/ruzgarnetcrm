<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Telegram;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\SubscriptionUpgrade;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionUpgradeController extends Controller
{
    //
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = Carbon::parse('now');

        return view('admin.subscription-upgrade.list', [
            'subsupgrades' => DB::table('subscriptions')
            ->join('subscription_upgrades', 'subscriptions.id', '=', 'subscription_upgrades.subscription_id')
            ->join('services','subscriptions.service_id','=','services.id')
            ->join('customers','customers.id','=','subscriptions.customer_id')
            ->join('customer_staff','customers.id','=','customer_staff.customer_id')
            ->join('staff','staff.id','=','customer_staff.staff_id')
            ->where('subscriptions.approved_at', '<' ,'2021-07-15')
            ->where('subscriptions.status','=',1)
            ->where('subscriptions.service_id','!=',8)
            ->select(DB::raw('
            subscription_upgrades.id AS id,
             customers.id AS customer_id,
            CONCAT(

                customers.first_name,
                " ",
                customers.last_name
            ) AS isim,
            subscription_upgrades.status,
            subscription_upgrades.description,
            services.name AS tarife,
            staff.first_name AS temsilci'))
            ->get()
        ]);
    }

    public function edit(SubscriptionUpgrade $subscriptionupgrade)
    {
        $subscription = Subscription::where('id',$subscriptionupgrade->subscription_id)->get();

        return view('admin.subscription-upgrade.edit', [
            'subscriptionupgrade' => $subscriptionupgrade,
            'subscription' => $subscription,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubscriptionUpgrade  $subscriptionUpgrade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubscriptionUpgrade $subscriptionupgrade)
    {

        $subscription = Subscription::where('id',$subscriptionupgrade->subscription_id)->get()->first();
        $validated = $request->validate([
            'status'=>'required',
            'description'=>'required'
        ]);

        $durum = trans('tables.subscription_upgrade.status.'.$validated["status"]);

        if ($subscriptionupgrade->update($validated)) {
            if($validated["status"] != "2"){
                Telegram::send(
                    "KaliteKontrolEkibi",
                    trans(
                        'telegram.edit_subscription_upgrade',
                        [
                            'username' => $request->user()->staff->full_name,
                            'customer' => $subscription->customer->full_name,
                            'staff' => $subscription->customer->staff->first_name,
                            'tarife' => $subscription->service->name,
                            'description' => $request->description,
                            'status' => $durum
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
                'redirect' => relative_route('admin.subscriptionupgrades')
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'toastr' => [
                    'type' => 'error',
                    'title' => trans('response.title.error'),
                    'message' => trans('response.edit.error')
                ]
            ]);
        }
    }
}
