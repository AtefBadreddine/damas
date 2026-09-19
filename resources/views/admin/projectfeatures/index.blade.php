@extends('admin.layouts.app', ["app_title" => "Facilities"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "name_en"  =>  "Name English",
            "name_ar"  =>  "Name Arabic"
        ];
    ?>
    @include("admin.layouts.table", [ 
        "box_title"    =>    "Facilities List"
    ])
    
@endsection
