<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Measurement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'measurement_code',

        'customer_id',
        'field_executive_id',

        'lead_id',
        'appointment_id',

        'height',
        'weight',
        'bmi',

        'neck',
        'chest',
        'waist',
        'hip',

        'shoulder',
        'arm_length',
        'bicep',
        'forearm',
        'wrist',

        'thigh',
        'knee',
        'calf',
        'ankle',

        'body_fat_percentage',

        'measurement_date',

        'status',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
        'bmi' => 'decimal:2',

        'neck' => 'decimal:2',
        'chest' => 'decimal:2',
        'waist' => 'decimal:2',
        'hip' => 'decimal:2',

        'shoulder' => 'decimal:2',
        'arm_length' => 'decimal:2',
        'bicep' => 'decimal:2',
        'forearm' => 'decimal:2',
        'wrist' => 'decimal:2',

        'thigh' => 'decimal:2',
        'knee' => 'decimal:2',
        'calf' => 'decimal:2',
        'ankle' => 'decimal:2',

        'body_fat_percentage' => 'decimal:2',

        'measurement_date' => 'datetime',

        'meta' => 'array',
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

    public function fieldExecutive()
    {
        return $this->belongsTo(
            User::class,
            'field_executive_id'
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

    public function photos()
    {
        return $this->hasMany(MeasurementPhoto::class);
    }

    public function notes()
    {
        return $this->hasMany(MeasurementNote::class);
    }

    public function recommendations()
    {
        return $this->hasMany(
            ProductRecommendation::class
        );
    }

    public function orders()
    {
        return $this->hasMany(
            OrderMeasurement::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute()
    {
        return $this->measurement_code;
    }
}