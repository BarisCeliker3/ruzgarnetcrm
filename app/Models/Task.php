<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Staff;
use App\Models\Role;

class Task extends Model
{
    use HasFactory;

    /**
     * All fields fillable
     *
     * @var array
     */
    protected $guarded = [];
    
     public function users()
    {
        return $this->belongsTo(User::class);
    }
    
       public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
    
      public function roles()
    {
        return $this->belongsTo(Role::class);
    }
    
  
}
