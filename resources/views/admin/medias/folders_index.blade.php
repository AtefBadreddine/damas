@extends('admin.layouts.app', ["app_title" => "Folders"])
@section('main_content')
   
    <?php
        $lignes = [
            "id"    =>  "",
            "name"  =>  "Name",
            "created_at"  =>  "Created at",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Images List"
    ])
    
@endsection
