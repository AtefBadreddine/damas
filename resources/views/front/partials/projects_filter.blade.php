<?php

//$is_mobile = Helper::get_device() != 'full' ? true : false;
$is_mobile = false;

$filterCountries = \App\Models\Country::orderBy('id')->get();
$filterCountryByCode = array();
foreach ($filterCountries as $fc) {
    $filterCountryByCode[$fc->code] = $fc;
}

$filterCountry = isset($locationCountry) && $locationCountry ? $locationCountry : null;
if (!$filterCountry && !empty($inputs['city_row'])) {
    $filterCityRow = $inputs['city_row'];
    if ($filterCityRow instanceof \App\Models\Country) {
        $filterCountry = $filterCityRow;
    } elseif (isset($filterCountryByCode[$filterCityRow->slug])) {
        $filterCountry = $filterCountryByCode[$filterCityRow->slug];
    } else {
        $filterCountry = $filterCityRow->countryRel ?: (isset($filterCountryByCode[$filterCityRow->country]) ? $filterCountryByCode[$filterCityRow->country] : null);
    }
}

// Cities whose slug is a country code ("turkey") are "all cities" rows; the country select replaces them.
$filterCities = array();
foreach ($citys as $fcity) {
    if (isset($filterCountryByCode[$fcity->slug])) {
        continue;
    }
    $fcCountryId = $fcity->country_id ?: (isset($filterCountryByCode[$fcity->country]) ? $filterCountryByCode[$fcity->country]->id : null);
    if (!$fcCountryId) {
        continue;
    }
    $filterCities[] = array(
        'slug' => $fcity->slug,
        'name' => $fcity->getName(),
        'country' => (int) $fcCountryId,
        'url' => $fcity->listingUrl(),
    );
}
$filterCountryUrls = array();
foreach ($filterCountries as $fc) {
    $filterCountryUrls[$fc->id] = $fc->listingUrl();
}

?>
<p class="top_title jazzira_font_bold"><?= trans("front.advanced search"); ?>
    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 220.6 239.5" xml:space="preserve"><g> <path class="st0" d="M110.2,0.5c31.7,0,63.3,0,95,0c6.1,0,10.8,2.3,13.6,7.6c2.6,4.9,2.5,10.2-1,14.6c-1.9,2.3-4.9,3.8-7.4,5.6 c-2.5,1.7-5.6,2.8-7.5,5c-22,26.7-43.9,53.6-65.7,80.6c-1.7,2.1-2.8,5.3-2.8,8c-0.2,28.3-0.2,56.5,0,84.8c0,4.6-1.6,7.4-5.4,9.7 c-11.5,7.1-22.7,14.6-34.2,21.6c-2.2,1.4-6.1,2.2-8.1,1.1c-1.9-1-3.4-4.8-3.4-7.4c-0.2-19.7,0-39.3,0-59c0-17.6,0-35.3-0.3-52.9 c0-2-0.9-4.3-2.1-5.8C58.5,86.3,36,58.7,13.4,31.1c-1.1-1.3-2.7-2.4-4.3-3.2c-7-3.3-10.3-9.5-8.7-16.7C1.8,5,7.5,0.5,14.8,0.5 C46.6,0.4,78.4,0.5,110.2,0.5z M195.9,29.4c-58.3,0-115.7,0-173.4,0c0.3,0.8,0.4,1.1,0.6,1.3C44.4,56.8,65.6,82.9,87,108.9 c1.1,1.4,3.6,2.3,5.5,2.3c8.5,0.2,17.1-0.5,25.5,0.3c8.2,0.8,13.3-2.2,18.3-8.6C155.6,78.3,175.6,54.3,195.9,29.4z M91.1,119.2 c0,37.5,0,74.3,0,112c11.8-7.5,22.8-14.4,33.6-21.5c1.2-0.8,1.9-3,1.9-4.6c0.2-8.3,0.1-16.7,0.1-25c0.1-14.1,0.2-28.2,0.3-42.3 c0-6.1,0-12.2,0-18.6C114.6,119.2,103,119.2,91.1,119.2z M110.2,8.2c-30.7,0-61.3,0-92,0c-7.5,0-10.8,2.1-10.6,6.7 c0.1,4.4,3.4,6.4,10.6,6.4c61.3,0,122.6,0,183.9,0c2,0,4.5,0.4,5.8-0.6c2-1.5,4.6-4.3,4.4-6.2c-0.3-2.3-3.1-4.4-5.3-6.1 c-0.9-0.7-2.9-0.2-4.4-0.2C171.9,8.2,141.1,8.2,110.2,8.2z"/> </g> </svg>
</p>


<span class="cleared_filter"><a href="<?= isset($locationAreaUrl) ? $locationAreaUrl : route("front.search", ["property-for-sale", "turkey"]) ?>"><?= trans("front.cleared"); ?></a></span>


<?= Form::open(isset($filterFormUrl) ? ["id" => "form-search", "url" => $filterFormUrl, "method" => "GET"] : ["id" => "form-search"]); ?>

<div class="loader_sec"></div>

<div class="form-group">
    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24.33 23.69" xml:space="preserve"><g> <path class="st0" d="M12.14,13.49c-1.08-1.21-2.16-2.38-3.19-3.58C8.46,9.33,7.98,8.71,7.6,8.04c-1.66-2.92-0.39-6.51,2.68-7.69 c3.15-1.21,6.62,0.84,7.11,4.18c0.15,1.06-0.05,2.04-0.53,2.98c-0.42,0.82-0.96,1.55-1.55,2.25c-0.98,1.17-1.97,2.34-2.96,3.51 C12.3,13.33,12.24,13.39,12.14,13.49z M12.17,2.78C10.72,2.79,9.54,3.97,9.55,5.4c0.01,1.44,1.19,2.61,2.63,2.61 c1.42,0,2.59-1.19,2.59-2.62C14.77,3.96,13.58,2.78,12.17,2.78z"></path> <path class="st0" d="M7.47,9.32c-0.97,0-1.88,0-2.84,0c0.07,0.1,0.1,0.16,0.14,0.21c2.33,2.9,4.66,5.8,6.99,8.71 c0.16,0.19,0.27,0.23,0.5,0.13c1.86-0.75,3.72-1.49,5.58-2.23c0.08-0.03,0.15-0.07,0.25-0.11c-1.35-1.2-2.68-2.38-4.03-3.58 c0.1-0.12,0.19-0.23,0.29-0.36c1.4,1.24,2.79,2.48,4.18,3.72c1.5-1.16,2.99-2.32,4.52-3.5c-2.11-1.07-4.19-2.13-6.28-3.2 c0.16-0.26,0.31-0.49,0.47-0.75c0.17,0.09,0.35,0.17,0.52,0.26c2.06,1.05,4.11,2.09,6.17,3.14c0.5,0.26,0.53,0.58,0.08,0.93 c-1.66,1.29-3.32,2.58-4.99,3.86c-0.12,0.09-0.26,0.17-0.4,0.23c-1.99,0.8-3.98,1.58-5.96,2.39c-0.17,0.07-0.34,0.2-0.46,0.34 c-1.06,1.29-2.11,2.58-3.17,3.88c-0.35,0.42-0.62,0.41-0.93-0.04c-2.66-3.91-5.31-7.81-7.97-11.72c-0.22-0.33-0.18-0.54,0.15-0.77 c1.1-0.76,2.21-1.51,3.32-2.26c0.12-0.08,0.28-0.13,0.43-0.14c0.9-0.03,1.79-0.03,2.69-0.06c0.15,0,0.24,0.05,0.31,0.18 C7.15,8.8,7.29,9.02,7.47,9.32z M11.62,18.8c-2.53-3.15-5.05-6.29-7.58-9.44c-1,0.68-1.98,1.35-2.98,2.04 c2.52,3.71,5.02,7.39,7.55,11.1C9.63,21.25,10.62,20.03,11.62,18.8z"></path> </g> </svg>

    <select name="country" id="filter_country" class="<?= $is_mobile?'':'selectpicker' ?> form-control" title="<?= trans("front.country"); ?>">
        <option value=""><?= trans("front.country"); ?></option>
        @foreach($filterCountries as $fc)
        <option value="<?= $fc->id ?>" <?= $filterCountry && $filterCountry->id == $fc->id ? 'selected' : ''; ?>><?= $fc->getTitle(); ?></option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24.33 23.69" xml:space="preserve"><g> <path class="st0" d="M12.14,13.49c-1.08-1.21-2.16-2.38-3.19-3.58C8.46,9.33,7.98,8.71,7.6,8.04c-1.66-2.92-0.39-6.51,2.68-7.69 c3.15-1.21,6.62,0.84,7.11,4.18c0.15,1.06-0.05,2.04-0.53,2.98c-0.42,0.82-0.96,1.55-1.55,2.25c-0.98,1.17-1.970,2.34-2.96,3.51 C12.3,13.33,12.24,13.39,12.14,13.49z M12.17,2.78C10.72,2.79,9.54,3.97,9.55,5.4c0.01,1.44,1.19,2.61,2.63,2.61 c1.42,0,2.59-1.19,2.59-2.62C14.77,3.96,13.58,2.78,12.17,2.78z"></path> <path class="st0" d="M7.47,9.32c-0.97,0-1.88,0-2.84,0c0.07,0.1,0.1,0.16,0.14,0.21c2.33,2.9,4.66,5.8,6.99,8.71 c0.16,0.19,0.27,0.23,0.5,0.13c1.86-0.75,3.72-1.49,5.58-2.23c0.08-0.03,0.15-0.07,0.25-0.11c-1.35-1.2-2.68-2.38-4.03-3.58 c0.1-0.12,0.19-0.23,0.29-0.36c1.4,1.24,2.79,2.48,4.18,3.72c1.5-1.16,2.99-2.32,4.52-3.5c-2.11-1.07-4.19-2.13-6.28-3.2 c0.16-0.26,0.31-0.49,0.47-0.75c0.17,0.09,0.35,0.17,0.52,0.26c2.060,1.05,4.11,2.09,6.17,3.14c0.5,0.26,0.53,0.58,0.08,0.93 c-1.66,1.29-3.32,2.58-4.99,3.86c-0.12,0.09-0.26,0.17-0.4,0.23c-1.99,0.8-3.98,1.58-5.96,2.39c-0.17,0.07-0.34,0.2-0.46,0.34 c-1.06,1.29-2.11,2.58-3.17,3.88c-0.35,0.42-0.62,0.41-0.93-0.04c-2.66-3.91-5.31-7.81-7.97-11.72c-0.22-0.33-0.18-0.54,0.15-0.77 c1.1-0.76,2.21-1.51,3.32-2.26c0.12-0.08,0.28-0.13,0.43-0.14c0.9-0.03,1.79-0.03,2.69-0.06c0.15,0,0.24,0.05,0.31,0.18 C7.15,8.8,7.29,9.02,7.47,9.32z M11.62,18.8c-2.53-3.15-5.05-6.29-7.58-9.44c-1,0.68-1.98,1.35-2.98,2.04 c2.52,3.71,5.02,7.39,7.55,11.1C9.63,21.25,10.62,20.03,11.62,18.8z"></path> </g> </svg>

    <select name="city" class="<?= $is_mobile?'':'selectpicker' ?> form-control input_seacrh" title="<?= trans("front.city"); ?>">
        <option value=""><?= trans("front.city"); ?></option>   <!---->
        @foreach($filterCities as $fcity)
        @if(!$filterCountry || $fcity['country'] == $filterCountry->id)
        <option value="<?= $fcity['slug']; ?>" <?= @$inputs["city"] == $fcity['slug'] ? 'selected' : ''; ?>><?= $fcity['name']; ?></option>
        @endif
        @endforeach
    </select>
</div>

<div class="form-group">
    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 46.18 61.05" xml:space="preserve"><g> <path class="st0" d="M23.09,0C10.36,0,0,10.36,0,23.09c0,5.25,3.62,12.93,10.76,22.83C15.92,53.07,21,58.72,21.21,58.96l1.88,2.08 l1.88-2.08c0.21-0.24,5.29-5.89,10.45-13.04c7.14-9.89,10.76-17.58,10.76-22.83C46.18,10.36,35.82,0,23.09,0L23.09,0z M23.09,53.43 C16.73,46,5.06,30.76,5.06,23.09c0-9.94,8.09-18.03,18.03-18.03s18.03,8.09,18.03,18.03C41.13,30.76,29.45,46,23.09,53.43 L23.09,53.43z M23.09,53.43"></path> <path class="st0" d="M31.47,23.09c0,4.63-3.75,8.38-8.38,8.38s-8.38-3.75-8.38-8.38s3.75-8.38,8.38-8.38S31.47,18.47,31.47,23.09 L31.47,23.09z M31.47,23.09"></path> </g> </svg>

    <select name="regions[]" class="<?= $is_mobile?'':'selectpicker' ?> form-control input_seacrh selectregions" data-live-search="true"  id="selectregions" title="<?= trans("front.all regions"); ?>" multiple>
        <option value=""><?= trans("front.all regions"); ?></option>
        @foreach($inputs["regions_options"] as $region)
			@if(in_array($region->id,json_decode($inputs["project_regions_options"])))@endif
		<option value="<?= $region->slug ?>" <?= in_array($region->slug, $inputs['regions']) ? 'selected' : ''; ?>><?= $region->getName(); ?></option>
			 
		@endforeach
        <?php /* @foreach($inputs["regions_options"] as $region)
          <option value="<?= $region->slug ?>" <?= in_array($region->slug, $inputs['regions']) ? 'selected' : ''; ?>><?= $region->getName(); ?></option>
          @endforeach
         */ ?>
    </select>
</div>

<div class="form-group">
    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 23.41 24.56" xml:space="preserve"><g> <path class="st0" d="M4.35,4.91l6.19,1.88l0.31-1.02L4.22,3.76l-2.95,1.7l0.53,0.92L4.35,4.91z M4.35,4.91"></path> <path class="st0" d="M4.35,6.79l6.19,1.88l0.31-1.02L4.22,5.63l-2.95,1.7l0.53,0.92L4.35,6.79z M4.35,6.79"></path> <path class="st0" d="M4.35,8.66l6.19,1.88l0.31-1.02L4.22,7.51l-2.95,1.7l0.53,0.92L4.35,8.66z M4.35,8.66"></path> <path class="st0" d="M4.35,10.54l6.19,1.88l0.31-1.02L4.22,9.39l-2.95,1.7l0.53,0.92L4.35,10.54z M4.35,10.54"></path> <path class="st0" d="M4.35,12.42l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L4.35,12.42z M4.35,12.42"></path> <path class="st0" d="M4.35,14.3l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L4.35,14.3z M4.35,14.3"></path> <path class="st0" d="M4.35,16.18l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L4.35,16.18z M4.35,16.18"></path> <path class="st0" d="M4.35,18.05l6.19,1.88l0.31-1.02L4.22,16.9l-2.95,1.7l0.53,0.92L4.35,18.05z M4.35,18.05"></path> <path class="st0" d="M14.47,4.91l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L14.47,4.91z M14.47,4.91"></path> <path class="st0" d="M14.47,3.03l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L14.47,3.03z M14.47,3.03"></path> <path class="st0" d="M14.47,1.15l6.19,1.88l0.31-1.02L14.34,0l-2.95,1.7l0.53,0.92L14.47,1.15z M14.47,1.15"></path> <path class="st0" d="M14.47,6.79l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L14.47,6.79z M14.47,6.79"></path> <path class="st0" d="M14.47,8.66l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L14.47,8.66z M14.47,8.66"></path> <path class="st0" d="M14.47,10.54l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L14.47,10.54z M14.47,10.54"></path> <path class="st0" d="M14.47,12.42l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L14.47,12.42z M14.47,12.42"></path> <path class="st0" d="M14.47,14.3l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L14.47,14.3z M14.47,14.3"></path> <path class="st0" d="M14.47,16.18l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L14.47,16.18z M14.47,16.18"></path> <path class="st0" d="M14.47,18.05l6.19,1.88l0.31-1.02l-6.63-2.01l-2.95,1.7l0.53,0.92L14.47,18.05z M14.47,18.05"></path> <path class="st0" d="M20.67,23.55v-1.77l0.3-0.98l-6.63-2.01l-2.95,1.7l0.3,0.52v2.55h-1.13v-1.77l0.3-0.98l-6.63-2.01l-2.95,1.7 L1.57,21v2.55H0v1.02h23.41v-1.02H20.67z M5.75,23.55v-2.16L9,22.16v1.38H5.75z M15.87,23.55v-2.16l3.25,0.78v1.38H15.87z M15.87,23.55"></path> </g> </svg>

    <select name="project_type" class="<?= $is_mobile?'':'selectpicker' ?> form-control input_seacrh" title="<?= trans("front.property type"); ?>">
        <option value=""><?= trans("front.property type"); ?></option>
        @foreach($ProjectTypes as $type)
        @if(in_array($type->id,json_decode($inputs["project_types_options"])))
		<option value="<?= $type->slug; ?>" data_id="<?= $type->id ?>" <?= @$inputs["project_type"] == $type->slug ? 'selected' : ''; ?>><?= $type->getName(); ?></option>
		@endif
        @endforeach
    </select>
</div>

<div class="form-group">
    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 21.72 18.82" xml:space="preserve"><g> <path class="st0" d="M21.35,10.86h-0.36V9.77c0-0.72-0.43-1.37-1.09-1.66V2.53c0-0.14-0.09-0.27-0.22-0.33 c0.14-0.23,0.22-0.49,0.22-0.75c0-0.8-0.65-1.45-1.45-1.45c-0.8,0-1.45,0.65-1.45,1.45c0,0.25,0.07,0.5,0.2,0.72H4.5 C4.63,1.95,4.7,1.7,4.7,1.45C4.7,0.65,4.06,0,3.26,0S1.81,0.65,1.81,1.45c0,0.27,0.08,0.53,0.22,0.75 C1.89,2.26,1.81,2.39,1.81,2.53v5.58C1.15,8.4,0.72,9.05,0.72,9.77v1.09H0.36c-0.2,0-0.36,0.16-0.36,0.36v5.07 c0,0.2,0.16,0.36,0.36,0.36h0.36v1.81c0,0.2,0.16,0.36,0.36,0.36h1.45c0.2,0,0.36-0.16,0.36-0.36v-1.81h15.92v1.81 c0,0.2,0.16,0.36,0.36,0.36h1.45c0.2,0,0.36-0.16,0.36-0.36v-1.81h0.36c0.2,0,0.36-0.16,0.36-0.36v-5.07 C21.72,11.02,21.55,10.86,21.35,10.86z M2.53,2.9h16.65v5.07h-1.46c0.24-0.31,0.37-0.69,0.37-1.09V6.15c0-1-0.81-1.81-1.81-1.81 h-2.9c-1,0-1.81,0.81-1.81,1.81v0.72c0,0.39,0.13,0.77,0.37,1.09H9.76c0.24-0.31,0.37-0.69,0.37-1.09V6.15c0-1-0.81-1.81-1.81-1.81 h-2.9c-1,0-1.81,0.81-1.81,1.81v0.72c0,0.39,0.13,0.77,0.37,1.09H2.53V2.9z M1.45,9.77c0-0.6,0.49-1.09,1.09-1.09h16.65 c0.6,0,1.09,0.49,1.09,1.09v1.09H1.45V9.77z M20.99,15.92H0.72v-4.34h20.27V15.92z"></path> </g> </svg>
<?php 


?>
    <select name="rooms" class="<?= $is_mobile?'':'selectpicker' ?> form-control pattern input_seacrh" title="<?= trans("front.rooms"); ?>" ><!--multiple-->
        <option value="" selected><?= trans("front.nums rooms"); ?></option>
        <?php foreach ($arr_rooms as $kr => $i): ?>
			@if(in_array($kr,json_decode($inputs["rooms_options"])))
            <option value="<?= $kr; ?>" <?= (@$inputs["rooms"] == $kr /* or session()->get("filter_rooms") == $kr */) ? 'selected' : ''; ?>><?= $i; ?></option>
			@endif
        <?php endforeach; ?>
    </select>
</div>

<div class="form-group features_select">
    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 18.73 14.27" xml:space="preserve"><g> <path class="st0" d="M16.32,12.59c0-0.3-0.29-0.54-0.65-0.54H2.91c-0.36,0-0.65,0.24-0.65,0.54v1.15c0,0.3,0.29,0.54,0.65,0.54 h12.76c0.36,0,0.65-0.24,0.65-0.54V12.59z M16.32,12.59"></path> <path class="st0" d="M18.4,0.14c-0.25-0.12-0.56-0.09-0.76,0.07l-4.47,3.49l-3.3-3.49C9.75,0.09,9.56,0,9.36,0h0 c-0.2,0-0.39,0.09-0.51,0.22l-3.3,3.52l-4.47-3.5C0.88,0.08,0.58,0.05,0.33,0.17C0.08,0.28-0.05,0.52,0.01,0.75l2.49,9.58 c0.06,0.25,0.33,0.42,0.63,0.42h12.45c0.3,0,0.57-0.18,0.63-0.42l2.49-9.61C18.78,0.5,18.65,0.26,18.4,0.14L18.4,0.14z M18.4,0.14"></path> </g> </svg>

    <select name="project_categories[]" id="project_categories" class="<?= $is_mobile?'':'selectpicker' ?> form-control input_seacrh" data-live-search="true" title="<?= trans("front.special advantages"); ?>" multiple>
        <option value=""><?= trans("front.special advantages"); ?></option>
        @foreach($tags as $tag)
		@if(in_array($tag->id,json_decode($inputs["project_tags_options"])))
        <option value="<?= $tag->slug; ?>" <?= in_array($tag->slug, $inputs['project_categories']) ? 'selected' : ''; ?>><?= $tag->getName(); ?></option>
        @endif
        @endforeach
    </select>
</div>

<div class="form-group budget_select">
    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 22.27 21.99" xml:space="preserve"><g> <path class="st0" d="M7.08,7.83C3.18,7.83,0,11.01,0,14.91s3.18,7.08,7.08,7.08s7.08-3.18,7.08-7.08S10.98,7.83,7.08,7.83z M7.08,14.02c1.59,0,2.88,1.2,2.88,2.68c0,1.26-0.94,2.32-2.2,2.6v0.3c0,0.38-0.31,0.69-0.69,0.69c-0.38,0-0.69-0.31-0.69-0.69 v-0.3c-1.26-0.29-2.2-1.35-2.2-2.6c0-0.38,0.31-0.69,0.69-0.69c0.38,0,0.69,0.31,0.69,0.69c0,0.72,0.68,1.31,1.51,1.31 s1.51-0.59,1.51-1.31c0-0.72-0.68-1.31-1.51-1.31c-1.59,0-2.88-1.2-2.88-2.68c0-1.26,0.94-2.32,2.2-2.6V9.75 c0-0.38,0.31-0.69,0.69-0.69c0.38,0,0.69,0.31,0.69,0.69v0.36c1.26,0.29,2.2,1.35,2.2,2.6c0,0.38-0.31,0.69-0.69,0.69 c-0.38,0-0.69-0.31-0.69-0.69c0-0.72-0.68-1.31-1.51-1.31s-1.51,0.59-1.51,1.31C5.57,13.43,6.24,14.02,7.08,14.02z"></path> <path class="st0" d="M22.27,1.23c0-0.68-0.55-1.23-1.23-1.23H9.48C8.81,0,8.26,0.55,8.26,1.23s0.55,1.23,1.23,1.23h11.56 C21.72,2.45,22.27,1.9,22.27,1.23z"></path> <path class="st0" d="M16.7,4.62c0-0.68-0.55-1.23-1.23-1.23H3.92c-0.68,0-1.23,0.55-1.23,1.23c0,0.68,0.55,1.23,1.23,1.23h3.02 h8.54C16.15,5.85,16.7,5.3,16.7,4.62z"></path> <path class="st0" d="M19.72,8.02c0-0.68-0.55-1.23-1.23-1.23H6.94c-0.19,0-0.37,0.04-0.54,0.12C6.62,6.9,6.85,6.89,7.08,6.89 c2.22,0,4.22,0.9,5.68,2.36h5.74C19.17,9.25,19.72,8.7,19.72,8.02z"></path> <path class="st0" d="M19.72,11.42c0-0.68-0.55-1.23-1.23-1.23h-4.94c0.54,0.73,0.95,1.56,1.21,2.45h3.72 C19.17,12.65,19.72,12.1,19.72,11.42z"></path> <path class="st0" d="M19.72,14.82c0-0.68-0.55-1.23-1.23-1.23h-3.51c0.07,0.43,0.11,0.87,0.11,1.32c0,0.38-0.03,0.76-0.08,1.13 h3.48C19.17,16.04,19.72,15.49,19.72,14.82z"></path> <path class="st0" d="M18.5,19.44c0.68,0,1.23-0.55,1.23-1.23s-0.55-1.23-1.23-1.23h-3.67c-0.24,0.89-0.62,1.72-1.13,2.45H18.5z"></path> </g> </svg>
    <div class="budget">
        <div class="dropdown">
            <button class="form-control dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= trans("front.budget"); ?> 
                <span class="number"></span>
            </button>
            <div id="budgetMenu" class="dropdown-menu shadow_type" aria-labelledby="dropdownMenuButton">
                <div class="range-slider">
                    <span class="rangeValues number"></span>
                    <input id="prmin" value="50000" class="min_budj input_seacrh" min="50000" max="2000000" step="50000" type="range" />
                    <input id="prmax" value="2000000" class="max_budj input_seacrh" min="50000" max="2000000" step="50000" type="range" />
                </div>
            </div>
        </div>
    </div>
</div>


<?= Form::close(); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var $ = window.jQuery;
    var filterCities = <?= json_encode($filterCities, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;
    var filterCountryUrls = <?= json_encode($filterCountryUrls, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?>;
    var cityPlaceholder = <?= json_encode(trans("front.city"), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;

    function refreshPickers($selects) {
        if ($.fn.selectpicker) {
            $selects.selectpicker('refresh');
        }
    }

    function clearDistricts() {
        var $regions = $('#selectregions');
        $regions.children('option').not(':first').remove();
        refreshPickers($regions);
    }

    $(document).on('change', '#filter_country', function () {
        var countryId = parseInt($(this).val(), 10);
        var $city = $('#form-search select[name=city]');
        $city.empty().append($('<option value=""></option>').text(cityPlaceholder));
        $.each(filterCities, function (i, c) {
            if (!countryId || c.country === countryId) {
                $city.append($('<option></option>').val(c.slug).text(c.name));
            }
        });
        refreshPickers($city);
        clearDistricts();

        if (countryId && filterCountryUrls[countryId]) {
            window.location.href = filterCountryUrls[countryId];
        }
    });

    $(document).on('change', '#form-search select[name=city]', clearDistricts);
});
</script>