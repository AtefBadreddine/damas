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
	/*------------
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
	foreach($pages as $p){
		if($p->hide_sitemap==0){
		?>
		<url>
			<loc><?= route('front.index') .'/'. $p->slug_link; ?></loc>
			<lastmod><?= $p->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
			<changefreq>monthly</changefreq>
			<priority>1</priority>
		</url>
	<?php }}  ?>
	
	@foreach ($citys as $c)
		@if($c->enable_district_page==true)
		<url>
			<loc><?= route('front.index') .'/'. $c->slug . '-districts' ; ?></loc>
			<lastmod><?= $c->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
			<changefreq>monthly</changefreq>
			<priority>1</priority>
		</url>
		<?php $regions = $c->regions()->where('show_on_districts_page',true)->get();//where('city_id',$city->id)->
		
		foreach($regions as $reg){ ?>
		<url>
			<loc><?= route('front.index') .'/'. $c->slug . '-districts/'.$reg->slug ; ?></loc>
			<lastmod><?= $reg->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
			<changefreq>monthly</changefreq>
			<priority>1</priority>
		</url>
		<?php } ?>
		@endif
    @endforeach

		<?php
		/*
		<url>
			<loc><?= route('front.index') .'/video' ; ?></loc>
			<lastmod><?= $c->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
			<changefreq>monthly</changefreq>
			<priority>1</priority>
		</url>
		*/ ?>
		
		
		<?php
		$arr_pips = DB::select("select distinct(concat(dms_projects_types.slug ,dms_cities.slug ,dms_projects_categories.slug)) as 'asx',
		dms_projects_types.slug as 'pt_slug',dms_cities.slug as 'city_slug',dms_projects_categories.slug as 'cat_slug' 
from dms_projects_types,dms_cities,dms_projects_categories,
dms_project_type,dms_project_category,dms_projects
WHERE dms_projects.city_id=dms_cities.id 
and dms_projects_categories.id=dms_project_category.project_category_id and dms_projects.id=dms_project_category.project_id
and dms_project_type.project_id=dms_projects.id and dms_project_type.project_type_id=dms_projects_types.id
and dms_projects.published=1");
		//appartment-for-sale/istanbul/istanbul-investment
		$used_links = [];
		foreach($arr_pips as $r){ ?>
			<url>
				<loc><?= route("front.search", [ $r->pt_slug, $r->city_slug, $r->cat_slug]); ?></loc>
				<changefreq>monthly</changefreq>
				<priority>0.9</priority>
			</url>
			<?php if(!in_array( ('property-for-sale' . $r->city_slug . $r->cat_slug) ,$used_links)){
				$used_links[] = ('property-for-sale' . $r->city_slug . $r->cat_slug);
				?>
			<url>
				<loc><?= route("front.search", [ 'property-for-sale', $r->city_slug, $r->cat_slug]); ?></loc>
				<changefreq>monthly</changefreq>
				<priority>0.9</priority>
			</url>
			<?php } ?>
		<?php if($r->city_slug=='istanbul'){ ?>
			<url>
				<loc><?= route("front.search", [ $r->pt_slug, 'turkey', $r->cat_slug]); ?></loc>
				<changefreq>monthly</changefreq>
				<priority>0.9</priority>
			</url>
			<?php
				if(!in_array( ('property-for-sale' . 'turkey' . $r->cat_slug) ,$used_links)){
				$used_links[] = ('property-for-sale' . 'turkey' . $r->cat_slug);
				?>
				<url>
					<loc><?= route("front.search", [ 'property-for-sale', 'turkey', $r->cat_slug]); ?></loc>
					<changefreq>monthly</changefreq>
					<priority>0.9</priority>
				</url>
				<?php } ?>
		<?php }
		}
		
		
		
		$jobs = \App\Models\Job::orderBy('id','desc')->get();
		
		?>
		@foreach ($jobs as $c)
		<url>
			<loc>{{ route('front.job_details',$c->slug) }}</loc>
			<lastmod><?= $c->updated_at->tz('UTC')->toAtomString(); ?></lastmod>
			<changefreq>monthly</changefreq>
			<priority>1</priority>
		</url>
		@endforeach

<url>
<loc>https://damas.net/</loc>
<changefreq>monthly</changefreq>
<priority>1</priority>
</url>
<url>
<loc>https://damas.net/en/</loc>
<changefreq>monthly</changefreq>
<priority>1</priority>
</url>
<url>
<loc>https://damas.net/fr/</loc>
<changefreq>monthly</changefreq>
<priority>1</priority>
</url>
<url>
<loc>https://damas.net/pe/</loc>
<changefreq>monthly</changefreq>
<priority>1</priority>
</url>
<url>
<loc>https://damas.net/ru/</loc>
<changefreq>monthly</changefreq>
<priority>1</priority>
</url>

</urlset>