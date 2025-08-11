<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Staff;
use App\Models\Subscription;
use App\Models\Customer;
use App\Models\Service;

class Rcb extends Model
{
    use HasFactory;

    /**
     * All fields fillable
     *
     * @var array
     */
    protected $guarded = [];
    protected $casts = [
   'created_at' => 'date:Y-m-d'
    ];
    
   
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
    
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
    
        public function service()
    {
        return $this->belongsTo(Service::class);
    }
  
}
