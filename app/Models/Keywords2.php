<?php
namespace App\Models;
use LaravelLocalization;

class Keywords2 extends BaseModel
{
    public $table = "keywords2";
    protected $fillable = ["keyword_ar", "keyword_en", "keyword_fr", "keyword_ru", "keyword_fa", "url", "url_en", "display", "country_id"];

    public function countryRel()
    {
        return $this->belongsTo("App\\Models\\Country", "country_id");
    }

    public function getKeyword()
    {
        $lang = LaravelLocalization::getCurrentLocale();
        $lang = $lang == 'pe' ? 'fa' : $lang;
        return $this->{"keyword_" . $lang};
    }

    public function getDisplay()
    {
        return explode(';', $this->display);
    }

    // Match any category, but always within one explicitly assigned country.
    public static function forContext($countryId, array $display, $lang)
    {
        $lang = $lang == 'pe' ? 'fa' : $lang;
        if (!in_array($lang, array('ar', 'en', 'fr', 'fa', 'ru'))) $lang = 'ar';
        $display = array_values(array_unique(array_filter($display, function ($value) {
            return $value === 'projects' || (ctype_digit((string) $value) && (int) $value > 0);
        })));
        $query = static::where('country_id', (int) $countryId)
            ->where('keyword_' . $lang, '!=', '')->where('url', '!=', '');
        if (!$countryId || !$display) return $query->whereRaw('1 = 0')->get();
        return $query->where(function ($query) use ($display) {
            foreach ($display as $value) $query->orWhere('display', 'like', '%;' . $value . ';%');
        })->orderBy('id', 'asc')->get();
    }

    // Keep the complete path, filters and fragment. English may override the URL
    // when its destination has a different slug. External URLs stay unchanged.
    public function getUrl($lang = null)
    {
        $lang = $lang ?: LaravelLocalization::getCurrentLocale();
        if (!in_array($lang, array('ar', 'en'))) return '';
        $raw = trim($lang === 'en' && trim((string) $this->url_en) !== '' ? $this->url_en : $this->url);
        if ($raw === '') return '';
        $parts = parse_url($raw);
        if ($parts === false || isset($parts['user']) || isset($parts['pass'])) return '';
        if (isset($parts['scheme']) && !in_array(strtolower($parts['scheme']), array('http', 'https'))) return '';
        $host = isset($parts['host']) ? strtolower($parts['host']) : '';
        $siteHost = strtolower((string) parse_url(config('app.url'), PHP_URL_HOST));
        if ($host && !in_array($host, array('damas.net', 'www.damas.net', $siteHost))) return $raw;
        $path = isset($parts['path']) ? $parts['path'] : '/';
        $path = preg_replace('#^/(ar|en)(?=/|$)#', '', '/' . ltrim($path, '/'));
        $result = url('/' . $lang . '/' . ltrim($path, '/'));
        if (isset($parts['query'])) $result .= '?' . $parts['query'];
        if (isset($parts['fragment'])) $result .= '#' . $parts['fragment'];
        return $result;
    }
}
