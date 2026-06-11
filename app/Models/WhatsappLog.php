<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'whatsapp_code',

        'user_id',

        'mobile',

        'template_name',

        'message',

        'media_url',

        'message_type',

        'provider',

        'provider_message_id',

        'status',

        'sent_by',

        'sent_at',

        'delivered_at',

        'read_at',

        'error_message',

        'response',

        'meta',
    ];

    protected $casts = [
        'sent_at'      => 'datetime',
        'delivered_at' => 'datetime',
        'read_at'      => 'datetime',

        'response' => 'array',
        'meta'     => 'array',
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

    public function sender()
    {
        return $this->belongsTo(
            User::class,
            'sent_by'
        );
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
        return $query->where('status', 'read');
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

    public function getIsReadAttribute()
    {
        return !is_null($this->read_at);
    }

    public function getIsDeliveredAttribute()
    {
        return !is_null($this->delivered_at);
    }
}