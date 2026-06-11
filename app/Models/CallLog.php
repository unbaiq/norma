<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'user_id',

        'call_code',

        'mobile',

        'call_type',

        'direction',

        'status',

        'duration',

        'started_at',
        'ended_at',

        'recording_url',

        'remarks',

        'next_followup_date',

        'meta',
    ];

    protected $casts = [
        'started_at'        => 'datetime',
        'ended_at'          => 'datetime',
        'next_followup_date'=> 'datetime',
        'meta'              => 'array',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeConnected($query)
    {
        return $query->where('status', 'connected');
    }

    public function scopeMissed($query)
    {
        return $query->where('status', 'missed');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('started_at', today());
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFormattedDurationAttribute()
    {
        if (!$this->duration) {
            return '00:00';
        }

        return gmdate('i:s', $this->duration);
    }
}