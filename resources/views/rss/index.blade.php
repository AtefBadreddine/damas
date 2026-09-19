<?= '<?xml version="1.0" encoding="ISO-8859-1"?>'; ?>
<rss version="2.0">
    <channel>
        <title><?= $infos->seo_title; ?></title>
        <link><?= url('/'); ?></link>
        <description><?= $infos->seo_description; ?></description>
        <language><?= LaravelLocalization::getCurrentLocale(); ?></language>
        @foreach($rows as $row)
        <item>
            <title><?= $row->title; ?></title>
            <description><?= preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $row->description); ?></description>
            @if($row->table_name() == "projects")
                <link><?= route("front.project", $row->slug); ?></link>
            @else
				@if($row->type == "news")
					<link><?= route("front.news.post", $row->slug); ?></link>
				@else
					<link><?= route("front.blog.post", $row->slug); ?></link>
				@endif
            @endif
            <pubDate><?= $row->created_at->tz('UTC')->toAtomString(); ?></pubDate>
        </item>
        @endforeach
    </channel>
</rss>