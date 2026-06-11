<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'payment_code',

        'order_id',

        'user_id',

        'payment_method',

        'gateway',

        'transaction_id',

        'gateway_order_id',

        'gateway_payment_id',

        'amount',

        'tax_amount',

        'discount_amount',

        'net_amount',

        'currency',

        'status',

        'paid_at',

        'failure_reason',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'amount'          => 'decimal:2',
        'tax_amount'      => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'net_amount'      => 'decimal:2',

        'paid_at'         => 'datetime',

        'meta'            => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function refunds()
    {
        return $this->hasMany(PaymentRefund::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsPaidAttribute()
    {
        return $this->status === 'paid';
    }
}