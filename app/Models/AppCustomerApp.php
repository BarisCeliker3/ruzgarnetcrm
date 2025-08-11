<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppCustomerApp extends Model
{
   protected $table = 'appcustomer_app';

    protected $fillable = [
        'appcustomer_name',
        'appcustomer_email',
        'appcustomer_tc',
        'appcustomer_begin',
        'app_phone',
    ];
public $timestamps = false;
}
