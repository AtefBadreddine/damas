<?php
namespace App\Models;

class Fotterproject extends BaseModel
{
    public $table = "fotterprojects";
    
    protected $fillable = [
        "project_id",
        "country_id",
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
     * Featured footer project IDs.
     * Null or "home" is the Home bucket (country_id IS NULL).
     *
     * @param \App\Models\Country|int|string|null $country
     * @return array
     */
    public static function projectIdsForCountry($country)
    {
        if ($country === null || $country === '' || $country === 'home') {
            $ids = static::whereNull('country_id')->lists('project_id');
            return is_array($ids) ? $ids : $ids->toArray();
        }

        $countryId = Country::resolveId($country);
        if (!$countryId) {
            return array();
        }

        $ids = static::where('country_id', $countryId)->lists('project_id');
        return is_array($ids) ? $ids : $ids->toArray();
    }
}
