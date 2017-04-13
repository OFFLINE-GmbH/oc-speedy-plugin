<?php

namespace OFFLINE\Speedy\Classes\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OFFLINE\Speedy\Models\Settings;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class Http2Middleware
 *
 * This class was originally created by JacobBennett
 * @see     https://github.com/JacobBennett/laravel-HTTP2ServerPush
 *
 * @package OFFLINE\Speedy\Classes\Middleware
 */
class Http2Middleware
{
    /**
     * The DomCrawler instance.
     *
     * @var \Symfony\Component\DomCrawler\Crawler
     */
    protected $crawler;

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
        if ( ! $this->shouldHandle($request, $response)) {
            return $response;
        }

        $this->generateAndAttachLinkHeaders($response);

        return $response;
    }

    /**
     * @param \Illuminate\Http\Response $response
     *
     * @return $this
     */
    protected function generateAndAttachLinkHeaders(Response $response)
    {
        $headers = $this->fetchLinkableNodes($response)
                        ->flatten(1)
                        ->map(function ($url) {
                            return $this->buildLinkHeaderString($url);
                        })
                        ->filter()
                        ->implode(',');

        if ( ! empty(trim($headers))) {
            $this->addLinkHeader($response, $headers);
        }

        return $this;
    }

    /**
     * Get the DomCrawler instance.
     *
     * @param \Illuminate\Http\Response $response
     *
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function getCrawler(Response $response)
    {
        if ($this->crawler) {
            return $this->crawler;
        }

        return $this->crawler = new Crawler($response->getContent());
    }

    /**
     * Get all nodes we are interested in pushing.
     *
     * @param \Illuminate\Http\Response $response
     *
     * @return \Illuminate\Support\Collection
     */
    protected function fetchLinkableNodes($response)
    {
        $crawler = $this->getCrawler($response);

        return collect($crawler->filter('link, script[src], img[src]')->extract(['src', 'href']));
    }

    /**
     * Build out header string based on asset extension.
     *
     * @param string $url
     *
     * @return string
     */
    private function buildLinkHeaderString($url)
    {
        $linkTypeMap = [
            '.CSS'  => 'style',
            '.JS'   => 'script',
            '.BMP'  => 'image',
            '.GIF'  => 'image',
            '.JPG'  => 'image',
            '.JPEG' => 'image',
            '.PNG'  => 'image',
            '.TIFF' => 'image',
        ];
        $type        = collect($linkTypeMap)->first(function ($extension) use ($url) {
            return str_contains(strtoupper($url), $extension);
        });

        return is_null($type) ? null : "<{$url}>; rel=preload; as={$type}";
    }

    /**
     * Add Link Header
     *
     * @param \Illuminate\Http\Response $response
     *
     * @param                           $link
     */
    private function addLinkHeader(Response $response, $link)
    {
        $response->header('Link', $link);
    }

    /**
     * @param Request $request
     * @param         $response
     *
     * @return bool
     */
    protected function shouldHandle(Request $request, $response)
    {
        return
            (bool)Settings::get('enable_http2', true) === true
            && $response instanceof Response
            && ! $response->isRedirection()
            && ! $request->isJson();
    }
}