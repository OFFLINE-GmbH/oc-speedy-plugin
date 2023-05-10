<?php

namespace OFFLINE\Speedy\Classes\Middleware;

use Closure;
use Cms\Classes\Theme;
use Config;
use Illuminate\Http\Request;
use OFFLINE\Speedy\Models\Settings;

class CDNMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($this->isDisabled() || $this->disableBecauseInDebug()) {
            return $response;
        }

        $theme = Theme::getActiveTheme();
        if (!$theme) {
            return $response;
        }

        $themeDir = $theme->getDirName();
        $themePath = Config::get('cms.themesPath', '/themes') . '/' . $themeDir;

        $baseUrl = url()->to('/');

        $cdnUrl = trim(Settings::get('domain_sharding_cdn', ''), '/');
        $themePath = trim($themePath, '/');

        $contents = $response->getContent();

        $replacements = [
            $baseUrl . '/' . $themePath => $cdnUrl . '/' . $themePath,
        ];

        foreach ($replacements as $from => $to) {
            $replaced = str_replace($from, $to, $contents);
        }

        $response->setContent($replaced);

        return $response;
    }

    protected function disableBecauseInDebug()
    {
        if (!config('app.debug')) {
            return false;
        }

        return (bool)Settings::get('enable_domain_sharding_in_debug', false) !== true;
    }

    protected function isDisabled()
    {
        return (bool)Settings::get('enable_domain_sharding', false) !== true;
    }

}
