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
        // Known locales missing from supportedLocales are 404s too, not /ar/fr/... redirects.
        $disabledLocales = array_diff(
            config('laravellocalization.knownLocales', []),
            LaravelLocalization::getSupportedLanguagesKeys()
        );
        if (in_array($segments[0], $disabledLocales, true)) {
            abort(404);
        }
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

        // Pages renamed or removed by the Oct 2026 restructure. $landingPath has no locale,
        // so /x, /ar/x and /en/x all go straight to the new URL in that locale.
        $renamedUrl = $this->renamedPageUrl($landingPath);
        if ($renamedUrl) {
            return redirect($renamedUrl . ($query ? '?' . $query : ''), $status);
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

    /**
     * New URL for a page path (without locale) that was renamed or removed, or null.
     * route() and listingUrl() resolve to the request's locale prefix (/ar when unprefixed).
     *
     * @param string $path
     * @return string|null
     */
    protected function renamedPageUrl($path)
    {
        static $routes = array(
            'investment-turkey-istanbul' => 'front.investment',
            'turkish-citizenship' => 'front.turkish_citizenship',
            'legal-affairs-turkey' => 'front.legal',
        );
        if (isset($routes[$path])) {
            return route($routes[$path]);
        }

        // Retired Turkey overview pages go to the Turkey listing.
        if (in_array($path, array('living-turkey-real-estate-ownership', 'living_turkey', 'turkey-territories'), true)) {
            return \Helper::geo_listing_url('turkey');
        }

        // Old district guides: /istanbul-districts[/basaksehir] -> the geo listing.
        if (preg_match('#^([^/]+)-districts(?:/([^/]+))?$#', $path, $m)) {
            return \Helper::legacyListingUrlFromParts('property-for-sale', $m[1], isset($m[2]) ? $m[2] : null)
                ?: \Helper::geo_listing_url($m[1]);
        }

        return null;
    }
}
