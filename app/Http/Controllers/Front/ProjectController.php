<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\BaseController;
use App\Models\City;
use App\Models\Country;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectType;
use App\Models\Region;
use Illuminate\Support\Facades\Redirect;
use Helper;
use DB;

class ProjectController extends BaseController
{
    /**
     * Project page: /{locale}/{country}/{city}/{region}/{project}
     *
     * @param string $country
     * @param string $city
     * @param string $region
     * @param string $project
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function show($country, $city, $region, $project)
    {
        $row = Project::where("old_slug", $project)->with(array("city.countryRel", "region"))->first();
        if ($row && $row->slug !== $project && $this->matchesGeo($row, $country, $city, $region) && $row->geoUrl()) {
            $query = request()->getQueryString();
            return Redirect::to($row->geoUrl() . ($query ? '?' . $query : ''), 301);
        }

        $row = Project::where("slug", $project)->with(array("city.countryRel", "region"))->first();
        if (!$row || !$this->matchesGeo($row, $country, $city, $region)) {
            abort(404);
        }

        if (isset($_SERVER["HTTP_REFERER"])) {
            $row->views += 1;
            $row->save();
        }

        $lang = (\LaravelLocalization::getCurrentLocale() == 'pe' ? 'fa' : \LaravelLocalization::getCurrentLocale());
        $video_code = '';
        $video_code2 = '';
        $videos = DB::select("SELECT dms_project_video.`project_id`, dms_project_video.`video_id`,dms_videos.link, dms_videos.lang,updated_at
FROM `dms_project_video`
left JOIN dms_videos on dms_videos.id=dms_project_video.video_id
WHERE dms_project_video.`project_id`=? and dms_videos.lang like ?
order by updated_at desc
limit 1", array($row->id, '%' . $lang . '%'));

        if (isset($videos[0])) {
            $link_video = $videos[0]->link;
            parse_str(parse_url($link_video, PHP_URL_QUERY), $array_of_vars);
            $video_code = @$array_of_vars['v'];
        }

        $link_video2 = $row->region ? $row->region->getLinkvideo() : '';
        if ($link_video2 != '') {
            parse_str(parse_url($link_video2, PHP_URL_QUERY), $array_of_vars);
            $video_code2 = @$array_of_vars['v'];
        }

        $project = $row;

        return view("front.project_show", compact("project", "video_code", "video_code2"));
    }

    /**
     * True only when country, city and district all match this project.
     *
     * @param \App\Models\Project $row
     * @param string $country
     * @param string $city
     * @param string $region
     * @return bool
     */
    protected function matchesGeo($row, $country, $city, $region)
    {
        if (!$row->city || !$row->region || !$row->city->slug || !$row->region->slug) {
            return false;
        }

        return $row->city->getCountrySlug() === $country
            && $row->city->slug === $city
            && $row->region->slug === $region;
    }

    /**
     * All projects listing: /{locale}/projects
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return $this->showLocation(null, null, null);
    }

    /**
     * Country listing: /{locale}/{country}/
     *
     * @param string $country
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function country($country)
    {
        return $this->showLocation($country, null, null);
    }

    /**
     * City listing: /{locale}/{country}/{city}/
     *
     * @param string $country
     * @param string $city
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function city($country, $city)
    {
        return $this->showLocation($country, $city, null);
    }

    /**
     * District listing: /{locale}/{country}/{city}/{region}/
     *
     * @param string $country
     * @param string $city
     * @param string $region
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function region($country, $city, $region)
    {
        return $this->showLocation($country, $city, $region);
    }

    /**
     * Shared listing for all-projects, country, city, and district pages.
     *
     * @param string|null $countrySlug
     * @param string|null $citySlug
     * @param string|null $regionSlug
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected function showLocation($countrySlug, $citySlug = null, $regionSlug = null)
    {
        $country = null;
        if ($countrySlug) {
            $country = Country::findBySlug($countrySlug);
            if (!$country) {
                abort(404);
            }
        }

        $city = null;
        $region = null;

        if ($citySlug) {
            $city = $this->findCity($country, $citySlug);
            if (!$city) {
                abort(404);
            }
        }

        if ($regionSlug) {
            $region = $this->findRegion($city, $regionSlug);
            if (!$region) {
                abort(404);
            }
            if ($region->slug !== $regionSlug) {
                return Redirect::to(route('front.location.region', array(
                    'country' => $country->slug,
                    'city' => $city->slug,
                    'region' => $region->slug,
                )), 301);
            }
        }

        $paginate_number = 6;
        $q = Project::where("published", 1)->where("sold", '!=', 100)->with(array('cardphoto', 'flavors', 'city', 'region'));

        $countryCityIds = array();
        if ($country) {
            $countryCityIds = City::where('country_id', $country->id)->lists('id');
            $countryCityIds = is_array($countryCityIds) ? $countryCityIds : $countryCityIds->toArray();
        }

        if ($region) {
            $q->where('region_id', $region->id);
        } elseif ($city) {
            $q->where('city_id', $city->id);
        } elseif ($country) {
            if (empty($countryCityIds)) {
                $q->whereRaw('1 = 0');
            } else {
                $q->whereIn('city_id', $countryCityIds);
            }
        }

        $unfilteredQuery = clone $q;
        $filters = $this->locationQueryFilters($city, $region, $countryCityIds);
        $this->applyLocationFilters($q, $filters);

        $allQuery = clone $q;
        $allprojects = $allQuery->get();
        $projects = $q->paginate($paginate_number);
        $projects->appends(request()->except('page'));

        $content = $this->locationContent($country, $city, $region, $filters);
        // With no matches, offer every option in this location so the visitor can change filters instead of hitting empty dropdowns.
        $optionProjects = count($allprojects) ? $allprojects : $unfilteredQuery->get();
        $filterData = $this->locationFilterInputs($country, $city, $region, $optionProjects);
        $filterData = $this->keepSelectedOptions($filterData, $filters);

        $inputs = array_merge($filterData, $content);
        $inputs['city'] = $city ? $city->slug : ($country ? $country->code : '');
        $inputs['city_row'] = $city ? $city : $country;
        if ($region) {
            $inputs['regions'] = array($region->slug);
        } else {
            $inputs['regions'] = array_map(function ($r) {
                return $r->slug;
            }, $filters['districts']);
        }
        $inputs['project_type'] = $filters['type'] ? $filters['type']->slug : '';
        $inputs['project_categories'] = array_map(function ($c) {
            return $c->slug;
        }, $filters['categories']);
        $inputs['rooms'] = $filters['rooms'];
        $inputs['price'] = $filters['price'];
        $inputs['sorting'] = $filters['sorting'];
        $inputs['__links'] = '';

        $projectsUrl = route('front.projects');
        $locationBaseUrl = $region ? $region->listingUrl() : ($city ? $city->listingUrl() : ($country ? $country->listingUrl() : $projectsUrl));
        $locationAreaUrl = $city ? $city->listingUrl() : ($country ? $country->listingUrl() : $projectsUrl);
        $filterFormUrl = $locationBaseUrl;

        $q_tags = array();
        $__type = 'property-for-sale';
        $__city = $inputs['city'];
        $__var1 = $region ? $region->slug : null;
        $__var2 = null;
        $search_noindex = count($allprojects) === 0;
        $is_location_page = true;
        $locationCountry = $country;
        $locationCity = $city;
        $locationRegion = $region;

        return view('front.location', compact(
            'projects',
            'inputs',
            'allprojects',
            'paginate_number',
            'q_tags',
            '__type',
            '__city',
            '__var1',
            '__var2',
            'search_noindex',
            'is_location_page',
            'filterFormUrl',
            'locationAreaUrl',
            'locationCountry',
            'locationCity',
            'locationRegion'
        ));
    }

    /**
     * Listing filters from the query string:
     * ?type=apartments-for-sale&category=sea-views,pool&district=a,b&rooms=1_2&price=100000-250000&sorting=views
     * Unknown values are ignored.
     *
     * @param \App\Models\City|null $city
     * @param \App\Models\Region|null $region
     * @param array $countryCityIds
     * @return array
     */
    protected function locationQueryFilters($city, $region, array $countryCityIds)
    {
        $request = request();
        $filters = array(
            'type' => null,
            'categories' => array(),
            'districts' => array(),
            'rooms' => '',
            'price' => '',
            'sorting' => '',
            'sorting_type' => 'desc',
        );

        $type = trim((string) $request->get('type', ''));
        if ($type !== '' && $type !== 'property-for-sale') {
            $filters['type'] = ProjectType::where('slug', $type)->first();
        }

        $categorySlugs = $this->csvQueryParam('category');
        if ($categorySlugs) {
            $filters['categories'] = ProjectCategory::whereIn('slug', $categorySlugs)->get()->all();
        }

        $districtSlugs = $region ? array() : $this->csvQueryParam('district');
        if ($districtSlugs) {
            $districtQuery = Region::whereIn('slug', $districtSlugs);
            if ($city) {
                $districtQuery->where('city_id', $city->id);
            } elseif (!empty($countryCityIds)) {
                $districtQuery->whereIn('city_id', $countryCityIds);
            }
            $filters['districts'] = $districtQuery->get()->all();
        }

        $rooms = (string) $request->get('rooms', '');
        if (preg_match('/^\d+_\d+$/', $rooms)) {
            $filters['rooms'] = $rooms;
        }

        // An unencoded "+" in "?price=150000-+" arrives as a space.
        $price = rtrim((string) $request->get('price', ''));
        if (substr($price, -1) === '-') {
            $price .= '+';
        }
        if (preg_match('/^\d+-(\d+|\+)$/', $price)) {
            $filters['price'] = $price;
        }

        $sorting = (string) $request->get('sorting', '');
        if (in_array($sorting, array('views', 'likes'), true)) {
            $filters['sorting'] = $sorting;
            $filters['sorting_type'] = $request->get('sorting_type') === 'asc' ? 'asc' : 'desc';
        }

        return $filters;
    }

    /**
     * Make sure the active type / category / rooms filters stay selectable in the sidebar.
     *
     * @param array $filterData
     * @param array $filters
     * @return array
     */
    protected function keepSelectedOptions(array $filterData, array $filters)
    {
        $typeIds = json_decode($filterData['project_types_options'], true);
        if ($filters['type']) {
            $typeIds[] = $filters['type']->id;
        }
        $tagIds = json_decode($filterData['project_tags_options'], true);
        foreach ($filters['categories'] as $category) {
            $tagIds[] = $category->id;
        }
        $roomKeys = json_decode($filterData['rooms_options'], true);
        if ($filters['rooms'] !== '') {
            $roomKeys[] = $filters['rooms'];
        }

        $filterData['project_types_options'] = json_encode(array_values(array_unique($typeIds)));
        $filterData['project_tags_options'] = json_encode(array_values(array_unique($tagIds)));
        $filterData['rooms_options'] = json_encode(array_values(array_unique($roomKeys)));

        return $filterData;
    }

    /**
     * Comma-separated (or array) query param as a list of slugs.
     *
     * @param string $name
     * @return array
     */
    protected function csvQueryParam($name)
    {
        $value = request()->get($name, array());
        $values = is_array($value) ? $value : explode(',', (string) $value);

        return array_values(array_unique(array_filter(array_map('trim', $values), 'strlen')));
    }

    /**
     * Apply type / category / district / rooms / price / sorting filters to the project query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $q
     * @param array $filters
     * @return void
     */
    protected function applyLocationFilters($q, array $filters)
    {
        if ($filters['type']) {
            $typeId = $filters['type']->id;
            $q->whereIn('projects.id', function ($sub) use ($typeId) {
                $sub->select('project_id')->from('project_type')->where('project_type_id', $typeId);
            });
        }

        foreach ($filters['categories'] as $category) {
            // hide_search_page categories only drive the page heading, they don't narrow results.
            if ($category->hide_search_page) {
                continue;
            }
            $categoryId = $category->id;
            $q->whereIn('projects.id', function ($sub) use ($categoryId) {
                $sub->select('project_id')->from('project_category')->where('project_category_id', $categoryId);
            });
        }

        if ($filters['districts']) {
            $q->whereIn('region_id', array_map(function ($r) {
                return $r->id;
            }, $filters['districts']));
        }

        $rooms = $filters['rooms'];
        $price = $filters['price'];
        if ($price !== '') {
            $q->where(DB::raw('datediff(delivered_date,NOW())'), '>', '-500');
        }
        if ($rooms !== '' || $price !== '') {
            $q->whereIn('projects.id', function ($sub) use ($rooms, $price) {
                $sub->select('project_id')->from('projects_flavors');
                if ($rooms !== '') {
                    $parts = explode('_', $rooms);
                    $sub->where('salon', (int) $parts[0])->where('room', (int) $parts[1]);
                }
                if ($price !== '') {
                    $parts = explode('-', $price);
                    if ($parts[1] === '+') {
                        $sub->where('price_usd', '>=', (int) $parts[0]);
                    } else {
                        $sub->whereBetween('price_usd', array((int) $parts[0], (int) $parts[1]));
                    }
                }
                $sub->groupBy('project_id');
            });
        }

        if ($filters['sorting']) {
            $q->orderBy($filters['sorting'], $filters['sorting_type']);
        } else {
            $q->orderBy('sort', 'asc');
        }
    }

    /**
     * Resolve a city in this country by URL slug or English name.
     *
     * @param \App\Models\Country $country
     * @param string $slug
     * @return \App\Models\City|null
     */
    protected function findCity($country, $slug)
    {
        $city = City::where('country_id', $country->id)->where('slug', $slug)->first();
        if ($city) {
            return $city;
        }

        return City::where('country_id', $country->id)
            ->whereRaw('LOWER(name_en) = ?', array(strtolower($slug)))
            ->first();
    }

    /**
     * Resolve a district in this city by URL slug or English name.
     *
     * @param \App\Models\City $city
     * @param string $slug
     * @return \App\Models\Region|null
     */
    protected function findRegion($city, $slug)
    {
        $region = Region::where('city_id', $city->id)->where('slug', $slug)->first();
        if ($region) {
            return $region;
        }

        return Region::where('city_id', $city->id)
            ->whereRaw('LOWER(name_en) = ?', array(strtolower(str_replace('-', ' ', $slug))))
            ->first();
    }

    /**
     * SEO and about copy for a geo listing.
     * Page title comes from the deepest content table (district → city → country).
     * If that title is empty, generate "properties for sale {place}".
     *
     * @param \App\Models\Country|null $country
     * @param \App\Models\City|null $city
     * @param \App\Models\Region|null $region
     * @param array $filters type / category filters override the heading and SEO title
     * @return array
     */
    protected function locationContent($country, $city = null, $region = null, array $filters = array())
    {
        $place = $country ? $country->getTitle() : '';
        $row = $country;
        if ($city) {
            $place = $city->getName() ? $city->getName() : $place;
            $row = $city;
        }
        if ($region) {
            $place = $region->getName() ? $region->getName() : $place;
            $row = $region;
        }

        $h1 = $place
            ? preg_replace('/\s+/', ' ', trim(trans('front.aqarat') . ' ' . trans('front.for_sale') . ' ' . $place))
            : trans('front.projects');

        $geoContent = null;
        $aboutBodyFromGeo = null;
        try {
            if ($region) {
                $geoContent = $region->districtContent;
            } elseif ($city) {
                $geoContent = $city->cityContent;
            } elseif ($country) {
                $geoContent = $country->countryContent;
            }
            if ($geoContent) {
                if ($geoContent->getTitle()) {
                    $h1 = $geoContent->getTitle();
                }
                $aboutBodyFromGeo = $geoContent->getContent();
            }
        } catch (\Exception $e) {
            $aboutBodyFromGeo = null;
        }

        $filterType = isset($filters['type']) ? $filters['type'] : null;
        $filterCategories = isset($filters['categories']) ? $filters['categories'] : array();
        $hasTypeOrCategory = $filterType || $filterCategories;
        if ($hasTypeOrCategory) {
            $categoryNames = array_map(function ($c) {
                return $c->getName();
            }, $filterCategories);
            $h1 = preg_replace('/\s+/', ' ', trim(
                ($filterType ? $filterType->getName() : ($place ? trans('front.aqarat') : trans('front.projects')))
                . ($place ? ' ' . trans('front.for_sale') . ' ' . $place : '')
                . ' ' . implode(', ', $categoryNames)
            ));
        }

        $seoTitle = $h1;
        $seoDescription = $h1;
        $seoKeywords = '';
        if ($row && !$hasTypeOrCategory && method_exists($row, 'getSeoTitle') && $row->getSeoTitle()) {
            $seoTitle = $row->getSeoTitle();
        }
        if ($row && !$hasTypeOrCategory && method_exists($row, 'getSeoDescription') && $row->getSeoDescription()) {
            $seoDescription = $row->getSeoDescription();
        }
        if ($row && method_exists($row, 'getSeoKeywords') && $row->getSeoKeywords()) {
            $seoKeywords = $row->getSeoKeywords();
        }

        $aboutBody = '';
        if (isset($aboutBodyFromGeo) && $aboutBodyFromGeo !== null && $aboutBodyFromGeo !== '') {
            $aboutBody = $aboutBodyFromGeo;
        } elseif ($row && method_exists($row, 'getAbout') && $row->getAbout()) {
            $aboutBody = $row->getAbout();
        }

        $ogImage = null;
        if ($city) {
            $current_lang = (\LaravelLocalization::getCurrentLocale() == 'pe' ? 'fa' : \LaravelLocalization::getCurrentLocale());
            if ($current_lang == 'en' && $city->media_en_id) {
                $ogImage = Helper::media_mob($city->mediaEn);
            } elseif ($current_lang == 'fr' && $city->media_fr_id) {
                $ogImage = Helper::media_mob($city->mediaFr);
            } elseif ($current_lang == 'ru' && $city->media_ru_id) {
                $ogImage = Helper::media_mob($city->mediaRu);
            } elseif ($current_lang == 'pe' && $city->media_fa_id) {
                $ogImage = Helper::media_mob($city->mediaFa);
            } elseif ($city->media_id) {
                $ogImage = Helper::media_mob($city->media);
            }
        }

        return array(
            'seo_title' => $seoTitle,
            'seo_description' => $seoDescription,
            'seo_keywords' => $seoKeywords,
            'og_image' => $ogImage,
            'about' => '<h1 property="name">' . $h1 . '</h1><div class="clearfix">' . $aboutBody . '</div>',
        );
    }

    /**
     * Filter sidebar data expected by projects_filter.
     *
     * @param \App\Models\Country|null $country
     * @param \App\Models\City|null $city
     * @param \App\Models\Region|null $region
     * @param \Illuminate\Support\Collection $allprojects
     * @return array
     */
    protected function locationFilterInputs($country, $city, $region, $allprojects)
    {
        $projectIds = array();
        $cityIds = array();
        $regionIds = array();
        foreach ($allprojects as $project) {
            $projectIds[] = $project->id;
            $cityIds[] = $project->city_id;
            $regionIds[] = $project->region_id;
        }
        $cityIds = array_values(array_unique($cityIds));
        $regionIds = array_values(array_unique($regionIds));

        $typeIds = array();
        $tagIds = array();
        $roomKeys = array();
        if (!empty($projectIds)) {
            foreach (DB::table('project_type')->select('project_type_id')->whereIn('project_id', $projectIds)->distinct()->get() as $row) {
                $typeIds[] = $row->project_type_id;
            }
            foreach (DB::table('project_category')->select('project_category_id')->whereIn('project_id', $projectIds)->distinct()->get() as $row) {
                $tagIds[] = $row->project_category_id;
            }
            $roomList = array('1_0', '1_1', '1_2', '1_3', '1_4', '1_5', '2_3', '2_4', '2_5', '2_6');
            foreach (DB::table('projects_flavors')->select('salon', 'room')->whereIn('project_id', $projectIds)->get() as $row) {
                $key = $row->salon . '_' . $row->room;
                if (in_array($key, $roomList)) {
                    $roomKeys[] = $key;
                }
            }
            $roomKeys = array_values(array_unique($roomKeys));
        }

        $regionsOptions = array();
        if ($city) {
            $regionsOptions = Region::select('regions.*')
                ->leftJoin('projects AS p', 'p.region_id', '=', 'regions.id')
                ->where('p.published', 1)
                ->where('p.sold', '!=', 100)
                ->where('p.city_id', $city->id)
                ->groupBy('regions.id')
                ->orderBy(DB::raw('count(dms_p.id)'), 'desc')
                ->with('city.countryRel')
                ->get();
        } else {
            $regionsQuery = Region::select('regions.*')
                ->leftJoin('projects AS p', 'p.region_id', '=', 'regions.id')
                ->where('p.published', 1)
                ->where('p.sold', '!=', 100);
            if ($country) {
                $countryCityIds = City::where('country_id', $country->id)->lists('id');
                $countryCityIds = is_array($countryCityIds) ? $countryCityIds : $countryCityIds->toArray();
                if (empty($countryCityIds)) {
                    $regionsOptions = array();
                    $regionsQuery = null;
                } else {
                    $regionsQuery->whereIn('p.city_id', $countryCityIds);
                }
            }
            if ($regionsQuery) {
                $regionsOptions = $regionsQuery
                    ->groupBy('regions.id')
                    ->orderBy(DB::raw('count(dms_p.id)'), 'desc')
                    ->with('city.countryRel')
                    ->get();
            }
        }

        return array(
            'regions_options' => $regionsOptions,
            'project_citys_options' => json_encode($cityIds),
            'project_regions_options' => json_encode($regionIds),
            'project_types_options' => json_encode($typeIds),
            'prices_options' => json_encode(array()),
            'rooms_options' => json_encode($roomKeys),
            'project_tags_options' => json_encode($tagIds),
        );
    }
}
