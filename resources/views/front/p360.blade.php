@extends('front.layout', [

"page_title" => '',
"page_description" => ''

])
@section('main_content')

<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$lang = $current_lang;
?>
@section('styles')
<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/index.css"); ?>
    <?= Html::style("resources/assets/css/searchpage.css"); ?>
    <?= Html::style("resources/assets/css/new-css/siteMap.css"); ?>
    <?= Html::style("http://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"); ?>

    <style>
        #canvas-container:after{
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 400px;
            height: 150px;
            margin-left: -200px;
            margin-top: -75px;
            background-color: red;
            z-index: 99;
        }
        #loading-gui #loading-logo {
            display: none !important;
        }

    </style>

    <?php if ($current_lang == 'en') { ?>
        <?= Html::style("resources/assets/css/new-css/siteMap-en.css"); ?>
    <?php } ?>

<?php } else { ?>
    <style><?php include(public_path() . "/css/sitemap" . ($current_lang == 'en' ? '-en' : '') . ".min.css"); ?></style>
<?php } ?>

@endsection





<!--content-->

<a href="javascript:;" class="sanaltur_opener" data-fancybox="" data-type="iframe" data-src="https://my.matterport.com/show/?m=v5iSwBsfqNt">
    <span class="txt"><span> مثال شقة</span>  جولة افتراضية</span>
</a>


@endsection





@section('scriptjs')
<script>
    $(document).ready(function () {

        $('body').find('.tree').fadeOut(0);

        $('.tree-title').click(function () {
            setStatus($(this));
        });
    });

    /**
     * Set the list opened or closed
     * */
    function setStatus(node) {
        var elements = [];
        $(node).each(function () {
            elements.push($(node).nextAll());
        });
        for (var i = 0; i < elements.length; i++) {
            if (elements[i].css('display') == 'none') {
                elements[i].fadeIn(0);
            } else {
                elements[i].fadeOut(0);
            }
        }
        if (elements[0].css('display') != 'none') {
            $(node).addClass('active');
        } else {
            $(node).removeClass('active');
        }
    }


</script>
@endsection