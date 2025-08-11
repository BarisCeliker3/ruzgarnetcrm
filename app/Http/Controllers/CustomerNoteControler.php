<?php

namespace App\Http\Controllers\Admin;
use App\Classes\Telegram;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerNote;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {


        return view('admin.customernotes.list',[
            'customer' => $customer,
            'customernotes' => CustomerNote::where('customer_id',$customer->id)->get()
        ]);
    }
}
