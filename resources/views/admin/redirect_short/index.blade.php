@extends('admin.layouts.app', ["app_title" => "Links Shortcut"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "created_at"  =>  "Created at",
            "url"  =>  "Original Link",
            "slug"  =>  "Short Link",
            "description"  =>  "Description",
            "hits"  =>  "Number of Visits",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Links Shortcut List"
    ])
    
@endsection
