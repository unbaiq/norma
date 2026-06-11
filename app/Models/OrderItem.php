<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',

        'product_id',
        'product_variant_id',

        'item_code',

        'product_name',

        'sku',

        'quantity',

        'unit_price',

        'discount_amount',

        'tax_amount',

        'subtotal',

        'total_amount',

        'status',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'quantity'        => 'decimal:2',
        'unit_price'      => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount'      => 'decimal:2',
        'subtotal'        => 'decimal:2',
        'total_amount'    => 'decimal:2',

        'meta'            => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(
            ProductVariant::class,
            'product_variant_id'
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

    public function getFinalAmountAttribute()
    {
        return $this->total_amount;
    }
}