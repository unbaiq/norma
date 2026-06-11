<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'commission_id',
        'user_id',

        'transaction_code',

        'transaction_type',

        'reference_type',
        'reference_id',

        'amount',

        'opening_balance',
        'closing_balance',

        'status',

        'transaction_date',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'opening_balance' => 'decimal:2',
        'closing_balance' => 'decimal:2',

        'transaction_date' => 'datetime',

        'meta' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function commission()
    {
        return $this->belongsTo(Commission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reference()
    {
        return $this->morphTo();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeCredit($query)
    {
        return $query->where('transaction_type', 'credit');
    }

    public function scopeDebit($query)
    {
        return $query->where('transaction_type', 'debit');
    }

    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
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