<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
<?php
	$locale = LaravelLocalization::getCurrentLocale();
	$current_lang = ($locale == 'pe' ? 'fa' : $locale);
	$pageUrl = function ($path) use ($locale) {
		return url($locale . '/' . ltrim($path, '/'));
	};

	$pages = Helper::query("Page", "all");
	$countryCodes = \App\Models\Country::lists('code')->all();
	$citys = Helper::query("City", "orderByPlacement");
	$listingCitys = $citys->filter(function ($c) use ($countryCodes) {
		return !in_array($c->slug, $countryCodes);
	});
	$allregions = \App\Models\Region::with('city')->get()->filter(function ($reg) use ($countryCodes) {
		return $reg->city && !in_array($reg->city->slug, $countryCodes);
	});

	$countries = array();
	foreach ($citys as $c) {
		$countrySlug = $c->getCountrySlug();
		if ($countrySlug && !isset($countries[$countrySlug])) {
			$countries[$countrySlug] = \App\Models\Country::findBySlug($countrySlug);
		}
	}
	$countries = array_filter($countries);

	$postHubs = array();
	foreach (\App\Enums\PostType::cases() as $postType) {
		$postHubs[] = route($postType->frontIndexRoute());
		$postCountries = \App\Models\Post::ofPostType($postType)
			->where('published', 1)
			->where('title_' . $current_lang, '!=', '')
			->select('country_id', 'country')
			->distinct()
			->get();
		$hubSlugs = array();
		foreach ($postCountries as $p) {
			$countrySlug = $p->getCountrySlug();
			if ($countrySlug && !in_array($countrySlug, $hubSlugs)) {
				$hubSlugs[] = $countrySlug;
				$postHubs[] = route($postType->frontCountryRoute(), $countrySlug);
			}
		}
	}
?>
	@foreach (LaravelLocalization::getSupportedLanguagesKeys() as $homeLocale)
	<url>
		<loc><?= $homeLocale == LaravelLocalization::getDefaultLocale() ? url('/') : url($homeLocale); ?></loc>
		<changefreq>monthly</changefreq>
		<priority>1</priority>
	</url>
	@endforeach

	<url>
		<loc><?= route('front.projects'); ?></loc>
		<changefreq>weekly</changefreq>
		<priority>0.9</priority>
	</url>

	@foreach ($countries as $country)
	<url>
		<loc><?= $country->listingUrl(); ?></loc>
		@if ($country->updated_at)
		<lastmod><?= $country->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
		@endif
		<changefreq>monthly</changefreq>
		<priority>0.9</priority>
	</url>
	@endforeach

	@foreach ($listingCitys as $c)
		<?php $cityUrl = $c->listingUrl(); ?>
		@if ($cityUrl)
		<url>
			<loc><?= $cityUrl; ?></loc>
			<lastmod><?= $c->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
			<changefreq>monthly</changefreq>
			<priority>0.9</priority>
		</url>
		@endif
	@endforeach

	@foreach ($allregions as $reg)
		<?php $regionUrl = $reg->listingUrl(); ?>
		@if ($regionUrl)
		<url>
			<loc><?= $regionUrl; ?></loc>
			<lastmod><?= $reg->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
			<changefreq>monthly</changefreq>
			<priority>0.9</priority>
		</url>
		@endif
	@endforeach

	@foreach ($postHubs as $hubUrl)
	<url>
		<loc><?= $hubUrl; ?></loc>
		<changefreq>weekly</changefreq>
		<priority>0.9</priority>
	</url>
	@endforeach

	@foreach ($pages as $p)
		@if ($p->hide_sitemap == 0)
		<url>
			<loc><?= $pageUrl($p->slug_link); ?></loc>
			<lastmod><?= $p->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
			<changefreq>monthly</changefreq>
			<priority>1</priority>
		</url>
		@endif
	@endforeach

	@foreach ($citys as $c)
		@if ($c->enable_district_page == true)
		<url>
			<loc><?= $pageUrl($c->slug . '-districts'); ?></loc>
			<lastmod><?= $c->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
			<changefreq>monthly</changefreq>
			<priority>1</priority>
		</url>
		@foreach ($c->regions()->where('show_on_districts_page', true)->get() as $reg)
		<url>
			<loc><?= $pageUrl($c->slug . '-districts/' . $reg->slug); ?></loc>
			<lastmod><?= $reg->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
			<changefreq>monthly</changefreq>
			<priority>1</priority>
		</url>
		@endforeach
		@endif
	@endforeach

	@foreach (\App\Models\Job::orderBy('id', 'desc')->get() as $job)
	<url>
		<loc><?= route('front.job_details', $job->slug); ?></loc>
		<lastmod><?= $job->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
		<changefreq>monthly</changefreq>
		<priority>1</priority>
	</url>
	@endforeach
</urlset>
