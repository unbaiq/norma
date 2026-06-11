<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMeasurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',

        'measurement_id',

        'customer_id',

        'measurement_code',

        'measurement_type',

        'height',
        'weight',

        'chest',
        'waist',
        'hip',

        'shoulder',
        'arm_length',

        'thigh',
        'knee',

        'ankle',

        'neck',

        'notes',

        'taken_by',

        'measurement_date',

        'status',

        'meta',
    ];

    protected $casts = [
        'height'      => 'decimal:2',
        'weight'      => 'decimal:2',
        'chest'       => 'decimal:2',
        'waist'       => 'decimal:2',
        'hip'         => 'decimal:2',
        'shoulder'    => 'decimal:2',
        'arm_length'  => 'decimal:2',
        'thigh'       => 'decimal:2',
        'knee'        => 'decimal:2',
        'ankle'       => 'decimal:2',
        'neck'        => 'decimal:2',

        'measurement_date' => 'datetime',

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

    public function measurement()
    {
        return $this->belongsTo(Measurement::class);
    }

    public function customer()
    {
        return $this->belongsTo(
            User::class,
            'customer_id'
        );
    }

    public function takenBy()
    {
        return $this->belongsTo(
            User::class,
            'taken_by'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeCompleted($query)
    {
        return $query->where(
            'status',
            'completed'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getBmiAttribute()
    {
        if (!$this->height || !$this->weight) {
            return null;
        }

        $heightInMeters = $this->height / 100;

        return round(
            $this->weight /
            ($heightInMeters * $heightInMeters),
            2
        );
    }
}