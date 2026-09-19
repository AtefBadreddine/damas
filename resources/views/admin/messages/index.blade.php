@extends('admin.layouts.app', ["app_title" => "   Inquiries"])
@section('main_content')
<?php $get_params = "&manual_insert=".Input::get("manual_insert")."&filterdate=".Input::get("filterdate"); ?>
    
    <?php
	
	
            $lignes["code"]  =  "Lead ID";
            $lignes["id"]  =  "Time & ID";
            $lignes["page"]  =  "Landing & Form";
            $lignes["country"]    = "Country & Number";
            $lignes["device"]  =  "Gadgets";
			$lignes["tags"] = "Sources";
			$lignes["insert_crm"] = "insert to CRM";
	
			if(Auth::user()->is('superadmin'))
				$lignes["budget"]    =  "Category & Budjet";
			
			
			
    ?>
    @include("admin.layouts.table_w", [
        "box_title"    =>    "Inquiries",
		"get_params"   =>    $get_params
    ])
    
@endsection
