<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'score_code',

        'score_period',

        'period_start_date',
        'period_end_date',

        'lead_score',
        'appointment_score',
        'measurement_score',
        'order_score',
        'sales_score',
        'commission_score',

        'attendance_score',

        'quality_score',

        'total_score',

        'rank_position',

        'grade',

        'status',

        'calculated_at',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'period_start_date' => 'date',
        'period_end_date'   => 'date',

        'lead_score'        => 'decimal:2',
        'appointment_score' => 'decimal:2',
        'measurement_score' => 'decimal:2',
        'order_score'       => 'decimal:2',
        'sales_score'       => 'decimal:2',
        'commission_score'  => 'decimal:2',
        'attendance_score'  => 'decimal:2',
        'quality_score'     => 'decimal:2',

        'total_score'       => 'decimal:2',

        'calculated_at'     => 'datetime',

        'meta'              => 'array',
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

    public function scopeDaily($query)
    {
        return $query->where('score_period', 'daily');
    }

    public function scopeMonthly($query)
    {
        return $query->where('score_period', 'monthly');
    }

    public function scopeTopPerformers($query)
    {
        return $query->orderByDesc('total_score');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsTopPerformerAttribute()
    {
        return $this->rank_position <= 10;
    }
}