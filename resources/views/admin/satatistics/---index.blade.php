@extends('admin.layouts.app', ["app_title" => "  رسائل الواتساب"])
@section('main_content')
<?php $get_params = "&manual_insert=".Input::get("manual_insert")."&filterdate=".Input::get("filterdate"); ?>
    
    <?php
        $lignes = [
            "id"    =>  "رقم الطلب",
            "name"  =>  "الإسم",
            "created_at"  =>  "وقت الإرسال"
			];
			
			if(Auth::user()->is('superadmin'))
				$lignes["tags"] = "اشارات قوقل";
			
            $lignes["country"]  =  "الدولة";
            $lignes["src"]  =  "المصدر";
            $lignes["device"]    = "الجهاز";
            $lignes["device_type"]    =  "نوع الجهاز";
            $lignes["browser"]    =  "المتصفح";
            $lignes["page"]  =  "الصفحة";
            $lignes["form_type"]  =  "مكان الأيقونة";
			
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "رسائل الواتساب",
		"get_params"   =>    $get_params
    ])
    
@endsection
