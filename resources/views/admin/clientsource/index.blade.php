@extends('admin.layouts.app', ["app_title" => "Sources Coding"])
@section('main_content')
       
    <p class="text-warning">
        <i class="fa fa-warning"></i> Word will be displayed <b>"Public"</b> By default
    </p>
    <?php
        $lignes = [
            "id"        =>  "",
            "src"   =>   "Src",
            "code"   =>   "Code",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Sources List"
    ])
    
@endsection