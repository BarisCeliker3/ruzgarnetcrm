<?php
namespace App\Http\Controllers\Admin;

class companymanagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('sirket-yonetim');
    }

}
