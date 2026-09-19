@extends('admin.layouts.form', ["app_title" => "Clear Cache"])
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
                                
								<span>
Separate URL(s) one per line:<br>
<b>Example:<br>
https://damas.net/turkish-citizenship<br>
https://damas.net/blog/iranians-demand-for-apartments-in-istanbul</b>
								</span>
                                <div class="dblocks">
                                    <textarea class="form-control" name="urls" placeholder="https://damas.net/blog" rows="10"></textarea>
                                </div>
                            </div>




                        </div>



                    </div>


               
            </div>
        </div>
    </div>

</fieldset>



@include("admin.layouts.media_input_js")
<script>
    
</script>
@endsection
