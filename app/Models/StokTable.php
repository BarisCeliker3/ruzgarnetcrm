<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



use App\Models\StokKategori;


class StokTable extends Model
{
    use HasFactory;

    /**
     * All fields fillable
     *
     * @var array
     */
    protected $guarded = [];
     protected $fillable = ['stok_adet'];
    
    
           public function stok_kategoris()
    {
       // return $this->belongsTo(App\Models\StokTable::class,’id’,’stok_id’);  //stok_takips.id = stok_tables.user_id
        return $this->belongsTo(StokKategori::class);
    }

  
}
