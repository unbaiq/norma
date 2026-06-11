<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Territory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'territory_code',

        'country_id',
        'state_id',
        'city_id',
        'area_id',

        'name',

        'territory_type',

        'manager_id',

        'latitude',
        'longitude',

        'coverage_radius',

        'status',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'coverage_radius' => 'decimal:2',

        'meta' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

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

    public function manager()
    {
        return $this->belongsTo(
            User::class,
            'manager_id'
        );
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function pincodes()
    {
        return $this->hasMany(Pincode::class);
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

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute()
    {
        return $this->name .
            ($this->city ? ' - ' . $this->city->name : '');
    }
}