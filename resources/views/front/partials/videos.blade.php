@foreach ($videos as $v)
<div class="item swiper-slide">
	<div class="content sec shadow_type">
		<div class="view_cont">
			<div class="int_cont image">
				<a href="<?= @session()->get("iso_country")=='TR'?$v->link:route('front.video',$v->slug) ?>" 
				<?php if(@session()->get("iso_country")=='TR'){ ?>data-fancybox="videos"<?php } ?>>
					<img class="lazy" loading="lazy" src="<?= ($v->pic); ?>" alt="damasturk" />
				</a>
			</div>
		</div>
		<div class="features_sec text_font">
			<p>
				<?= $v->title ?>
			</p>
			<ul>
				<li>
					<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 15.92 7.96" xml:space="preserve"><g> <g> <path class="st0" d="M0,4.03C2.09,1.58,4.61,0,7.92,0c1.16,0,2.26,0.27,3.33,0.72c1.79,0.75,3.28,1.91,4.67,3.28 c-0.1,0.11-0.18,0.22-0.28,0.32c-1.77,1.81-3.85,3.07-6.37,3.52c-2.12,0.37-4.1-0.05-5.96-1.1C2.07,6.03,1,5.11,0,4.03z M10.76,3.8c-0.02-1.59-1.3-2.83-2.91-2.81C6.32,1.01,5.07,2.3,5.08,3.85c0.01,1.58,1.29,2.83,2.86,2.82 C9.5,6.67,10.78,5.36,10.76,3.8z M1.35,4c1.1,1.07,2.32,1.94,3.78,2.49C3.86,4.93,3.77,3.32,4.78,1.6C3.46,2.16,2.34,2.97,1.35,4z M10.79,6.39c1.42-0.56,2.63-1.35,3.73-2.36c-1.02-0.92-2.1-1.7-3.36-2.28C12.04,3.39,11.92,4.91,10.79,6.39z"/> <path class="st0" d="M8.44,2.43c-0.6,0.25-0.8,0.53-0.67,0.94c0.11,0.36,0.46,0.57,0.84,0.5C9.03,3.81,9.23,3.5,9.2,2.95 c0.47,0.39,0.53,1.34,0.12,1.93c-0.5,0.72-1.48,0.94-2.25,0.51C6.33,4.97,6.03,4.07,6.38,3.31C6.73,2.54,7.65,2.15,8.44,2.43z"/> </g> </g> </svg>
					<span class="num"><?= $v->views ?></span>
				</li>
				<li><?= date("Y/m", strtotime($v->date_published)); ?></li>
			</ul>
		</div>
	</div>
</div>
@endforeach