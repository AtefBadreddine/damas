
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
<div class="blk_model">
    <div class="row">
        <?php
        $w = 397;
        $h = 198;
        if (Helper::get_device() != 'full') {
            $w = 400;
            $h = 400;
        }
        ?>
        @foreach($posts as $k => $post)
        @if($k==0)
        <aside class="col-md-6 col-sm-6 col-12">
            <div class="0" data-wow-duration="1s" data-wow-offset="200" style="height: 322px;">
                <aside class="news-item">
                    <a href="<?= $post->frontUrl(); ?>">
                        <img src="<?= Helper::get_thumbnail($post->photoCard, $w, $h); ?>" alt="<?= $post->getTitle(); ?>" class="img-responsive" style="width:100%"/>
                    </a>
                </aside>
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <h2 class="colored"><a href="<?= $post->frontUrl(); ?>"><?= $post->getTitle(); ?></a></h2>
                    </div>
                </div>
                <p class="clearfix"><?= Helper::str_limit($post->getContent()); ?></p>
                <!--<a href=""> قراءة المزيد </a>-->
            </div>
            @elseif($k==1)
            <div class="media my-media col-12 wow fadeIn" data-wow-duration="1s" data-wow-offset="200">
                <div class="media-left">
                    <a href="<?= $post->frontUrl(); ?>">
                        <img class="media-object" src="<?= Helper::get_thumbnail($post->photoCard, 100, 100, true); ?>" alt="<?= $post->getTitle(); ?>">
                    </a>
                </div>
                <div class="media-body">
                    <div class="media-heading colored"><a href="<?= $post->frontUrl(); ?>"><?= $post->getTitle(); ?></a></div>
                </div>
            </div>
        </aside>
        <aside class="col-md-6 col-sm-6 col-12"  style="padding:0 13px 0 3px">
            @else
            <div class="media my-media col-12 wow fadeIn" data-wow-duration="1s" data-wow-offset="200">
                <div class="media-left">
                    <a href="<?= $post->frontUrl(); ?>">
                        <img class="media-object" src="<?= Helper::get_thumbnail($post->photoCard, 100, 100, true); ?>" alt="<?= $post->getTitle(); ?>">
                    </a>
                </div>
                <div class="media-body">
                    <div class="media-heading colored"><a href="<?= $post->frontUrl(); ?>"><?= $post->getTitle(); ?></a></div>
                </div>
            </div>
            @endif
            @endforeach
        </aside>

        @if($section->link_click) 
        <a href="<?= $section->link_click; ?>" class="pull-left more"><?= trans("front.more posts"); ?></a>
        @endif
    </div>

</div>




<!-- share links -->
@if(Helper::get_device()=='mob')
@include("front.partials.share_links", [])
@endif