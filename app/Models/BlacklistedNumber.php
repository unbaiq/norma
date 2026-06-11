<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlacklistedNumber extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'mobile',

        'country_code',

        'reason',

        'blacklist_type',

        'source',

        'status',

        'blacklisted_by',

        'blacklisted_at',

        'expiry_date',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'blacklisted_at' => 'datetime',
        'expiry_date'    => 'date',
        'meta'           => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function blacklistedBy()
    {
        return $this->belongsTo(
            User::class,
            'blacklisted_by'
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

    public function scopePermanent($query)
    {
        return $query->where('blacklist_type', 'permanent');
    }

    public function scopeTemporary($query)
    {
        return $query->where('blacklist_type', 'temporary');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsExpiredAttribute()
    {
        if (!$this->expiry_date) {
            return false;
        }

        return now()->gt($this->expiry_date);
    }

    public function getFullMobileAttribute()
    {
        return $this->country_code . $this->mobile;
    }
}