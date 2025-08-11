<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Carbon;

use App\Http\Controllers\Controller;
use App\Models\Accounting;
use App\Models\Spending;
use App\Models\Content;
use App\Models\Appnoti;
use App\Models\Subscription;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class AccountingController extends Controller
// class accounting extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('admin.accounting.list', [
           // 'accountings' => Accounting::orderBy('id', 'desc')->get(),
           // 'accountings21' => Accounting::whereYear('date', Carbon::now()->year)->whereMonth('date', Carbon::now()->subMonths(1))->orderBy('id', 'DESC')->get()
           //'accountings21' => Accounting::whereYear('date', Carbon::now()->year)->whereMonth('date', Carbon::now()->subDays(31))->orderBy('id', 'DESC')->get()
           
            'accountings' => Accounting::whereYear('date', Carbon::now()->year)->whereMonth('date', Carbon::now()->month)->orderBy('id', 'DESC')->get(),
            //'accountings21' => Accounting::whereYear('date', Carbon::now()->year)->whereMonth('date', Carbon::now()->subMonthNoOverflow(1))->orderBy('id', 'DESC')->get(),
            'accountings21' => Accounting::whereYear('date', Carbon::today()->startOfMonth()->subMonth(1)->format('Y'))->whereMonth('date', Carbon::today()->startOfMonth()->subMonth(1))->orderBy('id', 'DESC')->get(),
            'accountings51' => Accounting::whereYear('date', Carbon::today()->startOfMonth()->subMonth(2)->format('Y'))->whereMonth('date', Carbon::today()->startOfMonth()->subMonth(2))->orderBy('id', 'DESC')->get(),
           
 'accountings55' => Accounting::whereYear('date', Carbon::today()->startOfMonth()->subMonth(3)->format('Y'))->whereMonth('date', Carbon::today()->startOfMonth()->subMonth(3))->orderBy('id', 'DESC')->get(),
           
            //'accountings51' => Accounting::whereYear('date', Carbon::now()->year)->whereMonth('date', Carbon::now()->subMonthNoOverflow(2))->orderBy('id', 'DESC')->get()

            
        ]);
    }
/**/
       public function Notiappindex()
    {
        $appnotis = Appnoti::orderBy('notify_time', 'desc')->paginate(20);
        return view('admin.appcontents.listcontents', compact('appnotis'));
    }

    public function Notiappcreate()
    {
        return view('admin.appnotis.create');
    }

public function Notiappstore(Request $request)
{
    $request->validate([
        'title'        => 'required|string|max:255',
        'body'         => 'nullable|string',
        
        'sent'         => 'required|boolean',
    ]);

    $appnoti = Appnoti::create($request->all());

    if ($request->ajax()) {
        return response()->json([
            'noti' => [
                'id' => $appnoti->id,
                'title' => $appnoti->title,
                'body' => $appnoti->body,
                'sent' => $appnoti->sent,
                'created_at' => $appnoti->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $appnoti->updated_at->format('Y-m-d H:i:s'),
            ]
        ], 200);
    }

    return redirect()->route('admin.appnotis.index')->with('success', 'Bildirim başarıyla eklendi.');
}

public function Notiappupdate(Request $request, Appnoti $appnoti)
{
    $request->validate([
        'title'        => 'required|string|max:255',
        'body'         => 'nullable|string',
        'notify_time'  => 'required|date',
        'sent'         => 'required|boolean',
    ]);
    $appnoti->update($request->all());

    if ($request->ajax()) {
        return response()->json([
            'noti' => [
                'id' => $appnoti->id,
                'title' => $appnoti->title,
                'body' => $appnoti->body,
                'notify_time_display' => \Carbon\Carbon::parse($appnoti->notify_time)->format('d.m.Y H:i'),
                'sent' => $appnoti->sent,
                'created_at' => $appnoti->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $appnoti->updated_at->format('Y-m-d H:i:s'),
            ]
        ], 200);
    }

    return redirect()->route('admin.appnotis.index')->with('success', 'Bildirim başarıyla güncellendi.');
}

public function Notiappdestroy(Request $request, Appnoti $appnoti)
{
    $appnoti->delete();

    if ($request->ajax()) {
        return response()->json(['success' => true], 200);
    }

    return redirect()->route('admin.appnotis.index')->with('success', 'Bildirim silindi.');
}

    public function contentindex()
{
    $contents = Content::orderBy('id', 'desc')->paginate(20);
    return view('admin.appcontents.listconten', compact('contents'));
}

public function contentcreate()
{
    return view('admin.appcontents.listconten');
}

public function contentstore(Request $request)
{
    $request->validate([
        'title'     => 'required|string|max:255',
        'body'      => 'nullable|string',
        'category'  => 'required|string|in:Aile,Çocuk', // enum değerleri
        'resim'     => 'nullable|string|max:255', // Eğer resim dosyası ise dosya doğrulaması ayrı yapılmalı
    ]);

    $content = Content::create($request->all());

    if ($request->ajax()) {
        return response()->json([
            'content' => [
                'id' => $content->id,
                'title' => $content->title,
                'body' => $content->body,
                'category' => $content->category,
                'resim' => $content->resim,
                'created_at' => $content->created_at,
                'updated_at' => $content->updated_at,
            ]
        ], 200);
    }

    return redirect()->route('admin.appcontents.listconten')->with('success', 'İçerik başarıyla eklendi.');
}

public function contentupdate(Request $request, Content $content)
{
    $request->validate([
        'title'     => 'required|string|max:255',
        'body'      => 'nullable|string',
        'category'  => 'required|string|in:Aile,Çocuk',
        'resim'     => 'nullable|string|max:255',
    ]);
    $content->update($request->all());

    if ($request->ajax()) {
        return response()->json([
            'content' => [
                'id' => $content->id,
                'title' => $content->title,
                'body' => $content->body,
                'category' => $content->category,
                'resim' => $content->resim,
                'created_at' => $content->created_at,
                'updated_at' => $content->updated_at,
            ]
        ], 200);
    }

    return redirect()->route('admin.appcontents.listconten')->with('success', 'İçerik başarıyla güncellendi.');
}

public function contentdestroy(Request $request, Content $content)
{
    $content->delete();

    if ($request->ajax()) {
        return response()->json(['success' => true], 200);
    }

    return redirect()->route('admin.appcontents.listconten')->with('success', 'İçerik silindi.');
}
    public function create()
    {
        return view('admin.accounting.add',[
            'subscriptions' => Subscription::where('status', 1)->get()
        ]);
    }
     public function report()
    {   
        $havele=DB::select("
         SELECT MONTH(accountings.date)  as created_at, SUM(accountings.price) as price FROM  accountings 
            WHERE YEAR(accountings.date) = YEAR(now()) 
            AND accountings.`payment_type` = '1'
            GROUP BY MONTH(accountings.date)
            ORDER BY MONTH(accountings.date)
         ");
         
        $post=DB::select("
         SELECT MONTH(accountings.date)  as created_at, SUM(accountings.price) as price FROM  accountings 
            WHERE YEAR(accountings.date) = YEAR(now()) 
            AND accountings.`payment_type` = '2'
            GROUP BY MONTH(accountings.date)
            ORDER BY MONTH(accountings.date)
         ");
     
     
      return view('admin.accounting.report', [
            'accountings' => Accounting::orderBy('id', 'desc')->get()
        ],compact('havele','post')); 

                
        
    }
/**/
public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $validated["date"] = $request->input('date');
        if (Accounting::create($validated)) {
            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.accountings')
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
/**/
   
/**/

    private function rules()
    {
        return [
            'name_surname' => 'required',
            'contents' => 'required',
            'bank' => 'required',
            'payment_type' => 'required',
            'price' => 'required',
            'note' => 'required',
            'date' => 'required',
            'staff_id' => 'required'

        ];
    }

}
