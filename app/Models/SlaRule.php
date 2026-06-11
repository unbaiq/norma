<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SlaRule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'rule_code',

        'name',

        'module',

        'priority',

        'response_time_minutes',

        'resolution_time_minutes',

        'escalation_time_minutes',

        'escalation_level',

        'status',

        'created_by',

        'approved_by',

        'approved_at',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'approved_at' => 'datetime',

        'meta' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function approver()
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

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
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

    public function getTotalSlaMinutesAttribute()
    {
        return $this->response_time_minutes +
               $this->resolution_time_minutes;
    }
}