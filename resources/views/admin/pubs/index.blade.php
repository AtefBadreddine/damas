@extends('admin.layouts.app', ["app_title" => "Property offers"])
@section('main_content')

    <?php
        $lignes = [
            "id"        =>  "",
            "title_ar"   =>   "Name Arabic",
            "title_en"   =>   "Name English",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Property offers List"
    ])
    
@endsection