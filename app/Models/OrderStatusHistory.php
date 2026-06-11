<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',

        'status_code',

        'old_status',
        'new_status',

        'changed_by',

        'remarks',

        'changed_at',

        'meta',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
        'meta'       => 'array',
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
        return "{$this->old_status} → {$this->new_status}";
    }
}