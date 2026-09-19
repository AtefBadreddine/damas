@extends('admin.layouts.app', ["app_title" => "Roles"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "name"  =>  "Name",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Roles List"
    ])
    
@endsection
