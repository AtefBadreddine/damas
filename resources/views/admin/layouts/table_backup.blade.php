<?php
    $route = Route::currentRouteName();
    $page_num = Input::get("page") ? Input::get("page") : 1;
    $tr_placement = @$tr_placement;
    $total_rows = $rows->total();

    $input_field = Input::get("field");
    $input_sort = Input::get("sort");
    if ( $input_sort ) {
        $page_sort = $input_sort=="asc"?"desc":"asc";
    } else {
        $page_sort = "asc";
    }
?>
<style>
.nobreak{
overflow-wrap: break-word;
word-wrap: break-word;
-ms-word-break: break-all;
/* This is the dangerous one in WebKit, as it breaks things wherever */
word-break: break-all;
/* Instead use this non-standard one: */
word-break: break-word;
/* Adds a hyphen where the word breaks, if supported (No Blink) */
-ms-hyphens: auto;
-moz-hyphens: auto;
-webkit-hyphens: auto;
hyphens: auto;
}
body tr td{
	text-align:center
}
</style>
<div class="box">
    <div class="box-header with-border">

<?php /*		@if(Route::currentRouteName()=='admin.whatsapp_msg') */ ?>
            @if(Auth::user()->is('superadmin'))
			<div class="col-md-3">
                <div class="input-group">
                    <select name="action" id="selectAction" class="form-control" style="height:28px;line-height: 1px;padding: 3px 10px;">
                        <option value="">Execution</option>
                        <option value="delete">Delete</option>
                    </select>
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-primary btn-flat" id="btnAction" style="border-radius:0;padding: 3px 15px">Implementation</button>
                    </span>
                </div>
            </div>
			@endif
	<?php /*	@else
        <h3 class="box-title"><?= @$box_title ?></h3>
		@endif
*/ ?>
        <div class="box-tools">
			
			

            @if($total_rows>10)
                <div class="pull-left" style="margin-right:10px;">
                    <?php $arr_nmbre = [10, 20, 40, 60, 100, 500]; ?>
                    <select id="select_lignes" class="form-control input-sm">
                        @foreach($arr_nmbre as $nbre)
                            <option value="<?= $nbre; ?>" <?= Helper::ajax_change_paginate_number()==$nbre?'selected':''; ?>><?= $nbre; ?></option>
                        @endforeach
						
						<?php /*
						@if( Route::currentRouteName()=='admin.whatsapp_msg' )
						<option value="<?= 500; ?>" <?= Helper::ajax_change_paginate_number()==500?'selected':''; ?>>500</option>
						@endif
						*/ ?>
					</select>
                </div>
            @endif
			
			
			
			

			
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width:20px;"><input class="checkall" type="checkbox" style="height:auto"></th>
					
				<th>NO</th>
                    @foreach($lignes as $kth => $th)
                        <?php if ( !$th ) continue; ?>
                        <th>
                            <a href="?field=<?= @explode("|", $kth)[0]; ?>&sort=<?= $page_sort; ?>&page=<?= $page_num; ?><?= @$get_params; ?>">{{ $th }}</a>
                        </th>
                    @endforeach
                    @if($tr_placement)<th style="width:130px;">Arrange items</th>@endif
                    
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $krow => $row)
                <tr class="" @if($row->insert_crm != '1' ) style="background-color:#2ecc717d" @endif>
                    
					<td class="text-center">
					<input type="checkbox" value="<?= $row->id; ?>" class="input_check" style="height:auto">
					
                        @if( Route::has("$route.edit") )
							@if($row->insert_crm != '1' )
                            <a href="<?= route("$route.edit", $row->id); ?>" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
							@endif
                        @endif
                        @if( Route::has("$route.list_cat") )
                            <a href="<?= route("$route.list_cat", $row->id); ?>" class="btn btn-primary btn-xs" title="Sections"><i class="fa fa-list"></i></a>
                        @endif
						
                        @if(Auth::user()->is('superadmin'))
                        @if( Route::has("$route.delete") )
                            <?= Form::open(["method" => "DELETE", "url" => route("$route.delete", $row->id), "class" => "inline"]); ?>
                                <button data-id="<?= $row->id; ?>" class="btn btn-danger btn-xs button_confirm" title="Delete"><i class="fa fa-trash"></i></button>
                            <?= Form::close(); ?>
                        @endif
                        @endif
                        @if( Route::has("$route.initializeviews") )
                            <?= Form::open(["method" => "POST", "url" => route("$route.initializeviews", $row->id), "class" => "inline"]); ?>
                                <button data-id="<?= $row->id; ?>" class="btn btn-info btn-xs button_confirm" title="Returns The Number Of Visits To Zero"><i class="fa fa-eye-slash"></i></button>
                            <?= Form::close(); ?>
							
							
                        <button data-lang="<?= $row->lang; ?>" data-slug="<?= $row->slug; ?>" data-id="<?= $row->id; ?>" class="btn btn-info btn-xs button_refresh_cache" title="Cache Update"><i class="fa fa-refresh"></i></button>
	
                        @endif
                        @if( Route::has("$route.block") )
                            <?= Form::open(["method" => "POST", "url" => route("$route.block", $row->id), "class" => "inline"]); ?>
                                <button data-id="<?= $row->id; ?>" class="btn btn-warning btn-xs button_confirm" title="<?= $row->blocked == 0 ? "Block IP" : "Unblock IP"; ?>"><i class="fa fa-bug"></i></button>
                            <?= Form::close(); ?>
                        @endif
					
					</td>
                    <!--<td><?= $rows->total() - ($krow+$rows->firstItem())+1; ?></td>-->
					
					
					<td><?= $placement = ($krow+$rows->firstItem()); ?></td>
					
					
                    
                    @foreach($lignes as $key => $th)
                        <?php
                            if ( !$th ) continue;
                            $arr_keys = explode('|', $key);
                        ?>
					
					
					
					
						
						
                        @if(@$arr_keys[1])
                            <?php
                                $field_id = @$arr_keys[0];
                                $model = ucfirst($arr_keys[1]);
                                $field = @$arr_keys[2];
                                $find_row =Helper::query($model, "find", ['id' => $row->$field_id]);
                            ?>
                            <td><?= $field ? $find_row->$field : $find_row->name_ar; ?></td>
                        @else
                            <td <?= $key=="mobile" ? "dir='ltr'":""; ?>>
								@if($route=="admin.whatsapp_msg" and $key=="email")
									<div class="nobreak">{{ $row->$key }}</div>
								@elseif($key=="code")
								<a href="https://crm.damas.net/app/leads/{{ $row->$key }}/edit" target="_blank">{{ $row->$key }}</a>
								@elseif($key=="page")
								<div class="nobreak">	
								<?php
								$lnk = $row->page=="https://www.damas.net/"?"damas.net":str_replace("https://www.damas.net/","",strtok($row->page,"?"));

								$t=explode('damas.net/amp',$lnk);

								if(isset($t[1]))
									$lnk = $t[1];

								$lnk = str_replace('.cdn.ampproject.org','',$lnk);

								$t=explode('damas.net/en/amp',$lnk);
								if(isset($t[1]))
									$lnk = $t[1];

								if(trim($lnk)=='' or trim($lnk)=='https://www.damas.net' or trim($lnk)=='https://www.damas.net/' or trim($lnk)=='https://www-damas-net/')
									$lnk = '/';


								echo '<a href="'.($lnk == '/'?'/':strtok(htmlspecialchars($row->page), "?")) .'" target="_blank">'. htmlspecialchars($lnk) .'</a>';

								?><br/>
								<?php
								if(in_array($row->form_type,array('الإستمارة','صفحة الهبوط -الفوتر','استمارة الفوتر','Landing - Down','الهيدر','Search - Down'))
								or str_replace('own','',$row->form_type)!=$row->form_type
								){
									echo 'Footer';
								}elseif(in_array($row->form_type,array('صفحة الهبوط - مدير المبيعات','قسم مدير المبيعات','قسم خدمة العملاء','استمارة بوب اب','Project - consulting department','قسم كيف تستخدم موقعنا','استمارة شبكات التواصل'))){
									echo 'Body';
								}elseif(in_array($row->form_type,array('صفحة الهبوط - الهيدر'))){
									echo 'Header';
								}elseif(in_array($row->form_type,array('فورم الهدية'))){
									echo 'Gift';
								}else{ ?>
									{{ $row->form_type }}
								<?php } ?>
								</div>
								@elseif($key=="tags")
									<div style="direction:ltr;text-align:center" class="nobreak">
									@if(strpos(strtolower($row->src), 'ampproject') !== false)
										Ampproject
									@elseif(strpos(strtolower($row->src), 'mail.google.com') !== false)
										Gmail
									@elseif(trim($row->src) == 'دخول مباشر')
										Direct
									@elseif(strpos(strtolower($row->src), 'google') !== false)
										Google
									@elseif(strpos(strtolower($row->src), 'facebook') !== false)
										Facebook
									@else
										{{ $row->src }}
									@endif
									<br/>
									<?php
									if(Auth::user()->is('superadmin'))
									if($row->$key!=''){
									$ts = json_decode($row->$key,true);
									
									if(!isset($ts['utm_content']) ){
									foreach($ts as $ke => $va)
									if($ke!='gclid' && $ke!='sHTTP_REFERER' && $ke!='sREQUEST_URI'){
									?>
										<?php
										echo htmlspecialchars($ke) . ': ';
										$va = ($va);
										echo strpos($va,'.')!==false?'<a target="_blank" rel="noopner" href="http://'.$va.'">'.htmlspecialchars($va).'</a>':htmlspecialchars($va);
										?>
										<br>
									<?php }
									}else{
										echo 'Display: '. @$ts['campaign-name'] .'<br>';
										echo 'Target: '. '<a target="_blank" rel="noopner" href="http://'. @$ts['utm_content'].'">'.htmlspecialchars(@$ts['utm_content']).'</a>';
									} 
									} ?>
									</div>
								@elseif($key=="src" )
									@if(strpos(strtolower($row->src), 'ampproject') !== false)
									Ampproject
									@elseif(strpos(strtolower($row->src), 'mail.google.com') !== false)
									Gmail
									@elseif(trim($row->src) == 'دخول مباشر')
									Direct
									@elseif(strpos(strtolower($row->src), 'google') !== false)
									Google
									@elseif(strpos(strtolower($row->src), 'facebook') !== false)
									Facebook
									@else
									{{ $row->src }}
									@endif
								@elseif($key=="budget" )
								{{ $row->communication_time }} <br/>{{ $row->budget }} 
								@elseif($key=="country" )
								{{ (trim($row->country)!=''?Helper::code_to_country($row->country):'') }} 
								<!--<br/>{{ $row->mobile }} -->
								@elseif($key=="device" )
									{{ strip_tags($row->device) }} <br/>
									{{ strip_tags($row->device_type) }} <br/>
									{{ strip_tags($row->platform) }} <br/>
									{{ strip_tags($row->browser) }}
                                @elseif($key=="id")
									<div style="text-align:center;direction:ltr">
									
									@if(Route::currentRouteName()=='admin.messages')
										@if((int)@$row->whatsapp_id!=0)
											{{ $row->whatsapp_id }}
										@else
											{{ 'F'.$row->id }}
										@endif
									@else
										{{ $row->id }}
									@endif
									<br/>
									<?= date("m/d/Y", strtotime($row->created_at)) ?><br><?= date("h:i a", strtotime($row->created_at)) ?></div>
                                @else
                                    <?= $row->$key; ?>
                                @endif
                            </td>
                        @endif                    
                    @endforeach
                    @if($tr_placement==true)
                    <td>
                        <small><a href="" id="showInputPlacement"><?= $row->placement; ?></a></small>
                        <input type="text" name="plcmnt" value="<?= $row->placement; ?>" id="txtPlacement" class="form-control input-sm hidden" data-id="<?= $row->id; ?>">
                        @if($placement>1)
                            <a href="?move=first&id=<?= $row->id; ?>&pos=1" class="btn btn-default btn-xs" title="Move to top"><i class="fa fa-angle-double-up"></i></a>
                            <a href="?move=up&id=<?= $row->id; ?>&pos=<?= $placement-1; ?>" class="btn btn-default btn-xs" title="Move Up"><i class="fa fa-angle-up"></i></a>
                        @endif
                        @if($placement!=$total_rows)
                            <a href="?move=down&id=<?= $row->id; ?>&pos=<?= $placement+1; ?>" class="btn btn-default btn-xs" title="Move Down"><i class="fa fa-angle-down"></i></a>
                            <a href="?move=last&id=<?= $row->id; ?>&pos=<?= $total_rows; ?>" class="btn btn-default btn-xs" title="Move to end"><i class="fa fa-angle-double-down"></i></a>
                        @endif
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
    @if(count($rows) )
    <div class="box-footer clearfix">
        <div class="row">

			@if(Route::currentRouteName()!='admin.whatsapp_msg' and Route::currentRouteName()!='admin.messages')
            <div class="col-md-3">
                <div class="input-group">
                    <select name="action" id="selectAction" class="form-control">
                        <option value="">Execution</option>
                        <option value="delete">Delete</option>
                    </select>
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-primary btn-flat" id="btnAction" style="border-radius:0;">Implementation</button>
                    </span>
                </div>
            </div>
			@endif

            <div class="col-md-9 text-left">
                <?= $rows->appends(Input::except('page'))->render(); ?>
            </div>
        </div>
    </div>
    @endif
</div>
<style>
.pagination {
    margin: 0;
    padding: 0;
    direction: ltr;
}
</style>
<script type="text/javascript">

$(function() {
    /*$('body').on('click', '.pagination a', function(e) {
        e.preventDefault();

        $('#load a').css('color', '#dfecf6');

        var url = $(this).attr('href');  
        getArticles(url);
        window.history.pushState("", "", url);
    });

    function getArticles(url) {
        $.ajax({
            url : url  
        }).done(function (data) {
            $('.articles').html(data);  
        }).fail(function () {
            alert('Articles could not be loaded.');
        });
    }*/
    $(document).on("click", "#btnAction", function(){
        var action = $('#selectAction').val();
        if ( action == 'delete' ) {
            bootbox.confirm("تأكيد الإجراء", function(result) {
                if ( result ) {
                    var inputs = {};
                    inputs["table"] = '<?= @$row ? $row->table_name() : ''; ?>';
                    $('.input_check:checked').each(function(){
                        var id = $(this).val();
                        inputs[id] = id;
                    });
                    $.ajax({
                        type: "POST",
                        url: "<?= route("admin.ajaxqueries"); ?>",
                        data: {
                            _token: '<?= csrf_token(); ?>',
                            action: "custom_func",
                            func: "deleteTableRows",
                            inputs: inputs
                        }
                    }).done(function(resp){
                        console.log(resp);
                        if ( !resp ) location.reload();
                    });
                }
            });
        }
        return false;
    });
    
    $(document).on("change", "#select_lignes", function(){
        var inputs = {};
        var vl = $(this).val();
        inputs["nbre"] = vl;
        $("#ajaxloading").show();
        $.ajax({
            type: "POST",
            url: "<?= route("admin.ajaxqueries"); ?>",
            data: {
                _token: '<?= csrf_token(); ?>',
                action: "custom_func",
                func: "change_paginate_number",
                inputs: inputs
            }
        }).done(function(resp){
            $("#ajaxloading").hide();
            location.reload();
        });
    });
    
    $(document).on("click", "#showInputPlacement", function(){
        $(this).closest("tr").find("#txtPlacement").removeClass("hidden");
        return false;
    });
    
    $(document).on("change", "#txtPlacement", function(){
        var inputs = {};
        inputs["nbre"] = $(this).val();
        inputs["id"] = $(this).attr("data-id");
        inputs["table"] = '<?= @$row ? $row->table_name() : ''; ?>';
        $("#ajaxloading").show();
        $.ajax({
            type: "POST",
            url: "<?= route("admin.ajaxqueries"); ?>",
            data: {
                _token: '<?= csrf_token(); ?>',
                action: "custom_func",
                func: "change_placement_row",
                inputs: inputs
            }
        }).done(function(resp){
            location.reload();
        });
    });
    
});

</script>
