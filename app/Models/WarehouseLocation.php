<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseLocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'warehouse_code',

        'name',

        'warehouse_type',

        'country_id',
        'state_id',
        'city_id',
        'area_id',
        'pincode_id',

        'address',

        'contact_person',
        'contact_number',
        'email',

        'latitude',
        'longitude',

        'storage_capacity',

        'status',

        'manager_id',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'storage_capacity' => 'decimal:2',

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

    public function pincode()
    {
        return $this->belongsTo(Pincode::class);
    }

    public function manager()
    {
        return $this->belongsTo(
            User::class,
            'manager_id'
        );
    }

    public function inventories()
    {
        return $this->hasMany(
            Inventory::class,
            'warehouse_id'
        );
    }

    public function incomingMovements()
    {
        return $this->hasMany(
            StockMovement::class,
            'to_warehouse_id'
        );
    }

    public function outgoingMovements()
    {
        return $this->hasMany(
            StockMovement::class,
            'from_warehouse_id'
        );
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

    public function getFullAddressAttribute()
    {
        return collect([
            $this->address,
            $this->area?->name,
            $this->city?->name,
            $this->state?->name,
            $this->pincode?->pincode,
        ])->filter()->implode(', ');
    }
}