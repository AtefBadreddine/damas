<aside class="col-md-12 col-sm-1 col-xs-12 videos">
    <div class="row">
        @if($section->show_title)
        <h3 class="colored blog-heading">
            @if($section->link_click) 
            <a href="<?= $section->link_click; ?>"><?= $section->getTitle(); ?></a>

            @else
            <?= $section->getTitle(); ?>
            @endif
        </h3>
        @endif
        <div class="clearfix"></div>
        <div class="row">
            @foreach($posts as $post)
            <aside class="col-md-4 col-sm-6 col-xs-12">
                <div class="global-new-item wow fadeIn" data-wow-duration="1s" data-wow-offset="200">
                    <aside class="news-item">
                        <amp-img src="<?= Helper::media_url($post->photoCard); ?>" width="533" height="533" layout="responsive" alt="{{ $post->getTitle() }}"></amp-img>
                        <a href="<?= route("front.blog.post", $post->slug); ?>">
                            <div class="layer">
                                <ul>
                                    <li><i class="flaticon-play-button"></i></li>
                                </ul>
                            </div>
                        </a>
                    </aside>
                    <h4 class="colored"><a href="<?= route("front.blog.post", $post->slug); ?>"><?= $post->getTitle(); ?></a></h4>
                </div>
            </aside>
            @endforeach

            <div class="col-sm-12 col-xs-12 text-center">
                <a href="<?= $section->link_click; ?>" class="more"><?= trans("front.more posts"); ?></a>
            </div>
        </div>
    </div>
</aside>
<div class="clearfix"></div>