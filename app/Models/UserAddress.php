<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'address_type',

        'name',
        'mobile',

        'address_line_1',
        'address_line_2',
        'landmark',

        'country_id',
        'state_id',
        'city_id',
        'area_id',
        'pincode_id',

        'latitude',
        'longitude',

        'is_default',
        'status',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
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

    public function pincode()
    {
        return $this->belongsTo(Pincode::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFullAddressAttribute()
    {
        return collect([
            $this->address_line_1,
            $this->address_line_2,
            $this->landmark,
            optional($this->area)->name,
            optional($this->city)->name,
            optional($this->state)->name,
            optional($this->country)->name,
            optional($this->pincode)->pincode,
        ])->filter()->implode(', ');
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

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function scopeHome($query)
    {
        return $query->where('address_type', 'home');
    }

    public function scopeOffice($query)
    {
        return $query->where('address_type', 'office');
    }
}