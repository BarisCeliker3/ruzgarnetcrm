<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestedUser extends Model
{
    use HasFactory;

    // Tablo adı
    protected $table = 'tested_users';

    // Otomatik olarak oluşturulacak timestamp'ları devre dışı bırak

    // Fillable özelliklerini belirtiyoruz
    protected $fillable = [
        'service_id',
        'subscription_id',
        'status',
        'customer_id',
    ];

    /**
     * service_id ilişkisini belirtmek
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * subscription_id ilişkisini belirtmek
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

    /**
     * customer_id ilişkisini belirtmek
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
