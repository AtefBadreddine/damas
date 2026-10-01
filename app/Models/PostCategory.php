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
        "seo_title_ar",
        "seo_description_ar",
        "seo_keywords_ar",
        "seo_title_en",
        "seo_description_en",
        "seo_keywords_en",
        "seo_title_fr",
        "seo_description_fr",
        "seo_keywords_fr",
        "seo_title_ru",
        "seo_description_ru",
        "seo_keywords_ru",
        "seo_title_fa",
        "seo_description_fa",
        "seo_keywords_fa",
        "icon",
        "country_id",
        "type",//blog or news
    ];

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
     * Find a category by slug in one country.
     *
     * @param \App\Models\Country|int|string|null $country
     * @param string $slug
     * @param string|null $type
     * @return static|null
     */
    public static function findInCountry($country, $slug, $type = null)
    {
        $countryId = Country::resolveId($country);
        if (!$countryId || $slug === null || $slug === '') {
            return null;
        }

        $query = static::where('country_id', $countryId)->where('slug', $slug);
        if ($type) {
            $query->where('type', $type);
        }

        return $query->first();
    }

    /**
     * Find a category by slug when the URL has no country. Returns null if none or more than one match.
     *
     * @param string $slug
     * @param string|null $type
     * @return static|null
     */
    public static function findUnambiguousBySlug($slug, $type = null)
    {
        if ($slug === null || $slug === '') {
            return null;
        }

        $query = static::where('slug', $slug);
        if ($type) {
            $query->where('type', $type);
        }
        $rows = $query->take(2)->get();
        if ($rows->count() !== 1) {
            return null;
        }

        return $rows->first();
    }

    /**
     * Canonical listing URL: /{locale}/{country}/guides?category={slug}
     *
     * @param bool $absolute
     * @return string
     */
    public function listingUrl($absolute = true)
    {
        $countrySlug = $this->getCountrySlug();
        if (!$countrySlug) {
            $country = Country::findBySlugOrCode('turkey');
            $countrySlug = $country ? $country->slug : 'turkiye';
        }

        $routeName = ($this->type == 'news') ? 'front.news.country' : 'front.blog.country';
        return route($routeName, $countrySlug, $absolute) . '?category=' . urlencode($this->slug);
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