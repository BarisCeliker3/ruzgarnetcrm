<?php

namespace App\Console\Commands;

use App\Classes\Telegram;
use Exception;
use Illuminate\Console\Command;
use App\Models\FaultRecord;
use Illuminate\Support\Facades\DB;

class CheckFaultCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ruzgarnet:checkFault';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check fault count.';

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
        try {

            $fault_count = FaultRecord::whereNotIn('status', [2,5,6])->count();

            $check_count = DB::select('select faultcount from faultcounts');


            $count = ($fault_count - $check_count[0]->faultcount);

            if($count >= 15){
                Telegram::send(
                    'ArizaSayisi',
                    'Son 30 dakika içinde açılan ariza sayisi: '.$count
                );
            }else{

            }

            DB::update(
                'update faultcounts set faultcount = '.$fault_count.' where id = 1'
            );


            $this->info('Auto payments checked.');
        } catch (Exception $e) {
            Telegram::send(
                'Test',
                'Command - Check Fault : ' . $e->getMessage()
            );
        }
    }
}
