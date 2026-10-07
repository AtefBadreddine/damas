<?php

namespace App\Http\Middleware;

use Closure;
use LaravelLocalization;

class RedirectToLocalePrefix
{
    /**
     * add:  /about-us -> /ar/about-us (home, auth, admin, endpoints stay unprefixed)
     * strip: /ar/login -> /login, /ar -> /
     */
    public function handle($request, Closure $next, $direction = 'add')
    {
        $query = $request->getQueryString();
        $status = in_array($request->method(), ['GET', 'HEAD']) ? 301 : 307;
        $locale = LaravelLocalization::getDefaultLocale();
        $path = trim($request->path(), '/');

        // Retired landing URLs must be 404s, including before locale redirects
        // and page-cache hits. Otherwise the legacy search catchall can serve them.
        $landingPath = $path;
        $segments = explode('/', $path, 2);
        if (in_array($segments[0], LaravelLocalization::getSupportedLanguagesKeys())) {
            $landingPath = isset($segments[1]) ? $segments[1] : '';
        }
        if (preg_match('#^(?:landing[2-5](?:/|$)|landing-[^/]*(?:/|$))#', $landingPath)) {
            abort(404);
        }

        if ($direction === 'strip') {
            if ($path === $locale || $path === '') {
                $target = '/';
            } elseif (strpos($path, $locale . '/') === 0) {
                $target = '/' . substr($path, strlen($locale) + 1);
            } else {
                return $next($request);
            }

            return redirect(url($target) . ($query ? '?' . $query : ''), $status);
        }

        if ($path === '') {
            return $next($request);
        }

        if (!function_exists('locale_prefix_hidden_segment')) {
            class_exists('Helper');
        }

        $first = explode('/', $path);
        $first = $first[0];
        $locales = LaravelLocalization::getSupportedLanguagesKeys();
        if (in_array($first, $locales) || locale_prefix_hidden_segment($first)) {
            return $next($request);
        }

        $url = url($locale . '/' . $path);

        return redirect($url . ($query ? '?' . $query : ''), $status);
    }
}
