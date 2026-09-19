@if($section->show_title)
    <h1 class="colored text-center h1blog"><?= $section->getTitle(); ?></h1>
@endif
<?php $arr_posts = [];

$style_lang = in_array($current_lang,['en','fr'])?'en':'ar';
?>
<!-- start slider -->
<div class="row mod1">
    <div class="container">
        <div class="col-md-8 pl5 pr5" style="float:<?=$style_lang=='en'?'left':'right' ?>">
		<style>
		.carousel{position:relative}.carousel-inner{position:relative;width:100%;overflow:hidden}.carousel-inner>.item{position:relative;display:none;-webkit-transition:.6s ease-in-out left;-o-transition:.6s ease-in-out left;transition:.6s ease-in-out left}.carousel-inner>.item>a>img,.carousel-inner>.item>img{line-height:1}@media all and (transform-3d),(-webkit-transform-3d){.carousel-inner>.item{-webkit-transition:-webkit-transform .6s ease-in-out;-o-transition:-o-transform .6s ease-in-out;transition:transform .6s ease-in-out;-webkit-backface-visibility:hidden;backface-visibility:hidden;-webkit-perspective:1000px;perspective:1000px}.carousel-inner>.item.active.right,.carousel-inner>.item.next{left:0;-webkit-transform:translate3d(100%,0,0);transform:translate3d(100%,0,0)}.carousel-inner>.item.active.left,.carousel-inner>.item.prev{left:0;-webkit-transform:translate3d(-100%,0,0);transform:translate3d(-100%,0,0)}.carousel-inner>.item.active,.carousel-inner>.item.next.left,.carousel-inner>.item.prev.right{left:0;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}}.carousel-inner>.active,.carousel-inner>.next,.carousel-inner>.prev{display:block}.carousel-inner>.active{left:0}.carousel-inner>.next,.carousel-inner>.prev{position:absolute;top:0;width:100%}.carousel-inner>.next{left:100%}.carousel-inner>.prev{left:-100%}.carousel-inner>.next.left,.carousel-inner>.prev.right{left:0}.carousel-inner>.active.left{left:-100%}.carousel-inner>.active.right{left:100%}.carousel-control{position:absolute;top:0;bottom:0;left:0;width:15%;font-size:20px;color:#fff;text-align:center;text-shadow:0 1px 2px rgba(0,0,0,.6);background-color:rgba(0,0,0,0);filter:alpha(opacity=50);opacity:.5}.carousel-control.left{background-image:-webkit-linear-gradient(left,rgba(0,0,0,.5) 0,rgba(0,0,0,.0001) 100%);background-image:-o-linear-gradient(left,rgba(0,0,0,.5) 0,rgba(0,0,0,.0001) 100%);background-image:-webkit-gradient(linear,left top,right top,from(rgba(0,0,0,.5)),to(rgba(0,0,0,.0001)));background-image:linear-gradient(to right,rgba(0,0,0,.5) 0,rgba(0,0,0,.0001) 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#80000000', endColorstr='#00000000', GradientType=1);background-repeat:repeat-x}.carousel-control.right{right:0;left:auto;background-image:-webkit-linear-gradient(left,rgba(0,0,0,.0001) 0,rgba(0,0,0,.5) 100%);background-image:-o-linear-gradient(left,rgba(0,0,0,.0001) 0,rgba(0,0,0,.5) 100%);background-image:-webkit-gradient(linear,left top,right top,from(rgba(0,0,0,.0001)),to(rgba(0,0,0,.5)));background-image:linear-gradient(to right,rgba(0,0,0,.0001) 0,rgba(0,0,0,.5) 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#80000000', GradientType=1);background-repeat:repeat-x}.carousel-control:focus,.carousel-control:hover{color:#fff;text-decoration:none;filter:alpha(opacity=90);outline:0;opacity:.9}.carousel-control .glyphicon-chevron-left,.carousel-control .glyphicon-chevron-right,.carousel-control .icon-next,.carousel-control .icon-prev{position:absolute;top:50%;z-index:5;display:inline-block;margin-top:-10px}.carousel-control .glyphicon-chevron-left,.carousel-control .icon-prev{left:50%;margin-left:-10px}.carousel-control .glyphicon-chevron-right,.carousel-control .icon-next{right:50%;margin-right:-10px}.carousel-control .icon-next,.carousel-control .icon-prev{width:20px;height:20px;font-family:serif;line-height:1}.carousel-control .icon-prev:before{content:'\2039'}.carousel-control .icon-next:before{content:'\203a'}.carousel-indicators{position:absolute;bottom:10px;left:50%;z-index:15;width:60%;padding-left:0;margin-left:-30%;text-align:center;list-style:none}.carousel-indicators li{display:inline-block;width:10px;height:10px;margin:1px;text-indent:-999px;cursor:pointer;background-color:#000\9;background-color:rgba(0,0,0,0);border:1px solid #fff;border-radius:10px}.carousel-indicators .active{width:12px;height:12px;margin:0;background-color:#fff}.carousel-caption{position:absolute;right:15%;bottom:20px;left:15%;z-index:10;padding-top:20px;padding-bottom:20px;color:#fff;text-align:center;text-shadow:0 1px 2px rgba(0,0,0,.6)}.carousel-caption .btn{text-shadow:none}@media screen and (min-width:768px){.carousel-control .glyphicon-chevron-left,.carousel-control .glyphicon-chevron-right,.carousel-control .icon-next,.carousel-control .icon-prev{width:30px;height:30px;margin-top:-10px;font-size:30px}.carousel-control .glyphicon-chevron-left,.carousel-control .icon-prev{margin-left:-10px}.carousel-control .glyphicon-chevron-right,.carousel-control .icon-next{margin-right:-10px}.carousel-caption{right:20%;left:20%;padding-bottom:30px}.carousel-indicators{bottom:20px}}
		</style>
		<?php
		$w=750;
		$h=400;
		if(Helper::get_device()=='mob'){
			$w=400;
			$h=400;
		}
		?>
            <article class="sliding3">
                <div id="carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($posts->take(4) as $k => $post)
                            <?php
							$cardphoto = $post->photoCard;
							if(Helper::get_device()=='mob')
								$img = Helper::get_thumbnail($cardphoto, $w, $h);
							else
								$img = Helper::get_thumbnail_full($cardphoto, $w, $h);
						?>
                            <div class="carousel-item item<?= $k==0 ? " active" : ""; ?>">
                                <a href="<?= route("front.blog.post", $post->slug); ?>">
								@if($cardphoto)
                                    <img src="<?= $img; ?>" class="img-responsive" alt="<?= $cardphoto->getDescription(); ?>">
                                    @endif
									<div class="layer layer-slider">
                                        <div class="col-xs-12">
                                            <h2><?= $post->getTitle(); ?></h2>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php
                                $arr_posts[] = [
                                    "key"   =>  $k,
                                    "img"   =>  $img,
                                    "alt"   =>  ($cardphoto ? $cardphoto->getDescription():''),
                                    "title" =>  $post->getTitle(),
                                ];
                            ?>
                        @endforeach
                    </div>
                </div>
                <div class="clearfix">
                    <div id="thumbcarousel" class="carousel slide" data-interval="false">
                        <div class="carousel-inner">
                            <div class="item active">
                                @foreach($arr_posts as $k => $post)
                                <div data-target="#carousel" data-slide-to="<?= $post["key"]; ?>" class="thumb<?= $post['key'] == 4 ? " hidden-xs" : ""; ?>" title="<?= $post["title"]; ?>">
                                    <img src="<?= $post["img"]; ?>" alt="<?= $post["alt"]; ?>" class="img-responsive">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

<script type="application/ld+json">
{
  "@context":"http://schema.org",
  "@type":"ItemList",
  "itemListElement":[
   @foreach($posts->take(5) as $k => $post)
    {
      "@type":"ListItem",
      "position":{{$k+1}},
      "url":"<?= route("front.blog.post", $post->slug); ?>"
    }
	@if($k+1!=5)
	{{ ',' }}
	@endif
	@endforeach
  ]
}
</script>
            </article>
        </div>
        <div class="col-md-4 col-sm-12 col-12 pl5 pr5"  style="float:<?=$style_lang=='en'?'left':'right' ?>">
                @include("front.partials.call_us_social", ["form_type" => "Blog - Up"])
            <?php /* ?>@if(@$show_social == true)
            @else
                <?php $is_mobile = Helper::is_mobile(); ?>
                @if($is_mobile)
                    @include("front.partials.call_us_mobile", ["form_type" => "Blog - Up"])
                @else
                    @include("front.partials.call_us_social", ["form_type" => "Blog - Up"])
                @endif
            @endif
			<?php */ ?>
			
        </div>
    </div>
    
</div>
<!-- end slider -->