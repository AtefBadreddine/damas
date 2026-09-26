@if($section->show_title)
    <h3 class="colored blog-heading">
        @if($section->link_click) 
            <a href="<?= $section->link_click; ?>"><?= $section->getTitle(); ?></a>
            <a href="<?= $section->link_click; ?>" class="pull-left more"><?= trans("front.more posts"); ?></a>
        @else
            <?= $section->getTitle(); ?>
        @endif
    </h3>
@endif

@foreach($posts as $k => $post)
    <div class="global-new-item wow fadeIn" data-wow-duration="1s" data-wow-offset="200">
        <aside class="news-item">
				<?php
				$w=397;
				$h=198;
				if(Helper::get_device()!='full'){
					$w=296;
					$h=148;
				}
				?>
            <a href="<?= $post->frontUrl(); ?>">
                <img src="<?= Helper::get_thumbnail($post->photoCard, $w, $h); ?>" alt="<?= $post->getTitle(); ?>" class="img-responsive"/>
            </a>
        </aside>
        <h2 class="colored"><a href="<?= $post->frontUrl(); ?>"><?= $post->getTitle(); ?></a></h2>
    </div>
@endforeach
