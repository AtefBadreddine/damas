@extends('admin.layouts.app', ["app_title" => "  WhatsApp Clicks"])
@section('main_content')
<?php $get_params = "&manual_insert=".Input::get("manual_insert")."&filterdate=".Input::get("filterdate"); ?>
    
    <?php
			/*if(Auth::user()->is('superadmin'))
				$lignes["budget"] = "Category & Budjet";*/


			//$lignes["code"] = "Lead ID";
            $lignes["id"]  =  "Time & ID";
			$lignes["tags"] = "Sources";

            $lignes["country"]    = "Country & Number";
            $lignes["device"]  =  "Gadgets";
            $lignes["navigation"] = "Tracking";
    ?>
    @include("admin.layouts.table_w", [
        "box_title"    =>    " WhatsApp",
		"get_params"   =>    $get_params
    ])
    
@endsection
