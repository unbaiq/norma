<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'wallet_code',

        'balance',
        'credit_balance',
        'debit_balance',

        'pending_balance',
        'withdrawable_balance',

        'currency',

        'status',

        'last_transaction_at',

        'remarks',
        'meta',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'credit_balance' => 'decimal:2',
        'debit_balance' => 'decimal:2',
        'pending_balance' => 'decimal:2',
        'withdrawable_balance' => 'decimal:2',

        'last_transaction_at' => 'datetime',

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

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(WalletWithdrawal::class);
    }

    public function settlements()
    {
        return $this->hasMany(WalletSettlement::class);
    }

    public function adjustments()
    {
        return $this->hasMany(WalletAdjustment::class);
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
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function credit($amount)
    {
        $this->increment('balance', $amount);
        $this->increment('credit_balance', $amount);
    }

    public function debit($amount)
    {
        $this->decrement('balance', $amount);
        $this->increment('debit_balance', $amount);
    }
}