<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BonusCommission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bonus_code',

        'user_id',
        'commission_id',
        'campaign_id',

        'bonus_type',

        'target_value',
        'achieved_value',

        'bonus_amount',

        'status',

        'earned_at',
        'approved_at',
        'paid_at',

        'approved_by',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'target_value'   => 'decimal:2',
        'achieved_value' => 'decimal:2',
        'bonus_amount'   => 'decimal:2',

        'earned_at'      => 'datetime',
        'approved_at'    => 'datetime',
        'paid_at'        => 'datetime',

        'meta'           => 'array',
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

    public function commission()
    {
        return $this->belongsTo(Commission::class);
    }

    public function campaign()
    {
        return $this->belongsTo(
            CommissionCampaign::class,
            'campaign_id'
        );
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

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFormattedBonusAmountAttribute()
    {
        return number_format(
            $this->bonus_amount,
            2
        );
    }
}