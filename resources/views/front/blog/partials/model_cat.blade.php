	<div class="mod4">
	<aside class="col-md-12 col-sm-1 col-12 videos">
    <div class="clearfix"></div>
    <div class="row">
	<?php $i=0;
	?>
        @foreach($posts as $post)
		<?php
		$i++;
		?>
        <aside class="col-md-4 col-sm-6 col-12 pl5 pr5">
            <div class="global-new-item wow fadeIn" data-wow-duration="1s" data-wow-offset="200" style="min-height:230px;">
                <aside class="news-item">
				<?php
				$w=338;
				$h=190;
				if(Helper::get_device()!='full'){
					$w=400;
					$h=400;
				}
				?>
					<img src="<?= Helper::get_thumbnail($post->photoCard, $w, $h); ?>" alt="<?= $post->getTitle(); ?>" class="img-responsive">
                    <a href="<?= route("front.blog.post", $post->slug); ?>">
                        <div class="layer">
                            <ul>
                                <li><i class="flaticon-play-button"></i></li>
                            </ul>
                        </div>
                    </a>
                </aside>
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <h2 class="colored"><a href="<?= route("front.blog.post", $post->slug); ?>"><?= $post->getTitle(); ?></a></h2>
                    </div>
                </div>
            </div>
        </aside>
		<?php 
		/*if($i>$start+$limit){
			break;
		}*/
		if(isset($limit) and $i>=5)
			break;
		?>
        @endforeach
		
    </div>
</aside>
</div>
<div class="clearfix"></div>
