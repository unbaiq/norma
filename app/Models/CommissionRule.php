<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommissionRule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'rule_code',

        'name',
        'description',

        'applicable_to',

        'commission_type',

        'calculation_method',

        'commission_value',

        'minimum_amount',
        'maximum_amount',

        'minimum_target',
        'maximum_target',

        'priority',

        'start_date',
        'end_date',

        'status',

        'created_by',
        'approved_by',

        'approved_at',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'commission_value' => 'decimal:2',

        'minimum_amount' => 'decimal:2',
        'maximum_amount' => 'decimal:2',

        'minimum_target' => 'decimal:2',
        'maximum_target' => 'decimal:2',

        'start_date' => 'date',
        'end_date' => 'date',

        'approved_at' => 'datetime',

        'meta' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function approver()
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }

    public function commissions()
    {
        return $this->hasMany(
            Commission::class
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

    public function scopeOrderRules($query)
    {
        return $query->where(
            'applicable_to',
            'order'
        );
    }

    public function scopeReferralRules($query)
    {
        return $query->where(
            'applicable_to',
            'referral'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsRunningAttribute()
    {
        return $this->status === 'active'
            && now()->between(
                $this->start_date,
                $this->end_date
            );
    }
}