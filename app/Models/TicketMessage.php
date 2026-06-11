<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'support_ticket_id',

        'message_code',

        'sender_id',

        'sender_type',

        'message',

        'message_type',

        'is_internal',

        'is_read',

        'read_at',

        'sent_at',

        'status',

        'meta',
    ];

    protected $casts = [
        'is_internal' => 'boolean',
        'is_read'     => 'boolean',

        'read_at' => 'datetime',
        'sent_at' => 'datetime',

        'meta' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function ticket()
    {
        return $this->belongsTo(
            SupportTicket::class,
            'support_ticket_id'
        );
    }

    public function sender()
    {
        return $this->belongsTo(
            User::class,
            'sender_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeInternal($query)
    {
        return $query->where(
            'is_internal',
            true
        );
    }

    public function scopePublic($query)
    {
        return $query->where(
            'is_internal',
            false
        );
    }

    public function scopeUnread($query)
    {
        return $query->where(
            'is_read',
            false
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsCustomerMessageAttribute()
    {
        return $this->sender_type === 'customer';
    }

    public function getIsAgentMessageAttribute()
    {
        return $this->sender_type === 'agent';
    }
}