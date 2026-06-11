<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',

        'assigned_by',
        'assigned_to',

        'assignment_code',

        'assignment_type',

        'assigned_at',

        'status',

        'accepted_at',
        'rejected_at',
        'completed_at',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'assigned_at'  => 'datetime',
        'accepted_at'  => 'datetime',
        'rejected_at'  => 'datetime',
        'completed_at' => 'datetime',

        'meta'         => 'array',
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

    public function assignedBy()
    {
        return $this->belongsTo(
            User::class,
            'assigned_by'
        );
    }

    public function assignedTo()
    {
        return $this->belongsTo(
            User::class,
            'assigned_to'
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

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getAssigneeNameAttribute()
    {
        return $this->assignedTo?->full_name;
    }
}