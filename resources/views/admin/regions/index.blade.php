@extends('admin.layouts.app', ["app_title" => "Districts"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "name_en"  =>  "Name English",
            "name_ar"  =>  "Name Aarabic",
            "city_id|City|name_en"  =>  "City",
            "slug"  =>  "Slug"
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Districts List"
    ])
    
@endsection