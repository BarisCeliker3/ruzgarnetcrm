<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//use App\Models\Staff;

use App\Models\Subscription;

class Gift extends Model
{
    use HasFactory;

    /**
     * All fields fillable
     *
     * @var array
     */
    protected $guarded = [];

      public function subscription()
     {
        return $this->belongsTo(Subscription::class);
     }
    


}
