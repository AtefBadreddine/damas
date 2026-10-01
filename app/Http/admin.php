<?php

/**
* admin routes
*/
Route::group(['prefix' => 'damas-administrator', 'namespace' => 'Admin', 'middleware' => 'auth'], function () {
    Route::any('/', ['as' => 'admin.index', 'uses' => 'AdminController@index']);
	
	Route::any('/clear_cache', ['as' => 'admin.clear_cache', 'uses' => 'AdminController@clear_cache']);
	
    // PageSpeed Insights
    Route::any('/pagespeed', [
        'as' => 'admin.pagespeed',
        'uses' => 'AdminController@pagespeed_index'
    ]);
    // index admin
    Route::any('/ajaxqueries', ['as' => 'admin.ajaxqueries', 'uses' => 'AdminController@ajax_queries']);
    // params
    Route::group(['prefix' => 'params', 'middleware' => 'checkpermission:admin.params'], function () {
        Route::any('/', ['as' => 'admin.params', 'uses' => 'AdminController@params_index']);
        Route::any('/{id}/edit', ['as' => 'admin.params.edit', 'uses' => 'AdminController@params_edit']);
    });
    Route::group(['prefix' => 'rating'], function () {
        Route::any('/params/', ['as' => 'admin.rating', 'uses' => 'AdminController@rating']);
        
    });
    // sitemap
    Route::group(['prefix' => 'sitemap', 'middleware' => 'checkpermission:admin.administrator'], function () {
		Route::any('/', ['as' => 'admin.sitemap', 'uses' => 'AdminController@sitemap_index']);
        Route::any('/{id}/edit', ['as' => 'admin.sitemap.edit', 'uses' => 'AdminController@sitemap_edit']);
        /*Route::any('/{id}/list_cat', ['as' => 'admin.sitemap.list_cat', 'uses' => 'AdminController@sitemap_list_cat']);
        Route::any('/list_cat/create?sitemap={id}', ['as' => 'admin.sitemap.list_cat.create', 'uses' => 'AdminController@sitemap_list_cat_edit']);
   */ 
		Route::any('/sitemap_cat/{id?}', ['as' => 'admin.sitemap_cat', 'uses' => 'AdminController@sitemap_cat']);
		Route::delete('/sitemap_cat/{id}/delete', ['as' => 'admin.sitemap_cat.delete', 'uses' => 'AdminController@sitemap_cat_delete']);
   });
    // notifications
    Route::group(['prefix' => 'notifs', 'middleware' => 'checkpermission:admin.notifs'], function () {
        Route::any('/', ['as' => 'admin.notifs', 'uses' => 'AdminController@notifs_index']);
        Route::delete('/{id}/delete', ['as' => 'admin.notifs.delete', 'uses' => 'AdminController@notifs_delete']);
    });
    // messages
    Route::group(['prefix' => 'messages', 'middleware' => 'checkpermission:admin.messages'], function () {
        Route::any('/', ['as' => 'admin.messages', 'uses' => 'AdminController@messages_index']);
        Route::any('/create', ['as' => 'admin.messages.create', 'uses' => 'AdminController@messages_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.messages.delete', 'uses' => 'AdminController@messages_delete']);
    });
    // messages_landing_index
    Route::group(['prefix' => 'messages_landing_index', 'middleware' => 'checkpermission:admin.landing_tourism'], function () {
        Route::any('/', ['as' => 'admin.messages_landing_index', 'uses' => 'AdminController@messages_landing_index']);
        Route::any('/create', ['as' => 'admin.messages_landing_index.create', 'uses' => 'AdminController@messages_landing_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.messages_landing_index.delete', 'uses' => 'AdminController@messages_landing_delete']);
    });
    // quizs
    /*Route::group(['prefix' => 'quizs', 'middleware' => 'checkpermission:admin.whatsapp_msg'], function () {
        Route::any('/', ['as' => 'admin.quizs', 'uses' => 'AdminController@quizs_index']);
        Route::delete('/{id}/delete', ['as' => 'admin.quizs.delete', 'uses' => 'AdminController@quizs_delete']);
    });*/
    // messagevac
    Route::group(['prefix' => 'messagesvac', 'middleware' => 'checkpermission:admin.messagesvac'], function () {
        Route::any('/', ['as' => 'admin.messagesvac', 'uses' => 'AdminController@messagesvac_index']);
        //Route::delete('/{id}/delete', ['as' => 'admin.messagesvac.delete', 'uses' => 'AdminController@messagesvac_delete']);
    });
    // redirect_short
    Route::group(['prefix' => 'redirect_short', 'middleware' => 'checkpermission:admin.redirect_short'], function () {
        Route::any('/', ['as' => 'admin.redirect_short', 'uses' => 'AdminController@redirect_short_index']);
        Route::any('/create', ['as' => 'admin.redirect_short.create', 'uses' => 'AdminController@redirect_short_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.redirect_short.delete', 'uses' => 'AdminController@redirect_short_delete']);
    });
    // whatsapp_msg
    Route::group(['prefix' => 'whatsapp-msg', 'middleware' => 'checkpermission:admin.whatsapp_msg'], function () {
        Route::any('/', ['as' => 'admin.whatsapp_msg', 'uses' => 'AdminController@whatsapp_msg_index']);
        Route::any('/create', ['as' => 'admin.whatsapp_msg.create', 'uses' => 'AdminController@whatsapp_msg_edit']);
        Route::any('/download', ['as' => 'admin.whatsapp_msg.download', 'uses' => 'AdminController@whatsapp_msg_download']);
        Route::any('/{id}/edit', ['as' => 'admin.whatsapp_msg.edit', 'uses' => 'AdminController@whatsapp_msg_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.whatsapp_msg.delete', 'uses' => 'AdminController@whatsapp_msg_delete']);
    });
    // backup_msg
    Route::group(['prefix' => 'backup-msg', 'middleware' => 'checkpermission:admin.backup_msg'], function () {
        Route::any('/', ['as' => 'admin.backup_msg', 'uses' => 'AdminController@backup_msg_index']);
        Route::any('/create', ['as' => 'admin.backup_msg.create', 'uses' => 'AdminController@backup_msg_edit']);
        Route::any('/download', ['as' => 'admin.backup_msg.download', 'uses' => 'AdminController@backup_msg_download']);
        Route::any('/{id}/edit', ['as' => 'admin.backup_msg.edit', 'uses' => 'AdminController@backup_msg_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.backup_msg.delete', 'uses' => 'AdminController@backup_msg_delete']);
    });
    // statistics
    Route::group(['prefix' => 'statistics', 'middleware' => 'checkpermission:admin.statistics'], function () {
        Route::any('/', ['as' => 'admin.statistics', 'uses' => 'AdminController@statistics_index']);
        Route::delete('/{id}/delete', ['as' => 'admin.statistics.delete', 'uses' => 'AdminController@statistics_delete']);
    });
    // search
    Route::group(['prefix' => 'search', 'middleware' => 'checkpermission:admin.search'], function () {
        Route::any('/', ['as' => 'admin.search', 'uses' => 'AdminController@search_index']);
        Route::delete('/{id}/delete', ['as' => 'admin.search.delete', 'uses' => 'AdminController@search_delete']);
    });
    // wordsearch
    Route::group(['prefix' => 'wordsearch', 'middleware' => 'checkpermission:admin.wordsearch'], function () {
        Route::any('/', ['as' => 'admin.wordsearch', 'uses' => 'AdminController@wordsearch_index']);
        Route::any('/create', ['as' => 'admin.wordsearch.create', 'uses' => 'AdminController@wordsearch_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.wordsearch.edit', 'uses' => 'AdminController@wordsearch_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.wordsearch.delete', 'uses' => 'AdminController@wordsearch_delete']);
    });
    // redirectsearch
    Route::group(['prefix' => 'redirectsearch', 'middleware' => 'checkpermission:admin.redirectsearch'], function () {
        Route::any('/', ['as' => 'admin.redirectsearch', 'uses' => 'AdminController@redirectsearch_index']);
        Route::any('/{id}/edit', ['as' => 'admin.redirectsearch.edit', 'uses' => 'AdminController@redirectsearch_edit']);
    });
    // redirectsearchprojectsprojects
    Route::group(['prefix' => 'redirectsearchprojects', 'middleware' => 'checkpermission:admin.redirectsearchprojects'], function () {
        Route::any('/', ['as' => 'admin.redirectsearchprojects', 'uses' => 'AdminController@redirectsearchprojects_index']);
        Route::any('/{id}/edit', ['as' => 'admin.redirectsearchprojects.edit', 'uses' => 'AdminController@redirectsearchprojects_edit']);
    });
    // redirectsearchposts
    Route::group(['prefix' => 'redirectsearchposts', 'middleware' => 'checkpermission:admin.redirectsearchposts'], function () {
        Route::any('/', ['as' => 'admin.redirectsearchposts', 'uses' => 'AdminController@redirectsearchposts_index']);
        Route::any('/{id}/edit', ['as' => 'admin.redirectsearchposts.edit', 'uses' => 'AdminController@redirectsearchposts_edit']);
    });
    // client source
    Route::group(['prefix' => 'cltsrc', 'middleware' => 'checkpermission:admin.clientsource'], function () {
        Route::any('/', ['as' => 'admin.clientsource', 'uses' => 'AdminController@clientsource_index']);
        Route::any('/create', ['as' => 'admin.clientsource.create', 'uses' => 'AdminController@clientsource_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.clientsource.edit', 'uses' => 'AdminController@clientsource_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.clientsource.delete', 'uses' => 'AdminController@clientsource_delete']);
    });
    // cities
    Route::group(['prefix' => 'cities', 'middleware' => 'checkpermission:admin.cities'], function () {
        Route::any('/', ['as' => 'admin.cities', 'uses' => 'AdminController@cities_index']);
        Route::any('/create', ['as' => 'admin.cities.create', 'uses' => 'AdminController@cities_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.cities.edit', 'uses' => 'AdminController@cities_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.cities.delete', 'uses' => 'AdminController@cities_delete']);
    });
    // countries
    Route::group(['prefix' => 'countries', 'middleware' => 'checkpermission:admin.countries'], function () {
        Route::any('/', ['as' => 'admin.countries', 'uses' => 'AdminController@countries_index']);
        Route::any('/create', ['as' => 'admin.countries.create', 'uses' => 'AdminController@countries_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.countries.edit', 'uses' => 'AdminController@countries_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.countries.delete', 'uses' => 'AdminController@countries_delete']);
    });
    // jobs
    Route::group(['prefix' => 'jobs', 'middleware' => 'checkpermission:admin.jobs'], function () {
        Route::any('/', ['as' => 'admin.jobs', 'uses' => 'AdminController@jobs_index']);
        Route::any('/create', ['as' => 'admin.jobs.create', 'uses' => 'AdminController@jobs_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.jobs.edit', 'uses' => 'AdminController@jobs_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.jobs.delete', 'uses' => 'AdminController@jobs_delete']);
    });
    // anchors
    Route::group(['prefix' => 'anchors'], function () {
        Route::any('/', ['as' => 'admin.anchors', 'uses' => 'AdminController@anchors_index']);
        Route::get('/export', ['as' => 'admin.anchors.export', 'uses' => 'AdminController@anchors_export']);
        Route::get('/check-status', ['as' => 'admin.anchors.check_status', 'uses' => 'AdminController@test_link_statuses']);
        Route::get('/update-external-link-statuses', ['as' => 'admin.update_external_link_statuses', 'uses' => 'AdminController@update_external_link_statuses']);
        Route::post('/update-link-statuses', ['as' => 'admin.update_link_statuses', 'uses' => 'AdminController@update_link_statuses']);
        Route::post('/mass-update', ['as' => 'admin.anchors.mass_update', 'uses' => 'AdminController@anchors_mass_update']);
    });
    //metatag tool
    Route::group(['prefix' => 'metatagtool'], function () {
       Route::any('/', ['as' => 'admin.metatag_tool', 'uses' => 'AdminController@metatagtool_index']); 
    });
    Route::post('/metatagtool/crawl', [
        'as' => 'admin.metatagtool.crawl',
        'uses' => 'AdminController@metatagtool_crawl'
    ]);
    Route::post('/metatagtool/update', [
        'as' => 'admin.metatagtool.update',
        'uses' => 'AdminController@metatagtool_update'
    ]);
    // CTA
    Route::group(['prefix' => 'cta'], function () {
       Route::any('/', ['as' => 'admin.cta', 'uses' => 'AdminController@cta_index']); 
    });
    // Whatsapp API
    Route::get('/whatsappapi', [
        'as' => 'admin.whatsappapi',
        'middleware' => 'checkpermission:admin.whatsapp_msg',
        'uses' => '\App\Http\Controllers\WhatsAppWebhookController@index'
    ]);
    Route::post('/whatsappapi/send', [
        'as' => 'admin.whatsappapi.send',
        'middleware' => 'checkpermission:admin.whatsapp_msg',
        'uses' => '\App\Http\Controllers\WhatsAppWebhookController@send'
    ]);
    // whatsapp api contacts
    Route::group(['prefix' => 'whatsapp-contacts', 'middleware' => 'checkpermission:admin.whatsapp_msg'], function () {
        Route::get('/', [
            'as' => 'admin.whatsapp_contacts',
            'uses' => 'WhatsAppContactController@index',
        ]);
        Route::post('/', [
            'as' => 'admin.whatsapp_contacts.store',
            'uses' => 'WhatsAppContactController@store',
        ]);
    });
    // whatsapp api chat
    Route::group(['prefix' => 'whatsappchat'], function () {
       Route::any('/', ['as' => 'admin.whatsapp_chat', 'uses' => 'AdminController@whatsapp_chat_index']); 
    });
    // competitors
    Route::group(['prefix' => 'competitors', 'middleware' => 'checkpermission:admin.competitors'], function () {
        Route::any('/', ['as' => 'admin.competitors', 'uses' => 'AdminController@competitors_index']);
        Route::any('/create_ads', ['as' => 'admin.competitors_ads.create', 'uses' => 'AdminController@competitors_ads_edit']);
        Route::any('/create', ['as' => 'admin.competitors.create', 'uses' => 'AdminController@competitors_edit']);
        Route::any('/{id}/edit_ads', ['as' => 'admin.competitors_ads.edit', 'uses' => 'AdminController@competitors_ads_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.competitors.edit', 'uses' => 'AdminController@competitors_edit']);
        Route::any('/{id}/delete_ads', ['as' => 'admin.competitors_ads.delete', 'uses' => 'AdminController@competitors_ads_delete']);
        Route::delete('/{id}/delete', ['as' => 'admin.competitors.delete', 'uses' => 'AdminController@competitors_delete']);
    });
    // jobsRoute::any('/keywords2', ['as' => 'admin.keywords2', 'uses' => 'AdminController@keywords2']);
    Route::group(['prefix' => 'keywords2', 'middleware' => 'checkpermission:admin.blog'], function () {
        Route::any('/', ['as' => 'admin.keywords2', 'uses' => 'AdminController@keywords2_index']);
        Route::any('/create', ['as' => 'admin.keywords2.create', 'uses' => 'AdminController@keywords2_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.keywords2.edit', 'uses' => 'AdminController@keywords2_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.keywords2.delete', 'uses' => 'AdminController@keywords2_delete']);
    });
    // pubs
    Route::group(['prefix' => 'pubs', 'middleware' => 'checkpermission:admin.projects'], function () {
        Route::any('/', ['as' => 'admin.pubs', 'uses' => 'ProjectController@pubs_index']);
        Route::any('/create', ['as' => 'admin.pubs.create', 'uses' => 'ProjectController@pubs_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.pubs.edit', 'uses' => 'ProjectController@pubs_edit']);
        //Route::delete('/{id}/delete', ['as' => 'admin.pubs.delete', 'uses' => 'AdminController@pubs_delete']);
    });
    // regions
    Route::group(['prefix' => 'regions', 'middleware' => 'checkpermission:admin.regions'], function () {
        Route::any('/', ['as' => 'admin.regions', 'uses' => 'AdminController@regions_index']);
        Route::any('/create', ['as' => 'admin.regions.create', 'uses' => 'AdminController@regions_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.regions.edit', 'uses' => 'AdminController@regions_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.regions.delete', 'uses' => 'AdminController@regions_delete']);
    });
    // sale manager
    Route::group(['prefix' => 'salesmanagers', 'middleware' => 'checkpermission:admin.salesmanagers'], function () {
        Route::any('/', ['as' => 'admin.salesmanagers', 'uses' => 'AdminController@salesmanagers_index']);
        Route::any('/create', ['as' => 'admin.salesmanagers.create', 'uses' => 'AdminController@salesmanagers_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.salesmanagers.edit', 'uses' => 'AdminController@salesmanagers_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.salesmanagers.delete', 'uses' => 'AdminController@salesmanagers_delete']);
    });
    // sale manager
    Route::group(['prefix' => 'salesmanagers_reviews', 'middleware' => 'checkpermission:admin.salesmanagers_reviews'], function () {
        Route::any('/', ['as' => 'admin.salesmanagers_reviews', 'uses' => 'AdminController@salesmanagers_reviews_index']);
        //Route::any('/create', ['as' => 'admin.salesmanagers_reviews.create', 'uses' => 'AdminController@salesmanagers_reviews_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.salesmanagers_reviews.edit', 'uses' => 'AdminController@salesmanagers_reviews_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.salesmanagers_reviews.delete', 'uses' => 'AdminController@salesmanagers_reviews_delete']);
    });
    // testimonials
    Route::group(['prefix' => 'testimonials', 'middleware' => 'checkpermission:admin.testimonials'], function () {
        Route::any('/', ['as' => 'admin.testimonials', 'uses' => 'AdminController@testimonials_index']);
        Route::any('/create', ['as' => 'admin.testimonials.create', 'uses' => 'AdminController@testimonials_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.testimonials.edit', 'uses' => 'AdminController@testimonials_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.testimonials.delete', 'uses' => 'AdminController@testimonials_delete']);
    });
    // videos
    Route::group(['prefix' => 'videos', 'middleware' => 'checkpermission:admin.medias'], function () {
        Route::any('/', ['as' => 'admin.videos', 'uses' => 'AdminController@videos_index']);
        Route::any('/create', ['as' => 'admin.videos.create', 'uses' => 'AdminController@videos_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.videos.edit', 'uses' => 'AdminController@videos_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.videos.delete', 'uses' => 'AdminController@videos_delete']);
    });
    // branch
    Route::group(['prefix' => 'branch', 'middleware' => 'checkpermission:admin.branch'], function () {
        Route::any('/', ['as' => 'admin.branch', 'uses' => 'AdminController@branch_index']);
        Route::any('/create', ['as' => 'admin.branch.create', 'uses' => 'AdminController@branch_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.branch.edit', 'uses' => 'AdminController@branch_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.branch.delete', 'uses' => 'AdminController@branch_delete']);
    });
    // landing page
    Route::group(['prefix' => 'landingpage', 'middleware' => 'checkpermission:admin.landingpage'], function () {
        Route::any('/', ['as' => 'admin.landingpage', 'uses' => 'AdminController@landingpage_index']);
        Route::any('/create', ['as' => 'admin.landingpage.create', 'uses' => 'AdminController@landingpage_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.landingpage.edit', 'uses' => 'AdminController@landingpage_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.landingpage.delete', 'uses' => 'AdminController@landingpage_delete']);
        Route::post('/{id}/initializeviews', ['as' => 'admin.landingpage.initializeviews', 'uses' => 'AdminController@landingpage_initializeviews']);
    });
    // new landing page
    Route::group(['prefix' => 'newlandingpage', 'middleware' => 'checkpermission:admin.landingpage'], function () {
        Route::any('/', ['as' => 'admin.newlandingpage', 'uses' => 'AdminController@newlandingpage_index']);
        Route::any('/create', ['as' => 'admin.newlandingpage.create', 'uses' => 'AdminController@newlandingpage_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.newlandingpage.edit', 'uses' => 'AdminController@newlandingpage_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.newlandingpage.delete', 'uses' => 'AdminController@newlandingpage_delete']);
        Route::post('/{id}/initializeviews', ['as' => 'admin.newlandingpage.initializeviews', 'uses' => 'AdminController@newlandingpage_initializeviews']);
    });
    // landing2 page
    Route::group(['prefix' => 'landing2'/*, 'middleware' => 'checkpermission:admin.landing2'*/], function () {
        Route::any('/', ['as' => 'admin.landing2', 'uses' => 'AdminController@landing2_index']);
        Route::any('/create', ['as' => 'admin.landing2.create', 'uses' => 'AdminController@landing2_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.landing2.edit', 'uses' => 'AdminController@landing2_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.landing2.delete', 'uses' => 'AdminController@landing2_delete']);
        //Route::post('/{id}/initializeviews', ['as' => 'admin.landing2.initializeviews', 'uses' => 'AdminController@landing2_initializeviews']);
    });
    // landing3 page
    Route::group(['prefix' => 'landing3'/*, 'middleware' => 'checkpermission:admin.landing3'*/], function () {
        Route::any('/', ['as' => 'admin.landing3', 'uses' => 'AdminController@landing3_index']);
        Route::any('/create', ['as' => 'admin.landing3.create', 'uses' => 'AdminController@landing3_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.landing3.edit', 'uses' => 'AdminController@landing3_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.landing3.delete', 'uses' => 'AdminController@landing3_delete']);
        //Route::post('/{id}/initializeviews', ['as' => 'admin.landing3.initializeviews', 'uses' => 'AdminController@landing3_initializeviews']);
    });
    Route::group(['prefix' => 'landing_tourism'/*, 'middleware' => 'checkpermission:admin.landing_tourism'*/], function () {
        Route::any('/', ['as' => 'admin.landing_tourism', 'uses' => 'AdminController@landing_tourism_index']);
        Route::any('/create', ['as' => 'admin.landing_tourism.create', 'uses' => 'AdminController@landing_tourism_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.landing_tourism.edit', 'uses' => 'AdminController@landing_tourism_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.landing_tourism.delete', 'uses' => 'AdminController@landing_tourism_delete']);
        //Route::post('/{id}/initializeviews', ['as' => 'admin.landing_tourism.initializeviews', 'uses' => 'AdminController@landing_tourism_initializeviews']);
    });
    // newsletter
    Route::group(['prefix' => 'newsletter', 'middleware' => 'checkpermission:admin.newsletter'], function () {
        Route::any('/', ['as' => 'admin.newsletter', 'uses' => 'AdminController@newsletter_index']);
		Route::any('/{id}/edit', ['as' => 'admin.newsletter.edit', 'uses' => 'AdminController@newsletter_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.newsletter.delete', 'uses' => 'AdminController@newsletter_delete']);
    });
    // projects
    Route::group(['prefix' => 'projects', 'middleware' => 'checkpermission:admin.projects'], function () {
        Route::any('/', ['as' => 'admin.projects', 'uses' => 'ProjectController@projects_index']);
        Route::any('/create', ['as' => 'admin.projects.create', 'uses' => 'ProjectController@projects_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.projects.edit', 'uses' => 'ProjectController@projects_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.projects.delete', 'uses' => 'ProjectController@projects_delete']);
        Route::post('/{id}/deletevideo', ['as' => 'admin.projects.deletevideo', 'uses' => 'ProjectController@deletevideo']);
    });
    Route::group(['prefix' => 'introcard', 'middleware' => 'checkpermission:admin.projects'], function () {
        //Route::any('/create', ['as' => 'admin.introcard.create', 'uses' => 'ProjectController@introcard_edit']);
        Route::any('/edit', ['as' => 'admin.introcard.edit', 'uses' => 'ProjectController@introcard_edit']);
        /*Route::delete('/{id}/delete', ['as' => 'admin.introcard.delete', 'uses' => 'ProjectController@introcard_delete']);*/
    });
	
    Route::group(['prefix' => 'fpost', 'middleware' => 'checkpermission:admin.blog'], function () {
        Route::any('/edit', ['as' => 'admin.fpost.edit', 'uses' => 'BlogController@fpost_edit']);
    });
    Route::group(['prefix' => 'projectfilter', 'middleware' => 'checkpermission:admin.projects'], function () {
        //Route::any('/create', ['as' => 'admin.introcard.create', 'uses' => 'ProjectController@introcard_edit']);
        Route::any('/edit', ['as' => 'admin.projectfilter.edit', 'uses' => 'ProjectController@projectfilter_edit']);
        /*Route::delete('/{id}/delete', ['as' => 'admin.introcard.delete', 'uses' => 'ProjectController@introcard_delete']);*/
    });
	
    // companies
    Route::group(['prefix' => 'companies', 'middleware' => 'checkpermission:admin.projects'], function () {
        Route::any('/', ['as' => 'admin.companies', 'uses' => 'ProjectController@companies_index']);
        Route::any('/create', ['as' => 'admin.companies.create', 'uses' => 'ProjectController@companies_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.companies.edit', 'uses' => 'ProjectController@companies_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.companies.delete', 'uses' => 'ProjectController@companies_delete']);
    });
    // project type
    Route::group(['prefix' => 'projecttype', 'middleware' => 'checkpermission:admin.projects'], function () {
        Route::any('/', ['as' => 'admin.projecttype', 'uses' => 'ProjectController@projecttype_index']);
        Route::any('/create', ['as' => 'admin.projecttype.create', 'uses' => 'ProjectController@projecttype_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.projecttype.edit', 'uses' => 'ProjectController@projecttype_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.projecttype.delete', 'uses' => 'ProjectController@projecttype_delete']);
    });
    // projects categories
    Route::group(['prefix' => 'projectcategory', 'middleware' => 'checkpermission:admin.projects'], function () {
        Route::any('/', ['as' => 'admin.projectcategory', 'uses' => 'ProjectController@projectcategory_index']);
        Route::any('/create', ['as' => 'admin.projectcategory.create', 'uses' => 'ProjectController@projectcategory_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.projectcategory.edit', 'uses' => 'ProjectController@projectcategory_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.projectcategory.delete', 'uses' => 'ProjectController@projectcategory_delete']);
    });
    // projects features
    Route::group(['prefix' => 'projectfeature', 'middleware' => 'checkpermission:admin.projects'], function () {
        Route::any('/', ['as' => 'admin.projectfeature', 'uses' => 'ProjectController@features_index']);
        Route::any('/create', ['as' => 'admin.projectfeature.create', 'uses' => 'ProjectController@features_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.projectfeature.edit', 'uses' => 'ProjectController@features_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.projectfeature.delete', 'uses' => 'ProjectController@feature_delete']);
    });
    // apparence
    Route::group(['prefix' => 'apparence', 'middleware' => 'checkpermission:admin.apparence'], function () {
        Route::group(['prefix' => 'menus'], function () {
            Route::any('/{id?}', ['as' => 'admin.apparence.menus', 'uses' => 'ApparenceController@menus']);
            Route::delete('/{id}/delete', ['as' => 'admin.apparence.menus.delete', 'uses' => 'ApparenceController@menus_delete']);
        });
        // sliders
        Route::group(['prefix' => 'sliders'], function () {
            Route::any('/', ['as' => 'admin.apparence.sliders', 'uses' => 'ApparenceController@sliders']);
            Route::any('/create', ['as' => 'admin.apparence.sliders.create', 'uses' => 'ApparenceController@sliders_edit']);
            Route::any('/{id}/edit', ['as' => 'admin.apparence.sliders.edit', 'uses' => 'ApparenceController@sliders_edit']);
            Route::delete('/{id}/delete', ['as' => 'admin.apparence.sliders.delete', 'uses' => 'ApparenceController@sliders_delete']);
        });
        // sections
        Route::group(['prefix' => 'sections'], function () {
            Route::any('/', ['as' => 'admin.apparence.sections', 'uses' => 'ApparenceController@sections']);
            Route::any('/create', ['as' => 'admin.apparence.sections.create', 'uses' => 'ApparenceController@sections_edit']);
            Route::any('/{id}/edit', ['as' => 'admin.apparence.sections.edit', 'uses' => 'ApparenceController@sections_edit']);
            Route::delete('/{id}/delete', ['as' => 'admin.apparence.sections.delete', 'uses' => 'ApparenceController@sections_delete']);
        });
		
        // sectionvideos
        Route::group(['prefix' => 'sectionvideos'], function () {
            Route::any('/', ['as' => 'admin.apparence.sectionvideos', 'uses' => 'ApparenceController@sectionvideos']);
            Route::any('/create', ['as' => 'admin.apparence.sectionvideos.create', 'uses' => 'ApparenceController@sectionvideos_edit']);
            Route::any('/{id}/edit', ['as' => 'admin.apparence.sectionvideos.edit', 'uses' => 'ApparenceController@sectionvideos_edit']);
            Route::delete('/{id}/delete', ['as' => 'admin.apparence.sectionvideos.delete', 'uses' => 'ApparenceController@sectionvideos_delete']);
        });
		
        // footer
        Route::group(['prefix' => 'footer'], function () {
            Route::any('/{id?}/{action?}', ['as' => 'admin.apparence.footer', 'uses' => 'ApparenceController@footer']);
            Route::delete('/{id}/links/delete', ['as' => 'admin.apparence.footer.delete', 'uses' => 'ApparenceController@footer_link_delete']);
        });
    });
    // medias
    Route::group(['prefix' => 'medias', 'middleware' => 'checkpermission:admin.medias'], function () {
        Route::any('/', ['as' => 'admin.medias', 'uses' => 'AdminController@medias_index']);
        Route::any('/create', ['as' => 'admin.medias.create', 'uses' => 'AdminController@medias_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.medias.edit', 'uses' => 'AdminController@medias_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.medias.delete', 'uses' => 'AdminController@medias_delete']);
        // folders
        Route::group(['prefix' => 'folders'], function () {
            Route::any('/', ['as' => 'admin.medias.folders', 'uses' => 'AdminController@medias_folders_index']);
            Route::any('/{id}/edit', ['as' => 'admin.medias.folders.edit', 'uses' => 'AdminController@medias_folders_edit']);
            Route::delete('/{id}/delete', ['as' => 'admin.medias.folders.delete', 'uses' => 'AdminController@medias_folders_delete']);
        });
        // pagination
        Route::any('/list', ['as' => 'admin.medias.list', 'uses' => 'AdminController@medias_list']);
        Route::any('/projects/{id}', ['uses' => 'AdminController@projects_medias']);
		
		
    });
    // blog
    Route::group(['prefix' => 'blog', 'middleware' => 'checkpermission:admin.blog'], function () {
        Route::any('/', ['as' => 'admin.blog.posts', 'uses' => 'BlogController@index']);
        Route::any('/create', ['as' => 'admin.blog.posts.create', 'uses' => 'BlogController@edit']);
        Route::any('/{id}/edit', ['as' => 'admin.blog.posts.edit', 'uses' => 'BlogController@edit']);
        Route::delete('/{id}/delete',  ['middleware' => 'checkpermission:admin.blog','as' => 'admin.blog.posts.delete', 'uses' => 'BlogController@delete']);
        // blog sections
        Route::group(['prefix' => 'sections'], function () {
            Route::any('/', ['as' => 'admin.blog.sections', 'uses' => 'BlogController@sections']);
            Route::any('/create', ['as' => 'admin.blog.sections.create', 'uses' => 'BlogController@sections_edit']);
            Route::any('/{id}/edit', ['as' => 'admin.blog.sections.edit', 'uses' => 'BlogController@sections_edit']);
            Route::delete('/{id}/delete', ['as' => 'admin.blog.sections.delete', 'uses' => 'BlogController@sections_delete']);
        });
        Route::any('/params', ['as' => 'admin.blog.params', 'uses' => 'BlogController@params']);
        Route::any('/paramsOman', ['as' => 'admin.blog.paramsOman', 'uses' => 'BlogController@paramsOman']);
        Route::any('/paramsSyria', ['as' => 'admin.blog.paramsSyria', 'uses' => 'BlogController@paramsSyria']);
        
        
        /* categories */
        Route::group(['prefix' => 'categories'], function () {
            Route::any('/', ['as' => 'admin.blog.categories', 'uses' => 'BlogController@categories']);
            Route::any('/create', ['as' => 'admin.blog.categories.create', 'uses' => 'BlogController@categories_edit']);
            Route::any('/{id}/edit', ['as' => 'admin.blog.categories.edit', 'uses' => 'BlogController@categories_edit']);
            Route::delete('/{id}/delete', ['as' => 'admin.blog.categories.delete', 'uses' => 'BlogController@categories_delete']);
        });
        Route::group(['prefix' => 'tags'], function () {
            Route::any('/', ['as' => 'admin.blog.tags', 'uses' => 'BlogController@tags']);
            Route::any('/create', ['as' => 'admin.blog.tags.create', 'uses' => 'BlogController@tags_edit']);
            Route::any('/{id}/edit', ['as' => 'admin.blog.tags.edit', 'uses' => 'BlogController@tags_edit']);
            Route::delete('/{id}/delete', ['as' => 'admin.blog.tags.delete', 'uses' => 'BlogController@tags_delete']);
        });
    });
	// News
    Route::group(['prefix' => 'news', 'middleware' => 'checkpermission:admin.blog'], function () {
        Route::any('/', ['as' => 'admin.news.posts', 'uses' => 'BlogController@index']);
        Route::any('/create', ['as' => 'admin.news.posts.create', 'uses' => 'BlogController@edit']);
        Route::any('/{id}/edit', ['as' => 'admin.news.posts.edit', 'uses' => 'BlogController@edit']);
        Route::delete('/{id}/delete',  ['middleware' => 'checkpermission:admin.blog','as' => 'admin.news.posts.delete', 'uses' => 'BlogController@delete']);
        // blog sections
        Route::group(['prefix' => 'sections'], function () {
            Route::any('/', ['as' => 'admin.news.sections', 'uses' => 'BlogController@sections']);
            Route::any('/create', ['as' => 'admin.news.sections.create', 'uses' => 'BlogController@sections_edit']);
            Route::any('/{id}/edit', ['as' => 'admin.news.sections.edit', 'uses' => 'BlogController@sections_edit']);
            Route::delete('/{id}/delete', ['as' => 'admin.news.sections.delete', 'uses' => 'BlogController@sections_delete']);
        });
        Route::any('/params', ['as' => 'admin.news.params', 'uses' => 'BlogController@params']);
        /* categories */
        Route::group(['prefix' => 'categories'], function () {
            Route::any('/', ['as' => 'admin.news.categories', 'uses' => 'BlogController@categories']);
            Route::any('/create', ['as' => 'admin.news.categories.create', 'uses' => 'BlogController@categories_edit']);
            Route::any('/{id}/edit', ['as' => 'admin.news.categories.edit', 'uses' => 'BlogController@categories_edit']);
            Route::delete('/{id}/delete', ['as' => 'admin.news.categories.delete', 'uses' => 'BlogController@categories_delete']);
        });
        Route::group(['prefix' => 'tags'], function () {
            Route::any('/', ['as' => 'admin.news.tags', 'uses' => 'BlogController@tags']);
            Route::any('/create', ['as' => 'admin.news.tags.create', 'uses' => 'BlogController@tags_edit']);
            Route::any('/{id}/edit', ['as' => 'admin.news.tags.edit', 'uses' => 'BlogController@tags_edit']);
            Route::delete('/{id}/delete', ['as' => 'admin.news.tags.delete', 'uses' => 'BlogController@tags_delete']);
        });
    });
    // Developers
    Route::group(['prefix' => 'developers', 'middleware' => 'checkpermission:admin.blog'], function () {
        Route::any('/', ['as' => 'admin.developer.posts', 'uses' => 'BlogController@index']);
        Route::any('/create', ['as' => 'admin.developer.posts.create', 'uses' => 'BlogController@edit']);
        Route::any('/{id}/edit', ['as' => 'admin.developer.posts.edit', 'uses' => 'BlogController@edit']);
        Route::delete('/{id}/delete', ['middleware' => 'checkpermission:admin.blog','as' => 'admin.developer.posts.delete', 'uses' => 'BlogController@delete']);
    });
    // Reports
    Route::group(['prefix' => 'reports', 'middleware' => 'checkpermission:admin.blog'], function () {
        Route::any('/', ['as' => 'admin.report.posts', 'uses' => 'BlogController@index']);
        Route::any('/create', ['as' => 'admin.report.posts.create', 'uses' => 'BlogController@edit']);
        Route::any('/{id}/edit', ['as' => 'admin.report.posts.edit', 'uses' => 'BlogController@edit']);
        Route::delete('/{id}/delete', ['middleware' => 'checkpermission:admin.blog','as' => 'admin.report.posts.delete', 'uses' => 'BlogController@delete']);
    });
	
	
	
    Route::group(['prefix' => 'faqpost', 'middleware' => 'checkpermission:admin.faq'], function () {
    // pages
		Route::any('/', ['as' => 'admin.faqpost', 'uses' => 'AdminController@faqpost']);
		Route::any('/create', ['as' => 'admin.faqpost.create', 'uses' => 'AdminController@faqpost_create']);
		Route::any('/{id}/edit', ['as' => 'admin.faqpost.edit', 'uses' => 'AdminController@faqpost_edit']);
		Route::delete('/{id}/delete', ['as' => 'admin.faqpost.delete', 'uses' => 'AdminController@faqpost_delete']);
		
	});
    Route::group(['prefix' => 'faqpost2', 'middleware' => 'checkpermission:admin.faq'], function () {
    // pages
		Route::any('/{id}/create', ['as' => 'admin.faqpost2.create', 'uses' => 'AdminController@faqpost2_edit']);
		Route::any('/{id}/list', ['as' => 'admin.faqpost2', 'uses' => 'AdminController@faqpost2']);
		Route::any('/{id}/edit', ['as' => 'admin.faqpost2.edit', 'uses' => 'AdminController@faqpost2_edit']);
		Route::delete('/{id}/delete', ['as' => 'admin.faqpost2.delete', 'uses' => 'AdminController@faqpost2_delete']);
		
	});
	Route::group(['prefix' => 'pages', 'middleware' => 'checkpermission:admin.faq'], function () {
        Route::any('/faq', ['as' => 'admin.pages.faq', 'uses' => 'AdminController@pages_faq']);
        Route::any('/offers', ['as' => 'admin.pages.offers', 'uses' => 'AdminController@pages_offers']);
	});
		
    Route::group(['prefix' => 'livingcat'], function () {
		Route::any('/', ['as' => 'admin.livingcat', 'uses' => 'AdminController@livingcat']);
		Route::any('/create', ['as' => 'admin.livingcat.create', 'uses' => 'AdminController@livingcat_edit']);
		Route::any('/{id}/edit', ['as' => 'admin.livingcat.edit', 'uses' => 'AdminController@livingcat_edit']);
		Route::delete('/{id}/delete', ['as' => 'admin.livingcat.delete', 'uses' => 'AdminController@livingcat_delete']);
	});
    Route::group(['prefix' => 'pages'], function () {
        //Route::any('/quiz', ['as' => 'admin.pages.quiz', 'uses' => 'AdminController@pages_quiz']);
        Route::any('/privacy', ['as' => 'admin.pages.privacy', 'uses' => 'AdminController@pages_privacy']);
        Route::any('/resale', ['as' => 'admin.pages.resale', 'uses' => 'AdminController@pages_resale']);
        Route::any('/rating', ['as' => 'admin.pages.rating', 'uses' => 'AdminController@pages_rating']);
        Route::any('/turkish_nationality', ['as' => 'admin.pages.turkish_nationality', 'uses' => 'AdminController@pages_turkish_nationality']);
        Route::any('/turkey_territories', ['as' => 'admin.pages.turkey_territories', 'uses' => 'AdminController@pages_turkey_territories']);
        Route::any('/turkey_guide', ['as' => 'admin.pages.turkey_guide', 'uses' => 'AdminController@pages_turkey_guide']);
        Route::any('/360', ['as' => 'admin.pages.360', 'uses' => 'AdminController@pages_360']);
        //Route::any('/resale', ['as' => 'admin.pages.resale', 'uses' => 'AdminController@pages_resale']);
		
        
		Route::any('/terms', ['as' => 'admin.pages.terms', 'uses' => 'AdminController@pages_terms']);
        Route::any('/about-us', ['as' => 'admin.pages.aboutus', 'uses' => 'AdminController@pages_about_us']);
        Route::any('/turkish-citizenship', ['as' => 'admin.pages.turkish_citizenship', 'uses' => 'AdminController@pages_turkish_citizenship']);
        Route::any('/legal', ['as' => 'admin.pages.legal', 'uses' => 'AdminController@pages_legal']);
        Route::any('/investment', ['as' => 'admin.pages.investment', 'uses' => 'AdminController@pages_investment']);
        Route::any('/living_turkey', ['as' => 'admin.pages.living_turkey', 'uses' => 'AdminController@pages_living_turkey']);
    
        Route::any('/vacancies', ['as' => 'admin.pages.vacancies', 'uses' => 'AdminController@pages_vacancies']);
        /* search seo page */
        Route::group(['prefix' => 'search', 'middleware' => 'checkpermission:admin.pages.search'], function () {
            Route::any('/', ['as' => 'admin.pages.search', 'uses' => 'AdminController@pages_search']);
            Route::any('/create', ['as' => 'admin.pages.search.create', 'uses' => 'AdminController@pages_search_edit']);
            Route::any('/{id}/edit', ['as' => 'admin.pages.search.edit', 'uses' => 'AdminController@pages_search_edit']);
            Route::delete('/{id}/delete', ['as' => 'admin.pages.search.delete', 'uses' => 'AdminController@pages_search_delete']);
        });
    });
    // users
    Route::group(['prefix' => 'users', 'middleware' => 'checkpermission:admin.users'], function () {
        Route::any('/', ['as' => 'admin.users', 'uses' => 'AdminController@users_index']);
        Route::any('/create', ['as' => 'admin.users.create', 'uses' => 'AdminController@users_edit']);
        Route::any('/{id}/edit', ['as' => 'admin.users.edit', 'uses' => 'AdminController@users_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.users.delete', 'uses' => 'AdminController@users_delete']);
        /* Roles */
        Route::group(['prefix' => 'roles'], function () {
            Route::any('/', ['as' => 'admin.users.roles', 'uses' => 'AdminController@users_roles_index']);
            Route::any('/create', ['as' => 'admin.users.roles.create', 'uses' => 'AdminController@users_roles_edit']);
            Route::any('/{id}/edit', ['as' => 'admin.users.roles.edit', 'uses' => 'AdminController@users_roles_edit']);
            Route::delete('/{id}/delete', ['as' => 'admin.users.roles.delete', 'uses' => 'AdminController@users_roles_delete']);
        });
    });
    // compte
    Route::group(['prefix' => 'compte'], function () {
        Route::any('/', ['as' => 'admin.compte', 'uses' => 'AdminController@compte']);
    });
    // stats
    Route::group(['prefix' => 'stats', 'middleware' => 'checkpermission:admin.stats'], function () {
        Route::any('/', ['as' => 'admin.stats', 'uses' => 'AdminController@stats_index']);
        Route::any('/create', ['as' => 'admin.stats.create', 'uses' => 'AdminController@stats_edit']);
        Route::delete('/{id}/delete', ['as' => 'admin.stats.delete', 'uses' => 'AdminController@stats_delete']);
        Route::post('/{id}/block', ['as' => 'admin.stats.block', 'uses' => 'AdminController@stats_block']);
    });
    
});
