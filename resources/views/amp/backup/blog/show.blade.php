@section('styles')
    .note-example{margin:30px 0}.note-example .note ol li,.note-example .note p,.note-example .note ul li{line-height:30px;font-size:18px;}.note-example .blog-heading{margin-bottom:30px;position:relative;border-bottom:3px solid #ebebeb;padding-bottom:10px}.note-example .blog-heading:after{content:'';position:absolute;right:0;bottom:-2px;border-bottom:2px solid #264584;width:60px}.note-example .social{margin-bottom:30px}.note-example .social aside{width:48%;font-size:20px;margin:10px 0;font-weight:700;display:inline-block}.note-example .social aside img{width:50px}.note-example .social aside a{color:#264584}.note-example .header-overlay-container .header-contactform{width:100%;background-color:rgba(18,38,71,.5)}.note-example .header-overlay-container .header-contactform .form-group{width:100%}.note-example .header-overlay-container .header-contactform .form-group .form-control{height:40px}.note-example .header-overlay-container .header-contactform .form-group textarea{min-height:100px}.note-example .header-overlay-container .header-contactform .btn{background-color:#264584;color:#fff}.note-example .header-overlay-container .header-contactform h4{color:#fff;border-color:rgba(255,255,255,.6);font-size:26px}
    .socialPlugin .socials {margin-top:0;}
    .note-example {margin-top:80px;}
    .note-example a {color: inherit;text-decoration: none;}
@endsection

<?php  $seo_title = $post->getSeoTitle(); ?>
@extends('amp.layout', [
    "page_title" => $seo_title ? $seo_title : $post->getTitle(),
    "page_description" => $post->getSeoDescription(),
    "page_keywords" => $post->getSeoKeywords(),
    "og_image"  =>  Helper::media_url($post->photoCard),
])
@section('main_content')


<?php
    $current_lang = LaravelLocalization::getCurrentLocale();
    $photoCard = $post->photoCard;
    $infos = Helper::get_params();
?>

<article class="note-example">
    <section class="container">
        <div class="row">
            <aside class="col-md-8 col-sm-8 col-xs-12">
                <div class="note">
                    <h1 class="colored blog-heading"><?= $post->getTitle(); ?></h1>
                    @if($photoCard)
                        <amp-img src="<?= Helper::media_url($photoCard); ?>" width="533" height="533" layout="responsive" alt="{{ $post->getTitle() }}"></amp-img>
                    @endif
                    <div class="clearfix"></div>
                    <br>
                    @include("amp.partials.call_us_small", ["form_type" => "Post - Up"])
                    <div class="leaad"><br>
                        <?php
                            $cnt = preg_replace('/(<[^>]+) style=".*?"/i', '$1', html_entity_decode($post->getContent()));
                            $cnt = preg_replace("/<img[^>]+\>/i", "", $cnt);
                            $cnt = preg_replace("/<iframe[^>]+\>/i", "", $cnt);
                        ?>
                        <?= $cnt; ?>
                    </div>
                </div>
            </aside>
            <aside class="col-md-4 col-sm-4 col-xs-12">
                <?php
                    $sections = Helper::query("BlogSection", "where", ["field" => "section_position", "value" => "sidebar_post"])->whereIn("lang", ["all", $current_lang])->get();
                ?>
                
                @foreach($sections as $k => $section)
                    @if($section->content_type == "projects")
                        <h3 class="colored blog-heading"> <?= $section->title_ar; ?> </h3>
                        <div class="alikes">
                            @foreach($section->projects()->limit($section->number_items)->get() as $project)
                                @include("amp.partials.project_item")
                            @endforeach
                        </div>
                    @else
                        <?php

                            $posts = Helper::query("Post", "where", ["field" => "post_type", "value" => $section->content_type])
                                ->limit($section->number_items)
                                ->where("published", 1)
                                ->whereIn("lang", ["all", $current_lang]);

                            if ( $section->content_display == "selected" ) {
                                $posts = $section->posts;
                            } elseif ( $section->content_display == "most_visited" ) {
                                $posts = $posts->orderBy("visites", "DESC")->get();
                            } else {
                                $posts = $posts->orderBy("created_at", "DESC")->get();
                            }
                        ?>
                        @include("amp.blog.partials.".$section->model)
                    @endif
                @endforeach
               
            </aside>
        </div>
    </section>
</article>

@include("amp.partials.call_us", ["form_type" => "Post - Down"])

@endsection

@section('schemaorg')
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "NewsArticle",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "https://google.com/article"
    },
    "headline": "<?= @$seo_title; ?>",
    "image": "<?= Helper::media_url($photoCard); ?>",
    "datePublished": "<?= $post->created_at; ?>",
    "dateModified": "<?= $post->updated_at; ?>",
    "author": {
        "@type": "Person",
        "name": "<?= $infos->name; ?>"
    },
    "publisher": {
        "@type": "Organization",
        "name": "<?= $infos->name; ?>",
        "logo": {
            "@type": "ImageObject",
            "url": "<?= asset("img/logo.png"); ?>"
        }
    },
    "description": "<?= htmlentities($post->getSeoDescription()); ?>"
}
</script>
@endsection
