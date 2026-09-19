@extends('admin.layouts.app', ["app_title" => "Search Pages"])
@section('main_content')

<?php
$lignes = [
    "id" => "",
    "name" => "Name",
    "link" => "Link",
    'search_pages_impressions' => 'Impressions',
    'search_pages_clicks' => 'Clicks',
    'search_pages_ctr' => 'CTR'
];
?>
@include("admin.layouts.table", [
"box_title"    =>    "Links List"
])

@endsection
