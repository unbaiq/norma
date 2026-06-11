<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_key',

        'setting_group',

        'setting_name',

        'setting_value',

        'setting_type',

        'description',

        'is_public',

        'is_editable',

        'status',

        'updated_by',

        'remarks',

        'meta',
    ];

    protected $casts = [
        'is_public'   => 'boolean',
        'is_editable' => 'boolean',

        'meta' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function updatedBy()
    {
        return $this->belongsTo(
            User::class,
            'updated_by'
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

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeGroup($query, $group)
    {
        return $query->where(
            'setting_group',
            $group
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public static function getValue($key, $default = null)
    {
        return static::where(
            'setting_key',
            $key
        )->value('setting_value') ?? $default;
    }

    public static function setValue($key, $value)
    {
        return static::updateOrCreate(
            ['setting_key' => $key],
            ['setting_value' => $value]
        );
    }
}