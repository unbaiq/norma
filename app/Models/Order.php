<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_code',

        'customer_id',
        'chemist_id',
        'distributor_id',

        'appointment_id',
        'measurement_id',

        'address_id',

        'subtotal',
        'discount_amount',
        'tax_amount',
        'shipping_amount',
        'total_amount',

        'payment_method',
        'payment_status',

        'order_status',

        'ordered_at',
        'confirmed_at',
        'processing_at',
        'shipped_at',
        'delivered_at',
        'cancelled_at',

        'remarks',
        'meta',
    ];

    protected $casts = [
        'subtotal'         => 'decimal:2',
        'discount_amount'  => 'decimal:2',
        'tax_amount'       => 'decimal:2',
        'shipping_amount'  => 'decimal:2',
        'total_amount'     => 'decimal:2',

        'ordered_at'       => 'datetime',
        'confirmed_at'     => 'datetime',
        'processing_at'    => 'datetime',
        'shipped_at'       => 'datetime',
        'delivered_at'     => 'datetime',
        'cancelled_at'     => 'datetime',

        'meta'             => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function chemist()
    {
        return $this->belongsTo(User::class, 'chemist_id');
    }

    public function distributor()
    {
        return $this->belongsTo(User::class, 'distributor_id');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function measurement()
    {
        return $this->belongsTo(Measurement::class);
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'address_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderMeasurements()
    {
        return $this->hasMany(OrderMeasurement::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePending($query)
    {
        return $query->where('order_status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('order_status', 'confirmed');
    }

    public function scopeDelivered($query)
    {
        return $query->where('order_status', 'delivered');
    }

    public function scopeCancelled($query)
    {
        return $query->where('order_status', 'cancelled');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFormattedTotalAttribute()
    {
        return number_format($this->total_amount, 2);
    }

    public function getTotalItemsAttribute()
    {
        return $this->items()->sum('quantity');
    }
}