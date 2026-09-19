@section('styles')


<style>
<?php if (App::isLocal()) { ?>

<?php } else { ?>
    <?php include(public_path("css/all-" . LaravelLocalization::getCurrentLocale() . ".min.css")); ?>
<?php } ?>
    body{
        background-color: #7A7A7A;
    }
    .full-section-mob{
        float: left;
        width: 100%;
        height: auto;
        min-height: 520px;
        padding: 0px 23px;
    }
    .section-content{
        float: none;
        width: 100%;
        height: 100%;
        min-height: 520px;
        max-width: 400px;
        margin: auto;
        position: relative;
        border-radius: 8px;
        background-image: url(/img/quiz-bg2.jpg);
        background-size: cover;
        background-position: top;
        -webkit-box-shadow: 10px 10px 16px -8px rgba(61,61,61,1);
        -moz-box-shadow: 10px 10px 16px -8px rgba(61,61,61,1);
        box-shadow: 10px 10px 16px -8px rgba(61,61,61,1);
    }
    .plane{
        position: absolute;
        top: -3px;
        left: -74px;
        width: 95%;
        opacity: 0;
    }
    .ribbon{
        position: absolute;
        top: -12px;
        right: -17px;
        width: 115px;
        opacity: 0;
    }
    .form{
        position: absolute;
        top: 25%;
        width: 100%;
        padding: 15px;
        text-align: center;
        opacity: 0;
    }
    .form h2{
        float: left;
        width: 100%;
        font-size: 29px;
        font-weight: normal;
        text-align: center !important;
        margin-bottom: 15px;
        color: #132467;
        letter-spacing: -1px;
    }
    .form h2 strong{
        float: left;
        width: 100%;
        font-size: 22px;
    }
    .form .form-group{
        float: left;
        width: 100%;
        margin-bottom: 10px;
    }
    .form .form-group input{
        float: left;
        width: 100%;
        border-radius: 20px;
        border: none;
        padding: 10px;
        text-align: right;
        direction: rtl;
        height: 40px;
        color: #ffffff;
        line-height: 2;
        font-family: DroidNaskhRegular;
        background-color: rgba(66, 152, 179);
        /*background-image: linear-gradient(to left, rgb(0, 124, 164) 0%, rgb(106, 190, 217) 100%);*/
    }
    .form .form-group.tel input{
        text-align: left;
        direction: ltr;
        padding-left: 45px;
    }
    .intl-tel-input .flag-dropdown {
        top: 5px;
    }
    .form .form-group input::-webkit-input-placeholder { /* Chrome/Opera/Safari */
        color: rgba(255,255,255,0.5);
        font-size: 15px;
        font-weight: normal;
    }
    .form .form-group input::-moz-placeholder { /* Firefox 19+ */
        color: rgba(255,255,255,0.5);
        font-size: 15px;
        font-weight: normal;
    }
    .form .form-group input:-ms-input-placeholder { /* IE 10+ */
        color: rgba(255,255,255,0.5);
        font-size: 15px;
        font-weight: normal;
    }
    .form .form-group input:-moz-placeholder { /* Firefox 18- */
        color: rgba(255,255,255,0.5);
        font-size: 15px;
        font-weight: normal;
    }
    .form .send-btn{
        width: 50%;
        display: block;
        text-align: center;
        margin: auto;
        border: none;
        background-color: #00355B;
        color: #ffffff;
        padding: 7px;
        border-radius: 20px;
        height: 39px;
    }
    .form .send-btn img{
        width: 21px;
        display: inline-flex;
    }
    .form .send-btn p{
        margin: 0px;
        display: inline-flex;
    }
    .shear-content{
        position: absolute;
        width: 100%;
        bottom: 0px;
        padding: 30px;
        text-align: center;
        display: none;
    }
    .shear-content .cont{
        float: left;
        width: 100%;
        height: auto;
        border-radius: 20px;
        padding-bottom: 15px;
        background-image: linear-gradient(to top, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 21255, 0.5) 50%, rgba(255, 255, 255, 0.1) 100%);
    }
    .shear-content h2{
        float: left;
        width: 100%;
        font-size: 40px;
        font-weight: normal;
        text-align: center !important;
        margin-bottom: 15px;
        color: #132467;
        letter-spacing: -1px;
    }
    .shear-content h2 strong{
        float: left;
        width: 100%;
        font-weight: normal;
        font-size: 28px;
    }
    .shear-content p{
        float: left;
        width: 100%;
        margin-top: 10px;
        color: #132467;
        font-size: 17px;
        font-style: italic;
        font-family: 'Montserrat', sans-serif !important;
    }
    .sharepost a .fa {
        height: 50px;
        width: 50px;
        line-height: 32px;
        text-align: center;
        color: #FFF;
        font-size: 25px;
        border-radius: 100%;
        transition: all .2s ease-in-out;
        padding-top: 9px;
        margin: 0px 8px;
        -webkit-box-shadow: 25px 25px 27px -23px rgba(107,107,107,1);
        -moz-box-shadow: 25px 25px 27px -23px rgba(107,107,107,1);
        box-shadow: 25px 25px 27px -23px rgba(107,107,107,1);
    }

    .shareSection {
        float: left;
        margin: 0px !important;
    }
    .rating-section{
        float: left;
        width: 100%;
        margin-bottom: 30px;
        margin-top: 15px;
    }
    .rating-section span{
        float: left;
        width: 100%;
        margin: 0px 0px 20px 0px;
        color: #132467;
        font-size: 25px;
    }
    .rating-section a{
        padding: 2px 25px 7px 25px;
        background-color: #ff0101;
        color: #ffffff;
        border-radius: 9px;
        font-size: 17px;
        background-image: linear-gradient(to bottom, #ff0018 0%, #99000f 100%);
    }

    @media only screen 
    and (min-device-width : 768px) 
    and (max-device-width : 1024px) 
    and (orientation : portrait) { 
        .full-section-mob {
            padding-top: 30px;
            height: 650px !important;
        }
    }
    @media (max-width: 767px) and (min-width: 481px) {
        .full-section-mob {
            height: 550px !important;
        }
    }
    @media (max-width: 480px) and (min-width: 320px) {

    }




</style>
@endsection

<?php
$page_title = $row->getSeoTitle();
$media = $row->media;
?>
@extends('front.layout', [
"page_title" => $page_title ? $page_title : $row->getTitle(),
"page_description"  =>    $row->getSeoDescription(),
"page_keywords"     =>    $row->getSeoKeywords(),
"og_image"          =>    Helper::media_mob($media),
"is_quiz_page" => true
])
@section('main_content')



<!-- Start Mobil Section -->
<div class="full-section-mob quiz">
    <div class="section-content">
        <img class="plane animated" src="<?= asset('/img/plane.png') ?>" alt="Damas"/>
        <img class="ribbon animated" src="<?= asset('/img/ribbon-flag.png') ?>" alt="Damas"/>



        <div class="form animated">
            <h2><?= trans("front.Register your information"); ?><strong><?= trans("front.For Istanbul trip"); ?></strong></h2>

            <?= Form::open(["url" => route("front.callus2"), "id" => "form-callus-lg"]); ?>
            <div class="form-group">
                <input type="text" name="name" placeholder="* <?= trans("front.name and fame"); ?>">
            </div>
            <div class="form-group tel">
                <input type="text" name="mobile" id="mobile-sm" placeholder="+90 123456789">
            </div>
            <div class="form-group">
                <input type="hidden" name="form_type" value="quiz">
                <input type="text" name="familymembers" placeholder="* <?= trans("front.family members"); ?>" />
            </div>
            <button type="submit" class="send-btn"><img src="{{ asset('img/send-icon-w.svg') }}"> <p><?= trans("front.Register"); ?></p></button>
            </form>
        </div>




        <div class="shear-content animated">
            <div class="cont">
                <h2><?= trans("front.Share our website"); ?><strong><?= trans("front.To complete the registration successfully"); ?></strong></h2>

                <?php
                $urls = [
                    'https://www.damas.net/en/property-for-sale/turkey/',
                    'https://www.damas.net/en/apartments-for-sale/turkey/',
                    'https://www.damas.net/en/property-for-sale/istanbul',
                    'https://www.damas.net/en/apartments-for-sale/istanbul/',
                    'https://www.damas.net/en/turkish-citizenship'
                ];
                $k = array_rand($urls);
                $url = $urls[$k];
                $current_lang = LaravelLocalization::getCurrentLocale();
				if($current_lang == 'ar'){
					$url = str_replace('/en/', '/', $url);
				}else{
					$url = str_replace('/en/', '/'.$current_lang.'/', $url);
				}
                ?>
                <div class="shareSection">
                    <div class="shareBtnsFloating sharepost social" data-url="<?= $url ?>">
                        <a href="#" target="_blank" class="btnshare" data-network="facebook"><i class="fa fa-facebook"></i></a>
                        <a href="#" target="_blank" class="btnshare" data-network="twitter"><i class="fa fa-twitter"></i></a>
                        <a href="#" target="_blank" class="btnshare" data-network="whatsapp"><i class="fa fa-whatsapp"></i></a>
                    </div>
                </div>

<!--                <p>damas.net</p>-->


                <div class="rating-section">
                    <span>لزيادة فرصتك بالنجاح</span>
                    <a href="https://goo.gl/C4cVbY" target="_blank">أضف تقييمك</a>
                </div>  


            </div>

        </div>


    </div>
</div>





@endsection

@section('scriptjs')



<script>
    var windowH = $(window).height() - 122;
    $(document).ready(function () {
        setTimeout(function () {
            $(".ribbon").css("opacity", "1");
            $(".ribbon").addClass("fadeInRight");
        }, 500);
        setTimeout(function () {
            $(".plane").css("opacity", "1");
            $(".plane").addClass("slideInLeft");
            $(".form").css("opacity", "1");
            $(".form").addClass("zoomIn");
        }, 700);


        $('.sharepost a').click(function () {
            $.post('<?= route('front.callus2') ?>', {'share': '1'});
        });

    });



    /*$(document).on("click", ".send-btn", function () {
     $(".form").fadeOut();
     setTimeout(function () {
     $(".shear-content").fadeIn();
     }, 200);
     
     });*/

</script>




@endsection
