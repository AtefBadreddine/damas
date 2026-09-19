<?php

$testimonials = Helper::query("Testimonial", "all");
$cnt_testimonials = 0;
foreach($testimonials as $tes){
	if(trim($tes->getContent())!='')
		$cnt_testimonials++;
}

if($cnt_testimonials>0){
?>
<!-- Testimonials -->
<div class="int_content testimonials int">

    <h2 class="sub_title int jazzira_font_bold"><?= trans("front.testimonials"); ?></h2>

    <div class="wrapper sec">
        <div class="slider video_slider"  <?php if ($current_lang == 'ar' || $current_lang == 'pe') { ?>  dir="rtl"  <?php } else { ?>  dir="ltr" <?php } ?>>
            <div class="slider__wrap swiper-wrapper">
                <?php
                $ci = -1;
                ?>
                @foreach($testimonials as $tes)
				@if(trim($tes->getContent())!='')
                <div class="item swiper-slide">
                    <div class="content sec shadow_type">
                        <div class="view_cont">
                            <div class="int_cont image">
                                <a data-fancybox="testimonials" href="{{ $tes->getVideo() }}">
                                    <?php /*<img class="lazy" data-src="<?= Helper::get_thumbnail($tes->background, 302, 207) ?>" alt="damasturk"/>*/ ?>
									
									{!! Helper::get_pic(Helper::get_thumbnail($tes->background, 302, 207),'lazy','','','damasturk', '') !!}
                                </a>
                            </div>
                        </div>
                        <div class="title">
                            <?php /*<img class="lazy" <?= isset($ajax) ? '' : 'data-' ?>src="<?= Helper::get_thumbnail($tes->photo, 80, 80) ?>"  alt="testimonials" />*/ ?>
							
							{!! Helper::get_pic(Helper::get_thumbnail($tes->photo, 80, 80),'lazy','','','damasturk', '') !!}
							
                            <h2 class="jazzira_font_bold" title="{{$tes->getName()}}   {{$tes->getJob()}} ">{{$tes->getName()}}   {{$tes->getJob()}} </h2>
                        </div>
                        <div class="features_sec">
                            <p>
                                “ {{$tes->getContent()}} ” 
                            </p>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>

            <div class="slider__controls">

                <div class="slider__pagination"></div>

                <div class="slider__button-next"></div>
                <div class="slider__button-prev"></div>
            </div>

        </div>
    </div>
</div>
<?php } ?>




