<?php
$full = false;
if(Helper::get_device()=='full')
	$full = true;
?>
<!-- Start Most Watched -->
                <div class="most-watched <?= ($full==true)?'most-watched-desktop most-watched-screen':'most-watched-mobile mobile-screen'?>">
                    <div class="title">
                        <i class="flaticon-eye"></i>
                        <h3><?=trans("front.Most watched")?></h3>
                    </div>

                    <div class="post">
                        <div class="slider <?= ($full==true)?'owl-carousel':'' ?>">
						<?php
						$projects = Helper::query("Project", "orderBy", ["field" => "views", "value" => "DESC"])->where("published", 1)->limit(9)->get();
						$ci = -1;
						?>
							@foreach($projects as $p)
							<?php
							$ci++;
							if($ci==0|| $ci==3 || $ci==6)
							echo '<div class="item">';	?>
							<div class="items" onclick="location.href='<?= route('front.project', $p->slug); ?>'">
                                
								{!! Helper::get_pic(Helper::get_thumbnail($p->cardphoto, 180, 140),'photo '.(!isset($ajax)?'lazyimg':''),'','',$p->cardphoto->getTitle()) !!}
                                <div class="info">
                                    <div class="name"><span>{{$p->name_en}}</span></div>
                                    <div class="about">
                                        {{ Helper::extract_intro_proj($p->getIntroCard(),100) }}
                                    </div>
                                    <div class="views">({{$p->views}} {{trans('front.view')}})</div>
                                </div>
                            </div>
							<?php
							if($ci==2|| $ci==5 || $ci==8)
							echo '</div>';	?>
							@endforeach
                        </div>
                        
                    </div>
                </div>
                 <!-- End Most Watched -->