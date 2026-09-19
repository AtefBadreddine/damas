
<style>
    .pages_slider_links{
        margin: 0px 0px 10px 0px;
    }
    .pages_slider_links .cont{
        float: left;
        width: 100%;
        height: 190px;
        background-color: #ffffff;
        border-radius: 10px;
        overflow: hidden;
    }
    .pages_slider_links a.link{
        float: left;
        width: 100%;
        height: 160px;
        overflow: hidden;
    }
    .pages_slider_links a.link img{
        float: left;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.3s;
    }
    .pages_slider_links a.title{
        float: left;
        width: 100%;
        height: 30px;
        padding: 2px;
        text-align: center;
        transition: all 0.3s;
    }
    .pages_slider_links a.title p{
        float: left;
        width: 100%;
        font-size: 16px;
        color: #058687;
        margin: 0px;
        transition: all 0.3s;
    }
    .pages_slider_links .item:hover a.link img{
        transform: scale(1.1);
        transition: all 0.3s;
    }
    .pages_slider_links .item:hover a.title{
        background-color: #058687;
        transition: all 0.3s;
    }
    .pages_slider_links .item:hover a.title p{
        color: #ffffff;
        transition: all 0.3s;
    }
    h2.sub_title.pages_slider_links_title{
        text-align: center;
        width: 100%;
        margin: 10px 0px 5px 0px;
        color: #b52049;
    }

    .district_type .cont {
        height: 280px;
    }
    .district_type a.link {
        height: 245px;
    }
    .district_type a.title {
        height: 35px;
        padding: 2px;
    }


    @media (max-width: 500px){
        .pages_slider_links .slider__controls{
            display: none;
        }
        h2.sub_title.pages_slider_links_title{
            margin: 10px 0px 5px 0px;
        }
    }
</style>

<h2 class="sub_title jazzira_font_bold pages_slider_links_title" onclick="capture()"><?= trans("front.The most important regions in") . ' ' . $region->city->getName(); ?> </h2>

<div class="wrapper sec">
    <div class="slider pages_slider_links" <?php if ($current_lang == 'ar') { ?>  dir="rtl"  <?php } else { ?>  dir="ltr" <?php } ?>>
        <div class="slider__wrap swiper-wrapper">
			<?php
			foreach($regions as $reg){ ?>
            <div class="item swiper-slide district_type">
                <div class="cont shadow_type">
                    <a class="link" href="{{ route('front.districts',[$reg->city->slug,$reg->slug]) }}" title="<?= $reg->getName() ?>">
                        <img class="" alt="<?= trans("front.DistrictsIstanbul"); ?>" title="<?= trans("front.DistrictsIstanbul"); ?>" src="{{ Helper::media_url($reg->primaryphoto) }}" width="200" height="150">
                    </a>
                    <a class="title" href="{{ route('front.districts',[$reg->city->slug,$reg->slug]) }}" title="<?= trans("front.DistrictsIstanbul"); ?>"> <p>{{ $reg->getName() }}</p> </a>
                </div> 
            </div> 
			<?php } ?>

        </div>

        <div class="slider__controls">
            <div class="slider__button-next"></div>
            <div class="slider__button-prev"></div>
        </div>

    </div>
</div>


