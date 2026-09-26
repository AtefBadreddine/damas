<div>
    @if($section->show_title)
    <h3 class="colored blog-heading">
        @if($section->link_click) 
        <a href="<?= $section->link_click; ?>"><?= $section->getTitle(); ?></a>

        @else
        <?= $section->getTitle(); ?>
        @endif
    </h3>
    @endif
    <div class="row">

        @foreach($posts as $k => $post)
        @if($k==0)
        <aside class="col-md-6 col-sm-6 col-xs-12">
            <div class="global-new-item">
                <aside class="news-item">
                    <amp-img src="<?= Helper::media_url($post->photoCard); ?>" width="533" height="533" layout="responsive" alt="{{ $post->getTitle() }}"></amp-img>
                </aside>
                <h4 class="colored"><a href="<?= $post->frontUrl(); ?>"><?= $post->getTitle(); ?></a></h4>
                <p class="clearfix"><?= Helper::str_limit($post->getContent()); ?></p>
                <!--<a href=""> قراءة المزيد </a>-->
            </div>
        </aside>

        @else
        <div class="col-sm-12 col-xs-12">
            <div class="media my-media wow fadeIn" data-wow-duration="1s" data-wow-offset="200">
                <div class="media-left">
                    <a href="<?= $post->frontUrl(); ?>">
                        <amp-img class="media-object" src="<?= Helper::media_url($post->photoCard); ?>" width="100" height="100" alt="{{ $post->getTitle() }}"></amp-img>
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading colored"><a href="<?= $post->frontUrl(); ?>"><?= $post->getTitle(); ?></a></h4>
                </div>
            </div>
        </div>
        @endif
        @endforeach

        <div class="col-sm-12 col-xs-12 text-center">
            <a href="<?= $section->link_click; ?>" class="more"><?= trans("front.more posts"); ?></a>
        </div>
    </div>
</div>