<?php

$testimonials = Helper::query("Testimonial", "all");
$cnt_testimonials = 0;
foreach($testimonials as $tes){
	if(trim($tes->getContent())!='')
		$cnt_testimonials++;
}

if($cnt_testimonials>0){
?>
<!-- Start Certificate Client -->
                <div class="certificate <?= ($full==true)?'certificate-desktop desktop-screen':'certificate-mobile mobile-screen'?>">
                    <div class="title">
                        <i class="flaticon-like3"></i>
                        <h2>{{trans('front.testimonial')}}</h2>
                    </div>
                    <!--<div class="nav">
                        <button class="up arrow"><i class="fa fa-chevron-up"></i></button>
                        <button class="down arrow"><i class="fa fa-chevron-down"></i></button>
                    </div>-->
                    <div class="clearfix"></div>
                    <div class="post">
                        <div class="slider owl-carousel">
						<?php
						$ci =-1;
						?>
							@foreach($testimonials as $tes)
							@if(trim($tes->getContent())!='')
                            <?php
							$ci++;
							if($ci==0|| $ci==2)
							echo '<div class="item">';	?>
							<div class="items">
                                <img class="photo <?= isset($ajax)?'':'lazyimg' ?>" <?= isset($ajax)?'':'data-' ?>src="<?=Helper::get_thumbnail($tes->photo,80,80)?>">
                                <div class="info">
                                    <span class="name">{{$tes->getName()}}</span>
                                    <span class="op">{{$tes->getContent()}}</span>
                                </div>
                            </div>
							<?php
							if($ci==1|| $ci==3)
							echo '</div>';	?>
						@endif
						@endforeach
							
                        </div>  
                    </div>
                </div>
                <!-- End Certificate Client -->
<?php } ?>