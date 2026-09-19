<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'amp*',
		'en/amp*',
        'fa/amp*',
        'fr/amp*',
        '*callus*',
		'*callus2*',
		'*/callus2*',
		'*callvac*',
		'*rating*',
		'*'
    ];
}
