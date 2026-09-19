@extends('admin.layouts.app', ["app_title" => "Tags"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "title_en"  =>  "English Title",
            "title_ar"  =>  "Arabic Title",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Tags List"
    ])
    
@endsection
