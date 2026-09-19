@extends('admin.layouts.app', ["app_title" => ($agent_name!=''?("Reviews of ".$agent_name.":"):"All reviews")])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "client_name"  =>  "Name",
            "client_country"  =>  "Country",
            "comment"  =>  "Comment",
            "avg_rv"  =>  "Rating",
            "sale_manager_id|SaleManager|name_en"  =>  "Agent",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    ""
    ])
    
@endsection
