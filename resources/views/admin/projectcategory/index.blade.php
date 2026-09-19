@extends('admin.layouts.app', ["app_title" => "Features"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "name_en"  =>  "Name English",
            "name_ar"  =>  "Name Arabic",
            "feature_slug" => "Slug"
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Features List",
        "tr_placement"    =>    true,
    ])
    
@endsection
