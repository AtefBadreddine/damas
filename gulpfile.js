var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    // plugins files

    mix.styles(["bootstrap.min.css", "font-awesome.min.css", "normalize.css", "owl.carousel.min.css", "intlTelInput.css", "animate.min.css", "coolshare.css", "flaticon.css"]
	, "public/css/plugins.min.css");


    mix.scripts(["bootstrap.min.js", "owl.carousel.js", "wow.min.js", "jquery.nicescroll.min.js", "intlTelInput.js", "coolshare.js", "jquery.unveil.js"]
	, "public/js/plugins.min.js");

    // global files
    mix.styles(["global.css", "navbar.css", "form.css", "footer.css", "alike-projects.css"]
	, "public/css/app.min.css");
    mix.scripts(["plugin.js", "main.js"]
	, "public/js/app.min.js");
    // index
    mix.styles(["main-page.css"]
	, "public/css/index.min.css");
    // bootstrap-rtl
    mix.styles(["bootstrap-rtl.min.css"]
	, "public/css/bootstrap-rtl.min.css");
    // ltr.css
    mix.styles(["ltr.css"]
	, "public/css/ltr.css");
    // blog.css
    mix.styles(["blog.css"]
	, "public/css/blog.css");
    // blog.css
    mix.styles(["bootstrap-select.min.css"]
	, "public/css/bootstrap-select.min.css");
    // note.css
    mix.styles(["note.css"]
	, "public/css/note.css");
    // note.css
    mix.styles(["searchpage.css"]
	, "public/css/searchpage.css");
    mix.styles(["landingpage_style.css"]
	, "public/css/landingpage_style.css");
    mix.styles(["landingpage_main.css"]
	, "public/css/landingpage_main.css");
    mix.styles(["contact.css"]
	, "public/css/contact.css");
    //jquery-3.1.1.min.js
    mix.scripts(["jquery-3.1.1.min.js"]
	, "public/css/jquery-3.1.1.min.js");
    mix.scripts(["landingpage_plugin.js"]
	, "public/css/landingpage_plugin.js");


    
	
	
	
    // project
    mix.styles(["remodal.css", "remodal-default-theme.css", "project.css"]
	, "public/css/project.min.css");
    mix.scripts(["remodal.min.js", "project.js"]
	, "public/js/project.min.js");
    mix.scripts(["remodal.min.js"]
	, "public/js/remodal.min.js");
    // search
    mix.scripts(["markerclusterer.js", "bootstrap-select.js", "defaults-ar_AR.js"]
	, "public/js/search.min.js");
});
