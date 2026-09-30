<?php
    $route = Route::currentRouteName();
    $isPostList = \App\Enums\PostType::isAdminList($route);
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
-ms-hyphens: auto;
-moz-hyphens: auto;
-webkit-hyphens: auto;
hyphens: auto;
}
</style>
<div class="box">

@if(Route::currentRouteName()=='admin.search')
<?php
$str_get = '';
foreach($_GET as $k=>$v)
$str_get = $str_get . $k.'='.$v.'&';
?>
<div class="panel with-nav-tabs pane88l-default">
    <div class="panel-heading lang-heading">
<ul class="nav nav-tabs">
<li <?= $_GET['lang']=='ar'?'class="active"':'' ?>><a href="?<?= str_replace(['lang=en','lang=fr','lang=pe','lang=ru'],'lang=ar',$str_get) ?>" >Arabic</a></li>
<li <?= $_GET['lang']=='en'?'class="active"':'' ?>><a href="?<?= str_replace(['lang=ar','lang=fr','lang=pe','lang=ru'],'lang=en',$str_get) ?>" >English</a></li>
<li <?= $_GET['lang']=='fr'?'class="active"':'' ?>><a href="?<?= str_replace(['lang=ar','lang=en','lang=pe','lang=ru'],'lang=fr',$str_get) ?>" >French</a></li>
<li <?= $_GET['lang']=='pe'?'class="active"':'' ?>><a href="?<?= str_replace(['lang=ar','lang=en','lang=fr','lang=ru'],'lang=pe',$str_get) ?>" >Perian</a></li>
<li <?= $_GET['lang']=='ru'?'class="active"':'' ?>><a href="?<?= str_replace(['lang=ar','lang=en','lang=fr','lang=pe'],'lang=ru',$str_get) ?>" >Russian</a></li>
</ul>
    </div>
</div>

@endif
    <div class="box-header with-border">
		@if(Route::currentRouteName()=='admin.whatsapp_msg' || Route::currentRouteName()=='admin.search')
            <div class="col-md-3">
                <div class="input-group">
                    <select name="action" id="selectAction" class="form-control" style="height:28px;line-height: 1px;padding: 3px 10px;">
                        <option value="">Bulk Actions</option>
                        <option value="delete">Delete</option>
                    </select>
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-primary btn-flat" id="btnAction" style="border-radius:0;padding: 3px 15px">Apply</button>
                    </span>
                </div>
            </div>
			<div class="col-md-9 text-left">
                <?= $rows->appends(Input::except('page'))->render(); ?>
            </div>
		@else
        <h3 class="box-title"><?= @$box_title ?></h3>
		@endif
		@if($isPostList)
    		<ul class="nav nav-tabs" style="margin-bottom:15px;">
                @foreach($countries as $country)
                <li class="<?= $tab == $country->code ? 'active' : '' ?>">
                    <a href="?tab=<?= $country->code ?>"><?= $country->name_en ?> (<?= isset($countryCounts[$country->code]) ? $countryCounts[$country->code] : 0 ?>)</a>
                </li>
                @endforeach
                <li class="<?= $tab == 'disabled' ? 'active' : '' ?>">
                    <a href="?tab=disabled">Disabled (<?= $disabledCount ?>)</a>
                </li>
            </ul>
		@endif

        <div class="box-tools">
            @if($isPostList or Route::currentRouteName()=='admin.pages.search')
                <input type="date" id="gsc-start-date" min="2017-01-01">
                –
                <input type="date" id="gsc-end-date" min="2017-01-01">
                <script>
                    const today = new Date().toISOString().split('T')[0];
                    let yesterday = new Date();
                    yesterday.setDate(yesterday.getDate() - 1);
                    yesterday = yesterday.toISOString().split('T')[0];
                    document.getElementById('gsc-start-date').max = today;
                    document.getElementById('gsc-end-date').max = today;
                    document.getElementById('gsc-start-date').value = yesterday;
                    document.getElementById('gsc-end-date').value = today;
                </script>
                <button class="btn btn-primary" onclick="connectGoogle()">Connect GSC</button>
            @endif
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
			@if( Route::currentRouteName()=='admin.projects' || Route::currentRouteName()=='admin.newsletter' || $isPostList || Route::currentRouteName()=='admin.faqpost2' )
				<form method="get" style="float:right">
                    @if(isset($tab))
                    <input type="hidden" name="tab" value="<?= $tab ?>">
                    @endif
                    <input type="text" name="search" value="<?= @$_GET['search'] ?>">
                    <input type="submit" class="btn" value="search">
                </form>
			@endif

            @if(  (Auth::user()->is('superadmin') or Auth::user()->id==22) and Route::currentRouteName()=='admin.whatsapp_msg' )
                <a href="<?= route("admin.whatsapp_msg.download"); ?>" class="btn btn-default btn-sm"><i class="fa fa-download"></i> Download data for Google Ads</a>
            @endif
			

            @if( Route::has("$route.create") )
				@if(Route::currentRouteName()=='admin.faqpost2' )
				<a href="<?= route("$route.create",@$id); ?>" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i> .Add New</a>
				@else
                <a href="<?= route("$route.create",@$r->id); ?>" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i> Add New</a>
				@endif
            @endif
            @if($total_rows>10)
                <div class="pull-left" style="margin-right:10px;display:flex;flex-direction:row;">
                    <p style="width:210px;margin:0 10px 0 0;padding-top: 5px;">Rows per page:</p> 
                    <?php $arr_nmbre = [10, 20, 40, 60, 100, 1000]; ?>
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
                            @if(in_array($kth, ['blog_impressions', 'blog_clicks', 'blog_ctr', 'blog_pos']))
                                <a href="#" class="gsc-sort" data-field="{{ $kth }}" data-sort="desc">
                                    {{ $th }}
                                </a>
                            @elseif($kth === 'word_count')
                                {{ $th }}
                            @else
                                <a href="?field=<?= @explode("|", $kth)[0]; ?>&sort=<?= $page_sort; ?>&page=<?= $page_num; ?><?= @$get_params; ?><?= isset($_GET['lang'])?'&lang=' . $_GET['lang']:'' ?>">{{ $th }}</a>
                            @endif
                        </th>
                    @endforeach
                    @if($tr_placement)<th style="width:130px;">Arrange items</th>@endif
                    <th style="width:100px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $krow => $row)
                <tr class="<?= $row->blocked == 1 ? "bg-danger" : ""; ?>" @if($route=="admin.whatsapp_msg" and $row->manual_insert=="0") style="background-color:#2ecc717d" @endif @if($isPostList and $row->published==false and (int)$row->redirect_post_id!=0) style="background-color:#b2ecec" @endif >
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
                            <td>
                                @if($find_row)
                                    {{ $field ? $find_row->$field : $find_row->name_en }}
                                @endif
                            </td>
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

								
								echo '<a href="'.strtok($row->page, "?") .'" target="_blank">'. htmlspecialchars($lnk) .'</a>';
								
								?>
								</div>
                                @elseif($route=="admin.videos" and $key=='section')
									<?php
									$secs = $row->sections;//->lists('sectionvideo_id')->toArray();
									//echo '<h1>' . count($secs) . '</h1>';
									
									foreach($secs as $sec)
										echo htmlspecialchars($sec->title_en) . '<br>';

									?>
                                @elseif($route=="admin.videos" and $key=='project')
									<?php
									$secs = $row->projects;//->lists('sectionvideo_id')->toArray();
									//echo '<h1>' . count($secs) . '</h1>';
									
									foreach($secs as $sec)
										echo htmlspecialchars($sec->title_en) . '<br>';

									?>
								@elseif($route=="admin.newlandingpage" and $key=='title')
									<a href="{{ route('front.landing.newlandingpage',$row->slug) }}" target="_blank">{{ $row->$key }}</a>
                                @elseif($route=="admin.projects" and $key=='name_en')
									<a href="{{ $row->frontUrl() }}" target="_blank">{{ $row->$key }}</a>
								@elseif($key=="link" and $route=="admin.pages.search")
                                    <a href="{{ $row->link }}" target="_blank" class="gsc-link">
                                        {{ $row->link }}
                                    </a>
								@elseif($key=="search_pages_impressions")
								    <p class="impressions"></p>
								@elseif($key=="search_pages_clicks")
								    <p class="clicks"></p>
								@elseif($key=="search_pages_ctr")
								    <p class="ctr"></p>
								@elseif($route=="admin.projectcategory" and $key=='feature_slug')
								    {{$row->slug}}
                                @elseif($route=="admin.landingpage" and $key=='name')
									<?php $langs = explode(',',$row->lang);
									foreach($langs as $ln){ ?>
									<a href="https://www.damas.net/<?= ($ln=='ar'?'':$ln.'/') ?>landing/<?= $row->slug ?>" target="_blank">
                                        {{ $row->project->title_en  }} - {{ ucfirst($ln) }}
                                    </a><br>
									<?php } ?>
                                @elseif($route=="admin.landing2" and $key=='title_en')
									{{ ($row->title_en!=''?$row->title_en:($row->title_ar!=''?$row->title_ar:($row->title_fr!=''?$row->title_fr:($row->title_ru!=''?$row->title_ru:$row->title_pe))))  }} 
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
									elseif($ln=='ru')
										echo $row->views_ru.'<br>';
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
                                @elseif($route=="admin.competitors" and $key=="name")
									<a href="<?= route("admin.competitors")."?competitor=$row->id"; ?>" >
                                        {{ $row->$key }}
                                    </a>
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
									
									if(!empty($w_w)){
									foreach($w_w as $sc=>$sv){
									if($sc == $row->lastcountry){
									?>
									{{ Helper::code_to_country($sc) }}({{ $sv }}) <br>
									<?php }}
									
									foreach($w_w as $sc=>$sv){
									if($sc != $row->lastcountry){
										?>
									{{ Helper::code_to_country($sc) }}({{ $sv }}) <br>
									<?php }}

									}
									?>
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
                                @elseif($route=="admin.projects" and $key=="region_id")
								<?php
								// if($row->payment_method=='تقسيط')
								// 	echo 'Installment';
								// elseif($row->payment_method=='نقدي')
								// 	echo 'Cash';
								echo \DB::table('regions')->where('id', $row->region_id)->value('name_en') ?? '';
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
                                @elseif($isPostList and $key=="prevent_archiving_in_blog")
								<?php
									echo ($row->prevent_archiving_in_blog==true?'NO':'');
								?>
                                @elseif($isPostList and $key=="category_id")
									{{ implode(',', $row->categories()->lists('name_en')->toArray()) }}
								@elseif($isPostList and $key=="update_date")
								{{ $row->update_date }}
								<?= ($row->update_by_name!=''?"<br>".$row->update_by_name:'') ?>
								@elseif($isPostList and $key=="title_ar")
									#<?= $row->countryRel ? ucfirst($row->countryRel->code) : '' ?><br>
									<a href="{{ $row->frontUrl() }}" target="_blank" class="gsc-link">{{ ($row->title_ar!=''?$row->title_ar:($row->title_en!=''?$row->title_en:($row->title_fa!=''?$row->title_fa:($row->title_ru!=''?$row->title_ru:'')))) }}</a>
								@elseif($isPostList and $key=="blog_impressions")
								    <p class="impressions"></p>
								@elseif($isPostList and $key=="blog_clicks")
								    <p class="clicks"></p>
								@elseif($isPostList and $key=="blog_ctr")
								    <p class="ctr"></p>
								@elseif($isPostList and $key=="blog_pos")
								    <p class="position"></p>
								@elseif($key === 'word_count')
                                    <?php $wordCountLanguages = ['ar' => 'Ar', 'en' => 'En', 'fr' => 'Fr', 'fa' => 'Fa', 'ru' => 'Ru']; ?>
                                    @foreach($wordCountLanguages as $wordCountLang => $wordCountLabel)
                                        <?php
                                            $wordCountField = 'content_' . $wordCountLang;
                                            $wordCountHtml = (string) $row->$wordCountField;
                                        ?>
                                        @if(trim($wordCountHtml) !== '')
                                            <?php
                                                $wordCountText = html_entity_decode($wordCountHtml, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                                $wordCountText = preg_replace('~<div\b[^>]*\bid\s*=\s*(["\'])sconnect-is-installed\1[^>]*>.*?</div\s*>~is', ' ', $wordCountText);
                                                $wordCountText = preg_replace('~<(script|style)\b[^>]*>.*?</\1\s*>~is', ' ', $wordCountText);
                                                $wordCountText = preg_replace('~</?(?:p|div|br|hr|li|ul|ol|h[1-6]|table|tr|td|th|section|article|blockquote)\b[^>]*>~i', ' ', $wordCountText);
                                                $wordCountText = html_entity_decode(strip_tags($wordCountText), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                                $wordCount = preg_match_all('~[^\s\p{Z}]*[\p{L}\p{N}][^\s\p{Z}]*~u', $wordCountText);
                                            ?>
                                            <div style="white-space: nowrap;">{{ $wordCountLabel }}: {{ $wordCount === false ? '—' : number_format($wordCount) }}</div>
                                        @endif
                                    @endforeach
								@elseif($isPostList and $key=="lang")
									<?= $row->content_ar!=''?'Ar ':''; ?>
									<?= $row->content_en!=''?'En ':''; ?>
									<?= $row->content_fr!=''?'Fr ':''; ?>
									<?= $row->content_fa!=''?'Pe':''; ?>
									<?= $row->content_ru!=''?'Ru':''; ?>
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
					
					
                        @if( $route=="admin.faqpost")
                            <a href="<?= route("admin.faqpost2", $row->id); ?>" class="btn btn-primary btn-xs" title="list"><i class="fa fa-list" style="color:#fff"></i></a>
                        @endif
						<?php
						$andco = '';
						if( $route=="admin.faqpost2")
							$andco = '?category='.$row->faq_post;
						?>
                        @if( Route::has("$route.edit") )
                            <a href="<?= route("$route.edit", $row->id) . $andco; ?>" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
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
							
							@if( $route!="admin.landing2")
                        <button data-lang="<?= $row->lang; ?>" data-slug="<?= $row->slug; ?>" data-id="<?= $row->id; ?>" class="btn btn-info btn-xs button_refresh_cache" title="Cache Update"><i class="fa fa-refresh"></i></button>
	
							@endif
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

			@if(Route::currentRouteName()!='admin.whatsapp_msg'  && Route::currentRouteName()!='admin.search')
            <div class="col-md-3">
                <div class="input-group">
                    <select name="action" id="selectAction" class="form-control">
                        <option value="">Bulk Actions</option>
                        <option value="delete">Delete</option>
                    </select>
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-primary btn-flat" id="btnAction" style="border-radius:0;">Apply</button>
                    </span>
                </div>
            </div>

            <div class="col-md-9 text-left">
                <?php
				$iapg = Input::except('page');
				if(isset($_GET['search']))
					$iapg['search'] = $_GET['search'];
				
				echo $rows->appends($iapg)->render(); ?>
            </div>
			@endif
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
<script src="https://accounts.google.com/gsi/client" async defer onload="initGoogleAuth()"></script>

<script>
console.log([...document.querySelectorAll(".gsc-link")].map(curr => curr.href));
    
let tokenClient;
let googleAccessToken = null;


function initGoogleAuth() {
    tokenClient = google.accounts.oauth2.initTokenClient({
        client_id: '424156267069-20nnlvdq22upvnug3bcjbtc5fvmn8ggo.apps.googleusercontent.com',
        scope: 'https://www.googleapis.com/auth/webmasters.readonly',
        callback: async (response) => {
            googleAccessToken = response.access_token;
            let loadedLinks = [...document.querySelectorAll(".gsc-link")].map(curr => {
                return {
                    impressions: curr.closest('tr').querySelector('.impressions'),
                    clicks: curr.closest('tr').querySelector('.clicks'),
                    ctr: curr.closest('tr').querySelector('.ctr'),
                    position: curr.closest('tr').querySelector('.position'),
                    href: curr.href
                }
            });
            console.log(loadedLinks);
            for(let link of loadedLinks){
                link.impressions.textContent = "Fetching...";
                link.clicks.textContent = "Fetching...";
                link.ctr.textContent = "Fetching...";
                link.position.textContent = "Fetching...";
                let response = await testGoogleFetch(link.href);
                if (response?.rows?.length) {
                    link.impressions.textContent = response.rows[0].impressions;
                    link.clicks.textContent = response.rows[0].clicks;
                    link.ctr.textContent = (Number(response.rows[0].ctr) * 100).toFixed(2) + "%";
                    link.position.textContent = Number(response.rows[0].position).toFixed(2);
                } else {
                    link.impressions.textContent = 0;
                    link.clicks.textContent = 0;
                    link.ctr.textContent = 0;
                    link.position.textContent = 0;
                }
            }
        }
    });
}

function connectGoogle() {
    if (!tokenClient) {
        console.log('Google OAuth is still loading');
        return;
    }

    tokenClient.requestAccessToken();
}

async function testGoogleFetch(link) {
    const body = {
        startDate: document.getElementById('gsc-start-date').value,
        endDate: document.getElementById('gsc-end-date').value,
        dimensions: ['page'],
        rowLimit: 25000,
        dimensionFilterGroups: [
            {
                filters: [
                    {
                        dimension: 'page',
                        operator: 'equals',
                        expression: link
                    }
                ]
            }
        ]
    };

    try {
        const response = await fetch(
            'https://www.googleapis.com/webmasters/v3/sites/' +
            encodeURIComponent('sc-domain:damas.net') +
            '/searchAnalytics/query',
            {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + googleAccessToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(body)
            }
        );

        const data = await response.json();
        console.log(data);
        return data;
    } catch (error) {
        console.error(error);
    }
}
document.querySelectorAll('.gsc-sort').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();

        const field = this.dataset.field;
        const direction = this.dataset.sort;

        const classMap = {
            blog_impressions: 'impressions',
            blog_clicks: 'clicks',
            blog_ctr: 'ctr',
            blog_pos: 'position'
        };

        const className = classMap[field];

        const tbody = document.querySelector('table tbody');
        const rows = [...tbody.querySelectorAll('tr')];

        rows.sort((a, b) => {
            const aValue = parseFloat(
                a.querySelector('.' + className)?.textContent
            ) || 0;

            const bValue = parseFloat(
                b.querySelector('.' + className)?.textContent
            ) || 0;

            return direction === 'asc'
                ? aValue - bValue
                : bValue - aValue;
        });

        rows.forEach(row => tbody.appendChild(row));

        this.dataset.sort = direction === 'asc' ? 'desc' : 'asc';
    });
});
</script>