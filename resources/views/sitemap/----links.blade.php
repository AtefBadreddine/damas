<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
    <?php
	$pages = Helper::query("Page", "all");
	$citys = Helper::query("City", "orderByPlacement");
	$projectstype = Helper::query("ProjectType", "orderByPlacement");
	$allregions = Helper::query("Region", "all");
	$ProjectCategorys = Helper::query("ProjectCategory", "all");
	?>
	@foreach ($citys as $c)
        <url>
            <loc><?= route("front.search", ['property-for-sale', $c->slug]); ?></loc>
            <lastmod><?= $c->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.9</priority>
        </url>
		@foreach($projectstype as $pt)
			<url>
				<loc><?= route("front.search", [ $pt->slug, $c->slug ]); ?></loc>
				<lastmod><?= $pt->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
				<changefreq>monthly</changefreq>
				<priority>0.9</priority>
			</url>
			
			
			<?php
	/*foreach($allregions as $reg){
		if($reg->city_id==$c->id){ 
			//appartments-for-sale/istanbul/bashak-shahir ?>
			?>
			<url>
				<loc><?= route("front.search", [$pt->slug, $c->slug, $reg->slug ]); ?></loc>
				<lastmod><?= $reg->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
				<changefreq>monthly</changefreq>
				<priority>0.9</priority>
			</url>
		<?php }
	}*/
	?>
	
	
	
	<?php
	//property-for-sale/turkey/istanbul-investment
	/*
	?>
	@foreach($ProjectCategorys as $pcat)
			<url>
				<loc><?= route("front.search", [ $pt->slug, $c->slug, $pcat->slug]); ?></loc>
				<lastmod><?= $pcat->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
				<changefreq>monthly</changefreq>
				<priority>0.9</priority>
			</url>
	@endforeach
	<?php */ ?>
	@endforeach
		
		
		
		<?php
		
	foreach($allregions as $reg){
		if($reg->city_id==$c->id){ ?>
			<url>
				<loc><?= route("front.search", ['property-for-sale', $c->slug, $reg->slug ]); ?></loc>
				<lastmod><?= $reg->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
				<changefreq>monthly</changefreq>
				<priority>0.9</priority>
			</url>
		<?php } 
	}
	?>
		
		
    @endforeach
	
	<?php
	foreach($pages as $p){ ?>
		<url>
			<loc><?= route('front.index') .'/'. $p->slug_link; ?></loc>
			<lastmod><?= $p->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
			<changefreq>monthly</changefreq>
			<priority>1</priority>
		</url>
	<?php }  ?>
	
	@foreach ($citys as $c)
		@if($c->enable_district_page==true)
		<url>
			<loc><?= route('front.index') .'/'. $c->slug . '-districts' ; ?></loc>
			<lastmod><?= $c->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
			<changefreq>monthly</changefreq>
			<priority>1</priority>
		</url>
		@endif
    @endforeach
</urlset>