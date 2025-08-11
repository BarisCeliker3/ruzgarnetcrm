<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passreset extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'pass_reset';
    protected $guarded = [];

    // Passreset bir AppCustomerApp'a aittir (user_id ile)
    public function appCustomer()
    {
        return $this->belongsTo(AppCustomerApp::class, 'user_id', 'id');
        // Eğer foreign key farklıysa ('user_id'), yukarıdaki gibi belirt.
    }
}