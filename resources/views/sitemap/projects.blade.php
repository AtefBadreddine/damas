<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
    @foreach ($projects as $project)
        <?php
            $img = Helper::media_url($project->cardPhoto);
            // video
            $link_video = $project->getLinkVideo();
            parse_str(parse_url($link_video, PHP_URL_QUERY), $array_of_vars);
            $video_code = @$array_of_vars['v'];
        ?>
        <url>
            <loc><?= $project->frontUrl(); ?></loc>
            <lastmod><?= $project->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.9</priority>
            <image:image>
                <image:loc><?= $img; ?></image:loc>
            </image:image>
			@foreach($project->projectPhotos as $pimg)
                <image:image>
                    <image:loc><?= Helper::media_url($pimg); ?></image:loc>
                </image:image>
            @endforeach
            @if($link_video)
            <video:video>
                <video:player_loc allow_embed="yes">https://www.youtube.com/v/{{$video_code}}</video:player_loc>
                <video:thumbnail_loc>{{$img}}</video:thumbnail_loc>
                <video:title>{{$project->getName()}}</video:title>
            </video:video>
            @endif
        </url>
    @endforeach
</urlset>