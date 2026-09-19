@extends('admin.layouts.form', ["app_title" => "Add Category"])
@section('main_form')



<style>
    .dblocks input{

    }
    .dblocks .row{
        margin: 13px 0;
    }
    .delrow{float:right}
</style>

<fieldset>
    <!--    <legend>Add a New post</legend>-->
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
            

                    <!-- Section Arabic -->
                    <div class=" fade in active" id="tab1default">

                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <label>Title Arabic<span class="red">(*)</span></label>
                                <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control", "placeholder" => "Arabic Title"]); ?>
                            </div> 
                        </div>
                        <div class="form-group col-md-4">
                            <label>Title English</label>
                            <?= Form::text("title_en", $row->title_en, ["class" => "form-control ltr", "placeholder" => "English Title"]); ?>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Title Frensh</label>
                            <?= Form::text("title_fr", $row->title_fr, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                        </div><div style="clear:both"></div>
                        <div class="form-group col-md-4">
                            <label>Title Persian</label>
                            <?= Form::text("title_fa", $row->title_fa, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Title Russian</label>
                            <?= Form::text("title_ru", $row->title_ru, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Type</label>
                            <?= Form::select("type", ["jobs" => "Jobs", "products" => "Products"], $row->type, ["class" => "form-control select2me selectrole"]); ?> 
                        </div>

                        <div class="col-md-12">










                            <div class="form-group col-md-12">
                                <h3>Prices:</h3>
                                        <!--<span>Question</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span>Answer</span>-->
                                <div class="dblocks">
                                    <?php
                                    //$rows = DB::select("select * from dms_faq order by id asc");

                                    foreach ($livingitems as $r) {
                                        ?>
                                        <div class="row add_question_sec">
                                            <div class="col-md-4">
                                                <input  class="form-control" style="direction:rtl" type="text" name="name_ar[]" placeholder="Title (Ar)" value="<?= $r->name_ar ?>" />
                                            </div>

                                            <div class="col-md-4">
                                                <input  class="form-control" style="direction:rtl" type="text" name="name_fa[]" placeholder="Title (Pe)" value="<?= $r->name_fa ?>" />
                                            </div>

                                            <div class="col-md-4">
                                                <input  class="form-control" type="text" name="name_en[]" placeholder="Title (En)" value="<?= $r->name_en ?>" />
                                            </div>

                                            <div class="col-md-4">
                                                <input  class="form-control" type="text" name="name_fr[]" placeholder="Title (Fr)" value="<?= $r->name_fr ?>" />
                                            </div>

                                            <div class="col-md-4">
                                                <input  class="form-control" type="text" name="name_ru[]" placeholder="Title (Ru)" value="<?= $r->name_ru ?>" />
                                            </div>

                                            <div class="col-md-4">
                                                <input  class="form-control" type="text" name="price[]" placeholder="Price (TL)" value="<?= $r->price ?>" />
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
                '<input  class="form-control" style="direction:rtl" type="text" name="name_ar[]" placeholder="Title (Ar)" value="" />' +
                '</div>' +
                '<div class="col-md-4">' +
                '<input  class="form-control" style="direction:rtl" type="text" name="name_fa[]" placeholder="Title (Pe)" value="" />' +
                '</div>' +
                 '<div class="col-md-4">' +
                '<input  class="form-control" type="text" name="name_en[]" placeholder="Title (En)" value="" />' +
                '</div>' +
                '<div class="col-md-4">' +
                '<input  class="form-control" type="text" name="name_fr[]" placeholder="Title (Fr)" value="" />' +
                '</div>' +
                '<div class="col-md-4">' +
                '<input  class="form-control" type="text" name="name_ru[]" placeholder="Title (Ru)" value="" />' +
                '</div>' +
                '<div class="col-md-4">' +
                '<input  class="form-control" type="text" name="price[]" placeholder="Price (TL)" value="" />' +
                '</div>' +
                '<input type="button" value="x" class="delrow" />' +
                '</div>');
    });

    $('body').on('click', '.delrow', function () {
        $(this).parent('.row').remove();
    });
</script>
@endsection
