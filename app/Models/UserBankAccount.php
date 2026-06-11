<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'account_holder_name',
        'bank_name',
        'branch_name',

        'account_number',
        'ifsc_code',

        'account_type',

        'upi_id',

        'is_primary',
        'is_verified',

        'verified_at',

        'status',

        'remarks',
    ];

    protected $casts = [
        'is_primary'  => 'boolean',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
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

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getMaskedAccountNumberAttribute()
    {
        return 'XXXXXX' . substr($this->account_number, -4);
    }
}