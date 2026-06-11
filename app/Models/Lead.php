<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lead_code',

        'customer_id',

        'name',
        'mobile',
        'email',

        'gender',
        'age',

        'source',

        'country_id',
        'state_id',
        'city_id',
        'area_id',
        'territory_id',

        'address',

        'assigned_to',

        'status',
        'priority',

        'expected_order_value',

        'lead_score',

        'converted_at',
        'closed_at',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'expected_order_value' => 'decimal:2',
        'lead_score'           => 'decimal:2',

        'converted_at'         => 'datetime',
        'closed_at'            => 'datetime',

        'meta'                 => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function customer()
    {
        return $this->belongsTo(
            User::class,
            'customer_id'
        );
    }

    public function assignedTo()
    {
        return $this->belongsTo(
            User::class,
            'assigned_to'
        );
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function territory()
    {
        return $this->belongsTo(Territory::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Lead Module
    |--------------------------------------------------------------------------
    */

    public function assignments()
    {
        return $this->hasMany(LeadAssignment::class);
    }

    public function followups()
    {
        return $this->hasMany(LeadFollowup::class);
    }

    public function rejections()
    {
        return $this->hasMany(LeadRejection::class);
    }

    public function callLogs()
    {
        return $this->hasMany(CallLog::class);
    }

    public function callAttempts()
    {
        return $this->hasMany(CallAttempt::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Appointment Module
    |--------------------------------------------------------------------------
    */

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Measurement Module
    |--------------------------------------------------------------------------
    */

    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Orders
    |--------------------------------------------------------------------------
    */

    public function orders()
    {
        return $this->hasMany(Order::class);
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

    public function scopeQualified($query)
    {
        return $query->where('status', 'qualified');
    }

    public function scopeConverted($query)
    {
        return $query->where('status', 'converted');
    }

    public function scopeHot($query)
    {
        return $query->where('priority', 'high');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getDisplayNameAttribute()
    {
        return $this->name . ' (' . $this->mobile . ')';
    }

    public function getLatestFollowupAttribute()
    {
        return $this->followups()
            ->latest('followup_date')
            ->first();
    }
}