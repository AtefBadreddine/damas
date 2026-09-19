
	<div class="mod4 mod4_full">
	<aside class="col-md-12 col-12 videos">
    <div class="clearfix"></div>
    <div class="row">
        @foreach($posts as $post)
        <aside class="col-12  pl5 pr5">
            <div class="global-new-item" style="">
                <aside class="news-item row">
				<?php
				$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
				$w=570;
				$h=303;
				?>
					<div class="col-6 cardpost">
<div class="share project-social">
<i class="flaticon-share cshare"></i>
<a href="#" class="likeCardItem" data-url="<?= route("front.likeitem"); ?>" 
data-typ="post" data-code="<?= $post->id; ?>">
<i class="fa fa-<?= in_array($post->id, session()->get("likedposts.ids", [])) ? 'heart' : 'heart-o'; ?>"></i></a>
<span class="pull-right social shareBtnsFloating" data-url="<?= route('front.blog.post', $post->slug); ?>" data-text="<?= $post->getTitle(); ?>">
<a href="#" class="btnshare" data-network="facebook"><i class="fa fa-facebook"></i></a>
<a href="#" class="btnshare" data-network="whatsapp"><i class="fa fa-whatsapp"></i></a>
</span>
</div>



						<a href="<?= route("front.blog.post", $post->slug); ?>" class="hrefpic">
						<img class="lazyimg img-responsive" src="<?= $emptypic ?>" data-src="<?= Helper::get_thumbnail($post->photoCard, $w, $h); ?>" alt="<?= $post->getTitle(); ?>">
						</a>
					</div>
					<div class="col-6 parag">
						<h2 class="colored"><a href="<?= route("front.blog.post", $post->slug); ?>"><?= $post->getTitle(); ?></a></h2>	
						<p>
						<?= Helper::str_limit($post->getContent(),(LaravelLocalization::getCurrentLocale()=='en'?140:200)); ?>
						</p>
						<div class="continue-reading"><a target="_blank" href="<?= route("front.blog.post", $post->slug); ?>">{{ trans('front.continue reading')}}</a></div>
					</div>
                </aside>
            </div>
        </aside>
        @endforeach
		
    </div>
</aside>
</div>
<div class="clearfix"></div>
