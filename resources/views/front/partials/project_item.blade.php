<?php
//Helper::get_project_flavors(1);
$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
$current_lang = LaravelLocalization::getCurrentLocale();
$is_mobile = Helper::is_mobile() || Helper::is_tablet();
$infos = Helper::get_params();
$flavor = array();
if (/* Route::currentRouteName()!='front.search' and */ session()->get("filter_rooms") != '') {
    list($salon, $room) = explode('_', session()->get("filter_rooms"));


    $flavors = $project->flavors;

    foreach ($flavors as $f) {
        if ($f->room == $room and $f->salon == $salon and $f->sold_out == false) {
            $flavor = $f;
            break;
        }
    }


    if (empty($flavor)) {
        $arr_rooms = array('1_0', '1_1', '1_2', '1_3', '1_4', '1_5', '2_3', '2_4', '2_5', '2_6');
        $arr_s_r = array();
        foreach ($arr_rooms as $r) {
            if ($r == session()->get("filter_rooms"))
                break;
            $arr_s_r[] = $r;
        }

        $arr_s_r = array_reverse($arr_s_r);

        foreach ($flavors as $f) {
            if ($f->sold_out == false) {
                foreach ($arr_s_r as $r_s_r) {
                    if ($f->salon . '_' . $f->room == $r_s_r) {
                        $flavor = $f;
                        break;
                    }
                }
            }
        }
    }
}

if (empty($flavor)) {
    $flavors = $project->flavors();
    $flavors = $flavors->where('sold_out', false); //عدم عرض سعر الشقق المباعة 
    $flavor = $flavors->orderBy("price", "ASC")->first();

    if (empty($flavor)) {
        $flavors = $project->flavors();
        $flavor = $flavors->orderBy("price", "ASC")->first();
    }
}

$projects_flavors = $project->flavors;

$open_blank = @$open_blank ? true : false;
$cardphoto = @$project->cardphoto;
/*if(!$cardphoto){
	$cardphoto = @$project->projectPhotos[0];
}*/

//$is_mobile = @$is_mobile;
$project_min_price = Helper::decimal_format(@$flavor->price, $project->is_price_usd);
/*
  ?>







  <div class="project-card <?= isset($class) ? $class : '' ?>"  <?= isset($proj_shema) ? ' property="itemListElement" typeof="ListItem"' : '' ?>>
  <?= isset($proj_shema) ? '<span class="hidden" property="position">' . $pos . '</span>' : '' ?>
  <div class="share project-social">
  <i class="flaticon-share cshare"></i>

  <a href="#" class="likeCardItem" data-url="<?= route("front.likeitem"); ?>"
  data-typ="project" data-code="<?= $project->id; ?>">
  <i class="fa fa-heart-o"></i><!--<i class="fa fa-heart"></i>--></a>

  <span class="pull-right social shareBtnsFloating" data-url="<?= $project->frontUrl(); ?>" data-text="<?= $project->getName(); ?>">
  <a href="#" class="btnshare" data-network="facebook"><i class="fa fa-facebook"></i></a>
  <a href="#" class="btnshare" data-network="whatsapp"><i class="fa fa-whatsapp"></i></a>
  </span>

  <?php
  $project_name_en = $project->name_en;
  preg_match_all('!\d+!', $project_name_en, $matches);
  $id_num = $matches[0][0];
  $id_text = str_replace($id_num, '', $project_name_en);
  ?>
  <div class="d105"  <?= isset($proj_shema) ? ' property="name"' : '' ?>><b><?= $id_text ?></b><span><?= $id_num ?></span></div>

  </div>
  <div class="contain" id="container" <?php if ($is_mobile) { ?> data-url="<?= $project->frontUrl(); ?>"<?php } ?>>
  <div class="image-project">
  <a href="<?= $project->frontUrl(); ?>" <?= $open_blank == true ? 'target="_blank"' : ''; ?> <?= isset($proj_shema) ? ' property="url"' : '' ?>>

  <?php
  $iw = 360;
  $ih = 280;
  if (!$is_mobile) {
  if (isset($page) and $page == 'index') {
  $iw = 360;
  $ih = 196;
  } else {
  $iw = 384;
  $ih = 171;
  }
  } else {
  if (isset($page) and $page == 'index') {
  $iw = 360;
  $ih = 282;
  } else {
  $iw = 363;
  $ih = 258;
  }
  }

  ?>
  {!! Helper::get_pic(Helper::get_thumbnail($cardphoto, $iw, $ih),(isset($ajax) and $ajax==true)?'img-responsive':'lazyimg img-responsive','','',(isset($cardphoto)?$cardphoto->getTitle():''), isset($proj_shema)?' property="image"':'') !!}
  </a>
  </div>
  <?php list($sclass, $slab) = $project->getStatus(); ?>


  @if($current_lang=='ar')
  <div class="title-project">
  @if($sclass!='resale')
  <div class="start">
  {{ trans("front.start") }}</div>



  @if(@$flavor->salon==0 and @$flavor->room==0)
  @else
  <button class="bed">
  <img src="<?= asset("img/bed.svg"); ?>" alt="Damas">
  <!--                <i class="flaticon-bed3"></i>-->
  <span><?= @$flavor->salon . "+" . @$flavor->room; ?></span>

  <ul class="dropdown-menu hidden">
  <?php
  foreach ($project->flavors as $f) {
  //if($f->observation!='مباع' and $f->salon.'_'.$f->room != @$flavor->salon."_".@$flavor->room){
  ?>
  <li><a data-val="<?= $f->salon . '_' . $f->room ?>" href="javascript:;"><?= $f->salon . '+' . $f->room ?></a></li>
  <?php } //}  ?>
  </ul>
  </button>
  @endif


  <div class="start">
  {{ trans("front.from") }}</div>


  @if(strlen($project_min_price)>8)
  <div class="price smlprice">
  {!! ' <strong>'. Helper::curr_format() .'</strong> '. $project_min_price  !!}
  </div>
  @else
  <div class="price">
  {!! ' <strong>'. Helper::curr_format() .'</strong> '. $project_min_price  !!}
  </div>
  @endif

  <?php
  //price to show when change beds select
  //Helper::decimal_format(@$flavor->price,$project->is_price_usd)
  foreach ($project->flavors as $f) {
  ?>
  <div class="price smlprice tpp<?= $f->salon . '_' . $f->room ?> hidden">
  {!! " <strong>". Helper::curr_format() ."</strong> " . Helper::decimal_format($f->price,$project->is_price_usd) !!}
  </div>
  <?php } ?>


  @endif
  </div>
  @else
  <div class="title-project">
  @if($sclass!='resale')
  <div class="start">{{ trans("front.start") }}</div>






  @if(@$flavor->salon==0 and @$flavor->room==0)
  @else
  <button class="bed"><i class="flaticon-bed3"></i><span><?= @$flavor->salon . "+" . @$flavor->room; ?></span>
  <!--<img src="<?= asset("img/bed.svg"); ?>" alt="Damas">-->
  <!--                <i class="flaticon-bed3"></i>-->
  <span><?= @$flavor->salon . "+" . @$flavor->room; ?></span>

  <ul class="dropdown-menu hidden">
  <?php
  foreach ($project->flavors as $f) {
  //if($f->observation!='مباع' and $f->salon.'_'.$f->room != @$flavor->salon."_".@$flavor->room){
  ?>
  <li><a data-val="<?= $f->salon . '_' . $f->room ?>" href="javascript:;"><?= $f->salon . '+' . $f->room ?></a></li>
  <?php } //}   ?>
  </ul>
  </button>
  @endif


  <div class="start">
  {{ trans("front.from") }}</div>

  @if(strlen($project_min_price)>8)
  <div class="price smlprice">
  {!! ' <strong>'. Helper::curr_format() .'</strong> '. $project_min_price  !!}
  </div>
  @else
  <div class="price">
  {!! ' <strong>'. Helper::curr_format() .'</strong> '. $project_min_price  !!}
  </div>
  @endif

  <?php
  //price to show when change beds select
  //Helper::decimal_format(@$flavor->price,$project->is_price_usd)
  foreach ($project->flavors as $f) {
  ?>
  <div class="price smlprice tpp<?= $f->salon . '_' . $f->room ?> hidden">
  {!! " <strong>". Helper::curr_format() ."</strong> " . Helper::decimal_format($f->price,$project->is_price_usd) !!}
  </div>
  <?php } ?>
  @endif
  </div>
  @endif
  <div style="clear:both"></div>
  <div class="about-project new-style">
  <?= $project->getIntroCard(); ?>
  </div>
  <div style="clear:both"></div>



  <?php
  if ($current_lang != 'en') {
  ?>
  <div class="info-project">

  <div class="status">
  <div class="<?= $sclass ?>">
  <div class="icon"></div>
  <p><?= $slab ?></p>
  </div>
  </div>
  <div class="key">
  <div >
  <i class="flaticon-room-key2"></i>
  <span><?= date("Y/m", strtotime($project->delivered_date)); ?></span>
  </div>

  </div>
  <div class="coin">
  <div>
  <i class="flaticon-coin2"></i>
  <span><?= trans('front.' . $project->payment_method); ?></span>
  </div>

  </div>
  </div>
  <?php
  } else {
  if (isset($class) and $class == "card-small") {
  ?>
  <div class="info-project">

  <div class="status">
  <?php list($sclass, $slab) = $project->getStatus(); ?>
  <div class="<?= $sclass ?>">
  <div class="icon"></div>
  <p><?= $slab ?></p>
  </div>
  </div>
  <div class="key">
  <div>
  <i class="flaticon-room-key2"></i>
  <span><?= date("Y/m", strtotime($project->delivered_date)); ?></span>
  </div>
  </div>
  <div class="coin">
  <div>
  <i class="flaticon-coin2"></i>
  <span><?= trans('front.' . $project->payment_method); ?></span>
  </div>
  </div>
  </div>
  <?php } else { ?>
  <div class="info-project">

  <div class="status">
  <?php list($sclass, $slab) = $project->getStatus(); ?>
  <div class="<?= $sclass ?>">
  <div class="icon"></div>
  <p><?= $slab ?></p>
  </div>
  </div>
  <div class="key">
  <i class="flaticon-room-key2"></i>
  <span><?= date("Y/m", strtotime($project->delivered_date)); ?></span>
  </div>
  <div class="coin">
  <i class="flaticon-coin2"></i>
  <span><?= trans('front.' . $project->payment_method); ?></span>
  </div>
  </div>
  <?php }
  }
  ?>
  <?php if (!$is_mobile) { ?>
  <div class="details"><a href="<?= $project->frontUrl(); ?>" <?= $open_blank == true ? 'target="_blank"' : ''; ?>  class="button"><?= trans('front.details') ?></a></div>
  <?php } ?>
  </div>
  </div>
  <?php */
?>









<div class="<?= isset($card_class)?$card_class:'item swiper-slide project_card' ?>">
    <div class="content sec shadow_type" <?= isset($proj_shema) ? ' property="itemListElement" typeof="ListItem"' : '' ?>>

		<?php if( (int)$project->cash_discount != 0 ){ ?>
        <a class="project_Id" href="<?= $project->frontUrl(); ?>">
            <span class="num"><?= $project->cash_discount ?>%OFF</span>
        </a>
		<?php } ?>
		
        <?php  if ($project->link_3d!='') { ?>
            <div class="icon_3d">
			<a href="<?= $project->frontUrl(); ?>#3d">
                <img width="30" height="20" src="<?= asset("/img/3d-floor-plans-icon.svg"); ?>" alt="3D Floor Plans"/>
			</a>
            </div>
        <?php  } ?>
		
        <div class="view_cont">
            <!-- image Project -->
            <div class="int_cont image show">
                <a href="<?= $project->frontUrl(); ?>" <?= $open_blank == true ? 'target="_blank"' : ''; ?> <?= isset($proj_shema) ? ' property="url"' : '' ?>
				
				title="{{ Helper::str_limit(nl2br(preg_replace("/[\r\n]+/", "", $project->getIntoLocation())),340) }}"
				>
                    <?php
                    $iw = 360;
                    $ih = 280;
                    //if (!$is_mobile) {
                        if (isset($page) and $page == 'index') {
                            $iw = 360;
                            $ih = 196;
                        } else {
                            $iw = 384;
                            $ih = 171;
                        }
                    
					$iximg_mob = Helper::get_thumbnail($cardphoto, $iw, $ih);
					//} else {
                        if (isset($page) and $page == 'index') {
                            $iw = 360;
                            $ih = 282;
                        } else {
                            $iw = 363;
                            $ih = 258;
                        }
                    //}
					$iximg_full = Helper::get_thumbnail($cardphoto, $iw, $ih);
                    ?>
                    <?php //{!! Helper::get_pic($iximg,(isset($ajax) and $ajax==true)?'img-responsive':'lazy img-responsive','','',(isset($cardphoto)?$cardphoto->getTitle():''), isset($proj_shema)?' property="image"':'') !!} ?>
                
				<picture>
					<source media="(min-width: 650px)" srcset="<?= $iximg_full ?>">
					<source media="(max-width: 650px)" srcset="<?= $iximg_mob ?>">
					<img src="<?= $iximg_full ?>" class="img-responsive" 
					loading="lazy" alt="{{  (isset($cardphoto)?$cardphoto->getTitle():'') }}" width="303" height="234">
				</picture>
				
				</a>
            </div>
            <!-- map Project -->
            <div class="int_cont map">

            </div>

            <?php
            $link_video = $project->getLinkVideo();
            if ($link_video != '') {
                parse_str(parse_url($link_video, PHP_URL_QUERY), $array_of_vars);
                ?>
                <div class="int_cont video">

                </div>
            <?php } ?>
        </div>
        <div class="control_sec">
            <!-- Price Project -->
            <div class="num">
                <p class="jazzira_font"><?= trans("front.starts from"); ?></p>
                @if(strlen($project_min_price)>8)
                {!! '<strong>'. Helper::curr_format() .'</strong> '. $project_min_price  !!}
                @else
                {!! '<strong>'. Helper::curr_format() .'</strong> '. $project_min_price  !!}
                @endif
            </div>

            <?php
            //price to show when change beds select
            //Helper::decimal_format(@$flavor->price,$project->is_price_usd)
            foreach ($projects_flavors as $f) { ?>
                <div class="num smlprice tpp<?= $f->salon . '_' . $f->room ?> hidden">
                    {!! "<strong>". Helper::curr_format() ."</strong> " . Helper::decimal_format($f->price,$project->is_price_usd) !!}
                </div>
            <?php } ?>

            <!-- image btn -->
            <div class="btn_style type_image active" rel="typeImage">
                <svg width="15" height="15" viewBox="0 0 16 16" id="941b7c6df16f1639c19993afa498088e"><path data-name="Image Icon copy 3" fill-rule="evenodd" d="M14 16H2a2 2 0 01-2-2V2a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2zm0-14H2v12h1.974l6.136-6.647a1.09 1.09 0 011.528-.086L14 9.373V2zm0 10.048l-3.023-2.7L6.687 14H14v-1.952zM6 8a2 2 0 112-2 2 2 0 01-2 2z"></path></svg>
            </div>
            <?php if ($link_video != '') { ?>
                <!-- video btn -->
                <div class="btn_style type_video" rel="typeVideo" data-video="<?= @$array_of_vars['v'] ?>">
                    <svg width="15" height="15" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 29.4 25" xml:space="preserve"><g> <path class="st0" d="M27.9,0H4.1H1.5C0.7,0,0,0.7,0,1.5v18.1c0,0.8,0.7,1.5,1.5,1.5h2.6H11V23H5c-0.3,0-0.5,0.2-0.5,0.5v1 C4.5,24.8,4.7,25,5,25h2.6h14.8c2.3,0,2.5-0.2,2.5-0.5v-1c0-0.3-0.2-0.5-0.5-0.5h-6v-1.9h9.5c0.8,0,1.5-0.7,1.5-1.5V1.5 C29.4,0.7,28.7,0,27.9,0z M27.5,18.9c0,0.2-0.2,0.4-0.4,0.4H2.2c-0.2,0-0.4-0.2-0.4-0.4V2.2C1.8,2,2,1.8,2.2,1.8h25 c0.2,0,0.4,0.2,0.4,0.4v16.7H27.5z"/> <path class="st0" d="M18.4,9.7L12,5.8c-0.7-0.4-1.5,0.1-1.5,0.9v7.8c0,0.8,0.9,1.3,1.5,0.9l6.4-3.9C19,11,19,10.1,18.4,9.7 L18.4,9.7z"/> </g> </svg>
                </div>
            <?php } ?>
            <!-- map btn -->
            <div class="btn_style type_map" rel="typeMap" data-coords="<?= $project->latitude; ?>,<?= $project->longitude; ?>">
                <svg width="15" height="15" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 15.5 20.4" xml:space="preserve"><g> <path class="st0" d="M7.7,0C3.5,0,0,3.5,0,7.7c0,1.8,1.2,4.3,3.6,7.6c1.7,2.4,3.4,4.3,3.5,4.4l0.6,0.7l0.6-0.7 c0.1-0.1,1.8-2,3.5-4.4c2.4-3.3,3.6-5.9,3.6-7.6C15.5,3.5,12,0,7.7,0L7.7,0z M7.7,17.9c-2.1-2.5-6-7.6-6-10.2c0-3.3,2.7-6,6-6 s6,2.7,6,6C13.8,10.3,9.9,15.4,7.7,17.9L7.7,17.9z M7.7,17.9"/> <path class="st0" d="M10.5,7.7c0,1.5-1.3,2.8-2.8,2.8S4.9,9.3,4.9,7.7s1.3-2.8,2.8-2.8S10.5,6.2,10.5,7.7L10.5,7.7z M10.5,7.7"/> </g> </svg>
            </div>
            <!-- Share Project -->
            <div class="dropdown share_sec">
                <div class="share shareBtn" id="dropdownMenuButtons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg width="15" height="15" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 18.2 18.2" xml:space="preserve"><path class="st0" d="M14.6,10.9c-1.3,0-2.4,0.7-3,1.6L7.2,10c0.2-0.6,0.2-1.3,0-1.9l4.4-2.5c0.7,1,1.8,1.6,3,1.6 c2,0,3.6-1.6,3.6-3.6c0-2-1.6-3.6-3.6-3.6c-2,0-3.6,1.6-3.6,3.6c0,0.2,0,0.3,0,0.5L6.4,6.7C5.1,5.2,2.8,5,1.3,6.3 c-1.5,1.3-1.7,3.6-0.4,5.1C2.2,13,4.5,13.2,6,11.9c0.2-0.1,0.3-0.3,0.4-0.4l4.6,2.6c0,0.2,0,0.3,0,0.5c0,2,1.6,3.6,3.6,3.6 c2,0,3.6-1.6,3.6-3.6C18.2,12.5,16.6,10.9,14.6,10.9z M14.6,1.6c1.1,0,2,0.9,2,2s-0.9,2-2,2s-2-0.9-2-2S13.5,1.6,14.6,1.6z M3.7,11.1c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S4.8,11.1,3.7,11.1z M14.6,16.5c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2 S15.7,16.5,14.6,16.5z"/> </svg>
                </div>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButtons"> 
                    <a href="#" data-url="<?= $project->frontUrl(); ?>" class="btnshare bluring" data-network="facebook" target="_blank"><i class="fa fa-facebook"></i></a>
                    <a href="#" data-url="<?= $project->frontUrl(); ?>" class="btnshare bluring" data-network="whatsapp" target="_blank"><svg width="39" height="39" viewBox="0 0 39 39"><path fill="#00E676" d="M10.7 32.8l.6.3c2.5 1.5 5.3 2.2 8.1 2.2 8.8 0 16-7.2 16-16 0-4.2-1.7-8.3-4.7-11.3s-7-4.7-11.3-4.7c-8.8 0-16 7.2-15.9 16.1 0 3 .9 5.9 2.4 8.4l.4.6-1.6 5.9 6-1.5z"></path><path fill="#FFF" d="M32.4 6.4C29 2.9 24.3 1 19.5 1 9.3 1 1.1 9.3 1.2 19.4c0 3.2.9 6.3 2.4 9.1L1 38l9.7-2.5c2.7 1.5 5.7 2.2 8.7 2.2 10.1 0 18.3-8.3 18.3-18.4 0-4.9-1.9-9.5-5.3-12.9zM19.5 34.6c-2.7 0-5.4-.7-7.7-2.1l-.6-.3-5.8 1.5L6.9 28l-.4-.6c-4.4-7.1-2.3-16.5 4.9-20.9s16.5-2.3 20.9 4.9 2.3 16.5-4.9 20.9c-2.3 1.5-5.1 2.3-7.9 2.3zm8.8-11.1l-1.1-.5s-1.6-.7-2.6-1.2c-.1 0-.2-.1-.3-.1-.3 0-.5.1-.7.2 0 0-.1.1-1.5 1.7-.1.2-.3.3-.5.3h-.1c-.1 0-.3-.1-.4-.2l-.5-.2c-1.1-.5-2.1-1.1-2.9-1.9-.2-.2-.5-.4-.7-.6-.7-.7-1.4-1.5-1.9-2.4l-.1-.2c-.1-.1-.1-.2-.2-.4 0-.2 0-.4.1-.5 0 0 .4-.5.7-.8.2-.2.3-.5.5-.7.2-.3.3-.7.2-1-.1-.5-1.3-3.2-1.6-3.8-.2-.3-.4-.4-.7-.5h-1.1c-.2 0-.4.1-.6.1l-.1.1c-.2.1-.4.3-.6.4-.2.2-.3.4-.5.6-.7.9-1.1 2-1.1 3.1 0 .8.2 1.6.5 2.3l.1.3c.9 1.9 2.1 3.6 3.7 5.1l.4.4c.3.3.6.5.8.8 2.1 1.8 4.5 3.1 7.2 3.8.3.1.7.1 1 .2h1c.5 0 1.1-.2 1.5-.4.3-.2.5-.2.7-.4l.2-.2c.2-.2.4-.3.6-.5s.4-.4.5-.6c.2-.4.3-.9.4-1.4v-.7s-.1-.1-.3-.2z"></path></svg></a>
                </div>
            </div>
            <!-- Like Project -->
            <?php /*if(count($projects_flavors) > 0) { ?>
                <!-- Setect Bed Room -->
    <!--        <select class="selectpicker pattern_select">
                <?php foreach ($projects_flavors as $f) { ?>
					<option data-icon="fa-bed" value="<?= $f->salon . '_' . $f->room ?>" <?= ((@$flavor->salon . "_" . @$flavor->room == $f->salon . '_' . $f->room) ? 'selected="selected"' : '') ?>><?= $f->salon . '+' . $f->room ?></option>
                <?php } ?>
                </select>-->
            <?php }*/ ?>



        </div>
        <div class="features_sec">
            <a class="project_name jazzira_font" href="<?= $project->frontUrl(); ?>"><?=$project->getIntroCard();?></a>
            <ul class="jazzira_font">
                <?php list($sclass, $slab) = $project->getStatus(); ?>
<?php

$project_city_name = $project->city->getName();
$project_region_name = '';
if($project->region)
$project_region_name = $project->region->getName();

?>
                <li>
                    <svg width="15" height="15" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 21.17 20.61" xml:space="preserve"><path class="st0" d="M7.79,8.63c0.9,1.05,1.83,2.06,2.77,3.12c0.08-0.09,0.14-0.15,0.19-0.21c0.86-1.02,1.72-2.03,2.57-3.05 c0.51-0.61,0.99-1.24,1.35-1.95c0.42-0.82,0.6-1.67,0.46-2.59c-0.42-2.91-3.45-4.69-6.19-3.63C6.28,1.33,5.18,4.45,6.62,7 C6.95,7.58,7.36,8.12,7.79,8.63z M10.59,2.42c1.23-0.01,2.27,1.03,2.27,2.27c0,1.24-1.02,2.28-2.26,2.28 c-1.26,0-2.29-1.02-2.29-2.27C8.31,3.46,9.33,2.43,10.59,2.42z M20.83,10.23c-1.79-0.91-3.58-1.82-5.37-2.73 c-0.15-0.08-0.3-0.15-0.45-0.22c-0.14,0.22-0.27,0.43-0.41,0.65c1.82,0.93,3.63,1.85,5.47,2.78c-1.33,1.03-2.62,2.04-3.93,3.05 c-1.21-1.08-2.42-2.15-3.64-3.23c-0.09,0.11-0.17,0.2-0.26,0.31c1.17,1.04,2.33,2.07,3.51,3.12c-0.09,0.04-0.15,0.07-0.22,0.1 c-1.62,0.65-3.24,1.29-4.85,1.94c-0.2,0.08-0.3,0.05-0.44-0.12c-2.02-2.53-4.05-5.06-6.08-7.58C4.11,8.25,4.09,8.2,4.03,8.11 c0.84,0,1.63,0,2.48,0C6.35,7.85,6.22,7.66,6.12,7.46C6.06,7.35,5.98,7.3,5.85,7.3C5.07,7.32,4.29,7.33,3.51,7.35 c-0.13,0-0.27,0.05-0.37,0.12C2.17,8.13,1.21,8.78,0.25,9.44c-0.29,0.2-0.32,0.38-0.13,0.67c2.31,3.4,4.62,6.8,6.94,10.2 c0.27,0.4,0.5,0.41,0.81,0.04c0.92-1.12,1.83-2.25,2.76-3.37c0.1-0.13,0.25-0.24,0.4-0.3c1.73-0.7,3.46-1.38,5.19-2.08 c0.12-0.05,0.24-0.12,0.35-0.2c1.45-1.12,2.89-2.24,4.34-3.36C21.29,10.73,21.26,10.45,20.83,10.23z M7.49,19.58 c-2.2-3.23-4.37-6.43-6.57-9.66c0.87-0.59,1.72-1.18,2.59-1.77c2.2,2.74,4.39,5.47,6.6,8.21C9.24,17.43,8.38,18.49,7.49,19.58z"/> </svg>
                    <p><?= $project_city_name; ?><br><?= $project_region_name ?></p>
                </li>


                <li>
                    <?php if ($sclass == 'under-construction') { ?>
                        <!-- اذا كان المشروع قيد الإنشاء-->
                        <svg width="15" height="15" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 20.78 20.65" xml:space="preserve"><path class="st0" d="M20.2,3.05h-1.36L13.42,0.8V0.3c0-0.17-0.14-0.3-0.3-0.3c-0.17,0-0.3,0.14-0.3,0.3v0.46L1.57,3.98H1.25 c-0.11,0-0.2,0.05-0.26,0.14C-0.04,5.79,0,5.7,0,5.81c0,0.17,0.13,0.31,0.3,0.31h1.58v0.43C1.88,7,2.25,7.37,2.7,7.37h0.12v3.08 c-0.34,0.12-0.58,0.45-0.58,0.83c0,0.37,0.23,0.69,0.55,0.82v0.15c0,0.08,0.03,0.15,0.08,0.21c0.42,0.45,0.54,0.53,0.52,0.76 c-0.02,0.21-0.19,0.34-0.38,0.34H2.86c-0.05-0.1-0.15-0.16-0.27-0.16c-0.17,0-0.3,0.14-0.3,0.3v0.16c0,0.17,0.14,0.3,0.3,0.3h0.42 c0.52,0,0.95-0.39,0.99-0.9c0.05-0.52-0.26-0.77-0.6-1.13v-0.01C3.75,12,4,11.67,4,11.28c0-0.38-0.24-0.7-0.58-0.83V7.37h0.12 C4,7.37,4.36,7,4.36,6.55V6.12c0.19,0,6.79,0,6.91,0c0,0.39,0,11.12,0,11.57h-0.04c-0.34,0-0.61,0.27-0.61,0.61v1.75H9.81 c-0.17,0-0.3,0.14-0.3,0.3s0.14,0.3,0.3,0.3c0.28,0,6.35,0,6.6,0c0.17,0,0.3-0.14,0.3-0.3s-0.14-0.3-0.3-0.3H15.6V18.3 c0-0.34-0.27-0.61-0.61-0.61h-0.04c0-0.48,0-9.05,0-9.53c0-0.17-0.14-0.3-0.3-0.3c-0.17,0-0.3,0.14-0.3,0.3v0.99h-2.46 c0-0.48,0-4.04,0-4.57h2.46c0,0.25,0,1.9,0,2.16c0,0.17,0.14,0.3,0.3,0.3c0.17,0,0.3-0.14,0.3-0.3V6.12h1.83v0.35 c0,0.32,0.26,0.58,0.58,0.58h0.71c0.17,0,0.3-0.14,0.3-0.3c0-0.17-0.14-0.3-0.3-0.3h-0.68V3.66c0.29,0,2.49,0,2.78,0v2.78h-0.68 c-0.17,0-0.3,0.14-0.3,0.3c0,0.17,0.14,0.3,0.3,0.3h0.71c0.32,0,0.58-0.26,0.58-0.58V3.63C20.78,3.31,20.52,3.05,20.2,3.05 L20.2,3.05z M0.85,5.51l0.57-0.93h1.4v0.93C1.92,5.51,2.29,5.51,0.85,5.51L0.85,5.51z M3.12,11.55c-0.15,0-0.27-0.12-0.27-0.27 c0-0.15,0.12-0.27,0.27-0.27c0.15,0,0.27,0.12,0.27,0.27C3.39,11.43,3.27,11.55,3.12,11.55L3.12,11.55z M3.75,6.55 c0,0.12-0.09,0.21-0.21,0.21H2.7c-0.12,0-0.21-0.09-0.21-0.21V6.12c0.46,0,0.81,0,1.26,0V6.55z M5.64,5.51c-0.26,0-1.95,0-2.21,0 V4.58h2.21V5.51z M8.46,5.51H6.25V4.58h2.21V5.51z M11.27,5.51H9.06V4.58h2.21V5.51z M13.42,9.76h0.93v1.53h-0.93V9.76z M13.42,11.89h0.93v1.53h-0.93V11.89z M13.42,14.03h0.93v1.53h-0.93V14.03z M13.42,16.16h0.93v1.53h-0.93V16.16z M11.88,9.76h0.93 v1.53h-0.93V9.76z M11.88,11.89h0.93v1.53h-0.93V11.89z M11.88,14.03h0.93v1.53h-0.93V14.03z M11.88,16.16h0.93v1.53h-0.93V16.16z M15,18.3l0,1.75h-3.77l0-1.75C11.61,18.3,14.59,18.3,15,18.3L15,18.3z M11.38,3.98c-0.25,0-7.26,0-7.6,0l8.77-2.5L11.38,3.98z M12.06,3.98l1.06-2.26l1.06,2.26H12.06z M16.78,5.51h-1.83V4.58h1.83V5.51z M16.78,3.63v0.35h-1.94l-1.12-2.39l3.55,1.48 C17,3.1,16.78,3.34,16.78,3.63L16.78,3.63z M16.78,3.63"/> </svg>
                        <p><?= trans("front.under cons"); ?></p><br><p class="num date"><?= date("Y/m", strtotime($project->delivered_date)); ?></p>
                    <?php } else { ?>
                        <!-- إذا كان المشروع جاهز -->
                        <svg width="15" height="15" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 28.07 21.56" xml:space="preserve"><path class="st0" d="M27.55,7.76c-0.8-0.42-2.55-0.41-3.24,0.45c-0.26,0.33-0.51,0.65-0.77,0.98c-0.67,0.87-1.43,1.85-2.82,3.44 c-0.31,0.36-0.72,0.65-1.19,0.9c0.02-0.07,0.03-0.14,0.03-0.21c0.05-0.58-0.22-1.14-0.69-1.47c-0.56-0.38-1.32-0.39-2.07-0.02 c-0.97,0.47-2.05,0.47-3.09,0.46c-0.13,0-0.25,0-0.37,0c-0.44,0-0.9-0.19-1.43-0.42c-0.72-0.3-1.54-0.65-2.6-0.65 c-1.2,0-2.37,0.71-3.1,1.26v-0.22c0-0.24-0.2-0.44-0.44-0.44H0.44C0.2,11.81,0,12.01,0,12.26v8.86c0,0.24,0.2,0.44,0.44,0.44h5.32 c0.24,0,0.44-0.2,0.44-0.44v-0.85c1.92,0.27,3.64,0.37,5.2,0.37c3.11,0,5.54-0.43,7.45-0.87c1.84-0.42,5.28-4.03,7.2-7.56 c0.36-0.67,0.74-1.3,1.08-1.86c0.47-0.77,0.8-1.33,0.9-1.67C28.08,8.55,28.16,8.08,27.55,7.76z M5.32,20.67H0.89V12.7h4.43V20.67z M26.38,9.9c-0.34,0.57-0.73,1.21-1.1,1.89c-1.93,3.55-5.2,6.8-6.62,7.12c-2.81,0.64-6.76,1.27-12.45,0.46v-5.74 c0.42-0.38,1.79-1.52,3.1-1.52c0.89,0,1.58,0.29,2.26,0.58c0.59,0.25,1.15,0.49,1.77,0.49c0.12,0,0.24,0,0.37,0 c1.09,0.01,2.33,0.02,3.49-0.55c0.46-0.22,0.89-0.24,1.18-0.04c0.22,0.15,0.33,0.4,0.31,0.66c-0.03,0.36-0.31,0.68-0.76,0.9 c-2.29,0.62-5.18,0.63-6.85,0.63c-0.24,0-0.44,0.2-0.44,0.44c0,0.24,0.2,0.44,0.44,0.44c1.66,0,3.58-0.02,5.44-0.31 c2.35-0.37,3.95-1.06,4.88-2.12c1.41-1.61,2.18-2.61,2.86-3.48c0.26-0.33,0.5-0.64,0.76-0.97c0.17-0.22,0.61-0.37,1.12-0.38 c0.48-0.02,0.86,0.08,1.02,0.17C27.02,8.83,26.71,9.35,26.38,9.9z M17.37,3.1c0-0.41,0.33-0.74,0.74-0.74s0.74,0.33,0.74,0.74 c0,0.41-0.33,0.74-0.74,0.74S17.37,3.51,17.37,3.1z M12.26,9.81h1.67c0.24,0,0.44-0.2,0.44-0.44V8.97h0.39 c0.12,0,0.44-0.16,0.44-0.44V8.14h0.39c0.24,0,0.44-0.2,0.44-0.44V7.3h0.39c0.12,0,0.23-0.05,0.31-0.13l0.99-0.99 c0.12,0.01,0.24,0.02,0.36,0.02c0,0,0,0,0,0c0.83,0,1.61-0.32,2.19-0.91c1.21-1.21,1.21-3.18,0-4.39C19.71,0.32,18.93,0,18.1,0 c-0.83,0-1.61,0.32-2.19,0.91c-0.85,0.85-1.13,2.12-0.73,3.23l-3.24,3.24c-0.08,0.08-0.13,0.2-0.13,0.31v1.67 C11.81,9.61,12.01,9.81,12.26,9.81z M12.7,7.88l3.32-3.32c0.13-0.13,0.17-0.33,0.09-0.5c-0.4-0.85-0.23-1.86,0.43-2.52 c0.42-0.42,0.97-0.65,1.57-0.65c0.59,0,1.15,0.23,1.57,0.65c0.86,0.86,0.86,2.27,0,3.13c-0.42,0.42-0.97,0.65-1.57,0.65c0,0,0,0,0,0 c-0.15,0-0.29-0.01-0.43-0.04c-0.15-0.03-0.29,0.02-0.4,0.12l-1.02,1.02H15.6c-0.24,0-0.44,0.2-0.44,0.44v0.39h-0.39 c-0.24,0-0.44,0.2-0.44,0.44v0.39h-0.39h0c-0.23,0-0.44,0.19-0.44,0.44v0.39H12.7V7.88z M2.36,16.69c0-0.41,0.33-0.74,0.74-0.74 c0.41,0,0.74,0.33,0.74,0.74c0,0.41-0.33,0.74-0.74,0.74C2.69,17.42,2.36,17.09,2.36,16.69z"/> </svg>
                        <p><?= trans("front.Ready to move"); ?></p>  
                    <?php } ?>
                </li>
                <li>

                    <?php if ($project->payment_method == 'نقدي') { ?>
                        <!-- اذا كان المشروع نقدا-->
                        <svg width="15" height="15" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 27.59 23.58" style="enable-background:new 0 0 27.59 23.58;" xml:space="preserve"><style type="text/css">.st0{fill:#028787}</style><path class="st0" d="M9.13,15.58c0,2.57,2.09,4.66,4.66,4.66c2.57,0,4.66-2.09,4.66-4.66s-2.09-4.66-4.66-4.66 C11.22,10.91,9.13,13.01,9.13,15.58z M17.65,15.58c0,2.12-1.73,3.85-3.85,3.85c-2.12,0-3.85-1.73-3.85-3.85 c0-2.12,1.73-3.85,3.85-3.85C15.92,11.72,17.65,13.45,17.65,15.58z M13.39,12.42v0.29c-0.72,0.18-1.25,0.83-1.25,1.61v0.2 c0,0.73,0.55,1.34,1.25,1.44v1.61c-0.26-0.14-0.45-0.42-0.45-0.76h-0.81c0,0.8,0.54,1.44,1.25,1.62v0.29h0.81v-0.29 c0.72-0.18,1.25-0.83,1.25-1.61v-0.2c0-0.73-0.55-1.34-1.25-1.44v-1.61c0.26,0.14,0.45,0.42,0.45,0.76h0.81 c0-0.8-0.54-1.44-1.25-1.62v-0.29H13.39z M13.39,15.14c-0.26-0.08-0.45-0.33-0.45-0.61v-0.2c0-0.32,0.18-0.6,0.45-0.75V15.14z M14.64,16.62v0.2c0,0.32-0.18,0.6-0.45,0.75v-1.56C14.46,16.1,14.64,16.34,14.64,16.62z M27.59,7.57v16H5.31v-0.81h21.47V8.38H0.81 v14.39H4.5v0.81H0v-16H27.59z M3.56,21.96c0.05-0.49,0.05-0.5,0.05-0.59c0-0.88-0.71-1.59-1.59-1.59h-0.4v-8.41h0.4 c0.94,0,1.67-0.81,1.58-1.74L3.56,9.19h15.47V10H4.41c-0.1,1.09-0.92,1.97-1.98,2.15V19c1.06,0.18,1.89,1.06,1.98,2.15h18.77 c0.1-1.09,0.92-1.97,1.98-2.15v-6.86c-1.06-0.18-1.89-1.06-1.98-2.15h-3.34V9.19h4.19c-0.05,0.49-0.05,0.5-0.05,0.59 c0,0.88,0.71,1.59,1.59,1.59h0.4v8.41h-0.4c-0.94,0-1.67,0.81-1.58,1.74l0.04,0.44H3.56z M22.26,4.3l0.35-0.21l1.24,2.06l-0.69,0.42 l-0.84-1.4c-1,0.39-2.16,0.07-2.81-0.82l-3.93,2.36l-0.42-0.69l4.66-2.8l0.19,0.4C20.41,4.46,21.45,4.78,22.26,4.3z M12.44,6.71 l-0.42-0.69L22.04,0l3.69,6.15l-0.69,0.42l-3.28-5.46L12.44,6.71z"/> </svg>
                        <p><?= trans('front.' . $project->payment_method); ?></p>
                    <?php } else { ?>
                        <!-- إذا كان المشروع تقسيط -->
                        <div class="progres">
                            <span class="pro">
                                <div class="progress" data-percentage="<?= $project->payment_percent ?>">
                                    <span class="progress-left">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <span class="progress-right">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <div class="progress-value">
                                        <strong class="num"><?= $project->payment_percent ?>%</strong>
                                    </div>
                                </div>
                            </span>
                        </div>
                        <p><?= trans('front.' . $project->payment_method); ?></p>
                        <p> <strong class="num"><?= $project->payment_months ?></strong> <?= trans("front.months"); ?></p>
                    <?php } ?>



                </li>
            </ul>
        </div>


    </div>
</div>
<script type="application/ld+json">
<?php
$rooms = 0;
if(isset($flavor))
$rooms = (int)$flavor->salon + (int)$flavor->room;
?>
{
"@context": "http://www.schema.org",
"@type":"SingleFamilyResidence",
"address":{"@type":"PostalAddress","addressLocality":"{{ $project_region_name }}",
"addressRegion":"{{ $project_city_name }}","addressCountry":"{{ trans('front.turkey') }}"},
"geo":{"@type":"GeoCoordinates","latitude":{{ $project->latitude }},"longitude":{{ $project->longitude }}},
"numberOfRooms": "{{ $rooms }}",
"floorSize": "{{ @$flavor->area }} m2",
"image" : "{{ $iximg_full }}",
"name": "{{ htmlentities($project->getIntroCard()) }}",
"description": "{{  htmlentities($project->getIntoLocation()) }}",
"url" : "{{ $project->frontUrl() }}",
    "telephone": "{{ $infos->tel_1 }}",
	"identifier": "{{ $project->name_en }}"
}
</script>
<?php 


/* ?>
  <!-- schema -->
  <script type="application/ld+json">
  {
  "@context": "http://www.schema.org",
  "@type": "Product",
  "aggregateRating": {
  "@type": "AggregateRating",
  "ratingValue": "4.<?=rand(1,9) ?>",
  "reviewCount": "<?= $project->likes+10 ?>"
  },
  "name": "<?= $project->getName(); ?>",
  "offers" : {
  "@type": "Offer",
  "url": "<?=URL::current();?>",
  "price": "<?= str_replace('.','',$project_min_price); ?>",
  "priceCurrency": "TRY",
  "priceValidUntil": "2029-11-05",
  "itemCondition": "https://schema.org/UsedCondition",
  "availability": "https://schema.org/InStock",
  "seller": {
  "@type": "Organization",
  "name": "DamasTurk"
  }
  },
  "image": "<?= Helper::media_url($cardphoto); ?>"
  ,
  "description": "<?= $project->getIntroCard(); ?>",
  "brand": {
  "@type": "Thing",
  "name": "Damasturk"
  },
  "review": {
  "@type": "Review",
  "reviewRating": {
  "@type": "Rating",
  "ratingValue": "<?= (rand(4,5)==4)?'4.'.rand(1,9):5 ?>",
  "bestRating": "5"
  },
  "author": {
  "@type": "Person",
  "name": "abdo"
  }}
  }
  </script>
  <?php */ ?>