<?php
$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr', 'ru']) ? 'en' : 'ar';
?>
@section('styles')
<?php
$infos = Helper::get_params();
$is_mobile = Helper::get_device() != 'full' ? true : false;
$citys = Helper::query("City", "orderByPlacement");
$ProjectTypes = Helper::query("ProjectType", "all");
$tags = Helper::query("ProjectCategory", "where", ["field" => "hide_search_page", "value" => false])->get();
$arr_rooms = [
    "1_0" => "1 + 0",
    "1_1" => "1 + 1",
    "1_2" => "1 + 2",
    "1_3" => "1 + 3",
    "1_4" => "1 + 4",
    "1_5" => "1 + 5",
    "2_3" => "2 + 3",
    "2_4" => "2 + 4",
    "2_5" => "2 + 5",
    "2_6" => "2 + 6"
];
$aboutBody = '';
if (count($allprojects) == 0) {
    $rh1 = ($current_lang == 'ar' ? 'لا يوجد نتائج' : 'No Results Found');
} else {
    $rh1 = trim((string) @$inputs['display_h1']);
    if ($rh1 === '') {
        $parts = explode('</h1>', $inputs['about'], 2);
        $rh1 = trim(strip_tags(@$parts[0]));
    }
    $rh1 = ($rh1 == '' ? trans('front.Properties') : $rh1);
    if (!empty($inputs['about_body'])) {
        $aboutBody = $inputs['about_body'];
    } else {
        $parts = explode('</h1>', $inputs['about'], 2);
        if (isset($parts[1])) {
            $inner = trim($parts[1]);
            if (preg_match('#^<div class="clearfix">(.*)</div>$#s', $inner, $aboutMatch)) {
                $aboutBody = $aboutMatch[1];
            } else {
                $aboutBody = $inner;
            }
        }
    }
}
$aboutPlain = html_entity_decode(strip_tags($aboutBody), ENT_QUOTES, 'UTF-8');
$hasAboutContent = trim(preg_replace('/\s+|&nbsp;|\x{00A0}/u', '', $aboutPlain)) !== '';
?>
@include('front.partials.search_layout_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/search.min.css') }}?v=06">
<?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
<link rel="stylesheet" type="text/css" href="{{ asset('css/search-en.min.css') }}?v=05">
<?php } ?>
@endsection

@extends('front.layout', [
    'hide_main_js' => true,
    'hide_onesignal' => true,
    "is_page_search" => '1',
    "page_title" => @$inputs["seo_title"],
    "page_description" => @$inputs["seo_description"],
    "page_keywords" => @$inputs["seo_keywords"],
    "og_image" => @$inputs["og_image"],
])

@section('main_content')
<div class="col-md-10 offset-md-1">
    <div class="full_sections int_page">
        <div class="left_sec">
            <div class="top_control_sec search_page">
                <div class="type_full sec">
                    <h1 class="jazzira_font_bold"><?= $rh1 ?></h1>
                    <strong class="num pr_count">(<?= count($allprojects); ?>)</strong>
                </div>
                <div class="categories_sec mob">
                    <ul>
                        <li class="filter"><a class="filter_btn"> <svg width="20" height="20" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 220.6 239.5" xml:space="preserve"><g> <path class="st0" d="M110.2,0.5c31.7,0,63.3,0,95,0c6.1,0,10.8,2.3,13.6,7.6c2.6,4.9,2.5,10.2-1,14.6c-1.9,2.3-4.9,3.8-7.4,5.6 c-2.5,1.7-5.6,2.8-7.5,5c-22,26.7-43.9,53.6-65.7,80.6c-1.7,2.1-2.8,5.3-2.8,8c-0.2,28.3-0.2,56.5,0,84.8c0,4.6-1.6,7.4-5.4,9.7 c-11.5,7.1-22.7,14.6-34.2,21.6c-2.2,1.4-6.1,2.2-8.1,1.1c-1.9-1-3.4-4.8-3.4-7.4c-0.2-19.7,0-39.3,0-59c0-17.6,0-35.3-0.3-52.9 c0-2-0.9-4.3-2.1-5.8C58.5,86.3,36,58.7,13.4,31.1c-1.1-1.3-2.7-2.4-4.3-3.2c-7-3.3-10.3-9.5-8.7-16.7C1.8,5,7.5,0.5,14.8,0.5 C46.6,0.4,78.4,0.5,110.2,0.5z"></path> </g> </svg> </a></li>
                    </ul>
                </div>
            </div>

            <div class="tab-content sec">
                <div class="int_content project_card">
                    <div class="type_mob">
                        <h1 class="jazzira_font_bold page_title_mob"><?= $rh1 ?></h1>
                        <strong class="num pr_count">(<?= count($allprojects); ?>)</strong>
                    </div>

                    @if($hasAboutContent)
                    <div class="content_section">
                        <div id="about-content" class="cont">
                            <div class="clearfix">{!! $aboutBody !!}</div>
                        </div>
                        <div class="action_content">
                            <span class="show_more_btn"><?= trans("front.read more"); ?></span>
                            <span class="show_less_btn"><?= trans("front.read less"); ?></span>
                        </div>
                    </div>
                    @endif

                    <div class="control_icons">
                        <a class="filter_btn">
                            <svg width="20" height="20" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 220.6 239.5" xml:space="preserve"><g> <path class="st0" d="M110.2,0.5c31.7,0,63.3,0,95,0c6.1,0,10.8,2.3,13.6,7.6c2.6,4.9,2.5,10.2-1,14.6c-1.9,2.3-4.9,3.8-7.4,5.6 c-2.5,1.7-5.6,2.8-7.5,5c-22,26.7-43.9,53.6-65.7,80.6c-1.7,2.1-2.8,5.3-2.8,8c-0.2,28.3-0.2,56.5,0,84.8c0,4.6-1.6,7.4-5.4,9.7 c-11.5,7.1-22.7,14.6-34.2,21.6c-2.2,1.4-6.1,2.2-8.1,1.1c-1.9-1-3.4-4.8-3.4-7.4c-0.2-19.7,0-39.3,0-59c0-17.6,0-35.3-0.3-52.9 c0-2-0.9-4.3-2.1-5.8C58.5,86.3,36,58.7,13.4,31.1c-1.1-1.3-2.7-2.4-4.3-3.2c-7-3.3-10.3-9.5-8.7-16.7C1.8,5,7.5,0.5,14.8,0.5 C46.6,0.4,78.4,0.5,110.2,0.5z"/> </g> </svg>
                        </a>
                    </div>

                    <div class="wrapper block_sec sec show">
                        @foreach($projects as $project)
                            @include("front.partials.project_item", [ "project" => $project, 'card_class' => 'item card_item' ])
                        @endforeach
                    </div>
                </div>

                @include('front.partials.pagination-projects', ['projects' => $projects, 'cnt_projs' => count($allprojects)])
            </div>
        </div>

        <div class="right_sec">
            <a class="close_filter_btn">
                <svg version="1.1" width="20" height="20" id="Layer_1"  x="0px" y="0px" viewBox="0 0 211.4 218.9" xml:space="preserve"><g> <path class="st0" d="M628.8-7.9c31.7,0,63.3,0,95,0c6.1,0,10.8,2.3,13.6,7.6c2.6,4.9,2.5,10.2-1,14.6c-1.9,2.3-4.9,3.8-7.4,5.6 c-2.5,1.7-5.6,2.8-7.5,5c-22,26.7-43.9,53.6-65.7,80.6c-1.7,2.1-2.8,5.3-2.8,8c-0.2,28.3-0.2,56.5,0,84.8c0,4.6-1.6,7.4-5.4,9.7 c-11.5,7.1-22.7,14.6-34.2,21.6c-2.2,1.4-6.1,2.2-8.1,1.1c-1.9-1-3.4-4.8-3.4-7.4c-0.2-19.7,0-39.3,0-59c0-17.6,0-35.3-0.3-52.9 c0-2-0.9-4.3-2.1-5.8c-22.4-27.7-45-55.3-67.6-82.9c-1.1-1.3-2.7-2.4-4.3-3.2c-7-3.3-10.3-9.5-8.7-16.7c1.4-6.3,7.1-10.8,14.4-10.8 C565.2-7.9,597-7.9,628.8-7.9z"/> </g> <path class="st0" d="M7.6,128.7L87.9,209c10.2,10.2,26.7,10.2,36.9,0c10.2-10.2,10.2-26.8,0-37l-31.3-31.4l86.3,0 c16.3,0,29.5-11.5,29.5-27.9c0-16.3-13.2-27.9-29.5-27.9l-90.9,0l35.9-37.5c10.2-10.2,10.2-27.5,0-37.7C114.7-0.5,98.1-0.9,87.9,9.3 L7.6,89.4C2.2,94.8-0.3,101.9,0,109C-0.3,116.1,2.2,123.2,7.6,128.7z"/> </svg>
            </a>
            <a id="outMenu" class="out_filter_btn"></a>
            <div class="fixed_sec">
                <section class="form fast_search shadow_type">
                    @include("front.partials.projects_filter")
                </section>
            </div>
        </div>

        <div class="sec share_links_sec">
            @include("front.partials.share_links", [])
        </div>
    </div>
</div>
@endsection

@section('scriptjs')
<?php
$countriesByCode = \App\Models\Country::all()->keyBy('code');
$projectsListingUrl = route('front.projects');
$locationCountryUrl = ($locationCountry ? $locationCountry->listingUrl() : $projectsListingUrl);
$cityUrls = array();
foreach ($citys as $c) {
    if (isset($countriesByCode[$c->slug]) && $countriesByCode[$c->slug]) {
        $cityUrls[$c->slug] = $countriesByCode[$c->slug]->listingUrl();
    } elseif ($c->listingUrl()) {
        $cityUrls[$c->slug] = $c->listingUrl();
    }
}
$regionUrls = array();
$hiddenFilterCityIds = array_flip(\App\Models\Country::hiddenFilterCityIds());
foreach ($inputs['regions_options'] as $r) {
    if (!$r) {
        continue;
    }
    if (isset($hiddenFilterCityIds[$r->city_id])) {
        continue;
    }
    $regionUrl = $r->listingUrl();
    if ($regionUrl) {
        $regionUrls[$r->slug] = $regionUrl;
    }
}
?>
<script type="text/javascript" src="{{ asset('js/main_search.min.js') }}?v=10"></script>
<script type="text/javascript" src="{{ asset('js/jquery.fancybox.min.js') }}?v=09" defer=""></script>
<script>
(function () {
    var listingFilterKeys = ['type', 'category', 'rooms', 'price', 'sorting', 'sorting_type', 'district', 'regions'];

    window.preserveQueryOnPathChange = function (pathUrl) {
        var params = new URLSearchParams(window.location.search);
        params.delete('page');
        params.delete('district');
        params.delete('regions');
        var qs = params.toString();
        return pathUrl + (qs ? '?' + qs : '');
    };

    window.buildProjectListingUrl = function (pathUrl, filterParams) {
        filterParams = filterParams || [];
        var params = new URLSearchParams(window.location.search);
        params.delete('page');
        listingFilterKeys.forEach(function (key) {
            params.delete(key);
        });
        filterParams.forEach(function (pair) {
            var eq = pair.indexOf('=');
            if (eq === -1) {
                return;
            }
            var key = decodeURIComponent(pair.slice(0, eq));
            var value = pair.slice(eq + 1);
            if (value === '') {
                params.delete(key);
            } else {
                params.set(key, decodeURIComponent(value.replace(/\+/g, ' ')));
            }
        });
        var qs = params.toString();
        return pathUrl + (qs ? '?' + qs : '');
    };
})();

$(document).ready(function () {
    $('.main_menu .links>li>a.projects_btn').addClass("active");
    $('.cleared_filter').show();
    $(".loader_sec").fadeOut();

    var oldsctop = $(window).scrollTop();
    $(window).scroll(function () {
        if (($(this).scrollTop()) > oldsctop) {
            $(".top_control_sec").addClass("scrollMob");
        } else {
            $(".top_control_sec").removeClass("scrollMob");
        }
        oldsctop = $(this).scrollTop();
    });

    $(document).on("click", ".filter_btn", function () {
        $(".right_sec").addClass("show");
    });
    $(document).on("click", ".close_filter_btn, #outMenu", function () {
        $(".right_sec").removeClass("show");
    });

    var aboutContentCounter = 1;
    var aboutContentCollapsedHeight = 350;

    function bindAboutContentActions($sec) {
        var $cont = $sec.find(".cont").first();
        var fullHeight = $cont.css({maxHeight: "none", height: "auto"}).height();
        $cont.css({maxHeight: aboutContentCollapsedHeight + "px", height: "auto"});
        if (fullHeight <= aboutContentCollapsedHeight) {
            $sec.find(".action_content").hide();
        }
    }

    $(".int_content .content_section").each(function () {
        bindAboutContentActions($(this));
    });
    $(".int_content .show_less_btn").hide();

    $(document).on("click", ".int_content .show_more_btn", function () {
        var $sec = $(this).closest(".content_section");
        var $cont = $sec.find(".cont").first();
        var $action = $(this).closest(".action_content");
        var $lessBtn = $action.find(".show_less_btn");

        if (aboutContentCounter === 1) {
            $cont.animate({maxHeight: "400px"}, 200);
            $("html, body").animate({scrollTop: $sec.offset().top - 100}, "slow");
            $lessBtn.show();
            aboutContentCounter++;
            return true;
        }
        if (aboutContentCounter === 2) {
            $cont.animate({maxHeight: "800px"}, 200);
            $("html, body").animate({scrollTop: $sec.offset().top - 50}, "slow");
            $lessBtn.show();
            aboutContentCounter++;
            return true;
        }
        if (aboutContentCounter === 3) {
            var heightDiv = $cont.css({maxHeight: "none"}).height();
            $cont.animate({maxHeight: heightDiv}, 200);
            $sec.addClass("show");
            $("html, body").animate({scrollTop: $sec.offset().top + 250}, "slow");
            $(this).hide();
            $lessBtn.show();
            $action.addClass("type_less");
            return false;
        }
        aboutContentCounter = 1;
        return false;
    });

    $(document).on("click", ".int_content .show_less_btn", function () {
        var $sec = $(this).closest(".content_section");
        var $cont = $sec.find(".cont").first();
        var $action = $(this).closest(".action_content");

        $cont.animate({maxHeight: aboutContentCollapsedHeight + "px"}, 300);
        $sec.removeClass("show");
        $("html, body").animate({scrollTop: $sec.offset().top - 100}, "slow");
        aboutContentCounter = 1;
        $action.removeClass("type_less");
        setTimeout(function () {
            $action.find(".show_less_btn").hide();
            $action.find(".show_more_btn").show();
        }, 300);
    });

    var PRICE_MIN = 50000, PRICE_MAX = 2000000;
    var cityUrls = <?= json_encode($cityUrls, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?>;
    var regionUrls = <?= json_encode($regionUrls, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?>;
    var locationAreaUrl = <?= json_encode($locationAreaUrl, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?>;
    var locationCountryUrl = <?= json_encode($locationCountryUrl, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?>;
    var projectsListingUrl = <?= json_encode($projectsListingUrl, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?>;
    var currentPrice = <?= json_encode((string) @$inputs['price']) ?>;
    var currentSorting = <?= json_encode((string) @$inputs['sorting']) ?>;
    var currentSortingType = <?= json_encode((string) Request::get('sorting_type', '')) ?>;
    var priceTouched = false;

    function showBudget() {
        var min = parseInt($('#prmin').val(), 10), max = parseInt($('#prmax').val(), 10);
        if (min > max) { var t = min; min = max; max = t; }
        $('.range-slider .rangeValues').text('$' + min + ' - $' + max);
        $('.budget .dropdown .dropdown-toggle .number').text('$' + min + ' - $' + max);
    }
    if (currentPrice) {
        var pr = currentPrice.split('-');
        $('#prmin').val(pr[0]);
        $('#prmax').val(pr[1] === '+' ? PRICE_MAX : pr[1]);
    }
    showBudget();
    $(document).on('input', '#prmin, #prmax', showBudget);

    function selectedValues(selector) {
        var out = [];
        $(selector + ' option:selected').each(function () {
            if ($(this).val()) {
                out.push($(this).val());
            }
        });
        return out;
    }

    function collectLocationFilterParams() {
        var params = [];

        var type = $('select[name=project_type]').val();
        if (type) {
            params.push('type=' + encodeURIComponent(type));
        }

        var categories = selectedValues('#project_categories');
        if (categories.length) {
            params.push('category=' + categories.map(encodeURIComponent).join(','));
        }

        var rooms = $('select[name=rooms]').val();
        if (rooms) {
            params.push('rooms=' + encodeURIComponent(rooms));
        }

        var price = currentPrice;
        if (priceTouched) {
            var min = parseInt($('#prmin').val(), 10), max = parseInt($('#prmax').val(), 10);
            if (min > max) { var t = min; min = max; max = t; }
            price = (min <= PRICE_MIN && max >= PRICE_MAX) ? '' : min + '-' + (max >= PRICE_MAX ? '+' : max);
        }
        if (price) {
            params.push('price=' + encodeURIComponent(price));
        }

        if (currentSorting) {
            params.push('sorting=' + encodeURIComponent(currentSorting));
            if (currentSortingType) {
                params.push('sorting_type=' + encodeURIComponent(currentSortingType));
            }
        }

        return params;
    }

    function resolveLocationListingPath() {
        var $regionOption = $('#selectregions option:selected');
        var regionSlug = $regionOption.val();
        if (regionSlug) {
            return $regionOption.attr('data-url') || regionUrls[regionSlug] || projectsListingUrl;
        }

        var citySlug = $('select[name=city]').val();
        if (citySlug) {
            return cityUrls[citySlug] || projectsListingUrl;
        }

        var filterData = window.projectsFilterData || {};
        var countryId = parseInt($('#filter_country').val(), 10);
        if (countryId && filterData.countryUrls && filterData.countryUrls[countryId]) {
            return filterData.countryUrls[countryId];
        }

        return projectsListingUrl;
    }

    function applyLocationFilters() {
        var url = resolveLocationListingPath();
        var params = collectLocationFilterParams();
        window.location.href = window.buildProjectListingUrl(url, params);
    }

    $(document).on("change", ".input_seacrh", function (e) {
        if (e.target.id === 'prmin' || e.target.id === 'prmax') {
            priceTouched = true;
        }
        $('.cleared_filter').show();
        return false;
    });

    $(document).on('click', '.send_btn_projects', function (e) {
        e.preventDefault();
        applyLocationFilters();
        return false;
    });

    $("#form-search").on("submit", function () {
        return false;
    });

    var loadingMore = false;
    function nextPageLink() {
        var $link = $('.pagination_list .load_more');
        return ($link.length && !$link.hasClass('d-none') && $link.attr('href')) ? $link : null;
    }
    function loadMoreProjects() {
        var $link = nextPageLink();
        if (loadingMore || !$link) {
            return;
        }
        loadingMore = true;
        $.get($link.attr('href')).done(function (html) {
            var $page = $('<div>').append($.parseHTML(html));
            $('.int_content .block_sec').append($page.find('.int_content .block_sec').children());
            var $next = $page.find('.pagination_list .load_more');
            if ($next.length && !$next.hasClass('d-none') && $next.attr('href')) {
                $link.attr('href', $next.attr('href'));
            } else {
                $('.pagination_list').remove();
            }
        }).fail(function () {
            $('.pagination_list').remove();
        }).always(function () {
            loadingMore = false;
            maybeLoadMore();
        });
    }
    function maybeLoadMore() {
        var $link = nextPageLink();
        if ($link && $link.offset().top < $(window).scrollTop() + $(window).height() + 600) {
            loadMoreProjects();
        }
    }
    $(window).on('scroll resize', maybeLoadMore);
    $(document).on('click', '.pagination_list .load_more', function (e) {
        e.preventDefault();
        loadMoreProjects();
    });
    maybeLoadMore();
});
</script>
@endsection

@section('schemaorg')
<script type="application/ld+json">
{
    "@context":"http://schema.org",
    "@type":"BreadcrumbList",
    "itemListElement":[
        {"@type":"ListItem","position":1,"name":"{{ trans('front.home') }}","item":"{{ route('front.index') }}"}
        @if(isset($locationCountry) && $locationCountry)
        ,{"@type":"ListItem","position":2,"name":"{{ $locationCountry->getTitle() }}","item":"{{ $locationCountry->listingUrl() }}"}
        @elseif(Route::currentRouteName() === 'front.projects')
        ,{"@type":"ListItem","position":2,"name":"{{ trans('front.projects') }}","item":"{{ route('front.projects') }}"}
        @endif
        @if(isset($locationCity) && $locationCity)
        ,{"@type":"ListItem","position":3,"name":"{{ $locationCity->getName() }}","item":"{{ $locationCity->listingUrl() }}"}
        @endif
        @if(isset($locationRegion) && $locationRegion)
        ,{"@type":"ListItem","position":4,"name":"{{ $locationRegion->getName() }}","item":"{{ $locationRegion->listingUrl() }}"}
        @endif
    ]
}
</script>
@endsection
