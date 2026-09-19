<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang,['en','fr'])?'en':'ar';
?>
@extends('front.layout', [
"page_title" => $agent->getSeoTitle(),
"page_description" => $agent->getSeoDescription(),
"og_image" => Helper::media_url($agent->photo),
])
@section('main_content')
@section('styles')
<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/index.css"); ?>
    <?= Html::style("resources/assets/css/searchpage.css"); ?>
    <!--<?= Html::style("resources/assets/css/owl.carousel.min.css"); ?>-->
    <?= Html::style("resources/assets/css/left_form_search.css"); ?>
    <?= Html::style("resources/assets/css/bootstrap-multiselect.css"); ?>
    <?= Html::style("resources/assets/css/new-css/myChart.css"); ?>
    <?= Html::style("resources/assets/css/jquery.rateyo.css"); ?>

    <?php /* Html::style("resources/assets/css/new-css/myChart.css"); */ ?>
    <?= Html::style("resources/assets/css/new-css/projects-new.css"); ?>



    <?php if (Helper::get_device() != 'full') { ?>
        <?= Html::style("resources/assets/css/agent.css"); ?>
    <?php } else { ?>
        <?= Html::style("resources/assets/css/agent-full.css"); ?>
    <?php } ?>




    <?php if ($style_lang == 'en') { ?>

        <?php if (Helper::get_device() != 'full') { ?>
            <?= Html::style("resources/assets/css/agent-en.css"); ?>
        <?php } else { ?>
            <?= Html::style("resources/assets/css/agent-en-full.css"); ?>
        <?php } ?>

    <?php } ?>

<?php } else { ?>
    <style><?php include(public_path() . "/css/agent-" . (Helper::get_device() != 'full' ? 'mob' : 'full') . ($style_lang == 'en' ? '-en' : '') . ".min.css"); ?></style>
<?php } ?>

@endsection

<style>
    .blk_model .list-group {
        list-style:none;
        padding:0;
    }
    .blk_model>.list-group>.list-group-item {

        display: block;

        float: right;

        clear: both;

        padding: 12px 18px 7px 18px;
    }
    .blk_model>.list-group {
        float:none;
        width:100%;
    }
    .blk_model>.list-group>.list-group-item>.list-group {
        background-color:#ebfbdf;
        display: block;
        /* width:25%; */
        /* float:right; */
        /* clear: both; */
    }

    .blk_model>.list-group>.list-group-item>.list-group {
        background-color:#fbe9e9
    }
    .blk_model>.list-group-item>.list-group-item{
        font-size:22px;padding: 15px 0 20px 0;
    }
    .blk_model>.list-group>.list-group>.list-group-item{
        font-size:16px;padding: 25px 0 15px 0;
    }
    .blk_model>.list-group>.list-group-item>.list-group>.list-group-item>.list-group>.list-group-item{
        font-size:13px;
        padding: 2px 0 3px 0;
        font-family: DroidNaskhRegular!important;
    }
    .blk_model>.list-group>.list-group-item>a{
        display:block;
        font-size: 20px;
        color: #000;
    }
    .blk_model>.list-group>.list-group-item>.list-group>.list-group-item{
        float:right;
        padding: 15px 33px 14px 33px;
        width: 25%;
    }
    .blk_model>.list-group>.list-group-item>.list-group>.list-group-item>a{
        color:#000
    }
    .blk_model>.list-group>.list-group-item>.list-group>.list-group-item>.list-group{
        padding: 11px 16px 0 0;
    }
    .blk_model {
        padding: 39px 20px;
    }
    @media (max-width : 990px) {
        .blk_model>.list-group>.list-group-item>.list-group>.list-group-item{
            width:100%
        }
        .blk_model>.list-group>.list-group-item {
            padding: 12px 8px 7px 0px;
        }
        .blk_model {
            float: left;
            width: 100%;
            padding: 20px 10px;
            margin: 0px;
        }
    }
.section-radar .icon-two {
background-color: #fff;
}
</style>





<?php if (Helper::get_device() != 'full') { ?>

    <article class="contact"  dir="<?= $style_lang == 'en' ? 'ltr' : 'rtl' ?>">
        <section class="container" style="padding:0">

            <!-- Start Info Section -->
            <div class="agent-info">
                <div class="image pull-right">
                    <img src="<?= asset("img/mask.png"); ?>" alt="Damas">
                    <div class="image-content" style="background-image: url('<?= Helper::media_url($agent->photo); ?>')"></div>
                </div>
                <div class="text pull-left">
                    <?php
                    $reviews = $agent->reviews->where('enabled', 1)->sortByDesc('created_at');
                    ?>
                    <h2><?= $agent->getName() ?></h2>
                    <span><?= $agent->getF('career') ?></span>
                    <div class="rating">
                        <div id="rateYo" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= round($reviews->avg('avg_rv'), 1) ?>"></div>
                        <div class="rating-ratio"><?= round($reviews->avg('avg_rv'), 1) ?></div>
                        <div class="number-of-ratings"><?= trans("front.Rating") ?><span><?= count($reviews) ?></span></div>
                    </div>
                    <span class="phone"><?= $agent->phone ?></span>
                    <span class="email"><?= $agent->email ?></span>
                </div>
            </div>

            <!-- Start About Section -->
            <div class="col-md-12 col-sm-12 col-12">
                <div class="about-agent">
                    <div class="icon-bg"></div>
                    <h2><?= $agent->getF('about_agent_title') ?></h2>
                    <div class="blk_model">
                        <ul class="text-content">
                            <?php
                            $arr = explode("\n", $agent->getF('about_agent_desc'));
                            foreach ($arr as $r) {
                                if (trim($r) != '') {
                                    ?>
                                    <li>
                                        <span class="check-icon icon-bg"></span>
                                        <p><?= $r ?></p>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                        <!-- Start Social Links -->
                        <div class="social-links">
                            <ul>
							<?php if($agent->facebook!=''){ ?>
                                <li><a href="<?= $agent->facebook ?>" rel="nofollow" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<?php }
							if($agent->twitter!=''){?>
								<li><a href="<?= $agent->twitter ?>" rel="nofollow" target="_blank"><i class="fa fa-twitter"></i></a></li>
                               <?php }
							   if($agent->linkedin!=''){?>
								<li><a href="<?= $agent->linkedin ?>" rel="nofollow" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                <?php }
								if($agent->instagram!=''){?>
								<li><a href="<?= $agent->instagram ?>" rel="nofollow" target="_blank"><i class="fa fa-instagram"></i></a></li>
                                <?php }
								if($agent->youtube!=''){?>
								<li><a href="<?= $agent->youtube ?>" rel="nofollow" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
								<?php } ?>
                            </ul>
                        </div>
                        <!-- End Social Links -->
                    </div>
                </div>
            </div>


            <!-- Start Advantages Section -->
            <div class="col-md-12 col-sm-12 col-12">
                <div class="about-agent advantages">
                    <div class="icon-bg"></div>
                    <h2><?= $agent->getF('avantages_title') ?></h2>
                    <div class="blk_model">
                        <ul class="text-content">
                            <?php
                            $arr = explode("\n", $agent->getF('avantages_desc'));
                            foreach ($arr as $r) {
                                if (trim($r) != '') {
                                    ?>
                                    <li>
                                        <span class="check-icon icon-bg"></span>
                                        <p><?= $r ?></p>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                        <ul class="regions">
                            <?php
                            $arr = explode("\n", $agent->getF('avantages_regions'));
                            foreach ($arr as $r) {
                                if (trim($r) != '') {
                                    ?>
                                    <li><p><?= $r ?></p></li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>


            <!-- Start First Slider Project -->
            <div class="project-slider">
                <h2><?= trans("front.CurrentProjects") ?></h2>
                <?php
                //$project_cat = Helper::query("ProjectCategory", "whereIn", ["field" => "slug", "value" => ['sea-views', 'luxury-real-estate']])->get();
                $q = \App\Models\Project::where("published", 1);
                $q->where('region_id', $agent->region_id);
                /* foreach ($project_cat as $project_cat_row)
                  $q->whereIn("id", function($q_pf) use ($project_cat_row) {
                  $q_pf->select("project_id")->from("project_category")->where("project_category_id", $project_cat_row->id);
                  }); */
                $q->orderBy("created_at", "desc");
				$qv = clone $q;
				$pv = $qv->get();
                $q->limit(6);
                $projects = $q->get();
                ?>
                <div class="carouselContainer" dir="<?= $style_lang == 'ar' ? 'rtl' : 'ltr' ?>">
                    <div class="innerCarousel">
                        <ul class="carouselList">
                            @foreach($projects as $prj)
                            <li class="item">
                                @include("front.partials.project_item", ["project" => $prj, "open_blank" => false, "class" => "card-small","page"=>"index"])
                            </li>
                            @endforeach
                            <li class="item">
                                <div class="more-option">
                                    <a href="<?= route("front.search") . "/property-for-sale/turkey/" . $agent->region->slug; ?>">
                                        <div class="logo">
                                            <img src="https://www.damas.net/img/Logo1.svg">
                                        </div>
                                        <span><?= trans("front.More options") ?></span> 
                                        <i class="flaticon-copy-files"></i> 
                                    </a> 
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- End First Slider Project -->


            <!-- Start Customer Evaluation -->
            <div class="col-md-12 col-sm-12 col-12">
                <div class="customer-evaluation">
                    <h2><?= trans("front.CustomerReviews") ?></h2>

                    <!-- Average Ratings -->
                    <div class="blk_model">
                        <ul class="rating-section average">
                            <li>
                                <label><span class="icon-bg"></span><p><?= trans("front.Professionalism dealing") ?></p></label>
                                <div class="rating-ratio"><?= round($reviews->avg('rv1'), 1) ?></div>
                                <div id="averageRatings1" class="clientRating avg_rate" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= round($reviews->avg('rv1'), 1) ?>"></div>
                            </li>
                            <li>
                                <label><span class="icon-bg"></span><p><?= trans("front.Communicate and follow up") ?></p></label>
                                <div class="rating-ratio"><?= round($reviews->avg('rv2'), 1) ?></div>
                                <div id="averageRatings2" class="clientRating avg_rate" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= round($reviews->avg('rv2'), 1) ?>"></div>
                            </li>
                            <li>
                                <label><span class="icon-bg"></span><p><?= trans("front.Credibility") ?></p></label>
                                <div class="rating-ratio"><?= round($reviews->avg('rv3'), 1) ?></div>
                                <div id="averageRatings3" class="clientRating avg_rate" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= round($reviews->avg('rv3'), 1) ?>"></div>
                            </li>
                            <li>
                                <label><span class="icon-bg"></span><p><?= trans("front.Experience in real estate") ?></p></label>
                                <div class="rating-ratio"><?= round($reviews->avg('rv4'), 1) ?></div>
                                <div id="averageRatings4" class="clientRating avg_rate" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= round($reviews->avg('rv4'), 1) ?>"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>



            <!-- Start Comments Section -->
            <div class="col-md-12 col-sm-12 col-12">
                <div class="comments-section">
                    <?php
                    if (count($reviews) > 0) {
                        ?>
                        <div class="blk_model">
                            <?php
                            $ii = 0;
                            foreach ($reviews as $r) {
                                $ii++;
                                ?>
                                <div class="content <?= $ii > 3 ? 'hidden' : '' ?>">
                                    <div class="top-section">
                                        <div class="clientInfo">
                                            <div class="details">
                                                <h2><?= $r->getF('client_name') ?></h2>
                                                <span class="city"><?= $r->getF('client_country') ?><i class="fa fa-map-marker"></i></span>
                                                <span class="date"><?= $r->created_at ?></span>
                                            </div>
                                        </div>
                                        <div class="stars-section">
                                            <div class="rating-ratio">
                                                <?= round($r->avg_rv, 1) ?></div>
                                            <div class="bigrateYo" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= round($r->avg_rv, 1) ?>" id="totalCustomerRatings"></div>
                                        </div>
                                    </div>
                                    <!--                                    <ul class="rating-section done">
                                                                            <li>
                                                                                <label><p>الاحترافية بالتعامل</p></label>
                                                                                <div class="rateYo clientRating" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= $r->rv1 ?>"></div>
                                                                            </li>
                                                                            <li>
                                                                                <label><p>التواصل والمتابعة</p></label>
                                                                                <div class="rateYo clientRating" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= $r->rv2 ?>"></div>
                                                                            </li>
                                                                            <li>
                                                                                <label><p>المصداقية</p></label>
                                                                                <div class="rateYo clientRating" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= $r->rv3 ?>"></div>
                                                                            </li>
                                                                            <li>
                                                                                <label><p>الخبرة بمجال العقارات</p></label>
                                                                                <div class="rateYo clientRating" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= $r->rv4 ?>"></div>
                                                                            </li>
                                                                            <li>
                                                                                <label><p>الخبرة في المناطق التركية</p></label>
                                                                                <div class="rateYo clientRating" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= $r->rv5 ?>"></div>
                                                                            </li>
                                                                            <li>
                                                                                <label><p>التعامل معه مرة أخرى</p></label>
                                                                                <div class="rateYo clientRating" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= $r->rv6 ?>"></div>
                                                                            </li>
                                                                        </ul>-->
                                    <p class="comment-text <?= (strlen($r->getF('comment')) > 200) ? 'hideText' : '' ?>">
                                        <?= htmlspecialchars($r->getF('comment')) ?>
                                        <button class="more-less-btn"><?= trans("front.read more") ?></button>
                                    </p>

                                </div>
                            <?php } ?>

                        </div>
                    <?php } ?>
                </div>
            </div>


            <div class="section-btn">
                <a class="add-rating-btn"><?= trans("front.Add Your Rating") ?></a>
            </div>


            <!-- Rating and Comment -->
            <div class="col-md-12 col-sm-12 col-12 rating-comment-section">
                <div class="customer-evaluation">
                    <div class="blk_model">
                        <div class="top-info">
                            <a class="close-form"><img src="<?= asset("img/close-icon-new.svg"); ?>" alt="Damas"></a>
                            <img src="<?= Helper::media_url($agent->photo); ?>" alt="Damas">
                            <div class="text">
                                <span><?= trans("front.Rate your business with") ?></span>
                                <h2><?= $agent->getName() ?></h2>
                                <span><?= $agent->getF('career') ?></span>
                            </div>
                        </div>
                        <?= Form::open(["url" => route("front.ajax", ['option' => 'agent_review']), "id" => "form-agent-reviews"]); ?>				
                        <ul class="rating-section">
                            <li>
                                <label><span class="icon-bg"></span><p><?= trans("front.Professionalism dealing") ?></p></label>
                                <div class="clientRating globrate" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>"></div>
                                <input type="hidden" name="rv1">
                            </li>

                            <li>
                                <label><span class="icon-bg"></span><p><?= trans("front.Communicate and follow up") ?></p></label>
                                <div class="clientRating globrate" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>"></div>
                                <input type="hidden" name="rv2">
                            </li>
                            <li>
                                <label><span class="icon-bg"></span><p><?= trans("front.Credibility") ?></p></label>
                                <div class="clientRating globrate" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>"></div>
                                <input type="hidden" name="rv3">
                            </li>
                            <li>
                                <label><span class="icon-bg"></span><p><?= trans("front.Experience in real estate") ?></p></label>
                                <div class="clientRating globrate" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>"></div>
                                <input type="hidden" name="rv4">
                            </li>
                            <li><p class="title"><?= trans("front.Quality title") ?></p></li>
                        </ul>
                        <input type="hidden" name="sale_manager_id" value="<?= $agent->id ?>">

                        <div class="comment-section info-section">
                            <div class="form-group">
                                <label><?= trans("front.name") ?></label>
                                <input type="text" name="client_name" placeholder="">
                            </div>
                        </div>
                        <div class="comment-section info-section">
                            <div class="form-group">
                                <label><?= trans("front.country") ?></label>
                                <input type="text" name="client_country" placeholder="">
                            </div>
                        </div>
                        <div class="comment-section">
                            <div class="form-group">
                                <label><?= trans("front.Tell others what you think") ?></label>
                                <textarea name="comment" id="ratingComment" placeholder=""></textarea>
                                <button type="submit" class="sendRating "><?= trans("front.send") ?></button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>







            <!-- Start Shear icons -->
            <div class="shareSection">
                <p><?= trans("front.Share the page") ?></p>
                <div class="shareBtnsFloating sharepost">
                    <a href="" class="btnshare" data-network="facebook"><i class="fa fa-facebook"></i></a>
                    <a href="" class="btnshare" data-network="twitter"><i class="fa fa-twitter"></i></a>
                    <a href="" class="btnshare" data-network="whatsapp"><i class="fa fa-whatsapp"></i></a>
                </div>
            </div>

            <!-- Start Customers service Form -->
            <div class="col-md-12 col-sm-12 col-12">
                <div class="new-content">
                    @include("front.partials.callus_consulting_department", ['place'=>'Header',"form_type" => "citizenship - consulting department"])
                </div>
            </div>
            <!-- End Customers service Form -->




            <!-- Start Agent statistics -->
            <div class="col-md-12 col-sm-12 col-12">
                <div class="new-content agent-statistics">
                    <h2><?= trans("front.AgentStatisticst") ?></h2>
                    <div class="blk_model">
                        <div class="content">
                            <h3><?= trans("front.TheGoalOfRepossession") ?></h3>
                            <div class="col-md-12">
                                <div class="circle-section">
                                    <div id="doughnutChart" class="chart"></div>
                                </div>
                                <ul class="chart-list">
                                    <li>
                                        <div class="circle green"></div><p>25% <?= trans("front.Living") ?></p>
                                    </li>
                                    <li>
                                        <div class="circle orange"></div><p>25% <?= trans("front.Investment") ?></p>
                                    </li>
                                    <li>
                                        <div class="circle grey"></div><p>25% <?= trans("front.Holidays") ?></p>
                                    </li>
                                    <li>
                                        <div class="circle blue"></div><p>25% <?= trans("front.TurkishCitizenship") ?></p>
                                    </li>
                                </ul>
                            </div>
                        </div>


                        <div class="content">
                            <h3><?= trans("front.Types of real estate") ?></h3>

                            <div class="col-md-12">
                                <div class="circle-section">
                                    <div id="doughnutChart2" class="chart"></div>
                                </div>

                                <ul class="chart-list">
                                    <li>
                                        <div class="circle green"></div><p>30% <?= trans("front.Apartments") ?></p>
                                    </li>
                                    <li>
                                        <div class="circle orange"></div><p>30% <?= trans("front.Shops") ?></p>
                                    </li>
                                    <li>
                                        <div class="circle grey"></div><p>30% <?= trans("front.Villas") ?></p>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="content">
                            <h3><?= trans("front.ClientsNationalities") ?></h3>

                            <div class="col-md-12">
                                <div class="circle-section">
                                    <div id="doughnutChart3" class="chart"></div>
                                </div>

                                <ul class="chart-list">
                                    <li>
                                        <div class="circle green"></div><p>25% <?= trans("front.Saudis") ?></p>
                                    </li>
                                    <li>
                                        <div class="circle orange"></div><p>25% <?= trans("front.Jordanians") ?></p>
                                    </li>
                                    <li>
                                        <div class="circle grey"></div><p>25% <?= trans("front.Palestinians") ?></p>
                                    </li>
                                    <li>
                                        <div class="circle blue"></div><p>25% <?= trans("front.OtherNationalities") ?></p>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="average-section">
                            <h3><?= trans("front.AverageClientBudgetsForThisAgent") ?></h3>
                            <ul class="average-list">
                                <li>
                                    <span>325K$</span>
                                    <p><?= trans("front.Max") ?></p>
                                </li>
                                <li class="active">
                                    <span>175K$</span>
                                    <p><?= trans("front.Middle") ?></p>
                                </li>
                                <li>
                                    <span>100K$</span>
                                    <p><?= trans("front.Min") ?></p>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Agent statistics -->




            <!-- Start Latest Videos -->
            <div class="col-md-12 col-sm-12 col-12">
                <div class="latest-videos">
                    <h2><?= trans("front.Latest Videos") ?></h2>
                    <ul class="videos-list">
                        <?php
						
                        foreach ($pv as $prj) {
                            $link_video = $prj->getLinkVideo();
                            parse_str(parse_url($link_video, PHP_URL_QUERY), $array_of_vars);
                            $video_code = @$array_of_vars['v'];
                            if (trim($link_video) != '') {
                                ?>
                                <li>

                                    <a data-fancybox href="https://www.youtube.com/embed/<?= $video_code; ?>" style="display:block">
                                        <img src="https://img.youtube.com/vi/<?= $video_code; ?>/hqdefault.jpg" style="max-width:160px">
                                        <img class="play-icon" src="<?= asset("img/play-icon.svg"); ?>" alt="Damas">
                                    </a>
                                    <!--<iframe width="250" height="150" src="https://www.youtube.com/embed/<?= $video_code; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <!-- End Latest Videos -->

            <!-- Start Section statistics -->
            <div class="col-md-12 col-sm-12 col-12">
                <div class="new-content">

                </div>
            </div>
            <!-- End Section statistics  -->




            <!-- Start Statistics  -->
            <div class="col-md-12 col-sm-12 col-12">
                <div class="new-content statistics">
                    <?php
                    $region = $agent->region;
                    ?>
                    <?php /* ?><?php */ ?>
                    @include("front.loadmore_projects.statistics", ['region'=>$region,'hide_most'=>true])


                </div>
            </div>

            <!-- End Statistics  -->




            <!-- Start Call Us -->
            <div class="col-md-12 col-sm-12 col-12">
                <div class="new-content">
                    @include("front.partials.call_us", ["form_type" => "Home - Down",'style'=>'width:100%;margin:0'])
                </div>
            </div>
            <!-- End Call Us  -->


            <!-- Start About Damas -->
            <div class="new-content">
                @include("front.loadmore_index.about-damas")
            </div>
            <!-- End About Damas -->


        </section>
    </article>


<?php } else { ?>


    <!-- Full Section -->
    <article class="contact"  dir="<?= $style_lang == 'en' ? 'ltr' : 'rtl' ?>">
        <section class="container" style="padding:0">

            <div class="section-right">

                <!-- Start Info Section -->
                <div class="agent-info">
                    <div class="image pull-right">
                        <img src="<?= asset("img/mask.png"); ?>" alt="Damas">
                        <div class="image-content" style="background-image: url('<?= Helper::media_url($agent->photo); ?>')"></div>
                    </div>
                    <div class="text pull-left">
                        <?php
                        $reviews = $agent->reviews->where('enabled', 1)->sortByDesc('created_at');
                        ?>
                        <h2><?= $agent->getName() ?></h2>
                        <span><?= $agent->getF('career') ?></span>
                        <div class="rating">
                            <div id="rateYo" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= round($reviews->avg('avg_rv'), 1) ?>"></div>
                            <div class="rating-ratio"><?= round($reviews->avg('avg_rv'), 1) ?></div>
                            <div class="number-of-ratings"><?= trans("front.Rating") ?><span><?= count($reviews) ?></span></div>
                        </div>
                        <span class="phone"><?= $agent->phone ?></span>
                        <span class="email"><?= $agent->email ?></span>
                    </div>
                </div>

                <!-- Start About Section -->
                <div class="about-agent">
                    <div class="icon-bg"></div>
                    <h2><?= $agent->getF('about_agent_title') ?></h2>
                    <div class="blk_model">
                        <ul class="text-content">
                            <?php
                            $arr = explode("\n", $agent->getF('about_agent_desc'));
                            foreach ($arr as $r) {
                                if (trim($r) != '') {
                                    ?>
                                    <li>
                                        <span class="check-icon icon-bg"></span>
                                        <p><?= $r ?></p>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>

                        <!-- Start Social Links -->
                        <div class="social-links">
                            <ul>
                            
							<?php if($agent->facebook!=''){ ?>
                                <li><a href="<?= $agent->facebook ?>" rel="nofollow" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<?php }
							if($agent->twitter!=''){?>
								<li><a href="<?= $agent->twitter ?>" rel="nofollow" target="_blank"><i class="fa fa-twitter"></i></a></li>
							   <?php }
							   if($agent->linkedin!=''){?>
								<li><a href="<?= $agent->linkedin ?>" rel="nofollow" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                <?php }
								if($agent->instagram!=''){?>
								<li><a href="<?= $agent->instagram ?>" rel="nofollow" target="_blank"><i class="fa fa-instagram"></i></a></li>
                                <?php }
								if($agent->youtube!=''){?>
								<li><a href="<?= $agent->youtube ?>" rel="nofollow" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
								<?php } ?>
							
							</ul>
                        </div>
                        <!-- End Social Links -->

                    </div>
                </div>


                <!-- Start Advantages Section -->
                <div class="about-agent advantages">
                    <div class="icon-bg"></div>
                    <h2><?= $agent->getF('avantages_title') ?></h2>
                    <div class="blk_model">
                        <ul class="text-content">
                            <?php
                            $arr = explode("\n", $agent->getF('avantages_desc'));
                            foreach ($arr as $r) {
                                if (trim($r) != '') {
                                    ?>
                                    <li>
                                        <span class="check-icon icon-bg"></span>
                                        <p><?= $r ?></p>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                        <ul class="regions">
                            <?php
                            $arr = explode("\n", $agent->getF('avantages_regions'));
                            foreach ($arr as $r) {
                                if (trim($r) != '') {
                                    ?>
                                    <li><p><?= $r ?></p></li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>



            <div class="section-left">
                <div class="left-form-full-content open agent-page">
                    <div class="right-form-content animated right-form-en">
                        <div class="col-md-12">
                            <img class="customers-service-icon" src="<?= asset('/img/customers-service-icon-b.svg') ?>" alt="customers-service-icon"/>
                        </div>
                        <div class="info">
                            <h3><?= trans("front.Contact With Real Estate Agent"); ?></h3>
                            <span>+90 555 160 50 00</span>
                            <div class="whatsapp">
                                <a target="_blank" href="https://www.damas.net/whatsapp_share?icon=6">
                                    <div class="whatsapp-icon"><i class="fa fa-whatsapp"></i></div>
                                </a>
                            </div>
                        </div>
                        <div class="right-form">
                            <?= Form::open(["url" => route("front.callus"), "id" => "form-callus-lg"]); ?>
                            <div class="name">
                                <input type="text" name="name" placeholder="* <?= trans("front.name and fame"); ?>">
                            </div>
<!--                            <div class="fame">
                                <input type="text" name="fame" placeholder="* <?= trans("front.fame"); ?>">
                            </div>-->
<!--                            <div class="email">
                                <input type="text" name="email" placeholder="<?= trans("front.email"); ?>" class="bluring" />
                            </div>-->
                            <div style="clear: both;margin-top:8px"></div>
                            <div class="tel">
                                <input type="text" name="mobile" id="mobile-sm" value="{{ @session()->get('call_country') }}" placeholder="+90 123456789">
                            </div>
                            <div class="textarea">
                                <textarea  rows="2" cols="20" name="message" placeholder=" <?= trans("front.is the property for housing or tourism? how many rooms?"); ?>..."></textarea>
                            </div>
                            <div class="time">
                                <select name="communication_time" title="<?= trans("front.communication time"); ?>">
                                    @if(Helper::is_mobile())
                                    <option value="" id="tm"><?= trans("front.communication time"); ?></option>
                                    @else
                                    <option value="" id="tm"><?= trans("front.communication time"); ?></option>
                                    @endif
                                    <option>9 - 12 AM</option>
                                    <option>12 - 3 PM</option>
                                    <option>3 - 6 PM</option>
                                    <option>6 - 9 PM</option>
                                    <option><?= trans("front.any time"); ?></option>
                                    <option><?= trans("front.now"); ?></option>
                                </select>
                            </div>
                            <div class="budget">
                                <select name="budget" title="<?= trans("front.budget"); ?>">
                                    @if(Helper::is_mobile())
                                    <option value="" id="bd"><?= trans("front.budget"); ?></option>
                                    @else
                                    <option value="" id="bd"><?= trans("front.budget"); ?></option>
                                    @endif
                                    <option dir="ltr">50K $ - 100K $</option>
                                    <option dir="ltr">100K $ - 150K $</option>
                                    <option dir="ltr">150K $ - 250K $</option>
                                    <option dir="ltr">250K $ - 400K $</option>
                                    <option dir="ltr">400K $ - 600K $</option>
                                    <option dir="ltr">600K $ - 1M $</option>
                                    <option dir="ltr">1M $ - 2M $</option>
                                    <option dir="ltr">+2M $</option>
                                </select>
                            </div>
                            <input type="hidden" name="form_type" value="Pop Up - Home"/>
                            <button type="submit" style="border: 0px; background-color: transparent"><img src="{{ asset('img/send2.png') }}"></button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>




            <!-- Start First Slider Project -->

            <div class="new-content">

                <div class="section-slider">
                    <h2><?= trans("front.CurrentProjects") ?></h2>

                    <?php
                    //$project_cat = Helper::query("ProjectCategory", "whereIn", ["field" => "slug", "value" => ['sea-views', 'luxury-real-estate']])->get();
                    $q = \App\Models\Project::where("published", 1);
                    $q->where('region_id', $agent->region_id);
                    /* foreach ($project_cat as $project_cat_row)
                      $q->whereIn("id", function($q_pf) use ($project_cat_row) {
                      $q_pf->select("project_id")->from("project_category")->where("project_category_id", $project_cat_row->id);
                      }); */
                    $q->orderBy("created_at", "desc");
					$qv = clone $q;
					$pv = $qv->get();
                    $q->limit(6);
                    $projects = $q->get();
                    ?>
                    <div class="content">
                        <div class="blk_model">
                            <div class="projects projects-<?= $style_lang ?>" dir="<?= $style_lang == 'ar' ? 'rtl' : 'ltr' ?>">
                                <div class="project-build">
                                    <div class="project-build-slider owl-carousel slider">
                                        @foreach($projects as $prj)
                                        <li class="item">
                                            @include("front.partials.project_item", ["project" => $prj, "open_blank" => false, "class" => "card-small","page"=>"index"])
                                        </li>
                                        @endforeach

                                        <div class="more-option">
                                            <a href="<?= route("front.search") . "/property-for-sale/turkey/" . $agent->region->slug; ?>">
                                                <div class="logo">
                                                    <img src="https://www.damas.net/img/Logo1.svg">
                                                </div>
                                                <span><?= trans("front.More options") ?></span> 
                                                <i class="flaticon-copy-files"></i> 
                                            </a> 
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="new-content">
                <h2><?= trans("front.CustomerReviews") ?></h2>
                <div class="section-left two">
                    <!-- Start Customer Evaluation -->
                    <div class="customer-evaluation">
                        <!-- Average Ratings -->
                        <div class="blk_model">
                            <ul class="rating-section average">
                                <li>
                                    <label><span class="icon-bg"></span><p><?= trans("front.Professionalism dealing") ?></p></label>
                                    <div class="rating-ratio"><?= round($reviews->avg('rv1'), 1) ?></div>
                                    <div id="averageRatings1" class="clientRating avg_rate" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= round($reviews->avg('rv1'), 1) ?>"></div>
                                </li>
                                <li>
                                    <label><span class="icon-bg"></span><p><?= trans("front.Communicate and follow up") ?></p></label>
                                    <div class="rating-ratio"><?= round($reviews->avg('rv2'), 1) ?></div>
                                    <div id="averageRatings2" class="clientRating avg_rate" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= round($reviews->avg('rv2'), 1) ?>"></div>
                                </li>
                                <li>
                                    <label><span class="icon-bg"></span><p><?= trans("front.Credibility") ?></p></label>
                                    <div class="rating-ratio"><?= round($reviews->avg('rv3'), 1) ?></div>
                                    <div id="averageRatings3" class="clientRating avg_rate" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= round($reviews->avg('rv3'), 1) ?>"></div>
                                </li>
                                <li>
                                    <label><span class="icon-bg"></span><p><?= trans("front.Experience in real estate") ?></p></label>
                                    <div class="rating-ratio"><?= round($reviews->avg('rv4'), 1) ?></div>
                                    <div id="averageRatings4" class="clientRating avg_rate" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= round($reviews->avg('rv4'), 1) ?>"></div>
                                </li>
                            </ul>
                        </div>
                    </div>


                    <!-- Rating and Comment -->
                    <div class="rating-comment-section open">
                        <div class="customer-evaluation">
                            <div class="blk_model">
                                <div class="top-info">
                                    <img src="<?= Helper::media_url($agent->photo); ?>" alt="Damas">
                                    <div class="text">
                                        <span><?= trans("front.Rate your business with") ?></span>
                                        <h2><?= $agent->getName() ?></h2>
                                        <span><?= $agent->getF('career') ?></span>
                                    </div>
                                </div>
                                <?= Form::open(["url" => route("front.ajax", ['option' => 'agent_review']), "id" => "form-agent-reviews"]); ?>				
                                <ul class="rating-section">
                                    <li>
                                        <label><span class="icon-bg"></span><p><?= trans("front.Professionalism dealing") ?></p></label>
                                        <div class="clientRating globrate" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>"></div>
                                        <input type="hidden" name="rv1">
                                    </li>

                                    <li>
                                        <label><span class="icon-bg"></span><p><?= trans("front.Communicate and follow up") ?></p></label>
                                        <div class="clientRating globrate" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>"></div>
                                        <input type="hidden" name="rv2">
                                    </li>
                                    <li>
                                        <label><span class="icon-bg"></span><p><?= trans("front.Credibility") ?></p></label>
                                        <div class="clientRating globrate" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>"></div>
                                        <input type="hidden" name="rv3">
                                    </li>
                                    <li>
                                        <label><span class="icon-bg"></span><p><?= trans("front.Experience in real estate") ?></p></label>
                                        <div class="clientRating globrate" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>"></div>
                                        <input type="hidden" name="rv4">
                                    </li>
                                    <li><p class="title"><?= trans("front.Quality title") ?></p></li>
                                </ul>
                                <input type="hidden" name="sale_manager_id" value="<?= $agent->id ?>">

                                <div class="comment-section info-section">
                                    <div class="form-group">
                                        <label><?= trans("front.name") ?></label>
                                        <input type="text" name="client_name" placeholder="">
                                    </div>
                                </div>
                                <div class="comment-section info-section">
                                    <div class="form-group">
                                        <label><?= trans("front.country") ?></label>
                                        <input type="text" name="client_country" placeholder="">
                                    </div>
                                </div>
                                <div class="comment-section">
                                    <div class="form-group">
                                        <label><?= trans("front.Tell others what you think") ?></label>
                                        <textarea name="comment" id="ratingComment" placeholder=""></textarea>
                                        <button type="submit" class="sendRating "><?= trans("front.send") ?></button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-right two">
                    <!-- Start Comments Section -->
                    <div class="comments-section">

                        <?php
                        if (count($reviews) > 0) {
                            ?>

                            <div class="blk_model">
                                <div class="scroll-cont scrollbar">
                                    <?php
                                    $ii = 0;
                                    foreach ($reviews as $r) {
                                        $ii++;
                                        ?>
                                        <div class="content">
                                            <div class="top-section">
                                                <div class="clientInfo">
                                                    <div class="details">
                                                        <h2><?= $r->getF('client_name') ?></h2>
                                                        <span class="city"><?= $r->getF('client_country') ?><i class="fa fa-map-marker"></i></span>
                                                        <span class="date"><?= $r->created_at ?></span>
                                                    </div>
                                                </div>
                                                <div class="stars-section">
                                                    <div class="rating-ratio">
                                                        <?= round($r->avg_rv, 1) ?></div>
                                                    <div class="bigrateYo" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= round($r->avg_rv, 1) ?>" id="totalCustomerRatings"></div>
                                                </div>
                                            </div>
                                            <!--                                    <ul class="rating-section done">
                                                                                    <li>
                                                                                        <label><p>الاحترافية بالتعامل</p></label>
                                                                                        <div class="rateYo clientRating" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= $r->rv1 ?>"></div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <label><p>التواصل والمتابعة</p></label>
                                                                                        <div class="rateYo clientRating" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= $r->rv2 ?>"></div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <label><p>المصداقية</p></label>
                                                                                        <div class="rateYo clientRating" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= $r->rv3 ?>"></div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <label><p>الخبرة بمجال العقارات</p></label>
                                                                                        <div class="rateYo clientRating" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= $r->rv4 ?>"></div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <label><p>الخبرة في المناطق التركية</p></label>
                                                                                        <div class="rateYo clientRating" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= $r->rv5 ?>"></div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <label><p>التعامل معه مرة أخرى</p></label>
                                                                                        <div class="rateYo clientRating" data-rtl="<?= $style_lang == 'en' ? 'false' : 'true' ?>" data-rating="<?= $r->rv6 ?>"></div>
                                                                                    </li>
                                                                                </ul>-->
                                            <div class="textSection">
                                                <p class="comment-text <?= (strlen($r->getF('comment')) > 250) ? 'hideText' : '' ?>">
                                                    <?= htmlspecialchars($r->getF('comment')) ?>
                                                    <button class="more-less-btn"><?= trans("front.read more") ?></button>
                                                </p>

                                            </div>

                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>



            <!-- Start Shear icons -->
            <div class="shareSection">
                <p><?= trans("front.Share the page") ?></p>
                <div class="shareBtnsFloating sharepost">
                    <a href="" class="btnshare" data-network="facebook"><i class="fa fa-facebook"></i></a>
                    <a href="" class="btnshare" data-network="twitter"><i class="fa fa-twitter"></i></a>
                    <a href="" class="btnshare" data-network="whatsapp"><i class="fa fa-whatsapp"></i></a>
                </div>
            </div>




            <!-- Start Agent statistics -->
            <div class="col-md-12 col-sm-12 col-12">
                <div class="new-content agent-statistics">
                    <h2><?= trans("front.AgentStatisticst") ?></h2>
                    <div class="blk_model">
                        <div class="content">
                            <h3><?= trans("front.TheGoalOfRepossession") ?></h3>
                            <div class="col-md-12">
                                <div class="circle-section">
                                    <div id="doughnutChart" class="chart"></div>
                                </div>

                                <ul class="chart-list">
                                    <li>
                                        <div class="circle green"></div><p>25% <?= trans("front.Living") ?></p>
                                    </li>
                                    <li>
                                        <div class="circle orange"></div><p>25% <?= trans("front.Investment") ?></p>
                                    </li>
                                    <li>
                                        <div class="circle grey"></div><p>25% <?= trans("front.Holidays") ?></p>
                                    </li>
                                    <li>
                                        <div class="circle blue"></div><p>25% <?= trans("front.TurkishCitizenship") ?></p>
                                    </li>
                                </ul>
                            </div>
                        </div>


                        <div class="content">
                            <h3><?= trans("front.Types of real estate") ?></h3>

                            <div class="col-md-12">
                                <div class="circle-section">
                                    <div id="doughnutChart2" class="chart"></div>
                                </div>
                                <ul class="chart-list">
                                    <li>
                                        <div class="circle green"></div><p>30% <?= trans("front.Apartments") ?></p>
                                    </li>
                                    <li>
                                        <div class="circle orange"></div><p>30% <?= trans("front.Shops") ?></p>
                                    </li>
                                    <li>
                                        <div class="circle grey"></div><p>30% <?= trans("front.Villas") ?></p>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="content">
                            <h3><?= trans("front.ClientsNationalities") ?></h3>

                            <div class="col-md-12">
                                <div class="circle-section">
                                    <div id="doughnutChart3" class="chart"></div>
                                </div>

                                <ul class="chart-list">
                                    <li>
                                        <div class="circle green"></div><p>25% <?= trans("front.Saudis") ?></p>
                                    </li>
                                    <li>
                                        <div class="circle orange"></div><p>25% <?= trans("front.Jordanians") ?></p>
                                    </li>
                                    <li>
                                        <div class="circle grey"></div><p>25% <?= trans("front.Palestinians") ?></p>
                                    </li>
                                    <li>
                                        <div class="circle blue"></div><p>25% <?= trans("front.OtherNationalities") ?></p>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="average-section">
                            <h3><?= trans("front.AverageClientBudgetsForThisAgent") ?></h3>
                            <ul class="average-list">
                                <li>
                                    <span>325K$</span>
                                    <p><?= trans("front.Max") ?></p>
                                </li>
                                <li class="active">
                                    <span>175K$</span>
                                    <p><?= trans("front.Middle") ?></p>
                                </li>
                                <li>
                                    <span>100K$</span>
                                    <p><?= trans("front.Min") ?></p>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Agent statistics -->




            <div class="section-left two">
                <!-- Start Customers service Form -->
                <div class="col-md-12 col-sm-12 col-12">
                    <div class="new-content">
                        @include("front.partials.callus_consulting_department", ['place'=>'Header',"form_type" => "citizenship - consulting department"])
                    </div>
                </div>
                <!-- End Customers service Form -->



                <!-- statistics_most -->
                <div class="col-md-12 col-sm-12 col-12">
                    <div class="new-content">
                        <div class="section-statistics">
                            @include("front.partials.statistics_most", [])
                        </div>
                    </div>
                </div>
                <!-- statistics_most -->



                <!-- Start About Damas -->
                <div class="col-md-12 col-sm-12 col-12">
                    <div class="new-content">
                        @include("front.partials.about_damass_full", [])
                    </div>
                </div>
                <!-- End About Damas -->



                <!-- Start Shear icons -->
                <div class="shareSection">
                    <p><?= trans("front.Share the page") ?></p>
                    <div class="shareBtnsFloating sharepost">
                        <a href="" class="btnshare" data-network="facebook"><i class="fa fa-facebook"></i></a>
                        <a href="" class="btnshare" data-network="twitter"><i class="fa fa-twitter"></i></a>
                        <a href="" class="btnshare" data-network="whatsapp"><i class="fa fa-whatsapp"></i></a>
                    </div>
                </div>

            </div>


            <div class="section-right two">
                <!-- Start Latest Videos -->
                <div class="col-md-12 col-sm-12 col-12">
                    <div class="latest-videos">
                        <h2><?= trans("front.Latest Videos") ?></h2>
                        <div class="blk_model">
                            <ul class="videos-list scrollbar">
                                <?php
                                foreach ($pv as $prj) {
                                    $link_video = $prj->getLinkVideo();
                                    parse_str(parse_url($link_video, PHP_URL_QUERY), $array_of_vars);
                                    $video_code = @$array_of_vars['v'];
                                    if (trim($link_video) != '') {
                                        ?>					
                                        <li>
                                            <a data-fancybox data-width="640" data-height="360" data-small-btn="true" href="https://www.youtube.com/embed/<?= $video_code; ?>">
                                                <img src="https://img.youtube.com/vi/<?= $video_code; ?>/hqdefault.jpg" style="max-width:160px">
                                                <img class="play-icon" src="<?= asset("img/play-icon.svg"); ?>" alt="Damas">
                                            </a>
            <!--<iframe width="250" height="150" src="https://www.youtube.com/embed/<?= $video_code; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Latest Videos -->



                <!-- Start Statistics  -->
                <div class="col-md-12 col-sm-12 col-12">
                    <div class="new-content statistics">
                        <?php
                        $region = $agent->region;
                        ?>
                        <?php /* ?><?php */ ?>
                        @include("front.loadmore_projects.statistics", ['region'=>$region,'hide_most'=>true])
                    </div>
                </div>

                <!-- End Statistics  -->


                <!-- Start Call Us -->
                <div class="col-md-12 col-sm-12 col-12">
                    <div class="new-content">
                        @include("front.partials.call_us", ["form_type" => "Home - Down",'style'=>'width:100%;margin:0'])
                    </div>
                </div>
                <!-- End Call Us  -->


            </div>


        </section>
    </article>

<?php } ?>
@endsection





@section('scriptjs')
<?php /* ?>
  <?= Html::script("js/radial-progress-bar.js") ?>
  <?= Html::script("js/Chart.min.js") ?>

  <?= Html::script("resources/assets/js/bootstrap-multiselect.js") ?><?php */ ?>
<?= Html::script("js/bootstrap-multiselect.js") ?>
<?= Html::script("js/myChart.js") ?>
<?= Html::script("js/jquery.rateyo.js"); ?>




<script>

    var lang = '<?= $current_lang ?>';
    $(".more-less-btn").on("click", function () {
        var commentText = $(this).parents(".comment-text");
        $(commentText).toggleClass("show");
        if ($(commentText).hasClass("show")) {
            if (lang == "ar") {
                $(this).text("أقل");
            } else {
                $(this).text("Less");
            }
        } else {
            if (lang == "ar") {
                $(this).text("اقرأ المزيد");
            } else {
                $(this).text("More");
            }
        }
    });


    $(".owl-carousel").owlCarousel({
        rtl: true,
        smartSpeed: 600,
        singleItem: true,
        autoWidth: true,
        responsiveClass: true,
        nav: true,
        lazyLoad: true,
        navText: ['<i class="fa fa-chevron-right"></i>', '<i class="fa fa-chevron-left"></i>'],
        responsive: {
            0: {
                items: 2
            }}
    });


    /*- Open Form Rating and Comment -*/
    $(".add-rating-btn").on("click", function () {
        $(".section-btn").fadeOut();
        $(".rating-comment-section").addClass("open");
    });

    /*- Close Form Rating and Comment -*/
    $(".close-form").on("click", function () {
        $(".rating-comment-section").removeClass("open");
        setTimeout(function () {
            $(".section-btn").fadeIn();
        }, 1000);
    });


    $('input[name=rs_year],input[name=rs_month]').change(function () {
        ajax_Sold_Chart('/ajax_statics', 'propertiesSold', 'rgba(13, 204, 211, 0.8)', 'rgba(13, 204, 211, 1)');
    });
    $('input[name=r_rs_year],input[name=r_rs_month]').change(function () {
        ajax_Sold_Chart('/ajax_statics', 'rentalProperties', 'rgba(231, 104, 0, 0.8)', 'rgba(231, 104, 0, 0.8)');
    });




    $(function () {
        $(".rateYo").each(function () {
            var rating = $(this).attr("data-rating");
            $(this).rateYo({
                rating: rating,
                numStars: 5,
                rtl: ($(this).attr("data-rtl")=='true'),
                starWidth: "20px",
                ratedFill: "#FEBE10",
                normalFill: "#BFBFBF",
                readOnly: true
            }
            );
        });
        $(".bigrateYo").each(function () {
            var rating = $(this).attr("data-rating");
            $(this).rateYo(
                    {
                        rating: rating,
                        numStars: 5,
                        rtl: ($(this).attr("data-rtl")=='true'),
                        spacing: "2px",
                        starWidth: "18px",
                        ratedFill: "#FEBE10",
                        normalFill: "#BFBFBF",
                        readOnly: true
                    }
            );
        });

        $("#rateYo").each(function () {
            $(this).rateYo({
                numStars: 5,
                rating: $(this).attr("data-rating"),
                rtl: ($(this).attr("data-rtl")=='true'),
                ratedFill: "#EEB31A",
                normalFill: "#ffffff",
                starWidth: "15px",
                readOnly: true
            });
        });


        $(".avg_rate").each(function () {
            $(this).rateYo({
                numStars: 5,
                rating: $(this).attr("data-rating"),
                rtl: ($(this).attr("data-rtl")=='true'),
                spacing: "2px",
                starWidth: "15px",
                ratedFill: "#FEBE10",
                normalFill: "#BFBFBF",
                readOnly: true
            });
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





    $(function () {
        $("#doughnutChart").drawDoughnutChart([
            {title: "السكن", value: 25, color: "#98D061"},
            {title: "الاستثمار", value: 25, color: "#FF9900"},
            {title: "العطل", value: 25, color: "#787878"},
            {title: "الجنسية التركية", value: 25, color: "#539CB8"}
        ]);
    });

    $(function () {
        $("#doughnutChart2").drawDoughnutChart([
            {title: "شقق سكنية", value: 30, color: "#98D061"},
            {title: "محلات تجارية", value: 30, color: "#FF9900"},
            {title: "فلل", value: 30, color: "#787878"}
        ]);
    });
    $(function () {
        $("#doughnutChart3").drawDoughnutChart([
            {title: "السكن", value: 25, color: "#98D061"},
            {title: "الاستثمار", value: 25, color: "#FF9900"},
            {title: "العطل", value: 25, color: "#787878"},
            {title: "الجنسية التركية", value: 25, color: "#539CB8"}
        ]);
    });
    /*!
     * jquery.drawDoughnutChart.js
     * Version: 0.4.1(Beta)
     * Inspired by Chart.js(http://www.chartjs.org/)
     *
     * Copyright 2014 hiro
     * https://github.com/githiro/drawDoughnutChart
     * Released under the MIT license.
     * 
     */
    ;
    (function ($, undefined) {
        $.fn.drawDoughnutChart = function (data, options) {
            var $this = this,
                    W = $this.width(),
                    H = $this.height(),
                    centerX = W / 2,
                    centerY = H / 2,
                    cos = Math.cos,
                    sin = Math.sin,
                    PI = Math.PI,
                    settings = $.extend({
                        segmentShowStroke: true,
                        segmentStrokeColor: "rgba(0,0,0,0",
                        segmentStrokeWidth: 1,
                        baseColor: "rgba(0,0,0,0)",
                        baseOffset: 10,
                        edgeOffset: 10, /*offset from edge of $this*/
                        percentageInnerCutout: 75,
                        animation: true,
                        animationSteps: 90,
                        animationEasing: "easeInOutExpo",
                        animateRotate: true,
                        tipOffsetX: -8,
                        tipOffsetY: -45,
                        tipClass: "doughnutTip",
                        summaryClass: "doughnutSummary",
                        summaryTitle: "TOTAL:",
                        summaryTitleClass: "doughnutSummaryTitle",
                        summaryNumberClass: "doughnutSummaryNumber",
                        beforeDraw: function () { },
                        afterDrawed: function () { },
                        onPathEnter: function (e, data) { },
                        onPathLeave: function (e, data) { }
                    }, options),
                    animationOptions = {
                        linear: function (t) {
                            return t;
                        },
                        easeInOutExpo: function (t) {
                            var v = t < .5 ? 8 * t * t * t * t : 1 - 8 * (--t) * t * t * t;
                            return (v > 1) ? 1 : v;
                        }
                    },
                    requestAnimFrame = function () {
                        return window.requestAnimationFrame ||
                                window.webkitRequestAnimationFrame ||
                                window.mozRequestAnimationFrame ||
                                window.oRequestAnimationFrame ||
                                window.msRequestAnimationFrame ||
                                function (callback) {
                                    window.setTimeout(callback, 1000 / 60);
                                };
                    }();

            settings.beforeDraw.call($this);

            var $svg = $('<svg width="' + W + '" height="' + H + '" viewBox="0 0 ' + W + ' ' + H + '" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"></svg>').appendTo($this),
                    $paths = [],
                    easingFunction = animationOptions[settings.animationEasing],
                    doughnutRadius = Min([H / 2, W / 2]) - settings.edgeOffset,
                    cutoutRadius = doughnutRadius * (settings.percentageInnerCutout / 100),
                    segmentTotal = 0;

            /*Draw base doughnut*/
            var baseDoughnutRadius = doughnutRadius + settings.baseOffset,
                    baseCutoutRadius = cutoutRadius - settings.baseOffset;
            $(document.createElementNS('http://www.w3.org/2000/svg', 'path'))
                    .attr({
                        "d": getHollowCirclePath(baseDoughnutRadius, baseCutoutRadius),
                        "fill": settings.baseColor
                    })
                    .appendTo($svg);

            /*Set up pie segments wrapper*/
            var $pathGroup = $(document.createElementNS('http://www.w3.org/2000/svg', 'g'));
            $pathGroup.attr({opacity: 0}).appendTo($svg);

            /*Set up tooltip*/
            var $tip = $('<div class="' + settings.tipClass + '" />').appendTo('body').hide(),
                    tipW = $tip.width(),
                    tipH = $tip.height();

            /*Set up center text area*/
            var summarySize = (cutoutRadius - (doughnutRadius - cutoutRadius)) * 2,
                    $summary = $('<div class="' + settings.summaryClass + '" />')
                    .appendTo($this)
                    .css({
                        width: summarySize + "px",
                        height: summarySize + "px",
                        "margin-left": -(summarySize / 2) + "px",
                        "margin-top": -(summarySize / 2) + "px"
                    });
            var $summaryTitle = $('<p class="' + settings.summaryTitleClass + '">' + settings.summaryTitle + '</p>').appendTo($summary);
            var $summaryNumber = $('<p class="' + settings.summaryNumberClass + '"></p>').appendTo($summary).css({opacity: 0});

            for (var i = 0, len = data.length; i < len; i++) {
                segmentTotal += data[i].value;
                $paths[i] = $(document.createElementNS('http://www.w3.org/2000/svg', 'path'))
                        .attr({
                            "stroke-width": settings.segmentStrokeWidth,
                            "stroke": settings.segmentStrokeColor,
                            "fill": data[i].color,
                            "data-order": i
                        })
                        .appendTo($pathGroup)
                        .on("mouseenter", pathMouseEnter)
                        .on("mouseleave", pathMouseLeave)
                        .on("mousemove", pathMouseMove);
            }

            /*Animation start*/
            animationLoop(drawPieSegments);

            /*Functions*/
            function getHollowCirclePath(doughnutRadius, cutoutRadius) {
                /*Calculate values for the path.*/
                /*We needn't calculate startRadius, segmentAngle and endRadius, because base doughnut doesn't animate.*/
                var startRadius = -1.570, /* -Math.PI/2*/
                        segmentAngle = 6.2831, /* 1 * ((99.9999/100) * (PI*2)),*/
                        endRadius = 4.7131, /* startRadius + segmentAngle*/
                        startX = centerX + cos(startRadius) * doughnutRadius,
                        startY = centerY + sin(startRadius) * doughnutRadius,
                        endX2 = centerX + cos(startRadius) * cutoutRadius,
                        endY2 = centerY + sin(startRadius) * cutoutRadius,
                        endX = centerX + cos(endRadius) * doughnutRadius,
                        endY = centerY + sin(endRadius) * doughnutRadius,
                        startX2 = centerX + cos(endRadius) * cutoutRadius,
                        startY2 = centerY + sin(endRadius) * cutoutRadius;
                var cmd = [
                    'M', startX, startY,
                    'A', doughnutRadius, doughnutRadius, 0, 1, 1, endX, endY, /*Draw outer circle*/
                    'Z', /*Close path*/
                    'M', startX2, startY2, /*Move pointer*/
                    'A', cutoutRadius, cutoutRadius, 0, 1, 0, endX2, endY2, /*Draw inner circle*/
                    'Z'
                ];
                cmd = cmd.join(' ');
                return cmd;
            }
            ;
            function pathMouseEnter(e) {
                var order = $(this).data().order;
                $tip.text(data[order].title + ": " + data[order].value)
                        .fadeIn(200);
                settings.onPathEnter.apply($(this), [e, data]);
            }
            function pathMouseLeave(e) {
                $tip.hide();
                settings.onPathLeave.apply($(this), [e, data]);
            }
            function pathMouseMove(e) {
                $tip.css({
                    top: e.pageY + settings.tipOffsetY,
                    left: e.pageX - $tip.width() / 2 + settings.tipOffsetX
                });
            }
            function drawPieSegments(animationDecimal) {
                var startRadius = -PI / 2, /*-90 degree*/
                        rotateAnimation = 1;
                if (settings.animation && settings.animateRotate)
                    rotateAnimation = animationDecimal;/*count up between0~1*/

                drawDoughnutText(animationDecimal, segmentTotal);

                $pathGroup.attr("opacity", animationDecimal);

                /*If data have only one value, we draw hollow circle(#1).*/
                if (data.length === 1 && (4.7122 < (rotateAnimation * ((data[0].value / segmentTotal) * (PI * 2)) + startRadius))) {
                    $paths[0].attr("d", getHollowCirclePath(doughnutRadius, cutoutRadius));
                    return;
                }
                for (var i = 0, len = data.length; i < len; i++) {
                    var segmentAngle = rotateAnimation * ((data[i].value / segmentTotal) * (PI * 2)),
                            endRadius = startRadius + segmentAngle,
                            largeArc = ((endRadius - startRadius) % (PI * 2)) > PI ? 1 : 0,
                            startX = centerX + cos(startRadius) * doughnutRadius,
                            startY = centerY + sin(startRadius) * doughnutRadius,
                            endX2 = centerX + cos(startRadius) * cutoutRadius,
                            endY2 = centerY + sin(startRadius) * cutoutRadius,
                            endX = centerX + cos(endRadius) * doughnutRadius,
                            endY = centerY + sin(endRadius) * doughnutRadius,
                            startX2 = centerX + cos(endRadius) * cutoutRadius,
                            startY2 = centerY + sin(endRadius) * cutoutRadius;
                    var cmd = [
                        'M', startX, startY, /*Move pointer*/
                        'A', doughnutRadius, doughnutRadius, 0, largeArc, 1, endX, endY, /*Draw outer arc path*/
                        'L', startX2, startY2, /*Draw line path(this line connects outer and innner arc paths)*/
                        'A', cutoutRadius, cutoutRadius, 0, largeArc, 0, endX2, endY2, /*Draw inner arc path*/
                        'Z'/*Cloth path*/
                    ];
                    $paths[i].attr("d", cmd.join(' '));
                    startRadius += segmentAngle;
                }
            }
            function drawDoughnutText(animationDecimal, segmentTotal) {
                $summaryNumber
                        .css({opacity: animationDecimal})
                        .text((segmentTotal * animationDecimal).toFixed(1));
            }
            function animateFrame(cnt, drawData) {
                var easeAdjustedAnimationPercent = (settings.animation) ? CapValue(easingFunction(cnt), null, 0) : 1;
                drawData(easeAdjustedAnimationPercent);
            }
            function animationLoop(drawData) {
                var animFrameAmount = (settings.animation) ? 1 / CapValue(settings.animationSteps, Number.MAX_VALUE, 1) : 1,
                        cnt = (settings.animation) ? 0 : 1;
                requestAnimFrame(function () {
                    cnt += animFrameAmount;
                    animateFrame(cnt, drawData);
                    if (cnt <= 1) {
                        requestAnimFrame(arguments.callee);
                    } else {
                        settings.afterDrawed.call($this);
                    }
                });
            }
            function Max(arr) {
                return Math.max.apply(null, arr);
            }
            function Min(arr) {
                return Math.min.apply(null, arr);
            }
            function isNumber(n) {
                return !isNaN(parseFloat(n)) && isFinite(n);
            }
            function CapValue(valueToCap, maxValue, minValue) {
                if (isNumber(maxValue) && valueToCap > maxValue)
                    return maxValue;
                if (isNumber(minValue) && valueToCap < minValue)
                    return minValue;
                return valueToCap;
            }
            return $this;
        };





        $(".clientRating").on("rateyo.change", function (e, data) {
            var rating = data.rating;
            $(this).parent().find('input[type=hidden]').val(rating);
        });
		
		$(".globrate").rateYo({
            numStars: 5,
			fullStar: true,
			rtl: ($(this).attr("data-rtl")=='true'),
            spacing: "2px",
            starWidth: "18px",
            ratedFill: "#FEBE10",
            normalFill: "#BFBFBF"
        });

        $("#form-agent-reviews").on("submit", function (e) {
            e.preventDefault();
            var form = $(this);
            var btn = form.find("button[type=submit]");
            var act = form.attr("action");
            var infos = form.serialize();
            /*btn.find(".fa").removeClass("fa-send").addClass("fa-spinner fa-spin");*/
            btn.html("<i class='fa fa-spinner fa-spin' style='color: #0d8dd3;'></i>");
            btn.attr("disabled", true);
            $.post(act, infos, function (resp) {
                form.find(".has-form-error").remove();
                if (resp.input) {
                    form.find('*[name=' + resp.input + ']').removeClass("animated flash").addClass("animated flash").focus();
                    form.find('*[name=' + resp.input + ']').after("<small  class='has-form-error error-" + resp.input + " text-danger' style='text-align:left;'>" + resp.message + "</small>");
                } else {

                    alert(resp.message);

                    form.parent(".blk_model").remove();
                }

                btn.html('أضف تقييمك');
                btn.removeAttr("disabled");
            });
            return false;
        });
    })(jQuery);



<?php
$json3 = Helper::ajax_statics('', 'top_country', 0, 0);
$json4 = Helper::ajax_statics('', 'top_city', 0, 0);
?>
    display_most_nat_data(<?= json_encode($json3) ?>);
    display_most_city_data(<?= json_encode($json4) ?>);



</script>
@endsection