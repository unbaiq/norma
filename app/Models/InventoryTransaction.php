<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',

        'transaction_code',

        'transaction_type',

        'reference_type',
        'reference_id',

        'quantity',

        'opening_stock',
        'closing_stock',

        'unit_cost',
        'total_amount',

        'performed_by',

        'transaction_date',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'quantity'       => 'decimal:2',
        'opening_stock'  => 'decimal:2',
        'closing_stock'  => 'decimal:2',

        'unit_cost'      => 'decimal:2',
        'total_amount'   => 'decimal:2',

        'transaction_date' => 'datetime',

        'meta' => 'array',
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

    public function performedBy()
    {
        return $this->belongsTo(
            User::class,
            'performed_by'
        );
    }

    public function reference()
    {
        return $this->morphTo();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeInward($query)
    {
        return $query->where(
            'transaction_type',
            'inward'
        );
    }

    public function scopeOutward($query)
    {
        return $query->where(
            'transaction_type',
            'outward'
        );
    }

    public function scopeLatestFirst($query)
    {
        return $query->latest('transaction_date');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getStockDifferenceAttribute()
    {
        return $this->closing_stock -
               $this->opening_stock;
    }
}