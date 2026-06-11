<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentReschedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',

        'reschedule_code',

        'old_appointment_date',
        'old_appointment_time',

        'new_appointment_date',
        'new_appointment_time',

        'reason',

        'requested_by',
        'approved_by',

        'status',

        'requested_at',
        'approved_at',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'old_appointment_date' => 'date',
        'new_appointment_date' => 'date',

        'requested_at' => 'datetime',
        'approved_at' => 'datetime',

        'meta' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function requestedBy()
    {
        return $this->belongsTo(
            User::class,
            'requested_by'
        );
    }

    public function approvedBy()
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
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

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getOldScheduleAttribute()
    {
        return $this->old_appointment_date .
            ' ' .
            $this->old_appointment_time;
    }

    public function getNewScheduleAttribute()
    {
        return $this->new_appointment_date .
            ' ' .
            $this->new_appointment_time;
    }
}