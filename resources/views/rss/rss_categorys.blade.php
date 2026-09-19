<?= '<?xml version="1.0" encoding="ISO-8859-1"?>'; ?>
<rss version="2.0">
    <channel>
        <title><?= $category->getName(); ?></title>
        <link><?= url('/'.$category->slug); ?></link>
        <description><?= $category->getSeoDescription(); ?></description>
        <language><?= LaravelLocalization::getCurrentLocale(); ?></language>
        @foreach($posts as $row)
        <item>
            <title><?= $row->getTitle(); ?></title>
            <description><?= preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $row->getSeoDescription()); ?></description>

				@if($row->type == "news")
					<link><?= route("front.news.post", $row->slug); ?></link>
				@else
					<link><?= route("front.blog.post", $row->slug); ?></link>
				@endif

            <pubDate><?= $row->created_at->tz('UTC')->toAtomString(); ?></pubDate>
        </item>
        @endforeach
    </channel>
</rss>