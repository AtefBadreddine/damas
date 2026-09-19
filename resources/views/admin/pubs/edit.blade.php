@extends('admin.layouts.form', ["app_title" => "Property offers", "app_desc" => ""])
@section('main_form')

<fieldset>
    <legend>Property offer</legend>
    <div class="form-group col-md-3">
        <label>Title Arabic<span class="red">(*)</span></label>
        <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Title English<span class="red">(*)</span></label>
        <?= Form::text("title_en", $row->title_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Title French<span class="red">(*)</span></label>
        <?= Form::text("title_fr", $row->title_fr, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Title Persian<span class="red">(*)</span></label>
        <?= Form::text("title_fa", $row->title_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Title Russian<span class="red">(*)</span></label>
        <?= Form::text("title_ru", $row->title_ru, ["class" => "form-control ltr"]); ?>
    </div>

    <div class="form-group col-md-4">
        <label>Picture</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_id",
            "ids"   =>	[$row->media_id]
        ])
    </div>
    <div class="form-group col-md-4">
        <label>Link<span class="red">(*)</span></label>
        <?= Form::text("link", $row->link, ["class" => "form-control"]); ?>
    </div>

</fieldset>

<fieldset>
    <legend>Content</legend>

<div class="col-md-12">
                            <div class="form-group">
                                <!--<span>Question</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span>Answer</span>-->
                                <div class="dblocks">
                                    <?php
                                    //$rows = DB::select("select * from dms_faq order by id asc");
									$content_ar = explode('#;#',$row->content_ar);
									$content_en = explode('#;#',$row->content_en);
									$content_fr = explode('#;#',$row->content_fr);
									$content_fa = explode('#;#',$row->content_fa);
									$content_ru = explode('#;#',$row->content_ru);
									
                                    for ($i=0;$i<count($content_ar);$i++) {
                                        ?>
                                        <div class="row add_question_sec">
                                            <div class="col-md-4">
                                                <textarea class="form-control" name="content_ar[]" placeholder="Content (Ar)"><?= @$content_ar[$i] ?></textarea>
                                            </div>
                                            <div class="col-md-4">
                                                <textarea class="form-control" name="content_en[]" placeholder="Content (En)"><?= @$content_en[$i] ?></textarea>
                                            </div>
                                            <div class="col-md-4">
                                                <textarea class="form-control" name="content_fr[]" placeholder="Content (Fr)"><?= @$content_fr[$i] ?></textarea>
                                            </div>
                                            <div class="col-md-4">
                                                <textarea class="form-control" name="content_fa[]" placeholder="Content (Pe)"><?= @$content_fa[$i] ?></textarea>
                                            </div>
                                            <div class="col-md-4">
                                                <textarea class="form-control" name="content_ru[]" placeholder="Content (Ru)"><?= @$content_ru[$i] ?></textarea>
                                            </div>
                                            <input type="button" value="x" class="delrow" />
                                        </div>
                                    <?php } ?>
                                </div>
                                <input class="btn btn-primary" type="button" id="addrow" value="Add +">	
                            </div>
                        </div>

</fieldset>



@include("admin.layouts.tinymce_js")
@include("admin.layouts.media_input_js")
<script>
    $('#addrow').click(function () {
        $('.dblocks').append('<div class="row add_question_sec">' +
                '<div class="col-md-4">' +
                '<textarea class="form-control" name="content_ar[]" placeholder="Content (Ar)"></textarea>' +
                '</div>' +
                '<div class="col-md-4">' +
                '<textarea class="form-control" name="content_en[]" placeholder="Content (En)"></textarea>' +
                '</div>' +
                '<div class="col-md-4">' +
                '<textarea class="form-control" name="content_fr[]" placeholder="Content (Fr)"></textarea>' +
                '</div>' +
                '<div class="col-md-4">' +
                '<textarea class="form-control" name="content_fa[]" placeholder="Content (Pe)"></textarea>' +
                '</div>' +
                '<div class="col-md-4">' +
                '<textarea class="form-control" name="content_ru[]" placeholder="Content (Ru)"></textarea>' +
                '</div>' +
                '<input type="button" value="x" class="delrow" />' +
                '</div>' );
    });

    $('body').on('click', '.delrow', function () {
        $(this).parent('.row').remove();
    });
</script>
@endsection