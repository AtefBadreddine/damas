<?= Form::open(); ?>
<div class="panel panel-default">
    <div class="panel-heading">Links</div>
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
                <label>Show on</label>
                <?php
                    $footerCountries = \App\Models\Country::ordered()->get();
                    $selectedFooterCountryId = $menu->country_id;
                ?>
                <select name="country_id" class="form-control select2me">
                    <option value="" <?= !$selectedFooterCountryId ? 'selected' : '' ?>>Global</option>
                    @foreach($footerCountries as $footerCountry)
                    <option value="<?= $footerCountry->id ?>" <?= ((int)$selectedFooterCountryId === (int)$footerCountry->id) ? 'selected' : '' ?>><?= $footerCountry->name_en ?></option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label>Link Type<span class="red">(*)</span></label>
                <?= Form::select("link_type", [
                    ""    =>  "",
                    "city"    =>  "City",
                    "post"    =>  "Post",
                    "category"    =>  "Features",
                    "region"    =>  "Districts",
                    "url"    =>  "Custom link",
                    "parent"    =>  "Top menu",
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
                    <?= Form::select("footer_section", [
					/*"links" => "القسم العلوي",*/
					"useful" => "Useful links",
					"quick" => "Quick links"], $menu->footer_section, ["class" => "form-control select2me"]); ?>
                </div>
            @endif
            
        </div>
    </div>                    
    <div class="panel-footer">
        <button class="btn btn-primary">Save</button>
    </div>
</div>
<?= Form::close(); ?>



<?php if(!isset($menu_new)){ ?>
<?= Form::open(); ?>
<div class="panel panel-default">
    <div class="panel-heading">Projects</div>
    <div class="panel-body">
        <div class="col-md-12">
        <?php
            $footerCountries = isset($footerCountries) ? $footerCountries : \App\Models\Country::ordered()->get();
            $selectedHomeProjectIds = \App\Models\Fotterproject::projectIdsForCountry(null);
        ?>
        <div class="form-group">
		<label>Global Projects</label>
			<select name="projects_id[home][]" class="form-control select2me" multiple>
				<option value=""></option>
				@foreach(\App\Models\Project::orderBy('id', 'desc')->get() as $project)
				<option value="<?= $project->id; ?>" <?= in_array($project->id, $selectedHomeProjectIds) ? 'selected' : ''; ?>><?= $project->name_ar; ?></option>
				@endforeach
			</select>
		</div>
        @foreach($footerCountries as $footerCountry)
        <div class="form-group">
            <?php
                $countryCityIds = \App\Models\City::where('country_id', $footerCountry->id)->lists('id');
                $countryCityIds = is_array($countryCityIds) ? $countryCityIds : $countryCityIds->toArray();
                if (empty($countryCityIds)) {
                    $countryCityIds = array(0);
                }
                $selectedProjectIds = \App\Models\Fotterproject::projectIdsForCountry($footerCountry);
            ?>
		<label><?= $footerCountry->name_en ?> Projects</label>
			<select name="projects_id[<?= $footerCountry->id ?>][]" class="form-control select2me" multiple>
				<option value=""></option>
				@foreach(\App\Models\Project::whereIn('city_id', $countryCityIds)->get() as $project)
				<option value="<?= $project->id; ?>" <?= in_array($project->id, $selectedProjectIds) ? 'selected' : ''; ?>><?= $project->name_ar; ?></option>
				@endforeach
			</select>
		</div>
        @endforeach
        </div>
    </div>                    
    <div class="panel-footer">
        <button class="btn btn-primary" name="save_projs">Save</button>
    </div>
</div>
<?= Form::close(); ?>
<?php } ?>



<style>.panel-body ul:first-child {padding:0;}.list-group-item{padding:5px;}</style>
   
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