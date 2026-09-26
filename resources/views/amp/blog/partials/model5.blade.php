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
    <!--<aside class="col-md-6 col-sm-6 col-xs-12">-->

    @foreach($posts as $k => $post)
    <?php if ($k <= 1): ?>
        <aside class=" col-md-6 col-sm-6 col-xs-12">
            <div class="global-new-item">
                <aside class="news-item">
                    <amp-img src="<?= Helper::media_url($post->photoCard); ?>" width="533" height="533" layout="responsive" alt="{{ $post->getTitle() }}"></amp-img>
                </aside>
                <h4 class="colored"><a href="<?= $post->frontUrl(); ?>"><?= $post->getTitle(); ?></a></h4>
            </div>
        </aside>
    <?php else: ?>
        <aside class=" col-md-6 col-sm-6 col-xs-12">
            <div class="global-new-item row">
                <aside class="news-item">
                    <a href="<?= $post->frontUrl(); ?>">
                        <amp-img src="<?= Helper::media_url($post->photoCard); ?>" width="533" height="533" layout="responsive" alt="{{ $post->getTitle() }}"></amp-img>
                    </a>
                </aside>
                <aside class=" col-md-6 col-sm-6 col-xs-12">
                    <h4 class="colored"><a href="<?= $post->frontUrl(); ?>"><?= $post->getTitle(); ?></a></h4>
                    <p><?= Helper::str_limit($post->getContent()); ?></p>
                </aside>
            </div>
        </aside>
    <?php endif; ?>
    @endforeach

    <div class="col-sm-12 col-xs-12 text-center">
        <a href="<?= $section->link_click; ?>" class="more"><?= trans("front.more posts"); ?></a>
    </div>

    <!--<aside class="col-md-12 col-sm-12 col-xs-12">
        <div>
            <button class="read-more">  المزيد </button>
        </div>
    </aside>-->
</div>