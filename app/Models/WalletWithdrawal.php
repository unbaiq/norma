<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletWithdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'user_id',
        'bank_account_id',

        'withdrawal_code',

        'amount',
        'processing_fee',
        'net_amount',

        'status',

        'requested_at',
        'approved_at',
        'processed_at',
        'rejected_at',

        'approved_by',
        'rejected_by',

        'transaction_reference',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'processing_fee' => 'decimal:2',
        'net_amount' => 'decimal:2',

        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'processed_at' => 'datetime',
        'rejected_at' => 'datetime',

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

    public function bankAccount()
    {
        return $this->belongsTo(
            UserBankAccount::class,
            'bank_account_id'
        );
    }

    public function approvedBy()
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }

    public function rejectedBy()
    {
        return $this->belongsTo(
            User::class,
            'rejected_by'
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

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeProcessed($query)
    {
        return $query->where('status', 'processed');
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

    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2);
    }
}