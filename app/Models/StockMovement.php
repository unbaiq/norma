<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'movement_code',

        'inventory_id',

        'product_id',

        'from_warehouse_id',
        'to_warehouse_id',

        'movement_type',

        'quantity',

        'reference_type',
        'reference_id',

        'performed_by',

        'movement_date',

        'status',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',

        'movement_date' => 'datetime',

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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function fromWarehouse()
    {
        return $this->belongsTo(
            WarehouseLocation::class,
            'from_warehouse_id'
        );
    }

    public function toWarehouse()
    {
        return $this->belongsTo(
            WarehouseLocation::class,
            'to_warehouse_id'
        );
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

    public function scopeTransfer($query)
    {
        return $query->where(
            'movement_type',
            'transfer'
        );
    }

    public function scopeInward($query)
    {
        return $query->where(
            'movement_type',
            'inward'
        );
    }

    public function scopeOutward($query)
    {
        return $query->where(
            'movement_type',
            'outward'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getWarehouseTransferAttribute()
    {
        return ($this->fromWarehouse?->name ?? '-') .
            ' → ' .
            ($this->toWarehouse?->name ?? '-');
    }
}