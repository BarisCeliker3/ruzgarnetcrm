<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommitmentNote extends Model
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
    public function Commitment()
    {
        return $this->belongsTo(Commitment::class);
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
