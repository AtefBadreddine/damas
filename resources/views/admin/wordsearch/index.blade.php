@extends('admin.layouts.app', ["app_title" => " Post research"])
@section('main_content')

    <?php
        $lignes = [
            "word"    =>  "Words",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    ""
    ])

@endsection