@extends('admin.layouts.app', ["app_title" => "Images"])
@section('main_content')

    <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><b>Images Folders</b></button>
    <div class="clearfix"></div><br>
    <div class="collapse" id="collapseExample">
        <div class="well">
		
            @foreach($folders as $folder)
                <?php //if ( $folder->cnt_medias == 0 ) {$folder->delete();continue;} ?>
                <a href="?folder_id=<?= $folder->id; ?>" class="btn btn-default ltr"><?= $folder->name; ?> (<?= $folder->cnt_medias; ?>)</a>
            @endforeach
        </div>
    </div>

    <?php
        $lignes = [
            "id"    =>  "",
            "name_en"  =>  "English Name",
            "name_ar"  =>  "Arabic Name",
            "folder_id|MediaFolder|name"  =>  "Folder",
            "size" => "Size",
            "created_at"  =>  "Created at",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    " Images List"
    ])

@endsection
