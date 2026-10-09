<?php
namespace App\Models;

class PostCategory extends BaseModel
{
    public $table = "posts_categories";
    
    protected $fillable = [
        "name_ar",
        "name_en",
        "name_fr",
        "name_ru",
        "name_fa",
        "placement",
        "slug",
        "icon",
    ];

    /**
     * Find a category by slug. Returns null if none or more than one match.
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
     * Listing URL on the current country/section: /{country}/guides?category={slug}
     *
     * @param bool $absolute
     * @param string|null $countrySlug
     * @param string|null $listingRoute e.g. front.blog.country, front.news.country
     * @return string
     */
    public function listingUrl($absolute = true, $countrySlug = null, $listingRoute = null)
    {
        if (!$listingRoute) {
            $listingRoute = $countrySlug ? 'front.blog.country' : 'front.blog.index';
        }

        $url = $countrySlug
            ? route($listingRoute, $countrySlug, $absolute)
            : route($listingRoute, array(), $absolute);

        return $url . '?category=' . urlencode($this->slug);
    }
    
    /**
    * posts
    *
    * @return void
    */
    public function posts()
    {
        return $this->belongsToMany("App\Models\Post", "post_category");
    }

}
