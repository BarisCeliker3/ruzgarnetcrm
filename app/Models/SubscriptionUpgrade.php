<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionUpgrade extends Model
{
    use HasFactory;
     /**
     * All fields fillable
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * SubscriptionUpgrade relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

}
