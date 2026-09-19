@extends('admin.layouts.app', ["app_title" => "   Participants"])
@section('main_content')

    
    <?php
	
	
            $lignes["created_at"]  =  "Time";
            $lignes["name"]  =  "Name";
            $lignes["mobile"]  =  "Mobile";
            $lignes["familymembers"]  =  "Family Members";
            $lignes["country"]    = "Country";
            $lignes["device"]  =  "Gadgets";
			/*$lignes["tags"] = "Sources";*/
	
			
			
			
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Participants",

    ])
    
@endsection
