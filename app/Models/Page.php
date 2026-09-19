<?php
namespace App\Models;
use LaravelLocalization;
class Page extends BaseModel
{
    public $table = "pages";
    
    protected $fillable = [
        "name",
        "media_id",
        "media_id_en",
        "media_id_fa",
        "slug",
        "title_ar",
        "title_en",
        "title_fa",
        "content_ar",
        "content_en",
        "content_fa",
        "seo_title_ar",
        "seo_description_ar",
        "seo_keywords_ar",
        "seo_title_en",
        "seo_description_en",
        "seo_keywords_en",
        "seo_title_fa",
        "seo_description_fa",
        "seo_keywords_fa",
        "nationality_decision1_media",
        "nationality_decision1_trans",
        "nationality_decision2_media",
        "nationality_decision2_trans",
        "nationality_decision3_media",
        "nationality_decision3_trans",
        "nationality_decision4_media",
        "nationality_decision4_trans",
        /*
		"steps_progress_nationality1",
        "steps_progress_nationality2",
        "steps_progress_nationality3",
        "steps_progress_nationality1_en",
        "steps_progress_nationality2_en",
        "steps_progress_nationality3_en",
        "steps_progress_nationality1_fa",
        "steps_progress_nationality2_fa",
        "steps_progress_nationality3_fa",
        "steps_progress_nationality1_fr",
        "steps_progress_nationality2_fr",
        "steps_progress_nationality3_fr",
        "steps_progress_nationality1_ru",
        "steps_progress_nationality2_ru",
        "steps_progress_nationality3_ru",
        */
		"published",
        "pos",
		"about_ar",
		"about_en",
		"about_fa",
		
		"niche_ar",
		"niche_en",
		"niche_fa",
		
		"vision_ar",
		"vision_en",
		"vision_fa",
		
		"about_fr",
        "content_fr",
        "title_fr",
        "media_id_fr",
        "seo_title_fr",
        "seo_description_fr",
        "seo_keywords_fr",
		"niche_fr",
		"vision_fr",
		
		"about_ru",
        "content_ru",
        "title_ru",
        "media_id_ru",
        "seo_title_ru",
        "seo_description_ru",
        "seo_keywords_ru",
		"niche_ru",
		"vision_ru",
		"post_id",
    ];
	/*
	public function getPost()
    {
		return $this->belongsTo("App\Models\Post", "post_id");
    }*/
    
    /**
    * media
    *
    * @return void
    */
    public function media()
    {
        return $this->belongsTo("App\Models\Media", "media_id");
    }
	
    public function getMediaId()
    {
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
		if($lang=='ar')
			$field = "media_id";
		else
			$field = "media_id_$lang";
        
		if($this->$field!='')
			return $this->$field;
		else
			return $this->media_id;
    }
    public function nationalitydecisionmedia1()
    {
        return $this->belongsTo("App\Models\Media", "nationality_decision1_media");
    }
    public function nationalitydecisionmedia2()
    {
        return $this->belongsTo("App\Models\Media", "nationality_decision2_media");
    }
    public function nationalitydecisionmedia3()
    {
        return $this->belongsTo("App\Models\Media", "nationality_decision3_media");
    }
    public function nationalitydecisionmedia4()
    {
        return $this->belongsTo("App\Models\Media", "nationality_decision4_media");
    }
    
	
	
    /**
    * projects
    *
    * @return void
    */
    public function projects()
    {
        return $this->belongsToMany("App\Models\Project", "page_project");
    }
    
    /**
    * Sync page projects
    *
    * @param array $categories
    * @return void
    */
    public function syncProjects($projects = [])
    {
        if ( count($projects) ) {
            $this->projects()->sync($projects); return;
        }
        $this->projects()->detach();
    }
	
/*
    public function projects2()
    {
        return $this->belongsToMany("App\Models\Project", "page_project2");
    }
    

    public function syncProjects2($projects = [])
    {
        if ( count($projects) ) {
            $this->projects2()->sync($projects); return;
        }
        $this->projects2()->detach();
    }
    */
	
	
	/**
    * translate
    *
    * @return void
    */
	public function seo_title()
    {
		
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        if($lang=='ar'){
			if($this->seo_title_ar!='')
				return $this->seo_title_ar;
			else
				return $this->name_ar;	
		}else{
			$field = 'seo_title_'.$lang;
			if($this->$field!=''){
				return $this->$field;
			}else{
				$field = 'name_'.$lang;
				return $this->$field;
				}
		}
    }
	public function seo_description()
	{
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "seo_description_$lang";
        return $this->$field;
	}
	public function about()
	{
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "about_$lang";
        return $this->$field;
	}
	public function niche()
	{
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "niche_$lang";
        return $this->$field;
	}
	public function vision()
	{
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "vision_$lang";
        return $this->$field;
	}
	
	public function getSteps_progress_nationality1()
	{
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
		if($lang=='ar')
			$lang = '';
		else
			$lang = '_'.$lang;
		
        $field = "steps_progress_nationality1$lang";
        return $this->$field;
	}
	public function getSteps_progress_nationality2()
	{
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
		if($lang=='ar')
			$lang = '';
		else
			$lang = '_'.$lang;
		
        $field = "steps_progress_nationality2$lang";
        return $this->$field;
	}
	public function getSteps_progress_nationality3()
	{
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
		if($lang=='ar')
			$lang = '';
		else
			$lang = '_'.$lang;
		
        $field = "steps_progress_nationality3$lang";
        return $this->$field;
	}
	
	
	
	public function getTitleP($lang='')
    {
		$belong_post = $this->belongsTo("App\Models\Post", "post_id")->first();
		if($belong_post!=false){
			return $belong_post->getCustomPost()['title'];
		}

        return '';
    }
    public function getDescriptionP($lang='')
    {
		$belong_post = $this->belongsTo("App\Models\Post", "post_id")->first();
		if($belong_post!=false){
			return $belong_post->getCustomPost()['content'];
		}
		return '';
    }
}