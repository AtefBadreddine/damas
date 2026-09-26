@section('styles')
body {padding-top:60px;}
[class*=flaticon]:before{margin-left:5px}.global-new-item{background-color:#fafafa;padding-bottom:15px;margin-bottom:10px}.global-new-item .news-item{position:relative;overflow:hidden;width: 100%;}.global-new-item .news-item:hover .layer{opacity:1;top:0}.global-new-item .news-item:hover .layer ul li{opacity:1}.global-new-item .news-item img{width:100%}.global-new-item .news-item .layer{position:absolute;z-index:888;top:0;left:0;opacity:0;height:100%;width:100%;background-color:rgba(0,0,0,.4);transition:all .3s ease-out}.global-new-item .news-item .layer ul li:nth-of-type(1) img,.global-new-item .news-item .layer ul li:nth-of-type(3) img{width:50px}.global-new-item .news-item .layer ul{display:flex;justify-content:space-around;font-size:40px;padding:0;margin:0;height:100%;align-items:center}.global-new-item .news-item .layer ul li{margin:0;opacity:0;transition:all .3s ease-out}.global-new-item .news-item .layer ul li:nth-of-type(2){transition-delay:.1s}.global-new-item .news-item .layer ul li:nth-of-type(3){transition-delay:.2s}.global-new-item .news-item .layer ul li i{color:#fff}.global-new-item .news-item .layer ul li i:before{font-size:40px}.global-new-item ul{list-style:none;display:flex;justify-content:flex-start;margin:15px 0;color:#0b7f7f;padding:0}.global-new-item ul li{margin-right:15px;line-height:35px;font-weight:700}.global-new-item h4{font-size:15px;font-weight:bolder;padding:0 10px}.global-new-item p{padding:0 10px 15px 10px;}.my-media{margin-top:0;margin-bottom:10px;font-weight:700;width: 100%;background-color: #ffffff;}.my-media .media-object{width:100px;height:100px;transition:all .3s ease-out}.my-media .media-object:hover{opacity:.8}.my-media p{line-height:35px}.my-media p i:before{margin-left:5px}.sliding3,.sliding3 .item a{position:relative}.sliding3 .owl-stage{position:relative;right:0}.sliding3 .item{margin:0;height:auto;padding:0;}.sliding3 .item a{display:block;width:100%;height:50%;padding:3px;overflow:hidden}.sliding3 .item a:hover .layer{top:45%}.sliding3 .item a .layer{position:absolute;bottom:0;left:3px;width:calc(100% - 6px);height:auto;background:linear-gradient(to top,rgba(0,0,0,.8),rgba(0,0,0,.2));color:#fff;font-weight:700;padding:10px 15px;transition:all .3s ease-out}.sliding3 .item a .layer h3{font-size:20px;color:#ffffff;margin-top:5px;}.sliding3 .item a .layer ul{list-style:none;display:flex;justify-content:flex-start;padding:0}.sliding3 .item a .layer ul li{margin-left:20px;line-height:50px}.sliding3 .item a .layer ul li i:before{margin-left:5px;line-height:40px;position:relative;top:3px}.sliding3 .item .first,.sliding3 .item .first img{height:100%}.sliding3 .owl-nav{position:absolute;top:calc(50% - 20px);left:0;height:0;z-index:9999;width:100%;display:flex;justify-content:space-between;font-size:60px;color:#0b7f7f;font-weight:100;padding:0 20px}.sliding3 .owl-nav>*{height:40px;width:40px;background-color:rgba(255,255,255,.8);text-align:center;line-height:40px}.sliding3 .layer h3{font-size:20px}.most-popular{margin:30px 0}.most-popular .videos .layer{top:30px;opacity:0}.most-popular .social{margin-bottom:30px}.most-popular .social aside{width:48%;font-size:20px;margin:10px 0;font-weight:700;display:inline-block}.most-popular .social aside img{width:50px}.most-popular .social aside a{color:#0b7f7f}
h1.colored {margin:30px 0;}h4.colored{line-height: 25px;}.global-new-item h4.colored{padding-bottom: 10px;}
.global-new-item {margin: 0px 0px 15px 0px; padding: 0px;}
.more {color: #fff;font-weight: 100;font-size: 18px;padding:5px 20px 8px 20px;background-color: #0b7f7f;border-radius: 5px;}
@endsection

<?php
$params = Helper::query("BlogParam", "find", ["id" => 1]);
$seo_title = $params->getSeoTitle();
?>
@extends('amp.layout', [
"page_title" => $seo_title ? $seo_title : $params->getTitle(),
"page_description" => $params->getSeoDescription(),
"page_keywords" => $params->getSeoKeywords()
])
@section('main_content')

<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$sections = Helper::query("BlogSection", "orderByPlacement", ["lang" => ["all", $current_lang]]);
$sidebar_content = null;
$core_content = null;
?>

@foreach($sections as $k => $section)
@if($section->content_type == "projects")
<?php ob_start(); ?>
<h3 class="colored blog-heading"> <?= $section->getTitle(); ?> </h3>
<div class="alikes">
    @foreach($section->projects()->limit($section->number_items)->get() as $project)
    <aside class="col-xs-12 wow fadeInUp" data-wow-duration="2s" data-wow-offset="200">
        @include("amp.partials.project_item")
    </aside>
    @endforeach
</div>
<div class="clearfix"></div>
<?php $projects_content = ob_get_clean(); ?>
<?php
if ($section->section_position == "sidebar")
    $sidebar_content .= $projects_content;
?>
@else
<?php
// select published posts by lang and type
if ($section->content_type == "category") {
    $post_category = Helper::query("PostCategory", "find", ["id" => $section->category_id]);
    $posts = $post_category->posts()
            ->limit($section->number_items)
            ->where("published", 1)
            ->whereIn("lang", ["all", $current_lang]);

    $section->link_click = route("front.blog.category", $post_category->slug);
    if (!$section->show_title) {
        $section->show_title = 1;
        $section->title_ar = $post_category->name_ar;
    }
} else {
    $posts = Helper::query("Post", "where", ["field" => "post_type", "value" => \App\Enums\PostType::fromSectionContentType($section->content_type)->value])
            ->where("published", 1)
            ->whereIn("lang", ["all", $current_lang])
            ->limit($section->number_items);
}

if ($section->content_display == "selected") {
    // selected posts from section
    $posts = $section->posts;
} elseif ($section->content_display == "most_visited") {
    // order by visites
    $posts = $posts->orderBy("visites", "DESC")->get();
} else {
    // order by placement
    $posts = $posts->orderBy("placement", "ASC")->get();
}
?>
@if($section->section_position == "slider")
@include("amp.blog.partials.".$section->model)
@elseif($section->section_position == "sidebar")
<!-- sidebar content -->
<?php $sidebar_content .= View::make("amp.blog.partials." . $section->model, ["section" => $section, "posts" => $posts])->render(); ?>
@else
<!-- core content -->
<?php $core_content .= View::make("amp.blog.partials." . $section->model, ["section" => $section, "posts" => $posts])->render(); ?>
@endif
@endif
@endforeach

<article class="most-popular">
    <section class="container-fluid">
        <div class="row">
            <aside class="col-md-8 col-sm-8 col-xs-12">
                <?= $core_content; ?>
            </aside>
            <aside class="col-md-4 col-sm-4 col-xs-12">

                <!-- show slidebar content -->
                <?= $sidebar_content; ?>
            </aside>
        </div>
    </section>
</article>

@include("amp.partials.call_us", ["form_type" => "Blog - Down"])

@endsection
