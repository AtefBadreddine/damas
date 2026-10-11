<?php

namespace App\Http\Middleware;

use Closure;
use LaravelLocalization;

class RedirectToLocalePrefix
{
    /**
     * add:  /about-us -> /ar/about-us (home, auth, admin, endpoints stay unprefixed)
     * strip: /ar/login -> /login, /ar -> /
     * Retired locales (fr, pe, ru) always go to English: /fr/oman -> /en/oman, /ru -> /en
     */
    private static $retiredLocales = ['fr', 'pe', 'ru'];

    public function handle($request, Closure $next, $direction = 'add')
    {
        $query = $request->getQueryString();
        $status = in_array($request->method(), ['GET', 'HEAD']) ? 301 : 307;
        $locale = LaravelLocalization::getDefaultLocale();
        $path = trim($request->path(), '/');

        // Runs before CacheGetPages, so cached /fr|/pe|/ru pages are never served again.
        $segments = explode('/', $path, 2);
        if (in_array($segments[0], self::$retiredLocales, true)) {
            $target = 'en' . (isset($segments[1]) && $segments[1] !== '' ? '/' . $segments[1] : '');

            return redirect(url($target) . ($query ? '?' . $query : ''), $status);
        }

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

        // Unprefixed legacy URLs already 301 in the controller. Skip the locale hop
        // so /blog/x goes once to /ar/guides/... instead of /blog/x -> /ar/blog/x -> geo.
        // /news and /projects listings still need /ar; only their old child paths skip.
        // /oman|/syria/blog uses the same controller 301; skip global and route localePrefix:add.
        $isLegacyRedirect = ($path === 'blog' || strpos($path, 'blog/') === 0)
            || preg_match('#^(oman|syria)/blog(/|$)#', $path)
            || preg_match('#^news/(category/)?[^/]+$#', $path)
            || preg_match('#^((oman|syria)/)?projects/[^/]+$#', $path);
        if ($isLegacyRedirect) {
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

        // Old /{type}/{city}/{var1?}/{var2?} listings go straight to the geo URL,
        // not /ar/{type}/... first. The type check runs before any other lookup, so
        // other pages (and /oman, /syria) skip this block. Unknown cities and slugs
        // resolve to null and fall through. The AMP search form result is a 302.
        $parts = explode('/', $path);
        if ($status === 301 && count($parts) >= 2 && count($parts) <= 4
            && \Helper::isLegacyListingType($first)) {
            $geoUrl = \Helper::legacyListingUrlFromRequest(
                $request,
                $parts[0],
                $parts[1],
                isset($parts[2]) ? $parts[2] : null,
                isset($parts[3]) ? $parts[3] : null
            );
            if ($geoUrl) {
                return redirect($geoUrl, $request->get('amp') == '1' ? 302 : 301);
            }
        }

        $url = url($locale . '/' . $path);

        return redirect($url . ($query ? '?' . $query : ''), $status);
    }
}
