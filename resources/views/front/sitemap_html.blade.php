<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr','ru']) ? 'en' : 'ar';

$infos = Helper::get_params();
?>
@extends('front.layout', [

"page_title" => $sitemap->getTitle(),
"page_description" => $sitemap->getSeoDescription(),
"page_keywords" => $sitemap->getSeoKeywords()

])
@section('main_content')


@section('styles')
<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/siteMap.css"); ?>
    <?= Html::style("http://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"); ?>


<?php } else { ?>
    <style><?php include(public_path() . "/css/sitemap.min.css"); ?></style>
    <?= Html::style("http://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"); ?>

<?php } ?>

@endsection



<div class="col-md-10 offset-md-1">
    <div class="full_sections int_page">


        <!-- Start Left Section -->
        <div class="left_sec">

            <div class="top_control_sec">
                <h1 class="jazzira_font_bold"><?= $sitemap->title; ?></h1>
            </div>


            <div class="int_content">

                <div class="filetree">



                    <?php
                    $html = '';
                    $citys = Helper::query("City", "orderByPlacement");
                    $ProjectTypes = Helper::query("ProjectType", "all");
                    $tags = Helper::query("ProjectCategory", "all");
                    foreach ($citys as $c) {
                        $html = $html . '<ul class="main-tree">';
                        $url = route("front.search") . "/property-for-sale/" . $c->getSlug();

                        if ($current_lang == 'ar') {
                            $html = $html . '<li class="tree-title">' . Helper::trimm(' عقارات للبيع  في ' . ($c->getName() == 'كل المدن' ? 'تركيا' : $c->getName())) . '</li>';
                        } elseif ($current_lang == 'en') {
                            $html = $html . '<li class="tree-title">' . Helper::trimm('property for sale in ' . $c->getName()) . '</li>';
                        } else {
                            $html = $html . '<li class="tree-title">' . Helper::trimm('propriétés à vendre à ' . $c->getName()) . '</li>';
                        }
                        foreach ($ProjectTypes as $pt) {
                            /* $_GET['city'] = $c->getSlug();
                              $_GET['project_type'] = $pt->getSlug();
                              $json = $this->search($request); */

                            $t = DB::select("select count(*) as 'cnt' from dms_projects,dms_cities,dms_projects_types,dms_project_type where dms_projects.city_id=dms_cities.id and dms_cities.slug=? and dms_projects.id=dms_project_type.project_id and dms_project_type.project_type_id=dms_projects_types.id and dms_projects_types.slug=?", array($c->getSlug(), $pt->getSlug()));

                            //echo '<h1>'.$c->getName().'</h1>';
                            if ($t[0]->cnt > 0 or in_array($c->getName(), array('كل المدن', 'Turkey'))) {
                                $url = route("front.search") . "/" . $pt->getSlug() . "/" . $c->getSlug();
                                if ($current_lang == 'ar')
                                    $html = $html . '<li class="tree-item"><a href="' . $url . '">' . Helper::trimm($pt->getName() . ' للبيع  في ' . ($c->getName() == 'كل المدن' ? 'تركيا' : $c->getName())) . '</a></li>';
                                elseif ($current_lang == 'en')
                                    $html = $html . '<li class="tree-item"><a href="' . $url . '">' . Helper::trimm($pt->getName() . ' for sale in ' . $c->getName()) . '</a></li>';
                                else
                                    $html = $html . '<li class="tree-item"><a href="' . $url . '">' . Helper::trimm($pt->getName() . ' à vendre à ' . $c->getName()) . '</a></li>';
                            }
                        }




                        foreach ($tags as $t) {

                            $t0 = DB::select("select count(*) as 'cnt' from dms_projects,dms_cities,dms_projects_types,dms_project_type,dms_projects_categories,dms_project_category where dms_projects.city_id=dms_cities.id and dms_cities.slug=? and dms_projects.id=dms_project_type.project_id and dms_project_type.project_type_id=dms_projects_types.id and dms_projects_types.slug=? and dms_projects.id=dms_project_category.project_id and dms_project_category.project_category_id=dms_projects_categories.id and dms_projects_categories.slug=?", array($c->getSlug(), $pt->getSlug(), $t->getSlug()));
                            if ($t0[0]->cnt > 0 or in_array($c->getName(), array('كل المدن', 'Turkey'))) {
                                foreach ($ProjectTypes as $pt) {
                                    $url = route("front.search") . "/" . $pt->getSlug() . "/" . $c->getSlug() . "/" . $t->getSlug();

                                    if ($current_lang == 'ar')
                                        $html = $html . '<li class="tree-item"><a href="' . $url . '">' . Helper::trimm($pt->getName() . ' ' . str_replace('عقارات', '', $t->getName()) . ' في ' . ($c->getName() == 'كل المدن' ? 'تركيا' : $c->getName())) . '</a></li>';
                                    elseif ($current_lang == 'en')
                                        $html = $html . '<li class="tree-item"><a href="' . $url . '">' . Helper::trimm($pt->getName() . ' ' . str_replace('عقارات', '', $t->getName()) . ' in ' . $c->getName()) . '</a></li>';
                                    else
                                        $html = $html . '<li class="tree-item"><a href="' . $url . '">' . Helper::trimm($pt->getName() . ' ' . str_replace('عقارات', '', $t->getName()) . ' à ' . $c->getName()) . '</a></li>';
                                }

                                /* $url = route("front.search")."/property-for-sale/".$c->getSlug()."/".$t->getSlug();
                                  DB::table('keywords')->insert(['keyword' => trim($t->getName() .' في '. ($c->getName()=='كل المدن'?'تركيا':$c->getName())),'table'=>'project', 'lang' => 'ar', 'url'=>$url]);
                                  DB::table('keywords')->insert(['keyword' => trim('عقارات '. str_replace('عقارات','',$t->getName()) .' في '. ($c->getName()=='كل المدن'?'تركيا':$c->getName())),'table'=>'project', 'lang' => 'ar', 'url'=>$url]);
                                  DB::table('keywords')->insert(['keyword' => trim(str_replace('عقارات','',$t->getName()) . ' in ' . $c->getName()),'table'=>'project', 'lang' => 'en', 'url'=>$url]); */
                            }
                        }




                        $html = $html . '</ul>';
                    }



                    $blogcats = Helper::query("PostCategory", "all");
                    //$html = $html.'<ul class="main-tree"><li class="tree-title"><a href="'.route("front.blog").'">'.($style_lang=='ar'?'المقالات العقارية':'Blog').'</a></li>';
                    $html = $html . '<ul class="main-tree"><li class="tree-title">' . ($style_lang == 'ar' ? 'المقالات العقارية' : 'Blog') . '</li>';
                    foreach ($blogcats as $bc) {
                        $url = route("front.blog.category", $bc->getSlug());

                        $html = $html . '<li class="tree-item"><a href="' . $url . '">' . trim($bc->getName()) . '</a></li>';
                    }
                    $html = $html . '</ul>';




                    $pages = Helper::query("Page", "all");


                    //$html = $html.'<ul class="main-tree"><li class="tree-title"><a href="'.route("front.blog").'">'.($style_lang=='ar'?'شركة داماس العقارية':'Abput DamasTurk').'</a></li>';
                    $html = $html . '<ul class="main-tree"><li class="tree-title">' . ($style_lang == 'ar' ? 'شركة داماس العقارية' : 'About DamasTurk') . '</li>';
                    foreach ($pages as $p) {
                        $url = route("front.index") . '/' . $p->getSlug();

                        //if($style_lang=='ar')
                        $html = $html . '<li class="tree-item"><a href="' . $url . '">' . trim($p->getTitle()) . '</a></li>';
                        //else
                        //$html = $html.'<li class="tree-item"><a href="'.$url.'">'.trim($p->getTitleEN()).'</a></li>';
                    }

                    //exit;
                    $html = $html . '</ul>';


                    echo $html;
                    ?>


                </div>

            </div>


        </div>
        <!-- End Left Section -->


        <!-- Start Fixed Section -->
        <div class="right_sec">

            <div id="fixed_sec" class="fixed_sec">

                <section class="form shadow_type form_sec">
                    @include("front.partials.call_us_fixed")
                </section>

            </div>
        </div>
        <!-- End Fixed Section -->



    </div>
</div>





@endsection





@section('scriptjs')
<script>


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