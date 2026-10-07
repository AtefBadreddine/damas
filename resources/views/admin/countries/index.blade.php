@extends('admin.layouts.app', ["app_title" => "Countries"])
@section('main_content')

    <?php
        $lignes = [
            "id"        =>  "",
            "name_ar"  =>  "Name Arabic",
            "name_en"  =>  "Name English",
            "slug"      =>  "Slug",
            "code"      =>  "Code",
            "whatsapp_number" => "WhatsApp",
			"project_impressions" => "Impressions",
            "project_clicks" => "Clicks",
            "project_ctr" => "CTR",
            "project_position" => "Position",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Countries List",
        "tr_placement" =>    true,
    ])
    
@endsection
