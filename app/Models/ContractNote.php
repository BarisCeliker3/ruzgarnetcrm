<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractNote extends Model
{
    use HasFactory;

     /**
     * All fields fillable
     *
     * @var array
     */
    protected $guarded = [];


    /**
     * CustomerNote relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Contract()
    {
        return $this->belongsTo(Contract::class);
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
