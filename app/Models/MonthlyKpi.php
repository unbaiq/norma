<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyKpi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'month',
        'year',

        'total_leads',
        'converted_leads',

        'total_followups',

        'appointments_scheduled',
        'appointments_completed',

        'measurements_completed',

        'orders_created',
        'orders_completed',

        'sales_amount',

        'commission_amount',

        'wallet_earnings',

        'performance_score',

        'rank_position',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'sales_amount'      => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'wallet_earnings'   => 'decimal:2',
        'performance_score' => 'decimal:2',

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

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeCurrentMonth($query)
    {
        return $query->where('month', now()->month)
                     ->where('year', now()->year);
    }

    public function scopeTopPerformers($query)
    {
        return $query->orderByDesc('performance_score');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getConversionRateAttribute()
    {
        if ($this->total_leads == 0) {
            return 0;
        }

        return round(
            ($this->converted_leads / $this->total_leads) * 100,
            2
        );
    }

    public function getMonthYearAttribute()
    {
        return $this->month . '/' . $this->year;
    }
}