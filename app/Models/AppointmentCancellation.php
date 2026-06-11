<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentCancellation extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',

        'cancelled_by',

        'cancellation_code',

        'reason',

        'description',

        'cancelled_at',

        'status',

        'meta',
    ];

    protected $casts = [
        'cancelled_at' => 'datetime',
        'meta'         => 'array',
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

    public function cancelledBy()
    {
        return $this->belongsTo(
            User::class,
            'cancelled_by'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
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

    public function getCancellationSummaryAttribute()
    {
        return "{$this->reason} - {$this->cancelled_at}";
    }
}