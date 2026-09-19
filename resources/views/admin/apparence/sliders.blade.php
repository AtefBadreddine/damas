@extends('admin.layouts.app', ["app_title" => "Sliders"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "name"  =>  "Name",
            "lang"  =>  "Lang",
            "created_at"  =>  "Created at",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Sliders List"
    ])
    
@endsection
