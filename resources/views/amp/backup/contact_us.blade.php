@extends('amp.layout', ["page_title" => trans("front.contact us")])
@section('main_content')

<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$infos = Helper::get_params();
$branchs = Helper::query("Branch", "orderBy", ["filed" => "id", "value" => "ASC"])->get();
?>
@section('styles')
.amp-social-links{
float: left;
width: 100%;
padding: 5px;
}
.amp-social-links li{
float: left;
width: 16.3333%;
list-style: none;
text-align: center;
margin-bottom: 15px;
}
.amp-social-links li a{
font-size: 21px;
width: 40px;
height: 40px;
display: block;
margin: auto;
background-color: red;
border-radius: 50%;
color: #ffffff;
padding: 4px;
}
.amp-social-links li.amp-facebook a{
background-color: #3f5c9a;
}
.amp-social-links li.amp-twitter a{
background-color: #1da1f2;
}
.amp-social-links li.amp-instagram a{
background: #d6249f;
background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%,#d6249f 60%,#285AEB 90%);
}
.amp-social-links li.amp-youtube a{
background: #FF0000;
}
.amp-social-links li.amp-linkedin a{
background: #0073b0;
}
.amp-social-links li.amp-whatsapp a{
background: #00b04c;
}
.amp-whit-section{
display: block;
width: 100%;
border-radius: 10px;
background-color: #ffffff;
padding: 15px 0px;
margin-bottom: 15px;
}
.amp-contetn{
display: inline-block;
width: 100%;
}
.amp-contetn .amp-icon{
float: left;
width: 35px;
}
.amp-contetn .amp-text{
float: right;
width: calc(100% - 45px);
text-align: left;
}
.amp-contetn .amp-text p{
font-size: 17px;
color: #5b5b5b;
font-family: 'Montserrat', sans-serif;
}
.amp-contetn .amp-text p a{
font-weight: bold;
}
.social{
display: flex;
}
.floating-message-inline {
margin: 0px;
margin-bottom: 15px;
}
.floating-message-inline .header-contactform {
margin-top: 0px;
}
.call-center h2, .main-head {
line-height: 30px;
}
.amp-about{
text-align: center;
padding: 10px;
}
.amp-about .amp-logo-damas{
float: right;
}
.amp-about p{
color: #000;
font-size: 14px;
text-align: justify;
direction: rtl;
line-height: 1.6;
width: 100%;
font-family: DroidNaskhRegular;
}
.amp-about .amp-logos{
width: 100%;
}
.amp-about a.amp-more{
background-color: #123985;
color: #fff;
width: 150px;
height: 41px;
border-radius: 5px;
margin: 15px auto 10px;
font-size: 19px;
text-align: center;
display: block;
padding: 5px;
}
.contact-form-section .container{
padding-right: 0px;
padding-left: 0px;
}
.amp-contact-photo{
width: 100%;
height: 160px;
margin-bottom: 15px;
background-image: url(../img/Contact-us.jpg);
background-size: cover;
background-position: center;
}
@endsection




<div class="container" >
    <!-- start contact -->
    <article class="contact" dir="<?= $current_lang == 'en' ? 'ltr' : 'rtl' ?>">
        <section class="container text-center" style="padding:0">
            <h2 class="text-center main-head" style="color:#264584;margin-top: 68px;"> 
                    <!--<span class="colored fa fa-phone wow bounceInDown" data-wow-duration="1s" data-wow-offset="300"></span> -->

                <!--                <div class="whatsapp">
                
                                    <div class="whatsapp">
                                        <a target="_blank" href="https://www.damas.net/whatsapp_share?icon=6">
                                            <div class="whatsapp-icon"><i class="fa fa-whatsapp"></i></div>
                                        </a>
                                    </div>
                
                                </div>-->

                <?= trans("front.contact us"); ?> 
            </h2>


            <div class='amp-contact-photo'></div>




            <div class="contact-form-section">
                @include("amp.partials.call_us", ["form_type" => "Post - Down"])
            </div>


            @foreach($branchs as $branch)
            <div class="text-right blk_model">
                <aside class="col-md-12 col-sm-12 col-12">
                    <h3 class="colored blog-heading"><?= $branch->getName(); ?></h3>
                </aside>
                <div class="amp-whit-section">
                    <aside class="col-md-6 col-sm-6 col-12">
                        <div class="amp-contetn">
                            <div class="amp-icon">
                                <amp-img src="<?= asset("img/placeholder.png"); ?>" width="32" height="32" alt="Address"></amp-img>
                            </div>
                            <div class="amp-text">
                                <p><?= $branch->getAddress(); ?></p>
                            </div>
                        </div>

                        <div class="amp-contetn">
                            <div class="amp-icon">
                                <amp-img src="<?= asset("img/smartphone.png"); ?>" width="32" height="32" alt="Mobile"></amp-img>
                            </div>
                            <div class="amp-text">
                                <p>Mobile: <a href="tel:<?= str_replace(array(' ', '+'), array('', '00'), $branch->mobile); ?>"><?= $branch->mobile; ?></a></p>
                            </div>
                        </div>

                        <div class="amp-contetn">
                            <div class="amp-icon">
                                <amp-img src="<?= asset("img/telephone.png"); ?>" width="32" height="32" alt="Telephone"></amp-img>
                            </div>
                            <div class="amp-text">
                                <p>Telephone: <a href="tel:<?= str_replace(array(' ', '+'), array('', '00'), $branch->phone); ?>"><?= $branch->phone; ?></a></p>
                            </div>
                        </div>

                        <div class="amp-contetn">
                            <div class="amp-icon">
                                <amp-img src="<?= asset("img/message1.png"); ?>" width="32" height="32" alt="Emails"></amp-img>
                            </div>
                            <div class="amp-text">
                                <p>Email: <a href="mailto:<?= ($branch->email ? $branch->email : $infos->emails); ?>"><?= nl2br($branch->email ? $branch->email : $infos->emails); ?></a></p>
                            </div>
                        </div>
                    </aside>
                    <aside class="col-md-6 col-sm-6 col-12">
                        <div id="map">
                            <amp-iframe width="200" height="100"
                                        sandbox="allow-scripts allow-same-origin"
                                        layout="responsive"
                                        frameborder="0"
                                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12035.994400701855!2d28.8118842!3d41.0471597!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf89d31800dbd4c79!2z2K_Yp9mF2KfYsyDYqtix2YMg2KfZhNi52YLYp9ix2YrYqSAtIERhbWFzdHVyayBSZWFsIEVzdGF0ZQ!5e0!3m2!1sfr!2sma!4v1533588018502">
                            </amp-iframe>

                            <!--<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12035.994400701855!2d28.8118842!3d41.0471597!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf89d31800dbd4c79!2z2K_Yp9mF2KfYsyDYqtix2YMg2KfZhNi52YLYp9ix2YrYqSAtIERhbWFzdHVyayBSZWFsIEVzdGF0ZQ!5e0!3m2!1sfr!2sma!4v1533588018502" width="100%" height="300" frameborder="0" style="border:0"></iframe>-->
                        </div>
                    </aside>
                </div>

            </div>
            @endforeach

            <div class="amp-whit-section">
                <h2 class="text-center main-head"><?= trans("front.join us on social media"); ?></h2>

                <div class="social">
                    <!--            <aside>
                                    <a href="<?= $infos->facebook; ?>" rel="nofollow" target="_blank">
                                        <img src="<?= asset("img/facebook.png"); ?>" alt="facebook">
                                        <span> <?= trans("front.facebook"); ?> </span>
                                    </a>
                                </aside>
                                <aside>
                                    <a href="<?= $infos->twitter; ?>" rel="nofollow" target="_blank">
                                        <img src="<?= asset("img/twitter.png"); ?>" alt="twitter">
                                        <span> <?= trans("front.twitter"); ?> </span>
                                    </a>
                                </aside>
                                <aside>
                                    <a href="https://www.damas.net/whatsapp_share?icon=6" rel="nofollow" target="_blank">
                                        <img src="<?= asset("img/googleplus.png"); ?>" alt="google plus">
                                        <span> <?= trans("front.googleplus"); ?> </span>
                                    </a>
                                </aside>
                                <aside>
                                    <a href="<?= $infos->instagram; ?>" rel="nofollow" target="_blank">
                                        <img src="<?= asset("img/instagram.png"); ?>" alt="instagram">
                                        <span> <?= trans("front.instagram"); ?> </span>
                                    </a>
                                </aside>
                                <aside>
                                    <a href="<?= $infos->youtube; ?>" rel="nofollow" target="_blank">
                                        <img src="<?= asset("img/youtube.png"); ?>" alt="youtube">
                                        <span> <?= trans("front.youtube"); ?> </span>
                                    </a>
                                </aside>
                                <aside>
                                    <a href="<?= $infos->linkedin; ?>" target="_blank">
                                        <img src="<?= asset("img/linkedin.png"); ?>" alt="linkedin">
                                        <span> <?= trans("front.linkedin"); ?> </span>
                                    </a>
                                </aside>-->
                    <ul class="amp-social-links"> 
                        <li class="amp-facebook"> <a href="<?= $infos->facebook; ?>" target="_blank" aria-label="Link to AMP HTML Facebook"> <i class="fa fa-facebook"></i> </a> </li>
                        <li class="amp-twitter"> <a href="<?= $infos->twitter; ?>" target="_blank" aria-label="Link to AMP HTML Twitter"> <i class="fa fa-twitter"></i> </a> </li> 
                        <li class="amp-instagram"> <a href="<?= $infos->instagram; ?>" target="_blank" aria-label="Link to AMP HTML Instagram"> <i class="fa fa-instagram"></i> </a> </li>
                        <li class="amp-youtube"> <a href="<?= $infos->youtube; ?>" target="_blank" aria-label="Link to AMP HTML pin trest"> <i class="fa fa-youtube"></i> </a> </li> 
                        <li class="amp-linkedin"> <a href="<?= $infos->linkedin; ?>/" target="_blank" aria-label="Link to AMP HTML pin trest"> <i class="fa fa-linkedin"></i> </a> </li>
                        <li class="amp-whatsapp"> <a href="https://www.damas.net/whatsapp_share?icon=5" target="_blank" aria-label="Link to AMP HTML pin trest"> <i class="fa fa-whatsapp"></i> </a> </li> 
                    </ul>
                </div>
            </div>

        </section>
    </article>
    <!-- end contact -->


</div>

<!-- Start About Damas -->
<div class="container" style="overflow:hidden">
    @include("amp.partials.about_damass_mob")
</div>

@endsection

