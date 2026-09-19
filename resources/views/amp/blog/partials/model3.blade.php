@if($section->show_title)
<h3 class="colored blog-heading">
    @if($section->link_click) 
    <a href="<?= $section->link_click; ?>"><?= $section->getTitle(); ?></a>

    @else
    <?= $section->getTitle(); ?>
    @endif
</h3>
@endif

@foreach($posts as $k => $post)
@if($k==0)
<div class="global-new-item">
    <aside class="news-item">
        <amp-img src="<?= Helper::media_url($post->photoCard); ?>" width="533" height="533" layout="responsive" alt="{{ $post->getTitle() }}"></amp-img>
    </aside>
    <h4 class="colored"><?= $post->getTitle(); ?></h4>
    <p><?= Helper::str_limit($post->getContent()); ?></p>
    <p><a href="<?= route("front.blog.post", $post->slug); ?>"> قراءة المزيد </a></p>
</div>
@else
<div class="media my-media">
    <div class="media-left">
        <a href="<?= route("front.blog.post", $post->slug); ?>">
            <amp-img src="<?= Helper::media_url($post->photoCard); ?>" width="100" height="100" alt="{{ $post->getTitle() }}"></amp-img>
        </a>
    </div>
    <div class="media-body">
        <h4 class="media-heading colored"><a href="<?= route("front.blog.post", $post->slug); ?>"><?= $post->getTitle(); ?></a></h4>
    </div>
</div>
@endif
@endforeach


<div class="col-sm-12 col-xs-12 text-center">
    <a href="<?= $section->link_click; ?>" class="more"><?= trans("front.more posts"); ?></a>
</div>


