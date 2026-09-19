@extends('admin.layouts.app', ["app_title" => "Sections "])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "title_en"  =>  "English Name",
            "title_ar"  =>  "Arabic Name",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Sections"
    ])
    
@endsection
