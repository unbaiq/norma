<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasurementNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'measurement_id',

        'note_code',

        'note_type',

        'title',

        'note',

        'created_by',

        'is_internal',

        'status',

        'recorded_at',

        'meta',
    ];

    protected $casts = [
        'is_internal' => 'boolean',

        'recorded_at' => 'datetime',

        'meta' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function measurement()
    {
        return $this->belongsTo(Measurement::class);
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

    public function scopeInternal($query)
    {
        return $query->where('is_internal', true);
    }

    public function scopePublic($query)
    {
        return $query->where('is_internal', false);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getShortNoteAttribute()
    {
        return \Illuminate\Support\Str::limit(
            $this->note,
            100
        );
    }
}