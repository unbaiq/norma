<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',

        'changed_by',

        'old_status',
        'new_status',

        'remarks',

        'changed_at',

        'meta',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
        'meta'       => 'array',
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

    public function changedBy()
    {
        return $this->belongsTo(
            User::class,
            'changed_by'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeLatestFirst($query)
    {
        return $query->latest('changed_at');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getStatusTransitionAttribute()
    {
        return "{$this->old_status} → {$this->new_status}";
    }
}