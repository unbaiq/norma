<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'parent_id',

        'category_code',

        'name',

        'slug',

        'description',

        'image',

        'icon',

        'display_order',

        'is_featured',

        'status',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'meta' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function parent()
    {
        return $this->belongsTo(
            ProductCategory::class,
            'parent_id'
        );
    }

    public function children()
    {
        return $this->hasMany(
            ProductCategory::class,
            'parent_id'
        );
    }

    public function products()
    {
        return $this->hasMany(
            Product::class,
            'category_id'
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

    public function scopeFeatured($query)
    {
        return $query->where(
            'is_featured',
            true
        );
    }

    public function scopeParentCategories($query)
    {
        return $query->whereNull('parent_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getHasChildrenAttribute()
    {
        return $this->children()->exists();
    }
}