<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletAdjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'user_id',

        'adjustment_code',

        'adjustment_type',

        'amount',

        'opening_balance',
        'closing_balance',

        'reason',

        'status',

        'approved_by',

        'approved_at',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'opening_balance' => 'decimal:2',
        'closing_balance' => 'decimal:2',

        'approved_at' => 'datetime',

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

    public function scopeCredit($query)
    {
        return $query->where('adjustment_type', 'credit');
    }

    public function scopeDebit($query)
    {
        return $query->where('adjustment_type', 'debit');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2);
    }
}