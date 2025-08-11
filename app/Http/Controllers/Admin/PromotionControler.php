<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestMessage;
use App\Classes\Telegram;
use App\Models\Notification;
use App\Models\Promotion;
use App\Models\Subscription;
use App\Models\Staff;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class PromotionControler extends Controller
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
        return view('admin.request-message.add');
    }

}
