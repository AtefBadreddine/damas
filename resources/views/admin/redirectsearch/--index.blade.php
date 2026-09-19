@extends('admin.layouts.app', ["app_title" => " توجيه كلمات البحث"])
@section('main_content')

    <?php
        $lignes = [
            "words"    =>  "كلمات البحث",
            "type"  =>  "نوع البحث",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "توجيه كلمات البحث"
    ])

@endsection