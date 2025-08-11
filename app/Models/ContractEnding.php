<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subscription;
use App\Models\Staff;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Categori;


class ContractEnding extends Model
{
    use HasFactory;
      /**
     * All fields fillable
     *
     * @var array
     */
    protected $guarded = [];
    protected $casts = [
        'options' => 'array',
        'values' => 'array'
    ];

      /**
     * Subscription relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
        public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
        public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
