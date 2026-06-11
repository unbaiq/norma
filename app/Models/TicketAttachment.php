<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'support_ticket_id',

        'attachment_code',

        'file_name',

        'original_name',

        'file_path',

        'file_type',

        'file_extension',

        'file_size',

        'uploaded_by',

        'status',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'file_size' => 'integer',

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

    public function uploader()
    {
        return $this->belongsTo(
            User::class,
            'uploaded_by'
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

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFileUrlAttribute()
    {
        return $this->file_path
            ? asset('storage/' . $this->file_path)
            : null;
    }

    public function getFileSizeMbAttribute()
    {
        return round(
            $this->file_size / 1024 / 1024,
            2
        );
    }
}