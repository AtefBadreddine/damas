@extends('admin.layouts.app', ["app_title" => "Categories"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "country_id|Country|name_en" => "Country",
            "name_en"  =>  "English Name",
            "name_ar"  =>  "Arabic Name",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Categories List",
        "tr_placement"    =>    true
    ])
    
@endsection
