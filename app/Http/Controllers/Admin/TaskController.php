<?php



namespace App\Http\Controllers\Admin;

use App\Classes\Moka;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Payment;

use App\Models\Task;

use App\Models\Task1;

use App\Models\Duty;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

use Illuminate\Support\Carbon;

use Illuminate\Validation\Rule;





use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Models\Customer;

use App\Models\Subscription;

use App\Models\Service;

use App\Models\Category;





use Illuminate\Support\Facades\DB;



class TaskController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Contracts\View\View

     */

     

    public function index()

    {

        $users = isset(request()->user()->staff) ? request()->user()->staff->id : request()->user()->staff_id ;

        return view('admin.task.list', ['tasks' => Task::orderBy('id','DESC')->where('tasks.user_id',$users)->get()]);

       

    //   return view('admin.task.list', ['tasks' => Task::orderBy('id','DESC')->get()]);



    }

    

    

    

    

    /**/

    

      public function store(Task $task,Request $request)

    {

        



     //   $task=new Task; 

      //  $task->roles_id=$request->roles_id;

      //  $task->user_id=$request->staff_id;

        

      //  $task->name_lastname=$request->name_lastname;

      //  $task->task1=$request->task1;

      //  $task->task2=$request->task2;

      //  $task->task3=$request->task3;

      //  $task->task4=$request->task4;

      //  $task->task5=$request->task5;

      //  $task->task6=$request->task6;

      //  $task->task7=$request->task7;

      //  $task->task8=$request->task8;



        

       // $task->task    = $request->input('task');

        //$task->unit    = $request->input('unit');

        //$task->user_id = $request->input('staff_id');



         

        $task->save();

      // alert('Görev başarılı bir şekilde oluşturuldu');

       // return redirect()->route('admin.task.list');

        

        return response()->json([

                'success' => true,

                'toastr' => [

                    'type' => 'success',

                    'title' => trans('response.title.success'),

                    'message' => trans('response.insert.success')

                ],

                 'status'=>201

            ]);

        

    }

    

    

  public function assignments()

    {

      

      //2tane şart var biri her kullanıcın idsine göre diğeri roles id göre

        $users = isset(request()->user()->staff) ? request()->user()->staff->id : request()->user()->staff_id ;

        $date = Carbon::parse('now');

        

        return view('admin.task.assignments', $this->viewData(), [

            'tasks' => DB::table('tasks')

          

        //  ->join('staff','staff.id','=','tasks.user_id')

         //  ->join('users','users.staff_id','=', 'tasks.user_id')

           //  ->join('users','users.role_id','=', 'tasks.roles_id')

            ->join('roles','roles.id', '=', 'tasks.roles_id')

             

            ->where('tasks.roles_id', '!=' ,'7') 

            ->Where('tasks.roles_id', '!=' ,'6') 

            ->Where('tasks.roles_id', '!=' ,'8')

            ->Where('tasks.roles_id', '!=' ,'9')

            //işten ayrılan kişilerin id'lerine göre sıralama burada gerçekleştiriliyor.

            ->where('tasks.user_id', '!=', 41)

            ->Where('tasks.user_id', '!=' ,'56')

            ->where('tasks.user_id', '!=', 57)

            ->where('tasks.user_id', '!=', 46)

            // ->where('tasks.roles_id', '=' ,'roles.id') 

            //->where('tasks.user_id', '=' ,'staff.staff_id')

        //   ->where('tasks.status','=',0) 

         // ->where('tasks.user_id',$users)

            

           // ->where('isset(request()->user()->staff)')

            

            ->orderBy(DB::raw("tasks.created_at"), 'DESC')

            

            ->select(DB::raw('

             tasks.id AS id,

            tasks.name_lastname AS name_lastname,

            tasks.task1 AS task1,

            tasks.status1 AS status1,

            

            tasks.task2 AS task2,

            tasks.status2 AS status2,

            

            tasks.task3 AS task3,

            tasks.status3 AS status3,

            

            tasks.task4 AS task4,

            tasks.status4 AS status4,

            

            tasks.task5 AS task5,

            tasks.status5 AS status5,

            

            tasks.roles_id AS roles_id,

            tasks.created_at AS created_at'))

            ->get(),

            

            

            'tasks2' => DB::table('tasks2')

          

        //  ->join('staff','staff.id','=','tasks.user_id')

         //  ->join('users','users.staff_id','=', 'tasks.user_id')

           //  ->join('users','users.role_id','=', 'tasks.roles_id')

            //->join('roles','roles.id', '=', 'tasks.roles_id')



           ->where('tasks2.roles_id', '!=' ,'7') 

           ->Where('tasks2.roles_id', '!=' ,'8')

         //  ->where('tasks2.created_at', 'like', "%2023-01-25%")

           ->where('tasks2.created_at', '<=', date('Y-m-d',strtotime($date. ' 0 days')))

           ->where('tasks2.created_at', '>=', date('Y-m-d',strtotime($date. ' -1 days')))

           // ->where('subscription_renewals.created_at', '>=', date('Y-m-d',strtotime($date. '-32 days')))

            // ->where('tasks.roles_id', '=' ,'roles.id') 

            //->where('tasks.user_id', '=' ,'staff.staff_id')

        //   ->where('tasks.status','=',0) 

         // ->where('tasks.user_id',$users)

            

           // ->where('isset(request()->user()->staff)')

           

           //->where(DB::raw("(select max('id') from tasks2)"))

           

           

            ->orderBy(DB::raw("tasks2.created_at"), 'ASC')

            ->select(DB::raw('

            tasks2.id AS id,

            tasks2.name_lastname AS name_lastname,

            tasks2.task1 AS task1,

            tasks2.user_id AS user_id,

            tasks2.status1 AS status1,

            

            tasks2.task2 AS task2,

            tasks2.status2 AS status2,

            

            tasks2.task3 AS task3,

            tasks2.status3 AS status3,

            

            tasks2.task4 AS task4,

            tasks2.status4 AS status4,

            

            tasks2.task5 AS task5,

            tasks2.status5 AS status5,

            

            tasks2.roles_id AS roles_id,

            tasks2.created_at AS created_at'))

            ->get(),

            



         

        'goreviYapmayans' => DB::select("select tasks.name_lastname as name_lastname  from tasks 

                left join tasks2

        on tasks.user_id = tasks2.user_id

        and tasks2.created_at BETWEEN CURDATE() - INTERVAL 1 DAY

        AND CURDATE() - INTERVAL 1 SECOND

        where   

         tasks2.user_id is null AND

         tasks.user_id !=10 AND 

         tasks.user_id !=11 AND 

         tasks.user_id !=33 AND 

         tasks.user_id !=37 AND 

         tasks.user_id !=38 AND 

         tasks.user_id !=56 AND

         tasks.user_id !=60 AND

         tasks.user_id !=54 AND

         tasks.user_id != 41 AND

         tasks.user_id !=52 AND

         tasks.user_id != 57 AND

         tasks.user_id != 46 AND

         tasks.user_id != 34 AND

         tasks.user_id != 70 AND

         tasks.user_id != 73 AND

         tasks.user_id != 69

         ")

          

        

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

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Contracts\View\View

     */



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\JsonResponse

     */

    public function create(Request $request)

    {

         //return view('admin.task.detail', ['tasks' => Task::orderBy('id','DESC')->get()]);

      

      

       $date = Carbon::parse('now');

        

        return view('admin.task.detail', $this->viewData(), [

            'tasks' => DB::table('tasks')

          

        //  ->join('staff','staff.id','=','tasks.user_id')

         //  ->join('users','users.staff_id','=', 'tasks.user_id')

           //  ->join('users','users.role_id','=', 'tasks.roles_id')

            ->join('roles','roles.id', '=', 'tasks.roles_id')

             

            ->where('tasks.roles_id', '!=' ,'7') 

            ->Where('tasks.roles_id', '!=' ,'6') 

           

            // ->where('tasks.roles_id', '=' ,'roles.id') 

            //->where('tasks.user_id', '=' ,'staff.staff_id')

        //   ->where('tasks.status','=',0) 

         // ->where('tasks.user_id',$users)

            

           // ->where('isset(request()->user()->staff)')

            

            ->orderBy(DB::raw("tasks.created_at"), 'DESC')

            

            ->select(DB::raw('

            tasks.id AS id,

            tasks.user_id AS user_id,

            tasks.roles_id AS roles_id,

            tasks.name_lastname AS name_lastname,

            tasks.task1 AS task1,

            tasks.status1 AS status1,

            

            tasks.task2 AS task2,

            tasks.status2 AS status2,

            

            tasks.task3 AS task3,

            tasks.status3 AS status3,

            

            tasks.task4 AS task4,

            tasks.status4 AS status4,

            

            tasks.task5 AS task5,

            tasks.status5 AS status5,

            

            tasks.roles_id AS roles_id,

            tasks.created_at AS created_at'))

            ->get()

            ]);

            

    }

    

      public function postadd(Request $request)

  {

    

   

       $tasks=new Task; 

       

      

       $tasks->user_id=$request->user_id;

       $tasks->roles_id=$request->roles_id;

       $tasks->name_lastname=$request->name_lastname;



       $tasks->task1=$request->task1;

       $tasks->task2=$request->task2;

       $tasks->task3=$request->task3;

       $tasks->task4=$request->task4;

       $tasks->task5=$request->task5;



        $tasks->save();

       // alert()->success('Başarılı!', 'Sayfanız Başarılı Bir Şekilde Güncellendi.');

         // return redirect()->route('admin.task.edit');

         

         

          return response()->json([

                'success' => true,

                'toastr' => [

                    'type' => 'success',

                    'title' => trans('response.title.success'),

                    'message' => trans('response.insert.success')

                ],

                 'status'=>201

            ]);

            



  }

  

   public function satisraports()

  {   

      $satis8=DB::select("

         SELECT MONTH(subscriptions.approved_at)  as created_at, 

                      staff.first_name as first_name, 

                      staff.last_name as last_name, COUNT(staff.id) as id FROM subscriptions

	

    INNER JOIN customers ON subscriptions.customer_id = customers.id

	INNER JOIN customer_staff ON customers.id = customer_staff.customer_id

    INNER JOIN staff ON customer_staff.staff_id = staff.id    

    

	 WHERE YEAR(subscriptions.approved_at) = YEAR(now()) AND subscriptions.status='1' AND staff.status21 ='1' AND customer_staff.staff_id = '54'

        GROUP BY staff.first_name,staff.last_name,MONTH(subscriptions.approved_at)

        ORDER BY MONTH(subscriptions.approved_at)

        ASC

     ");

     

       $satis7=DB::select("

         SELECT MONTH(subscriptions.approved_at)  as created_at, 

                      staff.first_name as first_name, 

                      staff.last_name as last_name, COUNT(staff.id) as id FROM subscriptions

	

    INNER JOIN customers ON subscriptions.customer_id = customers.id

	INNER JOIN customer_staff ON customers.id = customer_staff.customer_id

    INNER JOIN staff ON customer_staff.staff_id = staff.id    

    

	 WHERE YEAR(subscriptions.approved_at) = YEAR(now()) AND subscriptions.status='1' AND staff.status21 ='1' AND customer_staff.staff_id = '53'

        GROUP BY staff.first_name,staff.last_name,MONTH(subscriptions.approved_at)

        ORDER BY MONTH(subscriptions.approved_at)

        ASC

     ");

     

      $satis6=DB::select("

         SELECT MONTH(subscriptions.approved_at)  as created_at, 

                      staff.first_name as first_name, 

                      staff.last_name as last_name, COUNT(staff.id) as id FROM subscriptions

	

    INNER JOIN customers ON subscriptions.customer_id = customers.id

	INNER JOIN customer_staff ON customers.id = customer_staff.customer_id

    INNER JOIN staff ON customer_staff.staff_id = staff.id    

    

	 WHERE YEAR(subscriptions.approved_at) = YEAR(now()) AND subscriptions.status='1' AND staff.status21 ='1' AND customer_staff.staff_id = '49'

        GROUP BY staff.first_name,staff.last_name,MONTH(subscriptions.approved_at)

        ORDER BY MONTH(subscriptions.approved_at)

        ASC

     ");

     

       $satis5=DB::select("

         SELECT MONTH(subscriptions.approved_at)  as created_at, 

                      staff.first_name as first_name, 

                      staff.last_name as last_name, COUNT(staff.id) as id FROM subscriptions

	

    INNER JOIN customers ON subscriptions.customer_id = customers.id

	INNER JOIN customer_staff ON customers.id = customer_staff.customer_id

    INNER JOIN staff ON customer_staff.staff_id = staff.id    

    

	 WHERE YEAR(subscriptions.approved_at) = YEAR(now()) AND subscriptions.status='1' AND staff.status21 ='1' AND customer_staff.staff_id = '41'

        GROUP BY staff.first_name,staff.last_name,MONTH(subscriptions.approved_at)

        ORDER BY MONTH(subscriptions.approved_at)

        ASC

     ");

     

      $satis4=DB::select("

         SELECT MONTH(subscriptions.approved_at)  as created_at, 

                      staff.first_name as first_name, 

                      staff.last_name as last_name, COUNT(staff.id) as id FROM subscriptions

	

    INNER JOIN customers ON subscriptions.customer_id = customers.id

	INNER JOIN customer_staff ON customers.id = customer_staff.customer_id

    INNER JOIN staff ON customer_staff.staff_id = staff.id    

    

	 WHERE YEAR(subscriptions.approved_at) = YEAR(now()) AND subscriptions.status='1' AND staff.status21 ='1' AND customer_staff.staff_id = '44'

        GROUP BY staff.first_name,staff.last_name,MONTH(subscriptions.approved_at)

        ORDER BY MONTH(subscriptions.approved_at)

        ASC

     ");

     

// PLATİN TARİDE DEĞİŞİM

    $satis01=DB::select("

         SELECT MONTH(subscriptions.updated_at)  as created_at, 

                      staff.first_name as first_name, 

                      staff.last_name as last_name, COUNT(staff.id) as id FROM subscriptions

	

    INNER JOIN customers ON subscriptions.customer_id = customers.id

	INNER JOIN customer_staff ON customers.id = customer_staff.customer_id

    INNER JOIN staff ON customer_staff.staff_id = staff.id    

    

	 WHERE YEAR(subscriptions.updated_at) = YEAR(now()) AND subscriptions.status='2' AND staff.status21 ='1' AND customer_staff.staff_id = '44'

        GROUP BY staff.first_name,staff.last_name,MONTH(subscriptions.updated_at)

        ORDER BY MONTH(subscriptions.updated_at)

        ASC

     ");

     

     $satis02=DB::select("

         SELECT MONTH(subscriptions.updated_at)  as created_at, 

                      staff.first_name as first_name, 

                      staff.last_name as last_name, COUNT(staff.id) as id FROM subscriptions

	

    INNER JOIN customers ON subscriptions.customer_id = customers.id

	INNER JOIN customer_staff ON customers.id = customer_staff.customer_id

    INNER JOIN staff ON customer_staff.staff_id = staff.id    

    

	 WHERE YEAR(subscriptions.updated_at) = YEAR(now()) AND subscriptions.status='2' AND staff.status21 ='1' AND customer_staff.staff_id = '41'

        GROUP BY staff.first_name,staff.last_name,MONTH(subscriptions.updated_at)

        ORDER BY MONTH(subscriptions.updated_at)

        ASC

     ");

     

     $satis03=DB::select("

         SELECT MONTH(subscriptions.updated_at)  as created_at, 

                      staff.first_name as first_name, 

                      staff.last_name as last_name, COUNT(staff.id) as id FROM subscriptions

	

    INNER JOIN customers ON subscriptions.customer_id = customers.id

	INNER JOIN customer_staff ON customers.id = customer_staff.customer_id

    INNER JOIN staff ON customer_staff.staff_id = staff.id    

    

	 WHERE YEAR(subscriptions.updated_at) = YEAR(now()) AND subscriptions.status='2' AND staff.status21 ='1' AND customer_staff.staff_id = '49'

        GROUP BY staff.first_name,staff.last_name,MONTH(subscriptions.updated_at)

        ORDER BY MONTH(subscriptions.updated_at)

        ASC

     ");

     $satis04=DB::select("

         SELECT MONTH(subscriptions.updated_at)  as created_at, 

                      staff.first_name as first_name, 

                      staff.last_name as last_name, COUNT(staff.id) as id FROM subscriptions

	

    INNER JOIN customers ON subscriptions.customer_id = customers.id

	INNER JOIN customer_staff ON customers.id = customer_staff.customer_id

    INNER JOIN staff ON customer_staff.staff_id = staff.id    

    

	 WHERE YEAR(subscriptions.updated_at) = YEAR(now()) AND subscriptions.status='2' AND staff.status21 ='1' AND customer_staff.staff_id = '53'

        GROUP BY staff.first_name,staff.last_name,MONTH(subscriptions.updated_at)

        ORDER BY MONTH(subscriptions.updated_at)

        ASC

     ");

     

     $satis05=DB::select("

         SELECT MONTH(subscriptions.updated_at)  as created_at, 

                      staff.first_name as first_name, 

                      staff.last_name as last_name, COUNT(staff.id) as id FROM subscriptions

	

    INNER JOIN customers ON subscriptions.customer_id = customers.id

	INNER JOIN customer_staff ON customers.id = customer_staff.customer_id

    INNER JOIN staff ON customer_staff.staff_id = staff.id    

    

	 WHERE YEAR(subscriptions.updated_at) = YEAR(now()) AND subscriptions.status='2' AND staff.status21 ='1' AND customer_staff.staff_id = '54'

        GROUP BY staff.first_name,staff.last_name,MONTH(subscriptions.updated_at)

        ORDER BY MONTH(subscriptions.updated_at)

        ASC

     ");

// -- PLATİN TARİFE DEĞİŞİM

     

       $satis3=DB::select("

     SELECT MONTH(subscriptions.created_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(staff.id) as id FROM  subscriptions 

            INNER JOIN staff ON subscriptions.staff_id = staff.id

            

            WHERE YEAR(subscriptions.created_at) = YEAR(now()) 

            AND subscriptions.status='1' 

            AND staff.status21 ='1' 

            AND subscriptions.staff_id = '34'

            

            GROUP BY staff.first_name,staff.last_name, MONTH(subscriptions.created_at)

            ORDER BY MONTH(subscriptions.created_at) 

     ");

     

      $satis2=DB::select("

     SELECT MONTH(subscriptions.created_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(staff.id) as id FROM  subscriptions 

            INNER JOIN staff ON subscriptions.staff_id = staff.id

            

            WHERE YEAR(subscriptions.created_at) = YEAR(now()) 

            AND subscriptions.status='1' 

            AND staff.status21 ='1' 

            AND subscriptions.staff_id = '39'

            

            GROUP BY staff.first_name,staff.last_name, MONTH(subscriptions.created_at)

            ORDER BY MONTH(subscriptions.created_at) 

           

     ");

     

      $satis1=DB::select("

     SELECT MONTH(subscriptions.created_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(staff.id) as id FROM  subscriptions 

            INNER JOIN staff ON subscriptions.staff_id = staff.id

            

            WHERE YEAR(subscriptions.created_at) = YEAR(now()) 

            AND subscriptions.status='1' 

            AND staff.status21 ='1' 

            AND subscriptions.staff_id = '33'

            

            GROUP BY staff.first_name,staff.last_name, MONTH(subscriptions.created_at)

            ORDER BY MONTH(subscriptions.created_at) 

           

     ");

     

    $aylars2=DB::select("

     SELECT  MONTH(created_at)  as yil, COUNT(id) as id FROM  subscriptions 

        WHERE YEAR(created_at) = YEAR(now())

        GROUP BY MONTH(created_at)

        ORDER BY MONTH(created_at) ASC

     ");

     

         $aylars1=DB::select("

     SELECT  MONTH(created_at)  as yil, COUNT(id) as id FROM  subscriptions 

        WHERE YEAR(created_at) = 2022

        GROUP BY MONTH(created_at)

        ORDER BY MONTH(created_at) ASC

     ");

        

    $yillars2=DB::select("

      SELECT MONTH(subscriptions.approved_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(staff.id) as id FROM  subscriptions 

            

            INNER JOIN customers ON subscriptions.`customer_id` = customers.id

            INNER JOIN customer_staff ON customers.id = customer_staff.`customer_id`

            INNER JOIN staff ON customer_staff.staff_id = staff.id  



            WHERE YEAR(subscriptions.approved_at) = YEAR(now()) AND MONTH(subscriptions.approved_at) = MONTH(now())

            AND subscriptions.status='1' 

            AND staff.status21 ='1' 

            

            

            GROUP BY staff.first_name,staff.last_name, MONTH(subscriptions.approved_at)

            ORDER BY MONTH(subscriptions.approved_at)

     ");

     $yillars4=DB::select("

      SELECT MONTH(subscriptions.updated_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(staff.id) as id FROM  subscriptions 

            

            INNER JOIN customers ON subscriptions.`customer_id` = customers.id

            INNER JOIN customer_staff ON customers.id = customer_staff.`customer_id`

            INNER JOIN staff ON customer_staff.staff_id = staff.id  



            WHERE YEAR(subscriptions.updated_at) = YEAR(now()) AND MONTH(subscriptions.updated_at) = MONTH(now())

            AND subscriptions.status='2' 

            AND staff.status21 ='1' 

            

            GROUP BY staff.first_name,staff.last_name, MONTH(subscriptions.updated_at)

            ORDER BY MONTH(subscriptions.updated_at)

     ");

        

     $yillars=DB::select("

      SELECT MONTH(subscriptions.created_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(staff.id) as id FROM  subscriptions 

            INNER JOIN staff ON subscriptions.staff_id = staff.id

            

            WHERE YEAR(subscriptions.created_at) = YEAR(now()) AND MONTH(subscriptions.created_at) = MONTH(now())



            AND staff.status21 ='1'

            AND staff.id !='11' AND staff.id !='54' AND staff.id !='38' AND staff.id !='41' AND staff.id !='44' AND staff.id !='49' AND staff.id !='53' AND staff.id !='52' 





            GROUP BY staff.first_name,staff.last_name, MONTH(subscriptions.created_at)

            ORDER BY MONTH(subscriptions.created_at) ASC

            

            

     ");

     

      $services=DB::select("

        SELECT COUNT(id) as id FROM `services` 

         ");

         

       $staffs3=DB::select("

       SELECT COUNT(id) as id FROM `staff` WHERE `gender` = 2 AND status21=1

         ");

         

          $staffs2=DB::select("

       SELECT COUNT(id) as id FROM `staff` WHERE `gender` = 1 AND status21=1

         ");

         

         

      $staffs=DB::select(" 

       SELECT COUNT(id) as id FROM `staff` WHERE status21=1

         ");

         

      

       $subscriptions=DB::select("

       SELECT COUNT(id) as id FROM `subscriptions` WHERE `status` = 1

         ");

         

       $customers=DB::select("

       SELECT COUNT(id) as id FROM `customers` WHERE `customer_status` = 1

         ");



        $tarife=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        GROUP BY services.name 

        ORDER BY COUNT(services.id) 

        DESC

     ");

     $satislar = DB::select("
     SELECT 
         DATE(created_at) as gun,   -- Tarih (gün)
         COUNT(*) as adet           -- Satış sayısı
     FROM 
         subscriptions
     WHERE 
         created_at >= CURDATE() - INTERVAL 50 DAY    -- Son 50 gün
         AND status = '1'
     GROUP BY 
         DATE(created_at)
     ORDER BY 
         gun DESC
 ");

     $ocaks=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-01-01 00:00:00.000000' AND '2023-01-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

      $subats=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-02-01 00:00:00.000000' AND '2023-02-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

           $marts=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-03-01 00:00:00.000000' AND '2023-03-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

    $nisans=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-04-01 00:00:00.000000' AND '2023-04-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

         $mayiss=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-05-01 00:00:00.000000' AND '2023-05-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

              $hazirans=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-06-01 00:00:00.000000' AND '2023-06-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

    $temmuzs=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-07-01 00:00:00.000000' AND '2023-07-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

         $agustoss=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-08-01 00:00:00.000000' AND '2023-08-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

         $eyluls=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-09-01 00:00:00.000000' AND '2023-09-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

         $ekims=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-10-01 00:00:00.000000' AND '2023-10-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

         $kasims=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-11-01 00:00:00.000000' AND '2023-11-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

         $araliks=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-12-01 00:00:00.000000' AND '2023-12-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     "); 

     

    $iptal1s=DB::select("

     SELECT MONTH(request_messages.created_at)  as created_at, 

             staff.first_name as first_name, 

             staff.last_name as last_name, COUNT(staff.id) as id FROM request_messages



   INNER JOIN staff ON request_messages.staff_id = staff.id    

	 WHERE YEAR(request_messages.created_at) = YEAR(now()) AND 

                request_messages.talep= 'İptal' AND

                staff.id=44

                

        GROUP BY staff.first_name,staff.last_name,MONTH(request_messages.created_at)

        ORDER BY MONTH(request_messages.created_at)

        ASC;

     "); 

     

         $iptal2s=DB::select("

     SELECT MONTH(request_messages.created_at)  as created_at, 

             staff.first_name as first_name, 

             staff.last_name as last_name, COUNT(staff.id) as id FROM request_messages



   INNER JOIN staff ON request_messages.staff_id = staff.id    

	 WHERE YEAR(request_messages.created_at) = YEAR(now()) AND 

                request_messages.talep= 'İptal' AND

                staff.id=41

                

        GROUP BY staff.first_name,staff.last_name,MONTH(request_messages.created_at)

        ORDER BY MONTH(request_messages.created_at)

        ASC;

     "); 

     

              $iptal3s=DB::select("

     SELECT MONTH(request_messages.created_at)  as created_at, 

             staff.first_name as first_name, 

             staff.last_name as last_name, COUNT(staff.id) as id FROM request_messages



   INNER JOIN staff ON request_messages.staff_id = staff.id    

	 WHERE YEAR(request_messages.created_at) = YEAR(now()) AND 

                request_messages.talep= 'İptal' AND

                staff.id=49

                

        GROUP BY staff.first_name,staff.last_name,MONTH(request_messages.created_at)

        ORDER BY MONTH(request_messages.created_at)

        ASC;

     "); 

     

                   $iptal4s=DB::select("

     SELECT MONTH(request_messages.created_at)  as created_at, 

             staff.first_name as first_name, 

             staff.last_name as last_name, COUNT(staff.id) as id FROM request_messages



   INNER JOIN staff ON request_messages.staff_id = staff.id    

	 WHERE YEAR(request_messages.created_at) = YEAR(now()) AND 

                request_messages.talep= 'İptal' AND

                staff.id=53

                

        GROUP BY staff.first_name,staff.last_name,MONTH(request_messages.created_at)

        ORDER BY MONTH(request_messages.created_at)

        ASC;

     "); 

     

                        $iptal5s=DB::select("

    SELECT MONTH(request_messages.created_at)  as created_at, 

             staff.first_name as first_name, 

             staff.last_name as last_name, COUNT(staff.id) as id FROM request_messages



   INNER JOIN staff ON request_messages.staff_id = staff.id    

	 WHERE YEAR(request_messages.created_at) = YEAR(now()) AND 

                request_messages.talep= 'İptal' AND

                staff.id=54

                

        GROUP BY staff.first_name,staff.last_name,MONTH(request_messages.created_at)

        ORDER BY MONTH(request_messages.created_at)

        ASC;

     "); 

     

                             $buayiptals=DB::select("

SELECT MONTH(subscriptions.created_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(staff.id) as id FROM  subscriptions 

            INNER JOIN staff ON subscriptions.staff_id = staff.id

            

            WHERE YEAR(subscriptions.created_at) = YEAR(now()) AND MONTH(subscriptions.created_at) = MONTH(now())

            AND subscriptions.status ='1'

            AND staff.status21 ='1'

            AND staff.id !='11' AND staff.id !='54' AND staff.id !='38' AND staff.id !='41' AND staff.id !='44' AND staff.id !='49' AND staff.id !='53' AND staff.id !='52'





            GROUP BY staff.first_name,staff.last_name, MONTH(subscriptions.created_at)

            ORDER BY MONTH(subscriptions.created_at) ASC

     "); 

     

                                  $buayiptals2=DB::select("

SELECT MONTH(subscriptions.created_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(staff.id) as id FROM  subscriptions 

            INNER JOIN staff ON subscriptions.staff_id = staff.id

            

            WHERE YEAR(subscriptions.created_at) = YEAR(now()) AND MONTH(subscriptions.created_at) = MONTH(now())

            AND subscriptions.status ='0'

            AND staff.status21 ='1'

            AND staff.id !='11' AND staff.id !='54' AND staff.id !='38' AND staff.id !='41' AND staff.id !='44' AND staff.id !='49' AND staff.id !='53'





            GROUP BY staff.first_name,staff.last_name, MONTH(subscriptions.created_at)

            ORDER BY MONTH(subscriptions.created_at) ASC

     "); 

     

            $satis37=DB::select("

     SELECT MONTH(subscriptions.created_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(staff.id) as id FROM  subscriptions 

            INNER JOIN staff ON subscriptions.staff_id = staff.id

            

            WHERE YEAR(subscriptions.created_at) =  YEAR(now()) 

            AND subscriptions.status='1' 

            AND staff.status21 ='1' 

            AND subscriptions.staff_id = '57'

            

            GROUP BY staff.first_name,staff.last_name, MONTH(subscriptions.created_at)

            ORDER BY MONTH(subscriptions.created_at) 

     ");

     

      $satis60=DB::select("

     SELECT MONTH(subscriptions.created_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(staff.id) as id FROM  subscriptions 

            INNER JOIN staff ON subscriptions.staff_id = staff.id

            

            WHERE YEAR(subscriptions.created_at) =  YEAR(now()) 

            AND subscriptions.status='1' 

            AND staff.status21 ='1' 

            AND subscriptions.staff_id = '60'

            

            GROUP BY staff.first_name,staff.last_name, MONTH(subscriptions.created_at)

            ORDER BY MONTH(subscriptions.created_at) 

     ");

     

     

     

    return view('admin.rapors.satis',compact('satislar','satis60','satis37','buayiptals2','buayiptals','iptal5s','iptal4s','iptal3s','iptal2s','iptal1s','araliks','kasims','ekims','eyluls','agustoss',

                'temmuzs','hazirans','mayiss','nisans','marts','subats','ocaks','tarife',

                'customers','subscriptions','staffs','staffs2','staffs3',

                'services','yillars','yillars4','yillars2','aylars1',

                'aylars2','satis1','satis2','satis3','satis05','satis04','satis03','satis02','satis01','satis4','satis5','satis6','satis7','satis8'));  

  }

  

  

// --SATIŞ  

  

  

// LİSTE

  

   public function servicesraport(Request $request)

  {

       

    $satislar = DB::select("
    SELECT 
        DATE(created_at) as gun,   -- Tarih (gün)
        COUNT(*) as adet           -- Satış sayısı
    FROM 
        subscriptions
    WHERE 
        created_at >= CURDATE() - INTERVAL 50 DAY    -- Son 50 gün
     
    GROUP BY 
        DATE(created_at)
    ORDER BY 
        gun DESC
");

    $satis1=DB::select("

     SELECT MONTH(subscriptions.created_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(staff.id) as id FROM  subscriptions 

            INNER JOIN staff ON subscriptions.staff_id = staff.id

            

            WHERE YEAR(subscriptions.created_at) = YEAR(now()) 

            AND subscriptions.status='1' 

            AND staff.status21 ='1' 

            AND subscriptions.staff_id = '33'

            

            GROUP BY staff.first_name,staff.last_name, MONTH(subscriptions.created_at)

            ORDER BY MONTH(subscriptions.created_at) 

           

     ");

     

    $aylars2=DB::select("

     SELECT  MONTH(created_at)  as yil, COUNT(id) as id FROM  subscriptions 

        WHERE YEAR(created_at) = YEAR(now())

        GROUP BY MONTH(created_at)

        ORDER BY MONTH(created_at) ASC

     ");

     

         $aylars1=DB::select("

     SELECT  MONTH(created_at)  as yil, COUNT(id) as id FROM  subscriptions 

        WHERE YEAR(created_at) = 2022

        GROUP BY MONTH(created_at)

        ORDER BY MONTH(created_at) ASC

     ");

        

    $yillars2=DB::select("

      SELECT YEAR(subscriptions.`created_at`) as created_at, COUNT(id) as id FROM  subscriptions

        GROUP BY YEAR(created_at)

        ORDER BY YEAR(created_at) ASC

     ");

    $yillars3=DB::select("

     SELECT YEAR(subscriptions.`updated_at`) as created_at, COUNT(id) as id FROM  subscriptions

		WHERE subscriptions.`status`= '3'

        GROUP BY YEAR(`updated_at`)

        ORDER BY YEAR(`updated_at`) ASC

     ");

     $aylars4=DB::select("

     SELECT MONTH(subscriptions.`updated_at`) as created_at, COUNT(id) as id FROM  subscriptions

		WHERE subscriptions.`status`= '3' AND YEAR(subscriptions.updated_at) = YEAR(now())

        GROUP BY MONTH(`updated_at`)

        ORDER BY MONTH(`updated_at`) ASC

     ");

        

     $yillars=DB::select("

     SELECT YEAR(customers.`created_at`) as created_at, COUNT(id) as id FROM customers

        GROUP BY YEAR(created_at)

        ORDER BY YEAR(created_at) ASC

     ");

     

      $services=DB::select("

        SELECT COUNT(id) as id FROM `services` 

         ");

         

       $staffs3=DB::select("

       SELECT  COUNT(id) as id FROM `staff` WHERE `gender` = 2 AND status21=1

         ");

         

          $staffs2=DB::select("

       SELECT COUNT(id) as id FROM `staff` WHERE `gender` = 1 AND status21=1

         ");

         

         

      $staffs=DB::select(" 

       SELECT COUNT(id) as id FROM `staff` WHERE status21=1

         ");

         

      

       $subscriptions=DB::select("

       SELECT COUNT(id) as id FROM `subscriptions` WHERE `status` = 1

         ");

         

       $customers=DB::select("

       SELECT COUNT(id) as id FROM `customers` WHERE `customer_status` = 1

         ");



        $tarife=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        GROUP BY services.name 

        ORDER BY COUNT(services.id) 

        DESC

     ");

     

     $ocaks=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-01-01 00:00:00.000000' AND '2023-01-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

      $subats=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-02-01 00:00:00.000000' AND '2023-02-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

           $marts=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-03-01 00:00:00.000000' AND '2023-03-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

    $nisans=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-04-01 00:00:00.000000' AND '2023-04-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

         $mayiss=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-05-01 00:00:00.000000' AND '2023-05-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

              $hazirans=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-06-01 00:00:00.000000' AND '2023-06-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

    $temmuzs=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-07-01 00:00:00.000000' AND '2023-07-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

         $agustoss=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-08-01 00:00:00.000000' AND '2023-08-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

         $eyluls=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-09-01 00:00:00.000000' AND '2023-09-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

         $ekims=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-10-01 00:00:00.000000' AND '2023-10-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

         $kasims=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-11-01 00:00:00.000000' AND '2023-11-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     ");

     

         $araliks=DB::select("

     SELECT services.name as name, COUNT(service_id) as service_id FROM subscriptions 

        INNER JOIN services ON subscriptions.`service_id` = services.id

        WHERE subscriptions.status='1'

        AND subscriptions.approved_at BETWEEN '2023-12-01 00:00:00.000000' AND '2023-12-31 23:59:59.000000' 

        GROUP BY services.name 

        ORDER BY COUNT(services.id)

        DESC

     "); 

     

        $illers=DB::select("

          SELECT cities.name as name, COUNT(customer_info.city_id) as id FROM  customer_info 

            INNER JOIN customers ON customer_info.customer_id = customers.id

            INNER JOIN cities ON customer_info.city_id = cities.id

            GROUP BY cities.name 

            ORDER BY COUNT(customer_info.city_id) DESC LIMIT 10

     "); 

     

     

             $bugunAktif=DB::select("

         SELECT COUNT(subscriptions.id) as id FROM subscriptions 

            INNER JOIN customers ON subscriptions.customer_id = customers.id

            INNER JOIN customer_staff ON customers.id = customer_staff.customer_id

            INNER JOIN staff ON customer_staff.staff_id = staff.id  



            WHERE YEAR(subscriptions.approved_at) = YEAR(now()) 

            AND MONTH(subscriptions.approved_at) = MONTH(now())

            AND DAY(subscriptions.approved_at) = DAY(now())

            AND subscriptions.status='1' 

            AND staff.status21 ='1' 

            ORDER BY COUNT(subscriptions.approved_at)

     "); 

     



         $platiniumAktifListe=DB::select("

        SELECT MONTH(subscriptions.approved_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(staff.id) as id FROM  subscriptions 

            INNER JOIN customers ON subscriptions.`customer_id` = customers.id

            INNER JOIN customer_staff ON customers.id = customer_staff.`customer_id`

            INNER JOIN staff ON customer_staff.staff_id = staff.id  



            WHERE YEAR(subscriptions.approved_at) = YEAR(now()) AND 

            MONTH(subscriptions.approved_at) = MONTH(now()) AND 

            DAY(subscriptions.approved_at) = DAY(now())

            AND subscriptions.status='1' 

            AND staff.status21 ='1'

            AND customer_staff.staff_id = '49'

            

            GROUP BY staff.first_name,staff.last_name, MONTH(subscriptions.approved_at)

            ORDER BY MONTH(subscriptions.approved_at)

     "); 

     

              $platiniumAktifListe44=DB::select("

        SELECT MONTH(subscriptions.approved_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(staff.id) as id FROM  subscriptions 

            INNER JOIN customers ON subscriptions.`customer_id` = customers.id

            INNER JOIN customer_staff ON customers.id = customer_staff.`customer_id`

            INNER JOIN staff ON customer_staff.staff_id = staff.id  



            WHERE YEAR(subscriptions.approved_at) = YEAR(now()) AND 

            MONTH(subscriptions.approved_at) = MONTH(now()) AND 

            DAY(subscriptions.approved_at) = DAY(now())

            AND subscriptions.status='1' 

            AND staff.status21 ='1'

            AND customer_staff.staff_id = '44'

            

            GROUP BY staff.first_name,staff.last_name, MONTH(subscriptions.approved_at)

            ORDER BY MONTH(subscriptions.approved_at)

     "); 

     

                   $platiniumAktifListe41=DB::select("

        SELECT MONTH(subscriptions.approved_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(staff.id) as id FROM  subscriptions 

            INNER JOIN customers ON subscriptions.`customer_id` = customers.id

            INNER JOIN customer_staff ON customers.id = customer_staff.`customer_id`

            INNER JOIN staff ON customer_staff.staff_id = staff.id  



            WHERE YEAR(subscriptions.approved_at) = YEAR(now()) AND 

            MONTH(subscriptions.approved_at) = MONTH(now()) AND 

            DAY(subscriptions.approved_at) = DAY(now())

            AND subscriptions.status='1' 

            AND staff.status21 ='1'

            AND customer_staff.staff_id = '41'

            

            GROUP BY staff.first_name,staff.last_name, MONTH(subscriptions.approved_at)

            ORDER BY MONTH(subscriptions.approved_at)

     "); 

     

                   $platiniumAktifListe53=DB::select("

        SELECT MONTH(subscriptions.approved_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(staff.id) as id FROM  subscriptions 

            INNER JOIN customers ON subscriptions.`customer_id` = customers.id

            INNER JOIN customer_staff ON customers.id = customer_staff.`customer_id`

            INNER JOIN staff ON customer_staff.staff_id = staff.id  



            WHERE YEAR(subscriptions.approved_at) = YEAR(now()) AND 

            MONTH(subscriptions.approved_at) = MONTH(now()) AND 

            DAY(subscriptions.approved_at) = DAY(now())

            AND subscriptions.status='1' 

            AND staff.status21 ='1'

            AND customer_staff.staff_id = '53'

            

            GROUP BY staff.first_name,staff.last_name, MONTH(subscriptions.approved_at)

            ORDER BY MONTH(subscriptions.approved_at)

     "); 

     

                   $platiniumAktifListe54=DB::select("

        SELECT MONTH(subscriptions.approved_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(staff.id) as id FROM  subscriptions 

            INNER JOIN customers ON subscriptions.`customer_id` = customers.id

            INNER JOIN customer_staff ON customers.id = customer_staff.`customer_id`

            INNER JOIN staff ON customer_staff.staff_id = staff.id  



            WHERE YEAR(subscriptions.approved_at) = YEAR(now()) AND 

            MONTH(subscriptions.approved_at) = MONTH(now()) AND 

            DAY(subscriptions.approved_at) = DAY(now())

            AND subscriptions.status='1' 

            AND staff.status21 ='1'

            AND customer_staff.staff_id = '54'

            

            GROUP BY staff.first_name,staff.last_name, MONTH(subscriptions.approved_at)

            ORDER BY MONTH(subscriptions.approved_at)

     "); 

     

     

     $satisBugun=DB::select("

       SELECT  COUNT(subscriptions.id) as id FROM  subscriptions 

            INNER JOIN staff ON subscriptions.staff_id = staff.id

            

            WHERE YEAR(subscriptions.created_at)= YEAR(now())

            AND MONTH(subscriptions.created_at)= MONTH(now())

            AND DAY(subscriptions.created_at)= DAY(now())

            AND staff.status21 ='1' 

            AND staff.id!= 11

            AND staff.id!= 52

            AND staff.id!= 38

            

     "); 

     $satisBugun33=DB::select("

     SELECT DAY(subscriptions.created_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(subscriptions.id) as id FROM  subscriptions 

            INNER JOIN staff ON subscriptions.staff_id = staff.id

            

            WHERE YEAR(subscriptions.created_at)= YEAR(now())

            AND MONTH(subscriptions.created_at)= MONTH(now())

            AND DAY(subscriptions.created_at)= DAY(now())

            AND staff.id = 33

            AND staff.status21 =1 

            GROUP BY staff.first_name,staff.last_name, DAY(subscriptions.created_at)

           

      "); 

      

           $satisBugun34=DB::select("

     SELECT DAY(subscriptions.created_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(subscriptions.id) as id FROM  subscriptions 

            INNER JOIN staff ON subscriptions.staff_id = staff.id

            

            WHERE YEAR(subscriptions.created_at)= YEAR(now())

            AND MONTH(subscriptions.created_at)= MONTH(now())

            AND DAY(subscriptions.created_at)= DAY(now())

            AND staff.id = 34

            AND staff.status21 =1 

            GROUP BY staff.first_name,staff.last_name, DAY(subscriptions.created_at)

           

      "); 

      

           $satisBugun38=DB::select("

     SELECT DAY(subscriptions.created_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(subscriptions.id) as id FROM  subscriptions 

            INNER JOIN staff ON subscriptions.staff_id = staff.id

            

            WHERE YEAR(subscriptions.created_at)= YEAR(now())

            AND MONTH(subscriptions.created_at)= MONTH(now())

            AND DAY(subscriptions.created_at)= DAY(now())

            AND staff.id = 39

            AND staff.status21 =1 

            GROUP BY staff.first_name,staff.last_name, DAY(subscriptions.created_at)

           

      "); 

      

           $satisBugun57=DB::select("

     SELECT DAY(subscriptions.created_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(subscriptions.id) as id FROM  subscriptions 

            INNER JOIN staff ON subscriptions.staff_id = staff.id

            

            WHERE YEAR(subscriptions.created_at)= YEAR(now())

            AND MONTH(subscriptions.created_at)= MONTH(now())

            AND DAY(subscriptions.created_at)= DAY(now())

            AND staff.id = 57

            AND staff.status21 =1 

            GROUP BY staff.first_name,staff.last_name, DAY(subscriptions.created_at)

           

      "); 

      

      $satisBugun11=DB::select("

         SELECT DAY(subscriptions.created_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(subscriptions.id) as id FROM  subscriptions 

            INNER JOIN staff ON subscriptions.staff_id = staff.id

            

            WHERE YEAR(subscriptions.created_at)= YEAR(now())

            AND MONTH(subscriptions.created_at)= MONTH(now())

            AND DAY(subscriptions.created_at)= DAY(now())

            AND staff.id = 58

            AND staff.status21 =1 

            GROUP BY staff.first_name,staff.last_name, DAY(subscriptions.created_at)

           

      "); 

      $startDate = $request->input('start_date');
      $endDate = $request->input('end_date');
      
      // Tarih girilmemişse bugünün tarihi kullanılsın
      if (!$startDate || !$endDate) {
          $startDate = Carbon::today()->toDateString();
          $endDate = Carbon::today()->toDateString();
      }
      
      // Belirli türlerdeki ödemelerin toplamları
      $totals = DB::table('payments')
                  ->select(DB::raw('SUM(price) as total_price, type'))
                  ->whereBetween('paid_at', [$startDate, $endDate])
                  ->whereIn('type', [1,2,3,4,5,6,7])
                  ->groupBy('type')
                  ->get();
      
      // Genel ciro (tüm türlerin toplamı)
      $generalTotal = DB::table('payments')
                        ->whereBetween('paid_at', [$startDate, $endDate])
                        ->whereIn('type', [1,2,3,4,5,6,7])
                        ->sum('price');
      
      // AJAX isteği ise json döndür
      if ($request->ajax()) {
          return response()->json([
              'totals' => $totals,
              'general_total' => $generalTotal
          ]);
      }
  
  

    // Ödeme türü etiketlerini
    $typeLabels = [
        1 => 'Nakit',
        2 => 'POS',
        3 => 'Havale',
        4 => 'Kredi/Banka Kartı (Online)',
        5 => 'Otomatik Ödeme',
        6 => 'Nakit Ödeme (Manuel)',
        7 => 'Kredi/Banka Kartı (Manuel)',
    ];

      $satisBugun60=DB::select("

         SELECT DAY(subscriptions.created_at)  as created_at, staff.first_name as first_name,staff.last_name as last_name, COUNT(subscriptions.id) as id FROM  subscriptions 

            INNER JOIN staff ON subscriptions.staff_id = staff.id

            

            WHERE YEAR(subscriptions.created_at)= YEAR(now())

            AND MONTH(subscriptions.created_at)= MONTH(now())

            AND DAY(subscriptions.created_at)= DAY(now())

            AND staff.id = 60

            AND staff.status21 =1 

            GROUP BY staff.first_name,staff.last_name, DAY(subscriptions.created_at)

           

      "); 

     
    return view('admin.rapors.list',compact('satislar','typeLabels','totals','satisBugun60','satisBugun11','satisBugun57','satisBugun38','satisBugun34','satisBugun33','satisBugun','platiniumAktifListe54','platiniumAktifListe53','platiniumAktifListe41','platiniumAktifListe44','platiniumAktifListe','bugunAktif','illers','araliks','kasims','ekims','eyluls','agustoss',

                'temmuzs','hazirans','mayiss','nisans','marts','subats','ocaks','tarife',

                'customers','subscriptions','staffs','staffs2','staffs3',

                'services','yillars','aylars4','yillars3','yillars2','aylars1',

                'aylars2','satis1')); 

  }

  

   public function getupdate($id)

  {

     $task=Task::findOrFail($id);

     $tasks=Task::all();

    



    return view('admin.task.detailEdit',compact('tasks','task')); 

  }

  

  

  public function postupdate(Request $request, $id)

  {

       

       $task= Task::findOrFail($id);

       

       $task->user_id=$request->user_id;

       $task->roles_id=$request->roles_id;

       $task->name_lastname=$request->name_lastname;



       $task->task1=$request->task1;

       $task->status1=$request->status1;

       

       $task->task2=$request->task2;

       $task->status2=$request->status2;

       

       $task->task3=$request->task3;

       $task->status3=$request->status3;

       

       $task->task4=$request->task4;

       $task->status4=$request->status4;

       

       $task->task5=$request->task5;

       $task->status5=$request->status5;





        $task->save();

       // alert()->success('Başarılı!', 'Sayfanız Başarılı Bir Şekilde Güncellendi.');

         // return redirect()->route('admin.task.edit');

         

         

          return response()->json([

                'success' => true,

                'toastr' => [

                    'type' => 'success',

                    'title' => trans('response.title.success'),

                    'message' => trans('response.edit.success')

                ],

                 'status'=>201

            ]);

            

  }

  



    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Models\Service  $service

     * @return \Illuminate\Contracts\View\View

     */

    public function edit(Task $task)

    {

      

        return view('admin.task.edit', ['tasks' => Task::all()]);

        

    }

    

    public function guncelle(Request $request, $task)

    {

      $task=Task::findOrFail($task);

      $tasks=Task::all();

      

     return view('admin.task.update',compact('task','tasks'));

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Models\Service  $service

     * @return \Illuminate\Http\JsonResponse

     */

     

 public function update($id)

  {

     $task=Task::findOrFail($id);

     $tasks=Task::all();

     

    return view('admin.task.edit',compact('tasks','task')); 

  }

  



  

  

  public function updatePost(Request $request, $id)

  {

       

       $task= Task::findOrFail($id);



       $task->status1=$request->status1;

       

      

       $task->status2=$request->status2;

       

      

       $task->status3=$request->status3;

       

      

       $task->status4=$request->status4;

       

      

       $task->status5=$request->status5;



        $task->save();

       // alert()->success('Başarılı!', 'Sayfanız Başarılı Bir Şekilde Güncellendi.');

         // return redirect()->route('admin.task.edit');

         

         

          return response()->json([

                'success' => true,

                'toastr' => [

                    'type' => 'success',

                    'title' => trans('response.title.success'),

                    'message' => trans('response.edit.success')

                ],

                 'status'=>201

            ]);

            

  }

  

  

    public function ekleme(Task $oldTask,Task1 $task,Request $request,$id)

  {   

      $oldTask = Task::find($id); 

        $task = $oldTask->replicate(); 

        $task->setTable('tasks2');

        

        

        $task->save();



          return response()->json([

                'success' => true,

                'toastr' => [

                    'type' => 'success',

                    'title' => trans('response.title.success'),

                    'message' => trans('response.insert.success')

                ],

                 'status'=>201

            ]);

            

  }

  







}

