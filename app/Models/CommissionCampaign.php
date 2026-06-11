<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommissionCampaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'campaign_code',

        'name',
        'description',

        'campaign_type',

        'start_date',
        'end_date',

        'target_value',

        'commission_percentage',
        'bonus_amount',

        'status',

        'created_by',
        'approved_by',

        'approved_at',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'start_date'            => 'date',
        'end_date'              => 'date',

        'target_value'          => 'decimal:2',
        'commission_percentage' => 'decimal:2',
        'bonus_amount'          => 'decimal:2',

        'approved_at'           => 'datetime',

        'meta'                  => 'array',
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
            Commission::class,
            'commission_campaign_id'
        );
    }

    public function bonusCommissions()
    {
        return $this->hasMany(
            BonusCommission::class,
            'campaign_id'
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

    public function scopeUpcoming($query)
    {
        return $query->whereDate(
            'start_date',
            '>',
            now()
        );
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsRunningAttribute()
    {
        return now()->between(
            $this->start_date,
            $this->end_date
        );
    }

    public function getCampaignDurationAttribute()
    {
        return $this->start_date?->diffInDays(
            $this->end_date
        );
    }
}