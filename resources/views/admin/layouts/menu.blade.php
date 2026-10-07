<?php
$name_route = Route::currentRouteName();
$auth_user = Auth::user();

// Declare each link's route once. The script below derives the open groups
// from the matching link's actual position in the rendered sidebar.
$menuLink = function ($routeName, $suffix = '') {
    return 'href="' . e(route($routeName) . $suffix) . '"'
        . ' data-menu-route="' . e($routeName) . '"';
};
?>
<style>
    .fa-angle-right {
        transition: all 250ms ease;
        transform: rotate(0deg);
    }
    .fa-angle-right.rotate,
    #admin-sidebar-menu .treeview.menu-open > a > .fa-angle-right {
        transform: rotate(90deg);
    }
</style>
<ul id="admin-sidebar-menu" class="sidebar-menu direction" data-current-route="<?= e($name_route); ?>">
    <li class="header"></li>
	<?php
	if (isset($_SERVER['SERVER_NAME']) && strpos($_SERVER['SERVER_NAME'],'administrator.damas.net') !== false ) { ?>
    
    <!-- Start Media -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.medias'))
    <li class="treeview">
        <a href="#">
            <i class="fa fa-file-picture-o"></i> <span>Media</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li>
                <a <?= $menuLink('admin.medias'); ?>><i class="fa fa-angle-double-right"></i>Images</a>
            </li>
            <li>
                <a <?= $menuLink('admin.medias.folders'); ?>><i class="fa fa-angle-double-right"></i>Image Folders</a>
            </li>
            <!--<li>
                <a <?= $menuLink('admin.videos'); ?>><i class="fa fa-angle-double-right"></i>Videos</a>
            </li>
            <li>
                <a <?= $menuLink('admin.apparence.sectionvideos'); ?>><i class="fa fa-angle-double-right"></i>V.Categories</a>
            </li>-->
        </ul>
    </li>
	@endif
	<?php }else{ ?>
	
	<!-- Start Leads -->
    @if($auth_user->is('superadmin'))
    <li class="treeview">
        <a href="#">
            <i class="fa fa-whatsapp"></i> <span>Leads</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li>
                <a <?= $menuLink('admin.whatsappapi'); ?>>
                    <i class="fa fa-angle-double-right"></i> Webhooks
                </a>
            </li>
            <li>
                <a <?= $menuLink('admin.whatsapp_contacts'); ?>>
                    <i class="fa fa-angle-double-right"></i> Contacts (W. API)
                </a>
            </li>
            <li>
                <a <?= $menuLink('admin.whatsapp_chat'); ?>>
                    <i class="fa fa-angle-double-right"></i> Chat (W. API)
                </a>
            </li>
            <li >
                <a <?= $menuLink('admin.whatsapp_templates'); ?>>
                    <i class="fa fa-angle-double-right"></i> Templates (W. API)
                </a>
            </li>
            @if($auth_user->is('superadmin') or $auth_user->can('admin.whatsapp_msg'))
            <li>
                <a <?= $menuLink('admin.whatsapp_msg'); ?>><i class="fa fa-angle-double-right"></i> WhatsApp</a>
            </li>
            @endif
            @if($auth_user->is('superadmin') or $auth_user->can('admin.messages'))
            <li>
                <a <?= $menuLink('admin.messages'); ?>><i class="fa fa-angle-double-right"></i> Leads</a>
            </li>
            @endif
			@if($auth_user->is('superadmin') or $auth_user->can('admin.backup_msg'))
            <li>
                <a <?= $menuLink('admin.backup_msg'); ?>><i class="fa fa-angle-double-right"></i> Backup Leads</a>
            </li>
            @endif
            <li>
                <a <?= $menuLink('admin.cta'); ?>>
                    <i class="fa fa-angle-double-right"></i>
                    <span>CTA</span>
                </a>
            </li>

        </ul>
    </li>
    @endif
    <!-- End Leads -->
	
	<!-- Start SEO -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.landing_tourism') or $auth_user->can('admin.statistics') or $auth_user->can('admin.messages') or $auth_user->can('admin.whatsapp_msg') or $auth_user->can('admin.messagesvac') or $auth_user->can('admin.newsletter') or $auth_user->can('admin.wordsearch') or $auth_user->can('admin.redirectsearchprojects') or $auth_user->can('admin.search'))
    <li class="treeview">
        <a href="#">
            <i class="fa fa-search"></i> <span>SEO</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li>
                <a <?= $menuLink('admin.anchors'); ?>>
                    <i class="fa fa-angle-double-right"></i> Internal Links
                </a>
            </li>
            <li>
                <a <?= $menuLink('admin.metatag_tool'); ?>>
                    <i class="fa fa-angle-double-right"></i>
                    <span>Metatag Tool</span>
                </a>
            </li>
            <li>
                <a <?= $menuLink('admin.pagespeed'); ?>>
                    <i class="fa fa-angle-double-right"></i> Speed Insights
                </a>
            </li>
            <li>
                <a <?= $menuLink('admin.sitemap'); ?>><i class="fa fa-angle-double-right"></i> Sitemap</a>
            </li>
            
			
            

            <?php /*
              @if($auth_user->is('superadmin') or $auth_user->can('admin.whatsapp_msg'))
              <li>
              <a <?= $menuLink('admin.quizs'); ?>><i class="fa fa-angle-double-right"></i> Competition</a>
              </li>
              @endif
             */ ?>

            @if($auth_user->is('superadmin') or $auth_user->can('admin.messagesvac'))
            <!--<li>
                <a <?= $menuLink('admin.messagesvac'); ?>><i class="fa fa-angle-double-right"></i> HR Cvs</a>
            </li>-->
            @endif

            @if($auth_user->is('superadmin') or $auth_user->can('admin.newsletter'))
            <!--<li>
                <a <?= $menuLink('admin.newsletter'); ?>><i class="fa fa-angle-double-right"></i> Newsletter</a>
            </li>-->
            @endif

            @if($auth_user->is('superadmin') or $auth_user->can('admin.statistics'))
            <li>
                <a <?= $menuLink('admin.statistics'); ?>><i class="fa fa-angle-double-right"></i> Statistics </a>
            </li>
            @endif

            @if($auth_user->is('superadmin'))
            <li class="treeview">
                <a href="#"><i class="fa fa-angle-double-right"></i> Search</a>
                <ul class="treeview-menu">
                    <li><a <?= $menuLink('admin.search', '?field=updated_at&sort=desc&page=1&lang=ar'); ?>><i class="fa fa-circle-o"></i> Statistics</a></li>

                    <li><a <?= $menuLink('admin.redirectsearchprojects'); ?>><i class="fa fa-circle-o"></i> Project research</a></li>
                    <li><a <?= $menuLink('admin.wordsearch'); ?>><i class="fa fa-circle-o"></i> Post research </a></li>
                    <?php /* ?>
                      <li>**</li>
                      <li>**</li>
                      <li><a <?= $menuLink('admin.wordsearch'); ?>><i class="fa fa-circle-o"></i> الكلمات المتشابهة</a></li>
                      <li><a <?= $menuLink('admin.wordsearch'); ?>><i class="fa fa-circle-o"></i> توجيه البحث</a></li>
                      <?php */ ?>

                    <?php /*
                      <!--
                      <li><a <?= $menuLink('admin.redirectsearchprojects'); ?>><i class="fa fa-circle-o"></i> توجيه بحث المشاريع</a></li>
                      <li><a <?= $menuLink('admin.redirectsearchposts'); ?>><i class="fa fa-circle-o"></i> توجيه بحث المقالات</a></li>-->
                     */ ?>
                </ul>
            </li>			
            @endif


        </ul>
    </li>
    @endif

    <!-- End SEO -->
    @if($auth_user->is('superadmin'))
    <li class="treeview">
        <a>
            <i class="fa fa-cubes"></i> <span>Listings</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            @if($auth_user->is('superadmin') or $auth_user->can('admin.pages.search'))
            <li>
                <a <?= $menuLink('admin.pages.search'); ?>><i class="fa fa-angle-double-right"></i> Old Listings</a>
            </li>
            @endif
            <li>
                <a <?= $menuLink('admin.countries'); ?>><i class="fa fa-angle-double-right"></i> Countries</a>
            </li>
            @if($auth_user->is('superadmin') or $auth_user->can('admin.cities'))
            <li>
                <a <?= $menuLink('admin.cities'); ?>><i class="fa fa-angle-double-right"></i> Cities</a>
            </li>
            @endif
            @if($auth_user->is('superadmin') or $auth_user->can('admin.regions'))
            <li>
                <a <?= $menuLink('admin.regions'); ?>><i class="fa fa-angle-double-right"></i> Districts</a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    <!-- Start Properties -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.projects') or $auth_user->can('admin.cities') or $auth_user->can('admin.regions') or $auth_user->can('admin.salesmanagers'))
    <li class="treeview">
        <a href="#">
            <i class="fa fa-cubes"></i> <span>Properties</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">

            @if($auth_user->is('superadmin') or $auth_user->can('admin.projects'))
            <li>
                <a <?= $menuLink('admin.projects'); ?>><i class="fa fa-angle-double-right"></i> Properties</a>
            </li>
            <li>
                <a <?= $menuLink('admin.projecttype'); ?>><i class="fa fa-angle-double-right"></i> Types</a>
            </li>
            <li>
                <a <?= $menuLink('admin.projectcategory'); ?>><i class="fa fa-angle-double-right"></i> Features</a>
            </li>
            <li>
                <a <?= $menuLink('admin.projectfeature'); ?>><i class="fa fa-angle-double-right"></i> Facilities</a>
            </li>
			<li>
                <a <?= $menuLink('admin.introcard.edit'); ?>><i class="fa fa-angle-double-right"></i> Intro Cards</a>
            </li>
			<!--<li>
                <a <?= $menuLink('admin.projectfilter.edit'); ?>><i class="fa fa-angle-double-right"></i> Search Filters</a>
            </li>-->
            @endif
        </ul>
    </li>
    @endif
    <!-- End Properties -->
    

    <!-- Start Blog -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.blog'))
    <li class="treeview">
        <a href="#">
            <i class="fa fa-newspaper-o"></i> <span>Posts</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li>
                <a <?= $menuLink('admin.blog.posts'); ?>><i class="fa fa-angle-double-right"></i>Guides</a>
            </li>
            <li>
                <a <?= $menuLink('admin.developer.posts'); ?>><i class="fa fa-angle-double-right"></i>Developers</a>
            </li>
            <li>
                <a <?= $menuLink('admin.report.posts'); ?>><i class="fa fa-angle-double-right"></i>Reports</a>
            </li>
            <li>
                <a <?= $menuLink('admin.news.posts'); ?>><i class="fa fa-angle-double-right"></i>News</a>
            </li>
            <li>
                <a <?= $menuLink('admin.blog.categories'); ?>><i class="fa fa-angle-double-right"></i>Categories</a>
            </li>
            <li>
                <a <?= $menuLink('admin.blog.tags'); ?>><i class="fa fa-angle-double-right"></i>Tags</a>
            </li>
<!--            <li>
                <a <?= $menuLink('admin.blog.sections'); ?>><i class="fa fa-angle-double-right"></i> Sections</a>
            </li>-->
        </ul>
    </li>
	
	
    @endif
    <!-- End Blog -->
    
    <!-- Start Pages -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.pages.search') or $auth_user->can('admin.landingpage') or $auth_user->can('admin.faq'))
    <li class="treeview">
        <a href="#">
            <i class="fa fa-files-o"></i> <span>Landing </span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            @if($auth_user->is('superadmin') or $auth_user->can('admin.landingpage'))
			<li>
                <a <?= $menuLink('admin.landingpage'); ?>><i class="fa fa-angle-double-right"></i>Old Landing</a>
            </li>
            <li>
                <a <?= $menuLink('admin.newlandingpage'); ?>><i class="fa fa-angle-double-right"></i>New Landing</a>
            </li>
            <!--<li>-->
            <!--    <a <?= $menuLink('admin.landing2'); ?>><i class="fa fa-angle-double-right"></i>Landing Offers</a>-->
            <!--</li>-->
            <li>
                <a <?= $menuLink('admin.landing3'); ?>><i class="fa fa-angle-double-right"></i>Offers Landing</a>
            </li>
            <li>
                <a <?= $menuLink('admin.landing_tourism'); ?>><i class="fa fa-angle-double-right"></i>Tourism Landing</a>
            </li>
            @endif
            @if($auth_user->is('superadmin') or $auth_user->can('admin.landing_tourism'))
            <li>
                <a <?= $menuLink('admin.messages_landing_index'); ?>><i class="fa fa-angle-double-right"></i>Tourism Leads</a>
            </li>
            @endif
            
            <li>
                <a <?= $menuLink('admin.pages.turkey_guide'); ?>><i class="fa fa-angle-double-right"></i>Turkey guide</a>
            </li>

            @if($auth_user->is('superadmin'))
            <li>
                <a <?= $menuLink('admin.pages.turkish_citizenship'); ?>><i class="fa fa-angle-double-right"></i>Citizenship</a>
            </li>
            <li>
                <a <?= $menuLink('admin.pages.investment'); ?>><i class="fa fa-angle-double-right"></i>Investment</a>
            </li>
            <li>
                <a <?= $menuLink('admin.pages.legal'); ?>><i class="fa fa-angle-double-right"></i>Legal</a>
            </li>
            <?php /*
              <li>
              <a <?= $menuLink('admin.pages.quiz'); ?>><i class="fa fa-angle-double-right"></i> Competition form</a>
              </li> */ ?>
			  @endif
			<?php /*@if($auth_user->is('superadmin') or $auth_user->can('admin.pages.aboutus'))
            <li>
                <a <?= $menuLink('admin.pages.aboutus'); ?>><i class="fa fa-angle-double-right"></i> About us</a>
            </li>
			@endif */ ?>

            @if($auth_user->can('admin.branch'))  @endif


            





        </ul>
    </li>
    @endif
    <!-- End Pages -->

    <!-- Start Media -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.medias'))
    <li class="treeview">
        <a href="#">
            <i class="fa fa-file-picture-o"></i> <span>Media</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li>
                <a <?= $menuLink('admin.medias'); ?>><i class="fa fa-angle-double-right"></i>Images</a>
            </li>
            <li>
                <a <?= $menuLink('admin.medias.folders'); ?>><i class="fa fa-angle-double-right"></i>Image Folders</a>
            </li>
            <li>
                <a <?= $menuLink('admin.videos'); ?>><i class="fa fa-angle-double-right"></i>Videos</a>
            </li>
            <li>
                <a <?= $menuLink('admin.apparence.sectionvideos'); ?>><i class="fa fa-angle-double-right"></i>V. Categories</a>
            </li>
            <li>
                <a <?= $menuLink('admin.pages.360'); ?>><i class="fa fa-angle-double-right"></i>360</a>
            </li>
        </ul>
    </li>

    @endif
    <!-- End Media -->



    <!-- Start Jobs -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.jobs'))
    <li class="treeview">
        <a href="#">
            <i class="fa fa fa-tasks"></i> <span>Jobs</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">

			<li>
			<a <?= $menuLink('admin.pages.vacancies'); ?>><i class="fa fa-angle-double-right"></i> Page Jobs</a>
			</li>
			<li>
			<a <?= $menuLink('admin.jobs'); ?>><i class="fa fa-angle-double-right"></i> List Jobs</a>
			</li>

        </ul>
    </li>
    @endif
    
    <!--End Jobs-->
    <li class="treeview">
        <a href="#">
            <i class="fa fa-question"></i> <span>FAQ </span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li>
                <a <?= $menuLink('admin.pages.faq'); ?>><i class="fa fa-angle-double-right"></i>Main page</a>
            </li>
            <li>
                <a <?= $menuLink('admin.faqpost'); ?>><i class="fa fa-angle-double-right"></i>Categories</a>
            </li>
        </ul>	
    </li>
    <!-- Start Settings -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.apparence') or $auth_user->can('admin.params') or $auth_user->can('admin.redirect_short') or $auth_user->can('admin.support') or $auth_user->can('admin.stats'))
    <li class="treeview">
        <a href="#">
            <i class="fa fa-gears"></i> <span>Settings</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li>
                <a <?= $menuLink('admin.apparence.menus'); ?>><i class="fa fa-angle-double-right"></i>Side menu</a>
            </li>
            <?php /*<li>
                <a <?= $menuLink('admin.apparence.sliders'); ?>><i class="fa fa-angle-double-right"></i>Sliders</a>
            </li>*/ ?>
			<li>
                <a <?= $menuLink('admin.apparence.sections'); ?>><i class="fa fa-angle-double-right"></i>Home Projects</a>
            </li>
            <li>
                <a <?= $menuLink('admin.fpost.edit'); ?>><i class="fa fa-angle-double-right"></i>Similar Posts</a>
            </li>
			<?php /*
            <li>
                <a <?= $menuLink('admin.testimonials'); ?>><i class="fa fa-angle-double-right"></i>Testimonials</a>
            </li>*/ ?>
            <li>
                <a <?= $menuLink('admin.apparence.footer'); ?>><i class="fa fa-angle-double-right"></i>Footer</a>
            </li>
            <li>
               <a <?= $menuLink('admin.clear_cache'); ?>><i class="fa fa-angle-double-right"></i>Cache</a>
            </li>
            @if($auth_user->is('superadmin') or $auth_user->can('admin.blog') )<?php /*or $auth_user->can('admin.projects')*/ ?>
			<li>
                <a <?= $menuLink('admin.keywords2'); ?>><i class="fa fa-angle-double-right"></i>Keywords</a>
            </li>
			@endif
            @if($auth_user->is('superadmin') or $auth_user->can('admin.params'))
            <li>
                <a <?= $menuLink('admin.params'); ?>><i class="fa fa-angle-double-right"></i>Home Page</a>
            </li>
            @endif

            @if($auth_user->is('superadmin') or $auth_user->can('admin.redirect_short'))
            <li>
                <a <?= $menuLink('admin.redirect_short'); ?>><i class="fa fa-angle-double-right"></i>URLs Shortener</a>
            </li>
            @endif



            @if($auth_user->is('superadmin'))
            <li>
                <a <?= $menuLink('admin.users'); ?>><i class="fa fa-angle-double-right"></i>Users</a>
            </li>
            @endif

            @if($auth_user->is('superadmin'))
<!--<li>
    <a <?= $menuLink('admin.users.roles'); ?>><i class="fa fa-angle-double-right"></i>Roles</a>
</li>-->
            @endif

            <?php /* ?>
              @if($auth_user->is('superadmin') or $auth_user->can("admin.stats"))
              <li>
              <a <?= $menuLink('admin.stats'); ?>><i class="fa fa-angle-double-right"></i>Visitors</a>
              </li>
              @endif


              @if($auth_user->is('superadmin'))
              <li>
              <a <?= $menuLink('admin.clientsource'); ?>><i class="fa fa-angle-double-right"></i>Sources Coding</a>
              </li>
              @endif
              <?php */ ?>
              

            <li>
                <a <?= $menuLink('admin.pages.terms'); ?>><i class="fa fa-angle-double-right"></i>Terms of Use</a>
            </li>

            <li>
                <a <?= $menuLink('admin.pages.privacy'); ?>><i class="fa fa-angle-double-right"></i>Privacy Policy</a>
            </li>
        </ul>
    </li>
	
	
	@else
		
	<li class="treeview">
        <a <?= $menuLink('admin.clear_cache'); ?>>
            <i class="fa fa-refresh"></i> <span>Cache</span></i>
        </a>
	</li>
	@if($auth_user->is('superadmin') or $auth_user->can('admin.blog'))
	<li>
		<a <?= $menuLink('admin.keywords2'); ?>><i class="fa fa-angle-double-right"></i>Keywords</a>
	</li>
	@endif
	
	
    @endif
    <!-- End Settings -->
	
	
	
	
	<?php } ?>
	
	
	
	
</ul>

<script>
(function () {
    var menu = document.getElementById('admin-sidebar-menu');
    if (!menu) return;

    var currentRoute = menu.getAttribute('data-current-route') || '';
    var links = menu.querySelectorAll('a[data-menu-route]');
    var selected = null;
    var longestMatch = -1;

    // Prefer the most specific route: e.g. medias.folders over medias.
    // Dot boundaries prevent messages from also matching messagesvac.
    for (var i = 0; i < links.length; i++) {
        var routeName = links[i].getAttribute('data-menu-route');
        if (routeName && (currentRoute === routeName ||
                currentRoute.indexOf(routeName + '.') === 0)) {
            if (routeName.length > longestMatch) {
                selected = links[i];
                longestMatch = routeName.length;
            }
        }
    }

    // Also handle edit/create pages whose route names are not descendants
    // of the list route, when their URLs are under the list page's URL.
    if (!selected) {
        var currentPath = window.location.pathname.replace(/\/+$/, '') || '/';
        for (var j = 0; j < links.length; j++) {
            var linkPath = links[j].pathname.replace(/\/+$/, '') || '/';
            if (links[j].host === window.location.host && linkPath !== '/' &&
                    (currentPath === linkPath || currentPath.indexOf(linkPath + '/') === 0) &&
                    linkPath.length > longestMatch) {
                selected = links[j];
                longestMatch = linkPath.length;
            }
        }
    }

    if (!selected) return;
    selected.setAttribute('aria-current', 'page');

    // Walk the actual markup, opening every ancestor (including nested groups).
    var node = selected.parentElement;
    while (node && node !== menu) {
        if (node.tagName === 'LI') {
            node.classList.add('active');
            if (node.classList.contains('treeview')) {
                node.classList.add('menu-open');
            }
        } else if (node.tagName === 'UL' && node.classList.contains('treeview-menu')) {
            node.style.display = 'block';
        }
        node = node.parentElement;
    }
})();
</script>
