<?php 
namespace App\Models;

class BlogSection extends BaseModel
{
    public $table = "blog_sections";
    
    protected $fillable = [
        "title_ar",
        "title_en",
        "title_fr",
        "title_ru",
        "title_fa",
        "show_title",
        "lang",
        "model",
        "content_type",
        "content_display",
        "category_id",
        "number_items",
        "placement",
        "section_position",
    ];
    
    /**
    * section posts relation
    *
    * @return void
    */
    public function posts()
    {
        return $this->belongsToMany("App\Models\Post", "blog_section_post")->orderBy("placement");
    }
    
    /**
    * Sync section posts relation
    *
    * @param array $projects
    * @return void
    */
    public function syncSectionPosts($posts = [])
    {
        if ( count($posts) ) {
            $this->posts()->sync($posts); return;
        }
        $this->posts()->detach();
    }
    
    /**
    * section projects relation
    *
    * @return void
    */
    public function projects()
    {
        return $this->belongsToMany("App\Models\Project", "blog_section_project");
    }
    
    /**
    * Sync section projects relation
    *
    * @param array $projects
    * @return void
    */
    public function syncSectionProjects($projects = [])
    {
        if ( count($projects) ) {
            $this->projects()->sync($projects); return;
        }
        $this->projects()->detach();
    }
}
