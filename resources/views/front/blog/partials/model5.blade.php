@if($section->show_title)
    <h3 class="colored blog-heading">
<i class="<?=$section->icon?>"></i>
        @if($section->link_click) 
            <a href="<?= $section->link_click; ?>"><?= $section->getTitle(); ?></a>
        @else
            <?= $section->getTitle(); ?>
        @endif
    </h3>
@endif
	<div class="blk_model mod5">
<div class="row" style="margin-top:20px">
    <!--<aside class="col-md-6 col-sm-6 col-xs-12">-->
        <?php
				$w=397;
				$h=198;
				if(Helper::get_device()!='full'){
					$w=400;
					$h=400;
				}
				?>
    @foreach($posts as $k => $post)
        <?php if($k<=1): ?>
            <aside class=" col-md-6 col-sm-6 col-xs-12 pr5 pl5">
                <div class="global-new-item topr wow fadeIn" data-wow-duration="1s" data-wow-offset="200">
                    <aside class="news-item" style="margin-bottom:20px">
                        <a href="<?= route("front.blog.post", $post->slug); ?>">
                            <img src="<?= Helper::get_thumbnail($post->photoCard, $w, $h ); ?>" alt="<?= $post->getTitle(); ?>" class="img-responsive">
                        </a>
                    </aside>
                    <h2 class="colored"><a href="<?= route("front.blog.post", $post->slug); ?>"><?= $post->getTitle(); ?></a></h2>
                </div>
            </aside>
        <?php else: ?>
            <aside class=" col-md-6 col-sm-6 col-12  pr5 pl5" style="overflow: hidden">
                <div class="global-new-item btmr row wow fadeIn" data-wow-duration="1s" data-wow-offset="200" style="margin: 10px 0px 0px; padding: 0px;">
                    <aside class="news-item col-md-5 col-sm-5 col-12" style="">
                        <a href="<?= route("front.blog.post", $post->slug); ?>">
						<?php
				$w=178;
				$h=150;
				if(Helper::get_device()!='full'){
					$w=400;
					$h=400;
				}
				?>
                <img src="<?= Helper::get_thumbnail($post->photoCard, $w, $h, true); ?>" alt="<?= $post->getTitle(); ?>" class="img-responsive" style="height:100%">
                        </a>
                    </aside>
                    <aside class=" col-md-7 col-sm-7 col-12">
                        <div class="colored"><a href="<?= route("front.blog.post", $post->slug); ?>"><?= $post->getTitle(); ?></a></div>
                        <p><?= Helper::str_limit($post->getContent(), 50); ?></p>
                    </aside>
                </div>
            </aside>
        <?php endif; ?>
    @endforeach
        
		@if($section->show_title)
        @if($section->link_click) 
            <a href="<?= $section->link_click; ?>" class="pull-left more"><?= trans("front.more posts"); ?></a>
        @endif
        @endif
    
    <!--<aside class="col-md-12 col-sm-12 col-xs-12">
        <div>
            <button class="read-more">  المزيد </button>
        </div>
    </aside>-->
</div>
</div>