<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChemistRanking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'ranking_code',

        'ranking_period',

        'rank_position',

        'total_leads',
        'converted_leads',

        'total_orders',
        'completed_orders',

        'total_sales',

        'commission_earned',

        'performance_score',

        'achievement_percentage',

        'ranking_date',

        'status',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'total_sales' => 'decimal:2',
        'commission_earned' => 'decimal:2',
        'performance_score' => 'decimal:2',
        'achievement_percentage' => 'decimal:2',

        'ranking_date' => 'date',

        'meta' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function chemist()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeMonthly($query)
    {
        return $query->where(
            'ranking_period',
            'monthly'
        );
    }

    public function scopeQuarterly($query)
    {
        return $query->where(
            'ranking_period',
            'quarterly'
        );
    }

    public function scopeYearly($query)
    {
        return $query->where(
            'ranking_period',
            'yearly'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getRankLabelAttribute()
    {
        return '#' . $this->rank_position;
    }
}