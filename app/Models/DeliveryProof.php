<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryProof extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_id',

        'proof_code',

        'proof_type',

        'file_path',
        'file_name',

        'customer_name',

        'received_by',

        'latitude',
        'longitude',

        'captured_at',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'latitude'   => 'decimal:8',
        'longitude'  => 'decimal:8',

        'captured_at' => 'datetime',

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

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeImage($query)
    {
        return $query->where('proof_type', 'image');
    }

    public function scopeSignature($query)
    {
        return $query->where('proof_type', 'signature');
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