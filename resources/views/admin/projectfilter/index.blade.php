@extends('admin.layouts.app', ["app_title" => "Search Filters"])
@section('main_content')

    <?php
	$auth_user = Auth::user();

        $lignes = [
            "id"    =>  "",
            "created_at"    =>  "Created at",
            "title_ar"  =>  "Title ar",
        ];
	
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    " Filters List",
        "tr_placement"    =>    true
    ])
    
@endsection
