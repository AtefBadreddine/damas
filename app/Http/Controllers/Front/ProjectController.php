<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\BaseController;
use App\Models\Project;
use Illuminate\Support\Facades\Redirect;
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
        if ($row && $row->geoUrl()) {
            return Redirect::to($row->geoUrl(), 301);
        }

        $row = Project::where("slug", $project)->with(array("city.countryRel", "region"))->first();
        if (!$row || !$row->city) {
            abort(404);
        }

        $redirect = $this->redirectIfNotCanonical($row->geoUrl());
        if ($redirect) {
            return $redirect;
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
     * 301 to the canonical geo path when country/city/region/slug do not match.
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
