
@if($section->show_title and !isset($hide_title))
<h3 class="colored blog-heading">
    <i class="<?= $section->icon ?>"></i>
    @if($section->link_click) 
    <a href="<?= $section->link_click; ?>"><?= $section->getTitle(); ?></a>
    @else
    <?= $section->getTitle(); ?>
    @endif
</h3>
@endif
<div class="blk_model mod4">
    <aside class="col-md-12 col-sm-1 col-12 videos">
        <div class="clearfix"></div>
        <div class="row">
            @foreach($posts as $post)
            <aside class="col-md-4 col-sm-6 col-12  pl5 pr5">
                <div class="global-new-item wow fadeIn" data-wow-duration="1s" data-wow-offset="200" style="min-height:230px;">
                    <aside class="news-item">
                        <?php
                        $w = 254;
                        $h = 143;
                        if (Helper::get_device() != 'full') {
                            $w = 400;
                            $h = 400;
                        }
                        ?>
                        <img src="<?= Helper::get_thumbnail($post->photoCard, $w, $h); ?>" alt="<?= $post->getTitle(); ?>" class="img-responsive" />
                        <a href="<?= $post->frontUrl(); ?>">
                            <div class="layer">
                                <ul>
                                    <li><i class="flaticon-play-button"></i></li>
                                </ul>
                            </div>
                        </a>
                    </aside>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <h2 class="colored"><a href="<?= $post->frontUrl(); ?>"><?= $post->getTitle(); ?></a></h2>
                        </div>
                    </div>
                </div>
            </aside>
            @endforeach
            @if($section->link_click) 
            <a href="<?= $section->link_click; ?>" class="pull-left more"><?= trans("front.more posts"); ?></a>
            @endif
        </div>
    </aside>
</div>
<div class="clearfix"></div>



<!-- share links -->
@if(Helper::get_device()=='mob')
@include("front.partials.share_links", [])
@endif