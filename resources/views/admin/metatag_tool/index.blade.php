@extends('admin.layouts.app', ["app_title" => "Meta Tag Manager"])
@section('main_content')
<style>
    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
    @keyframes glow {
        0% {
            background-color: #19cecc;
        }
        50% {
            background-color: #12fcfa;
        }
        100% {
            background-color: #19cecc;
        }
    }
    .box-body {
        padding: 10px 0;
    }
    .filters {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }
    button {
        background-color: #13aaa8;
        color: #fff;
        border-radius: 3px;
        border: none;
    }
    .hidden {
        display: none;
    }
    .tnum {
        width: 0.05%;
    }
    .tsmallstr {
        width: 2%;
    }
    .tmedstr {
        width: 7%;
    }
    .tlargestr {
        width: 15%;
    }
    .table {
        min-width: 120vw;
    }
    *[contenteditable="true"], .contenteditable{
        cursor: pointer;
        background-color: #ddd;
    }
    #confirmationDialog {
        position: absolute;
        background-color: #fff;
        padding: 30px;
        border-radius: 15px;
        border: 2px solid #000;
        box-shadow: 0 5px 8px #222;
        color: red;
        text-align: center;
    }
    #confirmationDialog h3 {
        font-weight: 900;
    }
    .updateBtns {
        margin-top: 5%;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-evenly;
    }
    .updateBtns button {
        font-size: 20px;
        padding: 7px;
        height: fit-content;
    }
    #confirmUpdate {
        background-color: #c00;
    }
    #confirmUpdate:hover {
        background-color: #e00;
    }
    #cancel:hover {
        background-color: #19cecc;
    }
    .slug {
        line-break: anywhere;
    }
    #fetchingIndexes {
        position: absolute;
        top: 10vh;
        left: 50%;
        transform: translateX(-50%);
        background-color: #fff;
        width: fit-content;
        padding: 8px;
        border: 2px solid #000;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        gap: 10px
    }
    #fetchingIndexes p {
        margin: 0;
    }
    #fetchingIndexes div {
        width: 15px;
        height: 15px;
        animation: spin 4s linear infinite;
        background-color: #000;
    }
    .rich-results {
        white-space: nowrap;
        font-size: 1rem;
    }
    .nav-tabs-custom {
        margin-top: 1.5%;
    }
    td, td * {
        transition: background-color 0.2s;
    }
    tr.proccessing td, tr.proccessing td * {
        background-color: #fff3cd !important;
    }
</style>
<?php
    $language = @$_GET['lang'] == 'en' ? 'en' : 'ar';
    $posts = \DB::table('posts')->select(
        'id',
        'title_ar',
        'title_en',
        'slug',
        'seo_title_ar',
        'seo_title_en',
        'seo_description_ar',
        'seo_description_en',
        'country'
    )->get();
    $projects = \DB::table('projects')->select(
        'id',
        'name_en',
        'name_ar',
        'title_en',
        'slug',
        'seo_title_ar',
        'seo_title_en',
        'seo_description_ar',
        'seo_description_en',
        'city_id',
        'has_special_h1',
        'special_h1_ar',
        'special_h1_en'
    )->get();
    $listings = \DB::table('page_search')->select(
        'id',
        'title',
        'title_en',
        'link',
        'seo_title_ar',
        'seo_title_en',
        'seo_description_ar',
        'seo_description_en',
        'post_id'
    )->get();
    $links_statuses = \DB::table('links_status')->select('link', 'status', 'schema_json')->whereNotNull('schema_json')->get();
    $counter = 1;
    $projects = \App\Models\Project::with([
        'types',
        'categories',
        'city',
        'region'
    ])->select(
        'id',
        'title_en',
        'name_ar',
        'name_en',
        'slug',
        'city_id',
        'region_id',
        'sold',
        'has_special_h1',
        'special_h1_ar',
        'special_h1_en',
        'seo_title_ar',
        'seo_title_en',
        'seo_description_ar',
        'seo_description_en'
    )->get();
?>
<div id="metatag-tool-page">
    <div class="filters">
        <select id="countryFilter">
            <option value="all">All Countries</option>
            <option value="oman">Oman</option>
            <option value="turkey">Turkey</option>
            <option value="global">Global</option>
        </select>
        <select id="typeFilter">
            <option value="all">All Types</option>
            <option value="listing">Listing</option>
            <option value="project">Projects</option>
            <option value="post">Guides</option>
            <option value="general">General</option>
        </select>
        <select id="statusFilter">
            <option value="all">All HTTP</option>
            
        </select>
        <div>
            <button id="crawl">Start Crawling</button>
            <button type="button" id="connectGoogle">Connect GSC</button>
            <button id="update">Update All</button>
        </div>
        <dialog id="confirmationDialog">
            <h3>Are you sure you want to update <span class="fields-count"></span> page<span class="s"></span>?</h3>
            <p>Make sure that all of the changes you made are correct:</p>
            <p class="changes"></p>
            <div class="updateBtns">
                <button id="cancel">Cancel</button>
                <button id="confirmUpdate">Update</button>
            </div>
        </dialog>
        <div id="fetchingIndexes">
            <div id="loadingDiv"></div>
            <p id="loadingP">Loading Spreadsheet...</p>
        </div>
    </div>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="<?= $language === 'ar' ? 'active' : '' ?>">
                <a href="?<?= htmlspecialchars(http_build_query(array_merge($_GET, ['lang' => 'ar'])), ENT_QUOTES, 'UTF-8') ?>">
                    Arabic
                    <span id="lang-counter-ar"></span>
                </a>
            </li>
            <li class="<?= $language === 'en' ? 'active' : '' ?>">
                <a href="?<?= htmlspecialchars(http_build_query(array_merge($_GET, ['lang' => 'en'])), ENT_QUOTES, 'UTF-8') ?>">
                    English
                    <span id="lang-counter-en"></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover content-metatag-table">
                <thead>
                    <tr>
                        <th class="tnum">#</th>
                        <th class="tsmallstr">HTTP</th>
                        <th class="tmedstr">Page / H1</th>
                        <th class="tnum len-column">Len</th>
                        <th class="tmedstr">Slug</th>
                        <th class="tmedstr">Meta Title</th>
                        <th class="tnum len-column">Len</th>
                        <th class="tlargestr">Meta Description</th>
                        <th class="tnum len-column">Len</th>
                        <th class="tsmallstr canonincal-column">Canonical</th>
                        <th class="tsmallstr indexing-column">Indexing</th>
                        <th class="tmedstr lastcrawl-column">Last Crawl</th>
                        <th class="tsmallstr">Rich Results</th>
                        <th class="tmedstr">Schema</th>
                        <th class="tsmallstr">Sitemap</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listings as $listing)
                    <?php
                    $customH1 = $language === 'en'
                        ? trim((string)$listing->title_en)
                        : trim((string)$listing->title);
                    $post = null;
                    if ((int)$listing->post_id !== 0) {
                        $column = $language === 'en' ? 'title_en' : 'title_ar';
                        $post = \DB::table('posts')
                            ->select($column)
                            ->where('id', $listing->post_id)
                            ->first();
                    }
                    if ($post) {
                        $h1Source = 'blog';
                        $h1 = $post->{$column};
                        $effectivePostId = (int)$listing->post_id;
                    } elseif ($customH1 !== '') {
                        $h1Source = 'custom';
                        $h1 = $customH1;
                        $effectivePostId = 0;
                    } else {
                        $h1Source = 'generated';
                        $h1 = Helper::generate_search_h1_from_link($listing->link, $language);
                        $effectivePostId = 0;
                    }
                    ?>
                    <tr rowType="listing" data-id="{{ $listing->id }}" data-post-id="{{ $effectivePostId }}" data-country="<?= (strpos($listing->link, "oman") !== false || strpos($listing->link, "muscat") !== false) ? "oman" : "turkey" ?>">
                        <td>{{ $counter }}</td>
                        <td class="http-status">
                            <?php
                            $hasfound = false;
                                foreach($links_statuses as $statusObj){
                                    if($statusObj->link === $listing->link){
                                        $hasfound = true;
                                        $statusChain = json_decode($statusObj->status, true);
                                        echo is_array($statusChain)
                                            ? implode(' → ', $statusChain)
                                            : htmlspecialchars($statusObj->status, ENT_QUOTES, 'UTF-8');
                                    }
                                }
                                if($hasfound === false){
                                    echo "—";
                                }
                            ?>
                        </td>
                        <td class="h1td contenteditable">
                            <span class="h1-source">[{{ $h1Source }}]</span>
                            <a contenteditable="true" href="{{ $listing->link }}" target="_blank" class="link">{{ $h1 }}</a>
                        </td>
                        <td class="h1len"></td>
                        <td class="slug">{{ $listing->link }}</td>
                        <td contenteditable="true" class="meta">{{ $language === 'en' ? $listing->seo_title_en : $listing->seo_title_ar }}</td>
                        <td class="metalen"></td>
                        <td contenteditable="true" class="desc tlargetr">{{ $language === 'en' ? $listing->seo_description_en : $listing->seo_description_ar }}</td>
                        <td class="desclen"></td>
                        <td class="canonical"></td>
                        <td class="indexing"></td>
                        <td class="last-crawl"></td>
                        <td class="rich-results"></td>
                        <td class="schema">
                            <?php
                                $schemasArr = [];
                                foreach ($links_statuses as $statusObj) {
                                    if ($statusObj->link !== $listing->link) {
                                        continue;
                                    }
                                    $rawSchemas = json_decode($statusObj->schema_json, true);
                                    foreach ($rawSchemas as $rawSchema) {
                                        $schema = is_string($rawSchema) ? json_decode($rawSchema, true) : $rawSchema;
                                        if (!is_array($schema) || !isset($schema['@type'])) {
                                            continue;
                                        }
                                        $types = is_array($schema['@type']) ? $schema['@type'] : [$schema['@type']];
                                        foreach ($types as $type) {
                                            $schemasArr[] = htmlspecialchars($type, ENT_QUOTES, 'UTF-8');
                                        }
                                    }
                                    break;
                                }
                                echo implode(', ', array_unique($schemasArr));
                            ?>
                        </td>
                        <td class="sitemap"></td>
                    </tr>
                    @endforeach
                    @foreach($posts as $post)
                    <?php
                        $link = "https://damas.net/"
                            . ($language === 'en' ? 'en/' : '')
                            . ($post->country === 'oman' ? 'oman/' : '')
                            . "blog/"
                            . $post->slug;
                    ?>
                    <tr data-country="{{ strtolower($post->country) }}" rowType="post" data-id="{{ $post->id }}">
                        <td>{{ $counter }}</td>
                        <td class="http-status">
                            <?php 
                                foreach($links_statuses as $statusObj){
                                    if($statusObj->link === $link){
                                        $statusChain = json_decode($statusObj->status, true);
                                        echo is_array($statusChain)
                                            ? implode(' → ', $statusChain)
                                            : htmlspecialchars($statusObj->status, ENT_QUOTES, 'UTF-8');
                                    }
                                }
                            ?>
                        </td>
                        <td class="h1td contenteditable"><a contenteditable="true" href="{{ $link }}" target="_blank" class="link">{{ $language === 'en' ? $post->title_en : $post->title_ar }}</a></td>
                        <td class="h1len"></td>
                        <td class="slug">{{ $post->slug }}</td>
                        <td contenteditable="true" class="meta">{{ $language === 'en' ? $post->seo_title_en : $post->seo_title_ar }}</td>
                        <td class="metalen"></td>
                        <td contenteditable="true" class="desc tlargetr">{{ $language === 'en' ? $post->seo_description_en : $post->seo_description_ar }}</td>
                        <td class="desclen"></td>
                        <td class="canonical"></td>
                        <td class="indexing"></td>
                        <td class="last-crawl"></td>
                        <td class="rich-results"></td>
                        <td class="schema">
                            <?php
                                $schemasArr = [];
                                foreach ($links_statuses as $statusObj) {
                                    if ($statusObj->link !== $link) {
                                        continue;
                                    }
                                    $rawSchemas = json_decode($statusObj->schema_json, true);
                                    foreach ($rawSchemas as $rawSchema) {
                                        $schema = is_string($rawSchema) ? json_decode($rawSchema, true) : $rawSchema;
                                        if (!is_array($schema) || !isset($schema['@type'])) {
                                            continue;
                                        }
                                        $types = is_array($schema['@type']) ? $schema['@type'] : [$schema['@type']];
                                        foreach ($types as $type) {
                                            $schemasArr[] = htmlspecialchars($type, ENT_QUOTES, 'UTF-8');
                                        }
                                    }
                                    break;
                                }
                                echo implode(', ', array_unique($schemasArr));
                            ?>
                        </td>
                        <td class="sitemap"></td>
                    </tr>
                    <?php $counter++; ?>
                    @endforeach
                    @foreach($projects as $project)
                    <?php
                        $link = "https://damas.net/"
                            . ($language === 'en' ? 'en/' : '')
                            . (intval($project->city_id) === 13 ? 'oman/' : '')
                            . "projects/"
                            . $project->slug;
                        $isSoldOut = (int)$project->sold === 100;
                        $specialH1 = $language === 'en'
                            ? trim((string)$project->special_h1_en)
                            : trim((string)$project->special_h1_ar);
                        if ($isSoldOut) {
                            $h1Source = 'sold out — no H1';
                            $projectH1 = '';
                        } elseif ((int)$project->has_special_h1 === 1 && $specialH1 !== '') {
                            $h1Source = 'special';
                            $projectH1 = $specialH1;
                        } else {
                            $h1Source = 'generated';
                            $projectH1 = Helper::generate_project_default_h1($project, $language);
                        }
                    ?>
                    <tr rowType="project" data-id="{{ $project->id }}" data-sold="{{ $isSoldOut ? '1' : '0' }}">
                        <td>{{ $counter }}</td>
                        <td class="http-status">
                            <?php 
                                foreach($links_statuses as $statusObj){
                                    if($statusObj->link === $link){
                                        $statusChain = json_decode($statusObj->status, true);
                                        echo is_array($statusChain)
                                            ? implode(' → ', $statusChain)
                                            : htmlspecialchars($statusObj->status, ENT_QUOTES, 'UTF-8');
                                    }
                                }
                            ?>
                        </td>
                        <?php
                        $specialH1 = $language === 'en'
                            ? trim((string)$project->special_h1_en)
                            : trim((string)$project->special_h1_ar);
                        if ((int)$project->has_special_h1 === 1 && $specialH1 !== '') {
                            $h1Source = 'special';
                            $projectH1 = $specialH1;
                        } else {
                            $h1Source = 'generated';
                            $projectH1 = Helper::generate_project_default_h1($project, $language);
                        }
                        ?>
                        <td class="h1td contenteditable">
                            <span class="h1-source">[{{ $isSoldOut ? 'sold out' : $h1Source }}]</span>
                            <a contenteditable="{{ $isSoldOut ? 'false' : 'true' }}" href="{{ $link }}" target="_blank" class="link">{{ $isSoldOut ? '' : $projectH1 }}</a>
                        </td>
                        <td class="h1len"></td>
                        <td class="slug">{{ $project->slug }}</td>
                        <td contenteditable="true" class="meta">{{ $language === 'en' ? $project->seo_title_en : $project->seo_title_ar }}</td>
                        <td class="metalen"></td>
                        <td contenteditable="true" class="desc tlargetr">{{ $language === 'en' ? $project->seo_description_en : $project->seo_description_ar }}</td>
                        <td class="desclen"></td>
                        <td class="canonical"></td>
                        <td class="indexing"></td>
                        <td class="last-crawl"></td>
                        <td class="rich-results"></td>
                        <td class="schema">
                            <?php
                                $schemasArr = [];
                                foreach ($links_statuses as $statusObj) {
                                    if ($statusObj->link !== $link) {
                                        continue;
                                    }
                                    $rawSchemas = json_decode($statusObj->schema_json, true);
                                    foreach ($rawSchemas as $rawSchema) {
                                        $schema = is_string($rawSchema) ? json_decode($rawSchema, true) : $rawSchema;
                                        if (!is_array($schema) || !isset($schema['@type'])) {
                                            continue;
                                        }
                                        $types = is_array($schema['@type']) ? $schema['@type'] : [$schema['@type']];
                                        foreach ($types as $type) {
                                            $schemasArr[] = htmlspecialchars($type, ENT_QUOTES, 'UTF-8');
                                        }
                                    }
                                    break;
                                }
                                echo implode(', ', array_unique($schemasArr));
                            ?>
                        </td>
                        <td class="sitemap"></td>
                    </tr>
                    <?php $counter++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    const updateBtn = document.getElementById("update");
    const tableBody = document.querySelector("tbody");
    const confirmationDialog = document.getElementById("confirmationDialog");
    const cancelBtn = document.getElementById("cancel");
    const confirmUpdateBtn = document.getElementById("confirmUpdate");
    const loading = document.getElementById("fetchingIndexes");
    const loadingP = document.getElementById("loadingP");
    const countryFilter = document.getElementById("countryFilter");
    const postRows = document.querySelectorAll(".content-metatag-table tbody tr");
    const loadingDiv = loading.querySelector("div");
    const connectGoogleBtn = document.getElementById("connectGoogle");
    const allRows = tableBody.querySelectorAll("tr");
    const allRowsArr = [...allRows];
    const lastCrawlColumn = document.querySelector("lastcrawl-column");
    const canonicalColumn = document.querySelector("canonical-column");
    const indexingColumn = document.querySelector("indexing-column");
    const lenColumn = document.querySelector("len-column");
    const typeFilter = document.getElementById("typeFilter");
    const statusFilter = document.getElementById("statusFilter");
    const language = "{{ $language }}";
    
    let changes = new Map();
    
    function applyFilters(){
        const country = countryFilter.value;
        const type = typeFilter.value;
        findStatuses();
        const status = statusFilter.value;
        const selectedRows = allRowsArr.filter(row => {
            const rowCountry = row.querySelector(".link").href.includes("/oman/") || row.dataset.country === "oman" ? "oman" : "turkey";
            const rowType = row.getAttribute("rowType");
            const rowStatus = row.querySelector(".http-status").textContent.trim();
            const matchesCountry = country === "all" || rowCountry === country;
            const matchesType = type === "all" || rowType === type;
            const matchesStatus = status === "all" || rowStatus === status;
            return matchesCountry && matchesType && matchesStatus;
        });
        tableBody.replaceChildren(...selectedRows);
        [...tableBody.children].forEach((row, index) => {
            row.querySelector("td:nth-child(1)").textContent = index + 1;
        });
        addLengths();
        document.getElementById(`lang-counter-${language}`).textContent = ` (${[...tableBody.children].length})`;
    }
    async function handleFilterChange(){
        loading.style.display = "flex";
        loadingP.textContent = "Applying Filters...";
        await new Promise(resolve => requestAnimationFrame(() => requestAnimationFrame(resolve)));
        try {
            applyFilters();
        } finally {
            loading.style.display = "none";
            loadingP.textContent = "";
        }
    }
    applyFilters();
    countryFilter.addEventListener("change", handleFilterChange);
    typeFilter.addEventListener("change", handleFilterChange);
    statusFilter.addEventListener("change", handleFilterChange);
    updateBtn.addEventListener("click", () => {
        if(changes.size === 0){
            loading.style.display = "flex";
            loadingDiv.style.animation = "none"
            loadingP.textContent = "No fields were changed";
            setTimeout(() => {
                loading.style.display = "none";
                loadingDiv.style.animation = "spin 4s linear infinite";
                loadingP.textContent = "";
            }, 3000);
            return;
        }
        confirmationDialog.querySelector("h3 .fields-count").innerText = changes.size;
        confirmationDialog.querySelector("h3 .s").textContent = changes.size === 1 ? "" : "s";
        let h1Counter = 0;
        let metaCounter = 0;
        let descCounter = 0;
        [...changes.values()].forEach(curr => {
            if(curr.title_ar !== undefined || curr.title_en !== undefined){
                h1Counter++;
            }
            if(curr.seo_title_ar !== undefined || curr.seo_title_en !== undefined){
                metaCounter++;
            }
            if(curr.seo_description_ar !== undefined || curr.seo_description_en !== undefined){
                descCounter++;
            }
        });
        let changesArr = [];
        if(h1Counter > 0){
            changesArr.push(`H1: ${h1Counter}`);
        }
        if(metaCounter > 0){
            changesArr.push(`Meta Title: ${metaCounter}`);
        }
        if(descCounter > 0){
            changesArr.push(`Meta Description: ${descCounter}`);
        }
        confirmationDialog.querySelector(".changes").textContent = changesArr.join(", ");
        confirmationDialog.showModal();
    });
    cancelBtn.addEventListener("click", () => {
        confirmationDialog.close();
    });
    function findStatuses() {
        const selectedStatus = statusFilter.value;
        const country = countryFilter.value;
        const type = typeFilter.value;
        const statuses = [...new Set(allRowsArr.filter(row => {
            const rowCountry = row.querySelector(".link").href.includes("/oman/") || row.dataset.country === "oman" ? "oman" : "turkey";
            const rowType = row.getAttribute("rowType");
            return (country === "all" || rowCountry === country) && (type === "all" || rowType === type);
        }).map(row => row.querySelector(".http-status").textContent.trim()).filter(Boolean))];
        statusFilter.replaceChildren(
            new Option("All HTTP", "all"),
            ...statuses.map(status => new Option(status, status))
        );
        statusFilter.value = statuses.includes(selectedStatus) ? selectedStatus : "all";
    }
    function getLengthStatus(length, field) {
        const green = "#00a65a";
        const orange = "#ff9e00";
        const red = "#dd4b39";
        if (field === "h1") {
            if (length === 0) return [red, "-"];
            if (length <= 70) return [green];
            if (length <= 100) return [orange, "+"];
            return [red, "+"];
        }
        if (field === "meta") {
            if (length === 0) return [red, "-"];
            if (length < 30) return [orange, "-"];
            if (length <= 60) return [green];
            if (length <= 70) return [orange, "+"];
            return [red, "+"];
        }
        if (field === "desc") {
            if (length < 70) return [red, "-"];
            if (length < 120) return [orange, "-"];
            if (length <= 160) return [green];
            if (length <= 180) return [orange, "+"];
            return [red, "+"];
        }
        throw new Error("Unknown field: " + field);
    }
    function addLengths(){
        [...tableBody.querySelectorAll(".h1td")].forEach(cell => {
        const editable = cell.querySelector(".link");
        const lenCell = cell.parentElement.querySelector(".h1len");
        const updateLength = () => {
            const length = editable.textContent.trim().length;
            const result = getLengthStatus(length, "h1");
            lenCell.textContent = String(length) + (result.length === 2 ? `(${result[1]})` : "");
            lenCell.style.color = result[0];
        };
        updateLength();
        editable.addEventListener("input", updateLength);
    });
        [...tableBody.querySelectorAll(".meta")].forEach(curr => {
            const len = curr.parentElement.querySelector(".metalen");
            let result = getLengthStatus(curr.textContent.length, "meta");
            len.textContent = String(curr.textContent.length) + (result.length === 2 ? `(${result[1]})` : '');
            len.style.color = result[0];
            curr.addEventListener("input", () => {
                let result = getLengthStatus(curr.textContent.length, "meta");
                len.textContent = String(curr.textContent.length) + (result.length === 2 ? `(${result[1]})` : '');
                len.style.color = result[0];
            });
        });
        [...tableBody.querySelectorAll(".desc")].forEach(curr => {
            const len = curr.parentElement.querySelector(".desclen");
            let result = getLengthStatus(curr.textContent.length, "desc");
            len.textContent = String(curr.textContent.length) + (result.length === 2 ? `(${result[1]})` : '');
            len.style.color = result[0];
            curr.addEventListener("input", () => {
                let result = getLengthStatus(curr.textContent.length, "desc");
                len.textContent = String(curr.textContent.length) + (result.length === 2 ? `(${result[1]})` : '');
                len.style.color = result[0];
            });
        });
        [...tableBody.querySelectorAll("a")].forEach(curr => {
            curr.addEventListener("click", e => {
                if(e.ctrlKey){
                    window.open(curr.href, "_blank", "noopener,noreferrer");
                }
            });
        });
    }
    loading.style.display = "none";
    loadingP.textContent = "";
    
    document.getElementById("crawl").addEventListener("click", crawlRows);
    let googleAccessToken = null;
    let googleTokenClient = null;
    function googleAuthLoaded() {
        googleTokenClient = google.accounts.oauth2.initTokenClient({
            client_id: "424156267069-20nnlvdq22upvnug3bcjbtc5fvmn8ggo.apps.googleusercontent.com",
            scope: "https://www.googleapis.com/auth/webmasters.readonly",
            callback: async response => {
                if (response.error) {
                    console.error("Google authorization failed:", response);
                    return;
                }
                googleAccessToken = response.access_token;
                console.log("Google Search Console connected");
                await inspectFirstTenRows();
            }
        });
    }
    connectGoogleBtn.addEventListener("click", () => {
        if (!googleTokenClient) {
            console.error("Google authentication is still loading");
            return;
        }
        googleTokenClient.requestAccessToken();
    });
    async function getIndexing(url) {
        if (!googleAccessToken) {
            throw new Error("Google Search Console is not connected");
        }
        const response = await fetch("https://searchconsole.googleapis.com/v1/urlInspection/index:inspect", {
            method: "POST",
            headers: {
                "Authorization": "Bearer " + googleAccessToken,
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                inspectionUrl: url,
                siteUrl: "sc-domain:damas.net",
                languageCode: "en-US"
            })
        });
        const data = await response.json();
        if (!response.ok) {
            throw new Error(data.error ? data.error.message : "Inspection failed");
        }
        return data;
    }
    const formatter = new Intl.DateTimeFormat('en-GB', {
      day: 'numeric',
      month: 'short',
      year: 'numeric'
    });
    function getSeoStatuses(data) {
        const index = data?.inspectionResult?.indexStatusResult || {};
    
        const {
            verdict,
            coverageState,
            robotsTxtState,
            indexingState,
            pageFetchState,
            googleCanonical,
            userCanonical
        } = index;
    
        // ==========================================
        // 1. CANONICAL STATUS
        // ==========================================
    
        let canonicalStatus;
    
        if (coverageState === "URL is unknown to Google") {
            canonicalStatus = {
                message: "Unknown",
                color: "gray"
            };
        } else if (!userCanonical) {
            canonicalStatus = {
                message: "User Canonical Missing",
                color: "orange"
            };
        } else if (!googleCanonical) {
            canonicalStatus = {
                message: "Google Canonical Unknown",
                color: "orange"
            };
        } else if (userCanonical === googleCanonical) {
            canonicalStatus = {
                message: "Match",
                color: "green"
            };
        } else {
            canonicalStatus = {
                message: "Mismatch",
                color: "red"
            };
        }
    
    
        // ==========================================
        // 2. INDEX STATUS
        // ==========================================
    
        let indexStatus;
    
        if (coverageState === "URL is unknown to Google") {
            indexStatus = {
                message: "Unknown to Google",
                color: "gray"
            };
        }
    
        else if (
            robotsTxtState &&
            robotsTxtState !== "ALLOWED" &&
            robotsTxtState !== "ROBOTS_TXT_STATE_UNSPECIFIED"
        ) {
            indexStatus = {
                message: "Blocked by Robots",
                color: "red"
            };
        }
    
        else if (
            indexingState === "BLOCKED_BY_META_TAG" ||
            indexingState === "BLOCKED_BY_HTTP_HEADER"
        ) {
            indexStatus = {
                message: "Noindex",
                color: "red"
            };
        }
    
        else if (
            pageFetchState &&
            pageFetchState !== "SUCCESSFUL" &&
            pageFetchState !== "PAGE_FETCH_STATE_UNSPECIFIED"
        ) {
            indexStatus = {
                message: "Fetch Failed",
                color: "red"
            };
        }
    
        else if (/crawled.*not indexed/i.test(coverageState || "")) {
            indexStatus = {
                message: "Crawled - Not Indexed",
                color: "orange"
            };
        }
    
        else if (/discovered.*not indexed/i.test(coverageState || "")) {
            indexStatus = {
                message: "Discovered - Not Crawled",
                color: "orange"
            };
        }
    
        else if (/soft.?404/i.test(coverageState || "")) {
            indexStatus = {
                message: "Soft 404",
                color: "red"
            };
        }
    
        else if (/duplicate|alternate/i.test(coverageState || "")) {
            indexStatus = {
                message: "Duplicate",
                color: "orange"
            };
        }
    
        else if (
            verdict === "PASS" &&
            indexingState === "INDEXING_ALLOWED" &&
            pageFetchState === "SUCCESSFUL"
        ) {
            indexStatus = {
                message: "Indexed",
                color: "green"
            };
        }
    
        else {
            indexStatus = {
                message: "Other Issue",
                color: "orange"
            };
        }
    
    
        // [0] = Canonical Status
        // [1] = Index Status
        return [
            canonicalStatus,
            indexStatus
        ];
    }
    async function inspectFirstTenRows() {
        const rows = [...document.querySelectorAll(".content-metatag-table tbody tr")];
        loading.style.display = "flex";
        loadingDiv.style.animation = "spin 4s linear infinite";
        loadingP.textContent = loadingP.textContent === "" ? "Fetching Google for Indexings" : "Crawling Page Headers and Fetching Google for Indexings";
        for (const row of rows) {
            const link = row.querySelector(".link");
            if (!link) continue;
            try {
                const data = await getIndexing(link.href);
                console.log(link.href, data);
                let statuses = getSeoStatuses(data);
                row.querySelector(".canonical").textContent = statuses[0].message;
                row.querySelector(".canonical").style.color = statuses[0].color;
                row.querySelector(".indexing").textContent = statuses[1].message;
                row.querySelector(".indexing").style.color = statuses[1].color;
                row.querySelector(".rich-results").innerHTML = data.inspectionResult?.richResultsResult?.verdict === "PASS"
                    ? data.inspectionResult.richResultsResult.detectedItems.map(curr => "-"+curr.richResultType).join("<br>")
                    : "—"
                row.querySelector(".last-crawl").textContent = data?.inspectionResult?.indexStatusResult?.lastCrawlTime ? formatter.format(new Date(data.inspectionResult.indexStatusResult.lastCrawlTime)) : "—";
                row.querySelector(".sitemap").textContent = data?.inspectionResult?.sitemap ? "Yes" : "No";
            } catch (error) {
                console.error("Inspection failed for " + link.href, error);
            }
        }
        loading.style.display = "none";
        loadingP.textContent = "";
    }
    async function crawlPage(url) {
        const response = await fetch("{{ route('admin.metatagtool.crawl') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                url: url
            })
        });
        const data = await response.json();
        if (!response.ok) {
            throw new Error(data.error || "Internal crawl failed");
        }
        return data;
    }
    async function crawlRows() {
        const rows = [...document.querySelectorAll(".content-metatag-table tbody tr")];
        loading.style.display = "flex";
        loadingDiv.style.animation = "spin 4s linear infinite";
        loadingP.textContent = loadingP.textContent === "" ? "Crawling Page Headers" : "Crawling Page Headers and Fetching Google for Indexings";
        for (const row of rows) {
            row.classList.toggle("proccessing");
            const link = row.querySelector(".link");
            const httpCell = row.querySelector(".http-status");
            const schemaCell = row.querySelector(".schema");
            if (!link || !httpCell || !schemaCell) continue;
            httpCell.textContent = "...";
            schemaCell.textContent = "...";
            try {
                const result = await crawlPage(link.href);
                httpCell.innerHTML = result.httpStatus.join("<br>");
                if (result.httpStatus[result.httpStatus.length-1] >= 200 && result.httpStatus[result.httpStatus.length-1] < 300) {
                    httpCell.style.color = "green";
                } else if (result.httpStatus[result.httpStatus.length-1] >= 300 && result.httpStatus[result.httpStatus.length-1] < 400) {
                    httpCell.style.color = "#ff9e00";
                } else {
                    httpCell.style.color = "red";
                }
                if (result.schemas.length === 0) {
                    schemaCell.textContent = "None";
                    schemaCell.style.color = "#ff9e00";
                } else {
                    const invalidSchema = result.schemas.some(schema => !schema.valid);
                    schemaCell.textContent = result.schemas.map(schema => {
                        if (!schema.valid) return "Invalid JSON-LD";
                        return schema.types.length ? schema.types.join(", ") : "Unknown type";
                    }).join(" | ");
                    schemaCell.style.color = invalidSchema ? "red" : "green";
                }
            } catch (error) {
                httpCell.textContent = "Error";
                schemaCell.textContent = "Error";
                httpCell.style.color = "red";
                schemaCell.style.color = "red";
                console.error("Internal crawl failed for " + link.href, error);
            }
            finally {
                row.classList.toggle("proccessing");
            }
        }
        loading.style.display = "none";
        loadingP.textContent = "";
    }
    const collator = new Intl.Collator(undefined, {
        numeric: true,
        sensitivity: "base"
    });
    function sortRows(selector, type, ascending = true) {
        const direction = ascending ? 1 : -1;
        allRowsArr.sort((rowA, rowB) => {
            let valueA = rowA.querySelector(selector)?.textContent.trim() || "";
            let valueB = rowB.querySelector(selector)?.textContent.trim() || "";
            if (type === "number") {
                valueA = parseFloat(valueA) || 0;
                valueB = parseFloat(valueB) || 0;
                return (valueA - valueB) * direction;
            }
            if (type === "date") {
                valueA = Date.parse(valueA) || 0;
                valueB = Date.parse(valueB) || 0;
                return (valueA - valueB) * direction;
            }
            return collator.compare(valueA, valueB) * direction;
        });
        applyFilters();
    }
    const tableHeaders = [...document.querySelectorAll(".content-metatag-table thead th")];
    const columnSortMap = new Map([
        [tableHeaders[0], ["td:nth-child(1)", "number", true]],
        [tableHeaders[1], [".http-status", "number", true]],
        [tableHeaders[2], [".h1td", "text", true]],
        [tableHeaders[3], [".h1len", "number", true]],
        [tableHeaders[4], [".slug", "text", true]],
        [tableHeaders[5], [".meta", "text", true]],
        [tableHeaders[6], [".metalen", "number", true]],
        [tableHeaders[7], [".desc", "text", true]],
        [tableHeaders[8], [".desclen", "number", true]],
        [tableHeaders[9], [".canonical", "text", true]],
        [tableHeaders[10], [".indexing", "text", true]],
        [tableHeaders[11], [".last-crawl", "date", true]],
        [tableHeaders[12], [".rich-results", "text", true]],
        [tableHeaders[13], [".schema", "text", true]],
        [tableHeaders[14], [".sitemap", "text", true]]
    ]);
    [...columnSortMap].forEach(([header, configuration]) => {
        header.style.cursor = "pointer";
        header.addEventListener("click", () => {
            const [selector, type, ascending] = columnSortMap.get(header);
            sortRows(selector, type, ascending);
            columnSortMap.set(header, [selector, type, !ascending]);
            let counter = 1;
            [...tableBody.children].forEach(curr => {
                curr.querySelector("td:nth-child(1)").textContent = counter;
                counter++;
            });
        });
    });
    const currentLanguage = "{{ $language }}";
    const h1Field = `title_${currentLanguage}`;
    const metaField = `seo_title_${currentLanguage}`;
    const descriptionField = `seo_description_${currentLanguage}`;
    function trackField(row, selector, targetType, targetId, fieldName) {
        const cell = row.querySelector(selector);
        if (!cell) return;
        cell.addEventListener("input", () => {
            const key = `${targetType}:${targetId}`;
            const rowChanges = changes.get(key) || {
                type: targetType,
                id: targetId
            };
            rowChanges[fieldName] = cell.textContent.trim();
            changes.set(key, rowChanges);
            console.log(changes);
        });
    }
    allRowsArr.forEach(row => {
        const id = row.dataset.id;
        const type = row.getAttribute("rowType");
        if (!id) return;
        if (type === "listing") {
            const linkedPostId = Number(row.dataset.postId || 0);
            const listingH1Field = currentLanguage === "en" ? "title_en" : "title";
            if (linkedPostId > 0) {
                trackField(row, ".h1td .link", "post", linkedPostId, h1Field);
            } else {
                trackField(row, ".h1td .link", "listing", id, listingH1Field);
            }
            trackField(row, ".meta", "listing", id, metaField);
            trackField(row, ".desc", "listing", id, descriptionField);
            return;
        }
        if (!["post", "project"].includes(type)) return;
        trackField(row, ".h1td .link", type, id, h1Field);
        trackField(row, ".meta", type, id, metaField);
        trackField(row, ".desc", type, id, descriptionField);
    });
    confirmUpdateBtn.addEventListener("click", async () => {
        confirmationDialog.close();
        const changesJson = JSON.stringify([...changes.values()]);
        try {
            loading.style.display = "flex";
            loadingDiv.style.animation = "spin 4s linear infinite";
            loadingP.textContent = "Updating Fields...";
            const response = await fetch("{{ route('admin.metatagtool.update') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: changesJson
            });
            const data = await response.json();
            if (!response.ok || !data.success) {
                throw new Error(data.details || data.error || "Update failed");
            }
            changes.clear();
            loadingDiv.style.animation = "none";
            loadingP.textContent = data.message;
            setTimeout(() => {
                loading.style.display = "none";
                loadingP.textContent = "";
                loadingDiv.style.animation = "spin 4s linear infinite";
            }, 3000);
        } catch (error) {
            loading.style.display = "flex";
            loadingDiv.style.animation = "none";
            loadingP.textContent = "Error while updating: " + error.message;
            console.error(error);
        }
    });
</script>
<script src="https://accounts.google.com/gsi/client" onload="googleAuthLoaded()" async defer></script>
@endsection