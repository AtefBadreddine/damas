@if($section->show_title)
<h3 class="colored blog-heading">
    <i class="<?= $section->icon ?>"></i>
    @if($section->link_click) 
    <a href="<?= $section->link_click; ?>"><?= $section->getTitle(); ?></a>
    @else
    <?= $section->getTitle(); ?>
    @endif
</h3>
@endif

<div class="blk_model mod3 blk_mod_mod3">
    @foreach($posts as $k => $post)
    @if($k==0 and Helper::get_device()!='tab')
    <div class="global-new-item wow fadeIn" data-wow-duration="1s" data-wow-offset="200">
        <aside class="news-item">
            <a href="<?= route("front.blog.post", $post->slug); ?>">
                <img src="<?= Helper::get_thumbnail($post->photoCard, 600, 600, true); ?>" alt="<?= $post->getTitle(); ?>" class="img-responsive">
            </a>
        </aside>
        <div class="colored"><a href="<?= route("front.blog.post", $post->slug); ?>"><?= $post->getTitle(); ?></a></div>
        <p><?= Helper::str_limit($post->getContent()); ?></p>
        <p><a href="<?= route("front.blog.post", $post->slug); ?>" class="readmoretxt"><?= trans("front.more posts"); ?></a></p>
    </div>
    @else
    <div class="media my-media wow fadeIn btmro" data-wow-duration="1s" data-wow-offset="200">
        <div class="media-left">
            <a href="<?= route("front.blog.post", $post->slug); ?>">
                <img src="<?= Helper::get_thumbnail($post->photoCard, 100, 100, true); ?>" width="100" height="100" alt="<?= $post->getTitle(); ?>">
            </a>
        </div>
        <div class="media-body">
            <h2 class="media-heading colored"><a href="<?= route("front.blog.post", $post->slug); ?>"><?= $post->getTitle(); ?></a></h2>
        </div>
    </div>
    @endif
    @endforeach


    @if($section->show_title)
    @if($section->link_click)
    <div style="display:flex;align-items:center;justify-content:center;">
        <a href="<?= $section->link_click; ?>" class="pull-left more"
           style="margin:0"><?= trans("front.more posts"); ?></a></div>
    @endif
    @endif

</div>



<!-- share links -->
@if(Helper::get_device()=='mob')
@include("front.partials.share_links", [])
@endif