<?php
namespace App\Models;
use LaravelLocalization;
class Section extends BaseModel
{
    public $table = "sections";
    
    protected $fillable = [
        "name",
        "sectiontype_id",
        "number_items",
        "sectionposition_id",
        "lang",
        "title",
        "title_en",
        "title_fr",
        "title_ru",
        "title_fa",
        "placement",
        "background_color",
        "project_category",
        "post_category",
        "section_link",
        "device",
        "latestproject",
    ];
    
	
	
	public function getTitle()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        
		if($lang=='ar')
			$field = "title";
		else
			$field = "title_$lang";
	
        return $this->$field;
    }
	
	
    /**
    * section type relation
    *
    * @return void
    */
    public function type()
    {
        return $this->belongsTo("App\Models\SectionType", "sectiontype_id");
    }
    
    /**
    * section position relation
    *
    * @return void
    */
    public function position()
    {
        return $this->belongsTo("App\Models\SectionPosition", "sectionposition_id");
    }
    
    /**
    * section projects relation
    *
    * @return void
    */
    public function projects()
    {
        return $this->belongsToMany("App\Models\Project", "section_project");
    }
    
    /**
    * Sync section projects relation
    *
    * @param array $projects
    * @return void
    */
    public function syncProjects($projects = [])
    {
        if ( count($projects) ) {
            $this->projects()->sync($projects); return;
        }
        $this->projects()->detach();
    }
    
    
}