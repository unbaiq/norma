<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserKyc extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',

        'kyc_number',

        'kyc_type',

        'status',

        'submitted_at',
        'verified_at',
        'rejected_at',

        'verified_by',

        'risk_score',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'verified_at'  => 'datetime',
        'rejected_at'  => 'datetime',

        'risk_score'   => 'decimal:2',

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

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function documents()
    {
        return $this->hasMany(UserDocument::class, 'user_id', 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsVerifiedAttribute()
    {
        return $this->status === 'verified';
    }
}