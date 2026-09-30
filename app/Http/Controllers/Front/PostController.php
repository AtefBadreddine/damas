<?php
namespace App\Http\Controllers\Front;

use App\Enums\PostType;
use App\Http\Controllers\BaseController;
use App\Models\Country;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Helper;
use DB;
use Cookie;

class PostController extends BaseController
{
    /**
     * Blog page: /{locale}/{country}/guides/{post}
     *
     * @param string $country
     * @param string $post
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function show($country, $post)
    {
        return $this->showByType($country, $post, PostType::$BLOG);
    }

    /**
     * Developer page: /{locale}/{country}/developers/{post}
     *
     * @param string $country
     * @param string $post
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function showDevelopers($country, $post)
    {
        return $this->showByType($country, $post, PostType::$DEVELOPER);
    }

    /**
     * Report page: /{locale}/{country}/reports/{post}
     *
     * @param string $country
     * @param string $post
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function showReports($country, $post)
    {
        return $this->showByType($country, $post, PostType::$REPORT);
    }

    /**
     * Blog listing: /{locale}/guides (all countries, post type blog)
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->indexListing($request, PostType::$BLOG, null);
    }

    /**
     * Country blog listing: /{locale}/{country}/guides
     *
     * @param Request $request
     * @param string $country
     * @return \Illuminate\Http\Response
     */
    public function indexCountry(Request $request, $country)
    {
        return $this->indexListing($request, PostType::$BLOG, $country);
    }

    /**
     * Developers listing: /{locale}/developers
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function indexDevelopers(Request $request)
    {
        return $this->indexListing($request, PostType::$DEVELOPER, null);
    }

    /**
     * Country developers listing: /{locale}/{country}/developers
     *
     * @param Request $request
     * @param string $country
     * @return \Illuminate\Http\Response
     */
    public function indexDevelopersCountry(Request $request, $country)
    {
        return $this->indexListing($request, PostType::$DEVELOPER, $country);
    }

    /**
     * Reports listing: /{locale}/reports
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function indexReports(Request $request)
    {
        return $this->indexListing($request, PostType::$REPORT, null);
    }

    /**
     * Country reports listing: /{locale}/{country}/reports
     *
     * @param Request $request
     * @param string $country
     * @return \Illuminate\Http\Response
     */
    public function indexReportsCountry(Request $request, $country)
    {
        return $this->indexListing($request, PostType::$REPORT, $country);
    }

    /**
     * News listing: /{locale}/news
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function indexNews(Request $request)
    {
        return $this->indexListing($request, PostType::$NEWS, null);
    }

    /**
     * Country news listing: /{locale}/{country}/news
     *
     * @param Request $request
     * @param string $country
     * @return \Illuminate\Http\Response
     */
    public function indexNewsCountry(Request $request, $country)
    {
        return $this->indexListing($request, PostType::$NEWS, $country);
    }

    /**
     * Shared listing for /guides, /developers, /reports, /news and their country pages.
     *
     * @param Request $request
     * @param PostType $postType
     * @param string|null $countrySlug Country URL slug, or null for all countries / turkey (news)
     * @return \Illuminate\Http\Response
     */
    protected function indexListing(Request $request, PostType $postType, $countrySlug = null)
    {
        $type = $postType->value;
        $categoryType = $postType->categoryType();
        $countryModel = null;
        $countryCode = null;
        $countryId = null;

        if ($countrySlug) {
            $countryModel = Country::findBySlugOrCode($countrySlug);
            if (!$countryModel) {
                abort(404);
            }
        } elseif ($postType === PostType::$NEWS) {
            $countryModel = Country::findBySlugOrCode('turkey');
        }

        if ($countryModel) {
            $countryCode = $countryModel->code;
            $countryId = $countryModel->id;
        }

        $curent_lang = (\LaravelLocalization::getCurrentLocale() == 'pe' ? 'fa' : \LaravelLocalization::getCurrentLocale());
        $title = 'title_' . $curent_lang;
        $content = 'content_' . $curent_lang;

        $q = Post::where('published', 1)->where($title, '!=', '');
        $q->where('post_type', $postType->value);
        if ($countryId) {
            $q->where('country_id', $countryId);
        }

        $is_category_page = false;
        $category = null;
        $slug = null;
        $categorySlug = $request->get('category');
        if ($categorySlug) {
            $categoryQuery = PostCategory::where('slug', $categorySlug)->where('type', $categoryType);
            if ($countryId) {
                $categoryQuery->where('country_id', $countryId);
            }
            $category = $categoryQuery->first();
            if (!$category) {
                abort(404);
            }
            $q->whereIn('id', function ($sub) use ($category) {
                $sub->select('post_id')->from('post_category')->where('post_category_id', $category->id);
            });
            $is_category_page = true;
            $slug = $category->slug;
        }

        if (isset($_GET['search'])) {
            $q->where("$content", 'like', '%' . $_GET['search'] . '%');
        }

        $sorting = isset($_GET['sort']) ? $_GET['sort'] : 'recent';

        switch ($sorting) {
            case "az":
                $q->orderBy("$title", "asc");
                break;
            case "za":
                $q->orderBy("$title", "desc");
                break;
            case "oldest":
                $q->orderBy("created_at", "asc");
                break;
            default:
                $q->orderBy("placement", "asc");
        }
        $posts = $q->with(array('photoCard', 'countryRel'))->paginate(9);

        $posts->appends(array('sort' => $sorting));

        if (isset($_GET['search'])) {
            $posts->appends(array('search' => $_GET['search']));
        }
        if ($slug) {
            $posts->appends(array('category' => $slug));
        }

        if ($request->ajax()) {
            $ajax = true;
            return view("front.blog.partials.list_posts", compact('posts', 'ajax', 'type'));
        }
        $categoriesQuery = PostCategory::where('type', $categoryType);
        if ($countryId) {
            $categoriesQuery->where('country_id', $countryId);
        }
        $categories = $categoriesQuery->orderBy("placement", "asc")->get();
        $hide_whatsapp = false;
        if ($category && in_array($category->id, array(3, 4, 5, 6))) {
            $hide_whatsapp = true;
        }

        if ($countryModel) {
            $listingUrl = route($postType->frontCountryRoute(), $countryModel->slug);
        } else {
            $listingUrl = route($postType->frontIndexRoute());
        }

        return view("front.blog.index", compact('posts', 'is_category_page', 'categories', 'type', 'categoryType', 'hide_whatsapp', 'countryCode', 'countryModel', 'listingUrl', 'slug', 'category'));
    }

    /**
     * News page: /{locale}/{country}/news/{post}
     *
     * @param string $country
     * @param string $post
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function showNews($country, $post)
    {
        return $this->showByType($country, $post, PostType::$NEWS);
    }

    /**
     * Shared show page for guides, developers, reports and news.
     * A post reached under the wrong type or country 301s to its canonical URL.
     *
     * @param string $country
     * @param string $post
     * @param PostType $postType
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected function showByType($country, $post, PostType $postType)
    {
        $with = array("projects", "categories", "countryRel");
        $row = Post::where("slug", $post)->ofPostType($postType)->with($with)->first();
        if (!$row) {
            $row = Post::where("slug", $post)->with($with)->first();
        }
        $isOldSlug = false;
        if (!$row) {
            $row = Post::where("old_slug", $post)->with($with)->first();
            $isOldSlug = (bool) $row;
        }
        if (!$row) {
            abort(404);
        }

        if ($isOldSlug || $row->postTypeEnum() !== $postType || $row->getCountrySlug() !== $country) {
            $geoUrl = $row->geoUrl();
            if (!$geoUrl) {
                abort(404);
            }
            $query = request()->getQueryString();
            return redirect()->to($geoUrl . ($query ? '?' . $query : ''), 301);
        }

        $type = $postType->value;
        $categoryType = $postType->categoryType();
        $countryId = $row->country_id;
        if (!$countryId && $row->countryRel) {
            $countryId = $row->countryRel->id;
        }

        $ajax_projects_url = '';
        if ($row->with_projects_blog == true) {
            $url = $row->projects_url;
            $t = explode('.com/', $url);
            $t = explode('/', isset($t[1]) ? $t[1] : '');
            $project_type = (isset($t[0]) ? $t[0] : 'property-for-sale');
            $city = (isset($t[1]) ? $t[1] : 'turkey');

            $regions = array();
            $project_categories = array();

            $var1 = (isset($t[2]) ? $t[2] : null);
            $var2 = (isset($t[3]) ? $t[3] : null);

            $var1 = $var1 ? explode(",", $var1) : array();
            $var2 = $var2 ? explode(",", $var2) : array();

            $q_tags = Helper::query("ProjectCategory", "whereIn", array("field" => "slug", "value" => $var1))->get();
            if (count($q_tags) > 0) {
                $project_categories = $var1;
            } else {
                $q_regions = Helper::query("Region", "whereIn", array("field" => "slug", "value" => $var1))->get();
                if (count($q_regions) > 0) {
                    $regions = $var1;
                }
            }
            if ($var2) {
                $q_regions = Helper::query("Region", "whereIn", array("field" => "slug", "value" => $var2))->get();
                $regions = $var2;
            }

            $str_regions = '';
            foreach ($regions as $reg) {
                $str_regions = $str_regions . '&regions[]=' . $reg;
            }

            $str_project_categories = '';
            foreach ($project_categories as $pcat) {
                $str_project_categories = $str_project_categories . '&project_categories[]=' . $pcat;
            }

            $ajax_projects_url = '/property-for-sale/turkey?city=' . $city . $str_regions . '&project_type=' . $project_type . '&rooms=' . $str_project_categories . '&ajax=1&curr=USD&price_fields=0';
            $ajax_projects_url = \LaravelLocalization::localizeUrl($ajax_projects_url);
        }

        $post_id = $row->id;
        $src = '';
        $cookie_reffer = Cookie::get('reffer');
        $coourl = parse_url($cookie_reffer);
        if (($cookie_reffer != str_replace('gclid=', '', $cookie_reffer))) {
            $src = "Adwords";
        } else {
            $src = @$coourl['host'] ? $coourl['host'] : (@$coourl['path'] ? $coourl['path'] : 'دخول مباشر');
        }

        if (($src != '' and strpos(strtolower($src), 'google') !== false) or (strpos(strtolower(\URL::previous()), 'google') !== false)) {
            $vrow = \App\Models\Googlevisit::where("visit_date", DB::raw("date(now())"))->where('post_id', $post_id)->first();

            $arrids = array();
            foreach ($row->categories()->lists('id') as $iid) {
                $arrids[] = $iid;
            }

            $cat_ids = ',' . implode(',', $arrids) . ',';
            if ($vrow == false) {
                DB::insert("INSERT INTO `dms_googlevisits`(`post_id`, `visit_date`, `visit_count`,cat_ids) VALUES (?,date(NOW()),1,?)", array($post_id, $cat_ids));
            } else {
                DB::update("UPDATE `dms_googlevisits` SET visit_count=visit_count+1,cat_ids=? WHERE `id`=?", array($cat_ids, $vrow->id));
            }
        }

        $faqs = \App\Models\Faq::where("str_posts", 'like', '%,' . $row->id . ',%')->get();

        $link_lang = '';
        $current_lang = (\LaravelLocalization::getCurrentLocale() == 'pe' ? 'fa' : \LaravelLocalization::getCurrentLocale());
        $title = 'title_' . $current_lang;

        if (trim($row->$title) == '') {
            abort(404);
        }

        $availables_langs = array();
        if (trim($row->title_en) != '') {
            $availables_langs[] = 'en';
        }
        if (trim($row->title_fr) != '') {
            $availables_langs[] = 'fr';
        }
        if (trim($row->title_ru) != '') {
            $availables_langs[] = 'ru';
        }
        if (trim($row->title_fa) != '') {
            $availables_langs[] = 'pe';
        }
        if (trim($row->title_ar) != '') {
            $availables_langs[] = 'ar';
        }

        if (isset($_SERVER["HTTP_REFERER"])) {
            $row->views += 1;
            $row->save();
        }

        $categoriesQuery = PostCategory::where('type', $categoryType);
        if ($countryId) {
            $categoriesQuery->where('country_id', $countryId);
        }
        $categories = $categoriesQuery->orderBy("placement", "asc")->get();

        $lang = $current_lang;
        $video_code = '';
        $videos = DB::select("SELECT dms_post_video.`post_id`, dms_post_video.`video_id`,dms_videos.link, dms_videos.lang,updated_at
		FROM `dms_post_video`
		left JOIN dms_videos on dms_videos.id=dms_post_video.video_id
		WHERE dms_post_video.`post_id`=? and dms_videos.lang like ?
		order by updated_at desc
		limit 1", array($row->id, '%' . $lang . '%'));

        if (isset($videos[0])) {
            $link_video = $videos[0]->link;
            parse_str(parse_url($link_video, PHP_URL_QUERY), $array_of_vars);
            $video_code = @$array_of_vars['v'];
        }

        $hide_whatsapp = false;
        if (isset($row->categories[0])) {
            if (in_array($row->categories[0]->id, array(3, 4, 5, 6))) {
                $hide_whatsapp = true;
            }
        }

        $post = $row;
        $listingUrl = route($postType->frontCountryRoute(), $country);

        return view("front.blog.show", compact("post", "ajax_projects_url", "link_lang", "categories", "video_code", "faqs", "availables_langs", 'type', 'categoryType', 'hide_whatsapp', 'listingUrl'));
    }
}
