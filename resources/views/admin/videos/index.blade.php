@extends('admin.layouts.app', ["app_title" => "Videos"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "title"  =>  "The Video",//اظهار عامود اسم المشروع واللغة والتصنيف على الصفحة الرئيسية للفيديو في الادمن
			
			"project"=>"Project",
			"lang"=>"Lang",
			"section"=>"Section",// $row->sections()->lists('sectionvideo_id')->toArray()
			
			
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Videos List"
    ])
    
@endsection
