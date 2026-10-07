@extends('admin.layouts.app', ["app_title" => "Districts"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "name_en"  =>  "Name English",
            "projects_status" => "Projects ON / OFF",
            "name_ar"  =>  "Name Aarabic",
            "city_id|City|name_en"  =>  "City",
            "slug"  =>  "Slug",
			"project_impressions" => "Impressions",
            "project_clicks" => "Clicks",
            "project_ctr" => "CTR",
            "project_position" => "Position",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Districts List"
    ])
    
@endsection