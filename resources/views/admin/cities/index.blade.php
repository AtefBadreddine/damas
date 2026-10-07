@extends('admin.layouts.app', ["app_title" => "Cities"])
@section('main_content')

    <?php
        $lignes = [
            "id"        =>  "",
            "name_ar"   =>   "Name Arabic",
            "name_en"   =>   "Name English",
            "country_id|Country|name_en" => "Country",
            "slug"      =>   "Slug",
			"project_impressions" => "Impressions",
            "project_clicks" => "Clicks",
            "project_ctr" => "CTR",
            "project_position" => "Position",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Cities List"
    ])
    
@endsection