<?php
namespace App\Models;

class BlogParam extends BaseModel
{
    public $table = "blog_params";
    
    protected $fillable = [
        "title_ar",
        "title_en",
        "title_fa",
        "seo_title_ar",
        "seo_description_ar",
        "seo_keywords_ar",
        "seo_title_en",
        "seo_description_en",
        "seo_keywords_en",
        "seo_title_fa",
        "seo_description_fa",
        "seo_keywords_fa",
        "featured_post",
        "country_id",
		
        "seo_description_fr",
        "title_fr",
        "seo_title_fr",
        "seo_keywords_fr",
		
        "seo_description_ru",
        "title_ru",
        "seo_title_ru",
        "seo_keywords_ru",
    ];

    /**
     * Geographic country parent. News params keep country_id null.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function countryRel()
    {
        return $this->belongsTo("App\Models\Country", "country_id");
    }

    /**
     * Blog params (including featured posts) for a country model, id, slug, or legacy code.
     * Falls back to Turkey when the country has no row yet.
     *
     * @param \App\Models\Country|int|string|null $country
     * @return static
     */
    public static function forCountry($country)
    {
        $countryId = Country::resolveId($country);
        if ($countryId) {
            $row = static::where('country_id', $countryId)->first();
            if ($row) {
                return $row;
            }
        }

        $turkey = Country::findBySlugOrCode('turkey');
        if ($turkey) {
            $row = static::where('country_id', $turkey->id)->first();
            if ($row) {
                return $row;
            }
        }

        $row = static::find(1);
        return $row ? $row : new static;
    }
}
