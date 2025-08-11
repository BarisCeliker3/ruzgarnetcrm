<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerInfo;
class CustomerDocument extends Model
{
    use HasFactory;

     /**
     * All fields fillable
     *
     * @var array
     */
    protected $guarded = [];
    
    protected $casts = [
        'files' => 'array'
    ];
    /**
     * CustomerNote relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    public function customerInfo()
    {
        return $this->belongsTo(CustomerInfo::class);
    }

     /**
     * CustomerNote relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
