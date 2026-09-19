@extends('admin.layouts.app', ["app_title" => "FAQ's Categories"])
@section('main_content')

    <?php
	$auth_user = Auth::user();

        $lignes = [
            "id"    =>  "",
            "created_at"    =>  "Created at",
            "title_ar"  =>  "Title ",
        ];
	
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    " Posts List",
        "tr_placement"    =>    true
    ])
    
@endsection
