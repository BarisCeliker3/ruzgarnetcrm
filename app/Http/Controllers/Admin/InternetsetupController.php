<?php


namespace App\Http\Controllers\Admin;

use App\Classes\Telegram;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Internetsetup;
//use App\Models\Service;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InternetsetupController extends Controller
{
   

    public function index(Request $request)
    {
       
          return view('admin.internetsetup.list',

     ['internetsetups' => Internetsetup::
           join('staff','staff.id','=','internetsetups.staff_id')
           ->where('internetsetups.start_date', '>', date('Y-m-d', strtotime('2023-07-06')))
          ->orderBy(DB::raw("internetsetups.created_at"), 'DESC')
          ->select(DB::raw('
          
              internetsetups.customer_name as customer_name,
              internetsetups.telephone as telephone,
              internetsetups.adress as adress,
              internetsetups.bbk_code as bbk_code,
              internetsetups.users_name as users_name,
              internetsetups.users_password as users_password,
              internetsetups.start_date as start_date,
              internetsetups.note as note,
              internetsetups.status as status,
              
              staff.first_name as first_name,
              staff.last_name as last_name
              '))->get()]);
          
          
    }
    
    
    public function add(Request $request)
    {
       
          return view('admin.internetsetup.add',['customers' => Customer::orderBy('first_name', 'ASC')->get()]);
    }
    
     public function kurulum(Request $request)
    {
       
          return view('admin.internetsetup.kurulum',
          
     ['internetsetups' => Internetsetup::
           join('staff','staff.id','=','internetsetups.staff_id')
           ->where('internetsetups.status', '=',1)
          ->orderBy(DB::raw("internetsetups.created_at"), 'DESC')
          ->select(DB::raw('
              
              internetsetups.id as id,
              internetsetups.customer_name as customer_name,
              internetsetups.telephone as telephone,
              internetsetups.adress as adress,
              internetsetups.bbk_code as bbk_code,
              internetsetups.users_name as users_name,
              internetsetups.users_password as users_password,
              internetsetups.start_date as start_date,
              internetsetups.note as note,
              internetsetups.status as status,
              
              staff.first_name as first_name,
              staff.last_name as last_name
              '))->get()],
              
               ['internetsetups2' => Internetsetup::
           join('staff','staff.id','=','internetsetups.staff_id')
           ->where('internetsetups.status', '!=',1)
            ->where('internetsetups.start_date', '>', date('Y-m-d', strtotime('2023-07-06')))


          ->orderBy(DB::raw("internetsetups.created_at"), 'DESC')
          ->select(DB::raw('
              
              internetsetups.id as id,
              internetsetups.customer_name as customer_name,
              internetsetups.telephone as telephone,
              internetsetups.adress as adress,
              internetsetups.bbk_code as bbk_code,
              internetsetups.users_name as users_name,
              internetsetups.users_password as users_password,
              internetsetups.start_date as start_date,
              internetsetups.note as note,
              internetsetups.status as status,
              
              staff.first_name as first_name,
              staff.last_name as last_name
              '))->get()]
              );
    }
    
    
    public function edit($id)
    {     
         $internetsetup=Internetsetup::findOrFail($id);
         $internetsetups=Internetsetup::all();
  
        return view('admin.internetsetup.edit',compact('internetsetup','internetsetups'));
        
    }
    
       public function postedit(Request $request, $id)
    {     

       $internetsetup= Internetsetup::findOrFail($id);
      
       $internetsetup->note=$request->note;
       $internetsetup->status=$request->status;

       if ($internetsetup->save()) {
           
           
           if( $internetsetup->status == 2){
               Telegram::send(
                'İnternet Kurulum',
                trans(
                    'telegram.internetsetupedit',
                    [
                        'name' => $internetsetup->customer_name,
                        'telephone' => $internetsetup->telephone,
                        'status' => 'TAMAMLANDI'
                    ]
                )
            );
           }elseif($internetsetup->status == 3){
               Telegram::send(
                'İnternet Kurulum',
                trans(
                    'telegram.internetsetupedit',
                    [
                        'name' => $internetsetup->customer_name,
                        'telephone' => $internetsetup->telephone,
                        'status' => 'İPTAL EDİLDİ'
                    ]
                )
            );
           }
           
           return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.edit.success')
                ],
                'redirect' => relative_route('admin.kurulums')
            ]);
        
    }
    
    }
    
    
    
     public function addPost(Request $request)
    {
      
      /* $request->validate([
          'note'=>'min:1',
          'image'=>'file|mimes:csv,txt,xlx,xls,pdf,jpeg,png,jpg|max:1036822',
          //'image' => 'file|image|preview_mimes:jpeg,png,jpg,heic,heif|max:1036822',
        ]);
       */
       
      $internets= new Internetsetup; 
      $internets->staff_id=$request->staff_id;
      $internets->customer_name=$request->customer_name; 
      $internets->telephone=$request->telephone; 
      $internets->adress=$request->adress; 
      $internets->bbk_code=$request->bbk_code;
      $internets->users_name=$request->users_name; 
      $internets->users_password=$request->users_password; 
      //$internets->note=$request->note; 

       /*
        if($request->allFiles('image')){
            $file= $request->file('image');
            //$filename= date('YmdHi').$file->getClientOriginalName();
            $filename = $expenses->categori_id.'.'. "Dekont".'.'.date('Y-m-d-H-i-s').'.'.$file->getClientOriginalExtension();
            $file-> move(public_path('dekont'), $filename);
            $expenses['image']= $filename;
        }
      */
      
        $internets->save();
        
        Telegram::send(
                'İnternet Kurulum',
                trans(
                    'telegram.internetsetupadd',
                    [
                        'name' => $internets->customer_name,
                        'telephone' => $internets->telephone
                    ]
                )
            );
        
        
       return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.internetsetups')
            ]);

    }
    
  
   
}
