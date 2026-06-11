<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refund extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'refund_code',

        'payment_id',
        'order_id',
        'user_id',

        'refund_type',

        'refund_amount',

        'reason',

        'gateway',

        'gateway_refund_id',

        'status',

        'processed_by',

        'requested_at',
        'approved_at',
        'refunded_at',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'refund_amount' => 'decimal:2',

        'requested_at' => 'datetime',
        'approved_at'  => 'datetime',
        'refunded_at'  => 'datetime',

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

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(
            User::class,
            'processed_by'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsCompletedAttribute()
    {
        return $this->status === 'completed';
    }
}