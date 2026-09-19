@extends('admin.layouts.app', ["app_title" => "  Statistics"])
@section('main_content')

    <?php
        $lignes = [
            "word"    =>  "Keyword",
            "country"  =>  "Country",
            "source"  =>  "Source",
            "campaign"  =>  "Campaign",
            "cnt_search"  =>  "Volume",
            "updated_at"  =>  "Last Date",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Keywords"
    ])
    
@endsection
