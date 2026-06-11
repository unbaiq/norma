<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadFollowup extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',

        'assigned_to',

        'followup_code',

        'followup_type',

        'followup_date',
        'next_followup_date',

        'status',

        'call_duration',

        'outcome',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'followup_date'      => 'datetime',
        'next_followup_date' => 'datetime',

        'call_duration'      => 'integer',

        'meta'               => 'array',
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

    public function assignedUser()
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

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeToday($query)
    {
        return $query->whereDate(
            'followup_date',
            today()
        );
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'pending')
            ->whereDate('followup_date', '<', now());
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFormattedDurationAttribute()
    {
        if (!$this->call_duration) {
            return '00:00';
        }

        return gmdate(
            'i:s',
            $this->call_duration
        );
    }
}