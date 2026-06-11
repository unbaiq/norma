<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'audit_code',

        'event',

        'auditable_type',
        'auditable_id',

        'old_values',
        'new_values',

        'ip_address',

        'user_agent',

        'url',
        'method',

        'status',

        'performed_at',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'old_values'   => 'array',
        'new_values'   => 'array',
        'performed_at' => 'datetime',
        'meta'         => 'array',
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

    public function auditable()
    {
        return $this->morphTo();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeCreated($query)
    {
        return $query->where('event', 'created');
    }

    public function scopeUpdated($query)
    {
        return $query->where('event', 'updated');
    }

    public function scopeDeleted($query)
    {
        return $query->where('event', 'deleted');
    }

    public function scopeLatestFirst($query)
    {
        return $query->latest('performed_at');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getAuditSummaryAttribute()
    {
        return ucfirst($this->event) .
            ' on ' .
            class_basename($this->auditable_type);
    }
}