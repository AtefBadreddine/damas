@extends('admin.layouts.app', ["app_title" => "Posts"])
@section('main_content')
    <?php $get_params = "&search=".Input::get("search"); ?>
    
	
    <?php
	$auth_user = Auth::user();
	if($auth_user->is('superadmin')){
        $lignes = [
            "id"    =>  "",
            "created_at"    =>  "Created at",
            "update_date"    =>  "Updated at",
            "title_ar"  =>  "Title ",
            "blog_impressions" => "Impressions",
            "blog_clicks" => "Clicks",
            "blog_ctr" => "CTR",
            "blog_pos" => "Position",
            "lang"  =>  "Langs ",
            "word_count" => "Count",
            "category_id"  =>  "Category",
            "likes" =>  "Likes",
            "views" =>  "Views",
            "user_name"  =>  "User",
        ];
	}else{
		$lignes = [
            "id"    =>  "",
            "created_at"    =>  "Created at",
            "update_date"    =>  "Updated at",
            "title_ar"  =>  "Title ",
            "blog_impressions" => "Impressions",
            "blog_clicks" => "Clicks",
            "blog_ctr" => "CTR",
            "blog_pos" => "Position",
            "lang"  =>  "Langs ",
            "word_count" => "Count",
            "category_id"  =>  "Category",
            "likes" =>  "Likes",
            "views" =>  "Views",
            "user_name"  =>  "User",
            "prevent_archiving_in_blog"  =>  "archiving in ". ucfirst($type),
        ];
	}
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    " Posts List",
        "tr_placement"    =>    true,
		"get_params"   =>    $get_params
    ])
    
@endsection
