<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Expensecategory;


class Expen extends Model
{
    use HasFactory;

    /**
     * All fields fillable
     *
     * @var array
     */
    protected $guarded = [];
    
     public function expensecategories()
    {
        return $this->hasOne(Expensecategory::class);
    }
    

}
