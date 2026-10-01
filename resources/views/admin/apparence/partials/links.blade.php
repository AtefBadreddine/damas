<?php
    $footerLinksRoute = Route::currentRouteName();
    $isFooterLinksPage = $footerLinksRoute === 'admin.apparence.footer';
    $footerUsefulLinks = array();
    $footerUsefulCountryGroups = array();
    $footerActiveCountryId = null;
    $footerHasCurrentUsefulLink = false;
    if ($isFooterLinksPage) {
        $footerCountries = \App\Models\Country::ordered()->get();
        $footerUsefulLinks = Helper::query("FooterLink", "orderByPlacement")
            ->where("footer_section", "useful")->toArray();
        $footerLegacyCountry = \App\Models\Country::findBySlugOrCode('turkey');
        $footerLegacyCountryId = $footerLegacyCountry ? (int)$footerLegacyCountry->id : 0;
        $footerLinksByCountry = array();
        foreach ($footerUsefulLinks as $footerUsefulLink) {
            $footerLinkCountryId = !empty($footerUsefulLink['country_id'])
                ? (int)$footerUsefulLink['country_id'] : $footerLegacyCountryId;
            if (!isset($footerLinksByCountry[$footerLinkCountryId])) {
                $footerLinksByCountry[$footerLinkCountryId] = array();
            }
            $footerLinksByCountry[$footerLinkCountryId][] = $footerUsefulLink;
            if ((int)$footerUsefulLink['id'] === (int)$menu->id) {
                $footerHasCurrentUsefulLink = true;
                $footerActiveCountryId = $footerLinkCountryId;
            }
        }
        foreach ($footerCountries as $footerCountry) {
            $footerCountryId = (int)$footerCountry->id;
            if (!empty($footerLinksByCountry[$footerCountryId])) {
                $footerUsefulCountryGroups[$footerCountryId] = array(
                    'country' => $footerCountry,
                    'links' => $footerLinksByCountry[$footerCountryId],
                );
            }
        }
        if (!$footerHasCurrentUsefulLink) {
            $footerPreferredCountryId = $menu->id
                ? (int)$menu->country_id : (int)\Request::query('country_id', 0);
            if (isset($footerUsefulCountryGroups[$footerPreferredCountryId])) {
                $footerActiveCountryId = $footerPreferredCountryId;
            }
        }
        if (!isset($footerUsefulCountryGroups[$footerActiveCountryId])) {
            $footerActiveCountryId = null;
            foreach ($footerUsefulCountryGroups as $footerCountryId => $footerCountryGroup) {
                $footerActiveCountryId = $footerCountryId;
                break;
            }
        }
    }
    $footerCanDeleteUsefulLink = $isFooterLinksPage && $menu->id && $menu->footer_section === 'useful';
?>

<?= Form::open(); ?>
<div class="panel with-nav-tabs panel-default">
    <div class="panel-heading">
        <div style="margin-bottom:10px;">Keywords</div>
        @if($isFooterLinksPage)
        <ul class="nav nav-tabs footer-country-tabs">
            @foreach($footerUsefulCountryGroups as $footerCountryId => $footerCountryGroup)
            <li class="<?= $footerActiveCountryId === $footerCountryId ? 'active' : ''; ?>">
                <a href="{{ route($footerLinksRoute, $footerCountryGroup['links'][0]['id']) }}">
                    {{ $footerCountryGroup['country']->name_en }}
                </a>
            </li>
            @endforeach
        </ul>

        <ul class="nav nav-tabs footer-useful-link-tabs">
            @if(isset($footerUsefulCountryGroups[$footerActiveCountryId]))
            @foreach($footerUsefulCountryGroups[$footerActiveCountryId]['links'] as $footerUsefulLink)
            <li class="<?= (int)$menu->id === (int)$footerUsefulLink['id'] ? 'active' : ''; ?>">
                <a href="{{ route($footerLinksRoute, $footerUsefulLink['id']) }}">
                    {{ $footerUsefulLink['title_ar'] ?: ($footerUsefulLink['title_en'] ?: 'Link #'.$footerUsefulLink['id']) }}
                </a>
            </li>
            @endforeach
            @endif
            @if($menu->id && !$footerHasCurrentUsefulLink)
            <li class="active"><a href="{{ route($footerLinksRoute, $menu->id) }}">Edit Current Link</a></li>
            @endif
            <li class="<?= !$menu->id ? 'active' : ''; ?>">
                <a href="{{ route($footerLinksRoute, 0).($footerActiveCountryId !== null ? '?country_id='.$footerActiveCountryId : '') }}">+ New Keyword</a>
            </li>
        </ul>
        @endif
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <div class="form-group col-sm-3">
                <label>Link Title in Arabic <span class="red">(*)</span></label>
                <?= Form::text("title_ar", $menu->title_ar, ["class" => "form-control", "required" => true]); ?>
            </div>
            <div class="form-group col-sm-3">
                <label>Link Title in English</label>
                <?= Form::text("title_en", $menu->title_en, ["class" => "form-control ltr"]); ?>
            </div>
            <div class="form-group col-sm-3">
                <label>Link Title in French</label>
                <?= Form::text("title_fr", $menu->title_fr, ["class" => "form-control ltr"]); ?>
            </div>
            <div class="form-group col-sm-3">
                <label>Link Title in Persian</label>
                <?= Form::text("title_fa", $menu->title_fa, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-sm-3">
                <label>Link Title in Russian</label>
                <?= Form::text("title_ru", $menu->title_ru, ["class" => "form-control ltr"]); ?>
            </div>
            <div class="form-group col-sm-4">
                <label>Lang</label>
                <?= Form::select("lang", Helper::langs("all"), $menu->lang, ["class" => "form-control select2me"]); ?>
            </div>
            <div class="form-group col-sm-4">
                <label>Country</label>
                <?php
                    $footerCountries = isset($footerCountries) ? $footerCountries : \App\Models\Country::ordered()->get();
                    $selectedFooterCountryId = $menu->country_id;
                    if (!$menu->id && $isFooterLinksPage && $footerActiveCountryId !== null) {
                        $selectedFooterCountryId = $footerActiveCountryId;
                    }
                    if (!$selectedFooterCountryId) {
                        $turkeyCountry = \App\Models\Country::findBySlugOrCode('turkey');
                        $selectedFooterCountryId = $turkeyCountry ? $turkeyCountry->id : null;
                    }
                ?>
                <select name="country_id" class="form-control select2me">
                    @foreach($footerCountries as $footerCountry)
                    <option value="<?= $footerCountry->id; ?>" <?= ((int)$selectedFooterCountryId === (int)$footerCountry->id) ? 'selected' : ''; ?>><?= $footerCountry->name_en; ?></option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label>Link Type<span class="red">(*)</span></label>
                <?= Form::select("link_type", [
                    "" => "",
                    "city" => "City",
                    "post" => "Post",
                    "category" => "Features",
                    "region" => "Districts",
                    "url" => "Custom link",
                    "parent" => "Top menu",
                ], $menu->link_type, ["class" => "form-control select2me", "required" => true]); ?>
            </div>
            <div id="sect_options">
                <?php
                    $datas = $menu->attributesToArray();
                    $datas["route_name"] = Route::currentRouteName();
                ?>
                <?= Helper::ajax_selectLinksMenu($datas); ?>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-4">
                <label>Placement</label>
                <?= Form::text("placement", $menu->placement, ["class" => "form-control"]); ?>
            </div>
            @if($datas["route_name"] == "admin.apparence.footer")
            <div class="col-sm-4">
                <label>Section</label>
                <?= Form::select("footer_section", ["useful" => "Useful links", "quick" => "Quick links"], $menu->footer_section, ["class" => "form-control select2me"]); ?>
            </div>
            @endif
        </div>
    </div>
    <div class="panel-footer">
        <button type="submit" class="btn btn-primary" style="display: inline;">Save</button>
        @if($footerCanDeleteUsefulLink)
        <div style="margin-bottom:20px;display: inline;margin-left: 5px">
        <?= Form::open(["method" => "DELETE", "url" => route($footerLinksRoute.".delete", $menu->id), "class" => "inline"]); ?>
            <button type="submit" class="btn btn-danger btn-sm button_confirm" title="Delete this useful link"><i class="fa fa-trash"></i> Delete this keyword</button>
        <?= Form::close(); ?>
        </div>
        @endif
    </div>
</div>
<?= Form::close(); ?>


<?php if (!isset($menu_new)) { ?>
<?php
    $footerCountries = isset($footerCountries) ? $footerCountries : \App\Models\Country::ordered()->get();
?>
<?= Form::open(); ?>
<div class="panel with-nav-tabs panel-default">
    <div class="panel-heading">
        <div style="margin-bottom:10px;">Projects</div>
        <ul class="nav nav-tabs">
            <?php $footerTabIndex = 0; ?>
            @foreach($footerCountries as $footerCountry)
            <li class="<?= $footerTabIndex === 0 ? 'active' : ''; ?>">
                <a href="#footer-projects-<?= $footerCountry->id; ?>" data-toggle="tab"><?= $footerCountry->name_en; ?></a>
            </li>
            <?php $footerTabIndex++; ?>
            @endforeach
        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            <?php $footerTabIndex = 0; ?>
            @foreach($footerCountries as $footerCountry)
            <?php
                $countryCityIds = \App\Models\City::where('country_id', $footerCountry->id)->lists('id');
                $countryCityIds = is_array($countryCityIds) ? $countryCityIds : $countryCityIds->toArray();
                if (empty($countryCityIds)) {
                    $countryCityIds = array(0);
                }
                $selectedProjectIds = \App\Models\Fotterproject::projectIdsForCountry($footerCountry);
            ?>
            <div class="tab-pane fade <?= $footerTabIndex === 0 ? 'in active' : ''; ?>" id="footer-projects-<?= $footerCountry->id; ?>">
                <div class="form-group">
                    <label><?= $footerCountry->name_en; ?> Projects</label>
                    <select name="projects_id[<?= $footerCountry->id; ?>][]" class="form-control select2me" style="width:100%;" multiple>
                        <option value=""></option>
                        @foreach(\App\Models\Project::whereIn('city_id', $countryCityIds)->get() as $project)
                        <option value="<?= $project->id; ?>" <?= in_array($project->id, $selectedProjectIds) ? 'selected' : ''; ?>><?= $project->name_ar; ?></option>
                        @endforeach
                    </select>
                </div>
            </div>
            <?php $footerTabIndex++; ?>
            @endforeach
        </div>
    </div>
    <div class="panel-footer">
        <button type="submit" class="btn btn-primary" name="save_projs">Save</button>
    </div>
</div>
<?= Form::close(); ?>
<?php } ?>

<style>
.panel-body ul:first-child{padding:0;}
.list-group-item{padding:5px;}
.footer-country-tabs,.footer-useful-link-tabs{display:flex;flex-wrap:wrap;}
.footer-country-tabs>li{float:none;}
.footer-country-tabs>li>a{font-weight:600;}
.footer-useful-link-tabs{margin-top:14px;padding-top:10px;border-top:1px solid #ddd;}
.footer-useful-link-tabs>li{float:none;}
.footer-useful-link-tabs>li>a{white-space:normal;}
</style>
<script>
$(function(){
    $(document).on("change", "select[name=link_type]", function(){
        var vl = $(this).val();
        var inputs = {};
        inputs['link_type'] = vl;
        inputs['lang'] = $("select[name=lang]").val();
        inputs['route_name'] = '<?= Route::currentRouteName(); ?>';
        $("#ajaxloading").show();
        $.ajax({
            type: 'POST',
            url: '<?= route('admin.ajaxqueries'); ?>',
            data: {
                _token: '<?= csrf_token(); ?>',
                func: 'selectLinksMenu',
                inputs: inputs,
            }
        }).done(function(resp){
            $.getScript("<?= asset("admin/js/admin.js"); ?>");
            $("#sect_options").html(resp);
            $('#ajaxloading').hide();
        }).fail(function(xhr, status, error){
            alert('error: ' + error);
            $('#ajaxloading').hide();
        });
    });
});
</script>
