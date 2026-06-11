<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'delivery_code',

        'order_id',

        'customer_id',

        'delivery_partner_id',

        'assigned_to',

        'tracking_number',

        'delivery_type',

        'status',

        'pickup_address',
        'delivery_address',

        'pickup_date',
        'expected_delivery_date',
        'delivered_at',

        'shipping_cost',

        'proof_of_delivery',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'pickup_date' => 'datetime',
        'expected_delivery_date' => 'datetime',
        'delivered_at' => 'datetime',

        'shipping_cost' => 'decimal:2',

        'meta' => 'array',
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

    public function customer()
    {
        return $this->belongsTo(
            User::class,
            'customer_id'
        );
    }

    public function deliveryPartner()
    {
        return $this->belongsTo(
            User::class,
            'delivery_partner_id'
        );
    }

    public function assignedTo()
    {
        return $this->belongsTo(
            User::class,
            'assigned_to'
        );
    }

    public function assignments()
    {
        return $this->hasMany(
            DeliveryAssignment::class
        );
    }

    public function trackingLogs()
    {
        return $this->hasMany(
            DeliveryTracking::class
        );
    }

    public function proofs()
    {
        return $this->hasMany(
            DeliveryProof::class
        );
    }

    public function statusHistories()
    {
        return $this->hasMany(
            DeliveryStatusHistory::class
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

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeInTransit($query)
    {
        return $query->where('status', 'in_transit');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsDeliveredAttribute()
    {
        return $this->status === 'delivered';
    }
}