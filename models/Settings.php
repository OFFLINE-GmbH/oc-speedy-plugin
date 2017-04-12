<?php

namespace OFFLINE\Speedy\Models;

use Model;
use OFFLINE\Speedy\Classes\Htaccess\HtaccessManager;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'offline_speedy_settings';

    public $settingsFields = 'fields.yaml';

    public static function boot()
    {
        parent::boot();

        static::saved(function (Settings $setting) {

            function key($value, $setting)
            {
                $values = $setting->value;

                return array_key_exists($value, $values)
                    ? (bool)$values[$value]
                    : false;
            }

            $enableCaching        = key('enable_caching', $setting);
            $enableGzip           = key('enable_gzip', $setting);
            $enableDomainSharding = key('enable_domain_sharding', $setting);

            $htaccess = new HtaccessManager();
            $htaccess->toggleSection('caching', $enableCaching);
            $htaccess->toggleSection('gzip', $enableGzip);
            $htaccess->toggleSection('domain_sharding', $enableDomainSharding);
            $htaccess->save();
        });
    }

}