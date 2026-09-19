@extends('admin.layouts.app', ["app_title" => "Projects Section"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "title"  =>  "Title Ar",
            "title_en"  =>  "Title En",
            /*"sectiontype_id|SectionType|slug"  =>  "Content Type",
            "sectionposition_id|SectionPosition|name"  =>  "Section Position",*/
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Projects Section List"
    ])
    
@endsection
