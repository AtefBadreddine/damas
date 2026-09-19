@extends('admin.layouts.app', ["app_title" => "Branches"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "name_en"  =>  "Name English",
            "name_ar"  =>  "Name Arabic",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Branches List"
    ])
    
@endsection
