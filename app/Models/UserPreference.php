<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'language',
        'timezone',
        'currency',

        'theme',

        'email_notifications',
        'sms_notifications',
        'push_notifications',
        'whatsapp_notifications',

        'marketing_notifications',

        'location_tracking',

        'dashboard_layout',

        'meta',
    ];

    protected $casts = [
        'email_notifications'      => 'boolean',
        'sms_notifications'        => 'boolean',
        'push_notifications'       => 'boolean',
        'whatsapp_notifications'   => 'boolean',
        'marketing_notifications'  => 'boolean',
        'location_tracking'        => 'boolean',

        'dashboard_layout'         => 'array',
        'meta'                     => 'array',
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

    public function scopeEnglish($query)
    {
        return $query->where('language', 'en');
    }

    public function scopeDarkTheme($query)
    {
        return $query->where('theme', 'dark');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getNotificationChannelsAttribute()
    {
        return [
            'email'    => $this->email_notifications,
            'sms'      => $this->sms_notifications,
            'push'     => $this->push_notifications,
            'whatsapp' => $this->whatsapp_notifications,
        ];
    }
}