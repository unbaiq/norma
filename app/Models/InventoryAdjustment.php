<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAdjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',

        'adjustment_code',

        'adjustment_type',

        'old_quantity',
        'new_quantity',
        'adjusted_quantity',

        'reason',

        'approved_by',

        'adjusted_by',

        'adjusted_at',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'old_quantity'      => 'decimal:2',
        'new_quantity'      => 'decimal:2',
        'adjusted_quantity' => 'decimal:2',

        'adjusted_at'       => 'datetime',

        'meta'              => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function adjustedBy()
    {
        return $this->belongsTo(
            User::class,
            'adjusted_by'
        );
    }

    public function approvedBy()
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeIncrease($query)
    {
        return $query->where(
            'adjustment_type',
            'increase'
        );
    }

    public function scopeDecrease($query)
    {
        return $query->where(
            'adjustment_type',
            'decrease'
        );
    }

    public function scopeLatestFirst($query)
    {
        return $query->latest('adjusted_at');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getDifferenceAttribute()
    {
        return $this->new_quantity -
               $this->old_quantity;
    }
}