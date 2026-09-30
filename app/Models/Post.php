<?php
namespace App\Models;
use LaravelLocalization;
use Nicolaslopezj\Searchable\SearchableTrait;
use Helper;

class Post extends BaseModel
{
    use SearchableTrait;
    public $table = "posts";
    
    protected $fillable = [
        "title_ar",
        "title_en",
        "title_fr",
        "title_ru",
        "title_fa",
        "slug",
        "old_slug",
        "media_id",
        "content_ar",
        "content_en",
        "content_fr",
        "content_ru",
        "content_fa",
        "user_id",
        "user_name",
        "lang",
        "post_type",
        "published",
        "placement",
        "seo_title_ar",
        "seo_description_ar",
        "seo_keywords_ar",
        "seo_title_en",
        "seo_description_en",
        "seo_keywords_en",
        "seo_title_fr",
        "seo_title_ru",
        "seo_title_fa",
        "seo_description_fr",
        "seo_description_ru",
        "seo_description_fa",
        "seo_keywords_fr",
        "seo_keywords_ru",
        "seo_keywords_fa",
        "similar_posts",
        "send_notif_ar",
        "send_notif_en",
        "send_notif_fr",
        "send_notif_ru",
        "send_notif_fa",
        "redirect_post_id",
        "prevent_archiving_in_blog",
        "update_date",
        "update_by",
		"update_by_name",
		'country_id',
		
		"post_scheduling",
		"post_scheduling_date",
		"type",//blog or news
		"with_projects_blog",
		"projects_url",

		
    ];

    /**
     * Filter posts by PostType enum or string value.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \App\Enums\PostType|string $postType
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfPostType($query, $postType)
    {
        $value = $postType instanceof \App\Enums\PostType ? $postType->value : $postType;
        return $query->where('post_type', $value);
    }
    
    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'posts.title_ar' => 5,
            'posts.title_en' => 5,
            'posts.content_ar' => 5,
            'posts.content_en' => 5,
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
     * Geographic country parent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function countryRel()
    {
        return $this->belongsTo("App\Models\Country", "country_id");
    }

    /**
     * Country slug used in geo URLs (turkiye), not the legacy code (turkey).
     *
     * @return string|null
     */
    public function getCountrySlug()
    {
        return $this->countryRel ? $this->countryRel->slug : null;
    }

    /**
     * post_type as enum; legacy rows without it fall back to the blog/news `type`.
     *
     * @return \App\Enums\PostType
     */
    public function postTypeEnum()
    {
        $postType = \App\Enums\PostType::tryFrom((string) $this->post_type);
        if ($postType) {
            return $postType;
        }
        return ($this->type == 'news') ? \App\Enums\PostType::$NEWS : \App\Enums\PostType::$BLOG;
    }

    /**
     * Canonical geo URL by post_type:
     * /{locale}/{country}/guides|developers|reports|news/{post}
     * These are fixed path segments, not post categories.
     * Returns null when country is missing so callers can skip the 301.
     *
     * @param bool $absolute
     * @return string|null
     */
    public function geoUrl($absolute = true)
    {
        $countrySlug = $this->getCountrySlug();
        if (!$countrySlug) {
            return null;
        }

        $routeName = $this->postTypeEnum()->frontShowRoute();

        return route($routeName, array(
            'country' => $countrySlug,
            'post' => $this->slug,
        ), $absolute);
    }

    /**
     * Public post URL for menus, cards, and shares.
     * Prefers the geo path; falls back to the legacy /blog/{slug} or /news/{slug} 301.
     *
     * @param bool $absolute
     * @return string
     */
    public function frontUrl($absolute = true)
    {
        $url = $this->geoUrl($absolute);
        if ($url) {
            return $url;
        }
        $routeName = ($this->type == 'news') ? 'front.news.post' : 'front.blog.post';
        return route($routeName, $this->slug, $absolute);
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
    * tags
    *
    * @return void
    */
    public function tags()
    {
        return $this->belongsToMany("App\Models\Tag", "post_tag");
    }
	
   
    
    /**
    * Sync post tags
    *
    * @param array $tags
    * @return void
    */
    public function syncTags($tags = [])
    {
        if ( count($tags) ) {
            $this->tags()->sync($tags); return;
        }
        $this->tags()->detach();
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
		
		
		$content = Helper::add_links_html($content,$lang);
		
		if($full==false){
			$t = explode('<blockquote>',$content);
			if(isset($t[1])){
				$t = explode('</blockquote>',$t[1]);
				$content = $t[0];
			}
        }
		return array('title'=>$title,'content'=>$content,'createdAt'=>$this->createdAt,'updatedAt'=>$this->updatedAt,'cat_id'=> @$this->categories[0]->id);
    }

}