@extends('admin.layouts.app', ["app_title" => "Testimonials"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "name_en"  =>  "Name",
            "content_en"  =>  "Testimonial",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Testimonials List"
    ])
    
@endsection
