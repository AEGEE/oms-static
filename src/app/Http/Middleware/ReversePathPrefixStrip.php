<?php

namespace App\Http\Middleware;

use Closure;

class ReversePathPrefixStrip
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $response = $next($request);

        //TODO: Better fix for this?
        $content = $response->content();
        $content = $this->replace($content);
        $response->setContent($content);

        if (property_exists($response, 'targetUrl')) {
            $response->setTargetUrl($this->replace($response->getTargetUrl()));
        }

        return $response;
    }

    private function replace($str) {
        $str = preg_replace('!https?://appserver/!', 'http://appserver/static/', $str);
        $str = preg_replace('!https?://appserver/static/static/!', 'http://appserver/static/', $str);

        return $str;
    }
}
