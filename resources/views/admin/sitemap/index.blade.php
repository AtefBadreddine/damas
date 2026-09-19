@extends('admin.layouts.app', ["app_title" => "Sitemap"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "title"  =>  "Name",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Sitemap"
    ])
    
@endsection