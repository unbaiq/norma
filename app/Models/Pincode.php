<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pincode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'country_id',
        'state_id',
        'city_id',
        'area_id',
        'territory_id',

        'pincode',

        'post_office',

        'latitude',
        'longitude',

        'delivery_available',

        'status',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',

        'delivery_available' => 'boolean',

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

    public function territory()
    {
        return $this->belongsTo(Territory::class);
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

    public function scopeDeliverable($query)
    {
        return $query->where('delivery_available', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFullLocationAttribute()
    {
        return collect([
            $this->area?->name,
            $this->city?->name,
            $this->state?->name,
            $this->pincode,
        ])->filter()->implode(', ');
    }
}