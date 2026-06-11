<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInstruction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',

        'instruction_code',

        'instruction_type',

        'title',

        'content',

        'file_path',

        'display_order',

        'status',

        'created_by',

        'remarks',

        'meta',
    ];

    protected $casts = [
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

    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
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

    public function scopeUsage($query)
    {
        return $query->where(
            'instruction_type',
            'usage'
        );
    }

    public function scopeSafety($query)
    {
        return $query->where(
            'instruction_type',
            'safety'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFileUrlAttribute()
    {
        return $this->file_path
            ? asset('storage/' . $this->file_path)
            : null;
    }
}