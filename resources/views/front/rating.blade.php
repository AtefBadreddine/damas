<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr', 'ru']) ? 'en' : 'ar';
?>
@section('styles')
<?php
$infos = Helper::get_params();


$is_mobile = Helper::get_device() != 'full' ? true : false;

$right = ($style_lang == 'ar' ? 'right' : 'left');
?>
<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/rating.css"); ?>
    


<?php } else { ?>

    <?= Html::style("css/rating.min.css"); ?>

<?php } ?>
<?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
        <style>
            .rating_sec label.title {
                float: left;
                font-weight: bold;
            }
            .starrating {
                direction: rtl;
                text-align: left;
            }
            .alert_success svg {
                float: left;
                margin-left: 0px;
                margin-right: 20px;
            }
            .alert_success p {
                float: left;
                font-size: 20px;
                margin: 39px 0px 0px 0px;
            }
        </style>
    <?php } ?>

@endsection





@extends('front.layout', [
"page_title"        =>    ($page->getSeoTitle() ? $page->getSeoTitle() : $page->name),
"page_description"  =>    '',
"page_keywords"     =>    '',
"og_image"          =>    ($page->media?Helper::media_url_full($page->media):null)
])


@section('main_content')



<div class="col-md-10 offset-md-1">
    <div class="full_sections int_page">


        <!-- Start Left Section -->
        <div class="left_sec">

            <div class="top_control_sec">

                <h1 class="jazzira_font_bold"><?= $page->getTitle(); ?></h1>

            </div>




            <?php if (isset($_GET['success'])) { ?>
                <div class="alert_success sec">

                    <svg width="115px" height="115px" viewBox="0 0 133 133" version="1.1"> <g id="check-group" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" > <circle id="filled-circle" fill="#07b481" cx="66.5" cy="66.5" r="54.5"/> <circle id="white-circle" fill="#FFFFFF" cx="66.5" cy="66.5" r="55.5"/> <circle id="outline" stroke="#07b481" stroke-width="4" cx="66.5" cy="66.5" r="54.5"/> <polyline id="check" stroke="#FFFFFF" stroke-width="5.5" points="41 70 56 85 92 49"/> </g></svg>

                    <p><?= trans("front.rating page title success"); ?></p>


                    <ul class="links_list">
                        <li><a href="<?= route("front.index"); ?>" class="btn btn-default"> <?= trans("front.home"); ?></a></li>
                        <li><a href="<?= route("front.turkish_citizenship"); ?>" class="btn btn-default"> <?= trans("front.TurkishCitizenship"); ?></a></li>
                        <li><a href="<?= route("front.search", ["property-for-sale", "turkey"]) ?>" class="btn btn-default"> <?= trans("front.projects"); ?></a></li>
                    </ul>

                </div>	
            <?php } else {
                ?>

                <div class="content_section">
                    <div class="cont">
                        {!! html_entity_decode($page->getContent()) !!}
                        <?php /* <p>
                          تولي شركة damasturk العقارية أولوية عالية لتقييم خدماتنا وأداء فريق العمل، إنطلاقاً من إيماننا أنّ رضا العميل سرُ نجاح أيّ شركة كبرى، نحن نهتم بكل الشكاوى والمقترحات المقدمة من قبل عملائنا الكرام، ونعمل على تصحيح أخطاء فريق العمل، وتحسين جودة خدماتنا، وذلك للوصول لهدفنا الأساسي وهو (رضا العميل أولاً).
                          نرجو منك عميلنا العزيز التفضّل بالتعاون معنا في تحسين جودة خدماتنا المقدمة لكم، عبر تقييم جودة خدماتنا وأداء فريق العمل المسؤول عن المتابعة معكم، من حيث النواحي التالية:
                          </p> */ ?>
                    </div>
                </div>


                <form id="contact" method="post" action="{{ route('front.rating',[$lead,$hash]) }}">
                    {!! csrf_field() !!}
                    <div class="int_content">
                        <div class="rating_sec">
                            <div class="form-group">
                                <label class="title"><?= trans("front.rating page title one"); ?></label>
                                <div class="starrating">
                                    <input type="radio" id="offers_rating10" class="star10" name="offers_rating" value="10"><label for="offers_rating10" title="10 star">10</label>
                                    <input type="radio" id="offers_rating9" class="star9" name="offers_rating" value="9"><label for="offers_rating9" title="9 star">9</label>
                                    <input type="radio" id="offers_rating8" class="star8" name="offers_rating" value="8"><label for="offers_rating8" title="8 star">8</label>
                                    <input type="radio" id="offers_rating7" class="star7" name="offers_rating" value="7"><label for="offers_rating7" title="7 star">7</label>
                                    <input type="radio" id="offers_rating6" class="star6" name="offers_rating" value="6"><label for="offers_rating6" title="6 star">6</label>
                                    <input type="radio" id="offers_rating5" class="star5" name="offers_rating" value="5"><label for="offers_rating5" title="5 star">5</label>
                                    <input type="radio" id="offers_rating4" class="star4" name="offers_rating" value="4"><label for="offers_rating4" title="4 star">4</label>
                                    <input type="radio" id="offers_rating3" class="star3" name="offers_rating" value="3"><label for="offers_rating3" title="3 star">3</label>
                                    <input type="radio" id="offers_rating2" class="star2" name="offers_rating" value="2"><label for="offers_rating2" title="2 star">2</label>
                                    <input type="radio" id="offers_rating1" class="star1" name="offers_rating" value="1"><label for="offers_rating1" title="1 star">1</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="title"><?= trans("front.rating page title two"); ?></label>
                                <div class="starrating">
                                    <input type="radio" id="info_accuracy10" class="star10" name="info_accuracy" value="10"><label for="info_accuracy10" title="10 star">10</label>
                                    <input type="radio" id="info_accuracy9" class="star9" name="info_accuracy" value="9"><label for="info_accuracy9" title="9 star">9</label>
                                    <input type="radio" id="info_accuracy8" class=star8 name="info_accuracy" value="8"><label for="info_accuracy8" title="8 star">8</label>
                                    <input type="radio" id="info_accuracy7" class="star7" name="info_accuracy" value="7"><label for="info_accuracy7" title="7 star">7</label>
                                    <input type="radio" id="info_accuracy6" class="star6" name="info_accuracy" value="6"><label for="info_accuracy6" title="6 star">6</label>
                                    <input type="radio" id="info_accuracy5" class="star5" name="info_accuracy" value="5"><label for="info_accuracy5" title="5 star">5</label>
                                    <input type="radio" id="info_accuracy4" class="star4" name="info_accuracy" value="4"><label for="info_accuracy4" title="4 star">4</label>
                                    <input type="radio" id="info_accuracy3" class="star3" name="info_accuracy" value="3"><label for="info_accuracy3" title="3 star">3</label>
                                    <input type="radio" id="info_accuracy2" class="star2" name="info_accuracy" value="2"><label for="info_accuracy2" title="2 star">2</label>
                                    <input type="radio" id="info_accuracy1" class="star1" name="info_accuracy" value="1"><label for="info_accuracy1" title="1 star">1</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="title"><?= trans("front.rating page title three"); ?></label>
                                <div class="starrating">
                                    <input type="radio" id="dealing10" class="star10" name="dealing" value="10"><label for="dealing10" title="10 star">10</label>
                                    <input type="radio" id="dealing9" class="star9" name="dealing" value="9"><label for="dealing9" title="9 star">9</label>
                                    <input type="radio" id="dealing8" class="star8" name="dealing" value="8"><label for="dealing8" title="8 star">8</label>
                                    <input type="radio" id="dealing7" class="star7" name="dealing" value="7"><label for="dealing7" title="7 star">7</label>
                                    <input type="radio" id="dealing6" class="star6" name="dealing" value="6"><label for="dealing6" title="6 star">6</label>
                                    <input type="radio" id="dealing5" class="star5" name="dealing" value="5"><label for="dealing5" title="5 star">5</label>
                                    <input type="radio" id="dealing4" class="star4" name="dealing" value="4"><label for="dealing4" title="4 star">4</label>
                                    <input type="radio" id="dealing3" class="star3" name="dealing" value="3"><label for="dealing3" title="3 star">3</label>
                                    <input type="radio" id="dealing2" class="star2" name="dealing" value="2"><label for="dealing2" title="2 star">2</label>
                                    <input type="radio" id="dealing1" class="star1" name="dealing" value="1"><label for="dealing1" title="1 star">1</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="title"><?= trans("front.rating page title four"); ?></label>
                                <div class="starrating">
                                    <input type="radio" id="following_up10" class="star10" name="following_up" value="10"><label for="following_up10" title="10 star">10</label>
                                    <input type="radio" id="following_up9" class="star9" name="following_up" value="9"><label for="following_up9" title="9 star">9</label>
                                    <input type="radio" id="following_up8" class="star8" name="following_up" value="8"><label for="following_up8" title="8 star">8</label>
                                    <input type="radio" id="following_up7" class="star7" name="following_up" value="7"><label for="following_up7" title="7 star">7</label>
                                    <input type="radio" id="following_up6" class="star6" name="following_up" value="6"><label for="following_up6" title="6 star">6</label>
                                    <input type="radio" id="following_up5" class="star5" name="following_up" value="5"><label for="following_up5" title="5 star">5</label>
                                    <input type="radio" id="following_up4" class="star4" name="following_up" value="4"><label for="following_up4" title="4 star">4</label>
                                    <input type="radio" id="following_up3" class="star3" name="following_up" value="3"><label for="following_up3" title="3 star">3</label>
                                    <input type="radio" id="following_up2" class="star2" name="following_up" value="2"><label for="following_up2" title="2 star">2</label>
                                    <input type="radio" id="following_up1" class="star1" name="following_up" value="1"><label for="following_up1" title="1 star">1</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="title"><?= trans("front.rating page title five"); ?></label>
                                <div class="starrating">
                                    <input type="radio" id="credibility10" class="star10" name="credibility" value="10"><label for="credibility10" title="10 star">10</label>
                                    <input type="radio" id="credibility9" class="star9" name="credibility" value="9"><label for="credibility9" title="9 star">9</label>
                                    <input type="radio" id="credibility8" class="star8" name="credibility" value="8"><label for="credibility8" title="8 star">8</label>
                                    <input type="radio" id="credibility7" class="star7" name="credibility" value="7"><label for="credibility7" title="7 star">7</label>
                                    <input type="radio" id="credibility6" class="star6" name="credibility" value="6"><label for="credibility6" title="6 star">6</label>
                                    <input type="radio" id="credibility5" class="star5" name="credibility" value="5"><label for="credibility5" title="5 star">5</label>
                                    <input type="radio" id="credibility4" class="star4" name="credibility" value="4"><label for="credibility4" title="4 star">4</label>
                                    <input type="radio" id="credibility3" class="star3" name="credibility" value="3"><label for="credibility3" title="3 star">3</label>
                                    <input type="radio" id="credibility2" class="star2" name="credibility" value="2"><label for="credibility2" title="2 star">2</label>
                                    <input type="radio" id="credibility1" class="star1" name="credibility" value="1"><label for="credibility1" title="1 star">1</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="title"><?= trans("front.rating page title six"); ?></label>
                                <textarea class="content_complaint form-control" id="content_complaint" name="content_complaint"></textarea>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-default send_btn"><?= trans("front.send"); ?></button>
                            </div>

                        </div>
                    </div>
                </form>
            <?php } ?>
        </div>
        <!-- End Left Section -->


        <!-- Start Fixed Section -->
        <div class="right_sec">



            <div id="fixed_sec" class="fixed_sec">




                <!-- About Us -->
                @include("front.partials.about_sec" )



            </div>
        </div>
        <!-- End Fixed Section -->



    </div>
</div>





@endsection



@section('scriptjs')
<?= Html::script("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"); ?>




<script>
    $(document).ready(function () {

        $("body").on("submit", '#contact', function (e) {

            if (
                    !$('input[name=offers_rating]').is(':checked') ||
                    !$('input[name=info_accuracy]').is(':checked') ||
                    !$('input[name=dealing]').is(':checked') ||
                    !$('input[name=following_up]').is(':checked') ||
                    !$('input[name=credibility]').is(':checked')
                    ) {
                alert("يرجى إضافة التقييم");
            } else {

                e.preventDefault();
                var btn = $('#contact').find("button[type=submit]");
                btn.html("<i class='fa fa-spinner fa-spin'></i>");
                btn.attr("disabled", true);
                $.ajax({
                    type: "post",
                    data: $('#contact').serializeArray(),
                    url: "<?= route('front.rating', [$lead, $hash]) ?>",
                    success: function (data) {

                        window.location.href = "{{ route('front.rating',[$lead,$hash]) }}?success=1";

                    },
                    error: function (response) {
                        alert('The operation failed..., Please reload the page and try again');
                    }
                });
            }
        });


        $('.main_menu .links>li>a.offers_btn').addClass("active");


        $(window).scroll(function () {
            var scrollingPage = 0;
            var scrollingPage2 = 0;
            ;
            var scroll = $(window).scrollTop();
            if (scroll >= scrollingPage) {
                $(".header").addClass("scrolling");
            } else {
                $(".header").removeClass("scrolling");
            }
            if (scroll >= scrollingPage2) {
                $(".fixed_sec").addClass("fixed");
            } else {
                $(".fixed_sec").removeClass("fixed");
            }
        });



        $('.main_menu .links>li>a.faq_btn').addClass("active");

        if ($(window).width() <= 812) {
            outMenu = document.getElementById('outMenu');
            var fixeSecdHeight = $(".fixed_sec").height();
            setTimeout(function () {
                outMenu.setAttribute("style", "height: calc(100% - " + fixeSecdHeight + "px)");
                $("#outMenu").css("top", fixeSecdHeight);
            }, 1000);

            $("#outMenu").on("click", function () {
                $(".close_filter_btn").trigger("click");
            });
        }




        /**-- Open Filter Menu --**/
        $("body").on("click", ".filter_btn", function () {
            $(".right_sec").addClass("show");
            $("body").css("overflow-y", "hidden");
        });

        /**-- Close Filter Menu --**/
        $("body").on("click", ".close_filter_btn", function () {
            $(".right_sec").removeClass("show");
            $("body").css("overflow-y", "auto");
        });






        $('.collapse').on('show.bs.collapse', function () {
            var card = $(this).closest(".card");
            var cardHeader = $(this).closest(".card").find(".card-header");
            $(".card-header").removeClass("active");
            $(".faq .card").removeClass("active");
            $(cardHeader).addClass("active");
            $(card).addClass("active");

            $('html,body').animate({
                scrollTop: card.offset().top - 100
            }, 500);


        });

        $('.collapse').on('hide.bs.collapse', function () {
            var card = $(this).closest(".card");
            var cardHeader = $(this).closest(".card").find(".card-header");
            $(cardHeader).removeClass("active");
            $(card).removeClass("active");
        });

        var startScroll = 150;
        var supportLinks = $(".support_links");
        var oldsctop = $(window).scrollTop();
        $(window).scroll(function () {

            /*console.log('old' + oldsctop + ' ----new: '+ $(this).scrollTop());*/
            if (($(this).scrollTop()) > oldsctop) {
                $(".top_control_sec").addClass("scrollMob");
            } else {
                $(".top_control_sec").removeClass("scrollMob");
            }
            oldsctop = $(this).scrollTop();
        });
    });




</script>


@endsection



@section('schemaorg')

@endsection