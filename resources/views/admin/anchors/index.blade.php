@extends('admin.layouts.app', ["app_title" => "Internal Links Manager"])
@section('main_content')
<style>
button:not(.mass-update-close){
    background-color: #17a8a9;
    color: #fff;
    border-radius: 3px;
    border: none;
}
select {
    max-width: 10vw;
}
.content-anchors-table{
    table-layout:fixed;
    width:100%;
}
.content-anchors-table th:nth-child(1){
    width:75px;
}
 .content-anchors-table th:nth-child(2){
    width: 110px;
 }
.content-anchors-table th:nth-child(3){
    width:15%;
}
.content-anchors-table th:nth-child(4), .content-anchors-table th:nth-child(5){
    width:25%;
}
.content-anchors-table th:nth-child(7) {
    width: 12%;
}
.content-anchors-table th:nth-child(6), .content-anchors-table th:nth-child(8), .content-anchors-table th:nth-child(9), .content-anchors-table th:nth-child(10), .content-anchors-table th:nth-child(11){
    width:10%;
}
.content-anchors-table td{
    overflow-wrap:anywhere;
    word-break:break-word;
    vertical-align:top;
}
.content-anchors-table .anchor-url{
    direction:ltr;
    text-align:left;
    overflow-wrap:anywhere;
    word-break:break-all;
}
.nav-tabs-custom {
    margin-top: 1.5%;
}
.filters {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
}
.mass-update-popup{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.45);
    z-index:9999;
    align-items:center;
    justify-content:center;
}
.mass-update-popup-content{
    position:relative;
    background:#fff;
    padding:25px;
    width:400px;
    max-width:90%;
    border-radius:5px;
}
.mass-update-close{
    position:absolute;
    top:5px;
    right:10px;
    border:0;
    background:none;
    font-size:24px;
}
.content-anchors-table tr.currently-crawling > td{
    background-color:#fff3cd !important;
    transition:background-color 0.2s;
}
</style>
<script>
const projectTitles = {
    "saray-kent": "سراي كينت كوناكلاري",
    "tual-comfort": "توال كومفورت",
    "florya-park": "فلوريا بارك ريزيدنس",
    "yesilpinar-evleri": "يشيل بينار إفلري",
    "kiptas-kiraz": "كيبتاش كيراز إفلري",
    "vira-istanbul": "فيرا إسطنبول",
    "ritz-carlton": "ريتز كارلتون ريزيدنسز",
    "taksim-360": "تقسيم 360",
    "g-rotana": "جي روتانا",
    "propa-vista": "بروبا فيستا",
    "alize-kapadokya": "أليزه كابادوكيا",
    "deluxia-park-business": "ديلوكسيا بارك بيزنس",
    "collet-avcilar": "كوليت أفجيلار",
    "marina-yasam": "مارينا ياشام كوناكلاري",
    "strada": "سترادا",
    "iz-marin-konaklari": "إز مارين كوناكلاري",
    "agaoglu-cekmekoy-park": "آغا أوغلو تشكمه كوي بارك",
    "selenium-park": "سيلينيوم بارك",
    "kirimli-elite": "كيريملي إيليت",
    "gunesli-homes": "غونيشلي هومز",
    "kalamis-adalar": "كالاميش أدالار",
    "mina-towers": "مينا تاورز",
    "avrupa-saklivadi": "أفروبا كونوتلاري ساكلي فادي",
    "avrupa-yamanevleri": "أفروبا كونوتلاري يامان إفلري",
    "boutique-panorama": "بوتيك بانوراما",
    "lifes-hill": "لايفز هيل أيوب",
    "ses-port": "سيس بورت",
    "vaat-express": "فات إكسبريس",
    "lotus-yali": "لوتس يالي",
    "vaat-center": "فات سنتر",
    "ses-park": "سيس بارك",
    "favorist-alkent": "فافوريست ألكنت",
    "meydan-residence": "ميدان ريزيدنس",
    "kilic-life-maslak": "كيليتش لايف مسلك",
    "dap-teras-kule": "داب تيراس كوله",
    "real-merter": "ريال ميرتر",
    "empire-avcilar": "إمباير أفجيلار",
    "siltas-panorama": "سيلتاش بانوراما",
    "bakirci-topkapi": "باكيرجي توبكابي",
    "buyukyali": "بويوك يالي",
    "artea-bahcesehir": "أرتيا بهتشه شهير",
    "acibadem-konaklari": "أجيبادم كوناكلاري",
    "rotana-bomonti": "روتانا بومونتي",
    "istown": "إستاون",
    "pera-blue": "بيرا بلو ريزيدنس",
    "metro-home": "مترو هوم",
    "mest-istanbul": "مست إسطنبول",
    "no-27-residence": "نو 27 ريزيدنس",
    "asoy-plaza-9": "أسوي بلازا 9",
    "yakapark": "ياكا بارك",
    "asfor-kartal": "أسفور كارتال",
    "deluxia-park-residence": "ديلوكسيا بارك ريزيدنس",
    "ebruli": "إبرولي",
    "benesta-podio": "بينيستا بوديو بهتشلي إفلر",
    "marmarin-elite": "مارمارين إيليت",
    "queen-bomonti": "كوين بومونتي",
    "motivada-residence": "موتيفادا ريزيدنس بومونتي",
    "nisantasi-koru": "نيشانتاشي كورو",
    "anthill-bomonti": "أنثيل بومونتي",
    "nurol-tower": "نورول تاور",
    "city-center": "سيتي سنتر",
    "self-istanbul": "سيلف إسطنبول",
    "delta-dubai-comfort": "دلتا دبي كومفورت",
    "burc-istanbul": "بورج إسطنبول",
    "anka-avcilar": "أنكا أفجيلار",
    "lake-terrace-vilage": "ليك تيراس فيليج",
    "the-cruise-collection": "ذا كروز كوليكشن",
    "riverside-villa": "ريفرسايد فيلا",
    "four-seasons": "فور سيزونز",
    "lake-city": "ليك سيتي",
    "alpis-nilufer-house-2": "ألبيش نيلوفر هاوس 2",
    "alpis-nilufer-house-1": "ألبيش نيلوفر هاوس 1",
    "downtown-bursa": "داون تاون بورصة",
    "evinpark-kemerburgaz": "إيفين بارك كيمربورغاز",
    "alya-dream": "أليا دريم",
    "flores-konaklari": "فلوريس كوناكلاري توبكابي",
    "ramada-hotel": "رمادا هوتيل آند سويتس",
    "bizim-evler-guzelce": "بيزيم إفلر غوزلجه",
    "yasemin-evleri": "ياسمين إفلري",
    "sea-pearl": "سي بيرل",
    "referans-kartal-loca": "ريفيرانس كارتال لوجا",
    "kosuyolu-koru": "كوشويولو كورو إفلري",
    "bab-istanbul": "باب إسطنبول",
    "demir-life": "دمير لايف",
    "modernyaka": "مودرن ياكا"
};
</script>
<?php
    $group_by = isset($_GET['group_by']) ? $_GET['group_by'] : 'none';
    $anchors = [];
    $action_cta_exceptions = [
        'https://damas.net/whatsapp_share'
    ];
    $source_labels_by_url = [];
    $classify_source_type = function ($url) use (&$source_labels_by_url) {
        if (isset($source_labels_by_url[$url])) {
            return $source_labels_by_url[$url];
        }
        $path = (string)parse_url(trim($url), PHP_URL_PATH);
        foreach ([
            'Guides' => 'blog|guides', 'News' => 'news',
            'Developers' => 'developers', 'Reports' => 'reports'
        ] as $label => $segments) {
            if (preg_match('#/(?:' . $segments . ')(?:/|$)#i', $path)) {
                return $label;
            }
        }
        return 'General';
    };
    $classify_source_types = function ($urls) use ($classify_source_type) {
        $types = [];
        foreach ($urls as $url) {
            $type = $classify_source_type($url);
            if ($type !== null) {
                $types[$type] = true;
            }
        }
        return array_keys($types);
    };
    $classify_link = function ($href) use ($action_cta_exceptions) {
        $href = trim($href);
        foreach ($action_cta_exceptions as $exception) {
            if ($exception !== '' && strpos($href, $exception) === 0) {
                return 'Action / CTA';
            }
        }
        if ($href === '' || strpos($href, '#') === 0 || preg_match('/^(tel:|mailto:|javascript:)/i', $href)) {
            return 'Action / CTA';
        }
        if (preg_match('/^(https?:\/\/)?([^\/]+\.)?damas\.net(\/|$)/i', $href)) {
            return 'Internal';
        }
        if (preg_match('/^https?:\/\//i', $href)) {
            return 'External';
        }
        return 'Action / CTA';
    };
    $link_statuses = [];
    foreach (\DB::table('links_status')->get() as $link_status) {
        $raw_status = trim((string) $link_status->status);
        $decoded_status = json_decode($raw_status, true);
        if (is_array($decoded_status)) {
            $link_statuses[$link_status->link] = json_encode(array_values($decoded_status));
        } elseif (preg_match('/^\d+$/', $raw_status)) {
            $link_statuses[$link_status->link] = json_encode([(int) $raw_status]);
        } else {
            $link_statuses[$link_status->link] = null;
        }
    }
    $status_label = function ($status) {
        if ($status === null || $status === '') {
            return 'Not checked';
        }
        $chain = json_decode($status, true);
        if (!is_array($chain)) {
            return (string) $status;
        }
        return implode(' → ', $chain);
    };
    $status_final = function ($status) {
        if ($status === null || $status === '') {
            return null;
        }
        $chain = json_decode($status, true);
        if (!is_array($chain) || empty($chain)) {
            return null;
        }
        return (int) end($chain);
    };
    $content_field = @$_GET['lang'] == 'en' ? 'content_en' : 'content_ar';
    $content_name = @$_GET['lang'] == 'en' ? 'Content English' : 'Content Arabic';
    $title_field = @$_GET['lang'] == 'en' ? 'title_en' : 'title_ar';
    $search_column = isset($_GET['search_column']) ? $_GET['search_column'] : '';
    $search_value = isset($_GET['search_value']) ? trim($_GET['search_value']) : '';
    $search_mode = isset($_GET['search_mode']) && in_array($_GET['search_mode'], ['substring', 'exact']) ? $_GET['search_mode'] : '';
    $searchable_columns = ['text', 'url', 'web_url', 'admin_url', 'link_type', 'status', 'updated_at', 'count'];
    if (!in_array($search_column, $searchable_columns)) {
        $search_column = '';
    }
    $matches_search_value = function ($candidate, $value, $mode) {
        $candidate = (string) $candidate;
        $value = (string) $value;
        if ($mode == 'exact') {
            return strcasecmp($candidate, $value) === 0;
        }
        return stripos($candidate, $value) !== false;
    };
    $matches_search = function ($row, $column, $value, $mode) use ($matches_search_value, $status_label) {
        if ($value === '') {
            return true;
        }
        $values = [];
        if ($column == 'all') {
            $values = [
                isset($row['text']) ? $row['text'] : '',
                isset($row['url']) ? $row['url'] : '',
                isset($row['web_url']) ? $row['web_url'] : '',
                isset($row['admin_url']) ? $row['admin_url'] : '',
                isset($row['source_type']) ? $row['source_type'] : '',
                isset($row['link_type']) ? $row['link_type'] : '',
                isset($row['status']) && $row['status'] !== null ? $row['status'] : 'Not checked',
                isset($row['updated_at']) ? $row['updated_at'] : '',
                isset($row['updated_at']) && $row['updated_at'] !== '' ? date('d M Y', strtotime($row['updated_at'])) : ''
            ];
            if (isset($row['web_urls']) && is_array($row['web_urls'])) {
                foreach ($row['web_urls'] as $row_web_url) {
                    $values[] = $row_web_url;
                }
            }
        } else {
            if ($column == 'status') {
                $values[] = isset($row['status']) && $row['status'] !== null ? $status_label($row['status']) : 'Not checked';
            } elseif ($column == 'updated_at') {
                $raw_date = isset($row['updated_at']) ? $row['updated_at'] : '';
                $values[] = $raw_date;
                if ($raw_date !== '') {
                    $values[] = date('d M Y', strtotime($raw_date));
                }
            } elseif ($column == 'web_url') {
                if (isset($row['web_urls']) && is_array($row['web_urls'])) {
                    $values = $row['web_urls'];
                } else {
                    $values[] = isset($row['web_url']) ? $row['web_url'] : '';
                }
            } else {
                $values[] = isset($row[$column]) ? $row[$column] : '';
            }
        }
        foreach ($values as $candidate) {
            if ($matches_search_value($candidate, $value, $mode)) {
                return true;
            }
        }
        return false;
    };
    $arabic_count = 0;
    $english_count = 0;
    $source_type_filter = isset($_GET['source_type']) ? $_GET['source_type'] : 'all';
    $countries = \App\Models\Country::ordered()->get();
    $country_ids = [];
    $country_aliases = [];
    foreach ($countries as $country) {
        $country_ids[(string)$country->id] = true;
        foreach ([$country->code, $country->slug] as $alias) {
            if ((string)$alias !== '') {
                $country_aliases[(string)$alias] = (string)$country->id;
            }
        }
    }
    $selected_country = isset($_GET['country']) && is_string($_GET['country']) ? $_GET['country'] : 'all';
    if (isset($country_aliases[$selected_country])) {
        $selected_country = $country_aliases[$selected_country];
    }
    if ($selected_country !== 'all' && $selected_country !== 'global' && !isset($country_ids[$selected_country])) {
        $selected_country = 'all';
    }
    $_GET['country'] = $selected_country;
    $source_type_options = [
        'guides' => ['Guides'], 'news' => ['News'],
        'developers' => ['Developers'], 'reports' => ['Reports'],
        'listing' => ['Countries', 'Cities', 'Districts'],
        'country' => ['Countries'], 'city' => ['Cities'], 'region' => ['Districts'],
        'general' => ['General'], 'project' => ['Projects']
    ];
    $owner_sources = [];
    foreach (\App\Models\Post::with('countryRel')->orderBy('id')->get() as $record) {
        $post_type = $record->postTypeEnum();
        $owner_sources[] = [
            'owner_type' => 'post', 'record' => $record, 'field_prefix' => 'content',
            'country_id' => $record->countryRel ? (string)$record->countryRel->id : 'global',
            'label' => $post_type->label(), 'url_method' => 'frontUrl',
            'admin_url' => route($post_type->adminListRoute() . '.edit', $record->id)
        ];
    }
    foreach (\App\Models\Project::with(['city.countryRel', 'region'])->orderBy('id')->get() as $record) {
        foreach ([
            'intro_location' => ['Overview', null],
            'location' => ['Location', 'getLocation'],
            'governmental' => ['Government', 'getGovernmental'],
            'transportation' => ['Transportation', 'getTransportation'],
            'future_look' => ['Future Look', 'getFutureLook']
        ] as $prefix => $section) {
            $owner_sources[] = [
                'owner_type' => 'project', 'record' => $record, 'field_prefix' => $prefix,
                'field_label' => $section[0], 'inherited_method' => $section[1],
                'country_id' => $record->city && $record->city->countryRel
                    ? (string)$record->city->countryRel->id : 'global',
                'label' => 'Projects', 'url_method' => 'frontUrl',
                'admin_url' => route('admin.projects.edit', $record->id)
            ];
        }
    }
    foreach ([
        'country' => [$countries, 'content', 'Countries', 'countries'],
        'city' => [\App\Models\City::with('countryRel')->get(), 'about', 'Cities', 'cities'],
        'region' => [\App\Models\Region::with('city.countryRel')->get(), 'about', 'Districts', 'regions']
    ] as $owner_type => $config) {
        foreach ($config[0] as $record) {
            if (!$record->slug) {
                continue;
            }
            if ($owner_type === 'country') {
                $country_id = (string)$record->id;
            } elseif ($owner_type === 'city') {
                $country_id = $record->countryRel ? (string)$record->countryRel->id : 'global';
            } else {
                $country_id = $record->city && $record->city->countryRel
                    ? (string)$record->city->countryRel->id : 'global';
            }
            $owner_sources[] = [
                'owner_type' => $owner_type, 'record' => $record, 'field_prefix' => $config[1],
                'country_id' => $country_id, 'label' => $config[2], 'url_method' => 'listingUrl',
                'admin_url' => route('admin.' . $config[3] . '.edit', $record->id)
            ];
        }
    }
    // Availability comes from records in this country/mode, independently of the
    // chosen type, language, anchor text or link filters.
    $available_source_labels = [];
    foreach ($owner_sources as $source) {
        if (($selected_country !== 'all' && $source['country_id'] !== $selected_country)
            || ($group_by === 'disabled_blogs'
                && ($source['owner_type'] !== 'post' || (int)$source['record']->published !== 0))) {
            continue;
        }
        $available_source_labels[$source['label']] = true;
    }
    $source_type_labels = [];
    foreach ([
        'guides' => 'Guides', 'news' => 'News', 'developers' => 'Developers', 'reports' => 'Reports',
        'project' => 'Projects', 'listing' => 'All Search Pages', 'country' => 'Countries',
        'city' => 'Cities', 'region' => 'Districts', 'general' => 'General'
    ] as $type => $label) {
        if (array_intersect($source_type_options[$type], array_keys($available_source_labels))) {
            $source_type_labels[$type] = $label;
        }
    }
    if (!is_string($source_type_filter) || !isset($source_type_labels[$source_type_filter])) {
        $source_type_filter = 'all';
    }
    $_GET['source_type'] = $source_type_filter;
    $matches_source_type = function ($types) use ($source_type_filter, $source_type_options) {
        return $source_type_filter === 'all'
            || count(array_intersect($types, $source_type_options[$source_type_filter])) > 0;
    };
    $collect_anchors = function ($language) use ($owner_sources, $selected_country, $group_by, $link_statuses, $classify_link, &$source_labels_by_url) {
        $result = [];
        $inherited_sections = [];
        foreach ($owner_sources as $source) {
            $record = $source['record'];
            if ($group_by === 'disabled_blogs'
                && ($source['owner_type'] !== 'post' || (int)$record->published !== 0)) {
                continue;
            }
            if ($selected_country !== 'all' && $source['country_id'] !== $selected_country) {
                continue;
            }
            $field = $source['field_prefix'] . '_' . $language;
            if ((string)$record->$field === '') {
                continue;
            }
            // These project sections are fallbacks. Do not present an override
            // from a district (or its linked post) as editable project content.
            if (!empty($source['inherited_method']) && $record->region) {
                $key = $record->region->id . '|' . $field;
                if (!array_key_exists($key, $inherited_sections)) {
                    $method = $source['inherited_method'];
                    $inherited_sections[$key] = (string)$record->region->$method($language) !== '';
                }
                if ($inherited_sections[$key]) {
                    continue;
                }
            }
            try {
                $method = $source['url_method'];
                $web_url = $record->$method();
            } catch (\Exception $error) {
                continue;
            }
            if (!$web_url) {
                continue;
            }
            $path = (string)parse_url($web_url, PHP_URL_PATH);
            $path = preg_replace('#^/(?:ar|en)(?=/|$)#i', '', $path);
            $web_url = url($language . '/' . ltrim($path, '/'));
            $source_labels_by_url[$web_url] = $source['label'];
            $title_field = ($source['owner_type'] === 'post' ? 'title_' : 'name_') . $language;
            $html = html_entity_decode((string)$record->$field, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            preg_match_all('/<a\b[^>]*>.*?<\/a\s*>/isu', $html, $matches);
            foreach ($matches[0] as $index => $raw_anchor) {
                $dom = new \DOMDocument();
                $previous_errors = libxml_use_internal_errors(true);
                $dom->loadHTML('<?xml encoding="UTF-8"><body>' . $raw_anchor . '</body>');
                libxml_clear_errors();
                libxml_use_internal_errors($previous_errors);
                $link = $dom->getElementsByTagName('a')->item(0);
                if (!$link) {
                    continue;
                }
                $href = trim($link->getAttribute('href'));
                $text = trim($link->textContent);
                $display_text = $text;
                if ($text === '') {
                    $child_name = null;
                    foreach ($link->childNodes as $child) {
                        if ($child->nodeType === XML_ELEMENT_NODE) {
                            $child_name = $child->nodeName;
                            break;
                        }
                    }
                    $display_text = $child_name ? '[<' . $child_name . '>]' : '[Empty Anchor]';
                }
                $result[] = [
                    'text' => $display_text, 'original_text' => $text, 'url' => $href,
                    'owner_type' => $source['owner_type'], 'owner_id' => (int)$record->id,
                    'content_field' => $field, 'anchor_index' => $index, 'signature' => sha1($raw_anchor),
                    'admin_url' => $source['admin_url'], 'web_url' => $web_url, 'web_urls' => [$web_url],
                    'source_type' => $source['label'], 'source_types' => [$source['label']],
                    'source_title' => (string)$record->$title_field,
                    'content' => (isset($source['field_label']) ? $source['field_label'] : 'Content')
                        . ($language === 'en' ? ' English' : ' Arabic'),
                    'link_type' => $classify_link($href),
                    'status' => isset($link_statuses[$href]) ? $link_statuses[$href] : null,
                    'updated_at' => (string)($record->updated_at ?: $record->created_at)
                ];
            }
        }
        return $result;
    };
    $anchors = $collect_anchors(@$_GET['lang'] === 'en' ? 'en' : 'ar');
    $sort = @$_GET['sort'];
    $order = @$_GET['order'] == 'desc' ? 'desc' : 'asc';
    if ($sort == 'link_type') {
        usort($anchors, function ($a, $b) use ($order) {
            $comparison = strcmp($a['link_type'], $b['link_type']);
            return $order == 'asc' ? $comparison : -$comparison;
        });
    } elseif ($sort == 'target_query') {
        usort($anchors, function ($a, $b) use ($order) {
            $comparison = strcasecmp($a['text'], $b['text']);
            return $order == 'asc' ? $comparison : -$comparison;
        });
    }
    if (@$_GET['link_type'] == 'internal') {
        $anchors = array_filter($anchors, function ($anchor) {
            return $anchor['link_type'] == 'Internal';
        });
    } elseif (@$_GET['link_type'] == 'external') {
        $anchors = array_filter($anchors, function ($anchor) {
            return $anchor['link_type'] == 'External';
        });
    } elseif (@$_GET['link_type'] == 'action_cta') {
        $anchors = array_filter($anchors, function ($anchor) {
            return $anchor['link_type'] == 'Action / CTA';
        });
    }
    $anchors = array_filter($anchors, function ($anchor) use ($matches_source_type) {
        return $matches_source_type($anchor['source_types']);
    });
    $available_statuses = [];
    $has_not_checked = false;
    foreach ($anchors as $anchor) {
        if ($anchor['status'] === null) {
            $has_not_checked = true;
            continue;
        }
        $label = $status_label($anchor['status']);
        $available_statuses[$label] = true;
    }
    $available_statuses = array_keys($available_statuses);
    sort($available_statuses, SORT_NATURAL);
    if (@$_GET['status_filter'] == 'not_checked') {
        $anchors = array_filter($anchors, function ($anchor) {
            return $anchor['status'] === null;
        });
    } elseif (isset($_GET['status_filter']) && $_GET['status_filter'] !== 'all' && $_GET['status_filter'] !== '') {
        $selected_status = $_GET['status_filter'];
        $anchors = array_filter($anchors, function ($anchor) use ($selected_status, $status_label) {
            return $anchor['status'] !== null && $status_label($anchor['status']) === $selected_status;
        });
    }
    
    if ($search_value !== '' && $search_column != 'count') {
        $anchors = array_filter($anchors, function ($anchor) use ($matches_search, $search_column, $search_value, $search_mode) {
            return $matches_search($anchor, $search_column, $search_value, $search_mode);
        });
    }
    if ($sort == 'status') {
        usort($anchors, function ($a, $b) use ($order, $status_final) {
            $status_a = $status_final($a['status']);
            $status_b = $status_final($b['status']);
            $status_a = $status_a === null ? 999 : $status_a;
            $status_b = $status_b === null ? 999 : $status_b;
            $comparison = $status_a <=> $status_b;
            return $order == 'asc' ? $comparison : -$comparison;
        });
    }
    $groupable_columns = ['text', 'url', 'web_url', 'link_type', 'status', 'disabled_blogs'];
    $count_language_rows = function ($language_field) use ($collect_anchors, $group_by, $groupable_columns, $matches_search, $matches_search_value, $search_column, $search_value, $search_mode, $status_label, $matches_source_type) {
        $row_count = 0;
        $group_counts = [];
        $language = $language_field === 'content_en' ? 'en' : 'ar';
        foreach ($collect_anchors($language) as $row) {
            if (!$matches_source_type($row['source_types'])) {
                continue;
            }
            $wanted_link_type = ['internal' => 'Internal', 'external' => 'External', 'action_cta' => 'Action / CTA'];
            if (isset($wanted_link_type[@$_GET['link_type']]) && $row['link_type'] !== $wanted_link_type[$_GET['link_type']]) {
                continue;
            }
            if (@$_GET['status_filter'] === 'not_checked' && $row['status'] !== null) {
                continue;
            }
            $selected_status = isset($_GET['status_filter']) ? $_GET['status_filter'] : 'all';
            if ($selected_status !== 'all' && $selected_status !== '' && $selected_status !== 'not_checked'
                && ($row['status'] === null || $status_label($row['status']) !== $selected_status)) {
                continue;
            }
            if ($search_value !== '' && $search_column !== 'count' && !$matches_search($row, $search_column, $search_value, $search_mode)) {
                continue;
            }
            if ($group_by === 'none' || !in_array($group_by, $groupable_columns, true)) {
                if ($search_column !== 'count' || $search_value === '' || $matches_search_value('1', $search_value, $search_mode)) {
                    $row_count++;
                }
                continue;
            }
            if (in_array($group_by, ['web_url', 'disabled_blogs'], true)) {
                $keys = $row['web_urls'];
            } elseif ($group_by === 'status') {
                $keys = [$row['status'] === null ? '__NOT_CHECKED__' : $row['status']];
            } else {
                $keys = [$row[$group_by]];
            }
            foreach ($keys as $key) {
                if ($search_column === 'web_url' && $search_value !== '' && !$matches_search_value($key, $search_value, $search_mode)) {
                    continue;
                }
                $group_counts[(string)$key] = isset($group_counts[(string)$key]) ? $group_counts[(string)$key] + 1 : 1;
            }
        }
        if ($group_by === 'none' || !in_array($group_by, $groupable_columns, true)) {
            return $row_count;
        }
        if ($search_column === 'count' && $search_value !== '') {
            return count(array_filter($group_counts, function ($count) use ($matches_search_value, $search_value, $search_mode) {
                return $matches_search_value($count, $search_value, $search_mode);
            }));
        }
        return count($group_counts);
    };
    $arabic_count = $count_language_rows('content_ar');
    $english_count = $count_language_rows('content_en');
    $display_rows = [];
    if ($group_by != 'none' && in_array($group_by, $groupable_columns)) {
        $groups = [];
        foreach ($anchors as $anchor) {
            if (in_array($group_by, ['web_url', 'disabled_blogs'])) {
                $anchor_web_urls = isset($anchor['web_urls']) && is_array($anchor['web_urls']) ? $anchor['web_urls'] : [$anchor['web_url']];
                foreach ($anchor_web_urls as $source_url) {
                    if ($search_column == 'web_url' && $search_value !== '' && !$matches_search_value($source_url, $search_value, $search_mode)) {
                        continue;
                    }
                    $grouped_anchor = $anchor;
                    $grouped_anchor['web_url'] = $source_url;
                    $grouped_anchor['web_urls'] = [$source_url];
                    $grouped_source_type = $classify_source_type($source_url);
                    if ($grouped_source_type !== null) {
                        $grouped_anchor['source_type'] = $grouped_source_type;
                        $grouped_anchor['source_types'] = [$grouped_source_type];
                    }
                    if (!isset($groups[$source_url])) {
                        $groups[$source_url] = [];
                    }
                    $groups[$source_url][] = $grouped_anchor;
                }
                continue;
            }
            $group_value = $anchor[$group_by];
            if ($group_by == 'status' && $group_value === null) {
                $group_value = '__NOT_CHECKED__';
            }
            $group_key = $group_value === null ? '' : (string) $group_value;
            if (!isset($groups[$group_key])) {
                $groups[$group_key] = [];
            }
            $groups[$group_key][] = $anchor;
        }
        foreach ($groups as $items) {
            $unique_texts = [];
            $unique_urls = [];
            $unique_sources = [];
            $unique_admin_urls = [];
            $unique_contents = [];
            $unique_link_types = [];
            $unique_statuses = [];
            $unique_dates = [];
            foreach ($items as $item) {
                $unique_texts[(string) $item['text']] = true;
                $unique_urls[(string) $item['url']] = true;
                $item_web_urls = isset($item['web_urls']) && is_array($item['web_urls']) ? $item['web_urls'] : [$item['web_url']];
                foreach ($item_web_urls as $item_web_url) {
                    $unique_sources[(string) $item_web_url] = true;
                }
                $unique_admin_urls[(string) $item['admin_url']] = true;
                $unique_contents[(string) $item['content']] = true;
                $unique_link_types[(string) $item['link_type']] = true;
                $unique_statuses[$item['status'] === null ? '__NOT_CHECKED__' : (string) $item['status']] = true;
                $unique_dates[(string) $item['updated_at']] = true;
            }
            $display_rows[] = [
                'count' => count($items),
                'items' => $items,
                'anchor' => $items[0],
                'unique_texts' => count($unique_texts),
                'unique_urls' => count($unique_urls),
                'unique_sources' => count($unique_sources),
                'unique_admin_urls' => count($unique_admin_urls),
                'unique_contents' => count($unique_contents),
                'unique_link_types' => count($unique_link_types),
                'unique_statuses' => count($unique_statuses),
                'unique_dates' => count($unique_dates)
            ];
        }
    } else {
        foreach ($anchors as $anchor) {
            $display_rows[] = [
                'count' => 1,
                'items' => [$anchor],
                'anchor' => $anchor,
                'unique_texts' => 1,
                'unique_urls' => 1,
                'unique_sources' => isset($anchor['web_urls']) && is_array($anchor['web_urls']) ? count($anchor['web_urls']) : 1,
                'unique_admin_urls' => 1,
                'unique_contents' => 1,
                'unique_link_types' => 1,
                'unique_statuses' => 1,
                'unique_dates' => 1
            ];
        }
    }
    if ($search_value !== '' && $search_column == 'count') {
        $display_rows = array_filter($display_rows, function ($row) use ($search_value, $search_mode, $matches_search_value) {
            return $matches_search_value($row['count'], $search_value, $search_mode);
        });
    }
    if (in_array($group_by, ['web_url', 'disabled_blogs'])) {
        foreach ($display_rows as &$row) {
            $seen_anchor_pairs = [];
            $duplicate_count = 0;
            foreach ($row['items'] as $item) {
                $duplicate_key = (string) $item['text'] . "\x1F" . (string) $item['url'];
                if (isset($seen_anchor_pairs[$duplicate_key])) {
                    $duplicate_count++;
                } else {
                    $seen_anchor_pairs[$duplicate_key] = true;
                }
            }
            $row['duplicate_count'] = $duplicate_count;
        }
        unset($row);
    }
    if ($sort == 'count') {
        usort($display_rows, function ($a, $b) use ($order) {
            $comparison = $a['count'] <=> $b['count'];
            return $order == 'asc' ? $comparison : -$comparison;
        });
    } elseif ($sort == 'duplicates' && in_array($group_by, ['web_url', 'disabled_blogs'])) {
        usort($display_rows, function ($a, $b) use ($order) {
            $comparison = $a['duplicate_count'] <=> $b['duplicate_count'];
            return $order == 'asc' ? $comparison : -$comparison;
        });
    }
    $displayed_urls = [];
    foreach ($display_rows as $row) {
        foreach ($row['items'] as $item) {
            $url = trim($item['url']);
            if ($url === '' || !preg_match('/^https?:\/\//i', $url)) {
                continue;
            }
            $displayed_urls[] = $url;
        }
    }
?>
<div id="anchors-page">
    <div class="filters">
        <button type="button" id="update-project-anchor-texts" class="btn btn-warning" style="display:none;">
            Update Project Anchor Texts
        </button>
        <select id="country-filter" onchange="window.location.href='?country='+this.value+'&lang=<?= @$_GET['lang'] == 'en' ? 'en' : 'ar' ?>&source_type=<?= urlencode($source_type_filter) ?>&link_type=<?= @$_GET['link_type'] ?: 'all' ?>&status_filter=<?= @$_GET['status_filter'] ?: 'all' ?>&group_by=<?= @$_GET['group_by'] ?: 'none' ?>&search_column=<?= urlencode($search_column) ?>&search_mode=<?= urlencode($search_mode) ?>&search_value=<?= urlencode($search_value) ?>'">
            <option value="all" <?= empty($_GET['country']) || $_GET['country'] == 'all' ? 'selected' : '' ?>>All Countries</option>
            @foreach($countries as $country)
            <option value="{{ $country->id }}" <?= $selected_country === (string)$country->id ? 'selected' : '' ?>>{{ $country->name_en ?: $country->name_ar }}</option>
            @endforeach
            <option value="global" <?= $selected_country === 'global' ? 'selected' : '' ?>>Global / Unassigned</option>
        </select>
        <?php $source_type_filter = isset($_GET['source_type']) ? $_GET['source_type'] : 'all'; ?>
        <select onchange="window.location.href='?country=<?= @$_GET['country'] ?: 'all' ?>&lang=<?= @$_GET['lang'] == 'en' ? 'en' : 'ar' ?>&source_type='+this.value+'&link_type=<?= @$_GET['link_type'] ?: 'all' ?>&status_filter=<?= @$_GET['status_filter'] ?: 'all' ?>&group_by=<?= @$_GET['group_by'] ?: 'none' ?>&search_column=<?= urlencode($search_column) ?>&search_mode=<?= urlencode($search_mode) ?>&search_value=<?= urlencode($search_value) ?>'">
            <option value="all" <?= $source_type_filter == 'all' ? 'selected' : '' ?>>All Types</option>
            <?php foreach ($source_type_labels as $type_value => $type_label): ?>
            <option value="<?= $type_value ?>" <?= $source_type_filter === $type_value ? 'selected' : '' ?>><?= $type_label ?></option>
            <?php endforeach; ?>
        </select>
        <select onchange="window.location.href='?country=<?= @$_GET['country'] ?: 'all' ?>&lang=<?= @$_GET['lang'] == 'en' ? 'en' : 'ar' ?>&source_type=<?= urlencode($source_type_filter) ?>&link_type=<?= @$_GET['link_type'] ?: 'all' ?>&status_filter='+this.value+'&group_by=<?= @$_GET['group_by'] ?: 'none' ?>&search_column=<?= urlencode($search_column) ?>&search_mode=<?= urlencode($search_mode) ?>&search_value=<?= urlencode($search_value) ?>'">
            <option value="all" <?= empty($_GET['status_filter']) || $_GET['status_filter'] == 'all' ? 'selected' : '' ?>>All HTTP</option>
            <?php if ($has_not_checked): ?>
                <option value="not_checked" <?= @$_GET['status_filter'] == 'not_checked' ? 'selected' : '' ?>>Not checked</option>
            <?php endif; ?>
            <?php foreach ($available_statuses as $status): ?>
                <option value="<?= $status ?>" <?= isset($_GET['status_filter']) && (string) $_GET['status_filter'] === (string) $status ? 'selected' : '' ?>>
                    <?= $status ?>
                </option>
            <?php endforeach; ?>
        </select>
        <select onchange="window.location.href='?country='+document.getElementById('country-filter').value+'&lang=<?= @$_GET['lang'] == 'en' ? 'en' : 'ar' ?>&source_type=<?= urlencode($source_type_filter) ?>&link_type='+this.value+'&status_filter=<?= @$_GET['status_filter'] ?: 'all' ?>&group_by=<?= @$_GET['group_by'] ?: 'none' ?>&search_column=<?= urlencode($search_column) ?>&search_mode=<?= urlencode($search_mode) ?>&search_value=<?= urlencode($search_value) ?>'">
            <option value="all" <?= !in_array(@$_GET['link_type'], ['internal', 'external', 'action_cta', 'without_cta']) ? 'selected' : '' ?>>All Links</option>
            <option value="internal" <?= @$_GET['link_type'] == 'internal' ? 'selected' : '' ?>>Internal</option>
            <option value="external" <?= @$_GET['link_type'] == 'external' ? 'selected' : '' ?>>External</option>
            <option value="action_cta" <?= @$_GET['link_type'] == 'action_cta' ? 'selected' : '' ?>>Action / CTA</option>
        </select>
        <select onchange="window.location.href='?country=<?= @$_GET['country'] ?: 'all' ?>&lang=<?= @$_GET['lang'] == 'en' ? 'en' : 'ar' ?>&source_type=<?= urlencode($source_type_filter) ?>&link_type=<?= @$_GET['link_type'] ?: 'all' ?>&status_filter=<?= @$_GET['status_filter'] ?: 'all' ?>&group_by='+this.value+'&search_column=<?= urlencode($search_column) ?>&search_mode=<?= urlencode($search_mode) ?>&search_value=<?= urlencode($search_value) ?>'">
            <option value="none" <?= empty($_GET['group_by']) || $_GET['group_by'] == 'none' ? 'selected' : '' ?>>No Grouping</option>
            <option value="text" <?= @$_GET['group_by'] == 'text' ? 'selected' : '' ?>>Target Query</option>
            <option value="url" <?= @$_GET['group_by'] == 'url' ? 'selected' : '' ?>>Target URL</option>
            <option value="web_url" <?= @$_GET['group_by'] == 'web_url' ? 'selected' : '' ?>>Source URL</option>
            <option value="disabled_blogs" <?= @$_GET['group_by'] == 'disabled_blogs' ? 'selected' : '' ?>>Disabled Posts</option>
            <option value="link_type" <?= @$_GET['group_by'] == 'link_type' ? 'selected' : '' ?>>Link Type</option>
            <option value="status" <?= @$_GET['group_by'] == 'status' ? 'selected' : '' ?>>HTTP</option>
        </select>
        <button id="update-link-statuses-button" type="button" class="btn btn-primary btn-sm" onclick="updateLinkStatuses()">
            <i class="fa fa-refresh"></i> Update HTTP
        </button>
        <button type="button" id="export-anchors-csv" class="btn btn-default btn-sm">
            <i class="fa fa-download"></i> Export CSV
        </button>
        <button type="button" id="mass-update-open-button" style="display:none;">Mass Update</button>
        <div id="mass-update-popup" class="mass-update-popup" style="display:none;">
            <div class="mass-update-popup-content">
                <button type="button" id="mass-update-close-button" class="mass-update-close">&times;</button>
                <select id="mass-update-dropdown">
                    <option value="nothing">Mass Update</option>
                    <option value="edit-text">Edit Target Query</option>
                    <option value="edit-target-url">Edit Target URL</option>
                    <option value="keep-text">Remove Target URL Only</option>
                    <option value="remove-completely" style="color:red;font-weight:700;">Remove Target Query & URL</option>
                </select>
                <p id="mass-update-message" style="margin-top:5%"></p>
                <input type="text" style="display:none;" id="mass-update-input">
                <p id="mass-update-error" style="margin-top:5%;"></p>
                <button type="button" id="mass-update-submit-button" style="margin-top:5%">Update</button>
            </div>
        </div>
        <div id="anchors-search" style="display:flex;align-items:center;gap:5px;margin:0;">
            <select id="search-column" onchange="updateSearchControls()">
                <option value="">Select Column</option>
                <option value="text" <?= $search_column == 'text' ? 'selected' : '' ?>>Target Query</option>
                <option value="url" <?= $search_column == 'url' ? 'selected' : '' ?>>Target URL</option>
                <option value="web_url" <?= $search_column == 'web_url' ? 'selected' : '' ?>>Source URL</option>
                <option value="admin_url" <?= $search_column == 'admin_url' ? 'selected' : '' ?>>Edit Admin</option>
                <option value="link_type" <?= $search_column == 'link_type' ? 'selected' : '' ?>>Link Type</option>
                <option value="status" <?= $search_column == 'status' ? 'selected' : '' ?>>HTTP</option>
                <option value="updated_at" <?= $search_column == 'updated_at' ? 'selected' : '' ?>>Created At</option>
                <option value="count" <?= $search_column == 'count' ? 'selected' : '' ?>>Count</option>
            </select>
            <select id="search_mode" onchange="updateSearchControls()" style="<?= $search_column === '' ? 'display:none;' : '' ?>">
                <option value="">Match Type</option>
                <option value="substring" <?= $search_mode == 'substring' ? 'selected' : '' ?>>Contains</option>
                <option value="exact" <?= $search_mode == 'exact' ? 'selected' : '' ?>>Exact Match</option>
            </select>
            <div id="search-value-controls" style="display:<?= $search_column !== '' && $search_mode !== '' ? 'flex' : 'none' ?>;align-items:center;gap:5px;">
                <input type="text" id="search-value" value="<?= htmlspecialchars($search_value, ENT_QUOTES, 'UTF-8') ?>" placeholder="Search..." style="max-width:160px;">
                <button type="button" onclick="runAnchorsSearch()">Search</button>
            </div>
            <?php if ($search_value !== ''): ?>
                <a href="?country=<?= @$_GET['country'] ?: 'all' ?>&lang=<?= @$_GET['lang'] == 'en' ? 'en' : 'ar' ?>&source_type=<?= urlencode($source_type_filter) ?>&link_type=<?= @$_GET['link_type'] ?: 'all' ?>&status_filter=<?= @$_GET['status_filter'] ?: 'all' ?>&group_by=<?= @$_GET['group_by'] ?: 'none' ?>">Clear</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="<?= @$_GET['lang'] != 'en' ? 'active' : '' ?>">
                <a href="?country=<?= @$_GET['country'] ?: 'all' ?>&lang=ar&source_type=<?= urlencode($source_type_filter) ?>&link_type=<?= @$_GET['link_type'] ?: 'all' ?>&status_filter=<?= @$_GET['status_filter'] ?: 'all' ?>&group_by=<?= @$_GET['group_by'] ?: 'none' ?>&search_column=<?= urlencode($search_column) ?>&search_mode=<?= urlencode($search_mode) ?>&search_value=<?= urlencode($search_value) ?>">
                    Arabic (<?= $arabic_count ?>)
                </a>
            </li>
            <li class="<?= @$_GET['lang'] == 'en' ? 'active' : '' ?>">
                <a href="?country=<?= @$_GET['country'] ?: 'all' ?>&lang=en&source_type=<?= urlencode($source_type_filter) ?>&link_type=<?= @$_GET['link_type'] ?: 'all' ?>&status_filter=<?= @$_GET['status_filter'] ?: 'all' ?>&group_by=<?= @$_GET['group_by'] ?: 'none' ?>&search_column=<?= urlencode($search_column) ?>&search_mode=<?= urlencode($search_mode) ?>&search_value=<?= urlencode($search_value) ?>">
                    English (<?= $english_count ?>)
                </a>
            </li>
        </ul>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover content-anchors-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="check-visible-anchors" class="no-icheck">
                            #
                        </th>
                        <th>
                            <a href="?country=<?= @$_GET['country'] ?: 'all' ?>&lang=<?= @$_GET['lang'] == 'en' ? 'en' : 'ar' ?>&source_type=<?= urlencode($source_type_filter) ?>&link_type=<?= @$_GET['link_type'] ?: 'all' ?>&status_filter=<?= @$_GET['status_filter'] ?: 'all' ?>&group_by=<?= @$_GET['group_by'] ?: 'none' ?>&sort=count&order=<?= $sort == 'count' && $order == 'asc' ? 'desc' : 'asc' ?>&search_column=<?= urlencode($search_column) ?>&search_mode=<?= urlencode($search_mode) ?>&search_value=<?= urlencode($search_value) ?>">
                                Count
                            </a>
                        </th>
                        <th>
                            <a href="?country=<?= @$_GET['country'] ?: 'all' ?>&lang=<?= @$_GET['lang'] == 'en' ? 'en' : 'ar' ?>&source_type=<?= urlencode($source_type_filter) ?>&link_type=<?= @$_GET['link_type'] ?: 'all' ?>&status_filter=<?= @$_GET['status_filter'] ?: 'all' ?>&group_by=<?= @$_GET['group_by'] ?: 'none' ?>&search_column=<?= urlencode($search_column) ?>&search_mode=<?= urlencode($search_mode) ?>&search_value=<?= urlencode($search_value) ?>&sort=target_query&order=<?= $sort == 'target_query' && $order == 'asc' ? 'desc' : 'asc' ?>">
                                Target Query
                            </a>
                        </th>
                        <th>Target URL</th>
                        <th>Source URL</th>
                        <th>Edit Admin</th>
                        <th>Source Type</th>
                        <th>
                            <a href="?country=<?= @$_GET['country'] ?: 'all' ?>&lang=<?= @$_GET['lang'] == 'en' ? 'en' : 'ar' ?>&source_type=<?= urlencode($source_type_filter) ?>&link_type=<?= @$_GET['link_type'] ?: 'all' ?>&status_filter=<?= @$_GET['status_filter'] ?: 'all' ?>&group_by=<?= @$_GET['group_by'] ?: 'none' ?>&search_column=<?= urlencode($search_column) ?>&search_mode=<?= urlencode($search_mode) ?>&search_value=<?= urlencode($search_value) ?>&sort=link_type&order=<?= $sort == 'link_type' && $order == 'asc' ? 'desc' : 'asc' ?>">
                                Link Type
                            </a>
                        </th>
                        <th>
                            <a href="?country=<?= @$_GET['country'] ?: 'all' ?>&lang=<?= @$_GET['lang'] == 'en' ? 'en' : 'ar' ?>&source_type=<?= urlencode($source_type_filter) ?>&link_type=<?= @$_GET['link_type'] ?: 'all' ?>&status_filter=<?= @$_GET['status_filter'] ?: 'all' ?>&group_by=<?= @$_GET['group_by'] ?: 'none' ?>&search_column=<?= urlencode($search_column) ?>&search_mode=<?= urlencode($search_mode) ?>&search_value=<?= urlencode($search_value) ?>&sort=status&order=<?= $sort == 'status' && $order == 'asc' ? 'desc' : 'asc' ?>">
                                HTTP
                            </a>
                        </th>
                        <th>Created At</th>
                        @if(in_array($group_by, ['web_url', 'disabled_blogs']))
                            <th>
                                <a href="?country=<?= @$_GET['country'] ?: 'all' ?>&lang=<?= @$_GET['lang'] == 'en' ? 'en' : 'ar' ?>&source_type=<?= urlencode($source_type_filter) ?>&link_type=<?= @$_GET['link_type'] ?: 'all' ?>&status_filter=<?= @$_GET['status_filter'] ?: 'all' ?>&group_by=<?= urlencode($group_by) ?>&search_column=<?= urlencode($search_column) ?>&search_mode=<?= urlencode($search_mode) ?>&search_value=<?= urlencode($search_value) ?>&sort=duplicates&order=<?= $sort == 'duplicates' && $order == 'asc' ? 'desc' : 'asc' ?>">
                                    Duplicates
                                </a>
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    <?php $number = 1; ?>
                    @foreach($display_rows as $row)
                    <?php $anchor = $row['anchor']; ?>
                    <?php
                        $mass_update_items = [];
                        $mass_update_seen = [];
                        foreach ($row['items'] as $item) {
                            $mass_update_key = $item['owner_type'] . '|' . $item['owner_id'] . '|' . $item['content_field'] . '|' . $item['anchor_index'] . '|' . $item['signature'];
                            if (isset($mass_update_seen[$mass_update_key])) {
                                continue;
                            }
                            $mass_update_seen[$mass_update_key] = true;
                            $mass_update_items[] = [
                                'owner_type' => $item['owner_type'],
                                'owner_id' => $item['owner_id'],
                                'content_field' => $item['content_field'],
                                'anchor_index' => $item['anchor_index'],
                                'signature' => $item['signature']
                            ];
                        }
                    ?>
                        <tr>
                            <td style="display:flex;flex-direction:row;align-items:center;justify-content:center;">
                                <input type="checkbox" class="anchor-checkbox no-icheck" data-url="{{ $anchor['url'] }}" data-anchors="{{ json_encode($mass_update_items) }}" style="margin-top:2px;cursor:pointer;">
                                <p style="margin:0 0 0 7px;">{{ $number++ }}</p>
                            </td>
                            <td>{{ $row['count'] }}</td>
                            <td>
                                @if($row['unique_texts'] == 1)
                                    {{ $anchor['text'] }}
                                @else
                                    {{ $row['unique_texts'] }} unique
                                @endif
                            </td>
                            <td class="anchor-url">
                            <?php
                                $target_urls = [];
                                foreach ($row['items'] as $item) {
                                    $url_key = (string) $item['url'];
                                    if (!isset($target_urls[$url_key])) {
                                        $target_urls[$url_key] = 0;
                                    }
                                    $target_urls[$url_key]++;
                                }
                                $target_url_count = count($target_urls);
                            ?>
                            @if($group_by == 'text' && $target_url_count <= 5)
                                <?php $target_url_index = 0; ?>
                                @foreach($target_urls as $target_url => $target_url_occurrences)
                                    {{ $target_url_occurrences }}: <a target="_blank" href="{{ $target_url }}">{{ $target_url }}</a><?php if (++$target_url_index < $target_url_count): ?><br><?php endif; ?>
                                @endforeach
                            @elseif($group_by != 'none' && $target_url_count <= 5)
                                <?php $target_url_index = 0; ?>
                                @foreach($target_urls as $target_url => $target_url_occurrences)
                                    <a target="_blank" href="{{ $target_url }}">{{ $target_url }}</a><?php if (++$target_url_index < $target_url_count): ?><br><?php endif; ?>
                                @endforeach
                            @elseif($row['unique_urls'] == 1)
                                <a target="_blank" href="{{ $anchor['url'] }}">{{ $anchor['url'] }}</a>
                            @else
                                {{ $row['unique_urls'] }} unique
                            @endif
                        </td>
                            <td>
                                <?php
                                    $source_urls = [];
                                    foreach ($row['items'] as $item) {
                                        $item_web_urls = isset($item['web_urls']) ? $item['web_urls'] : [$item['web_url']];
                                        foreach ($item_web_urls as $source_url) {
                                            $source_urls[(string) $source_url] = isset($item['source_title']) ? $item['source_title'] : $source_url;
                                        }
                                    }
                                    $source_url_count = count($source_urls);
                                ?>
                                @if($source_url_count <= 5)
                                    <?php $source_url_index = 0; ?>
                                    @foreach($source_urls as $source_url => $source_title)
                                        <?php $visible_source_type = $classify_source_type($source_url); ?>
                                        <a href="{{ $source_url }}" target="_blank">
                                            {{ '[' . ($visible_source_type ?: 'Unknown') . ']' }} {{ $source_title }}
                                        </a><?php if (++$source_url_index < $source_url_count): ?><br><?php endif; ?>
                                    @endforeach
                                @else
                                    {{ $source_url_count }} unique
                                @endif
                            </td>
                            <td>
                                @if($row['unique_admin_urls'] == 1)
                                    <a target="_blank" href="{{ $anchor['admin_url'] }}">Admin URL</a>
                                @else
                                    {{ $row['unique_admin_urls'] }} unique
                                @endif
                            </td>
                            <td>
                                @if($group_by != 'none')
                                    <?php
                                        $source_type_counts = [];
                                        foreach ($row['items'] as $item) {
                                            $item_source_types = isset($item['source_types']) && is_array($item['source_types']) ? $item['source_types'] : [$item['source_type']];
                                            foreach ($item_source_types as $value) {
                                                if (!isset($source_type_counts[$value])) {
                                                    $source_type_counts[$value] = 0;
                                                }
                                                $source_type_counts[$value]++;
                                            }
                                        }
                                    ?>
                                    <?php $source_type_index = 0; ?>
                                    @foreach($source_type_counts as $source_type => $occurrences)
                                        {{ $occurrences }}: {{ $source_type }}<?php if (++$source_type_index < count($source_type_counts)): ?><br><?php endif; ?>
                                    @endforeach
                                @else
                                    {{ $anchor['source_type'] }}
                                @endif
                            </td>
                            <td>
                                @if($group_by != 'none')
                                    <?php
                                        $link_type_counts = [];
                                        foreach ($row['items'] as $item) {
                                            $link_type_value = (string) $item['link_type'];
                                            if (!isset($link_type_counts[$link_type_value])) {
                                                $link_type_counts[$link_type_value] = 0;
                                            }
                                            $link_type_counts[$link_type_value]++;
                                        }
                                        $link_type_index = 0;
                                        $link_type_count = count($link_type_counts);
                                    ?>
                                    @foreach($link_type_counts as $link_type_value => $link_type_occurrences)
                                        {{ $link_type_occurrences }}: {{ $link_type_value }}<?php if (++$link_type_index < $link_type_count): ?><br><?php endif; ?>
                                    @endforeach
                                @else
                                    {{ $anchor['link_type'] }}
                                @endif
                            </td>
                            <?php
                            $status_items = [];
                            foreach ($row['items'] as $item) {
                                $status_items[] = [
                                    'url' => $item['url'],
                                    'status' => $item['status']
                                ];
                            }
                            ?>
                            <td class="http-status" data-grouped="<?= $group_by != 'none' ? '1' : '0' ?>" data-status-items="<?= htmlspecialchars(json_encode($status_items, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8') ?>">
                                <?php
                                $status_counts = [];
                                foreach ($row['items'] as $item) {
                                    $status_value = $status_label($item['status']);
                                    if (!isset($status_counts[$status_value])) {
                                        $status_counts[$status_value] = 0;
                                    }
                                    $status_counts[$status_value]++;
                                }
                                ?>
                                @if($group_by != 'none')
                                    <?php
                                    $status_index = 0;
                                    $status_count = count($status_counts);
                                    ?>
                                    @foreach($status_counts as $status_value => $status_occurrences)
                                        {{ $status_occurrences }}: {{ $status_value }}<?php if (++$status_index < $status_count): ?><br><?php endif; ?>
                                    @endforeach
                                @else
                                    {{ $status_label($anchor['status']) }}
                                @endif
                            </td>
                            <td>
                                @if($row['unique_dates'] == 1)
                                    {{ date('d M Y', strtotime($anchor['updated_at'])) }}
                                @else
                                    {{ $row['unique_dates'] }} unique
                                @endif
                            </td>
                            @if(in_array($group_by, ['web_url', 'disabled_blogs']))
                            <td>{{ $row['duplicate_count'] }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <?php
        $csv_rows = [['#', 'Count', 'Target Query', 'Target URL', 'Source URL', 'Edit / Admin', 'Source Type', 'Link Type', 'Status', 'Updated At']];
        foreach (array_values($display_rows) as $csv_index => $csv_row) {
            $csv_values = ['text' => [], 'url' => [], 'web_url' => [], 'admin_url' => [], 'source_type' => [], 'link_type' => [], 'status' => [], 'updated_at' => []];
            foreach ($csv_row['items'] as $csv_item) {
                foreach ($csv_values as $csv_field => $unused) {
                    if ($csv_field === 'web_url') {
                        $values = $csv_item['web_urls'];
                    } elseif ($csv_field === 'status') {
                        $values = [$status_label($csv_item['status'])];
                    } else {
                        $values = [(string)$csv_item[$csv_field]];
                    }
                    foreach ($values as $csv_value) {
                        $csv_values[$csv_field][(string)$csv_value] = true;
                    }
                }
            }
            $csv_line = [$csv_index + 1, $csv_row['count']];
            foreach ($csv_values as $values) {
                $csv_line[] = implode(' | ', array_keys($values));
            }
            $csv_rows[] = $csv_line;
        }
    ?>
    <script type="application/json" id="anchors-csv-data"><?= json_encode($csv_rows, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) ?></script>
    <script>
        document.getElementById('export-anchors-csv').addEventListener('click', function () {
            const rows = JSON.parse(document.getElementById('anchors-csv-data').textContent);
            const csv = '\uFEFF' + rows.map(row => row.map(value => {
                let text = String(value);
                if (/^[=+@-]/.test(text)) text = "'" + text;
                return '"' + text.replace(/"/g, '""') + '"';
            }).join(',')).join('\r\n');
            const url = URL.createObjectURL(new Blob([csv], { type: 'text/csv;charset=utf-8' }));
            const link = document.createElement('a');
            link.href = url;
            link.download = 'content-links-' + new Date().toISOString().slice(0, 10) + '.csv';
            document.body.appendChild(link);
            link.click();
            link.remove();
            setTimeout(() => URL.revokeObjectURL(url), 1000);
        });
    </script>
    <script>
        // async function removeDuplicateAnchors(){
        //     const button = document.getElementById("remove-duplicate-anchors-button");
        //     if(!button) return;
        //     const totalDuplicates = duplicateSourceBatches.reduce((total, batch) => total + batch.anchors.length, 0);
        //     if(totalDuplicates === 0){
        //         alert("No duplicate anchors found.");
        //         return;
        //     }
        //     if(!confirm("Remove anchorness from " + totalDuplicates + " duplicate anchors while keeping the first occurrence of each?")){
        //         return;
        //     }
        //     button.disabled = true;
        //     let updated = 0;
        //     let skipped = 0;
        //     let processedSources = 0;
        //     try{
        //         for(const batch of duplicateSourceBatches){
        //             processedSources++;
        //             button.textContent = "Checking " + processedSources + "/" + duplicateSourceBatches.length;
        //             if(batch.anchors.length === 0){
        //                 continue;
        //             }
        //             const response = await fetch('<?= route('admin.anchors.mass_update') ?>', {
        //                 method: 'POST',
        //                 headers: {
        //                     'Content-Type': 'application/json',
        //                     'X-CSRF-TOKEN': '<?= csrf_token() ?>',
        //                     'Accept': 'application/json'
        //                 },
        //                 body: JSON.stringify({
        //                     operation: 'keep-text',
        //                     value: '',
        //                     anchors: batch.anchors
        //                 })
        //             });
        //             const data = await response.json();
        //             if(!response.ok || !data.success){
        //                 throw new Error(data.message || "Duplicate removal failed.");
        //             }
        //             updated += Number(data.updated || 0);
        //             skipped += Number(data.skipped || 0);
        //         }
        //         alert(
        //             "Duplicate cleanup finished.\n" +
        //             "Removed anchorness: " + updated + "\n" +
        //             "Skipped: " + skipped
        //         );
        //         window.location.reload();
        //     }catch(error){
        //         console.error("DUPLICATE ANCHOR CLEANUP FAILED:", error);
        //         alert("Duplicate cleanup failed: " + error.message);
        //         button.disabled = false;
        //         button.textContent = "Remove Duplicate Anchors (" + totalDuplicates + ")";
        //     }
        // }
        const displayedUrls = new Set(<?= json_encode($displayed_urls, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>);
        function statusLabel(status) {
            if (status === null || status === "") {
                return "Not checked";
            }
            try {
                const chain = JSON.parse(status);
                if (Array.isArray(chain)) {
                    return chain.join(" → ");
                }
            } catch (error) {}
            return String(status);
        }
        function renderStatusCell(cell) {
            const items = JSON.parse(cell.dataset.statusItems);
            const counts = new Map();
            items.forEach(item => {
                const label = statusLabel(item.status);
                counts.set(label, (counts.get(label) || 0) + 1);
            });
            if (cell.dataset.grouped === "0") {
                cell.textContent = items.length ? statusLabel(items[0].status) : "Not checked";
                return;
            }
            cell.innerHTML = [...counts.entries()].map(([status, count]) => count + ": " + status).join("<br>");
        }
        function getRowsForUrl(url) {
            return [...document.querySelectorAll(".http-status")].filter(cell => {
                const items = JSON.parse(cell.dataset.statusItems);
                return items.some(item => item.url === url);
            }).map(cell => cell.closest("tr"));
        }
        function updateDisplayedStatus(url, statusChain) {
            const newStatus = JSON.stringify(statusChain);
            document.querySelectorAll(".http-status").forEach(cell => {
                const items = JSON.parse(cell.dataset.statusItems);
                let changed = false;
                items.forEach(item => {
                    if (item.url === url) {
                        item.status = newStatus;
                        changed = true;
                    }
                });
                if (!changed) {
                    return;
                }
                cell.dataset.statusItems = JSON.stringify(items);
                renderStatusCell(cell);
            });
        }
        async function updateLinkStatuses() {
            const button = document.getElementById('update-link-statuses-button');
            const urls = Array.from(displayedUrls);
            let checked = 0;
            button.disabled = true;
            button.innerHTML = '<i class="fa fa-refresh fa-spin"></i> Updating 0/' + urls.length;
            console.log('=== LINK STATUS CRAWLER STARTED ===');
            console.log('Displayed unique URLs:', urls.length);
            try {
                for (const url of urls) {
                    const currentRows = getRowsForUrl(url);
                    currentRows.forEach(row => row.classList.add("currently-crawling"));
                    console.log("Crawling:", url);
                    try {
                        const response = await fetch('<?= route('admin.update_link_statuses') ?>', {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "<?= csrf_token() ?>",
                                "Accept": "application/json"
                            },
                            body: JSON.stringify({
                                url: url
                            })
                        });
                        const data = await response.json();
                        if (!response.ok) {
                            console.error("CRAWL ERROR:", {
                                url: url,
                                status: data.redirectChain,
                                finalUrl: data.finalUrl,
                                error: data.error
                            });
                        } else {
                            updateDisplayedStatus(url, data.redirectChain);
                            console.log("CRAWLED:", {
                                url: url,
                                status: data.redirectChain,
                                finalUrl: data.finalUrl,
                                error: data.error
                            });
                        }
                    } finally {
                        currentRows.forEach(row => row.classList.remove("currently-crawling"));
                    }
                    checked++;
                    button.innerHTML = '<i class="fa fa-refresh fa-spin"></i> Updating ' + checked + "/" + urls.length;
                }
                console.log('=== LINK STATUS CRAWLER FINISHED ===');
                console.log('Checked:', checked);
                button.disabled = false;
                button.innerHTML = '<i class="fa fa-refresh"></i> Update Statuses';
            } catch (error) {
                console.error('=== LINK STATUS CRAWLER FAILED ===');
                console.error(error);
                button.disabled = false;
                button.innerHTML = '<i class="fa fa-refresh"></i> Update Statuses';
            }
        }
        const anchorCheckboxes = document.querySelectorAll('.anchor-checkbox');
        const checkVisibleAnchors = document.getElementById('check-visible-anchors');
        checkVisibleAnchors.addEventListener('change', () => {
            document.querySelectorAll('.anchor-checkbox').forEach(checkbox => {
                const row = checkbox.closest('tr');
                if (row && row.offsetParent !== null) {
                    checkbox.checked = checkVisibleAnchors.checked;
                }
            });
            updateMassUpdateButton();
        });
        const massUpdateOpenButton = document.getElementById('mass-update-open-button');
        const massUpdatePopup = document.getElementById('mass-update-popup');
        const massUpdateCloseButton = document.getElementById('mass-update-close-button');
        const massUpdateDropdown = document.getElementById('mass-update-dropdown');
        const massUpdateMsg = document.getElementById('mass-update-message');
        const massUpdateInput = document.getElementById('mass-update-input');
        const massUpdateSubmitButton = document.getElementById('mass-update-submit-button');
        function getSelectedMassUpdateAnchors() {
            const selectedCheckboxes = document.querySelectorAll('.anchor-checkbox:checked');
            const uniqueAnchors = new Map();
            selectedCheckboxes.forEach(checkbox => {
                const checkboxAnchors = JSON.parse(checkbox.dataset.anchors);
                checkboxAnchors.forEach(anchor => {
                    const key = anchor.owner_type + '|' + anchor.owner_id + '|' + anchor.content_field + '|' + anchor.anchor_index + '|' + anchor.signature;
                    uniqueAnchors.set(key, anchor);
                });
            });
            return [...uniqueAnchors.values()];
        }
        function updateMassUpdateButton() {
            const selectedCount = getSelectedMassUpdateAnchors().length;
            if (selectedCount > 0) {
                massUpdateOpenButton.style.display = 'inline-block';
                massUpdateOpenButton.textContent = 'Mass Update (' + selectedCount + ')';
            } else {
                massUpdateOpenButton.style.display = 'none';
                massUpdatePopup.style.display = 'none';
            }
        }
        anchorCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                updateMassUpdateButton();
                const visibleCheckboxes = [...document.querySelectorAll('.anchor-checkbox')].filter(item => item.closest('tr').offsetParent !== null);
                checkVisibleAnchors.checked = visibleCheckboxes.length > 0 && visibleCheckboxes.every(item => item.checked);
            });
        });
        massUpdateOpenButton.addEventListener('click', () => {
            massUpdatePopup.style.display = 'flex';
        });
        massUpdateCloseButton.addEventListener('click', () => {
            massUpdatePopup.style.display = 'none';
        });
        massUpdatePopup.addEventListener('click', event => {
            if (event.target === massUpdatePopup) {
                massUpdatePopup.style.display = 'none';
            }
        });
        massUpdateDropdown.addEventListener('change', () => {
            massUpdateInput.value = '';
            if (massUpdateDropdown.value === 'edit-text') {
                massUpdateMsg.textContent = 'New Target Query:';
                massUpdateInput.style.display = 'block';
            } else if (massUpdateDropdown.value === 'edit-target-url') {
                massUpdateMsg.textContent = 'New Target URL:';
                massUpdateInput.style.display = 'block';
            } else {
                massUpdateMsg.textContent = '';
                massUpdateInput.style.display = 'none';
            }
        });
        massUpdateSubmitButton.addEventListener('click', async () => {
            const operation = massUpdateDropdown.value;
            const value = massUpdateInput.value;
            const selected = document.querySelectorAll('.anchor-checkbox:checked');
            if (operation === 'nothing') {
                alert('Choose a mass update operation first.');
                return;
            }
            if (selected.length === 0) {
                alert('No anchors selected.');
                return;
            }
            if ((operation === 'edit-text' || operation === 'edit-target-url') && value.trim() === '') {
                alert('Please enter a new value.');
                return;
            }
            const anchors = getSelectedMassUpdateAnchors();
            console.log('MASS UPDATE REQUEST:', {
                operation: operation,
                value: value,
                anchors: anchors
            });
            massUpdateSubmitButton.disabled = true;
            massUpdateSubmitButton.textContent = 'Updating...';
            try {
                const response = await fetch('<?= route('admin.anchors.mass_update') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?= csrf_token() ?>',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        operation: operation,
                        value: value,
                        anchors: anchors
                    })
                });
                const data = await response.json();
                console.log('MASS UPDATE RESPONSE:', data);
                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'Mass update failed.');
                }
                alert(
                    'Mass update finished.\n' +
                    'Updated: ' + data.updated + '\n' +
                    'Skipped: ' + data.skipped
                );
                window.location.reload();
            } catch (error) {
                console.error('MASS UPDATE FAILED:', error);
                alert('Mass update failed: ' + error.message);
                massUpdateSubmitButton.disabled = false;
                massUpdateSubmitButton.textContent = 'Update';
            }
        });
        function updateSearchControls() {
            const column = document.getElementById('search-column');
            const mode = document.getElementById('search_mode');
            const valueControls = document.getElementById('search-value-controls');
            if (column.value === '') {
                mode.value = '';
                mode.style.display = 'none';
                valueControls.style.display = 'none';
                return;
            }
            mode.style.display = 'block';
            if (mode.value === '') {
                valueControls.style.display = 'none';
                return;
            }
            valueControls.style.display = 'flex';
        }
        function runAnchorsSearch() {
            const column = document.getElementById('search-column').value;
            const mode = document.getElementById('search_mode').value;
            const value = document.getElementById('search-value').value;
            if (!column || !mode || !value.trim()) {
                return;
            }
            window.location.href = '?country=<?= @$_GET['country'] ?: 'all' ?>&lang=<?= @$_GET['lang'] == 'en' ? 'en' : 'ar' ?>&source_type=<?= urlencode($source_type_filter) ?>&link_type=<?= @$_GET['link_type'] ?: 'all' ?>&status_filter=<?= @$_GET['status_filter'] ?: 'all' ?>&group_by=<?= @$_GET['group_by'] ?: 'none' ?>&search_column=' + encodeURIComponent(column) + '&search_mode=' + encodeURIComponent(mode) + '&search_value=' + encodeURIComponent(value);
        }
        
        
        
        
        async function updateProjectAnchorTexts(groups){
            let updatedGroups = 0;
            let updatedAnchors = 0;
            let skippedAnchors = 0;
            const failedGroups = [];
            for(const group of groups){
                const slug = group.url.split("t/projects/")[1]?.split(/[/?#]/)[0];
                if(!slug){
                    continue;
                }
                const title = projectTitles[slug];
                if(!title){
                    console.warn("No Arabic title for:", slug);
                    failedGroups.push(group.url);
                    continue;
                }
                const response = await fetch("<?= route('admin.anchors.mass_update') ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "<?= csrf_token() ?>"
                    },
                    body: JSON.stringify({
                        operation: "edit-text",
                        value: "مشروع " + title,
                        anchors: group.anchors
                    })
                });
                const data = await response.json();
                if(!response.ok || !data.success){
                    console.error("Failed:", group.url, data);
                    failedGroups.push(group.url);
                    continue;
                }
                updatedGroups++;
                updatedAnchors += Number(data.updated || 0);
                skippedAnchors += Number(data.skipped || 0);
                console.log(updatedGroups + "/" + groups.length, group.url, "→ مشروع " + title, "| Updated:", data.updated, "| Skipped:", data.skipped);
            }
            console.log({
                totalGroups: groups.length,
                updatedGroups,
                updatedAnchors,
                skippedAnchors,
                failedGroups
            });
        }
        document.getElementById("update-project-anchor-texts").addEventListener("click", async function(){
            const params = new URLSearchParams(window.location.search);
            if(params.get("group_by") !== "url"){
                alert("STOP: Group by Target URL first.");
                return;
            }
            if(params.get("lang") === "en"){
                alert("STOP: Switch to the Arabic tab first.");
                return;
            }
            const groups = [...document.querySelectorAll(".anchor-checkbox")].map(checkbox => {
                const anchors = JSON.parse(checkbox.dataset.anchors || "[]");
                return {
                    url: checkbox.dataset.url || "",
                    anchors: anchors
                };
            }).filter(group => group.anchors.length && group.url.includes("t/projects/"));
            const totalAnchors = groups.reduce((total, group) => total + group.anchors.length, 0);
            const missingTitles = groups.filter(group => {
                const slug = group.url.split("t/projects/")[1]?.split(/[/?#]/)[0];
                return !slug || !projectTitles[slug];
            });
            console.log("Project groups:", groups.length);
            console.log("Physical anchors:", totalAnchors);
            console.log("Missing titles:", missingTitles);
            if(groups.length !== 85 || totalAnchors !== 143 || missingTitles.length){
                alert("STOP: Expected 85 groups / 143 anchors / 0 missing titles. Check console.");
                return;
            }
            if(!confirm("Update 143 Arabic project anchors across 85 project URLs?")){
                return;
            }
            await updateProjectAnchorTexts(groups);
        });
    </script>
</div>
@endsection