<?php
    $name_route = Route::currentRouteName();
    $auth_user = Auth::user();
?>

<ul class="sidebar-menu direction">
    <li class="header"></li>
    <!-- params -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.params') or $auth_user->can('admin.messages') or $auth_user->can('admin.whatsapp_msg'))
    <li class="treeview <?= Helper::container_array($name_route, ["redirect_short","admin.params", "admin.notifs", "admin.messages", "admin.whatsapp_msg", "admin.clientsource",'admin.wordsearch','admin.search','admin.redirectsearch']) ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa fa-gears"></i> <span>Settings</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            @if($auth_user->is('superadmin') or $auth_user->can('admin.params'))
            <li class="<?= Helper::container_array($name_route, ['admin.params']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.params'); ?>"><i class="fa fa-angle-double-right"></i> Home Settings</a>
            </li>
            @endif
            @if($auth_user->is('superadmin') or $auth_user->can('admin.messages'))
            <li class="<?= ($name_route=='admin.messages') ? 'active' : ''; ?>">
                <a href="<?= route('admin.messages'); ?>"><i class="fa fa-angle-double-right"></i> Inquiries</a>
            </li>
            @endif
            @if($auth_user->is('superadmin') or $auth_user->can('admin.whatsapp_msg'))
            <li class="<?= Helper::container_array($name_route, ['admin.whatsapp_msg']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.whatsapp_msg'); ?>"><i class="fa fa-angle-double-right"></i> WhatsApp</a>
            </li>
            @endif
            @if($auth_user->is('superadmin'))
            <li class="<?= Helper::container_array($name_route, ['admin.clientsource']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.clientsource'); ?>"><i class="fa fa-angle-double-right"></i>  Sources Coding</a>
            </li>
            @endif
            @if($auth_user->is('superadmin') or $auth_user->can('admin.messagesvac'))
            <li class="<?= ($name_route=='admin.messagesvac') ? 'active' : ''; ?>">
                <a href="<?= route('admin.messagesvac'); ?>"><i class="fa fa-angle-double-right"></i> HR Applications</a>
            </li>
            @endif
            @if($auth_user->is('superadmin') or $auth_user->can('admin.redirect_short'))
            <li class="<?= Helper::container_array($name_route, ['admin.redirect_short']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.redirect_short'); ?>"><i class="fa fa-angle-double-right"></i> Links Shortcut</a>
            </li>
            @endif

			@if($auth_user->is('superadmin'))
			<li class="treeview <?= Helper::container_array($name_route, [/*'admin.redirectsearchprojects','admin.search','admin.redirectsearch'*/]) ? ' menu-open' : ''; ?>">
              <a href="#"><i class="fa fa-angle-double-right"></i> Search</a>
              <ul class="treeview-menu" style="<?= Helper::container_array($name_route, ['admin.wordsearch','admin.search','admin.redirectsearch']) ? 'display: block;' : ''; ?>">
                <li class="<?= Helper::container_array($name_route, ['admin.search']) ? 'active' : ''; ?>"><a href="<?= route('admin.search'); ?>"><i class="fa fa-circle-o"></i> Statistics</a></li>
                <?php /*<!--<li class="<?= ($name_route=='admin.wordsearch') ? 'active' : ''; ?>"><a href="<?= route('admin.wordsearch'); ?>"><i class="fa fa-circle-o"></i> الكلمات المتشابهة</a></li>
                <li class="<?= Helper::container_array($name_route, ['admin.redirectsearch']) ? 'active' : ''; ?>"><a href="<?= route('admin.redirectsearch'); ?>"><i class="fa fa-circle-o"></i> توجيه البحث</a></li>-->*/ ?>


				<?php /*
				<!--
                <li class="<?= Helper::container_array($name_route, ['admin.redirectsearchprojects']) ? 'active' : ''; ?>"><a href="<?= route('admin.redirectsearchprojects'); ?>"><i class="fa fa-circle-o"></i> توجيه بحث المشاريع</a></li>
                <li class="<?= Helper::container_array($name_route, ['admin.redirectsearchposts']) ? 'active' : ''; ?>"><a href="<?= route('admin.redirectsearchposts'); ?>"><i class="fa fa-circle-o"></i> توجيه بحث المقالات</a></li>-->
				*/ ?>
              </ul>
            </li>			
			@endif

			<?php /*
            @if($auth_user->is('superadmin'))
            <li class="<?= Helper::container_array($name_route, ['admin.wordsearch']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.wordsearch'); ?>"><i class="fa fa-angle-double-right"></i>الكلمات المتشابهة</a>
            </li>
            @endif
            @if($auth_user->is('superadmin'))
            <li class="<?= Helper::container_array($name_route, ['admin.redirectsearch']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.redirectsearch'); ?>"><i class="fa fa-angle-double-right"></i>توجيه البحث</a>
            </li>
            @endif
            @if($auth_user->is('superadmin'))
            <li class="<?= Helper::container_array($name_route, ['admin.search']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.search'); ?>"><i class="fa fa-angle-double-right"></i> الإحصائيات</a>
            </li>
            @endif
			*/ ?>
        </ul>
    </li>
    @endif
    <!-- bases -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.cities') or $auth_user->can('admin.regions') or $auth_user->can('admin.salesmanagers') or $auth_user->can('admin.branch') or $auth_user->can('admin.landingpage') or $auth_user->can('admin.newsletter'))
    <li class="treeview <?= Helper::container_array($name_route, ["admin.statistics", "admin.cities", "admin.regions", "admin.salesmanagers", "admin.branch", "admin.landingpage", "admin.newsletter"]) ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa fa-folder"></i> <span>Content</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
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
            
            @if($auth_user->is('superadmin') or $auth_user->can('admin.salesmanagers'))
            <li class="<?= Helper::container_array($name_route, ['admin.salesmanagers']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.salesmanagers'); ?>"><i class="fa fa-angle-double-right"></i> Salesman</a>
            </li>
            @endif
            
            @if($auth_user->is('superadmin') or $auth_user->can('admin.branch'))
            <li class="<?= Helper::container_array($name_route, ['admin.branch']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.branch'); ?>"><i class="fa fa-angle-double-right"></i> Branches</a>
            </li>
            @endif
            
            @if($auth_user->is('superadmin') or $auth_user->can('admin.landingpage'))
            <li class="<?= Helper::container_array($name_route, ['admin.landingpage']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.landingpage'); ?>"><i class="fa fa-angle-double-right"></i> Landing pages</a>
            </li>
            @endif
            
            @if($auth_user->is('superadmin') or $auth_user->can('admin.newsletter'))
            <li class="<?= Helper::container_array($name_route, ['admin.newsletter']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.newsletter'); ?>"><i class="fa fa-angle-double-right"></i> Newsletter</a>
            </li>
            @endif
            @if($auth_user->is('superadmin'))
            <li class="<?= Helper::container_array($name_route, ['admin.statistics']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.statistics'); ?>"><i class="fa fa-angle-double-right"></i> Turkstat Statistics</a>
            </li>
            @endif
            
        </ul>
    </li>
    @endif
    <!-- projects -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.projects'))
    <li class="treeview <?= Helper::container_array($name_route, ["admin.projects", "admin.projecttype", "admin.projectcategory", "admin.projectfeature"]) ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa fa-cubes"></i> <span>Properties</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
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
        </ul>
    </li>
    @endif
    <!-- sections -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.apparence'))
    <li class="treeview <?= Helper::container_array($name_route, ["admin.apparence","admin.testimonials"]) ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa fa-window-restore"></i> <span>Appearance</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="<?= Helper::container_array($name_route, ['admin.apparence.menus']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.apparence.menus'); ?>"><i class="fa fa-angle-double-right"></i> Lists</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.apparence.sliders']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.apparence.sliders'); ?>"><i class="fa fa-angle-double-right"></i> Sliders</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.apparence.sections']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.apparence.sections'); ?>"><i class="fa fa-angle-double-right"></i> Sections</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.testimonials']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.testimonials'); ?>"><i class="fa fa-angle-double-right"></i> Testimonials</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.apparence.footer']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.apparence.footer'); ?>"><i class="fa fa-angle-double-right"></i>Footer </a>
            </li>
        </ul>
    </li>
    @endif
    <!-- medias -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.medias'))
    <li class="treeview <?= Helper::container_array($name_route, ["admin.medias","admin.videos"]) ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa fa-file-picture-o"></i> <span>Media</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="<?= Helper::container_array($name_route, ['admin.medias']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.medias'); ?>"><i class="fa fa-angle-double-right"></i>  All Images</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.medias.folders']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.medias.folders'); ?>"><i class="fa fa-angle-double-right"></i> Images Folders</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.videos']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.videos'); ?>"><i class="fa fa-angle-double-right"></i> Videos</a>
            </li>
        </ul>
    </li>
    @endif
    <!-- blog -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.blog'))
    <li class="treeview <?= Helper::container_array($name_route, ["admin.blog"]) ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa fa-newspaper-o"></i> <span>Blog</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="<?= Helper::container_array($name_route, ['admin.blog.params']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.blog.params'); ?>"><i class="fa fa-angle-double-right"></i> Settings</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.blog.sections']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.blog.sections'); ?>"><i class="fa fa-angle-double-right"></i> Sections</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.blog.posts']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.blog.posts'); ?>"><i class="fa fa-angle-double-right"></i>All Posts</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.blog.categories']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.blog.categories'); ?>"><i class="fa fa-angle-double-right"></i>Categories</a>
            </li>
        </ul>
    </li>
    @endif
    <!-- pages -->
    @if($auth_user->is('superadmin') or $auth_user->can('admin.pages.search'))
    <li class="treeview <?= Helper::container_array($name_route, ["admin.pages","admin.sitemap"]) ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa fa-files-o"></i> <span>Special Pages</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            @if($auth_user->is('superadmin'))
            <li class="<?= Helper::container_array($name_route, ['admin.pages.turkish_citizenship']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.pages.turkish_citizenship'); ?>"><i class="fa fa-angle-double-right"></i>Turkish Citizenship</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.pages.aboutus']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.pages.aboutus'); ?>"><i class="fa fa-angle-double-right"></i> who are we</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.sitemap']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.pages.vacancies'); ?>"><i class="fa fa-angle-double-right"></i> Sitemap</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.pages.vacancies']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.pages.vacancies'); ?>"><i class="fa fa-angle-double-right"></i> Vacancies</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.pages.terms']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.pages.terms'); ?>"><i class="fa fa-angle-double-right"></i> Terms of Use</a>
            </li>
            <li class="<?= Helper::container_array($name_route, ['admin.pages.privacy']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.pages.privacy'); ?>"><i class="fa fa-angle-double-right"></i> Privacy Policy</a>
            </li>
			
			<?php /*
			<li class="treeview <?= Helper::container_array($name_route, ['admin.sitemap','admin.sitemap_cat']) ? ' menu-open' : ''; ?>">
              <a href="#"><i class="fa fa-angle-double-right"></i> خريطة الموقع
                
              </a>
              <ul class="treeview-menu" style="<?= Helper::container_array($name_route, ['admin.sitemap','admin.sitemap_cat']) ? 'display: block;' : ''; ?>">
                <li class="<?= ($name_route=='admin.sitemap') ? 'active' : ''; ?>"><a href="<?= route('admin.sitemap'); ?>"><i class="fa fa-circle-o"></i> إعدادات</a></li>
                <li class="<?= Helper::container_array($name_route, ['admin.sitemap_cat']) ? 'active' : ''; ?>"><a href="<?= route('admin.sitemap_cat'); ?>"><i class="fa fa-circle-o"></i> الروابط</a></li>
              </ul>
            </li>
			*/ ?>
			
            @endif
            <li class="<?= Helper::container_array($name_route, ['admin.pages.search']) ? ' active' : ''; ?>">
                <a href="<?= route('admin.pages.search'); ?>"><i class="fa fa-angle-double-right"></i> SEO Search Page</a>
            </li>
        </ul>
    </li>
    @endif
    <!-- users -->
    @if($auth_user->is('superadmin'))
    <li class="treeview <?= Helper::container_array($name_route, ["admin.users"]) ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa fa-users"></i> <span>Users</span> <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="<?= Helper::container_array($name_route, ['admin.users']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.users'); ?>"><i class="fa fa-angle-double-right"></i> All users</a>
            </li>
           <!--<li class="<?= Helper::container_array($name_route, ['admin.users.roles']) ? 'active' : ''; ?>">
                <a href="<?= route('admin.users.roles'); ?>"><i class="fa fa-angle-double-right"></i> الصلاحيات</a>
            </li>-->
        </ul>
    </li>
    @endif
    <!-- chat -->
    @if($auth_user->is('superadmin') or $auth_user->can("admin.support"))
    <li class="<?= Helper::container_array($name_route, ["admin.support"]) ? 'active' : ''; ?>">
        <a href="<?= route('admin.support'); ?>">
            <i class="fa fa-comments"></i> <span>Chat</span>
        </a>
    </li>
    @endif
    <!-- stats -->
    @if($auth_user->is('superadmin') or $auth_user->can("admin.stats"))
    <li class="<?= Helper::container_array($name_route, ["admin.stats"]) ? 'active' : ''; ?>">
        <a href="<?= route('admin.stats'); ?>">
            <i class="fa fa-bar-chart"></i> <span>Visitors</span>
        </a>
    </li>
    @endif
</ul>
