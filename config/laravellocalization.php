<?php

return [
	'supportedLocales' => [
		'ar'          => ['name' => 'Arabic',                 'script' => 'Arab', 'native' => 'العربية'],
		'en'          => ['name' => 'English',                'script' => 'Latn', 'native' => 'English'],
		'fr'          => ['name' => 'Frensh',                'script' => 'Latn', 'native' => 'Frensh'],
		'pe'          => ['name' => 'Persian',                'script' => 'Arab', 'native' => 'Persian'],
		'ru'          => ['name' => 'Russian',                'script' => 'Latn', 'native' => 'Russian'],
		//'fa'          => ['name' => 'Persian',                'script' => 'Arab', 'native' => 'Persian'],
	],
	
	
	
		
	// Negotiate for the user locale using the Accept-Language header if it's not defined in the URL?
	// If false, system will take app.php locale attribute
	'useAcceptLanguageHeader' => true,

	// If LaravelLocalizationRedirectFilter is active and hideDefaultLocaleInURL
	// is true, the url would not have the default application language
    //
    // IMPORTANT - When hideDefaultLocaleInURL is set to true, the unlocalized root is treated as the applications default locale "app.locale".
    // Because of this language negotiation using the Accept-Language header will NEVER occur when hideDefaultLocaleInURL is true.
    //
	'hideDefaultLocaleInURL' => true,

];
