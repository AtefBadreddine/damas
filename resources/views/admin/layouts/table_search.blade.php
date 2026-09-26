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
</style>
<div class="box">
    <div class="box-header with-border">

		@if(Route::currentRouteName()=='admin.whatsapp_msg')
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
		@else
        <h3 class="box-title"><?= @$box_title ?></h3>
		@endif

        <div class="box-tools">
			@if( Route::currentRouteName()=='admin.whatsapp_msg' )
				<!--<?php if(isset($_GET['manual_insert']) and $_GET['manual_insert']==1){ ?>
				<a href="<?= route("admin.whatsapp_msg"); ?>" class="btn btn-default btn-sm"><i class="fa fa-list"></i> عرض الكل</a>
				<?php }else{ ?>
				<a href="<?= route("admin.whatsapp_msg"); ?>?manual_insert=1" class="btn btn-default btn-sm"><i class="fa fa-list"></i> عرض النقرات المعدلة فقط</a>
				<?php } ?>-->


<select id="manual_insert" onchange="window.location.href = '<?= route("admin.whatsapp_msg"); ?>?manual_insert='+this.options[this.selectedIndex].value + (document.getElementById('filterdate').value=='0'?'':'&filterdate='+document.getElementById('filterdate').value)">
<option value="0">View All</option>
<option value="1" <?= @$_GET['manual_insert']=='1'?'selected="selected"':'' ?>>Adjusted Clicks</option>
<option value="2" <?= @$_GET['manual_insert']=='2'?'selected="selected"':'' ?>>Unadjusted Clicks</option>
</select>

<select id="filterdate" onchange="window.location.href = '<?= route("admin.whatsapp_msg"); ?>?filterdate='+this.options[this.selectedIndex].value + (document.getElementById('manual_insert').value=='0'?'':'&manual_insert='+document.getElementById('manual_insert').value)">
<option value="0">التاريخ</option>
<option value="today" <?= @$_GET['filterdate']=='today'?'selected="selected"':'' ?>>Today</option>
<option value="yesterday" <?= @$_GET['filterdate']=='yesterday'?'selected="selected"':'' ?>>Yesterday</option>
<option value="last7days" <?= @$_GET['filterdate']=='last7days'?'selected="selected"':'' ?>>Last 7 Days</option>
<option value="last15days" <?= @$_GET['filterdate']=='last15days'?'selected="selected"':'' ?>>Last 15 Days</option>
<option value="thismonth" <?= @$_GET['filterdate']=='thismonth'?'selected="selected"':'' ?>>Current Month</option>
<option value="lastmonth" <?= @$_GET['filterdate']=='lastmonth'?'selected="selected"':'' ?>>Last Month</option>
</select>

			@endif
			@if( Route::currentRouteName()=='admin.projects' || Route::currentRouteName()=='admin.newsletter' )
				<form method="get" style="float:right">
					<input type="text" class="nochnage" name="search" value="<?= @$_GET['search'] ?>" >
					<input type="submit" class="btn" value="search" />
				</form>
			@endif
            @if(  Auth::user()->is('superadmin') and Route::currentRouteName()=='admin.whatsapp_msg' )
                <a href="<?= route("admin.whatsapp_msg.download"); ?>" class="btn btn-default btn-sm"><i class="fa fa-download"></i> Download data for Google Ads</a>
                
            @endif
			

            @if( Route::has("$route.create") )
                <a href="<?= route("$route.create",@$r->id); ?>" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i> Add New</a>
            @endif
            @if($total_rows>10)
                <div class="pull-left" style="margin-right:10px;">
                    <?php $arr_nmbre = [10, 20, 40, 60, 100]; ?>
                    <select id="select_lignes" class="form-control input-sm">
                        @foreach($arr_nmbre as $nbre)
                            <option value="<?= $nbre; ?>" <?= Helper::ajax_change_paginate_number()==$nbre?'selected':''; ?>><?= $nbre; ?></option>
                        @endforeach
						
						@if( Route::currentRouteName()=='admin.whatsapp_msg' )
						<option value="<?= 100000; ?>" <?= Helper::ajax_change_paginate_number()==100000?'selected':''; ?>>All</option>
						@endif
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
                    <th style="width:20px;"><input class="checkall" type="checkbox"></th>
                    <th></th>
                    @foreach($lignes as $kth => $th)
                        <?php if ( !$th ) continue; ?>
                        <th>
                            <a href="?field=<?= @explode("|", $kth)[0]; ?>&sort=<?= $page_sort; ?>&page=<?= $page_num; ?><?= @$get_params; ?>">{{ $th }}</a>
                        </th>
                    @endforeach
                    @if($tr_placement)<th style="width:130px;">Arrange items</th>@endif
                    <th style="width:100px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $krow => $row)
                <tr class="<?= $row->blocked == 1 ? "bg-danger" : ""; ?>" @if($route=="admin.whatsapp_msg" and $row->manual_insert=="0") style="background-color:#2ecc717d" @endif>
                    <td class="text-center"><input type="checkbox" value="<?= $row->id; ?>" class="input_check"></td>
                    <!--<td><?= $rows->total() - ($krow+$rows->firstItem())+1; ?></td>-->
					
					
					
					
                    <td><?= $placement = ($krow+$rows->firstItem()); ?></td>
                    @foreach($lignes as $key => $th)
                        <?php
                            if ( !$th ) continue;
                            $arr_keys = explode('|', $key);
                        ?>
					
					
					
					
						<?php /*
						@if(/$route=="admin.stats" and/ $key=="country")
							@if(!$row->country and $row->ip!='')
							<?php
								$json = file_get_contents("https://www.iplocate.io/api/lookup/{$row->ip}");
								$track = json_decode($json);
								//$row->iso_code = @$track->country_code;
								$row->country = @$track->country;
								//$row->city = @$track->city;
								$row->save();
							?>
							@endif
						@endif
						*/ ?>
                        @if(@$arr_keys[1])
                            <?php
                                $field_id = @$arr_keys[0];
                                $model = ucfirst($arr_keys[1]);
                                $field = @$arr_keys[2];
                                $find_row =Helper::query($model, "find", ['id' => $row->$field_id]);
                            ?>
                            <td>{{ $field ? $find_row->$field : $find_row->name_en }}</td>
                        @else
                            <td <?= $key=="mobile" ? "dir='ltr'":""; ?>>
								@if($route=="admin.whatsapp_msg" and $key=="email")
									<div class="nobreak">{{ $row->$key }}</div>
								@elseif($route=="admin.whatsapp_msg" and $key=="page")
								<div class="nobreak">	
								<?php
								$lnk = $row->page=="https://www.damas.net/"?"damas.net":str_replace("https://www.damas.net/","",strtok($row->page,"?"));
								/*$lnk = '';
								for($i=0;$i<strlen($lnk0);$i++){
										$lnk = $lnk.$lnk0[$i];
									if($i!=0 and $i%20==0)
										$lnk = $lnk.'<br>';
								}
								$lnk = str_replace(array('https://','http://','www-','www.'),'',$lnk);*/
								
								$t=explode('damas.net/amp',$lnk);

								if(isset($t[1]))
									$lnk = $t[1];

								$lnk = str_replace('.cdn.ampproject.org','',$lnk);

								$t=explode('damas.net/en/amp',$lnk);
								if(isset($t[1]))
									$lnk = $t[1];

								if(trim($lnk)=='' or trim($lnk)=='https://www.damas.net' or trim($lnk)=='https://www.damas.net/' or trim($lnk)=='https://www-damas-net/')
									$lnk = '/';

								
								echo '<a href="'.strtok($row->page, "?") .'" target="_blank">'. $lnk .'</a>';
								
								?>
								</div>
                                @elseif($route=="admin.projects" and $key=='name_en')
									<a href="{{ $row->frontUrl() }}" target="_blank">{{ $row->$key }}</a>
                                @elseif($route=="admin.landingpage" and $key=='name')
									<?php $langs = explode(',',$row->lang);
									foreach($langs as $ln){ ?>
									<a href="https://www.damas.net/<?= ($ln=='ar'?'':$ln.'/') ?>landing/<?= $row->slug ?>" target="_blank">
                                        {{ $row->project->title_en  }} - {{ ucfirst($ln) }}
                                    </a><br>
									<?php } ?>
                                @elseif($route=="admin.landingpage" and $key=='views')
									<?php $langs = explode(',',$row->lang);
									foreach($langs as $ln){
									if($ln=='ar')
										echo $row->views.'<br>';
									elseif($ln=='en')
										echo $row->views_en.'<br>';
									elseif($ln=='fr')
										echo $row->views_fr.'<br>';
									elseif($ln=='fa')
										echo $row->views_fa.'<br>';
									?>
									<?php } ?>
                                @elseif($route=="admin.wordsearch")
									@if($key=="word")
										{{ $row->word }}
									@elseif($key=='type')
										@if($row->$key == 'project')
											Project
										@elseif($row->$key == 'post')
											Posts
										@else
											All
										@endif
									@endif
                                @elseif($route=="admin.medias.folders" and $key=="name")
                                    <a href="<?= route("admin.medias")."?folder_id=$row->id"; ?>" target="_blank">
                                        {{ $row->$key }}
                                    </a>
								@elseif($key=="tags" and ($route=="admin.messages" or $route=="admin.whatsapp_msg"))
									<div style="direction: ltr;text-align: left;" class="nobreak">
									<?php
									/*if($row->$key!=''){
									$ts = json_decode($row->$key);
									?>
										@foreach($ts as $ke => $va)
											@if($ke!='gclid')
												{{ $ke . ': ' . (strpos('.',$va)!==false?'<a rel="noopner" href="http://'.$va.'">'.$va.'</a>':$va) }}<br>
											@endif
										@endforeach
									<?php }*/ ?>
									</div>
								
								@elseif($route=="admin.search" and $key=="word")
									<a href="{{ url('search/?s='.$row->word) }}" target="_blank">
										{{ $row->$key }}
                                    </a>
								@elseif($route=="admin.search" and $key=="campaign")
								{{ $row->$key }}
								<!--<br>
								{{ $row->target }}-->
								@elseif($route=="admin.search" and $key=="country")
									<?php
									$w_w = unserialize(urldecode($row->country));
									if(!empty($w_w))
									foreach($w_w as $sc=>$sv){
									?>
									{{ $sc }}({{ $sv }}) <br>
									<?php } ?>
								@elseif($route=="admin.search" and $key=="source")
									@if(strpos(strtolower($row->source), 'ampproject') !== false)
										Ampproject
									@elseif(strpos(strtolower($row->source), 'mail.google.com') !== false)
										Gmail
									@elseif(trim($row->source) == 'دخول مباشر')
										Direct
									@elseif(strpos(strtolower($row->source), 'google') !== false)
										Google
									@elseif(strpos(strtolower($row->source), 'facebook') !== false)
										Facebook
									@else
										{{ $row->source }}
									@endif
								@elseif($key=="src" and ($route=="admin.whatsapp_msg"))
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
								@elseif($key=="device" and ($route=="admin.whatsapp_msg"))
									{{ strip_tags($row->device) }} <br/>
									{{ strip_tags($row->device_type) }} <br/>
									{{ strip_tags($row->platform) }} <br/>
									{{ strip_tags($row->browser) }}
									
                                @elseif($route=="admin.messagesvac" and $key=="academic_degree")
									<?php
									$arr_degs_name = unserialize(urldecode($row->academic_degree));
									for($u=0;$u<count($arr_degs_name);$u++){ ?>
									{{ $arr_degs_name[$u] }}<br>
									<?php
									}
									?>
                                @elseif($route=="admin.messagesvac" and $key=="company")
									<?php
									$arr_comps_name = unserialize(urldecode($row->company));
									for($u=0;$u<count($arr_comps_name);$u++){ ?>
									{{ $arr_comps_name[$u] }}<br>
									<?php
									}
									?>
                                @elseif($route=="admin.projects" and $key=="payment_method")
								<?php
								if($row->payment_method=='تقسيط')
									echo 'Installment';
								elseif($row->payment_method=='نقدي')
									echo 'Cash';
								?>
                                @elseif($route=="admin.messagesvac" and $key=="field")
									<?php
									$arr_comps_name = unserialize(urldecode($row->field));
									for($u=0;$u<count($arr_comps_name);$u++){ ?>
									{{ $arr_comps_name[$u] }}<br>
									<?php
									}
									?>
								@elseif($route=="admin.redirect_short" and $key=="slug")
									<input type="text" value="https://www.damas.net/<?= $row->slug ?>" readonly style="direction:ltr">
								@elseif($route=="admin.redirect_short" and $key=="url")
									<div class="nobreak">{{ $row->url }}</div>
								@elseif($key=="country")
									{{ Helper::code_to_country($row->$key) }}
                                @elseif($route=="admin.messagesvac" and $key=="period")
									<?php
									$arr_periods_name = unserialize(urldecode($row->period));
									for($u=0;$u<count($arr_periods_name);$u++){ ?>
									{{ $arr_periods_name[$u] }}<br>
									<?php
									}
									?>
                                @elseif($route=="admin.messages" and $key=="form_type")
                                    <a href="<?= strtok($row->page, '?') ?>" target="_blank">{{ $row->form_type }}</a>
                                @elseif($route=="admin.stats" and $key=="updated_at")
                                    <span><b>اخر نشاط</b>: <?= Helper::dateHuman($row->updated_at); ?></span> <small>(<?= $row->updated_at; ?>)</small><br>
                                    <span><b>وقت الدخول</b>:</span><small><?= $row->created_at; ?></small><br>
                                    @if($row->page_views > 1)
                                        <span><b>المدة بين آخر نشاطين</b>: <?= $difMin = Helper::dateDifference($row->created_at, $row->updated_at); ?></span>
                                    @endif
                                    <!-- delete if date diff > 7 days -->
                                    <?php
                                        $difdays = Helper::dateDifference($row->updated_at, date('Y-m-d h:i:s'), 'day');
                                        if ( $difdays > 3 or @$difMin > 4500 ) {
                                            $row->deleted = 1;
                                            $row->save();
                                        }
                                    ?>
                                @elseif($route=="admin.stats" and $key=="page_views")
                                    <?php
                                        $arr_pv = array_filter(explode("#", $row->pages));
                                        $u_arr_pv = array_unique($arr_pv);
                                    ?>
                                    {{ count($u_arr_pv)."/".count($arr_pv) }}
                                @elseif($route=="admin.blog.posts" and $key=="category_id")
									{{ implode(',', $row->categories()->lists('name_en')->toArray()) }}
                                @else
									{{ $row->$key }}
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
                    <td>
					<?php
					if(isset($reviews_links)){ ?>
					<a href="<?= route("admin.salesmanagers_reviews"); ?>?agent=<?= $row->id ?>" class="btn btn-warning btn-xs" title="Reviews"><i class="fa fa-star"></i></a>
					<?php } ?>
                        @if( Route::has("$route.edit") )
                            <a href="<?= route("$route.edit", $row->id); ?>" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
                        @endif
                        @if( Route::has("$route.list_cat") )
                            <a href="<?= route("$route.list_cat", $row->id); ?>" class="btn btn-primary btn-xs" title="Sections"><i class="fa fa-list"></i></a>
                        @endif
                        @if( Route::has("$route.delete") )
                            <?= Form::open(["method" => "DELETE", "url" => route("$route.delete", $row->id), "class" => "inline"]); ?>
                                <button data-id="<?= $row->id; ?>" class="btn btn-danger btn-xs button_confirm" title="Delete"><i class="fa fa-trash"></i></button>
                            <?= Form::close(); ?>
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
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
    @if(count($rows) )
    <div class="box-footer clearfix">
        <div class="row">

			@if(Route::currentRouteName()!='admin.whatsapp_msg')
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
