<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_id',

        'tracking_code',

        'status',

        'location',

        'latitude',
        'longitude',

        'event_time',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'latitude'   => 'decimal:8',
        'longitude'  => 'decimal:8',

        'event_time' => 'datetime',

        'meta'       => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeLatestFirst($query)
    {
        return $query->latest('event_time');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeInTransit($query)
    {
        return $query->where('status', 'in_transit');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getCoordinatesAttribute()
    {
        return $this->latitude . ',' . $this->longitude;
    }
}