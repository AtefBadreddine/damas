<?php

if($_SERVER['SERVER_NAME'] == 'www.aqsaway.com' or $_SERVER['SERVER_NAME'] == 'aqsaway.com') exit();


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

    #2 - visitors source
    /*if ( isset($_SERVER['HTTP_REFERER']) and ($_SERVER['HTTP_REFERER'] == str_replace('https://www.damas.net', '', $_SERVER['HTTP_REFERER'])) ) {
        setcookie("reffer", $_SERVER['HTTP_REFERER'], time()+3600, "/", "damas.net", 1);
    }*/
    if ( isset($_SERVER['HTTP_REFERER']) and (strpos(strtolower($_SERVER['HTTP_REFERER']), 'https://www.damas.net')===false or strpos(strtolower($_SERVER['HTTP_REFERER']), 'https://www.damas.net')!==0)) {
        setcookie("reffer", $_SERVER['HTTP_REFERER'], time()+86400, "/", "damas.net", 1);
    }

	if ( isset($_SERVER['REQUEST_URI']) and $_SERVER['REQUEST_URI']!='/rss') {
        setcookie("navigation", @$_COOKIE['navigation'].'\n'. 'damas.net'.$_SERVER['REQUEST_URI'] , time()+3600, "/", "damas.net", 1);
    }
	
	
	/*if(isset($_GET['cosin'])){
	echo '<pre dir="ltr">';
	print_r($_SERVER);
	echo '</pre>';
	}*/
	
    if( (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) and $_SERVER['HTTP_X_FORWARDED_PROTO'] == "http") or @$_SERVER['REQUEST_SCHEME'] == "http" ){
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $redirect);
        exit();
    }
    
    

require __DIR__.'/bootstrap/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__.'/bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);