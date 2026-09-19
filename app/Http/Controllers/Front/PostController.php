<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\BaseController;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Support\Facades\Redirect;
use Helper;
use DB;
use Cookie;

class PostController extends BaseController
{
    /**
     * Blog page: /{locale}/{country}/buying-guide/{post}
     *
     * @param string $country
     * @param string $post
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function show($country, $post)
    {
        $row = Post::where("slug", $post)->where("type", "blog")->with(array("projects", "categories", "countryRel"))->first();
        if (!$row) {
            abort(404);
        }

        $redirect = $this->redirectIfNotCanonical($row->geoUrl());
        if ($redirect) {
            return $redirect;
        }

        $type = $row->type ? $row->type : 'blog';
        $countryCode = $row->country;

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

        $categories = PostCategory::where('type', $type)->where('country', $countryCode)->orderBy("placement", "asc")->get();

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

        return view("front.blog.show", compact("post", "ajax_projects_url", "link_lang", "categories", "video_code", "faqs", "availables_langs", 'type', 'hide_whatsapp'));
    }

    /**
     * 301 to the canonical geo path when country/slug do not match.
     *
     * @param string $canonicalUrl
     * @return \Illuminate\Http\RedirectResponse|null
     */
    protected function redirectIfNotCanonical($canonicalUrl)
    {
        if (!$canonicalUrl) {
            return null;
        }

        $current = '/' . trim(request()->path(), '/');
        $canonicalPath = parse_url($canonicalUrl, PHP_URL_PATH);
        $canonicalPath = '/' . trim($canonicalPath, '/');

        if (urldecode($current) !== urldecode($canonicalPath)) {
            $query = request()->getQueryString();
            return Redirect::to($canonicalUrl . ($query ? '?' . $query : ''), 301);
        }

        return null;
    }
}
