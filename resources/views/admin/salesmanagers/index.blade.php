@extends('admin.layouts.app', ["app_title" => "Salesman"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "name_en"  =>  "Name English",
            "name_ar"  =>  "Name Arabic",
            "email"  =>  "Email",
            "phone"  =>  "Phone Number",
            "region_id|Region|name_en"  =>  "Region",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Salesman List",
        "reviews_links"    =>    true,
    ])
    
@endsection
