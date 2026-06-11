<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'notification_id',

        'log_code',

        'channel',

        'status',

        'recipient',

        'provider',

        'provider_message_id',

        'error_message',

        'sent_at',
        'delivered_at',
        'read_at',

        'response',

        'meta',
    ];

    protected $casts = [
        'sent_at'      => 'datetime',
        'delivered_at' => 'datetime',
        'read_at'      => 'datetime',

        'response'     => 'array',
        'meta'         => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsDeliveredAttribute()
    {
        return !is_null($this->delivered_at);
    }

    public function getIsReadAttribute()
    {
        return !is_null($this->read_at);
    }
}