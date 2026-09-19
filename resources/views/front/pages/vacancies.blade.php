<?php
    $current_lang = LaravelLocalization::getCurrentLocale();
    //$photoCard = $post->photoCard;
    $infos = Helper::get_params();
    $is_mobile = Helper::is_mobile();
	$arr_prices = [
	"50000-100000"=>Helper::usd_to_format("50K $")."-".Helper::usd_to_format("100K $"),"100000-150000"=>Helper::usd_to_format("100K $")."-".Helper::usd_to_format("150K $"),"150000-250000"=>Helper::usd_to_format("150K $")."-".Helper::usd_to_format("250K $"),"250000-400000"=>Helper::usd_to_format("250K $")."-".Helper::usd_to_format("400K $"),"400000-600000"=>Helper::usd_to_format("400K $")."-".Helper::usd_to_format("600K $"),"600000-1000000"=>Helper::usd_to_format("600K $")."-".Helper::usd_to_format("1M $"),"1000000-2000000"=>Helper::usd_to_format("1M $")."-".Helper::usd_to_format("2M $"),"2000000-+"=>'+'.Helper::usd_to_format("2M $")
	];
?>
@section('styles')
<?php
if(App::isLocal()){ ?>
<?= Html::style("/resources/assets/css/global.css"); ?>
<?= Html::style("/resources/assets/css/left_form_search.css"); ?>
<?= Html::style("/resources/assets/css/index.css"); ?>
<?= Html::style("/resources/assets/css/note.css"); ?>
<?= Html::style("/resources/assets/css/blog.css"); ?>
<?php }else{ ?>
    <style><?php include(public_path()."/css/about" . ($current_lang=='en'?'-en':'') . ".min.css"); ?></style>
<?php } ?>


<style>
.blog-heading1{
padding-top: 54px;
padding-bottom: 31px!important}


<?php if($current_lang!='en'){ ?>

div.note .pic:after {
content: "";
display: block;
border-style: solid;
border-width: 31px 31px 0 0;
border-color: #E9EBEE transparent;
position: absolute;
top: -2px;
left: 5px;
}
div.note .pic:before {
content: "";
display: block;
border-style: solid;
border-width: 31px 31px 0 0;
border-color: lightgray transparent;
position: absolute;
top: -1px;
left: 5px;
}
<?php }else{?>
.content .about:before{content:none}
.content .about:after{content:none}
<?php } ?>
.content section {
    margin: 0;
    width: 100%;
}
h3.blog-heading{
clear: both;
padding: 25px 3px 19px 0;
}
.alikes{padding: 0 8px;}
.content {
    width: auto;
    height: auto;
margin: 0;}



@if(Helper::get_device()!='full')

@font-face{font-family:BukraRegular;src:url(/fonts/ar/29lt-bukra-regular.ttf) }

.blog-heading1 {
    padding-top: 0;
    margin-top: -21px;
    line-height: 37px;
    margin-bottom: 16px;
    text-align: center;
}
.fa-heart{color: #1F3A73;}
.shareBtnsFloating{text-align:center}
#section_callcenter_left .down-form {
    border-radius: 20px 20px 20px 20px;
    margin-bottom: 15px;
}
.content .projects .project-card .contain .image-project{height: 138px!important}
.container {
padding-right: 10px;
padding-left: 10px;}
.most-watched {
    margin-bottom: 20px;
}
h3.blog-heading {
    padding: 1px 3px 19px 0;
}
@endif
</style>

@if(Helper::get_device()=='tab')
<style>
.certificate .post .items .info span {
	max-width: 100%!important;
}
@media (min-width: 840px) and (max-width: 1366px) {
	.content section .projects{
		height:530px
	}
	.container {
    max-width: 808px;
    padding: 0!important;
}
.note-example{    margin-bottom: 20px;}
.icoli1,.container>.col-md-8, .container>.col-md-4{
	max-width:100%;flex: auto;}
.blog-heading1 {
    margin: 105px 0 13px 0;
}
.content {
    max-width: 100%;
flex: auto;}
.about_d img{
max-width: 400px;
margin: 0 auto!important;
display: block;}
.blk_searh .discover-mobile .title h3 {
margin: 0 auto;
display: block;
background-position: 82% 3px;
}
.content .colmun2 {
width: 100%!important;
}
}
@media (min-width: 540px) and (max-width: 840px) {
.icoli1,.container>.col-md-8, .container>.col-md-4{
	max-width:100%;flex: auto;}
.blog-heading1 {margin: 112px 0 0px 0;}
.down-form-content .down-form {
    padding: 20px 76px!important;
    margin: 23px 0;
}
.about_d img{
max-width: 400px;
margin: 0 auto!important;
display: block;}
.blk_searh .discover-mobile .title h3 {
margin: 0 auto;
display: block;
background-position: 82% 3px;
}
.content {
    max-width: 100%;
flex: auto;}
#projects_2blk h3.blog-heading {
margin-right: 30px;}
.content .colmun2 {
width: 100%!important;
}
}
</style>
@endif
@endsection

<?php
    $page_title = $row->getSeoTitle();
    $media = $row->media;
?>
@extends('front.layout', [
    "page_title" => $page_title ? $page_title : $row->getTitle(),
    "page_description"  =>    $row->getSeoDescription(),
    "page_keywords"     =>    $row->getSeoKeywords(),
    "og_image"          =>    Helper::media_mob($media),
    "amp_url"  =>  route("amp.front.vacancies")
])
@section('main_content')

<article class="note-example">
    <section class="container" style="direction:<?=$current_lang=='en'?'ltr':'rtl' ?>">
        <h1 class="colored blog-heading blog-heading1"><?= $row->getTitle(); ?></h1>
        <div class="row">
            <aside class="icoli1 col-md-8 col-sm-8 col-12 p<?=$current_lang!='en'?'l':'r' ?>5">
                <div class="note wow fadeInUp" data-wow-duration="1.3s">
                    @if($media)
                        <div class="pic"><img src="<?= Helper::media_url($media); ?>"  style="width:100%" class="img-responsive" alt="<?= $page_title; ?>"></div>
                       
                    @endif
					<div class="blk_model mod5" style="clear:both">
                    <div class="clearfix"></div>
                    <div class="leaad">
                        <?= html_entity_decode($row->getContent()); ?>
                    </div>
                    </div>
                </div>

            </aside>
            <aside class="icoli2 content col-md-4 col-sm-4 col-12 pr5">
			
			<div class="leftbarfixed sidebar sticky"
			style="<?=Helper::get_device()=='full'?'width:355px;':'' ?>" >
			
			
			

				

				

				<?php if(Helper::get_device()=='full'){ ?>
				
			<div style="width:100%;height:391px" id="section_callcenter_left">
			
			</div>
                <!-- Start Certificate Client -->
                @include("front.partials.certificate", [ "full" => true ])
                <!-- End Certificate Client -->
				
				
				
						@include("front.partials.about_damass_full", [])
                <?php }else{ ?>

				
				
						<div class="colmun2">
                <!-- Start Certificate Client -->
                @include("front.partials.certificate", [ "full" => false ])
                <!-- End Certificate Client ee -->
		<div class="clearfix"></div>
		
		<!-- Start About Damas -->
                @include("front.partials.about_damass_mob", [])
                <!-- End About Damas -->
		</div>
			
			
			
			<?php } ?>
		
			</div>
            </aside>
        </div>
    </section>
</article>

@endsection



@section('scriptjs')

	
@if(Helper::get_device()=='full')

<input type="hidden" value="0" id="scrollv"/>
<script>

window.onload = function(){
$("#section_callcenter_left").css('height',$('.pic').height());

if($('.icoli2').height()>$('.icoli1').height())
return false;


var top_bsearch_elems_height =0;
if($("#section_callcenter_left").length > 0)
top_bsearch_elems_height = top_bsearch_elems_height + $('#section_callcenter_left').height()-85;



/*
if($(".certificate").length > 0)
top_bsearch_elems_height = top_bsearch_elems_height + $('.certificate').height()-50;*/


var bot_bsearch_elems_height=$('.about-damas').height()+$('.certificate').height()+300;

var $sticky = $('.sticky');
var rightpx=$(window).width() - ($sticky.offset().left + $sticky.outerWidth());

var test=false;
$(window).scroll(function(){



var scrollTop  = $(window).scrollTop();
var d_search_top = $('.certificate').offset().top - scrollTop;
var d_footer_top = $('footer').offset().top - scrollTop;
/*
var w1=;
var w2=;
var t1=;*/


if( $('#scrollv').val() < $(window).scrollTop() ){
		test=false;
		/*console.log('B');*/
		var windowTop = $(window).scrollTop();
		$('#scrollv').val(windowTop);
		if(d_search_top>118){
			$sticky.css({position: 'initial', top: 'initial'});
		}else if ( d_footer_top> bot_bsearch_elems_height ) {
			$sticky.css({ position: 'fixed', top: -1*top_bsearch_elems_height <?= ($current_lang=='en')?',right:rightpx':''?> });
		}else {
			$sticky.css({ position: 'absolute', top: 'auto',bottom:0,right: 'auto' });
		}
	}else{
		/*console.log('T');*/
		var windowTop = $(window).scrollTop();
		$('#scrollv').val(windowTop);
		if($sticky.offset().top<bot_bsearch_elems_height-300 && test===false){
			test=true;
			$sticky.css({position: 'initial', top: 'initial'});
		}else if(test===false){
		if(bot_bsearch_elems_height>=d_footer_top){
			$sticky.css({ position: 'absolute', top: 'auto',bottom:0,right: 'auto' });
		}else {
			$sticky.css({ position: 'fixed', top: -1*top_bsearch_elems_height <?= ($current_lang=='en')?',right:rightpx':''?> });
		}
		}
	}
    });
};
</script>
@endif


@endsection