@extends('admin.layouts.app', ["app_title" => "Jobs"])
@section('main_content')

    <?php
        $lignes = [
            "id"        =>  "",
            "title_ar"   =>   "Title Arabic",
            "title_en"   =>   "Title English"
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Jobs List"
    ])
    
@endsection