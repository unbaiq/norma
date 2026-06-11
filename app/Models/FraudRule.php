<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FraudRule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'rule_code',

        'name',
        'description',

        'rule_type',

        'risk_score',

        'condition_type',
        'condition_value',

        'action_type',

        'priority',

        'status',

        'created_by',
        'approved_by',

        'approved_at',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'risk_score' => 'decimal:2',

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

    public function fraudCases()
    {
        return $this->hasMany(FraudCase::class);
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

    public function scopeHighRisk($query)
    {
        return $query->where('risk_score', '>=', 80);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsHighRiskAttribute()
    {
        return $this->risk_score >= 80;
    }
}