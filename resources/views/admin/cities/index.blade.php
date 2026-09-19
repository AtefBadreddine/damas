@extends('admin.layouts.app', ["app_title" => "Cities"])
@section('main_content')

    <?php
        $lignes = [
            "id"        =>  "",
            "name_ar"   =>   "Name Arabic",
            "name_en"   =>   "Name English",
            "slug"      =>   "Slug"
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Cities List"
    ])
    
@endsection