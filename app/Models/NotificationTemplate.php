<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'template_code',

        'name',

        'type',

        'channel',

        'subject',

        'title',

        'message',

        'variables',

        'status',

        'is_default',

        'created_by',

        'approved_by',

        'approved_at',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'variables'   => 'array',
        'is_default'  => 'boolean',
        'approved_at' => 'datetime',
        'meta'        => 'array',
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

    public function scopeEmail($query)
    {
        return $query->where('channel', 'email');
    }

    public function scopeSms($query)
    {
        return $query->where('channel', 'sms');
    }

    public function scopeWhatsapp($query)
    {
        return $query->where('channel', 'whatsapp');
    }

    public function scopePush($query)
    {
        return $query->where('channel', 'push');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getVariableCountAttribute()
    {
        return count($this->variables ?? []);
    }
}