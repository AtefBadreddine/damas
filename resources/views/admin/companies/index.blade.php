@extends('admin.layouts.app', ["app_title" => "Companies"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
			"company_name"=>"Company's name",
			"establishment_year"=>"Date of Establishment",
			"under_cons_projects"=>"Under cons. Projects ",
			"ready_projects"=>"Ready Projects",
			"finishing_quality"=>"Finishing & Quality",
			"external_expansion"=>"External Expansion",
			"delayed_projects"	=>"Delayed Projects"
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Companies List"
    ])
    
@endsection