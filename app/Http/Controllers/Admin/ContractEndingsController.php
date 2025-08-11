<?php


namespace App\Http\Controllers\Admin;

use App\Classes\Telegram;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\Service;
use App\Models\Category;
use App\Models\SubscriptionRenewal;
use App\Models\SubscriptionUpgrade;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractEndingsController extends Controller
{
   
 //
   public function create()
    {
        return view('admin.contract-endings.add',[
            'subscriptions' => Subscription::where('status', 1)->get()
        ]);
    }
    

  public function isscontrols()
    {
      
        
        $date = Carbon::parse('now');
        
        return view('admin.contract-endings.isscontrols', $this->viewData(), [
 
 // START 15 GÜN GÜNCELL        
            'subsupgradesalti' => DB::table('subscriptions')
          
            ->join('services','subscriptions.service_id','=','services.id')
            ->join('customers','customers.id','=','subscriptions.customer_id')
            ->join('customer_staff','customers.id','=','customer_staff.customer_id')
           // ->join('staff','staff.id','=','customer_staff.staff_id')
           // ->select('subscriptions.*')
            //->join('renewal','renewal.id','=','subscriptions.subscription_id')
            
            ->join('subscription_renewals','subscription_renewals.subscription_id','=','subscriptions.id')
            
           // ->join('staff','staff.id','=','subscription_renewals.staff_id')

            ->join('staff','staff.id','=','customer_staff.staff_id')



           //->where('subscription_renewals.created_at', '>=', '2022-12-10')
           
            
            //->where('subscriptions.options','like','%"modem":"2"%')
            //->orWhere('subscriptions.options','like','%"modem":"3"%')
             //->where('subscriptions.options','=',"")
             
             ->where('subscriptions.status','=',1)  
            //->where('subscriptions.id','=',8175)
           // ->where('subscriptions.end_date', 'like', "%2023-03-03%")
              ->where('subscriptions.end_date', '=', date('Y-m-d',strtotime($date. ' +15 days')))
            //  ->where('subscriptions.end_date', '>=', date('Y-m-d',strtotime($date. ' +14 days')))
              ->where('subscription_renewals.created_at', '>=', date('Y-m-d',strtotime($date. '-32 days')))
              ->where('subscription_renewals.status','=',0)  
               
              
             

               // ->whereNotNull('subscriptions.options','=','')

         
            ->orderBy(DB::raw("subscriptions.end_date"), 'DESC')
            // ->orderBy(DB::raw("staff.first_name"), 'DESC')->distinct()
            
            ->select(DB::raw('
             customers.id AS customer_id,
            CONCAT(
               
                customers.first_name,
                " ",
                customers.last_name
            ) AS isim, 
         

            subscription_renewals.status AS status,
            subscription_renewals.subscription_id AS subscription_id,
            subscription_renewals.new_price AS new_price,
            subscription_renewals.new_commitment AS new_commitment,
            staff.first_name AS first_name,
            staff.last_name AS last_name,
            
            customers.telephone AS telephone,
            services.name AS name,
            subscriptions.end_date AS bitistarihi,
            subscriptions.options AS Options,
            subscriptions.price AS price,
            
             subscriptions.id AS id,
             subscriptions.staff_id AS staff_id,
            staff.first_name AS temsilci'))
            ->get(),
            
            
// END  15 GÜN GÜNCELLENEN 

// START ISS De uzayacaklar
             'subsupgradesyedi' => DB::table('subscriptions')
          
              ->join('services','subscriptions.service_id','=','services.id')
            ->join('customers','customers.id','=','subscriptions.customer_id')
            ->join('customer_staff','customers.id','=','customer_staff.customer_id')
           // ->join('staff','staff.id','=','customer_staff.staff_id')
           // ->select('subscriptions.*')
            //->join('renewal','renewal.id','=','subscriptions.subscription_id')
            
            ->join('subscription_renewals','subscription_renewals.subscription_id','=','subscriptions.id')
            
           // ->join('staff','staff.id','=','subscription_renewals.staff_id')

            ->join('staff','staff.id','=','customer_staff.staff_id')



           //->where('subscription_renewals.created_at', '>=', '2022-12-10')
           
            
            //->where('subscriptions.options','like','%"modem":"2"%')
            //->orWhere('subscriptions.options','like','%"modem":"3"%')
             //->where('subscriptions.options','=',"")
             
             ->where('subscriptions.status','=',1)
            //->where('subscriptions.id','=',8175)
           // ->where('subscriptions.end_date', 'like', "%2023-03-03%")
              ->where('subscriptions.end_date', '=', date('Y-m-d',strtotime($date. ' +10 days')))
             // ->where('subscription_renewals.created_at', '>=', date('Y-m-d',strtotime($date. '-5 days')))
                ->where('subscription_renewals.status','=',0)  
              
             

               // ->whereNotNull('subscriptions.options','=','')


            ->orderBy(DB::raw("subscriptions.end_date"), 'DESC')
            ->orderBy(DB::raw("staff.first_name"), 'ASC')
            
            ->select(DB::raw('
             customers.id AS customer_id,
            CONCAT(
               
                customers.first_name,
                " ",
                customers.last_name
            ) AS isim, 
         

            subscription_renewals.status AS status,
            subscription_renewals.new_price AS new_price,
            subscription_renewals.new_commitment AS new_commitment,
            staff.first_name AS first_name,
            staff.last_name AS last_name,
            
            customers.telephone AS telephone,
            services.name AS name,
            subscriptions.end_date AS bitistarihi,
            subscriptions.options AS Options,
            subscriptions.price AS price,
            
             subscriptions.id AS id,
             subscriptions.staff_id AS staff_id,
            staff.first_name AS temsilci'))
            ->get()

 
     //END ISS De uzayacaklar

        ]);

    }
   
    
    

    
  public function store(SubscriptionRenewal $subscriptionRenewal,Request $request)
    {    
        $request->validate([
          'new_price'=>'required',
        ]);

        $subscriptionRenewal  = new SubscriptionRenewal;
        $subscriptionRenewal->subscription_id = $request->subscription_id; 
        $subscriptionRenewal->staff_id        = $request->staff_id;
        $subscriptionRenewal->new_commitment  = $request->input('new_commitment');
        $subscriptionRenewal->new_price       = $request->input('new_price');

        
         $subscriptionRenewal->save();
      
       // alert()->success('Başarılı!', 'Sayfa Başarılı Bir Şekilde oluşturuldu.');
          //return redirect()->route('admin.contract-endings.list');
          
                return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                 'status'=>201
                 
            ]);
            
          

            
        // return redirect()->back();
       
        
        
       // alert()->success('Başarılı!', 'Makaleniz Başarılı Bir Şekilde oluşturuldu.');
       // return redirect()->route('admin.contract-endings.list');
        
      
            
          //  if($subscriptionRenewal->save())
       //     {
        //          return redirect();
        //    }else{
      //          echo "HATA VAR";
      //     }
                    
      //return view('admin.contract-endings.list',$subscriptionRenewal->subscription_id);
      
    // dd($subscriptionRenewal);
         
 
        
          //$new_price = $request->validate(['new_price' => 'required|numeric'])['new_price'];
          //$new_commitment = $request->validate(['new_commitment' => 'required'])['new_commitment'];
          //$subscription_id = $request->user()->subscription_id;
          //$staff_id = $request->user()->staff_id;
          
        //  $this->validate($request,[
         //   'new_commitment' => 'required',
        //    'new_price' => 'required'
      //  ]);
        
            // $subscription_id     = Subscription::findOrFail($id);
        //     $subscriptionRenewal = new SubscriptionRenewal;

      //  $subscriptionRenewal->new_commitment = $request->input('new_commitment');
     //   $subscriptionRenewal->new_price = $request->input('new_price');
     //   $subscriptionRenewal->subscription_id = $request->input('subscription_id');
     //   $subscriptionRenewal->staff_id = $request->input('staff_id');
        
        //$emps->save();
        //return redirect('/employee')->with('success', 'Data saved');
          //     return view('admin.contractending.post',[
          //  'subscriptions' => Subscription::where('status', 1)->get()
       // ]);
       
      // return view('admin.contract-endings.list');
      
 
    }
    
    
    
   public function ekle(Subscription $subsupend)
    {
      return view('admin.contractending.ekle',['subscriptions' => $subsupend]);
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
     
      public function ekleme($id)
    {     
         
        $subsupend=Subscription::findOrFail($id);
        $subsupgrades=Subscription::all();
        
         $subsupendiki=Subscription::findOrFail($id);
         $subsupgradesiki=Subscription::all();
         
         $subsupgradesdortend=Subscription::findOrFail($id);
         $subsupgradesdort=Subscription::all();
        
         $subsupgradesbesend=Subscription::findOrFail($id);
         $subsupgradesbes=Subscription::all();
        
        return view('admin.contract-endings.ekleme',compact('subsupend','subsupgrades','subsupendiki','subsupgradesiki','subsupgradesdortend','subsupgradesdort','subsupgradesbesend','subsupgradesbes'));
        
            

    }
    
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
        
        return view('admin.contract-endings.list', $this->viewData(), [
  //   START  43-45 GÜN GÜNCELL        
                 'subsupgrades' => DB::table('subscriptions')
    ->leftJoin(DB::raw('
        (SELECT p1.*
         FROM payments p1
         INNER JOIN (
             SELECT subscription_id, MAX(created_at) AS max_date
             FROM payments
             GROUP BY subscription_id
         ) p2 ON p1.subscription_id = p2.subscription_id AND p1.created_at = p2.max_date
        ) as payments
    '), 'payments.subscription_id', '=', 'subscriptions.id')
    ->join('services', 'subscriptions.service_id', '=', 'services.id')
    ->join('customers', 'customers.id', '=', 'subscriptions.customer_id')
    ->join('customer_staff', 'customers.id', '=', 'customer_staff.customer_id')
    ->join('subscription_renewals', 'subscription_renewals.subscription_id', '=', 'subscriptions.id')
    ->join('staff', 'staff.id', '=', 'subscription_renewals.staff_id')
    ->where('subscriptions.status', '=', 1)
  ->where('subscriptions.end_date', '>=', date('Y-m-d', strtotime($date . ' +32 days')))
->where('subscriptions.end_date', '<=', date('Y-m-d', strtotime($date . ' +45 days')))

    ->where('subscription_renewals.created_at', '>=', date('Y-m-d', strtotime($date . ' -5 days')))
    ->where('subscription_renewals.status', '=', 0)
   
    ->orderBy(DB::raw("subscription_renewals.id"), 'DESC')
    ->distinct()  // Verilerin tekrarlanmaması için DISTINCT ekledim
    ->select(DB::raw('
        customers.id AS customer_id,
        CONCAT(customers.first_name, " ", customers.last_name) AS isim,
        subscription_renewals.status AS status,
        subscription_renewals.new_price AS new_price,
        staff.first_name AS first_name,
        staff.last_name AS last_name,
        customers.telephone AS telephone,
        services.name AS name,
        subscriptions.end_date AS bitistarihi,
        subscriptions.options AS Options,
        subscriptions.price AS price,
        subscriptions.id AS id,
        subscriptions.staff_id AS staff_id,
        staff.first_name AS temsilci,
        payments.price AS payment_amount,
        payments.created_at AS payment_date
    '))
    ->get(),


// END  43-45 GÜN GÜNCELLENEN 



// END  43-45 GÜN GÜNCELLENMEYEN 

            

             'subsupgradesiki' => DB::table('subscriptions')

          

            ->join('services','subscriptions.service_id','=','services.id')

            ->join('customers','customers.id','=','subscriptions.customer_id')

            ->join('customer_staff','customers.id','=','customer_staff.customer_id')

            ->join('staff','staff.id','=','customer_staff.staff_id')

       // İBRAHİM     ->leftJoin('subscription_renewals','subscription_renewals.subscription_id','=','subscriptions.id')

          // ->where('subscription_renewals.created_at', 'like', "%2023-01-20%")

        // İBRAHİM    ->where('subscription_renewals.subscription_id')



       ->where('subscriptions.end_date', '>=', date('Y-m-d',strtotime($date. ' +32 days')))

       //45 RZGR

       ->where('subscriptions.end_date', '<=', date('Y-m-d',strtotime($date. ' +45 days')))

        

      //  ->where('subscriptions.id','=',8175)
     //   ->where('subscription_renewals.created_at', '>=', date('Y-m-d H:i:s',strtotime($date. '-5 days')))

        // ->where('subscriptions.end_date', '>=', date('Y-m-d',strtotime($date. '+40 days')))

        // ->where('subscriptions.end_date', 'like', "%2023-02-28%")
            ->where('subscriptions.status','=',1)
        



            

            ->orderBy(DB::raw("subscriptions.end_date"), 'DESC')

            ->select(DB::raw('

             customers.id AS customer_id,

            CONCAT(

               

                customers.first_name,

                " ",

                customers.last_name

            ) AS isim,

             

            customers.telephone AS telephone,

            services.name AS tarife,

            subscriptions.price AS price,

            subscriptions.end_date AS bitistarihi,

            subscriptions.options AS Options,

            

             subscriptions.id AS id,

            staff.first_name AS temsilci'))

            ->get(),

            

// END  43-45 GÜN GÜNCELLENMEYEN             

            

//   START  30 GÜN GÜNCELL 

          'subsupgradesdort' => DB::table('subscriptions')
    ->join('services', 'subscriptions.service_id', '=', 'services.id')
    ->join('customers', 'customers.id', '=', 'subscriptions.customer_id')
    ->join('customer_staff', 'customers.id', '=', 'customer_staff.customer_id')
    ->join('subscription_renewals', 'subscription_renewals.subscription_id', '=', 'subscriptions.id')
    ->join('staff', 'staff.id', '=', 'subscription_renewals.staff_id')
    ->where('subscriptions.status', '=', 1)
    ->where('subscription_renewals.status', '=', 0)
    ->where('subscriptions.end_date', '>=', date('Y-m-d', strtotime($date)))
    ->where('subscriptions.end_date', '<=', date('Y-m-d', strtotime($date . ' +33 days')))
    ->where('subscription_renewals.created_at', '>=', date('Y-m-d', strtotime($date . ' -5 days')))
    ->orderBy(DB::raw("subscriptions.end_date"), 'DESC')
    ->distinct()  // Verilerin iki kez dönmemesi için DISTINCT kullanıyoruz
    ->select(DB::raw('
        customers.id AS customer_id,
        CONCAT(customers.first_name, " ", customers.last_name) AS isim,
        subscription_renewals.status AS status,
        subscription_renewals.new_price AS new_price,
        staff.first_name AS first_name,
        staff.last_name AS last_name,
        customers.telephone AS telephone,
        services.name AS name,
        subscriptions.end_date AS bitistarihi,
        subscriptions.options AS Options,
        subscriptions.price AS price,
        subscriptions.id AS id,
        subscriptions.staff_id AS staff_id,
        staff.first_name AS temsilci
    '))
    ->get(),

            

    // END 30 GÜN GÜNCELENEN

    

    //START 30 GÜN GÜNCELLENMEYEN

    

                 'subsupgradesbes' => DB::table('subscriptions')

          

            ->join('services','subscriptions.service_id','=','services.id')

            ->join('customers','customers.id','=','subscriptions.customer_id')

            ->join('customer_staff','customers.id','=','customer_staff.customer_id')

            ->join('staff','staff.id','=','customer_staff.staff_id')

            ->leftJoin('subscription_renewals','subscription_renewals.subscription_id','=','subscriptions.id')

          // ->where('subscription_renewals.created_at', 'like', "%2023-01-20%")

              ->where('subscription_renewals.subscription_id')



      //  ->where('subscriptions.end_date', '>=', date('Y-m-d',strtotime($date. ' +44 days')))

      

           ->where('subscriptions.end_date', '>=', date('Y-m-d',strtotime($date))) 

          //->where('subscriptions.end_date', '>=', date('Y-m-d',strtotime($date. ' +0 days'))) 

          ->where('subscriptions.end_date', '<=', date('Y-m-d',strtotime($date. ' +32 days')))

       // ->where('subscriptions.end_date', '=', date('Y-m-d',strtotime($date. ' +30 days')))

       

       

       

     //   ->where('subscription_renewals.created_at', '>=', date('Y-m-d H:i:s',strtotime($date. '-5 days')))

        // ->where('subscriptions.end_date', '>=', date('Y-m-d',strtotime($date. '+40 days')))

        // ->where('subscriptions.end_date', 'like', "%2023-02-28%")

            ->where('subscriptions.status','=',1)

            

        

        

            



            

            ->orderBy(DB::raw("subscriptions.end_date"), 'DESC')

            ->select(DB::raw('
             
             customers.id AS customer_id,

            CONCAT(

               

                customers.first_name,

                " ",

                customers.last_name

            ) AS isim,

         

         customers.telephone AS telephone,

            services.name AS tarife,
            services.id As serviceId,
            subscriptions.price AS price,

            subscriptions.end_date AS bitistarihi,

            subscriptions.options AS Options,

            

             subscriptions.id AS id,

            staff.first_name AS temsilci'))

            ->get(),

    

    //END 30 GÜN GÜNCELLENMEYEN

    
    // START 1 GÜN GÜNCELLENMEYEN
    
             'subsupgradesuc' => DB::table('subscriptions')
          
            ->join('services','subscriptions.service_id','=','services.id')
            ->join('customers','customers.id','=','subscriptions.customer_id')
            ->join('customer_staff','customers.id','=','customer_staff.customer_id')
            ->join('staff','staff.id','=','customer_staff.staff_id')
            //1 RZGR
            ->where('subscriptions.end_date', '=', date('Y-m-d',strtotime($date. ' +45 days')))
    //       ->where('subscriptions.end_date', '>=', date('Y-m-d',strtotime($date. '+40 days')))
            ->where('subscriptions.status','=',1)
            
            ->orderBy(DB::raw("subscriptions.end_date"), 'DESC')
            ->select(DB::raw('
             customers.id AS customer_id,
            CONCAT(
               
                customers.first_name,
                " ",
                customers.last_name
            ) AS isim,
         
         customers.telephone AS telephone,
            services.name AS tarife,
            subscriptions.end_date AS bitistarihi,
            
             subscriptions.id AS szmid,
             subscriptions.options AS Options,
            staff.first_name AS temsilci'))
            ->get()

        ]);

    }
    

  
  
   
}
