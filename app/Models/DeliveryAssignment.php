<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_id',

        'assigned_to',
        'assigned_by',

        'assignment_code',

        'vehicle_type',

        'status',

        'assigned_at',
        'accepted_at',
        'started_at',
        'completed_at',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'assigned_at'  => 'datetime',
        'accepted_at'  => 'datetime',
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',

        'meta' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(
            User::class,
            'assigned_to'
        );
    }

    public function assignedBy()
    {
        return $this->belongsTo(
            User::class,
            'assigned_by'
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

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
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