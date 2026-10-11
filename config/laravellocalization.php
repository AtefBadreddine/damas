<?php

return [
	'supportedLocales' => [
		'ar'          => ['name' => 'Arabic',                 'script' => 'Arab', 'native' => 'العربية'],
		'en'          => ['name' => 'English',                'script' => 'Latn', 'native' => 'English'],
		// fr, pe and ru are retired: RedirectToLocalePrefix 301s /fr|/pe|/ru/... to /en/...
	],
	
	
	
		
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
