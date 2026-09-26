<?php

use Carbon\Carbon;
use App\Models\ProjectFlavor;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Cache;


if (!function_exists('localized_route')) {
    function localized_route($name, $parameters = [], $absolute = true)
    {
        if (!is_array($parameters)) {
            $parameters = [$parameters];
        }

        $url = route($name, $parameters, $absolute);

        // فحص ما إذا كان الرابط الأصلي يحتوي على "/oman/"
        if (strpos(request()->getPathInfo(), '/oman/') !== false) {

            // استخراج الجزء بعد الدومين (مسار الرابط)
            $path = parse_url($url, PHP_URL_PATH);

            // استخراج اللغة إن وُجدت (2 حروف فقط)
            preg_match('#^/([a-z]{2})(/|$)#', $path, $matches);
            $lang = $matches[1] ?? null;

            if ($lang) {
                // إدخال "/oman" بعد اللغة
                $url = str_replace("/$lang/", "/$lang/oman/", $url);
            } else {
                // لا يوجد لغة -> ضع "/oman" مباشرة بعد الدومين
                $url = str_replace(url('/'), url('/oman'), $url);
            }
        }

        return $url;
    }
}

if (!function_exists('localized_url')) {
    /**
     * LaravelLocalization::getLocalizedURL() that keeps the default locale in the URL
     * on locale-required routes (/en/guides -> /ar/guides, not /guides).
     */
    function localized_url($locale)
    {
        $url = LaravelLocalization::getLocalizedURL($locale);

        $route = Route::current();
        $action = $route ? $route->getAction() : [];
        if (empty($action['locale_required']) || $locale !== LaravelLocalization::getDefaultLocale()) {
            return $url;
        }

        $root = request()->root();
        return $root . '/' . $locale . '/' . ltrim(substr($url, strlen($root)), '/');
    }
}

if (!function_exists('seo_url')) {
    /**
     * Canonical/hreflang URL: localized path without query string, except ?page=N when N > 1.
     */
    function seo_url($locale = null)
    {
        $locale = $locale ?: LaravelLocalization::getCurrentLocale();
        $url = strtok(localized_url($locale), '?');
        $url = str_replace('/public/', '/', $url);

        $page = (int) request()->get('page');

        return $page > 1 ? $url . '?page=' . $page : $url;
    }
}

if (!function_exists('front_link')) {
    /**
     * Prepend /ar to stored unprefixed page URLs when the current locale is Arabic.
     * Leaves endpoints, already-prefixed paths, home, and external URLs unchanged.
     */
    function front_link($url)
    {
        if ($url === null || $url === '' || $url === '#') {
            return $url;
        }

        $url = str_replace(array('https://www.damas.net', 'http://www.damas.net', 'https://damas.net', 'http://damas.net'), '', $url);

        if (preg_match('#^(https?:)?//#', $url) || strpos($url, 'mailto:') === 0 || strpos($url, 'tel:') === 0 || strpos($url, 'javascript:') === 0) {
            return $url;
        }

        if (LaravelLocalization::getCurrentLocale() !== LaravelLocalization::getDefaultLocale()) {
            return $url;
        }

        $parts = parse_url($url);
        $path = isset($parts['path']) ? $parts['path'] : '';
        if ($path === '' || $path === '/') {
            return $url;
        }

        $first = explode('/', ltrim($path, '/'));
        $first = $first[0];

        $locales = LaravelLocalization::getSupportedLanguagesKeys();
        if (in_array($first, $locales)) {
            return $url;
        }

        $skip = array(
            'ajax', 'ajax_projects_info', 'ajax_group_projects', 'ajaxposts', 'ajax_statics',
            'callus', 'callus2', 'callmeModalAjax', 'callvac', 'call_us_landing_tourism',
            'loadmore', 'newsletter', 'likeitem', 'like_video', 'confirmation',
            'preview_pdf', 'testphp', 'cron_tiny_picture', 'sitemap_xml', 'rss', 'rss_notifs',
            'whatsapp_share', 'ratesexchange-try', 'currency', 'filter_rooms',
            'login', 'logout', 'register', 'password', 'damas-administrator',
            'amp', 'oman', 'syria', 'webhooks',
        );
        if (in_array($first, $skip) || strpos($first, 'cron_') === 0) {
            return $url;
        }

        $new = '/' . LaravelLocalization::getDefaultLocale() . '/' . ltrim($path, '/');
        if (!empty($parts['query'])) {
            $new .= '?' . $parts['query'];
        }
        if (!empty($parts['fragment'])) {
            $new .= '#' . $parts['fragment'];
        }

        return $new;
    }
}

class Helper
{
    public static $params=array();
    public static $device='';
    public static $flavors=array();
    public static $pubs=array();
    /**
     * generate a project's default H1.
     *
     * @param \App\Models\Project $project
     * @param string $language
     * @return string
     */
    public static function generate_project_default_h1($project, $language = 'ar')
    {
        $language = $language === 'en' ? 'en' : 'ar';
        $originalLanguage = \LaravelLocalization::getCurrentLocale();
        \LaravelLocalization::setLocale($language);
        try {
            $projectTypes = $project->types;
            $projectCategories = $project->categories;
            $typeName = isset($projectTypes[0]) ? $projectTypes[0]->getName() : '';
            $categoryName = isset($projectCategories[0]) ? $projectCategories[0]->getName() : '';
            $cityName = $project->city ? $project->city->getName() : '';
            $regionName = $project->region ? $project->region->getName() : '';
            $h1 = $typeName . ' ' . trans('front.for_sale') . ' ' . $cityName . ' ' . $regionName . ' ' . $categoryName;
            return trim(preg_replace('/\s+/u', ' ', $h1));
        } finally {
            \LaravelLocalization::setLocale($originalLanguage);
        }
    }
    /**
     * generate the fallback H1 for a search/listing URL.
     *
     * @param string $link
     * @param string $language
     * @return string|null
     */
    public static function generate_search_h1_from_link($link, $language = 'ar')
    {
        static $cache = [];
        $language = $language === 'en' ? 'en' : 'ar';
        $path = parse_url($link, PHP_URL_PATH);
        if (!is_string($path)) {
            return null;
        }
        $segments = array_values(array_filter(explode('/', trim($path, '/')), 'strlen'));
        $segments = array_map('rawurldecode', $segments);
        if (isset($segments[0]) && in_array($segments[0], ['ar', 'en', 'fr', 'tr', 'fa', 'pe'], true)) {
            array_shift($segments);
        }
        $projectTypeSlug = isset($segments[0]) ? $segments[0] : 'property-for-sale';
        $citySlug = isset($segments[1]) ? $segments[1] : 'turkey';
        $var1 = isset($segments[2]) ? array_values(array_filter(explode(',', $segments[2]), 'strlen')) : [];
        $var2 = isset($segments[3]) ? array_values(array_filter(explode(',', $segments[3]), 'strlen')) : [];
        $cacheKey = $language . '|' . $projectTypeSlug . '|' . $citySlug . '|' . implode(',', $var1) . '|' . implode(',', $var2);
        if (array_key_exists($cacheKey, $cache)) {
            return $cache[$cacheKey];
        }
        $originalLanguage = \LaravelLocalization::getCurrentLocale();
        \LaravelLocalization::setLocale($language);
        try {
            $projectTypeName = trans('front.aqarat') . ' ' . trans('front.for_sale');
            if ($projectTypeSlug !== 'property-for-sale') {
                $projectType = self::query("ProjectType", "where", [
                    "field" => "slug",
                    "value" => $projectTypeSlug
                ])->first();
                if (!$projectType) {
                    $cache[$cacheKey] = null;
                    return null;
                }
                $projectTypeName = $projectType->getName() . ' ' . trans('front.for_sale');
            }
            $city = self::query("City", "where", [
                "field" => "slug",
                "value" => $citySlug
            ])->first();
            if (!$city) {
                $cache[$cacheKey] = null;
                return null;
            }
            $cityName = $city->getName();
            $categorySlugs = [];
            $regionSlugs = [];
            if (count($var1) > 0) {
                $categoryCheck = self::query("ProjectCategory", "whereIn", [
                    "field" => "slug",
                    "value" => $var1
                ])->get();
                if (count($categoryCheck) > 0) {
                    $categorySlugs = $var1;
                } else {
                    $regionCheck = self::query("Region", "whereIn", [
                        "field" => "slug",
                        "value" => $var1
                    ])->get();
                    if (count($regionCheck) === 0) {
                        $cache[$cacheKey] = null;
                        return null;
                    }
                    $regionSlugs = $var1;
                }
            }
            if (count($var2) > 0) {
                $regionCheck = self::query("Region", "whereIn", [
                    "field" => "slug",
                    "value" => $var2
                ])->get();
                if (count($regionCheck) === 0) {
                    $cache[$cacheKey] = null;
                    return null;
                }
                $regionSlugs = $var2;
            }
            $regionNames = [];
            foreach ($regionSlugs as $regionSlug) {
                $region = self::query("Region", "where", [
                    "field" => "slug",
                    "value" => $regionSlug
                ])->first();
                if (!$region) {
                    $cache[$cacheKey] = null;
                    return null;
                }
                $regionNames[] = $region->getName();
            }
            $categoryNames = [];
            foreach ($categorySlugs as $categorySlug) {
                $category = self::query("ProjectCategory", "where", [
                    "field" => "slug",
                    "value" => $categorySlug
                ])->first();
                if (!$category) {
                    $cache[$cacheKey] = null;
                    return null;
                }
                $categoryNames[] = $category->getName();
            }
            $parts = [
                $projectTypeName,
                $cityName,
                implode(', ', $regionNames),
                implode(', ', $categoryNames)
            ];
            $result = trim(preg_replace('/\s+/u', ' ', implode(' ', array_filter($parts, 'strlen'))));
            $cache[$cacheKey] = $result;
            return $result;
        } finally {
            \LaravelLocalization::setLocale($originalLanguage);
        }
    }
    /**
    * global mobile phone
    *
    * @return void
    */
    public static function mobile_num($num=null, $trim=false)
    {
        if ( !$num ) {
            $infos = self::get_params();
            $num = $infos->tel_1;
        }
        return $num;
    }
    public static function getPub()
    {
		if(!empty(self::$pubs))
			return self::$pubs;
        
		self::$pubs = \App\Models\Pub::orderBy("id", 'asc')->get();
		
		return self::$pubs;
    }
	
	
	
	public static function callback($matches) {
		//print_r($matches);

		if (preg_match('#^https?://(www\.)?damasturk\.com(/.+)?$#i', $matches[1]) and !preg_match('#^https?://(www\.)?damasturk\.com/whats(/.+)?$#i', $matches[1]) and !preg_match('#^https?://(www\.)?damasturk\.com/whatsapp_share(/.+)?$#i', $matches[1])) {
			return $matches[2];
		}else{
			return '<a href="' . $matches[1] . '" target="_blank">' . $matches[2] . '</a>';
		}

		//return '';
		return $matches[2]; // or you can remove only the anchor and print the text only
	}
	public static function add_links_html($html,$current_lang){
		return $html;
		/*
		//remove all internal link
		$pattern = '#<a[^>]*href=[\'"]([^\'"]*)[\'"][^>]*>(((?!<a\s).)*)</a>#i';
		$html = preg_replace_callback($pattern, 'self::callback', $html);
		*/
		//$html = html_entity_decode($html);
		
		if($current_lang=='ar'){
		$arr_regs = [
		'مناطق اسطنبول','منطقة أرناؤوط كوي','منطقة افجلار','منطقة باغجلار','منطقة بهشة ليفلر','منطقة بكر كوي','منطقة باشاك شهير','منطقة بيرم باشا','منطقة بشكتاش','منطقة بيليك دوزو','منطقة بي أوغلو','منطقة بيوك تشك ميجي','منطقة تشالجا','منطقة اسنلر','منطقة اسنيورت','منطقة  السلطان أيوب','منطقة الفاتح','منطقة غازي عثمان باشا','منطقة','منطقة كايت هانه','منطقة كوتشوك تشيكميجي','منطقة سراير','منطقة سيليفري','منطقة سلطان غازي','منطقة  شيشلي','منطقة زيتون بورنو','جزر الاميرات','منطقة أدالار','منطقة أتا شهير','منطقة بيكوز','منطقة تشكمي كوي','منطقة كاديكوي','منطقة كارتال','منطقة مالتبه','منطقة بندك','منطقة سان جاك تيبي','منطقة السلطان بيلي','منطقة شيله','منطقة توزلا','منطقة العمرانية','منطقة اسكودار',
		"داماس تورك العقارية"
		];
		$arr_regs_links = [
		'https://damas.net/istanbul-districts','https://damas.net/istanbul-districts#d1','https://damas.net/istanbul-districts#d2','https://damas.net/istanbul-districts#d3','https://damas.net/istanbul-districts#d4','https://damas.net/istanbul-districts#d5','https://damas.net/istanbul-districts#d6','https://damas.net/istanbul-districts#d7','https://damas.net/istanbul-districts#d8','https://damas.net/istanbul-districts#d9','https://damas.net/istanbul-districts#d10','https://damas.net/istanbul-districts#d11','https://damas.net/istanbul-districts#d12','https://damas.net/istanbul-districts#d13','https://damas.net/istanbul-districts#d14','https://damas.net/istanbul-districts#d15','https://damas.net/istanbul-districts#d16','https://damas.net/istanbul-districts#d17','https://damas.net/istanbul-districts#d18','https://damas.net/istanbul-districts#d19','https://damas.net/istanbul-districts#d20','https://damas.net/istanbul-districts#d21','https://damas.net/istanbul-districts#d22','https://damas.net/istanbul-districts#d23','https://damas.net/istanbul-districts#d24','https://damas.net/istanbul-districts#d25','https://damas.net/istanbul-districts#a1','https://damas.net/istanbul-districts#a1','https://damas.net/istanbul-districts#a2','https://damas.net/istanbul-districts#a3','https://damas.net/istanbul-districts#a4','https://damas.net/istanbul-districts#a5','https://damas.net/istanbul-districts#a6','https://damas.net/istanbul-districts#a7','https://damas.net/istanbul-districts#a8','https://damas.net/istanbul-districts#a9','https://damas.net/istanbul-districts#a10','https://damas.net/istanbul-districts#a11','https://damas.net/istanbul-districts#a12','https://damas.net/istanbul-districts#a13','https://damas.net/istanbul-districts#a14',
		"https://damas.net/"
		];
		
		}else{

		$arr_regs = [
		'Istanbul Districts','Arnavutkoy District','Avcılar District','Bagcılar District','Bahcelievler District','Bakirkoy District','Başakşehir District','Bayrampasa District','Besiktas District','Beylikdüzü District','Beyoglu District','Büyükçekmece District','Catalca District','Esenler District','Esenyurt District','Eyüp Sultan District','Fatih District','Gaziosmanpasa District','Güngören District','Kağıthane District','Küçükçekmece District','Sariyer District','Silivri District','Sultangazi District','Sisli District','Zeytinburnu District','Princesses Islands','Adalar District','Ataşehir District','Beykoz District','Cekmekoy District','Kadıköy District','Kartal District','Maltepe District','Pendik District','Sancaktepe District','Sultanbeyli District','Sile District','Tuzla District','Ümraniye District','Uskudar District',
		];
		$arr_regs_links = [
		'https://damas.net/en/istanbul-districts','https://damas.net/en/istanbul-districts#d1','https://damas.net/en/istanbul-districts#d2','https://damas.net/en/istanbul-districts#d3','https://damas.net/en/istanbul-districts#d4','https://damas.net/en/istanbul-districts#d5','https://damas.net/en/istanbul-districts#d6','https://damas.net/en/istanbul-districts#d7','https://damas.net/en/istanbul-districts#d8','https://damas.net/en/istanbul-districts#d9','https://damas.net/en/istanbul-districts#d10','https://damas.net/en/istanbul-districts#d11','https://damas.net/en/istanbul-districts#d12','https://damas.net/en/istanbul-districts#d13','https://damas.net/en/istanbul-districts#d14','https://damas.net/en/istanbul-districts#d15','https://damas.net/en/istanbul-districts#d16','https://damas.net/en/istanbul-districts#d17','https://damas.net/en/istanbul-districts#d18','https://damas.net/en/istanbul-districts#d19','https://damas.net/en/istanbul-districts#d20','https://damas.net/en/istanbul-districts#d21','https://damas.net/en/istanbul-districts#d22','https://damas.net/en/istanbul-districts#d23','https://damas.net/en/istanbul-districts#d24','https://damas.net/en/istanbul-districts#d25','https://damas.net/en/istanbul-districts#a1','https://damas.net/en/istanbul-districts#a1','https://damas.net/en/istanbul-districts#a2','https://damas.net/en/istanbul-districts#a3','https://damas.net/en/istanbul-districts#a4','https://damas.net/en/istanbul-districts#a5','https://damas.net/en/istanbul-districts#a6','https://damas.net/en/istanbul-districts#a7','https://damas.net/en/istanbul-districts#a8','https://damas.net/en/istanbul-districts#a9','https://damas.net/en/istanbul-districts#a10','https://damas.net/en/istanbul-districts#a11','https://damas.net/en/istanbul-districts#a12','https://damas.net/en/istanbul-districts#a13','https://damas.net/en/istanbul-districts#a14'
		];
		}
		$html = str_replace(htmlentities('الجنسية التركية'), '<a href="' . route("front.turkish_citizenship") . '" target="_blank">الجنسية التركية</a>', $html);
		
		for($i=0;$i<count($arr_regs);$i++){
			$html = str_replace($arr_regs[$i],'<a href="'.$arr_regs_links[$i].'">'.$arr_regs[$i].'</a>',$html);
		}
		
		
		
		return $html;
	}
	public static function  GnerateLnk($project_type_slg,$project_type_nme, $city_slg,$city_nme, $project_categories_slg ,$regions_slg){
		
		if($city_slg=='turkey')
		$city_slg = '';
		$arrlink = [];

		if($project_categories_slg==''){
		
		
		if($project_type_slg == ''  && $city_slg == ''  && $regions_slg==''/*&& $project_categories_slg == ''*/){
			$cities = Helper::query("City", "all");
			foreach($cities as $c){
				if($c->id!=2)
				$arrlink[] = '<li><a href="'. route('front.search',['property-for-sale',$c->slug]) .'">'. $c->getName() .'</a></li>';
			}
			return implode('',$arrlink);
		
		}/*elseif($project_type_slg != ''  && $city_slg == ''  && $regions_slg==''){
			$ptyp = Helper::query("ProjectType", "all");
			foreach($ptyp as $c){
				$arrlink[] = '<li><a href="'. route('front.search',[$c->slug,'turkey']) .'">'. $c->getName() .'</a></li>';
			}
			return implode('',$arrlink);
			
		}*/
		elseif(($project_type_slg != ''  && $city_slg == '')  /*&& $regions_slg==''*/){
			$cities = Helper::query("City", "all");
			//exit();
			$Rproject_type = Helper::query("ProjectType", "where", ["field" => "slug", "value" => $project_type_slg])->first();
			
			$ptyps = DB::select("SELECT distinct(dms_projects.city_id) FROM `dms_projects`,dms_project_type
			WHERE dms_projects.id=dms_project_type.project_id and dms_project_type.project_type_id=?  and dms_projects.published=1 and dms_projects.sold != 100",array($Rproject_type->id));//.*
			
			$arr_ids = [];
			foreach($ptyps as $r)
			$arr_ids[] = $r->city_id;
			
			foreach($cities as $c){
				if($c->id!=2 and in_array($c->id,$arr_ids))
				$arrlink[] = '<li><a class="ptcity" href="'. route('front.search',[$project_type_slg,$c->slug]) .'">' . $project_type_nme .' '. $c->getName() .'</a></li>';
			}
			return implode('',$arrlink);
			
		}elseif($project_type_slg == ''  && $city_slg != ''  /*&& $regions_slg==''*/){
			
			$Rcity = Helper::query("City", "where", ["field" => "slug", "value" => $city_slg])->first();
			$ptyps = DB::select("SELECT distinct(dms_project_type.project_type_id) 
			FROM `dms_projects`,dms_project_type
			WHERE dms_projects.id=dms_project_type.project_id and dms_projects.city_id=?  and dms_projects.published=1 and dms_projects.sold != 100",array($Rcity->id));//.*
			
			$arr_ids = [];
			foreach($ptyps as $r)
			$arr_ids[] = $r->project_type_id;
			
			$ptyp = Helper::query("ProjectType", "all");
			foreach($ptyp as $c){
				if(in_array($c->id,$arr_ids))
				$arrlink[] = '<li><a class="pts" href="'. route('front.search',[$c->slug,$city_slg]) .'">'. $c->getName() .' '. $city_nme .'</a></li>';
			}
			return implode('',$arrlink);
		}
		}
		$conds = [];
		if($project_type_slg!=''){
			$Rproject_type = Helper::query("ProjectType", "where", ["field" => "slug", "value" => $project_type_slg])->first();
			$conds[] = $Rproject_type->id;
		}
		if($city_slg!=''){
			$Rcity = Helper::query("City", "where", ["field" => "slug", "value" => $city_slg])->first();
			$conds[] = $Rcity->id;
		}
		/*echo ("SELECT distinct(dms_project_category.`project_category_id`) 
		FROM `dms_project_category` ,dms_projects,dms_project_type
		WHERE 
		`dms_project_category`.`project_id`=dms_projects.id
		and dms_projects.id=dms_project_type.project_id "
		. ($project_type_slg!=''?" and dms_project_type.project_type_id=?":'')
		. ($city_slg!=''?" and dms_projects.city_id=?":''));
		exit;*/
		$ptyps= DB::select("SELECT distinct(dms_project_category.`project_category_id`) 
		FROM `dms_project_category` ,dms_projects,dms_project_type
		WHERE 
		`dms_project_category`.`project_id`=dms_projects.id
		and dms_projects.id=dms_project_type.project_id and dms_projects.published=1 and dms_projects.sold != 100"
		. ($project_type_slg!=''?" and dms_project_type.project_type_id=?":'')
		. ($city_slg!=''?" and dms_projects.city_id=?":'')
		,
		$conds);
		
		$arr_ids = [];
		foreach($ptyps as $r)
			$arr_ids[] = $r->project_category_id;
		
		
		
		$pcats = Helper::query("ProjectCategory", "all");
		
		$activea='';
		foreach($pcats as $c){
			if($c->hide_search_page==0 && in_array($c->id,$arr_ids)){
			$url = route("front.search")."/".($project_type_slg==''?'property-for-sale':$project_type_slg)."/".($city_slg==''?'turkey':$city_slg)."/".$c->slug;
			
			if( $project_categories_slg==$c->slug )
				$activea = '<li class="active"><a href="'. $url .'">'. $c->getName() .'</a></li>';
			else
				$arrlink[] = '<li><a href="'. $url .'">'. $c->getName() .'</a></li>';
			}
		}
		
		if($activea!='')
			array_unshift($arrlink, $activea);
		
		return implode('',$arrlink);
	
	}
	public static function  parse_statistcics($Rregion,$type) {
		if($Rregion){
		switch($type){
			case 'demographique':
				$arr = json_decode($Rregion->demographics, true);
				/*echo '<pre>';
				print_r($arr);
				echo '</pre>';*/
				//exit;
			break;
			case 'abc':
			
			break;
		}
		return $arr;
		}
	}
	public static function timecrypt($str,$decrypt=false){
		$arr1 = ['i','z','e','n','t','x','y'];
		$arr2 = ['2','0','9','7','5','8','1'];
		
		if($decrypt==false){
			return str_replace($arr2,$arr1,$str);
		}else{
			return str_replace($arr1,$arr2,$str);
		}
		
	}
	public static function  unique_multidim_array($array, $key) { 
    $temp_array = array(); 
    $i = 0; 
    $key_array = array(); 
    
    foreach($array as $val) { 
        if (!in_array($val->label, $key_array)) { 
            $key_array[$i] = $val->label; 
            $temp_array[$i] = $val; 
        }
        $i++; 
    }
	
	/*echo '<pre>';
	print_r($temp_array);
	echo '</pre>';
	exit;*/
    return $temp_array; 
	} 
	public static function whatsapp_share($num=null,$whatsapp_text='')
	{
		/*$whatsapp_num = self::mobile_num($num);
		$whatsapp_num = str_replace(" ", "", $whatsapp_num);
		$whatsapp_text = urlencode(Request::url()) . "\r\n\r\n" . $whatsapp_text;		
		return "https://api.whatsapp.com/send?phone=$whatsapp_num&text=$whatsapp_text";*/
		return route("front.whatsapp_share");
	}
    
    /**
    * is mobile
    *
    * @return void
    */
    public static function is_mobile()
    {
        /*$agent = new Agent();
        return $agent->isMobile();*/
		return self::get_device()!='full'?true:false;
    }
    /**
    * is tablet
    *
    * @return void
    */
    public static function is_tablet()
    {
        $agent = new Agent();
        return $agent->isTablet();
    }
    public static function extract_intro_proj($txt,$nbre)
    {
		if(strlen($txt)>$nbre){
		//$txt = substr($txt,0,$nbre);
		for($i=$nbre;$i<strlen($txt);$i++){
			if($txt[$i]==' '){
				$txt = substr($txt,0,$i);
				break;
				}
		}
		
		}
		return $txt.'..';
    }
    public static function get_device($truedevice=false)
    {
		if(isset($_GET['device']) and in_array($_GET['device'],array('mob','full','tab')) and $truedevice==false)
			return $_GET['device'];
		
		if(!empty(self::$device))
			return self::$device;
		
        $agent = new Agent();
        if($agent->isTablet()){
			self::$device = 'tab';
			return 'tab';
		}
		elseif($agent->isMobile()){
			self::$device = 'mob';
			return 'mob';
		}
		else{
			self::$device = 'full';
			return 'full';
		}
    }
    
    /**
    * decimal format
    *
    * @param decimal $nbre
    * @return void
    */
    public static function curr_format($format='')
    {
		
		if($format==''){
		if(session()->get("currency")=='')
			return '₺';
		else{
			if(session()->get("currency")=='USD')
				return '$';
			elseif(session()->get("currency")=='EUR')
				return '€';
			elseif(session()->get("currency")=='GBP')
				return '£';
			elseif(session()->get("currency")=='TRY')
				return '₺';
			else
				return session()->get("currency");
		}
		}else{
			if($format=='USD')
				return '$';
			elseif($format=='EUR')
				return '€';
			elseif($format=='SAR')
				return 'SA';
			elseif($format=='TRY')
				return '₺';
			else
				return $format;
		}
	}
    public static function get_list_prices($format){
		$arr_prices = [
				"50000-100000"      =>  Helper::usd_to_format("50K $",$format)." - ".Helper::usd_to_format("100K $",$format),
				"100000-150000"     =>  Helper::usd_to_format("100K $",$format)." - ".Helper::usd_to_format("150K $",$format),
				"150000-250000"     =>  Helper::usd_to_format("150K $",$format)." - ".Helper::usd_to_format("250K $",$format),
				"250000-400000"     =>  Helper::usd_to_format("250K $",$format)." - ".Helper::usd_to_format("400K $",$format),
				"400000-600000"     =>  Helper::usd_to_format("400K $",$format)." - ".Helper::usd_to_format("600K $",$format),
				"600000-1000000"    =>  Helper::usd_to_format("600K $",$format)." - ".Helper::usd_to_format("1M $",$format),
				"1000000-2000000"   =>  Helper::usd_to_format("1M $",$format)." - ".Helper::usd_to_format("2M $",$format),
				"2000000-+"          =>  '+'.Helper::usd_to_format("2M $",$format),
			];
		return $arr_prices;
	}
    public static function to_usd_format($ex,$nbre,$current_format){
		
		
		$nbre = $nbre/(float)$ex[$current_format];
		if(isset($ex['USD'])){
			$nbre = $nbre*(float)$ex['USD'];
		}
		return round($nbre);
		
	}
    public static function usd_to_format_KM($nbre,$hide_format=false){
		return str_replace(['.000.000','.000'],['M','K'],self::usd_to_format($nbre,'',$hide_format));
	}
    public static function usd_to_format($nbre,$format='',$hide_format=false,$convert000=true){
		
		
		if($format==''){
		if(session()->get("currency")=='USD'){
			if($hide_format==false)
				return $nbre;
			else
				return str_replace(' $','',$nbre);
		}else{
			
			$nbre = (int)str_replace(array(' $','+','K','M'), array('','','000','000000'), $nbre);
			
			
			if(session()->get("currency")=='')
				$to_curr = 'TRY';
			else
				$to_curr = session()->get("currency");
			
			$infos = self::get_params();
			$ex = unserialize($infos->exchange);

			$nbre = $nbre/(float)$ex['USD'];
			
			if(isset($ex[$to_curr])){
				$nbre = round($nbre*(float)$ex[$to_curr], -3);
			}
			return /*self::str_lreplace('.000', 'K',*/ self::custom_number_format($nbre) /*)*/ . ($hide_format==true?'':' '. self::curr_format());
		}
		}else{
			if($format=='USD'){
			return $nbre;
			}else{
				
			$nbre = (int)str_replace(array(' $','+','K','M'), array('','','000','000000'), $nbre);
			
			
			$to_curr = $format;
			
			$infos = self::get_params();
			$ex = unserialize($infos->exchange);

			$nbre = $nbre/(float)$ex['USD'];
			
			if(isset($ex[$to_curr])){
				$nbre = round($nbre*(float)$ex[$to_curr], -3);
			}
			if($convert000==false)
				return $nbre;
			else
				return /*self::str_lreplace('.000', 'K',*/ self::custom_number_format($nbre , 0, ',', '.')/*)*/ .($hide_format==true?'':' '. self::curr_format($format));
			}
		}
	}
	public static function custom_number_format($n) {
    if ($n < 1000) {
        $n_format = number_format($n);
    } else if ($n < 1000000) {
        $n_format = number_format($n / 1000, 1) . 'K';
    } else if ($n < 1000000000) {
        $n_format = number_format($n / 1000000, 1) . 'M';
    } else {
        $n_format = number_format($n / 1000000000, 1) . 'B';
    }
	$n_format = str_replace('.0','',$n_format);
	return $n_format;
}
	public static function str_lreplace($search, $replace, $subject)
{
    $pos = strrpos($subject, $search);

    if($pos !== false)
    {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }

    return $subject;
	}

	public static function decimal_format($nbre, $is_usd=0)
    {
        //if ( is_numeric($nbre) )
            //$nbre =  number_format($nbre, 0);
        $nbre = (float)str_replace(',', '.', $nbre);
		
		
		if($is_usd==1){//price is usd so convert to TRY
			$infos = self::get_params();
			$ex = unserialize($infos->exchange);
			$nbre = $nbre/(float)$ex['USD'];
			 //$nbre = 1;
		}elseif($is_usd==2){//price is eur so convert to TRY
			$infos = self::get_params();
			$ex = unserialize($infos->exchange);
			$nbre = $nbre/(float)$ex['EUR'];
			 //$nbre = 2;
		}elseif($is_usd==3){//OMR
		    $infos = self::get_params();
			$ex = unserialize($infos->exchange);
			$nbre = $nbre/(float)$ex['OMR'];
		    
		}
		
		
		
		
		if(session()->get("currency")=='' or session()->get("currency")=='TRY'){
			return '<span>'.self::str_replace_first('.','</span>.',number_format(round($nbre,-2) , 0, ',', '.'));
		}else{
			if(!isset($ex)){
			$infos = self::get_params();
			$ex = unserialize($infos->exchange);
			}
			
			if(isset($ex[session()->get("currency")])){
				$nbre = round($nbre*(float)$ex[session()->get("currency")], -2);
			}
			
			return '<span>'.self::str_replace_first('.','</span>.',number_format($nbre , 0, ',', '.'));
		}
    }
	
	
	/**
    * clean_navigation
    *
    * @return void
    */
    public static function clean_navigation($nav)
	{
		if($nav!=''){
			$navs = explode('>>',$nav);
			$arr=[];
			foreach($navs as $n){
				$n = trim($n);
				if (
					strpos($n, '/fonts') !== false or 
					strpos($n, '/Ryl') !== false or 
					strpos($n, '/newsletter') !== false or 
					strpos($n, '/like') !== false or 
					/*strpos($n, '/whatsapp_share') !== false or */
					strpos($n, 'loadmore') !== false or 
					strpos($n, 'ajax/') !== false or 
					/*strpos($n, 'confirmation') !== false or */
					strpos($n, 'callus') !== false or
					strpos($n, 'call_us') !== false or 
					strpos($n, 'uploads/') !== false or
					strpos($n, '.css') !== false or
					strpos($n, '.js') !== false or
					strpos($n, '/img/') !== false or
					strpos($n, '.svg') !== false or
					strpos($n, '.jpg') !== false or
					strpos($n, '.png') !== false or
					strpos($n, '.jpeg') !== false or
					strpos($n, 'callus2') !== false or
					strpos($n, 'call_us2') !== false
					) {
				}else{
					$arr[] = str_replace(['https://','http://','www.','https://www-damas-net.cdn.ampproject.org/v/s/'],'',$n);
				}
			}
			return implode('>>',$arr);
		}
		return '';
	}
	/**
    * str replace first
    *
    * @return void
    */
    public static function str_replace_first($from, $to, $content)
	{
		$from = '/'.preg_quote($from, '/').'/';

		return preg_replace($from, $to, $content, 1);
	}
	
	/*public static function convert_statc_json($json,$static_curr){
		$json = json_decode($json, true);
		if($json['datapairs']==null or empty($json)){
			return array();
		}else{
			
		}
	}*/
	
	public static function merge_calc_avg($json1,$json2,$static_curr){
		
		$json1 = json_decode($json1, true);
		$json2 = json_decode($json2, true);

		/*echo '<pre>';
		print_r($json1);
		echo '</pre><br>######################################################<br>######################################################<br>######################################################';
		
		echo '<pre>';
		print_r($json2);
		echo '</pre><br>######################################################<br>######################################################<br>######################################################';
		*/
		
		if($json1['datapairs']==null or empty($json1)){
			$json1 = '';
		}
		if($json2['datapairs']==null or empty($json2)){
			$json2 = '';
		}

		if($json1 !='' and $json2 !='' ){
			$json = array();
			foreach($json1['datapairs'] as $r1){
				foreach($json2['datapairs'] as $r2){
					if($r1['date'] == $r2['date']){
						

						if($year!=0){ //filter date if not global 0
							if(str_replace($year,'',$r1['date'])==$r1['date'])
								continue;
						}
						$arr = array();
						$arr['date'] = $r1['date'];
						
						if($r1[$static_curr]=='')
							$arr['cur_cur'] = $r2[$static_curr];
						elseif($r2[$static_curr]=='')
							$arr['cur_cur'] = $r1[$static_curr];
						else
							$arr['cur_cur'] = ($r1[$static_curr]+$r2[$static_curr])/2;

						/*if($r1['eur']=='')
							$arr['eur'] = $r2['eur'];
						elseif($r2['eur']=='')
							$arr['eur'] = $r1['eur'];
						else
							$arr['eur'] = ($r1['eur']+$r2['eur'])/2;
						
						if($r1['usd']=='')
							$arr['usd'] = $r2['usd'];
						elseif($r2['usd']=='')
							$arr['usd'] = $r1['usd'];
						else
							$arr['usd'] = ($r1['usd']+$r2['usd'])/2;
						
						if($r1['pnd']=='')
							$arr['pnd'] = $r2['pnd'];
						elseif($r2['pnd']=='')
							$arr['pnd'] = $r1['pnd'];
						else
							$arr['pnd'] = ($r1['pnd']+$r2['pnd'])/2;*/
						
						
						$json[] = $arr;
						//$json['data'][] = $arr;
						break;
					}
				}
			}
			/*echo '<pre>';
			print_r($json);
			echo '</pre>';
			exit;*/
			return $json;
			/**/
			
		}elseif($json1 !=''){
			return self::json_currency($json1,$static_curr,$year);
		}elseif($json2 !=''){
			return self::json_currency($json2,$static_curr,$year);
		}
		//exit();
		
	}
	public static function code_to_country( $code, $returnarray=true ){

    $code = strtoupper(trim($code));

    $countryList = array(
	'TR'=>'Turkey','IR'=>'Iran','SY'=>'Syria','EG'=>'Egypt','PS'=>'Palestine','IQ'=>'Iraq','JO'=>'Jordan','DZ'=>'Algeria','TN'=>'Tunisia','YE'=>'Yemen','MA'=>'Morocco','AF'=>'Afghanistan','AX'=>'Aland Islands','AL'=>'Albania','AS'=>'American Samoa','AD'=>'Andorra','AO'=>'Angola','AI'=>'Anguilla','AQ'=>'Antarctica','AG'=>'Antigua and Barbuda','AR'=>'Argentina','AM'=>'Armenia','AW'=>'Aruba','AU'=>'Australia','AT'=>'Austria','AZ'=>'Azerbaijan','BS'=>'Bahamas the','BH'=>'Bahrain','BD'=>'Bangladesh','BB'=>'Barbados','BY'=>'Belarus','BE'=>'Belgium','BZ'=>'Belize','BJ'=>'Benin','BM'=>'Bermuda','BT'=>'Bhutan','BO'=>'Bolivia','BA'=>'Bosnia and Herzegovina','BW'=>'Botswana','BV'=>'Bouvet Island (Bouvetoya)','BR'=>'Brazil','IO'=>'British Indian Ocean Territory (Chagos Archipelago)','VG'=>'British Virgin Islands','BN'=>'Brunei Darussalam','BG'=>'Bulgaria','BF'=>'Burkina Faso','BI'=>'Burundi','KH'=>'Cambodia','CM'=>'Cameroon','CA'=>'Canada','CV'=>'Cape Verde','KY'=>'Cayman Islands','CF'=>'Central African','TD'=>'Chad','CL'=>'Chile','CN'=>'China','CX'=>'Christmas Island','CC'=>'Cocos (Keeling) Islands','CO'=>'Colombia','KM'=>'Comoros the','CD'=>'Congo','CG'=>'Congo the','CK'=>'Cook Islands','CR'=>'Costa Rica','CI'=>'Cote d\'Ivoire','HR'=>'Croatia','CU'=>'Cuba','CY'=>'Cyprus','CZ'=>'Czech','DK'=>'Denmark','DJ'=>'Djibouti','DM'=>'Dominica','DO'=>'Dominican','EC'=>'Ecuador','SV'=>'El Salvador','GQ'=>'Equatorial Guinea','ER'=>'Eritrea','EE'=>'Estonia','ET'=>'Ethiopia','FO'=>'Faroe Islands','FK'=>'Falkland Islands (Malvinas)','FJ'=>'Fiji the Fiji Islands','FI'=>'Finland','FR'=>'France','GF'=>'French Guiana','PF'=>'French Polynesia','TF'=>'French Southern Territories','GA'=>'Gabon','GM'=>'Gambia the','GE'=>'Georgia','DE'=>'Germany','GH'=>'Ghana','GI'=>'Gibraltar','GR'=>'Greece','GL'=>'Greenland','GD'=>'Grenada','GP'=>'Guadeloupe','GU'=>'Guam','GT'=>'Guatemala','GG'=>'Guernsey','GN'=>'Guinea','GW'=>'Guinea-Bissau','GY'=>'Guyana','HT'=>'Haiti','HM'=>'Heard Island and McDonald Islands','VA'=>'Holy See (Vatican City State)','HN'=>'Honduras','HK'=>'Hong Kong','HU'=>'Hungary','IS'=>'Iceland','IN'=>'India','ID'=>'Indonesia','IE'=>'Ireland','IM'=>'Isle of Man','IL'=>'Israel','IT'=>'Italy','JM'=>'Jamaica','JP'=>'Japan','JE'=>'Jersey','KZ'=>'Kazakhstan','KE'=>'Kenya','KI'=>'Kiribati','KP'=>'Korea','KR'=>'Korea','KW'=>'Kuwait','KG'=>'Kyrgyz','LA'=>'Lao','LV'=>'Latvia','LB'=>'Lebanon','LS'=>'Lesotho','LR'=>'Liberia','LY'=>'Libyan','LI'=>'Liechtenstein','LT'=>'Lithuania','LU'=>'Luxembourg','MO'=>'Macao','MK'=>'Macedonia','MG'=>'Madagascar','MW'=>'Malawi','MY'=>'Malaysia','MV'=>'Maldives','ML'=>'Mali','MT'=>'Malta','MH'=>'Marshall Islands','MQ'=>'Martinique','MR'=>'Mauritania','MU'=>'Mauritius','YT'=>'Mayotte','MX'=>'Mexico','FM'=>'Micronesia','MD'=>'Moldova','MC'=>'Monaco','MN'=>'Mongolia','ME'=>'Montenegro','MS'=>'Montserrat','MZ'=>'Mozambique','MM'=>'Myanmar','NA'=>'Namibia','NR'=>'Nauru','NP'=>'Nepal','AN'=>'Netherlands Antilles','NL'=>'Netherlands','NC'=>'New Caledonia','NZ'=>'New Zealand','NI'=>'Nicaragua','NE'=>'Niger','NG'=>'Nigeria','NU'=>'Niue','NF'=>'Norfolk Island','MP'=>'Northern Mariana Islands','NO'=>'Norway','OM'=>'Oman','PK'=>'Pakistan','PW'=>'Palau','PA'=>'Panama','PG'=>'Papua New Guinea','PY'=>'Paraguay','PE'=>'Peru','PH'=>'Philippines','PN'=>'Pitcairn Islands','PL'=>'Poland','PT'=>'Portugal','PR'=>'Puerto Rico','QA'=>'Qatar','RE'=>'Reunion','RO'=>'Romania','RU'=>'Russia','RW'=>'Rwanda','BL'=>'Saint Barthelemy','SH'=>'Saint Helena','KN'=>'Saint Kitts and Nevis','LC'=>'Saint Lucia','MF'=>'Saint Martin','PM'=>'Saint Pierre and Miquelon','VC'=>'Saint Vincent and the Grenadines','WS'=>'Samoa','SM'=>'San Marino','ST'=>'Sao Tome and Principe','SA'=>'Saudi Arabia','SN'=>'Senegal','RS'=>'Serbia','SC'=>'Seychelles','SL'=>'Sierra Leone','SG'=>'Singapore','SK'=>'Slovakia (Slovak Republic)','SI'=>'Slovenia','SB'=>'Solomon Islands','SO'=>'Somalia','ZA'=>'South Africa','GS'=>'South Georgia and the South Sandwich Islands','ES'=>'Spain','LK'=>'Sri Lanka','SD'=>'Sudan','SR'=>'Suriname','SJ'=>'Svalbard & Jan Mayen Islands','SZ'=>'Swaziland','SE'=>'Sweden','CH'=>'Switzerland','TW'=>'Taiwan','TJ'=>'Tajikistan','TZ'=>'Tanzania','TH'=>'Thailand','TL'=>'Timor-Leste','TG'=>'Togo','TK'=>'Tokelau','TO'=>'Tonga','TT'=>'Trinidad and Tobago','TM'=>'Turkmenistan','TC'=>'Turks and Caicos Islands','TV'=>'Tuvalu','UG'=>'Uganda','UA'=>'Ukraine','AE'=>'Emirates','GB'=>'UK','US'=>'USA','UM'=>'United States Minor Outlying Islands','VI'=>'United States Virgin Islands','UY'=>'Uruguay, Eastern Republic of','UZ'=>'Uzbekistan','VU'=>'Vanuatu','VE'=>'Venezuela','VN'=>'Vietnam','WF'=>'Wallis and Futuna','EH'=>'Western Sahara','ZM'=>'Zambia','ZW'=>'Zimbabwe' );
	
	if($code == ''  and $returnarray==true )
		return $countryList;

    if( !isset($countryList[$code])) 
		return $code;
    else 
		return $countryList[$code];
    
	}
	
	public static function getCityName($projects_count,$i){
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());		
		$field = 'name_'.$lang;
		
		return $projects_count[$i]->$field;
	}
	public static function json_currency($json,$static_curr,$year,$month){
		$data = array();
		if(!is_array($json))
			$json = json_decode($json,true);
		
		if(isset($json['datapairs']) and $json['datapairs']!=null){
			$x = 0;
		foreach($json['datapairs'] as $r){
			$x++;
			list($m,$y) = self::get_ex_month($r['date']);
			//echo $m.','.$y.' | '.$r['date'] . "\n";
			//exit;
			if($year!=0){ //filter date if not global 0
				if($year!=$y)
					continue;
			}
			if($month!=0){ //filter date if not global 0
				if($month!=$m)
					continue;
					
			}
			if($r[$static_curr]==null)//filter null val
				continue;
			
			if($year==0 and $month==0 and $x%2==0 ){// سيتم عرض ذاتا كثيرة لذلك سنخفضها الى النصف
				continue;
			}
			
			
			$arr = array();
			$arr['cur_cur'] = $r[$static_curr];
			$arr['date'] = $r['date'];
			$data[] = $arr;
			
		}
		}
		//exit;
	return $data;
	}
	
	public static function get_ex_month($date){
		$t = explode(' ',$date);//May 2015
		$arr = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
		$year = @$t[1];
		$month = array_search(strtolower(@$t[0]), $arr) + 1;
		return array($month,$year);
	}
    /**
    * rates exchange
    *
    * @return void
    */
    public static function rates_exchange()
    {
        //$json = @file_get_contents('https://api.fixer.io/latest?base=TRY');
        $json = file_get_contents('http://api.exchangeratesapi.io/v1/latest?access_key=1107883f2fdba1bf89e09b861423c3ad');
		
        $obj = json_decode($json, true);
        if(@$obj['success']=='true'){
			

			$val_USD = $obj['rates']['USD']/$obj['rates']['TRY'];
			$val_EUR = $obj['rates']['USD']/$obj['rates']['EUR'];

			
			/*$price = 50000;//try
			echo $price.' TRY<br>';
			echo $price*$val_USD.' $<br>';
			echo $price*$val_EUR.' Eur<br>';
			exit;*/
			
			
		
		
		$value = $val_USD;
        if ( $value != '') {
            ProjectFlavor::whereNotNull("price")
                ->where("rates_exchange", 1)
                ->update(["price_usd" => DB::raw("ROUND(price*$value, -3)")]);
            
			
			foreach(Helper::query("ProjectType", "all") as $typ){
				\App\Models\ProjectDetail::whereNotNull("pm".$typ->id)
					->where("is_price_usd", 0)
					->update(["pm".$typ->id."_usd" => DB::raw("ROUND(pm".$typ->id."*$value, 0)")]);
			}
        }
		
		
        /*$json = file_get_contents('http://api.exchangeratesapi.io/v1/latest?access_key=1107883f2fdba1bf89e09b861423c3ad&base=EUR');
        $obj = json_decode($json, true);*/
        $value = $val_EUR;
        if ( $value != '') {
            ProjectFlavor::whereNotNull("price")
                ->where("rates_exchange", 2)
                ->update(["price_usd" => DB::raw("ROUND(price*$value, -3)")]);
				
			foreach(Helper::query("ProjectType", "all") as $typ){
				\App\Models\ProjectDetail::whereNotNull("pm".$typ->id)
					->where("is_price_usd", 2)
					->update(["pm".$typ->id."_usd" => DB::raw("ROUND(pm".$typ->id."*$value, 0)")]);
			}
        }
		
		
		}
		
		
    }
	
	public static function get_set_project_youtube_video_statistcis($ids){
		exit;
		if(trim($ids)=='')
			return false;
				
				$arrvideos = explode(',',$ids);
				$arrvids = [];
				foreach($arrvideos as $ytb){
					//echo $ytb.'<br>';
					parse_str( parse_url( $ytb, PHP_URL_QUERY ), $my_array_of_vars );
					if(isset($my_array_of_vars['v']))
						$arrvids[] = $my_array_of_vars['v'];
				}
				$ids = implode(',',$arrvids);

				$json = file_get_contents('https://www.googleapis.com/youtube/v3/videos?part=statistics,snippet&id='.$ids.'&key=AIzaSyAo7CUEF4x6b3c_bXlGTIkoe0BvS3iGDIo');
				$jsonData = json_decode($json);
				
			for($i=0;$i<count($jsonData->items);$i++){
				$vid = $jsonData->items[$i]->id;
				$views = $jsonData->items[$i]->statistics->viewCount;
				$likes = $jsonData->items[$i]->statistics->likeCount;

				$title = $jsonData->items[$i]->snippet->title;

				$pic = $jsonData->items[$i]->snippet->thumbnails->medium->url;

				$date_published = substr($jsonData->items[$i]->snippet->publishedAt, 0, 10);
				
				
				
				
				
				$projects = DB::select("SELECT `id`,`linkvideo_ar` FROM `dms_projects` WHERE `linkvideo_ar` like '%$vid%'");
				$arr_ids = [];
				foreach($projects as $prid)
					$arr_ids[] = $prid->id;
				if(!empty($arr_ids)){
					$str_ids = implode(',',$arr_ids);
					DB::update("UPDATE `dms_projects_details` SET `ytb_likes_ar`=?,`ytb_views_ar`=? WHERE `project_id` in (".$str_ids.")",[$likes,$views]);
				}
				
				$projects = DB::select("SELECT `id`,`linkvideo_fr` FROM `dms_projects` WHERE `linkvideo_fr` like '%$vid%'");
				$arr_ids = [];
				foreach($projects as $prid)
					$arr_ids[] = $prid->id;
				if(!empty($arr_ids)){
					$str_ids = implode(',',$arr_ids);
					DB::update("UPDATE `dms_projects_details` SET `ytb_likes_fr`=?,`ytb_views_fr`=? WHERE `project_id` in (".$str_ids.")",[$likes,$views]);
				}
				
				$projects = DB::select("SELECT `id`,`linkvideo_en` FROM `dms_projects` WHERE `linkvideo_en` like '%$vid%'");
				$arr_ids = [];
				foreach($projects as $prid)
					$arr_ids[] = $prid->id;
				if(!empty($arr_ids)){
					$str_ids = implode(',',$arr_ids);
					DB::update("UPDATE `dms_projects_details` SET `ytb_likes_en`=?,`ytb_views_en`=? WHERE `project_id` in (".$str_ids.")",[$likes,$views]);
				}
				
				$projects = DB::select("SELECT `id`,`linkvideo_fa` FROM `dms_projects` WHERE `linkvideo_fa` like '%$vid%'");
				$arr_ids = [];
				foreach($projects as $prid)
					$arr_ids[] = $prid->id;
				if(!empty($arr_ids)){
					$str_ids = implode(',',$arr_ids);
					DB::update("UPDATE `dms_projects_details` SET `ytb_likes_fa`=?,`ytb_views_fa`=? WHERE `project_id` in (".$str_ids.")",[$likes,$views]);
				}
				
				
				
				
				/*
				$inputs = [];
				if(\App\Models\ProjectDetail::where("project_id",$project->id )->first()==false){
					$inputs["project_id"] = $project->id;
					Helper::query("ProjectDetail", "save", [
						"inputs"    =>  $inputs,
						"project_id" => 
					]);
				}*/
				//else
				//	DB::update("update `id`,`linkvideo_ar`,`linkvideo_fa`,`linkvideo_en`,`linkvideo_fr` FROM `dms_projects` WHERE `linkvideo_ar` like '%$vid%' or `linkvideo_fa` =? or `linkvideo_en` =? or `linkvideo_fr` =?");


			}
	}
    /**
    * rates exchange
    *
    * @return void
    */
    public static function update_youtube_video_statistcis()
    {//not used anywere
		$todays = (int) date('d');
		//if($todays%2!=0){
			$videos = DB::table('crm_videos')->where('video','like','%youtube%')->limit(20)->orderBy('id','desc')->get();

			foreach($videos as $v){
				parse_str( parse_url( $v->video, PHP_URL_QUERY ), $my_array_of_vars );
				$id = $my_array_of_vars['v'];

				$json = file_get_contents('https://www.googleapis.com/youtube/v3/videos?part=contentDetails,statistics,snippet&id='.$id.'&key=AIzaSyAo7CUEF4x6b3c_bXlGTIkoe0BvS3iGDIo');
				$jsonData = json_decode($json);

				$duration = $jsonData->items[0]->contentDetails->duration;
				$views = $jsonData->items[0]->statistics->viewCount;
				$likes = $jsonData->items[0]->statistics->likeCount;

				$title = $jsonData->items[0]->snippet->title;

				$pic = $jsonData->items[0]->snippet->thumbnails->medium->url;

				$date_published = substr($jsonData->items[0]->snippet->publishedAt, 0, 10);
				
				DB::table('crm_videos')->where('id',$v->id)->update(
					[
						'date_published' => $date_published,
						'views' => $views,
						'likes' => $likes,
						'pic' => $pic,
						'title' => $title,
						'duration' => $duration
					]);
			}
		/*}else{
			
		// add all projectdetail
		$pojids = DB::select("SELECT dms_projects.id 
				FROM `dms_projects` 
				left join dms_projects_details on dms_projects_details.project_id=dms_projects.id
				WHERE project_id is null");
				
				foreach($pojids as $pid){
					$inputs = ['project_id'=>$pid->id];
					Helper::query("ProjectDetail", "save", [
						"inputs"    =>  $inputs
					]);
				}
		//  end add all projectdetail 
			
			
			$projs = DB::select("SELECT `id`,`linkvideo_ar`,`linkvideo_fa`,`linkvideo_en`,`linkvideo_fr` FROM `dms_projects` WHERE `linkvideo_ar` !='' or `linkvideo_fa` !='' or `linkvideo_en` !='' or `linkvideo_fr` !=''");

			$ytbs = [];
			foreach($projs as $y){
				if($y->linkvideo_ar!='')
					$ytbs[] = $y->linkvideo_ar;
				if($y->linkvideo_en!='')
					$ytbs[] = $y->linkvideo_en;
				if($y->linkvideo_fr!='')
					$ytbs[] = $y->linkvideo_fr;
				if($y->linkvideo_fa!='')
					$ytbs[] = $y->linkvideo_fa;
			}
			$ytbs = array_unique($ytbs);
			//echo count($ytbs);
			

			for($i=0;$i<(count($ytbs)/6)+3;$i++){
				Helper::get_set_project_youtube_video_statistcis(implode(',',array_slice($ytbs, $i*6, ($i+1)*6)));
			}
			
			
		}*/
    }
    public static function update_youtube_video_only($lastid='')
    {
		if($lastid!='')
			$videos = DB::table('videos')->where('id',$lastid)->orderBy('last_update','asc')->get();
		else
			$videos = DB::table('videos')->orderBy('last_update','asc')->get();
		$today = date("Y-m-d");
		
		$max = 34;
		$i=0;
		foreach($videos as $v){
			
			//if(date_diff(date_create($today),date_create($v->last_update))->format("%a")>=2){
			
			$i++;
			if($i==$max)
				exit;
			

			parse_str( parse_url( $v->link, PHP_URL_QUERY ), $my_array_of_vars );
			$id = $my_array_of_vars['v'];

			$json = file_get_contents('https://www.googleapis.com/youtube/v3/videos?part=contentDetails,statistics,snippet&id='.$id.'&key=AIzaSyAo7CUEF4x6b3c_bXlGTIkoe0BvS3iGDIo');
			$jsonData = json_decode($json);
			
			if(count($jsonData->items)>0){
				$views = $jsonData->items[0]->statistics->viewCount;
				$duration = $jsonData->items[0]->contentDetails->duration;
				$title = $jsonData->items[0]->snippet->title;
				$likes = $jsonData->items[0]->statistics->likeCount;
				$pic = $jsonData->items[0]->snippet->thumbnails->medium->url;

				$date_published = substr($jsonData->items[0]->snippet->publishedAt, 0, 10);
				
				DB::table('videos')->where('id',$v->id)->update(
					[
						'date_published' => $date_published,
						'title' => $title,
						'views' => $views,
						'likes' => $likes,
						'duration' => $duration,
						'pic' => $pic,
						'last_update' =>$today
					]);
			
			}else{
				DB::table('videos')->where('id',$v->id)->update(
					[
						'last_update' =>$today
					]);
			}
			//}
		}
		//exit;
    }
    
    public static function faTOen($string) {
		return strtr($string, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
	}
    /**
    * get url of item
    *
    * @return void
    */
    public static function get_link_url($link_type, $link_value)
    {
        $link = "#";
        switch ($link_type)
        {
            case 'city':
                $row = Helper::query("City", "find", ["id" => $link_value]);
                $link = url("/property-for-sale/$row->slug");
                break;
            case 'post':
                $row = Helper::query("Post", "find", ["id" => $link_value]);
                $link = $row->frontUrl();
                break;
            case 'category':
                $row = Helper::query("ProjectCategory", "find", ["id" => $link_value]);
                $link = url("/property-for-sale/turkey/$row->slug");
                break;
            case 'region':
                $row = Helper::query("Region", "find", ["id" => $link_value]);
                $link = url("/property-for-sale/turkey/$row->slug");
                break;
        }
        return $link;
    }
    
    /**
    * get json data for projects
    *
    * @return void
    */
    public static function get_json_map_projects($projects)
    {
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $arr = [];
        foreach ($projects as $p) {
            /*$flv = $p->flavors;
            $rooms = @$flv->sum("salon")."+".@$flv->sum("room");
            $area = @$flv->first()->area;
			$falvor = @$flv->first();
            ob_start();
			//if($lang=='ar'){
            ?>
                
				<div class="mapcontent">
                    <h4><?= $lang=='ar'?$p->getName():trans('front.residance').' '.$p->getNameEn().' '.trans("front.in").' '.@$p->city->getName(); ?></h4>
					
					<div class="contsp">
					<div class="start">
					<?= trans("front.start") ?></div>
					<?php
					if(@$falvor->salon==0 and @$falvor->room==0){ 
					
					}else{ ?>
					<div class="bed"><i class="flaticon-bed3"></i>
					<span><?= $falvor->salon."+".$falvor->room; ?></span>
					</div>
					<?php } ?>

					<div class="start">
					<?= trans("front.from") ?></div>
					</div>
					
					<?php
					$project_min_price = @$falvor->price;
					$project_min_price = Helper::decimal_format(@$falvor->price, $p->is_price_usd);
					if(strlen($project_min_price)>8){ ?>
					<div class="price smlprice">
					<?= $project_min_price . ' ' . Helper::curr_format() ?>
					</div>
					<?php }else{ ?>
					<div class="price">
					<?= $project_min_price . ' ' . Helper::curr_format() ?>
					</div>
					<?php } ?>
					
					
                    <p class="text-center"><a href="<?= $p->frontUrl(); ?>" class="btn btn-default btn-xs" target="_blank"><?= trans("front.read more"); ?></a></p>
                </div>
            <?php
			//}
            $content = ob_get_clean();
			*/
            $arr[] = [
                "id"  =>  $p->id,
                "lat"  =>  (float) $p->latitude,
                "lng"  =>  (float) $p->longitude,
                //"info"  =>  $content,
				"code"  =>  preg_replace('/[^0-9]/', '', $p->name_en),
            ];
        }
        return (json_encode($arr));
    }
	/**
    * get json data for projects
    *
    * @return void
    */
    public static function get_ajax_projects_info($id)
    {
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $arr = [];
        $p = \App\Models\Project::where('id',$id)->first();

            $flv = $p->flavors()->where('sold_out', false);
            //$rooms = @$flv->sum("salon")."+".@$flv->sum("room");
            //$area = @$flv->first()->area;
			$falvor = @$flv->first();
			//if($lang=='ar'){
				/*
            ?>
                
				<div class="mapcontent">
                    <h4><?= $lang=='ar'?$p->getName():trans('front.residance').' '.$p->getNameEn().' '.trans("front.in").' '.@$p->city->getName(); ?></h4>
					<?php if($falvor!==false){ ?>
						<div class="contsp">
						<div class="start">
						<?= trans("front.start") ?></div>
						<?php
						if(@$falvor->salon==0 and @$falvor->room==0){ 
						
						}else{ ?>
						<div class="bed"><i class="flaticon-bed3"></i>
						<span><?= $falvor->salon."+".$falvor->room; ?></span>
						</div>
						<?php } ?>

						<div class="start">
						<?= trans("front.from") ?></div>
						</div>
						
						<?php
						$project_min_price = @$falvor->price;
						$project_min_price = Helper::decimal_format(@$falvor->price, $p->is_price_usd);
						if(strlen($project_min_price)>8){ ?>
						<div class="price smlprice">
						<?= $project_min_price . ' ' . Helper::curr_format() ?>
						</div>
						<?php }else{ ?>
						<div class="price">
						<?= $project_min_price . ' ' . Helper::curr_format() ?>
						</div>
						<?php } ?>
					<?php } ?>
					
                    <p class="text-center"><a href="<?= $p->frontUrl(); ?>" class="btn btn-default btn-xs" target="_blank"><?= trans("front.read more"); ?></a></p>
                </div>
            <?php
			*/
			//}
            $content = '<div class="window_map_info num"><a href="'.$p->frontUrl().'"><img src="'. (Helper::get_thumbnail($p->cardphoto, 360, 196)) .'"/></a><h3>'. $p->getIntroCard() .'</h3><strong>'. ( Helper::decimal_format(@$falvor->price, $p->is_price_usd) . ' ' . Helper::curr_format()) .'</strong></div>';

        return trim(preg_replace('/\s+/', ' ', $content));
    }
    
    /**
    * date format
    *
    * @return void
    */
    public static function dateHuman($date)
    {
        if ( LaravelLocalization::getCurrentLocale() == 'ar' )
            Carbon::setLocale('ar');
        return $date->diffForHumans();
    }
    public static function dateDifference($date1, $date2, $typ = 'minute')
    {
        $date1 = Carbon::parse($date1);
        $date2 = Carbon::parse($date2);
        $diff = 0;
        switch ($typ) 
        {
            case 'month':
                $diff = $date2->diffInMonths($date1);
                break;
                
            case 'day':
                $diff = $date2->diffInDays($date1);
                break;
                
            case 'minute':
                $diff = $date2->diffInMinutes($date1);
                if ( $diff == 0 ) $diff = $date2->diffInSeconds($date1)." ثواني";
                else $diff = $diff." دقيقة";
                break;
                
            case 'year':
                $diff = $date2->diffInYears($date1);
                break;
        }
        return $diff;
    }
    
    /**
    * tranlate fron database
    *
    * @param App\Models\Model $row
    * @param string $lang
    * @return void
    */
    public static function trans($row, $field, $lang)
    {
        $v = $field."_".$lang;
        return $row->$v;
    }
    
	public static function Clear_all_cache(){
    Cache::flush();
    }
	
	public static function Clear_cache($urls){
		$arr_urls = [];
		foreach($urls as $u){
			if(trim($u)!=''){
				$u = str_replace(['.net/en/','.net/fr/','.net/ru/','.net/pe/'],'.net/',$u);
				
				$arr_urls[] = $u;
				$arr_urls[] = str_replace('.net/','.net/en/',$u);
				$arr_urls[] = str_replace('.net/','.net/fr/',$u);
				$arr_urls[] = str_replace('.net/','.net/pe/',$u);
				$arr_urls[] = str_replace('.net/','.net/ru/',$u);
				
				
				
			}
		
		
		
        	if (substr(rtrim($u, ' '), -1) === '/') {
                // حذف الـ Slash الأخيرة فقط من نهاية الرابط
                $u_without_slash = rtrim($u, '/'); 
                
                // إضافة الرابط النظيف ولغاته بدون سلاش في النهاية
                $arr_urls[] = $u_without_slash;
                $arr_urls[] = $u_without_slash . '/en';
                $arr_urls[] = $u_without_slash . '/fr';
                $arr_urls[] = $u_without_slash . '/pe';
                $arr_urls[] = $u_without_slash . '/ru';
            }
        
		}
		
		
		$arr_urls = array_unique($arr_urls);
		
		
		foreach($arr_urls as $url){
		    
		    $key = 'page_cache_' . md5($url);

            if (Cache::has($key)) {
                Cache::forget($key);
            }
		    
		}
		
/*		
$tocken = "pOEisOzlEv1Gs9FCKCLNuf2HwHvQWSR6FCx4_-yU";
$zone_id ="815abdc65621435088ff4e4944448b2c";

$ch = curl_init();
$headers = array(
                 'Authorization:Bearer '.$tocken,
                 'X-Auth-Email:damas.net@gmail.com',
                 'X-Auth-Key:'.$tocken,
                 'Content-Type:application/json',
                  );
$data = array(
              //'purge_everything' => true //,
               
			   'files' => $arr_urls
			   );
$json = json_encode($data);
curl_setopt($ch, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/".$zone_id."/purge_cache");
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$return = curl_exec($ch);
curl_close($ch);
*/

	}
    
    /**
    * except of content
    *
    * @return void
    */
    public static function str_limit($text, $limit = 170)
    {
        //return str_limit(strip_tags(html_entity_decode($text)), $limit);
		return self::extract_intro_proj(strip_tags(html_entity_decode($text)),$limit);
    }
    
    /**
    * list lang
    *
    * @return void
    */
    public static function langs($withall = null)
    {
        if ( $withall )
            return ["all" => "All", "ar" => "Arabic", "en" => "English", "fr" => "French", "fa" => "Persian", "ru" => "Russian"];
            
        return ["ar" => "Arabic", "en" => "English", "fr" => "French", "fa" => "Persian", "ru" => "Russian"];
    }
    
    /**
    * change paginate number
    *
    * @param array $params
    * @return void
    */
    public static function ajax_change_paginate_number($params = [])
    {
        $nbre = @$params["nbre"];
        $pagin = session()->get("paginate_number");
        if ( $nbre > 0 ) {
            session()->put('paginate_number', $nbre);
        } else if ( !$pagin ){
            session()->put('paginate_number', 20);
        }
        return session()->get("paginate_number");
    }

    /**
    * change position row
    *
    * @param array $params
    * @return void
    */
    public static function ajax_change_placement_row($params=[])
    {
        $id = $params["id"];
        $table = $params["table"];
        $nbre = $params["nbre"];
        DB::table($table)->where("id", $id)->update(["placement" => $nbre]);
    }

    /**
    * execute queries
    *
    * @return void
    */
    public static function query($model, $func, $params = [],$andor='and')
    {
        $class = "App\Models\\$model";
        switch ($func)
        {
            case 'new':
                $reflect  = new \ReflectionClass($class);
                return $reflect->newInstanceArgs();
                break;
                
            case 'find':
                $row = call_user_func([$class, $func], $params['id']);
                if ( $row ) return $row;
                return (new ReflectionClass($class))->newInstanceArgs();
                break;
                
            case 'save':
                $inputs = $params['inputs'];
                $id = @$params['id'];
                if ( $id ) {
                    $row = call_user_func([$class, "find"], $id);
                    $row->update($inputs);
                    session()->flash("flashmessage", ["typ" => "success", "message" => "تم التحديث بنجاح"]);
                } else {
                    $reflect  = new ReflectionClass($class);
                    $row = $reflect->newInstanceArgs();
                    $row = $row->create($inputs);
                    session()->flash("flashmessage", ["typ" => "success", "message" => "تم الإنشاء بنجاح"]);
                }
                if ( @$params['route'] ) {
                    $route = $params['route'];
                    return self::form_redirect($route, $row, @$inputs['redirect_to_list']);
                }
                return $row;
                break;
                
            case 'where':
                $operation = @$params['operation'] ? $params['operation'] : "=";
                return call_user_func([$class, "where"], $params['field'], $operation, $params['value']);
                break;
                
            case 'whereIn':
                return call_user_func([$class, "whereIn"], $params['field'], $params['value']);
                break;
                
            case 'delete':
                $row = call_user_func([$class, "find"], $params['id']);
                $row->delete();
                session()->flash("flashmessage", ["typ" => "success", "message" => "تم الحذف بنجاح"]);
                return redirect()->back();
                break;
                
            case 'latest':
                $limit = isset($params['limit']) ? $params['limit'] : 1000;
                return call_user_func([$class, 'orderBy'], 'created_at', 'DESC')->where("published", 1)->limit($limit)->get();
                break;
                
            case 'published':
                return call_user_func([$class, 'where'], 'published', 1)->get();
                break;
                
            case 'orderBy':
                $field = isset($params['field']) ? $params['field'] : "id";
                $value = isset($params['value']) ? $params['value'] : "ASC";
                return call_user_func([$class, 'orderBy'], $field, $value);
                break;
                
             case 'all':
                return call_user_func([$class, 'orderBy'], 'id', 'ASC')->get();
                break;
                
             case 'paginate':
                $field = Input::get("field") ? Input::get("field") : "id";
                $sort = in_array(Input::get("sort"), ["asc", "desc"]) ? Input::get("sort") : "desc";
                
                $pagin = self::ajax_change_paginate_number();
				
				if(!empty($params)){
					$q = call_user_func([$class, 'orderBy'], "$field", "$sort");
					
					/*echo '<pre>';
					print_r($params);
					echo '</pre>';
					echo $r[0].'=>'.$r[1];
					exit;*/
					if($andor=='and'){

						foreach($params as $r)
							if(count($r)==3)
								$q->where($r[0] ,$r[1], $r[2]);
							elseif(count($r)==2)
								$q->where($r[0] ,$r[1]);
							elseif(count($r)==1)
								$q->where($r[0]);
					}else{

						foreach($params as $r)
							if(count($r)==3)
								$q->orWhere($r[0] ,$r[1], $r[2]);
							elseif(count($r)==2)
								$q->orWhere($r[0] ,$r[1]);
							elseif(count($r)==1)
								$q->orWhere($r[0]);
					}
                
				return $q->paginate($pagin);
				}else
					return call_user_func([$class, 'orderBy'], "$field", "$sort")->paginate($pagin);
                //return call_user_func([$class, 'orderBy'], 'id', 'DESC')->paginate(30);
                break;
                
             case 'orderByPlacement':
                $lang = isset($params["lang"]) ? $params["lang"] : null;
                $device = isset($params["device"]) ? $params["device"] : null;
                
                $q = call_user_func([$class, 'orderBy'], 'placement', 'ASC');
                
                if ( $lang )$q->whereIn("lang", $lang);
                if ( $device ) $q->whereIn("device", $device);
                
                return $q->get();
                break;
                
             case 'lists':
                return call_user_func([$class, 'lists'], $params[0], @$params[1])->toArray();
                break;
        }
    }
    /**
    * redirect form submit
    *
    * @param int $var
    * @return void
    */
    public static function form_redirect($route, $row, $redirect_to_list)
    {
        if ( $redirect_to_list == 1 ) return redirect()->route($route);
        elseif ( $redirect_to_list == -1) return redirect()->route("$route.create");
        return redirect()->route("$route.edit", $row->id);
    }
    
    /**
    * if array contains
    *
    * @param String $str
    * @param Array $arr
    * @return void
    */
    public static function container_array($str, $arr = [])
    {
        foreach ( $arr as $s ) {
            if ( strpos($str, $s) !== false )  return true;
        }
        return false;
    }
    
    /**
    * list files
    *
    * @param array $inputs
    * @return void
    */
    public static function ajax_listFiles($inputs = [])
    {
        $medias = self::query("Media", "orderBy", ["field" => "id", "value", "ASC"])->paginate(20);
        $folders = self::query("MediaFolder", "all");
        $ids = isset($inputs["ids"]) ? $inputs["ids"] : null;
        $inputs["ids"] = is_array($ids) ? implode(",", $ids) : $ids;
        ob_start();
        ?>
            <div class="modal-header">
                <button type="button" class="close pull-left" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Media</h4>
            </div>
            <div class="modal-body clearfix">
                <div class="clearfix form-group">
                    <label>Folders</label>
                    <button type="button" data-id="-1" class="btn btn-primary btn-xs btn_change_folder">All photos</button>
                    <?php foreach ( $folders as $folder ): ?>
                        <button type="button" data-id="<?= $folder->id; ?>" class="btn btn-default btn-xs btn_change_folder"><?= $folder->name; ?></button>
                    <?php endforeach; ?>
                </div>                       
                <?= View::make("admin.medias.media_grid", ["rows" => $medias, "inputs" => $inputs])->render(); ?>
            </div>
            <div class="modal-footer clearfix">
                <?= Form::hidden("target", @$inputs["target"], ["id" => "targetInput"]); ?>
                <input type="hidden" class="form-control" id="txt_ids_files" value="<?= $inputs["ids"]; ?>">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Choose</button>
            </div>
        <?php
        return ob_get_clean();
    }
    
    /**
    * update media modal session
    *
    * @param int $var
    * @return void
    */
    public static function ajax_getSelectedMediasModal($inputs=[])
    {
        $ids = @$inputs["ids"];
        if ( $ids ) {
            $ids = explode(",", $ids);
            $ids = array_unique($ids);
            if ( !is_array($ids) ) $ids = [$ids];
            
            $str_options = "";
            foreach ($ids as $id) {
                $media = self::query("Media", "find", ["id" => $id]);
                if ( !$media->id ) continue;
                $str_options .= "<option value='".$id."' selected>".$media->name_ar."</option>";
            }
            return $str_options;            
        }
    }
    
    /**
    * add file modal
    *
    * @return void
    */
    public static function ajax_addFiles($inputs = [])
    {
        $row = self::query("Media", "new");
        ob_start();
        ?>
            <?= Form::open(['url' => route('admin.medias.create'), 'id' => 'form-media', 'files' => true]); ?>
                <div class="modal-header" style="display: flex;align-items: center;justify-content: space-between;flex-direction: row-reverse;width: 100%">
                    <h4 class="modal-title" style="color: #0f8280;font-size: 1.2em;">Select Images</h4>
                    <button type="button" class="close pull-left" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body clearfix">
                    <?= View::make("admin.medias.form", ['row' => $row])->render(); ?>
                </div>
                <div class="modal-footer clearfix">
                    <button class="btn btn-primary btn_save_media">Add Images</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <?= Form::hidden("target", @$inputs["target"], ["id" => "targetInput"]); ?>
                    <input type="hidden" class="form-control" id="txt_ids_files">
                </div>
            <?= Form::close(); ?>
        <?php
        return ob_get_clean();
    }
    
    /**
    * file size
    *
    * @return void
    */
    public static function format_bytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));
        return round($bytes, $precision) . ' ' . $units[$pow]; 
    }
    
    /**
    * get media url
    *
    * @return void
    */
    public static function media_url_full($media,$mob=false)
    {
        if ( !$media ) return asset('img/default_card.png');
        $path = $media->path;
        if($mob==true && $media->path_mobile)
            $path = $media->path_mobile;
            
        return asset("".$path);
    }
    /**
    * get media url
    *
    * @return void
    */
    public static function media_url($media,$x='',$y='',$mobile=false)
    {
        if ( !$media ) return asset('img/default_card.png');
        $path = $media->path;
		/*if ( in_array(self::get_device(),array('tab','mob')) and $media->path_mobile ) {*/
        if ( (self::is_mobile() and $media->path_mobile) or ($mobile==true and $media->path_mobile) ) {
            $path = $media->path_mobile;
        }
		/*echo asset("".$path);
		exit;*/
        return asset("".$path);
    }

    public static function media_dev($media,$dev='full')
    {
		if($dev=='tab')
		$dev='mob';
	
        if ( !$media ) return asset('img/default_card.png');
        
		if($dev=='mob')
			$path = $media->path_mobile;
		else
			$path = $media->path;
	
		if($path=='')
		$path = $media->path!=''?$media->path:$media->path_mobile;

        return asset("".$path);
    }
    public static function media_mob($media)
    {
        if ( !$media ) return asset('img/default_card.png');

		$path = $media->path_mobile!=''?$media->path_mobile:$media->path;

        return asset("".$path);
    }
	
	public static function empty_pic(){
		return "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";
	}
    /**
    * get shema pic url
    *
    * @return void
    */
    public static function shema_pic_url($media)
    {
        if ( !$media ) return asset('img/c8e367d3-c9ac-48a1-a4c2-998440e67acf.jpg');
        
        if ( $media->path_mobile ) {
            $path = $media->path_mobile;
        }else{
			$path = $media->path;
		}

        return asset("".$path);
    }

    /**
    * get thumbnail
    *
    * @param int $var
    * @return void
    */
    public static function get_thumbnail($media, $width = null, $height = null, $mbl='' /*, $x=false*/)
    {
        //return self::media_url($media);
        if ( !$media ) return null;
        $path = @$media->path;
        if ( self::is_mobile() and @$media->path_mobile ) {
            $path = @$media->path_mobile;
			
			if($mbl===false)/*me*/
            $path = @$media->path;
        } else if ( $mbl === true ) {
            if(@$media->path_mobile)
				$path = @$media->path_mobile;
			else
				$path = @$media->path;
		}
		/*echo '<p class="pxx" style="display:none">'. $path.' $$$ '.(public_path($path)).'</p>';*/
		if(@file_exists(public_path($path))){
			
			if(@file_exists(public_path(str_replace('uploads/','uploads_origin/',$path)))){
				$path = str_replace('uploads/','uploads_origin/',$path);
			}
			
			$path_info = pathinfo($path);
			if($path_info['extension']=='webp')
			    return asset($path);
			
			$img = ThumbImage::open(public_path($path));
			if ( !$width ) $width = $img->width();
			if ( !$height ) $height = $img->height();
			
			/*if($x==true)
				return public_path($path);*/
			
			if($path_info['extension']=='png')
				return asset($img->zoomCrop($width, $height)->png());/*zoomCrop;cropResize;resize*/
			else
				return asset($img->zoomCrop($width, $height)->jpeg());/*zoomCrop;cropResize;resize*/
		}else{
			return 'https://www.damas.net/img/L-ogo.svg';
		}
    }
    /**
    * get thumbnail full
    *
    * @param int $var
    * @return void
    */
    public static function get_thumbnail_full($media, $width = null, $height = null)
    {

        if ( !$media ) return null;
        $path = @$media->path;
		
		if(@file_exists(public_path(str_replace('uploads/','uploads_origin/',$path)))){
			$path = str_replace('uploads/','uploads_origin/',$path);
		}
		
        $img = ThumbImage::open(public_path($path));
        if ( !$width ) $width = $img->width();
        if ( !$height ) $height = $img->height();
		
		$path_info = pathinfo($path);
		if($path_info['extension']=='png')
			return asset($img->zoomCrop($width, $height)->png());/*zoomCrop;cropResize;resize*/
		else
			return asset($img->zoomCrop($width, $height)->jpeg());/*zoomCrop;cropResize;resize*/
    }
    /**
    * get get_pic
    *
    * @param int $var
    * @return void
    */
    public static function get_pic($url,$class="",$id="",$style="",$alt='',$other='')
    {
		/*if(strpos($url, 'damas.net/') !== false){
			$url = explode('damas.net/',$url)[1];
		}*/

		/*if(is_array($url)){
			$attrs = $url;
			$url = $attrs;
			$class = ;
			$id = ;
			$style = ;
			$alt = ;
			$other = ;			
		}*/
		
		if($alt=='')
			$alt = 'damasturk';
		
		$emptypic = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";
		//default image
		$lazy=0;
		if(strpos($class, 'lazy') !== false)
			$lazy = 1;
		
		/*<!--$attr = '';
		if(!empty($attrs)){
			foreach($attrs as $k=>$v){
				$attr = ' '.$k.'="'.$v.'"';
			}
		}-->*/

		$html = '<img ' . 
		($class!=''?' class="'.$class.'"':'') .
		($alt!=''?' alt="'.$alt.'"':'') .
		($alt!=''?' title="'.$alt.'"':'') .
		' src="'. $url .'"'. 
		($style!=''?' style="'.$style.'"':'').
		($id!=''?' id="'.$id.'"':'').
		' loading="lazy"' . ' '.$other.
		' />';
		
		return $html;
		
		/*
		$webpurl = '';
		//detect image floder [cache,uploads,img]
		if(strpos($url, '/cache/') !== false){
			$webpurl = str_replace('/cache/','/cachewebp/',$url);
		}elseif(strpos($url, '/uploads/') !== false)
			$webpurl = str_replace('/uploads/','/uploadswebp/',$url);
		else //img
			$webpurl = str_replace('/img/','/imgwebp/',$url);


		$info = pathinfo($webpurl);
		$webpurl = @$info['dirname'].'/'. @$info['filename'] . '.webp';


		$ext=@explode('.com/',$webpurl)[1];
		//if(date('H')=='22' or date('H')=='23' or date('H')=='21' or date('H')=='00'){
		if(App::environment('production')){
			
			if(!file_exists($ext)){
				
				$pathdir = '/home/damas2/public_html/'.@explode('.com/',$info['dirname'])[1];
				if (!file_exists($pathdir)) {
					mkdir($pathdir, 0777, true);
				}
				
				$imagePath = '/home/damas2/public_html/'. @explode('.com/',$url)[1];
				if(@$info['extension']=='png'){
					$im = @imagecreatefrompng($imagePath);
					imagepalettetotruecolor($im);
					imagealphablending($im, true);
					imagesavealpha($im, true);
				}else
					$im = @imagecreatefromjpeg($imagePath);
				$newImagePath = str_replace([".jpg",".png"], ".webp", '/home/damas2/public_html/'.$ext);
				
				//echo '***'.$imagePath;
				imagewebp($im, $newImagePath, 100);
			}
		}
		
		
			//exit($webpurl);
			if($lazy==1){
			$html ='<picture>' .
			'<source data-srcset="'.$webpurl.'" type="image/webp">'.
			'<source data-srcset="'. $url .'" type="image/' . (@$info['extension']=='png'?'png':'jpeg') .'">'.
			$html . 
			'</picture>';
			}else{
			$html ='<picture>' .
			'<source srcset="'.$webpurl.'" type="image/webp">'.
			'<source srcset="'. $url .'" type="image/' . (@$info['extension']=='png'?'png':'jpeg') .'">'.
			$html . 
			'</picture>';
			}
		
		
		$html = str_replace('  ',' ',$html);
	return $html;*/
	}
    /**
    * get get_pic
    *
    * @param int $var
    * @return void
    */
    public static function picture($arr)
    {
		//$url,$class="",$id="",$style="",$alt='',$other='';

	return self::get_pic(
		isset($arr['src'])?$arr['src']:'',
		isset($arr['class'])?$arr['class']:'',
		isset($arr['id'])?$arr['id']:'',
		isset($arr['style'])?$arr['style']:'',
		isset($arr['alt'])?$arr['alt']:'',
		isset($arr['other'])?$arr['other']:''
	);
	}
    /**
    * get get_webp
    *
    * @param int $var
    * @return void
    */
    public static function get_webp($url)
    {
		$info = pathinfo($url);
		//print_r($info);
		$file = $info['dirname'].'/'.$info['filename'] . '.webp';
		echo $file;
		if($info['filename']=='hot-to-use21')
		exit;
		if(file_exists($file)){
		$htm = '<source srcset="'. $url .'" type="image/jpeg">';
		$htm = '<source srcset="'.$file.'" type="image/webp">'.$htm;
		return $html;
		}
		return "";
    }
    
    /**
    * get select of options menu
    *
    * @param array $inputs
    * @return void
    */
    public static function ajax_selectLinksMenu($inputs = [])
    {
        $links = ["0" => "بدون"] + self::query("Menu", "lists", ["title_ar", "id"]);
        if( @$inputs["route_name"] == "admin.apparence.footer" ) {
            $links = ["0" => "بدون"] + self::query("FooterLink", "lists", ["title_ar", "id"]);
        }
        $typ = @$inputs["link_type"];
        ob_start();
        ?>
            <div class="form-group col-sm-4">
                <label>Parent menu</label>
                <?= Form::select("parent_id", $links, @$inputs["parent_id"], ["class" => "form-control select2me"]); ?>
            </div>
        <?php
        $parent_select = ob_get_clean();
        $input = null;
        $label = null;
        switch ($typ)
        {
            case 'city':
                $options = self::query("City", "lists", ["name_en", "id"]);
                $input = Form::select("link_value", $options, @$inputs["link_value"], ["class" => "form-control select2me"]);
                $label = "City";
                break;
                
            case 'project':
                $options = self::query("Project", "lists", ["name_ar", "id"]);
                return Form::select("link_value", $options, @$inputs["link_value"], ["class" => "form-control select2me"]).$parent_select;
                break;
                
            case 'category':
                $options = self::query("ProjectCategory", "lists", ["name_ar", "id"]);
                $input = Form::select("link_value", $options, @$inputs["link_value"], ["class" => "form-control select2me"]);
                break;
                
            case 'region':
                $options = self::query("Region", "lists", ["name_ar", "id"]);
                $input = Form::select("link_value", $options, @$inputs["link_value"], ["class" => "form-control select2me"]);
                break;
                
            case 'post':
                $options = self::query("Post", "lists", ["title_ar", "id"]);
                $input = Form::select("link_value", $options, @$inputs["link_value"], ["class" => "form-control select2me"]);
                $label = "Post";
                break;
                
            case 'url':
                $input = Form::text("link", @$inputs["link"], ["class" => "form-control ltr", "placeholder" => "https://www.example.com"]);
                $label = "Link";
                break;
                
            case 'parent':
                $parent_select = null;
                break;
        }
        ob_start();
        ?>
            <div class="form-group col-sm-4">
                <label><?= $label; ?></label>
                <?= $input; ?>
            </div>
            <?= $parent_select; ?>
        <?php
        return ob_get_clean();
    }
    /**
    * get select of options menu
    *
    * @param array $inputs
    * @return void
    */
    public static function ajax_selectLinksMenu_sitemap($inputs = [])
    {
        $links = ["0" => "بدون"] + self::query("SitemapCats", "lists", ["title_ar", "id"]);
        /*if( @$inputs["route_name"] == "admin.apparence.footer" ) {
            $links = ["0" => "بدون"] + self::query("FooterLink", "lists", ["title_ar", "id"]);
        }*/
        $typ = @$inputs["link_type"];
        ob_start();
        ?>
            <div class="form-group col-sm-4">
                <label>Parent menu</label>
                <?= Form::select("parent_id", $links, @$inputs["parent_id"], ["class" => "form-control select2me"]); ?>
            </div>
        <?php
        $parent_select = ob_get_clean();
        $input = null;
        $label = null;
        switch ($typ)
        {
            case 'city':
                $options = self::query("City", "lists", ["name_ar", "id"]);
                $input = Form::select("link_value", $options, @$inputs["link_value"], ["class" => "form-control select2me"]);
                $label = "المدينة";
                break;
                
            case 'project':
                $options = self::query("Project", "lists", ["name_ar", "id"]);
                return Form::select("link_value", $options, @$inputs["link_value"], ["class" => "form-control select2me"]).$parent_select;
                break;
                
            case 'category':
                $options = self::query("ProjectCategory", "lists", ["name_ar", "id"]);
                $input = Form::select("link_value", $options, @$inputs["link_value"], ["class" => "form-control select2me"]);
                break;
                
            case 'region':
                $options = self::query("Region", "lists", ["name_ar", "id"]);
                $input = Form::select("link_value", $options, @$inputs["link_value"], ["class" => "form-control select2me"]);
                break;
                
            case 'post':
                $options = self::query("Post", "lists", ["title_ar", "id"]);
                $input = Form::select("link_value", $options, @$inputs["link_value"], ["class" => "form-control select2me"]);
                $label = "المقال";
                break;
                
            case 'url':
                $input = Form::text("link", @$inputs["link"], ["class" => "form-control ltr", "placeholder" => "https://www.example.com"]);
                $label = "الرابط";
                break;
                
            case 'parent':
                //$parent_select = null;
                break;
        }
        ob_start();
        ?>
            <div class="form-group col-sm-4">
                <label><?= $label; ?></label>
                <?= $input; ?>
            </div>
            <?= $parent_select; ?>
        <?php
        return ob_get_clean();
    }
    
    /**
    * get params
    *
    * @return void
    */
    public static function get_params()
    {
		
		if(!empty(self::$params))
			return self::$params;
		
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $param = self::query("Param", "where", ["field" => "lang", "value" => $lang])->first();
        if ( !$param ) return self::query("Param", "new");
        
		self::$params = $param;
		
		return $param;
    }
	
    /**
    * get flavors
    *
    * @return void
    */
    public static function get_project_flavors($project)
    {
		
		if(!empty(self::$flavors[$project]))
			return self::$flavors[$project];
		

        $flavors = self::query("flavors", "orderBy", ["field" => "project_id", "value", "ASC"])->get();
        
		foreach($flavors as $f){
			$flavors[$f->project_id][] = $f;
		}
		self::$flavors = $flavors;
		
		echo '<pre>';
		print_r($flavors);
		echo '</pre>';
		exit;
		return $flavors;
    }
	/**
    * get compress projects cards
    *
    * @return void
    */
    public static function get_compress_cards($content)
    {
		
		$thtm = [
		'<aside class="col-md-6 col-sm-6 col-xs-12"> <div class="item"> <div class="project-card card-small" >  <div class="share project-social"> <i class="flaticon-share cshare"></i> <a href="#" class="likeCardItem" data-url="',
		'<i class="fa fa-heart-o"></i></a> <span class="pull-right social shareBtnsFloating" data-url=',
		'> <a href="#" class="btnshare" data-network="facebook"><i class="fa fa-facebook"></i></a> <a href="#" class="btnshare" data-network="whatsapp"><i class="fa fa-whatsapp"></i></a> </span>  <div class="d105" ><b>',
		'</span></div> </div> <div class="contain" id="container" > <div class="image-project"> <a href=',
		' target="_blank" >  <img class="img-responsive" alt=',
		'</a> </div>   <div class="title-project">  <div class="start">',
		'/> </a> </div>   <div class="title-project">  </div>  <div class="clearfix"></div> <div class="about-project new-style">',
		'</div> <div class="clearfix"></div>  <div class="info-project">  <div class="status"> <div class="resale"> <div class="icon"></div> <p',
		'</div> </div> <div class="key"> <div > <i class="flaticon-room-key2"></i> <span>',
		'</span> </div> </div> <div class="coin"> <div> <i class="flaticon-coin2"></i> <span>',
		'</span> </div> </div> </div>   <div class="details"><a href=',
		'</a></div> </div> </div> </div> </aside>',
		'<div class="price smlprice tpp1_1 hidden">  <strong>',
		'<div class="price smlprice tpp1_2 hidden">  <strong>',
		'<div class="price smlprice tpp1_3 hidden">  <strong>',
		'<div class="price smlprice tpp1_4 hidden">  <strong>',
		'<div class="price smlprice tpp1_5 hidden">  <strong>',
		'<div class="price smlprice tpp2_3 hidden">  <strong>',
		'<div class="price smlprice tpp2_4 hidden">  <strong>',
		'<div class="price smlprice tpp2_5 hidden">  <strong>',
		'<div class="price smlprice tpp2_6 hidden">  <strong>',
		'</div> <div class="clearfix"></div>  <div class="info-project">  <div class="status"> <div class="ready"> <div class="icon"></div> <p',
		'likeitem" data-typ="project" data-code="',
		'</span> <ul class="dropdown-menu hidden">  <li><a data-val="',
		'</div>  <div class="price smlprice">  <strong>',
		'https://www.damas.net/projects/',
		'https://www.damas.net/',
		'</a></li>  </ul> </button>  <div class="start">',
		'</strong> <span>',
		'<div class="clearfix"></div>',
		'" target="_blank" class="button">',
		'<div id="projects-paginate" class="alikes text-center"> <aside class="col-md-12 col-sm-1 col-xs-12" style="width:100%;margin:0 0 20px 0"> <button class="btn btn-primary btnLoadMoreProjets" id="show_more" style="margin-top:0"><i class="fa fa-list"></i> '. trans("front.load more") .'<div class="lds-ring"> <div></div> <div></div> <div></div> <div></div> </div> </button> </aside> </div>',
		'</a></li>  <li><a data-val="',
		'" href="javascript:;">',
		'img/bed.svg" alt="Damas"> <span>',
		'</div>  <button class="bed"> <img src="',
		'<div class="info-project">  <div class="status"> <div class="under-construction"> <div class="icon"></div> <p>'
		];



		

		return str_replace($thtm,['%p1','%p2','%p3','%p4','%p5','%p6','%p7','%p8','%p9','%pa','%pb','%pc','%pd','%pe','%pf','%pg','%ph','%pi','%pj','%pk','%pl','%pm','%pn','%po','%pq','%pr','%ps','%pt','%pu','%x1','%x2','%x3','%x4','%x5','%x6','%x7','%x8'],$content);
    }
	
    
    /**
    * show nav menu tree
    *
    * @param int $parent
    * @param int $niveau
    * @param array $items
    * @param array $params
    * @return void
    */
    public static function new_menu_tree_front($parent, $level, $items, $class_ul = "naviga", $class_ahref= "nav-link")
    {
		
		/*<div class="panel">
		  <div class="panel-heading" role="tab" id="headingOne">
			<div class="panel-title">
				<a class="active" role="button" data-toggle="collapse" data-parent="#accordionLinks" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				  <strong class="jazzira_font_bold">الجنسية التركية</strong>
				  <i class="arrow"></i>
			  </a>
			</div>
		  </div>
		  <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
			<div class="panel-body">
			 <ul class="links_list">
				<li>
					<a href="{{ route('front.faq_show','turkish-citizenship') }}" title="link name"><?= trans("front.quick menu link 2"); ?></a>
				</li>
				<li>
					<a href="<?= route("front.blog.category", 'turkish-citizenship') ?>" title="link name"><?= trans("front.quick menu link 3"); ?></a>
				</li>
				<li>
					<a href="<?= route("front.video") ?>/turkish-citizenship-series-1" title="link name"><?= trans("front.quick menu link 4"); ?></a>
				</li>
			</ul>
			</div>
		  </div>
		</div>*/
        $ilang = LaravelLocalization::getCurrentLocale();
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
		/*if($lang=='fa')
			$lang = 'ar';*/
		
			$index_link = ($lang == "ar"  ? "link" : "link_".$lang);
			
			$content = '';
			$i=0;
			foreach($items as $item) {
				$i++;
				if ( $item['parent_id'] == 0 ) {
					$content.='<div class="panel">
		  <div class="panel-heading" role="tab" id="headingOne'.$i.'">
			<div class="panel-title">
				<a class="'. ($i==1?'active':'') .'" ';
				
				if ( $item['link_type'] == 'parent' ) {
				    $content.='role="button" data-toggle="collapse" data-parent="#accordionLinks" href="#collapseOne'.$i.'" aria-expanded="true" aria-controls="collapseOne'.$i.'"';
				}else{
				    $content.=' href="'. str_replace('.net/en','.net'. ($ilang=='ar'?'':'/'.$ilang),$item['link_en'])  .'" ';
				}
				
				$content.='>
				  <strong class="jazzira_font_bold">'.$item["title_$lang"].'</strong>';
				  
				  if ( $item['link_type'] == 'parent' ) {
				    $content.='<i class="arrow"></i>';
				  }
			  $content.='</a>
			</div>
		  </div>';
		  
		  if ( $item['link_type'] == 'parent' ) {
		  $content.='<div id="collapseOne'.$i.'" class="panel-collapse collapse '. ($i==1?'show':'') .'" role="tabpanel" aria-labelledby="headingOne'.$i.'">
			<div class="panel-body">
				<ul class="links_list">';
				
				
					foreach($items as $subm) {
						if ( $subm['parent_id'] == $item['id'] and  trim($subm["title_$lang"])!='') {
    					    $content.='<li><a href="'. str_replace('.net/en','.net'. ($ilang=='ar'?'':'/'.$ilang),$subm['link_en']) .'" title="'. $subm["title_$lang"] .'">'.$subm["title_$lang"].'</a></li>';
    					}
					}
					
					
					$content .="</ul></div></div>";
		  }
		  
		  $content.="</div>";
				
			
			}
			}
			
			$content .= '';

        return $content;
    }
    
    /**
    * show nav menu tree
    *
    * @param int $parent
    * @param int $niveau
    * @param array $items
    * @param array $params
    * @return void
    */
    public static function menu_tree_front($parent, $level, $items, $class_ul = "naviga", $class_ahref= "nav-link")
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
		if($lang=='fa')
			$lang = 'ar';
			$index_link = ($lang == "ar"  ? "link" : "link_".$lang);
			$content = '<ul class="naviga">';
			foreach($items as $item) {
				if ( $item['parent_id'] == 0 ) {
					$content.='<li class="parent_menu">
				<div class="drop"  >
					  <a href="'. front_link($item[$index_link]).'" class="pd0">
					  <i class="fa fa-angle-down"></i>
					  <span>'.$item["title_$lang"].'</span>
					  </a>
				</div>
				<ul class="dropdown-menu">';
				
				
					foreach($items as $subm) {
						if ( $subm['parent_id'] == $item['id'] ) {
					$content.='<li><a href="'. front_link($subm[$index_link]) .'">'.$subm["title_$lang"].'</a></li>';
					}
					}
					
					
					$content .="</ul></li>";
				
			
			}
			}
			$content .= '</ul>';

        return $content;
    }
    public static function menu_tree_map($parent, $level, $items, $lang)
    {
		$index_link = $lang == "ar" ? "link" : "link_".$lang;
       $content = '<ul class="list-group">';
        foreach($items as $item) {
            if ( $item['parent_id'] == $parent ) {
                $submenu = self::menu_tree_map($item['id'], ($level+1), $items, $lang);
                ob_start();
                ?>
                    <li class="list-group-item">
					<a href="<?= front_link($item[$index_link]) ?>">
                        <?= $item["title_$lang"]; ?>
                        </a>
                    
                <?php
                $li = ob_get_clean();
                $content .= $li;
                $content .= $submenu;
            }
        }
        $content .= '</ul></li>';
        return $content;
    }
	
    public static function menu_tree_front_mobile_amp($parent, $level, $items, $class_ul = "naviga", $class_ahref= "nav-link")
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
			$index_link = $lang == "ar" ? "link" : "link_".$lang;
			$content = '';
			foreach($items as $item) {
				if ( $item['parent_id'] == 0 ) {
					$content.='<section>
					<h2 class="accordionheader">' . $item["title_$lang"].'<i class="fa fa-plus"></i>
					<i class="fa fa-minus"></i></h2><div class="accordcontent">
							<ul class="amp-menu-links">';
					foreach($items as $subm) {
						if ( $subm['parent_id'] == $item['id'] ) {
							$content.='<li><a href="'.$subm[$index_link].'">'.$subm["title_$lang"].'</a></li>';
						}
					}
					$content .="</ul></div></section>";
				}
			}
			$content .= '';
        return $content;
    }
    public static function menu_tree_front_mobile($parent, $level, $items, $class_ul = "naviga", $class_ahref= "nav-link")
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
			$index_link = $lang == "ar" ? "link" : "link_".$lang;
			$content = '<ul class="menu">';
			foreach($items as $item) {
				if ( $item['parent_id'] == 0 ) {
					$content.='<li class="list">
				<a href="'.front_link($item[$index_link]).'">'.$item["title_$lang"].'</a>
				<ul class="items">';
					foreach($items as $subm) {
						if ( $subm['parent_id'] == $item['id'] ) {
					$content.='<li><a href="'.front_link($subm[$index_link]).'">'.$subm["title_$lang"].'</a></li>';
					}
					}
					$content .="</ul></li>";
			}
			}
			$content .= '</ul>';
        return $content;
    }
    public static function menu_tree_admin($parent, $level, $items, $lang = "ar")
    {
        $content = '<ul class="list-group">';
        foreach($items as $item) {
            if ( $item['parent_id'] == $parent ) {
                $submenu = self::menu_tree_admin($item['id'], ($level+1), $items, $lang);
                ob_start();
                ?>
                    <li class="list-group-item">
                        <?= $item["title_$lang"]; ?>
                        <div class="pull-left">
                            <a href="<?= route(Route::currentRouteName(), $item['id']); ?>" class="btn btn-primary btn-xs" title="تعديل"><i class="fa fa-edit"></i></a>
                            <?php /*if ( $submenu == '<ul class="list-group"></ul>' and $item['fixed'] == 0 ):*/ ?>
                                <?= Form::open(["method" => "DELETE", "url" => route(Route::currentRouteName().".delete", $item['id']), "class" => "inline"]); ?>
                                    <button data-id="<?= $item['id']; ?>" class="btn btn-danger btn-xs button_confirm" title="حذف"><i class="fa fa-trash"></i></button>
                                <?= Form::close(); ?>
                            <?php //endif; ?>
                        </div>
                    </li>
                <?php
                $li = ob_get_clean();
                $content .= $li;
                $content .= $submenu;
            }
        }
        $content .= '</ul>';
		$content = str_replace('<ul class="list-group"></ul>','',$content);
        return $content;
    }
    public static function menu_tree_footer($parent, $level, $items, $class_ul = null)
    {
        $content = null;
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        if ( $class_ul )
            $content = '<ul class="'.$class_ul.'">';
        foreach($items as $item) {
            if ( $item['parent_id'] == $parent ) {
                $content .= "<h4>".$item["title_$lang"]."</h4>";
                $submenu = self::menu_tree_front($item['id'], ($level+1), $items, "list-inline", null);
                if ( $item['link'] != '#' ) $content .= '<li><a href="'.front_link($item['link']).'">'.'</a>';
                if ( $submenu != '<ul class="list-inline"></ul>' ) $content .= $submenu;
                $content ."</li>";
            }
        }
        $content .= '</ul>';
        return $content;
    }
    
    /**
    * get tr project price
    *
    * @return void
    */
    public static function ajax_getTrPriceProject($inputs = [])
    {
        $length = $inputs["length"];
        ob_start();
        ?>
            <tr>
                <td><input type="text" name="offer[]" class="form-control input-sm"></td>
                <td><input type="text" name="price[]" class="form-control input-sm"></td>
                <td><input type="text" name="room[]" class="form-control input-sm"></td>
                <td><input type="text" name="area[]" class="form-control input-sm"></td>
                <td><input type="text" name="salon[]" class="form-control input-sm">
				<input type="hidden" name="date_created[]" class="form-control input-sm" value="<?= date("Y-m-d"); ?>">
				</td>
                <td><input type="text" name="observation[]" class="form-control input-sm"></td>
                <td><input type="text" name="observation_en[]" class="form-control input-sm"></td>
                <td><input type="text" name="observation_fr[]" class="form-control input-sm"></td>
                <td><button type="button" class="btn btn-default btn-xs btn-flat btn_tr_delete"><i class="fa fa-trash"></i></button></td>
            </tr>
        <?php
        return ob_get_clean();
    }
    public static function TrToEng($txt){
		$turkish = array();//turkish letters
		$english   = array();//english cooridinators letters

		return str_ireplace(["ı", "ğ", "ü", "ş", "ö", "ç"], ["i", "g", "u", "s", "o", "c"], $txt);//replace php function
	}
    public static function trimm($str){
		$str = str_replace('   ','  ',$str );
		$arr1 = ['شقق شقق','مكاتب شقق','محلات شقق','فلل شقق',' أسعار ',' إطلالات ',' تقسيط ',' جاهز '];
		$arr2 = ['شقق','مكاتب','محلات','فلل',' بأسعار ',' بإطلالات ',' بتقسيط ',' جاهزة '];
		$str = str_replace($arr1,$arr2,$str);
		return trim($str);
	}
    public static function qualify_keyword_mysql($keyword){
		$keyword = str_replace(array('ا','أ','آ','إ'),'_',$keyword);
		$keyword = str_replace(array('ة ','ه '),"_ ",$keyword);
		$keyword = str_replace(array('ة','ه'),"_",$keyword);
		$keyword = str_replace(array('ية','يه'),"__",$keyword);
		$keyword = str_replace('  '," ",$keyword);
		return trim($keyword);
	}
    public static function qualify_keyword($keyword){
		$keyword = str_replace(array('ا','أ','آ','إ'),'ا',$keyword);
		//$keyword = str_replace(array('ة ','ه '),"ة ",$keyword);
		$keyword = str_replace(array('ة','ه'),"ة",$keyword);
		$keyword = str_replace(array('ية','يه'),"",$keyword);
		$keyword = str_replace('  '," ",$keyword);
		return trim($keyword);
	}
    public static function arr_keyword_mysql($keyword,$camma=false){
		//$keywords = explode(' ',trim($keyword));
		$lay = [' على ',' الى ',' من ',' في '];//,' ال'     ,   ' والبال',
		
		$keywords = str_replace($lay,' ',$keyword);
		$keywords = trim(str_replace('  ',' ',$keywords));
		$keywords = self::qualify_keyword_mysql($keywords);
		
		if($camma==true){
			$keywords = str_replace([' ,',', '],',',$keywords);
		return @explode(',',$keywords);
		}else
		return @explode(' ',$keywords);
	}
	
    public static function build_search_url($search){
		/*$project_type = '';
		$city = '';
		$tags = '';
		$region = '';

		if($search[0]->class=='type')
			$project_type = $search[0]->slug;
		elseif($search[0]->class=='city')
			$city = $search[0]->city;
		elseif($search[0]->class=='tag')
			$tags = $search[0]->tag;*/

		//$url = route("front.search")."/".($project_type==''?'property-for-sale':$project_type)."/".($city==''?'turkey':$city) . ($tags!=''?'/'.$tags:'') . ($region!=''?'/'.$region:'');
		return array($search->class,$search->slug);
	}
	/*public static function build_search_urls($searchs){
		
		//foreach()
		
	}
	*/
    /**
    * delete rows
    *
    * @param array $inputs
    * @return void
    */
    public static function ajax_deleteTableRows($inputs = [])
    {
        $table = $inputs["table"];
        if ( $table == "medias" ) {
            $rows = DB::table($table)->whereIn("id", $inputs)->get();
            foreach ($rows as $row) {
                $filepath = public_path($row->path);
                @unlink($filepath);
            }
        }
        $rows = DB::table($table)->whereIn("id", $inputs)->delete();
    }
    
    /**
    * chat messages html
    *
    * @param array $inputs
    * @return void
    */
   /* public static function chat_messages($inputs = [], $message = null)
    {
        $auth_user = Auth::user();
        $support_user = Helper::support_user();
        $chat_user = session()->get("chatuser");
        
        $chat_message_id = @$chat_user["chat_message_id"];
        $parent_message = Helper::query("ChatMessage", "find", ["id" => $chat_message_id]);
        
        $messages = Helper::query("ChatMessage", "where", ["field" => "parent_id", "value" => $parent_message->id])->get();
        
        $support_user_online = $support_user->isOnline();
        
        ob_start();
        ?>
            <?php if($chat_user and $parent_message): ?>
                <div class="row msg_container base_sent">
                    <div class="col-xs-12">
                        <div class="messages msg_sent">
                            <span class="author"><?= $parent_message->author; ?></span>
                            <div class="clearfix"></div>
                            <p><?= $parent_message->message; ?></p>
                        </div>
                    </div>
                    <!--<div class="col-md-2 col-xs-2"></div>-->
                </div>
                
                <?php if ( count($messages) ): ?>
                    <?php foreach($messages as $msg): ?>
                    <div class="row msg_container base_sent">
                        <div class="col-xs-12">
                            <div class="messages msg_sent">
                                <span class="author"><?= htmlentities($msg->author); ?></span>
                                <div class="clearfix"></div>
                                <p><?= htmlentities($msg->message); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php $msg->update(["viewed" => 1]); ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-warning text-center"><small>سنتواصل معك قريبا</small></div>
                <?php endif; ?>
                
            <?php else: ?>
                <?= Form::open(["url" => route("front.callus"), "id" => "form-callus-chat"]); ?>
                    <div class="form-group">
                        <input type="text" name="name" class="form-control bluring" placeholder="<?= trans("front.your name"); ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" name="email" class="form-control bluring" placeholder="<?= trans("front.your email"); ?>">
                    </div>
                    <div class="form-group" dir="ltr">
                        <input type="text" name="mobile" id="inputMobileChat" placeholder="+90 123456789" class="bluring form-control">
                    </div>
                    <div class="form-group">
                        <textarea name="message" class="form-control bluring" placeholder="<?= trans("front.message"); ?>"></textarea>
                    </div>
                    <input type="hidden" name="form_type" value="Chat">
                    <button type="submit" class="btn btn-primary btn-block"><?= trans("front.send"); ?></button>
                <?= Form::close() ?>
            <?php endif; ?>
        <?php
        return ob_get_clean();
    }*/
    public static function support_user()
    {
        $u = Helper::query("User", "where", ["field" => "role_type", "value" => "support"])->first();
        if ( !$u ) $u = Helper::query("User", "new");
        return $u;
    }

	public static function add_notif($descr='',$lead=0,$link='',$users=[],$color='blue',$type='',$crm_oman=''){
		$users = array_unique($users);
		$data['type'] = $type;
		$data['color'] = $color;
		$data['descr'] = $descr;
		$data['lead'] = $lead;
		$data['link'] = $link;
		$data['n_created_at'] = date('Y-m-d H:i:s');
		$data['n_created_by'] = 0;
		
		DB::connection('mysql_crm'.$crm_oman)->table('notifs')->insert($data);
		$id = DB::connection('mysql_crm'.$crm_oman)->getPdo()->lastInsertId();
		foreach($users as $u){
			if($u==0){//administrator
				$users = self::getUserByRole('superadmin',$crm_oman);
				if(count($users)>0)
					$u = $users[0]->id;
			}
			$dt['user'] = $u;
			$dt['notif'] = $id;
			DB::connection('mysql_crm'.$crm_oman)->table('notifs_users')->insert($dt);
		}
	}
	
	public static function getUserByRole($rol,$crm_oman=''){
		$users = DB::connection('mysql_crm'.$crm_oman)->table('users')->where("enabled", '1')->where("deleted", 0)->where("role_lib", $rol)->get();
		return $users;
	}
    public static function sendOnesignalNotification($app_id,$auth_key,$title,$desc,$img,$url){
		//exit();//locale
		/*echo $title.','.$desc.','.$img.','.$url;
		exit;*/
		$heading = array(
			"en" => $title
			);
		$content = array(
			"en" => $desc
			);

		$fields = array(
			'app_id' => $app_id,
			'included_segments' => array('All'),//test user
			/*'data' => array("foo" => "bar"),*/
			'large_icon' =>"https://www.damas.net/img/favicon.png",
			'headings' => $heading,
			'contents' => $content,
			'url' => $url,
			'big_picture' => $img, //512*256
			'chrome_big_picture' => $img, //512*256
			'chrome_web_image' => $img, //512*256
			'chrome_web_icon' =>"https://www.damas.net/img/favicon.png"
		);

		$fields = json_encode($fields);
		print("\nJSON sent:\n");
		print($fields);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
													   'Authorization: Basic ' . $auth_key));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

			$response = curl_exec($ch);
			curl_close($ch);

			//return $response;
			
			$return["allresponses"] = $response;
			$return = json_encode( $return);

		echo "<pre>";
		print_r($return);
		echo "</pre>";
	}


	public static function project_id_html($name_en){
		
		$project_name_en = $name_en;
        preg_match_all('!\d+!', $project_name_en, $matches);
        $id_num = $matches[0][0];
        $id_text = str_replace($id_num, '', $project_name_en);
		return '<span><b>'.$id_text.'</b><strong>'.$id_num.'</strong></span>';
	
	}

	public static function ajax_statics($region_name,$type,$year=0,$month=0,$project_type=null,$price_type=null,$countries=null,$cities=null){
		//tl,usd,pnd,eur
		$currency = '$';
		$static_curr = 'usd';
		if(session()->get("currency")=='TRY'){
			$currency = '₺';
			$static_curr = 'tl';
		}elseif(session()->get("currency")=='EUR'){
			$currency = '€';
			$static_curr = 'eur';
		}elseif(session()->get("currency")=='GBP'){
			$currency = '£';
			$static_curr = 'pnd';
		}


		$fields = array();
		switch($type){
			case 'region_sale':
				$region = DB::select("SELECT stat_region.id,`PRICE_PER_MS_RESIDENTIAL`,`TOTAL_PRICE_RESIDENTIAL`,`PRICE_PER_MS_COMMERCIAL`,`TOTAL_PRICE_COMMERCIAL`
				FROM `dms_regions`
				left join stat_region on stat_region.name=dms_regions.name_en
				where `dms_regions`.`name_en`=?",[$region_name]);
				$region = @$region[0];
				
				//DB::table('stat_region')->select('*')->where("word", $keyword)->get();
				if($project_type == 'apartments_villas'){
					if($price_type == 'price_m')
						$json = self::json_currency($region->PRICE_PER_MS_RESIDENTIAL,$static_curr,$year,$month);
					else{ //price_total
						$json = self::json_currency($region->TOTAL_PRICE_RESIDENTIAL,$static_curr,$year,$month);
						}
				}else{ //office_shops
					if($price_type == 'price_m'){
						$json = self::json_currency($region->PRICE_PER_MS_COMMERCIAL,$static_curr,$year,$month);
						//$json = self::merge_calc_avg($region->PRICE_PER_MS_COMMERCIAL_OFFICE,$region->PRICE_PER_MS_COMMERCIAL_STORE,$static_curr,$year);
					}else{ //price_total
						$json = self::json_currency($region->TOTAL_PRICE_COMMERCIAL,$static_curr,$year,$month);
						//$json = self::merge_calc_avg($region->TOTAL_PRICE_COMMERCIAL_OFFICE,$region->TOTAL_PRICE_COMMERCIAL_STORE,$static_curr,$year);
					}
					
				}
				
		$rjson['data'] = $json==null?[]:$json;
		$rjson['curr'] = $currency;
		$rjson['curr_txt'] = $static_curr;
		return $rjson;
			break;
			case 'region_rent':
			$region = DB::select("SELECT stat_region.id,`R_PRICE_PER_MS_RESIDENTIAL`,`R_TOTAL_PRICE_RESIDENTIAL`,`R_PRICE_PER_MS_COMMERCIAL`,`R_TOTAL_PRICE_COMMERCIAL`
				FROM `dms_regions`
				left join stat_region on stat_region.name=dms_regions.name_en
				where `dms_regions`.`name_en`=?",[$region_name]);
				$region = @$region[0];
				
				//DB::table('stat_region')->select('*')->where("word", $keyword)->get();
				if($project_type == 'apartments_villas'){
					if($price_type == 'price_m')
						$json = self::json_currency($region->R_PRICE_PER_MS_RESIDENTIAL,$static_curr,$year,$month);
					else{ //price_total
						$json = self::json_currency($region->R_TOTAL_PRICE_RESIDENTIAL,$static_curr,$year,$month);
						}
				}else{ //office_shops
					if($price_type == 'price_m'){
						$json = self::json_currency($region->R_PRICE_PER_MS_COMMERCIAL,$static_curr,$year,$month);
						//$json = self::merge_calc_avg($region->PRICE_PER_MS_COMMERCIAL_OFFICE,$region->PRICE_PER_MS_COMMERCIAL_STORE,$static_curr,$year);
					}else{ //price_total
						$json = self::json_currency($region->R_TOTAL_PRICE_COMMERCIAL,$static_curr,$year,$month);
						//$json = self::merge_calc_avg($region->TOTAL_PRICE_COMMERCIAL_OFFICE,$region->TOTAL_PRICE_COMMERCIAL_STORE,$static_curr,$year);
					}
					
				}
				
		$rjson['data'] = $json==null?[]:$json;
		$rjson['curr'] = $currency;
		$rjson['curr_txt'] = $static_curr;
		return $rjson;
			break;
			
			
			
			
			case 'top_country':
				$slected_country = array();
				$top5_id = [];
				$year = (int)$year;
				$month = (int)$month;
				$tcountries = @explode(',',$countries);
				foreach($tcountries as $k=>$v){
					$tcountries[$k] = str_replace("'","",$v);
				}
				$countries = implode(",",$tcountries);
				
				
				/*echo print_r($countries);
				exit;*/
				$arrwhere = array();
				$where = " Where `type`='country'";
				
				if($year!=0){
					$where = $where." and `year`=?";
					$arrwhere[] = $year;
				}
				if($month!=0){
					$where = $where." and `imonth`=?";
					$arrwhere[] = $month;
				}
				
				$top5 = DB::select("SELECT *,sum(value) as 'value','0' as 'percent' 
				FROM `stat_house_sales`
				$where and `country` not in ('". str_replace(",","','",$countries)."') 
				group by country
				order by sum(value) DESC
				limit 5",$arrwhere);

				if($countries!=''){
					$where = $where." and `country` in ('". str_replace(",","','",$countries)."') ";

					//$arrwhere[] = "('". str_replace(",","','",$countries)."')";
					//$arrwhere[] = "'".implode("','",$tcountries)."'";
				$slected_country = DB::select("SELECT *,sum(value) as 'value','0' as 'percent'
				FROM `stat_house_sales`
				$where
				group by country
				order by field(country,'". str_replace(",","','",$countries)."')
				limit 5",$arrwhere);/*order by sum(value) DESC*/
			
			
			
				}
			
			//$top5
			if(count($slected_country)==5){
				$arr = $slected_country;
			}elseif(count($slected_country)==0){
				$arr = $top5;
			}else{//merge
				//$arr = $slected_country;
				$arr = array();
				foreach($slected_country as $s){
					$arr[$s->id] = $s;
					$slected_ids[] = $s->id;
				}
				foreach($top5 as $t){
					$arr[$t->id] = $t;
					$top5_country[] = $t->country;
				}
				
				
				/*
				$arr2 = [];
				foreach($arr as $v){
					$arr2[] = $v;
				}
				$arr = $arr2;
				for($i=0;$i<count($arr);$i++){
					for($j=0;$j<count($arr);$j++){
						if($arr[$i]->value > $arr[$j]->value){
							$x = $arr[$i];
							$arr[$i] = $arr[$j];
							$arr[$j] = $x;
						}
					}
				}*/
				
				/*
				$nbr_to_hide = count($slected_ids)+count($top5_country) - 5;
				//$slected_country;
				
				for($i=0;$i<count($arr);$i++){
					if($nbr_to_hide>0 and in_array($arr[$i]->country,$top5_country)){
						unset($arr[$i]);
						$nbr_to_hide-=1;
					}
				}
				
				
				$arr2 = [];*/
				$i=0;
				foreach($arr as $r){
					$arr2[] = $r;
					if($i==4)
						break;
					$i++;
				}
				
				$arr = $arr2;
				
				
			}
			
			
			
			//get max val
			$maxval=0;
			foreach($arr as $r){
				if($r->value>$maxval)
				$maxval = $r->value;
			}
			
			$maxval = round($maxval+($maxval/5), -1);
				$first = (int)($maxval/3);
				$second = (int)(2*($maxval/3));
				$last = (int)(3*($maxval/3));
				
				
				for($i=0;$i<count($arr);$i++){
				$arr[$i]->percent = round(($arr[$i]->value*100)/$maxval,2);
				}
				
				$data['options'] = array($first,$second,$last);
				$data['data'] = $arr;
				
				
				
				

				
				return $data;
			break;
			case 'top_city':
			
				$slected_city = array();
				$top5_id = [];
				$year = (int)$year;
				$month = (int)$month;
				
				$tcities = @explode(',',$cities);
				foreach($tcities as $k=>$v){
					$tcities[$k] = str_replace("'","",$v);
				}
				$cities = implode(",",$tcities);
				
				
				/*echo print_r($cities);
				exit;*/
				$arrwhere = array();
				$where = " Where `type`='city'";
				
				if($year!=0){
					$where = $where." and `year`=?";
					$arrwhere[] = $year;
				}
				if($month!=0){
					$where = $where." and `imonth`=?";
					$arrwhere[] = $month;
				}
				
				$top5 = DB::select("SELECT *,sum(value) as 'value','0' as 'percent' 
				FROM `stat_house_sales`
				$where and `city` not in ('". str_replace(",","','",$cities)."') 
				group by city
				order by sum(value) DESC
				limit 5",$arrwhere);

				if($cities!=''){
					$where = $where." and `city` in ('". str_replace(",","','",$cities)."') ";

					//$arrwhere[] = "('". str_replace(",","','",$cities)."')";
					//$arrwhere[] = "'".implode("','",$tcities)."'";
				$slected_city = DB::select("SELECT *,sum(value) as 'value','0' as 'percent'
				FROM `stat_house_sales`
				$where
				group by city
				order by field(city,'". str_replace(",","','",$cities)."')
				limit 5",$arrwhere);/*order by sum(value) DESC*/
			
			
			
				}
			
			//$top5
			if(count($slected_city)==5){
				$arr = $slected_city;
			}elseif(count($slected_city)==0){
				$arr = $top5;
			}else{//merge
				$arr = array();
				foreach($slected_city as $s){
					$arr[$s->id] = $s;
					$slected_ids[] = $s->id;
				}
				foreach($top5 as $t){
					$arr[$t->id] = $t;
					$top5_city[] = $t->country;
				}
				/*$arr = array();
				foreach($top5 as $t){
					$arr[$t->id] = $t;
					$top5_city[] = $t->city;
				}
				foreach($slected_city as $s){
					$arr[$s->id] = $s;
					$slected_ids[] = $s->id;
				}
				
				$arr2 = [];
				foreach($arr as $v){
					$arr2[] = $v;
				}
				$arr = $arr2;
				for($i=0;$i<count($arr);$i++){
					for($j=0;$j<count($arr);$j++){
						if($arr[$i]->value > $arr[$j]->value){
							$x = $arr[$i];
							$arr[$i] = $arr[$j];
							$arr[$j] = $x;
						}
					}
				}
				
				
				$nbr_to_hide = count($slected_ids)+count($top5_city) - 5;
				//$slected_city;
				
				for($i=0;$i<count($arr);$i++){
					if($nbr_to_hide>0 and in_array($arr[$i]->city,$top5_city)){
						unset($arr[$i]);
						$nbr_to_hide-=1;
					}
				}*/
				
				$i=0;
				foreach($arr as $r){
					$arr2[] = $r;
					if($i==4)
						break;
					$i++;
				}
				
				$arr = $arr2;
				
				
			}
			
			//get max val
			$maxval=0;
			foreach($arr as $r){
				if($r->value>$maxval)
				$maxval = $r->value;
			}
			
			$maxval = round($maxval+($maxval/5), -1);
			$first = (int)($maxval/3);
			$second = (int)(2*($maxval/3));
			$last = (int)(3*($maxval/3));
				
				
				for($i=0;$i<count($arr);$i++){
				$arr[$i]->percent = round(($arr[$i]->value*100)/$maxval,2);
				}
				
				$data['options'] = array($first,$second,$last);
				$data['data'] = $arr;
				
				
				
				

				
				return $data;
			break;
			default:
			
			break;
		}
		
}
public static function ar_slug($str, $limit = null) {
    if ($limit) {
        $str = mb_substr($str, 0, $limit, "utf-8");
    }
    $text = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    // trim
    $text = trim($text, '-');
    return $text;
}
public static function get_json_Video($v){
	$data['id'] = @explode('=',$v->link)[1];
	$data['_id'] = $v->id;
	//if(count(explode(',',$v->lang))>1)
	if((int)$v->project_id != 0)
		$data['title'] = $v->project->getIntroCard();
	else
		$data['title'] = $v->title;
	
	$data['slug'] = $v->slug;
	$data['views'] = $v->getViews();
	$data['likes'] = $v->getLikes();
	$data['image'] = $v->pic;
	$data['class'] = 'section';
	$data['date'] = Helper::time_elapsed_string($v->date_published);

	return $data;
}

public static function get_json_Video_projects($project){
	$link_video = $project->getLinkVideo();
	$detail = $project->Detail;
	parse_str(parse_url($link_video, PHP_URL_QUERY), $array_of_vars);
	$data['id'] = @$array_of_vars['v'];
	
	
	$data['_id'] = $project->id;
	$data['slug'] = $project->slug;
	$data['title'] = $project->getIntroCard();
	
	$data['views'] = $detail->getViews();
	$data['likes'] = $detail->getLikes();
	
	$data['image'] = Helper::get_thumbnail($project->cardphoto, 817, 454);
	$data['class'] = 'project';
	$data['date'] = Helper::time_elapsed_string($project->created_at);

	return $data;
}
public static function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
	$current_lang = LaravelLocalization::getCurrentLocale();
    
	if($current_lang=='ar')
	$string = array(
        'y' => 'سنة',
        'm' => 'شهور',
        'w' => 'اسبوع',
        'd' => 'يوم',
        'h' => 'ساعة',
        'i' => 'دقيقة',
        's' => 'ثانية',
    );
	else
	$string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
	
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
			if($current_lang=='ar')
				$v = $diff->$k . ' ' . $v;
			else
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
	if($current_lang=='ar')
		return $string ? 'قبل ' .implode(', ', $string) : 'الان';
	else
		return $string ? implode(', ', $string) . ' ago' : 'just now';
}


public static function get_json_project($project){

$current_lang = LaravelLocalization::getCurrentLocale();
$is_mobile = Helper::is_mobile() || Helper::is_tablet();
$infos = Helper::get_params();
$flavor = array();
if (/* Route::currentRouteName()!='front.search' and */ session()->get("filter_rooms") != '') {
    list($salon, $room) = explode('_', session()->get("filter_rooms"));


    $flavors = $project->flavors;

    foreach ($flavors as $f) {
        if ($f->room == $room and $f->salon == $salon and $f->sold_out == false) {
            $flavor = $f;
            break;
        }
    }


    if (empty($flavor)) {
        $arr_rooms = array('1_0', '1_1', '1_2', '1_3', '1_4', '1_5', '2_3', '2_4', '2_5', '2_6');
        $arr_s_r = array();
        foreach ($arr_rooms as $r) {
            if ($r == session()->get("filter_rooms"))
                break;
            $arr_s_r[] = $r;
        }

        $arr_s_r = array_reverse($arr_s_r);

        foreach ($flavors as $f) {
            if ($f->sold_out == false) {
                foreach ($arr_s_r as $r_s_r) {
                    if ($f->salon . '_' . $f->room == $r_s_r) {
                        $flavor = $f;
                        break;
                    }
                }
            }
        }
    }
}

if (empty($flavor)) {
    $flavors = $project->flavors();
    $flavors = $flavors->where('sold_out',false); //عدم عرض سعر الشقق المباعة 
    $flavor = $flavors->orderBy("price", "ASC")->first();

    if (empty($flavor)) {
        $flavors = $project->flavors();
        $flavor = $flavors->orderBy("price", "ASC")->first();
    }
}

$projects_flavors = $project->flavors;

$open_blank = @$open_blank ? true : false;
$cardphoto = @$project->cardphoto;
//$is_mobile = @$is_mobile;
$project_min_price = Helper::decimal_format(@$flavor->price, $project->is_price_usd);

			
$data['url'] = $project->frontUrl();

$iw = 360;
$ih = 280;
if (!$is_mobile) {
if (isset($page) and $page == 'index') {
$iw = 360;
$ih = 196;
} else {
$iw = 384;
$ih = 171;
}
} else {
if (isset($page) and $page == 'index') {
$iw = 360;
$ih = 282;
} else {
$iw = 363;
$ih = 258;
}
}


$data['pic'] = Helper::get_thumbnail($cardphoto, $iw, $ih);

$data['lat'] = substr($project->latitude,0,14);
$data['long'] = substr($project->longitude,0,14);
if(strlen($project_min_price)>8)
	$data['price'] = '<strong> '. Helper::curr_format() .'</strong> '. $project_min_price;
else
	$data['price'] = '<strong> '. Helper::curr_format() .'</strong> '. $project_min_price;

/*echo ''.session()->get("currency").'W';
echo $data['price'];
			exit;*/

$data['title'] = $project->getIntroCard();

$data['name'] = $project->getNameEn();


$link_video = $project->getLinkVideo();
parse_str(parse_url($link_video, PHP_URL_QUERY), $array_of_vars);
$video_code = @$array_of_vars['v'];
$data['youtube'] = '';
if($video_code!='')
$data['youtube'] = 'https://www.youtube.com/embed/' . $video_code.'?autoplay=1';
$data['video_code'] = $video_code;

list($sclass, $slab) = $project->getStatus();

if($sclass=='under-construction'){
$data['status'] = 'under-construction';
$data['deliverd_date'] = date("Y/m", strtotime($project->delivered_date));
}else{
$data['status'] = 'ready';
}
$data['payment_method'] = $project->payment_method;
$data['percent'] = $project->payment_percent;
$data['months'] = $project->payment_months;
$data['link_3d'] = $project->link_3d;
$data['city'] = $project->city->getName();
$data['region'] = $project->region->getName();

$data['cash_discount'] = (int)$project->cash_discount;

//$data['payment_method_trans'] = trans('front.' . $project->payment_method);
return $data;
}


	public static function get_campaing($navs){
		if($navs=='0' or $navs=='')
			return '';
		
		$t_navs = array_reverse(explode('>>',$navs));
		
		foreach($t_navs as $url){
			$target = Helper::get_target($url,true);
			if($target!='')
				return $target;
		}
		
		return '';
	}
	public static function get_target($url,$camp=false,$navs=''){
		
		if(/*strpos($url, 'call') !== false &&*/ $camp==false && $navs!=''){
			$t_navs = array_reverse(explode('>>',$navs));
		
			foreach($t_navs as $url){
				if(strpos($url, 'call:') === false){
					break;
					//return $url;
				}
			}
		}
		
		
		$url = str_replace(['www-damas-net.cdn.ampproject.org/v/s/','/amp','https://','www.'],'',$url);
		$url = str_replace(['/ar/','/en/','/fr/','/fa/','/pe/','/ru/'],'/',$url);
		$n = explode(':', $url);
		$url = trim($n[0]);
		
		$t = explode('?',$url);
		$url = @$t[0];
		$lang = LaravelLocalization::getCurrentLocale();
		if($lang!='ar')
			$lang = 'en';
		
		$ret = '';
		if (preg_match('#/(turkiye|oman|emirates|syria)/(buying-guide|guides)/([^/\?]+)#', $url, $m) || preg_match('#/(turkiye|oman|emirates|syria)/news/([^/\?]+)#', $url, $m)) {
			if($camp==true)
				return 'Blog';
			$post = \App\Models\Post::where("slug", isset($m[3]) ? $m[3] : $m[2])->first();
			if($post!=false)
				foreach ($post->categories()->lists('name_'. $lang) as $cat) {
					$ret = $cat;
					break;
				}
		} elseif (preg_match('#/(turkiye|oman|emirates|syria)/([^/]+)/([^/]+)/([^/\?]+)#', $url, $m)) {
			if($camp==true)
				return 'Project';
			$arr = DB::select("SELECT `name_".$lang."` as 'name' FROM `dms_projects` WHERE slug=?",[$m[4]]);
				if(isset($arr[0])){
					$ret = $arr[0]->name;
				}
		} elseif (strpos($url, '/projects/') !== false) {
			if($camp==true)
				return 'Project';
			
			$t = explode('projects/',$url);
			$arr = DB::select("SELECT `name_".$lang."` as 'name' FROM `dms_projects` WHERE slug=?",[$t[1]]);
				if(isset($arr[0])){
					$ret = $arr[0]->name;
				}
		
		}elseif (strpos($url, '/blog/category/') !== false) {//اسم التصنيف
			if($camp==true)
				return 'Blog';
			$t= explode('blog/category/',$url);
			if(isset($t[1])){
				$arr = DB::select("SELECT name_".$lang." as 'name'  FROM `dms_posts_categories` WHERE `slug`=?",[$t[1]]);
				if($arr[0]){
					$ret = $arr[0]->name;
				}
			}
		}elseif (strpos($url, '/blog/') !== false) {//اسم التصنيف
			if($camp==true)
				return 'Blog';
			$t = explode('blog/',$url);
			if(isset($t[1]) and strlen($t[1])>2){
				$slug = $t[1];
				$post = \App\Models\Post::where("slug", $slug)->first();
				if($post!=false)
					foreach ($post->categories()->lists('name_'. $lang) as $cat) {
						$ret = $cat;
						break;
					}
			}
		}elseif (strpos($url, '/blog') !== false) {//اسم التصنيف
			if($camp==true)
				return 'Blog';
			$ret = ($lang=='en'?'Blog':'المدونة');
		}elseif (strpos($url, '/investment') !== false) {
			if($camp==true)
				return 'Pages';
			$ret = ($lang=='en'?'Investment':'الإستثمار');
		}elseif (strpos($url, '/legal') !== false) {
			if($camp==true)
				return 'Pages';
			$ret = ($lang=='en'?'Legal':'شؤون قانونية');
		}elseif (strpos($url, '/jobs') !== false) {
			if($camp==true)
				return 'Pages';
			$ret = ($lang=='en'?'Jobs':'الوظائف');
		}elseif (strpos($url, '/living-turkey') !== false) {
			if($camp==true)
				return 'Pages';
			$ret = ($lang=='en'?'Living in turkey':'المعيشة في تركيا');
		}elseif (strpos($url, '/about-us') !== false) {
			if($camp==true)
				return 'Pages';
			$ret = ($lang=='en'?'About us':'من نحن');
		}elseif (strpos($url, '/turkish-citizenship') !== false) {
			if($camp==true)
				return 'Pages';
			$ret = ($lang=='en'?'Turkish citizenship':'الجنسية التركية');
		}elseif (strpos($url, '/video') !== false) {
			if($camp==true)
				return 'Pages';
			$ret = ($lang=='en'?'Video':'الفيديو');
		}elseif (strpos($url, '/faq') !== false) {
			if($camp==true)
				return 'Pages';
			$ret = ($lang=='en'?'FAQ':'الأسئلة الشائعة');
		}elseif (strpos($url, '/projects/') !== false) {
			if($camp==true)
				return 'Project';
			$ret = ($lang=='en'?'Project':'مشروع');
		}elseif (strlen(str_replace(['https://','damas.net'],'',$url))<3) {
			if($camp==true)
				return 'Pages';
			$ret = ($lang=='en'?'Home':'الرئيسية');
		}elseif (strpos($url, '-for-sale/') !== false or strpos($url, 'duplex/') !== false or strpos($url, 'land/') !== false or strpos($url, 'penthouse/') !== false) {
			
			if($camp==true)
				return 'Listings';
			
			
			$t = explode('/',$url);
			
			if(strpos($t[0], '-for-sale/') !== false or strpos($t[0], 'duplex/') !== false or strpos($t[0], 'land/') !== false or strpos($t[0], 'penthouse/') !== false){
				$i=0;
			}else{
				$i=1;
			}
			$type = $t[$i];
			$city = @$t[$i+1];
			$var1 = @$t[$i+2];
			$var2 = @$t[$i+3];
			$region = "";
				
			$arrs = DB::select("select name_". $lang ." as 'name' from dms_projects_types where slug=?",[$type]);
			if(isset($arrs[0])){
				$type = $arrs[0]->name;
			}
			
			if($type == 'property-for-sale')
				$type = ($lang=='en'?'Property':'عقارات');
			
			$arrs = DB::select("SELECT `name_". $lang ."` as 'name' FROM `dms_cities` WHERE slug=?",[$city]);
			if(isset($arrs[0])){
				$city = $arrs[0]->name;
			}
			
			$var1 = $var1 ? explode(",", $var1) : [];
			$var2 = $var2 ? explode(",", $var2) : [];
			
			$name_lang = 'name_'.$lang;
			$q_regions = Helper::query("Region", "whereIn", ["field" => "slug", "value" => $var1])->get();
			if ( count($q_regions) > 0 ) {
				$region = $q_regions[0]->$name_lang;
			}else{
				if ( $var2 ) {
					$q_regions = Helper::query("Region", "whereIn", ["field" => "slug", "value" => $var2])->get();
					$region = $q_regions[0]->$name_lang;
				}
            }
			
			if($region!='')
				$ret = $type . ($lang=='en'?' for sale in ':' للبيع في ') .$region;
			else
				$ret = $type . ($lang=='en'?' for sale in ':' للبيع في ') .$city;
		}

		/*if($ret=='')
			return $url;
		else*/
		
		return $ret;
	}
	
	
	public static function getNextLeadCode($crm=''){
	    
	    //$crm = str_replace('turkey','',$crm);
	    
		$last_lead_code = DB::connection('mysql_crm'.$crm)->table('params')->where("id", '1')->first()->last_lead_code;
		$alphabet =   array('A','B','C','D','E','F','G','H','I','J','K', 'L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		//$leads = DB::table('leads')->where('id','>',0)->get();
		$i=0;
		$findcode = false;
		foreach($alphabet as $a1){
			foreach($alphabet as $a2){
				for($a3=0;$a3<=9;$a3++){
					for($a4=0;$a4<=9;$a4++){
						if($last_lead_code=='ZZ99' or strlen($last_lead_code)>4){
							for($a5=0;$a5<=9;$a5++){
								if($findcode == true)
									return $a1.$a2.$a3.$a4.$a5;
								if($last_lead_code == $a1.$a2.$a3.$a4.$a5)
									$findcode = true;
							}
						}else{
						if($findcode == true)
							return $a1.$a2.$a3.$a4;
						if($last_lead_code == $a1.$a2.$a3.$a4)
							$findcode = true;
						}
					}
				}
			}
		}
	
	}
	public static function getNextHrCode(){
		$last_lead_code = DB::connection('mysql_crm')->table('params')->where("id", '1')->first()->last_hr_code;
		$alphabet =   array('A','B','C','D','E','F','G','H','I','J','K', 'L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		//$leads = DB::table('leads')->where('id','>',0)->get();
		$i=0;
		$findcode = false;
		foreach($alphabet as $a1){
			foreach($alphabet as $a2){
				for($a3=0;$a3<=9;$a3++){
					for($a4=0;$a4<=9;$a4++){
						if($last_lead_code=='ZZ99' or strlen($last_lead_code)>4){
							for($a5=0;$a5<=9;$a5++){
								if($findcode == true)
									return $a1.$a2.$a3.$a4.$a5;
								if($last_lead_code == $a1.$a2.$a3.$a4.$a5)
									$findcode = true;
							}
						}else{
						if($findcode == true)
							return $a1.$a2.$a3.$a4;
						if($last_lead_code == $a1.$a2.$a3.$a4)
							$findcode = true;
						}
					}
				}
			}
		}
	
	}
}