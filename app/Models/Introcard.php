<?php
namespace App\Models;
use LaravelLocalization;
use Nicolaslopezj\Searchable\SearchableTrait;

class Introcard extends BaseModel
{
    use SearchableTrait;
    public $table = "introcards";
    
    protected $fillable = [
        "title_ar",
        "title_en",
        "title_fr",
        "title_ru",
        "title_fa",
    ];
    
    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'posts.title_ar' => 5,
            'posts.title_en' => 5,
        ]
    ];
    
    /**
    * user
    *
    * @return void
    */
    public function user()
    {
        return $this->belongsTo("App\Models\User", "user_id");
    }
    
    /**
    * media
    *
    * @return void
    */
    public function photoCard()
    {
        return $this->belongsTo("App\Models\Media", "media_id");
    }
    
    /**
    * categories
    *
    * @return void
    */
    public function categories()
    {
        return $this->belongsToMany("App\Models\PostCategory", "post_category");
    }
	
   
    
    /**
    * Sync post categories
    *
    * @param array $categories
    * @return void
    */
    public function syncCategories($categories = [])
    {
        if ( count($categories) ) {
            $this->categories()->sync($categories); return;
        }
        $this->categories()->detach();
    }
    
    /**
    * projects
    *
    * @return void
    */
    public function projects()
    {
        return $this->belongsToMany("App\Models\Project", "post_project");
    }
    
    /**
    * Sync post projects
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




	/**
    * section videos relation
    *
    * @return void
    */
    public function videos()
    {
        return $this->belongsToMany("App\Models\Video", "post_video");
    }

	/**
    * Sync section videos relation
    *
    * @param array $videos
    * @return void
    */
    public function syncVideos($videos = [])
    {
        if ( count($videos) ) {
            $this->videos()->sync($videos); return;
        }
        $this->videos()->detach();
    }
	
	
	public function getCustomPost($full=false)
    {
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());

		$title = "title_$lang";
		$content = "content_$lang";
		$title = $this->$title;
		$content = $this->$content;
		$content = html_entity_decode($content);
		
		
		if($full==false){
			$t = explode('<blockquote>',$content);
			if(isset($t[1])){
				$t = explode('</blockquote>',$t[1]);
				$content = $t[0];
			}
        }
		return array('title'=>$title,'content'=>$content);
    }

}