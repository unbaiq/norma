<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoginLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'login_type',

        'ip_address',

        'device_id',
        'device_name',
        'device_type',

        'platform',
        'browser',

        'latitude',
        'longitude',

        'country',
        'state',
        'city',

        'status',

        'failure_reason',

        'logged_in_at',
        'logged_out_at',

        'session_id',

        'meta',
    ];

    protected $casts = [
        'logged_in_at'  => 'datetime',
        'logged_out_at' => 'datetime',
        'meta'          => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('logged_in_at', today());
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getDurationAttribute()
    {
        if (!$this->logged_out_at || !$this->logged_in_at) {
            return null;
        }

        return $this->logged_in_at->diffInMinutes(
            $this->logged_out_at
        );
    }
}