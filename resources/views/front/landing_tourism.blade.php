<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr', 'ru']) ? 'en' : 'ar';
$current_locale = $current_lang;
$lang = $current_lang;
?>
@section('styles')
<?php
$infos = Helper::get_params();

$is_mobile = Helper::get_device() != 'full' ? true : false;


$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
?>
<!DOCTYPE html>
<html lang="<?= $lang; ?>" dir="<?= $lang == "ar" ? "ltr" : "ltr"; ?>">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/vnd.microsoft.icon" href="<?= asset("img/favicon.png"); ?>" />



        <title>{{ $landing->getSeoTitle() }}</title>
        <link rel="canonical" href="<?= Request::url(); ?>" />
        <meta property="og:url" content="<?= Request::url(); ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="{{ $landing->getSeoTitle() }}" />
        <meta property="og:image" content="" />
        <meta property="og:image:width" content="900" />
        <meta property="og:image:height" content="500" />

        <meta property="og:description" content="{{ $landing->getSeoDescription() }}">
        <meta name="description" content="{{ $landing->getSeoDescription() }}">


        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">


        <style>


        </style>


        <?php if (App::isLocal()) { ?>
            <?= Html::style("resources/assets/css/intlTelInput.css") ?>

            <?= Html::style("resources/assets/css/landing-tourism.css") ?>


        <?php } else { ?>

            <?= Html::style("css/landing-tourism.min.css"); ?>

        <?php } ?>


        <?php if (!App::isLocal()) { ?>
            <!-- Google Tag Manager -->
            <script>
                setTimeout(function () {
                    (function (w, d, s, l, i) {
                        w[l] = w[l] || [];
                        w[l].push({'gtm.start':
                                    new Date().getTime(), event: 'gtm.js'});
                        var f = d.getElementsByTagName(s)[0],
                                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                        j.async = true;
                        j.src =
                                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                        f.parentNode.insertBefore(j, f);
                    })(window, document, 'script', 'dataLayer', 'GTM-NQMR57V');
                }, 3000);


            </script>
            <!-- End Google Tag Manager -->
        <?php } ?>


        <script>

        </script>

        <style>

        </style>

    </head>

    <body class="tourism">

        <!-- Start Header -->
        <div class="landing_header">
            <div class="main_menu">
                <a href="#"> <img width="160" height="123" class="flag_header" src="<?= asset("img/Flag-Header.svg"); ?>" alt="damasturk"/></a>
                <a class="navbar-brand full" href="#">
                    <img width="210" height="76" src="<?= asset("img/damas-turk-logo.svg"); ?>" alt="damasturk"/>
                </a>

            </div>
        </div>
        <!-- End Header -->

        <div class="col-md-10 offset-md-1">
            <div class="full_sections">
                <div class="sub_section">

                    <div class="sec">
                        <img class="top_photo" width="500" height="500" src="<?= asset("img/landing-tourism-banner.png"); ?>" alt="damasturk"/>
                    </div>

                    <div class="sec">
                        <iframe class="vid_embed_item" 
                                src="https://www.youtube.com/embed/mX4aIC2oQzg?autoplay=1&loop=1" 
                                width="315" height="560" frameborder="0" 
                                webkitallowfullscreen mozallowfullscreen allowfullscreen>
                        </iframe>
                    </div>

                    <h1 class="page_title">
                        احصل على رحلة سياحية الى تركيا<br>
                        مع داماس العقارية
                        <br>
                        <span>عند شراء أحد أصدقائك أو أقاربك عن طريقك</span>
                    </h1>


                    <div class="sec">
                        <form id="form_sec">
                            <h2>لمزيد من التفاصيل تواصل معنا</h2>

                            <div class="sec">
                                <div class="form-group">
                                    <label for="name">الاسم*</label>
                                    <input type="text" name="name" id="name" class="form-control"/>
                                    <span class="invalid_name alert">من فضلك ادخل الاسم</span>
                                </div>
                                <div class="form-group">
                                    <label for="mobile-sm">رقم الهاتف*</label>
                                    <input class="form-control" type="text" name="mobile" value="{{ @session()->get('call_country') }}" id="mobile-sm" placeholder="">
                                    <span class="invalid_mobile alert">من فضلك ادخل رقم الهاتف</span>
                                </div>
                                <div class="form-group">
                                    <label for="email">البريد الالكتروني*</label>
                                    <input type="email" name="email" id="email" class="form-control"/>
                                    <span class="invalid_email alert">من فضلك اخدل بريد الكتروني صحيح</span>
                                </div>
                                <div class="form-group">
                                    <a class="send_btn">إرسال</a>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>



        <div class="sub_footer">
            <div class="logo_sec">
                <img width="155" height="76" src="<?= asset("img/damas-turk-logo.svg"); ?>" alt="damasturk"/>
            </div>
            <div class="copyright animate__animated"><?= trans("front.View the intellectual property rights of damasturk"); ?>  © <span class="num"><?= date('Y'); ?></span> <br> <span class="num">(Fikri Mülkiyet Hakları)</span> </div>
        </div>





        <?php if (App::isLocal()) { ?>
            <?= Html::script("resources/assets/js/jquery-3.6.0.min.js") ?>
            <?= Html::script("resources/assets/js/intlTelInput.js") ?>
            <?= Html::script("resources/assets/js/jquery.lazy.min.js") ?>
            <?= Html::script("resources/assets/js/jquery.fancybox.min.js") ?>
            <?= Html::script("https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js") ?>
            <?= Html::script("https://cdn.jsdelivr.net/foundation/6.2.4-rc2/foundation.min.js") ?>
        <?php } else { ?>
            <?= Html::script("js/landing2.min.js") ?>
        <?php } ?>

        <script>




				<?php
				$get = '';
				foreach($_GET as $k=>$v){
					if($get=='')
						$get = $k . '=' . $v;
					else
						$get = $get .'&'. $k . '=' . $v;
				}
				if(isset($_GET['sHTTP_REFERER']) && isset($_GET['sREQUEST_URI'])){
					$js_gets = "";
				}else{
					$js_gets = "'&sHTTP_REFERER=' + encodeURIComponent(document.referrer) + '&sREQUEST_URI=' + '/' + encodeURIComponent(window.location.pathname.substr(1))";
				}
				?>
				$.getJSON( "/ajax/call_country?<?= $get ?>" + <?= $js_gets ?> , function(data){
					var call_ctry = data.call_country;
					$('input[name=mobile]').val(call_ctry);
					$('input[name=phone]').val(call_ctry);
					
					
					
					call_ctry = call_ctry.replace('+','');
					var country_abr = $('input[name=mobile]:eq(0)').parent('div').find('.country-list').find('li[data-dial-code="'+call_ctry+'"]').data('country-code');
					$('input[name=mobile]').parent('div').find('.selected-flag').find('.flag').attr('class','flag '+country_abr);
					$('input[name=phone]').parent('div').find('.selected-flag').find('.flag').attr('class','flag '+country_abr);
					
					
				});
				
 $(document).ready(function () { });

            $('body').on('click', '.btnshare', function (e) {
                /*if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && $(this).attr('href')!='') {
                 alert('mob 00');
                 }else{
                 */
                e.preventDefault();
                var data_url = $(this).attr("data-url");
                var data_title = $(this).attr("data-text");
                if (!data_url) {
                    data_url = window.location.href;
                }
                if (!data_title) {
                    data_title = document.title;
                }
                var url = encodeURIComponent(data_url),
                        title = encodeURIComponent(data_title),
                        w = 500,
                        h = 400,
                        typ = $(this).attr("data-network"),
                        left = (screen.width / 2) - (w / 2),
                        top = (screen.height / 2) - (h / 2);

                var share_url = "";
                if (typ == 'facebook') {
                    share_url = 'https://facebook.com/sharer.php?u=' + url;
                } else if (typ == 'twitter') {
                    share_url = 'https://twitter.com/intent/tweet?url=' + url + '&text=' + title + '&via=damasturk';
                } else if (typ == 'googleplus') {
                    share_url = 'https://plus.google.com/share?url=' + url;
                } else if (typ == 'linkedin') {
                    share_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' + url + '&title=' + title + '&source=damas.net';
                } else if (typ == 'whatsapp') {
                    share_url = 'https://api.whatsapp.com/send?text=' + title + ' ' + url;
                }



                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && $(this).attr('href') == '') {
                    window.open(share_url, '_blank');
                } else {
                    window.open(share_url, 'Social Share', 'toolbar=no, location=no, directories=no, status=no,' +
                            ' menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
                }

            });






            /* input tel flag */
            $("#mobile-sm, #mobile-lg, #InputMobile, #inputMobileChat").intlTelInput({
                preferredCountries: ["undif", "sa", "tr", "qa", "sy", "iq", "kw", "bh", "ae", "ye", "jo", "dz", "ly", "eg", "sd", "om"],
                initialCountry: "auto",
                separateDialCode: true,
                preferredCountries: ["sa", "ae"]
            });

            $('.send_btn').click(function (e) {

                e.preventDefault();
                e.stopPropagation();
                var emailFilter = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/g;
                var phoneFilter = /\d{10}\b/;

                var error = false;
                var name = $('input[name="name"]').val();
                var mobile = $('input[name="mobile"]').val();
                var email = $('input[name="email"]').val();

                if (name == "") {
                    $('.invalid_name').show().delay(2000).fadeOut(300);
                    $('input[name="name"]').focus();
                } else if (!phoneFilter.test(mobile)) {
                    $('.invalid_mobile').show().delay(2000).fadeOut(300);
                    $('input[name="mobile"]').focus();
                } else if (!emailFilter.test(email)) {
                    $('.invalid_email').show().delay(2000).fadeOut(300);
                    $('input[name="email"]').focus();
                } else {

                    $('.send_btn').css("pointer-events", "none");
                    $('.send_btn').text("");
                    $('.send_btn').css("background-color", "#8b8b8b");
                    $('.send_btn').append('<div class="loading_btn"></div>');


                    var postData = $('#form_sec').serialize();
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('front.call_us_landing_tourism') }}",
                        data: postData,
                        success: function (response) {
                            if (response.success == 1) {
                                $('.alert_form').removeClass("alert-danger").addClass("alert-success").text("تم ارسال الرسالة بنجاح").show().delay(2000).fadeOut(300);
                                $('input[name="name"]').val("");
                                $('input[name="mobile"]').val("");
                                $('input[name="email"]').val("");
                                setTimeout(function () {
                                    window.location.href = '/confirmation?t=2';
                                }, 2000);
                            } else {
                                $('.alert_form').removeClass("alert-success").addClass("alert-danger").text("حدث خطأ أثناء ارسالة الرسالة").show().delay(2000).fadeOut(300);
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            }
                            
                        },
                        error: function (errorThrown) {
                            $('.error').show().delay(2000).fadeOut(300);
                            $('.invalid, .success').hide();
                            console.log(errorThrown);
                        }
                    });
                }
            });

        </script>


    </body>
</html>