<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',

        'variant_code',

        'sku',

        'name',

        'size',

        'color',

        'side',

        'support_level',

        'measurement_range',

        'mrp',

        'selling_price',

        'stock_quantity',

        'weight',

        'status',

        'is_default',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'mrp' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'stock_quantity' => 'decimal:2',
        'weight' => 'decimal:2',

        'is_default' => 'boolean',

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

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function recommendations()
    {
        return $this->hasMany(
            ProductRecommendation::class
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

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getDiscountAmountAttribute()
    {
        return $this->mrp - $this->selling_price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->mrp <= 0) {
            return 0;
        }

        return round(
            (($this->mrp - $this->selling_price) / $this->mrp) * 100,
            2
        );
    }
}