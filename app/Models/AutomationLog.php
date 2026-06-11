<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutomationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'automation_code',
        'automation_name',
        'automation_type',

        'workflow_rule_id',
        'sla_rule_id',

        'entity_type',
        'entity_id',

        'status',

        'attempts',
        'max_attempts',

        'started_at',
        'completed_at',

        'execution_time_ms',

        'message',
        'error_message',

        'request_payload',
        'response_payload',

        'queue_name',
        'job_id',

        'trigger_source',
        'triggered_by',

        'meta',
    ];

    protected $casts = [
        'started_at'       => 'datetime',
        'completed_at'     => 'datetime',

        'request_payload'  => 'array',
        'response_payload' => 'array',

        'meta'             => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function workflowRule()
    {
        return $this->belongsTo(WorkflowRule::class);
    }

    public function slaRule()
    {
        return $this->belongsTo(SlaRule::class);
    }

    public function triggeredBy()
    {
        return $this->belongsTo(
            User::class,
            'triggered_by'
        );
    }

    public function entity()
    {
        return $this->morphTo();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'queued');
    }

    public function scopeToday($query)
    {
        return $query->whereDate(
            'created_at',
            today()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getExecutionSecondsAttribute()
    {
        return $this->execution_time_ms
            ? round($this->execution_time_ms / 1000, 2)
            : 0;
    }

    public function getIsFailedAttribute()
    {
        return $this->status === 'failed';
    }
}