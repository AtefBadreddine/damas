<?php
$allCountriesByCode = array();
foreach (\App\Models\Country::ordered()->get() as $hc) {
    $allCountriesByCode[$hc->code] = $hc;
}
$homeCountries = \App\Models\Country::ordered()->visibleInFilters()->get();
$homeCountryByCode = array();
$homeCountryUrls = array();
$visibleCountryIds = array();
foreach ($homeCountries as $hc) {
    $homeCountryByCode[$hc->code] = $hc;
    $homeCountryUrls[$hc->id] = $hc->listingUrl();
    $visibleCountryIds[(int) $hc->id] = true;
}
// Cities whose slug is a country code ("turkey") are "all cities" rows; the country select replaces them.
$homeCities = array();
$homeCityCountry = array();
foreach ($citys as $hcity) {
    if (isset($allCountriesByCode[$hcity->slug])) {
        continue;
    }
    $hcCountryId = $hcity->country_id;
    if (!$hcCountryId || !isset($visibleCountryIds[$hcCountryId]) || !$hcity->listingUrl()) {
        continue;
    }
    $homeCityCountry[$hcity->id] = (int) $hcCountryId;
    $homeCities[] = array('id' => (int) $hcity->id, 'slug' => $hcity->slug, 'name' => $hcity->getName(), 'country' => (int) $hcCountryId, 'url' => $hcity->listingUrl());
}

?>
<?= Form::open(["id" => "form-search"]); ?>

<div class="form-group country_group">
    <svg version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 24.33 23.69" xml:space="preserve"><g> <path class="st0" d="M12.14,13.49c-1.08-1.21-2.16-2.38-3.19-3.58C8.46,9.33,7.98,8.71,7.6,8.04c-1.66-2.92-0.39-6.51,2.68-7.69 c3.15-1.21,6.62,0.84,7.11,4.18c0.15,1.06-0.05,2.04-0.53,2.98c-0.42,0.82-0.96,1.55-1.55,2.25c-0.98,1.17-1.97,2.34-2.96,3.51 C12.3,13.33,12.24,13.39,12.14,13.49z M12.17,2.78C10.72,2.79,9.54,3.97,9.55,5.4c0.01,1.44,1.19,2.61,2.63,2.61 c1.42,0,2.59-1.19,2.59-2.62C14.77,3.96,13.58,2.78,12.17,2.78z"></path> <path class="st0" d="M7.47,9.32c-0.97,0-1.88,0-2.84,0c0.07,0.1,0.1,0.16,0.14,0.21c2.33,2.9,4.66,5.8,6.99,8.71 c0.16,0.19,0.27,0.23,0.5,0.13c1.86-0.75,3.72-1.49,5.58-2.23c0.08-0.03,0.15-0.07,0.25-0.11c-1.35-1.2-2.68-2.38-4.03-3.58 c0.1-0.12,0.19-0.23,0.29-0.36c1.4,1.24,2.79,2.48,4.18,3.72c1.5-1.16,2.99-2.32,4.52-3.5c-2.11-1.07-4.19-2.13-6.28-3.2 c0.16-0.26,0.31-0.49,0.47-0.75c0.17,0.09,0.35,0.17,0.52,0.26c2.06,1.05,4.11,2.09,6.17,3.14c0.5,0.26,0.53,0.58,0.08,0.93 c-1.66,1.29-3.32,2.58-4.99,3.86c-0.12,0.09-0.26,0.17-0.4,0.23c-1.99,0.8-3.98,1.58-5.96,2.39c-0.17,0.07-0.34,0.2-0.46,0.34 c-1.06,1.29-2.11,2.58-3.17,3.88c-0.35,0.42-0.62,0.41-0.93-0.04c-2.66-3.91-5.31-7.81-7.97-11.72c-0.22-0.33-0.18-0.54,0.15-0.77 c1.1-0.76,2.21-1.51,3.32-2.26c0.12-0.08,0.28-0.13,0.43-0.14c0.9-0.03,1.79-0.03,2.69-0.06c0.15,0,0.24,0.05,0.31,0.18 C7.15,8.8,7.29,9.02,7.47,9.32z M11.62,18.8c-2.53-3.15-5.05-6.29-7.58-9.44c-1,0.68-1.98,1.35-2.98,2.04 c2.52,3.71,5.02,7.39,7.55,11.1C9.63,21.25,10.62,20.03,11.62,18.8z"></path> </g> </svg>
    <select class="selectpicker form-control" name="country" title="<?= trans("front.country"); ?>">
        <option value="" selected><?= trans("front.country"); ?></option>
        @foreach($homeCountries as $hc)
        <option value="<?= $hc->id; ?>"><?= $hc->getTitle(); ?></option>
        @endforeach
    </select>
</div>

<div class="form-group city_group">
    <svg version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 24.33 23.69" xml:space="preserve"><g> <path class="st0" d="M12.14,13.49c-1.08-1.21-2.16-2.38-3.19-3.58C8.46,9.33,7.98,8.71,7.6,8.04c-1.66-2.92-0.39-6.51,2.68-7.69 c3.15-1.21,6.62,0.84,7.11,4.18c0.15,1.06-0.05,2.04-0.53,2.98c-0.42,0.82-0.96,1.55-1.55,2.25c-0.98,1.17-1.97,2.34-2.96,3.51 C12.3,13.33,12.24,13.39,12.14,13.49z M12.17,2.78C10.72,2.79,9.54,3.97,9.55,5.4c0.01,1.44,1.19,2.61,2.63,2.61 c1.42,0,2.59-1.19,2.59-2.62C14.77,3.96,13.58,2.78,12.17,2.78z"></path> <path class="st0" d="M7.47,9.32c-0.97,0-1.88,0-2.84,0c0.07,0.1,0.1,0.16,0.14,0.21c2.33,2.9,4.66,5.8,6.99,8.71 c0.16,0.19,0.27,0.23,0.5,0.13c1.86-0.75,3.72-1.49,5.58-2.23c0.08-0.03,0.15-0.07,0.25-0.11c-1.35-1.2-2.68-2.38-4.03-3.58 c0.1-0.12,0.19-0.23,0.29-0.36c1.4,1.24,2.79,2.48,4.18,3.72c1.5-1.16,2.99-2.32,4.52-3.5c-2.11-1.07-4.19-2.13-6.28-3.2 c0.16-0.26,0.31-0.49,0.47-0.75c0.17,0.09,0.35,0.17,0.52,0.26c2.06,1.05,4.11,2.09,6.17,3.14c0.5,0.26,0.53,0.58,0.08,0.93 c-1.66,1.29-3.32,2.58-4.99,3.86c-0.12,0.09-0.26,0.17-0.4,0.23c-1.99,0.8-3.98,1.58-5.96,2.39c-0.17,0.07-0.34,0.2-0.46,0.34 c-1.06,1.29-2.11,2.58-3.17,3.88c-0.35,0.42-0.62,0.41-0.93-0.04c-2.66-3.91-5.31-7.81-7.97-11.72c-0.22-0.33-0.18-0.54,0.15-0.77 c1.1-0.76,2.21-1.51,3.32-2.26c0.12-0.08,0.28-0.13,0.43-0.14c0.9-0.03,1.79-0.03,2.69-0.06c0.15,0,0.24,0.05,0.31,0.18 C7.15,8.8,7.29,9.02,7.47,9.32z M11.62,18.8c-2.53-3.15-5.05-6.29-7.58-9.44c-1,0.68-1.98,1.35-2.98,2.04 c2.52,3.71,5.02,7.39,7.55,11.1C9.63,21.25,10.62,20.03,11.62,18.8z"></path> </g> </svg>
    <select class="selectpicker form-control" name="city" title="<?= trans("front.city"); ?>">
        <option value="" selected><?= trans("front.city"); ?></option>
    </select>
</div>
<div class="form-group">
    <svg version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 23.41 24.56" xml:space="preserve"><g> <path class="st0" d="M4.35,4.91l6.19,1.88l0.31-1.02L4.22,3.76l-2.95,1.7l0.53,0.92L4.35,4.91z M4.35,4.91"></path> <path class="st0" d="M4.35,6.79l6.19,1.88l0.31-1.02L4.22,5.63l-2.95,1.7l0.53,0.92L4.35,6.79z M4.35,6.79"></path> <path class="st0" d="M4.35,8.66l6.19,1.88l0.31-1.02L4.22,7.51l-2.95,1.7l0.53,0.92L4.35,8.66z M4.35,8.66"></path> <path class="st0" d="M4.35,10.54l6.19,1.88l0.31-1.02L4.22,9.39l-2.95,1.7l0.53,0.92L4.35,10.54z M4.35,10.54"></path> <path class="st0" d="M4.35,12.42l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L4.35,12.42z M4.35,12.42"></path> <path class="st0" d="M4.35,14.3l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L4.35,14.3z M4.35,14.3"></path> <path class="st0" d="M4.35,16.18l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L4.35,16.18z M4.35,16.18"></path> <path class="st0" d="M4.35,18.05l6.19,1.88l0.31-1.02L4.22,16.9l-2.95,1.7l0.53,0.92L4.35,18.05z M4.35,18.05"></path> <path class="st0" d="M14.47,4.91l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L14.47,4.91z M14.47,4.91"></path> <path class="st0" d="M14.47,3.03l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L14.47,3.03z M14.47,3.03"></path> <path class="st0" d="M14.47,1.15l6.19,1.88l0.31-1.02L14.34,0l-2.95,1.7l0.53,0.92L14.47,1.15z M14.47,1.15"></path> <path class="st0" d="M14.47,6.79l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L14.47,6.79z M14.47,6.79"></path> <path class="st0" d="M14.47,8.66l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L14.47,8.66z M14.47,8.66"></path> <path class="st0" d="M14.47,10.54l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L14.47,10.54z M14.47,10.54"></path> <path class="st0" d="M14.47,12.42l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L14.47,12.42z M14.47,12.42"></path> <path class="st0" d="M14.47,14.3l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L14.47,14.3z M14.47,14.3"></path> <path class="st0" d="M14.47,16.18l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L14.47,16.18z M14.47,16.18"></path> <path class="st0" d="M14.47,18.05l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L14.47,18.05z M14.47,18.05"></path> <path class="st0" d="M20.67,23.55v-1.77l0.3-0.98l-6.63-2.01l-2.95,1.7l0.3,0.52v2.55h-1.13v-1.77l0.3-0.98l-6.63-2.01l-2.95,1.7 L1.57,21v2.55H0v1.02h23.41v-1.02H20.67z M5.75,23.55v-2.16L9,22.16v1.38H5.75z M15.87,23.55v-2.16l3.25,0.78v1.38H15.87z M15.87,23.55"></path> </g> </svg>
    <select class="selectpicker form-control" name="project_type">
        <option value=""><?= trans("front.all real estate"); ?></option>
        @foreach($all_project_types as $typ)
        <option value="<?= $typ->slug; ?>"><?= $typ->getName(); ?></option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <svg version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 21.72 18.82" xml:space="preserve"><g> <path class="st0" d="M21.35,10.86h-0.36V9.77c0-0.72-0.43-1.37-1.09-1.66V2.53c0-0.14-0.09-0.27-0.22-0.33 c0.14-0.23,0.22-0.49,0.22-0.75c0-0.8-0.65-1.45-1.45-1.45c-0.8,0-1.45,0.65-1.45,1.45c0,0.25,0.07,0.5,0.2,0.72H4.5 C4.63,1.95,4.7,1.7,4.7,1.45C4.7,0.65,4.06,0,3.26,0S1.81,0.65,1.81,1.45c0,0.27,0.08,0.53,0.22,0.75 C1.89,2.26,1.81,2.39,1.81,2.53v5.58C1.15,8.4,0.72,9.05,0.72,9.77v1.09H0.36c-0.2,0-0.36,0.16-0.36,0.36v5.07 c0,0.2,0.16,0.36,0.36,0.36h0.36v1.81c0,0.2,0.16,0.36,0.36,0.36h1.45c0.2,0,0.36-0.16,0.36-0.36v-1.81h15.92v1.81 c0,0.2,0.16,0.36,0.36,0.36h1.45c0.2,0,0.36-0.16,0.36-0.36v-1.81h0.36c0.2,0,0.36-0.16,0.36-0.36v-5.07 C21.72,11.02,21.55,10.86,21.35,10.86z M2.53,2.9h16.65v5.07h-1.46c0.24-0.31,0.37-0.69,0.37-1.09V6.15c0-1-0.81-1.81-1.81-1.81 h-2.9c-1,0-1.81,0.81-1.81,1.81v0.72c0,0.39,0.13,0.77,0.37,1.09H9.76c0.24-0.31,0.37-0.69,0.37-1.09V6.15c0-1-0.81-1.81-1.81-1.81 h-2.9c-1,0-1.81,0.81-1.81,1.81v0.72c0,0.39,0.13,0.77,0.37,1.09H2.53V2.9z M1.45,9.77c0-0.6,0.49-1.09,1.09-1.09h16.65 c0.6,0,1.09,0.49,1.09,1.09v1.09H1.45V9.77z M20.99,15.92H0.72v-4.34h20.27V15.92z"></path> </g> </svg>
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

<div class="form-group budget_group">
    <div class="budget">
        <div id="budgetMenu">
            <div class="range-slider"> <span class="rangeValues num"></span>
                <input value="50000" class="min_budj" min="50000" max="2000000" step="50000" type="range">
                    <input value="2000000" class="max_budj" min="50000" max="2000000" step="50000" type="range">
                        </div>
                        </div>
                        </div>
                        </div>

                        <div class="form-group btn_sec">
                            <button type="submit" class="send_btn send_btn_index"> 
                                <?= trans("front.Discover"); ?>
                                <svg version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 26.15 22.4" xml:space="preserve"><path class="st0" d="M24.72,20.5l-6.2-6c1.2-1.5,1.9-3.4,1.9-5.5c0-4.9-4.1-9-9.2-9s-9.2,4-9.2,9c0,4.9,4.1,9,9.2,9 c2.1,0,4.1-0.7,5.6-1.9l6.2,6c0.2,0.2,0.5,0.3,0.8,0.3s0.6-0.1,0.8-0.3C25.22,21.6,25.22,20.9,24.72,20.5z M4.42,8.9 c0-3.7,3.1-6.7,6.9-6.7s6.9,3,6.9,6.7c0,1.8-0.8,3.5-2,4.7l0,0l0,0c-1.2,1.2-3,2-4.8,2C7.52,15.7,4.42,12.7,4.42,8.9z"/> </svg>
                            </button>
                        </div>

                        <?= Form::close(); ?>

<script>
window.homeFilterData = {
    cities: <?= json_encode($homeCities, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>,
    countryUrls: <?= json_encode($homeCountryUrls, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?>,
    cityLabel: <?= json_encode(trans("front.city"), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>,
    projectsUrl: <?= json_encode(route('front.projects'), JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?>
};
</script>