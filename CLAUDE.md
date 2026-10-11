# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

Codebase for **damas.net**, a multilingual real-estate site (Turkey, Oman, UAE, Syria) with a built-in admin panel and CRM. It is a **Laravel 5.1** app running on **PHP 8.x** (locally PHP 8.3 under Laragon at `http://damas.test`; production is cPanel/Apache). The project root is the web root: root `index.php` and `.htaccess` forward to `public/index.php`, serve existing files from `public/`, and let missing static assets 404 without booting Laravel.

## Commands

```bash
composer install          # post-install runs scripts/php82-compat.php, which patches vendor/ Laravel for PHP 8.2+
php artisan route:list    # check route registration / ordering after editing routes
php artisan cache:clear   # needed after most front-end changes (see "Full-page cache")
gulp                      # Laravel Elixir: concatenates CSS/JS in resources/assets into public/css, public/js
```

There is no test suite: no phpunit.xml, and `app/test/TestCase.php` is only a stub. Verify changes by requesting URLs, e.g. `curl -sI http://damas.test/blog/some-slug`, and checking the status code and `Location` header.

If `composer install`/`update` ever runs without its scripts, re-run `php scripts/php82-compat.php`. Without it, Laravel 5.1 turns PHP 8 deprecations into exceptions.

## Route restructure and legacy 301s (most important context)

The URL scheme was restructured. **Old routes are kept only so they can 301 to the new canonical URLs, and those redirects must keep working.** All front routes are in `app/Http/routes.php`. Admin routes are in `app/Http/admin.php` (prefix `damas-administrator`, `auth` middleware, plus per-section `checkpermission:<perm>`).

### New canonical URL scheme
- Pages always carry a locale prefix: `/ar/about-us`, `/en/oman/guides/x`. The home page is the exception: `/` for Arabic (the default locale) and `/en` etc. for the others.
- Geo hierarchy, handled by `Front\ProjectController`: `/{locale}/{country}` → `/{city}` → `/{region}` → `/{project}`. `{country}` is restricted by `Country::slugPattern()`, which reads slugs from the DB and falls back to `turkiye|oman|uae|syria`.
- Posts, handled by `Front\PostController`: `/{locale}[/{country}]/guides|developers|reports|news[/{post}]`. The four types come from `App\Enums\PostType`, a class-based enum (use `PostType::$BLOG` etc. and `tryFrom()`). Its `frontIndexRoute()`, `frontCountryRoute()` and `frontShowRoute()` methods map each type to its route name. The `blog` type is the one served at `guides`.
- Canonical URLs are built by model methods such as `geoUrl()` and `listingUrl()` on `Post`, `Project`, `Country`, `City`, `Region` and `PostCategory`. Use these; don't hand-build paths. A show page reached with a non-canonical slug, or under the wrong post type, 301s to `geoUrl()`.

### How old URLs are redirected
- **Locale prefix**: the `RedirectToLocalePrefix` middleware runs globally and also as the route middleware `localePrefix:add|strip`.
  - `add` 301s unprefixed page URLs to `/ar/...`.
  - `strip` 301s `/ar/login` → `/login` and `/ar` → `/`.
  - Non-GET requests get a 307 instead of a 301.
  - Retired `landing2-5` and `landing-*` URLs `abort(404)` here, before any other handling.
  - Unprefixed old listing URLs (`/{type}/{city}/{var1?}/{var2?}`, where `{type}` passes `Helper::isLegacyListingType()`) 301 straight to the geo URL here via `Helper::legacyListingUrlFromRequest()`, one hop, before the `/ar` redirect. The old AMP search form (`?amp=1` on a listing path) gets a 302. `?amp=1` on any other path is ignored.
- **Endpoints stay unprefixed**: AJAX, cron, callus, login/register, `damas-administrator`, webhooks and similar are listed in `locale_prefix_hidden_segment()` in `app/Helpers/Helper.php`. Add any new technical endpoint there, or it will be redirected to `/ar/...`.
- **`$legacyGroup`** in routes.php registers auth, endpoint and home routes twice. One copy is the normal one. The other is a `/{defaultLocale}/...` copy that strips the prefix.
- **Redirect-only legacy routes** point at `HomeController` methods that only look up the record and 301 to its new URL. They are `$redirectOnlyRoutes` (`/projects/{slug}`, `/blog/...`, `/news/{slug}`, `/news/category/...`) plus the `/oman/...` and `/syria/...` groups. Examples:
  - `project_show` and `blog_show_post` redirect to `geoUrl()`.
  - `blog_index` and `blog_show_category` redirect to the index route, as `/guides?category=slug`.
  - `search()` (the old listing renderer, now removed) only 301s via `Helper::legacyListingUrlFromRequest()` or 404s, and `redirect_url` uses the DB-driven short redirects. Build links to old-style type/city/tag/region combinations with `Helper::legacy_listing_url()`.
- These redirect-only paths are deliberately **excluded** from the locale `add` redirect (the `$isLegacyRedirect` check in `RedirectToLocalePrefix`). That keeps each one to a single hop (`/blog/x` → `/ar/guides/...`) rather than chaining through `/ar/blog/x`. If you add a legacy path, update that check too.
- Legacy routes pass `country` and `type` as **extra keys in the route action array**, not via `Route::defaults()`. On Laravel 5.1, `defaults()` overwrites the last path parameter. `HomeController::legacyRouteValue()` reads them back (route parameter first, then the action array).

### Ordering pitfalls in `$pageRoutes`
- Routes are matched in registration order, and the generic catch-alls are last: `/{type}/{city}/{var1?}/{var2?}` (old search) and `/{redirect_slug}`. A new fixed page must be registered **above** them. Inside `{country}`, the `{city}` patterns exclude reserved words such as `guides`, `news` and `projects`, so a new reserved segment must be added to those `where` regexes.
- The route file branches on `$urlLocale = LaravelLocalization::setLocale()`. It registers different groups depending on whether the current request has a locale prefix, so `route:list` output depends on the request URL.

## Other architecture notes

- **Full-page cache**: the `CacheGetPages` global middleware stores the HTML of every GET response for 30 days, keyed by full URL (`page_cache_*` in the file cache). Admin, cron, currency, webhook and some AJAX paths are exempt. After changing templates, routes or redirects, run `php artisan cache:clear` (or use the admin `clear_cache` action or `/clear-cache`), or you will see stale output.
- **Locales** (`config/laravellocalization.php`): `ar` (default), `en`, `fr`, `pe` (Persian), `ru`. `hideDefaultLocaleInURL` is false. Content code maps `pe` to `fa` when selecting DB language columns.
- **Controllers are very large**: `Front/HomeController.php` (~7.8k lines), `Admin/AdminController.php` (~5k) and `app/Helpers/Helper.php` (~4.4k, a global `Helper` class plus global functions, classmap-autoloaded). Grep for the method you need instead of reading them whole. The newer, cleaner code is `Front/ProjectController` and `Front/PostController`.
- **Models**: `app/Models`, tables prefixed `dms_`. Roles and permissions use `bican/roles`, enforced by the `checkpermission` middleware.
- **Other front parts**: an AMP mirror under `/amp` (`Front/AmpController`, `resources/views/amp`), and the `exchange` middleware for currency conversion. A WhatsApp Business webhook (`/webhooks/whatsapp`) is configured in `config/whatsapp.php`.
- **PHP version range**: code must parse on PHP 7.4 as well as 8.x (the `.htaccess` cPanel block references ea-php74). So no native enums, `match`, readonly properties, etc.; follow the `PostType` class-based enum pattern.
- Files with suffixes like `*.before-*`, and the `___old/` directory, are local backups. Ignore them.
