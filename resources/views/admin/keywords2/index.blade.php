@extends('admin.layouts.app', ["app_title" => "Keywords"])
@section('main_content')

    <?php
        $lignes = [
            "id"        =>  "",
            "keyword_ar"   =>   "Arabic keywords",
            "url"   =>   "Url",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Keywords List"
    ])
    
@endsection