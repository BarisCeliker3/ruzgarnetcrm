<?php


namespace App\Http\Controllers\Admin;

use App\Classes\Telegram;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\Service;
use App\Models\Rcb;
use App\Models\Category;
use App\Models\SubscriptionRenewal;
use App\Models\SubscriptionUpgrade;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RcbController extends Controller
{
   

   public function rcbs()
    {
        return view('admin.rcb.list',[
            'subscriptions' => Subscription::where('status', 1)->get()
        ]);
    }
    
   public function edit($id)
    {     
         $subsupendiki=Rcb::with('customer','service','staff','subscription')->findOrFail($id);
         $subsupgradesiki=Rcb::all();
  
        return view('admin.rcb.edit',compact('subsupendiki','subsupgradesiki'));
        
    }
    
      public function ekleme($id)
    {     
         
        $subsupend=Subscription::with('customer','service','staff')->findOrFail($id);
        $subsupgrades=Subscription::all();
        
      //   $subsupendiki=Subscription::with('customer','service','staff')->findOrFail($id);
        // $subsupgradesiki=Subscription::all();
        
        
        return view('admin.rcb.ekleme',compact('subsupend','subsupgrades'));
        
    }
    
   public function rapor()
    {     

         $date = Carbon::parse('now');
        
        return view('admin.rcb.rapor', $this->viewData(), [


 //  START  rcb aranlar       
            'subsupgradesiki' => DB::table('rcbs')

             ->join('subscriptions','subscriptions.id','=','rcbs.subscription_id')
             ->join('services','services.id','=','rcbs.service_id')
             ->join('customers','customers.id','=','rcbs.customer_id')
           //  ->join('customers','customers.id','=','subscriptions.customer_id')
             
             
            
           // ->join('staff','staff.id','=','customer_staff.staff_id')
            ->join('staff','staff.id','=','rcbs.staff_id')
            
          //   ->join('staff','staff.id','=','rcbs.staff_id')
            
      //      ->join('subscription_renewals','subscription_renewals.subscription_id','=','subscriptions.id')
            
         //   ->join('staff','staff.id','=','subscription_renewals.staff_id')

           //->where('subscription_renewals.created_at', '>=', '2022-12-10')
           
            
            //->where('subscriptions.options','like','%"modem":"2"%')
            //->orWhere('subscriptions.options','like','%"modem":"3"%')
           // ->where('rcbs.subscription_id')
             
             ->where('subscriptions.status','=',1)
            //->where('subscriptions.id','=',8175)
           // ->where('subscriptions.end_date', 'like', "%2023-03-03%")
           //  ->where('subscriptions.end_date', '>=', date('Y-m-d',strtotime($date. ' +43 days')))
             
            //  ->where('subscriptions.approved_at', '>=', date('Y-m-d',strtotime($date. '-6 days')))
            //  ->where('subscriptions.approved_at', '<=', date('Y-m-d',strtotime($date. '-4 days')))

            //  ->where('subscription_renewals.created_at', '>=', date('Y-m-d',strtotime($date. '-5 days')))


               // ->whereNotNull('subscriptions.options','=','')


            ->orderBy(DB::raw("rcbs.id"), 'DESC')
            
            ->select(DB::raw('
            customers.id AS customer_id,
            CONCAT(
               
                customers.first_name,
               
                " ",
                customers.last_name
            ) AS isim, 
         
             customers.telephone,
             customers.first_name as first_name,
              customers.last_name as last_name, 
             services.name AS name, 

             staff.first_name AS first_name,
             staff.last_name AS last_name,
             staff.first_name AS temsilci,
             
              rcbs.id AS id,
              rcbs.staff_id AS staff_id,
              rcbs.note AS note,
              rcbs.status AS status,
              rcbs.result AS result,
              rcbs.created_at AS created_at'))
              ->get()
        ]);
        
        // END  arananlar

        
    }
    
    
  public function editPost(Request $request, $id)
  {
       
       $subsupendiki= Rcb::findOrFail($id);

       $subsupendiki->note=$request->note;
       $subsupendiki->status=$request->status;
       $subsupendiki->result=$request->result;
        $subsupendiki->save();

         
         return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.edit.success')
                ],
                'redirect' => relative_route('admin.rcbs')
            ]);
            
  }
    

    
public function store(Rcb $rcbs , Request $request)
    {    
        $request->validate([
          'note'=>'required',
        ]);
        
       $rcbs  = new Rcb;
       $rcbs->subscription_id = $request->subscription_id; 
       $rcbs->service_id      = $request->service_id;
       $rcbs->customer_id     = $request->customer_id;
       $rcbs->staff_id        = $request->staff_id;
       $rcbs->note            = $request->input('note');
       $rcbs->status          = $request->input('status');
       $rcbs->result          = $request->input('result');

       $rcbs->save();
                return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.rcbs')
            ]);
    }
    

    
    
 public function viewData()
    {
        $categories = Category::where('status', 1)->where('type', 2)->get();

        $option_fields = [];
        foreach ($categories as $category) {
            $option_fields[$category->key] = $category->option_fields;
        }

        $services = Service::where('status', 1)->orderBy('id','desc')->get();
        
    


        $service_props = [];
        foreach ($services as $service) {
            $service_props[$service->id] = [
                'price' => $service->price,
                'category' => $service->category->key
            ];
        }

        $data = [
            'services' => Service::where('status', 1)->orderByRaw('name * 1')->get(),
            'customers' => Customer::where('type', '<>', 1)->orderBy('id', 'DESC')->get(),
            'subscriptions' => Subscription::whereIn('status',[0,1,2])->orderBy('id', 'DESC')->get(),
            'option_fields' => $option_fields,
            'service_props' => $service_props
        ];
       
       return $data;
    }
    
    
    
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     

    
        public static function renewal(Subscription $subscription, int $staff_id, int $new_commitment, float $price)
    {
        self::where('status', 0)->where('subscription_id', $subscription->id)->update(['status' => 2]);

        return self::create([
            'subscription_id' => $subscription->id,
            'staff_id' => $staff_id,
            'new_commitment' => $new_commitment,
            'new_price' => $price,
            'status' => 0
        ]);
    }
    
        public function index(Request $request)
    {      

           
        $date = Carbon::parse('now');
        
        return view('admin.rcb.list', $this->viewData(), [
    //  START  43-45 GÜN GÜNCELL        
            'subsupgrades' => DB::table('subscriptions')
          
            ->join('services','subscriptions.service_id','=','services.id')
            ->join('customers','customers.id','=','subscriptions.customer_id')
            ->join('customer_staff','customers.id','=','customer_staff.customer_id')
            ->join('staff','staff.id','=','customer_staff.staff_id')
            // ->select('subscriptions.*')
             ->leftJoin('rcbs','rcbs.subscription_id','=','subscriptions.id')
            
      //      ->join('subscription_renewals','subscription_renewals.subscription_id','=','subscriptions.id')
            
         //   ->join('staff','staff.id','=','subscription_renewals.staff_id')

           //->where('subscription_renewals.created_at', '>=', '2022-12-10')
           
            
            //->where('subscriptions.options','like','%"modem":"2"%')
            //->orWhere('subscriptions.options','like','%"modem":"3"%')
            ->where('rcbs.subscription_id')
             ->where('subscriptions.status','=',1)
            //->where('subscriptions.id','=',8175)
           // ->where('subscriptions.end_date', 'like', "%2023-03-03%")
           //  ->where('subscriptions.end_date', '>=', date('Y-m-d',strtotime($date. ' +43 days')))
             
              ->where('subscriptions.approved_at', '>=', date('Y-m-d',strtotime($date. '-6 days')))
              ->where('subscriptions.approved_at', '<=', date('Y-m-d',strtotime($date. '-4 days')))

            //  ->where('subscription_renewals.created_at', '>=', date('Y-m-d',strtotime($date. '-5 days')))


               // ->whereNotNull('subscriptions.options','=','')


            ->orderBy(DB::raw("rcbs.id"), 'DESC')
            
            ->select(DB::raw('
             customers.id AS customer_id,
            CONCAT(
               
                customers.first_name,
               
                " ",
                customers.last_name
            ) AS isim, 
         
             customers.telephone,
             
           
            staff.first_name AS first_name,
            staff.last_name AS last_name,
            
            services.name AS name,
            subscriptions.end_date AS bitistarihi,
            subscriptions.approved_at AS approved_at,
            subscriptions.options AS Options,
            subscriptions.price AS price,
            
             subscriptions.id AS id,
             subscriptions.staff_id AS staff_id,
            staff.first_name AS temsilci'))
            ->get(),
// END  aranmayanlar

 //  START  rcb aranlar       
            'subsupgradesiki' => DB::table('rcbs')

             ->join('subscriptions','subscriptions.id','=','rcbs.subscription_id')
             ->join('services','services.id','=','rcbs.service_id')
             ->join('customers','customers.id','=','rcbs.customer_id')
           //  ->join('customers','customers.id','=','subscriptions.customer_id')
             
             
            
           // ->join('staff','staff.id','=','customer_staff.staff_id')
            ->join('staff','staff.id','=','rcbs.staff_id')
            
          //   ->join('staff','staff.id','=','rcbs.staff_id')
            
      //      ->join('subscription_renewals','subscription_renewals.subscription_id','=','subscriptions.id')
            
         //   ->join('staff','staff.id','=','subscription_renewals.staff_id')

           //->where('subscription_renewals.created_at', '>=', '2022-12-10')
           
            
            //->where('subscriptions.options','like','%"modem":"2"%')
            //->orWhere('subscriptions.options','like','%"modem":"3"%')
           // ->where('rcbs.subscription_id')
             
             ->where('subscriptions.status','=',1)
            //->where('subscriptions.id','=',8175)
           // ->where('subscriptions.end_date', 'like', "%2023-03-03%")
           //  ->where('subscriptions.end_date', '>=', date('Y-m-d',strtotime($date. ' +43 days')))
             
              ->where('subscriptions.approved_at', '>=', date('Y-m-d',strtotime($date. '-6 days')))
              ->where('subscriptions.approved_at', '<=', date('Y-m-d',strtotime($date. '-4 days')))

            //  ->where('subscription_renewals.created_at', '>=', date('Y-m-d',strtotime($date. '-5 days')))


               // ->whereNotNull('subscriptions.options','=','')


            ->orderBy(DB::raw("rcbs.id"), 'DESC')
            
            ->select(DB::raw('
            customers.id AS customer_id,
            CONCAT(
               
                customers.first_name,
               
                " ",
                customers.last_name
            ) AS isim, 
         
             customers.telephone,
             customers.first_name as first_name,
              customers.last_name as last_name, 
             services.name AS name, 

             staff.first_name AS first_name,
             staff.last_name AS last_name,
             staff.first_name AS temsilci,
             
              rcbs.id AS id,
              rcbs.staff_id AS staff_id,
              rcbs.note AS note,
              rcbs.status AS status,
              rcbs.result AS result,
              rcbs.created_at AS created_at


'))
            ->get()
// END  arananlar



        ]);

    }
    
    

  
  
   
}
