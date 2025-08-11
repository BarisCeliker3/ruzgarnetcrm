<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Models\Staff;
use App\Models\StokTable;
use App\Models\Customer;


class StokTakip extends Model
{
    use HasFactory;

    /**
     * All fields fillable
     *
     * @var array
     */
    protected $guarded = [];

       public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
    
       public function stoktables()
    {
       // return $this->belongsTo(App\Models\StokTable::class,’id’,’stok_id’);  //stok_takips.id = stok_tables.user_id
        return $this->belongsTo(StokTable::class);
    }
    

}
