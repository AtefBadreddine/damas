@section('styles')
.btn,.btn:hover{color:#fff}input,select{height:40px;line-height:40px;padding:0 20px}input:focus,select:focus{box-shadow:none;outline:0}textarea{line-height:normal;padding:10px 20px}.section-heading{text-align-last:center;margin-bottom:15px}.btn{cursor:pointer;background-color:#0F6868;outline:0;border-color:#0F6868}.btn-primary,.btn:hover{background-color:#2765b4;border-color:#2765b4}.btn-primary:hover{background-color:#0F6868;border-color:#0F6868}.news-construct{position:relative;padding-bottom:30px}.news-construct .banner{background-color:transparent}.news-construct .item{margin:0}.news-construct .item a{display:block;width:100%;height:100%;padding:3px;position:relative;overflow:hidden}.news-construct .item a .layer{position:absolute;top:3px;left:3px;width:calc(100% - 6px);height:calc(100% - 6px);background:rgba(0,0,0,.4);color:#fff;font-weight:700;padding:50% 15px 10px 10px;transition:all .3s ease-out}.news-construct .item a .layer:hover{background:rgba(0,0,0,.6)}.news-construct .item a .layer h3{font-size:20px;position: absolute;
bottom: 16px;}.news-construct .item a .layer h3:hover{color:#a8c7ff}.news-construct .item a .layer ul{list-style:none;display:flex;justify-content:flex-start;padding:0}.news-construct .item a .layer ul li{margin-left:20px;line-height:40px}.news-construct .item a .layer ul li i:before{margin-left:5px}.news-construct .item img{height:100%;width:100%}.news-construct .item a .layer{padding-bottom:20%}.news-construct .layer h3{font-size:20px}
.filter{margin:20px 0}.filter .container h2{color:#fff;background-color:#0F6868;font-size:18px;text-align:center;padding:12px;margin:0;border-radius:5px 5px 0 0}.filter .container>div{background-color:#cbdfe6;display:flex;justify-content:space-between;padding:10px 5px;border-radius:0 0 5px 5px}.filter .container>div select{padding:0;width:28.5714285714%;background-color:#0F6868;color:#cbdfe6;font-size:12px;border:0;height:auto;border-right:5px solid #17A8A9;border-radius:5px 0 0 5px}.filter .container>div div{text-align:center}.filter .container>div div span{width:35px;height:35px;cursor:pointer;background-color:#0F6868;color:#fff;line-height:35px;display:inline-block;border-radius:5px}.filter .container>div div span:before{margin-left:0}
.alikes .btn {background-color: #0F6868;border-radius: 5px;outline: none;border: 0;transition: all .3s ease-out;margin-top: 20px;}
.hauto{height: auto}
@endsection

<?php
    $infos = Helper::get_params();
    $current_lang = LaravelLocalization::getCurrentLocale();
?>
@extends('amp.layout', [
    "page_description" => $infos->seo_description,
    "page_keywords" => $infos->seo_keywords,
])
@section('main_content')
    
<header>
    
    <amp-carousel width="300" height="400" layout="responsive" type="slides">
        @foreach(Helper::query("Slider", "whereIn", ["field" => "lang", "value" => [$current_lang, "all"]])->get() as $kslider => $slider)
            <?php $slider_img = ($slider->media_mobile_id) ? $slider->mediaMobile : $slider->media; ?>
            <a href="<?= $slider->slider_link; ?>">
                <amp-img src="<?= Helper::media_url($slider_img); ?>" width="300" height="400" layout="responsive" alt="<?= $slider->name; ?>"></amp-img>
            </a>
        @endforeach
    </amp-carousel>

    <section class="filter">
        <form target="_top" method="get" id="form-search" action="{{ route('front.search') . '/property-for-sale/turkey' }}">
        <section class="container">
            <h2><?= $infos->form_title; ?></h2>
            <div>
                <select name="city">
                    @foreach(Helper::query('City', 'orderByPlacement') as $city)
                        <option value="<?= $city->slug; ?>"><?= $city->getName(); ?></option>
                    @endforeach
                </select>
                <select name="project_type">
                    <option value=""><?= trans("front.all real estate"); ?></option>
                    @foreach(Helper::query('ProjectType', 'all') as $typ)
                        <option value="<?= $typ->slug; ?>"><?= $typ->getName(); ?></option>
                    @endforeach
                </select>
                <select name="project_category">
                    <option value=""><?= trans("front.special advantages"); ?></option>
                    @foreach(Helper::query('ProjectCategory', 'all') as $cat)
                        <option value="<?= $cat->slug; ?>"><?= $cat->getName(); ?></option>
                    @endforeach
                </select>
                <div>
				<input type="hidden" value="1" name="amp" />
                    <button type="submit">
                        <span class="flaticon-magnifying-glass" id="btnFilter"></span>
                    </button>
                </div>
            </div>
        </section>
        </form>
    </section>
    
    <section class="container">
        @include("amp.partials.call_us_small", ["form_type" => "Home - Up"])
    </section>
    
</header>

<br>

	

	
	
	

	

	
	
<?php
$ProjectCategorys=array();
	$j=0;
    $sections = Helper::query("Section", "orderByPlacement", [
        /*"lang" => [$current_lang],*/
        "device" => ["all", "mobile"],
    ]);
?>
@foreach($sections as $section)
    <?php $section_position = @$section->position->slug; ?>
    <?php $section_type = @$section->type->slug;$i  =0;
	if($section_type!='projects')
	continue;
	?>
    <section>
        <div class="container">
            <div class="section-heading">
                <h3 class="section-title main-head">
                    <span class="colored flaticon-<?= $section->icon; ?>"></span> <?= ($current_lang=='en')?$section->title_en:$section->title; ?>
                </h3>
            </div>
			
            @if($section_type == "projects")

                <?php
	$cat_slug='';
		if ( $section_position == "featured_projects"  ) {
			if ( $section->project_category  ) {
				$category_row = Helper::query("ProjectCategory", "find", ["id" => (isset($_COOKIE['cat'.$j])?$_COOKIE['cat'.$j]:$section->project_category) ]);
				$cat_slug = $category_row->slug;
				$projects = $category_row->projects()->where("published", 1)->limit($section->number_items )->orderBy("id", "DESC")->get();
			} elseif($section->latestproject==true) {
				$projects = Helper::query("Project", "latest", ["limit" => $section->number_items]);
			} else {
				$projects = $section->projects()->where("published", 1)->limit($section->number_items)->get();
			}
		} else {
			$projects = Helper::query("Project", "latest", ["limit" => $section->number_items]);
		}
	?>

                <div class="row alikes" dir="ltr">
<amp-carousel width="345"
  height="400"
  layout="responsive"
  type="slides"
  controls
  autoplay delay="3000"
  >
					@foreach($projects as $project)


                        <aside class="col-md-4 col-sm-6 col-xs-12">
                            @include("amp.partials.project_item")
                        </aside>
						
                    @endforeach
</amp-carousel>

                    @if(count($projects))
                        <aside class="col-md-12 col-sm-1 col-xs-12">
                            <a href="{{route('front.search', ['property-for-sale', 'turkey',$cat_slug])}}" class="btn btn-primary btn-lg"><i class="fa fa-list"></i> <?= trans("front.view more"); ?></a>
                        </aside>
                    @endif
                </div>

				
				
				
            @endif
                
            
</div>
</section>
@endforeach
















<section>
        <div class="container">
            <div class="section-heading">
                <h3 class="section-title main-head">
                    <span class="colored flaticon-"></span> {{ trans('front.latest posts')}}
                </h3>
            </div>
<?php
//$posts = Helper::query("Post", "latest", ["limit" => $section->number_items]); 
$posts = Helper::query("Post", "orderBy", ["field" => "created_at", "value" => "DESC"])->where("published", 1)->whereIn('lang',array($current_lang,'all'))->limit(6)->get();

?>

<div class="row news-construct">
<amp-carousel width="400"  dir="ltr"
height="400"
layout="responsive"
type="slides"
controls

>
@foreach($posts as $post)
<aside class="col-md-3 col-sm-6 col-xs-12">
<div class="item">
<a href="<?= route("front.blog.post", $post->slug); ?>" class="first">
<amp-img src="<?= Helper::get_thumbnail($post->photoCard, 400, 400); ?>" width="400" height="400" layout="responsive"></amp-img>
<div class="layer">
<h3><?= $post->getTitle(); ?></h3>
</div>
</a>
</div>
</aside>
@endforeach
</amp-carousel>
</div>




</div>
</section>



<?php  ?>
    @include('amp.partials.call_us', ["form_type" => "Home - Down"])    
    
@endsection

@section('schemaorg')
<script type="application/ld+json">
{
	"@context":"http://schema.org",
	"@type":"RealEstateAgent",
	"name":"<?= $infos->name; ?>",
	"address":{
		"@type":"PostalAddress",
		"streetAddress":"<?= $infos->address; ?>"
	},
	"image":"<?= asset('img/logo.png'); ?>",
	"email":"<?= $infos->email; ?>",
	"telePhone":"<?= $infos->tel_1; ?>",
	"url":"<?= url("/"); ?>",
	"geo":{
		"@type":"GeoCoordinates",
		"latitude":"<?= $infos->latitude; ?>",
		"longitude":"<?= $infos->longitude; ?>"
	},
	"priceRange":"$$$"
}
</script>
@endsection