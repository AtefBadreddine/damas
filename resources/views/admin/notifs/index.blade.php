@extends('admin.layouts.app', ["app_title" => " الإشعارات الواردة"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "created_at"  =>  "تاريخ الإشعار",
            "msg"  =>  "الإشعار",
            "link"  =>  "الرابط",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "قائمة الإشعارات"
    ])
    
@endsection
