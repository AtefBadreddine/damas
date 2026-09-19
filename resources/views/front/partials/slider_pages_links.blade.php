
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

    @media (max-width: 500px){
        .pages_slider_links .slider__controls{
            display: none;
        }
        h2.sub_title.pages_slider_links_title{
            margin: 10px 0px 5px 0px;
        }
    }
</style>

<h2 class="sub_title jazzira_font_bold pages_slider_links_title"><?= trans("front.useful links"); ?></h2>

<div class="wrapper sec">
    <div class="slider pages_slider_links" <?php if ($current_lang == 'ar') { ?>  dir="rtl"  <?php } else { ?>  dir="ltr" <?php } ?>>
        <div class="slider__wrap swiper-wrapper">

            <div class="item swiper-slide">
                <div class="cont shadow_type">
                    <a class="link" href="<?= route("front.search", ["apartments-for-sale", "istanbul"]) ?>" title="<?= trans("front.Istanbul apartments"); ?>">
                        <img class="lazy" alt="<?= trans("front.Istanbul apartments"); ?>" title="<?= trans("front.Istanbul apartments"); ?>" loading="lazy" src="/img/pages-links/apartments.jpg" width="200" height="150"> 
                    </a>
                    <a class="title" href="<?= route("front.search", ["apartments-for-sale", "istanbul"]) ?>" title="<?= trans("front.Istanbul apartments"); ?>"> <p><?= trans("front.Istanbul apartments"); ?></p> </a>
                </div> 
            </div> 

            <div class="item swiper-slide">
                <div class="cont shadow_type">
                    <a class="link" href="<?= route("front.search", ["villas-for-sale", "istanbul"]) ?>" title="<?= trans("front.Istanbul villas"); ?>">
                        <img class="lazy" alt="<?= trans("front.Istanbul villas"); ?>" title="<?= trans("front.Istanbul villas"); ?>" loading="lazy" src="/img/pages-links/villas.jpg" width="200" height="150"> 
                    </a>
                    <a class="title" href="<?= route("front.search", ["villas-for-sale", "istanbul"]) ?>" title="<?= trans("front.Istanbul villas"); ?>"> <p><?= trans("front.Istanbul villas"); ?></p> </a>
                </div> 
            </div> 

            <div class="item swiper-slide">
                <div class="cont shadow_type">
                    <a class="link" href="{{ route('front.turkish_citizenship') }}" title="<?= trans("front.TurkishCitizenship"); ?>">
                        <img class="lazy" alt="<?= trans("front.TurkishCitizenship"); ?>" title="<?= trans("front.TurkishCitizenship"); ?>" loading="lazy" src="/img/pages-links/turkish-citizenship.jpg" width="200" height="150"> 
                    </a>
                    <a class="title" href="{{ route('front.turkish_citizenship') }}" title="<?= trans("front.TurkishCitizenship"); ?>"> <p><?= trans("front.TurkishCitizenship"); ?></p> </a>
                </div> 
            </div> 

            <div class="item swiper-slide">
                <div class="cont shadow_type">
                    <a class="link" href="{{ route('front.investment') }}" title="<?= trans("front.InvestmentTurkey"); ?>">
                        <img class="" alt="<?= trans("front.InvestmentTurkey"); ?>" title="<?= trans("front.InvestmentTurkey"); ?>" src="/img/pages-links/investment.jpg" width="200" height="150"> 
                    </a>
                    <a class="title" href="{{ route('front.investment') }}" title="<?= trans("front.InvestmentTurkey"); ?>"> <p><?= trans("front.InvestmentTurkey"); ?></p> </a>
                </div> 
            </div> 

            <div class="item swiper-slide">
                <div class="cont shadow_type">
                    <a class="link" href="{{ route('front.legal') }}" title="<?= trans("front.Legal Affairs"); ?>">
                        <img class="" alt="<?= trans("front.Legal Affairs"); ?>" title="<?= trans("front.Legal Affairs"); ?>" src="/img/pages-links/legal.jpg" width="200" height="150"> 
                    </a>
                    <a class="title" href="{{ route('front.legal') }}" title="<?= trans("front.Legal Affairs"); ?>"> <p><?= trans("front.Legal Affairs"); ?></p> </a>
                </div> 
            </div> 

            <div class="item swiper-slide">
                <div class="cont shadow_type">
                    <a class="link" href="/<?= $current_lang ?>/istanbul-districts" title="<?= trans("front.DistrictsIstanbul"); ?>">
                        <img class="" alt="<?= trans("front.DistrictsIstanbul"); ?>" title="<?= trans("front.DistrictsIstanbul"); ?>" src="/img/pages-links/istanbul-districts.jpg" width="200" height="150"> 
                    </a>
                    <a class="title" href="/<?= $current_lang ?>/istanbul-districts" title="<?= trans("front.DistrictsIstanbul"); ?>"> <p><?= trans("front.DistrictsIstanbul"); ?></p> </a>
                </div> 
            </div> 

            <div class="item swiper-slide">
                <div class="cont shadow_type">
                    <a class="link" href="{{ route('front.living_turkey') }}" title="<?= trans("front.LivingTurkey2"); ?>">
                        <img class="" alt="<?= trans("front.LivingTurkey2"); ?>" title="<?= trans("front.LivingTurkey2"); ?>" src="/img/pages-links/living.jpg" width="200" height="150"> 
                    </a>
                    <a class="title" href="{{ route('front.living_turkey') }}" title="<?= trans("front.LivingTurkey2"); ?>"> <p><?= trans("front.LivingTurkey2"); ?></p> </a>
                </div> 
            </div> 

            <div class="item swiper-slide">
                <div class="cont shadow_type">
                    <a class="link" href="{{ route('front.turkey_guide') }}" title="<?= trans("front.turkey guide"); ?>">
                        <img class="" alt="<?= trans("front.turkey guide"); ?>" title="<?= trans("front.turkey guide"); ?>" src="/img/pages-links/turkey-guide.jpg" width="200" height="150"> 
                    </a>
                    <a class="title" href="{{ route('front.turkey_guide') }}" title="<?= trans("front.turkey guide"); ?>"> <p><?= trans("front.turkey guide"); ?></p> </a>
                </div> 
            </div> 

        </div>

        <div class="slider__controls">
            <div class="slider__button-next"></div>
            <div class="slider__button-prev"></div>
        </div>

    </div>
</div>