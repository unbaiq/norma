<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FraudLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'fraud_case_id',

        'log_code',

        'action',

        'old_status',
        'new_status',

        'risk_score',

        'performed_by',

        'remarks',

        'logged_at',

        'meta',
    ];

    protected $casts = [
        'risk_score' => 'decimal:2',

        'logged_at' => 'datetime',

        'meta' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function fraudCase()
    {
        return $this->belongsTo(FraudCase::class);
    }

    public function performedBy()
    {
        return $this->belongsTo(
            User::class,
            'performed_by'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeLatestFirst($query)
    {
        return $query->latest('logged_at');
    }

    public function scopeStatusChanged($query)
    {
        return $query->whereNotNull('old_status');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getStatusTransitionAttribute()
    {
        return $this->old_status .
            ' → ' .
            $this->new_status;
    }
}