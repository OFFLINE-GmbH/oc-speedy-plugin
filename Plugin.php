<?php namespace OFFLINE\Speedy;

use Illuminate\Contracts\Http\Kernel;
use OFFLINE\Speedy\Classes\Middleware\CDNMiddleware;
use OFFLINE\Speedy\Classes\Middleware\Http2Middleware;
use System\Classes\PluginBase;

/**
 * Speedy Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'offline.speedy::lang.plugin.name',
            'description' => 'offline.speedy::lang.plugin.description',
            'author'      => 'offline.speedy::lang.plugin.author',
            'homepage'    => 'https://offline.swiss',
            'icon'        => 'icon-flash',
        ];
    }

    public function boot()
    {
        $this->app[Kernel::class]->pushMiddleware(Http2Middleware::class);
        $this->app[Kernel::class]->pushMiddleware(CDNMiddleware::class);
    }

    public function registerPermissions()
    {
        return [
            'offline.speedy.manage_settings' => [
                'tab'   => 'offline.speedy::lang.plugin.name',
                'label' => 'offline.speedy::lang.plugin.manage_settings_permission',
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'offline.speedy::lang.plugin.name',
                'description' => 'offline.speedy::lang.plugin.manage_settings',
                'category'    => 'system::lang.system.categories.cms',
                'icon'        => 'icon-flash',
                'class'       => 'Offline\Speedy\Models\Settings',
                'order'       => 500,
                'keywords'    => 'speedy caching optimization',
                'permissions' => ['offline.speedy.manage_settings'],
            ],
        ];
    }

}
