<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Validator;
use DB;
use Helper;
use Input;

class ProjectController extends BaseController
{
    
    /**
    * project list
    *
    * @param int $var
    * @return void
    */
    public function projects_index()
    {
		$where = [];
		if(isset($_GET['search']) && $_GET['search']!=''){
			$search = '%'.$_GET['search'].'%';
			//$where[] = [DB::raw(" name_en like $search or project_link like $search or slug like $search or payment_method like $search or intro_card_ar like $search intro_card_en or like $search ")];
			$where[] = ["name_en", "like", $search];
			$where[] = ["project_link", "like", $search];
			$where[] = ["slug", "like", $search];
			$where[] = ["payment_method", "like", $search];
			$where[] = ["intro_card_ar", "like", $search];
			$where[] = ["intro_card_en", "like", $search];
			$where[] = ["location_ar", "like", $search];
			$where[] = ["location_en", "like", $search];
			$where[] = ["intro_location_ar", "like", $search];
			$where[] = ["intro_location_en", "like", $search];
			$where[] = ["transportation_ar", "like", $search];
			$where[] = ["transportation_en", "like", $search];
			$where[] = ["future_look_ar", "like", $search];
			$where[] = ["future_look_en", "like", $search];
			
			$rows = Helper::query("Project", "paginate", $where,'or');
		}else{
        $rows = Helper::query("Project", "paginate");
        }
		return view("admin.projects.index", compact("rows"));
    }
    
    /**
    * project edit
    *
    * @param Illuminate\Http\Request $request
    * @param int $id
    * @return void
    */
    public function projects_edit(Request $request, $id = null)
    {
        $row = Helper::query("Project", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "name_ar"  =>  "required",
                "name_en"  =>  "required",
                "project_link"  =>  "required",
                "companies"  =>  "required",
                /*"salemanager_ar_id"  =>  "required",*/
                "slug"     =>  "required|alpha_dash|unique_slug_per_country:" . ($id ?: 'NULL'),
                "dms_map"     =>  "unique:{$row->table_name()},dms_map,$id",
                /*"latitude"     =>  "unique:{$row->table_name()},latitude,$id",
                "longitude"     =>  "unique:{$row->table_name()},longitude,$id",*/
                "city_id"  =>  "required",
                "old_slug"  =>  "different:slug",
            ]);
            $inputs = $request->all();
            $inputs["old_slug"] = trim((string) @$inputs["old_slug"]) ?: null;
			
			/*echo '<pre>';
			print_r($inputs);
			echo '</pre>';
			exit;*/
            $dms_map = @$inputs["dms_map"];
            if ( $dms_map ) {
                $arr_dms = preg_split("/(°|'|\"| )/", $dms_map);
                
                $lat_deg = (float) @$arr_dms[0];
                $lat_min = (float) @$arr_dms[1];
                $lat_sec = (float) @$arr_dms[2];
                
                $lng_deg = (float) @$arr_dms[4];
                $lng_min = (float) @$arr_dms[5];
                $lng_sec = (float) @$arr_dms[6];
                
                $latitude = $lat_deg + $lat_min/60 + $lat_sec/(60*60);
                $longitude = $lng_deg + $lng_min/60 + $lng_sec/(60*60);
                
                $inputs["latitude"] = $latitude;
                $inputs["longitude"] = $longitude;
            }
            //$inputs["enable_offer"] = @$inputs["enable_offer"] ? 1 : 0;
            $inputs["published"] = @$inputs["published"] ? 1 : 0;
            $inputs["featured"] = @$inputs["featured"] ? 1 : 0;
            /*$inputs["is_price_usd"] = @$inputs["is_price_usd"] ? 1 : 0;
            $inputs["buyed"] = @$inputs["buyed"] ? 1 : 0;
			*/
            
            $similar_projects = @$inputs["similar_projects"];
            $title_ar = @$inputs["title_ar"];
            $title_en = @$inputs["title_en"];
            $inputs["similar_projects"] = $similar_projects?implode(",", $similar_projects):"";
            
			/* Auto-generated Arabic name from English name + city (disabled — use name_ar from form)
			$c = Helper::query("City", "find", ['id' => $inputs["city_id"]]);
			$inputs["name_ar"] = 'مجمع '.$inputs["name_en"].' في '. @$c->getName();
			*/

			if ( !$id ) {
                $inputs["user_id"] = $request->user()->id;
                $inputs["user_name"] = $request->user()->username;
				$inputs['edit_date'] = date('Y-m-d');
            }
            $saved_project = Helper::query("Project", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
            ]);
            // types
            $saved_project->syncTypes($request->get('projecttype_id', []));
            // companies
            $saved_project->syncCompanies($request->get('companies', []));
            // categoriess
            //******$saved_project->syncCategories($request->get('category_id', []));
            // project_photos
            $saved_project->syncProjectPhotos($request->get('project_photos', []));
            // features
            $saved_project->syncFeatures($request->get('feature_id', []));
            // features
            $saved_project->syncPlanPhotos($request->get('plan_photos', []));
            // posts
            $saved_project->syncPosts($request->get('post_id', []));
            // posts en
            $saved_project->syncPostsEn($request->get('post_en_id', []));
            $saved_project->syncPostsFr($request->get('post_fr_id', []));
            
			// flavors
            /*Helper::query("ProjectFlavor", "where", ["field" => "project_id", "value" => $saved_project->id])->delete();
            $prices = $request->get("price", []);
            foreach ($prices as $k => $price) {
                //if ( !$price ) continue;
                $arr = [
                    "project_id"    =>  $saved_project->id,
                    "price"    =>  $price,
                    "price_usd"    =>  $price,
                    "offer"    =>  @$inputs["offer"][$k],
                    "room"    =>  @$inputs["room"][$k],
                    "area"    =>  @$inputs["area"][$k],
                    "salon"    =>  @$inputs["salon"][$k],
                    "observation"    =>  @$inputs["observation"][$k],
                    "observation_en"    =>  @$inputs["observation_en"][$k],
                    "date_created"    =>  @$inputs["date_created"][$k],
                    "rates_exchange"    =>  !$inputs["is_price_usd"],
                ];
                Helper::query("ProjectFlavor", "save", ['inputs' => $arr]);
			}*/
				
				/*
				UPDATE `dms_projects` SET `file_offer`=concat('media/offer/',`name_en`,'.jpg');
				UPDATE `dms_projects` SET `file_pdf`=concat('media/pdf/',`name_en`,'.pdf');
				*/
				
				
				/*
				//upload Iinfographic
				$file = $request->file('file_infographic');
				if($file!=''){
					$path = 'media/infographic/';
					$ext = $file->getClientOriginalExtension();
					$name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
					$new_name = str_slug($name).'_'.sha1(time()-5);
					$filename = $new_name.".".$ext;
					$file->move(public_path($path), $filename);
					if($saved_project->file_infographic!=''){
						if(file_exists(public_path($saved_project->file_infographic)))
						@unlink(public_path($saved_project->file_infographic));
					}
					$saved_project->file_infographic = $path . $filename;
				}
				//upload Infographic_en
				$file = $request->file('file_infographic_en');
				if($file!=''){
					$path = 'media/infographic/';
					$ext = $file->getClientOriginalExtension();
					$name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
					$new_name = str_slug($name).'_'.sha1(time()-5);
					$filename = $new_name."en.".$ext;
					$file->move(public_path($path), $filename);
					if($saved_project->file_infographic_en!=''){
						if(file_exists(public_path($saved_project->file_infographic_en)))
						@unlink(public_path($saved_project->file_infographic_en));
					}
					$saved_project->file_infographic_en = $path . $filename;
				}
				//upload Infographic_fr
				$file = $request->file('file_infographic_fr');
				if($file!=''){
					$path = 'media/infographic/';
					$ext = $file->getClientOriginalExtension();
					$name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
					$new_name = str_slug($name).'_'.sha1(time()-5);
					$filename = $new_name."fr.".$ext;
					$file->move(public_path($path), $filename);
					if($saved_project->file_infographic_fr!=''){
						if(file_exists(public_path($saved_project->file_infographic_fr)))
						@unlink(public_path($saved_project->file_infographic_fr));
					}
					$saved_project->file_infographic_fr = $path . $filename;
				}
				*/
				
				
				
				
				
				//upload Infographic
				/*$file = $request->file('file_offer');
				if($file!=''){
					$path = 'media/offer/';
					$ext = $file->getClientOriginalExtension();
					$name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
					$new_name = str_slug($name).'_'.sha1(time()-5);
					$filename = $new_name.".".$ext;
					$file->move(public_path($path), $filename);
					if($saved_project->file_offer!=''){
						if(file_exists(public_path($saved_project->file_offer)))
						@unlink(public_path($saved_project->file_offer));
					}
					$saved_project->file_offer = $path . $filename;
				}
				//upload Infographic_en
				$file = $request->file('file_offer_en');
				if($file!=''){
					$path = 'media/offer/';
					$ext = $file->getClientOriginalExtension();
					$name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
					$new_name = str_slug($name).'_'.sha1(time()-5);
					$filename = $new_name."en.".$ext;
					$file->move(public_path($path), $filename);
					if($saved_project->file_offer_en!=''){
						if(file_exists(public_path($saved_project->file_offer_en)))
						@unlink(public_path($saved_project->file_offer_en));
					}
					$saved_project->file_offer_en = $path . $filename;
				}
				//upload Infographic_fr
				$file = $request->file('file_offer_fr');
				if($file!=''){
					$path = 'media/offer/';
					$ext = $file->getClientOriginalExtension();
					$name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
					$new_name = str_slug($name).'_'.sha1(time()-5);
					$filename = $new_name."fr.".$ext;
					$file->move(public_path($path), $filename);
					if($saved_project->file_offer_fr!=''){
						if(file_exists(public_path($saved_project->file_offer_fr)))
						@unlink(public_path($saved_project->file_offer_fr));
					}
					$saved_project->file_offer_fr = $path . $filename;
				}



				if(($row->enable_offer==false and $request->get('enable_offer', null)==true)
					or ($saved_project->file_offer_fr . $saved_project->file_offer_en . $saved_project->file_offer != $row->file_offer_fr . $row->file_offer_en . $row->file_offer)
				){
					
					//insert notif
					$uconsults = Helper::getUserByRole('consultant');
					$users = [];
					foreach($uconsults as $u)
						$users[] = $u->id;

					Helper::add_notif($saved_project->name_en .' >> Offer updated','', 'https//www.damas.net/projects/'.$row->slug,$users,'blue','project_offer_update');
				}*/





				/*
				//upload pdf
				$file = $request->file('file_pdf');
				if($file!=''){
					$path = 'media/pdf/';
					$ext = $file->getClientOriginalExtension();
					$name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
					$new_name = str_slug($name).'_'.sha1(time());
					$filename = $new_name.".".$ext;
					$file->move(public_path($path), $filename);
					if($saved_project->file_pdf!=''){
						if(file_exists(public_path($saved_project->file_pdf)))
						@unlink(public_path($saved_project->file_pdf));
					}
					$saved_project->file_pdf = $path . $filename;
				}
				//upload pdf en
				$file = $request->file('file_pdf_en');
				if($file!=''){
					$path = 'media/pdf/';
					$ext = $file->getClientOriginalExtension();
					$name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
					$new_name = str_slug($name).'_'.sha1(time());
					$filename = $new_name."_en.".$ext;
					$file->move(public_path($path), $filename);
					if($saved_project->file_pdf_en!=''){
						if(file_exists(public_path($saved_project->file_pdf_en)))
						@unlink(public_path($saved_project->file_pdf_en));
					}
					$saved_project->file_pdf_en = $path . $filename;
				}
				//upload pdf fr
				$file = $request->file('file_pdf_fr');
				if($file!=''){
					$path = 'media/pdf/';
					$ext = $file->getClientOriginalExtension();
					$name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
					$new_name = str_slug($name).'_'.sha1(time());
					$filename = $new_name."_fr.".$ext;
					$file->move(public_path($path), $filename);
					if($saved_project->file_pdf_fr!=''){
						if(file_exists(public_path($saved_project->file_pdf_fr)))
						@unlink(public_path($saved_project->file_pdf_fr));
					}
					$saved_project->file_pdf_fr = $path . $filename;
				}
				*/
				
				$saved_project->save();
				
				//upload videos
				$video_titles = $request->get('video_title', []);
				//$video_titles = [];
				$files = $request->file('video', []);
				$rooms = $request->get('rooms', []);
				/*echo '<pre>';
				print_r($rooms);
				echo '</pre>';
				exit;*/
				$crm_video_id = $request->get('crm_video_id', []);
				$i = 0;
				foreach ($crm_video_id as $kvideo => $vidid) {
					$file = isset($files[$i])?$files[$i]:'';
					if($file!=''){
					$path = 'media/video/';
					$ext = $file->getClientOriginalExtension();
					$name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
					$new_name = str_slug($name).'_'.sha1(time()+$i);
					$filename = $new_name.".".$ext;
					$file->move(public_path($path), $filename);
					
					if($crm_video_id[$i]==0){//new video
						DB::table('crm_videos')->insert(['project'=>$saved_project->id,'rooms'=>str_replace(' ','',$rooms[$i]),'video_title'=>@$video_titles[$i],'video'=> $path . $filename]);
					}else{//update video
						$ovideo = DB::table('crm_videos')->where('id',$crm_video_id[$i])->first();
						if($ovideo!=false){
							if(file_exists(public_path($ovideo->video)))
								@unlink(public_path($ovideo->video));
							DB::table('crm_videos')->where('id',$crm_video_id[$i])->update(['project'=>$saved_project->id,'rooms'=>$rooms[$i],'video_title'=>@$video_titles[$i],'video'=> $path . $filename]);
						}
					}
					
					}else{//update room only
						if($crm_video_id[$i]!=0){
						//DB::enableQueryLog();
							DB::table('crm_videos')->where('id',$crm_video_id[$i])->update(['rooms'=>$rooms[$i],'video_title'=>@$video_titles[$i]]);
						/*$laQuery = DB::getQueryLog();
						print_r($laQuery);
						exit;*/
						}
					}
				$i++;
				}
				
				
				
				
				//YOUTUBE Videos
				
				DB::table('crm_videos')->where('project',$saved_project->id)->where('video','like','%youtube.com/%')->delete();
				
				$yvideos = $request->get('yvideo', []);
				$yrooms = $request->get('yrooms', []);
				$yvideo_title = $request->get('yvideo_title', []);
				$yvideo_title_en = $request->get('yvideo_title_en', []);
				$i = 0;
				foreach ($yvideos as $kvideo => $vidid) {
					DB::table('crm_videos')->insert(['project'=>$saved_project->id,'rooms'=>str_replace(' ','',$yrooms[$i]),'video'=> $yvideos[$i],'video_title'=> $yvideo_title[$i],'video_title_en'=> $yvideo_title_en[$i]]);
					$i++;
				}
				
				//exit;
            
            @Helper::rates_exchange();
            //@Helper::update_youtube_video_statistcis();
            
			
			Helper::Clear_cache([$saved_project->frontUrl()]);
			
			
            return Helper::form_redirect("admin.projects", $saved_project, $request->get('redirect_to_list', null));
        }
        $countries = Helper::query("Country", "all");
        $initialCountryId = '';
        if ($row->city_id) {
            $projectCity = Helper::query("City", "find", ['id' => $row->city_id]);
            if ($projectCity) {
                $initialCountryId = $projectCity->country_id;
            }
        }

        return view("admin.projects.edit", compact("row", "countries", "initialCountryId"));
    }
    
    /**
    * delete project
    *
    * @param int $var
    * @return void
    */
    public function projects_delete($id)
    {
		
		DB::table('project_video')->where('project_id',$id)->delete();
		DB::table('projects_details')->where('project_id',$id)->delete();
		//DB::table('post_video')->where('project_id',$id)->delete();
        return Helper::query("Project", "delete", ["id" => $id]);
    }
	
    /**
    * delete video
    *
    * @param int $var
    * @return void
    */
    public function deletevideo($id)
    {

		$vid = DB::table('crm_videos')->where('id',$id)->first();		

		if(file_exists(public_path($vid->video)))
			@unlink(public_path($vid->video));

		DB::table('crm_videos')->where('id',$id)->delete();
		
        return response()->json(['success'=>true]);
    }
    
    /**
    * features index
    *
    * @return void
    */
    public function features_index()
    {
        $rows = Helper::query("ProjectFeature", "paginate");
        return view("admin.projectfeatures.index", compact("rows"));
    }
    
    /**
    * features edit
    *
    * @return void
    */
    public function features_edit(Request $request, $id = null)
    {
        $row = Helper::query("ProjectFeature", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "name_ar"  =>  "required",
                "name_en"  =>  "required",
            ]);
            return Helper::query("ProjectFeature", "save", [
                "inputs"    =>  $request->all(),
                "id"        =>  $id,
                "route"     =>  "admin.projectfeature",
            ]);
        }
        return view("admin.projectfeatures.edit", compact("row"));
    }
    
    /**
    * delete feature
    *
    * @param int $var
    * @return void
    */
    public function feature_delete($id)
    {
        return Helper::query("ProjectFeature", "delete", ["id" => $id]);
    }
    
        /**
    * project type list
    *
    * @return void
    */
    public function projecttype_index()
    {
        $rows = Helper::query("ProjectType", "paginate");
        return view("admin.projecttype.index", compact("rows"));
    }
    
    /**
    * project type edit
    *
    * @param Illuminate\Http\Request $request
    * @param int $id
    * @return void
    */
    public function projecttype_edit(Request $request, $id = null)
    {
        
		$row = Helper::query("ProjectType", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "name_ar"  =>  "required",
                "slug"     =>  "required|alpha_dash|unique:{$row->table_name()},slug,$id",
            ]);
			
			$data = $request->all();
			$salons = $request->get('salon',[]);
			$rooms = $request->get('room',[]);
			$arr = [];
			for($i=0;$i<count($salons);$i++){
				$arr[] = ['salon'=>$salons[$i],'room'=>$rooms[$i]];
			}
			$data['pattern'] = serialize($arr);
            
			return Helper::query("ProjectType", "save", [
                "inputs"    =>  $data,
                "id"        =>  $id,
                "route"     =>  "admin.projecttype",
            ]);
        }
        return view("admin.projecttype.edit", compact("row"));
    }
    
    /**
    * project type delete
    *
    * @param int $id
    * @return void
    */
    public function projecttype_delete($id)
    {
        return Helper::query("ProjectType", "delete", ["id" => $id]);
    }


	public function introcard_edit(Request $request, $id = null)
    {
		$rows = DB::select("select * from dms_introcards order by id asc");
		
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "title_ar"  =>  "required",
            ]);
			
			
           /** $livingcat = Helper::query("Introcard", "save", [
                "inputs"    =>  $request->all(),
                "id"        =>  $id,
            ]);*/
			
				$title_ar = $request->get('title_ar', []);
				$title_en = $request->get('title_en', []);
				$title_fr = $request->get('title_fr', []);
				$title_fa = $request->get('title_fa', []);
				$title_ru = $request->get('title_ru', []);
				
				DB::table("introcards")->delete();
				for($i=0;$i<count($title_ar);$i++){
					DB::table("introcards")->insert([
						'title_ar'=>$title_ar[$i],
						'title_en'=>$title_en[$i],
						'title_fr'=>$title_fr[$i],
						'title_fa'=>$title_fa[$i],
						'title_ru'=>$title_ru[$i]
					]);
				}
				
				return redirect()->route("admin.introcard.edit");
        }
        return view("admin.introcard.edit", compact("rows"));
    }
	
	public function projectfilter_edit(Request $request, $id = null)
    {
		$rows = DB::select("select * from dms_projectfilters order by id asc");
		
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "title_ar"  =>  "required",
            ]);
			
			
           /** $livingcat = Helper::query("Introcard", "save", [
                "inputs"    =>  $request->all(),
                "id"        =>  $id,
            ]);*/
			
				$title_ar = $request->get('title_ar', []);
				$title_en = $request->get('title_en', []);
				$title_fr = $request->get('title_fr', []);
				$title_fa = $request->get('title_fa', []);
				$title_ru = $request->get('title_ru', []);
				$link = $request->get('link', []);
				
				DB::table("projectfilters")->delete();
				for($i=0;$i<count($title_ar);$i++){
					DB::table("projectfilters")->insert([
						'title_ar'=>$title_ar[$i],
						'title_en'=>$title_en[$i],
						'title_fr'=>$title_fr[$i],
						'title_fa'=>$title_fa[$i],
						'title_ru'=>$title_ru[$i],
						'link'=>$link[$i]
					]);
				}
				
				return redirect()->route("admin.projectfilter.edit");
        }
        return view("admin.projectfilter.edit", compact("rows"));
    }
	
    
    /**
    * projects categories index
    *
    * @return void
    */
    public function projectcategory_index()
    {
		$move = Input::get("move");
        if ( $move ) {
            $pos = Input::get("pos");
            $selected_row = Helper::query("ProjectCategory", "find", ["id" => Input::get("id")]);
            switch ($move)
            {
                case 'first':
                    $index = (int)$selected_row->placement;
                    $selected_row->update(["placement" => 1]);
                    Helper::query("ProjectCategory", "where", ["field" => "id", "value" => $selected_row->id, "operation" => "<>"])->where("placement", "<", $index)->update(["placement" => \DB::raw("placement+1")]);
                    break;
                    
                case 'last':
                    $index = (int)$selected_row->max("placement")+1;
                    $selected_row->update(["placement" => $index]);
                    break;
                    
                case 'up':
                    $selected_row->update(["placement" => \DB::raw("placement-1")]);
                    break;
                    
                case 'down':
                    $selected_row->update(["placement" => \DB::raw("placement+1")]);
                    break;
                    
                default:
                    /*$target_row = Helper::query("Post", "find", ["id" => $pos]);
                    $index1 = $selected_row->placement;
                    $index2 = @$target_row->placement;                    
                    $selected_row->update(["placement" => $index2]);
                    $target_row->update(["placement" => $index1]);*/
                    break;                    
            }
            return redirect()->back();
        }
        if ( !Input::get("field") )
            Input::replace(['field' => 'placement', 'sort' => 'asc']);
		
        $rows = Helper::query("ProjectCategory", "paginate");
        return view("admin.projectcategory.index", compact("rows"));
    }
    
    /**
    * project category edit
    *
    * @param Illuminate\Http\Request $request
    * @param int $id
    * @return void
    */
    public function projectcategory_edit(Request $request, $id = null)
    {
		//exit();
        $row = Helper::query("ProjectCategory", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "name_ar"  =>  "required",
                "slug"     =>  "required|alpha_dash|unique:{$row->table_name()},slug,$id",
            ]);
			$inputs = $request->all();
			$inputs["hide_search_page"] = @$inputs["hide_search_page"] ? 1 : 0;
            return Helper::query("ProjectCategory", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
                "route"     =>  "admin.projectcategory",
            ]);
        }
        return view("admin.projectcategory.edit", compact("row"));
    }
    
    /**
    * project category delete
    *
    * @param int $var
    * @return void
    */
    public function projectcategory_delete($id)
    {
        return Helper::query("ProjectCategory", "delete", ["id" => $id]);
    }
    
	
	
    /**
    * pub list
    *
    * @param int $var
    * @return void
    */
    public function pubs_index()
    {
        $rows = Helper::query("Pub", "paginate");
		return view("admin.pubs.index", compact("rows"));
    }
	/**
    * edit pub
    *
    * @param int $id
    * @return void
    */
    public function pubs_edit(Request $request, $id = null)
    {
        $row = Helper::query("Pub", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "title_ar"  =>  "required|unique:{$row->table_name()},title_ar,$id"
            ]);
            $inputs = $request->all();
			
			
			$inputs['content_ar'] = implode('#;#',$request->get('content_ar',[]));
			$inputs['content_fr'] = implode('#;#',$request->get('content_fr',[]));
			$inputs['content_fa'] = implode('#;#',$request->get('content_fa',[]));
			$inputs['content_en'] = implode('#;#',$request->get('content_en',[]));
			$inputs['content_ru'] = implode('#;#',$request->get('content_ru',[]));
			
            return Helper::query("Pub", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
                "route"     =>  "admin.pubs",
            ]);
        }
        return view("admin.pubs.edit", compact("row"));
    }
	
	
	
	
	
	/**
    * companies index
    *
    * @return void
    */
    public function companies_index()
    {
        $rows = Helper::query("Company", "paginate");
        return view("admin.companies.index", compact("rows"));
    }
    
    /**
    * edit company
    *
    * @param int $id
    * @return void
    */
    public function companies_edit(Request $request, $id = null)
    {
        $row = Helper::query("Company", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "company_name"  =>  "required|unique:{$row->table_name()},company_name,$id"
            ]);
            $inputs = $request->all();
            return Helper::query("Company", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
                "route"     =>  "admin.companies",
            ]);
        }
        return view("admin.companies.edit", compact("row"));
    }
    
    /**
    * delete company
    *
    * @param int $var
    * @return void
    */
    public function companies_delete($id)
    {
        return Helper::query("Company", "delete", ["id" => $id]);
    }
}