@extends('admin.layouts.app', ["app_title" => isset($postType) ? $postType->label() : "Posts"])
@section('main_content')
    <?php $get_params = "&search=".Input::get("search"); ?>
    
	
    <?php
    if(\Auth::user()->is('superadmin')){
        $lignes = [
            "id" => "",
            "created_at" => "Created on",
            "title_ar" => "Title ",
            "views" => "Views",
            "word_count" => "Count",
            "category_id" => "Category",
            "blog_impressions" => "Imp.",
            "blog_clicks" => "Clicks",
            "blog_ctr" => "CTR",
            "blog_pos" => "Position",
            "blog_last_crawl" => "Last Crawl",
            "update_date" => "Updated on",
    
            // "lang" => "Langs ",
            // "likes" => "Likes",
            // "user_name" => "User",
        ];
    
        $lignes = array_reverse($lignes);
    
    }else{
    
        $lignes = [
            "id" => "",
            "created_at" => "Created on",
            "title_ar" => "Title ",
            "views" => "Views",
            "word_count" => "Count",
            "category_id" => "Category",
            "blog_impressions" => "Imp.",
            "blog_clicks" => "Clicks",
            "blog_ctr" => "CTR",
            "blog_pos" => "Position",
            "blog_last_crawl" => "Last Crawl",
            "update_date" => "Updated on",
    
            // "lang" => "Langs ",
            // "likes" => "Likes",
            // "user_name" => "User",
    
            "prevent_archiving_in_blog" =>
                "archiving in ".(
                    isset($postType)
                        ? $postType->label()
                        : ucfirst($type)
                ),
        ];
    
        $lignes = array_reverse($lignes);
    }
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    " Posts List",
        "tr_placement"    =>    true,
		"get_params"   =>    $get_params
    ])
    
@endsection
