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