@extends('admin.layouts.app', ["app_title" => "   Tourism Messages "])
@section('main_content')
<style>
.box-tools select, .box-tools a{
display:none!important
}
</style>

<?php //$get_params = "&manual_insert=".Input::get("manual_insert")."&filterdate=".Input::get("filterdate"); ?>
    
    <?php
	
	
            //$lignes["code"]  =  " ID";
            $lignes["id"]  =  "Time & ID";
			$lignes["name"] = "Name";
			$lignes["mobile"] = "Mobile";
			$lignes["email"] = "E-mail";
            $lignes["page"]  =  "Landing";
            $lignes["country"]    = "Country";
            $lignes["device"]  =  "Gadgets";
			$lignes["tags"] = "Sources";

    ?>
    @include("admin.layouts.table_w", [
        "box_title"    =>    "Messages"
    ])
    
@endsection
