@extends('admin.layouts.app', ["app_title" => "  Backup Messages"])
@section('main_content')
<?php $get_params = "&manual_insert=".Input::get("manual_insert")."&filterdate=".Input::get("filterdate"); ?>
    
    <?php
			/*if(Auth::user()->is('superadmin'))
				$lignes["budget"] = "Category & Budjet";*/


			$lignes["code"] = "Code";
			$lignes["name"] = "Name";
			$lignes["mobile"] = "Mobile";
			$lignes["message"] = "Message";
            $lignes["country"]    = "Country";
			
			
			$lignes["tags"] = "Sources";

            $lignes["page"]  =  "Landing & Form";
            $lignes["id"]  =  "Time & ID";
            $lignes["device"]  =  "Gadgets";

    ?>
    @include("admin.layouts.table_backup", [
        "box_title"    =>    " Backup Messages",
		"get_params"   =>    $get_params
    ])
    
@endsection
