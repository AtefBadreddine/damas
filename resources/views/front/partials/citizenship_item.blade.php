<?php
//Helper::get_project_flavors(1);
$current_lang = LaravelLocalization::getCurrentLocale();
$is_mobile = Helper::is_mobile();
$infos = Helper::get_params();
$flavor=array();
$cardphoto = $post->media;
?>

<div class="post-card project-card <?=isset($class)?$class:''?> cardpost">
<div class="share project-social">
<i class="flaticon-share cshare"></i>

<a href="#" class="likeCardItem" data-url="<?= route("front.likeitem"); ?>" 
data-typ="post" data-code="<?= $post->id; ?>">
<i class="fa fa-<?= in_array($post->id, session()->get("likedposts.ids", [])) ? 'heart' : 'heart-o'; ?>"></i></a>

<span class="pull-right social shareBtnsFloating" data-url="<?= $post->frontUrl(); ?>" data-text="<?= $post->getTitle(); ?>">
<a href="#" class="btnshare" data-network="facebook"><i class="fa fa-facebook"></i></a>
<a href="#" class="btnshare" data-network="whatsapp"><i class="fa fa-whatsapp"></i></a>
</span>

</div>
<div class="contain" id="container">
<div class="image-project">
<a href="<?= route('front.turkish_citizenship'); ?>" <?= $open_blank == true ? 'target="_blank"' : ''; ?>>

<?php
$iw=360;
$ih=280;
if(!$is_mobile){
$iw=360;
$ih=196;
}else{
$iw=360;
$ih=360;
}
?>

<img class="<?= isset($ajax)?'':'lazyimg' ?> img-responsive" <?= isset($ajax)?'':'data-' ?>src="<?= Helper::get_thumbnail($cardphoto, $iw, $ih); ?>" alt="<?= $cardphoto?$cardphoto->getDescription():''; ?>">

</a>
</div>


<!--
<div class="title-project">
	
</div>-->


<div style="clear:both"></div>
<div class="about-project">
<a href="<?= route('front.turkish_citizenship'); ?>"><?= $post->getTitle(); ?></a>
</div>
<div style="clear:both"></div>




<?php /*if(!$is_mobile){ ?>
<div class="details"><a href="<?= $post->frontUrl(); ?>" <?= $open_blank == true ? 'target="_blank"' : ''; ?>  class="button"><?=trans('front.details')?></a></div>
<?php }*/ ?>

</div>
</div>