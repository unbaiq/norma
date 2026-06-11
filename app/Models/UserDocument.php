<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',

        'document_type',
        'document_number',

        'document_name',
        'file_name',
        'file_path',
        'file_url',

        'mime_type',
        'file_size',

        'issued_date',
        'expiry_date',

        'is_verified',
        'verified_at',
        'verified_by',

        'status',

        'remarks',
        'meta',
    ];

    protected $casts = [
        'issued_date' => 'date',
        'expiry_date' => 'date',

        'is_verified' => 'boolean',

        'verified_at' => 'datetime',

        'meta' => 'array',
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

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getDocumentUrlAttribute()
    {
        return $this->file_path
            ? asset('storage/' . $this->file_path)
            : null;
    }

    public function getIsExpiredAttribute()
    {
        if (!$this->expiry_date) {
            return false;
        }

        return $this->expiry_date->isPast();
    }
}