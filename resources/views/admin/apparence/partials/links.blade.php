<?php
    $footerLinksRoute = Route::currentRouteName();
    $isFooterLinksPage = $footerLinksRoute === 'admin.apparence.footer';
    $footerUsefulLinks = array();
    $footerUsefulCountryGroups = array();
    $footerActiveCountryId = null;
    $footerHasCurrentUsefulLink = false;
    $footerGlobalGroupKey = 'global';
    if ($isFooterLinksPage) {
        $footerCountries = \App\Models\Country::ordered()->get();
        $footerUsefulLinks = Helper::query("FooterLink", "orderByPlacement")
            ->where("footer_section", "useful")->toArray();
        $footerLinksByCountry = array();
        foreach ($footerUsefulLinks as $footerUsefulLink) {
            $footerLinkCountryId = !empty($footerUsefulLink['country_id'])
                ? (int)$footerUsefulLink['country_id'] : $footerGlobalGroupKey;
            if (!isset($footerLinksByCountry[$footerLinkCountryId])) {
                $footerLinksByCountry[$footerLinkCountryId] = array();
            }
            $footerLinksByCountry[$footerLinkCountryId][] = $footerUsefulLink;
            if ((int)$footerUsefulLink['id'] === (int)$menu->id) {
                $footerHasCurrentUsefulLink = true;
                $footerActiveCountryId = $footerLinkCountryId;
            }
        }
        $footerUsefulCountryGroups[$footerGlobalGroupKey] = array(
            'country' => (object) array('id' => null, 'name_en' => 'Global'),
            'links' => isset($footerLinksByCountry[$footerGlobalGroupKey]) ? $footerLinksByCountry[$footerGlobalGroupKey] : array(),
        );
        foreach ($footerCountries as $footerCountry) {
            $footerCountryId = (int)$footerCountry->id;
            $footerUsefulCountryGroups[$footerCountryId] = array(
                'country' => $footerCountry,
                'links' => isset($footerLinksByCountry[$footerCountryId]) ? $footerLinksByCountry[$footerCountryId] : array(),
            );
        }
        if (!$footerHasCurrentUsefulLink) {
            if ($menu->id) {
                $footerPreferredCountryId = $menu->country_id ? (int)$menu->country_id : $footerGlobalGroupKey;
            } else {
                $queryCountryId = \Request::query('country_id');
                if ($queryCountryId === null || $queryCountryId === '' || $queryCountryId === $footerGlobalGroupKey) {
                    $footerPreferredCountryId = $footerGlobalGroupKey;
                } else {
                    $footerPreferredCountryId = (int)$queryCountryId;
                }
            }
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
    $isQuickMenuPage = isset($is_quick_menu_page) ? $is_quick_menu_page : ($footerLinksRoute === 'admin.apparence.menus');
    $menuOwnForm = !isset($menu_own_form) || $menu_own_form;
    $titleLabelArabic = $isQuickMenuPage ? 'Title (Arabic)' : 'Link Title in Arabic';
    $titleLabelEnglish = $isQuickMenuPage ? 'Title (English)' : 'Link Title in English';
    $titleLabelFrench = $isQuickMenuPage ? 'Title (French)' : 'Link Title in French';
    $titleLabelPersian = $isQuickMenuPage ? 'Title (Persian)' : 'Link Title in Persian';
    $titleLabelRussian = $isQuickMenuPage ? 'Title (Russian)' : 'Link Title in Russian';
?>

<?php if ($menuOwnForm): ?><?= Form::open(["method" => "POST", "id" => "footer-keyword-editor"]); ?><?php endif; ?>
<div class="panel with-nav-tabs panel-default">
    <div class="panel-heading">
        @if($isFooterLinksPage)
        <div style="margin-bottom:10px;">Keywords</div>
        @endif
        @if($isFooterLinksPage)
        <ul class="nav nav-tabs footer-country-tabs">
            @foreach($footerUsefulCountryGroups as $footerCountryId => $footerCountryGroup)
            <?php
                if (!empty($footerCountryGroup['links'])) {
                    $footerTabUrl = route($footerLinksRoute, $footerCountryGroup['links'][0]['id']);
                } elseif ($footerCountryId === $footerGlobalGroupKey) {
                    $footerTabUrl = route($footerLinksRoute, 0);
                } else {
                    $footerTabUrl = route($footerLinksRoute, 0).'?country_id='.$footerCountryId;
                }
            ?>
            <li class="<?= $footerActiveCountryId === $footerCountryId ? 'active' : ''; ?>">
                <a href="{{ $footerTabUrl }}">
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
                <a href="{{ route($footerLinksRoute, 0).($footerActiveCountryId !== null && $footerActiveCountryId !== $footerGlobalGroupKey ? '?country_id='.$footerActiveCountryId : '') }}">+ New Keyword</a>
            </li>
        </ul>
        @endif
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <div class="form-group col-sm-3">
                <label><?= $titleLabelArabic; ?> <span class="red">(*)</span></label>
                <?= Form::text("title_ar", $menu->title_ar, ["class" => "form-control", "required" => true]); ?>
            </div>
            <div class="form-group col-sm-3">
                <label><?= $titleLabelEnglish; ?></label>
                <?= Form::text("title_en", $menu->title_en, ["class" => "form-control ltr"]); ?>
            </div>
            <div class="form-group col-sm-3">
                <label><?= $titleLabelFrench; ?></label>
                <?= Form::text("title_fr", $menu->title_fr, ["class" => "form-control ltr"]); ?>
            </div>
            <div class="form-group col-sm-3">
                <label><?= $titleLabelPersian; ?></label>
                <?= Form::text("title_fa", $menu->title_fa, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-sm-3">
                <label><?= $titleLabelRussian; ?></label>
                <?= Form::text("title_ru", $menu->title_ru, ["class" => "form-control ltr"]); ?>
            </div>
            <div class="form-group col-sm-4">
                <label>Lang</label>
                <?php if ($isQuickMenuPage): ?>
                    <?= Form::select("lang[]", Helper::langs("all"), Helper::parseMenuLangs($menu->lang), ["class" => "form-control menu-lang-multiselect", "multiple" => "multiple", "id" => "menu-lang-select"]); ?>
                    <p class="help-block">All = every locale. Picking a language with All selected keeps the language and drops All.</p>
                <?php else: ?>
                    <?= Form::select("lang", Helper::langs("all"), $menu->lang, ["class" => "form-control select2me"]); ?>
                <?php endif; ?>
            </div>
            @if($isFooterLinksPage)
            <div class="form-group col-sm-4">
                <label>Show on</label>
                <?php
                    $footerCountries = isset($footerCountries) ? $footerCountries : \App\Models\Country::ordered()->get();
                    $selectedFooterCountryId = $menu->country_id;
                    if (!$menu->id && $isFooterLinksPage && $footerActiveCountryId !== null && $footerActiveCountryId !== $footerGlobalGroupKey) {
                        $selectedFooterCountryId = $footerActiveCountryId;
                    }
                ?>
                <select name="country_id" class="form-control select2me">
                    <option value="" <?= !$selectedFooterCountryId ? 'selected' : '' ?>>Global</option>
                    @foreach($footerCountries as $footerCountry)
                    <option value="<?= $footerCountry->id; ?>" <?= ((int)$selectedFooterCountryId === (int)$footerCountry->id) ? 'selected' : ''; ?>><?= $footerCountry->name_en; ?></option>
                    @endforeach
                </select>
            </div>
            @endif
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
        @if($isQuickMenuPage && $menu->id)
        <a href="{{ route('admin.apparence.menus') }}" class="btn btn-default">Cancel</a>
        @endif
    </div>
</div>
<?php if ($menuOwnForm): ?><?= Form::close(); ?><?php endif; ?>

        @if($footerCanDeleteUsefulLink)
        <div style="margin-bottom:20px;">
        <?= Form::open(["method" => "DELETE", "url" => route($footerLinksRoute.".delete", $menu->id), "class" => "inline", "id" => "footer-keyword-delete"]); ?>
            <button type="submit" class="btn btn-danger btn-sm button_confirm" title="Delete this useful link"><i class="fa fa-trash"></i> Delete this keyword</button>
        <?= Form::close(); ?>
        </div>
        @endif

<?php if (!isset($menu_new)) { ?>
<?php
    $footerCountries = isset($footerCountries) ? $footerCountries : \App\Models\Country::ordered()->get();
    $selectedHomeProjectIds = \App\Models\Fotterproject::projectIdsForCountry(null);
?>
<?= Form::open(); ?>
<div class="panel with-nav-tabs panel-default">
    <div class="panel-heading">
        <div style="margin-bottom:10px;">Projects</div>
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#footer-projects-home" data-toggle="tab">Global</a>
            </li>
            @foreach($footerCountries as $footerCountry)
            <li>
                <a href="#footer-projects-<?= $footerCountry->id; ?>" data-toggle="tab"><?= $footerCountry->name_en; ?></a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane fade in active" id="footer-projects-home">
                <div class="form-group">
                    <label>Global Projects</label>
                    <select name="projects_id[home][]" class="form-control select2me" style="width:100%;" multiple>
                        <option value=""></option>
                        @foreach(\App\Models\Project::orderBy('id', 'desc')->get() as $project)
                        <option value="<?= $project->id; ?>" <?= in_array($project->id, $selectedHomeProjectIds) ? 'selected' : ''; ?>><?= $project->title_en; ?></option>
                        @endforeach
                    </select>
                </div>
            </div>
            @foreach($footerCountries as $footerCountry)
            <?php
                $countryCityIds = \App\Models\City::where('country_id', $footerCountry->id)->lists('id');
                $countryCityIds = is_array($countryCityIds) ? $countryCityIds : $countryCityIds->toArray();
                if (empty($countryCityIds)) {
                    $countryCityIds = array(0);
                }
                $selectedProjectIds = \App\Models\Fotterproject::projectIdsForCountry($footerCountry);
            ?>
            <div class="tab-pane fade" id="footer-projects-<?= $footerCountry->id; ?>">
                <div class="form-group">
                    <label><?= $footerCountry->name_en; ?> Projects</label>
                    <select name="projects_id[<?= $footerCountry->id; ?>][]" class="form-control select2me" style="width:100%;" multiple>
                        <option value=""></option>
                        @foreach(\App\Models\Project::whereIn('city_id', $countryCityIds)->get() as $project)
                        <option value="<?= $project->id; ?>" <?= in_array($project->id, $selectedProjectIds) ? 'selected' : ''; ?>><?= $project->title_en; ?></option>
                        @endforeach
                    </select>
                </div>
            </div>
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
    function menuLangValues($el) {
        var vals = $el.val() || [];
        return $.isArray(vals) ? vals.slice() : [vals];
    }
    function setMenuLangValues($el, vals) {
        $el.find("option").prop("selected", false);
        $.each(vals, function (_, val) {
            $el.find("option[value='" + val + "']").prop("selected", true);
        });
        $el.val(vals);
        if ($el.data("select2")) {
            try { $el.select2("val", vals); } catch (e) {}
        }
    }
    $(".menu-lang-multiselect").each(function () {
        var $el = $(this);
        var syncing = false;
        var previous = menuLangValues($el);
        if ($().select2 && !$el.data("select2")) {
            $el.select2({
                width: "100%",
                placeholder: "Choose languages",
                allowClear: false,
                dir: "ltr"
            });
        }
        $el.on("change", function () {
            if (syncing) return;
            var curr = menuLangValues($el);
            var specific = $.grep(curr, function (v) { return v !== "all"; });
            var hasAll = curr.indexOf("all") !== -1;
            var addedAll = hasAll && previous.indexOf("all") === -1;
            var next = curr;
            if (hasAll && specific.length) {
                next = addedAll ? ["all"] : specific;
                syncing = true;
                setMenuLangValues($el, next);
                syncing = false;
            }
            previous = next.slice();
        });
        $el.closest("form").on("submit", function () {
            $el.prop("disabled", false);
            setMenuLangValues($el, menuLangValues($el));
        });
    });
    $(document).on("change", "select[name=link_type]", function(){
        var vl = $(this).val();
        var inputs = {};
        inputs['link_type'] = vl;
        inputs['lang'] = $("select[name='lang[]']").val() || $("select[name=lang]").val();
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
