<?php

return [
	// The only switch for a locale: listed here, it gets routes, sitemaps, hreflang and links.
	// Not listed, its /{locale}/... URLs are 404s. Run config:clear and cache:clear after a change.
	'supportedLocales' => [
		'ar'          => ['name' => 'Arabic',                 'script' => 'Arab', 'native' => 'العربية'],
		'en'          => ['name' => 'English',                'script' => 'Latn', 'native' => 'English'],
		// 'fr'          => ['name' => 'French',                 'script' => 'Latn', 'native' => 'français'],
		// 'pe'          => ['name' => 'Persian',                'script' => 'Arab', 'native' => 'فارسی'],
		// 'ru'          => ['name' => 'Russian',                'script' => 'Cyrl', 'native' => 'русский'],
	],

	// Every locale the code and DB columns can serve. This never enables anything; it only tells
	// RedirectToLocalePrefix that /fr is a disabled locale (404), not a page slug to prefix with /ar.
	'knownLocales' => ['ar', 'en', 'fr', 'pe', 'ru'],
	
	
	
		
	// When the URL has no locale segment (e.g. /), use app.locale (ar), not Accept-Language.
	// Required when hideDefaultLocaleInURL is false; otherwise / defaults to the browser language.
	'useAcceptLanguageHeader' => false,

	// If LaravelLocalizationRedirectFilter is active and hideDefaultLocaleInURL
	// is true, the url would not have the default application language
    //
    // IMPORTANT - When hideDefaultLocaleInURL is set to true, the unlocalized root is treated as the applications default locale "app.locale".
    // Because of this language negotiation using the Accept-Language header will NEVER occur when hideDefaultLocaleInURL is true.
    //
	'hideDefaultLocaleInURL' => false,

];
