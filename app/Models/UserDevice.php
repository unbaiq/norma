<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'device_id',
        'device_name',
        'device_type',

        'platform',
        'os_version',

        'app_version',

        'device_token',

        'ip_address',

        'latitude',
        'longitude',

        'is_primary',
        'is_active',

        'last_login_at',
        'last_activity_at',

        'remarks',
    ];

    protected $casts = [
        'is_primary'      => 'boolean',
        'is_active'       => 'boolean',
        'last_login_at'   => 'datetime',
        'last_activity_at'=> 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
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

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function scopeAndroid($query)
    {
        return $query->where('platform', 'android');
    }

    public function scopeIos($query)
    {
        return $query->where('platform', 'ios');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getDeviceInfoAttribute()
    {
        return "{$this->device_name} ({$this->platform})";
    }
}