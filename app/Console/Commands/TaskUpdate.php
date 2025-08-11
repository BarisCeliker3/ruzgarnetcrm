<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Console\Command;

class TaskUpdate extends Command
{
    
    protected $signature = 'ruzgarnet:TaskUpdate';

    /**
     * The console command description.
     *
     * @var string
     */


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        
        //Günlük Görev Sıfırlama
          try {
        DB::table('tasks')
         ->where(function($query) {
            $query->where('status1', '=',1)
                  ->orWhere('status2', '=',1)
                  ->orWhere('status3', '=',1)
                  ->orWhere('status4', '=',1)
                  ->orWhere('status5', '=',1);
                })
           ->update(['status1' => '0','status2' => '0','status3' => '0','status4' => '0','status5' => '0']);
           
          } catch (Exception $e) {
           
         }

        $this->info('deneme test.');
    }
}
