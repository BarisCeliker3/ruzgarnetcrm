<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppCustomerApp;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AppCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index() {
    $customers = AppCustomerApp::paginate(15); // veya istediğin kadar satır
    return view('admin.appcustomer_app.index', compact('customers'));
}

   
}
