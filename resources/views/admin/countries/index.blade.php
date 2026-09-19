@extends('admin.layouts.app', ["app_title" => "Countries"])
@section('main_content')

    <?php
        $lignes = [
            "id"        =>  "",
            "title_ar"  =>  "Title Arabic",
            "title_en"  =>  "Title English",
            "slug"      =>  "Slug",
            "code"      =>  "Code",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Countries List"
    ])
    
@endsection
