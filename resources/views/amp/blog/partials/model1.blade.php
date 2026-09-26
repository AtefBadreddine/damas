@if($section->show_title)
    <h1 class="colored text-center"><?= $section->getTitle(); ?></h1>
@endif
<!-- start slider -->
<article class="sliding3">
    <section class="container-fluid">
        <div class="owl-carousel owl-theme">

            @foreach($posts->take(5) as $k => $post)
                <?php $img = Helper::media_url($post->photoCard); ?>
                <?php ob_start(); ?>
                    <a href="<?= $post->frontUrl(); ?>" class="<?= $k==0?'first':''; ?>">
                        <amp-img src="<?= $img; ?>" width="533" height="533" layout="responsive" alt="{{ $post->getTitle() }}"></amp-img>
                        <span class="banner"> <i class="flaticon-like"></i> </span>
                        @if($k==0)
                        <div class="layer">
                            <h3><?= $post->getTitle(); ?></h3>
                        </div>
                        @endif
                    </a>
                <?php $item_slide = ob_get_clean(); ?>
                @if($k==0)
                    <div class="item col-xs-12" data-merge="1">
                        <?= $item_slide; ?>
                    </div>
                @else
                    @if($k%2==0)
                        <?= $item_slide.'</div>'; ?>
                    @else
                        <?= '<div class="item col-xs-6">'.$item_slide; ?>
                        <?= count($posts)-1==$k?"</div>":""; ?>
                    @endif
                @endif
            @endforeach
            <div class="clearfix"></div>
            <br>
            <div class="clearfix">
                @include("amp.partials.call_us_small", ["form_type" => "Blog - Up"])
            </div>

        </div>
    </section>
</article>
<!-- end slider -->
<div class="clearfix"></div>