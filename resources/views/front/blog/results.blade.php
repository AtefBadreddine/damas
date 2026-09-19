
<div class="col-md-10 offset-md-1">
    <div class="full_sections int_page">


        <!-- Start Left Section -->
        <div class="left_sec">

            <div class="top_control_sec">
                 <h1>مخزن المعلومات</h1>
                <p><span>نتائج البحث</span> <strong>{{ $posts->total() }}</strong></p>

                <section class="form fast_search sort_filter">
                    <div class="form-group">
                        <select class="selectpicker form-control" name="sort" title="الترتيب حسب"  onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                            <option value="?sort=recent" <?=  (isset($_GET['sort']) && $_GET['sort']=='recent')?'selected':'' ?>>الترتيب حسب</option>
                            <option value="?sort=recent" <?=  (isset($_GET['sort']) && $_GET['sort']=='recent')?'selected':'' ?>>الأحدث</option>
                            <option value="?sort=oldest" <?=  (isset($_GET['sort']) && $_GET['sort']=='oldest')?'selected':'' ?>>الأقدم</option>
                            <option value="?sort=az" <?=  (isset($_GET['sort']) && $_GET['sort']=='az')?'selected="selected"':'' ?>>من الألف إلى الياء</option>
                            <option value="?sort=za" <?=  (isset($_GET['sort']) && $_GET['sort']=='za')?'selected':'' ?>>من الياء إلى الألف</option>
                        </select>
                    </div>
                </section>

                <a class="filter_btn">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 220.6 239.5" xml:space="preserve"><g> <path class="st0" d="M110.2,0.5c31.7,0,63.3,0,95,0c6.1,0,10.8,2.3,13.6,7.6c2.6,4.9,2.5,10.2-1,14.6c-1.9,2.3-4.9,3.8-7.4,5.6 c-2.5,1.7-5.6,2.8-7.5,5c-22,26.7-43.9,53.6-65.7,80.6c-1.7,2.1-2.8,5.3-2.8,8c-0.2,28.3-0.2,56.5,0,84.8c0,4.6-1.6,7.4-5.4,9.7 c-11.5,7.1-22.7,14.6-34.2,21.6c-2.2,1.4-6.1,2.2-8.1,1.1c-1.9-1-3.4-4.8-3.4-7.4c-0.2-19.7,0-39.3,0-59c0-17.6,0-35.3-0.3-52.9 c0-2-0.9-4.3-2.1-5.8C58.5,86.3,36,58.7,13.4,31.1c-1.1-1.3-2.7-2.4-4.3-3.2c-7-3.3-10.3-9.5-8.7-16.7C1.8,5,7.5,0.5,14.8,0.5 C46.6,0.4,78.4,0.5,110.2,0.5z M195.9,29.4c-58.3,0-115.7,0-173.4,0c0.3,0.8,0.4,1.1,0.6,1.3C44.4,56.8,65.6,82.9,87,108.9 c1.1,1.4,3.6,2.3,5.5,2.3c8.5,0.2,17.1-0.5,25.5,0.3c8.2,0.8,13.3-2.2,18.3-8.6C155.6,78.3,175.6,54.3,195.9,29.4z M91.1,119.2 c0,37.5,0,74.3,0,112c11.8-7.5,22.8-14.4,33.6-21.5c1.2-0.8,1.9-3,1.9-4.6c0.2-8.3,0.1-16.7,0.1-25c0.1-14.1,0.2-28.2,0.3-42.3 c0-6.1,0-12.2,0-18.6C114.6,119.2,103,119.2,91.1,119.2z M110.2,8.2c-30.7,0-61.3,0-92,0c-7.5,0-10.8,2.1-10.6,6.7 c0.1,4.4,3.4,6.4,10.6,6.4c61.3,0,122.6,0,183.9,0c2,0,4.5,0.4,5.8-0.6c2-1.5,4.6-4.3,4.4-6.2c-0.3-2.3-3.1-4.4-5.3-6.1 c-0.9-0.7-2.9-0.2-4.4-0.2C171.9,8.2,141.1,8.2,110.2,8.2z"/> </g> </svg>
                </a>

            </div>


            <div class="int_content">
                <ul class="blog_catd_sec">
				<?php $pos = -1; ?>
				@foreach($posts as $p)
				<?php $pos++ ?>
                    <li <?= ($pos%3==0?'style="clear:both"':'') ?>>
                        <div class="sec shadow_type">
                            <!-- image -->
                            <div class="image_cont">
                                <a href="<?= route("front.".$type.".post", $p->slug) ?>"><img class="lazy" loading="lazy"
                                src="<?= Helper::get_thumbnail($p->photoCard, 288, 177, true); ?>" alt="damasturk"/><span class="date num"><?= date_format($p->created_at, "d/m/Y"); ?></span></a>
                            </div>
                            <div class="text">
                                <span>
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 328.4 254.4" xml:space="preserve"><g> <path class="st0" d="M164.7,69.8c50.2,0,100.3,0,150.5,0c10.5,0,13.8,3.6,13,14c-4,52.8-8.1,105.7-12.2,158.5 c-0.6,7.8-5.4,12.1-13.6,12.1c-22.7,0-45.3,0-68,0c-68.8,0-137.7,0-206.5,0c-11.1,0-14.9-3.6-15.7-14.7 c-4-52.2-8.1-104.3-12.1-156.5c-0.7-9.6,2.8-13.4,12.6-13.4C63.4,69.8,114.1,69.8,164.7,69.8z"/> <path class="st0" d="M314.3,64.4c-5.2,0-9.6,0-14.4,0c-0.1-1.7-0.2-3.1-0.4-4.6c-0.6-5.7-4.6-9.9-10.2-10.7 c-1.8-0.2-3.7-0.3-5.5-0.3c-79.8,0-159.7,0-239.5,0c-4.6,0-9.5-0.1-12.2,4.1c-2.1,3.1-3,7.1-4.6,11.3c-3.5,0-7.9,0-13,0 c-0.1-1.5-0.3-3.1-0.3-4.7c0-15.7,0-31.3,0-47c0-8.9,3.4-12.4,12.4-12.5c29.5-0.1,59-0.1,88.5,0c8.4,0,14.7,3.9,18.3,11.6 c0.6,1.2,1.2,2.4,1.8,3.6c4.4,9,11.6,13.4,21.6,13.3c48,0,96,0,144,0c10.6,0,13.6,3,13.6,13.7C314.3,49.5,314.3,56.6,314.3,64.4z" /> </g> </svg>
                                    <strong>
									<?php
										$post_cat = '';
                                        foreach ($p->categories()->lists('name_' . $current_lang) as $cat) {
                                            echo $cat;
                                            break;
                                        }?>
									</strong>
                                </span>
                                <h2>{{ $p->getTitle() }}</h2>
                                <p>
                                    {{ Helper::str_limit($p->getContent()) }}
                                </p>
                                <a class="more" href="<?= route("front.".$type.".post", $p->slug); ?>">اقرأ المزيد</a>
                            </div>
                        </div>
                    </li>
					@endforeach
                    
                </ul>
            </div>


            <div class="pagination_sec sec shadow_type">
                <span class="page_number"><?= $posts->currentPage() ?> of {{ $posts->lastPage() }}</span>

                <nav class="pagination_list" aria-label="Page navigation example">


<?php
 ?>

@if ($posts->lastPage() > 1)
<ul class="pagination justify-content-end num">
    <li class="page-item {{ ($posts->currentPage() == 1) ? ' disabled' : '' }}">
        <a class="page-link" href="{{ $posts->url(1) }}"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10"><path data-name="Forma 1 copy 5" fill-rule="evenodd" d="M.279 4.33l4.1-4.054a.96.96 0 011.347 0 .942.942 0 010 1.338L3.319 3.992h7.677a1.027 1.027 0 011.015 1.016 1 1 0 01-1 1H3.324l2.4 2.375a.94.94 0 010 1.337.956.956 0 01-1.347 0l-4.1-4.054A.942.942 0 01.279 4.33z"></path></svg></a>
    </li>
    @for ($i = 1; $i <= $posts->lastPage(); $i++)
         <?php
	 $link_limit = 10;
            $half_total_links = floor($link_limit / 2);
            $from = $posts->currentPage() - $half_total_links;
            $to = $posts->currentPage() + $half_total_links;
            if ($posts->currentPage() < $half_total_links) {
               $to += $half_total_links - $posts->currentPage();
            }
            if ($posts->lastPage() - $posts->currentPage() < $half_total_links) {
                $from -= $half_total_links - ($posts->lastPage() - $posts->currentPage()) - 1;
            }
            ?>
            @if ($from < $i && $i < $to)
                <li class="page-item {{ ($posts->currentPage() == $i) ? ' active' : '' }}">
                    <a class="page-link" href="{{ $posts->url($i) }}">{{ $i }}</a>
                </li>
            @endif
    @endfor
    <li class="page-item {{ ($posts->currentPage() == $posts->lastPage()) ? ' disabled' : '' }}">
        <a class="page-link" href="{{ $posts->url($posts->currentPage()+1) }}" ><svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10"><path data-name="Forma 1 copy 5" fill-rule="evenodd" d="M11.721 5.67l-4.1 4.054a.96.96 0 01-1.347 0 .942.942 0 010-1.338l2.407-2.378H1.004A1.027 1.027 0 01-.007 5a1 1 0 011-1H8.68l-2.4-2.375a.94.94 0 010-1.337.956.956 0 011.347 0l4.1 4.054a.942.942 0 01-.006 1.328z"></path></svg></a>
    </li>
</ul>
@endif



					<!--<ul class="pagination justify-content-end num">
                        <li class="page-item disabled">
                            <a class="page-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10"><path data-name="Forma 1 copy 5" fill-rule="evenodd" d="M.279 4.33l4.1-4.054a.96.96 0 011.347 0 .942.942 0 010 1.338L3.319 3.992h7.677a1.027 1.027 0 011.015 1.016 1 1 0 01-1 1H3.324l2.4 2.375a.94.94 0 010 1.337.956.956 0 01-1.347 0l-4.1-4.054A.942.942 0 01.279 4.33z"></path></svg></a>
                        </li>
                        <li class="page-item active disabled"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10"><path data-name="Forma 1 copy 5" fill-rule="evenodd" d="M11.721 5.67l-4.1 4.054a.96.96 0 01-1.347 0 .942.942 0 010-1.338l2.407-2.378H1.004A1.027 1.027 0 01-.007 5a1 1 0 011-1H8.68l-2.4-2.375a.94.94 0 010-1.337.956.956 0 011.347 0l4.1 4.054a.942.942 0 01-.006 1.328z"></path></svg></a>
                        </li>
                    </ul>-->
                </nav>
            </div>


        </div>
        <!-- End Left Section -->


        <!-- Start Fixed Section -->
        <div class="right_sec">
            <a class="close_filter_btn">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 211.4 218.9" xml:space="preserve"><g> <path class="st0" d="M628.8-7.9c31.7,0,63.3,0,95,0c6.1,0,10.8,2.3,13.6,7.6c2.6,4.9,2.5,10.2-1,14.6c-1.9,2.3-4.9,3.8-7.4,5.6 c-2.5,1.7-5.6,2.8-7.5,5c-22,26.7-43.9,53.6-65.7,80.6c-1.7,2.1-2.8,5.3-2.8,8c-0.2,28.3-0.2,56.5,0,84.8c0,4.6-1.6,7.4-5.4,9.7 c-11.5,7.1-22.7,14.6-34.2,21.6c-2.2,1.4-6.1,2.2-8.1,1.1c-1.9-1-3.4-4.8-3.4-7.4c-0.2-19.7,0-39.3,0-59c0-17.6,0-35.3-0.3-52.9 c0-2-0.9-4.3-2.1-5.8c-22.4-27.7-45-55.3-67.6-82.9c-1.1-1.3-2.7-2.4-4.3-3.2c-7-3.3-10.3-9.5-8.7-16.7c1.4-6.3,7.1-10.8,14.4-10.8 C565.2-7.9,597-7.9,628.8-7.9z M714.5,21c-58.3,0-115.7,0-173.4,0c0.3,0.8,0.4,1.1,0.6,1.3c21.2,26.1,42.5,52.2,63.9,78.2 c1.1,1.4,3.6,2.3,5.5,2.3c8.5,0.2,17.1-0.5,25.5,0.3c8.2,0.8,13.3-2.2,18.3-8.6C674.2,70,694.2,45.9,714.5,21z M609.7,110.9 c0,37.5,0,74.3,0,112c11.8-7.5,22.8-14.4,33.6-21.5c1.2-0.8,1.9-3,1.9-4.6c0.2-8.3,0.1-16.7,0.1-25c0.1-14.1,0.2-28.2,0.3-42.3 c0-6.1,0-12.2,0-18.6C633.2,110.9,621.6,110.9,609.7,110.9z M628.8-0.2c-30.7,0-61.3,0-92,0c-7.5,0-10.8,2.1-10.6,6.7 c0.1,4.4,3.4,6.4,10.6,6.4c61.3,0,122.6,0,183.9,0c2,0,4.5,0.4,5.8-0.6c2-1.5,4.6-4.3,4.4-6.2c-0.3-2.3-3.1-4.4-5.3-6.1 c-0.9-0.7-2.9-0.2-4.4-0.2C690.5-0.2,659.7-0.2,628.8-0.2z"/> </g> <path class="st0" d="M7.6,128.7L87.9,209c10.2,10.2,26.7,10.2,36.9,0c10.2-10.2,10.2-26.8,0-37l-31.3-31.4l86.3,0 c16.3,0,29.5-11.5,29.5-27.9c0-16.3-13.2-27.9-29.5-27.9l-90.9,0l35.9-37.5c10.2-10.2,10.2-27.5,0-37.7C114.7-0.5,98.1-0.9,87.9,9.3 L7.6,89.4C2.2,94.8-0.3,101.9,0,109C-0.3,116.1,2.2,123.2,7.6,128.7z"/> </svg>
            </a>

            <div class="fixed_sec">

                <!--<section class="form fast_search search_filter shadow_type">-->
                    @include("front.partials.blog_filter")
                <!--</section>-->

                <section class="form shadow_type form_sec">
                    @include("front.partials.call_us_fixed")
                </section>

            </div>
        </div>
        <!-- End Fixed Section -->



    </div>
</div>