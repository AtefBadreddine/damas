<?php
namespace App\Models;
use LaravelLocalization;
class Video extends BaseModel
{
    public $table = "videos";
    
    protected $fillable = [
        "title",
        "slug",
        "link",
        "lang",
        "media_id",
        "show_on_media",
		
        "project_id",

		'views',
		'likes',
		'c_likes',
		'pic',
		'date_published',
		'last_update',
		'duration',
    ];

	public function getLikes()
    {
        return ($this->likes+$this->c_likes);
    }

	public function getViews()
    {
        return $this->views;
    }

    public function project()
    {
        return $this->belongsTo("App\Models\Project", "project_id");
    }
    public function photo()
    {
        return $this->belongsTo("App\Models\Media", "media_id");
    }
    public function getLinkVideo()
    {
        return $this->link;
    }
	
	/**
    * section videos relation
    *
    * @return void
    */
    public function sections()
    {
        return $this->belongsToMany("App\Models\Sectionvideo", "sectionvideo_video");
    }
	
	/**
    * Sync section sections relation
    *
    * @param array $sections
    * @return void
    */
    public function syncSections($sections = [])
    {
        if ( count($sections) ) {
            $this->sections()->sync($sections); return;
        }
        $this->sections()->detach();
    }
	
	/**
    * section videos relation
    *
    * @return void
    */
    public function projects()
    {
        return $this->belongsToMany("App\Models\Project", "project_video");
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
	
	
	/**
    * section videos relation
    *
    * @return void
    */
    public function posts()
    {
        return $this->belongsToMany("App\Models\Post", "post_video");
    }
	
	/**
    * Sync section posts relation
    *
    * @param array $posts
    * @return void
    */
    public function syncPosts($posts = [])
    {
        if ( count($posts) ) {
            $this->posts()->sync($posts); return;
        }
        $this->posts()->detach();
    }
}