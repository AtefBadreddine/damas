<?php
    $filterdate = $_GET['filterdate'] ?? 'today';
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
    
    function formatDuration(int $seconds): string {
    $start = new DateTimeImmutable('@0');
    $end = new DateTimeImmutable("@$seconds");
    $interval = $start->diff($end);
    $hours = $interval->days * 24 + $interval->h;

    $parts = [];

    if ($hours > 0) {
        $parts[] = $hours . 'h';
    }

    if ($interval->i > 0 || $hours > 0) {
        $minutes = $hours > 0 ? str_pad($interval->i, 2, '0', STR_PAD_LEFT) : $interval->i;
        $parts[] = $minutes . 'm';
    }

    if ($interval->s > 0 || empty($parts)) {
        $secondsStr = !empty($parts) ? str_pad($interval->s, 2, '0', STR_PAD_LEFT) : $interval->s;
        $parts[] = $secondsStr . 's';
    }

    return implode(' ', $parts);
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
.row.flexParent {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
}
.col-md-9 {
    width: auto;
}
.box-tools {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
}
</style>

<div class="box">
    <div class="box-header with-border">

<?php /*		@if(Route::currentRouteName()=='admin.whatsapp_msg') */ ?>
            @if(Auth::user()->is('superadmin'))
			<div class="col-md-3">
                <div class="input-group">
                    <select name="action" id="selectAction" class="form-control" style="height:28px;line-height: 1px;padding: 3px 10px;width: 150px">
                        <option value="">Bulk Actions</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-primary btn-flat" id="btnAction" style="border-radius:0;padding: 3px 15px;margin-left:-69.6px;">Apply</button>
                    </span>
                </div>
            </div>
			@endif
	<?php /*	@else
        <h3 class="box-title"><?= @$box_title ?></h3>
		@endif
*/ ?>
        <div class="box-tools">
			
			
@if($route=="admin.whatsapp_msg")
<select id="manual_insert" onchange="window.location.href = '?manual_insert='+this.options[this.selectedIndex].value + (document.getElementById('filterdate').value=='0'?'':'&filterdate='+document.getElementById('filterdate').value)" style="width: 150px;margin-left: 0px;">
<option value="0">WhatsApp Clicks</option>
<option value="1" <?= @$_GET['manual_insert']=='1'?'selected="selected"':'' ?>>Clicks & Sent</option>
<option value="2" <?= @$_GET['manual_insert']=='2'?'selected="selected"':'' ?>>Only Clicks</option>
</select>
@else
<select id="type" onchange="window.location.href = '?type='+this.options[this.selectedIndex].value + 
(document.getElementById('filterdate').value=='0'?'':'&filterdate='+document.getElementById('filterdate').value)
">
<option value="0">View All</option>
<option value="2" <?= @$_GET['type']=='2'?'selected="selected"':'' ?>>WhatsApp Requests</option>
<option value="1" <?= @$_GET['type']=='1'?'selected="selected"':'' ?>>Form Requests</option>
</select>
@endif

<select id="filterdate" onchange="window.location.href = '?filterdate='+this.options[this.selectedIndex].value + 
@if($route=="admin.whatsapp_msg")
(document.getElementById('manual_insert').value=='0'?'':'&manual_insert='+document.getElementById('manual_insert').value)
@else
(document.getElementById('type').value=='0'?'':'&type='+document.getElementById('type').value)
@endif
">

<option value="0">All Time</option>
<option value="today" <?= @$_GET['filterdate']=='today'?'selected="selected"':'' ?>>Today</option>
<option value="yesterday" <?= @$_GET['filterdate']=='yesterday'?'selected="selected"':'' ?>>Yesterday</option>
<option value="last7days" <?= @$_GET['filterdate']=='last7days'?'selected="selected"':'' ?>>Last 7 Days</option>
<option value="last15days" <?= @$_GET['filterdate']=='last15days'?'selected="selected"':'' ?>>Last 15 Days</option>
<option value="thismonth" <?= @$_GET['filterdate']=='thismonth'?'selected="selected"':'' ?>>Current Month</option>
<option value="lastmonth" <?= @$_GET['filterdate']=='lastmonth'?'selected="selected"':'' ?>>Last Month</option>
</select>

			@if($route=="admin.whatsapp_msg")
            <select id="trackingFilter">
                <option value="all">All rows</option>
                <option value="with" selected>Tracking Data</option>
                <option value="none">No Tracking Data</option>
            </select>
            <span id="trackingCount"></span>
            @endif

		
            @if(  (Auth::user()->is('superadmin') or Auth::user()->id==22) and Route::currentRouteName()=='admin.whatsapp_msg' )
                <a href="<?= route("admin.whatsapp_msg.download"); ?>" class="btn btn-default btn-sm"><i class="fa fa-download"></i> Export GCLIDs</a>
                
            @endif

            @if( Route::has("$route.create") )
                <a href="<?= route("$route.create",@$r->id); ?>" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i> Add New</a>
            @endif
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
        <table id="messagesTable" class="table table-bordered table-hover">
            <thead>
                <tr>
					
                    <th>NO</th>
                    <?php $i = 0 ?>
                    @foreach($lignes as $kth => $th)
                        <?php if ( !$th ) continue; ?>
                        <th style="<?php if($i===0){echo("width: 150px");} ?>">
                            @if($route=="admin.whatsapp_msg" && $kth=="navigation")
                                <a href="#" id="sortTracking">Tracking ↕</a>
                            @else
                                <a href="?field=<?= @explode("|", $kth)[0]; ?>&sort=<?= $page_sort; ?>&page=<?= $page_num; ?><?= @$get_params; ?>">{{ $th }}</a>
                            @endif
                        </th>
                        <?php $i++ ?>
                    @endforeach
                    @if($tr_placement)<th style="width:130px;">Arrange items</th>@endif
                    <td style="width: 250px">Notes</td>
                    <th style="width:90px;"><input class="checkall" type="checkbox"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $krow => $row)
                <tr class="<?= $row->blocked == 1 ? "bg-danger" : ""; ?>" @if($route=="admin.whatsapp_msg" and $row->manual_insert=="0") style="background-color:#2ecc717d" @endif>
                
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
								<a href="https://<?= $row->ccountry=='oman'?'oman.':'' ?>crm.damas.net/app/leads/{{ $row->$key }}/edit" target="_blank">{{ $row->$key }}</a>
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
								
								</div>
								@elseif($key=="navigation")
								<?php
								$duration = 0;
								$trackingArr = [];
								$navigation = explode('>>', $row->navigation);
								if($navigation[0] === ''){
								    $resultMsg = 'No Tracking Data';
								}
								else {
    								foreach($navigation as $index => $pair){
    								    if($index === (count($navigation) - 1)) continue;
    								    $pairArr = explode(':', $pair);
    								    $pairArr[0] = '<a href="https://damas.net'.$pairArr[0].'" target="_blank">'.$pairArr[0].'</a>';
    								    $time = intval(explode(':', $navigation[$index+1])[1]) - intval($pairArr[1]);
    								    $pairArr[1] = "<b>" . formatDuration($time) . "</b>";
    								    $duration += intval($time);
    								    array_push($trackingArr, $pairArr[0] . ': ' . $pairArr[1]);
    								}
    								$resultMsg = "Total Duration: <b>".formatDuration($duration)."</b>\n" . implode("\n", $trackingArr);
								}
								?>
								    <script>console.log(<?= json_encode($row) ?>)</script>
                                    <div class="tracking-data"
                                    data-duration="{{ $duration }}"
                                    data-has-tracking="{{ count($trackingArr) > 0 ? '1' : '0' }}"
                                    style="
                                        min-width:250px;
                                        max-width:450px;
                                        max-height:200px;
                                        overflow:auto;
                                        white-space:pre-wrap;
                                        overflow-wrap:anywhere;
                                    "><?= $resultMsg ?></div>
                                    <br>
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
								@elseif($key=="tags")
								<?php
                                $sourceTags = json_decode($row->tags, true);
                                $utmSource = trim((string) ($sourceTags['utm_source'] ?? ''));
                                ?>
									<div style="direction:ltr;text-align:center" class="nobreak">
								    @if($utmSource !== '')
                                        {{ $utmSource }}
									@elseif(strpos(strtolower($row->src), 'ampproject') !== false)
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
									@if($route=="admin.whatsapp_msg" && $row->code!='')
										
										, <a href="https://<?= $row->crm=='oman'?'oman.':''  ?>crm.damas.net/app/leads/{{ $row->code }}/edit" target="_blank">{{ $row->code }}</a>
										
									@endif
									<br/>
									<?php
									if(Auth::user()->is('superadmin'))
									if($row->$key!=''){
									$ts = json_decode($row->$key,true);
									
									if(!isset($ts['utm_content']) ){
									foreach($ts as $ke => $va)
									if($ke!='gclid' && $ke!='sHTTP_REFERER' && $ke!='sREQUEST_URI' && $ke!='gad_source' && $ke!='gad_campaignid' && $ke!='gbraid'){
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
								    @if($row->gclid!=null)
								    <button style="display: inline;font-size: 10px;height: fit-content;color:#fff;" class="btn btn-default copy-gclid">GCLID</button>
								    <script>
								        [...document.querySelectorAll('.copy-gclid')].forEach(curr => {
								            curr.addEventListener("click", () => {
								                if(curr.classList[curr.classList.length-1] !== 'clicked'){
    								                navigator.clipboard.writeText('<?= $row->gclid ?>');
    								                curr.textContent = 'Copied!';
    								                curr.classList.add('clicked');
    								                setTimeout(() => curr.textContent = 'GCLID', 2000);
    								            }
								            });
								        });
								    </script>
								    @endif
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
								@elseif($key=="country")
                                    <span class="fi fi-{{ strtolower($row->country) }}" style="font-size:2em;"></span><br>
                                    {{ Helper::code_to_country($row->country) }} <br>
                                    {{ $row->mobile }}
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
									<br>
									<b><?= date("j M Y", strtotime($row->created_at)) ?><br></b><?= date("h:i:s a", strtotime($row->created_at)) ?></div>
                                @else
                                    <?= $row->$key; ?>
                                @endif
                            </td>
                        @endif                    
                    @endforeach
                    <td class="notes" id="<?= $row->id ?>">
                        <div contenteditable="true" style="width:230px;min-height:50px;height:100%;background-color:#fff;text-align: right;" class="note" dir="rtl"></div>
                        <button class="btn btn-default note-save" style="display: inline;font-size: 12px; margin-top: 10%;color:#fff">Save</button>
                    </td>
                    <td class="text-center">
					<input type="checkbox" value="<?= $row->id; ?>" class="input_check">
					
                        @if( Route::has("$route.edit") )
                            <a href="<?= route("$route.edit", $row->id); ?>" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
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
        <div class="row flexParent">

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
    
    
[...document.querySelectorAll('.note')].forEach(curr => {
    curr.addEventListener('input', () => curr.parentElement.querySelector('.note-save').textContent = 'Save')
    curr.textContent = localStorage.getItem(curr.parentElement.id) ?? ''; 
});
[...document.querySelectorAll('.note-save')].forEach(curr => {
    curr.addEventListener("click", () => {
        localStorage.setItem(curr.parentElement.id, curr.parentElement.querySelector('.note').textContent);
        curr.textContent = 'Saved!';
        setTimeout(() => curr.textContent = 'Save', 2000);
    });
});

					        
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
            if (!$('.input_check:checked').length) {
                bootbox.alert('Select at least one row first.');
                return false;
            }
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
    
    const trackingFilter = document.getElementById('trackingFilter');
    if (trackingFilter) {
        const table = document.getElementById('messagesTable');
        const tbody = table.querySelector('tbody');
        const allTrackingRows = Array.from(tbody.children);
        let trackingAscending = true;
        document.getElementById('sortTracking').addEventListener('click', function (event) {
            event.preventDefault();
            function getDuration(row) {
                const tracking = row.querySelector('.tracking-data');
                if (!tracking || tracking.dataset.hasTracking !== '1') return null;
                const duration = Number(tracking.dataset.duration);
                return Number.isFinite(duration) && duration >= 0 ? duration : null;
            }
            allTrackingRows.sort((a, b) => {
                const aDuration = getDuration(a);
                const bDuration = getDuration(b);
                if (aDuration === null && bDuration === null) return 0;
                if (aDuration === null) return 1;
                if (bDuration === null) return -1;
                return trackingAscending ? aDuration - bDuration : bDuration - aDuration;
            });
            this.textContent = trackingAscending ? 'Tracking ↑' : 'Tracking ↓';
            trackingAscending = !trackingAscending;
            applyTrackingFilter();
        });
        function clearTrackingSelection() {
            const checkboxes = $(allTrackingRows).find('.input_check').add($(table).find('.checkall'));
            checkboxes.each(function () {
                if ($.fn.iCheck && $(this).data('iCheck')) {
                    $(this).iCheck('uncheck');
                }
                this.checked = false;
                this.indeterminate = false;
            });
        }
        function applyTrackingFilter() {
            clearTrackingSelection();
            const filter = trackingFilter.value;
            const matchingRows = allTrackingRows.filter(row => {
                const tracking = row.querySelector('.tracking-data');
                const hasTracking = tracking?.dataset.hasTracking === '1';
                if (filter === 'with') return hasTracking;
                if (filter === 'none') return !hasTracking;
                return true;
            });
            $(allTrackingRows).detach();
            matchingRows.forEach(row => tbody.appendChild(row));
            document.getElementById('trackingCount').textContent =
                matchingRows.length + ' / ' + allTrackingRows.length + ' loaded rows';
        }
        trackingFilter.addEventListener('change', applyTrackingFilter);
        applyTrackingFilter();
    }
    
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
