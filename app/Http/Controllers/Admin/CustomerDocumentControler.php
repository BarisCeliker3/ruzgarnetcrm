<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use App\Classes\Telegram;
use App\Classes\Moka;
use App\Models\MokaAutoPayment;
use App\Models\MokaSale;
use App\Classes\Messages;
use App\Classes\SMS;
use App\Models\SentMessage;
use App\Models\Message;
use App\Models\CustomerDocument;
use App\Models\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Livewire\WithFileUploads;
use Exception;
  use Validator;
use SoapClient;
use App\Models\Subscription;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Storage;

class CustomerDocumentControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
     public function ekle(Customer $customer, Request $request)
    {
      
       $request->validate([
          'note'=>'min:3',
          'image'=>'file|image|mimes:jpeg,png,jpg,heic,heif|max:1036822',
          //'image' => 'file|image|preview_mimes:jpeg,png,jpg,heic,heif|max:1036822',
        ]);

      $customer= new  CustomerDocument; //page modelini page değişkenine atıyorum
      $customer->staff_id=$request->staff_id; // request gelen title değerini,  article değikenin title değerine ata ve  veritabanında kaydet
      $customer->customer_id=$request->customer_id;
      $customer->document_name=$request->document_name; // request gelen title değerini,  page değikenin title değerine ata ve  veritabanında kaydet
      $customer->note=$request->note;

        if($request->allFiles('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('public/evrak'), $filename);
            $customer['image']= $filename;
        }

        $customer->save();
        
       return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.customer.documents',$customer->customer_id)
            ]);
        
    }
    
    
    
    
    public function ekleme(Customer $customer, Request $request)
    {
      
       $request->validate([
          'note'=>'min:1',
          'image'=>'file|mimes:csv,txt,xlx,xls,pdf,jpeg,png,jpg|max:1036822',
          //'image' => 'file|image|preview_mimes:jpeg,png,jpg,heic,heif|max:1036822',
        ]);

      $customer= new  CustomerDocument; //page modelini page değişkenine atıyorum
      $customer->staff_id=$request->staff_id; // request gelen title değerini,  article değikenin title değerine ata ve  veritabanında kaydet
      $customer->customer_id=$request->customer_id;
      $customer->document_name=$request->document_name; // request gelen title değerini,  page değikenin title değerine ata ve  veritabanında kaydet
      $customer->note=$request->note;

        if($request->allFiles('image')){
            $file= $request->file('image');
           // $filename= date('YmdHi').$file->getClientOriginalName();
            $filename = $customer->customer_id.'.'.date('Y-m-d-H-i-s').'.'.$file->getClientOriginalExtension();
            $file-> move(public_path('public/evrak'), $filename);
            $customer['image']= $filename;
        }

        $customer->save();
        
       return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.customer.documents',$customer->customer_id)
            ]);

    }
    

  
     public function edit($id)
    {     
         $customer_document=CustomerDocument::with('customer','customerInfo')->findOrFail($id);
         $customer_documents=CustomerDocument::all();
  
        return view('admin.customer-documents.edit',compact('customer_document','customer_documents'));
        
    }
    
    public function delete(Request $request,$id)
    {

        $customerDocuments = CustomerDocument::find($request->id);
        unlink("public/evrak/".$customerDocuments->image);
        $silme = CustomerDocument::where("id", $customerDocuments->id)->delete();

        if ($silme) {
            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.delete.success')
                ],
                'redirect' => relative_route('admin.customer.documents',$customerDocuments->customer_id)
            ]);
         }
    
    }
  
    
   public function postedit(Request $request, $id)
    {     

       $customer_document= CustomerDocument::findOrFail($id);
       
     
       $customer_document->staff_id=$request->staff_id;
       $customer_document->customer_id=$request->customer_id;
       $customer_document->document_name=$request->document_name;

       
       $customer_document->note=$request->note;
       $customer_document->status=$request->status;

       if ($customer_document->save()) {
            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'status'=>201,
            ]);
        
    }
    
    }
  
    
    public function index(Customer $customer)
    {




        // $moka = new Moka();
        // $count = 0;
        // $moka_sales = MokaSale::whereNull("disabled_at")->get();
        // foreach ($moka_sales as $sale) {
        //     if($sale->subscription->status == 1)
        //     {

        //         $payment = $sale->subscription->lastUnpaidPayment();
        //         if ($payment) {
        //             if (!$payment->isPaid()) {
        //                 $count++;
        //             }
        //         }


        //     }

        // }
        // dd($count);


        // $moka = new Moka;
        // $sonuc = $moka->get_payment_plan_report();
        // $plan = [];
        // $iptal = [];
        // if($sonuc->Data!= null){
        //     foreach($sonuc->Data->PaymentPlanList as $planlist){
        //         if($planlist->PlanStatus == 0)
        //         {
        //             $plan [] = $planlist->DealerPaymentPlanId;
        //         }

        //     }
        //     //$plan = [59542,59555,59640,59653,59735,59768,59849,59961,59985,60012,60053,60054,60123,60135,60142,60149,61043];
        //     //dd($plan);
        //     foreach($plan as $plans){
        //         $moka_auto_payments [] = DB::table('moka_auto_payments')
        //         ->join('payments', 'moka_auto_payments.payment_id', '=', 'payments.id')
        //         ->where('moka_plan_id',$plans)

        //         ->select('payments.*','moka_auto_payments.moka_plan_id')
        //         ->first();
        //     }
        //     //dd($moka_auto_payments);
        //     //  $moka_auto_payments = DB::table('moka_auto_payments')
        //     //  ->join('payments', 'moka_auto_payments.payment_id', '=', 'payments.id')
        //     //  ->whereIn('moka_plan_id',$plan)
        //     //  ->whereNotNull('paid_at')
        //     //  ->select('payments.*','moka_auto_payments.moka_plan_id')
        //     //  ->get();
        //     //dd($moka_auto_payments);
        //     foreach($moka_auto_payments as $payments){
        //         if($payments->status == 2){
        //         $iptal [] = $moka->delete_payment_plan($payments->moka_plan_id);
        //         }
        //     }
        //   dd($iptal);
        // }


        // $moka = new Moka;
        // $sonuc = $moka->get_payment_plan_report();

        // $plan = [];
        // $idler = [];
        // if($sonuc->Data!= null){
        //     foreach($sonuc->Data->PaymentPlanList as $planlist){
        //         if($planlist->PlanStatus == 1 )
        //         {
        //             $plan [] = $planlist->DealerPaymentPlanId;
        //         }
        //     }

        //     dd($plan);
        //     $moka_auto_payments = DB::table('moka_auto_payments')
        //     ->join('payments', 'moka_auto_payments.payment_id', '=', 'payments.id')
        //     ->whereIn('moka_plan_id',$plan)
        //     ->select('payments.*')
        //     ->get();

        //     //dd($moka_auto_payments);
        //     foreach($moka_auto_payments as $payments){
        //         if($payments->status == 1){
        //             $idler [] = $payments->subscription_id;
        //                $payment = Payment::find($payments->id);
        //                $payment->receive([
        //                'type' => 5
        //               ]);
        //         }
        //     }

        //     dd($idler);
        // }

       return view('admin.customer-documents.list',[
            'customer' => $customer,
            'customerDocuments' => CustomerDocument::where('customer_id',$customer->id)->
            orderby('id','desc')
            ->get()
        ]);

    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sms_list(Customer $customer)
    {
        return view('admin.customer-sms.list',[
            'customer' => $customer,
            'customerSms' => DB::table('customer_sms')->where('customer_id',$customer->id)
            ->orderby('id','desc')
            ->get()
        ]);

    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer)
    {
        return view('admin.customer-documents.ekle', [
            'customer' => $customer
        ]);
    }
    
    /** PDF DOCUMENT **/
    
   public function pdfdocument()
    {
        return view('admin.customer-documents.pdfdocument',[
 
 //PDF DOCUMENT
            'customer_documents' => DB::table('customer_documents')
          
            
            
            
            ->join('customers','customers.id','=','customer_documents.customer_id')
            
             ->join('customer_staff','customers.id','=','customer_staff.customer_id')
             ->join('staff','staff.id','=','customer_staff.staff_id')

             ->where('customer_documents.created_at','>=', '2023-03-25 13:00:00')
             ->where('customer_documents.status','<', '3')
             ->where('customer_documents.document_name','=', 'PDF İmzasız Sözleşme')
             ->orderBy(DB::raw("customer_documents.created_at"), 'DESC')
             
            ->select(DB::raw('
             customers.id AS customer_id,
            CONCAT(
               
                customers.first_name,
                " ",
                customers.last_name
            ) AS isim, 
         

            customer_documents.created_at AS created_at,
            customer_documents.image AS image,
            customer_documents.document_name AS document_name,
            customer_documents.id AS id,
            customer_documents.status AS status,
            customer_documents.note AS note,
            
            staff.first_name AS first_name,
            staff.last_name AS last_name,

            
            staff.first_name AS temsilci'))
            ->get()
            
            
// dondorulanlar



        ]);
    }
    
    /** // PDF DOCUMENT **/ 
     
         public function createUpload(Customer $customer)
    {
        return view('admin.customer-documents.ekleme', [
            'customer' => $customer
        ]);
    }

       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Customer $customer , Request $request)
    {
       
        
        $validated = $request->validate($this->rules());
        $validated["staff_id"] = $request->user()->staff_id;
        $validated["customer_id"] = $customer->id;

        
        if ($message = CustomerDocument::create($validated)) {

            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.customer.documents',$customer->id)
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



}
