<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'appointment_code',

        'lead_id',
        'customer_id',

        'field_executive_id',
        'assigned_by',

        'appointment_type',

        'appointment_date',
        'appointment_time',

        'status',

        'address',

        'latitude',
        'longitude',

        'confirmed_at',
        'started_at',
        'completed_at',
        'cancelled_at',

        'cancellation_reason',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',

        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',

        'confirmed_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',

        'meta' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function customer()
    {
        return $this->belongsTo(
            User::class,
            'customer_id'
        );
    }

    public function fieldExecutive()
    {
        return $this->belongsTo(
            User::class,
            'field_executive_id'
        );
    }

    public function assignedBy()
    {
        return $this->belongsTo(
            User::class,
            'assigned_by'
        );
    }

    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(
            AppointmentStatusHistory::class
        );
    }

    public function reschedules()
    {
        return $this->hasMany(
            AppointmentReschedule::class
        );
    }

    public function cancellations()
    {
        return $this->hasMany(
            AppointmentCancellation::class
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

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeToday($query)
    {
        return $query->whereDate(
            'appointment_date',
            today()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getAppointmentDateTimeAttribute()
    {
        return $this->appointment_date .
            ' ' .
            $this->appointment_time;
    }
}