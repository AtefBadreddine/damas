<?php
namespace App\Models;

class Country extends BaseModel
{
    public $table = "countries";

    protected $fillable = [
        "slug",
        "code",
        "whatsapp_number",
        "name_ar",
        "name_en",
        "h1_ar",
        "h1_en",
        "media_id",
        "media_en_id",
        "content_ar",
        "content_en",
        "seo_title_ar",
        "seo_description_ar",
        "seo_title_en",
        "seo_description_en",
        "placement",
        "show",
    ];

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('placement', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Countries visible in home / search filter dropdowns.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisibleInFilters($query)
    {
        return $query->where('show', 1);
    }

    /**
     * City IDs for countries hidden from front filters (cascade to cities & districts).
     *
     * @return array
     */
    public static function hiddenFilterCityIds()
    {
        static $ids = null;
        if ($ids !== null) {
            return $ids;
        }

        if (!\Schema::hasColumn('countries', 'show')) {
            return $ids = array();
        }

        $hiddenCountryIds = static::where('show', 0)->lists('id')->toArray();
        if (empty($hiddenCountryIds)) {
            return $ids = array();
        }

        return $ids = City::whereIn('country_id', $hiddenCountryIds)->lists('id')->toArray();
    }

    /**
     * Use slug in URLs: /ar/turkiye , /en/oman
     */
    public function getRouteKeyName()
    {
        return "slug";
    }

    public function getCode()
    {
        return $this->code;
    }

    /**
     * Digits-only WhatsApp number for api.whatsapp.com (empty when unset).
     *
     * @return string
     */
    public function getWhatsappNumber()
    {
        return preg_replace('/\D+/', '', (string) $this->whatsapp_number);
    }

    public static function findBySlug($slug)
    {
        return static::where("slug", $slug)->first();
    }

    public static function findByCode($code)
    {
        return static::where("code", $code)->first();
    }

    /**
     * Regex of country URL slugs for route constraints (turkiye|oman|...).
     *
     * @return string
     */
    public static function slugPattern()
    {
        static $pattern = null;
        if ($pattern !== null) {
            return $pattern;
        }

        $fallback = 'turkiye|oman|uae|syria';
        try {
            if (!\Schema::hasTable('countries')) {
                return $pattern = $fallback;
            }
            $quoted = array();
            foreach (static::select('slug')->get() as $country) {
                if (!empty($country->slug) && is_string($country->slug)) {
                    $quoted[] = preg_quote($country->slug, '/');
                }
            }
            if (empty($quoted)) {
                return $pattern = $fallback;
            }
            return $pattern = implode('|', $quoted);
        } catch (\Throwable $e) {
            return $pattern = $fallback;
        }
    }

    /**
     * cities
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany("App\Models\City", "country_id");
    }

    /**
     * posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany("App\Models\Post", "country_id");
    }

    /**
     * post categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postCategories()
    {
        return $this->hasMany("App\Models\PostCategory", "country_id");
    }

    public function getTitle()
    {
        $lang = (\LaravelLocalization::getCurrentLocale() == 'pe' ? 'fa' : \LaravelLocalization::getCurrentLocale());
        $field = "name_" . $lang;
        if (isset($this->$field) && $this->$field) {
            return $this->$field;
        }
        return $this->name_en ? $this->name_en : $this->name_ar;
    }

    public function getH1()
    {
        return $this->localized('h1');
    }

    public function getContent()
    {
        return $this->localized('content');
    }

    public function getSeoTitle()
    {
        return $this->localized('seo_title');
    }

    public function getSeoDescription()
    {
        return $this->localized('seo_description');
    }

    /**
     * Countries only store ar/en; other locales use the English value.
     *
     * @param string $prefix
     * @return string|null
     */
    protected function localized($prefix)
    {
        $lang = \LaravelLocalization::getCurrentLocale() == 'ar' ? 'ar' : 'en';
        $field = $prefix . "_" . $lang;
        return $this->$field;
    }

    /**
     * Country listing URL: /{locale}/{country}/
     *
     * @param bool $absolute
     * @return string
     */
    public function listingUrl($absolute = true)
    {
        return route('front.location.country', $this->slug, $absolute);
    }

    public function media()
    {
        $lang = (\LaravelLocalization::getCurrentLocale() == 'pe' ? 'fa' : \LaravelLocalization::getCurrentLocale());
        if ($lang == 'ar') {
            return $this->belongsTo("App\Models\Media", "media_id");
        }
        return $this->belongsTo("App\Models\Media", "media_en_id");
    }

    public function mediaAr()
    {
        return $this->belongsTo("App\Models\Media", "media_id");
    }

    public function mediaEn()
    {
        return $this->belongsTo("App\Models\Media", "media_en_id");
    }
}
