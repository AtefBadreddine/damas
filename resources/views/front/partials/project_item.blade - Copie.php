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
        if ($f->room == $room and $f->salon == $salon and $f->observation != 'مباع') {
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
            if ($f->observation != 'مباع') {
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
    $flavors = $flavors->where('observation', '!=', 'مباع'); //عدم عرض سعر الشقق المباعة 
    $flavor = $flavors->orderBy("price", "ASC")->first();

    if (empty($flavor)) {
        $flavors = $project->flavors();
        $flavor = $flavors->orderBy("price", "ASC")->first();
    }
}

$projects_flavors = $project->flavors;

$open_blank = @$open_blank ? true : false;
$cardphoto = @$project->cardphoto;
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

        <span class="pull-right social shareBtnsFloating" data-url="<?= route('front.project', $project->slug); ?>" data-text="<?= $project->getName(); ?>">
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
    <div class="contain" id="container" <?php if ($is_mobile) { ?> data-url="<?= route('front.project', $project->slug); ?>"<?php } ?>>
        <div class="image-project">
            <a href="<?= route('front.project', $project->slug); ?>" <?= $open_blank == true ? 'target="_blank"' : ''; ?> <?= isset($proj_shema) ? ' property="url"' : '' ?>>

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
            <div class="details"><a href="<?= route('front.project', $project->slug); ?>" <?= $open_blank == true ? 'target="_blank"' : ''; ?>  class="button"><?= trans('front.details') ?></a></div>
<?php } ?>
    </div>
</div>
<?php */ ?>









<div class="item swiper-slide">
	<div class="content sec shadow_type" <?= isset($proj_shema) ? ' property="itemListElement" typeof="ListItem"' : '' ?>>
		<div class="view_cont">
			<!-- image Project -->
			<div class="int_cont image">
				<a href="<?= route('front.project', $project->slug); ?>" <?= $open_blank == true ? 'target="_blank"' : ''; ?> <?= isset($proj_shema) ? ' property="url"' : '' ?>>
				<!--<img class="lazy" data-src="<?= asset("/img/01.jpg"); ?>" alt="damasturk"/>-->
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
				{!! Helper::get_pic(Helper::get_thumbnail($cardphoto, $iw, $ih),(isset($ajax) and $ajax==true)?'img-responsive':'lazy img-responsive','','',(isset($cardphoto)?$cardphoto->getTitle():''), isset($proj_shema)?' property="image"':'') !!}
				</a>
			</div>
			<!-- map Project -->
			<div class="int_cont map">
				<iframe width="100%" height="200" frameborder="0" style="border:0" src="https://maps.google.com/maps?q=<?= $project->latitude; ?>,<?= $project->longitude; ?>&amp;hl=es;z=14&amp;output=embed"></iframe>
			</div>
		</div>
		<div class="control_sec">
			<!-- Price Project -->
			<div class="num"> 
			@if(strlen($project_min_price)>8)
                {!! '<strong>'. Helper::curr_format() .'</strong> '. $project_min_price  !!}
            @else
                {!! '<strong>'. Helper::curr_format() .'</strong> '. $project_min_price  !!}
            @endif
			</div>
			
			<?php
            //price to show when change beds select
            //Helper::decimal_format(@$flavor->price,$project->is_price_usd)
            foreach ($projects_flavors as $f) {
                ?>
                <div class="num smlprice tpp<?= $f->salon . '_' . $f->room ?> hidden">
                    {!! "<strong>". Helper::curr_format() ."</strong> " . Helper::decimal_format($f->price,$project->is_price_usd) !!}
                </div>
            <?php } ?>
			
			<!-- image and map btn -->
			<div class="btn_style change_view">
				<div class="type_map">
					<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 15.5 20.4" xml:space="preserve"><g> <path class="st0" d="M7.7,0C3.5,0,0,3.5,0,7.7c0,1.8,1.2,4.3,3.6,7.6c1.7,2.4,3.4,4.3,3.5,4.4l0.6,0.7l0.6-0.7 c0.1-0.1,1.8-2,3.5-4.4c2.4-3.3,3.6-5.9,3.6-7.6C15.5,3.5,12,0,7.7,0L7.7,0z M7.7,17.9c-2.1-2.5-6-7.6-6-10.2c0-3.3,2.7-6,6-6 s6,2.7,6,6C13.8,10.3,9.9,15.4,7.7,17.9L7.7,17.9z M7.7,17.9"/> <path class="st0" d="M10.5,7.7c0,1.5-1.3,2.8-2.8,2.8S4.9,9.3,4.9,7.7s1.3-2.8,2.8-2.8S10.5,6.2,10.5,7.7L10.5,7.7z M10.5,7.7"/> </g> </svg>
				</div>
				<div class="type_image">
					<svg viewBox="0 0 16 16" id="941b7c6df16f1639c19993afa498088e" xmlns="http://www.w3.org/2000/svg"><path data-name="Image Icon copy 3" fill-rule="evenodd" d="M14 16H2a2 2 0 01-2-2V2a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2zm0-14H2v12h1.974l6.136-6.647a1.09 1.09 0 011.528-.086L14 9.373V2zm0 10.048l-3.023-2.7L6.687 14H14v-1.952zM6 8a2 2 0 112-2 2 2 0 01-2 2z"></path></svg>
				</div>
			</div>
			<!-- Share Project -->
			<div class="dropdown share_sec">
				<div class="btn_style share" id="dropdownMenuButtons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 18.2 18.2" xml:space="preserve"><path class="st0" d="M14.6,10.9c-1.3,0-2.4,0.7-3,1.6L7.2,10c0.2-0.6,0.2-1.3,0-1.9l4.4-2.5c0.7,1,1.8,1.6,3,1.6 c2,0,3.6-1.6,3.6-3.6c0-2-1.6-3.6-3.6-3.6c-2,0-3.6,1.6-3.6,3.6c0,0.2,0,0.3,0,0.5L6.4,6.7C5.1,5.2,2.8,5,1.3,6.3 c-1.5,1.3-1.7,3.6-0.4,5.1C2.2,13,4.5,13.2,6,11.9c0.2-0.1,0.3-0.3,0.4-0.4l4.6,2.6c0,0.2,0,0.3,0,0.5c0,2,1.6,3.6,3.6,3.6 c2,0,3.6-1.6,3.6-3.6C18.2,12.5,16.6,10.9,14.6,10.9z M14.6,1.6c1.1,0,2,0.9,2,2s-0.9,2-2,2s-2-0.9-2-2S13.5,1.6,14.6,1.6z M3.7,11.1c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S4.8,11.1,3.7,11.1z M14.6,16.5c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2 S15.7,16.5,14.6,16.5z"/> </svg>
				</div>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButtons"> 
					<a href="https://facebook.com/sharer.php?u=<?= route('front.project', $project->slug); ?>" class="btnshare bluring" data-network="facebook" target="_blank"><i class="fa fa-facebook"></i></a>
					<a href="https://api.whatsapp.com/send?text=<?= route('front.project', $project->slug); ?>" class="btnshare bluring" data-network="whatsapp" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 39 39"><path fill="#00E676" d="M10.7 32.8l.6.3c2.5 1.5 5.3 2.2 8.1 2.2 8.8 0 16-7.2 16-16 0-4.2-1.7-8.3-4.7-11.3s-7-4.7-11.3-4.7c-8.8 0-16 7.2-15.9 16.1 0 3 .9 5.9 2.4 8.4l.4.6-1.6 5.9 6-1.5z"></path><path fill="#FFF" d="M32.4 6.4C29 2.9 24.3 1 19.5 1 9.3 1 1.1 9.3 1.2 19.4c0 3.2.9 6.3 2.4 9.1L1 38l9.7-2.5c2.7 1.5 5.7 2.2 8.7 2.2 10.1 0 18.3-8.3 18.3-18.4 0-4.9-1.9-9.5-5.3-12.9zM19.5 34.6c-2.7 0-5.4-.7-7.7-2.1l-.6-.3-5.8 1.5L6.9 28l-.4-.6c-4.4-7.1-2.3-16.5 4.9-20.9s16.5-2.3 20.9 4.9 2.3 16.5-4.9 20.9c-2.3 1.5-5.1 2.3-7.9 2.3zm8.8-11.1l-1.1-.5s-1.6-.7-2.6-1.2c-.1 0-.2-.1-.3-.1-.3 0-.5.1-.7.2 0 0-.1.1-1.5 1.7-.1.2-.3.3-.5.3h-.1c-.1 0-.3-.1-.4-.2l-.5-.2c-1.1-.5-2.1-1.1-2.9-1.9-.2-.2-.5-.4-.7-.6-.7-.7-1.4-1.5-1.9-2.4l-.1-.2c-.1-.1-.1-.2-.2-.4 0-.2 0-.4.1-.5 0 0 .4-.5.7-.8.2-.2.3-.5.5-.7.2-.3.3-.7.2-1-.1-.5-1.3-3.2-1.6-3.8-.2-.3-.4-.4-.7-.5h-1.1c-.2 0-.4.1-.6.1l-.1.1c-.2.1-.4.3-.6.4-.2.2-.3.4-.5.6-.7.9-1.1 2-1.1 3.1 0 .8.2 1.6.5 2.3l.1.3c.9 1.9 2.1 3.6 3.7 5.1l.4.4c.3.3.6.5.8.8 2.1 1.8 4.5 3.1 7.2 3.8.3.1.7.1 1 .2h1c.5 0 1.1-.2 1.5-.4.3-.2.5-.2.7-.4l.2-.2c.2-.2.4-.3.6-.5s.4-.4.5-.6c.2-.4.3-.9.4-1.4v-.7s-.1-.1-.3-.2z"></path></svg></a>
				</div>
			</div>
			<!-- Like Project -->
			<div class="btn_style like">
				<svg class="like_icon" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 19.6 18.1" xml:space="preserve"><g> <g> <path class="st0" d="M15.6,11.1c1.3-1.3,2-2.5,2.3-3.8C18,6.7,18,6.2,18,5.9c0,0,0,0,0-0.1c-0.2-2.4-1.8-4.1-3.9-4.1 c-1.6,0-2.9,1-3.6,2.4c-0.3,0.7-1.2,0.7-1.5,0C8.4,2.6,7.1,1.6,5.6,1.6c-2.1,0-3.7,1.8-3.9,4.1l0,0.1c0,0.4,0,0.9,0.1,1.5 c0.3,1.4,1.1,2.7,2.2,3.7l5.8,5.1L15.6,11.1z M14.1,0c3,0,5.2,2.5,5.5,5.6c0,0,0,0.1,0,0.2c0,0.5,0,1.2-0.2,2 c-0.4,1.6-1.2,3-2.7,4.6l-6.4,5.5c-0.3,0.3-0.8,0.3-1.1,0l-6.3-5.6c-1.4-1.2-2.3-2.8-2.7-4.6C0,6.9,0,6.2,0,5.7c0-0.1,0-0.1,0-0.1 C0.3,2.4,2.6,0,5.6,0c1.7,0,3.2,0.8,4.2,2.1C10.8,0.8,12.4,0,14.1,0z"/> </g> </g> </svg>
				<svg class="liked_icon" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 17.7 16.5" style="enable-background:new 0 0 17.7 16.5;" xml:space="preserve"><style type="text/css">.st0{fill:#0F6868;enable-background:new }</style><path class="st0" d="M17.7,4.9C17.5,2,15.5,0,12.9,0c-1.7,0-3.2,0.9-4.1,2.3C7.9,0.8,6.5,0,4.8,0C2.3,0,0.3,2.1,0,4.9 C0,5-0.1,5.7,0.1,6.8c0.4,1.6,1.2,3,2.4,4.1l6.2,5.6l6.3-5.6c1.2-1.1,2.1-2.5,2.4-4.1C17.8,5.6,17.7,5,17.7,4.9L17.7,4.9z"/> </svg>
			</div>
			<?php if(count($projects_flavors)>0){ ?>
			<!-- Setect Bed Room -->
			<select class="selectpicker pattern_select">
				<?php
                    foreach ($projects_flavors as $f) { ?>
                        <option data-icon="fa-bed" value="<?= $f->salon . '_' . $f->room ?>" <?=  ((@$flavor->salon . "_" . @$flavor->room==$f->salon . '_' . $f->room)?'selected="selected"':'') ?>><?= $f->salon . '+' . $f->room ?></option>
                    <?php } ?>
			</select>
			<?php } ?>
			
			
			
		</div>
		<div class="features_sec">
			<h2 class="project_name"><?= $project->getIntroCard(); ?></h2>
			<ul>
			<?php list($sclass, $slab) = $project->getStatus(); ?>
				<li>
					
					<?php if($sclass=='under-construction'){ ?>
					<!-- اذا كان المشروع قيد الإنشاء-->
					<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 15.07 15.42" xml:space="preserve"><g> <g> <path class="st0" d="M15.07,14.11v-1c0-0.68-0.4-1.08-1.08-1.08H7.23c-0.91,0-1.38,0.43-1.38,1.08v1.3c0,0.67,0.45,1.01,1.38,1.01 h6.76C14.67,15.42,15.07,14.97,15.07,14.11L15.07,14.11z M13.84,14.19H7.07v-0.92h6.77V14.19z M13.84,14.19"/> <path class="st0" d="M9.84,4.96v2.94l0.39,1.05H9.57L3.14,0L1.72,0.85l0.43,0.75v3.97H1.7L2,7.73h0.15v0.65 C1.88,8.51,1.57,8.78,1.57,9.26c0,0.33,0.13,0.56,0.31,0.72l-1.67,1.44h0.47l1.48-1.27c0.13,0.05,0.28,0.08,0.42,0.08 c0.14,0,0.28-0.04,0.41-0.11l1.6,1.3h0.48l0,0L3.23,9.92c0.12-0.15,0.21-0.35,0.21-0.61c0-0.17-0.14-0.31-0.31-0.31 c-0.17,0-0.31,0.14-0.31,0.31c0,0.11-0.03,0.18-0.07,0.22L2.67,9.47c-0.06-0.05-0.14-0.05-0.2,0l-0.11,0.1 c-0.1-0.05-0.18-0.14-0.18-0.31c0-0.28,0.28-0.35,0.33-0.36c0.15-0.03,0.26-0.15,0.26-0.3V7.73h0.34l0.43-2.15H3.08V3.35l3.69,7.1 v0.36H8v0.61h4.61v-0.61h1.85V4.96H9.84z M7.18,6.56L7.18,6.56L5.93,7.39l0.65-1.66L7.18,6.56z M2.77,5.58H2.46V2.19l0.31,0.58 V5.58z M3.03,2.44L2.5,1.44l0.83-0.54L3.03,2.44z M3.76,1.52l0.59,1.02L3.39,3.16L3.76,1.52z M3.85,3.74l0.9-0.58L4.4,4.76 L3.85,3.74z M5.12,3.68l0.66,0.97L4.79,5.29L5.12,3.68z M5.02,6.02l1.11-0.76L5.5,6.95L5.02,6.02z M6.67,8.94L6.13,8l1.33-0.95 L6.67,8.94z M7.09,9.62L8,7.65l0.74,1.01L7.09,9.62z M13.22,8.04h-2.15V6.2h2.15V8.04z M13.22,8.04"/> <path class="st0" d="M0.31,13.27H0v0.62h4.92v-0.62H4.3v-0.92h0.62v-0.62H0v0.62h0.62v0.92H0.31z M0.31,13.27"/> </g> </g> </svg>
					<p class="num"><?= date("Y/m", strtotime($project->delivered_date)); ?></p>
					<?php }else{ ?>
					<!-- إذا كان المشروع جاهز -->
					<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 15.37 15.36" xml:space="preserve"><g> <g> <path class="st0" d="M3.31,14.16h10.46c-0.25,0.7-0.91,1.2-1.7,1.2H3.31c-0.99,0-1.8-0.81-1.8-1.8v-6.3L0.81,7.9L0,7.01L7.69,0 l6.28,5.73h-1.78l-4.5-4.11L2.71,6.17v7.4C2.71,13.89,2.98,14.16,3.31,14.16L3.31,14.16z M15.37,9.96c0,1.65-1.35,3-3,3 c-0.95,0-1.84-0.45-2.4-1.2h-4.5l-1.56-1.48v-0.6l1.56-1.52h4.51c0.56-0.75,1.45-1.2,2.4-1.2C14.02,6.96,15.37,8.31,15.37,9.96 L15.37,9.96z M14.17,9.96c0-0.99-0.81-1.8-1.8-1.8c-0.64,0-1.24,0.35-1.56,0.9l-0.17,0.3H5.95L5.33,9.97l0.62,0.59h0.86l0.78-0.83 l0.87,0.83h2.18l0.17,0.3c0.32,0.56,0.92,0.9,1.56,0.9C13.36,11.76,14.17,10.96,14.17,9.96L14.17,9.96z M12.97,9.36 c-0.33,0-0.6,0.27-0.6,0.6c0,0.33,0.27,0.6,0.6,0.6c0.33,0,0.6-0.27,0.6-0.6C13.57,9.63,13.3,9.36,12.97,9.36L12.97,9.36z M12.97,9.36"/> </g> </g> </svg>
					<?php } ?>
				</li>
				<li><?= trans('front.' . $project->payment_method); ?></li>
			</ul>
		</div>


	</div>
</div>
<?php /* ?>
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