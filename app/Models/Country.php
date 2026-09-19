<?php
namespace App\Models;

class Country extends BaseModel
{
    public $table = "countries";

    protected $fillable = [
        "slug",
        "code",
        "title_ar",
        "title_en",
    ];

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

        $fallback = 'turkiye|oman|emirates|syria';
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
}
