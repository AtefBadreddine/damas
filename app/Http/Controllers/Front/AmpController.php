<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Validator;
use Helper;
use DB;
use Mail;
use Jenssegers\Agent\Agent;

class AmpController extends BaseController
{
    
    /**
    * index
    *
    * @return view
    */
    public function index()
    {
        return view("amp.index");
    }
    
	
	
	
	
	
    /**
    * show project
    *
    * @param string $slug
    * @return void
    */
    public function project_show($slug)
    {
        $project = Helper::query("Project", "where", ["field" => "slug", "value" => $slug])->first();
        if ( !$project ) abort(404);
        if ( isset($_SERVER["HTTP_REFERER"]) ) {
            $project->views += 1; $project->save();
        }
        return view("amp.project_show", compact("project"));
    }
    
   
    /**
    * show blogpost
    *
    * @param string $slug
    * @return void
    */
    public function blog_show_post($slug)
    { //exit('rrr');
        $post = Helper::query("Post", "where", ["field" => "slug", "value" => $slug])->first();
        if ( !$post ) $post = Helper::query("Post", "where", ["field" => "old_slug", "value" => $slug])->first();
        if ( !$post ) 
			return Redirect::to(route("front.blog")); //abort(404);
        if ( isset($_SERVER["HTTP_REFERER"]) ) {
            $post->views += 1; $post->save();
        }
        return view("amp.blog.show", compact("post"));
    }
    /**
    * search
    *
    * @return voidca
    */
    public function search(Request $request, $type = null, $city = null, $var1 = null, $var2 = null)
    {        
        $paginate_number = 12;
        $hide_search_page = '';
        $inputs = $request->all();
        if ( $request->ajax() ) {
            $inputs["project_type"] = $request->get("project_type", null);
            $inputs["city"] = $request->get("city", null);
            $inputs["project_categories"] = $request->get("project_categories", []);
            $inputs["regions"] = $request->get("regions", []);
        } else {
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
                }
            }

            if ( $var2 ) {
                $q_regions = Helper::query("Region", "whereIn", ["field" => "slug", "value" => $var2])->get();
                $inputs["regions"] = $var2;
            }
            
            if ( count($q_tags) == 0 and count($var1) > 0 and count($q_regions) == 0 ) {
                abort(404);
            }
            if ( count($q_regions) == 0 and count($var2) > 0 ) {
                abort(404);
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
        $q = \App\Models\Project::where("published", 1);
        
        // project type
        if ( $inputs["project_type"] and $inputs["project_type"] != "property-for-sale" ) {
            $project_type_row = Helper::query("ProjectType", "where", ["field" => "slug", "value" => $inputs["project_type"]])->first();
            if ( !$project_type_row ) abort(404);
            $q->whereIn("id", function($q_typ) use ($project_type_row) {
                $q_typ->select("project_id")->from("project_type")->where("project_type_id", $project_type_row->id);
            });
            
            $about_title = $project_type_row->getAboutTitle();
            $about_description = $project_type_row->getAbout();
            $inputs["row"] = $project_type_row;
            // seo tags
            $seo_title = $project_type_row->getSeoTitle();
            $arr_seo_title[0] = $seo_title ? $seo_title : $project_type_row->getName();
            $arr_seo_description[0] = $project_type_row->getSeoDescription();
            $arr_seo_keywords[0] = $project_type_row->getSeoKeywords();
        }
        
        // city
        if ( $inputs["city"] /*and $inputs["city"] !== "turkey"*/ ) {
            $city_row = Helper::query("City", "where", ["field" => "slug", "value" => $inputs["city"]])->first();
            if ( !$city_row ) abort(404);
            if ( $inputs["city"] !== "turkey" ) {
                $q->where("city_id", $city_row->id);
            }
            
            $about_title = $city_row->getAboutTitle();
            $about_description = $city_row->getAbout();
            $inputs["row"] = $city_row;
            $inputs["city_row"] = $city_row;
            // seo tags
            $seo_title = $city_row->getSeoTitle();
            $arr_seo_title[0] = $seo_title ? $seo_title : $city_row->getName();
            $arr_seo_description[0] = $city_row->getSeoDescription();
            $arr_seo_keywords[0] = $city_row->getSeoKeywords();
        }
        
        // project features
        if ( $inputs["project_categories"]  or $hide_search_page != '') {
            $arr_cats = [];
			
			if($hide_search_page != ''){
				$inputs["project_categories"] = $hide_search_page;
			}
			
            foreach ($inputs["project_categories"] as $cat) {
                $project_cat_row = Helper::query("ProjectCategory", "where", ["field" => "slug", "value" => $cat])->first(); 
                if ( !$project_cat_row ) abort(404);
                $arr_cats[] = @$project_cat_row->id;

				if($hide_search_page == ''){
					$q->whereIn("id", function($q_pf) use ($project_cat_row) {
						$q_pf->select("project_id")->from("project_category")->where("project_category_id", $project_cat_row->id);
					});
				}
            }
            $link_tags = "/".implode(",", $inputs["project_categories"]);
            /*$q->whereIn("id", function($q_pf) use ($arr_cats) {
                //$q_pf->select("project_id")->from("project_category")->whereRaw("");
                $q_pf->select("project_id")->from("project_category")->whereIn("project_category_id", $arr_cats);
            });*/
            
            $about_title = @$project_cat_row->getAboutTitle();
            $about_description = @$project_cat_row->getAbout();
            $inputs["row"] = @$project_cat_row;
            // seo tags
            $seo_title = @$project_cat_row->getSeoTitle();
            $arr_seo_title[0] = $seo_title ? $seo_title : @$project_cat_row->getName();
            $arr_seo_description[0] = @$project_cat_row->getSeoDescription();
            $arr_seo_keywords[0] = @$project_cat_row->getSeoKeywords();
        }
        
        // regions
        if ( $inputs["regions"] ) {
            $arr_reg = [];
            foreach ($inputs["regions"] as $reg) {
                $region_row = Helper::query("Region", "where", ["field" => "slug", "value" => $reg])->first();
                if ( !$region_row ) abort(404);
                $arr_reg[] = @$region_row->id;
            }
            $q->whereIn("region_id", $arr_reg);            
            $link_region = "/".implode(",", $inputs["regions"]);
            
            $about_title = @$region_row->getAboutTitle();
            $about_description = @$region_row->getAbout();
            $inputs["row"] = @$region_row;
            // seo tags
            $seo_title = @$region_row->getSeoTitle();
            $arr_seo_title[0] = $seo_title ? $seo_title : @$region_row->getName();
            $arr_seo_description[0] = @$region_row->getSeoDescription();
            $arr_seo_keywords[0] = @$region_row->getSeoKeywords();
        }
        
        $link_others = [];
        // rooms
        if ( @$inputs["rooms"] ) {
            $q->whereIn("id", function($q_r) use ($inputs) {
                $q_r->select("project_id")
                    ->from("projects_flavors")
                    ->havingRaw("SUM(room+salon) >= ".$inputs["rooms"])
                    ->groupBy("project_id");
            });
            $link_others[] = "rooms=".$inputs["rooms"];
        }
        // price
        if ( @$inputs["minprice"] or @$inputs["maxprice"] ) {
            $q->whereIn("id", function($q_r) use ($inputs) {
                $q_r->select("project_id")
                    ->from("projects_flavors")
                    ->whereBetween('price_usd', [$inputs["minprice"], $inputs["maxprice"]])
                    ->groupBy("project_id");
            });
            $link_others[] = "minprice=".$inputs["minprice"];
            $link_others[] = "maxprice=".$inputs["maxprice"];
        }
        
        // about content
        $inputs["about"] = '<h1>'.$about_title.'</h1><div class="clearfix">'.$about_description.'</div>';
        
        // sorting
        $sorting = @$inputs["sorting"];
        switch ($sorting)
        {
            /*case "price":
                $q->orderBy(function($qr){
                    $qr->select("id")->from("projects_flavors");
                });
                break;*/
                
            case "views":
                $q->orderBy("views", "DESC");
                break;
                
            case "likes":
                $q->orderBy("likes", "DESC");
                break;
        
            default:
                $q->orderBy("created_at", "DESC");
                $inputs["sorting"] = "newest";
                break;
        }
        $link_others[] = "sorting=".$sorting;
        
        $link_others = count($link_others) ? ("?".implode("&", $link_others)) : null;
        $q1 = $q;
        $allprojects = $q1->get();
        if ( $request->ajax() ) {
            $url = route("amp.search")."/".$inputs["project_type"]."/".$inputs["city"].$link_tags.$link_region.$link_others;
            $projects = $q->paginate($paginate_number);
            $inputs["count"] = count($allprojects);
            return response()->json([
                "url"       =>  $url,
                "content"   =>  view('amp.partials.search_results_projects', ['projects' => $projects, "paginate_number" => $paginate_number])->render(),
                "inputs"    =>  $inputs,
                "map_projects"    =>  Helper::get_json_map_projects($allprojects),
                "latitude"    =>  (float) @$inputs["city_row"]->latitude,
                "longitude"    =>  (float) @$inputs["city_row"]->longitude,
            ]);
        } else {
            
            $req_url = str_replace("/amp", "", \LaravelLocalization::getLocalizedURL("ar"));
            $page_seo = Helper::query("PageSearch", "where", ["field" => "link", "value" => $req_url])->first();
            $current_lang = \LaravelLocalization::getCurrentLocale();
            
            if ( $page_seo ) {                
                $inputs["seo_title"] = $page_seo->getSeoTitle();
                $inputs["seo_description"] = $page_seo->getSeoDescription();
                $inputs["seo_keywords"] = $page_seo->getSeoKeywords();
                
                if ( $current_lang == 'en' ) {
                    $inputs["og_image"] = $page_seo->media_en_id ? Helper::media_url($page_seo->mediaEn) : null;
                } else {
                    $inputs["og_image"] = $page_seo->media_id ? Helper::media_url($page_seo->media) : null;                    
                }
                
                if ( $page_seo->content ) {
                    $inputs["about"] = '<h1>'.$page_seo->title.'</h1><div class="clearfix">'.$page_seo->content.'</div>';
                }
            } else {
                if ( $current_lang == 'en' ) {
                    $inputs["og_image"] = $inputs["city_row"]->media_en_id ? Helper::media_url($inputs["city_row"]->mediaEn) : null;
                } else {
                    $inputs["og_image"] = $inputs["city_row"]->media_id ? Helper::media_url($inputs["city_row"]->media) : null;                    
                }
                $inputs["seo_title"] = implode(".", $arr_seo_title);
                $inputs["seo_description"] = trim(implode(".", $arr_seo_description));
                $inputs["seo_keywords"] = trim(implode(".", $arr_seo_keywords));
            }
            
            $projects = $q->paginate($paginate_number);
        }
        
        return view("amp.search", compact("projects", "inputs", "allprojects", "paginate_number"));
    }
    
    /**
    * call us
    *
    * @return void
    */
    public function call_us(Request $request)
    {
        if ( $request->isMethod('post') ) {
            $inputs = $request->all();
            $name = $request->get("name", null);
            //$email = $request->get("email", null);
            $mobile = @$request->get("countrycode", null) . str_replace(" ", "", $request->get("mobile", null));
            $message = $request->get("message", null);
			
			if($request->get("communication_time", null)!='')
				$communication_time = $request->get("communication_time", null);
			else
				$communication_time = "Any Time";
     
            $inputs["name"] = htmlentities($name);
            $inputs["email"] = $request->get("email", null);
            $inputs["mobile"] = htmlentities($mobile);
            $inputs["message"] = htmlentities($message);
            $inputs["page"] = \URL::previous();
            $inputs["form_type"] = $request->get("form_type", null);
			$inputs["communication_time"] = $communication_time;
			

		/*if(isset($_SERVER['HTTP_CF_IPCOUNTRY']))
			$inputs["country"] = $_SERVER["HTTP_CF_IPCOUNTRY"];
		else*/
			$inputs["country"] = @session()->get("iso_country");
			
            /* Device */
            $agent = new Agent();
            if ( $agent->isMobile() ) {
                $inputs["device"] = "Mobile";
            } elseif ( $agent->isTablet() ) {
                $inputs["device"] = "Tablet";
            } else {
                $inputs["device"] = "Desktop";
            }
            
            // Source visitor
            $cookie_reffer = @$_COOKIE["reffer"];
            $coourl = parse_url($cookie_reffer);
			$inputs["src"] = "Google AMP";
            /*if ( ($cookie_reffer != str_replace('gclid=', '', $cookie_reffer)) or ($inputs["page"] != str_replace('gclid=', '', $inputs["page"])) ){
                $inputs["src"] = "Adwords";
            } else {
                $inputs["src"] = @$coourl['host'] ? $coourl['host'] : (@$coourl['path'] ? $coourl['path'] : 'دخول مباشر');
            }
            
            if ( $inputs["src"] == "دخول مباشر" ) {
                $inputs["full_src"] = "دخول مباشر";
				if(str_replace('ampproject','',$inputs["page"]) != $inputs["page"]){
					$inputs["src"] = 'www-damasturk-com.cdn.ampproject.org';
				}elseif(str_replace('fbclid','',$inputs["page"]) != $inputs["page"]){
					$inputs["src"] = 'facebook.com';
				}
            } else {
            }*/
                $inputs["full_src"] = $cookie_reffer;
            $inputs['navigation'] = Helper::clean_navigation(@$_COOKIE["navigation"]);
            // save
            $saved_message = Helper::query("Message", "save", [
                "inputs"    =>  $inputs,
            ]);

            
			
			
			
			/*
			// send mail 
            $inputs["message"] = $message;
            $inputs["email_inquiries"] = env("MAIL_INQUIRIES", "leads@damas.net");
            // send mail to admin
            Mail::send("emails.callus_admin", ["inputs" => $inputs], function ($m) use ($inputs) {
                $m->from($inputs["email"], $inputs["name"])
                    ->to($inputs["email_inquiries"])
                    ->subject("داماس العقارية - رسالة جديدة");
            });

            // send mail to user
            $params = Helper::get_params();
            if ( $params->user_email_send == 0 ) {
                $inputs["from_name"] = $params->name;
                
                //$inputs["message_content"] = str_replace(["{name}", "{email}", "{mobile}", "{message}"], [$inputs["name"], $inputs["email"], $inputs["mobile"], $inputs["message"]], nl2br($params->user_email_text));
                $inputs["message_content"] = str_replace(["{name}", "{email}", "{mobile}", "{message}", "{communication_time}", "{budget}"], [$inputs["name"], $inputs["email"], $inputs["mobile"], $inputs["message"], $inputs["communication_time"], $inputs["budget"]], nl2br($params->user_email_text));
                
                //$inputs["message_subject"] = str_replace(["{name}", "{email}", "{mobile}", "{message}"], [$inputs["name"], $inputs["email"], $inputs["mobile"], $inputs["message"]], nl2br($params->user_email_title));
                $inputs["message_subject"] = str_replace(["{name}", "{email}", "{mobile}", "{message}", "{communication_time}", "{budget}"], [$inputs["name"], $inputs["email"], $inputs["mobile"], $inputs["message"], $inputs["communication_time"], $inputs["budget"]], nl2br($params->user_email_title));
                
                Mail::send([], [], function ($m) use ($inputs) {
                    $m->from($inputs["email_inquiries"], $inputs["from_name"])
                        ->to($inputs["email"])
                        ->subject($inputs["message_subject"])
                        ->setBody($inputs["message_content"], "text/html");
                });
            }
			*/





		// ZOHO CRM insert contact
		$inputs['id'] = $saved_message->id;
		//$this->insert_crm_contact($inputs);
		//$this->zoho_insert_contact($inputs);

		session()->flash("flashmessage", null);
		session()->put("callus_success", $saved_message->id);






            $domain_url = url("/");
			
            header("Content-type: application/json");
            header("Access-Control-Allow-Credentials: true");
            header("Access-Control-Allow-Origin: ". str_replace('.', '-','https://www.damas.net') .".cdn.ampproject.org");
            header("AMP-Access-Control-Allow-Source-Origin: " . $domain_url);
            header("Access-Control-Expose-Headers: AMP-Access-Control-Allow-Source-Origin");
            header("AMP-Redirect-To: https://www.damas.net/confirmation?amp=1&page=" . $inputs['id']);
            header("Access-Control-Expose-Headers: AMP-Redirect-To, AMP-Access-Control-Allow-Source-Origin");
			echo json_encode(array('successmsg'=>'data post'));
            exit;
        }
         
    }
	
	/*
    function insert_crm_contact($inputs = [])
    {
		
		$inputs['mobile'] = str_replace("+", "", $inputs['mobile']);
		$inputs['page'] = str_replace('www-damas-net.cdn.ampproject.org/v/s/','',strtok($inputs['page'], '?'));
		$inputs['src'] = 'Google AMP';
		$inputs['country'] = Helper::code_to_country(@$inputs['country']);
		$inputs['navigation'] = strtok($inputs['navigation'], '?');
		//########### Insert to CRM ###################
		$data['name'] = $inputs['name'];
		$data['mobile'] = Helper::faTOen(str_replace(['+',' ','-','.'],'',$inputs['mobile']));
		$data['email'] = $inputs['email'];
		$data['message'] = $inputs['message'];
		$data['contact_time'] = $inputs['communication_time'];
		$data['source'] = 'Google AMP';
		$data['gadget'] = @$inputs['device'];
		$data['campaign'] = '';
		$data['target'] = '';
		$data['budget'] = @$inputs['budget'];
		$data['navigation'] = Helper::clean_navigation(@$_COOKIE["navigation"]);
		$data['country'] = $inputs['country'];
		$data['l_created_at'] = date('Y-m-d H:i');
		$data['l_updated_at'] = date('Y-m-d H:i');
		$data['l_created_by'] = 0;
		$data['l_updated_by'] = 0;
		
        $insert_crm = DB::connection('mysql_crm')->table('leads')->insert($data);
		$lead_id = DB::connection('mysql_crm')->getPdo()->lastInsertId();
		DB::table('messages')->where("id", $inputs['id'])->update(['insert_crm' => $insert_crm]);
		
		//insert task
		$task_data['task_owner'] = 0;
		$task_data['t_created_by'] = 0;
		$task_data['t_created_at'] = date('Y-m-d H:i');
		$task_data['due_date'] = date('Y-m-d');
		$task_data['task_type'] = 'Following';
		$task_data['task_name'] = 'First Call';//No Answer
		$task_data['lead'] = $lead_id;
		DB::connection('mysql_crm')->table('tasks')->insert($task_data);
		
		//insert notif
		$supervisors = Helper::getUserByRole('supervisor');
		$users=[];
		//$users[] = 0;//administrator
		foreach($supervisors as $rr)
			$users[] = $rr->id;
		Helper::add_notif('new client registered ("'.$data['name'].'")',$lead_id,'/app/leads/'.$lead_id.'/edit',$users,'green','new_lead_form');
    }
	*/
    
    /**
    * blog index
    *
    * @return void
    */
    public function blog_index()
    {
        return view("amp.blog.index");
    }
    
    
    /**
    * contact us
    *
    * @return void
    */
    public function contactus(Request $request)
    {
        return view("amp.contact_us");
    }
	
	
    /**
    * about us
    *
    * @return void
    */
    public function about_us()
    {
		//exit('zzzeez');
        $row = Helper::query("Page", "where", ["field" => "slug", "value" => "about-us"])->first();
        if ( !$row ) $row = Helper::query("Page", "new");
        return view("amp.pages.show", compact("row"));
    }

	
    /**
    * privacy
    *
    * @return void
    */
    public function privacy()
    {
        $row = Helper::query("Page", "where", ["field" => "slug", "value" => "privacy"])->first();
        if ( !$row ) $row = Helper::query("Page", "new");
        return view("amp.pages.show", compact("row"));
    }
    
    /**
    * vacancies
    *
    * @return void
    */
    public function vacancies()
    {
        $row = Helper::query("Page", "where", ["field" => "slug", "value" => "vacancies"])->first();
        if ( !$row ) $row = Helper::query("Page", "new");
		
		
            /*$agent = new Agent();
            if ( $agent->isTablet() or $agent->isMobile() ) {
				return view("front.pages.vacancies_mob", compact("row"));
            }else {*/
				return view("amp.pages.show", compact("row"));
			//}
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
        return view("amp.pages.show", compact("row"));
    }
	
	/**
    * turkish citizenship
    *
    * @return void
    */
    public function turkish_citizenship()
    {
		$page = Helper::query("Page", "where", ["field" => "slug", "value" => "turkish-citizenship"])->first();
        return view("amp.turkish_citizenship", compact("page"));
    }
	
	
    /**
    * like project
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
    
}