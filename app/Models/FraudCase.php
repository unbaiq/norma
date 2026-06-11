<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FraudCase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'case_code',

        'user_id',
        'lead_id',
        'order_id',

        'fraud_rule_id',

        'case_type',

        'risk_score',

        'status',

        'description',

        'reported_by',

        'assigned_to',

        'detected_at',
        'resolved_at',

        'resolution_notes',

        'action_taken',

        'meta',
    ];

    protected $casts = [
        'risk_score'  => 'decimal:2',

        'detected_at' => 'datetime',
        'resolved_at' => 'datetime',

        'meta'        => 'array',
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

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function fraudRule()
    {
        return $this->belongsTo(FraudRule::class);
    }

    public function reportedBy()
    {
        return $this->belongsTo(
            User::class,
            'reported_by'
        );
    }

    public function assignedTo()
    {
        return $this->belongsTo(
            User::class,
            'assigned_to'
        );
    }

    public function logs()
    {
        return $this->hasMany(FraudLog::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
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