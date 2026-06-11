<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_id',

        'changed_by',

        'old_status',
        'new_status',

        'remarks',

        'latitude',
        'longitude',

        'changed_at',

        'meta',
    ];

    protected $casts = [
        'latitude'  => 'decimal:8',
        'longitude' => 'decimal:8',

        'changed_at' => 'datetime',

        'meta' => 'array',
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

    public function changedBy()
    {
        return $this->belongsTo(
            User::class,
            'changed_by'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeLatestFirst($query)
    {
        return $query->latest('changed_at');
    }

    public function scopeDelivered($query)
    {
        return $query->where(
            'new_status',
            'delivered'
        );
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