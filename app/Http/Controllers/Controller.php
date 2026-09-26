<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * PHP 8 treats string keys as named arguments; Laravel 5.1 mixes route
     * names with spliced positional dependencies, so pass them positionally.
     */
    public function callAction($method, $parameters)
    {
        return call_user_func_array([$this, $method], array_values($parameters));
    }
}
