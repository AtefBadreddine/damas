<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Helper;

class BaseController extends Controller
{
    
    /**
    * ajax queries
    *
    * @param Illuminate\Http\Request $request
    * @return void
    */
    public function ajax_queries(Request $request)
    {
        $action = $request->get('action');
        switch ($action)
        {
            default:
                $func = "ajax_".$request->get('func');
                return Helper::$func($request->get('inputs', []));
                break; 
        }
    }
    
}