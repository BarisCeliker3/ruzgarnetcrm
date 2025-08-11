<?php

namespace App\Http\Controllers\Admin;
use App\Classes\Telegram;
use App\Http\Controllers\Controller;
use App\Models\ContractEnding;
use App\Models\ContractNote;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $contractending)
    {

        return view('admin.contractendings.list',[
            'customer' => $customer,
            'customernotes' => CommitmentNote::where('customer_id',$contractending->id)->get()
        ]);
    }
}
