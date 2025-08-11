<?php
namespace App\Models;

use Illuminate\Support\Facades\Schema;

class TestModel
{
    function __construct()
    {
        if(!Schema::hasTable('testmodels'))
        {
            Schema::connection('mysql')->create('testmodels', function($table)
            {
                $table->increments('id');
            });
        }
    }
}