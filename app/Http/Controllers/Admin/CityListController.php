<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CityList;
use App\Models\Staff;
use App\Models\Customer;
use App\Models\StokKategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CityListController extends Controller
{

    public function index()
    {
        //return view('admin.stok.list', ['stoktakips' => StokTakip::all()]);
                return view('admin.citylist.list',  [


 
             'citylists' => DB::select("
                SELECT cities.name as sehir, COUNT(subscriptions.id) as id FROM `subscriptions` 	
            	INNER JOIN customers ON subscriptions.customer_id = customers.id
            	INNER JOIN customer_info ON customers.id = customer_info.customer_id
            	INNER JOIN cities ON customer_info.city_id = cities.id
            	
            	WHERE
            		YEAR(subscriptions.`created_at`)= YEAR(now())
                  	AND MONTH(subscriptions.`created_at`)= MONTH(now())
                  	AND DAY(subscriptions.`created_at`)= DAY(now())
                    AND subscriptions.staff_id != '11'
            		
                    GROUP BY cities.name 
                    ORDER BY COUNT(subscriptions.id) DESC")
              
           
              
            
              
        ]);
    }
    
    
    
    
    

}
