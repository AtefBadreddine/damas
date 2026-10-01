<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Validator;
use Helper;
use DB;

class ApparenceController extends BaseController
{
    
    /**
    * menus
    *
    * @return void
    */
    public function menus(Request $request, $id = null)
    {
        $menu = Helper::query("Menu", "find", ["id" => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "title_ar" =>  "required",
                "link_type" =>  "required",
            ]);
            $inputs = $request->all();
            $inputs["parent_id"] = @$inputs["parent_id"] ? $inputs["parent_id"] : 0;
            $link_type = @$inputs["link_type"];
            $link_value = @$inputs["link_value"];
            if ( $link_type != "url" ) {
                $inputs["link"] = Helper::get_link_url($link_type, $link_value);
            }
            $inputs["link_en"] = str_replace("damas.net", "damas.net/en", $inputs["link"]);
            $inputs["link_fr"] = str_replace("damas.net", "damas.net/fr", $inputs["link"]);
            Helper::query("Menu", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
            ]);
            return redirect()->back();
        }
        return view("admin.apparence.menus", compact("menu"));
    }
    
    /**
    * delete menu
    *
    * @param int $id
    * @return void
    */
    public function menus_delete($id)
    {
        return Helper::query("Menu", "delete", ["id" => $id]);
    }
    
    /**
    * sliders list
    *
    * @return void
    */
    public function sliders()
    {
        $rows = Helper::query("Slider", "paginate");
        return view("admin.apparence.sliders", compact("rows"));
    }
    
    /**
    * edit slider
    *
    * @param int $var
    * @return void
    */
    public function sliders_edit(Request $request, $id = null)
    {
        $row = Helper::query("Slider", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            
            if ( $request->ajax() ) {
                $act = $request->get("action");
                $field = "video_".$request->get("field");
                if ( $act == "deletevideo" ) {
                    $vdo = $row->$field;
                    $row->update(["$field" => null]);
                    $videopath = public_path("videos/$vdo");
                    @unlink($videopath);
                    
                    return null;
                }
            }
            
            $this->validate($request, [
                "name"  =>  "required",
                "lang"  =>  "required",
            ]);
            $inputs = $request->all();
            
            $path = "videos/";
            $video_desktop = $request->file("video_desktop", null);
            $video_mobile = $request->file("video_mobile", null);
            if ( $video_desktop ) {
                $name = pathinfo($video_desktop->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = str_slug($name).'-'.time().".mp4";
                $video_desktop->move(public_path($path), $filename);
                $inputs["video_desktop"] = $filename;
            }
            if ( $video_mobile ) {
                $name = pathinfo($video_mobile->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = str_slug($name).'-'.time().".mp4";
                $video_mobile->move(public_path($path), $filename);
                $inputs["video_mobile"] = $filename;
            }
            
            return Helper::query("Slider", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
                "route"     =>  "admin.apparence.sliders",
            ]);
        }
        return view("admin.apparence.sliders_edit", compact("row"));
    }
    
    /**
    * delete slider
    *
    * @param int $var
    * @return void
    */
    public function sliders_delete($id)
    {
        $row = Helper::query("Slider", "find", ["id" => $id]);
        if ( $row->video_desktop ) {
            $videopath = public_path("videos/$row->video_desktop");
            @unlink($videopath);
        }
        if ( $row->video_mobile ) {
            $videopath = public_path("videos/$row->video_mobile");
            @unlink($videopath);
        }
        return Helper::query("Slider", "delete", ["id" => $id]);
    }
    
    /**
    * sectionvideos list
    *
    * @return void
    */
    public function sectionvideos()
    {
        $rows = Helper::query("Sectionvideo", "paginate");
        return view("admin.apparence.sectionvideos", compact("rows"));
    }
    
    /**
    * edit sectionvideo
    *
    * @param int $id
    * @return void
    */
    public function sectionvideos_edit(Request $request, $id = null)
    {
		//exit('secvedit');
        $row = Helper::query("Sectionvideo", "find", ['id' => $id]);
        
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "title_ar"  =>  "required",
            ]);
            $inputs = $request->all();

            $saved = Helper::query("Sectionvideo", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
            ]);
            $videos = $request->get('videos', []);
            //$position = $saved->position;
            //$saved->syncVideos($videos);

            return Helper::form_redirect("admin.apparence.sectionvideos", $saved, $request->get('redirect_to_list', null));
        }
        return view("admin.apparence.sectionvideos_edit", compact("row"));
    }
    
    /**
    * delete sectionvideo
    *
    * @param int $id
    * @return void
    */
    public function sectionvideos_delete($id)
    {
        return Helper::query("Sectionvideo", "delete", ["id" => $id]);
    }
	
	
	
	
	
    /**
    * sections list
    *
    * @return void
    */
    public function sections()
    {
        $rows = Helper::query("Section", "paginate");
        return view("admin.apparence.sections", compact("rows"));
    }
    
    /**
    * edit section
    *
    * @param int $id
    * @return void
    */
    public function sections_edit(Request $request, $id = null)
    {
        $row = Helper::query("Section", "find", ['id' => $id]);
        
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "title"  =>  "required",
                "title_en"  =>  "required",
                "sectiontype_id"  =>  "required",
                "sectionposition_id"  =>  "required",
                //"lang"  =>  "required",
            ]);
            $inputs = $request->all();
            
            
			/*echo '<pre>';
			print_r($inputs);
			echo '</pre>';
			exit;*/
			$inputs['latestproject'] = (isset($inputs['latestproject'])?true:false);
            $saved = Helper::query("Section", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
                //"route"     =>  "admin.apparence.sections",
            ]);
            $projects = $request->get('projects', []);
            $position = $saved->position;
            
            $type = $saved->type;
            if ( $position->slug == "featured_projects" and !$id ) {
                $projects = Helper::query("Project", "where", ["field" => "featured", "value" => 1])->limit($saved->number_items)->lists("id")->toArray();
            }
            $saved->syncProjects($projects);

            return Helper::form_redirect("admin.apparence.sections", $saved, $request->get('redirect_to_list', null));
        }
        return view("admin.apparence.sections_edit", compact("row"));
    }
    
    /**
    * delete section
    *
    * @param int $id
    * @return void
    */
    public function sections_delete($id)
    {
        return Helper::query("Section", "delete", ["id" => $id]);
    }
    
    /**
    * footer
    *
    * @return void
    */
    public function footer(Request $request, $id = null, $action = null)
    {
        $menu = Helper::query("FooterLink", "find", ["id" => $id]);
        if ( $request->isMethod('post') ) {
			
            if(isset($_POST['save_projs'])){
				
				
				DB::table('fotterprojects')->where('id','>',0)->delete();
				
				$posted = $request->get('projects_id', array());
				$homeIds = isset($posted['home']) ? (array) $posted['home'] : array();
				foreach ($homeIds as $pid) {
					if (!$pid) {
						continue;
					}
					Helper::query("Fotterproject", "save", array(
						"inputs" => array(
							'project_id' => $pid,
							'country_id' => null,
						),
					));
				}
				foreach (Helper::query("Country", "all") as $country) {
					$ids = isset($posted[$country->id]) ? (array) $posted[$country->id] : array();
					foreach ($ids as $pid) {
						if (!$pid) {
							continue;
						}
						Helper::query("Fotterproject", "save", array(
							"inputs" => array(
								'project_id' => $pid,
								'country_id' => $country->id,
							),
						));
					}
				}
				
				
			}else{
				$countryId = $request->get('country_id');
				$countryId = ($countryId === null || $countryId === '') ? null : (int) $countryId;
				$rules = [
					"title_ar" =>  "required",
					"link_type" =>  "required",
				];
				if ($countryId !== null) {
					$rules["country_id"] = "integer";
				}
				$this->validate($request, $rules);
				$inputs = $request->all();
				unset($inputs['country']);
				$inputs['country_id'] = $countryId;
				
				$inputs["parent_id"] = @$inputs["parent_id"] ? $inputs["parent_id"] : 0;
				$link_type = @$inputs["link_type"];
				$link_value = @$inputs["link_value"];
				if ( $link_type != "url" ) {
					$inputs["link"] = Helper::get_link_url($link_type, $link_value);
				}
				
				Helper::query("FooterLink", "save", [
					"inputs"    =>  $inputs,
					"id"        =>  $id,
				]);
			}
            return redirect()->route("admin.apparence.footer");
        }
        return view("admin.apparence.footer", compact("menu"));
    }
    
    /**
    * delete links footer
    *
    * @param int $var
    * @return void
    */
    public function footer_link_delete($id)
    {
        Helper::query("FooterLink", "delete", ["id" => $id]);
        return redirect()->route("admin.apparence.footer");
    }
    
}