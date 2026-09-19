

@section('styles')
.note-example {
margin: 30px 0px 0px 0px;
}

.note-example .note ol li,
.note-example .note p,
.note-example .note ul li {
line-height: 30px;
font-size: 15px;
}

.note-example .blog-heading {
margin-bottom: 30px;
position: relative;
padding-bottom: 10px
}

.note-example .social {
float: left;
width: 100%;
background-color: #ffffff;
padding: 5px;
margin: 15px 0px 0px 0px;
border-radius: 5px;
}
.note-example .social .blog-heading{
margin: 0px;
}

.note-example .header-overlay-container .header-contactform {
width: 100%;
background-color: rgba(18, 38, 71, .5)
}

.note-example .header-overlay-container .header-contactform .form-group {
width: 100%
}

.note-example .header-overlay-container .header-contactform .form-group .form-control {
height: 40px
}

.note-example .header-overlay-container .header-contactform .form-group textarea {
min-height: 100px
}

.note-example .header-overlay-container .header-contactform .btn {
background-color: #264584;
color: #fff
}

.note-example .header-overlay-container .header-contactform h4 {
color: #fff;
border-color: rgba(255, 255, 255, .6);
font-size: 26px
}

.socialPlugin .socials {
margin-top: 0;
}

.note-example {
margin-top: 80px;
}

.note-example a {
color: inherit;
text-decoration: none;
}
.amp-social-links{
float: left;
width: 100%;
padding: 5px;
}
.amp-social-links li{
float: left;
width: 33.3333%;
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
@endsection

<?php
$seo_title = $row->getSeoTitle();

$page_title = $row->getSeoTitle();
$media = $row->media;
?>
@extends('amp.layout', [
"page_title" => $seo_title ? $seo_title : $row->getTitle(),
"page_description" => $row->getSeoDescription(),
"page_keywords" => $row->getSeoKeywords(),
"og_image"  =>  Helper::media_url($row->photoCard),
])
@section('main_content')


<article class="note-example">
    <section class="container">
        <div class="row">
            <aside class="col-md-8 col-sm-8 col-xs-12">
                <div class="note wow fadeInUp" data-wow-duration="1.3s">
                    <h1 class="colored blog-heading"><?= $row->getTitle(); ?></h1>
                    @if($media)
                    <amp-img src="<?= Helper::media_url($media); ?>" width="533" height="533" layout="responsive" alt="{{ $row->getTitle() }}"></amp-img>
                    @endif
                    <div class="clearfix"></div>
                    <div class="leaad">
                        <?php
                        /*$cnt = preg_replace('/(<[^>]+) style=".*?"/i', '$1', html_entity_decode($row->getContent()));
                        $cnt = preg_replace("/<img[^>]+\>/i", "", $cnt);
                        $cnt = preg_replace("/<iframe[^>]+\>/i", "", $cnt);*/
                        ?>
                        <?php
						$cnt = html_entity_decode($row->getContent());
						$cnt = str_replace(["https://www.youtube.com/embed/","//www.youtube.com/embed/"],"",$cnt);
						$cnt = preg_replace( '/(width|height)=\"\d*\"\s/', "", $cnt );
						$cnt = preg_replace('/<iframe\s+.*?\s+src=(".*?").*?<\/iframe>/', '<amp-youtube
						data-videoid=$1
						layout="responsive"
						width="480" height="270"></amp-youtube>', $cnt);
						
						
							
							
							$cnt = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $cnt);

							
                            $cnt = preg_replace("/<img[^>]+\>/i", "", $cnt);
                           // $cnt = preg_replace("/<iframe[^>]+\>/i", "", $cnt);
							$cnt = str_replace("<video", "<amp-video", $cnt);
							$cnt = str_replace("</video", "</amp-video", $cnt);
							
							$cnt = str_replace('allowfullscreen="allowfullscreen"','',$cnt);
							$cnt = str_replace('<iframe src="','<amp-youtube layout="responsive" width="480" height="270" data-videoid="',$cnt);
							$cnt = str_replace('</iframe>','</amp-youtube>',$cnt);
							$cnt = str_replace('width="100%" height="314"','',$cnt);
							$cnt = str_replace('frameborder="0"','',$cnt);
							
							
                        ?>
                        <?= $cnt; ?>
                    </div>
                </div>
            </aside>
            <aside class="col-md-4 col-sm-4 col-xs-12">
                @include("amp.blog.partials.social")


            </aside>
        </div>
    </section>
</article>

@include("amp.partials.call_us", ["form_type" => "Post - Down"])

@endsection