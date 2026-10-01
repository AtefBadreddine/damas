<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\Paginator;
//use App\Http\Controllers\Front\Response;
use Validator;
//use App\Notifications\AgendamentoPendente;
use Helper;
use DB;
use Session;
use File;
use URL;
use Image;
use Input;
use Mail;
use Jenssegers\Agent\Agent;
use App\Models\Post;
use App\Models\PostCategory;
use MaxMind\Db\Reader;
use Cookie;
//use App\Models\RedirectShort;
//use App\Http\Controllers\Front\Session;
//App\Http\Controllers\Front\ZCRMModule
class HomeController extends BaseController
{
    
    /**
    * index
    *
    * @return view
    */
    public function index(Request $request)
    {
		
		/*
		//redirect to browser language
		if(!isset($_SERVER['HTTP_REFERER']) && isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
			
			$browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
			$browser_lang = ($browser_lang =='fa'?'pe': $browser_lang);
			
			if(\LaravelLocalization::getCurrentLocale() == 'ar'){
				if($browser_lang!='ar' && in_array($browser_lang,['fr', 'pe', 'ru', 'en'])){
					
					return Redirect::to(\LaravelLocalization::getLocalizedURL($browser_lang));
				}
			}
		}
		*/
		
		//session()->set("iso_country", 'TR');
		/*print_r($_SESSION);
		exit;*/
		//$lang = \LaravelLocalization::getCurrentLocale();
		$device = Helper::get_device();
		/*if(count($_GET)==0 and file_exists("tmp/index-".$lang."-".$device.".html")){
			readfile("tmp/index-".$lang."-".$device.".html");
			exit();
		}else{*/
		
		
		
		$agent = new Agent();
			
		/*$id = $request->get('id',null);
		$hash = $request->get('hash',null);
		$cron_job = $request->get('cron_job',null);
		if($cron_job && $request->has('device') && $hash == md5($id).'b01'.sha1($id)){
			$result = view("front.index", compact("agent"));
			$result = str_replace(array('    ','  '),' ',$result);
			$result = str_replace('?cron_job=true&device=full&hash=77e84768cef2ae5949bf793cac3d7711b010d17fe604dccd84493d56367970167dcda121f54&id=2319508','',$result);
			$result = str_replace('cron_job=true&device=full&hash=77e84768cef2ae5949bf793cac3d7711b010d17fe604dccd84493d56367970167dcda121f54&id=2319508','',$result);

			file_put_contents("tmp/index-".$lang."-".$request->get('device').".html", $result);
			return response()->json(['success' => 'success'], 200);
		}else{*/
		
		
		$projects_count = DB::select("select `dms_cities`.slug,`dms_cities`.media_index,`dms_cities`.`name_ar`,`dms_cities`.`name_en`,`dms_cities`.`name_fr`,`dms_cities`.`name_fa`,`dms_cities`.`name_ru`,count(dms_projects.id) as 'cnt'
		from dms_cities,dms_projects
		where dms_cities.id=dms_projects.city_id and dms_projects.published=1  and sold!=100
		group by `dms_cities`.`id`
		order by count(dms_projects.id) desc");
		
			return view("front.index", compact("agent","projects_count"));
		//}
		//}
    }
	
	
	/**
    * callmeModalAjax
    *
    * @return void
    */
	 public function callmeModalAjax(Request $request ){
	
			return view("front.callmeModalAjax");
    }


	/**
    * redirect short url
    *
    * @return void
    */
    public function redirect_url($slug ,Request $request )
    {
		/*echo $slug;
		exit;*/
		$get = '';
		foreach($_GET as $k=>$v){
			if($get=='')
				$get = $k . '=' . $v;
			else
				$get = $get .'&'. $k . '=' . $v;
		}
		
		
		$pageRoutes = [
			'investment' => 'front.investment',
			'legal' => 'front.legal',
			'living_turkey' => 'front.living_turkey',
			'privacy' => 'front.privacy',
			'terms' => 'front.terms',
		];
		if(isset($pageRoutes[$slug])){
			return Redirect::to(route($pageRoutes[$slug]) . ($get==''?'':'?' . $get), 301 );
		}
		
		$link = \App\Models\RedirectShort::where('slug',$slug)->first();
		if(!$link){
			abort(404);
		}else{
			$link->hits +=1;
			$link->save();

			
			//check is media url
			if(strpos($link->url, '/media/') !== false){
				$u = explode('/media/',$link->url);
				
				
				/*echo $u[1];
				exit;*/
				echo $this->project_data($request,$u[1]);
				exit;
			}
			
			if(isset($_GET['id']))//$slug=='jX7'
				$url = $link->url . '&text=.' . $_GET['id'];
			else
				$url = $link->url;
			/*echo ($url . (strpos($url, '?') !== false?'&'.$get:'?' . $get));
			exit;*/
			return \Redirect::to($url . (strpos($url, '?') !== false?'&'.$get:'?' . $get), 301);
			}
	}

    /**
    * load more
    *
    * @return void
    */
    public function loadmore(Request $request)
    {
		$page = $request->get("page", null);
		$cat = $request->get("cat", null);
		$data['cat'] = $cat;
        $data['current_lang'] = \LaravelLocalization::getCurrentLocale();
        $data['infos'] = Helper::get_params();
        $data['device'] = Helper::get_device();

		if($page==''){
		switch($cat){
        case '1':
		return view("front.loadmore_index.how-to-use", $data);
		break;
		case '2':
        return view("front.loadmore_index.project_sliders", $data);
		break;
        case '3':
		return view("front.loadmore_index.most_watched", $data);
		break;
		/*case '4':
		return view("front.loadmore_index.news", $data);
		break;*/
		case '4':
		return view("front.loadmore_index.paragraph", $data);
		break;
		case '5':
		return view("front.loadmore_index.videos", $data);
		break;
		case '6':
		return view("front.loadmore_index.about-damas", $data);
		break;
		case '7':
		return view("front.loadmore_index.certificat", $data);
		break;
		case '8':
		return view("front.loadmore_index.call-us", $data);
		break;
		default:

		}
		}elseif($page=='land'){
			$landid = $request->get("id", null);
			$data['landing'] = Helper::query("LandingPage", "where", ["field" => "id", "value" => $landid])->first();
		
			$data['project'] = $data['landing']->project;
			$data['images'] = $data['project']->projectPhotos;

		switch($cat){
        case '1':
		return view("front.loadmore_land.main_card", $data);
		break;
		case '2':
        return view("front.loadmore_land.section_strategy", $data);
		break;
        case '3':
		return view("front.loadmore_land.location-importance", $data);
		break;
		case '4':
		return view("front.loadmore_land.section-location", $data);
		break;
        case '5':
		return view("front.loadmore_projects.statistics", $data);
		break;
		case '6':
		return view("front.loadmore_land.how-to-use", $data);
		break;
		case '7':
		return view("front.loadmore_land.price-table", $data);
		break;
		case '8':
		return view("front.loadmore_land.video", $data);
		break;
		case '9':
		return view("front.loadmore_land.maps", $data);
		break;
		case '10':
		return view("front.loadmore_land.call-us", $data);
		break;
		case '11':
		return view("front.loadmore_land.our_services", $data);
		break;
		case '12':
		return view("front.loadmore_land.certificat", $data);
		break;
		case '13':
		return view("front.loadmore_land.about-damas", $data);
		break;
		default:
		}
		}elseif($page=='project'){
			$id = $request->get("id", null);
			$data['project'] = Helper::query("Project", "where", ["field" => "id", "value" => $id])->first();
			//$data['landing'] = Helper::query("LandingPage", "where", ["field" => "id", "value" => $landid])->first();
		
			//$data['project'] = $data['landing']->project;
			//$data['images'] = $data['project']->projectPhotos;

		switch($cat){
        case '1':
		return view("front.loadmore_projects.main_card", $data);
		break;
		case '2':
        return view("front.loadmore_projects.section_strategy", $data);
		break;
        case '3':
		return view("front.loadmore_projects.location-importance", $data);
		break;
        case '4':
		return view("front.loadmore_projects.section-location", $data);
		break;
        case '5':/*last*/
		return view("front.loadmore_projects.video", $data);
		break;
        case '6':
		return view("front.loadmore_projects.statistics", $data);
		break;
		case '7':
		return view("front.loadmore_projects.price-table", $data);
		break;
		case '8':
		return view("front.loadmore_projects.maps", $data);
		break;
		case '9':
		return view("front.loadmore_projects.call-us", $data);
		break;
		case '10':
		return view("front.loadmore_projects.related_projects", $data);
		break;/*
		case '8':
		return view("front.loadmore_projects.related_articles", $data);
		break;*/
		case '11':
		return view("front.loadmore_projects.certificat-about-mostview", $data);
		default:

		}
		}elseif($page=='blog'){
		return view("front.blog.loadmore_blog", $data);
		}elseif($page=='blogcategory'){
			$data['cnt_pg'] = $request->get("cnt_pg", null);
			$data['slug'] = $request->get("slug", null);
		return view("front.blog.loadmore_blogcategory", $data);
		}
    }
    /**
    * districts
    *
    * @param string $slug
    * @return void
    */
    public function districts($slug)
    {
		$city = Helper::query("City", "where", ["field" => "slug", "value" => $slug])->first();
		if($city==false or $city->enable_district_page==false)
		abort(404);
		
		$regions = $city->regions()->where('show_on_districts_page',true)->get();
		
        return view("front.districts_page", compact("city","regions"));
	}
    /**
    * district detail
    *
    * @param string $slug
    * @return void
    */
    public function district_detail($slug,$region_slug)
    {
		$city = Helper::query("City", "where", ["field" => "slug", "value" => $slug])->first();
		if($city==false or $city->enable_district_page==false)
			abort(404);
		
		$regions = $city->regions()->where('show_on_districts_page',true)->where('city_id',$city->id)->get();
		$region = $city->regions()->where('show_on_districts_page',true)->where('slug',$region_slug)->first();
		
		if($region==false)
			abort(404);
		
        return view("front.district_detail", compact("city","region","regions"));
	}
	/**
    * show project
    *
    * @param string $slug
    * @return void
    */
    public function project_show(Request $request, $slug)
    {
		$countrySlug = $this->legacyCountrySlug($request);
		if ( $countrySlug ) {
			$project = \App\Models\Project::findInCountry($countrySlug, $slug);
		} else {
			$project = \App\Models\Project::findUnambiguousBySlug($slug);
		}
        if ( !$project ) abort(404);

		$geoUrl = $project->geoUrl();
		if ( $geoUrl ) {
			$query = request()->getQueryString();
			return Redirect::to($geoUrl . ($query ? '?' . $query : ''), 301);
		}

		abort(404);
    }
    /**
    * preview pdf
    *
    * @param int $id
    * @return void
    */
    public function preview_pdf($id)
    {
        $project = Helper::query("Project", "where", ["field" => "id", "value" => $id])->first();
        if ( !$project or $project->file_pdf=='')
			abort(404);
		
        if('fr'==@$_GET['lang'])
			return view("front.preview_pdf", ['pdf'=>$project->file_pdf_fr]);
		elseif('en'==@$_GET['lang'])
			return view("front.preview_pdf", ['pdf'=>$project->file_pdf_en]);
		else
			return view("front.preview_pdf", ['pdf'=>$project->file_pdf]);
    }
    /**
    * project data
    *
    * @param int $id
    * @return void
    */
    public function project_data(Request $request,$id)
    {
		$country = $this->legacyRouteValue($request, 'country') ?: 'turkey';

		if(strpos(URL::current(), '/media/') !== false /*&& !isset($_GET['abc1qa445zs45zde8defr45rfr5'])*/){
			
			if((strpos($request->headers->get('referer'), 'crm.damas.net/app') !== false )){
			
			}elseif(isset($_GET['mt'])){
				
				$gtime = Helper::timecrypt($_GET['mt'],true);
				$t = time()-99999;
				if(($gtime<$t && $gtime>$t-(60*3))){
				//echo $gtime.'<'.$t. 'y<br>';
				//echo $gtime . 'e<br>';
				//exit;
				}else{
				exit();
				}
			}else{
				exit;
			}

		}
		
		
		
		//app()->setLocale('en');
		
		$t = explode('?',$id);
		if(isset($t[0]))
			$id = $t[0];
		if(isset($t[1])){
			$get = $t[1];
			$_GET['display'] = str_replace('display=','',$t[1]);
		}
		
        $video_about = \App\Models\Video::where("show_on_media",true)->first();
		//$id='D845';
        $project = \App\Models\Project::findInCountry($country, $id);
        if ( !$project ) {
            $countryId = \App\Models\Country::resolveId($country);
            $query = \App\Models\Project::where("name_en", strtoupper($id));
            if ( $countryId ) {
                $query->whereHas('city', function ($q) use ($countryId) {
                    $q->where('country_id', $countryId);
                });
            }
            $project = $query->first();
        }
        //echo $project->name_en;
		if ( !$project ) abort(404);
		
		
		
		/*if($project->city->country!=$country){
		    //echo $project->city->country."!=".$country;
		    return Redirect::to(route("front.index"). ($country=='turkey'?'/oman':'') ."/media/". $project->slug , 301 );
		}*/
		
		
        /*if ( isset($_SERVER["HTTP_REFERER"]) ) {
            $project->views += 1; $project->save();
        }*/
		$request->session()->put("currency",'TRY');
		$is_proj_data=true;
        return view("front.project_data", compact("project","video_about","country","is_proj_data"));
    }
    /**
    * turkish citizenship
    *
    * @param string $slug
    * @return void
    */
    public function turkish_citizenship()
    {
		$page = Helper::query("Page", "where", ["field" => "slug", "value" => "turkish-citizenship"])->first();
		
        return view("front.turkish_citizenship", compact("page"));
    }

    public function whatsapp_share(Request $request)
    {/*
		echo '<pre>';
		print_r($_SERVER);
		//echo file_get_contents('/botchecker/index.php?ip=127.0.0.1');
		exit;*/
		
		
		
		//$inputs["page"] = $request->get("page", null);
		$infos = Helper::get_params();

		/* Device */
		$agent = new Agent();
		$inputs["device_type"] = $agent->device();//Iphone
		
		if($inputs["device_type"]=='Bot'){
			return Redirect::to("https://api.whatsapp.com/send?phone=905551605000");
		}
		
		$inputs["platform"] = $agent->platform();//iOS
		
		if($inputs["device_type"]=='0' and $inputs["platform"]=='0'){
			return Redirect::to("https://api.whatsapp.com/send?phone=905551605000");
		}
		
		
		$inputs["browser"] = $agent->browser();//chrome
		

		/*
		echo $inputs["device_type"].$inputs["platform"].$inputs["browser"];
		exit;*/
		if ( $agent->isMobile() ) {
			$inputs["device"] = "Mobile";
		} elseif ( $agent->isTablet() ) {
			$inputs["device"] = "Tablet";
		} else {
			$inputs["device"] = "Desktop";
		}
		
		
		/*if(isset($_SERVER['HTTP_CF_IPCOUNTRY']))
			$inputs["country"] = $_SERVER["HTTP_CF_IPCOUNTRY"];*/
		
		$inputs["country"] = @session()->get("iso_country");
		
		
		
		
		if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
			$inputs["ip"] = $_SERVER["HTTP_CF_CONNECTING_IP"];
		else
			$inputs["ip"] = @$_SERVER['HTTP_X_REAL_IP']; //\Request::ip();
		
		
	
		if($request->get("tel") != '')
			$whatsapp_num = $request->get("tel");
		else
			$whatsapp_num = Helper::whatsappNumber();
		
		$whatsapp_num = str_replace(' ','',$whatsapp_num);
		$whatsapp_num = str_replace('+','',$whatsapp_num);

		if(in_array($inputs["ip"],['51.210.121.151'])){
			return Redirect::to("https://api.whatsapp.com/send?phone=".$whatsapp_num);
		}
		
		
		
		$row_w = \App\Models\Whatsappmsg::where('ip',$inputs["ip"])->whereNull('code')->first();
		
		if($row_w != false){
			
			
			
			$whatsapp_text = $infos->whatsapp_share;
			
			$txt = '';
			if(isset($_GET['txt']))
				$txt = ' '.$_GET['txt'];
			
			$whatsapp_text = $row_w->id . $txt . ". ".$whatsapp_text; /*.". ". ($inputs["page"]) ." "*/
			
			return Redirect::to("https://api.whatsapp.com/send?phone=$whatsapp_num&text=$whatsapp_text");
			exit;
		}
		
		$inputs["page"] = \URL::previous();
		
		// Source visitor
		$cookie_reffer = Cookie::get("reffer");
		$coourl = parse_url($cookie_reffer);
		if ( ($cookie_reffer != str_replace('gclid=', '', $cookie_reffer)) or ($inputs["page"] != str_replace('gclid=', '', $inputs["page"])) ){
			$inputs["src"] = "Adwords";
		} else {
			$inputs["src"] = @$coourl['host'] ? $coourl['host'] : (@$coourl['path'] ? $coourl['path'] : 'دخول مباشر');
		}
		
		if(Cookie::get('gclid')!=''){
			$inputs["gclid"] = Cookie::get('gclid');
			$inputs["src"] = "Adwords";
			
		}
			if(Cookie::get('tags')!='')
			$inputs["tags"] = Cookie::get('tags');
		
		if ( $inputs["src"] == "دخول مباشر" ) {
			$inputs["full_src"] = "دخول مباشر";
			
		} else {
			$inputs["full_src"] = $cookie_reffer;
		}
					if(str_replace('ampproject','',$inputs["page"]) != $inputs["page"]){
						$inputs["src"] = 'Google AMP';
					}elseif(str_replace('fbclid','',$inputs["page"]) != $inputs["page"]){
						$inputs["src"] = 'facebook.com';
					}
		
		if(($inputs['src'] == 'Direct' or $inputs['src'] == "دخول مباشر")  && strpos(strtolower($inputs["src"]), 'damasturk') === false){
			
			if(strpos(strtolower($inputs["src"]), 'ampproject') !== false)
				$inputs['src'] = 'Google AMP';
			elseif(strpos(strtolower($inputs["src"]), 'mail.google.com') !== false)
				$inputs['src'] = 'Gmail';
			elseif(strpos(strtolower($inputs["src"]), 'google') !== false)
				$inputs['src'] = 'Google';
			elseif(strpos(strtolower($inputs["src"]), 'facebook') !== false)
				$inputs['src'] = 'Facebook';
			elseif(strpos(strtolower($inputs["src"]), 'youtube') !== false)
				$inputs['src'] = 'Youtube';
			elseif(strpos(strtolower($inputs["src"]), 'instagram') !== false)
				$inputs['src'] = 'Instagram';
				
				
			$inputs['src'] = str_replace('wwww.','',$inputs['src']);
			if(in_array(substr($inputs['src'], -4) , ['.net','.com']))
				$inputs['src'] = substr($inputs['src'], 0,-4);
			
			
			if(isset($_POST['src']) && $_POST['src']!=''){
				$inputs['src'] = $_POST['src'];
				//$inputs["full_src"]  = $_POST['src'];
			}
		}
		
		$inputs["navigation"] = Helper::clean_navigation(Cookie::get('navigation')). '>>call:'. (time()-1665411611);
		if($request->get("icon") == '1' or $request->get("icon") == '01')
			$inputs["form_type"] = 'الهيدر';
		elseif($request->get("icon") == '2')
			$inputs["form_type"] = 'الإستمارة';
		elseif($request->get("icon") == '21')
			$inputs["form_type"] = 'قسم خدمة العملاء';
		elseif($request->get("icon") == '22')
			$inputs["form_type"] = 'قسم مدير المبيعات';
		elseif($request->get("icon") == '3')
			$inputs["form_type"] = 'استمارة بوب اب';
		elseif($request->get("icon") == '4')
			$inputs["form_type"] = 'استمارة الفوتر';
		elseif($request->get("icon") == '101')
			$inputs["form_type"] = 'قسم كيف تستخدم موقعنا';
		elseif($request->get("icon") == '5')
			$inputs["form_type"] = 'استمارة شبكات التواصل';
		elseif($request->get("icon") == '7')
			$inputs["form_type"] = 'صفحة الهبوط - الهيدر';
		elseif($request->get("icon") == '8')
			$inputs["form_type"] = 'صفحة الهبوط - مدير المبيعات';
		elseif($request->get("icon") == '9')
			$inputs["form_type"] = 'صفحة الهبوط -الفوتر';
		elseif($request->get("icon") == '10')
			$inputs["form_type"] = 'بانر - بلوق';
		elseif($request->get("icon") == '11')
			$inputs["form_type"] = 'صفحة العروض';
		elseif($request->get("icon") == '12')
			$inputs["form_type"] = 'صفحة هبوط العروض';




		if(($inputs["src"] == "دخول مباشر" &&  $inputs["full_src"] == "دخول مباشر" &&  $inputs["navigation"] == "" && ($inputs["platform"]=='0') && ($inputs["device_type"]=='Bot' or $inputs["device_type"]=='0'))
		or ( $inputs["src"] == "دخول مباشر" &&  $inputs["full_src"] == "دخول مباشر" &&  ($inputs["country"] == "SE" or  $inputs["country"] == "CA"))
		){
			
		}else{
		if (!$request->session()->has('demande_id')) {

			if($request->session()->has('searchs.id'))
				$inputs["search_fields"] = urlencode(serialize($request->session()->get('searchs.id', [])));
			
			
			$arrsip = DB::select("SELECT * from blackips where ip=?",[$inputs['ip']]);
			if(count($arrsip)>0){
				return Redirect::to("https://api.whatsapp.com/send?phone=".$whatsapp_num);
			}else{
				$result = json_decode(file_get_contents('https://damas.net/botchecker/check.php?ip='.$inputs['ip']));
				if($result->allow=='1'){
					
				}else{
					DB::insert("INSERT INTO `blackips`( `ip`) VALUES (?)",[$inputs['ip']]);
					return Redirect::to("https://api.whatsapp.com/send?phone=".$whatsapp_num);
				}
			}



			$saved_message = Helper::query("Whatsappmsg", "save", [
                    "inputs"    =>  $inputs,
                ]);


		/*
		//اعتقد فقط بعدما يتم تحديث النقرة في الادمن
		//عندها ترسل الى CRM ايضا
		if(strpos(strtolower($inputs["src"]), 'ampproject') !== false)
			$inputs['src'] = 'Ampproject';
		elseif(strpos(strtolower($inputs["src"]), 'mail.google.com') !== false)
			$inputs['src'] = 'Gmail';
		elseif(trim($inputs["src"]) == 'دخول مباشر')
			$inputs['src'] = 'Direct';
		elseif(strpos(strtolower($inputs["src"]), 'google') !== false)
			$inputs['src'] = 'Google';
		elseif(strpos(strtolower($inputs["src"]), 'facebook') !== false)
			$inputs['src'] = 'Facebook';*/
		
		
		
		
		
		
		$request->session()->put('demande_id', $saved_message->id);
		}
		}

		if($request->get("tel") != '')
			$whatsapp_num = $request->get("tel");
		else
			$whatsapp_num = Helper::whatsappNumber();
		
		$whatsapp_num = str_replace(' ','',$whatsapp_num);
		$whatsapp_num = str_replace('+','',$whatsapp_num);
		
		$whatsapp_text = $infos->whatsapp_share;
		
		$txt = '';
		if(isset($_GET['txt']))
			$txt = ' '.$_GET['txt'];
		
		$whatsapp_text = $request->session()->get('demande_id') . $txt . ". ".$whatsapp_text; /*.". ". ($inputs["page"]) ." "*/
		
        return Redirect::to("https://api.whatsapp.com/send?phone=$whatsapp_num&text=$whatsapp_text");
    }

    /**
    * ajax
    *
    * @return void
    */
    public function ajax(Request $request,$option)
    {
		if($option=='increment_visit'){
			DB::update("UPDATE `dms_posts` SET views = views+1 where id=?",[@$_POST['post']]);
			return response()->json(['success' => true ]);
		}elseif($option=='call_country'){
			/*if(isset($_GET['e4'])){
				exit('404');
			}*/
			$arr = [];
			foreach($_GET as $k=>$v){
				$arr[str_replace('amp;','',$k)] = $v;
			}
			$_GET = $arr;
			
			if(isset($_GET['sHTTP_REFERER']))
				$_GET['sHTTP_REFERER'] = urldecode($_GET['sHTTP_REFERER']);

			if(isset($_GET['sREQUEST_URI']))
				$_GET['sREQUEST_URI'] = urldecode($_GET['sREQUEST_URI']);

			if ( isset($_GET['sHTTP_REFERER']) and (strpos(strtolower($_GET['sHTTP_REFERER']), 'https://damas.net')===false or strpos(strtolower($_GET['sHTTP_REFERER']), 'https://damas.net')!==0)) {
				//setcookie("reffer", ($_GET['sHTTP_REFERER']), time()+86400, "/"/*, "damas.net", 1*/);
				Cookie::queue('reffer', $_GET['sHTTP_REFERER'] , 60*24*30);
			}

			if ( isset($_GET['sREQUEST_URI'])) {
				$str = ($_GET['sREQUEST_URI']);
				if(
					strpos($str, '/rss') === false 
				and strpos($str, '.css') === false 
				and strpos($str, '.ttf') === false 
				and strpos($str, '.png') === false 
				and strpos($str, '.jpg') === false 
				and strpos($str, '/uploads/') === false 
				and strpos($str, '.js') === false 
				and strpos($str, 'call') === false 
				and strpos($str, '/loadmore') === false 
				and strpos($str, '/like') === false 
				and strpos($str, 'ajax') === false 
				/*and strpos($str, 'confirmation') === false*/
				and strpos($str, '/Ryl') === false
				and strpos($str, '/fonts') === false
				and strpos($str, '/newsletter') === false
				and strpos($str, '/whatsapp_share') === false
				and strpos($str, '.svg') === false
				){
					//setcookie("navigation", @$_COOKIE['navigation'] . (@$_COOKIE['navigation']!=''?' >> ':'') . 'damas.net' . strtok($str,'?').':'.time() , time()+3600, "/", "damas.net", 1);
					if(strlen(Cookie::get('navigation'))<=1950)
						Cookie::queue('navigation', Cookie::get('navigation') . (Cookie::get('navigation')!=''?' >> ':'') . '' . strtok($str,'?').':'. (time()-1665411611) , 60*24*2);
					
					}
			}
			
			if(isset($_GET['gclid'])){
				//setcookie('gclid', $_GET['gclid'], time() + (86400 * 90), "/");
				//setcookie('tags', json_encode($_GET), time() + (86400 * 90), "/");
				
				Cookie::queue('gclid', $_GET['gclid'] , 60*24*30);
				Cookie::queue('tags', json_encode($_GET) , 60*24*30);
			}
			
			if(isset($_GET['utm_source']) or isset($_GET['campaign-name'])){
				Cookie::queue('tags', json_encode($_GET) , 60*24*30);
				//setcookie('tags', json_encode($_GET), time() + (86400 * 90), "/");
			}
			//Cookie::queue('testc', Cookie::get('testc') . "-->" . time() , 15);
			
			
			return response()->json(['call_country' => @session()->get('call_country') ]);
			
			
			
	}elseif($option=='submit_resale'){
			$type = \App\Models\ProjectType::where('id',@$_POST['type_id'])->first();
			$inputs = $request->all();

			
			
			$inputs['status'] = 'on';
			$inputs['name'] = substr(ucfirst($type->name_en), 0, 1);
			
			
				$inputs['created_at'] = date('Y-m-d H:i');
			
			
			
			
			
			$inputs['phone'] = str_replace(' ','',@$inputs['phone']);
			$inputs['special_offer'] = '0';
			$inputs['updated_at'] = date('Y-m-d H:i');
			
			$inputs['user_name'] = 'Client';
			
			
			
			
			$arr = DB::select("SELECT city_id FROM `dms_resellprojects` where ajax_city_id=?  and city_id is not null",[$inputs['ajax_city_id']]);
			
			if(isset($arr[0])){
				$inputs['city_id'] = $arr[0]->city_id;
			}else{
				$inputs['city_id'] = 3;
			}
			
			$resellprojct = Helper::query("Resellproject", "save", [
				"inputs"    =>  $inputs,
				"id"        =>  $request->get("id"),
			]);
			
			
			$code = "R" . $resellprojct->name . $resellprojct->id;
			\App\Models\Resellproject::where('id',$resellprojct->id)->update(['code'=>$code ]);
			return response()->json(['success' => true , 'code' => $code ]);
		
		}elseif($option=='load_regions'){
			$regions = DB::select("select `TownID`, `CityID`, `TownName` from dms_resal_town where CityID=?",[@$_POST['city_id']]);
			$html = '<option value="">المنطقة</option>';
			foreach($regions as $r){
				$html = $html . '<option value="'.$r->TownID.'">'.$r->TownName .'</option>';
			}
			return $html;
		
		}elseif($option=='load_zones'){

			$zones = DB::select("SELECT `DistrictID`, `TownID`, `DistrictName` FROM `dms_resal_district` where TownID=?",[@$_POST['region_id']]);//]
			$html = '<option value="">الحي</option>';
			foreach($zones as $r){
				$html = $html . '<option value="'.$r->DistrictID.'">'. $r->DistrictName .'</option>';
			}
			return $html;		



		}elseif($option=='load_complex_regions'){
			$city = \App\Models\City::where('id',@$_POST['city_id'])->first();
			$regions = [];
			if($city!=false){
				$regions = $city->regions;
			}
			
			$html = '<option value="">' . trans("front.resale form title region") . '</option>';
			foreach($regions as $r){
				$html = $html . '<option value="'.$r->id.'">'.$r->getName() .'</option>';
			}
			return $html;
		
		}elseif($option=='load_complex_types_by_region'){
			//$city = \App\Models\City::where('id',$_POST['region_id'])->first();
			$projs = \App\Models\Project::where("published", 1)->where("region_id",@$_POST['region_id'])->with('types')->get();//flavors
			
			$arr_types = [];
			foreach($projs as $r){
				foreach($r->types as $t)
					$arr_types[] = $t->id;
			}
			
			$arr_types = array_unique($arr_types);
			
			
			$html = '<option value="">' . trans("front.resale form title type") . '</option>';
			$_types = Helper::query("ProjectType", "all");
			$types = [];
			foreach($_types as $r)
				if(in_array($r->id,$arr_types))
					$html = $html . '<option value="'.$r->id.'">'.$r->getName() .'</option>';
			
			
			return $html;
		
		}elseif($option=='load_complex_rooms_by_types_and_region'){
			//$city = \App\Models\City::where('id',$_POST['region_id'])->first();
			$projs = \App\Models\Project::where("published", 1)->where("region_id",@$_POST['region_id'])->with('flavors')->get();//flavors

			/*$q->whereIn("projects.id", function($q_typ) use ($project_type_row) {
                $q_typ->select("project_id")->from("project_type")->where("project_type_id", $project_type_row->id);
            });*/

			$arr_rooms = [];
			$arr_prices = [];
			foreach($projs as $r){
				foreach($r->flavors as $t)
					if($t->type==@$_POST['type_id'] && (int)$t->price_usd !=0 && (int)$t->area !=0){
						$arr_rooms[] = $t->salon . '+' . $t->room;
						
						$arr_prices[$t->salon . '+' . $t->room][] = strip_tags(Helper::usd_to_format(($t->price_usd / $t->area), 'TRY', true,false));//$t->price_usd / $t->area
						}
			}

			$arr_rooms = array_unique($arr_rooms);
			sort($arr_rooms);

			$html = '<option value="">' . trans("front.resale form title room") . '</option>';

			foreach($arr_rooms as $r)
					$html = $html . '<option value="'.$r.'" data-m2-price="'. round(array_sum($arr_prices[$r])/count(($arr_prices[$r]))) .'">'.$r .'</option>';

			return $html;

		}elseif($option=='agent_review'){
			
			$current_lang = (\LaravelLocalization::getCurrentLocale()=='pe'?'fa':\LaravelLocalization::getCurrentLocale());
        if ( $request->isMethod('post') ) {
            $inputs = $request->all();
			
			
            $rv1 = $request->get("rv1", null);
            $rv2 = $request->get("rv2", null);
            $rv3 = $request->get("rv3", null);
            $rv4 = $request->get("rv4", null);
            //$rv5 = $request->get("rv5", null);
            //$rv6 = $request->get("rv6", null);
			
                if($rv1=='') return response()->json(["input" =>"rv1","message" =>  trans("front.please select a rating")]);
                if($rv2=='') return response()->json(["input" =>"rv2","message" =>  trans("front.please select a rating"),]);
                if($rv3=='') return response()->json(["input" =>"rv3","message" =>  trans("front.please select a rating"),]);
                if($rv4=='') return response()->json(["input" =>"rv4","message" =>  trans("front.please select a rating"),]);
                //if($rv5=='') return response()->json(["input" =>"rv5","message" =>  trans("front.please select a rating"),]);
                //if($rv6=='') return response()->json(["input" =>"rv6","message" =>  trans("front.please select a rating"),]);
                
                if(!$request->get("client_name", null)) return response()->json(["input" =>  "client_name","message" =>  trans("front.please enter your name")]);
                if(!$request->get("client_country", null)) return response()->json(["input" =>  "client_country","message" =>  trans("front.please enter your country")]);
                if(!$request->get("comment", null)) return response()->json(["input" =>  "comment","message" =>  trans("front.please enter your comment")]);
                
				$inputs['avg_rv'] = array_sum([$rv1,$rv2,$rv3,$rv4])/4 ;
				$inputs['enabled'] = false;
                $saved_message = Helper::query("SaleManagerReview", "save", ["inputs" => $inputs]);
				
				$inputs['id'] = $saved_message->id;

                return response()->json([
                    "message"   =>  "تم الإرسال شكرا لك"
                ]);
        }
			
		}
		
		/*$q = \App\Models\Project::where("published", 1);
		$q->whereIn("id", function($q_pf) use ($project_cat_id) {
			$q_pf->select("project_id")->from("project_category")->where("project_category_id", $project_cat_id);
		});
		$q->join("projects_flavors as flv", "flv.project_id", "=", "projects.id")
			->orderBy("projects.id", "desc")->groupBy("project_id");
		$arr = $q->get();


		echo '<pre>';
		print_r($arr);
		echo '</pre>';*/
	}

    /**
    * search
    *
    * @return void
    */
    public function search(Request $request, $type = null, $city = null, $var1 = null, $var2 = null)
    {
		//turkey and oman
		$__type = $type;
		$__city = $city;
		$__var1 = $var1;
		$__var2 = $var2;

		$current_lang = (\LaravelLocalization::getCurrentLocale()=='pe'?'fa':\LaravelLocalization::getCurrentLocale());
		

		if($request->get("amp")=='1'){
				$url = route("front.search")."/".($request->get("project_type")==''?'property-for-sale':$request->get("project_type"))."/".($request->get("city")==''?'turkey':$request->get("city")).($request->get("project_category")==''?'':"/".$request->get("project_category"));
				return Redirect::to($url);
		}

		if ($request->isMethod('get') && !$request->ajax() && !isset($_GET['ajax'])) {
			$geoUrl = $this->legacySearchGeoUrl($request, $type, $city, $var1, $var2);
			if ($geoUrl) {
				return Redirect::to($geoUrl, 301);
			}
		}
		
		
		//$start = microtime(true);

		
		//rooms
        $paginate_number = 6;
        $inputs = $request->all();
		if(@$inputs['price_fields']=='1' and @$inputs['price2'] and @$inputs['curr']){
			if($inputs['curr']=='USD')
			$inputs['price'] = $inputs['price2'];
			else{
				$infos = Helper::get_params();
				$ex = unserialize($infos->exchange);
				//convert from other curr to usd
				$pr0 = explode('-',$inputs['price2']);
				$inputs['price'] = Helper::to_usd_format($ex,$pr0[0],$inputs['curr']).'-'.Helper::to_usd_format($ex,$pr0[1],$inputs['curr']);
			}
		
		}
		$hide_search_page = '';
		
		
		
		
		
        if ( $request->ajax() or isset($_GET['ajax'])) {
			/*if($request->get("curr")) //IMPORTANT!!!!
			$request->session()->put('currency', $request->get("curr", null));*/

            $inputs["project_type"] = $request->get("project_type", @$_GET['project_type']);
            $inputs["city"] = $request->get("city", @$_GET['city']);
            $inputs["project_categories"] = $request->get("project_categories", []);
            $inputs["regions"] = $request->get("regions", []);
			
			if(in_array($inputs["city"],['turkey','oman']) or $inputs["city"] == ''){
			
			$Rregion = \App\Models\Region::whereIn('slug',$inputs["regions"])->first();
			if($Rregion!=false){
				$city = Helper::query("City", "where", ["field" => "id", "value" => $Rregion->city_id])->first()->slug;
				$inputs["city"] = $city;
				//$_GET['city'] = $city;
			}
			}
        } else {
		if(in_array($city,['turkey','oman','syria']) and $var1!=null){ // /property-for-sale/turkey/buyukcekmece Redirect To /property-for-sale/istanbul/buyukcekmece
			if($var2!=null)
				$arr_var = array_merge(explode(',',$var1),explode(',',$var2));
			else
				$arr_var = explode(',',$var1);
			
			$Rregion = \App\Models\Region::whereIn('slug',$arr_var)->first();
			if($Rregion!=false){
				$city = Helper::query("City", "where", ["field" => "id", "value" => $Rregion->city_id])->first()->slug;
				
				$url = URL::current();
                $url = str_replace('/turkey/', '/'.$city.'/', $url);
                $url = str_replace('/oman/', '/'.$city.'/', $url);
                $url = str_replace('/syria/', '/'.$city.'/', $url);
                return Redirect::to($url);
			}
		}
            $inputs["project_type"] = $type;
            $inputs["city"] = $city;
            $inputs["project_categories"] = [];
            $inputs["regions"] = [];
            
            $var1 = $var1 ? explode(",", $var1) : [];
            $var2 = $var2 ? explode(",", $var2) : [];
            
			
            $q_regions = [];
            $q_tags = Helper::query("ProjectCategory", "whereIn", ["field" => "slug", "value" => $var1])->get();
            if ( count($q_tags) > 0 ) {
				if($q_tags[0]->hide_search_page==false){
					$inputs["project_categories"] = $var1;
				}else{
					$hide_search_page = $var1;
				}
            } else {
                $q_regions = Helper::query("Region", "whereIn", ["field" => "slug", "value" => $var1])->get();
                if ( count($q_regions) > 0 ) {
                    $inputs["regions"] = $var1;
					/*if($city == null){
						$city = Helper::query("City", "where", ["field" => "id", "value" => $q_regions[0]->city_id])->first()->slug;
						$inputs["city"] = $city;
					}*/
                }
            }

            if ( $var2 ) {
                $q_regions = Helper::query("Region", "whereIn", ["field" => "slug", "value" => $var2])->get();
                $inputs["regions"] = $var2;
					/*if($city == null){
						$city = Helper::query("City", "where", ["field" => "id", "value" => $q_regions[0]->city_id])->first()->slug;
						$inputs["city"] = $city;
					}*/
            }

            if ( count($q_tags) == 0 and count($var1) > 0 and count($q_regions) == 0 ) {
                return abort(404);//Redirect::to(route('front.search') . '/property-for-sale/turkey', 301);
            }
            if ( count($q_regions) == 0 and count($var2) > 0 ) {
                return abort(404);//Redirect::to(route('front.search') . '/property-for-sale/turkey', 301);
            }
        }

        // query
        $link_tags = null;
        $link_region = null;
        $about_title = null;
        $about_description = null;
        $arr_seo_title = [];
        $arr_seo_description = [];
        $arr_seo_keywords = [];
        $inputs["lat"] = "";
        $q = \App\Models\Project::where("published", 1)->where("sold",'!=', 100)->with('cardphoto')->with('flavors'); //->select(['id','name_en','card_photo_id','city_id','region_id','latitude','longitude']);//select only id,city_id,region_id, lat long
        
		/*
		//قادم من البحث العام
		if(isset($_GET['sprojects'])){
			$art = explode(',',$_GET['sprojects']);
			$arridp = [];
			foreach($art as $idp){
				$arridp[] = (int)$idp;
			}
			$q->whereIn("id",$arridp);
		}
		*/
		
		
		$__links = '';
		$project_type_nme = '';
		$project_type_slg = '';
		$city_nme = '';
		$city_slg = '';
		$project_categories_nme = '';
		$project_categories_slg = '';
		$regions_nme = '';
		$regions_slg = '';
		
		/*$about_title = '';
		$about_description = '';*/
		
		/*if($project_type_slg == ''  && $city_slg == '' && $project_categories_slg == '' && $regions_slg==''){
			$link = ;
		}*/
		
		$generate_h1['project_type'] = trans('front.aqarat').' '.trans('front.for_sale');
        // project type
        if ( $inputs["project_type"] and $inputs["project_type"] != "property-for-sale" ) {
			
			
            $project_type_row = Helper::query("ProjectType", "where", ["field" => "slug", "value" => $inputs["project_type"]])->first();
            if ( !$project_type_row ) abort(404);//return Redirect::to(route('front.search') . '/property-for-sale/turkey', 301);//abort(404);
            $q->whereIn("projects.id", function($q_typ) use ($project_type_row) {
                $q_typ->select("project_id")->from("project_type")->where("project_type_id", $project_type_row->id);
            });
            
            /*$about_title = $project_type_row->getAboutTitle();
            $about_description = $project_type_row->getAbout();*/
			
			/*if ( $project_type_row->getPost ) {
				$tpost = $project_type_row->getPost->getCustomPost(true);
				$about_title = $tpost['title'];
				$about_description = $tpost['content'];
			}*/
			
            $inputs["row"] = $project_type_row;
            // seo tags
            $seo_title = $project_type_row->getSeoTitle();
            $arr_seo_title[0] = $seo_title ? $seo_title : $project_type_row->getName();
            $arr_seo_description[0] = $project_type_row->getSeoDescription();
            $arr_seo_keywords[0] = $project_type_row->getSeoKeywords();
			
			$project_type_nme = $project_type_row->getName();
			$project_type_slg = $project_type_row->slug;
			
			$generate_h1['project_type'] = $project_type_row->getName().' '.trans('front.for_sale');
        }
        // city
        
		if(@$inputs["city"]=='oman' or @$inputs["city"]=='syria')
			$generate_h1['city'] = trans('front.'.$inputs["city"]);
		else
			$generate_h1['city'] = trans('front.turkey');
        if ( $inputs["city"] /*and $inputs["city"] !== "turkey"*/ ) {
            $city_row = Helper::query("City", "where", ["field" => "slug", "value" => $inputs["city"]])->first();
            if ( !$city_row ) abort(404);//return Redirect::to(route('front.search') . '/property-for-sale/turkey', 301);
            if ( $inputs["city"] !== "turkey" && $inputs["city"] !== "oman" && $inputs["city"] !== "syria" ) {
                $q->where("city_id", $city_row->id);
                // filter region by city id
                //$inputs["regions_options"] = Helper::query("Region", "where", ["field" => "city_id", "value" => $city_row->id])->get();
				$inputs["regions_options"] = \App\Models\Region::select('regions.*')->leftJoin('projects AS p', 'p.region_id', '=', 'regions.id')->where("p.published", 1)->where("p.sold",'!=', 100)->where("p.city_id", $city_row->id)->groupBy('regions.id')->having(DB::raw('count(dms_p.id)'), '>', 0)->orderBy(DB::raw('count(dms_p.id)'),'desc')->get();//
				
            }else{
				$countryRow = \App\Models\Country::findBySlugOrCode($inputs["city"]);
				$citiesids = $countryRow
					? \App\Models\City::where('country_id', $countryRow->id)->lists('id')->toArray()
					: array();
				//if($inputs["city"] == "turkey"){
					$q->whereIn("city_id", $citiesids);
					$inputs["regions_options"] = [];
					//$inputs["regions_options"] = \App\Models\Region::select('regions.*')->leftJoin('projects AS p', 'p.region_id', '=', 'regions.id')->where("p.published", 1)->where("p.sold",'!=', 100)->where("p.city_id", $city_row->id)->groupBy('regions.id')->having(DB::raw('count(dms_p.id)'), '>', 0)->orderBy(DB::raw('count(dms_p.id)'),'desc')->get();//
				//}elseif($inputs["city"] == "oman"){
					//$q->where("city_id", $city_row->id);
					//$inputs["regions_options"] = \App\Models\Region::select('regions.*')->leftJoin('projects AS p', 'p.region_id', '=', 'regions.id')->where("p.published", 1)->where("p.sold",'!=', 100)->where("p.city_id", $city_row->id)->groupBy('regions.id')->having(DB::raw('count(dms_p.id)'), '>', 0)->orderBy(DB::raw('count(dms_p.id)'),'desc')->get();//
				//}
			}
            
            /*$about_title = $city_row->getAboutTitle();
            $about_description = $city_row->getAbout();
			*/
			/*if ( $city_row->getPost ) {
				$tpost = $city_row->getPost->getCustomPost(true);
				$about_title = $tpost['title'];
				$about_description = $tpost['content'];
			}*/
			
			
            $inputs["row"] = $city_row;
            $inputs["city_row"] = $city_row;
            // seo tags
			if(!isset($arr_seo_title[0])){
            $seo_title = $city_row->getSeoTitle();
            $arr_seo_title[0] = $seo_title ? $seo_title : $city_row->getName();
            $arr_seo_description[0] = $city_row->getSeoDescription();
            $arr_seo_keywords[0] = $city_row->getSeoKeywords();
            }
			
			$city_nme = $city_row->getName();
			$city_slg = $city_row->slug;
			$generate_h1['city'] = $city_row->getName();
        }
		if(!isset($inputs["regions_options"])){
			
			//$inputs["regions_options"] = Helper::query("Region", "all");
        $inputs["regions_options"] = \App\Models\Region::select('regions.*')->leftJoin('projects AS p', 'p.region_id', '=', 'regions.id')->where("p.published", 1)->where("p.sold",'!=', 100)->groupBy('regions.id')->having(DB::raw('count(dms_p.id)'), '>', 0)->orderBy(DB::raw('count(dms_p.id)'),'desc')->get();//->orderBy(DB::raw('count(dms_projects)'),'desc')
		}
        
		
        $link_others = [];
        // rooms
			/*
			//commented by me
			if(isset($inputs["rooms"]) and $inputs["rooms"]=='')
				$request->session()->put('filter_rooms', '');
			elseif(!isset($inputs["rooms"]) and @session()->get("filter_rooms")!='')
				$inputs["rooms"] = session()->get("filter_rooms");
			*/

        if ( isset($inputs["rooms"]) and $inputs["rooms"]!='') {
			/*if(!isset($inputs["rooms"]))
				$inputs["rooms"] = session()->get("filter_rooms");
			else*/
				$request->session()->put('filter_rooms', $inputs["rooms"]);
            $ex_rm = explode("_", $inputs["rooms"]);
            $num1 = (int) @$ex_rm[0];
            $num2 = (int) @$ex_rm[1];
			
			if(!isset($inputs["price"]) or $inputs["price"]=='')
            $q->whereIn("projects.id", function($q_r) use ($inputs, $num1, $num2) {
                $q_r->select("project_id")
                    ->from("projects_flavors")
                    //->havingRaw("SUM(room+salon) >= ".$num1)
                    ->where("salon", $num1)
                    ->where("room", $num2)
                    ->groupBy("project_id");
            });
            $link_others[] = "rooms=".$inputs["rooms"];
        }
        if ( isset($inputs["price"]) and $inputs["price"]!='') {
			
			//price selected so we remove all projects with delivered date more thaan 365days
			
			//if(datediff('2019-02-22',NOW())>365
			$q->where(DB::raw('datediff(delivered_date,NOW())'),'>','-500');
			
            $expl_price = explode("-", $inputs["price"]);
            $minprice = @$expl_price[0];
            $maxprice = @$expl_price[1];
			
			if(!isset($inputs["rooms"]) or $inputs["rooms"]=='')
            $q->whereIn("projects.id", function($q_r) use ($inputs, $minprice, $maxprice) {
                $q_r->select("project_id")
                    ->from("projects_flavors")
                    ->groupBy("project_id");
                if ( $maxprice == '+' ) {
                    $q_r->where("price_usd", ">=", $minprice);
                } else {
                    $q_r->whereBetween('price_usd', [$minprice, $maxprice]);
                }
            });
            $link_others[] = "price=".$inputs["price"];
        }
		
		//تم اختيار فلترة السعر و فلترة الغرف
		if(isset($inputs["rooms"]) and $inputs["rooms"]!='' and isset($inputs["price"]) and $inputs["price"]!=''){
			$q->whereIn("projects.id", function($q_r) use ($inputs, $num1, $num2, $minprice, $maxprice) {
                $q_r->select("project_id")
                    ->from("projects_flavors")
                    //->havingRaw("SUM(room+salon) >= ".$num1)
                    ->where("salon", $num1)
                    ->where("room", $num2);
					if ( $maxprice == '+' ) {
						$q_r->where("price_usd", ">=", $minprice);
					} else {
						$q_r->whereBetween('price_usd', [$minprice, $maxprice]);
					}
                    $q_r->groupBy("project_id");
            });
		}
		
		
		//$q_auto_inputs = clone $q; //do not add multi options to filter input conditions
		
		
        // price
        /*if ( @$inputs["minprice"] or @$inputs["maxprice"] ) {
            $q->whereIn("id", function($q_r) use ($inputs) {
                $q_r->select("project_id")
                    ->from("projects_flavors")
                    ->whereBetween('price_usd', [$inputs["minprice"], $inputs["maxprice"]])
                    ->groupBy("project_id");
            });
            $link_others[] = "minprice=".$inputs["minprice"];
            $link_others[] = "maxprice=".$inputs["maxprice"];
        }*/
		
		
		
        // project features
		$generate_h1['project_categories'] = '';
        if ( $inputs["project_categories"]  or $hide_search_page != '') {
            $arr_cats = [];
			
			if($hide_search_page != ''){
				$inputs["project_categories"] = $hide_search_page;
			}
			
			if(count($inputs["project_categories"])>0){
				$generate_h1['project_categories'] = '';//trans('front.features');
			}
			$first=true;
            foreach ($inputs["project_categories"] as $cat) {
                $project_cat_row = Helper::query("ProjectCategory", "where", ["field" => "slug", "value" => $cat])->first(); 
                if ( !$project_cat_row ) abort(404);//return Redirect::to(route('front.search') . '/property-for-sale/turkey', 301);
				
				
				$generate_h1['project_categories'] = $generate_h1['project_categories'].($first==true?' ':', ').$project_cat_row->getName();
				$first=false;	
				
                $arr_cats[] = @$project_cat_row->id;

				if($hide_search_page == ''){
                $q->whereIn("projects.id", function($q_pf) use ($project_cat_row) {
                    $q_pf->select("project_id")->from("project_category")->where("project_category_id", $project_cat_row->id);
                });
				}
            }
            /*$q->whereIn("id", function($q_pf) use ($arr_cats) {
                $q_pf->select("project_id")->from("project_category")->whereIn("project_category_id", $arr_cats);
            });*/
            $link_tags = "/".implode(",", $inputs["project_categories"]);
            /*
            $about_title = @$project_cat_row->getAboutTitle();
            $about_description = @$project_cat_row->getAbout();
			*/
			/*if(isset($project_cat_row))
			if ( $project_cat_row->getPost ) {
				$tpost = $project_cat_row->getPost->getCustomPost(true);
				$about_title = $tpost['title'];
				$about_description = $tpost['content'];
			}*/
			
            $inputs["row"] = @$project_cat_row;
            // seo tags
            $seo_title = @$project_cat_row->getSeoTitle();
            $arr_seo_title[0] = $seo_title ? $seo_title : @$project_cat_row->getName();
            $arr_seo_description[0] = @$project_cat_row->getSeoDescription();
            $arr_seo_keywords[0] = @$project_cat_row->getSeoKeywords();
			
			
			$project_categories_nme = $project_cat_row->getName();
			$project_categories_slg = $project_cat_row->slug;
        }
        
		
		
		
        // regions
		$generate_h1['regions'] = '';
        if ( $inputs["regions"] ) {
            $arr_reg = [];
			
			if(count($inputs["regions"])>1)
				$generate_h1['regions'] = '';//trans('front.regions');
			elseif(count($inputs["regions"])>0){
				$generate_h1['regions'] = '';//trans('front.region');
			}
			$first=true;
			foreach ($inputs["regions"] as $reg) {
                $region_row = Helper::query("Region", "where", ["field" => "slug", "value" => $reg])->first();
                if ( !$region_row )
					return abort(404);//Redirect::to(route('front.search') . '/property-for-sale/turkey', 301);
					$generate_h1['regions'] = $generate_h1['regions'].($first==true?' ':', ').$region_row->getName();
					$first=false;
					
                $arr_reg[] = @$region_row->id;
            }
            $q->whereIn("region_id", $arr_reg);            
            $link_region = "/".implode(",", $inputs["regions"]);
            /*
            $about_title = @$region_row->getAboutTitle();
            $about_description = @$region_row->getAbout();*/
			
			/*if(isset($region_row))
			if ( $region_row->getPost ) {
				$tpost = $region_row->getPost->getCustomPost(true);
				$about_title = $tpost['title'];
				$about_description = $tpost['content'];
			}*/
            $inputs["row"] = @$region_row;
            // seo tags
            $seo_title = @$region_row->getSeoTitle();
            $arr_seo_title[0] = $seo_title ? $seo_title : @$region_row->getName();
            $arr_seo_description[0] = @$region_row->getSeoDescription();
            $arr_seo_keywords[0] = @$region_row->getSeoKeywords();
			
			$regions_nme = @$region_row->getName();
			$regions_slg = @$region_row->slug;
        }
        
		$q_auto_inputs = clone $q; //on the top
		
		if(in_array(@$city_row->id,[7,11])){
        $inputs["__links"] = Helper::GnerateLnk('',$project_type_nme, '',$city_nme, $project_categories_slg ,'');
        }else
		$inputs["__links"] = Helper::GnerateLnk($project_type_slg,$project_type_nme, $city_slg,$city_nme, $project_categories_slg ,$regions_slg);
		
		
		
		
			/*$req_url =  strtok($url, "?");
			$req_url = strtok(\LaravelLocalization::getLocalizedURL("ar"), "?");
			$req_url = str_replace('newdemo.','',$req_url);
            $page_seo = Helper::query("PageSearch", "where", ["field" => "link", "value" => $req_url])->first();				
            if ( $page_seo ) {
                
				
                if ( $page_seo->getPost ) {
					$tpost = $page_seo->getPost->getCustomPost(true);
					$about_title = $tpost['title'];
					$inputs["about"] = '<h1 property="name">'.$tpost['title'].'</h1><div class="clearfix">'.$tpost['content'].'</div>';
				
				}
            }
			
			
			if($about_title==null){*/
				$generate_h1 = $generate_h1['project_type'] .' '.$generate_h1['city'].' '.$generate_h1['regions'].' '.$generate_h1['project_categories'];
				$inputs["about"] = '<h1 property="name">'. str_replace('  ',' ',$generate_h1) .'</h1><div class="clearfix">'.$about_description.'</div>';
			//}
		
		
		
		
		
		
		
		
		
        // about content
		
		
		
		//$html = html_entity_decode($post->getContent());
        //if mobile then find moile picture
                
        if(Helper::get_device()=='mob'){
        $doc = new \DOMDocument();
        @$doc->loadHTML($inputs["about"]);
        $tags = $doc->getElementsByTagName('img');
        foreach ($tags as $tag) {
        $t=explode('uploads/',$tag->getAttribute('src'));
        if(isset($t[1]))
        	if(file_exists('uploads/'. str_replace('.jpg','_mobile.jpg',$t[1]))){
        	$mx= str_replace('.jpg','_mobile.jpg',$t[1]);
        	$inputs["about"] = str_replace($t[1],$mx,$inputs["about"]);
        	}else{
        		$tt = DB::table("medias")->select("filename_mobile")->where('filename',$t[1])->limit(1)->get();
        		if(count($tt)>0 and file_exists('uploads/'.$tt[0]->filename_mobile)){
        			$inputs["about"] = str_replace($t[1],$tt[0]->filename_mobile,$inputs["about"]);
        		}
        	}
        }
        }
        //$inputs["about"] = str_replace('الجنسية التركية','<a href="'.route("front.turkish_citizenship").'" target="_blank">الجنسية التركية</a>',$inputs["about"]);	
		
		
        
        // sorting
        $sorting = @$inputs["sorting"];
        $sorting_type = @$inputs["sorting_type"]=='asc' ? "asc" : "desc";
        switch ($sorting)
        {
            /*case "price":
			case "price_asc":
				//exit('price or peice_asc');
				if ( $sorting == "price_asc" ) {
                    $sorting_type = "asc";
                    $sorting = "price";
                }
                $q->join("projects_flavors as flavor", "flavor.project_id", "=", "projects.id")
                    ->orderBy("flavor.price_usd", "$sorting_type")->groupBy("project_id");
                $link_others[] = "sorting=".$sorting;
                break;
            case "area":
            case "area_asc":
				if ( $sorting == "area_asc" ) {
                    $sorting_type = "asc";
                    $sorting = "area";
                }
                $q->join("projects_flavors as flv", "flv.project_id", "=", "projects.id")
                    ->orderBy("flv.area", "$sorting_type")->groupBy("project_id");
                $link_others[] = "sorting=".$sorting;
                break;
              */  
            case "views":
                $q->orderBy("views", "$sorting_type");
                $link_others[] = "sorting=".$sorting;
                break;
                
            case "likes":
                $q->orderBy("likes", "$sorting_type");
                $link_others[] = "sorting=".$sorting;
                break;
            default:
                $q->orderBy("sort", "asc");
                $inputs["sorting"] = "relevance";
                break;
        /*
            case "oldest":
                $q->orderBy("created_at", "asc");
                $inputs["sorting"] = "oldest";
                break;
            default:
                $q->orderBy("created_at", "$sorting_type");
                $inputs["sorting"] = "newest";
                break;*/
        }
        if ( $sorting_type!='desc' ) $link_others[] = "sorting_type=".$sorting_type;
        
        
        $link_others = count($link_others) ? ("?".implode("&", $link_others)) : null;
        $q1 = $q;
        $allprojects = $q1->get();
		
        if ( $request->ajax() or isset($_GET['ajax'])) {
            $url = route("front.search")."/".($inputs["project_type"]==''?'property-for-sale':$inputs["project_type"])."/".($inputs["city"]==''?'turkey':$inputs["city"]).$link_tags.$link_region.$link_others;
			
			$data_search['project_type'] = $inputs["project_type"];
			$data_search['project_categories'] = $link_tags;
			$data_search['rooms'] = (isset($inputs["rooms"])?$inputs["rooms"]:'');
			$data_search['regions'] = $link_region;
			$data_search['price'] = (isset($inputs["price"])?$inputs["price"]:'');
			$data_search['city'] = ($inputs["city"]==''?'turkey':$inputs["city"]);
			
			
			if($request->session()->has('searchs.id')){
				$request->session()->push("searchs.id", $data_search);
			}else{
				$request->session()->put('searchs.id', []);
				$request->session()->put("searchs.id", [$data_search]);
			}



			/*
			$user=\Cookie::get('user');
			$user=json_decode($user);
			*/
			
			if (strpos($url, '?') !== false)
				$url = $url . (isset($_GET['page'])?('&page='.$_GET['page']):'');
			else
				$url = $url . (isset($_GET['page'])?('?page='.$_GET['page']):'');

			$projects = $q->paginate($paginate_number);
            $inputs["count"] = count($allprojects);
			/*echo(count($allprojects));
			exit;
			echo '<pre>';
			print_r($allprojects);
			echo '<pre>';
			exit;*/
            // regions city
            $str_regions = null;
            $str_listing_regions = null;
            foreach($inputs["regions_options"] as $opreg) {
                $str_regions .= "<option value='$opreg->slug'>".$opreg->getName()."</option>";
                $str_listing_regions .= "<li data-value='$opreg->slug'><i></i> ".$opreg->getName()."</li>";
            }
			
			
			
			
			
			
			
			
			
			
			
			
			//********* Copy 1 filter
			
            // when change city -> change project type 
			$inputs["project_citys_options"] = json_encode(array());
			$inputs["project_regions_options"] = json_encode(array());
			$inputs["project_types_options"] = json_encode(array());
			$inputs["prices_options"] =  json_encode(array());
			$inputs["rooms_options"] =  json_encode(array());
			$inputs["project_tags_options"] =  json_encode(array());
			
			
				
				//DB::enableQueryLog();
				if(@$inputs["g"]==1){
					$q_auto_inputs = $allprojects;
					//prices_options
				}else
					$q_auto_inputs = $q_auto_inputs->get();
				
				//print_r(DB::getQueryLog());
				$projects_id = array();
				$arr_cits = array();
				$arr_regs = array();
				foreach($q_auto_inputs as $p){//$allprojects
					$projects_id[] = $p->id;
					$arr_cits[] = $p->city_id;
					$arr_regs[] = $p->region_id;
					//echo $p->region_id.'<br>';
				}
				
				$arr_cits = array_unique($arr_cits);
				sort($arr_cits);
				$arr_regs = array_unique($arr_regs);
				sort($arr_regs);
				$inputs["project_citys_options"] = json_encode($arr_cits);
				$inputs["project_regions_options"] = json_encode($arr_regs);
				
				$results = DB::table('project_type')->select('project_type_id')->whereIn('project_id',$projects_id )->distinct('project_type_id')->get();
				
					$arr = array();
				foreach($results as $r){
					$arr[] = $r->project_type_id;
				}
				$inputs["project_types_options"] =  json_encode($arr);
			
				
				//price list + rooms list
				$results = DB::table('projects_flavors')->select('project_id','salon','room','price_usd')->whereIn('project_id',$projects_id )->get();//->distinct('price_usd')
				$arr_p = array();
				$arr_ro = array();
				foreach($results as $r){
					/*if($r->price_usd<100000)
						$arr_p[0] = "50000-100000";
					elseif($r->price_usd<150000)
						$arr_p[1] = "100000-150000";
					elseif($r->price_usd<250000)
						$arr_p[2] = "150000-250000";
					elseif($r->price_usd<400000)
						$arr_p[3] = "250000-400000";
					elseif($r->price_usd<600000)
						$arr_p[4] = "400000-600000";
					elseif($r->price_usd<1000000)
						$arr_p[5] = "600000-1000000";
					elseif($r->price_usd<2000000)
						$arr_p[6] = "1000000-2000000";
					elseif($r->price_usd>=2000000)
						$arr_p[7] = "2000000-+";*/
					
					$arr_rooms = array('1_0','1_1','1_2','1_3','1_4','1_5','2_3','2_4','2_5','2_6');
					foreach($arr_rooms as $rom){
						if($r->salon.'_'.$r->room == $rom){
							$arr_ro[] = $rom;
							break;
						}
					}
				}
				/*$arr0=array();
				foreach($arr_p as $k=>$v)
					$arr0[]=str_replace('-','.',$v);
				sort($arr0);
				
				foreach($arr0 as $k=>$v)
				$arr0[$k] = str_replace('.','-',$v);

				$inputs["prices_options"] =  json_encode($arr0);*/
				
			
				$arr_ro = array_unique($arr_ro);
				sort($arr_ro);
				$inputs["rooms_options"] = json_encode($arr_ro);
				
				
				$results = DB::table('project_category')->select('project_category_id')->whereIn('project_id',$projects_id )->distinct('project_category_id')->get();
					$arr = array();
				foreach($results as $r){
					$arr[] = $r->project_category_id;
				}
				$inputs["project_tags_options"] =  json_encode($arr);
			
			//*************  Copy 1 filter End
				
				
				
				
			unset($inputs["row"]);
			$city_lat = (float) @$inputs["city_row"]->latitude;
			$city_lng = (float) @$inputs["city_row"]->longitude;
			unset($inputs["city_row"]);
			unset($inputs["regions_options"]);
			
			
			/*echo Helper::get_compress_cards(view('front.partials.search_results_projects', ['projects' => $projects, "paginate_number" => $paginate_number])->render());
			exit;*/
			
			//filter and get all required field here
			$req_projects = [];
			foreach($projects as $project){
				$req_projects[] = Helper::get_json_project($project);
			}
			//$jsonprojects = json_encode($req_projects,false);
			$jsonprojects = ($req_projects);
			
			/*echo '<pre>';
			print_r($req_projects[0]);
			echo '</pre>';
			exit;*/
			
			//@include('front.partials.pagination-projects',['projects'=>$projects])
			
			
			$pagin_block = view('front.partials.pagination-projects', ['projects' => $projects,"cnt_projs" => count($allprojects)])->render();
			
			
			
			
			
			
			
			
			$req_url =  strtok($url, "?");
			//$req_url = strtok(\LaravelLocalization::getLocalizedURL("ar"), "?");
			$req_url = str_replace('newdemo.','',$req_url);
			$req_url = preg_replace('#(https?://[^/]+)(?:/(?:ru|fa|pe|fr|en|ar))(?=/|$)#', '$1', $req_url, 1);
			/*echo $req_url;
			exit;*/
            $page_seo = Helper::query("PageSearch", "where", ["field" => "link", "value" => $req_url])->first();				
            if ( $page_seo ) {
                /*$inputs["seo_title"] = $page_seo->getSeoTitle();
                $inputs["seo_description"] = $page_seo->getSeoDescription();
                $inputs["seo_keywords"] = $page_seo->getSeoKeywords();
				*/
				
                if ($page_seo->getPost) {
                    $tpost = $page_seo->getPost->getCustomPost(true);
                    $about_title = $tpost['title'];
                    $inputs["about"] = '<h1 property="name">'.$tpost['title'].'</h1><div class="clearfix">'.$tpost['content'].'</div>';
                } elseif ($current_lang == 'ar' && (!empty($page_seo->title) || !empty($page_seo->content))) {
                    $about_title = $page_seo->title;
                    $inputs["about"] = '<h1 property="name">'.$page_seo->title.'</h1><div class="clearfix">'.$page_seo->content.'</div>';
                } elseif ($current_lang == 'en' && (!empty($page_seo->title_en) || !empty($page_seo->content_en))) {
                    $about_title = $page_seo->title_en;
                    $inputs["about"] = '<h1 property="name">'.$page_seo->title_en.'</h1><div class="clearfix">'.$page_seo->content_en.'</div>';
                }
            }
			
			
			/*if($about_title==null){
				$generate_h1 = $generate_h1['project_type'] .' '.$generate_h1['city'].' '.$generate_h1['regions'].' '.$generate_h1['project_categories'];
				$inputs["about"] = '<h1 property="name">'. str_replace('  ',' ',$generate_h1) .'</h1><div class="clearfix">'.$about_description.'</div>';
			}*/
			//sleep(1);
			
			//$inputs["map"] = 'none';
            return response()->json([
                "url"       =>  $url,
				"__links" => $inputs["__links"],
                //"content"   =>  (@$inputs["map"]=='only'?[]:Helper::get_compress_cards(view('front.partials.search_results_projects', ['projects' => $projects, "paginate_number" => $paginate_number])->render())),
                "content"   =>  (@$inputs["map"]=='only'?[]: $jsonprojects),
                "paginate_number" => @$paginate_number,
				"inputs"    =>  (@$inputs["map"]=='only'?[]:$inputs),
                ////"map_projects"    =>  /*(@$inputs["map"]=='none'?[]: */ Helper::get_json_map_projects($allprojects),//),
                ////"latitude"    =>   $city_lat,
                ////"longitude"    =>  $city_lng,
                "pagin_block"    =>  $pagin_block,
                "page_number"    =>  '',////($projects->currentPage() .' of '. $projects->lastPage()),
                /*"regions_options"   =>  $str_regions,
                "regions_listing"   =>  $str_listing_regions,*/
            ]);
		
        } else {//no ajax
            
			//********* Copy 1 filter
			
            // when change city -> change project type 
			$inputs["project_citys_options"] = json_encode(array());
			$inputs["project_regions_options"] = json_encode(array());
			$inputs["project_types_options"] = json_encode(array());
			$inputs["prices_options"] =  json_encode(array());
			$inputs["rooms_options"] =  json_encode(array());
			$inputs["project_tags_options"] =  json_encode(array());
			
			
				
				//DB::enableQueryLog();
				if(@$inputs["g"]==1){
					$q_auto_inputs = $allprojects;
					//prices_options
				}else
					$q_auto_inputs = $q_auto_inputs->get();
				
				//print_r(DB::getQueryLog());
				$projects_id = array();
				$arr_cits = array();
				$arr_regs = array();
				foreach($q_auto_inputs as $p){//$allprojects
					$projects_id[] = $p->id;
					$arr_cits[] = $p->city_id;
					$arr_regs[] = $p->region_id;
					//echo $p->region_id.'<br>';
				}
				
				$arr_cits = array_unique($arr_cits);
				sort($arr_cits);
				$arr_regs = array_unique($arr_regs);
				sort($arr_regs);
				$inputs["project_citys_options"] = json_encode($arr_cits);
				$inputs["project_regions_options"] = json_encode($arr_regs);
				
				$results = DB::table('project_type')->select('project_type_id')->whereIn('project_id',$projects_id )->distinct('project_type_id')->get();
					$arr = array();
				foreach($results as $r){
					$arr[] = $r->project_type_id;
				}
				$inputs["project_types_options"] =  json_encode($arr);
			
				
				//price list + rooms list
				$results = DB::table('projects_flavors')->select('project_id','salon','room','price_usd')->whereIn('project_id',$projects_id )->get();//->distinct('price_usd')
				$arr_p = array();
				$arr_ro = array();
				foreach($results as $r){
					/*if($r->price_usd<100000)
						$arr_p[0] = "50000-100000";
					elseif($r->price_usd<150000)
						$arr_p[1] = "100000-150000";
					elseif($r->price_usd<250000)
						$arr_p[2] = "150000-250000";
					elseif($r->price_usd<400000)
						$arr_p[3] = "250000-400000";
					elseif($r->price_usd<600000)
						$arr_p[4] = "400000-600000";
					elseif($r->price_usd<1000000)
						$arr_p[5] = "600000-1000000";
					elseif($r->price_usd<2000000)
						$arr_p[6] = "1000000-2000000";
					elseif($r->price_usd>=2000000)
						$arr_p[7] = "2000000-+";*/
					
					$arr_rooms = array('1_0','1_1','1_2','1_3','1_4','1_5','2_3','2_4','2_5','2_6');
					foreach($arr_rooms as $rom){
						if($r->salon.'_'.$r->room == $rom){
							$arr_ro[] = $rom;
							break;
						}
					}
				}
				/*$arr0=array();
				foreach($arr_p as $k=>$v)
					$arr0[]=str_replace('-','.',$v);
				sort($arr0);
				
				foreach($arr0 as $k=>$v)
				$arr0[$k] = str_replace('.','-',$v);

				$inputs["prices_options"] =  json_encode($arr0);
				*/
			
				$arr_ro = array_unique($arr_ro);
				sort($arr_ro);
				$inputs["rooms_options"] = json_encode($arr_ro);
				
				
				$results = DB::table('project_category')->select('project_category_id')->whereIn('project_id',$projects_id )->distinct('project_category_id')->get();
					$arr = array();
				foreach($results as $r){
					$arr[] = $r->project_category_id;
				}
				$inputs["project_tags_options"] =  json_encode($arr);
			
			//*************  Copy 1 filter End
            
			
			$req_url = strtok(\LaravelLocalization::getLocalizedURL("ar"), "?");
			
			$req_url = str_replace('newdemo.','',$req_url);
			
            $page_seo = Helper::query("PageSearch", "where", ["field" => "link", "value" => $req_url])->first();
				
            if ( $page_seo ) {
                $inputs["seo_title"] = $page_seo->getSeoTitle();
                $inputs["createdAt"] = $page_seo->createdAt;
                $inputs["seo_description"] = $page_seo->getSeoDescription();
                $inputs["seo_keywords"] = $page_seo->getSeoKeywords();
				
				
                if($current_lang == 'en'){
                    $inputs["og_image"] = $page_seo->media_en_id ? Helper::media_mob($page_seo->mediaEn) : null;
                }elseif($current_lang == 'fr'){
                    $inputs["og_image"] = $page_seo->media_fr_id ? Helper::media_mob($page_seo->mediaFr) : null;
                }elseif($current_lang == 'ru'){
                    $inputs["og_image"] = $page_seo->media_ru_id ? Helper::media_mob($page_seo->mediaRu) : null;
                }elseif($current_lang == 'pe'){
                    $inputs["og_image"] = $page_seo->media_fa_id ? Helper::media_mob($page_seo->mediaFa) : null;
                } else {
                    $inputs["og_image"] = $page_seo->media_id ? Helper::media_mob($page_seo->media) : null;
					/*if(isset($_GET['sss'])){
						echo $inputs["og_image"];
						exit;
					}*/
                }
				if($inputs["og_image"]==null && $current_lang != 'ar')
					$inputs["og_image"] = $page_seo->media_id ? Helper::media_mob($page_seo->media) : null;
				
				
                if ($page_seo->getPost) {
                    $tpost = $page_seo->getPost->getCustomPost(true);
                    $inputs["about"] = '<h1 property="name">'.$tpost['title'].'</h1><div class="clearfix">'.$tpost['content'].'</div>';
                    $inputs['cat_id'] = $tpost['cat_id'];
                } elseif ($current_lang == 'ar' && (!empty($page_seo->title) || !empty($page_seo->content))) {
                    $inputs["about"] = '<h1 property="name">'.$page_seo->title.'</h1><div class="clearfix">'.$page_seo->content.'</div>';
                } elseif ($current_lang == 'en' && (!empty($page_seo->title_en) || !empty($page_seo->content_en))) {
                    $inputs["about"] = '<h1 property="name">'.$page_seo->title_en.'</h1><div class="clearfix">'.$page_seo->content_en.'</div>';
                }
				//if ( $page_seo->content ) {
					/*if ( $current_lang == 'en' )
						$inputs["about"] = '<h1 property="name">'.$page_seo->title_en.'</h1><div class="clearfix">'.$page_seo->content_en.'</div>';
					elseif ( $current_lang == 'fr' )
						$inputs["about"] = '<h1 property="name">'.$page_seo->title_fr.'</h1><div class="clearfix">'.$page_seo->content_fr.'</div>';
					else
						$inputs["about"] = '<h1 property="name">'.$page_seo->title.'</h1><div class="clearfix">'.$page_seo->content.'</div>';*/
                
				
				
				
						if(Helper::get_device()=='mob'){
						$doc = new \DOMDocument();
						@$doc->loadHTML($inputs["about"]);
						$tags = $doc->getElementsByTagName('img');
						foreach ($tags as $tag) {
							$t=explode('uploads/',$tag->getAttribute('src'));
							if(isset($t[1]))
								if(file_exists('uploads/'. str_replace('.jpg','_mobile.jpg',$t[1]))){
								$mx= str_replace('.jpg','_mobile.jpg',$t[1]);
								$inputs["about"] = str_replace($t[1],$mx,$inputs["about"]);
								}else{
									$tt = DB::table("medias")->select("filename_mobile")->where('filename',$t[1])->limit(1)->get();
										if(count($tt)>0 and file_exists('uploads/'.$tt[0]->filename_mobile)){
											$inputs["about"] = str_replace($t[1],$tt[0]->filename_mobile,$inputs["about"]);
									}
								}
							}
						}
				
				
				
            } else {
                if ( $current_lang == 'en' ) {
                    $inputs["og_image"] = $inputs["city_row"]->media_en_id ? Helper::media_mob($inputs["city_row"]->mediaEn) : null;
                } elseif ( $current_lang == 'fr' ) {
                    $inputs["og_image"] = $inputs["city_row"]->media_fr_id ? Helper::media_mob($inputs["city_row"]->mediaFr) : null;
                } elseif ( $current_lang == 'ru' ) {
                    $inputs["og_image"] = $inputs["city_row"]->media_ru_id ? Helper::media_mob($inputs["city_row"]->mediaRu) : null;
                } elseif ( $current_lang == 'pe' ) {
                    $inputs["og_image"] = $inputs["city_row"]->media_fa_id ? Helper::media_mob($inputs["city_row"]->mediaFa) : null;
                } else {
                    $inputs["og_image"] = $inputs["city_row"]->media_id ? Helper::media_mob($inputs["city_row"]->media) : null;
                }
				if($inputs["og_image"]==null && $current_lang != 'ar')
					$inputs["og_image"] = $inputs["city_row"]->media_id ? Helper::media_mob($inputs["city_row"]->media) : null;
				
				
                /*$inputs["seo_title"] = implode(".", $arr_seo_title);
                $inputs["seo_description"] = trim(implode(".", $arr_seo_description));
                $inputs["seo_keywords"] = trim(implode(".", $arr_seo_keywords));*/
				//$generate_h1 = $generate_h1['project_type'] .' '.$generate_h1['city'].' '.$generate_h1['regions'].' '.$generate_h1['project_categories'];
				$generate_h1 = str_replace('  ',' ',trim($generate_h1));
				$inputs["seo_title"] = $generate_h1;
                $inputs["seo_description"] = $generate_h1;
                $inputs["seo_keywords"] = '';
            }
            
            $projects = $q->paginate($paginate_number);
			
			//filter and get all required field here
			/*$req_projects = [];
			foreach($projects as $project){
				$req_projects[] = Helper::get_json_project($project);
			}
			$jsonprojects = json_encode($req_projects);*/
        }
        
		/*echo microtime(true) - $start;
		exit;*/
		
		$search_noindex = count($allprojects) === 0 || count($projects) === 0;
		if(count($allprojects)==0 and !isset($_GET['s']) /*and @$_GET['page']==1*/){
			//abort(404);////comment
			
			//exit();
			
			
			$lq = \App\Models\Project::where("published", 1)->where("sold",'!=', 100)->with('cardphoto')->with('flavors');
			$lq2 = clone $lq;
			if(isset($city_row) && isset($project_type_row)){
				$projects = $lq->where('city_id',$city_row->id)->whereIn("projects.id", function($q_typ) use ($project_type_row) {
					$q_typ->select("project_id")->from("project_type")->where("project_type_id", $project_type_row->id);
				})->limit(3)->get();
				if(count($projects)==0){
					$projects = $lq2->where('city_id',$city_row->id)->limit(3)->get();
				}
			}elseif(isset($city_row) && !isset($project_type_row)){
			    
				$projects = $lq->where('city_id',$city_row->id)->limit(3)->get();
				if(count($projects)==0){
					$projects = $lq2->limit(3)->get();
				}
			}elseif(!isset($city_row) && isset($project_type_row)){
				$projects = $lq->whereIn("projects.id", function($q_typ) use ($project_type_row) {
					$q_typ->select("project_id")->from("project_type")->where("project_type_id", $project_type_row->id);
				})->limit(3)->get();
			}
			
			
			/*
			if($city_slg=='' && $project_type_slg!='')
				$route = route('front.search') . '/' . $project_type_slg . '/turkey';
			elseif($city_slg!='' && $project_type_slg=='')
				$route = route('front.search'). '/property-for-sale/' . $city_slg;
			elseif($city_slg!='' && $project_type_slg!='')
				$route = route('front.search'). '/'.$project_type_slg.'/turkey';
			else
				$route = route('front.search') . '/property-for-sale/turkey';
			
			return Redirect::to($route, 301);*/
		}
		
        return view("front.search", compact("projects", "inputs", "allprojects", "paginate_number"/*,"jsonprojects"*/,"q_tags","__type","__city","__var1","__var2","search_noindex"));
    }

    /**
     * Map a legacy search URL to the geo listing:
     * /{type}/{city}/{category|district}/{district} -> /{country}/{city}/{district}?type=&category=
     * Returns null when the URL can't be resolved, so search() keeps its 404 handling.
     *
     * @param \Illuminate\Http\Request $request
     * @param string|null $type
     * @param string|null $citySlug
     * @param string|null $var1
     * @param string|null $var2
     * @return string|null
     */
    protected function legacySearchGeoUrl(Request $request, $type, $citySlug, $var1, $var2)
    {
        $var1 = $var1 ? array_values(array_filter(explode(',', $var1))) : array();
        $var2 = $var2 ? array_values(array_filter(explode(',', $var2))) : array();

        $categories = array();
        $regionSlugs = array();
        if ($var1) {
            if (\App\Models\ProjectCategory::whereIn('slug', $var1)->count() > 0) {
                $categories = $var1;
            } elseif (\App\Models\Region::whereIn('slug', $var1)->count() > 0) {
                $regionSlugs = $var1;
            } else {
                return null;
            }
        }
        if ($var2) {
            $regionSlugs = $var2;
        }

        $params = array();
        if ($type && $type !== 'property-for-sale') {
            if (!\App\Models\ProjectType::where('slug', $type)->first()) {
                return null;
            }
            $params['type'] = $type;
        }
        if ($categories) {
            $params['category'] = implode(',', $categories);
        }
		
        $country = $citySlug ? \App\Models\Country::findBySlugOrCode($citySlug) : null;
        $cityRow = null;
        if (!$country) {
            $cityRow = $citySlug ? \App\Models\City::where('slug', $citySlug)->first() : null;
            if (!$cityRow || !$cityRow->listingUrl()) {
                return null;
            }
        }

        $regions = array();
        if ($regionSlugs) {
            $regionQuery = \App\Models\Region::whereIn('slug', $regionSlugs);
            if ($cityRow) {
                $regionQuery->where('city_id', $cityRow->id);
            }
            $regions = $regionQuery->get()->all();
            if (!$cityRow && $regions) {
                $cityRow = $regions[0]->city;
                $regions = array_values(array_filter($regions, function ($r) use ($cityRow) {
                    return $r->city_id == $cityRow->id;
                }));
            }
        }

        if (count($regions) && $regions[0]->listingUrl()) {
            $url = $regions[0]->listingUrl();
        } elseif ($cityRow && $cityRow->listingUrl()) {
            $url = $cityRow->listingUrl();
        } elseif ($country) {
            $url = $country->listingUrl();
        } else {
            return null;
        }

        $query = array_merge($request->except(array('ajax', 'amp', 'page')), $params);
        return $url . ($query ? '?' . str_replace('%2C', ',', http_build_query($query)) : '');
    }
    
    /**
    * contact
    *
    * @return void
    */
    public function contact()
    {
        return view("front.contact");
    }
    /**
    * show landing page
    *
    * @param string $slug
    * @return void
    */
    public function landingpage_show(Request $request,$slug)
    {
		$lang = (\LaravelLocalization::getCurrentLocale()=='pe'?'fa':\LaravelLocalization::getCurrentLocale());
        //$landing = Helper::query("LandingPage", "where", ["field" => "slug", "value" => $slug])->first();
        $landings = DB::table('landingpages')->where('slug',$slug )->get();//->where('lang',$lang )->first()
		
		foreach($landings as $l){
			$langs = explode(',',$l->lang);
			if(in_array($lang,$langs)){
				$landing = $l;
				break;
			}
		}
		
		
		if ( !isset($landing) ) abort(404);
		
		$device = Helper::get_device();
		/*if(!$request->get('cron_job') and file_exists("tmp/landing-".$slug."-".$lang."-".$device.".html")){
			
			DB::statement("UPDATE `dms_landingpages` SET `views`=`views`+1 where `id`=".$landing->id);
			
			include "tmp/landing-".$slug."-".$lang."-".$device.".html";
			exit();
		}*/
		
		
		
		$landing = Helper::query("LandingPage", "where", ["field" => "id", "value" => $landing->id])->first();
		
		if($lang=='ar')
			$landing->views += 1;
		elseif($lang=='pe' || $lang=='fa')
			$landing->views_fa += 1;
		elseif($lang=='en')
			$landing->views_en += 1; 
		elseif($lang=='fr')
			$landing->views_fr += 1; 
		elseif($lang=='ru')
			$landing->views_ru += 1; 
		
		$landing->save();
        
		//$lang = $landing->lang;
		
		
		
		
	/**/
	$id = $request->get('id',null);
	$hash = $request->get('hash',null);
	$cron_job = $request->get('cron_job',null);
	
	/*if($cron_job && $request->has('device') && $hash == md5($id).'b01'.sha1($id)){
		$result = view("front.landingpage_show", compact("landing", "lang", "slug"));
		$result = str_replace(array('    ','  '),' ',$result);

		file_put_contents("tmp/landing-".$slug."-".$lang."-".$request->get('device').".html", $result);
		return response()->json(['success' => 'success'], 200);
	}else{*/
		$lang = \LaravelLocalization::getCurrentLocale();
		return view("front.landingpage_show", compact("landing", "lang", "slug"));
	//}
    }
    /**
    * show landing page
    *
    * @param string $slug
    * @return void
    */
    public function landing2(Request $request,$slug)
    {
		//$lang = (\LaravelLocalization::getCurrentLocale()=='pe'?'fa':\LaravelLocalization::getCurrentLocale());
		$lang = (\LaravelLocalization::getCurrentLocale());
        //$landing = Helper::query("LandingPage", "where", ["field" => "slug", "value" => $slug])->first();
		$landings = DB::table('landing2')->where('slug',$slug )->get();//->where('lang',$lang )->first()

		foreach($landings as $l){
			$langs = explode(',',$l->lang);
			if(in_array($lang,$langs)){
				$landing = $l;
				break;
			}
		}


		if ( !isset($landing) ) abort(404);


		$landing = Helper::query("Landing2", "where", ["field" => "id", "value" => $landing->id])->first();
		
		if($lang=='ar')
			$landing->views += 1;
		elseif($lang=='pe' || $lang=='fa')
			$landing->views_fa += 1;
		elseif($lang=='en')
			$landing->views_en += 1; 
		elseif($lang=='fr')
			$landing->views_fr += 1; 
		elseif($lang=='ru')
			$landing->views_ru += 1; 
		
		$landing->save();
        
		
		//$offers = $landing->offers()->get();//->where('offer_end_date','>=',DB::raw('date(NOW())'))
		$landing2_resell_offers = DB::select("SELECT * FROM `dms_landing2_resell_offer` WHERE `landing2_id`=? order by arrange asc",[$landing->id]);
		

	/*$id = $request->get('id',null);
	$hash = $request->get('hash',null);
	$cron_job = $request->get('cron_job',null);
	
	$lang = \LaravelLocalization::getCurrentLocale();*/
	
	return view("front.landing2",compact('landing','landing2_resell_offers'));
	
    }
    /**
    * show landing page
    *
    * @param string $slug
    * @return void
    */
    public function landing3(Request $request,$slug)
    {
		//$lang = (\LaravelLocalization::getCurrentLocale()=='pe'?'fa':\LaravelLocalization::getCurrentLocale());
		$lang = (\LaravelLocalization::getCurrentLocale());
        //$landing = Helper::query("LandingPage", "where", ["field" => "slug", "value" => $slug])->first();
		$landings = DB::table('landing3')->where('slug',$slug )->get();//->where('lang',$lang )->first()

		foreach($landings as $l){
			$langs = explode(',',$l->lang);
			if(in_array($lang,$langs)){
				$landing = $l;
				break;
			}
		}


		if ( !isset($landing) ) abort(404);


		$landing = Helper::query("Landing3", "where", ["field" => "id", "value" => $landing->id])->first();
		
		if($lang=='ar')
			$landing->views += 1;
		elseif($lang=='pe' || $lang=='fa')
			$landing->views_fa += 1;
		elseif($lang=='en')
			$landing->views_en += 1; 
		elseif($lang=='fr')
			$landing->views_fr += 1; 
		elseif($lang=='ru')
			$landing->views_ru += 1; 
		
		$landing->save();
        
		
		//$offers = $landing->offers()->get();//->where('offer_end_date','>=',DB::raw('date(NOW())'))
		$landing2_resell_offers = DB::select("SELECT * FROM `dms_landing3_resell_offer` WHERE `landing3_id`=? order by arrange asc",[$landing->id]);
		

	/*$id = $request->get('id',null);
	$hash = $request->get('hash',null);
	$cron_job = $request->get('cron_job',null);
	
	$lang = \LaravelLocalization::getCurrentLocale();*/
	
	return view("front.landing3",compact('landing','landing2_resell_offers'));
	
    }
	    /**
    * show landing page
    *
    * @param string $slug
    * @return void
    */
    public function landing4(Request $request,$slug)
    {
		//$lang = (\LaravelLocalization::getCurrentLocale()=='pe'?'fa':\LaravelLocalization::getCurrentLocale());
		$lang = (\LaravelLocalization::getCurrentLocale());
        //$landing = Helper::query("LandingPage", "where", ["field" => "slug", "value" => $slug])->first();
		$landings = DB::table('landing2')->get();//->where('slug',$slug )

		foreach($landings as $l){
			$langs = explode(',',$l->lang);
			if(in_array($lang,$langs)){
				$landing = $l;
				break;
			}
		}


		if ( !isset($landing) ) abort(404);


		$landing = Helper::query("Landing2", "where", ["field" => "id", "value" => $landing->id])->first();
		
		if($lang=='ar')
			$landing->views += 1;
		elseif($lang=='pe' || $lang=='fa')
			$landing->views_fa += 1;
		elseif($lang=='en')
			$landing->views_en += 1; 
		elseif($lang=='fr')
			$landing->views_fr += 1; 
		elseif($lang=='ru')
			$landing->views_ru += 1; 
		
		$landing->save();
        
		
		//$offers = $landing->offers()->get();//->where('offer_end_date','>=',DB::raw('date(NOW())'))
		$landing2_resell_offers = DB::select("SELECT * FROM `dms_landing3_resell_offer` WHERE `landing3_id`=? order by arrange asc",[$landing->id]);
		

	/*$id = $request->get('id',null);
	$hash = $request->get('hash',null);
	$cron_job = $request->get('cron_job',null);
	
	$lang = \LaravelLocalization::getCurrentLocale();*/
	
	return view("front.landing4",compact('landing','landing2_resell_offers'));
	
    }
    /**
    * show landing_tourism page
    *
    * @param string $slug
    * @return void
    */
    public function landing_tourism(Request $request)
    {
		$lang = (\LaravelLocalization::getCurrentLocale());
        $landings = DB::table('landing_tourism')->get();//->where('lang',$lang )->first()->where('slug',$slug )

		foreach($landings as $l){
			$langs = explode(',',$l->lang);
			if(in_array($lang,$langs)){
				$landing = $l;
				break;
			}
		}


		if ( !isset($landing) ) abort(404);


		$landing = Helper::query("LandingTourism", "where", ["field" => "id", "value" => $landing->id])->first();
		
		if($lang=='ar')
			$landing->views += 1;
		elseif($lang=='pe' || $lang=='fa')
			$landing->views_fa += 1;
		elseif($lang=='en')
			$landing->views_en += 1;
		elseif($lang=='fr')
			$landing->views_fr += 1;
		elseif($lang=='ru')
			$landing->views_ru += 1;
		
		$landing->save();
        
		

	
		return view("front.landing_tourism",compact('landing'));
    }

    /**
    * show landing turkish citizenship page
    *
    * @param string $slug
    * @return void
    */
    public function newlandingpage($slug,Request $request)
    {
		$lang = (\LaravelLocalization::getCurrentLocale());
        $landing = DB::table('newlandingpages')->where('slug',$slug )->first();//->first()->where('slug',$slug )



		if ( !isset($landing) ) abort(404);


		$landing = Helper::query("NewLandingPage", "where", ["field" => "id", "value" => $landing->id])->first();
		
		//if($lang=='ar')
			$landing->views += 1;
		/*elseif($lang=='pe' || $lang=='fa')
			$landing->views_fa += 1;
		elseif($lang=='en')
			$landing->views_en += 1;
		elseif($lang=='fr')
			$landing->views_fr += 1;
		elseif($lang=='ru')
			$landing->views_ru += 1;*/
		
		$landing->save();


		return view("front.landing.".$slug,compact('landing'));
    }
    /**
    * show landing page
    *
    * @param string $slug
    * @return void
    */
    public function qr()
    {
		//$lang = (\LaravelLocalization::getCurrentLocale()=='pe'?'fa':\LaravelLocalization::getCurrentLocale());
		$lang = (\LaravelLocalization::getCurrentLocale());

		

	/*$id = $request->get('id',null);
	$hash = $request->get('hash',null);
	$cron_job = $request->get('cron_job',null);
	
	$lang = \LaravelLocalization::getCurrentLocale();*/
	
	return view("front.qr");
	
    }

    /**
    * callvac
    *
    * @return void
    */
    public function callvac(Request $request)
    {
        $current_lang = \LaravelLocalization::getCurrentLocale();
        if ( $request->isMethod('post') ) {
            $inputs = $request->all();
			//dd($inputs);
		
		
		

		/* Device */
		//$agent = new Agent();
		/*$inputs["device_type"] = $agent->device();//Iphone
		$inputs["platform"] = $agent->platform();//iOS
		$inputs["browser"] = $agent->browser();//chrome
		
            if ( $agent->isTablet() ) {
                $inputs["device"] = "Tablet";
            }elseif ( $agent->isMobile() ) {
                $inputs["device"] = "Mobile";
            } else {
                $inputs["device"] = "Desktop";
            }
		*/
		//$email = $request->get("email", null);
		//$inputs["country"] = @session()->get("iso_country");
		//$inputs["ip"] = @$_SERVER['HTTP_X_REAL_IP']; //\Request::ip();
		

            //if ( $request->ajax() ) {
                if ( trim($inputs['h_name'])=='' ) {
                    return response()->json([
                        "input" =>  "name",
                        "message" =>  trans("front.please enter your name"),
                    ]);
                }
				
				
				/*$inputs["lang"] = $current_lang;
				$inputs["name"] = htmlentities($name);
                $inputs["fame"] = htmlentities($fame);*/
				
                
                // Source visitor
                $cookie_reffer = Cookie::get("reffer");
                $coourl = parse_url($cookie_reffer);
				$inputs["page"] = \URL::previous();
                if ( ($cookie_reffer != str_replace('gclid=', '', $cookie_reffer)) or ($inputs["page"] != str_replace('gclid=', '', $inputs["page"])) ){
                    $inputs["src"] = "Adwords";
                } else {
                    $inputs["src"] = @$coourl['host'] ? $coourl['host'] : (@$coourl['path'] ? $coourl['path'] : 'دخول مباشر');
                }
                
				if(Cookie::get('gclid')!=''){
					$inputs["gclid"] = Cookie::get('gclid');
					$inputs["src"] = "Adwords";
					
				}
				if(Cookie::get('tags')!='')
					$inputs["tags"] = Cookie::get('tags');

				
                if ( $inputs["src"] == "دخول مباشر" ) {
                    $inputs["full_src"] = "دخول مباشر";
				} else {
                    $inputs["full_src"] = $cookie_reffer;
                }
				if(str_replace('ampproject','',$inputs["page"]) != $inputs["page"]){
					$inputs["src"] = 'Google AMP';
				}elseif(str_replace('fbclid','',$inputs["page"]) != $inputs["page"]){
					$inputs["src"] = 'facebook.com';
				}
                
                
				$inputs['navigation'] = Helper::clean_navigation(Cookie::get('navigation')). '>>call:'. (time()-1665411611);
				
				
				
				

                /*$saved_message = Helper::query("Message", "save", [
                    "inputs"    =>  $inputs,
                ]);*/
				
				
				
                // ZOHO CRM insert contact
				//$inputs['id'] = $saved_message->id;
                
				//$this->insert_to_crm($inputs);
				$is_src = false;
		foreach ( Helper::query("ClientSource", "orderBy", ["field" => "src", "value" => "DESC"])->get() as $row ) {
			if (strpos(strtolower(@$inputs["src"]), strtolower($row->src)) !== false) {
				$inputs['src'] = $row->code;
				$is_src = true;
				break;
			}
		}
		if(strpos(strtolower($inputs["src"]), 'ampproject') !== false)
			$inputs['src'] = 'Google AMP';
		elseif(strpos(strtolower($inputs["src"]), 'mail.google.com') !== false)
			$inputs['src'] = 'Gmail';
		elseif(trim($inputs["src"]) == 'دخول مباشر')
			$inputs['src'] = 'Direct';
		elseif(strpos(strtolower($inputs["src"]), 'google') !== false)
			$inputs['src'] = 'Google';
		elseif(strpos(strtolower($inputs["src"]), 'facebook') !== false)
			$inputs['src'] = 'Facebook';
		elseif(strpos(strtolower($inputs["src"]), 'youtube') !== false)
			$inputs['src'] = 'Youtube';
		elseif(strpos(strtolower($inputs["src"]), 'instagram') !== false)
			$inputs['src'] = 'Instagram';
			
			/*
		$inputs['src'] = str_replace('wwww.','',$inputs['src']);
		if(in_array(substr($inputs['src'], -4) , ['.net','.com']))
			$inputs['src'] = substr($inputs['src'], 0,-4);
		*/
		
		if(isset($_POST['src']) && $_POST['src']!=''){
			$inputs['src'] = $_POST['src'];
			//$inputs["full_src"]  = $_POST['src'];
		}



		if($inputs['src'] == 'Direct' && strpos(strtolower(@$inputs["page"]), 'damasturk') === false){

			$inputs['src'] = @$inputs["page"];
			
			if(strpos(strtolower($inputs["src"]), 'ampproject') !== false)
				$inputs['src'] = 'Google AMP';
			elseif(strpos(strtolower($inputs["src"]), 'mail.google.com') !== false)
				$inputs['src'] = 'Gmail';
			elseif(strpos(strtolower($inputs["src"]), 'google') !== false)
				$inputs['src'] = 'Google';
			elseif(strpos(strtolower($inputs["src"]), 'facebook') !== false)
				$inputs['src'] = 'Facebook';
			elseif(strpos(strtolower($inputs["src"]), 'instagram') !== false)
				$inputs['src'] = 'Instagram';
			elseif(strpos(strtolower($inputs["src"]), 'youtube') !== false)
				$inputs['src'] = 'Youtube';
				
			
		}
		
			$inputs['src'] = str_replace('wwww.','',$inputs['src']);
			if(in_array(substr($inputs['src'], -4) , ['.net','.com']))
				$inputs['src'] = substr($inputs['src'], 0,-4);
			
		

		//########### Insert to CRM ###################
		
		$data['h_source'] = $inputs['src'];
		$data['h_name'] = $inputs['h_name'];
		$data['h_email'] = $inputs['h_email'] . $inputs['emailType'];
		$data['h_campaign'] = '';
		$data['h_target'] = '';
		$tgs = [];
		$inputs["tags"] = '';
		if(Cookie::get('tags')!='')
			$inputs["tags"] = Cookie::get('tags');
		if($inputs['tags']!=''){
			$tgs = json_decode($inputs['tags'],true);
		}else{
			$t = explode('?',$inputs['page']);
			if(isset($t[1])){
				parse_str($t[1], $tgs);
			}
		}
		if(isset($_POST['src']) && $_POST['src']!=''){
			$tgs = [];
		}
		if(isset($tgs['campaign-name']) /*&& $tgs['utm_source']=='yektanet'*/){
			$data['h_campaign'] = $tgs['campaign-name'];
			$data['h_target'] = @$tgs['utm_content'];
		}elseif(isset($tgs['Search'])){
			$data['h_campaign'] = $tgs['Search'];
			$data['h_target'] = @$tgs['keyword'];
		}elseif(isset($tgs['Display'])){
			$data['h_campaign'] = $tgs['Display'];
			$data['h_target'] = isset($tgs['Target'])?$tgs['Target']:@$tgs['placement'];
		}elseif(isset($tgs['Remarket'])){
			$data['h_campaign'] = $tgs['Remarket'];
			$data['h_target'] = isset($tgs['Target'])?$tgs['Target']:@$tgs['placement'];
		}else{
			$data['h_campaign'] = @Helper::get_campaing($inputs['navigation']);
			$data['h_target'] = @Helper::get_target($inputs['page'],false,$inputs['navigation']);
		}
		
		
		$data['h_created_at'] = date('Y-m-d H:i');
		//$inputs['h_updated_at'] = date('Y-m-d H:i');
		
		$data['h_created_by'] = 0;
		$data['h_updated_by'] = 0;
		$data['h_category'] = 'Fresh';
		$data['h_type'] = 'Cvs';
		$data['h_country'] = Helper::code_to_country(@session()->get("iso_country"),false);
		if(isset($inputs['h_position']))
			if(is_array($inputs['h_position']))
				$data['h_position'] = implode(';',$inputs['h_position']);
			else
				$data['h_position'] = $inputs['h_position'];
	
		$data['h_commission'] = Helper::faTOen(@$inputs['h_commission']);
		$data['h_linkedin'] = @$inputs['h_linkedin'];
		$data['h_salary'] = @$inputs['h_salary'];
		$data['h_citizenship'] = @$inputs['h_citizenship'];
		//$data['h_age'] = @$inputs['h_age'];
		$data['h_age'] = @$inputs['h_age_m'] .'-'.  @$inputs['h_age_y'];
		$data['h_mobile'] = Helper::faTOen(str_replace([' ','-','.'],'',@$inputs['h_mobile']));
		$data['h_message'] = @$inputs['h_message'];
		$data['h_gender'] = @$inputs['h_gender'];
		$data['h_marriage'] = @$inputs['h_marriage'];
		$data['h_license'] = @$inputs['h_license'];
		//$data['h_entry_to_turkey'] = @$inputs['h_entry_to_turkey'];
		$data['h_entry_to_turkey'] = @$inputs['h_entry_to_turkey_m'] .'-'. @$inputs['h_entry_to_turkey_y'];
		$data['h_availability'] = @$inputs['h_availability'];
		$data['h_identification'] = @$inputs['h_identification'];
		//$data['h_source_txt'] = @$inputs['h_source_txt'];
		$data['h_type_job'] = @$inputs['h_type_job'];
		 
		 
		 
		
		
		
		//fix h_number_sales
		$is_real_estate = false;
		$withcommission = false;
		for($i=0;$i<count($inputs['companyName']);$i++){
			if(@$inputs['companySector'][$i]=='Real Estate'){
				$is_real_estate = true;
				break;
			}
		}
		$list_positions = [];
		if(is_array($inputs['h_position']))
			$list_positions = $inputs['h_position'];
		else
			$list_positions[] = $inputs['h_position'];
		
		foreach($list_positions as $posi){
			if(in_array($posi,['Telesales Manager','Arabic Telesales','English Telesales','French Telesales','Persian Telesales','Russian Telesales','Sales Manager','Salesman','Portfolio'])){
				$withcommission = true;
				break;
				}
		}
		
		if($is_real_estate == true && $withcommission == true){
			if(isset($inputs['h_number_sales']))
				$data['h_number_sales'] = (int)$inputs['h_number_sales'];
			else
				$data['h_number_sales'] = 0;
		}else{
			$data['h_number_sales'] = null;
		}


		$content_h_profile_image = @file_get_contents($inputs['h_profile_image']);

		
		$data['h_city'] = @$inputs['h_city'];
		$data['h_district'] = @$inputs['h_district'];
		
		//check already registred by Email and Mobile
		//if yess then add copie and convert to View CV
		$already_send_job = false;
		
		$arr_emails = DB::connection('mysql_crm')->table('hrs')->where('h_email', 'like', $data['h_email'])->where('h_code','!=','copie')->orderBy('id','asc')->get();
		if(count($arr_emails)>0){
			$hr_parent = $arr_emails[0]->id;
			$hr_h_code = $arr_emails[0]->h_code;
			$already_send_job = true;
		}else{
			$arr_mobs = DB::connection('mysql_crm')->table('hrs')->where(DB::raw("trim(h_mobile)"), trim(str_replace(['⁦', '⁩'], '', $inputs['h_mobile'])))->where('h_code','!=','copie')->orderBy('id','asc')->get();
			if(count($arr_mobs)>0){
				$hr_parent = $arr_mobs[0]->id;
				$hr_h_code = $arr_mobs[0]->h_code;
				$already_send_job = true;
			}
		}
		//End check already registred by Email and Mobile
		if($already_send_job == true){
			$data['h_code'] = 'copie';
			$data['hr_parent'] = $hr_parent;
			
			//@file_put_contents(public_path('h_profile_images/'.$data['h_code'].'.jpeg'), $content_h_profile_image);
			//$data['h_profile_image'] = '.jpeg';
			
			session()->put("job_success", $hr_h_code);
			
			
			
			//update Older
			//$data['hr_parent'] = $hr_parent;
			$data2 = $data;
			unset($data2['hr_parent']);
			unset($data2['h_code']);
			DB::connection('mysql_crm')->table('hrs')->where("id", $hr_parent)->update($data2);
			@file_put_contents(public_path('h_profile_images/'. $hr_h_code .'.jpeg'), $content_h_profile_image );
			
			//update view to 'Cvs'
			DB::connection('mysql_crm')->table('hrs')->where("id", $hr_parent)->where("h_type",'!=', 'Hired')->update(['h_type'=>'Cvs']);

			DB::connection('mysql_crm')->table('experiments')->where('hr_id',$hr_parent)->delete();
			DB::connection('mysql_crm')->table('langs')->where('hr_id',$hr_parent)->delete();
			DB::connection('mysql_crm')->table('certificates')->where('hr_id',$hr_parent)->delete();

		}else{
			$data['h_code'] = Helper::getNextHrCode();
			$hr_h_code = $data['h_code'];
			DB::connection('mysql_crm')->table('params')->where("id", '1')->update(['last_hr_code'=>$data['h_code']]);
			session()->put("job_success", $data['h_code']);
		}
		
		
		
		
		
        $insert_crm = DB::connection('mysql_crm')->table('hrs')->insert($data);
		$hr_id = DB::connection('mysql_crm')->getPdo()->lastInsertId();
		
		
		@file_put_contents(public_path('h_profile_images/'. $hr_id .'.jpeg'), $content_h_profile_image );
		DB::connection('mysql_crm')->table('hrs')->where('id',$hr_id)->update(['h_profile_image'=>$hr_id.'.jpeg']);
		
		//Insert Copie	
		if($already_send_job == false){
			$data_copie = $data;
			$data_copie['hr_parent'] = $hr_id;
			$data_copie['h_code'] = 'copie';
			$insert_crm = DB::connection('mysql_crm')->table('hrs')->insert($data_copie);
			$hr_id_copie = DB::connection('mysql_crm')->getPdo()->lastInsertId();	
			
			
			@file_put_contents(public_path('h_profile_images/'. $hr_id_copie .'.jpeg'), $content_h_profile_image);
			DB::connection('mysql_crm')->table('hrs')->where('id',$hr_id_copie)->update(['h_profile_image'=>$hr_id_copie.'.jpeg']);
			
		}
		//End Insert Copie

		@file_put_contents(public_path('h_profile_images/'.$data['h_code'].'.jpeg'), $content_h_profile_image);
		
		/*$certificates = DB::table('certificates')->where("hr_id", $id)->orderBy("id", "asc")->get();
		$experiments = DB::table('experiments')->where("hr_id", $id)->orderBy("id", "asc")->get();
		$langs = DB::table('langs')->where("hr_id", $id)->orderBy("id", "asc")->get();*/
		for($i=0;$i<count($inputs['companyName']);$i++){
			$data_ex['hr_id'] = $hr_id;
			$data_ex['companyName'] = @$inputs['companyName'][$i];
			$data_ex['companySector'] = @$inputs['companySector'][$i];
			
			
			$inputs['durationWorkFrom'][$i] = @$inputs['durationWorkFrom_m'][$i] .'-'. @$inputs['durationWorkFrom_y'][$i];
			$inputs['durationWorkTo'][$i] = @$inputs['durationWorkTo_m'][$i] .'-'. @$inputs['durationWorkTo_y'][$i];
			
			$inputs['durationWork'][$i] = @$inputs['durationWorkFrom'][$i] .' - '. @$inputs['durationWorkTo'][$i];
			$data_ex['durationWorkRange'] = $inputs['durationWork'][$i];
			$data_ex['durationWork'] = 0;
			
			$t1 = explode('-','01-' . @$inputs['durationWorkFrom'][$i]);
			$durationWorkFrom = @$t1[2].'-'. @$t1[1].'-'. @$t1[0];
			$t1 = explode('-','01-' . @$inputs['durationWorkTo'][$i]);
			$durationWorkTo = @$t1[2].'-'. @$t1[1].'-'. @$t1[0];
			
			
			if(strlen($durationWorkFrom)>9 && strlen($durationWorkTo)>9){
				$earlier = new \DateTime($durationWorkFrom);
				$later = new \DateTime($durationWorkTo);

				$inputs['durationWork'][$i] = $later->diff($earlier)->format("%a");

				$data_ex['durationWork'] = round($inputs['durationWork'][$i]/30,0);
			}
			
			
			//$data_ex['durationWork'] = @$inputs['durationWork'][$i];
			$data_ex['experience'] = @$inputs['experience'][$i];
			
			DB::connection('mysql_crm')->table('experiments')->insert($data_ex);
			
			
			if($already_send_job == true){
				$data_ex['hr_id'] = $hr_parent;
				DB::connection('mysql_crm')->table('experiments')->insert($data_ex);
			}
			
			//Insert Copie
			if($already_send_job==false){
				$data_ex['hr_id'] = $hr_id_copie;
				DB::connection('mysql_crm')->table('experiments')->insert($data_ex);
			}
			//End Insert Copie
		}
		
		$list_certs = ['PhD'=>8,'Master'=>7,"Bachelor's Degree"=>6,'Diploma'=>5,'Institute'=>4,'High School'=>3,'Middle School'=>2];
		for($i=0;$i<count($inputs['certificateName']);$i++){
			$data_cert['hr_id'] = $hr_id;
			$data_cert['certificateName'] = @$inputs['certificateName'][$i];
			$data_cert['universityName'] = @$inputs['universityName'][$i];
			$data_cert['specialization'] = @$inputs['specialization'][$i];
			$data_cert['stillStudying'] = @$inputs['stillStudying'][$i];
			$data_cert['certificateDegree'] = @$inputs['certificateDegree'][$i];
			$data_cert['certificateDegreeInt'] = @$list_certs[$data_cert['certificateName']];
			$data_cert['certificateDate'] = @$inputs['certificateDate'][$i];
			DB::connection('mysql_crm')->table('certificates')->insert($data_cert);
			
			
			
			if($already_send_job == true){
				$data_cert['hr_id'] = $hr_parent;
				DB::connection('mysql_crm')->table('certificates')->insert($data_cert);
			}
			//Insert Copie
			if($already_send_job==false){
				$data_cert['hr_id'] = $hr_id_copie;
				DB::connection('mysql_crm')->table('certificates')->insert($data_cert);
			}
			//End Insert Copie
		}
		
		
		$list_langs = ['Advanced'=>4,'Upper Intermediate'=>3,'Intermediate'=>2,'Beginner'=>1];
		for($i=0;$i<count($inputs['langName']);$i++){
			$data_lang['hr_id'] = $hr_id;
			$data_lang['langName'] = @$inputs['langName'][$i];
			$data_lang['langLevel'] = @$inputs['langLevel'][$i];
			$data_lang['langLevelInt'] = @$list_langs[$data_lang['langLevel']];
			$data_lang['hasCertificat'] = @$inputs['hasCertificat'][$i];
			DB::connection('mysql_crm')->table('langs')->insert($data_lang);
			
			
			
			
			if($already_send_job == true){
				$data_lang['hr_id'] = $hr_parent;
				DB::connection('mysql_crm')->table('langs')->insert($data_lang);
			}
			//Insert Copie
			if($already_send_job==false){
				$data_lang['hr_id'] = $hr_id_copie;
				DB::connection('mysql_crm')->table('langs')->insert($data_lang);
			}
			//End Insert Copie
		}
		
		
		
		
		$experience = '';
		$education = '';
		$languages = '';
		$Rexperience = DB::connection('mysql_crm')->table('experiments')->where("hr_id", $hr_id)->where("companySector", 'Real Estate')->orderBy(DB::raw("CAST(durationWork AS UNSIGNED)"), "desc")->first();
		if($Rexperience!=false){
			$experience = $Rexperience->companySector;
		}else{
			$Rexperience = DB::connection('mysql_crm')->table('experiments')->where("hr_id", $hr_id)->orderBy(DB::raw("CAST(durationWork AS UNSIGNED)"), "desc")->first();
			if($Rexperience!=false)
				$experience = $Rexperience->companySector;
		}
		
		
		$Reducation = DB::connection('mysql_crm')->table('certificates')->where("hr_id", $hr_id)->orderBy(DB::raw("CAST(certificateDegreeInt AS UNSIGNED)"), "desc")->first();
		if($Reducation!=false)
			$education = $Reducation->certificateName;
		$Rlanguages = DB::connection('mysql_crm')->table('langs')->where("hr_id", $hr_id)->orderBy(DB::raw("CAST(langLevelInt AS UNSIGNED)"), "desc")->first();
		if($Rlanguages!=false)
			$languages = $Rlanguages->langName;
		DB::connection('mysql_crm')->table('hrs')->where('id',$hr_id)->update(['experience'=>$experience,'education'=>$education,'languages'=>$languages]);
		
		
                return response()->json([
                    "message"   =>  "تم الإرسال شكرا لك",
                    "job_code"   =>  $hr_h_code,
                    "url"       =>  url(($current_lang!='ar'?'/'.$current_lang:'') . "/confirmation")
                ]);
            //}
            
        }
        //return redirect()->back();
		exit;
    }
	
	public function submitted_job(Request $request)
    {

		$job_code = session()->get('job_success');
		
		if ( !$job_code ) {abort(404);}
		
		
		
        return view("front.pages.submitted",['job_code'=>$job_code]);
    }
	
	function insert_to_reserve($inputs,$request){
		// Source visitor
                $cookie_reffer = Cookie::get('reffer');
                $coourl = parse_url($cookie_reffer);
                if ( ($cookie_reffer != str_replace('gclid=', '', $cookie_reffer)) or ($inputs["page"] != str_replace('gclid=', '', $inputs["page"])) ){
                    $inputs["src"] = "Adwords";
                } else {
                    $inputs["src"] = @$coourl['host'] ? $coourl['host'] : (@$coourl['path'] ? $coourl['path'] : 'دخول مباشر');
                }
                
				if(Cookie::get('gclid')!=''){
					$inputs["gclid"] = Cookie::get('gclid');
					$inputs["src"] = "Adwords";
					
				}
				if(Cookie::get('tags')!='')
					$inputs["tags"] = Cookie::get('tags');

				
                if ( $inputs["src"] == "دخول مباشر" ) {
                    $inputs["full_src"] = "دخول مباشر";
				} else {
                    $inputs["full_src"] = $cookie_reffer;
                }
				if(str_replace('ampproject','',$inputs["page"]) != $inputs["page"]){
					$inputs["src"] = 'Google AMP';
				}elseif(str_replace('fbclid','',$inputs["page"]) != $inputs["page"]){
					$inputs["src"] = 'facebook.com';
				}
                
                
				$inputs['navigation'] = Helper::clean_navigation(Cookie::get('navigation')). '>>call:'. (time()-1665411611);
				
				
				
				
				if($request->session()->has('searchs.id'))
					$inputs["search_fields"] = urlencode(serialize($request->session()->get('searchs.id', [])));
                $saved_message = Helper::query("Message3", "save", [
                    "inputs"    =>  $inputs,
                ]);
	}
	
	/**
    * call us
    *
    * @return void
    */
    public function call_us(Request $request)
    {
        $current_lang = \LaravelLocalization::getCurrentLocale();
        if ( $request->isMethod('post') ) {
            $inputs = $request->all();
			
		Helper::query("Message2", "save", [ "inputs"    =>  $inputs ]);
		
		
		
		
		if(isset($inputs['free_tour_form']) and $inputs['free_tour_form']=='1')
			$inputs['arrival_date'] = date("Y-m-d", strtotime($inputs['arrival_date']));	

		
		
		

		/* Device */
		$agent = new Agent();
		$inputs["device_type"] = $agent->device();//Iphone
		$inputs["platform"] = $agent->platform();//iOS
		$inputs["browser"] = $agent->browser();//chrome
		
            if ( $agent->isTablet() ) {
                $inputs["device"] = "Tablet";
            }elseif ( $agent->isMobile() ) {
                $inputs["device"] = "Mobile";
            } else {
                $inputs["device"] = "Desktop";
            }
			
            $name = trim($request->get("name", null));
			$fame = '';//$request->get("fame", null);
            $email = $request->get("email", null);
			$mobile = Helper::faTOen(str_replace(" ", "", $request->get("mobile", null)));
			if(@$mobile[0]=='0' and @$mobile[1]=='0'){
				$mobile = '+' . substr($mobile, 2);
			}

            $message = trim($request->get("message", null));
            
			
			$communication_time = $request->get("communication_time", null);
			
			
            $budget = $request->get("budget", null);
            $country = $request->get("country", null);
			$inputs["country"] = $country;
    	/*if(isset($_SERVER['HTTP_CF_IPCOUNTRY']))
			$inputs["country"] = $_SERVER["HTTP_CF_IPCOUNTRY"];*/
		$inputs["country"] = @session()->get("iso_country");
		
		/**/if(isset($_SERVER["HTTP_X_REAL_IP"]))
			$inputs["ip"] = $_SERVER["HTTP_X_REAL_IP"];
		else
			$inputs["ip"] = @$_SERVER['HTTP_CF_CONNECTING_IP']; //\Request::ip();
		




			$inputs["lang"] = $current_lang;
			$inputs["name"] = htmlentities($name);
			$inputs["fame"] = htmlentities($fame);
			$inputs["fullname"] = $inputs["name"];
			//$inputs["email"] = htmlentities($email);
			$inputs["mobile"] = htmlentities($mobile);
			$inputs["message"] = htmlentities($message);
			$inputs["communication_time"] = htmlentities($communication_time);
			$inputs["budget"] = htmlentities($budget);
			//$inputs["country"] = htmlentities($country);
			$inputs["page"] = \URL::previous();
			$inputs["form_type"] = $request->get("form_type", null);
				
				
				
            //if ( $request->ajax() ) {
			if ( !$name ) {
				$this->insert_to_reserve($inputs,$request);
				return response()->json([
					"input" =>  "name",
					"message" =>  trans("front.please enter your name"),
				]);
			}
				
				
			if($request->get("communication_time", null)!='')
				$communication_time = $request->get("communication_time", null);
			else
				$communication_time = "";
			
			
			
				
				/*if ( !$message ) {
                    return response()->json([
                        "input" =>  "message",
                        "message" =>  trans("front.please enter your name"),
                    ]);
                }*/
				/*if ( !$fame ) {
                    return response()->json([
                        "input" =>  "fame",
                        "message" =>  trans("front.please enter your fame"),
                    ]);
                }*/
                /*if ( !$email ) {
                    return response()->json([
                        "input" =>  "email",
                        "message" =>  trans("front.please enter your email"),
                    ]);
                }
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					return response()->json([
                        "input" =>  "email",
                        "message" =>  trans("front.please enter a valid email"),
                    ]);
				}*/
				
                if ( !$mobile ) {
					$this->insert_to_reserve($inputs,$request);
                    return response()->json([
                        "input" =>  "mobile",
                        "message" =>  trans("front.please enter your mobile"),
                    ]);
                }
                if ( !preg_match('/^[+][0-9 ]{7,20}$/', $mobile) ) {
					$this->insert_to_reserve($inputs,$request);
                    return response()->json([
                        "input" =>  "mobile",
                        "message" =>  trans("front.please enter a valid mobile number"),
                    ]);
                }
                if ( !$message ) {
					$this->insert_to_reserve($inputs,$request);
                    return response()->json([
                        "input" =>  "message",
                        "message" =>  trans("front.please enter the message"),
                    ]);
                }
				/*if ( $communication_time=='' ) {
				return response()->json([
					"input" =>  "communication_time",
					"message" =>  trans("front.please select a contact time"),
				]);
				}*/

				
				
                
                // Source visitor
                $cookie_reffer = Cookie::get("reffer");
                $coourl = parse_url($cookie_reffer);
                if ( ($cookie_reffer != str_replace('gclid=', '', $cookie_reffer)) or ($inputs["page"] != str_replace('gclid=', '', $inputs["page"])) ){
                    $inputs["src"] = "Adwords";
                } else {
                    $inputs["src"] = @$coourl['host'] ? $coourl['host'] : (@$coourl['path'] ? $coourl['path'] : 'دخول مباشر');
                }
                
				if(Cookie::get('gclid')!=''){
					$inputs["gclid"] = Cookie::get('gclid');
					$inputs["src"] = "Adwords";
					
				}
				if(Cookie::get('tags')!='')
					$inputs["tags"] = Cookie::get('tags');

				
                if ( $inputs["src"] == "دخول مباشر" ) {
                    $inputs["full_src"] = "دخول مباشر";
				} else {
                    $inputs["full_src"] = $cookie_reffer;
                }
				if(str_replace('ampproject','',$inputs["page"]) != $inputs["page"]){
					$inputs["src"] = 'Google AMP';
				}elseif(str_replace('fbclid','',$inputs["page"]) != $inputs["page"]){
					$inputs["src"] = 'facebook.com';
				}
                
                
				$inputs['navigation'] = Helper::clean_navigation(Cookie::get('navigation')). '>>call:'. (time()-1665411611);
				
				
				
				
				if($request->session()->has('searchs.id'))
					$inputs["search_fields"] = urlencode(serialize($request->session()->get('searchs.id', [])));
                $saved_message = Helper::query("Message", "save", [
                    "inputs"    =>  $inputs,
                ]);
				
				
				

                
                // ZOHO CRM insert contact
				$inputs['id'] = $saved_message->id;
                
				//$this->insert_to_crm($inputs);

                session()->flash("flashmessage", null);
                session()->put("callus_success", $saved_message->id);

                return response()->json([
                    "message"   =>  "تم الإرسال شكرا لك",
                    "url"       =>  url(($current_lang!='ar'?'/'.$current_lang:'') . "/confirmation")
                ]);
            //}
            
        }
        //return redirect()->back();
		exit;
    }





	/**
    * call us landing tourism
    *
    * @return void
    */
    public function call_us_landing_tourism(Request $request)
    {
        $current_lang = \LaravelLocalization::getCurrentLocale();
        if ( $request->isMethod('post') ) {
            $inputs = $request->all();
			
		
		

		/* Device */
		$agent = new Agent();
		$inputs["device_type"] = $agent->device();//Iphone
		$inputs["platform"] = $agent->platform();//iOS
		$inputs["browser"] = $agent->browser();//chrome
		
            if ( $agent->isTablet() ) {
                $inputs["device"] = "Tablet";
            }elseif ( $agent->isMobile() ) {
                $inputs["device"] = "Mobile";
            } else {
                $inputs["device"] = "Desktop";
            }
			
            $name = trim($request->get("name", null));
			$fame = '';//$request->get("fame", null);
            $email = $request->get("email", null);
			
			
			
			
			$mobile = Helper::faTOen(str_replace(" ", "", $request->get("mobile", null)));
			if(@$mobile[0]=='0' and @$mobile[1]=='0'){
				$mobile = '+' . substr($mobile, 2);
			}

            $message = trim($request->get("message", null));
            
			
			$communication_time = $request->get("communication_time", null);
			
			
            $budget = $request->get("budget", null);
            $country = $request->get("country", null);
			$inputs["country"] = $country;
    	/*if(isset($_SERVER['HTTP_CF_IPCOUNTRY']))
			$inputs["country"] = $_SERVER["HTTP_CF_IPCOUNTRY"];*/
		$inputs["country"] = @session()->get("iso_country");
		
		/*if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
			$inputs["ip"] = $_SERVER["HTTP_CF_CONNECTING_IP"];
		else*/
			$inputs["ip"] = @$_SERVER['HTTP_X_REAL_IP']; //\Request::ip();
		




			$inputs["email"] = $email;
			$inputs["lang"] = $current_lang;
			$inputs["name"] = htmlentities($name);
			$inputs["fame"] = htmlentities($fame);
			$inputs["fullname"] = $inputs["name"];
			//$inputs["email"] = htmlentities($email);
			$inputs["mobile"] = htmlentities($mobile);
			$inputs["message"] = htmlentities($message);
			$inputs["communication_time"] = htmlentities($communication_time);
			$inputs["budget"] = htmlentities($budget);
			//$inputs["country"] = htmlentities($country);
			$inputs["page"] = \URL::previous();
			$inputs["form_type"] = $request->get("form_type", null);
				
				
				
            //if ( $request->ajax() ) {
			if ( !$name ) {
				return response()->json([
					"input" =>  "name",
					"message" =>  trans("front.please enter your name"),
				]);
			}
			
			
			
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				return response()->json([
					"input" =>  "email",
					"message" =>  ("please enter a valid email"),
				]);
			}
				
                if ( !$mobile ) {
					return response()->json([
                        "input" =>  "mobile",
                        "message" =>  trans("front.please enter your mobile"),
                    ]);
                }
                if ( !preg_match('/^[+][0-9 ]{7,20}$/', $mobile) ) {
					return response()->json([
                        "input" =>  "mobile",
                        "message" =>  trans("front.please enter a valid mobile number"),
                    ]);
                }



                // Source visitor
                $cookie_reffer = Cookie::get("reffer");
                $coourl = parse_url($cookie_reffer);
                if ( ($cookie_reffer != str_replace('gclid=', '', $cookie_reffer)) or ($inputs["page"] != str_replace('gclid=', '', $inputs["page"])) ){
                    $inputs["src"] = "Adwords";
                } else {
                    $inputs["src"] = @$coourl['host'] ? $coourl['host'] : (@$coourl['path'] ? $coourl['path'] : 'دخول مباشر');
                }
                
				if(Cookie::get('gclid')!=''){
					$inputs["gclid"] = Cookie::get('gclid');
					$inputs["src"] = "Adwords";
				}
				if(Cookie::get('tags')!='')
					$inputs["tags"] = Cookie::get('tags');

                if ( $inputs["src"] == "دخول مباشر" ) {
                    $inputs["full_src"] = "دخول مباشر";
				} else {
                    $inputs["full_src"] = $cookie_reffer;
                }
				if(str_replace('ampproject','',$inputs["page"]) != $inputs["page"]){
					$inputs["src"] = 'Google AMP';
				}elseif(str_replace('fbclid','',$inputs["page"]) != $inputs["page"]){
					$inputs["src"] = 'facebook.com';
				}
                
                
				$inputs['navigation'] = Helper::clean_navigation(Cookie::get('navigation')). '>>call:'. (time()-1665411611);
				
				
				
				
				if($request->session()->has('searchs.id'))
					$inputs["search_fields"] = urlencode(serialize($request->session()->get('searchs.id', [])));
                $saved_message = Helper::query("MessageLandingTourism", "save", [
                    "inputs"    =>  $inputs,
                ]);
				
				
				

                
                // ZOHO CRM insert contact
				$inputs['id'] = $saved_message->id;
                
				//$this->insert_to_crm($inputs);

                session()->flash("flashmessage", null);
                session()->put("callus_success", $saved_message->id);

                return response()->json([
                    "success"   =>  1,
                    "message"   =>  "تم الإرسال شكرا لك",
                    "url"       =>  url(($current_lang!='ar'?'/'.$current_lang:'') . "/confirmation")
                ]);
            //}
            
        }
        //return redirect()->back();
		exit;
    }
    /**
    * call us 2
    *
    * @return void
    */
    public function call_us2(Request $request)
    {
        $current_lang = \LaravelLocalization::getCurrentLocale();
        if ( $request->isMethod('post') ) {
            $inputs = $request->all();
			
			Helper::query("Message2", "save", [ "inputs"    =>  $inputs ]);
			
			/*if($request->get("share", null)=='1'){
				$Quiz = Helper::query("Quiz", "find", ["id" => session()->get('share_success')]);
				if ( $Quiz!=false ) {
					$Quiz->update(["share" => 'True']);
				}
				session()->forget("share_success");
				exit;
			}*/
		/* Device */
		$agent = new Agent();
		$inputs["device_type"] = $agent->device();//Iphone
		$inputs["platform"] = $agent->platform();//iOS
		$inputs["browser"] = $agent->browser();//chrome
		
            if ( $agent->isTablet() ) {
                $inputs["device"] = "Tablet";
            }elseif ( $agent->isMobile() ) {
                $inputs["device"] = "Mobile";
            } else {
                $inputs["device"] = "Desktop";
            }
			
            $familymembers = $request->get("familymembers", null);
            $name = $request->get("name", null);
			$mobile = Helper::faTOen(str_replace(" ", "", $request->get("mobile", null)));
			if(@$mobile[0]=='0' and @$mobile[1]=='0'){
				$mobile = '+' . substr($mobile, 2);
			}
            
                if($request->get("form_type", null) == 'newsletter'){
					$inputs["form_type"] = 'newsletter';
					$inputs["message"] = 'newsletter';
				}else{
					$inputs["form_type"] = 'فورم الهدية';
					$inputs["message"] = 'فورم الهدية';
				}
            //if ( $request->ajax() ) {
				if($request->get("form_type", null) != 'newsletter')
                if ( !$name ) {
                    return response()->json([
                        "input" =>  "name",
                        "message" =>  trans("front.please enter your name"),
                    ]);
                }
                if ( !$mobile ) {
                    return response()->json([
                        "input" =>  "mobile",
                        "message" =>  trans("front.please enter your mobile"),
                    ]);
                }
                if ( !preg_match('/^[+][0-9 ]{7,20}$/', $mobile) ) {
                    return response()->json([
                        "input" =>  "mobile",
                        "message" =>  trans("front.please enter a valid mobile number"),
                    ]);
                }
				
				/*if($inputs["form_type"] == 'quiz')
                if ( !$familymembers ) {
                    return response()->json([
                        "input" =>  "familymembers",
                        "message" =>  (\LaravelLocalization::getCurrentLocale()=='en'?'please enter number of family members':'من فضلك ادخل عدد افراد اسرتك'),
                    ]);
                }*/
				

				$inputs["lang"] = $current_lang;
				$inputs["name"] = htmlentities($name);
				$inputs["fullname"] = $inputs["name"];
                $inputs["mobile"] = htmlentities($mobile);
                $inputs["page"] = \URL::previous();
                
                // Source visitor
                $cookie_reffer = Cookie::get("reffer");
                $coourl = parse_url($cookie_reffer);
                if ( ($cookie_reffer != str_replace('gclid=', '', $cookie_reffer)) or ($inputs["page"] != str_replace('gclid=', '', $inputs["page"])) ){
                    $inputs["src"] = "Adwords";
                } else {
                    $inputs["src"] = @$coourl['host'] ? $coourl['host'] : (@$coourl['path'] ? $coourl['path'] : 'دخول مباشر');
                }


				if(Cookie::get('gclid')!=''){
					$inputs["gclid"] = Cookie::get('gclid');
					$inputs["src"] = "Adwords";
					
				}
					if(Cookie::get('tags')!='')
					$inputs["tags"] = Cookie::get('tags');

                if ( $inputs["src"] == "دخول مباشر" ) {
                    $inputs["full_src"] = "دخول مباشر";
                } else {
                    $inputs["full_src"] = $cookie_reffer;
                }


		
		/*if(isset($_SERVER['HTTP_CF_IPCOUNTRY']))
			$inputs["country"] = $_SERVER["HTTP_CF_IPCOUNTRY"];*/
		$inputs["country"] = @session()->get("iso_country");
		
		/*if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
			$inputs["ip"] = $_SERVER["HTTP_CF_CONNECTING_IP"];
		else*/
			$inputs["ip"] = @$_SERVER['HTTP_X_REAL_IP']; //\Request::ip();


				$inputs['navigation'] = Helper::clean_navigation(Cookie::get('navigation')). '>>call:'. (time()-1665411611);
                
				if($inputs["form_type"] == 'quiz')
					$saved_message = Helper::query("Quiz", "save", [
						"inputs"    =>  $inputs,
					]);
				else{
					if($request->session()->has('searchs.id'))
						$inputs["search_fields"] = urlencode(serialize($request->session()->get('searchs.id', [])));
					$saved_message = Helper::query("Message", "save", [
						"inputs"    =>  $inputs,
					]);
					//$this->insert_to_crm2($inputs);
				}
                //$inputs['id'] = $saved_message->id;


                session()->flash("flashmessage", null);

				/*if($inputs["form_type"] == 'quiz')
					session()->put("share_success", $saved_message->id);
				else*/
					session()->put("callus_success", $saved_message->id);

				if(/*$inputs["form_type"] == 'quiz' or*/ $inputs["form_type"] == 'newsletter')
					/*return response()->json([
						"success"   => true
					]);*/
					return response()->json([
						"message"   =>  trans("front.signup newsletter success"),
					]);
				else
					return response()->json([
						"message"   =>  "تم الإرسال شكرا لك",
						"url"       =>  url(($current_lang!='ar'?'/'.$current_lang:'') . "/confirmation")
					]);
            //}
            
        }
        //return redirect()->back();
		exit;
    }
    /*
    * quiz
    *
    * @return void
    
    public function quiz(Request $request)
    {
		$row = Helper::query("Page", "where", ["field" => "slug", "value" => "quiz"])->first();
        //if ( !$row ) $row = Helper::query("Page", "new");
		return view("front.quiz", compact("row"));
	}*/
    /**
    * call vac
    *
    * @return void
    */
    /*public function callvac(Request $request)
    {
		//sleep(6);
        $current_lang = \LaravelLocalization::getCurrentLocale();
        if ( $request->isMethod('post') ) {
            $inputs = $request->all();
			
			
			
            $citizenship = $request->get("citizenship", null);
            $name = $request->get("name", null);
            $email = $request->get("email", null);
			$mobile = str_replace(" ", "", $request->get("mobile", null));

            

            if ( $request->ajax() ) {
                if ( !$name ) {
                    return response()->json([
                        "input" =>  "name",
                        "message" =>  ("please enter your name"),
                    ]);
                }
                if ( !$mobile ) {
                    return response()->json([
                        "input" =>  "mobile",
                        "message" =>  ("please enter your mobile"),
                    ]);
                }
                if ( !preg_match('/^[+0-9 ]{7,20}$/', $mobile) ) {
                    return response()->json([
                        "input" =>  "mobile",
                        "message" =>  ("please enter a valid mobile number"),
                    ]);
                }
				
                if ( !$email ) {
                    return response()->json([
                        "input" =>  "email",
                        "message" =>  ("please enter your email"),
                    ]);
                }
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					return response()->json([
                        "input" =>  "email",
                        "message" =>  ("please enter a valid email"),
                    ]);
				}

				$path = "degs/";
				//$files = $request->file('field');
				$files = $request->get('field', []);
				
				$degs = $request->get('academic_degree', []);
				
				$arr_fields = array();
				$arr_degs = array();
				foreach ($files as $kfile => $file) {
                    //$ext = $file->getClientOriginalExtension();
                    //$name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    //$new_name = str_slug($name).MD5(time());
                    //$filename = $new_name.".".$ext;
					//$arr_fields[] = $filename;
					//
					$arr_fields[] = $file;
					$arr_degs[] = @$degs[$kfile];
					
					//
					//if(!in_array(strtolower($ext),array('pdf','doc','docx'))){
					//	return response()->json([
                    //    "input" =>  "field",
                    //    "message" =>  "file extension '".$ext."' not allowed",
                   // ]);
					//}
					
					
					//$file->move(public_path($path), $filename);
					//
				}
				
				
				$arr_fields = serialize($arr_fields);
				$inputs['field'] = urlencode($arr_fields);
				
				$arr_degs = serialize($arr_degs);
				$inputs['academic_degree'] = urlencode($arr_degs);
				
				
				
				
				$companys = $request->get('company', []);
				$periods = $request->get('period', []);
				
				$arr_companys = array();
				$arr_periods = array();
				foreach ($companys as $k => $company) {
					$arr_companys[] = $company;
					$arr_periods[] = @$periods[$k];
				}

				
				$arr_companys = serialize($arr_companys);
				$inputs['company'] = urlencode($arr_companys);

				$arr_periods = serialize($arr_periods);
				$inputs['period'] = urlencode($arr_periods);


				$inputs["citizenship"] = $citizenship;
				$inputs["lang"] = $current_lang;
				$inputs["name"] = htmlentities($name);
				$inputs["fullname"] = $inputs["name"];
                $inputs["mobile"] = htmlentities($mobile);
                
                $saved_message = Helper::query("Messagevac", "save", [
                    "inputs"    =>  $inputs,
                ]);
				
                session()->flash("flashmessage", null);
                session()->put("callus_success", $saved_message->id);

                return response()->json([
                    "message"   =>  "تم الإرسال شكرا لك",
                    "url"       =>  url( ($current_lang=='en'?'/en':'') . "/confirmation")
                ]);
            }
            
        }
        return redirect()->back();
    }*/
    public function call_us_confirmation(Request $request)
    {
	/*if(isset($_GET['amp'])){
		return view("front.confirmation");
	}*/


	if(!$request->get("page", null))
		$callus_success = session()->get('callus_success');
	elseif(isset($_GET['amp'])){
		session()->put("callus_success", $request->get("page", null));
		$callus_success = session()->get('callus_success');
	}

		if ( !$callus_success ) {abort(404);}
		
		if ( $request->isMethod("post") ) {
            $this->validate($request, ["email" => "required|email"]);
            $email = htmlentities($request->get("email"));
            // save
            $row = Helper::query("Newsletter", "where", ["field" => "email", "value" => $email])->first();
            if ( !$row ) {
                $row = Helper::query("Newsletter", "new");
                $row->email = $email;
                $row->save();
            }
            
			
			
            $message = Helper::query("Message", "find", ["id" => $callus_success]);
            if ( !@$message->email ) {
                $message->update(["email" => $email]);
			   }
				//$results = DB::select("select * from dms_messages where insert_crm=0 and created_at <= NOW() - INTERVAL 5 MINUTE");
				$r = json_decode(json_encode($message), true);
				
				if($r['form_type']=='فورم الهدية')
					$this->insert_to_crm2($r);
				else
					$this->insert_to_crm($r);
         
			
			session()->forget("callus_success");
            
			//echo 'OK:'.$callus_success;
            return redirect()->route("front.index");
        }
		
        return view("front.confirmation");
    }
	
    function insert_to_crm($inputs = []){
		$is_src = false;
		foreach ( Helper::query("ClientSource", "orderBy", ["field" => "src", "value" => "DESC"])->get() as $row ) {
			if (strpos(strtolower(@$inputs["src"]), strtolower($row->src)) !== false) {
				$inputs['src'] = $row->code;
				$is_src = true;
				break;
			}
		}
		if(strpos(strtolower($inputs["src"]), 'ampproject') !== false)
			$inputs['src'] = 'Google AMP';
		elseif(strpos(strtolower($inputs["src"]), 'mail.google.com') !== false)
			$inputs['src'] = 'Gmail';
		elseif(trim($inputs["src"]) == 'دخول مباشر')
			$inputs['src'] = 'Direct';
		elseif(strpos(strtolower($inputs["src"]), 'google') !== false)
			$inputs['src'] = 'Google';
		elseif(strpos(strtolower($inputs["src"]), 'facebook') !== false)
			$inputs['src'] = 'Facebook';
		elseif(strpos(strtolower($inputs["src"]), 'instagram') !== false)
			$inputs['src'] = 'Instagram';
		elseif(strpos(strtolower($inputs["src"]), 'youtube') !== false)
			$inputs['src'] = 'Youtube';
			
			
		
		
		
		

		if($inputs['src'] == 'Direct' && strpos(strtolower(@$inputs["page"]), 'damasturk') === false){

			$inputs['src'] = @$inputs["page"];
			
			if(strpos(strtolower($inputs["src"]), 'ampproject') !== false)
				$inputs['src'] = 'Google AMP';
			elseif(strpos(strtolower($inputs["src"]), 'mail.google.com') !== false)
				$inputs['src'] = 'Gmail';
			elseif(strpos(strtolower($inputs["src"]), 'google') !== false)
				$inputs['src'] = 'Google';
			elseif(strpos(strtolower($inputs["src"]), 'facebook') !== false)
				$inputs['src'] = 'Facebook';
			elseif(strpos(strtolower($inputs["src"]), 'instagram') !== false)
				$inputs['src'] = 'Instagram';
			elseif(strpos(strtolower($inputs["src"]), 'youtube') !== false)
				$inputs['src'] = 'Youtube';
				
				
			
			
			if(isset($_POST['src']) && $_POST['src']!=''){
				$inputs['src'] = $_POST['src'];
				//$inputs["full_src"]  = $_POST['src'];
			}
		}
		
		$inputs['src'] = str_replace('wwww.','',$inputs['src']);
		if(in_array(substr($inputs['src'], -4) , ['.net','.com']))
			$inputs['src'] = substr($inputs['src'], 0,-4);
		
		$current_lang = $inputs['lang'];
		
		//$inputs['mobile'] = str_replace("+", "", $inputs['mobile']);
		$fame = $inputs["fame"]?:".";
		
		
		
		$inputs['name'] = $inputs['name'];
		$inputs['email'] = $inputs['email'];
		$inputs['mobile'] = $inputs['mobile'];
		$inputs['message'] = $inputs['message'];
		$inputs['communication_time'] = $inputs['communication_time'];
		$inputs['page'] = str_replace('www-damas-net.cdn.ampproject.org/v/s/','',strtok($inputs['page'], '?'));
		$inputs['src'] = str_replace('www-damas-net.cdn.ampproject.org/v/s/','',strtok($inputs['src'], '?'));
		$inputs['country'] = Helper::code_to_country($inputs['country'],false);
		$inputs['budget'] = str_replace('&lt;','<',$inputs['budget']);
		$inputs['navigation'] = strtok($inputs['navigation'], '?');
		
		
		$inputs["email_inquiries"] = env("MAIL_INQUIRIES", "leads@damas.net");
		/*
		//send to admin
		$inputs["email_inquiries"] = env("MAIL_INQUIRIES", "leads@damas.net");
		// send mail to admin
		Mail::send("emails.callus_admin", ["inputs" => $inputs], function ($m) use ($inputs) {
			$m->from("noreply@damas.net", $inputs["name"])
				->to($inputs["email_inquiries"])
				->subject("داماس تورك العقارية - رسالة جديدة");
		});*/
		
		
		// send mail to user
		if ( $inputs["email"] ) {
			$params = Helper::get_params();
			if ( $params->user_email_send == 0 ) {
				$inputs["from_name"] = $params->name;
				
				//$inputs["message_content"] = str_replace(["{name}", "{email}", "{mobile}", "{message}"], [$inputs["name"], $inputs["email"], $inputs["mobile"], $inputs["message"]], nl2br($params->user_email_text));
				$inputs["message_content"] = str_replace(["{name}", "{email}", "{mobile}", "{message}", "{communication_time}", "{budget}"], [$inputs["name"], $inputs["email"], "<span dir='ltr'>{$inputs["mobile"]}</span>", $inputs["message"], $inputs["communication_time"], $inputs["budget"]], nl2br($params->user_email_text));
				if ( $current_lang == "ar" ) {
					$inputs["message_content"] = "<html lang='ar' dir='rtl'><head></head><body><div style='font-size:15px;direction:rtl;text-align:right;'>".$inputs["message_content"]."</div></body></html>";
				}
				
				//$inputs["message_subject"] = str_replace(["{name}", "{email}", "{mobile}", "{message}"], [$inputs["name"], $inputs["email"], $inputs["mobile"], $inputs["message"]], nl2br($params->user_email_title));
				$inputs["message_subject"] = str_replace(["{name}", "{email}", "{mobile}", "{message}", "{communication_time}", "{budget}"], [$inputs["name"], $inputs["email"], $inputs["mobile"], $inputs["message"], $inputs["communication_time"], $inputs["budget"]], nl2br($params->user_email_title));
				
			
				
				Mail::send([], [], function ($m) use ($inputs) {
					$m->from($inputs["email_inquiries"], $inputs["from_name"])
						->to($inputs["email"])
						->subject($inputs["message_subject"])
						->setBody($inputs["message_content"], "text/html");
				});
			}
		}






		
		
		
		
		
		
		
		
		
		
		//########### Insert to CRM ###################
		$data['is_damas_net'] = $inputs['is_damas_net'];
		$data['name'] = $inputs['name'] .' '. @$inputs["fame"];
		$data['mobile'] = Helper::faTOen(str_replace([' ','-','.'],'',$inputs['mobile']));
		$data['email'] = $inputs['email'];
		$data['message'] = $inputs['message'];
		$data['contact_time'] = $inputs['communication_time'];
		$data['source'] = $inputs['src'];
		$data['gadget'] = $inputs['device'];
		
		
		if(isset($inputs['free_tour_form']) and $inputs['free_tour_form']=='1'){
			$data['free_tour_form'] = true;
			$data['tour_type'] = $inputs['tour_type'];
			$data['arrival_date'] = date("Y-m-d", strtotime($inputs['arrival_date']));
		}
		
		$data['campaign'] = '';
		$data['target'] = '';
		$tgs = [];
		if($inputs['tags']!=''){
			$tgs = json_decode($inputs['tags'],true);
		}else{
			$t = explode('?',$inputs['page']);
			if(isset($t[1])){
				parse_str($t[1], $tgs);
			}
		}
		if(isset($tgs['campaign-name']) /*&& $tgs['utm_source']=='yektanet'*/){
			$data['campaign'] = $tgs['campaign-name'];
			$data['target'] = @$tgs['utm_content'];
		}elseif(isset($tgs['Search'])){
			$data['campaign'] = $tgs['Search'];
			$data['target'] = @$tgs['keyword'];
		}elseif(isset($tgs['Display'])){
			$data['campaign'] = $tgs['Display'];
			$data['target'] = isset($tgs['Target'])?$tgs['Target']:@$tgs['placement'];
		}elseif(isset($tgs['Remarket'])){
			$data['campaign'] = $tgs['Remarket'];
			$data['target'] = isset($tgs['Target'])?$tgs['Target']:@$tgs['placement'];
		}else{
			$data['campaign'] = @Helper::get_campaing($inputs['navigation']);
			$data['target'] = @Helper::get_target($inputs['page'],false,$inputs['navigation']);
		}
		
		$data['search_fields'] = $inputs['search_fields'];
		
		$data['budget'] = $inputs['budget'];
		$data['navigation'] = Helper::clean_navigation(@$inputs["navigation"]). '>>call:'. (time()-1665411611);
		$data['country'] = $inputs['country'];
		$data['l_created_at'] = date('Y-m-d H:i');
		$data['l_updated_at'] = date('Y-m-d H:i');
		$data['l_created_by'] = 0;
		$data['l_updated_by'] = 0;
		
		$crm_oman = '';
		if(@$inputs['ccountry']=='oman')
		$crm_oman = 'oman';
		
		$data['code'] = Helper::getNextLeadCode($crm_oman);
		DB::connection('mysql_crm'.$crm_oman)->table('params')->where("id", '1')->update(['last_lead_code'=>$data['code']]);
		
        $insert_crm = DB::connection('mysql_crm'.$crm_oman)->table('leads')->insert($data);
		$lead_id = DB::connection('mysql_crm'.$crm_oman)->getPdo()->lastInsertId();
		DB::table('messages')->where("id", $inputs['id'])->update(['insert_crm' => $insert_crm,'code'=>$data['code']]);

		//insert task
		$task_data['task_owner'] = 0;
		$task_data['t_created_by'] = 0;
		$task_data['t_created_at'] = date('Y-m-d H:i');
		$task_data['due_date'] = date('Y-m-d');
		$task_data['task_type'] = 'Following';
		$task_data['task_name'] = 'First Call';//No Answer
		$task_data['lead'] = $lead_id;
		DB::connection('mysql_crm'.$crm_oman)->table('tasks')->insert($task_data);
		
		//insert note	
		$a_data['note'] = '"System" Created this lead';
		$a_data['type'] = 'created_by';
		$a_data['lead'] = $lead_id;
		$a_data['n_created_at'] = date('Y-m-d H:i');
		$a_data['n_created_by'] = 0;
		DB::connection('mysql_crm'.$crm_oman)->table('notes')->insert($a_data);
		
		//insert notif
		$supervisors = Helper::getUserByRole('supervisor',$crm_oman);
		$users=[];
		//$users[] = 0;//administrator
		foreach($supervisors as $rr)
			$users[] = $rr->id;
		Helper::add_notif('new client registered ("'.$data['name'].'")',$lead_id, '/app/leads/'.$lead_id.'/edit',$users,'green','new_lead_form',$crm_oman);
		
		/*if($inputs['name']=='test'){
		echo 'insert to crm success:'.$insdt;
		exit;
		}*/
		//########### End insert to CRM ###################
	}
	
    /*function zoho_insert_contact($inputs = [])
    {
		$is_src = false;
		foreach ( Helper::query("ClientSource", "orderBy", ["field" => "src", "value" => "DESC"])->get() as $row ) {
			if (strpos(strtolower(@$inputs["src"]), strtolower($row->src)) !== false) {
				$inputs['src'] = $row->code;
				$is_src = true;
				break;
			}
		}
		if(strpos(strtolower($inputs["src"]), 'ampproject') !== false)
			$inputs['src'] = 'Google AMP';
		elseif(strpos(strtolower($inputs["src"]), 'mail.google.com') !== false)
			$inputs['src'] = 'Gmail';
		elseif(trim($inputs["src"]) == 'دخول مباشر')
			$inputs['src'] = 'Direct';
		elseif(strpos(strtolower($inputs["src"]), 'google') !== false)
			$inputs['src'] = 'Google';
		elseif(strpos(strtolower($inputs["src"]), 'facebook') !== false)
			$inputs['src'] = 'Facebook';
		
		$current_lang = $inputs['lang'];
		
		$inputs['mobile'] = str_replace("+", "", $inputs['mobile']);
		$fame = $inputs["fame"]?:".";
		
		
		$inputs['name'] = $inputs['name'];
		$fame = strtok($fame, '?');
		$inputs['email'] = strtok($inputs['email'], '?');
		$inputs['mobile'] = strtok($inputs['mobile'], '?');
		$inputs['message'] = strtok($inputs['message'], '?');
		$inputs['communication_time'] = strtok($inputs['communication_time'], '?');
		$inputs['page'] = str_replace('www-damas-net.cdn.ampproject.org/v/s/','',strtok($inputs['page'], '?'));
		$inputs['src'] = str_replace('www-damas-net.cdn.ampproject.org/v/s/','',strtok($inputs['src'], '?'));
		$inputs['country'] = Helper::code_to_country($inputs['country']);
		$inputs['budget'] = strtok(str_replace('&lt;','<',$inputs['budget']), '?');
		$inputs['navigation'] = strtok($inputs['navigation'], '?');
		
		
		///if($inputs['src']=='Google'){
			//old insert to crm
		
		//$result="inserted to CRM";
		//}else{
        $token = env("ZOHO_TOKEN");
        $xmldata = "<?xml version='1.0' encoding='UTF-8' ?><Leads><row no='1'>".
          "<FL val='First Name'><![CDATA[{$inputs['name']}]]></FL>".
          "<FL val='Last Name'><![CDATA[{$fame}]]></FL>".
          "<FL val='Email'><![CDATA[{$inputs['email']}]]></FL>".
          "<FL val='Mobile'><![CDATA[%2B{$inputs['mobile']}]]></FL>".
          "<FL val='Message'><![CDATA[{$inputs['message']}]]></FL>".
          "<FL val='Contact Time'><![CDATA[{$inputs['communication_time']}]]></FL>".
          "<FL val='Landing Page'><![CDATA[{$inputs['page']}]]></FL>".
          "<FL val='Lead Source >>'><![CDATA[{$inputs['src']}]]></FL>".
          "<FL val='Country'><![CDATA[{$inputs['country']}]]></FL>".
          "<FL val='Expected Budget'><![CDATA[{$inputs['budget']}]]></FL>".
          "<FL val='Navigation'><![CDATA[{$inputs['navigation']}]]></FL>".
          "</row></Leads>";
        $url = 'https://crm.zoho.com/crm/private/xml/Leads/insertRecords';
        $param= 'authtoken='.$token.'&scope=crmapi&newFormat=1&xmlData='.$xmldata;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($ch);
        curl_close($ch);
		
		$x = @simplexml_load_string( $result);
		$result = @$x->result->message[0];
		//}
		DB::table('messages')->where("id", $inputs['id'])->update(["zoho" => $result,'send_email' => 1]);
		return true;
    }*/
	
	//gift form
    function insert_to_crm2($inputs = [],$is_newsletter=false){
		$current_lang = \LaravelLocalization::getCurrentLocale();
		$is_src = false;
		foreach ( Helper::query("ClientSource", "orderBy", ["field" => "src", "value" => "DESC"])->get() as $row ) {
			if (strpos(strtolower(@$inputs["src"]), strtolower($row->src)) !== false) {
				$inputs['src'] = $row->code; 
				$is_src = true;
				break;
			}
		}
		
		if(strpos(strtolower($inputs["src"]), 'ampproject') !== false)
			$inputs['src'] = 'Google AMP';
		elseif(strpos(strtolower($inputs["src"]), 'mail.google.com') !== false)
			$inputs['src'] = 'Gmail';
		elseif(trim($inputs["src"]) == 'دخول مباشر')
			$inputs['src'] = 'Direct';
		elseif(strpos(strtolower($inputs["src"]), 'google') !== false)
			$inputs['src'] = 'Google';
		elseif(strpos(strtolower($inputs["src"]), 'facebook') !== false)
			$inputs['src'] = 'Facebook';
		elseif(strpos(strtolower($inputs["src"]), 'instagram') !== false)
			$inputs['src'] = 'Instagram';
		elseif(strpos(strtolower($inputs["src"]), 'youtube') !== false)
			$inputs['src'] = 'Youtube';
		
		
		if($inputs['src'] == 'Direct' && strpos(strtolower(@$inputs["page"]), 'damasturk') === false){

			$inputs['src'] = @$inputs["page"];

			if(strpos(strtolower($inputs["src"]), 'ampproject') !== false)
				$inputs['src'] = 'Google AMP';
			elseif(strpos(strtolower($inputs["src"]), 'mail.google.com') !== false)
				$inputs['src'] = 'Gmail';
			elseif(strpos(strtolower($inputs["src"]), 'google') !== false)
				$inputs['src'] = 'Google';
			elseif(strpos(strtolower($inputs["src"]), 'facebook') !== false)
				$inputs['src'] = 'Facebook';
			elseif(strpos(strtolower($inputs["src"]), 'instagram') !== false)
				$inputs['src'] = 'Instagram';
			elseif(strpos(strtolower($inputs["src"]), 'youtube') !== false)
				$inputs['src'] = 'Youtube';
				
				
			
			
			if(isset($_POST['src']) && $_POST['src']!=''){
				$inputs['src'] = $_POST['src'];
				//$inputs["full_src"]  = $_POST['src'];
			}
		}
		
			
		$inputs['src'] = str_replace('wwww.','',$inputs['src']);
		if(in_array(substr($inputs['src'], -4) , ['.net','.com']))
			$inputs['src'] = substr($inputs['src'], 0,-4);
		
		
			$current_lang = $inputs['lang'];
	
	
		//$inputs['mobile'] = str_replace("+", "", $inputs['mobile']);
		
		
		
		$inputs['name'] = $inputs['name'];

		$inputs['mobile'] = $inputs['mobile'];
		$inputs['page'] = str_replace('www-damas-net.cdn.ampproject.org/v/s/','',strtok($inputs['page'], '?'));
		$inputs['src'] = str_replace('www-damas-net.cdn.ampproject.org/v/s/','',strtok($inputs['src'], '?'));
		$inputs['navigation'] = strtok($inputs['navigation'], '?');
		$inputs['country'] = Helper::code_to_country($inputs['country'],false);
		//$inputs['country'] = ucfirst(strtolower($inputs['country']));
		
		if($is_newsletter==true)
			$message = 'newsletter';
		else
			$message = $current_lang!='ar'?'please send me a gift':'يرجى إرسال الهدية';
		
		
		
		//########### Insert to CRM ###################
		$data['is_damas_net'] = $inputs['is_damas_net'];
		$data['name'] = $inputs['name'];
		$data['mobile'] = Helper::faTOen(str_replace([' ','-','.'],'',$inputs['mobile']));
		$data['message'] = $message;
		$data['source'] = $inputs['src'];
		$data['gadget'] = $inputs['device'];
		/*if(Cookie::get('tags')!=''){
			$tgs = json_decode(Cookie::get('tags'),true);
			$data['campaign'] = (isset($tgs['Search'])?$tgs['Search']:@$tgs['Display']);
			$data['target'] = (isset($tgs['keyword'])?$tgs['keyword']:@$tgs['target']);
		}*/
		$tgs = [];
		if($inputs['tags']!=''){
			$tgs = json_decode($inputs['tags'],true);
		}else{
			$t = explode('?',$inputs['page']);
			if(isset($t[1])){
				parse_str($t[1], $tgs);
			}
		}
		if(isset($tgs['campaign-name']) /*&& $tgs['utm_source']=='yektanet'*/){
			$data['campaign'] = @$tgs['campaign-name'];
			$data['target'] = @$tgs['utm_content'];
		}elseif(isset($tgs['Search'])){
			$data['campaign'] = $tgs['Search'];
			$data['target'] = @$tgs['keyword'];
		}elseif(isset($tgs['Display'])){
			$data['campaign'] = $tgs['Display'];
			$data['target'] = isset($tgs['Target'])?$tgs['Target']:@$tgs['placement'];
		}elseif(isset($tgs['Remarket'])){
			$data['campaign'] = $tgs['Remarket'];
			$data['target'] = isset($tgs['Target'])?$tgs['Target']:@$tgs['placement'];
		}else{
			$data['campaign'] = @Helper::get_campaing($inputs['navigation']);
			$data['target'] = @Helper::get_target($inputs['page'],false,$inputs['navigation']);
		}
		$data['search_fields'] = $inputs['search_fields'];
		
		
		$data['navigation'] = Helper::clean_navigation(@$inputs["navigation"]). '>>call:'. (time()-1665411611);
		$data['country'] = $inputs['country'];
		$data['l_created_at'] = date('Y-m-d H:i');
		$data['l_updated_at'] = date('Y-m-d H:i');
		$data['l_created_by'] = 0;
		$data['l_updated_by'] = 0;
		
		
		$crm_oman = '';
		if(@$inputs['ccountry']=='oman')
		$crm_oman = 'oman';
		
		$data['code'] = Helper::getNextLeadCode($crm_oman);
		DB::connection('mysql_crm'.$crm_oman)->table('params')->where("id", '1')->update(['last_lead_code'=>$data['code']]);
		
        $insert_crm = DB::connection('mysql_crm'.$crm_oman)->table('leads')->insert($data);
		$lead_id = DB::connection('mysql_crm'.$crm_oman)->getPdo()->lastInsertId();
		DB::table('messages')->where("id", $inputs['id'])->update(['insert_crm' => $insert_crm,'code'=>$data['code']]);
		
		//insert task
		$task_data['task_owner'] = 0;
		$task_data['t_created_by'] = 0;
		$task_data['t_created_at'] = date('Y-m-d H:i');
		$task_data['due_date'] = date('Y-m-d');
		$task_data['task_type'] = 'Following';
		$task_data['task_name'] = 'First Call';//No Answer
		$task_data['lead'] = $lead_id;
		DB::connection('mysql_crm'.$crm_oman)->table('tasks')->insert($task_data);
		
		//insert note	
		$a_data['note'] = '"System" Created this lead';
		$a_data['type'] = 'created_by';
		$a_data['lead'] = $lead_id;
		$a_data['n_created_at'] = date('Y-m-d H:i');
		$a_data['n_created_by'] = 0;
		DB::connection('mysql_crm'.$crm_oman)->table('notes')->insert($a_data);
		
		//insert notif
		$supervisors = Helper::getUserByRole('supervisor',$crm_oman);
		$users=[];
		//$users[] = 0;//administrator
		foreach($supervisors as $rr)
			$users[] = $rr->id;
		
		Helper::add_notif('new client registered ("'.$data['name'].'")',$lead_id,'/app/leads/'.$lead_id.'/edit',$users,'green','new_lead_form',$crm_oman);
		//########### End insert to CRM ###################
			$result="inserted to CRM";
		
	
	}
	
    /*function zoho_insert_contact2($inputs = [])
    {
		$current_lang = \LaravelLocalization::getCurrentLocale();
		$is_src = false;
		foreach ( Helper::query("ClientSource", "orderBy", ["field" => "src", "value" => "DESC"])->get() as $row ) {
			if (strpos(strtolower(@$inputs["src"]), strtolower($row->src)) !== false) {
				$inputs['src'] = $row->code; 
				$is_src = true;
				break;
			}
		}
		if ( $is_src == false ) {
			//$inputs['src'] = "UNKNOWN";
		}
		
		if(strpos(strtolower($inputs["src"]), 'ampproject') !== false)
			$inputs['src'] = 'Google AMP';
		elseif(strpos(strtolower($inputs["src"]), 'mail.google.com') !== false)
			$inputs['src'] = 'Gmail';
		elseif(trim($inputs["src"]) == 'دخول مباشر')
			$inputs['src'] = 'Direct';
		elseif(strpos(strtolower($inputs["src"]), 'google') !== false)
			$inputs['src'] = 'Google';
		elseif(strpos(strtolower($inputs["src"]), 'facebook') !== false)
			$inputs['src'] = 'Facebook';
		
		
		
		
		
		
				$current_lang = $inputs['lang'];
		
		
		
		
		
		// send mail  noreply@damas.net
		//$inputs["message"] = $message;
		//لم يتم ارسال الاميلات بعد  لعدم وجود حقل الاميل في فرم الهدية
		if($inputs['send_email']==false){
				$inputs["fullname"] = $inputs["name"];
				$inputs["email_inquiries"] = env("MAIL_INQUIRIES", "leads@damas.net");
				// send mail to admin
				Mail::send("emails.callus_admin", ["inputs" => $inputs], function ($m) use ($inputs) {
					$m->from("noreply@damas.net", $inputs["fullname"])
						->to($inputs["email_inquiries"])
						->subject("داماس تورك العقارية - رسالة جديدة");
				});

				if ( $inputs["email"]!='' ) {
					
					// send mail to user
					$params = Helper::get_params();
					if ( $params->user_email_send == 0 ) {
						$inputs["from_name"] = $params->name;
						
						//$inputs["message_content"] = str_replace(["{name}", "{email}", "{mobile}", "{message}"], [$inputs["name"], $inputs["email"], $inputs["mobile"], $inputs["message"]], nl2br($params->user_email_text));
						$inputs["message_content"] = str_replace(["{name}", "{email}", "{mobile}", "{message}", "{communication_time}", "{budget}"], [$inputs["name"], $inputs["email"], "<span dir='ltr'>{$inputs["mobile"]}</span>", $inputs["message"], $inputs["communication_time"], $inputs["budget"]], nl2br($params->user_email_text));
						if ( $current_lang == "ar" ) {
							$inputs["message_content"] = "<html lang='ar' dir='rtl'><head></head><body><div style='font-size:15px;direction:rtl;text-align:right;'>".$inputs["message_content"]."</div></body></html>";
						}
						
						//$inputs["message_subject"] = str_replace(["{name}", "{email}", "{mobile}", "{message}"], [$inputs["name"], $inputs["email"], $inputs["mobile"], $inputs["message"]], nl2br($params->user_email_title));
						$inputs["message_subject"] = str_replace(["{name}", "{email}", "{mobile}", "{message}", "{communication_time}", "{budget}"], [$inputs["name"], $inputs["email"], $inputs["mobile"], $inputs["message"], $inputs["communication_time"], $inputs["budget"]], nl2br($params->user_email_title));
						
						Mail::send([], [], function ($m) use ($inputs) {
							$m->from($inputs["email_inquiries"], $inputs["from_name"])
								->to($inputs["email"])
								->subject($inputs["message_subject"])
								->setBody($inputs["message_content"], "text/html");
						});
					}
				}
		}
		
		
		
		
		
		DB::table('messages')->where("id", $inputs['id'])->update(['send_email' => 1]);
		
		return true;
    }*/
    function pipedrive_insert_deal($inputs)
    {
        $api_token = '387b5b839a1a6c08b2fc158b9abcb54cae9ffd7c';
        
        $hours = null;
        switch ($inputs["communication_time"])
        {
            case "9 - 12 AM":$hours = "7";break;
            case "12 - 3 PM":$hours = "8";break;
            case "3 - 6 PM":$hours = "9";break;
            case "6 - 9 PM":$hours = "10";break;
            case "أي وقت":$hours = "11";break;
            case "الآن":$hours = "12";break;
        }
        
        $person = [
            "name"  =>  $inputs['name'],
            "email" =>  $inputs['email'],
            "phone" =>  $inputs['mobile'],
            "b485f8820fce9b08b8d988c94ff89f250acb5a87" =>  $hours,
            //"023352fddde92bc38ef19efcf23b4f223bc4456a" =>  "FB Page",
            "e83d37087c731ada9277736bd6fc9808ae46db15" =>  $inputs['message'],
            //"794cdaeb4228a5b39b4fc5fbd0137b6741af7d5e" =>  "Nationality",
            //"fdaf4aa98f5680de2f781f83ca225eec58edcc87" =>  "Lead Source",
        ];
        $url = 'https://damasturk.pipedrive.com/v1/persons?api_token=' . $api_token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $person);
        $output = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($output, true);
        
        if (!empty($result["data"]["id"])) {
            $deal = [
                "title" =>  $result["data"]["name"]." deal",
                "person_id" =>  $result["data"]["id"]
            ];
            $url = 'https://damasturk.pipedrive.com/v1/deals?api_token=' . $api_token;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $deal);
            $output = curl_exec($ch);
            curl_close($ch);
        }
    }
    
    // /**
    // * chat index
    // *
    // * @return void
    // */
    // public function chat_index(Request $request, $id = null)
    // {
    //     $close_chat = \Input::get("closechat");
    //     if ( $close_chat == true ) {
    //         session()->forget("chatuser");
    //         return redirect()->back();
    //     }
    //     $chatuser = session()->get("chatuser");
    //     if ( $request->ajax() ) {
    //         if ( $request->isMethod("post") ) {
    //             $message = $request->get("message", null);
    //             if ( $message and $chatuser ) {
    //                 $inputs = session()->get("chatuser");
    //                 $inputs["author"] = $inputs["name"];
    //                 $inputs["message"] = $message;
    //                 $inputs["parent_id"] = $id;
                    
    //                 $msg_row = Helper::query("ChatMessage", "find", ["id" => $id]);
    //                 if($msg_row) $msg_row->update(["viewed" => 0]);
                    
    //                 Helper::query("ChatMessage", "save", ["inputs" => $inputs]);

    //                 return response()->json([
    //                     "html"  =>  Helper::chat_messages($inputs)  
    //                 ]);
    //             }
    //         } else {
    //             $rows = Helper::query("ChatMessage", "where", ["field" => "viewed", "value" => 0])->where("chat_user_id", @$chatuser["chat_user_id"])->get();
    //             //while ( count($rows) < 1 ) usleep(2000);
    //             if ( count($rows) > 0 ) {
    //                 $parent_message = Helper::query("ChatMessage", "find", ["id" => @$chatuser["chat_message_id"]]);
    //                 return response()->json([
    //                     "html"  =>  Helper::chat_messages(),
    //                     "url_action"  =>  route("front.chat", $parent_message->id),
    //                 ]);
    //             } else {
    //                 usleep(2000);
    //             }
    //         }
    //     }
    //     return view("front.chat.index");
    // }
    
    /**
    * blog index
    *
    * @return void
    */
    public function blog_index(Request $request)
    {
		$postType = $this->legacyPostType($request);

		$query = $request->getQueryString();
		$suffix = $query ? '?' . $query : '';

		$countrySlug = $this->legacyCountrySlug($request);
		if ($countrySlug) {
			return Redirect::to(route($postType->frontCountryRoute(), $countrySlug) . $suffix, 301);
		}

		return Redirect::to(route($postType->frontIndexRoute()) . $suffix, 301);
    }

    /**
     * Route value by name: URL parameter first, then the route action (see routes.php legacy groups).
     *
     * @param Request $request
     * @param string $key
     * @return string|null
     */
    protected function legacyRouteValue(Request $request, $key)
    {
		$route = $request->route();
		if (!$route) {
			return null;
		}

		$value = $route->parameter($key);
		if ($value === null) {
			$action = $route->getAction();
			$value = isset($action[$key]) ? $action[$key] : null;
		}
		return $value;
    }

    /**
     * Post type from the legacy route's `type` (blog|news).
     *
     * @param Request $request
     * @return \App\Enums\PostType
     */
    protected function legacyPostType(Request $request)
    {
		return \App\Enums\PostType::tryFrom((string) $this->legacyRouteValue($request, 'type')) ?: \App\Enums\PostType::$BLOG;
    }

    /**
     * Country URL slug from the legacy route's `country` (code or slug), or null when absent.
     *
     * @param Request $request
     * @return string|null
     */
    protected function legacyCountrySlug(Request $request)
    {
		$country = $this->legacyRouteValue($request, 'country');
		if (!$country) {
			return null;
		}

		$row = \App\Models\Country::findBySlugOrCode($country);
		return $row ? $row->slug : null;
    }
    /**
    * show blog category
    * Old /blog/category/{slug} (and /oman|/syria variants) → /{country}/guides?category={slug}.
    *
    * @param string $slug
    * @return void
    */
    public function blog_show_category(Request $request, $slug)
    {
        $categoryType = $this->legacyPostType($request)->categoryType();
        $routeCountry = $this->legacyCountrySlug($request);
        if ( $routeCountry ) {
            $category = PostCategory::findInCountry($routeCountry, $slug, $categoryType);
            if ( !$category ) {
                $category = PostCategory::findInCountry($routeCountry, $slug);
            }
        } else {
            $category = PostCategory::findUnambiguousBySlug($slug, $categoryType);
            if ( !$category ) {
                $category = PostCategory::findUnambiguousBySlug($slug);
            }
        }
        if (!$category) {
            abort(404);
        }

        $countrySlug = $category->getCountrySlug() ?: $this->legacyCountrySlug($request);
        if (!$countrySlug) {
            $country = \App\Models\Country::findBySlugOrCode('turkey');
            $countrySlug = $country ? $country->slug : 'turkiye';
        }

        parse_str($request->getQueryString() ?: '', $query);
        $query['category'] = $category->slug;

        $url = route($this->legacyPostType($request)->frontCountryRoute(), $countrySlug) . '?' . http_build_query($query);
        return Redirect::to($url, 301);
    }
    /**
    * show blogpost
    *
    * @param string $slug
    * @return void
    */
    public function blog_show_post(Request $request, $slug)
    {
		$postType = $this->legacyPostType($request);
		$countrySlug = $this->legacyCountrySlug($request);
		if ( $countrySlug ) {
			$post = Post::findInCountry($countrySlug, $slug, $postType);
			if ( !$post ) $post = Post::findInCountry($countrySlug, $slug);
		} else {
			$post = Post::findUnambiguousBySlug($slug, $postType);
			if ( !$post ) $post = Post::findUnambiguousBySlug($slug);
		}
		if ( !$post ) abort(404);

		$geoUrl = $post->geoUrl();
		if ( $geoUrl ) {
			$query = $request->getQueryString();
			return Redirect::to($geoUrl . ($query ? '?' . $query : ''), 301);
		}

		abort(404);
    }
	/**
    * show ajaxposts
    *
    * @param int $id
    * @return void
    */
    public function ajaxposts($id)
    {
		$data = [];
		$post = Helper::query("Post", "where", ["field" => "id", "value" => $id])->first();
		if($post){
			$data['title'] = $post->getTitle();
			$data['descr'] = html_entity_decode($post->getContent());
		}
		return response()->json($data);
	}

    /**
    * show blog category
    *
    * @param string $slug
    * @return void
    */
    public function ajax_group_projects($id)
    {
		if(isset($_GET['index'])){
			$index = (int)$_GET['index'];
			setcookie('cat'.$index, $id, time() + (86400 * 30), "/"); // 30day
		}

		$category_row = Helper::query("ProjectCategory", "find", ["id" => $id ]);
		
		$q = \App\Models\Project::where("published", 1);
		$q->whereIn("id", function($q_pf) use ($id) {
			$q_pf->select("project_id")->from("project_category")->where("project_category_id", $id);
		});
		$q->join("projects_flavors as flv", "flv.project_id", "=", "projects.id")
			->orderBy("projects.id", "desc")
			->groupBy("project_id");
		$arr = $q->get();/*->limit(7)*/
        return view("front.ajax_group_projects",  ["projects"=>$arr,'slug'=>$category_row->slug]);
    }
    
    
	/**
    * sitemap_html
    *
    * @return void
    */
    public function sitemap_html(Request $request )
    {
		
		/*
		echo '<pre>';
		print_r($request);
		echo '</pre>';
		exit;*/
		/*$request->merge(['ajax' => 'eee']);
		$request->merge(['city' => 'bursa']);
		$request->merge(['project_type' => 'property-for-sale']);*/
		$lang = (\LaravelLocalization::getCurrentLocale()=='pe'?'fa':\LaravelLocalization::getCurrentLocale());
		
		
		
		
		
		$projects=array();
		$posts=array();
		$html = '';
		
        $sitemap = Helper::query("Sitemap", "where", ["field" => "lang", "value" => $lang])->first();
		
		return view("front.sitemap_html",compact("projects", "posts","sitemap","lang"));
	}
	
	
	
    /**
    * sitemap
    *
    * @return void
    */
    public function sitemap($slug = null)
    {
		

		$current_lang = (\LaravelLocalization::getCurrentLocale()=='pe'?'fa':\LaravelLocalization::getCurrentLocale());

        if ( $slug == "posts" ) {
            return Redirect::to(route("sitemap", "guides"), 301);
        }

        $postSitemaps = array(
            "guides" => \App\Enums\PostType::$BLOG,
            "developers" => \App\Enums\PostType::$DEVELOPER,
            "reports" => \App\Enums\PostType::$REPORT,
            "news" => \App\Enums\PostType::$NEWS,
        );

        if ( $slug and !in_array($slug, array_merge(["projects", "links"], array_keys($postSitemaps))) ) abort(404);

        if ( isset($postSitemaps[$slug]) ) {
            $posts = Post::query()->ofPostType($postSitemaps[$slug])->where('title_'.$current_lang,'!=','')->where('content_'.$current_lang,'!=','')->where("published", 1)->where("prevent_archiving_in_blog", false)->where("redirect_post_id",'0')->with(array('photoCard', 'countryRel'))->orderBy('id','desc')->get();
            return response()->view("sitemap.posts", ["posts"  => $posts])->header('Content-Type', 'text/xml');
        }
		
        if ( $slug == "projects" ) {
			
				$projects = Helper::query("Project", "orderBy", ["field" => "id", "value" => "DESC"])->where("published", 1)->where("sold",'!=', '100')->get();
				return response()->view("sitemap.projects", ["projects"  => $projects])->header('Content-Type', 'text/xml');
			/*if($current_lang!='en'){//disable project english
			}else{
				$projects = array();
				return response()->view("sitemap.projects", ["projects"  => $projects])->header('Content-Type', 'text/xml');
			}*/
        } elseif ( $slug == "links" ) {
			//exit('ff');
            //$posts = Helper::query("Post", "orderBy", ["field" => "id", "value" => "DESC"])->where("published", 1)->where("lang",$current_lang )->get();
			//$posts = Post::query()->whereIn('lang',array($current_lang,'all'))->where("published", 1)->orderBy('id','desc')->get();
            //exit;
			return response()->view("sitemap.links", [])->header('Content-Type', 'text/xml');
        }
        return response()->view("sitemap.index")->header('Content-Type', 'text/xml');
    }
    
    
    
    /**
    * rss
    *
    * @return void
    */
    public function rss(Request $request, $slug = '')
    {
        $limit = 5000;
        if ($request->ajax()) {
            $limit = 1;
        }
        $current_lang = (\LaravelLocalization::getCurrentLocale() == 'pe' ? 'fa' : \LaravelLocalization::getCurrentLocale());

        $rssSlugToPostType = array(
            'blog' => 'blog',
            'news' => 'news',
            'developers' => 'developer',
            'reports' => 'report',
        );
        if ($slug !== '' && $slug !== 'projects' && !isset($rssSlugToPostType[$slug])) {
            abort(404);
        }

        $projects = array();
        $posts = array();
        if ($slug === '' || $slug === 'projects') {
            $projects = Helper::query('Project', 'orderBy', array('field' => 'created_at', 'value' => 'DESC'))
                ->where('published', 1)
                ->select('id', "name_$current_lang AS title", 'slug', "seo_description_$current_lang AS description", 'created_at')
                ->limit($limit)
                ->get();
        }

        $postSelect = array(
            'id',
            "title_$current_lang AS title",
            'slug',
            'post_type',
            'country_id',
            "seo_description_$current_lang AS description",
            'created_at',
        );

        if ($slug === '') {
            $posts = Post::query()
                ->select($postSelect)
                ->where('title_' . $current_lang, '!=', '')
                ->where('published', 1)
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        } elseif (isset($rssSlugToPostType[$slug])) {
            $posts = Post::query()
                ->select($postSelect)
                ->where('title_' . $current_lang, '!=', '')
                ->where('published', 1)
                ->ofPostType($rssSlugToPostType[$slug])
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        }

        $data = array();
        foreach ($projects as $p) {
            $data[strtotime($p->created_at)] = $p;
        }
        foreach ($posts as $p) {
            $data[strtotime($p->created_at)] = $p;
        }
        krsort($data);

        $channelTitle = null;
        if ($slug === 'blog') {
            $channelTitle = trans('front.guides');
        } elseif ($slug === 'news') {
            $channelTitle = trans('front.news');
        } elseif ($slug === 'developers') {
            $channelTitle = trans('front.developer');
        } elseif ($slug === 'reports') {
            $channelTitle = trans('front.report');
        } elseif ($slug === 'projects') {
            $channelTitle = trans('front.projects');
        }

        return response()->view('rss.index', array(
            'infos' => Helper::get_params(),
            'rows' => $data,
            'channelTitle' => $channelTitle,
        ))->header('Content-Type', 'text/xml');
    }
    /**
    * rss_notifs
    *
    * @return void
    */
    /*public function rss_notifs(Request $request)
    {
		$limit = 10;
		if ( $request->ajax() ) {
			$limit=1;
		}
		$current_lang = \LaravelLocalization::getCurrentLocale();
		
        $projects = Helper::query("Project", "orderBy", ["field" => "created_at", "value" => "DESC"])
            ->where("published", 1)
            ->select(  "*","name_en AS title", "slug", "seo_description_en AS description","name_ar AS title", "slug", "seo_description_ar AS description", "created_at")
			->limit($limit)
            ->get();

		$posts = Post::query()->select( "id","lang","title_ar AS title", "slug", "seo_description_ar AS description","title_en AS title", "slug", "seo_description_en AS description", "created_at")->where("published", 1)->orderBy('created_at','desc')->limit($limit)->get();
		
		
		$data = array();
		foreach($projects as $p)
		$data[strtotime($p->created_at)]=$p;
		
		
        return response()->view("rss.rss_notifs", [
            "infos" =>  Helper::get_params(),
            "rows"  =>  $data,
        ])->header('Content-Type', 'text/xml');
    }*/
    
    /**
    * privacy
    *
    * @return void
    */
    public function privacy()
    {
        $row = Helper::query("Page", "where", ["field" => "slug", "value" => "privacy"])->first();
        if ( !$row ) $row = Helper::query("Page", "new");
        return view("front.pages.show", compact("row"));
    }
    
    /**
    * rating
    *
    * @return void
    */
    public function rating($lead,$hash,Request $request)
    {
        $page = Helper::query("Page", "where", ["field" => "slug", "value" => "rating"])->first();
		if ( !$page ) $page = Helper::query("Page", "new");
		
		$rating = DB::connection('mysql_crm')->table('leads')->where('code',$lead)->first();
		
		
		if($rating==false or md5($lead.'.') != $hash)
			abort(404);

		
		if($request->ajax()){
			$data['lead'] = $rating->id;
			$data['offers_rating'] = $request->get("offers_rating");
			$data['info_accuracy'] = $request->get("info_accuracy");
			$data['dealing'] = $request->get("dealing");
			$data['following_up'] = $request->get("following_up");
			$data['credibility'] = $request->get("credibility");


			$data['type'] = 'rating';
			//if(($rating->leadtype=='lead' and $rating->category=='Tour') or $rating->leadtype=='deal')
			
			if($rating->client_status=='' or $rating->client_status=='Consultant Follow-Up')
				$data['rate_consultant'] = $rating->lead_owner;
			else //
				$data['rate_salesman'] = $rating->salesman;

			$data['content_complaint'] = $request->get("content_complaint");
			
			$data['n_created_at'] = date('Y-m-d H:i');
			$data['n_updated_at'] = date('Y-m-d H:i');

		

			DB::connection('mysql_crm')->table('notes')->insert($data);
			DB::connection('mysql_crm')->table('leads')->where('id',$rating->id)->update(['rating_filled'=>true]);
			
			
			//update lead avg rating ...
			
			
			return response()->json([
                        "success"  =>  1  
                    ]);
			
		}
		
		
        return view("front.rating", compact("page","rating","lead","hash"));
    }
    
    /**
    * video
    *
    * @return void
    */
    public function video(Request $request,$slug=null)
    {
		/*echo strtolower(@session()->get("iso_country"));
		exit;*/
		/*echo session()->get("iso_country");
		exit;*/
		
		/*if(@session()->get("iso_country")=='TR' and !isset($_GET['alla'])){
			return Redirect::to(route("front.search")."/property-for-sale/turkey", 302 );
		}*/
		
        $current_lang = (\LaravelLocalization::getCurrentLocale()=='pe'?'fa':\LaravelLocalization::getCurrentLocale());
		
		$sections = Helper::query("Sectionvideo", "orderByPlacement");//, [ "lang" => [$current_lang] ]
		
		if($request->ajax()){
        $type = $request->get("type");
        $id = $request->get("id");
			
			$allvideos = [];
			if($type=='all'){
				foreach($sections as $sec){
					foreach($sec->videos()->orderBy('id','desc')->get() as $v)
						if(in_array($current_lang,explode(',',$v->lang)))
							$allvideos[] = Helper::get_json_Video($v);
				}
			}elseif($type=='sec'){
				foreach($sections as $sec){
					if($sec->id==$id)
						foreach($sec->videos()->orderBy('id','desc')->get() as $v)
							if(in_array($current_lang,explode(',',$v->lang)))
								$allvideos[] = Helper::get_json_Video($v);
				}
			}
			/*elseif($type=='city'){
				$projs = \App\Models\Project::where("published", 1)->where('city_id',$id)->get();
				
				foreach($projs as $p){
					if($p->getLinkVideo()!='')
						$allvideos[] = Helper::get_json_Video_projects($p);
				}
			}*/
			
			$allvideos = json_encode($allvideos);
		
		return response()->json([ "videos" =>  $allvideos ]);
		}
		$type = 'all';
		$type_id = '';
		
		
		/*$cities = \App\Models\City::where('id','!=',2)->orderBy('placement')->get();*/
		
		$curr_sec = [];
		$class = '';
		$curr_sec_id = '';
		$video = [];
		$allvideos = [];
		$used_secs = [];
		$i=0;
		foreach($sections as $sec){
			foreach($sec->videos()->orderBy('id','desc')->get() as $v){
					if(in_array($current_lang,explode(',',$v->lang))){
						$allvideos[] = Helper::get_json_Video($v);
						$used_secs[] = $sec->id;
					}
					if($v->slug == $slug and $slug!='' and in_array($current_lang,explode(',',$v->lang))){
						$curr_sec = $sec;
						$video = $v;
						$class = 'section';
						$curr_sec_id = $sec->id;
					}
				}
				$i++;
			}
			
			if(!empty($curr_sec)){
				$allvideos = [];
				foreach($curr_sec->videos()->orderBy('id','desc')->get() as $v){
					if(in_array($current_lang,explode(',',$v->lang))){
						$allvideos[] = Helper::get_json_Video($v);
						$used_secs[] = $curr_sec->id;
					}
					//exit;
				}
			}
		
		
		if(empty($curr_sec) && $slug!=''){
			//find slug in projects video
			/*if(empty($video)){
				$video = \App\Models\Project::where("published", 1)->where('slug',$slug)->first();
				if($video!=false){
					$class = 'project';
					$curr_sec_id = $video->city_id;
					
					$allvideos = [];
					$projs = \App\Models\Project::where("published", 1)->where('city_id',$curr_sec_id)->get();
					foreach($projs as $p){
						if($p->getLinkVideo()!='')
							$allvideos[] = Helper::get_json_Video_projects($p);
					}
				}else{*/
					return Redirect::to(route("front.video"));
				/*}
			}*/
		}

		$allvideos = json_encode($allvideos);
		
        return view("front.video",compact('sections','used_secs'/*,'cities'*/,'allvideos','video','slug','class','curr_sec_id'));
    }
    /**
    * investment
    *
    * @return void
    */
    public function investment()
    {
		$page = Helper::query("Page", "where", ["field" => "slug", "value" => "investment"])->first();
        return view("front.investment", compact("page"));
    }
    /**
    * legal
    *
    * @return void
    */
    public function legal()
    {
		$page = Helper::query("Page", "where", ["field" => "slug", "value" => "legal"])->first();
        return view("front.legal", compact("page"));
    }
	/**
    * faq
    *
    * @return void
    */
    public function faq()
    {
        $page = Helper::query("Page", "where", ["field" => "slug", "value" => "faq"])->first();
		
		$curent_lang = (\LaravelLocalization::getCurrentLocale()=='pe'?'fa':\LaravelLocalization::getCurrentLocale());
		$qs = 'q_' . $curent_lang;
		$rs = 'r_' . $curent_lang;
		
		$q = \App\Models\Faq::where($qs,'!=','')->where($rs,'!=','');
		
		if(isset($_GET['s'])){
			$q->where("$rs",'like','%'.$_GET['s'].'%');
			$q->orWhere("$qs",'like','%'.$_GET['s'].'%');
		}
		$q->orderBy("id","desc");
		$posts = $q->paginate(10);
		
		
        return view("front.faq", compact("page","posts"));
    }
	/**
     * stories
     *
     * @return void
     */
    public function stories($slug='') {
		
		if(strtolower(@session()->get("iso_country"))=='tr' and !isset($_GET['alla'])){
			return Redirect::to(route("front.search")."/property-for-sale/turkey", 302 );
		}

		$curent_lang = (\LaravelLocalization::getCurrentLocale()=='pe'?'fa':\LaravelLocalization::getCurrentLocale());
		$title = "story_title_".$curent_lang;
        $page = Helper::query("Page", "where", ["field" => "slug", "value" => "faq"])->first();
        $CURRENT_DATE = "Date(CONVERT_TZ(NOW(), @@session.time_zone, '+3:00'))";
		$stories = \App\Models\Story::where(DB::raw("concat(COALESCE(file1,''),COALESCE(file2,''),COALESCE(file3,''),COALESCE(file4,''),COALESCE(file5,''))"),'!=','')
		->leftJoin('projects as proj', 'proj.id', '=', 'story.project_id')
		//->where(DB::raw('DATE(dms_story.updated_at)'), '>=' ,DB::raw("{$CURRENT_DATE} - INTERVAL 7 DAY"))
		->where($title,'!=','')
		->where(function($query) {
			$curent_lang = (\LaravelLocalization::getCurrentLocale()=='pe'?'fa':\LaravelLocalization::getCurrentLocale());
						$query->whereIn('lang1', [$curent_lang,'all'])
							  ->orWhereIn('lang2', [$curent_lang,'all'])
							  ->orWhereIn('lang3', [$curent_lang,'all'])
							  ->orWhereIn('lang4', [$curent_lang,'all'])
							  ->orWhereIn('lang5', [$curent_lang,'all']);
				})
		->orderBy('story.updated_at','desc')
		->get();

		/*foreach($stories as $s)
			echo $s->updated_at;
		exit;*/
		
		return view("front.stories", compact("page","stories","slug"));
    }
	/**
    * faq
    *
    * @return void
    */
    public function faq_show($slug)
    {
        //$page = Helper::query("Page", "where", ["field" => "slug", "value" => "faq"])->first();
        $page = \App\Models\Faqpost::where('slug',$slug)->first();
		if ( !$page ) abort(404);
		return view("front.faq_show", compact("page","slug"));
    }
    /**
    * living_turkey
    *
    * @return void
    */
    public function living_turkey() //living-turkey-real-estate-ownership
    {
        $page = Helper::query("Page", "where", ["field" => "slug", "value" => "living_turkey"])->first();
        
		$cats = \App\Models\Livingcat::orderBy('placement','asc')->get();
		return view("front.living_turkey", compact("page","cats"));
    }
    /**
    * terms
    *
    * @return void
    */
    public function terms()
    {
        $row = Helper::query("Page", "where", ["field" => "slug", "value" => "terms"])->first();
        if ( !$row ) $row = Helper::query("Page", "new");
        return view("front.pages.show", compact("row"));
    }
    
    /**
    * about us
    *
    * @return void
    */
    public function about_us()
    {
        $row = Helper::query("Page", "where", ["field" => "slug", "value" => "about-us"])->first();
        if ( !$row ) $row = Helper::query("Page", "new");
        return view("front.pages.about", compact("row"));
    }
	
	/**
    * resale
    *
    * @return void
    */
    public function resale_details($id,Request $request)
    {
        $row = Helper::query("Page", "where", ["field" => "slug", "value" => "resale"])->first();
		
		
		$r = \App\Models\Resellproject::where('published',true)->where('code',$id)->first();
		
		if($r==false)
			abort("404");
		
		$_type = \App\Models\ProjectType::where('id',$r->type_id)->first();
			
        $_cities = DB::select("select CityName from dms_resal_city where CityID=?",[$r->ajax_city_id]);
			
        $_regions = DB::select("select TownName from dms_resal_town where TownID=?",[$r->region_id]);
			
		
        return view("front.resale_details", compact("row","_type","_cities","_regions","r"));
    }
	
	
    /**
    * resale
    *
    * @return void
    */
    public function resale(Request $request)
    {
		
		
		if ( $request->isMethod('post') ) {
            $inputs = $request->all();
			//dd($inputs);
		
		
		

		/* Device */
		//$agent = new Agent();
		/*$inputs["device_type"] = $agent->device();//Iphone
		$inputs["platform"] = $agent->platform();//iOS
		$inputs["browser"] = $agent->browser();//chrome
		
            if ( $agent->isTablet() ) {
                $inputs["device"] = "Tablet";
            }elseif ( $agent->isMobile() ) {
                $inputs["device"] = "Mobile";
            } else {
                $inputs["device"] = "Desktop";
            }
		*/
		//$email = $request->get("email", null);
		//$inputs["country"] = @session()->get("iso_country");
		//$inputs["ip"] = @$_SERVER['HTTP_X_REAL_IP']; //\Request::ip();
		

            //if ( $request->ajax() ) {
                if ( trim($inputs['h_name'])=='' ) {
                    return response()->json([
                        "input" =>  "name",
                        "message" =>  trans("front.please enter your name"),
                    ]);
                }
				
				
				/*$inputs["lang"] = $current_lang;
				$inputs["name"] = htmlentities($name);
                $inputs["fame"] = htmlentities($fame);*/
				
                
                // Source visitor
                $cookie_reffer = Cookie::get('reffer');
                $coourl = parse_url($cookie_reffer);
				$inputs["page"] = \URL::previous();
                if ( ($cookie_reffer != str_replace('gclid=', '', $cookie_reffer)) or ($inputs["page"] != str_replace('gclid=', '', $inputs["page"])) ){
                    $inputs["src"] = "Adwords";
                } else {
                    $inputs["src"] = @$coourl['host'] ? $coourl['host'] : (@$coourl['path'] ? $coourl['path'] : 'دخول مباشر');
                }
                
				if(Cookie::get('gclid')!=''){
					$inputs["gclid"] = Cookie::get('gclid');
					$inputs["src"] = "Adwords";
					
				}
				if(Cookie::get('tags')!='')
					$inputs["tags"] = Cookie::get('tags');

				
                if ( $inputs["src"] == "دخول مباشر" ) {
                    $inputs["full_src"] = "دخول مباشر";
				} else {
                    $inputs["full_src"] = $cookie_reffer;
                }
				if(str_replace('ampproject','',$inputs["page"]) != $inputs["page"]){
					$inputs["src"] = 'Google AMP';
				}elseif(str_replace('fbclid','',$inputs["page"]) != $inputs["page"]){
					$inputs["src"] = 'facebook.com';
				}
                
                
				$inputs['navigation'] = Helper::clean_navigation(Cookie::get('navigation')). '>>call:'. (time()-1665411611);
				
				
				
				

                /*$saved_message = Helper::query("Message", "save", [
                    "inputs"    =>  $inputs,
                ]);*/
				
				
				
                // ZOHO CRM insert contact
				//$inputs['id'] = $saved_message->id;
                
				//$this->insert_to_crm($inputs);
				$is_src = false;
		foreach ( Helper::query("ClientSource", "orderBy", ["field" => "src", "value" => "DESC"])->get() as $row ) {
			if (strpos(strtolower(@$inputs["src"]), strtolower($row->src)) !== false) {
				$inputs['src'] = $row->code;
				$is_src = true;
				break;
			}
		}
		if(strpos(strtolower($inputs["src"]), 'ampproject') !== false)
			$inputs['src'] = 'Google AMP';
		elseif(strpos(strtolower($inputs["src"]), 'mail.google.com') !== false)
			$inputs['src'] = 'Gmail';
		elseif(trim($inputs["src"]) == 'دخول مباشر')
			$inputs['src'] = 'Direct';
		elseif(strpos(strtolower($inputs["src"]), 'google') !== false)
			$inputs['src'] = 'Google';
		elseif(strpos(strtolower($inputs["src"]), 'facebook') !== false)
			$inputs['src'] = 'Facebook';
		elseif(strpos(strtolower($inputs["src"]), 'instagram') !== false)
			$inputs['src'] = 'Instagram';
		elseif(strpos(strtolower($inputs["src"]), 'youtube') !== false)
			$inputs['src'] = 'Youtube';
			
			
		
		
		if(isset($_POST['src']) && $_POST['src']!=''){
			$inputs['src'] = $_POST['src'];
			//$inputs["full_src"]  = $_POST['src'];
		}
		
		
		
		if($inputs['src'] == 'Direct' && strpos(strtolower(@$inputs["page"]), 'damasturk') === false){

			$inputs['src'] = @$inputs["page"];
			
			if(strpos(strtolower($inputs["src"]), 'ampproject') !== false)
				$inputs['src'] = 'Google AMP';
			elseif(strpos(strtolower($inputs["src"]), 'mail.google.com') !== false)
				$inputs['src'] = 'Gmail';
			elseif(strpos(strtolower($inputs["src"]), 'google') !== false)
				$inputs['src'] = 'Google';
			elseif(strpos(strtolower($inputs["src"]), 'facebook') !== false)
				$inputs['src'] = 'Facebook';
			elseif(strpos(strtolower($inputs["src"]), 'instagram') !== false)
				$inputs['src'] = 'Instagram';
			elseif(strpos(strtolower($inputs["src"]), 'youtube') !== false)
				$inputs['src'] = 'Youtube';
				
				
			
			if(isset($_POST['src']) && $_POST['src']!=''){
				$inputs['src'] = $_POST['src'];
				//$inputs["full_src"]  = $_POST['src'];
			}
		}
		
		$inputs['src'] = str_replace('wwww.','',$inputs['src']);
		if(in_array(substr($inputs['src'], -4) , ['.net','.com']))
			$inputs['src'] = substr($inputs['src'], 0,-4);
		

		//########### Insert to CRM ###################
		$inputs['name'] = substr(ucfirst($type->name_en), 0, 1);
		$inputs['created_at'] = date('Y-m-d H:i');
		$inputs['user_name'] = 'Client';
		
		
		$inputs['special_offer'] = (isset($inputs['special_offer'])?'1':'0');
		$inputs['updated_at'] = date('Y-m-d H:i');
		
		
		
		
		
		$arr = DB::select("SELECT city_id FROM `dms_resellprojects` where ajax_city_id=?  and city_id is not null",[$inputs['ajax_city_id']]);
		
		if(isset($arr[0])){
			$inputs['city_id'] = $arr[0]->city_id;
		}else{
			$inputs['city_id'] = 3;
		}
		
		
		$resellprojct = Helper::query("Resellproject", "save", [
			"inputs"    =>  $inputs,
			"id"        =>  $request->get("id"),
		]);
		
		/*$data['h_source'] = $inputs['src'];
		
		$data['h_created_at'] = date('Y-m-d H:i');
		
		$data['h_created_by'] = 0;
		$data['h_updated_by'] = 0;


		$data['h_mobile'] = Helper::faTOen(str_replace([' ','-','.'],'',@$inputs['h_mobile']));
		
		$data['h_city'] = @$inputs['h_city'];
		$data['h_district'] = @$inputs['h_district'];
		
		
		session()->put("job_success", $data['h_code']);
		
		DB::connection('mysql_crm')->table('params')->where("id", '1')->update(['last_hr_code'=>$data['h_code']]);
		
        $insert_crm = DB::connection('mysql_crm')->table('hrs')->insert($data);
		$hr_id = DB::connection('mysql_crm')->getPdo()->lastInsertId();*/
		
                return response()->json([
                    "message"   =>  "تم الإرسال شكرا لك",
                    "url"       =>  url(($current_lang!='ar'?'/'.$current_lang:'') . "/confirmation")
                ]);
            //}
            
        }
		
		
        $row = Helper::query("Page", "where", ["field" => "slug", "value" => "resale"])->first();
        if ( !$row ) $row = Helper::query("Page", "new");
		
		
		
		
		$availables_langs = [];
		if(trim($row->title_en)!='')
			$availables_langs[] = 'en';
		if(trim($row->title_fr)!='')
			$availables_langs[] = 'fr';
		if(trim($row->title_ru)!='')
			$availables_langs[] = 'ru';
		if(trim($row->title_fa)!='')
			$availables_langs[] = 'pe';
		if(trim($row->title_ar)!='')
			$availables_langs[] = 'ar';
		
        return view("front.resale", compact("row","availables_langs"));
    }
	
	
    /**
    * turkish_nationality
    *
    * @return void
    */
    public function turkish_nationality()
    {
        $row = Helper::query("Page", "where", ["field" => "slug", "value" => "turkish-nationality"])->first();
        if ( !$row ) $row = Helper::query("Page", "new");
		$availables_langs = [];
		if(trim($row->title_en)!='')
			$availables_langs[] = 'en';
		if(trim($row->title_fr)!='')
			$availables_langs[] = 'fr';
		if(trim($row->title_ru)!='')
			$availables_langs[] = 'ru';
		if(trim($row->title_fa)!='')
			$availables_langs[] = 'pe';
		if(trim($row->title_ar)!='')
			$availables_langs[] = 'ar';
        return view("front.turkish_nationality", compact("row","availables_langs"));
    }

    /**
    * turkey_territories
    *
    * @return void
    */
    public function turkey_territories()
    {
        $row = Helper::query("Page", "where", ["field" => "slug", "value" => "turkey-territories"])->first();
        if ( !$row ) $row = Helper::query("Page", "new");
		$availables_langs = [];
		if(trim($row->title_en)!='')
			$availables_langs[] = 'en';
		if(trim($row->title_fr)!='')
			$availables_langs[] = 'fr';
		if(trim($row->title_ru)!='')
			$availables_langs[] = 'ru';
		if(trim($row->title_fa)!='')
			$availables_langs[] = 'pe';
		if(trim($row->title_ar)!='')
			$availables_langs[] = 'ar';
        return view("front.turkey_territories", compact("row","availables_langs"));
    }
	
    /**
    * turkey-guide
    *
    * @return void
    */
    public function turkey_guide()
    {
        $row = Helper::query("Page", "where", ["field" => "slug", "value" => "turkey_guide"])->first();
        if ( !$row ) $row = Helper::query("Page", "new");
		$availables_langs = [];
		if(trim($row->title_en)!='')
			$availables_langs[] = 'en';
		if(trim($row->title_fr)!='')
			$availables_langs[] = 'fr';
		if(trim($row->title_ru)!='')
			$availables_langs[] = 'ru';
		if(trim($row->title_fa)!='')
			$availables_langs[] = 'pe';
		if(trim($row->title_ar)!='')
			$availables_langs[] = 'ar';
        return view("front.turkey_guide", compact("row","availables_langs"));
    }
    
    /**
    * vacancies
    *
    * @return void
    **/
    public function vacancies()
    {
        return Redirect::to(route("front.land_vacancies"));
		
		/*$row = Helper::query("Page", "where", ["field" => "slug", "value" => "vacancies"])->first();
        if ( !$row ) $row = Helper::query("Page", "new");
		
				return view("front.pages.vacancies", compact("row"));*/
			
    }
	
    /**
    * land_vacancies
    *
    * @return void
    */
    public function land_vacancies()
    {
        $row = Helper::query("Page", "where", ["field" => "slug", "value" => "jobs"])->first();
        if ( !$row ) $row = Helper::query("Page", "new");
		
		$lang = \LaravelLocalization::getCurrentLocale();
		if(in_array($lang,['fr','ru','pe','fa']))
			$jobs = [];
		else
			$jobs = \App\Models\Job::orderBy('id','desc')->get();
		
		//return view("front.pages.vacancies_mob", compact("row"));
		
		/*$agent = new Agent();
            if ( $agent->isTablet() or $agent->isMobile() ) {*/
				return view("front.pages.vacancies_mob", compact("row","jobs"));
            /*}else {
				return view("front.pages.vacancies", compact("row"));
			}*/
    }
    /**
    * land_vacancies
    *
    * @return void
    */
    public function job_details($slug)
    {
        $row = Helper::query("Page", "where", ["field" => "slug", "value" => "jobs"])->first();
        if ( !$row ) $row = Helper::query("Page", "new");
		
		$jobs = \App\Models\Job::orderBy('id','desc')->get();
		$job = \App\Models\Job::where('slug',$slug)->orderBy('id','desc')->first();
		if($job==false)
			abort("404");
		
		$lang = \LaravelLocalization::getCurrentLocale();
		if(in_array($lang,['fr','ru','pe','fa']))
			abort("404");
		
		if(($lang=='ar' and trim($job->title_ar)=='') or ($lang=='en' and trim($job->title_en)==''))
			abort("404");
		
		
		$availables_langs = [];
		if(trim($job->title_ar)!='')
			$availables_langs[] = 'ar';
		if(trim($job->title_en)!='')
			$availables_langs[] = 'en';
		/*if(trim($job->title_ru)!='')
			$availables_langs[] = 'ru';
		if(trim($job->title_fa)!='')
			$availables_langs[] = 'pe';
		if(trim($job->title_fr)!='')
			$availables_langs[] = 'fr';*/
		/*if(isset($_GET['x'])){
			print_r($availables_langs);
			exit;
			}*/
			
			
			
			
		return view("front.pages.job", compact("row","jobs",'job','availables_langs'));
    }
    
    /**
    * job
    *
    * @return void
    */
    public function job()
    {
        $row = Helper::query("Page", "where", ["field" => "slug", "value" => "jobs"])->first();
        if ( !$row ) $row = Helper::query("Page", "new");
		
		$page = $row; 
		
		return view("front.pages.job", compact("row","page"));
        
    }
    /**
    * contact us
    *
    * @return void
    */
    public function contactus(Request $request)
    {
        return view("front.contact_us");
    }
    /**
    * agent
    *
    * @return void
    */
    public function agent(Request $request,$slug)
    {
		abort(404);
		$agent = Helper::query("SaleManager", "where", ["field" => "slug", "value" => $slug])->first();
		if ( !$agent ) {
			abort(404);
		}else{
			$data['agent'] = $agent;
        return view("front.agent",$data);
		}
    }
    
    /**
    * like item
    *
    * @return void
    */
    public function like_item(Request $request)
    {
        $typ = $request->get("typ");
        $id = $request->get("id");       
        if ( $typ == "project" ) {
            $likedprojects = $request->session()->get("likedprojects.ids", []);
            if ( !in_array($id, $likedprojects) ) {
                $project = Helper::query("Project", "find", ["id" => $id]);
                if ( $project ) {
                    $project->likes+=1;
                    $project->save();
                    $request->session()->push('likedprojects.ids', $project->id);
                }
            }
        } elseif ( $typ == "post" ) {
            $likedposts = $request->session()->get("likedposts.ids", []);
            if ( !in_array($id, $likedposts) ) {
                $post = Helper::query("Post", "find", ["id" => $id]);
                if ( $post ) {
                    $post->likes+=1;
                    $post->save();
                    $request->session()->push('likedposts.ids', $post->id);
                }
            }
        }
    }

    /**
    * like video
    *
    * @return void
    */
    public function like_video(Request $request)
    {
		$lang = (\LaravelLocalization::getCurrentLocale()=='pe'?'fa':\LaravelLocalization::getCurrentLocale());
        $typ = $request->get("typ");
        $id = $request->get("id");
        if ( $typ == "project" ) {
            $likedprojects = $request->session()->get("likedVprojects".$lang.".ids", []);
            if ( !in_array($id, $likedprojects) ) {
                //$project = \\ProjectDetail", "find", ["project_id" => $id]);
				$project = Helper::query("ProjectDetail", "where", ["field" => "project_id", "value" => $id])->first();
                if ( $project ) {
                    $f_like = "c_likes_".$lang;
					/*$project->$f_like+=1;
                    $project->save();*/
					
					//$inputs[$f_like] = $project->$f_like+1;
					DB::update("UPDATE `dms_projects_details` SET $f_like=? WHERE `project_id`=?",[$project->$f_like+1, $id]);
					/*Helper::query("ProjectDetail", "save", [
						"inputs"    =>  $inputs,
						"project_id" => $id
					]);                   */


					return response()->json([
                        "success"  =>  1  
                    ]);
				   $request->session()->push("likedVprojects".$lang.".ids", $project->project_id);
                }
            }
        } elseif ( $typ == "section" ) {
            $likedvideos = $request->session()->get("likedvideos.ids", []);
            if ( !in_array($id, $likedvideos) ) {
                $video = Helper::query("Video", "find", ["id" => $id]);
                if ( $video ) {
                    $video->c_likes+=1;
                    $video->save();
                    $request->session()->push('likedvideos.ids', $video->id);
					return response()->json([
                        "success"  =>  1  
                    ]);
				}
            }
        }
		return response()->json([
                        "success"  =>  0  
                    ]);
    }
    
    /**
    * newsletter_signup
    *
    * @return void
    */
    public function newsletter_signup(Request $request)
    {
        /*$email = htmlentities($request->get("email"));
        if ( !$email ) {
            return response()->json([
                "input" =>  "email",
                "message" =>  trans("front.please enter your email"),
            ]);
        }*/
        // save
        $row = Helper::query("Newsletter", "where", ["field" => "email", "value" => $mobile])->first();
        if ( !$row ) {
            $row = Helper::query("Newsletter", "new");
        }
        $row->email = $email;
        $row->save();
        
        if ( $request->ajax() ) {
            return response()->json([
                "message"   =>  trans("front.signup newsletter success"),
            ]);
        }
        
        return redirect()->back();
    }
    public function currency($curr='TRY', Request $request)
    {
		if(in_array($curr,array('TRY','USD','EUR','IRR','RUB','GBP','SAR','IQD','AED','KWD','OMR','SYP','QAR','BHD','JOD','DZD','YER','EGP','ILS','LYD','MAD','TND')))
			$request->session()->put('currency', $curr);
        //tl,usd,pnd,eur
		$previousUrl = app('url')->previous();
		
		if (strpos($previousUrl, '?') !== false)
			$previousUrl = $previousUrl . '&t=' . time();
		else
			$previousUrl = $previousUrl . '?t=' . time();
		
        return redirect()->to($previousUrl);
    }
    public function filter_rooms($s_r, Request $request)
    {
		if(in_array($s_r,array('1_0','1_1','1_2','1_3','1_4','1_5','2_3','2_4','2_5','2_6')))
			$request->session()->put('filter_rooms', $s_r);
		else
			$request->session()->put('filter_rooms', '');
        //exit();
		if(isset($_SERVER['HTTP_REFERER']))
        return redirect(str_replace('rooms=','rm=',$_SERVER['HTTP_REFERER']));
    }
	
	//insert failed zoho add
    public function cron_crm_insert(Request $request)
    {
		$CURRENT_DATE_TIME = "CONVERT_TZ(NOW(), @@session.time_zone, '+3:00')";

		$results = DB::select("select * from dms_messages where insert_crm=0 and created_at <= {$CURRENT_DATE_TIME} - INTERVAL 5 MINUTE");
		$results = json_decode(json_encode($results), true);


		foreach($results as $r){
			if($r['form_type']=='فورم الهدية')
				$x = $this->insert_to_crm2($r,false);
			elseif($r['form_type']=='newsletter')
				$x = $this->insert_to_crm2($r,true);
			else
				$x = $this->insert_to_crm($r);
		}
		
		
		//check auto publish post
		$posts = DB::select("select * from dms_posts where post_scheduling=1 and published=0 and post_scheduling_date <= {$CURRENT_DATE_TIME} - INTERVAL 3 MINUTE");
		
		foreach($posts as $p){
			DB::update('update dms_posts set published = 1, post_scheduling=0, post_scheduling_date=null,
			created_at=?,
			updated_at=?,
			update_date=?
			where id=?',[date('Y-m-d H:i'),date('Y-m-d H:i'),date('Y-m-d H:i'),$p->id]);
		}



		/*
		if(!isset($_GET['bx']))
			exit;
		$results = DB::select("select * from dms_messages where id >? and (zoho is null or zoho='') order by id desc", [4613]);
		$results = json_decode(json_encode($results), true);

		echo '<style>td{border:1px solid red}</style><table><tr><td>EXits CRM</td><td>created_at</td><td>ID</td><td>Name</td><td>Fame</td><td>Email</td><td>Mobile</td><td>Form_type</td><td>Message</td></tr>';
		foreach($results as $r){
			$v = DB::connection('mysql_crm')->select("select * from dms_leads where ((mobile like ? and trim(mobile)!='') or (email like ?  and trim(email)!='')) ",['%'.$r['mobile'].'%','%'.$r['email'].'%']);
			if(count($v)==0 and $r['insert_crm']==false)
			echo '<tr><td>*'. count($v) .'' ((count($v))>0?('<br>'. @$v[0]->mobile.'-'. @$v[0]->movbile):'')  .'</td><td>'.$r['created_at'] .'</td><td>'.$r['id'] .'</td><td>'. $r['name'] .'</td><td>'. $r['fame']  .'</td><td>'. $r['email']  .'</td><td>'. $r['mobile'] .'</td><td>'. $r['form_type'] .'</td><td>'. $r['message'].'</td></tr>';
			
			if($r['form_type']=='فورم الهدية')
				$x = $this->zoho_insert_contact2($r);
			else
				$x = $this->zoho_insert_contact($r);
			//echo 'Response:' . $x.'<br>';
		}
		echo '</table>';
		*/
		
		
		
		
	}
    public function cron_currency(Request $request)
    {
		
		
		
		//update sort projects
		DB::update('update dms_projects set sort = (FLOOR( 1 + RAND( ) *60 ))');
		
		
		
		
		
		$json = file_get_contents('http://data.fixer.io/api/latest?access_key=e1486879de719e8ea22426eae7fe9dd3');//7b59274c1248e541c74802fda710b5c6
		$obj = json_decode($json,true);
		
		if(@$obj['success']=='true')
		if(@$obj['rates']['USD']!=''){
			$ex['TRY'] = 1;
			$ex['USD'] = $obj['rates']['USD']/$obj['rates']['TRY'];
			$ex['EUR'] = $obj['rates']['EUR']/$obj['rates']['TRY'];
			$ex['GBP'] = $obj['rates']['GBP']/$obj['rates']['TRY'];//لسترليني
			$ex['IRR'] = $obj['rates']['IRR']/$obj['rates']['TRY'];//ايراني
			$ex['RUB'] = $obj['rates']['RUB']/$obj['rates']['TRY'];
			$ex['SAR'] = $obj['rates']['SAR']/$obj['rates']['TRY'];
			$ex['IQD'] = $obj['rates']['IQD']/$obj['rates']['TRY'];//عراقي
			$ex['AED'] = $obj['rates']['AED']/$obj['rates']['TRY'];//اماراتي
			$ex['KWD'] = $obj['rates']['KWD']/$obj['rates']['TRY'];//كويتي
			$ex['OMR'] = $obj['rates']['OMR']/$obj['rates']['TRY'];//oman
			$ex['SYP'] = $obj['rates']['SYP']/$obj['rates']['TRY'];//سوري
			$ex['QAR'] = $obj['rates']['QAR']/$obj['rates']['TRY'];//قطري
			$ex['BHD'] = $obj['rates']['BHD']/$obj['rates']['TRY'];//بحريني
			$ex['JOD'] = $obj['rates']['JOD']/$obj['rates']['TRY'];//اردني
			$ex['DZD'] = $obj['rates']['DZD']/$obj['rates']['TRY'];//جزائري
			$ex['YER'] = $obj['rates']['YER']/$obj['rates']['TRY'];//يمني
			$ex['EGP'] = $obj['rates']['EGP']/$obj['rates']['TRY'];//مصري
			$ex['ILS'] = $obj['rates']['ILS']/$obj['rates']['TRY'];//فلسطيني
			$ex['LYD'] = $obj['rates']['LYD']/$obj['rates']['TRY'];//ليبي
			$ex['MAD'] = $obj['rates']['MAD']/$obj['rates']['TRY'];//مغربي
			$ex['TND'] = $obj['rates']['TND']/$obj['rates']['TRY'];//تونسي


			$serialized_array = serialize($ex);
			//echo $serialized_array;
			
			DB::table('params')->update(["exchange" => $serialized_array]);
			
			DB::connection('mysql_crm')->table('acc_exchange')->insert(["date"=> @$obj['date'],"exchange" => $serialized_array]);
			
		//$unserialized_array = unserialize($serialized_array);
		}
        
		
		
		

		
        response()->json(['success' => 'success'], 200);
    }
     public function cron_notifications(Request $request){
		
		$app_id_damasturk = "d117bb52-8f62-4275-8b60-58bf8d16e878";
		$auth_key_damasturk = "Y2YxYTUwMTEtZTk3MS00MDU0LTljNWMtNDA3ODFlMjgyZDIx";
		
		
		$app_id_damasnet = "001fe1dd-342f-4613-a349-ab7156bb48c4";
		$auth_key_damasnet = "NmU0MmNmZGUtOTM5NC00YjNmLWIyMjMtMzUyYmM0Nzg2NzY2";
		
		$app_id_damasturk_no_w = "2f1084c2-51c8-4e36-9d43-f55965d8e722";
		$auth_key_damasturk_no_w = "MzQ5MzVhOGQtMGYwMi00YzM2LWI0YzUtM2M0YzgxYTBkYzRm";
		
		//echo 'damas.net<br>';

		$posts = DB::table('posts')
				->where('title_ar','!=','')
				//->whereIn('lang',array('ar','all'))
				->where("published", 1)
				->where(function($query) {
						$query->where('send_notif_ar', 0)->orWhere('send_notif_en', 0);
				})
				->orderBy('id','asc')
				->get();
		

		$send_post = false;
		foreach($posts as $p){
				$img = 'https://damas.net/'.DB::table('medias')->where('id',$p->media_id)->first()->path;
			if($p->send_notif_ar==false and $p->title_ar!=''){//عربي
				$send_post = true;
				$url = 'https://damas.net/'. ($p->type) .'/'.$p->slug;
				Helper::sendOnesignalNotification($app_id_damasnet,$auth_key_damasnet,$p->title_ar,$p->seo_description_ar,$img,$url);
				Helper::sendOnesignalNotification($app_id_damasturk,$auth_key_damasturk,$p->title_ar,$p->seo_description_ar,$img,$url);
				Helper::sendOnesignalNotification($app_id_damasturk_no_w,$auth_key_damasturk_no_w,$p->title_ar,$p->seo_description_ar,$img,$url);
				
				DB::table('posts')->where("id" , $p->id)->update(["send_notif_ar" => 1]);
			}
			if($p->send_notif_en==false and $send_post==false and $p->title_en!=''){
				$send_post = true;
				$url = 'https://damas.net/en/'. ($p->type) .'/'.$p->slug;
				Helper::sendOnesignalNotification($app_id_damasnet,$auth_key_damasnet,$p->title_en,$p->seo_description_en,$img,$url);
				Helper::sendOnesignalNotification($app_id_damasturk,$auth_key_damasturk,$p->title_en,$p->seo_description_en,$img,$url);
				Helper::sendOnesignalNotification($app_id_damasturk_no_w,$auth_key_damasturk_no_w,$p->title_en,$p->seo_description_en,$img,$url);
			
				DB::table('posts')->where("id",$p->id)->update(["send_notif_en" => 1]);
			}
			if($p->send_notif_fr==false and $send_post==false and $p->title_fr!=''){
				$send_post = true;
				$url = 'https://damas.net/fr/'. ($p->type) .'/'.$p->slug;
				Helper::sendOnesignalNotification($app_id_damasnet,$auth_key_damasnet,$p->title_fr,$p->seo_description_fr,$img,$url);
				Helper::sendOnesignalNotification($app_id_damasturk,$auth_key_damasturk,$p->title_fr,$p->seo_description_fr,$img,$url);
				Helper::sendOnesignalNotification($app_id_damasturk_no_w,$auth_key_damasturk_no_w,$p->title_fr,$p->seo_description_fr,$img,$url);
			
				DB::table('posts')->where("id",$p->id)->update(["send_notif_fr" => 1]);
			}
			if($send_post == true)
			break;
		}




		if($send_post == false){
			$projects = DB::table('projects')
					->where("published", 1)
					->where(function($query) {
							$query->where('send_notif_ar', 0)->orWhere('send_notif_en', 0)->orWhere('send_notif_fr', 0);
					})
					->orderBy('id','asc')
					->get();

			foreach($projects as $pr){
				$send_post = false;
				$p = Helper::query("Project", "where", ["field" => "id", "value" => $pr->id])->first();
					$img = 'https://www.damas.net/'.$p->projectPhotos[0]->path;
				$notifPath = parse_url($p->frontUrl(), PHP_URL_PATH);
				$notifPath = preg_replace('#^/(en|fr|pe|ru|ar)(/|$)#', '/', $notifPath);
				if($p->send_notif_ar==false ){//عربي
					$url = 'https://www.damas.net'.$notifPath;
					Helper::sendOnesignalNotification($app_id_damasnet,$auth_key_damasnet,$p->seo_title_ar,$p->seo_description_ar,$img,$url);
					Helper::sendOnesignalNotification($app_id_damasturk,$auth_key_damasturk,$p->seo_title_ar,$p->seo_description_ar,$img,$url);
					Helper::sendOnesignalNotification($app_id_damasturk_no_w,$auth_key_damasturk_no_w,$p->seo_title_ar,$p->seo_description_ar,$img,$url);
					$send_post=true;
					DB::table('projects')->where("id", $pr->id)->update(["send_notif_ar" => 1]);
				}
				if($p->send_notif_en==false  and $send_post==false){
					
					$url = 'https://www.damas.net/en'.$notifPath;
					Helper::sendOnesignalNotification($app_id_damasnet,$auth_key_damasnet,$p->seo_title_en,$p->seo_description_en,$img,$url);
					Helper::sendOnesignalNotification($app_id_damasturk,$auth_key_damasturk,$p->seo_title_en,$p->seo_description_en,$img,$url);
					Helper::sendOnesignalNotification($app_id_damasturk_no_w,$auth_key_damasturk_no_w,$p->seo_title_en,$p->seo_description_en,$img,$url);
					DB::table('projects')->where("id" , $pr->id)->update(["send_notif_en" => 1]);
				}
				if($p->send_notif_fr==false  and $send_post==false){
					
					$url = 'https://www.damas.net/fr'.$notifPath;
					Helper::sendOnesignalNotification($app_id_damasnet,$auth_key_damasnet,$p->seo_title_fr,$p->seo_description_fr,$img,$url);
					Helper::sendOnesignalNotification($app_id_damasturk,$auth_key_damasturk,$p->seo_title_fr,$p->seo_description_fr,$img,$url);
					Helper::sendOnesignalNotification($app_id_damasturk_no_w,$auth_key_damasturk_no_w,$p->seo_title_fr,$p->seo_description_fr,$img,$url);
					DB::table('projects')->where("id" , $pr->id)->update(["send_notif_fr" => 1]);
				}
				
				
				
				break;
			}
		}
		
		
	}
    public function cron_currency_changes(Request $request)
    {
		exit;
		$data = array();
		$arrcurr=array('usd','sar','eur','xau');
		foreach($arrcurr as $cur){
		$html = file_get_contents('https://walletinvestor.com/fx-converter/'.$cur.'/try/1');
		
		$html = trim(preg_replace('/\s+/', ' ', $html));

		$html = str_replace('> <','><',$html);
		
		/*echo $html;
		exit;*/
		$tt = explode('converter-title-amount">',$html);
		$tt0 = explode('</span>',$tt[1]);
		
		$tt = explode('Changes %</th></tr></thead>',$html);
		$tt = explode('</td></tr><tr>',$tt[1]);
		$tt = explode('</td><td>',$tt[0]);
		
		
		$data[$cur] = array($tt0[0],$tt[count($tt)-1]);
		
		}

		$serialized_array = serialize($data); 

		DB::table('params')->update(["exch_gold" => $serialized_array]);
		
        
        response()->json(['success' => 'success'], 200);
    }
    public function ajax_statics(Request $request)
    {
		$region_name = $request->get('region',null);
		$type = $request->get('type',null);

		$year = (int) $request->get('year',null);
		$month = $request->get('month',null);

		$project_type = $request->get('project_type',null);
		$price_type = $request->get('price_type',null);

		$countries = $request->get('countries',null);
		$cities = $request->get('cities',null);
		
		
		
		$countrie_last = $request->get('countrie_last',null);
		$citie_last = $request->get('citie_last',null);
		if($countrie_last!='' && $countries!=''){//اضافتها الى البداية
			$countries = $countrie_last.','.str_replace(array(','.$countrie_last,$countrie_last.','),'',$countries);
		}
		if($citie_last!='' && $cities!=''){//اضافتها الى البداية
			$cities = $citie_last.','.str_replace(array(','.$citie_last,$citie_last.','),'',$cities);
		}




		return response()->json(Helper::ajax_statics($region_name,$type,$year,$month,$project_type,$price_type,$countries,$cities),200);

    }
    public function cron_keywords(Request $request){
		
		$url = '';
		//clean keywords table
		//DB::delete('delete from dms_keywords');
		DB::delete('TRUNCATE TABLE `dms_keywords`');
		
		
		//SEARCH word
		$searchs = DB::table("wordsearch")->select("id","word","type","lang")->orderBy('id','desc')->get();
		foreach($searchs as $e){
			$tw = explode(',',$e->word);
			foreach($tw as $r)
			DB::table('keywords')->insert(['keyword' => Helper::trimm($r), 'lang' => ($e->lang=='fa'?'pe':$e->lang),'table'=>$e->type,
			'url'=>$url]);
		}
		//SEARCH
		$searchs = DB::table("search")->select("id","word","cnt_search")->limit(10)->orderBy('cnt_search','desc')->get();
		foreach($searchs as $e){
			DB::table('keywords')->insert(['keyword' => Helper::trimm($e->word), 'lang' => 'ar','table'=>'search',
			'url'=>$url]);
		}

		//POST
		$url = '';
		$posts = DB::table('posts')->select('id','title_en','slug','title_ar','title_ru','title_fr','title_fa','seo_keywords_ar','seo_keywords_en','seo_keywords_ru','seo_keywords_fr','seo_keywords_fa')->orderBy('seo_keywords_ar')->get();
		foreach($posts as $p){
			$post = Post::find($p->id);
			$url = $post ? $post->frontUrl() : route('front.blog.post', $p->slug);
			if(Helper::trimm($p->seo_keywords_ar) != ''){
				$t = explode(',',$p->seo_keywords_ar);
				foreach($t as $e)
					if(Helper::trimm($e)!='')
						DB::table('keywords')->insert(['keyword' => Helper::trimm($e),'table'=>'post', 'lang' => 'ar', 'url'=>$url]);
			}
			if(Helper::trimm($p->seo_keywords_en) != ''){
				$t = explode(',',$p->seo_keywords_en);
				foreach($t as $e)
					if(Helper::trimm($e)!='')
						DB::table('keywords')->insert(['keyword' => Helper::trimm($e),'table'=>'post', 'lang' => 'en', 'url'=>$url]);
			}
			if(Helper::trimm($p->seo_keywords_fr) != ''){
				$t = explode(',',$p->seo_keywords_fr);
				foreach($t as $e)
					if(Helper::trimm($e)!='')
						DB::table('keywords')->insert(['keyword' => Helper::trimm($e),'table'=>'post', 'lang' => 'fr', 'url'=>$url]);
			}
			if(Helper::trimm($p->seo_keywords_ru) != ''){
				$t = explode(',',$p->seo_keywords_ru);
				foreach($t as $e)
					if(Helper::trimm($e)!='')
						DB::table('keywords')->insert(['keyword' => Helper::trimm($e),'table'=>'post', 'lang' => 'ru', 'url'=>$url]);
			}
			if(Helper::trimm($p->seo_keywords_fa) != ''){
				$t = explode(',',$p->seo_keywords_fa);
				foreach($t as $e)
					if(Helper::trimm($e)!='')
						DB::table('keywords')->insert(['keyword' => Helper::trimm($e),'table'=>'post', 'lang' => 'fa', 'url'=>$url]);
			}
			DB::table('keywords')->insert(['keyword' => Helper::trimm($p->title_ar),'table'=>'post', 'lang' => 'ar', 'url'=>$url]);
			DB::table('keywords')->insert(['keyword' => Helper::trimm($p->title_en),'table'=>'post', 'lang' => 'en', 'url'=>$url]);
			DB::table('keywords')->insert(['keyword' => Helper::trimm($p->title_fr),'table'=>'post', 'lang' => 'fr', 'url'=>$url]);
			DB::table('keywords')->insert(['keyword' => Helper::trimm($p->title_ru),'table'=>'post', 'lang' => 'ru', 'url'=>$url]);
			DB::table('keywords')->insert(['keyword' => Helper::trimm($p->title_fa),'table'=>'post', 'lang' => 'fa', 'url'=>$url]);
			
		}
		
		//PROJECT
		$url = '';
		$projects = DB::table('projects')->select(/*'title_en','title_ar','name_en','name_ar',*/'id','slug','seo_keywords_ar','seo_keywords_en','seo_keywords_ru','seo_keywords_fr','seo_keywords_fa')->orderBy('seo_keywords_ar')->get();
		foreach($projects as $p){
			$project = \App\Models\Project::find($p->id);
			$url = $project ? $project->frontUrl() : route('front.project', $p->slug);
			if(Helper::trimm($p->seo_keywords_ar) != ''){
				$t = explode(',',$p->seo_keywords_ar);
				foreach($t as $e)
					if(Helper::trimm($e)!='')
						DB::table('keywords')->insert(['keyword' => Helper::trimm($e),'table'=>'project', 'lang' => 'ar', 'url'=>$url]);
			}
			if(Helper::trimm($p->seo_keywords_en) != ''){
				$t = explode(',',$p->seo_keywords_en);
				foreach($t as $e)
					if(Helper::trimm($e)!='')
						DB::table('keywords')->insert(['keyword' => Helper::trimm($e),'table'=>'project', 'lang' => 'en', 'url'=>$url]);
			}
			if(Helper::trimm($p->seo_keywords_fr) != ''){
				$t = explode(',',$p->seo_keywords_fr);
				foreach($t as $e)
					if(Helper::trimm($e)!='')
						DB::table('keywords')->insert(['keyword' => Helper::trimm($e),'table'=>'project', 'lang' => 'fr', 'url'=>$url]);
			}
			if(Helper::trimm($p->seo_keywords_ru) != ''){
				$t = explode(',',$p->seo_keywords_ru);
				foreach($t as $e)
					if(Helper::trimm($e)!='')
						DB::table('keywords')->insert(['keyword' => Helper::trimm($e),'table'=>'project', 'lang' => 'ru', 'url'=>$url]);
			}
			if(Helper::trimm($p->seo_keywords_fa) != ''){
				$t = explode(',',$p->seo_keywords_fa);
				foreach($t as $e)
					if(Helper::trimm($e)!='')
						DB::table('keywords')->insert(['keyword' => Helper::trimm($e),'table'=>'project', 'lang' => 'fa', 'url'=>$url]);
			}
			/*DB::table('keywords')->insert(['keyword' => Helper::trimm($p->name_ar),'table'=>'project', 'lang' => 'ar', 'url'=>$url]);//url=project
			DB::table('keywords')->insert(['keyword' => Helper::trimm($p->name_en),'table'=>'project', 'lang' => 'en', 'url'=>$url]);

			if($p->title_ar!='')
				DB::table('keywords')->insert(['keyword' => Helper::trimm($p->title_ar),'table'=>'project', 'lang' => 'ar', 'url'=>$url]);
			if($p->title_en!='')
				DB::table('keywords')->insert(['keyword' => Helper::trimm($p->title_en),'table'=>'project', 'lang' => 'en', 'url'=>$url]);*/
		}

		//type  [فلل للبيع في تركيا   -  فلل للبيع في استنبول]
		$url = '';
		$citys = Helper::query("City", "orderByPlacement");
		$ProjectTypes = Helper::query("ProjectType", "all");
		foreach($citys as $c){
			foreach($ProjectTypes as $pt){
				$url = route("front.search")."/".$pt->getSlug()."/".$c->getSlug();
				DB::table('keywords')->insert(['keyword' => Helper::trimm($pt->getName() .' للبيع  في '. ($c->getName()=='كل المدن'?'تركيا':$c->getName())),'table'=>'project', 'lang' => 'ar','url'=>$url]);
				DB::table('keywords')->insert(['keyword' => Helper::trimm($pt->getNameEn() . ' for sale in ' . $c->getNameEn()),'table'=>'project', 'lang' => 'en','url'=>$url]);
				DB::table('keywords')->insert(['keyword' => Helper::trimm($pt->getNameFr() . ' à vendre à ' . $c->getNameFr()),'table'=>'project', 'lang' => 'fr','url'=>$url]);
				DB::table('keywords')->insert(['keyword' => Helper::trimm($pt->getNameFa() . ' برای فروش در ' . $c->getNameFa()),'table'=>'project', 'lang' => 'fa','url'=>$url]);
			}
			$url = route("front.search")."/property-for-sale/".$c->getSlug();
			DB::table('keywords')->insert(['keyword' => Helper::trimm(' عقارات للبيع  في '. ($c->getName()=='كل المدن'?'تركيا':$c->getName())),'table'=>'project', 'lang' => 'ar','url'=>$url]);
			DB::table('keywords')->insert(['keyword' => Helper::trimm('property for sale in ' . $c->getNameEn()),'table'=>'project', 'lang' => 'en','url'=>$url]);
			DB::table('keywords')->insert(['keyword' => Helper::trimm(' املاک فروشی در '. ($c->getNameFa()=='كل المدن'?'تركيا':$c->getNameFa())),'table'=>'project', 'lang' => 'fa','url'=>$url]);
			DB::table('keywords')->insert(['keyword' => Helper::trimm('propriété à vendre à ' . $c->getNameFr()),'table'=>'project', 'lang' => 'fr','url'=>$url]);
		}

		//Region
		$url = '';
		$regions = Helper::query("Region", "all");
		foreach($regions as $r){
			$url = route("front.search")."/property-for-sale/turkey/".$r->getSlug();
			//DB::table('keywords')->insert(['keyword' => Helper::trimm($r->getName()),'table'=>'project', 'lang' => 'ar','url'=>$url]);
			DB::table('keywords')->insert(['keyword' => Helper::trimm('منطقة '.$r->getName()),'table'=>'project', 'lang' => 'ar','url'=>$url]);
			DB::table('keywords')->insert(['keyword' => Helper::trimm($r->getNameEn()),'table'=>'project', 'lang' => 'en','url'=>$url]);
			DB::table('keywords')->insert(['keyword' => Helper::trimm($r->getNameFr()),'table'=>'project', 'lang' => 'fr','url'=>$url]);
			DB::table('keywords')->insert(['keyword' => Helper::trimm($r->getNameFa()),'table'=>'project', 'lang' => 'fa','url'=>$url]);
		}
		
		
		
		
		//type in region
		$url = '';
		foreach($ProjectTypes as $pt){
			$i=true;
			foreach($regions as $r){
				$url = route("front.search")."/".$pt->getSlug()."/turkey/".$r->getSlug();
				DB::table('keywords')->insert(['keyword' => Helper::trimm($pt->getName() .' للبيع في '.$r->getName()),'table'=>'project', 'lang' => 'ar', 'url'=>$url]);
				DB::table('keywords')->insert(['keyword' => Helper::trimm($pt->getNameEn() .' for sale in '.$r->getNameEn()),'table'=>'project', 'lang' => 'en', 'url'=>'en/'.$url]);
				DB::table('keywords')->insert(['keyword' => Helper::trimm($pt->getNameFr() .' à vendre à '.$r->getNameFr()),'table'=>'project', 'lang' => 'fr', 'url'=>'fr/'.$url]);
				DB::table('keywords')->insert(['keyword' => Helper::trimm($pt->getNameFa() .' برای فروش در '.$r->getNameFa()),'table'=>'project', 'lang' => 'fa', 'url'=>'pe/'.$url]);
				if($i==true){
					$url = route("front.search")."/property-for-sale/turkey/".$r->getSlug();
					DB::table('keywords')->insert(['keyword' => Helper::trimm($pt->getName() .' للبيع في '.$r->getName()),'table'=>'project', 'lang' => 'ar', 'url'=>$url]);
					DB::table('keywords')->insert(['keyword' => Helper::trimm($pt->getNameEn() .' for sale in '.$r->getNameEn()),'table'=>'project', 'lang' => 'en', 'url'=>'en/'.$url]);
					DB::table('keywords')->insert(['keyword' => Helper::trimm($pt->getNameFr() .' à vendre à '.$r->getNameFr()),'table'=>'project', 'lang' => 'fr', 'url'=>'fr/'.$url]);
					DB::table('keywords')->insert(['keyword' => Helper::trimm($pt->getNameFa() .'  برای فروش در  '.$r->getNameFa()),'table'=>'project', 'lang' => 'fa', 'url'=>'pe/'.$url]);
					$i = false;
				}
			}
		}
		
		
		//tags in city
		$url = '';
		$tags = Helper::query("ProjectCategory", "all");
		foreach($citys as $c){
			foreach($tags as $t){
				
				foreach($ProjectTypes as $pt){
					$url = route("front.search")."/".$pt->getSlug()."/".$c->getSlug()."/".$t->getSlug();
					//echo $url.'<br>';
					//echo $t->getName() .' في '. ($c->getName()=='كل المدن'?'تركيا':$c->getName()).'<br>';
					
					DB::table('keywords')->insert(['keyword' => Helper::trimm($pt->getName() .' '. str_replace('عقارات','',$t->getName()) .' في '. ($c->getName()=='كل المدن'?'تركيا':$c->getName())),'table'=>'project', 'lang' => 'ar', 'url'=>$url]);
					DB::table('keywords')->insert(['keyword' => Helper::trimm($pt->getNameEn() .' '. str_replace('عقارات','',$t->getNameEn()) . ' in ' . $c->getNameEn()),'table'=>'project', 'lang' => 'en', 'url'=>$url]);
					
					DB::table('keywords')->insert(['keyword' => Helper::trimm($pt->getNameFr() .' '. str_replace('عقارات','',$t->getNameFr()) . ' en ' . $c->getNameFr()),'table'=>'project', 'lang' => 'fr', 'url'=>$url]);
					DB::table('keywords')->insert(['keyword' => Helper::trimm($pt->getNameFa() .' '. str_replace('عقارات','',$t->getNameFa()) . ' در ' . $c->getNameFa()),'table'=>'project', 'lang' => 'fa', 'url'=>$url]);
				}
				
				$url = route("front.search")."/property-for-sale/".$c->getSlug()."/".$t->getSlug();
				DB::table('keywords')->insert(['keyword' => Helper::trimm($t->getName() .' في '. ($c->getName()=='كل المدن'?'تركيا':$c->getName())),'table'=>'project', 'lang' => 'ar', 'url'=>$url]);
				DB::table('keywords')->insert(['keyword' => Helper::trimm('عقارات '. str_replace('عقارات','',$t->getName()) .' في '. ($c->getName()=='كل المدن'?'تركيا':$c->getName())),'table'=>'project', 'lang' => 'ar', 'url'=>$url]);
				DB::table('keywords')->insert(['keyword' => Helper::trimm(str_replace('عقارات','',$t->getNameEn()) . ' in ' . $c->getNameEn()),'table'=>'project', 'lang' => 'en', 'url'=>$url]);	
				DB::table('keywords')->insert(['keyword' => Helper::trimm(str_replace('عقارات','',$t->getNameFr()) . ' en ' . $c->getNameFr()),'table'=>'project', 'lang' => 'fr', 'url'=>$url]);	
				DB::table('keywords')->insert(['keyword' => Helper::trimm(str_replace('عقارات','',$t->getNameFa()) . ' در ' . $c->getNameFa()),'table'=>'project', 'lang' => 'fa', 'url'=>$url]);	
			}
		}
		
		//exit;
		
		//Remove dupliacte concat(keyword+table) except not null url
		$all = DB::select("SELECT concat(`keyword`,`table`) as 'lconcat',count(*) as 'cnt'
			FROM `dms_keywords`
			group by concat(`keyword`,`table`)
			HAVING count(*)>1");
		/*print_r($all);
		exit;*/
		foreach($all as $l){
			DB::delete('delete from dms_keywords where concat(`keyword`,`table`)=? and url!=? limit ?',[$l->lconcat,'',$l->cnt-1]);
		}

		//Remove dupliacte concat(keyword+table) except 1 row
		$all = DB::select("SELECT concat(`keyword`,`table`) as 'lconcat',count(*) as 'cnt'
			FROM `dms_keywords`
			group by concat(`keyword`,`table`)
			HAVING count(*)>1");
		foreach($all as $l){
			DB::delete('delete from dms_keywords where concat(`keyword`,`table`)=? limit ?',[$l->lconcat,$l->cnt-1]);
		}


		// remove blank from website
		DB::update("update dms_keywords set keyword = REPLACE(keyword,'  ',' ')");


		//update URL locale
		$all = DB::select("SELECT * 
			FROM `dms_keywords`");

		
		foreach($all as $k=>$r){
			if($r->url!=''){
				if($r->lang=='en')
					DB::update("update dms_keywords set url=? where id=?",array(str_replace('turk.com/','turk.com/en/',$r->url),$r->id));
				elseif($r->lang=='fr')
					DB::update("update dms_keywords set url=? where id=?",array(str_replace('turk.com/','turk.com/fr/',$r->url),$r->id));
				elseif($r->lang=='fa' or $r->lang=='pe')
					DB::update("update dms_keywords set url=? where id=?",array(str_replace('turk.com/','turk.com/pe/',$r->url),$r->id));
			}
		}



		//set url for non defined
		/*$all = DB::select("SELECT *
			FROM `dms_keywords` where url = ''
			order by id asc");
			
		foreach($all as $l){
			$l->keyword
			
		}*/


		/*$url = route("front.search")."/property-for-sale/turkey";
		DB::update('update dms_keywords set url=? where url=?',[$url,'']);*/
		/*
		
		echo '<pre>';
		print_r($all);
		echo '</pre>';
		exit;*/
		response()->json(['success' => 'success'], 200);
		
		
	}
	/*public function url_keyword($k){
		$all = DB::select("SELECT *
			FROM `dms_keywords` WHERE  REGEXP 'sports|pub'");
		
	}*/
    
    /**
    * cron_tiny_picture
    *
    * @return void
    */
    public function cron_tiny_picture()
    {
		exit;
	//***  Tinify ***
	try {//FpnZlVQY4H4rptyrxWDh7pQpGnmkhtC0
		\Tinify\setKey("81zqCr5z0QCQhVf3kZXv93NnpzBy78fc");
		\Tinify\validate();
		
		$cnt_comp_this_month = \Tinify\compressionCount();
		echo "optimized pics this month:".$cnt_comp_this_month.'<br>';
		

		if($cnt_comp_this_month<500){
		
		//if($cnt_comp_this_month>)
		$pics = DB::table('medias')->where('size_after',0)->limit(10)->OrderBy('id','desc')->get();
		
		foreach($pics as $r){
			
			//$pic_m = public_path($pic->path_mobile);
			$pic = public_path($r->path);
			echo $pic.'<br>';
			$size_before = filesize($pic);
			//$msize_after = -1;

			if(is_file($pic) and file_exists($pic)){
				$source = \Tinify\fromFile($pic);
				$output = $source->toBuffer();
				copy($pic, str_replace('uploads/','uploads_origin/',$pic));
				file_put_contents($pic, $output);
				clearstatcache();
				$size_after = filesize($pic);
				DB::table('medias')->where('id',$r->id)->update(['size_before'=>$size_before,'size_after'=>$size_after]);
				if($size_after>$size_before){
					copy(str_replace('uploads/','uploads_origin/',$pic), $pic);
				}
			}
		}
		
		
		
    clearstatcache();
		
		$pics = DB::table('medias')->where('msize_after',0)->limit(10)->OrderBy('id','desc')->get();
		
		foreach($pics as $r){
			$pic = public_path($r->path_mobile);
			$size_before = filesize($pic);
			//$msize_after = -1;
			if($r->path_mobile!='' and is_file($pic) and file_exists($pic)){
				$source = \Tinify\fromFile($pic);
				$output = $source->toBuffer();
				copy($pic, str_replace('uploads/','uploads_origin/',$pic));
				file_put_contents($pic, $output);
				
				clearstatcache();
				$size_after = filesize($pic);
				DB::table('medias')->where('id',$r->id)->update(['msize_before'=>$size_before,'msize_after'=>$size_after]);
				if($size_after>$size_before){
					copy(str_replace('uploads/','uploads_origin/',$pic), $pic);
				}
			}
		}
	

    
	}	
		
	} catch(\Tinify\AccountException $e) {
	print("The error message is: " . $e->getMessage());
	// Verify your API key and account limit.
	}
	}
    /**
    * testphp page
    *
    * @return void
    */
    public function testphp(Request $request)
    {
		//$inputs['h_email']
		//$arr_emails = DB::connection('mysql_crm')->table('hrs')->where('h_email', 'like', $inputs['h_email'])->where('h_code','!=','copie')->orderBy('id','asc')->get();
		//echo count($arr_emails);
		exit;
		//if(strlen(Cookie::get('navigation'))<=1950)
			//echo (Cookie::get('navigation'));
		//exit;
		
		
		//if(Cookie::get('gclidd')=='')
		//	echo "nothindssss";
		
		
		
		echo Cookie::get('navigation').'<br>';
		
		//echo '----------------------------------------------------------------<br>';
		//echo @$_COOKIE['navigation'];
		exit;
		
		echo Helper::usd_to_format(500, 'TRY', false);
		
		exit();
		$arrhrs = DB::connection('mysql_crm')->table('hrs')->get();
		
		foreach($arrhrs as $hr){
			$hr_id = $hr->id;
		
		
		$experience = '';
		$education = '';
		$languages = '';
		
		$Rexperience = DB::connection('mysql_crm')->table('experiments')->where("hr_id", $hr_id)->orderBy(DB::raw("CAST(durationWork AS UNSIGNED)"), "desc")->first();
		if($Rexperience!=false)
			$experience = $Rexperience->companyName;
		
		$list_certs = ['PhD'=>8,'Master'=>7,"Bachelor's Degree"=>6,'Diploma'=>5,'Institute'=>4,'High School'=>3,'Middle School'=>2];
		
		$Reducation = DB::connection('mysql_crm')->table('certificates')->where("hr_id", $hr_id)->orderBy(DB::raw("CAST(certificateDegreeInt AS UNSIGNED)"), "desc")->first();
		if($Reducation!=false)
			$education = $Reducation->certificateName;
		
		$list_langs = ['Advanced'=>4,'Upper Intermediate'=>3,'Intermediate'=>2,'Beginner'=>1];
		
		$Rlanguages = DB::connection('mysql_crm')->table('langs')->where("hr_id", $hr_id)->orderBy(DB::raw("CAST(langLevelInt AS UNSIGNED)"), "desc")->first();
		if($Rlanguages!=false)
			$languages = $Rlanguages->langName;
		
		DB::connection('mysql_crm')->table('hrs')->where('id',$hr_id)->update(['experience'=>$experience,'education'=>$education,'languages'=>$languages]);
		
		}
		
		exit;
		echo \Request::ip();
		exit;
	$x = floor(59/60);
	
	echo $x;
	exit;
		$data = (['name'=>'aaa','id'=>1]);
		//$request->session()->forget('searchs.id');
		if($request->session()->has('searchs.id')){
			$request->session()->push("searchs.id", ($data));
		}else{
			$request->session()->put('searchs.id', []);
			$request->session()->put("searchs.id", [$data]);
		}
		
		echo '<pre>';
		print_r($request->session()->get("searchs.id"));
		echo '</pre>';
		
    }	
		public function testphp2(Request $request)
    {
			/*
			$user=\Cookie::get('user');
			$user=json_decode($user);
			*/
		exit;
	$arrw = DB::connection('mysql_crm')->table('leads')->where('target','')->orWhereNull('target')->limit(10000)->orderBy('id','desc')->get();
	
	$upw=0;
	$upm=0;
	foreach($arrw as $w){
		
	//part 1
		if($w->whatsapp_code!=''){//whatsapp
			$rw = DB::select("SELECT * FROM `dms_whatsapp_msg` WHERE id=?",[$w->whatsapp_code]);
			if(count($rw)==1){
				$upw++;
				DB::connection('mysql_crm')->table('leads')->where('id',$w->id)->update(['target'=>@Helper::get_target($rw[0]->page) ]);
			}
		}else{//message
			$rw = DB::select("SELECT * FROM `dms_messages` WHERE mobile=? or mobile=?",[$w->mobile,$w->mobile2]);
			
			if(count($rw)==1){
				$upm++;
				DB::connection('mysql_crm')->table('leads')->where('id',$w->id)->update(['target'=>@Helper::get_target($rw[0]->page) ]);
			}
		}
		
	//part 2 update target by navaigation
		/*if($w->navigation!=''){
			$t0 = explode('>>',$w->navigation);
			
			$t = [];
			foreach($t0 as $u){
				if (strpos($u, '/ajax') !== false or strpos($u, '/fonts/') !== false or strpos($u, '/newsletter') !== false or strpos($u, '/Ryl') !== false or strpos($u, 'whatsapp_share') !== false or strpos($u, '.js') !== false or strpos($u, '/loadmore') !== false or strpos($u, '/landing/') !== false or strpos($u, '/callus') !== false){
					
				}else{
					$t[] = $u;
				}
			}
			
			if(isset($t[count($t)-1])){
				//echo trim($t[count($t)-1]).' --> '.@Helper::get_target(trim($t[count($t)-1])).'<br>';
				DB::connection('mysql_crm')->table('leads')->where('id',$w->id)->update(['target'=>@Helper::get_target(trim($t[count($t)-1])) ]);
			}
		}*/
	
	}
	
	echo "Wathsapp: " . $upw . '<br>';
	echo "Messages: " . $upm;
	
	
	

	exit;
	/*
$arr  = [
['10','1','?','?','DS318'],
['?','0','?','?','DS317'],
];
foreach($arr as $r){
$data['cash_discount'] = $r[0];
$data['tabu'] = (bool) $r[1];
$data['bs'] = $r[2];
$data['fs'] = $r[3];
\App\Models\Project::where("name_en", $r[4])->update($data);
}
exit('ok');*/
		/*$rows = DB::table('newsletter2')->OrderBy('id','desc')->get();
		$old_news = DB::table('newsletter')->OrderBy('id','desc')->get();
		foreach($rows as $r){
			//echo $r->id . '<br>';
			foreach($old_news as $o){
				if($o->id==$r->id)
					DB::table('newsletter2')->where('id',$r->id)->update(['created_at'=>$o->created_at,'updated_at'=>$o->updated_at]);
			}
		}*/
		/*echo '<pre>';
		print_r($rows);
		echo '</pre>';*/
		
/*		DB::enableQueryLog();
		$current_lang = 'ar';
		$last_posts = Helper::query("Post", "orderBy", ["field" => "created_at", "value" => "DESC"])->where("published", 1)->where('title_'.$current_lang,'!=','')->limit(3)->get();
	$laQuery = DB::getQueryLog();
	echo $laQuery[0]['query'];*/
exit;		
		/*
		//add old project(-1000days) to resal category
		$projects = DB::table('projects')->get();
		$project_cat_id = 23;
		
		foreach($projects as $p){
			$dif = ((strtotime($p->delivered_date) - strtotime(date('Y-m-d')))/3600)/24;
			if($dif<-1000){
				$p_cat = DB::table('project_category')->where('project_id',$p->id)->where('project_category_id',$project_cat_id)->first();
				if($p_cat==false)
					DB::table('project_category')->insert(['project_id'=>$p->id, 'project_category_id'=>$project_cat_id]);
				
			}
			
		}
		*/
		
	exit;
	/*
	//***  Tinify ***
	try {
		\Tinify\setKey("FpnZlVQY4H4rptyrxWDh7pQpGnmkhtC0");
		\Tinify\validate();
		
		$cnt_comp_this_month = \Tinify\compressionCount();
		echo $cnt_comp_this_month;
		if($cnt_comp_this_month<500){
		
		//if($cnt_comp_this_month>)
		$pics = DB::table('medias')->where('size_after',0)->limit(20)->OrderBy('id','desc')->get();
		
		foreach($pics as $r){
			//$pic_m = public_path($pic->path_mobile);
			$pic = public_path($r->path);
			$size_before = filesize($pic);
			//$msize_after = -1;

			if(is_file($pic) and file_exists($pic)){
				$source = \Tinify\fromFile($pic);
				$output = $source->toBuffer();
				copy($pic, str_replace('uploads/','uploads_origin/',$pic));
				file_put_contents($pic, $output);
				clearstatcache();
				$size_after = filesize($pic);
				DB::table('medias')->where('id',$r->id)->update(['size_before'=>$size_before,'size_after'=>$size_after]);
				if($size_after>$size_before){
					copy(str_replace('uploads/','uploads_origin/',$pic), $pic);
				}
			}
		}
		
		
		
    clearstatcache();
		
		$pics = DB::table('medias')->where('msize_after',0)->limit(20)->OrderBy('id','desc')->get();
		
		foreach($pics as $r){
			$pic = public_path($r->path_mobile);
			$size_before = filesize($pic);
			//$msize_after = -1;
			if($r->path_mobile!='' and is_file($pic) and file_exists($pic)){
				$source = \Tinify\fromFile($pic);
				$output = $source->toBuffer();
				copy($pic, str_replace('uploads/','uploads_origin/',$pic));
				file_put_contents($pic, $output);
				
				clearstatcache();
				$size_after = filesize($pic);
				DB::table('medias')->where('id',$r->id)->update(['msize_before'=>$size_before,'msize_after'=>$size_after]);
				if($size_after>$size_before){
					copy(str_replace('uploads/','uploads_origin/',$pic), $pic);
				}
			}
		}
	

    
	}	
		
	} catch(\Tinify\AccountException $e) {
	print("The error message is: " . $e->getMessage());
	// Verify your API key and account limit.
	}
*/


		exit;
		$arrw = DB::connection('mysql_crm')->table('leads')->where('tags','!=','')->get();
		/*echo count($arrw);
		exit;
		foreach($arrw as $w){
			if($w->tags!=''){
			$tgs = json_decode($w->tags,true);
			$data['campaign'] = (isset($tgs['Search'])?$tgs['Search']:@$tgs['Display']);
			$data['target'] = (isset($tgs['keyword'])?$tgs['keyword']:@$tgs['target']);
			
			DB::connection('mysql_crm')->table('leads')->where('id',$w->id)->update($data);
			echo '<br>';
			print_r($data);
			}
		}*/
		
		exit;
		//update whatsapp country by ip
		$arrw = DB::table('whatsapp_msg')->where('country','!=',null)->get();
		//echo count($arrw);
		foreach($arrw as $w){
			
			$ipAddress = $w->ip;
			$databaseFile = public_path('GeoLite2-Country.mmdb');
			$reader = new Reader($databaseFile);
			$country = $reader->get($ipAddress)['country']['names']['en'];
			$reader->close();
			
			//DB::table('whatsapp_msg')->where('id',$w->id)->update(['country'=>$country]);
			echo $w->country.'=>'.$country.'<br>';
		}


		exit;
		$start = microtime(true);
		$ipAddress = '196.116.144.117';
		$databaseFile = public_path('GeoLite2-Country.mmdb');

		$reader = new Reader($databaseFile);

		// get returns just the record for the IP address
		echo '<pre>';
		print_r($reader->get($ipAddress));
		echo '</pre><br><br>';
		// getWithPrefixLen returns an array containing the record and the
		// associated prefix length for that record.
		echo '<pre>';
		print_r($reader->getWithPrefixLen($ipAddress));
		echo '</pre>';
		
		echo @$reader->get($ipAddress)['country']['iso_code'].'<br>';
		echo @$reader->get($ipAddress)['country']['names']['en'];
		$reader->close();
		
		
		
		
		exit;
/*		$dbhost = '127.0.0.1';
        $dbuser = 'aqsawayc_damas';
        $dbpass = 'b)I!{Mn0(}!';
        $dbname = 'aqsawayc_olddamas';
        
        $backupFile = $dbname . date("Y-m-d-H-i-s") . '.gz';
$command = "mysqldump --opt -h $dbhost -u $dbuser -p $dbpass $dbname | gzip > $backupFile";
system($command);*/

exit;
/*	
$arr = [['251','D-705','damas705','DA001','da001'],
['250','D-704','damas704','DA002','da002'],
['249','D-703','damas703','DA003','da003'],
['240','D-371','damas371','DY013','dy013']
];

foreach($arr as $r){
if(count($r)>5)
exit('errors');
	
$id = $r[0];
$name_en = $r[1];
$slug = $r[2];
$new_name_en = $r[3];
$new_slug = $r[4];

if(strtolower($new_name_en)!=$new_slug)
	exit('fiddd');
DB::table('projects')->where('id',$id)->update(['name_en'=>$new_name_en,'slug'=>$new_slug]);
*/
/*
$slug = strtolower(str_replace('-','',$name_en));
if(in_array($slug,$land_slugs)){
echo "Redirect 301 /landing/".$slug." /landing/".$new_slug."<br/>";
}*/
//landing 
//multimedia


//echo "Redirect 301 /multimedia/".$slug." /multimedia/".$new_slug."<br>";

//}

/*

$land_slugs = ['d186','d218','d209','d163','d158','d129','d137','d110'];
	foreach($arr as $r){
		if(count($r)>5)
			exit('errors');
		$id = $r[0];
		$name_en = $r[1];
		$slug = $r[2];
		$new_name_en = $r[3];
		$new_slug = $r[4];


		$slug = strtolower(str_replace('-','',$name_en));
		if(in_array($slug,$land_slugs)){
			//echo "Redirect 301 /landing/".$slug." /landing/".$new_slug."<br/>";
			DB::table('landingpages')->where('slug',$slug)->update(['slug'=>$new_slug,'name'=>$new_name_en]);	
		}
	}


*/
	exit;
		//composer dumpautoload
		//print_r($_SERVER);
	$start = microtime(true);
		$ipAddress = '196.116.144.117';
$databaseFile = public_path('GeoLite2-Country.mmdb');

$reader = new Reader($databaseFile);

// get returns just the record for the IP address
/*echo '<pre>';
print_r($reader->get($ipAddress));
echo '</pre><br><br>';*/
// getWithPrefixLen returns an array containing the record and the
// associated prefix length for that record.
/*echo '<pre>';
print_r($reader->getWithPrefixLen($ipAddress));
echo '</pre>';*/
echo @$reader->get($ipAddress)['country']['iso_code'];
$reader->close();

echo '<br><br><br>';
echo microtime(true) - $start;
/*echo '<br><br><br>';
$start = microtime(true);
		$all = DB::select("SELECT * 
			FROM `dms_keywords`");
echo microtime(true) - $start;
		exit('404');*/
		/*
$arr = [
['D-217','https://www.bulvaratakent.com/','Bulvar Atakent ','Maksem Inşaat','',''],
['D-361','http://www.mallofistanbul.com.tr/welcome','Mall of Istanbul ','Torunlar GYO','',''],
['D-362','Not found','Sky Bahcesehir ','Sinan Gay.','',''],
['D-364','http://www.dumankaya.com/','Dumankaya Bahçe.','Dumankaya Inşaat','',''],
['D-363','https://www.balancegunesli.com.tr/','Balance Güneşli ','Balance Gay.','',''],
['D-371','Not found','Rıhtım Palace ','akcan yapı','',''],
];

foreach($arr as $r){
$proj = DB::table('projects')->where('name_en',$r[0])->first();
if($proj==false){
	echo $r[0].'<br>';
	exit;
	}
	
if(trim($r[3])!=''){
$c = DB::table('companies')->where('company_name',trim($r[3]))->first();
if($c==false){
	echo 'COMP: '.$r[3];
	exit("111");
	}
echo DB::table('project_company')->insert(['project_id'=>$proj->id,'company_id'=>$c->id]);
}
if(trim($r[4])!=''){
$c = DB::table('companies')->where('company_name',trim($r[4]))->first();
if($c==false){
	echo 'COMP: '.$r[4];
	exit("222");
	}
echo DB::table('project_company')->insert(['project_id'=>$proj->id,'company_id'=>$c->id]);
}
if(trim($r[5])!=''){
$c = DB::table('companies')->where('company_name',trim($r[5]))->first();
if($c==false){
	echo 'COMP: '.$r[5];
	exit("333");
	}
echo DB::table('project_company')->insert(['project_id'=>$proj->id,'company_id'=>$c->id]);
}

echo DB::update('UPDATE `dms_projects` SET `project_link`=?,title_en=? WHERE name_en=?',[$r[1],$r[2],$r[0]]);



}*/

exit;
/*
$arr = [['Astaşaries','http://www.astasaries.com/'],
['24 Gay.','http://www.24gayrimenkul.com/'],];
foreach($arr as $r){
	DB::table('companies')->insert(['company_name'=>$r[0],'link'=>$r[1]]);
}

		exit;*/
		/*
		$projs = DB::table('projects')->where('id','>',0)->get();
		$unx_pdf = 0;//240
		$unx_inf = 0;
		foreach($projs as $p){
			if(!file_exists(public_path($p->file_infographic))){
				$p->file_infographic = '';
				$unx_pdf++;
				DB::table('projects')->where('id',$p->id)->update(['file_infographic'=>'']);
			}
			if(!file_exists(public_path($p->file_pdf))){
				$p->file_pdf = '';
				$unx_inf++;
				DB::table('projects')->where('id',$p->id)->update(['file_pdf'=>'']);
			}
			
		}
		
		echo 'unx_pdf: '.$unx_pdf.'<br>';
		echo 'unx_in: '.$unx_inf;
		exit;
		*/
		
		/*$arr1 = DB::select("select * from dms_projects where payment_method='تقسيط'",[]);
			foreach($arr1 as $r){
				preg_match_all('!\d+!', $r->paymentmethod_ar, $matches);
				$matches = $matches[0];
				if(count($matches)==2){
					DB::update("update dms_projects set payment_percent=?,payment_months=? where id=?",[$matches[0],$matches[1],$r->id]);
					echo '1';
				}else
					echo '<br>0';
			}
		
		exit;*/
		
/* date("Y/m", strtotime(date('Y-m-d') ));
exit;*/
		/*echo ((strtotime('2019-09-26') - strtotime(date('Y-m-d')))/3600)/24;
				exit;*/
		/*
		$dif>365
		'revendre'
		$dif>0
		'ready'
		$dif<0
		'under cons'
		*/
		
		/*$arr1 = DB::select("select id, concat('01-',replace(`delivered_date`,'/','-')) as 'date1' from dms_projects where delivered_date like '%/%'",[]);
			foreach($arr1 as $r){
			$t = explode('-',$r->date1);
			$date = $t[2].'-'.$t[1].'-'.$t[0];
			DB::update('update dms_projects set delivered_date2=? where id=?',[$date,$r->id]);		
			}*/
			/*
	$arrr = [
["D-100","http://www.ispartakuleevleri.net/"],
["D-836","https://www.kuzugrup.com/en/proje/spradon-houses/"]
];

DB::update('UPDATE `dms_projects` SET `project_link`=?',['']);

foreach($arrr as $r){
			
			echo DB::update('UPDATE `dms_projects` SET `project_link`=? WHERE name_en=?',[$r[1], $r[0]]);
echo '<br>';			
			}
		echo 'ok';*/
		exit;
		/*$data=[
		['aa1'],
		['aa2'],
		['aa3'],
		['aa4'],
		['aa5'],
		['aa6'],
		['aa7'],
		['aa8'],
		['aa9'],
		['aa10'],
		['aa11'],
		['aa12'],
		];*/
		
		
		/*$keyword = 'اسطنبول';
		
		$q = "SELECT distinct p.* FROM dms_posts p WHERE p.published = 1  and (title_ar like ? or title_en like ? or content_ar like ? or content_en like ? ) order by CASE 
		WHEN title_ar like ? THEN 1
		WHEN title_en like ? THEN 2
		WHEN content_ar like ? THEN 3
		WHEN content_en like ? THEN 4	
		ELSE -1 END ASC";
        $data = \App\Models\Post::hydrateRaw($q,array('%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%'));
		$x=$data;
		echo 'Count: '.count($data).'<br/>';
		
		
		$data = $data->forPage(isset($_GET['page'])?$_GET['page']:1, 10);
		foreach($data as $r)
		echo $r->id.'<br>';
		
		echo '<br><br><br>';
		foreach($x as $r)
		echo $r->id.'<br>';
		
		
		*/
		exit;
		/*
		echo count($posts);
		return view("front.contact_us");
		
		exit;
		 $token = env("ZOHO_TOKEN");
		 $zcrmModuleIns = ZCRMModule::getInstance("Contacts");
$bulkAPIResponse=$zcrmModuleIns->getRecords();
$recordsArray = $bulkAPIResponse->getData(); // $recordsArray - array of ZCRMRecord instances

echo '<pre>';
print_r($recordsArray);
echo '<pre>';
exit;
        $xmldata = "<?xml version='1.0' encoding='UTF-8' ?><Leads><row no='1'>".
          "<FL val='First Name'><![CDATA[{$inputs['name']}]]></FL>".
          "<FL val='Last Name'><![CDATA[{$fame}]]></FL>".
          "<FL val='Email'><![CDATA[{$inputs['email']}]]></FL>".
          "<FL val='Mobile'><![CDATA[%2B{$inputs['mobile']}]]></FL>".
          "<FL val='Message'><![CDATA[{$inputs['message']}]]></FL>".
          "<FL val='Contact Time'><![CDATA[{$inputs['communication_time']}]]></FL>".
          "<FL val='Landing Page'><![CDATA[{$inputs['page']}]]></FL>".
          "<FL val='Lead Source >>'><![CDATA[{$inputs['src']}]]></FL>".
          "<FL val='Country'><![CDATA[{$inputs['country']}]]></FL>".
          "<FL val='Expected Budget'><![CDATA[{$inputs['budget']}]]></FL>".
          "<FL val='Navigation'><![CDATA[{$inputs['navigation']}]]></FL>".
          "</row></Leads>";
        $url = 'https://crm.zoho.com/crm/private/xml/Leads/insertRecords';
        $param= 'authtoken='.$token.'&scope=crmapi&newFormat=1&xmlData='.$xmldata;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($ch);
        curl_close($ch);
		
		$x = @simplexml_load_string( $result);
		$result = @$x->result->message[0];
		
		
		
		exit;
		$arr1 = DB::select("SELECT id,page,gclid,download FROM `dms_whatsapp_msg` 
		WHERE id>14310 and page like '%gclid=%'
		ORDER BY `dms_whatsapp_msg`.`id` DESC",[]);


	foreach($arr1 as $r){
		echo $r->page.'<br>';
		$t = explode('gclid=',$r->page);
		echo $t[1].'<br>';
		DB::update('update dms_whatsapp_msg set gclid=?, download=0 where id=?',[@$t[1],$r->id]);
		
	}	
		*/
	}
	
	
	
	
	
    /**
    * show ajaxkeywords
    *
    * @param string $slug
    * @return void
    */
    public function ajaxkeywords()
    {
		$s = \Input::get("term");
		$s = str_replace(['%','<','>'],'',$s);
		
		if(\LaravelLocalization::getCurrentLocale()=='ar' or \LaravelLocalization::getCurrentLocale()=='pe'){
			$s = str_replace(array('ا','أ','آ','إ'),'_',$s);
			$s = str_replace(array('ة ','ه '),"_ ",$s);
			$s = str_replace(array('ة','ه'),"_",$s);
			$s = str_replace(array('ية','يه'),"__",$s);
			$s = str_replace('  '," ",$s);
		}
/*
الاشخاص الذين يبحثونعن مشاريع  في مستطيل البحث العام
غالبا لم  يعلمو بوجود صفحة البحث عن المشاريع
حيث يمكن البحث بتفاصيل و فلترة ادق 
لا يمكن ان الوصول لها  في البحث العام


اقترح ان  نظهر خيار للمستخدم بعد ان يضغط زر البحث العام  تفتح نافذة بها زرين الاول مواصلة البحث في المنشورات و الثاني الانتقال لصفحة البحث عن المشاريع
وسنحاول ان نحدد الخيارات في فورم المشاريع باءا على كلمة البحث التي ادخلها
مثلا اذا ادخل كلمة 'مشاريع عقارية في استنبول '
مشاريع استنبول تلقائيا ستنبول تلقائيا




default  (top 10 searched)
المدن
المناطق
[مزايا خاصة ] + في  + [المدينة]
[مزايا خاصة ] + في  + [المنطقة]

[نوع العقار] + في + [المدينة]
[نوع العقار] + في + [المنطقة]

sleep(200);

*/ 
if($s!=''){
		$arr1 = DB::select("SELECT distinct(`keyword`) as 'label',`keyword` as 'value',`table`,id,url,lang
			FROM `dms_keywords`
			where keyword like ?
			group by (`keyword`) 
			order by keyword asc
			limit 10
			",[''.$s.'%']);
		
		if(count($arr1)<10){
			$arr2 = DB::select("SELECT distinct(`keyword`) as 'label',`keyword` as 'value',`table`,id,url,lang
				FROM `dms_keywords`
				where keyword like ?
				group by (`keyword`) 
				order by keyword asc
				limit ?
				",['%'.$s.'%',20-count($arr1)]);
			$arr1 = array_merge($arr1,$arr2);
			$arr1 = Helper::unique_multidim_array($arr1,'keyword');
		}
		//$arr1 = array_unique($arr1);

return response()->json($arr1);
}
	






    }
    /**
    * offers
    *
    * @return void
    */
    public function tag($slug)
    {
		$tag = Helper::query("Tag", "where", ["field" => "slug", "value" => $slug])->first();
		if(!$tag or $tag->getTitle()=='')
			abort(404);
		
		$lang = (\LaravelLocalization::getCurrentLocale()=='pe'?'fa':\LaravelLocalization::getCurrentLocale());
		$posts = $tag->posts()->where('title_'.$lang,'!=','')->where('published',true)->orderBy('update_date','desc')->get();
		//dd($posts);
		
		
		$availables_langs = [];
		if(trim($tag->title_en)!='')
			$availables_langs[] = 'en';
		if(trim($tag->title_fr)!='')
			$availables_langs[] = 'fr';
		if(trim($tag->title_ru)!='')
			$availables_langs[] = 'ru';
		if(trim($tag->title_fa)!='')
			$availables_langs[] = 'pe';
		if(trim($tag->title_ar)!='')
			$availables_langs[] = 'ar';
		
		return view("front.tags",compact('tag','posts','availables_langs'));
	}
    /**
    * offers
    *
    * @return void
    */
    public function offers($offerid='')
    {
		//DB::enableQueryLog();
		$q = \App\Models\Land2offer::where('offer_end_date','>=',DB::raw('NOW()'));
		//;
		if($offerid!='')
			$q->where('id',$offerid)->orWhere('id', substr($offerid, 2));
		
		$offers = $q->get();
		
		/*$laQuery = DB::getQueryLog();
		echo $laQuery[0]['query'].'<br>';
		exit;*/
		
		/*if(count($offers)==0)
			abort(404);*/
		
		$page = Helper::query("Page", "where", ["field" => "slug", "value" => "offers"])->first();
		$title = ($page->getSeoTitle() ? $page->getSeoTitle() : $page->name);
		if($offerid!='' and count($offers)>0)
			$title = $offers[0]->getTitle();
		
		return view("front.offers",compact('page','offers','title'));
	}
	/**
    * 3603d
    *
    * @return void
    */
    public function view_360($offerid='')
    {
		$q = \App\Models\Project::where('link_3d','!=','')->where("published", 1)->where("sold",'!=', 100)->with('cardphoto');
		$projects = $q->get();
		
		$page = Helper::query("Page", "where", ["field" => "slug", "value" => "360"])->first();
		return view("front.view_360",compact('page','projects'));
	}
    /**
    * search page
    *
    * @return void
    */
    public function search_page()
    {
        $keyword = \Input::get("s");
        $keyword = str_replace(['}','{','*'],'',$keyword);
		if(trim($keyword)=='')
			return view("front.searchpage", ["data"=>[], "cnt_posts"=>0,"cnt_projects"=>0,"nbre_page"=>0]);
			
		
		
		
		
		
		
		$sinputs["page"] = \URL::previous();
		$sinputs["navigation"] = Helper::clean_navigation(Cookie::get('navigation'));
		$sinputs["tags"] = '';
		$sinputs["src"] = '';
		// Source visitor
		$cookie_reffer = Cookie::get('reffer');
		$coourl = parse_url($cookie_reffer);
		if ( ($cookie_reffer != str_replace('gclid=', '', $cookie_reffer)) or ($sinputs["page"] != str_replace('gclid=', '', $sinputs["page"])) ){
			$sinputs["src"] = "Adwords";
		} else {
			$sinputs["src"] = @$coourl['host'] ? $coourl['host'] : (@$coourl['path'] ? $coourl['path'] : 'دخول مباشر');
		}
		
		if(Cookie::get('gclid')!=''){
			$sinputs["src"] = "Adwords";
			
		}
			if(Cookie::get('tags')!="")
			$sinputs["tags"] = Cookie::get('tags');
		
		if(str_replace('ampproject','',$sinputs["page"]) != $sinputs["page"]){
			$sinputs["src"] = 'Google AMP';
		}elseif(str_replace('fbclid','',$sinputs["page"]) != $sinputs["page"]){
			$sinputs["src"] = 'facebook.com';
		}
		$tgs = [];
		if($sinputs['tags']!=''){
			$tgs = json_decode($sinputs['tags'],true);
		}else{
			$t = explode('?',$sinputs['page']);
			if(isset($t[1])){
				parse_str($t[1], $tgs);
			}
		}
		$inputs['source'] = $sinputs["src"];
		if(isset($tgs['campaign-name']) /*&& $tgs['utm_source']=='yektanet'*/){
			$inputs['campaign'] = $tgs['campaign-name'];
			$inputs['target'] = @$tgs['utm_content'];
		}elseif(isset($tgs['Search'])){
			$inputs['campaign'] = $tgs['Search'];
			$inputs['target'] = @$tgs['keyword'];
		}elseif(isset($tgs['Display'])){
			$inputs['campaign'] = $tgs['Display'];
			$inputs['target'] = isset($tgs['Target'])?$tgs['Target']:@$tgs['placement'];
		}elseif(isset($tgs['Remarket'])){
			$inputs['campaign'] = $tgs['Remarket'];
			$inputs['target'] = isset($tgs['Target'])?$tgs['Target']:@$tgs['placement'];
		}else{
			$inputs['campaign'] = @Helper::get_campaing($sinputs['navigation']);
			$inputs['target'] = @Helper::get_target($sinputs['page'],false,$inputs['navigation']);
		}
		
		
		
		
		
		
		
		
		$projects = [];
		$posts = [];
		$multikeywordprojectsearch = false;
		$multikeywordpostsearch = false;
		
		
		if($sinputs["src"]!='دخول مباشر'){
		//حفظ كلمة البحث و زيادة عدد مرات البحث في حالة كانت مضافة سابقا
			$search = DB::table("search")->where("word", $keyword)->get();
			$u_country = (string) @session()->get("iso_country");
			if(count($search)>0){
				//DB::table("search")->where('id',$search[0]->id)->update(["cnt_search" => $search[0]->cnt_search+1]);
				$inputs["keyword"] = $keyword;
				$inputs["cnt_search"] = $search[0]->cnt_search+1;
				
				
				$arr_co = unserialize(urldecode($search[0]->country));
				if(isset($arr_co[$u_country]))
					$arr_co[$u_country] = $arr_co[$u_country]+1;
				else
					$arr_co[$u_country] = 1;
				$inputs['country'] = urlencode(serialize($arr_co));
				$inputs['lastcountry'] = $u_country;
				$inputs['lang'] = \LaravelLocalization::getCurrentLocale();
				
				Helper::query("Search", "save", [
						"inputs"    =>  $inputs,
						"id"        =>  $search[0]->id
					]);
			}else{
				$inputs['word'] = $keyword;
				
				$arr_co = [];
				if(isset($u_country))
					$arr_co[$u_country] = 1;
				$inputs['country'] = urlencode(serialize($arr_co));
				
				
				$inputs['lang'] = \LaravelLocalization::getCurrentLocale();
				$inputs['lastcountry'] = $u_country;
				$inputs['cnt_search'] = 1;
				Helper::query("Search", "save", ["inputs"    =>  $inputs]);
			}
		}



		//تجاهل لعض الحروف في كلمة البحث مثل  ا','أ','آ','إه ة..
		if(\LaravelLocalization::getCurrentLocale()=='ar' || \LaravelLocalization::getCurrentLocale()=='pe'){
			$keyword = Helper::qualify_keyword_mysql($keyword);
		}
		/*echo $keyword;
		exit;*/
		$arrkeywords = Helper::arr_keyword_mysql(\Input::get("s"));
        
		
		
		//البحث عن الكلمات في جدول توجيه بحث المشاريع
		$project_type = '';
		$city = '';
		$tags = '';
		$region = '';
		$global = false;
		//اولا نبحث عن الكلمة ككل
		$search = DB::table("projectssearchkeywords")->select("id","keywords","class","slug")->where('keywords','LIKE','%'.$keyword.'%')->get();
		//->andWhere('class','in',array('global','type','tag'))
		if(count($search)>0){
			
			list($class,$slug) = Helper::build_search_url($search[0]);
			if($class=='type')
				$project_type = $slug;
			elseif($class=='city')
				$city = $slug;
			elseif($class=='tag')
				$tags = $slug;
			elseif($class=='region')
				$region = $slug;
			elseif($class=='global')
				$global = true;
		}else{
			//نبحث ع كل كلمة على حدة
			foreach($arrkeywords as $keyw){
				if( mb_strlen(str_replace('_','',$keyw))<2){//اذا كان عدد حروفه اقل من 4 و احد حروفه غير محدد
					continue;
				}
				$search = DB::table("projectssearchkeywords")->select("id","keywords","class","slug")->where('keywords','LIKE','%'.$keyw.'%')->get();
				if(count($search)>0){
				$exist = true;
				list($class,$slug) = Helper::build_search_url($search[0]);
				//echo '->Key:'.$keyw.'| '.$class.' | '.$slug.'<br>';
				
				if($class=='type')
					$project_type = $slug;
				elseif($class=='city')
					$city = $slug;
				elseif($class=='tag')
					$tags = $slug;
				elseif($class=='region')
					$region = $slug;
				elseif($class=='global')
					$global = true;
				}
			}
		}
		//exit;
		//التاكد من وجود نتيجة
		if($project_type != '' || $tags != '' || $global == true){
			return Redirect::to(route("front.search")."/".($project_type==''?'property-for-sale':$project_type)."/".($city==''?'turkey':$city) . ($tags!=''?'/'.$tags:'') . ($region!=''?'/'.$region:''));
		}
		
		//تم الانتهاء من قسم التخويل الى مشروع
		
		
		
		//بدأ البحث عن المقالات
		$redirect_post = false;
			$search = DB::table("redirectsearch")->select("id")->where('words','LIKE','%'.$keyword.'%')->get();
			if(count($search)>0){
				$redirect_post = true;
			}else{
				//اذا لم يجد يقسم الكلمة و يبحث عن كل جزء على حدة
				$search = DB::table("redirectsearch")->select("id");
				$i=false;
				foreach($arrkeywords as $keyw){
					if($i==false)
						$search->where('words','LIKE','%'.$keyw.'%');
					else
						$search->orWhere('words','LIKE','%'.$keyw.'%');
				$i=true;
				}
				if(count($search->get())>0)
				$redirect_post = true;
			}
		
		
		//البحث عن المقالات
		/*$posts = Helper::query("Post", "where", ["field" => "published", "value" => 1]);
		//DB::table("redirectsearch")->select("id")
		$posts->where('title_ar','like','%'.$keyword.'%')
				->orWhere('title_en','like','%'.$keyword.'%')
				->orWhere('content_ar','like','%'.$keyword.'%')
				->orWhere('content_en','like','%'.$keyword.'%')
				->orderBy('CASE WHEN title_ar like '' THEN 1 ELSE -1 END ASC');
		$posts = $posts->get();*/
		
		
	
		$q = "SELECT distinct p.*,concat('9999',p.id) as 'id', 'post' as 'datattype',CASE 
		WHEN title_ar like ? THEN 1
		WHEN title_en like ? THEN 1
		WHEN title_fr like ? THEN 1
		WHEN title_ru like ? THEN 1
		WHEN title_fa like ? THEN 1
		WHEN content_ar like ? THEN 2
		WHEN content_en like ? THEN 2
		WHEN content_fr like ? THEN 2
		WHEN content_ru like ? THEN 2
		WHEN content_fa like ? THEN 2
		WHEN seo_keywords_ar like ? THEN 3
		WHEN seo_keywords_en like ? THEN 3
		WHEN seo_keywords_fr like ? THEN 3
		WHEN seo_keywords_ru like ? THEN 3
		WHEN seo_keywords_fa like ? THEN 3
		ELSE -1 END as 'pos' FROM dms_posts p WHERE p.published = 1  and 
		(
		title_ar like ? or title_en like ? or content_ar like ? or content_en like ? or  seo_keywords_ar like ? or  seo_keywords_en like ? 
		or title_fa like ? or title_fr like ? or title_ru like ? or content_fa like ? or content_ru like ?  or content_fr like ? or  seo_keywords_fa like ? or  seo_keywords_fr like ?  or  seo_keywords_ru like ? 
		) order by pos ASC";
        $posts = \App\Models\Post::hydrateRaw($q,array('%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%'));


		$q = str_replace(['dms_posts','9999',"'post'",'THEN 1','THEN 2','THEN 3'],['dms_pages','98888',"'page'",'THEN 0','THEN 0','THEN 0'],$q);
		$pages = \App\Models\Page::hydrateRaw($q,array('%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%'));

		//البحث عن كل الكلمات المتشابهة و المرادفة
		$posts2 = [];
		$pages2 = [];// مثل صفحة الجنسية التركية
		$search = DB::table("wordsearch")->select("id","word","type")->where('word','LIKE','%'.$keyword.'%')->get();
		$keywords = [];
		if(count($search)>0){
		
		$keywords = Helper::arr_keyword_mysql($search[0]->word,true);
		
		
			//if($search->type == 'post' or $search->type == 'all'){
				$arrcond = [];
				$q = "SELECT distinct p.*,concat('9999',p.id) as 'id', 'post' as 'datattype',CASE ";
				foreach($keywords as $word){
					$q = $q . "
					WHEN title_ar like ? THEN 1
					WHEN title_en like ? THEN 1
					WHEN title_fr like ? THEN 1
					WHEN title_fa like ? THEN 1
					WHEN title_ru like ? THEN 1
					WHEN content_ar like ? THEN 2
					WHEN content_en like ? THEN 2
					WHEN content_fr like ? THEN 2
					WHEN content_fa like ? THEN 2
					WHEN content_ru like ? THEN 2
					";
					$arrcond[] = '%'.$word.'%';
					$arrcond[] = '%'.$word.'%';
					$arrcond[] = '%'.$word.'%';
					$arrcond[] = '%'.$word.'%';
					$arrcond[] = '%'.$word.'%';
					$arrcond[] = '%'.$word.'%';
					$arrcond[] = '%'.$word.'%';
					$arrcond[] = '%'.$word.'%';
					$arrcond[] = '%'.$word.'%';
					$arrcond[] = '%'.$word.'%';
				}

				$q = $q . " ELSE -1 END as 'pos' FROM dms_posts p WHERE p.published = 1  and (";
				$first = true;
				foreach($keywords as $word){
					if($first == true)
						$q = $q . " title_ar like ? or title_en like ? or content_ar like ? or content_en like ? or title_fr like ? or title_fa like ? or title_ru like ? or content_fr like ? or content_fa like ? or content_ru like ? ";
					else
						$q = $q . " or title_ar like ? or title_en like ? or title_ru like ? or content_ar like ? or content_en like ?  or title_fr like ? or title_fa like ? or content_fr like ? or content_fa like ?  or content_ru like ? ";

					$arrcond[] = '%'.$word.'%';
					$arrcond[] = '%'.$word.'%';
					$arrcond[] = '%'.$word.'%';
					$arrcond[] = '%'.$word.'%';
					$arrcond[] = '%'.$word.'%';
					$arrcond[] = '%'.$word.'%';
					$arrcond[] = '%'.$word.'%';
					$arrcond[] = '%'.$word.'%';
					$arrcond[] = '%'.$word.'%';
					$arrcond[] = '%'.$word.'%';
				$first = false;
				}
				
				$q = $q . ") order by pos ASC";
				
				$posts2 = \App\Models\Post::hydrateRaw($q,$arrcond);
				
				//pages
				$q = str_replace(['dms_posts','9999',"'post'",'THEN 1','THEN 2'],['dms_pages','98888',"'page'",'THEN 0','THEN 0'],$q);
				$pages2 = \App\Models\Page::hydrateRaw($q,$arrcond);









				/*$posts = Helper::query("Post", "where", ["field" => "published", "value" => 1]);
				$posts->where('title_ar','like','%'.$keyword.'%')->orWhere('title_en','like','%'.$keyword.'%');
				foreach($keywords as $word){
					$posts->orWhere('title_ar','like','%'.$word.'%')
						  ->orWhere('title_en','like','%'.$word.'%')
						  ->orWhere('content_ar','like','%'.$word.'%')
						  ->orWhere('content_en','like','%'.$word.'%');
				}
				$posts = $posts->get();*/
			//}
		}
		//نهاية البحث عن كل الكلمات المتشابهة و المرادفة
		
		$projects = array();
		if($redirect_post == false){//البحث لا يخص المقالات فقط اذن سيتم البحث داخل المشاريع ايضا
			
			$q = "SELECT distinct p.*, 'project' as 'datattype',CASE 
		WHEN title_ar like ? THEN 1
		WHEN title_en like ? THEN 1
		WHEN seo_title_fr like ? THEN 1
		WHEN seo_title_fa like ? THEN 1
		WHEN seo_title_ru like ? THEN 1
		WHEN company like ? THEN 1
		WHEN name_ar like ? THEN 1
		WHEN name_en like ? THEN 1
		WHEN intro_card_ar like ? THEN 2
		WHEN intro_card_en like ? THEN 2
		WHEN intro_card_fr like ? THEN 2
		WHEN intro_card_fa like ? THEN 2
		WHEN intro_card_ru like ? THEN 2
		WHEN location_ar like ? THEN 2
		WHEN location_en like ? THEN 2
		WHEN location_fr like ? THEN 2
		WHEN location_fa like ? THEN 2
		WHEN location_ru like ? THEN 2
		ELSE -1 END as 'pos' FROM dms_projects p WHERE p.published = 1 and (title_ar like ? or title_en like ? or company like ? or name_ar like ? or name_en like ? or intro_card_ar like ? or intro_card_en like ? or location_ar like ? or location_en like ? or name_fa like ? or intro_card_fr like ? or intro_card_fa like ? or location_fr like ? or location_fa like ? ) order by pos ASC";
			$projects = \App\Models\Project::hydrateRaw($q,array('%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%','%'.$keyword.'%'));
		}
		
		/*
		$cnt_posts = count($posts);
		$cnt_projects = count($projects);
		*/
		$data = [];
		$data = $posts->merge($posts2)->sortBy("pos");
		$data = $data->merge($pages)->sortBy("pos");
		$data = $data->merge($pages2)->sortBy("pos");
		$cnt_posts = count($data);
		
		
		//$projects = $projects->merge($projects2)->sortBy("pos");
		$cnt_projects = count($projects);
		
		
		$data = $data->merge($projects)->sortBy("pos");
		
		/*
		if(count($projects)==0)
			$data = $posts;
		elseif(count($posts)==0)
			$data = $projects;
		else
			$data = $projects->merge($posts)->sortBy("pos");//->paginate(10);
		
		//$posts2 = [];
		if(count($posts2)>0)
			$data = $data->merge($posts2)->sortBy("pos");//->paginate(10);

		
		//data and page
		if(count($data)==0)
			$data = $pages;
		elseif(count($pages)==0)
			$data = $data;
		else
			$data = $data->merge($pages)->sortBy("pos");
		*/
		
		$data = $data->forPage(isset($_GET['page'])?$_GET['page']:1, 10);
		
		
		if(count($pages2)>0)
			$data = $data->merge($pages2)->sortBy("pos");
		
		
		
		//echo count($items);
		
		//$total = $cnt_posts + $cnt_projects;
		
		$nbre_page = ceil(($cnt_posts + $cnt_projects)/10);
		//exit;
		
		return view("front.searchpage", compact("data", "cnt_posts","cnt_projects","nbre_page"));
		
		
		
		
		/*
		exit;
		//Old Code
		$redirect = '';
		
		//البحث عن كل الكلمات المتشابهة و المرادفة
		$search = DB::table("wordsearch")->select("id","word","type")->where('word','LIKE','%'.$keyword.'%')->get();
		$keywords = [];
		if(count($search)>0){
			$search = $search[0];
			$t = explode(',',$search->word);
			foreach($t as $k){
				if(trim($k)!='')
					$keywords[] = Helper::qualify_keyword($k);
			}
			
			if($search->type == 'post' or $search->type == 'all'){
				
				$posts = Helper::query("Post", "where", ["field" => "published", "value" => 1]);
				
				$posts->where('title_ar','like','%'.$keyword.'%')->orWhere('title_en','like','%'.$keyword.'%');
				foreach($keywords as $word){
					$posts->orWhere('title_ar','like','%'.$word.'%')
						  ->orWhere('title_en','like','%'.$word.'%')
						  ->orWhere('content_ar','like','%'.$word.'%')
						  ->orWhere('content_en','like','%'.$word.'%');
				}
				$posts = $posts->get();
			}
			if($search->type == 'project' or $search->type == 'all'){
				$projects = Helper::query("Project", "where", ["field" => "published", "value" => 1]);
				
				$projects->where('title_ar','like','%'.$keyword.'%')->orWhere('title_en','like','%'.$keyword.'%');
				foreach($keywords as $word){
					$projects->orWhere('title_ar','like','%'.$word.'%')
							->orWhere('title_en','like','%'.$word.'%')
							->orWhere('name_ar','like','%'.$word.'%')
							->orWhere('name_en','like','%'.$word.'%')
							->orWhere('intro_card_ar','like','%'.$word.'%')
							->orWhere('intro_card_en','like','%'.$word.'%');
				}
				$projects = $projects->get();
				
				
				
				if($search->type == 'project'){
					if(count($projects)==0 and count($arrkeywords)>1){
						
						$projects = Helper::query("Project", "where", ["field" => "published", "value" => 1]);
						$i=false;
						
						foreach($arrkeywords as $keyw){
							if($i == false)
							$projects->where('title_ar','like','%'.$keyw.'%');
							
							$projects->orWhere('title_ar','like','%'.$keyw.'%')->orWhere('title_en','like','%'.$keyw.'%')
									->orWhere('name_ar','like','%'.$keyw.'%')->orWhere('name_en','like','%'.$keyw.'%')
									->orWhere('intro_card_ar','like','%'.$keyw.'%')->orWhere('intro_card_en','like','%'.$keyw.'%');
							$i = true;
						}
						$projects = $projects->get();
					}
					
					$arps = [];
					foreach($projects as $p)
					$arps[] = $p->id;

					return Redirect::to(route("front.search")."/property-for-sale/turkey".'?sprojects=' . implode(',',$arps));
				}
			}
			
			
			
			
		}else{//في حالة الكلمة غير موجودة في جول الكلمات المتشابهة
			//البحث في الكلمات الموجهة
			
			$search = DB::table("redirectsearch")->select("id","type")->where('words','LIKE','%'.$keyword.'%')->get();
			if(count($search)>0){
				$redirect = $search[0]->type;
			}else{
				//اذا لم يجد يقسم الكلمة و يبحث عن كل جزء على حدة
				$search = DB::table("redirectsearch")->select("id","type");
				$i=false;
				foreach($arrkeywords as $keyw){
					if($i==false)
						$search->where('words','LIKE','%'.$keyw.'%');
					else
						$search->orWhere('words','LIKE','%'.$keyw.'%');
				$i=true;
				}
				if(count($search->get())>0)
				$redirect = $search->get()[0]->type;
			}
			
			//البحث عن المشاريع و العقارات
				if($redirect=='post' or $redirect==''){
					$posts = Helper::query("Post", "where", ["field" => "published", "value" => 1]);
					
					$posts->where('title_ar','like','%'.$keyword.'%')
							->orWhere('title_en','like','%'.$keyword.'%')
							->orWhere('content_ar','like','%'.$keyword.'%')
							->orWhere('content_en','like','%'.$keyword.'%');
					$posts = $posts->get();
					
					//if(count($posts)==0)
					//اذا لم يجد يبحث في الحقول الاخرى
					
				}

				if($redirect=='project' or $redirect==''){
					$projects = Helper::query("Project", "where", ["field" => "published", "value" => 1]);
					$projects->where('title_ar','like','%'.$keyword.'%')
							->orWhere('title_en','like','%'.$keyword.'%')
							->orWhere('name_ar','like','%'.$keyword.'%')
							->orWhere('name_en','like','%'.$keyword.'%')
							->orWhere('intro_card_ar','like','%'.$keyword.'%')
							->orWhere('intro_card_en','like','%'.$keyword.'%');
					$projects = $projects->get();
					
					//if(count($projects)==0)
					//اذا لم يجد يبحث في الحقول الاخرى
				}

				if($redirect == 'project'){
					if(count($projects)==0 and count($arrkeywords)>1){
						$projects = Helper::query("Project", "where", ["field" => "published", "value" => 1]);
						$i=false;
						
						foreach($arrkeywords as $keyw){
							if($i == false)
							$projects->where('title_ar','like','%'.$keyw.'%');
							
							$projects->orWhere('title_ar','like','%'.$keyw.'%')->orWhere('title_en','like','%'.$keyw.'%')
									->orWhere('name_ar','like','%'.$keyw.'%')->orWhere('name_en','like','%'.$keyw.'%')
									->orWhere('intro_card_ar','like','%'.$keyw.'%')->orWhere('intro_card_en','like','%'.$keyw.'%');
							$i = true;
						}
						$projects = $projects->get();
					}
					$arps = [];
					foreach($projects as $p)
					$arps[] = $p->id;
					//exit(count($arps));
					return Redirect::to(route("front.search")."/property-for-sale/turkey".'?sprojects=' . implode(',',$arps));
				}
			
			
			
			
		}
		
		
		
		
		
		if(($redirect == '' or $redirect == 'project') and count($projects)==0 and $multikeywordprojectsearch==false){
			$projects = Helper::query("Project", "where", ["field" => "published", "value" => 1]);
			$i=false;
			
			foreach($arrkeywords as $keyw){
				if($i == false)
				$projects->where('title_ar','like','%'.$keyw.'%');
				
				$projects->orWhere('title_ar','like','%'.$keyw.'%')->orWhere('title_en','like','%'.$keyw.'%')
						->orWhere('name_ar','like','%'.$keyw.'%')->orWhere('name_en','like','%'.$keyw.'%')
						->orWhere('intro_card_ar','like','%'.$keyw.'%')->orWhere('intro_card_en','like','%'.$keyw.'%');
				$i = true;
			}
			$projects = $projects->get();

		}
		if(($redirect == '' or $redirect == 'post') and count($posts)==0 and $multikeywordpostsearch==false){
			$posts = Helper::query("Post", "where", ["field" => "published", "value" => 1]);
			$i=false;
			
			foreach($arrkeywords as $keyw){
				if($i == false)
				$posts->where('title_ar','like','%'.$keyw.'%');
			
					$posts->where('title_ar','like','%'.$keyw.'%')->orWhere('title_en','like','%'.$keyw.'%')
							->orWhere('content_ar','like','%'.$keyw.'%')->orWhere('content_en','like','%'.$keyw.'%');		
			}
			$posts = $posts->get();
		}
		
        return view("front.searchpage", compact("projects", "posts"));*/
    }

    public function cron_crm_tasks_due_date(Request $request)
    {
		
		
		Helper::update_youtube_video_only();
		
		//update last 6 video views
		//Helper::update_youtube_video_statistcis();!!!
		
		//update crm task due_date to today
		/*if(date('H')=='01'){
			$tasks = DB::connection('mysql_crm')->select("SELECT `dms_tasks`.id
			FROM `dms_tasks`
			left join dms_leads on dms_leads.id=dms_tasks.lead
			WHERE due_date<date(now()) and closed=false and leadtype='lead'");

			$tasks_ids = [];
			foreach($tasks as $t){
				$tasks_ids[] = $t->id;
			}

			if(count($tasks_ids)>0){
				$tasks_ids = implode(',',$tasks_ids);
				//DB::connection('mysql_crm')->enableQueryLog();
				$q = DB::connection('mysql_crm')->update('update dms_tasks set due_date=? where id in('.$tasks_ids.')',[date('Y-m-d')]);			
				//print_r(DB::connection('mysql_crm')->getQueryLog());
			}
		}*/
	}
		
}