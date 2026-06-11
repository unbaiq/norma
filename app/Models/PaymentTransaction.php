<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',

        'transaction_code',

        'transaction_type',

        'gateway',

        'gateway_transaction_id',

        'reference_no',

        'amount',

        'currency',

        'status',

        'request_payload',

        'response_payload',

        'processed_at',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'amount' => 'decimal:2',

        'processed_at' => 'datetime',

        'request_payload' => 'array',
        'response_payload' => 'array',

        'meta' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeLatestFirst($query)
    {
        return $query->latest('processed_at');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsSuccessfulAttribute()
    {
        return $this->status === 'success';
    }
}