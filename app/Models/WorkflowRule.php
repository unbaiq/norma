<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkflowRule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'rule_code',

        'name',

        'module',

        'event',

        'conditions',

        'actions',

        'priority',

        'execution_order',

        'is_active',

        'created_by',

        'approved_by',

        'approved_at',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'conditions' => 'array',
        'actions'    => 'array',

        'is_active'  => 'boolean',

        'approved_at' => 'datetime',

        'meta' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function approver()
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeModule($query, $module)
    {
        return $query->where('module', $module);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getStatusAttribute()
    {
        return $this->is_active
            ? 'active'
            : 'inactive';
    }
}