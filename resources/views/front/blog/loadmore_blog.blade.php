<?php
$current_lang = LaravelLocalization::getCurrentLocale();


$sections = \App\Models\BlogSection::whereIn("lang", ["all", $current_lang])
		->orderBy("section_position", "ASC")
		->orderBy("placement", "ASC")->get();

$core_content = '';
?>


@if(isset($sections[$cat]) and $sections[$cat]->content_type!='posts')
<?php $section = $sections[$cat]; ?>

   @if($section->content_type == "projects")
            <?php ob_start(); ?>
            <h3 class="colored blog-heading"> <?= $section->getTitle(); ?> </h3>
            <div class="alikes">
                @foreach($section->projects()->limit($section->number_items)->get() as $project)
                    <aside class="col-12 wow fadeInUp" data-wow-duration="2s" data-wow-offset="200">
                        @include("front.partials.project_item")
                    </aside>
                @endforeach
            </div>
            <div class="clearfix"></div>
            <?php $projects_content = ob_get_clean(); ?>
            <?php
                if($section->section_position == "sidebar") $sidebar_content .= $projects_content;
            ?>
   @else
        <?php
            // select published posts by lang and type
            if ( $section->content_type == "category" ) {
                $post_category = Helper::query("PostCategory", "find", ["id" => $section->category_id]);
                $posts = $post_category->posts()
                    ->limit($section->number_items)
                    ->where("published", 1)
                    ->whereIn("lang", ["all", $current_lang]);
                
                $section->link_click = route("front.blog.category", $post_category->slug);
                if ( !$section->show_title ) {
                    $section->show_title = 1;
                    $section->title_ar = $post_category->name_ar;
                }
            } else {
                $posts = Helper::query("Post", "where", ["field" => "post_type", "value" => $section->content_type])
                    ->limit($section->number_items)
                    ->where("published", 1)
                    ->whereIn("lang", ["all", $current_lang]);
            }

            if ( $section->content_display == "selected" ) {
                // selected posts from section
                $posts = $section->posts;
            } elseif ( $section->content_display == "most_visited" ) {
                // order by visites
                $posts = $posts->orderBy("visites", "DESC")->get();
            } else {
                // order by created date
                $posts = $posts->orderBy("placement", "ASC")->get();
            }
        ?>
            <?php $core_content = View::make("front.blog.partials.".$section->model, ["section" => $section, "posts" => $posts,'current_lang'=>$current_lang])->render(); ?>
    @endif

@elseif($cat - count($sections)==-1)

<!--<?= Html::style("css/intlTelInput.css"); ?>-->
<?php $core_content = View::make("front.partials.call_us", ["form_type" => "Blog - Down","ajax"=>true])->render(); ?>
<script>
/* input tel flag */
$("#mobile-sm, #mobile-lg, #InputMobile, #inputMobileChat").intlTelInput({
preferredCountries: ["undif","sa","tr","qa","sy","iq","kw","bh","ae","ye","jo","dz","ly","eg","sd","om"]
});
$("#mobile-sm, #mobile-lg, #InputMobile, #inputMobileChat").on("change", function(){
var $this = $(this);
var frm = $this.closest("form");
var country = frm.find(".country-list .country.active .country-name").text();
var input_country = frm.find("input[name=country]");
if ( input_country.length > 0 ) {
	input_country.val(country);
} else {
	frm.append("<input name='country' type='hidden' value='"+country+"' />");
}
});
$(".intl-tel-input").addClass("bluring");
</script>
@elseif($cat - count($sections)==0)
<?php $core_content = View::make("front.partials.about_damass_mob", [])->render(); ?>
@endif




@if($core_content!='')
<div class="most-popular">
	<div class="container" style="direction:<?=$current_lang=='en'?'ltr':'rtl' ?>">
		<div class="row sectionblank">
			<aside class="col-md-8 col-sm-8 col-12 p<?=$current_lang!='en'?'l':'r' ?>5">
                <?= $core_content; ?>
			</aside>
		</div>
	</div>
</div>
@endif
