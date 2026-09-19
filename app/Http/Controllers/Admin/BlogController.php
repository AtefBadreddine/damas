<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Validator;
use Helper;
use Input;

class BlogController extends BaseController
{
    
    
    
    /**
    * blog params
    *
    * @return void
    */
    public function params(Request $request)
    {
		$type = Helper::container_array(\Route::currentRouteName(), ['admin.news'])?'news':'blog';//.post
        
		$row = Helper::query("BlogParam", "find", ["id" => ($type=='blog')?1:2]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "title_ar"  =>  "required",
                "title_en"  =>  "required",
            ]);
            $inputs = $request->all();
            $saved =  Helper::query("BlogParam", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $row->id,
            ]);
            return redirect()->back();
        }
        return view("admin.blog.params", compact("row","type"));
    }
    
	/**
    * blog params
    *
    * @return void
    */
    public function paramsOman(Request $request)
    {
		$type = Helper::container_array(\Route::currentRouteName(), ['admin.news'])?'news':'blog';//.post
        
		$row = Helper::query("BlogParam", "find", ["id" => 3]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "title_ar"  =>  "required",
                "title_en"  =>  "required",
            ]);
            $inputs = $request->all();
            $saved =  Helper::query("BlogParam", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $row->id,
            ]);
            return redirect()->back();
        }
        return view("admin.blog.params", compact("row","type"));
    }
    
    /**
    * blog params
    *
    * @return void
    */
    public function paramsSyria(Request $request)
    {
		$type = Helper::container_array(\Route::currentRouteName(), ['admin.news'])?'news':'blog';//.post
        
		$row = Helper::query("BlogParam", "find", ["id" => 4]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "title_ar"  =>  "required",
                "title_en"  =>  "required",
            ]);
            $inputs = $request->all();
            $saved =  Helper::query("BlogParam", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $row->id,
            ]);
            return redirect()->back();
        }
        return view("admin.blog.params", compact("row","type"));
    }
	
	public function fpost_edit(Request $request, $id = null)
    {
		$row = Helper::query("BlogParam", "find", ["id" => 1]);
		
		$rows = [];
		if($row->featured_post!='')
		$rows = explode(',',$row->featured_post);
		
		
		
		$row = Helper::query("BlogParam", "find", ["id" => 3]);
		
		$rows_om = [];
		if($row->featured_post!='')
		$rows_om = explode(',',$row->featured_post);
        
        
        
		if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "fposts"  =>  "required",
            ]);
			
			
           Helper::query("BlogParam", "save", [
				"inputs"    =>  ['featured_post' =>  implode(',',$request->get('fposts',[]))],
                "id"        =>  1,
            ]);
            
            Helper::query("BlogParam", "save", [
				"inputs"    =>  ['featured_post' =>  implode(',',$request->get('fposts_om',[]))],
                "id"        =>  3,
            ]);
			
			
			return redirect()->route("admin.fpost.edit");
        }
        return view("admin.fpost.edit", compact("rows","rows_om"));
    }
    /**
    * sections
    *
    * @return void
    */
    public function sections()
    {
        $rows = Helper::query("BlogSection", "paginate");
        return view("admin.blog.sections_index", compact("rows"));
    }
    
    /**
    * edit section
    *
    * @param int $var
    * @return void
    */
    public function sections_edit(Request $request, $id = null)
    {
        $row = Helper::query("BlogSection", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "title_ar"  =>  "required",
            ]);
            $inputs = $request->all();
            $inputs["show_title"] = @$inputs["show_title"] ? 1 : 0;
            $saved =  Helper::query("BlogSection", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
            ]);
            
            // selected posts
            $saved->syncSectionPosts($request->get('posts_selected', []));
            // selected projects
            $saved->syncSectionProjects($request->get('projects_selected', []));
            
            return Helper::form_redirect("admin.blog.sections", $saved, $request->get('redirect_to_list', null));
        }
        return view("admin.blog.sections_edit", compact("row"));
    }
    
    /**
    * delete section
    *
    * @param int $var
    * @return void
    */
    public function sections_delete($id)
    {
        return Helper::query("BlogSection", "delete", ["id" => $id]);
    }
    
    /**
    * list
    *
    * @return void
    */
    public function index()
    {
        $type = Helper::container_array(\Route::currentRouteName(), ['admin.news']) ? 'news' : 'blog';
        $tab = Input::get('tab', 'turkey');
    
        $move = Input::get("move");
    
        if ($move) {
            $pos = Input::get("pos");
            $selected_row = Helper::query("Post", "find", ["id" => Input::get("id")]);
    
            switch ($move)
            {
                case 'first':
                    $index = $selected_row->placement;
                    $selected_row->update(["placement" => 1]);
                    Helper::query("Post", "where", [
                        "field" => "id",
                        "value" => $selected_row->id,
                        "operation" => "<>"
                    ])->where("placement", "<", $index)
                      ->update(["placement" => \DB::raw("placement+1")]);
                    break;
    
                case 'last':
                    $index = $selected_row->max("placement") + 1;
                    $selected_row->update(["placement" => $index]);
                    break;
    
                case 'up':
                    $selected_row->update(["placement" => \DB::raw("placement-1")]);
                    break;
    
                case 'down':
                    $selected_row->update(["placement" => \DB::raw("placement+1")]);
                    break;
            }
    
            return redirect()->back();
        }
        
        $turkeyCount = Helper::query("Post", "where", [
            "field" => "type",
            "value" => $type
        ])->where('published', 1)
          ->where('country', 'turkey')
          ->count();
        
        $omanCount = Helper::query("Post", "where", [
            "field" => "type",
            "value" => $type
        ])->where('published', 1)
          ->where('country', 'oman')
          ->count();
        
        $disabledCount = Helper::query("Post", "where", [
            "field" => "type",
            "value" => $type
        ])->where('published', 0)
          ->count();
    
        if (!Input::get("field")) {
            Input::merge([
                'field' => 'placement',
                'sort' => 'asc'
            ]);
        }
    
        $field = Input::get("field") ? Input::get("field") : "updated_at";
        $sort = in_array(Input::get("sort"), ["asc", "desc"])
            ? Input::get("sort")
            : "desc";
    
        $query = Helper::query("Post", "where", [
            "field" => "type",
            "value" => $type
        ]);
    
        if ($tab == 'turkey') {
            $query->where('published', 1)
                  ->where('country', 'turkey');
        } elseif ($tab == 'oman') {
            $query->where('published', 1)
                  ->where('country', 'oman');
        } elseif ($tab == 'disabled') {
            $query->where('published', 0);
        }
    
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $search = '%' . $_GET['search'] . '%';
    
            $query->where(function($q) use ($search) {
                $q->where("title_ar", "like", $search)
                  ->orWhere("title_en", "like", $search)
                  ->orWhere("title_fr", "like", $search)
                  ->orWhere("title_fa", "like", $search)
                  ->orWhere("title_ru", "like", $search)
                  ->orWhere("content_ar", "like", $search)
                  ->orWhere("content_en", "like", $search)
                  ->orWhere("content_fr", "like", $search)
                  ->orWhere("content_fa", "like", $search)
                  ->orWhere("content_ru", "like", $search);
            });
        }
    
        $rows = $query
            ->orderBy($field, $sort)
            ->paginate(Helper::ajax_change_paginate_number());
    
        return view("admin.blog.index", compact(
            "rows",
            "type",
            "tab",
            "turkeyCount",
            "omanCount",
            "disabledCount"
        ));
    }
    public function nofollow($html, $skip = null) {
	//$html = html_entity_decode($html);
    return preg_replace_callback(
        "#(<a[^>]+?)>#is", function ($mach) use ($skip) {
            return (
                !($skip && strpos($mach[1], $skip) !== false) &&
                strpos($mach[1], 'rel=') === false
            ) ? $mach[1] . ' rel="nofollow">' : $mach[0];
        },
        $html
    );
	}
    /**
    * edit
    *
    * @return void
    */
//     public function edit(Request $request, $id = null)
//     {
// 		$type = Helper::container_array(\Route::currentRouteName(), ['admin.news'])?'news':'blog';//.post
		
//         $row = Helper::query("Post", "find", ['id' => $id]);
//         if ( $request->isMethod('post') ) {
//             \Log::info('BLOG EDIT: before validation');
//             $this->validate($request, [
//                 /*"title_ar"  =>  "required",*/
//                 "slug"     =>  "alpha_dash|unique:{$row->table_name()},slug,$id",
//                 //"content_ar"  =>  "required",
//             ]);
//             \Log::info('BLOG EDIT: after validation');
    public function edit(Request $request, $id = null)
    {
        \Log::info(
            'BLOG DEBUG 001: edit() ENTERED | METHOD=' . $request->method()
        );
    
        $type = Helper::container_array(
            \Route::currentRouteName(),
            ['admin.news']
        ) ? 'news' : 'blog';
    
        \Log::info('BLOG DEBUG 002: TYPE CALCULATED');
    
        $row = Helper::query("Post", "find", ['id' => $id]);
    
        \Log::info('BLOG DEBUG 003: POST FIND COMPLETED');
        \Log::info('BLOG DEBUG 003.5: BEFORE METHOD CHECK');
        \Log::info('BLOG DEBUG 003.5: METHOD = ' . $request->method());
    
        if ($request->isMethod('post')) {
    
            \Log::info('BLOG DEBUG 004: POST BRANCH ENTERED');
    
            \Log::info('BLOG DEBUG 005: BEFORE VALIDATION');
    
            $this->validate($request, [
                "slug" => "alpha_dash|unique:{$row->table_name()},slug,$id",
            ]);
    
            \Log::info('BLOG DEBUG 006: AFTER VALIDATION');
            \Log::info('BLOG DEBUG 007: BEFORE REQUEST ALL');

            $inputs = $request->all();
            
            \Log::info('BLOG DEBUG 008: AFTER REQUEST ALL');
            
            \Log::info('BLOG DEBUG 009: BEFORE CONTENT_AR NOFOLLOW');
            
            $inputs["content_ar"] = htmlentities(
                $this->nofollow($inputs["content_ar"], 'damas.net')
            );
            
            \Log::info('BLOG DEBUG 010: AFTER CONTENT_AR NOFOLLOW');
            
            \Log::info('BLOG DEBUG 011: BEFORE CONTENT_EN NOFOLLOW');
            
            $inputs["content_en"] = htmlentities(
                $this->nofollow($inputs["content_en"], 'damas.net')
            );
            
            \Log::info('BLOG DEBUG 012: AFTER CONTENT_EN NOFOLLOW');
            $inputs["published"] = @$inputs["published"] ? 1 : 0;
            $inputs["post_scheduling"] = @$inputs["post_scheduling"] ? 1 : 0;
			if($inputs["post_scheduling"]==0)
				$inputs["post_scheduling_date"] = null;
			
			if($inputs["published"]==1){
				$inputs["post_scheduling"] = 0;
				$inputs["post_scheduling_date"] = null;
            }
			$inputs["with_projects_blog"] = @$inputs["with_projects_blog"] ? 1 : 0;
			
			
			if($inputs["slug"]==''){
				$inputs["published"] = 0;
			}
			
            $similar_posts = @$inputs["similar_posts"];
            $inputs["similar_posts"] = $similar_posts?implode(",", $similar_posts):"";
			
			$inputs["update_date"] = date('Y-m-d H:i');
            if ( !$id ) {
                $inputs["user_id"] = $request->user()->id;
                $inputs["user_name"] = $request->user()->username;
                $inputs["placement"] = 1;
				
				$inputs["update_date"] = date('Y-m-d H:i');
				$inputs["update_by"] = $request->user()->id;
            }else{
				$inputs["update_by"] = $request->user()->id;
				$inputs["update_by_name"] = $request->user()->username;
			}
            $saved_post = Helper::query("Post", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
            ]);
			
			
			
            
            if ( !$id ) {
                Helper::query("Post", "where", ["field" => "id", "value" => $saved_post->id, "operation" => "<>"])
                    ->update(["placement" => \DB::raw('placement+1')]);
            }
            
            // categories
            $saved_post->syncCategories($request->get('category_id', []));
            // categories
            $saved_post->syncTags($request->get('tag_id', []));
            // projects
            $saved_post->syncProjects($request->get('project_id', []));
            //$saved_post->syncPosts($request->get('post_id', []));
            
			
			
			$urls_cache[] = route('front.'.$type.'.post',[$saved_post->slug]);
			$urls_cache[] = route('front.'.$type);
			Helper::Clear_cache($urls_cache);
			
			
            return Helper::form_redirect("admin.".$type.".posts", $saved_post, @$inputs['redirect_to_list']);
        }
        \Log::info('BLOG DEBUG 100: RETURNING EDIT VIEW');
        $countries = Helper::query("Country", "all");
        return view("admin.blog.edit", compact("row","type","countries"));
    }
    
    /**
    * delete post
    *
    * @param int $var
    * @return void
    */
    public function delete($id)
    {
        return Helper::query("Post", "delete", ["id" => $id]);
    }
    
    /**
    * categories index
    *
    * @return void
    */
    public function categories()
    {
		$type = Helper::container_array(\Route::currentRouteName(), ['admin.news'])?'news':'blog';//.post
		
		
		
		
		$move = Input::get("move");
        if ( $move ) {
            $pos = Input::get("pos");
            $selected_row = Helper::query("PostCategory", "find", ["id" => Input::get("id")]);
            switch ($move)
            {
                case 'first':
                    $index = $selected_row->placement;
                    $selected_row->update(["placement" => 1]);
                    Helper::query("PostCategory", "where", ["field" => "id", "value" => $selected_row->id, "operation" => "<>"])->where("placement", "<", $index)->update(["placement" => \DB::raw("placement+1")]);
                    break;
                    
                case 'last':
                    $index = $selected_row->max("placement")+1;
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
		
		
		
		$field = Input::get("field") ? Input::get("field") : "updated_at";
			$sort = in_array(Input::get("sort"), ["asc", "desc"]) ? Input::get("sort") : "desc";
			//$rows = $q->orderBy("$field", "$sort")
		
		$rows = Helper::query("PostCategory", "where", ["field" => "type", "value" => $type])->orderBy("$field", "$sort")
			//->orderBy(@$_GET['field'], @$_GET['sort'])
			->paginate(Helper::ajax_change_paginate_number());
			
        //$rows = Helper::query("PostCategory", "paginate");
        return view("admin.blog.category_index", compact("rows","type"));
    }
    
    /**
    * edit category
    *
    * @param int $id
    * @return void
    */
    public function categories_edit(Request $request, $id = null)
    {
		$type = Helper::container_array(\Route::currentRouteName(), ['admin.news'])?'news':'blog';//.post
        $row = Helper::query("PostCategory", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "name_ar"  =>  "required",
                "slug"     =>  "required|alpha_dash|unique:{$row->table_name()},slug,$id",
            ]);
            $inputs = $request->all();
            return Helper::query("PostCategory", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
                "route"     =>  "admin.".$type.".categories",
            ]);
        }
        return view("admin.blog.category_edit", compact("row","type"));
    }
    
    /**
    * delete category
    *
    * @param int $var
    * @return void
    */
    public function categories_delete($id)
    {
		
        return Helper::query("PostCategory", "delete", ["id" => $id]);
    }
	
	
	
	/**
    * tags index
    *
    * @return void
    */
    public function tags()
    {
		$type = Helper::container_array(\Route::currentRouteName(), ['admin.news'])?'news':'blog';//.post
		
		$rows = Helper::query("Tag", "where", ["field" => "type", "value" => $type])
			//->orderBy(@$_GET['field'], @$_GET['sort'])
			->paginate(Helper::ajax_change_paginate_number());
        //$rows = Helper::query("Tag", "paginate");
        return view("admin.blog.tag_index", compact("rows"));
    }
    
    /**
    * edit tag
    *
    * @param int $id
    * @return void
    */
    public function tags_edit(Request $request, $id = null)
    {
		$type = Helper::container_array(\Route::currentRouteName(), ['admin.news'])?'news':'blog';//.post
        
		
		$row = Helper::query("Tag", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "slug"     =>  "required|alpha_dash|unique:{$row->table_name()},slug,$id",
            ]);
            $inputs = $request->all();
            return Helper::query("Tag", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
                "route"     =>  "admin.".$type.".tags",
            ]);
        }
        return view("admin.blog.tag_edit", compact("row","type"));
    }
    
    /**
    * delete tag
    *
    * @param int $var
    * @return void
    */
    public function tags_delete($id)
    {
        return Helper::query("Tag", "delete", ["id" => $id]);
    }
    
}