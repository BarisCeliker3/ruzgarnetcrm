<?php

namespace App\Http\Controllers\Admin;
use App\Classes\Telegram;
use App\Http\Controllers\Controller;
use App\Models\SubscriberCounter;
use App\Models\CommitmentNote;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $subscribercounter)
    {

        return view('admin.subscribercounters.list',[
            'customer' => $customer,
            'customernotes' => CommitmentNote::where('customer_id',$subscribercounter->id)->get()
        ]);
    }
}
