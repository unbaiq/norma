<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DistributorChemistMapping extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'distributor_id',
        'chemist_id',

        'mapping_code',

        'territory_id',

        'status',

        'assigned_by',

        'assigned_at',
        'approved_at',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'approved_at' => 'datetime',

        'meta' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function distributor()
    {
        return $this->belongsTo(
            User::class,
            'distributor_id'
        );
    }

    public function chemist()
    {
        return $this->belongsTo(
            User::class,
            'chemist_id'
        );
    }

    public function territory()
    {
        return $this->belongsTo(Territory::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(
            User::class,
            'assigned_by'
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

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getMappingNameAttribute()
    {
        return $this->distributor?->full_name .
            ' → ' .
            $this->chemist?->full_name;
    }
}