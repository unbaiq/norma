<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRecommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'recommendation_code',

        'customer_id',

        'lead_id',
        'appointment_id',
        'measurement_id',

        'product_id',
        'product_variant_id',

        'recommended_by',

        'recommendation_type',

        'priority',

        'quantity',

        'notes',

        'status',

        'recommended_at',

        'approved_at',

        'meta',
    ];

    protected $casts = [
        'recommended_at' => 'datetime',
        'approved_at'    => 'datetime',
        'meta'           => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function customer()
    {
        return $this->belongsTo(
            User::class,
            'customer_id'
        );
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function measurement()
    {
        return $this->belongsTo(Measurement::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(
            ProductVariant::class,
            'product_variant_id'
        );
    }

    public function recommendedBy()
    {
        return $this->belongsTo(
            User::class,
            'recommended_by'
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

    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsApprovedAttribute()
    {
        return $this->status === 'approved';
    }
}