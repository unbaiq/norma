<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletSettlement extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'user_id',

        'settlement_code',

        'settlement_type',

        'gross_amount',
        'deduction_amount',
        'net_amount',

        'settlement_period_start',
        'settlement_period_end',

        'status',

        'settled_at',

        'approved_by',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'gross_amount' => 'decimal:2',
        'deduction_amount' => 'decimal:2',
        'net_amount' => 'decimal:2',

        'settlement_period_start' => 'date',
        'settlement_period_end' => 'date',

        'settled_at' => 'datetime',

        'meta' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFormattedNetAmountAttribute()
    {
        return number_format($this->net_amount, 2);
    }
}