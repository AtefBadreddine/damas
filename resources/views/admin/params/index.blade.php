@extends('admin.layouts.app', ["app_title" => "Home Page"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "lang"  =>  "Lang",
            "name"  =>  "Name",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Home Page Settings"
    ])
    
@endsection