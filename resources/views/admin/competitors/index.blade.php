<?php $title = (isset($comp) ? $comp->name : 'Competitors'); ?>
@extends('admin.layouts.app', ["app_title" => $title])
@section('main_content')



<?php
if (!isset($comp)) {
    $lignes = [
        "id" => "",
        "name" => "Name"
    ];
    ?>
    @include("admin.layouts.table", [
    "box_title"    =>    "Competitors"
    ])
<?php } else { ?>





    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <style>
        .card-image{
            position: relative;
            width: 100px;
            height: 100px;
            display: block;
        }
        .content {
            position: relative;
        }
        .add_btn{
            position: absolute;
            top: -32px;
            right: 15px;
        }
        .table>tbody>tr>td{
            vertical-align: middle;
        }
        .modal-header .close {
            margin-top: -30px;
        }
        .post_card{
            width: 100%;
            border: 1px solid #cccccc;
            overflow: hidden;
            border-radius: 6px;
            margin-bottom: 15px;
        }
        .post_card img{
            width: 100%;
            height: auto;
        }
        .post_card h2{
            padding: 0px 10px;
            font-size: 18px;
            color: #058687;
        }
        .post_card p{
            padding: 0px 10px;
            font-size: 14px;
            color: #555555;
        }
        .tab-content{
            padding: 0px 10px;
        }
    </style>

    <a href="#" class="btn btn-default btn-sm add_btn" id="btn_add_new_ads" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus-circle"></i> Add New</a>

    <div class="box">


        <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading lang-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1default"  data-toggle="tab">Google</a></li>
                    <li><a href="#tab2default" data-toggle="tab">Facebook</a></li>
                    <li><a href="#tab3default" data-toggle="tab">Instagram</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">

                    <!-- Google Section -->
                    <div class="tab-pane fade in active" id="tab1default">
                        
                        <div class="col-md-12">
                            <div class="row table">
							
							
							
							
							
									<?php
									$ads = $comp->ads;
									$i=0;
									foreach($ads as $ad){
										if($ad->tab_section=='Google'){
											$i++;
									?>
									<div class="col-md-6 ">
                                    <div class="post_card tr_<?= $ad->id ?>">
                                        <a target="_blank" class="link" href="<?= $ad->link ?>">
                                            <img src="<?= asset($ad->image) ?>" alt="title" />
                                        </a>
                                        <h2><?= $ad->title ?></h2>
                                        <p class="ad_type"><?= $ad->ad_type ?></p>
										<span class="tab_section" style="display: none;">
											<?= $ad->tab_section ?>
										</span>

										<a href="#" data-id="<?= $ad->id ?>" class="btn_edit_ads btn btn-primary btn-xs"  data-toggle="modal" data-target="#exampleModal"><i class="fa fa-edit"></i></a>
										<button data-id="<?= $ad->id ?>" class="btn_delete_ad btn btn-danger btn-xs " title="Delete"><i class="fa fa-trash"></i></button> 
									</div>
									</div>
									<?php }
									} ?>
                                        


                            </div>
                        </div>
                    </div>

                    <!-- Facebook Section -->
                    <div class="tab-pane fade" id="tab2default">
                        
						
                        <div class="col-md-12">
                            <div class="row table">
							
							
							
							
							
									<?php
									$ads = $comp->ads;
									$i=0;
									foreach($ads as $ad){
										if($ad->tab_section=='Facebook'){
											$i++;
									?>
									<div class="col-md-6 ">
                                    <div class="post_card tr_<?= $ad->id ?>">
                                        <a target="_blank" class="link" href="<?= $ad->link ?>">
                                            <img src="<?= asset($ad->image) ?>" alt="title" />
                                        </a>
                                        <h2><?= $ad->title ?></h2>
                                        <p class="ad_type"><?= $ad->ad_type ?></p>
										<span class="tab_section" style="display: none;">
											<?= $ad->tab_section ?>
										</span>

										<a href="#" data-id="<?= $ad->id ?>" class="btn_edit_ads btn btn-primary btn-xs"  data-toggle="modal" data-target="#exampleModal"><i class="fa fa-edit"></i></a>
										<button data-id="<?= $ad->id ?>" class="btn_delete_ad btn btn-danger btn-xs " title="Delete"><i class="fa fa-trash"></i></button> 
									</div>
									</div>
									<?php }
									} ?>
                                        


                            </div>
                        </div>
                    </div>

                    <!-- Instagram Section -->
                    <div class="tab-pane fade" id="tab3default">
						<div class="col-md-12">
                            <div class="row table">
							
							
							
							
							
									<?php
									$ads = $comp->ads;
									$i=0;
									foreach($ads as $ad){
										if($ad->tab_section=='Instagram'){
											$i++;
									?>
									<div class="col-md-6 ">
                                    <div class="post_card tr_<?= $ad->id ?>">
                                        <a target="_blank" class="link" href="<?= $ad->link ?>">
                                            <img src="<?= asset($ad->image) ?>" alt="title" />
                                        </a>
                                        <h2><?= $ad->title ?></h2>
                                        <p class="ad_type"><?= $ad->ad_type ?></p>
										<span class="tab_section" style="display: none;">
											<?= $ad->tab_section ?>
										</span>

										<a href="#" data-id="<?= $ad->id ?>" class="btn_edit_ads btn btn-primary btn-xs"  data-toggle="modal" data-target="#exampleModal"><i class="fa fa-edit"></i></a>
										<button data-id="<?= $ad->id ?>" class="btn_delete_ad btn btn-danger btn-xs " title="Delete"><i class="fa fa-trash"></i></button> 
									</div>
									</div>
									<?php }
									} ?>
                                        


                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>




    <!-- Add Edit Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ad Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <form method="post" action="" enctype="multipart/form-data" id="myform">
					<input type="hidden" name="competitor_id" value="<?= $comp->id ?>" />
					<input type="hidden" name="id" value="" />
                <div class="modal-body">
                        <div class="form-group">
                            <label for="title" class="col-form-label">Title:</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-form-label">URL:</label>
                            <input type="url" class="form-control" id="link" name="link">
                        </div>
                        <div class="form-group">
                            <label for="ad_type" class="col-form-label">Ad Type:</label>
                            <select class="form-control" name="ad_type" id="ad_type">
                                <option value="">Ad Type</option>
                                <option value="Text">Text</option>
                                <option value="Video">Video</option>
                                <option value="Photo">Photo</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ad_type" class="col-form-label">Tab Section:</label>
                            <select class="form-control" name="tab_section" id="tab_section">
                                <option value="">Tab Section</option>
                                <option value="Google">Google</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Instagram">Instagram</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="photo" class="col-form-label">Upload Photo:</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/png, image/jpg, image/jpeg">
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="submit_ad" class="btn btn-primary">Save changes</button>
                </div></form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

    <script>
        // Fancybox Config
        $('[data-fancybox="gallery"]').fancybox({
            buttons: [
                "slideShow",
                "thumbs",
                "zoom",
                "fullScreen",
                "share",
                "close"
            ],
            loop: false,
            protect: true
        });
$(document).ready(function(){
    $("#myform").submit(function(e){
		e.preventDefault();
		$("#submit_ad").attr('disabled','disabled');
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: $('#myform').attr('action'),
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
				$("#submit_ad").removeAttr('disabled');
				$("#exampleModal").modal('hide');
				
				if($('#myform').attr('action').includes("create")){
					alert('action containe create');
					if($('#tab_section').val()=='Google'){
						$('#tab1default .table').prepend(response.html);
					}else if($('#tab_section').val()=='Facebook'){
						$('#tab2default .table').prepend(response.html);
					}else{
						$('#tab3default .table').prepend(response.html);
					}
				}else{
					$('.table .tr_'+ $('#myform input[name="id"]').val()).html(response.html);
					
				}
				
            },
        });
    });
});


$('#btn_add_new_ads').click(function(){
	$('#myform').attr('action','<?= route('admin.competitors_ads.create') ?>');
	//$('#myform input[name="competitor_id"]').val('');
	$('#myform input[name="title"]').val('');
	$('#myform input[name="link"]').val('');
	$('#myform select[name="ad_type"]').val('');
	$('#myform select[name="tab_section"]').val('');
});
$('.btn_edit_ads').click(function(){
	id = $(this).data('id');
	$('#myform').attr('action','<?= route('admin.competitors_ads.edit',0) ?>'.replace('0',id));


	tr = $(this).parent("div");
	$('#myform input[name="id"]').val(id);
	$('#myform input[name="title"]').val(tr.find('h2').text().trim());
	$('#myform input[name="link"]').val(tr.find('.link').attr("href").trim());
	$('#myform select[name="ad_type"]').val(tr.find('.ad_type').text().trim());
	$('#myform select[name="tab_section"]').val(tr.find('.tab_section').text().trim());



});
$('.btn_delete_ad').click(function(){
	
	
	if(confirm("Confirm delete")){
		id = $(this).data('id');
		url = '<?= route('admin.competitors_ads.delete',0) ?>'.replace('0',id);
		
		
		$(this).parent("div").remove();
		
		
		
		$.ajax({
				url: url,
				type: 'post',
				data: {},
				contentType: false,
				processData: false,
				success: function(response){
					
				},
        });
	}
	
});


    </script>



<?php } ?>

@endsection