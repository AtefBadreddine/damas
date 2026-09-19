@extends('admin.layouts.app', ["app_title" => "Properties"])
@section('main_content')
<?php $get_params = "&search=".Input::get("search"); ?>
    <?php
	$auth_user = Auth::user();
	if($auth_user->is('superadmin')){
        $lignes = [
            "name_en"  =>  "ID",
            "created_at"  =>  "Created At",
            "city_id|City|name_en"  =>  "City",
            "region_id"  =>  "District",
			"payment_percent" => "%",
			"payment_months" => "M",
			//"paymentmethod_ar" => "paymentmethod_ar",
			
            "title_en"  =>  "Name",
            "likes"  =>  "Likes",
            "views"  =>  "Clicks",
            "user_name"  =>  "User",
        ];
	}else{
		$lignes = [
            "name_en"  =>  "ID",
            "created_at"  =>  "Created At",
            "city_id|City|name_en"  =>  "City",
            "region_id"  =>  "District",
			"payment_percent" => "%",
			"payment_months" => "M",
			//"paymentmethod_ar" => "paymentmethod_ar",
            "title_en"  =>  "Name",
            "likes"  =>  "Likes",
            "views"  =>  "Clicks",
        ];
	}
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "",
		"get_params"   =>    $get_params
    ])

@endsection