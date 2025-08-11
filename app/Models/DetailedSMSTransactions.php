<?php
namespace App\Models;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;
use Carbon\Carbon;


class DetailedSMSTransactions
{
    /*
        private final function __construct() {
        echo __CLASS__ . " initialize only once ";
    }
     
    public static function getConnect() {
        if (!isset(self::$obj)) {
            self::$obj = new DataBaseConnector();
        }
         
        return self::$obj;
    }
    */
    
    private static $obj;
    
    private final function __construct()
    {
        
    }
    
    public static function getInstance()
    {
       if(!Schema::hasTable('detailed_sms'))
        {
            Schema::connection('mysql')->create('detailed_sms', function($table)
            {
                $table->bigIncrements('id');
                $table->string('title', 100);
                $table->string('message', 900);
                $table->string('phone', 12);
                $table->integer('bulk_id', 60);
                $table->dateTime('created_at');
                $table->integer('status_code')->nullable();
                $table->string('operator', 60)->nullable();
                $table->integer('fail_reason')->nullable();
                $table->dateTime('last_check_time')->nullable();
                $table->integer('count_of_check')->default(0);
            });
        }
        
        if (!isset(self::$obj)) {
            self::$obj = new DetailedSMSTransactions();
        }
         
        return self::$obj;
    }
    
    
    public function save($title, $message, $phone, $bulkId)
    {
       
        $messageArray = array();
        try{
        

            for($i=0; $i<count($phone); $i++)
            {
               $data = [
                'title' => $title,
                'message' => $message,
                'phone' => $phone[$i],
                'bulk_id' => $bulkId,
                'created_at' => Carbon::now(),
                'status_code' => NULL,
                'operator' => NULL,
                'fail_reason' => NULL,
                'last_check_time' => NULL,
                'count_of_check' => 0
              ];
              array_push($messageArray, $data);
            }
            DB::table('detailed_sms')->insert($messageArray);
        //Storage::disk('local')->append("messageResult.txt", strval(DB::table('detailed_sms')->insert($data)), "\n");
        }
        catch(Exception $ex)
        {
            Storage::disk('local')->append("messageResult.txt", $ex->__toString(), "\n");
        } 
        
    }
    
    public function saveMulti($title, $gsm, $msg, $intResult)
    {
        $messageArray = array();
        try
        {
            for($i=0; $i<count($gsm); $i++)
            {
                   $data = [
                    'title' => $title,
                    'message' => $msg[$i],
                    'phone' => $gsm[$i],
                    'bulk_id' => $intResult,
                    'created_at' => Carbon::now(),
                    'status_code' => NULL,
                    'operator' => NULL,
                    'fail_reason' => NULL,
                    'last_check_time' => NULL,
                    'count_of_check' => 0
                  ];
                  array_push($messageArray, $data);            
            }
        DB::table('detailed_sms')->insert($messageArray);
        }
        catch(Exception $ex)
        {
            Storage::disk('local')->append("messageResult.txt", $ex->__toString(), "\n");
        }
    }
    
    public function updateMessages($resultArray)
    {
        try{
           //Storage::disk('local')->append("niger.txt", print_r($resultArray, true), "\n");
           //$innerArr = json_decode(json_encode ( $resultArray[0] ) , true);
           //Storage::disk('local')->append("extremelyhard.txt", print_r($innerArr['@attributes'][''], true), "\n");
           //Storage::disk('local')->append("lastRes.txt", print_r($resultArray, true), "\n");
           //DB::table('table')->where('confirmed', '=', 0)->update(array('confirmed' => 1));
           for($i=0; $i<count($resultArray); $i++)
           {
               /*
               $changeArr = ['email' => 'new@email.com', 'name' => 'my new name'];
                $id = 1;
                $table = 'users';
                
                foreach($changeArr as $key => $value){
                    DB::table('updateTable')->insert(['table' => $table, 'id' => $id, 'col' => $key, 'oldVal' => $value]);
                }
                
                $updateItem = DB::table($table)->where('id', $id)->update($changeArr);
               */
               //Storage::disk('local')->append("greco.txt", $resultArray[$i], "\n");
               $innerArr = json_decode(json_encode ( $resultArray[$i] ) , true);
               

               //Storage::disk('local')->append("krall.txt", print_r($innerArr['@attributes'], true), "\n");
               $countOfCheck = DB::table('detailed_sms')->select('count_of_check', 'bulk_id')->where('detailed_sms.bulk_id', "=", $innerArr['@attributes']['jobid'])->first();
               $hallelujah = json_decode(json_encode ( $countOfCheck ) , true);
               //for($j=0; $j<count($hallelujah); $j++)
               //{
                   $hh = intval($hallelujah['count_of_check']);
                   $hh++;
                   /*
                   Storage::disk('local')->append("reArr0.txt", $resultArray[0], "\n");
                   Storage::disk('local')->append("kemah.txt", $hh." ".$hallelujah['bulk_id'], "\n");
                   Storage::disk('local')->append("kemah.txt", print_r($innerArr,true), "\n");
                   Storage::disk('local')->append("hallelujah.txt", count($hallelujah), "\n");
                   Storage::disk('local')->append("innerArr.txt", count($innerArr), "\n");
                   Storage::disk('local')->append("resultArr.txt", count($resultArray), "\n");
                   */
                   //ARTIK GÜNCELLEMEYİ BURADAN YAPABİLİRİM
                $affected =  DB::table('detailed_sms')->where('detailed_sms.bulk_id', '=', $hallelujah['bulk_id'])->where('detailed_sms.phone', '=', $resultArray[$i])
                                            ->update(['status_code' => $innerArr['@attributes']['durum'], 'operator' => $innerArr['@attributes']['operator'], 'fail_reason' => $innerArr['@attributes']['failreason'], 'last_check_time' => Carbon::now(), 'count_of_check' => $hh]);
                $proof = $resultArray[$i]." ".$affected." ".$innerArr['@attributes']['failreason'];
                Storage::disk('local')->append('proof.txt', $proof, "\n"); 
               //}
               /*
               foreach($hallelujah as $key)
               {
                   
                    $array = explode(' ', $key);
                    Storage::disk('local')->append("sifir.txt",$array[0], "\n");
                    Storage::disk('local')->append("donk.txt", $key, "\n");
                   /*
                    $countOfCheck = -1;
                    if($key == 'count_of_check')
                    {
                        $value = intval($value);
                        $value++;
                        $countOfCheck = $value;
                    }
                    
                    Storage::disk('local')->append("tahrip.txt", print_r($innerArr, true), "\n");
                    Storage::disk('local')->append("det.txt", $key." ".$value." ".$innerArr['@attributes']['durum']." ".$innerArr['@attributes']['operator']." ".$countOfCheck, "\n");
                    
               }*/
               //$lastCountOfCheckArr = json_decode(json_encode ( $lastCountOfCheck ) , true);

               //Storage::disk('local')->append("innerArr.txt", count($innerArr), "\n");
               //Storage::disk('local')->append("lastCountOfCheck.txt", count($lastCountOfCheckArr), "\n");
               //$countOf
               //Storage::disk('local')->append('zs.txt', print_r($lastCountOfCheckArr, true), "\n");
               //Storage::disk('local')->append("bigstick.txt", $resultArray[$i], "\n");
               //Storage::disk('local')->append("bigstick.txt", print_r($innerArr['@attributes'], true), "\n");
               $changeArray = ['status_code' => $innerArr['@attributes']['durum'], 'operator' => $innerArr['@attributes']['operator'], 'fail_reason' => $innerArr['@attributes']['failreason'], 'last_check_time' => Carbon::now(), ''];
               
           }
        }
        catch(Exception $ex)
        {
            
        }
            
    }
}