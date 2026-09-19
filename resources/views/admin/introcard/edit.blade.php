@extends('admin.layouts.form', ["app_title" => "Intro cards"])
@section('main_form')



<style>
    .dblocks input{

    }
    .dblocks .row{
        margin: 13px 0;
    }
    .delrow{float:right}
</style>
<?php $row = 1; ?>
<fieldset>
    <!--    <legend>Add a New post</legend>-->
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
            

                    <!-- Section Arabic -->
                    <div class=" fade in active" id="tab1default">

                       

                        <div class="col-md-12">










                            <div class="form-group col-md-12">
                                
                                        <!--<span>Question</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span>Answer</span>-->
                                <div class="dblocks">
                                    <?php
                                    //$rows = DB::select("select * from dms_faq order by id asc");

                                    foreach ($rows as $r) {
                                        ?>
                                        <div class="row add_question_sec">
                                            <div class="col-md-4">
                                                <input  class="form-control" style="direction:rtl" type="text" name="title_ar[]" placeholder="Title (Ar)" value="<?= $r->title_ar ?>" />
                                            </div>

                                            <div class="col-md-4">
                                                <input  class="form-control" style="direction:rtl" type="text" name="title_fa[]" placeholder="Title (Pe)" value="<?= $r->title_fa ?>" />
                                            </div>

                                            <div class="col-md-4">
                                                <input  class="form-control" type="text" name="title_en[]" placeholder="Title (En)" value="<?= $r->title_en ?>" />
                                            </div>

                                            <div class="col-md-4">
                                                <input  class="form-control" type="text" name="title_fr[]" placeholder="Title (Fr)" value="<?= $r->title_fr ?>" />
                                            </div>
                                            <div class="col-md-4">
                                                <input  class="form-control" type="text" name="title_ru[]" placeholder="Title (Ru)" value="<?= $r->title_ru ?>" />
                                            </div>
                                            <input type="button" value="x" class="delrow" />
                                        </div>
                                    <?php } ?>
                                </div>
                                <input class="btn btn-primary" type="button" id="addrow" value="Add +">	
                            </div>




                        </div>



                    </div>


               
            </div>
        </div>
    </div>

</fieldset>



@include("admin.layouts.media_input_js")
<script>
    $('#addrow').click(function () {
        $('.dblocks').append('<div class="row add_question_sec">' +
                '<div class="col-md-4">' +
                '<input  class="form-control" style="direction:rtl" type="text" name="title_ar[]" placeholder="Title (Ar)" value="" />' +
                '</div>' +
                '<div class="col-md-4">' +
                '<input  class="form-control" style="direction:rtl" type="text" name="title_fa[]" placeholder="Title (Pe)" value="" />' +
                '</div>' +
                '<div class="col-md-4">' +
                '<input  class="form-control" type="text" name="title_en[]" placeholder="Title (En)" value="" />' +
                '</div>' +
                '<div class="col-md-4">' +
                '<input  class="form-control" type="text" name="title_fr[]" placeholder="Title (Fr)" value="" />' +
                '</div>' +
                '<div class="col-md-4">' +
                '<input  class="form-control" type="text" name="title_ru[]" placeholder="Title (Ru)" value="" />' +
                '</div>' +
                '<input type="button" value="x" class="delrow" />' +
                '</div>');
    });

    $('body').on('click', '.delrow', function () {
        $(this).parent('.row').remove();
    });
</script>
@endsection
