@extends('admin.layouts.app', ["app_title" => "Videos Section"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "title_en"  =>  "Title",
            /*"lang"  =>  "Lang",
            "title_en"  =>  "Title En",
            "sectiontype_id|SectionType|slug"  =>  "Content Type",
            "sectionposition_id|SectionPosition|name"  =>  "Section Position",*/
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Videos Section List"
    ])
    
@endsection
