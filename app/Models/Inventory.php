<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'inventory_code',

        'product_id',
        'warehouse_location_id',

        'batch_no',

        'sku',

        'available_qty',
        'reserved_qty',
        'damaged_qty',
        'returned_qty',

        'reorder_level',
        'maximum_stock',

        'unit_cost',

        'manufacturing_date',
        'expiry_date',

        'status',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'available_qty' => 'decimal:2',
        'reserved_qty'  => 'decimal:2',
        'damaged_qty'   => 'decimal:2',
        'returned_qty'  => 'decimal:2',

        'reorder_level' => 'decimal:2',
        'maximum_stock' => 'decimal:2',

        'unit_cost'     => 'decimal:2',

        'manufacturing_date' => 'date',
        'expiry_date'        => 'date',

        'meta' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouseLocation()
    {
        return $this->belongsTo(
            WarehouseLocation::class
        );
    }

    public function transactions()
    {
        return $this->hasMany(
            InventoryTransaction::class
        );
    }

    public function adjustments()
    {
        return $this->hasMany(
            InventoryAdjustment::class
        );
    }

    public function stockMovements()
    {
        return $this->hasMany(
            StockMovement::class
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

    public function scopeLowStock($query)
    {
        return $query->whereColumn(
            'available_qty',
            '<=',
            'reorder_level'
        );
    }

    public function scopeExpired($query)
    {
        return $query->whereDate(
            'expiry_date',
            '<',
            now()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getTotalStockAttribute()
    {
        return (
            $this->available_qty +
            $this->reserved_qty +
            $this->returned_qty
        );
    }

    public function getIsLowStockAttribute()
    {
        return $this->available_qty <= $this->reorder_level;
    }
}