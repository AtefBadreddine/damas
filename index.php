<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

$isStatic = preg_match('/\.(?:css|js|mjs|map|png|jpe?g|gif|svg|webp|ico|woff2?|ttf|eot|otf|json|webmanifest|mp3|mp4|pdf)$/i', $uri);
if ($isStatic) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'Not Found';
    return;
}

require_once __DIR__.'/public/index.php';





/*
if(substr($_SERVER['SERVER_NAME'],0,4) != "www." && $_SERVER['SERVER_NAME'] != 'localhost'){
    header("HTTP/1.1 301 Moved Permanently"); 
	header('Location: https://www.'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
	//exit();
}*/
/*if(!isset($_GET['111']))
	exit();

if($_SERVER['SERVER_NAME'] == 'www.aqsaway.com' or $_SERVER['SERVER_NAME'] == 'aqsaway.com') exit();
*/

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylorotwell@gmail.com>
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels nice to relax.
|
*/

	

/*if(isset($_GET['cosin'])){
echo '<pre dir="ltr">';
print_r($_SERVER);
echo '</pre>';
}*/

/*if( (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) and $_SERVER['HTTP_X_FORWARDED_PROTO'] == "http") or @$_SERVER['REQUEST_SCHEME'] == "http" ){
$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
header('HTTP/1.1 301 Moved Permanently');
header('Location: ' . $redirect);
exit();
}*/