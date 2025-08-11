<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StokTakip;
use App\Models\StokTable;
use App\Models\Staff;
use App\Models\Customer;
use App\Models\StokKategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;

class StokTakipController extends Controller
{

    public function index()
    {
        //return view('admin.stok.list', ['stoktakips' => StokTakip::all()]);
                return view('admin.stok.list',  [


 'stok_takips1' => DB::table('stok_takips')->join('stok_tables','stok_tables.id','=','stok_takips.stok_id')
                                         ->join('stok_kategoris','stok_kategoris.id','=','stok_tables.kategori')->select(
                 DB::raw('stok_takips.stok_id as stok_id'),
                  
                 DB::raw('count(stok_takips.status) as total'))
                 ->groupBy(DB::raw('stok_takips.stok_id'))->get(),


 //  START  stoktakips        
           // 'stok_takips' => DB::table('stok_takips')

           //  ->join('stok_tables','stok_tables.id','=','stok_takips.stok_id')
           //  ->join('stok_kategoris','stok_kategoris.id','=','stok_tables.kategori')
            // ->join('customers','customers.id','=','stok_tables.customer_id')
            // ->join('staff','staff.id','=','stok_tables.staff_id')
             
             //->where('stok_takips.status','=','katego')

            
           
         //  ->orderBy(DB::raw("stok_kategoris.name"), 'ASC')
             
           // ->select(DB::raw('
            
            //  stok_kategoris.name as name,
             // stok_tables.model as model, 
            //  stok_tables.stok_adet as stok_adet, 
           //   stok_takips.status AS status,
            //  stok_takips.stok_id AS stok_id

            //  '))
             // ->get(),
             
             'stok_kiralıks' => DB::select("
                 SELECT stok_tables.model as model,stok_takips.status as status, COUNT(stok_takips.id) as id FROM  stok_takips 
                 INNER JOIN stok_tables ON stok_takips.`stok_id` = stok_tables.id
                 WHERE stok_takips.status = 'Kiralık'
                 GROUP BY stok_takips.status,stok_tables.model"),
            
            'stok_satlıks' => DB::select("
                 SELECT stok_tables.model as model,stok_takips.status as status, COUNT(stok_takips.id) as id FROM  stok_takips 
                 INNER JOIN stok_tables ON stok_takips.`stok_id` = stok_tables.id
                 WHERE stok_takips.status = 'Satılık'
                 GROUP BY stok_takips.status,stok_tables.model"),
            
            'stok_geriiades' => DB::select("
                 SELECT stok_tables.model as model,stok_takips.status as status, COUNT(stok_takips.id) as id FROM  stok_takips 
                 INNER JOIN stok_tables ON stok_takips.`stok_id` = stok_tables.id
                 WHERE stok_takips.status = 'Geri İade'
                 GROUP BY stok_takips.status,stok_tables.model"),
                 
            'eski_iade' => DB::select("
                 SELECT stok_tables.model as model,stok_takips.status as status, COUNT(stok_takips.id) as id FROM  stok_takips 
                 INNER JOIN stok_tables ON stok_takips.`stok_id` = stok_tables.id
                 WHERE stok_takips.status = 'Eski İade'
                 GROUP BY stok_takips.status,stok_tables.model"),
              
              'stok_tables' => DB::table('stok_tables')
              
            // ->join('stok_takips','stok_takips.stok_id','=','stok_tables.id')
             ->join('stok_kategoris','stok_kategoris.id','=','stok_tables.kategori')
             ->orderBy(DB::raw("stok_kategoris.name"), 'ASC')

            ->select(DB::raw('
              stok_kategoris.name as name,
              stok_tables.model as model,
              stok_tables.stok_adet as stok_adet,
              stok_tables.id as id

              '))
              ->get(),
              
            
              
        ]);
    }
    
    public function stokekle()
    {
        return view('admin.stok.stokekle', ['stokekles' => StokTable::all()], ['stok_kategoris'   => DB::table('stok_kategoris')->get()]);
    }
    
      public function stokekleme(Request $request)
    {
           
       $stoktable=new StokTable; 

       $stoktable->kategori=$request->kategori;
       $stoktable->model=$request->model;
       $stoktable->stok_adet=$request->stok_adet;

        $stoktable->save();
       
          return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.stoktakips')
            ]);
    }
    
    public function stokCustomersEkle()
    {                                                
         return view('admin.stok.stokCustomersEkle', [
                                                       'stoktables'  => StokTable::all(),
                                                       'stoktables21'   => StokTable::all()
                                                     ],
                                                     //18.09.2023 16:20 alttaki satırın yerine bir alttaki devreye alındı.
                                                     //['customers'   => Customer::where('customer_status',1)->orderByDesc("id")->get()]
                                                     ['customers'   => Customer::all()]
                                                     );
                                                   

    }
    
    
        public function stokCustomersEkleme(Request $request)
    {
           
       $stoktakip=new StokTakip; 
       
       $stoktakip->customers_name=$request->customers_name;
       $stoktakip->staff_id=$request->staff_id;
       $stoktakip->stok_id=$request->stok_id;
       $stoktakip->status=$request->status;
       $stoktakip->payment=$request->payment;
       $stoktakip->price=$request->price;
       $stoktakip->start_date=$request->start_date;
       $stoktakip->stok_adet=$request->stok_adet;
       $stoktakip->note=$request->note;
       $stoktakip->serino=$request->serino;
       
        $stoktakip->save();
               $stoktakip21 = StokTable::where(['id' => $request->stok_id])->first();
            if($stoktakip21){
           $stock = $stoktakip21->stok_adet - (int) $request->stok_adet;
               $stoktakip21->update(['stok_adet' => $stock]);
            }
            
        
         
          return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.stoktakips')
            ]);
    }
    
    
        public function eskiiade()
    {                                                
         return view('admin.stok.eskiiade', [
                                           'stoktables'  => StokTable::all(),
                                           'stoktables21'   => StokTable::all()
                                            ],
                                             ['customers'   => Customer::where('customer_status',1)->orderByDesc("id")->get()]);
    }
    
    public function eskiiadeEkle(Request $request)
    {
           
       $stoktakip=new StokTakip; 
       
       $stoktakip->customers_name=$request->customers_name;
       $stoktakip->staff_id=$request->staff_id;
       $stoktakip->stok_id=$request->stok_id;
       $stoktakip->status=$request->status;
       $stoktakip->payment=$request->payment;
       $stoktakip->price=$request->price;
       $stoktakip->start_date=$request->start_date;
       $stoktakip->stok_adet=$request->stok_adet;
       $stoktakip->note=$request->note;
       $stoktakip->serino=$request->serino;
       
        $stoktakip->save();
               $stoktakip21 = StokTable::where(['id' => $request->stok_id])->first();
            if($stoktakip21){
           $stock = $stoktakip21->stok_adet+(int) $request->stok_adet;
               $stoktakip21->update(['stok_adet' => $stock]);
            }
            
        
         
          return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.stoktakips')
            ]);
    }
    
    
    
    

    

    public function stoklistes()
    {
        return view('admin.stok.stokliste', ['stok_takips' => StokTakip::join('stok_tables','stok_tables.id','=','stok_takips.stok_id')
        ->orderBy(DB::raw("stok_takips.created_at"), 'DESC')
         ->select(DB::raw('
              stok_takips.id as id,
              stok_takips.stok_id as stok_id,
              stok_takips.customers_name as customers_name,
              stok_tables.model as model,
              stok_tables.kategori as kategori,
              stok_takips.price as price,
              stok_takips.stok_adet as stok_adet,
              stok_takips.status as status,
              stok_takips.payment as payment,
              stok_takips.note as note,
              stok_takips.start_date as start_date,
              stok_takips.serino as serino
              '))->get()]);

    }
    
    public function stoklistedit(Request $request,$id)
    {
         $stok_takip  =StokTakip::findOrFail($id);
         $stok_takips =StokTakip::all();
         $customers   =Customer::where('customer_status',1)->orderByDesc("id")->get();
         $stok_tables =StokTable::all();
  
        return view('admin.stok.stoklistedit',compact('stok_takip','stok_takips','customers','stok_tables'));
       
    }
    
    public function stoklistedit2(Request $request,$id)
    {
         $stok_takip  =StokTakip::findOrFail($id);
         $stok_takips =StokTakip::all();
         $customers   =Customer::where('customer_status',1)->orderByDesc("id")->get();
         $stok_tables =StokTable::all();
  
        return view('admin.stok.geriiade',compact('stok_takip','stok_takips','customers','stok_tables'));
       
    }
    
    
    public function stoklistPost(Request $request,$id)
    {
       $stok_takip= StokTakip::findOrFail($id);

       $stok_takip->staff_id=$request->staff_id;
       $stok_takip->model=$request->model;
       $stok_takip->price=$request->price;
       $stok_takip->stok_adet=$request->stok_adet;
       $stok_takip->status=$request->status;
       $stok_takip->payment=$request->payment;
       $stok_takip->note=$request->note;
       $stok_takip->start_date=$request->start_date;
       $stok_takip->serino=$request->serino;
       
       $stok_takip->save();

        return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.edit.success')
                ],
                'redirect' => relative_route('admin.stoklistes')
            ]);
       
    }
    
    public function stoklistPost2(Request $request,$id)
    {
           
       $stok_takip= StokTakip::findOrFail($id);
       
       $stok_takip->stok_id=$request->stok_id;
       $stok_takip->staff_id=$request->staff_id;
       $stok_takip->model=$request->model;
       $stok_takip->price=$request->price;
       $stok_takip->stok_adet=$request->stok_adet;
       $stok_takip->status=$request->status;
       $stok_takip->payment=$request->payment;
       $stok_takip->note=$request->note;
       $stok_takip->start_date=$request->start_date;
       $stok_takip->serino=$request->serino;
       
       $stok_takip->save();
               $stoktakip21 = StokTable::where(['id' => $request->stok_id])->first();
            if($stoktakip21){
           $stock = $stoktakip21->stok_adet + (int) $request->stok_adet;
               $stoktakip21->update(['stok_adet' => $stock]);
            }
            
        
         
          return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.stoklistes')
            ]);
    }
    

    public function store(Request $request)
    {
        
       
    }

    public function edit(Role $role)
    {
       
    }

     public function stokedit(Request $request,$id)
     {
         
         $stok_table = DB::table('stok_tables')->join('stok_kategoris', 'stok_tables.kategori', '=', 'stok_kategoris.id')->where("stok_tables.id", "=", $id)->first();
         $stok_tables = DB::table('stok_tables')->where("id", "=", $id)->first();
         //echo $id;
         //$stok_table=StokTable::with('stok_kategoris')->findOrFail($id);
         //$stok_tables=StokTable::all();
         //print_r($stok_table->id);
         //echo "<hr>";
         //print_r($stok_tables->id);
         DB::disconnect(DB::connection()->getDatabaseName());    
         return view('admin.stok.stokedit',compact('stok_table','stok_tables'));
     }
    
    public function stokPost(Request $request,$id)
    {
        
       $stok_table= StokTable::findOrFail($id);

       $stok_table->model=$request->model;
       $stok_table->stok_adet=$request->stok_adet;
       $stok_table->save();

        return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.edit.success')
                ],
                'redirect' => relative_route('admin.stoktakips')
            ]);

    }
    

}
