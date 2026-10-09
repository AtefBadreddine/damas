<?php
namespace App\Models;
use LaravelLocalization;
class Tag extends BaseModel
{
    public $table = "tags";
    
    protected $fillable = [
        "slug",
        "name",
        "title_ar",
        "title_en",
        "title_fa",
		"title_fr",
		"title_ru",

        "media_id",
		"placement",
    ];

    /**
     * Find a tag by slug. Returns null if none or more than one match.
     *
     * @param string $slug
     * @return static|null
     */
    public static function findUnambiguousBySlug($slug)
    {
        if ($slug === null || $slug === '') {
            return null;
        }

        $rows = static::where('slug', $slug)->take(2)->get();
        if ($rows->count() !== 1) {
            return null;
        }

        return $rows->first();
    }
    
    /**
    * media
    *
    * @return void
    */
    public function media()
    {
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
			return $this->belongsTo("App\Models\Media", "media_id");
    }
    
    /**
    * posts
    *
    * @return void
    */
    public function posts()
    {
        return $this->belongsToMany("App\Models\Post","post_tag");
    }
}
