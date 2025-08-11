<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expensecategory;
use App\Models\Expen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Storage;


class ExpenController extends Controller
{  

    public function index()
    {   
        $firstDayOfMonth = Carbon::now()->startOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();
       
        $GenelToplam = Expen::whereBetween('start_date', [$firstDayOfMonth, $lastDayOfMonth])->sum('price');

       /*
        $GenelToplam=DB::select("
         SELECT SUM(expens.price) as id FROM expens 
            INNER JOIN expensecategories ON expens.categori_id = expensecategories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            AND MONTH(expens.start_date) = MONTH(now())
            ORDER BY SUM(expens.start_date);
        ");
        
        */
        
        $mutfakToplam=DB::select("
         SELECT SUM(expens.price) as id FROM expens 
            INNER JOIN expensecategories ON expens.categori_id = expensecategories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            AND MONTH(expens.start_date) = MONTH(now())
            AND expens.categori_id='1' 
            ORDER BY SUM(expens.start_date);
        ");
        
        
     
      $posToplam=DB::select("
         SELECT SUM(expens.price) as id FROM expens 
            INNER JOIN expensecategories ON expens.categori_id = expensecategories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            AND MONTH(expens.start_date) = MONTH(now())
            AND expens.categori_id='2' 
            ORDER BY SUM(expens.start_date);
        ");
        
        
         $yakitToplam=DB::select("
         SELECT SUM(expens.price) as id FROM expens 
            INNER JOIN expensecategories ON expens.categori_id = expensecategories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            AND MONTH(expens.start_date) = MONTH(now())
            AND expens.categori_id='4' 
            ORDER BY SUM(expens.start_date);
        ");
        
        
         $digerGiderlerToplam=DB::select("
         SELECT SUM(expens.price) as id FROM expens 
            INNER JOIN expensecategories ON expens.categori_id = expensecategories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            AND MONTH(expens.start_date) = MONTH(now())
            AND expens.categori_id='5' 
            ORDER BY SUM(expens.start_date);
        ");
        
        
         $kasaToplam=DB::select("
         SELECT SUM(expens.price) as id FROM expens 
            INNER JOIN expensecategories ON expens.categori_id = expensecategories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            AND MONTH(expens.start_date) = MONTH(now())
            AND expens.categori_id='3' 
            ORDER BY SUM(expens.start_date);
        ");
        
        $dekontToplam=DB::select("
         SELECT SUM(expens.price) as id FROM expens 
            INNER JOIN expensecategories ON expens.categori_id = expensecategories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            AND MONTH(expens.start_date) = MONTH(now())
            AND expens.categori_id='6' 
            ORDER BY SUM(expens.start_date);
        ");
        
       $aylikToplam=DB::select("
         SELECT MONTH(expens.start_date)  as created_at, SUM(expens.price) as id FROM  expens 
            INNER JOIN expensecategories ON expens.categori_id = expensecategories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            GROUP BY  MONTH(expens.start_date)
            ORDER BY MONTH(expens.start_date) ASC;
        ");
        
        return view('admin.expensereport.list',compact('GenelToplam','mutfakToplam','posToplam','yakitToplam','digerGiderlerToplam','kasaToplam','dekontToplam','aylikToplam'));
    }
    
    
    
    public function mutfak()
    {  
        
        
        $mutfakRapor=DB::select("
          SELECT MONTH(expens.start_date)  as created_at, SUM(expens.price) as id FROM  expens 
            INNER JOIN expensecategories ON expens.categori_id = expensecategories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            AND expens.categori_id='1'  
            GROUP BY  MONTH(expens.start_date)
            ORDER BY MONTH(expens.start_date) ASC;
        ");
        
        
        return view('admin.expensereport.mutfak',compact('mutfakRapor'),
        
     ['expens' => Expen::
        
            join('expensecategories','expensecategories.id','=','expens.categori_id')
          ->join('staff','staff.id','=','expens.staff_id')
          ->where('expensecategories.name','=','MUTFAK')
          ->orderBy(DB::raw("expens.created_at"), 'DESC')
          ->select(DB::raw('
              expensecategories.name as name,
              expens.image as image,
              expens.price as price,
              expens.start_date as start_date,
              expens.note as note,
              staff.first_name as first_name,
              staff.last_name as last_name
              '))->get()]);
              
    }
    
        public function pos()
    {  
        
        $posRapor=DB::select("
         SELECT MONTH(expens.start_date)  as created_at, SUM(expens.price) as id FROM  expens 
            INNER JOIN expensecategories ON expens.categori_id = expensecategories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            AND expens.categori_id='2'  
            GROUP BY  MONTH(expens.start_date)
            ORDER BY MONTH(expens.start_date) ASC;
        ");
        return view('admin.expensereport.pos',compact('posRapor'),
        
         ['expens' => Expen::
         join('expensecategories','expensecategories.id','=','expens.categori_id')
          ->join('staff','staff.id','=','expens.staff_id')
          ->where('expensecategories.name','=','POS')
          ->orderBy(DB::raw("expens.created_at"), 'DESC')
          ->select(DB::raw('
              expensecategories.name as name,
              expens.image as image,
              expens.price as price,
              expens.start_date as start_date,
              expens.note as note,
              staff.first_name as first_name,
              staff.last_name as last_name
              '))->get()]);
              
       
    }
    
    
        public function yakit()
    {  
        
         $yakitRapor=DB::select("
         SELECT MONTH(expens.start_date)  as created_at, SUM(expens.price) as id FROM  expens 
            INNER JOIN expensecategories ON expens.categori_id = expensecategories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            AND expens.categori_id='4'  
            GROUP BY  MONTH(expens.start_date)
            ORDER BY MONTH(expens.start_date) ASC;
        ");
        
        return view('admin.expensereport.yakit',compact('yakitRapor'),
         ['expens' => Expen::
         join('expensecategories','expensecategories.id','=','expens.categori_id')
          ->join('staff','staff.id','=','expens.staff_id')
          ->where('expensecategories.name','=','YAKIT')
          ->orderBy(DB::raw("expens.created_at"), 'DESC')
          ->select(DB::raw('
              expensecategories.name as name,
              expens.image as image,
              expens.price as price,
              expens.start_date as start_date,
              expens.note as note,
              staff.first_name as first_name,
              staff.last_name as last_name
              '))->get()]);
    }
    
    
        public function digerGiderler()
    {   
        
                 $digerGiderRapor=DB::select("
         SELECT MONTH(expens.start_date)  as created_at, SUM(expens.price) as id FROM  expens 
            INNER JOIN categories ON expens.categori_id = categories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            AND expens.categori_id='5'  
            GROUP BY  MONTH(expens.start_date)
            ORDER BY MONTH(expens.start_date) ASC;
        ");
        
        return view('admin.expensereport.digerGiderler',compact('digerGiderRapor'),
        
         ['expens' => Expen::
         join('expensecategories','expensecategories.id','=','expens.categori_id')
          ->join('staff','staff.id','=','expens.staff_id')
          ->where('expensecategories.name','=','DİĞER GİDERLER')
          ->orderBy(DB::raw("expens.created_at"), 'DESC')
          ->select(DB::raw('
              expensecategories.name as name,
              expens.image as image,
              expens.price as price,
              expens.start_date as start_date,
              expens.note as note,
              staff.first_name as first_name,
              staff.last_name as last_name
              '))->get()]);
    }
    
        public function kasa()
    {  
        $kasaRapor=DB::select("
        SELECT MONTH(expens.start_date)  as created_at, SUM(expens.price) as id FROM  expens 
            INNER JOIN expensecategories ON expens.categori_id = expensecategories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            AND expens.categori_id='3'  
            GROUP BY  MONTH(expens.start_date)
            ORDER BY MONTH(expens.start_date) ASC;
        ");
        
        return view('admin.expensereport.kasa',compact('kasaRapor'),
        
         ['expens' => Expen::
         join('expensecategories','expensecategories.id','=','expens.categori_id')
          ->join('staff','staff.id','=','expens.staff_id')
          ->where('expensecategories.name','=','GÜNLÜK KASA')
          ->orderBy(DB::raw("expens.created_at"), 'DESC')
          ->select(DB::raw('
              expensecategories.name as name,
              expens.image as image,
              expens.price as price,
              expens.start_date as start_date,
              expens.note as note,
              staff.first_name as first_name,
              staff.last_name as last_name
              '))->get()]);
    }
    
    public function dekont()
    {  
        $dekontRapor=DB::select("
         SELECT MONTH(expens.start_date)  as created_at, SUM(expens.price) as id FROM  expens 
            INNER JOIN expensecategories ON expens.categori_id = expensecategories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            AND expens.categori_id='6'  
            GROUP BY  MONTH(expens.start_date)
            ORDER BY MONTH(expens.start_date) ASC;
        ");
        
        return view('admin.expensereport.dekont',compact('dekontRapor'),
        
         ['expens' => Expen::
         join('expensecategories','expensecategories.id','=','expens.categori_id')
          ->join('staff','staff.id','=','expens.staff_id')
          ->where('expensecategories.name','=','DEKONT')
          ->orderBy(DB::raw("expens.created_at"), 'DESC')
          ->select(DB::raw('
              expensecategories.name as name,
              expens.image as image,
              expens.price as price,
              expens.start_date as start_date,
              expens.note as note,
              staff.first_name as first_name,
              staff.last_name as last_name
              '))->get()]);
    }
    
    public function expenselist()
    {   
        $mtfkRapor=DB::select("
         SELECT MONTH(expens.start_date)  as created_at, SUM(expens.price) as id FROM  expens 
            INNER JOIN expensecategories ON expens.categori_id = expensecategories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            AND expens.categori_id='1'  
            GROUP BY  MONTH(expens.start_date)
            ORDER BY MONTH(expens.start_date) ASC;
        ");
        
        Storage::disk('local')->append('mtfkRapor.dat', print_r($mtfkRapor, true));        
        $psRapor=DB::select("
        SELECT MONTH(expens.start_date)  as created_at, SUM(expens.price) as id FROM  expens 
            INNER JOIN expensecategories ON expens.categori_id = expensecategories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            AND expens.categori_id='2'  
            GROUP BY  MONTH(expens.start_date)
            ORDER BY MONTH(expens.start_date) ASC;
        ");
        
        
        $gnlkRapor=DB::select("
         SELECT MONTH(expens.start_date)  as created_at, SUM(expens.price) as id FROM  expens 
            INNER JOIN expensecategories ON expens.categori_id = expensecategories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            AND expens.categori_id='3'  
            GROUP BY  MONTH(expens.start_date)
            ORDER BY MONTH(expens.start_date) ASC;
        ");
        
        
        $yktRapor=DB::select("
         SELECT MONTH(expens.start_date)  as created_at, SUM(expens.price) as id FROM  expens 
            INNER JOIN expensecategories ON expens.categori_id = expensecategories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            AND expens.categori_id='4'  
            GROUP BY  MONTH(expens.start_date)
            ORDER BY MONTH(expens.start_date) ASC;
        ");
        
        $dgdrRapor=DB::select("
         SELECT MONTH(expens.start_date)  as created_at, SUM(expens.price) as id FROM  expens 
            INNER JOIN expensecategories ON expens.categori_id = expensecategories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            AND expens.categori_id='5'  
            GROUP BY  MONTH(expens.start_date)
            ORDER BY MONTH(expens.start_date) ASC;
        ");
        
        $dkntRapor=DB::select("
         SELECT MONTH(expens.start_date)  as created_at, SUM(expens.price) as id FROM  expens 
            INNER JOIN expensecategories ON expens.categori_id = expensecategories.id
            WHERE YEAR(expens.start_date) = YEAR(now()) 
            AND expens.categori_id='6'  
            GROUP BY  MONTH(expens.start_date)
            ORDER BY MONTH(expens.start_date) ASC;
        ");
        
        return view('admin.expensereport.expenselist',compact('mtfkRapor','psRapor','gnlkRapor','yktRapor','dgdrRapor','dkntRapor'),['expens' => Expen::
            
            
            join('expensecategories','expensecategories.id','=','expens.categori_id')
            ->join('staff','staff.id','=','expens.staff_id')
          ->orderBy(DB::raw("expens.created_at"), 'DESC')
          ->select(DB::raw('
              expensecategories.name as name,
              expens.image as image,
              expens.price as price,
              expens.start_date as start_date,
              expens.note as note,
              expens.id as id,
              staff.first_name as first_name,
              staff.last_name as last_name
              '))->get()]);

    }
    
    
    public function giderekle()
    {
            return view('admin.expensereport.add',['expens' => Expen::orderBy('id', 'DESC')->get()], ['expensecategories' => Expensecategory::orderBy('id', 'DESC')->get()]);
    }
    
    
     public function gidereklePost(Request $request)
    {
      
       $request->validate([
          'note'=>'min:1',
          'image'=>'file|mimes:csv,txt,xlx,xls,pdf,jpeg,png,jpg|max:1036822',
          //'image' => 'file|image|preview_mimes:jpeg,png,jpg,heic,heif|max:1036822',
        ]);

      $expenses= new Expen; 
      $expenses->categori_id=$request->categori_id;
      $expenses->staff_id=$request->staff_id; 
      $expenses->note=$request->note; 
      $expenses->price=$request->price; 
     // $expenses->start_date=$request->start_date; 

        if($request->allFiles('image')){
            $file= $request->file('image');
            //$filename= date('YmdHi').$file->getClientOriginalName();
            $filename = $expenses->categori_id.'.'. "Dekont".'.'.date('Y-m-d-H-i-s').'.'.$file->getClientOriginalExtension();
            $file-> move(public_path('dekont'), $filename);
            $expenses['image']= $filename;
        }

        $expenses->save();
        
       return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.expenselists')
            ]);

    }
    
    
    
    
    
    

}
