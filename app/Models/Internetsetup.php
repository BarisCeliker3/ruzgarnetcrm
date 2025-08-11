<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



use App\Models\Customer;


class Internetsetup extends Model
{
    use HasFactory;

    /**
     * All fields fillable
     *
     * @var array
     */
    protected $guarded = [];
    // protected $fillable = ['stok_adet'];
    
    
   public function customers()
    {
       
        return $this->belongsTo(Customer::class);
    }

  
}
