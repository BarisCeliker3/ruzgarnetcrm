<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Telegram;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\SubscriptionFreeze;
use App\Models\CustomerApplicationType;
use App\Models\Staff;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class FrozenonesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('admin.frozenones.list', ['subscription_freezes' => Frozenones::all()]);
       //   return view('admin.frozenones.list', ['subscription_freezes' => SubscriptionFreeze::get()]);
        
    return view('admin.frozenones.list',[
 
 //dondorulanlar
            'subscription_freezes' => DB::table('subscription_freezes')
          
            ->join('subscriptions','subscriptions.id','=','subscription_freezes.subscription_id')
            ->join('customers','customers.id','=','subscriptions.customer_id')
            
             ->join('customer_staff','customers.id','=','customer_staff.customer_id')
             ->join('staff','staff.id','=','customer_staff.staff_id')

             ->where('subscriptions.status','=',4)  

             ->orderBy(DB::raw("subscription_freezes.created_at"), 'DESC')
            
            ->select(DB::raw('
             customers.id AS customer_id,
            CONCAT(
               
                customers.first_name,
                " ",
                customers.last_name
            ) AS isim, 
         

            subscription_freezes.created_at AS created_at,
            subscription_freezes.description AS description,
            
             subscriptions.id AS id,
             subscriptions.customer_id AS customer_id,
            
            staff.first_name AS first_name,
            staff.last_name AS last_name,
            
            staff.first_name AS temsilci'))
            ->get(),
            
            
// dondorulanlar



        ]);
        
    }
    
      
    
     
    
    
}
