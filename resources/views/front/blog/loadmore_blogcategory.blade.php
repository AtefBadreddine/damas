<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang,['en','fr'])?'en':'ar';

$start = $cat * 5;
$limit = 5;
//$cnt_pg
$category = Helper::query("PostCategory", "where", ["field" => "slug", "value" => $slug])->first();

$q = $category->posts()
        ->where("published", 1)
        ->whereIn("lang", ["all", $current_lang])
        ->orderBy('placement', 'ASC');
/*
  echo '<pre>';
  print_r($posts);
  echo '</pre>';
  exit; */
?>
<?php
if ($cat - $cnt_pg < 0) {
    $posts = $q->limit($limit)->offset($start)->get();
    ?>
    <div class="note-example">
        <div class="container"  style="direction:<?= $style_lang == 'en' ? 'ltr' : 'rtl' ?>">
            <div class="row">
                <article class="icoli1 article_col col-md-8 col-sm-8 col-12 p<?= $style_lang != 'en' ? 'l' : 'r' ?>5">
                    <div class="note wow fadeInUp" data-wow-duration="1.3s" style="visibility: visible; animation-duration: 1.3s; animation-name: fadeInUp;">
                        <div class="leaad">
                            <?= View::make("front.blog.partials.model_cat", ["hide_title" => true, "posts" => $posts])->render(); ?>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
    <?php
} else {
    $posts = $q->limit(1)->get();
    if ($cat - $cnt_pg == 0) {
        ?>

            <!-- share links -->
            @if(Helper::get_device()=='mob')
            @include("front.partials.share_links", [])
            @endif


        <div class="note-example">
            <div class="container"  style="direction:<?= $style_lang == 'en' ? 'ltr' : 'rtl' ?>">
                <div class="row">
                    <article class="icoli1 article_col col-md-8 col-sm-8 col-12 p<?= $style_lang != 'en' ? 'l' : 'r' ?>5">
                        @include("front.partials.call_us_social", ["form_type"    => "Blog Category - Up"])
                    </article>
                </div>
            </div>
        </div>
    <?php } elseif ($cat - $cnt_pg == 1) {
        ?>
        <div class="content cont_mobile" style="overflow:hidden;width:100%">
            <section style="float:<?= $style_lang == 'en' ? 'left' : 'right' ?>">
                <div class="projects projects-<?= $style_lang ?>" dir="<?= $style_lang == 'ar' ? 'rtl' : 'ltr' ?>">
                    <div class="project-build">
                        <h3 class="colored blog-heading">
                            <i class="flaticon-award"></i>
                            <?= trans("front.featured projects"); ?> </h3>
                        <div class="project-build-slider owl-carousel slider is_mobile_<?= $style_lang ?>">
                            <?php
                            $post_projects = @$posts[0]->projects;
                            ?>
                            @foreach($post_projects as $post_project)
                            <div class="item">
                                @include("front.partials.project_item", ["project" => $post_project, "open_blank" => false, "class" => "card-small","page"=>"index",'ajax'=>true])
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <script>

            /** project slider **/
            $(".projects-ar .owl-carousel").owlCarousel({
                autoWidth: true,
                rtl: true,
                nav: true,
                smartSpeed: 600
            })

            $(".projects-en .owl-carousel").owlCarousel({
                autoWidth: true,
                nav: true,
                smartSpeed: 600
            })
        </script>
    <?php } elseif ($cat - $cnt_pg == 2) {
        ?>
        <div class="container">
            <!--Mob-->

            @include("front.partials.most-watched", [ "full" => false,'ajax'=>true ])


            @include("front.partials.blk_left_search", ['mob'=>true])
            @include("front.partials.about_damass_mob", [])

        </div>
    <?php } ?>

<?php } ?>
