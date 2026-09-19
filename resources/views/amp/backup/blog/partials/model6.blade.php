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
    <div class="global-new-item">
        <aside class="news-item">
            <amp-img src="<?= Helper::media_url($post->photoCard); ?>" width="533" height="533" layout="responsive" alt="{{ $post->getTitle() }}"></amp-img>
        </aside>
        <h4 class="colored"><a href="<?= route("front.blog.post", $post->slug); ?>"><?= $post->getTitle(); ?></a></h4>
    </div>
@endforeach
