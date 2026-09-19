@extends('admin.layouts.app', ["app_title" => "Users"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "username"  =>  "User Name",
            "name"  =>  "Name",
            "email"  =>  "Email",
            "role_lib"  =>  "Roles",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Users List"
    ])
    
@endsection
