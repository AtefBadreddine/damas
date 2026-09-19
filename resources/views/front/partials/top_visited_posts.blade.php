<?php
			
			$category = Helper::query("PostCategory", "where", ["field" => "id", "value" => $cat_id])->first();
        
		$Lposts = DB::select("select distinct post_id from dms_googlevisits
			where `cat_ids` like '%,".$cat_id.",%' and visit_date > NOW() - INTERVAL 60 DAY
			group by `visit_date`
			order by sum(visit_count) DESC
			");
		
		$post_ids = [];
		foreach($Lposts as $pid){
			$post_ids[] = $pid->post_id;
		}
		
		if(count($post_ids)>0){
		$current_lang = LaravelLocalization::getCurrentLocale();
		$top_posts = \App\Models\Post::whereIn('id',$post_ids)->where('title_'.($current_lang == 'pe' ? 'fa' : $current_lang),'!=','')->where('published',true)->orderBy(DB::raw("FIND_IN_SET(id, '". implode(',',$post_ids) ."')"))->limit(4)->get();
            if (count($top_posts) > 0) { ?>
                <div class="int_content  not_bg">
                    <div class="similar_articles sec">
                        <h2 class="sub_title jazzira_font_bold"><?= trans("front.related posts"); ?></h2>

                        <div class="wrapper sec">

                            <div class="slider video_slider" dir="rtl">

                                <div class="slider__wrap swiper-wrapper">

                                    @foreach($top_posts as $post)
                                    @include("front.partials.post_item", ["post" => $post, "open_blank" => false, "class" => "card-small","page"=>"index"])
                                    @endforeach

                                </div>

                                <div class="slider__controls">
                                    <div class="slider__pagination"></div>
                                    <div class="slider__button-next"></div>
                                    <div class="slider__button-prev"></div>
                                </div>
                                <a href="{{ route('front.blog') }}" class="more shadow_type"><?= trans("front.show more"); ?></a>
                            </div>

                        </div>

                    </div>
                </div>
            <?php }} ?>