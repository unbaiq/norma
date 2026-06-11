<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'email_code',

        'recipient_email',
        'recipient_name',

        'subject',

        'template_name',

        'email_type',

        'status',

        'sent_by',

        'sent_at',
        'delivered_at',
        'opened_at',

        'error_message',

        'attachments',

        'meta',
    ];

    protected $casts = [
        'sent_at'      => 'datetime',
        'delivered_at' => 'datetime',
        'opened_at'    => 'datetime',

        'attachments'  => 'array',
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

    public function scopeOpened($query)
    {
        return $query->whereNotNull('opened_at');
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

    public function getIsOpenedAttribute()
    {
        return !is_null($this->opened_at);
    }

    public function getIsDeliveredAttribute()
    {
        return !is_null($this->delivered_at);
    }
}