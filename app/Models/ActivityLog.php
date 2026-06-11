<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'activity_code',

        'module',

        'action',

        'description',

        'subject_type',
        'subject_id',

        'ip_address',

        'device_type',
        'platform',

        'url',
        'method',

        'old_values',
        'new_values',

        'status',

        'performed_at',

        'meta',
    ];

    protected $casts = [
        'old_values'   => 'array',
        'new_values'   => 'array',
        'meta'         => 'array',
        'performed_at' => 'datetime',
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

    public function subject()
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

    public function scopeModule($query, $module)
    {
        return $query->where('module', $module);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getActivityTitleAttribute()
    {
        return ucfirst($this->action) . ' - ' . ucfirst($this->module);
    }
}