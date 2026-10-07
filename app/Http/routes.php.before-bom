<?php

Route::get('/cron_cache_stats', function () {
    $hits = Cache::get('cache_hits', 0);
    $misses = Cache::get('cache_misses', 0);

    return "
    <h2>Cache Statistics</h2>
    <p><strong>Cache HIT:</strong> $hits</p>
    <p><strong>Cache MISS:</strong> $misses</p>
    ";
});

Route::get('/redis-test', function () {
    try {
        Cache::put('test_key', 'Redis works ✅', 60);
        return Cache::get('test_key');
    } catch (Throwable $e) {
        return 'Redis Error ❌: ' . $e->getMessage();
    }
});

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
});


/**
* whatsapp business platform webhooks
*/
Route::get('/webhooks/whatsapp', [
    'uses' => 'WhatsAppWebhookController@verify'
]);
Route::post('/webhooks/whatsapp', [
    'uses' => 'WhatsAppWebhookController@receive'
]);


/**
* admin routes
*/
require __DIR__ . '/admin.php';


/**
* Locale prefixes
* Pages always carry the locale: /ar/about-us, /en/oman/guides/x.
* Home stays / for Arabic and /en for other locales.
* Endpoints and auth keep the default locale hidden.
*/
$urlLocale = LaravelLocalization::setLocale();
$defaultLocale = LaravelLocalization::getDefaultLocale();
$localeRequiredPrefix = $urlLocale ?: $defaultLocale;
$legacyPrefix = ($urlLocale === $defaultLocale) ? null : $urlLocale;

$legacyGroup = function (array $attributes, $closure) use ($urlLocale, $defaultLocale) {
    if ($urlLocale === $defaultLocale) {
        $stripPrefix = $defaultLocale;
        if (!empty($attributes['prefix'])) {
            $stripPrefix .= '/' . ltrim($attributes['prefix'], '/');
        }
        $strip = array(
            'prefix' => $stripPrefix,
            'middleware' => array('localePrefix:strip'),
        );
        if (!empty($attributes['namespace'])) {
            $strip['namespace'] = $attributes['namespace'];
        }
        Route::group($strip, $closure);
    }
    Route::group($attributes, $closure);
};


/**
* Auth routes
*/
$authRoutes = function () {
    Route::get('/damas-administrator/login', ['as' => 'login_adm', 'uses' => 'AuthController@getLogin']);
    Route::post('/damas-administrator/login', 'AuthController@postLogin');

    Route::get('/login', ['as' => 'login', 'uses' => 'AuthController@getLogin']);
    Route::post('/login', 'AuthController@postLogin');
    Route::get('/logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);

    Route::get('/register', ['as' => 'register', 'uses' => 'AuthController@getRegister']);
    Route::post('/register', ['as' => 'register', 'uses' => 'AuthController@postRegister']);

    Route::controllers([
        'password' => 'PasswordController',
    ]);
};
$legacyGroup(['prefix' => $legacyPrefix, 'middleware' => ['localize'], 'namespace' => 'Auth'], $authRoutes);


/**
* Legacy /oman and /syria URLs. `country` (Country code) and `type` (PostType value)
* live in the route action, not Route::defaults(): on 5.1 defaults() overwrites the
* last path parameter ({slug}). HomeController::legacyRouteValue() reads them.
*/
$omanRoutes = function () {
    Route::any('/projects/{slug}', ['as' => 'front.project.oman', 'uses' => 'HomeController@project_show', 'country' => 'oman']);
    Route::any('/media/{slug}', ['as' => 'front.project_data.oman', 'uses' => 'HomeController@project_data', 'country' => 'oman']);
    Route::group(['prefix' => 'blog'], function () {
        Route::any('/', ['as' => 'front.blog.oman', 'uses' => 'HomeController@blog_index', 'country' => 'oman', 'type' => 'blog']);
        Route::any('/category/{slug}', ['as' => 'front.blog.category.oman', 'uses' => 'HomeController@blog_show_category', 'country' => 'oman', 'type' => 'blog']);
        Route::any('/{slug}', ['as' => 'front.blog.post.oman', 'uses' => 'HomeController@blog_show_post', 'country' => 'oman', 'type' => 'blog']);
    });
};
$omanFront = array(
    'middleware' => array('localize', 'exchange'),
    'namespace' => 'Front',
    'locale_required' => true,
);
if ($urlLocale === null) {
    Route::group(array_merge($omanFront, array('prefix' => 'oman', 'middleware' => array('localePrefix:add'))), $omanRoutes);
}
Route::group(array_merge($omanFront, array('prefix' => $localeRequiredPrefix . '/oman')), $omanRoutes);

$syriaRoutes = function () {
    Route::any('/projects/{slug}', ['as' => 'front.project.syria', 'uses' => 'HomeController@project_show', 'country' => 'syria']);
    Route::any('/media/{slug}', ['as' => 'front.project_data.syria', 'uses' => 'HomeController@project_data', 'country' => 'syria']);
    Route::group(['prefix' => 'blog'], function () {
        Route::any('/', ['as' => 'front.blog.syria', 'uses' => 'HomeController@blog_index', 'country' => 'syria', 'type' => 'blog']);
        Route::any('/category/{slug}', ['as' => 'front.blog.category.syria', 'uses' => 'HomeController@blog_show_category', 'country' => 'syria', 'type' => 'blog']);
        Route::any('/{slug}', ['as' => 'front.blog.post.syria', 'uses' => 'HomeController@blog_show_post', 'country' => 'syria', 'type' => 'blog']);
    });
};
$syriaFront = array(
    'middleware' => array('localize', 'exchange'),
    'namespace' => 'Front',
    'locale_required' => true,
);
if ($urlLocale === null) {
    Route::group(array_merge($syriaFront, array('prefix' => 'syria', 'middleware' => array('localePrefix:add'))), $syriaRoutes);
}
Route::group(array_merge($syriaFront, array('prefix' => $localeRequiredPrefix . '/syria')), $syriaRoutes);


/**
* AMP routes
*/
$ampRoutes = function () {
    Route::group(['prefix' => 'amp'], function () {
        Route::any('/', ['as' => 'amp.front.index', 'uses' => 'AmpController@index']);
        Route::any('/projects/{slug}', ['as' => 'amp.front.project', 'uses' => 'AmpController@project_show']);
        Route::any('/callus', ['as' => 'amp.front.callus', 'uses' => 'AmpController@call_us']);
        Route::group(['prefix' => 'blog'], function () {
            Route::any('/', ['as' => 'amp.front.blog', 'uses' => 'AmpController@blog_index']);
            Route::any('/{slug}', ['as' => 'amp.front.blog.post', 'uses' => 'AmpController@blog_show_post']);
        });
        Route::any('/{type}/{city}/{var1?}/{var2?}', ['as' => 'amp.front.search', 'uses' => 'AmpController@search']);
        Route::any('/privacy-policy', ['as' => 'amp.front.privacy', 'uses' => 'AmpController@privacy']);
        Route::any('/terms-of-use', ['as' => 'amp.front.terms', 'uses' => 'AmpController@terms']);
        Route::any('/contact-us', ['as' => 'amp.front.contact', 'uses' => 'AmpController@contactus']);
        Route::any('/about-us', ['as' => 'amp.front.about', 'uses' => 'AmpController@about_us']);
        Route::any('/vacancies', ['as' => 'amp.front.vacancies', 'uses' => 'AmpController@vacancies']);
        Route::any('/turkish-citizenship', ['as' => 'amp.front.turkish_citizenship', 'uses' => 'AmpController@turkish_citizenship']);
        Route::any('/investment-turkey-istanbul', ['as' => 'amp.front.investment', 'uses' => 'AmpController@investment']);
        Route::any('/living-turkey-real-estate-ownership', ['as' => 'amp.front.living_turkey', 'uses' => 'AmpController@living_turkey']);
        Route::any('/faq', ['as' => 'amp.front.faq', 'uses' => 'AmpController@faq']);
        Route::any('/story', ['as' => 'amp.front.stories', 'uses' => 'AmpController@stories']);
        Route::any('/legal-affairs-turkey', ['as' => 'amp.front.legal', 'uses' => 'AmpController@legal']);
    });
};
$ampFront = array(
    'middleware' => array('localize'),
    'namespace' => 'Front',
    'locale_required' => true,
);
if ($urlLocale === null) {
    Route::group(array_merge($ampFront, array('middleware' => array('localePrefix:add'))), $ampRoutes);
}
Route::group(array_merge($ampFront, array('prefix' => $localeRequiredPrefix)), $ampRoutes);


/**
* Technical endpoints — default locale stays hidden
*/
$endpointRoutes = function () {
    Route::any('/callmeModalAjax', ['as' => 'front.callmeModalAjax', 'uses' => 'HomeController@callmeModalAjax']);
    Route::get('/ajax/keyword', ['as' => 'front.ajaxkeywords', 'uses' => 'HomeController@ajaxkeywords']);
    Route::any('/ajax/{option}', ['as' => 'front.ajax', 'uses' => 'HomeController@ajax']);
    Route::any('/preview_pdf/{id}', ['as' => 'front.preview_pdf', 'uses' => 'HomeController@preview_pdf']);
    Route::any('/ajax_group_projects/{id}', ['as' => 'front.ajax_group_projects', 'uses' => 'HomeController@ajax_group_projects']);
    Route::any('/ajaxposts/{id}', ['as' => 'front.ajaxposts', 'uses' => 'HomeController@ajaxposts']);
    Route::any('/callvac', ['as' => 'front.callvac', 'uses' => 'HomeController@callvac']);
    Route::get('/ajax_projects_info/{id}', ['as' => 'front.ajax_projects_info', 'uses' => function ($id) {
        return response(Helper::get_ajax_projects_info($id))->header('Content-Type', 'text/plain');
    }]);
    Route::any('/testphp', ['as' => 'front.testphp', 'uses' => 'HomeController@testphp']);
    Route::any('/cron_tiny_picture', ['as' => 'front.cron_tiny_picture', 'uses' => 'HomeController@cron_tiny_picture']);
    Route::any('/loadmore', ['as' => 'front.loadmore', 'uses' => 'HomeController@loadmore']);
    Route::any('/callus', ['as' => 'front.callus', 'uses' => 'HomeController@call_us']);
    Route::any('/callus2', ['as' => 'front.callus2', 'uses' => 'HomeController@call_us2']);
    Route::any('/call_us_landing_tourism', ['as' => 'front.call_us_landing_tourism', 'uses' => 'HomeController@call_us_landing_tourism']);
    Route::any('/confirmation', ['uses' => 'HomeController@call_us_confirmation']);
    Route::post('/newsletter', ['as' => 'front.newsletter', 'uses' => 'HomeController@newsletter_signup']);
    Route::post('/likeitem', ['as' => 'front.likeitem', 'uses' => 'HomeController@like_item']);
    Route::post('/like_video', ['as' => 'front.like_video', 'uses' => 'HomeController@like_video']);
    Route::get('/sitemap_xml/{slug?}', ['as' => 'sitemap', 'uses' => 'HomeController@sitemap']);
    Route::get('/rss/{rss?}', ['uses' => 'HomeController@rss']);
    Route::get('/rss_notifs', ['uses' => 'HomeController@rss_notifs']);
    Route::get('/ajax_statics', ['as' => 'front.ajax_statics', 'uses' => 'HomeController@ajax_statics']);
    Route::get('/whatsapp_share', ['as' => 'front.whatsapp_share', 'uses' => 'HomeController@whatsapp_share']);
    Route::get('/ratesexchange-try', function () { Helper::rates_exchange(); });
    Route::get('/currency/{curr}', ['as' => 'front.currency', 'uses' => 'HomeController@currency']);
    Route::get('/filter_rooms/{curr}', ['as' => 'front.filter_rooms', 'uses' => 'HomeController@filter_rooms']);
    Route::get('/cron_currency', ['as' => 'front.cron_currency', 'uses' => 'HomeController@cron_currency']);
    Route::get('/cron_currency_changes', ['as' => 'front.cron_currency_changes', 'uses' => 'HomeController@cron_currency_changes']);
    Route::get('/cron_keywords', ['as' => 'front.cron_keywords', 'uses' => 'HomeController@cron_keywords']);
    Route::get('/cron_crm_insert', ['as' => 'front.cron_crm_insert', 'uses' => 'HomeController@cron_crm_insert']);
    Route::get('/cron_notifications', ['as' => 'front.cron_notifications', 'uses' => 'HomeController@cron_notifications']);
    Route::get('/cron_crm_tasks_due_date', ['as' => 'front.cron_crm_tasks_due_date', 'uses' => 'HomeController@cron_crm_tasks_due_date']);
};
$legacyGroup(['prefix' => $legacyPrefix, 'middleware' => ['localize', 'exchange'], 'namespace' => 'Front'], $endpointRoutes);


$homeRoute = function () {
    Route::any('/', ['as' => 'front.index', 'uses' => 'HomeController@index']);
};
$legacyGroup(['prefix' => $legacyPrefix, 'middleware' => ['localize', 'exchange'], 'namespace' => 'Front'], $homeRoute);


/**
* Legacy redirect-only pages: hit the controller unprefixed so /blog/x
* 301s once to the geo URL instead of /blog/x -> /ar/blog/x -> geo.
*/
$redirectOnlyRoutes = function () {
    Route::any('/projects/{slug}', ['as' => 'front.project', 'uses' => 'HomeController@project_show']);
    Route::group(['prefix' => 'blog'], function () {
        Route::any('/', ['as' => 'front.blog', 'uses' => 'HomeController@blog_index', 'type' => 'blog']);
        Route::any('/category/{slug}', ['as' => 'front.blog.category', 'uses' => 'HomeController@blog_show_category', 'type' => 'blog']);
        Route::any('/{slug}', ['as' => 'front.blog.post', 'uses' => 'HomeController@blog_show_post', 'type' => 'blog']);
    });
    Route::group(['prefix' => 'news'], function () {
        Route::any('/{slug}', ['as' => 'front.news.post', 'uses' => 'HomeController@blog_show_post', 'type' => 'news']);
        Route::any('/category/{slug}', ['as' => 'front.news.category', 'uses' => 'HomeController@blog_show_category', 'type' => 'news']);
    });
};

/**
* Locale-required front pages
*/
$pageRoutes = function () {
    Route::any('guides', [
        'as' => 'front.blog.index',
        'uses' => 'PostController@index',
    ]);
    Route::any('developers', [
        'as' => 'front.developer.index',
        'uses' => 'PostController@indexDevelopers',
    ]);
    Route::any('reports', [
        'as' => 'front.report.index',
        'uses' => 'PostController@indexReports',
    ]);
    Route::any('news', [
        'as' => 'front.news',
        'uses' => 'PostController@indexNews',
    ]);

    Route::group([
        'prefix' => '{country}',
        'where' => ['country' => \App\Models\Country::slugPattern()],
    ], function () {
        Route::any('guides', [
            'as' => 'front.blog.country',
            'uses' => 'PostController@indexCountry',
        ]);
        Route::any('developers', [
            'as' => 'front.developer.country',
            'uses' => 'PostController@indexDevelopersCountry',
        ]);
        Route::any('reports', [
            'as' => 'front.report.country',
            'uses' => 'PostController@indexReportsCountry',
        ]);
        Route::any('news', [
            'as' => 'front.news.country',
            'uses' => 'PostController@indexNewsCountry',
        ]);

        Route::any('{city}/{region}/{project}', [
            'as' => 'front.project.show',
            'uses' => 'ProjectController@show',
        ]);
        Route::any('guides/{post}', [
            'as' => 'front.blog.post.show',
            'uses' => 'PostController@show',
        ]);
        Route::any('developers/{post}', [
            'as' => 'front.developer.post.show',
            'uses' => 'PostController@showDevelopers',
        ]);
        Route::any('reports/{post}', [
            'as' => 'front.report.post.show',
            'uses' => 'PostController@showReports',
        ]);
        Route::any('news/{post}', [
            'as' => 'front.news.post.show',
            'uses' => 'PostController@showNews',
        ]);

        Route::any('/', [
            'as' => 'front.location.country',
            'uses' => 'ProjectController@country',
        ]);
        Route::any('{city}', [
            'as' => 'front.location.city',
            'uses' => 'ProjectController@city',
            'where' => ['city' => '^(?!guides$|developers$|reports$|news$|projects$|media$|blog$)[^/]+'],
        ]);
        Route::any('{city}/{region}', [
            'as' => 'front.location.region',
            'uses' => 'ProjectController@region',
            'where' => [
                'city' => '^(?!guides$|developers$|reports$|news$|projects$|media$|blog$)[^/]+',
                'region' => '[^/]+',
            ],
        ]);
    });

    Route::any('/projects', ['as' => 'front.projects', 'uses' => 'ProjectController@index']);

    Route::group(['prefix' => 'chat'], function () {
        Route::any('/{id?}', ['as' => 'front.chat', 'uses' => 'HomeController@chat_index']);
    });

    Route::any('/landing-tourism', ['as' => 'front.landing_tourism', 'uses' => 'HomeController@landing_tourism']);
    Route::any('/{slug}-districts', ['as' => 'front.districts', 'uses' => 'HomeController@districts']);
    Route::any('/{slug}-districts/{region_slug}', ['as' => 'front.districts', 'uses' => 'HomeController@district_detail']);
    Route::any('/rating/{lead}/{hash}', ['as' => 'front.rating', 'uses' => 'HomeController@rating']);
    Route::get('/tag/{tag}', ['as' => 'front.tag', 'uses' => 'HomeController@tag']);
    Route::any('/story/{slug?}', ['as' => 'front.stories', 'uses' => 'HomeController@stories']);
    Route::get('/resale/{id}', ['as' => 'front.resale_details', 'uses' => 'HomeController@resale_details']);
    Route::any('/media/{slug}', ['as' => 'front.project_data', 'uses' => 'HomeController@project_data']);
    Route::any('/360/{id}', ['as' => 'front.p360', 'uses' => 'HomeController@p360']);
    Route::any('/turkish-citizenship', ['as' => 'front.turkish_citizenship', 'uses' => 'HomeController@turkish_citizenship']);
    Route::any('/landing/{slug}', ['as' => 'front.landingpage', 'uses' => 'HomeController@landingpage_show']);
    Route::any('/landing2/{slug}', ['as' => 'front.landing2', 'uses' => 'HomeController@landing2']);
    Route::any('/landing3/{slug}', ['as' => 'front.landing3', 'uses' => 'HomeController@landing3']);
    Route::any('/landing4/{slug}', ['as' => 'front.landing4', 'uses' => 'HomeController@landing4']);
    Route::any('/landing5/{slug}', ['as' => 'front.landing5', 'uses' => 'HomeController@landing5']);
    Route::any('/landing-{slug}', ['as' => 'front.landing.newlandingpage', 'uses' => 'HomeController@newlandingpage']);
    Route::any('/qr', ['as' => 'front.qr', 'uses' => 'HomeController@qr']);
    Route::any('/contact', ['as' => 'front.contact', 'uses' => 'HomeController@contact']);
    Route::any('/video/{slug?}', ['as' => 'front.video', 'uses' => 'HomeController@video']);
    Route::any('/investment-turkey-istanbul', ['as' => 'front.investment', 'uses' => 'HomeController@investment']);
    Route::any('/faq', ['as' => 'front.faq', 'uses' => 'HomeController@faq']);
    Route::any('/faq-show/{slug}', ['as' => 'front.faq_show', 'uses' => 'HomeController@faq_show']);
    Route::any('/living-turkey-real-estate-ownership', ['as' => 'front.living_turkey', 'uses' => 'HomeController@living_turkey']);
    Route::any('/legal-affairs-turkey', ['as' => 'front.legal', 'uses' => 'HomeController@legal']);
    Route::get('/agents/{slug}', ['as' => 'front.agent', 'uses' => 'HomeController@agent']);
    Route::get('/privacy-policy', ['as' => 'front.privacy', 'uses' => 'HomeController@privacy']);
    Route::get('/terms-of-use', ['as' => 'front.terms', 'uses' => 'HomeController@terms']);
    Route::get('/contact-us', ['as' => 'front.contactus', 'uses' => 'HomeController@contactus']);
    Route::get('/about-us', ['as' => 'front.aboutus', 'uses' => 'HomeController@about_us']);
    Route::get('/resale', ['as' => 'front.resale', 'uses' => 'HomeController@resale']);
    Route::get('/turkish-nationality', ['as' => 'front.turkish_nationality', 'uses' => 'HomeController@turkish_nationality']);
    Route::get('/turkey-territories', ['as' => 'front.turkey_territories', 'uses' => 'HomeController@turkey_territories']);
    Route::get('/turkey-guide', ['as' => 'front.turkey_guide', 'uses' => 'HomeController@turkey_guide']);
    Route::get('/sitemap', ['as' => 'front.sitemap_html', 'uses' => 'HomeController@sitemap_html']);
    Route::get('/vacancies', ['as' => 'front.vacancies', 'uses' => 'HomeController@vacancies']);
    Route::get('/jobs', ['as' => 'front.land_vacancies', 'uses' => 'HomeController@land_vacancies']);
    Route::get('/job/{slug}', ['as' => 'front.job_details', 'uses' => 'HomeController@job_details']);
    Route::get('/offers/{offerid?}', ['as' => 'front.offers', 'uses' => 'HomeController@offers']);
    Route::get('/360', ['as' => 'front.view_360', 'uses' => 'HomeController@view_360']);
    Route::get('/submitted', ['as' => 'front.submitted_job', 'uses' => 'HomeController@submitted_job']);
    Route::get('/search', ['as' => 'front.searchpage', 'uses' => 'HomeController@search_page']);

    Route::any('/{type}/{city}/{var1?}/{var2?}', [
        'as' => 'front.search',
        'uses' => 'HomeController@search',
        'where' => ['type' => '^(?!damas-administrator$|webhooks$)[^/]+'],
    ]);
    Route::get('/{slug}', [
        'as' => 'front.redirect_url',
        'uses' => 'HomeController@redirect_url',
        'where' => ['slug' => '^(?!damas-administrator$|webhooks$)[^/]+'],
    ]);
};

$pageFront = array(
    'middleware' => array('localize', 'exchange'),
    'namespace' => 'Front',
    'locale_required' => true,
);

if ($urlLocale === null) {
    Route::group(['middleware' => ['localize', 'exchange'], 'namespace' => 'Front'], $redirectOnlyRoutes);
    Route::group(['middleware' => ['localePrefix:add'], 'namespace' => 'Front'], $pageRoutes);
}

Route::group(array_merge($pageFront, array('prefix' => $localeRequiredPrefix)), $redirectOnlyRoutes);
Route::group(array_merge($pageFront, array('prefix' => $localeRequiredPrefix)), $pageRoutes);
