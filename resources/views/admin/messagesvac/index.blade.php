@extends('admin.layouts.app', ["app_title" => "HR Cvs"])
@section('main_content')

    <?php
        $lignes = [
            "id"    =>  "",
            "name"  =>  "Name",
            "email"  =>  "Email",
            "mobile"  =>  "Mobile",
            "created_at"  =>  "Created at",
            "citizenship"  =>  "Citizenship",
            "academic_degree"  =>  "Academic Degree",
            "field"  =>  "Field",
            "company"  =>  "Companies",
            "period"  =>  "Period of work"
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "HR Cvs List"
    ])
    <script>
	$('table th:last').hide()
    </script>
@endsection
