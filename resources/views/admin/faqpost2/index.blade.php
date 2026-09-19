@extends('admin.layouts.app', ["app_title" => "FAQ's " . $pgtitle ])
@section('main_content')

    <?php
	$auth_user = Auth::user();

        $lignes = [
            "id"    =>  "",
            //"created_at"    =>  "Created at",
            //"title_ar"  =>  "Title ",
			"q_ar"  =>  "Question (Ar)",
			"r_ar"  =>  "Answer (Ar)",
			"q_en"  =>  "Question (En)",
			"r_en"  =>  "Answer (En)",
			"q_fr"  =>  "Question (Fr)",
			"r_fr"  =>  "Answer (Fr)",
			"q_fa"  =>  "Question (Pe)",
			"r_fa"  =>  "Answer (Pe)",
			"q_ru"  =>  "Question (Ru)",
			"r_ru"  =>  "Answer (Ru)",
			//"str_posts"  =>  "str_posts"
        ];
	
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    " Posts List",
    ])
    
@endsection
