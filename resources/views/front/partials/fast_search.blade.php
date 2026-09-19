<?php
if(!isset($proj_cats))
$proj_cats = Helper::query('ProjectCategory', "where", ["field" => "hide_search_page", "value" => false])->get();

if(!isset($citys))
$citys = App\Models\City::where('id','!=',2)->orderBy('placement','asc')->get();
//Helper::query("City", "where", ["field" => "hide_search_page", "value" => false]);

?>
<?= Form::open(["id" => "form-search"]); ?>

<div class="form-group one">
    <select class="selectpicker form-control" name="city">
        <option value="">المدينة</option>
		@foreach($citys as $city)
			<option value="<?= $city->slug; ?>" data-city="<?= $city->id; ?>"><?= $city->getName(); ?></option>
		@endforeach
    </select>
</div>

<div class="form-group two">
    <select class="selectpicker form-control" name="project_type">
		<option value=""><?= trans("front.all real estate"); ?></option>
		@foreach($all_project_types as $typ)
		<option value="<?= $typ->slug; ?>"><?= $typ->getName(); ?></option>
		@endforeach
    </select>
</div>

<div class="form-group three">
    <select class="selectpicker form-control pattern" name="rooms">
		<option value="" selected><?= trans("front.rooms"); ?></option>
		<?php
		$arr_rooms = [
			"1_0" => "1 + 0", "1_1" => "1 + 1", "1_2" => "1 + 2", "1_3" => "1 + 3", "1_4" => "1 + 4", "1_5" => "1 + 5", "2_3" => "2 + 3", "2_4" => "2 + 4", "2_5" => "2 + 5", "2_6" => "2 + 6"
		];
		foreach ($arr_rooms as $kr => $i):
			?>
			<option value="<?= $kr; ?>" <?= @$inputs["rooms"] == $kr ? 'selected' : ''; ?>><?= $i; ?></option>
		<?php endforeach; ?>
    </select>
</div>

<div class="form-group four">
    <div class="budget">
        <div class="dropdown">
            <button class="form-control dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= trans("front.budget"); ?> 
            </button>
            <div id="budgetMenu" class="dropdown-menu shadow_type" aria-labelledby="dropdownMenuButton">
                <div class="range-slider">
                    <span class="rangeValues num"></span>
                    <input value="50000" class="min_budj" min="50000" max="2000000" step="50000" type="range">
                    <input value="100000" class="max_budj" min="50000" max="2000000" step="50000" type="range">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group btn_sec">
    <button type="submit" class="send_btn send_btn_fast"> ابحث عن عقارك</button>
</div>

<?= Form::close(); ?>