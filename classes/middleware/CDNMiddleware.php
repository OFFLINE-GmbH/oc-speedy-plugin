<?php

namespace OFFLINE\Speedy\Classes\Middleware;

use Closure;
use Cms\Classes\Theme;
use Config;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use OFFLINE\Speedy\Models\Settings;

class CDNMiddleware
{
    protected $urlGenerator;
    protected $themePath;
    protected $cdnUrl;

    public function __construct(UrlGenerator $urlGenerator)
    {
        $themeDir  = Theme::getActiveTheme()->getDirName();
        $themePath = Config::get('cms.themesPath', '/themes') . '/' . $themeDir;

        $this->urlGenerator = $urlGenerator;
        $this->baseUrl      = $this->urlGenerator->to('/');

        $this->cdnUrl    = trim(Settings::get('domain_sharding_cdn', ''), '/');
        $this->themePath = trim($themePath, '/');
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($this->isDisabled() || $this->disableBecauseInDebug()) {
            return $response;
        }

        $contents = $response->getContent();

        $replacements = [
            $this->baseUrl . '/' . $this->themePath => $this->cdnUrl . '/' . $this->themePath,
        ];

        foreach ($replacements as $from => $to) {
            $replaced = str_replace($from, $to, $contents);
        }

        $response->setContent($replaced);

        return $response;
    }

    protected function disableBecauseInDebug()
    {
        if ( ! config('app.debug')) {
            return false;
        }

        return (bool)Settings::get('enable_domain_sharding_in_debug', false) !== true;
    }

    protected function isDisabled()
    {
        return (bool)Settings::get('enable_domain_sharding', false) !== true;
    }

}