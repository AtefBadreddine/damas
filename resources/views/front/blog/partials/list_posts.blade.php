<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$pos = -1; ?><?php /* ?>
                    <style>
                        @media (max-width: 5000px){
                            img {
                                min-height: auto !important;
                                max-height: fit-content !important;
                            }
                        }
                    </style> <?php */ ?>
                    @foreach($posts as $p)
                    <?php $pos++ ?>
                    <li>
                        <div class="sec shadow_type">
                            <div class="image_cont">
                                <a href="<?= localized_route("front.".$type.".post", $p->slug) ?>">

								<?php /*<!--
                                    fixed by  dev
                                -->
                                 <img
                                    src="<?= asset($p->photoCard->path_mobile) ?>"
                                    style="object-fit: cover;"
                                >*/
                                ?>
                               
                                
                                {!! Helper::get_pic(Helper::get_thumbnail($p->photoCard, 288, 177, true),(isset($ajax)?'':'lazy'),'','', $p->getTitle(), '') !!}

								<span class="date num"><?= date_format(new DateTime($p->update_date), "d/m/Y"); ?></span></a>
                            </div>
                            <div class="text jazzira_font">
                                <span>
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 328.4 254.4" xml:space="preserve"><g> <path class="st0" d="M164.7,69.8c50.2,0,100.3,0,150.5,0c10.5,0,13.8,3.6,13,14c-4,52.8-8.1,105.7-12.2,158.5 c-0.6,7.8-5.4,12.1-13.6,12.1c-22.7,0-45.3,0-68,0c-68.8,0-137.7,0-206.5,0c-11.1,0-14.9-3.6-15.7-14.7 c-4-52.2-8.1-104.3-12.1-156.5c-0.7-9.6,2.8-13.4,12.6-13.4C63.4,69.8,114.1,69.8,164.7,69.8z"/> <path class="st0" d="M314.3,64.4c-5.2,0-9.6,0-14.4,0c-0.1-1.7-0.2-3.1-0.4-4.6c-0.6-5.7-4.6-9.9-10.2-10.7 c-1.8-0.2-3.7-0.3-5.5-0.3c-79.8,0-159.7,0-239.5,0c-4.6,0-9.5-0.1-12.2,4.1c-2.1,3.1-3,7.1-4.6,11.3c-3.5,0-7.9,0-13,0 c-0.1-1.5-0.3-3.1-0.3-4.7c0-15.7,0-31.3,0-47c0-8.9,3.4-12.4,12.4-12.5c29.5-0.1,59-0.1,88.5,0c8.4,0,14.7,3.9,18.3,11.6 c0.6,1.2,1.2,2.4,1.8,3.6c4.4,9,11.6,13.4,21.6,13.3c48,0,96,0,144,0c10.6,0,13.6,3,13.6,13.7C314.3,49.5,314.3,56.6,314.3,64.4z" /> </g> </svg>
                                    <strong>
                                        <?php
                                        $post_cat = '';
                                        foreach ($p->categories()->lists('name_' . ($current_lang == 'pe' ? 'fa' : $current_lang)) as $cat) {
                                            echo $cat;
                                            break;
                                        }
                                        ?>
                                    </strong>
                                </span>
                                <h2><a href="<?= localized_route("front.".$type.".post", $p->slug); ?>">{{ $p->getTitle() }}</a></h2>
                                <p>
                                    {{ Helper::str_limit($p->getContent()) }}
                                </p>
                                <a class="more jazzira_font_bold" href="<?= localized_route("front.".$type.".post", $p->slug); ?>"><?= trans("front.read more"); ?></a>
                            </div>
                        </div>
                    </li>
                    <?php /*<pre style="display:none">
                    {{ print_r([
                        'path' => $p->photoCard->path,
                        'path_mobile' => $p->photoCard->path_mobile
                    ], true) }}
                    </pre>*/?>
                    @endforeach
@if(count($posts)>0)
<li style=" width: 100%;text-align:center;min-height: auto;">
<a class="btn load_more {{ ($posts->currentPage()==$posts->lastPage())?'d-none':'' }}" href="{{ $posts->url($posts->currentPage()+1) }}" ><i class="fa fa-spinner fa-spin"></i></a>
</li>
@endif