<?php
$name_route = Route::currentRouteName();
$auth_user = Auth::user();
?>
<style>
    .fa-angle-right {
        transition: all 250ms ease;
        transform: rotate(0deg);
    }
    .fa-angle-right.rotate {
        transform: rotate(90deg);
    }
</style>
<ul class="sidebar-menu direction">
    <li class="header"></li>
	<?php
	if (isset($_SERVER['SERVER_NAME']) && strpos($_SERVER['SERVER_NAME'],'administrator.damas.net') !== false ) { ?>
    
    <!-- Start Media -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.medias'))
    <li class="treeview <?= Helper::container_array($name_route, ["admin.medias", "admin.apparence.sectionvideos", "admin.videos"]) ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa fa-file-picture-o"></i> <span>Media</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="<?= Helper::container_array($name_route, ['admin.medias']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.medias'); ?>"><i class="fa fa-angle-double-right"></i>Images</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.medias.folders']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.medias.folders'); ?>"><i class="fa fa-angle-double-right"></i>Image Folders</a>
            </li>
            <!--<li class="<?= Helper::container_array($name_route, ['admin.videos']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.videos'); ?>"><i class="fa fa-angle-double-right"></i>Videos</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.apparence.sectionvideos']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.apparence.sectionvideos'); ?>"><i class="fa fa-angle-double-right"></i>V.Categories</a>
            </li>-->
        </ul>
    </li>
	@endif
	<?php }else{ ?>
	
	<!-- Start Whatsapp API -->
    @if($auth_user->is('superadmin'))
    <li class="treeview <?= Helper::container_array($name_route, ['admin.anchors']) ? 'active menu-open' : ''; ?>">
        <a href="#">
            <i class="fa fa-whatsapp"></i> <span>Leads</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu" style="<?= Helper::container_array($name_route, ['admin.whatsappapi']) ? 'display: block;' : ''; ?>">
            <li class="<?= ($name_route == 'admin.whatsappapi') ? 'active' : ''; ?>">
                <a href="<?= route('admin.whatsappapi'); ?>">
                    <i class="fa fa-angle-double-right"></i> Webhooks
                </a>
            </li>
            <li class="<?= ($name_route == 'admin.whatsapp_contacts') ? 'active' : ''; ?>">
                <a href="<?= route('admin.whatsapp_contacts'); ?>">
                    <i class="fa fa-angle-double-right"></i> Contacts (W. API)
                </a>
            </li>
            <li class="<?= ($name_route == 'admin.whatsapp_chat') ? 'active' : ''; ?>">
                <a href="<?= route('admin.whatsapp_chat'); ?>">
                    <i class="fa fa-angle-double-right"></i> Chat (W. API)
                </a>
            </li>
            @if($auth_user->is('superadmin') or $auth_user->can('admin.whatsapp_msg'))
            <li class="<?= Helper::container_array($name_route, ['admin.whatsapp_msg']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.whatsapp_msg'); ?>"><i class="fa fa-angle-double-right"></i> WhatsApp</a>
            </li>
            @endif
            @if($auth_user->is('superadmin') or $auth_user->can('admin.messages'))
            <li class="<?= ($name_route == 'admin.messages') ? 'active' : ''; ?>">
                <a href="<?= route('admin.messages'); ?>"><i class="fa fa-angle-double-right"></i> Leads</a>
            </li>
            @endif
			@if($auth_user->is('superadmin') or $auth_user->can('admin.backup_msg'))
            <li class="<?= ($name_route == 'admin.backup_msg') ? 'active' : ''; ?>">
                <a href="<?= route('admin.backup_msg'); ?>"><i class="fa fa-angle-double-right"></i> Backup Leads</a>
            </li>
            @endif
            <li class="<?= $name_route == 'admin.cta' ? 'active' : ''; ?>">
                <a href="<?= route('admin.cta'); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <span>CTA</span>
                </a>
            </li>

        </ul>
    </li>
    @endif
    <!-- End Whatsapp API -->
	
	<!-- Start SEO -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.landing_tourism') or $auth_user->can('admin.statistics') or $auth_user->can('admin.messages') or $auth_user->can('admin.whatsapp_msg') or $auth_user->can('admin.messagesvac') or $auth_user->can('admin.newsletter') or $auth_user->can('admin.wordsearch') or $auth_user->can('admin.redirectsearchprojects') or $auth_user->can('admin.search'))
    <li class="treeview <?= Helper::container_array($name_route, ["admin.quizs","admin.backup_msg", "admin.statistics", "admin.messages", "admin.whatsapp_msg", "admin.messagesvac", "admin.wordsearch", "admin.search", "admin.redirectsearchprojects", "admin.newsletter"]) ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa fa-search"></i> <span>SEO</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="<?= ($name_route == 'admin.anchors') ? 'active' : ''; ?>">
                <a href="<?= route('admin.anchors'); ?>">
                    <i class="fa fa-angle-double-right"></i> Internal Links
                </a>
            </li>
            <li class="<?= $name_route == 'admin.metatag_tool' ? 'active' : ''; ?>">
                <a href="<?= route('admin.metatag_tool'); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <span>Metatag Tool</span>
                </a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.sitemap']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.sitemap'); ?>"><i class="fa fa-angle-double-right"></i> Sitemap</a>
            </li>
            
			
            

            <?php /*
              @if($auth_user->is('superadmin') or $auth_user->can('admin.whatsapp_msg'))
              <li class="<?= Helper::container_array($name_route, ['admin.quizs']) ? 'active' : ''; ?>">
              <a href="<?= route('admin.quizs'); ?>"><i class="fa fa-angle-double-right"></i> Competition</a>
              </li>
              @endif
             */ ?>

            @if($auth_user->is('superadmin') or $auth_user->can('admin.messagesvac'))
            <!--<li class="<?= ($name_route == 'admin.messagesvac') ? 'active' : ''; ?>">
                <a href="<?= route('admin.messagesvac'); ?>"><i class="fa fa-angle-double-right"></i> HR Cvs</a>
            </li>-->
            @endif

            @if($auth_user->is('superadmin') or $auth_user->can('admin.newsletter'))
            <!--<li class="<?= Helper::container_array($name_route, ['admin.newsletter']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.newsletter'); ?>"><i class="fa fa-angle-double-right"></i> Newsletter</a>
            </li>-->
            @endif

            @if($auth_user->is('superadmin') or $auth_user->can('admin.statistics'))
            <li class="<?= Helper::container_array($name_route, ['admin.statistics']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.statistics'); ?>"><i class="fa fa-angle-double-right"></i> Statistics </a>
            </li>
            @endif

            @if($auth_user->is('superadmin'))
            <li class="treeview <?= Helper::container_array($name_route, ['admin.redirectsearchprojects', 'admin.search', 'admin.wordsearch']) ? ' menu-open' : ''; ?>">
                <a href="#"><i class="fa fa-angle-double-right"></i> Search</a>
                <ul class="treeview-menu" style="<?= Helper::container_array($name_route, ['admin.wordsearch', 'admin.search', 'admin.wordsearch']) ? 'display: block;' : ''; ?>">
                    <li class="<?= Helper::container_array($name_route, ['admin.search']) ? 'active' : ''; ?>"><a href="<?= route('admin.search'); ?>?field=updated_at&sort=desc&page=1&lang=ar"><i class="fa fa-circle-o"></i> Statistics</a></li>

                    <li class="<?= Helper::container_array($name_route, ['admin.redirectsearchprojects']) ? 'active' : ''; ?>"><a href="<?= route('admin.redirectsearchprojects'); ?>"><i class="fa fa-circle-o"></i> Project research</a></li>
                    <li class="<?= Helper::container_array($name_route, ['admin.wordsearch']) ? 'active' : ''; ?>"><a href="<?= route('admin.wordsearch'); ?>"><i class="fa fa-circle-o"></i> Post research </a></li>
                    <?php /* ?>
                      <li>**</li>
                      <li>**</li>
                      <li class="<?= ($name_route=='admin.wordsearch') ? 'active' : ''; ?>"><a href="<?= route('admin.wordsearch'); ?>"><i class="fa fa-circle-o"></i> الكلمات المتشابهة</a></li>
                      <li class="<?= Helper::container_array($name_route, ['admin.wordsearch']) ? 'active' : ''; ?>"><a href="<?= route('admin.wordsearch'); ?>"><i class="fa fa-circle-o"></i> توجيه البحث</a></li>
                      <?php */ ?>

                    <?php /*
                      <!--
                      <li class="<?= Helper::container_array($name_route, ['admin.redirectsearchprojects']) ? 'active' : ''; ?>"><a href="<?= route('admin.redirectsearchprojects'); ?>"><i class="fa fa-circle-o"></i> توجيه بحث المشاريع</a></li>
                      <li class="<?= Helper::container_array($name_route, ['admin.redirectsearchposts']) ? 'active' : ''; ?>"><a href="<?= route('admin.redirectsearchposts'); ?>"><i class="fa fa-circle-o"></i> توجيه بحث المقالات</a></li>-->
                     */ ?>
                </ul>
            </li>			
            @endif


        </ul>
    </li>
    @endif

    <!-- End SEO -->
    @if($auth_user->is('superadmin'))
    <li class="treeview <?= Helper::container_array($name_route, ['admin.companies', "admin.projects", "admin.regions", "admin.projecttype", "admin.projectcategory", "admin.cities", "admin.salesmanagers", "admin.projectfeature", "admin.introcard"]) ? 'active' : ''; ?>">
        <a>
            <i class="fa fa-cubes"></i> <span>Listings</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            @if($auth_user->is('superadmin') or $auth_user->can('admin.pages.search'))
            <li class="<?= Helper::container_array($name_route, ['admin.pages.search']) ? ' active' : ''; ?>">
                <a href="<?= route('admin.pages.search'); ?>"><i class="fa fa-angle-double-right"></i> Old Listings</a>
            </li>
            @endif
            <li>
                <a href="<?= route('admin.countries'); ?>"><i class="fa fa-angle-double-right"></i> Countries</a>
            </li>
            @if($auth_user->is('superadmin') or $auth_user->can('admin.cities'))
            <li class="<?= Helper::container_array($name_route, ['admin.cities']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.cities'); ?>"><i class="fa fa-angle-double-right"></i> Cities</a>
            </li>
            @endif
            @if($auth_user->is('superadmin') or $auth_user->can('admin.regions'))
            <li class="<?= Helper::container_array($name_route, ['admin.regions']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.regions'); ?>"><i class="fa fa-angle-double-right"></i> Districts</a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    <!-- Start Properties -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.projects') or $auth_user->can('admin.cities') or $auth_user->can('admin.regions') or $auth_user->can('admin.salesmanagers'))
    <li class="treeview <?= Helper::container_array($name_route, ['admin.companies', "admin.projects", "admin.regions", "admin.projecttype", "admin.projectcategory", "admin.cities", "admin.salesmanagers", "admin.projectfeature", "admin.introcard"]) ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa fa-cubes"></i> <span>Properties</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">

            @if($auth_user->is('superadmin') or $auth_user->can('admin.projects'))
            <li class="<?= Helper::container_array($name_route, ['admin.projects']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.projects'); ?>"><i class="fa fa-angle-double-right"></i> Properties</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.projecttype']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.projecttype'); ?>"><i class="fa fa-angle-double-right"></i> Types</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.projectcategory']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.projectcategory'); ?>"><i class="fa fa-angle-double-right"></i> Features</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.projectfeature']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.projectfeature'); ?>"><i class="fa fa-angle-double-right"></i> Facilities</a>
            </li>
			<li class="<?= Helper::container_array($name_route, ['admin.introcard.edit']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.introcard.edit'); ?>"><i class="fa fa-angle-double-right"></i> Intro Cards</a>
            </li>
			<!--<li class="<?= Helper::container_array($name_route, ['admin.projectfilter.edit']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.projectfilter.edit'); ?>"><i class="fa fa-angle-double-right"></i> Search Filters</a>
            </li>-->
            @endif
        </ul>
    </li>
    @endif
    <!-- End Properties -->
    

    <!-- Start Blog -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.blog'))
    <li class="treeview <?= Helper::container_array($name_route, ["admin.blog","admin.news","admin.developer","admin.report","admin.fpost"]) ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa fa-newspaper-o"></i> <span>Posts</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="<?= Helper::container_array($name_route, ['admin.blog.posts']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.blog.posts'); ?>"><i class="fa fa-angle-double-right"></i>Guides</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.developer.posts']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.developer.posts'); ?>"><i class="fa fa-angle-double-right"></i>Developers</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.report.posts']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.report.posts'); ?>"><i class="fa fa-angle-double-right"></i>Reports</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.news.posts']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.news.posts'); ?>"><i class="fa fa-angle-double-right"></i>News</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.blog.categories']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.blog.categories'); ?>"><i class="fa fa-angle-double-right"></i>Categories</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.blog.tags']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.blog.tags'); ?>"><i class="fa fa-angle-double-right"></i>Tags</a>
            </li>
<!--            <li class="<?= Helper::container_array($name_route, ['admin.blog.sections']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.blog.sections'); ?>"><i class="fa fa-angle-double-right"></i> Sections</a>
            </li>-->
        </ul>
    </li>
	
	
    @endif
    <!-- End Blog -->
    
    <!-- Start Pages -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.pages.search') or $auth_user->can('admin.landingpage') or $auth_user->can('admin.faq'))
    <li class="treeview <?= Helper::container_array($name_route, ["admin.newlandingpage","admin.landing_tourism", "admin.pages.search", "admin.pages.turkish_citizenship", "admin.pages.legal", "admin.pages.investment", "admin.pages.aboutus", "admin.pages.terms", "admin.pages.privacy", "admin.branch", "admin.landingpage",'admin.pages.rating','admin.pages.resale','admin.pages.turkish_nationality','admin.rating', "admin.sitemap"]) ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa fa-files-o"></i> <span>Landing </span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            @if($auth_user->is('superadmin') or $auth_user->can('admin.landingpage'))
            <li class="<?= Helper::container_array($name_route, ['admin.newlandingpage']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.newlandingpage'); ?>"><i class="fa fa-angle-double-right"></i>New Landing Pages</a>
            </li>
			<li class="<?= Helper::container_array($name_route, ['admin.landingpage']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.landingpage'); ?>"><i class="fa fa-angle-double-right"></i>Landing Pages</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.landing2']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.landing2'); ?>"><i class="fa fa-angle-double-right"></i>Landing Offers</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.landing3']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.landing3'); ?>"><i class="fa fa-angle-double-right"></i>New Landing Offers</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.landing_tourism']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.landing_tourism'); ?>"><i class="fa fa-angle-double-right"></i>Tourism Landing</a>
            </li>
            @endif
            @if($auth_user->is('superadmin') or $auth_user->can('admin.landing_tourism'))
            <li class="<?= ($name_route == 'admin.messages_landing_index') ? 'active' : ''; ?>">
                <a href="<?= route('admin.messages_landing_index'); ?>"><i class="fa fa-angle-double-right"></i> Tourism Landing Message</a>
            </li>
            @endif


            @if($auth_user->is('superadmin'))
            <li class="<?= Helper::container_array($name_route, ['admin.pages.turkish_citizenship']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.pages.turkish_citizenship'); ?>"><i class="fa fa-angle-double-right"></i>Citizenship</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.pages.legal']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.pages.legal'); ?>"><i class="fa fa-angle-double-right"></i>Legal</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.pages.investment']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.pages.investment'); ?>"><i class="fa fa-angle-double-right"></i>Investment</a>
            </li>
            <?php /*
              <li class="<?= Helper::container_array($name_route, ['admin.pages.quiz']) ? 'active' : ''; ?>">
              <a href="<?= route('admin.pages.quiz'); ?>"><i class="fa fa-angle-double-right"></i> Competition form</a>
              </li> */ ?>
			  @endif
			<?php /*@if($auth_user->is('superadmin') or $auth_user->can('admin.pages.aboutus'))
            <li class="<?= Helper::container_array($name_route, ['admin.pages.aboutus']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.pages.aboutus'); ?>"><i class="fa fa-angle-double-right"></i> About us</a>
            </li>
			@endif */ ?>

            @if($auth_user->can('admin.branch'))  @endif


            

            <li class="<?= Helper::container_array($name_route, ['admin.pages.terms']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.pages.terms'); ?>"><i class="fa fa-angle-double-right"></i>Terms of Use</a>
            </li>

            <li class="<?= Helper::container_array($name_route, ['admin.pages.privacy']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.pages.privacy'); ?>"><i class="fa fa-angle-double-right"></i>Privacy Policy</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.pages.turkey_guide']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.pages.turkey_guide'); ?>"><i class="fa fa-angle-double-right"></i>Turkey guide</a>
            </li>





        </ul>
    </li>
    @endif
    <!-- End Pages -->

    <!-- Start Media -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.medias'))
    <li class="treeview <?= Helper::container_array($name_route, ["admin.medias", "admin.apparence.sectionvideos", "admin.videos"]) ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa fa-file-picture-o"></i> <span>Media</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="<?= Helper::container_array($name_route, ['admin.medias']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.medias'); ?>"><i class="fa fa-angle-double-right"></i>Images</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.medias.folders']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.medias.folders'); ?>"><i class="fa fa-angle-double-right"></i>Image Folders</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.videos']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.videos'); ?>"><i class="fa fa-angle-double-right"></i>Videos</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.apparence.sectionvideos']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.apparence.sectionvideos'); ?>"><i class="fa fa-angle-double-right"></i>V. Categories</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.pages.360']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.pages.360'); ?>"><i class="fa fa-angle-double-right"></i>360</a>
            </li>
        </ul>
    </li>

    @endif
    <!-- End Media -->



    <!-- Start Jobs -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.jobs'))
    <li class="treeview <?= Helper::container_array($name_route, ["admin.jobs","admin.pages.vacancies"]) ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa fa fa-tasks"></i> <span>Jobs</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">

			<li class="<?= Helper::container_array($name_route, ['admin.pages.vacancies']) ? 'active' : ''; ?>">
			<a href="<?= route('admin.pages.vacancies'); ?>"><i class="fa fa-angle-double-right"></i> Page Jobs</a>
			</li>
			<li class="<?= Helper::container_array($name_route, ['admin.jobs']) ? 'active' : ''; ?>">
			<a href="<?= route('admin.jobs'); ?>"><i class="fa fa-angle-double-right"></i> List Jobs</a>
			</li>

        </ul>
    </li>
    @endif
    
    <!--End Jobs-->
    <li class="treeview <?= Helper::container_array($name_route, ["admin.pages.faq", "admin.faqpost"]) ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa fa-question"></i> <span>FAQ </span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="<?= Helper::container_array($name_route, ['admin.pages.faq']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.pages.faq'); ?>"><i class="fa fa-angle-double-right"></i>Main page</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.faqpost']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.faqpost'); ?>"><i class="fa fa-angle-double-right"></i>Categories</a>
            </li>
        </ul>	
    </li>
    <!-- Start Settings -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.apparence') or $auth_user->can('admin.params') or $auth_user->can('admin.redirect_short') or $auth_user->can('admin.support') or $auth_user->can('admin.stats'))
    <li class="treeview <?= Helper::container_array($name_route, ["admin.params", "admin.stats", "admin.redirect_short", "admin.support", "admin.clientsource", 'admin.clear_cache', 'admin.users','admin.keywords2']) ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa fa-gears"></i> <span>Settings</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="<?= Helper::container_array($name_route, ['admin.apparence.menus']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.apparence.menus'); ?>"><i class="fa fa-angle-double-right"></i>Side menu</a>
            </li>
            <?php /*<li class="<?= Helper::container_array($name_route, ['admin.apparence.sliders']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.apparence.sliders'); ?>"><i class="fa fa-angle-double-right"></i>Sliders</a>
            </li>*/ ?>
			<li class="<?= Helper::container_array($name_route, ['admin.apparence.sections']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.apparence.sections'); ?>"><i class="fa fa-angle-double-right"></i>Projects Section</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.fpost.edit']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.fpost.edit'); ?>"><i class="fa fa-angle-double-right"></i>Featured Posts</a>
            </li>
			<?php /*
            <li class="<?= Helper::container_array($name_route, ['admin.testimonials']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.testimonials'); ?>"><i class="fa fa-angle-double-right"></i>Testimonials</a>
            </li>*/ ?>
            <li class="<?= Helper::container_array($name_route, ['admin.apparence.footer']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.apparence.footer'); ?>"><i class="fa fa-angle-double-right"></i>Footer</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.clear_cache']) ? 'active' : ''; ?>">
               <a href="<?= route('admin.clear_cache'); ?>"><i class="fa fa-angle-double-right"></i>Cache</a>
            </li>
            @if($auth_user->is('superadmin') or $auth_user->can('admin.blog') )<?php /*or $auth_user->can('admin.projects')*/ ?>
			<li class="<?= Helper::container_array($name_route, ['admin.keywords2']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.keywords2'); ?>"><i class="fa fa-angle-double-right"></i>Keywords</a>
            </li>
			@endif
            @if($auth_user->is('superadmin') or $auth_user->can('admin.params'))
            <li class="<?= Helper::container_array($name_route, ['admin.params']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.params'); ?>"><i class="fa fa-angle-double-right"></i>Home Page</a>
            </li>
            @endif

            @if($auth_user->is('superadmin') or $auth_user->can('admin.redirect_short'))
            <li class="<?= Helper::container_array($name_route, ['admin.redirect_short']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.redirect_short'); ?>"><i class="fa fa-angle-double-right"></i>URLs Shortener</a>
            </li>
            @endif



            @if($auth_user->is('superadmin'))
            <li class="<?= Helper::container_array($name_route, ['admin.users']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.users'); ?>"><i class="fa fa-angle-double-right"></i>Users</a>
            </li>
            @endif

            @if($auth_user->is('superadmin'))
<!--<li class="<?= Helper::container_array($name_route, ['admin.users.roles']) ? 'active' : ''; ?>">
    <a href="<?= route('admin.users.roles'); ?>"><i class="fa fa-angle-double-right"></i>Roles</a>
</li>-->
            @endif

            <?php /* ?>
              @if($auth_user->is('superadmin') or $auth_user->can("admin.stats"))
              <li class="<?= Helper::container_array($name_route, ["admin.stats"]) ? 'active' : ''; ?>">
              <a href="<?= route('admin.stats'); ?>"><i class="fa fa-angle-double-right"></i>Visitors</a>
              </li>
              @endif


              @if($auth_user->is('superadmin'))
              <li class="<?= Helper::container_array($name_route, ['admin.clientsource']) ? 'active' : ''; ?>">
              <a href="<?= route('admin.clientsource'); ?>"><i class="fa fa-angle-double-right"></i>Sources Coding</a>
              </li>
              @endif
              <?php */ ?>
        </ul>
    </li>
	
	
	@else
		
	<li class="treeview <?= Helper::container_array($name_route, ["admin.clear_cache"]) ? 'active' : ''; ?>">
        <a href="{{ route('admin.clear_cache') }}">
            <i class="fa fa-refresh"></i> <span>Cache</span></i>
        </a>
	</li>
	@if($auth_user->is('superadmin') or $auth_user->can('admin.blog'))
	<li class="<?= Helper::container_array($name_route, ['admin.keywords2']) ? 'active' : ''; ?>">
		<a href="<?= route('admin.keywords2'); ?>"><i class="fa fa-angle-double-right"></i>Keywords</a>
	</li>
	@endif
	
	
    @endif
    <!-- End Settings -->
	
	
	
	
	<?php } ?>
	
	
	
	
</ul>
