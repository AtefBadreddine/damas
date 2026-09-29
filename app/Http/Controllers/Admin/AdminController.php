<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Validator;
use Helper;
use File;
use Image;
use Input;
use DB;

class AdminController extends BaseController
{
    public function whatsapp_chat_index(){
        return view("admin.whatsapp_chat.index");
    }
    public function projects_medias($id)
    {
        echo '<pre>';
        
        /*$files = [
            "16-77f71813930c1a4fb034e3bf44d9a8eb5.jpg",
            "16-87f71813930c1a4fb034e3bf44d9a8eb5.jpg",
            "16-97f71813930c1a4fb034e3bf44d9a8eb5.jpg",
            "16-107f71813930c1a4fb034e3bf44d9a8eb5.jpg",
            "16-117f71813930c1a4fb034e3bf44d9a8eb5.jpg",
            "1667f71813930c1a4fb034e3bf44d9a8eb5.jpg",
        ];
        foreach ($files as $filename) {
            $media = Helper::query("Media", "where", ["field" => "filename", "value" => $filename])->first();
            if ( $media ) {
                $img = Image::make("public/uploads/$filename");
                $logo = Image::make(public_path("img/logo.png"))->opacity(15);
                $img->insert($logo, 'center');
                $img->save(public_path("uploads")."/$filename");
                echo $filename;
                echo '<br>';
            }
        }
        die('ok');*/
        
        /*$projects = \App\Models\Project::where('id', ">", 28)->get();;
        foreach ($projects as $k => $project) {
            $images = $project->planPhotos;
            echo $project->id;
            if ( count($images) > 0 ) {
                foreach ($project->planPhotos as $k => $img) {
                    $filename = $img->filename;
                    $img = Image::make("https://www.damas.net/public/uploads/$filename");
                    $logo = Image::make(public_path("img/logo.png"))->opacity(20);            
                    $img->insert($logo, 'center');
                    $img->save(public_path("uploads")."/$filename");
                    echo $filename;
                    echo '<br>';
                }   
            }
        }*/
    }
    
    /**
    * admin index.
    *
    * @return void
    */
    public function index()
    {
        return view("admin.index");
    }
    
    
    /**
     * anchors crawler
     * 
     * @return json
     */
    
    public function update_link_statuses(\Illuminate\Http\Request $request)
    {
        $starting_memory = memory_get_usage(true);
        $url = trim((string) $request->input('url'));
        if ($url === '' || !filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json([
                'error' => 'Invalid URL'
            ], 422);
        }
        $url_parts = parse_url($url);
        $scheme = isset($url_parts['scheme']) ? strtolower($url_parts['scheme']) : '';
        if (!in_array($scheme, ['http', 'https'], true)) {
            return response()->json([
                'error' => 'Only HTTP and HTTPS URLs can be crawled'
            ], 422);
        }
        $resolve_redirect_url = function ($base_url, $location) {
            $location = trim($location);
            if ($location === '') {
                return null;
            }
            if (preg_match('/^https?:\/\//i', $location)) {
                return $location;
            }
            $base = parse_url($base_url);
            if (!$base || empty($base['scheme']) || empty($base['host'])) {
                return null;
            }
            if (strpos($location, '//') === 0) {
                return $base['scheme'] . ':' . $location;
            }
            $authority = $base['scheme'] . '://' . $base['host'];
            if (isset($base['port'])) {
                $authority .= ':' . $base['port'];
            }
            $base_path = isset($base['path']) && $base['path'] !== '' ? $base['path'] : '/';
            if ($location[0] === '?') {
                return $authority . $base_path . $location;
            }
            if ($location[0] === '#') {
                return $authority . $base_path . (isset($base['query']) ? '?' . $base['query'] : '');
            }
            $fragment_position = strpos($location, '#');
            if ($fragment_position !== false) {
                $location = substr($location, 0, $fragment_position);
            }
            $suffix = '';
            $query_position = strpos($location, '?');
            if ($query_position !== false) {
                $suffix = substr($location, $query_position);
                $location = substr($location, 0, $query_position);
            }
            if (strpos($location, '/') === 0) {
                $path = $location;
            } else {
                $last_slash = strrpos($base_path, '/');
                $directory = $last_slash === false ? '/' : substr($base_path, 0, $last_slash + 1);
                $path = $directory . $location;
            }
            $segments = explode('/', $path);
            $normalized_segments = [];
            foreach ($segments as $segment) {
                if ($segment === '' || $segment === '.') {
                    continue;
                }
                if ($segment === '..') {
                    array_pop($normalized_segments);
                    continue;
                }
                $normalized_segments[] = $segment;
            }
            return $authority . '/' . implode('/', $normalized_segments) . $suffix;
        };
        $redirect_chain = [];
        $redirect_urls = [];
        $visited_urls = [];
        $current_url = $url;
        $final_url = $url;
        $maximum_redirects = 5;
        $crawler_error = null;
        $possible_redirect_loop = false;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_COOKIEFILE, '');
        for ($redirect_index = 0; $redirect_index <= $maximum_redirects; $redirect_index++) {
            if (isset($visited_urls[$current_url])) {
                $possible_redirect_loop = true;
            }
            $visited_urls[$current_url] = true;
            $redirect_urls[] = $current_url;
            $current_status = 0;
            $location = null;
            $body_started = false;
            curl_setopt_array($curl, [
                CURLOPT_URL => $current_url,
                CURLOPT_HTTPGET => true,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_USERAGENT => 'Damas-Link-Status-Crawler/2.0',
                CURLOPT_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
                CURLOPT_HEADERFUNCTION => function ($curl, $header) use (&$current_status, &$location) {
                    $trimmed_header = trim($header);
                    if (preg_match('/^HTTP\/\S+\s+(\d{3})/', $trimmed_header, $matches)) {
                        $status = (int) $matches[1];
                        if ($status >= 200) {
                            $current_status = $status;
                            $location = null;
                        }
                        return strlen($header);
                    }
                    if (stripos($trimmed_header, 'Location:') === 0) {
                        $location = trim(substr($trimmed_header, 9));
                    }
                    return strlen($header);
                },
                CURLOPT_WRITEFUNCTION => function ($curl, $chunk) use (&$body_started) {
                    $body_started = true;
                    return 0;
                }
            ]);
            curl_exec($curl);
            $curl_error_number = curl_errno($curl);
            $curl_error = curl_error($curl);
            $reported_status = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($current_status === 0 && $reported_status > 0) {
                $current_status = $reported_status;
            }
            if ($curl_error_number && !($curl_error_number === CURLE_WRITE_ERROR && $body_started)) {
                $crawler_error = $curl_error !== '' ? $curl_error : 'Unknown cURL error';
                if ($current_status === 0) {
                    $redirect_chain[] = 0;
                }
                break;
            }
            if ($current_status === 0) {
                $redirect_chain[] = 0;
                $crawler_error = 'No HTTP status was received';
                break;
            }
            $redirect_chain[] = $current_status;
            $final_url = $current_url;
            if ($current_status >= 300 && $current_status < 400 && $location !== null && $location !== '') {
                if ($redirect_index >= $maximum_redirects) {
                    $crawler_error = $possible_redirect_loop
                        ? 'Redirect loop detected after ' . $maximum_redirects . ' redirects'
                        : 'Maximum redirect limit reached';
                    break;
                }
                $next_url = $resolve_redirect_url($current_url, $location);
                if ($next_url === null || !filter_var($next_url, FILTER_VALIDATE_URL)) {
                    $crawler_error = 'Invalid redirect URL';
                    break;
                }
                $next_parts = parse_url($next_url);
                $next_scheme = isset($next_parts['scheme']) ? strtolower($next_parts['scheme']) : '';
                if (!in_array($next_scheme, ['http', 'https'], true)) {
                    $crawler_error = 'Redirected to a non-HTTP URL';
                    break;
                }
                $current_url = $next_url;
                continue;
            }
            break;
        }
        curl_close($curl);
        if (empty($redirect_chain)) {
            $redirect_chain[] = 0;
        }
        $stored_status = json_encode(array_values($redirect_chain));
        if (\DB::table('links_status')->where('link', $url)->exists()) {
            \DB::table('links_status')->where('link', $url)->update([
                'status' => $stored_status
            ]);
        } else {
            \DB::table('links_status')->insert([
                'link' => $url,
                'status' => $stored_status
            ]);
        }
        return response()->json([
            'url' => $url,
            'status' => $redirect_chain,
            'firstHttpStatus' => isset($redirect_chain[0]) ? $redirect_chain[0] : 0,
            'finalHttpStatus' => end($redirect_chain),
            'finalUrl' => $final_url,
            'redirectChain' => $redirect_chain,
            'error' => $crawler_error,
            'redirectUrls' => $redirect_urls,
            'starting_memory_mb' => round($starting_memory / 1024 / 1024, 2),
            'current_memory_mb' => round(memory_get_usage(true) / 1024 / 1024, 2),
            'peak_memory_mb' => round(memory_get_peak_usage(true) / 1024 / 1024, 2)
        ]);
    }
    
    /**
     * anchors mass update
     */
    
    public function anchors_mass_update(Request $request)
    {
        $operation = $request->get('operation');
        $value = $request->get('value', '');
        $selected_anchors = $request->get('anchors', []);
        $allowed_operations = [
            'edit-text',
            'edit-target-url',
            'keep-text',
            'remove-completely'
        ];
        if (!in_array($operation, $allowed_operations)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid operation.'
            ], 400);
        }
        if (!is_array($selected_anchors) || empty($selected_anchors)) {
            return response()->json([
                'success' => false,
                'message' => 'No anchors were selected.'
            ], 400);
        }
        if (($operation == 'edit-text' || $operation == 'edit-target-url') && trim($value) === '') {
            return response()->json([
                'success' => false,
                'message' => 'A new value is required.'
            ], 400);
        }
        $groups = [];
        foreach ($selected_anchors as $selected_anchor) {
            if (!isset($selected_anchor['post_id'], $selected_anchor['content_field'], $selected_anchor['anchor_index'], $selected_anchor['signature'])) {
                continue;
            }
            $post_id = (int) $selected_anchor['post_id'];
            $content_field = $selected_anchor['content_field'];
            $anchor_index = (int) $selected_anchor['anchor_index'];
            $signature = $selected_anchor['signature'];
            if (!in_array($content_field, ['content_ar', 'content_en'])) {
                continue;
            }
            if ($anchor_index < 0) {
                continue;
            }
            $group_key = $post_id . '|' . $content_field;
            if (!isset($groups[$group_key])) {
                $groups[$group_key] = [
                    'post_id' => $post_id,
                    'content_field' => $content_field,
                    'anchors' => []
                ];
            }
            $groups[$group_key]['anchors'][] = [
                'anchor_index' => $anchor_index,
                'signature' => $signature
            ];
        }
        if (empty($groups)) {
            return response()->json([
                'success' => false,
                'message' => 'No valid anchors were received.'
            ], 400);
        }
        $updated = 0;
        $skipped = 0;
        $updated_posts = [];
        $errors = [];
        foreach ($groups as $group) {
            $post = Helper::query("Post", "find", [
                'id' => $group['post_id']
            ]);
            if (!$post) {
                $skipped += count($group['anchors']);
                $errors[] = 'Post ' . $group['post_id'] . ' was not found.';
                continue;
            }
            $content_field = $group['content_field'];
            $stored_content = $post->$content_field;
            if (empty($stored_content)) {
                $skipped += count($group['anchors']);
                $errors[] = 'Post ' . $post->id . ' has empty ' . $content_field . '.';
                continue;
            }
            preg_match_all('/&lt;a\b.*?&gt;.*?&lt;\/a\s*&gt;/isu', $stored_content, $encoded_matches, PREG_OFFSET_CAPTURE);
            $encoded_anchors = isset($encoded_matches[0]) ? $encoded_matches[0] : [];
            $targets = [];
            foreach ($group['anchors'] as $selected_anchor) {
                $index = $selected_anchor['anchor_index'];
                if (!isset($encoded_anchors[$index])) {
                    $skipped++;
                    $errors[] = 'Anchor #' . $index . ' no longer exists in post ' . $post->id . '.';
                    continue;
                }
                $encoded_anchor = $encoded_anchors[$index][0];
                $offset = $encoded_anchors[$index][1];
                $raw_anchor = html_entity_decode($encoded_anchor, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                if (sha1($raw_anchor) !== $selected_anchor['signature']) {
                    $skipped++;
                    $errors[] = 'Anchor #' . $index . ' in post ' . $post->id . ' changed after the page was loaded and was skipped.';
                    continue;
                }
                $replacement = $raw_anchor;
                if ($operation == 'edit-text') {
                    $open_end = strpos($raw_anchor, '>');
                    $close_start = strripos($raw_anchor, '</a');
                    if ($open_end === false || $close_start === false || $close_start <= $open_end) {
                        $skipped++;
                        $errors[] = 'Anchor #' . $index . ' in post ' . $post->id . ' has invalid anchor markup.';
                        continue;
                    }
                    $old_inner = substr($raw_anchor, $open_end + 1, $close_start - ($open_end + 1));
                    $space_token = '(?:\s|&nbsp;|&#160;|&#xA0;)';
                    $leading_space = '';
                    $trailing_space = '';
                    if (preg_match('/^(' . $space_token . '*)/iu', $old_inner, $leading_match)) {
                        $leading_space = $leading_match[1];
                    }
                    if (preg_match('/(' . $space_token . '*)$/iu', $old_inner, $trailing_match)) {
                        $trailing_space = $trailing_match[1];
                    }
                    $safe_text = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    $safe_text = preg_replace_callback('/(^ +| +$| {2,})/u', function ($match) {
                        return str_repeat('&nbsp;', strlen($match[0]));
                    }, $safe_text);
                    $replacement = substr($raw_anchor, 0, $open_end + 1) . $leading_space . $safe_text . $trailing_space . substr($raw_anchor, $close_start);
                } elseif ($operation == 'edit-target-url') {
                    $open_end = strpos($raw_anchor, '>');
                    if ($open_end === false) {
                        $skipped++;
                        $errors[] = 'Anchor #' . $index . ' in post ' . $post->id . ' has invalid anchor markup.';
                        continue;
                    }
                    $opening_tag = substr($raw_anchor, 0, $open_end + 1);
                    $anchor_body = substr($raw_anchor, $open_end + 1);
                    $safe_url = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    if (preg_match('/\bhref\s*=\s*(["\']).*?\1/isu', $opening_tag)) {
                        $opening_tag = preg_replace_callback('/\bhref\s*=\s*(["\']).*?\1/isu', function ($match) use ($safe_url) {
                            return 'href=' . $match[1] . $safe_url . $match[1];
                        }, $opening_tag, 1);
                    } else {
                        $opening_tag = substr($opening_tag, 0, -1) . ' href="' . $safe_url . '">';
                    }
                    $replacement = $opening_tag . $anchor_body;
                } elseif ($operation == 'keep-text') {
                    $open_end = strpos($raw_anchor, '>');
                    $close_start = strripos($raw_anchor, '</a');
                    if ($open_end === false || $close_start === false || $close_start <= $open_end) {
                        $skipped++;
                        $errors[] = 'Anchor #' . $index . ' in post ' . $post->id . ' has invalid anchor markup.';
                        continue;
                    }
                    $replacement = substr(
                        $raw_anchor,
                        $open_end + 1,
                        $close_start - ($open_end + 1)
                    );
                } elseif ($operation == 'remove-completely') {
                    $replacement = '';
                }
                $encoded_replacement = $replacement === '' ? '' : htmlentities($replacement);
                $targets[] = [
                    'offset' => $offset,
                    'length' => strlen($encoded_anchor),
                    'replacement' => $encoded_replacement,
                    'index' => $index
                ];
            }
            if (empty($targets)) {
                continue;
            }
            usort($targets, function ($a, $b) {
                return $b['offset'] <=> $a['offset'];
            });
            $new_stored_content = $stored_content;
            foreach ($targets as $target) {
                $new_stored_content = substr($new_stored_content, 0, $target['offset'])
                    . $target['replacement']
                    . substr($new_stored_content, $target['offset'] + $target['length']);
                $updated++;
            }
            if ($new_stored_content === $stored_content) {
                continue;
            }
            \DB::table('posts')
                ->where('id', $post->id)
                ->update([
                    $content_field => $new_stored_content
                ]);
            $updated_posts[$post->id] = $post;
        }
        foreach ($updated_posts as $post) {
            $urls_cache = [];
            $urls_cache[] = $post->frontUrl();
            $urls_cache[] = route('front.blog');
            Helper::Clear_cache($urls_cache);
        }
        \Log::info('ANCHORS MASS UPDATE FINISHED', [
            'operation' => $operation,
            'updated' => $updated,
            'skipped' => $skipped,
            'posts' => array_keys($updated_posts),
            'errors' => $errors
        ]);
        return response()->json([
            'success' => true,
            'operation' => $operation,
            'updated' => $updated,
            'skipped' => $skipped,
            'posts_updated' => count($updated_posts),
            'errors' => $errors
        ]);
    }
    
    /**
     * matatag tool crawler
     * @return \Illuminate\Http\JsonResponse
     */
        
        
    public function metatagtool_crawl(\Illuminate\Http\Request $request)
    {
        $url = $request->input('url');
        if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['error' => 'Invalid URL'], 422);
        }
        $urlParts = parse_url($url);
        $scheme = isset($urlParts['scheme']) ? strtolower($urlParts['scheme']) : '';
        $host = isset($urlParts['host']) ? strtolower($urlParts['host']) : '';
        if ($scheme !== 'https' || !in_array($host, ['damas.net', 'www.damas.net'], true)) {
            return response()->json(['error' => 'Only damas.net URLs are allowed'], 403);
        }
        $formatSchemas = function (array $rawSchemas) {
            $formattedSchemas = [];
            foreach ($rawSchemas as $rawSchema) {
                if (!is_string($rawSchema)) {
                    $rawSchema = json_encode($rawSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                }
                $decoded = json_decode($rawSchema, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $formattedSchemas[] = [
                        'raw' => $rawSchema,
                        'valid' => false,
                        'types' => [],
                        'error' => json_last_error_msg()
                    ];
                    continue;
                }
                $types = [];
                $collectTypes = function ($value) use (&$collectTypes, &$types) {
                    if (!is_array($value)) {
                        return;
                    }
                    if (isset($value['@type'])) {
                        $currentTypes = is_array($value['@type']) ? $value['@type'] : [$value['@type']];
                        foreach ($currentTypes as $currentType) {
                            if (is_string($currentType)) {
                                $types[] = $currentType;
                            }
                        }
                    }
                    foreach ($value as $child) {
                        if (is_array($child)) {
                            $collectTypes($child);
                        }
                    }
                };
                $collectTypes($decoded);
                $formattedSchemas[] = [
                    'raw' => $rawSchema,
                    'valid' => true,
                    'types' => array_values(array_unique($types)),
                    'error' => null
                ];
            }
            return $formattedSchemas;
        };
        $headHtml = '';
        $currentStatus = 0;
        $firstHttpStatus = null;
        $redirectChain = [];
        $stoppedAtHead = false;
        $headLimitReached = false;
        $maximumHeadSize = 262144;
        $responseHeaders = [];
        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_ENCODING => '',
            CURLOPT_USERAGENT => 'Damas-Metatag-Internal-Crawler/1.0',
            CURLOPT_PROTOCOLS => CURLPROTO_HTTPS,
            CURLOPT_REDIR_PROTOCOLS => CURLPROTO_HTTPS,
            CURLOPT_HEADERFUNCTION => function ($curl, $header) use (&$currentStatus, &$firstHttpStatus, &$redirectChain, &$headHtml, &$responseHeaders) {
                $trimmedHeader = trim($header);
                if ($trimmedHeader !== '') {
                    $responseHeaders[] = $trimmedHeader;
                }
                if (preg_match('/^HTTP\/\S+\s+(\d{3})/', $trimmedHeader, $matches)) {
                    $currentStatus = intval($matches[1]);
                    if ($currentStatus >= 200) {
                        if ($firstHttpStatus === null) {
                            $firstHttpStatus = $currentStatus;
                        }
                        $redirectChain[] = $currentStatus;
                    }
                    $headHtml = '';
                }
                return strlen($header);
            },
            CURLOPT_WRITEFUNCTION => function ($curl, $chunk) use (&$headHtml, &$currentStatus, &$stoppedAtHead, &$headLimitReached, $maximumHeadSize) {
                if ($currentStatus >= 300 && $currentStatus < 400) {
                    return strlen($chunk);
                }
                $headHtml .= $chunk;
                $headEnd = stripos($headHtml, '</head>');
                if ($headEnd !== false) {
                    $headHtml = substr($headHtml, 0, $headEnd + 7);
                    $stoppedAtHead = true;
                    return 0;
                }
                if (strlen($headHtml) >= $maximumHeadSize) {
                    $headLimitReached = true;
                    return 0;
                }
                return strlen($chunk);
            }
        ]);
        curl_exec($curl);
        $finalHttpStatus = intval(curl_getinfo($curl, CURLINFO_HTTP_CODE));
        $finalUrl = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
        $curlErrorNumber = curl_errno($curl);
        $curlError = curl_error($curl);
        curl_close($curl);
        if ($headLimitReached) {
            return response()->json(['error' => 'The page head exceeded 256 KB'], 413);
        }
        if ($curlErrorNumber && !($curlErrorNumber === CURLE_WRITE_ERROR && $stoppedAtHead)) {
            return response()->json([
                'error' => 'Crawler request failed',
                'details' => $curlError
            ], 502);
        }
        if ($finalHttpStatus === 403) {
            return response()->json([
                'error' => 'Crawler received 403',
                'headers' => $responseHeaders,
                'responseHtml' => $headHtml,
                'finalUrl' => $finalUrl
            ], 403);
        }
        if (empty($redirectChain)) {
            $redirectChain[] = $finalHttpStatus;
        }
        if ($firstHttpStatus === null) {
            $firstHttpStatus = $finalHttpStatus;
        }
        $rawSchemas = [];
        if ($headHtml !== '') {
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML('<?xml encoding="UTF-8">' . $headHtml);
            libxml_clear_errors();
            $xpath = new \DOMXPath($dom);
            $schemaScripts = $xpath->query('//script[contains(translate(@type, "ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz"), "application/ld+json")]');
            foreach ($schemaScripts as $schemaScript) {
                $json = trim($schemaScript->textContent);
                $json = preg_replace('/^\xEF\xBB\xBF/', '', $json);
                $json = preg_replace('/^\s*<!--|-->\s*$/', '', $json);
                if ($json !== '') {
                    $rawSchemas[] = $json;
                }
            }
        }
        $storedStatuses = json_encode(array_values($redirectChain));
        $storedSchemas = json_encode($rawSchemas, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        \DB::transaction(function () use ($url, $storedStatuses, $storedSchemas) {
            \DB::table('links_status')->where('link', $url)->delete();
            \DB::table('links_status')->insert([
                'link' => $url,
                'status' => $storedStatuses,
                'schema_json' => $storedSchemas
            ]);
        });
        return response()->json([
            'url' => $url,
            'httpStatus' => $redirectChain,
            'firstHttpStatus' => $firstHttpStatus,
            'finalHttpStatus' => $finalHttpStatus,
            'finalUrl' => $finalUrl,
            'redirectChain' => $redirectChain,
            'schemas' => $formatSchemas($rawSchemas),
            'cached' => false
        ]);
    }
        
    /**
     * Update Metatag Tool fields.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
        
    public function metatagtool_update(\Illuminate\Http\Request $request)
    {
        $changes = $request->json()->all();
        if (!is_array($changes) || count($changes) === 0) {
            return response()->json([
                'success' => false,
                'error' => 'No changes were provided'
            ], 422);
        }
        if (count($changes) > 5000) {
            return response()->json([
                'success' => false,
                'error' => 'Too many changes were provided'
            ], 413);
        }
        $allowedTypes = ['post', 'project', 'listing'];
        $allowedFields = [
            'title',
            'title_ar',
            'title_en',
            'seo_title_ar',
            'seo_title_en',
            'seo_description_ar',
            'seo_description_en'
        ];
        foreach ($changes as $change) {
            if (!is_array($change)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid change format'
                ], 422);
            }
            if (!isset($change['id']) || !is_numeric($change['id'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'A valid row ID is required'
                ], 422);
            }
            if (!isset($change['type']) || !in_array($change['type'], $allowedTypes, true)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid row type'
                ], 422);
            }
            foreach ($allowedFields as $field) {
                if (array_key_exists($field, $change) && !is_string($change[$field])) {
                    return response()->json([
                        'success' => false,
                        'error' => 'Invalid value for ' . $field
                    ], 422);
                }
            }
        }
        \DB::beginTransaction();
        try {
            $processedRows = 0;
            $updatedFields = 0;
            foreach ($changes as $change) {
                $id = intval($change['id']);
                $type = $change['type'];
                $updates = [];
                foreach ([
                    'seo_title_ar',
                    'seo_title_en',
                    'seo_description_ar',
                    'seo_description_en'
                ] as $field) {
                    if (array_key_exists($field, $change)) {
                        $updates[$field] = $change[$field];
                        $updatedFields++;
                    }
                }
                if ($type === 'post') {
                    $postExists = \DB::table('posts')->where('id', $id)->first();
                    if (!$postExists) {
                        throw new \Exception('Post not found: ' . $id);
                    }
                    foreach (['title_ar', 'title_en'] as $field) {
                        if (array_key_exists($field, $change)) {
                            $updates[$field] = $change[$field];
                            $updatedFields++;
                        }
                    }
                    if (!empty($updates)) {
                        \DB::table('posts')->where('id', $id)->update($updates);
                        $processedRows++;
                    }
                    continue;
                }
                if ($type === 'project') {
                    $project = \App\Models\Project::with([
                        'types',
                        'categories',
                        'city',
                        'region'
                    ])->find($id);
                    if (!$project) {
                        throw new \Exception('Project not found: ' . $id);
                    }
                    $hasArabicH1Change = array_key_exists('title_ar', $change);
                    $hasEnglishH1Change = array_key_exists('title_en', $change);
                    $hasH1Change = $hasArabicH1Change || $hasEnglishH1Change;
                    $hasArabicH1Change = array_key_exists('title_ar', $change);
                    $hasEnglishH1Change = array_key_exists('title_en', $change);
                    $hasH1Change = $hasArabicH1Change || $hasEnglishH1Change;
                    if ((int)$project->sold === 100 && $hasH1Change) {
                        throw new \Exception('Sold-out project has no rendered H1: ' . $id);
                    }
                    if ($hasH1Change) {
                        $generatedArabicH1 = Helper::generate_project_default_h1($project, 'ar');
                        $generatedEnglishH1 = Helper::generate_project_default_h1($project, 'en');
                        $currentArabicH1 = (int)$project->has_special_h1 === 1 && trim((string)$project->special_h1_ar) !== ''
                            ? $project->special_h1_ar
                            : $generatedArabicH1;
                        $currentEnglishH1 = (int)$project->has_special_h1 === 1 && trim((string)$project->special_h1_en) !== ''
                            ? $project->special_h1_en
                            : $generatedEnglishH1;
                        $updates['special_h1_ar'] = $hasArabicH1Change
                            ? $change['title_ar']
                            : $currentArabicH1;
                        $updates['special_h1_en'] = $hasEnglishH1Change
                            ? $change['title_en']
                            : $currentEnglishH1;
                        $updates['has_special_h1'] = 1;
                        if ($hasArabicH1Change) {
                            $updatedFields++;
                        }
                        if ($hasEnglishH1Change) {
                            $updatedFields++;
                        }
                    }
                    if (!empty($updates)) {
                        \DB::table('projects')->where('id', $id)->update($updates);
                        $processedRows++;
                    }
                    continue;
                }
                if ($type === 'listing') {
                    $listing = \DB::table('page_search')
                        ->select('id')
                        ->where('id', $id)
                        ->first();
                    if (!$listing) {
                        throw new \Exception('Listing not found: ' . $id);
                    }
                    foreach (['title', 'title_en'] as $field) {
                        if (array_key_exists($field, $change)) {
                            $updates[$field] = $change[$field];
                            $updatedFields++;
                        }
                    }
                    if (!empty($updates)) {
                        \DB::table('page_search')->where('id', $id)->update($updates);
                        $processedRows++;
                    }
                    continue;
                }
            }
            \DB::commit();
            return response()->json([
                'success' => true,
                'processedRows' => $processedRows,
                'updatedFields' => $updatedFields,
                'message' => $processedRows . ' row' . ($processedRows === 1 ? '' : 's') . ' updated successfully'
            ]);
        } catch (\Exception $error) {
            \DB::rollBack();
            \Log::error('Metatag Tool update failed', [
                'error' => $error->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'The database update failed',
                'details' => $error->getMessage()
            ], 500);
        }
    }
        
    /**
    * params index
    *
    * @return void
    */
    public function params_index()
    {
        $rows = Helper::query("Param", "paginate");
        return view("admin.params.index", compact("rows"));
    }
    
    /**
    * params edit
    *
    * @param Illuminate\Http\Request $request
    * @param int $id
    * @return void
    */
    public function params_edit(Request $request, $id = null)
    {
        $row = Helper::query("Param", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "name"  =>  "required",
                "email"  =>  "required",
                "seo_title"  =>  "required",
                "seo_description"  =>  "required",
            ]);
            $inputs = $request->all();
			$inputs["parag_index_content"] = htmlentities($inputs["parag_index_content"]);
            $inputs["user_email_send"] = @$inputs["user_email_send"] ? 1 : 0;
            return Helper::query("Param", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
                "route"     =>  "admin.params",
            ]);
        }
        return view("admin.params.edit", compact("row"));
    }
	
	
    /**
    * sitemap index
    *
    * @return void
    */
    public function sitemap_index()
    {
        $rows = Helper::query("Sitemap", "paginate");
        return view("admin.sitemap.index", compact("rows"));
    }
    /**
    * sitemap index
    *
    * @return void
    */
    /*public function sitemap_list_cat($id)
    {
        //$rows = Helper::query("Sitemap", "paginate");
        //$rows = Helper::query("Sitemap")->where("id",($id==1?'ar':'en'));
		$r = Helper::query("Sitemap", "find", ['id' => $id]);
		$rows = Helper::query("SitemapCats", "paginate");
        return view("admin.sitemap_cat.index", compact("rows","r"));
    }*/
    
    /**
    * sitemap edit
    *
    * @param Illuminate\Http\Request $request
    * @param int $id
    * @return void
    */
   /* public function sitemap_list_cat_edit(Request $request, $id = null)
    {
        $row = Helper::query("SitemapCats", "find", ['id' => $id]);
		$r = Helper::query("Sitemap", "find", ['id' =>  $row->sitemap]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "title"  =>  "required",
                "links"  =>  "required",
            ]);
            $inputs = $request->all();
            return Helper::query("SitemapCats", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
                "route"     =>  "admin.sitemap",
            ]);
        }
        return view("admin.sitemap_cat.edit", compact("row"));
    }*/
    /**
    * sitemap edit
    *
    * @param Illuminate\Http\Request $request
    * @param int $id
    * @return void
    */
    public function sitemap_edit(Request $request, $id = null)
    {
        $row = Helper::query("Sitemap", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "title"  =>  "required",
                "seo_title"  =>  "required",
                "seo_description"  =>  "required",
            ]);
            $inputs = $request->all();
            return Helper::query("Sitemap", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
                "route"     =>  "admin.sitemap",
            ]);
		}
        return view("admin.sitemap.edit", compact("row"));
    }
    
	
	
	
	
	
	
    /**
    * menus
    *
    * @return void
    */
    public function sitemap_cat(Request $request, $id = null)
    {
        $menu = Helper::query("SitemapCats", "find", ["id" => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "title_ar" =>  "required",
                "link_type" =>  "required",
            ]);
            $inputs = $request->all();
            $inputs["parent_id"] = @$inputs["parent_id"] ? $inputs["parent_id"] : 0;
            $link_type = @$inputs["link_type"];
            $link_value = @$inputs["link_value"];
            if ( $link_type != "url" ) {
                $inputs["link"] = Helper::get_link_url($link_type, $link_value);
            }
            $inputs["link_en"] = str_replace("damas.net", "damas.net/en", $inputs["link"]);
            
			/*echo '<pre>';
			print_r($inputs);
			echo '</pre>';
			exit;*/
			Helper::query("SitemapCats", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
            ]);
            //return redirect()->back();
			
			return redirect()->route("admin.sitemap_cat");
        }
        return view("admin.sitemap_cat.menus", compact("menu"));
    }
    
    /**
    * delete menu
    *
    * @param int $id
    * @return void
    */
    public function sitemap_cat_delete($id)
    {
        return Helper::query("SitemapCats", "delete", ["id" => $id]);
    }
	
	
	
	
    /**
    * notifications index
    *
    * @return void
    */
    public function notifs_index()
    {
        $rows = Helper::query("Notif", "paginate");
        return view("admin.notifs.index", compact("rows"));
    }
    
    /**
    * notifications delete
    *
    * @param int $id
    * @return void
    */
    public function notifs_delete($id)
    {
        return Helper::query("Notif", "delete", ["id" => $id]);
    }








    /**
    * messages index
    *
    * @return void
    */
    public function messages_index()
    {
		$where = [];
		
		if(isset($_GET['type']) or isset($_GET['filterdate'])){
			if(isset($_GET['type']) and $_GET['type']!=0)
				if($_GET['type']=='1')
					$where[] = ['whatsapp_id','=',0];
				else //2
					$where[] = ['whatsapp_id','>',0];

			if(isset($_GET['filterdate']))
			switch($_GET['filterdate']){
				case 'today':
					//$where[] = ['created_at', '>=' , DB::raw('NOW() - INTERVAL 1 DAY')];
					$where[] = [DB::raw('DATE(created_at)'), '=' , DB::raw('CURRENT_DATE')];
				break;
				case "yesterday":
					$where[] = [ DB::raw('DATE(created_at)'), '=' ,DB::raw('CURRENT_DATE - INTERVAL 1 DAY') ];
				break;
				case "last7days":
					$where[] = ['created_at', '>=' , DB::raw('NOW() - INTERVAL 7 DAY')];
				break;
				case "last15days":
					$where[] = ['created_at', '>=' , DB::raw('NOW() - INTERVAL 15 DAY')];
				break;
				case "thismonth":
					$where[] = [DB::raw('MONTH(created_at)'), '=' , DB::raw('MONTH(CURRENT_DATE)')];
					$where[] = [DB::raw('YEAR(created_at)'), '=' , DB::raw('YEAR(CURRENT_DATE)')];
				break;
				case "lastmonth":
					$where[] = [DB::raw('YEAR(created_at)') ,'=', DB::raw('YEAR(CURRENT_DATE - INTERVAL 1 MONTH)')];
					$where[] = [DB::raw('MONTH(created_at)') ,'=', DB::raw('MONTH(CURRENT_DATE - INTERVAL 1 MONTH)')];
				break;
				}



			$rows = Helper::query("Message", "paginate", $where);
		}else{
			$rows = Helper::query("Message", "paginate");
		}
        return view("admin.messages.index", compact("rows"));
    }

    /**
    * messages_landing index
    *
    * @return void
    */
    public function messages_landing_index()
    {
		$where = [];
		
		if(isset($_GET['type']) or isset($_GET['filterdate'])){
			if(isset($_GET['type']) and $_GET['type']!=0)
				if($_GET['type']=='1')
					$where[] = ['whatsapp_id','=',0];
				else //2
					$where[] = ['whatsapp_id','>',0];

			if(isset($_GET['filterdate']))
			switch($_GET['filterdate']){
				case 'today':
					//$where[] = ['created_at', '>=' , DB::raw('NOW() - INTERVAL 1 DAY')];
					$where[] = [DB::raw('DATE(created_at)'), '=' , DB::raw('CURRENT_DATE')];
				break;
				case "yesterday":
					$where[] = [ DB::raw('DATE(created_at)'), '=' ,DB::raw('CURRENT_DATE - INTERVAL 1 DAY') ];
				break;
				case "last7days":
					$where[] = ['created_at', '>=' , DB::raw('NOW() - INTERVAL 7 DAY')];
				break;
				case "last15days":
					$where[] = ['created_at', '>=' , DB::raw('NOW() - INTERVAL 15 DAY')];
				break;
				case "thismonth":
					$where[] = [DB::raw('MONTH(created_at)'), '=' , DB::raw('MONTH(CURRENT_DATE)')];
					$where[] = [DB::raw('YEAR(created_at)'), '=' , DB::raw('YEAR(CURRENT_DATE)')];
				break;
				case "lastmonth":
					$where[] = [DB::raw('YEAR(created_at)') ,'=', DB::raw('YEAR(CURRENT_DATE - INTERVAL 1 MONTH)')];
					$where[] = [DB::raw('MONTH(created_at)') ,'=', DB::raw('MONTH(CURRENT_DATE - INTERVAL 1 MONTH)')];
				break;
				}



			$rows = Helper::query("MessageLandingTourism", "paginate", $where);
		}else{
			$rows = Helper::query("MessageLandingTourism", "paginate");
		}
        return view("admin.messages_landing_tourism.index", compact("rows"));
    }
	
    /**
    * messages index
    *
    * @return void
    */
    public function quizs_index()
    {
		$rows = Helper::query("Quiz", "paginate");
        return view("admin.quizs.index", compact("rows"));
    }
    
    /**
    * messages edit
    *
    * @param int $id
    * @return void
    */
    public function messages_edit(Request $request, $id = null)
    {
        $row = Helper::query("Message", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            //$this->validate($request, []);
            $inputs = $request->all();
            $inputs["manual_insert"] = 1;
            Helper::query("Message", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
            ]);
            return redirect()->route("admin.messages");
        }
        return view("admin.messages.edit", compact("row"));
    }
    
    /**
    * messages delete
    *
    * @param int $id
    * @return void
    */
    public function messages_delete($id)
    {
        return Helper::query("Message", "delete", ["id" => $id]);
    }
    /**
    * quizs delete
    *
    * @param int $id
    * @return void
    */
    public function quizs_delete($id)
    {
        return Helper::query("Quiz", "delete", ["id" => $id]);
    }
	








    /**
    * messagesvac index
    *
    * @return void
    */
    public function messagesvac_index()
    {
        $rows = Helper::query("Messagevac", "paginate");
        return view("admin.messagesvac.index", compact("rows"));
    }
    /**
    * messagesvac delete
    *
    * @param int $id
    * @return void
    */
    public function messagesvac_delete($id)
    {
        return Helper::query("Messagevac", "delete", ["id" => $id]);
    }
	
	

    /**
    * redirect_short index
    *
    * @return void
    */
    public function redirect_short_index()
    {
        $rows = Helper::query("RedirectShort", "paginate");
        return view("admin.redirect_short.index", compact("rows"));
    }
    /**
    * messagesvac delete
    *
    * @param int $id
    * @return void
    */
    public function redirect_short_delete($id)
    {
        return Helper::query("RedirectShort", "delete", ["id" => $id]);
    }


    public function redirect_short_edit(Request $request, $id = null)
    {
        $row = Helper::query("RedirectShort", "find", ['id' => $id]);
        //$row = array();
        if ( $request->isMethod('post') ) {
            $inputs = $request->all();
			$this->validate($request, [
                "url" =>  "required"
            ]);

            //$inputs["slug"] = \App\Myclass\PseudoCrypt::hash('10',3);
            $last = Helper::query("RedirectShort", "save", [
                "inputs"    =>  $inputs,
                //"id"        =>  $id,
            ]);

			$link = \App\Models\RedirectShort::where('id',$last->id)->first();
			$link->slug =  \App\Myclass\PseudoCrypt::hash($last->id,3);
			$link->save();

            return redirect()->route("admin.redirect_short");
        }

        return view("admin.redirect_short.edit", compact("row"));
    }
	
	
	
    
    /**
    * whatsapp_msg index
    *
    * @return void
    */
    public function whatsapp_msg_index()
    {
        
		$where = [];
		$where[] = ['deleted','=',0];
		
		
		if(isset($_GET['manual_insert']) or isset($_GET['filterdate'])){
			if(isset($_GET['manual_insert']) and $_GET['manual_insert']!=0)
				$where[] = ['manual_insert','=',($_GET['manual_insert']==2?0:1)];
			if(isset($_GET['filterdate']))
				
			switch($_GET['filterdate']){
				case 'today':
					//$where[] = ['created_at', '>=' , DB::raw('NOW() - INTERVAL 1 DAY')];
					$where[] = [DB::raw('DATE(created_at)'), '=' , DB::raw('CURRENT_DATE')];
				break;
				case "yesterday":
					$where[] = [ DB::raw('DATE(created_at)'), '=' ,DB::raw('CURRENT_DATE - INTERVAL 1 DAY') ];
				break;
				case "last7days":
					$where[] = ['created_at', '>=' , DB::raw('NOW() - INTERVAL 7 DAY')];
				break;
				case "last15days":
					$where[] = ['created_at', '>=' , DB::raw('NOW() - INTERVAL 15 DAY')];
				break;
				case "thismonth":
					$where[] = [DB::raw('MONTH(created_at)'), '=' , DB::raw('MONTH(CURRENT_DATE)')];
					$where[] = [DB::raw('YEAR(created_at)'), '=' , DB::raw('YEAR(CURRENT_DATE)')];
				break;
				case "lastmonth":
					$where[] = [DB::raw('YEAR(created_at)') ,'=', DB::raw('YEAR(CURRENT_DATE - INTERVAL 1 MONTH)')];
					$where[] = [DB::raw('MONTH(created_at)') ,'=', DB::raw('MONTH(CURRENT_DATE - INTERVAL 1 MONTH)')];
				break;
				}



			$rows = Helper::query("Whatsappmsg", "paginate", $where);
		}else{
			$rows = Helper::query("Whatsappmsg", "paginate",$where);
		}
		
        return view("admin.whatsapp_msg.index", compact("rows"));
    }
    
	
    /**
    * whatsapp_msg edit
    *
    * @param int $id
    * @return void
    */
     public function whatsapp_msg_edit(Request $request, $id = null)
    {
        
        $row = Helper::query("Whatsappmsg", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
				"mobile" =>  "required"
			]);
            $inputs = $request->all();
			
			//$inputs['navigation'] = @$_COOKIE["navigation"];
            $inputs["manual_insert"] = 1;
			
		
		    $inputs['code'] = Helper::getNextLeadCode($inputs["crm"]);
			
			DB::connection('mysql_crm'.$inputs["crm"])->table('params')->where("id", '1')->update(['last_lead_code'=>$inputs['code']]);
			
			
            Helper::query("Whatsappmsg", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
            ]);
			// ZOHO CRM insert contact
				$row = Helper::query("Whatsappmsg", "find", ['id' => $id]);
				
				$row->code = $inputs['code'];
                $insert_crm = $this->insert_crm_contact($row,0,$inputs["crm"]);
                //$rres = $this->zoho_insert_contact($row);

				$e= (array)$row['attributes'];
				//unset($e['id']);
				$e['code'] = $inputs["code"];
				$e['whatsapp_id'] = $id;
				$e['insert_crm'] = $insert_crm;
				$e['ccountry'] = ($inputs["crm"]==''?'turkey':$inputs["crm"]);
				
				
				
				
				
				//$e['zoho'] = $rres;

			/*
			echo '<pre>';
			print_r($e);
			exit();
			*/
			
			

				Helper::query("Message", "save", [
                "inputs"    =>  $e
				]);
				

            return redirect()->route("admin.whatsapp_msg");
        }
        return view("admin.whatsapp_msg.edit", compact("row"));
    }
	
    /**
    * backup_msg index
    *
    * @return void
    */
    public function backup_msg_index()
    {
		
		DB::delete("delete FROM `dms_messages3` where message like '%viagra%' or message like '%drugs%' or message like '%pharmacy%'
		 or length(mobile)<5
		 or message like '%casino%'
		 or message like '% seo %'
		 or message like '%[url%'
		 or message like '% sex%'
		 or message like '% porn%'
		 or message like '% Weight loss%'
		 or (message like '%http://%' and message not like '%damas.net%')
		 or (message like '%https://%' and message not like '%damas.net%')");
		
		
		DB::delete("delete FROM `dms_messages3` where REPLACE(`mobile`, ' ', '') in (select REPLACE(`mobile`, ' ', '') from dms_messages)");
        
		
		/*$where = [];
		
		if(isset($_GET['manual_insert']) or isset($_GET['filterdate'])){
			if(isset($_GET['manual_insert']) and $_GET['manual_insert']!=0)
				$where[] = ['manual_insert','=',($_GET['manual_insert']==2?0:1)];
			if(isset($_GET['filterdate']))
				
			switch($_GET['filterdate']){
				case 'today':
					//$where[] = ['created_at', '>=' , DB::raw('NOW() - INTERVAL 1 DAY')];
					$where[] = [DB::raw('DATE(created_at)'), '=' , DB::raw('CURRENT_DATE')];
				break;
				case "yesterday":
					$where[] = [ DB::raw('DATE(created_at)'), '=' ,DB::raw('CURRENT_DATE - INTERVAL 1 DAY') ];
				break;
				case "last7days":
					$where[] = ['created_at', '>=' , DB::raw('NOW() - INTERVAL 7 DAY')];
				break;
				case "last15days":
					$where[] = ['created_at', '>=' , DB::raw('NOW() - INTERVAL 15 DAY')];
				break;
				case "thismonth":
					$where[] = [DB::raw('MONTH(created_at)'), '=' , DB::raw('MONTH(CURRENT_DATE)')];
					$where[] = [DB::raw('YEAR(created_at)'), '=' , DB::raw('YEAR(CURRENT_DATE)')];
				break;
				case "lastmonth":
					$where[] = [DB::raw('YEAR(created_at)') ,'=', DB::raw('YEAR(CURRENT_DATE - INTERVAL 1 MONTH)')];
					$where[] = [DB::raw('MONTH(created_at)') ,'=', DB::raw('MONTH(CURRENT_DATE - INTERVAL 1 MONTH)')];
				break;
				}



			$rows = Helper::query("Message3", "paginate", $where);
		}else{
			$rows = Helper::query("Message3", "paginate");
		}*/
		$rows = Helper::query("Message3", "paginate");
		
        return view("admin.backup_msg.index", compact("rows"));
    }
    
	
    /**
    * backup_msg edit
    *
    * @param int $id
    * @return void
    */
     public function backup_msg_edit(Request $request, $id = null)
    {
        $row = Helper::query("Message3", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
				"mobile" =>  "required"
			]);
            $inputs = $request->all();
			
			//$inputs['navigation'] = @$_COOKIE["navigation"];
            $inputs["backup_table"] = 1;
            
			$inputs['code'] = Helper::getNextLeadCode();
			DB::connection('mysql_crm')->table('params')->where("id", '1')->update(['last_lead_code'=>$inputs['code']]);
			
			/*Helper::query("Message3", "save", [
                "inputs"    =>  $inputs
				]);*/
			

				$row = Helper::query("Message3", "find", ['id' => $id]);
				
				$row->code = $inputs['code'];
				$row->mobile = $inputs['mobile'];
				$row->message = $inputs['message'];
				$row->name = $inputs['name'];
				$row->backup_table = 1;
				$row->save();
                
				$insert_crm = $this->insert_crm_contact($row,1);
                
				
            return redirect()->route("admin.backup_msg");
        }
        return view("admin.backup_msg.edit", compact("row"));
    }
     public function wordsearch_edit(Request $request, $id = null)
    {
        $row = Helper::query("WordSearch", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            //$this->validate($request, []);
            $inputs = $request->all();
			echo $id;
			/*
            echo '<pre>';
			print_r($inputs);
            echo '</pre>';
			exit;*/
            Helper::query("WordSearch", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
            ]);
			return redirect()->route("admin.wordsearch");
        }
        return view("admin.wordsearch.edit", compact("row"));
    }
     public function redirectsearch_edit(Request $request, $id = null)
    {
        $row = Helper::query("RedirectSearch", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            //$this->validate($request, []);
            $inputs = $request->all();
			echo $id;
			/*
            echo '<pre>';
			print_r($inputs);
            echo '</pre>';
			exit;*/
            Helper::query("RedirectSearch", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
            ]);
			return redirect()->route("admin.redirectsearch.edit",$id);
        }
        return view("admin.redirectsearch.edit", compact("row"));
    }
	public function redirectsearchprojects_index(Request $request, $id = null)
    {

		$data['citys'] = Helper::query("City", "all");
		$data['regions'] = Helper::query("Region", "all");
		$data['types'] = Helper::query("ProjectType", "all");
		//$data['tags'] = Helper::query("ProjectCategory", "all");
		$data['tags'] = Helper::query("ProjectCategory", "where", ["field" => "hide_search_page", "value" => false])->get();
		$data['row'] = Helper::query("Redirectsearchprojects", "all");


        if ( $request->isMethod('post') ) {
            //$this->validate($request, []);
            $inputs = $request->all();
			//echo $id;
			
			DB::delete("TRUNCATE TABLE `dms_projectssearchkeywords`");
			foreach($inputs['words'] as $class=>$arr){
				foreach($arr as $slug=>$keywords){
					Helper::query("Projectssearchkeywords", "save", ["inputs"=>['class'=>$class,'slug'=>$slug,'keywords'=>$keywords]]);
					}
			}
			
			/*
            echo '<pre>';
			print_r($inputs);
            echo '</pre>';
			exit;
			
			$data["inputs"] = $inputs;
			$data["id"] = $id;
            */
			//Helper::query("Redirectsearchprojects", "save", $data);
			return redirect()->route("admin.redirectsearchprojects");
        }
        return view("admin.redirectsearchprojects.index", $data);
    }
    /**
    * whatsapp_msg edit
    *
    * @param int $id
    * @return void
    */
    public function statistics_index(Request $request, $id = null)
    {
		$countrys = DB::select("SELECT distinct country FROM `stat_house_sales` WHERE country!=''");
		$citys = DB::select("SELECT distinct city FROM `stat_house_sales` WHERE city!=''");
        //$row = Helper::query("Whatsappmsg", "find", ['id' => $id]);
		$data = array();
		if(Input::get('year') and Input::get('month') and Input::get('type')){
		$data = DB::select("SELECT * FROM `stat_house_sales` WHERE year=? and imonth=? and type=?",array(Input::get('year'),Input::get('month'),Input::get('type')));
		//find if exist edit if not insert
		//get_adm_statistics(Input::get('year'),Input::get('month'),Input::get('type'))
		}
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "type"   =>  "required",
                "month"   =>  "required",
                "year"   =>  "required",
            ]);
            $inputs = $request->all();
			
			
			/*
			foreach($inputs['value'] as $city=>$value)
				echo $city .' => '. $value.'<br>';

			echo '<pre>';
			print_r($inputs);
			echo '</pre>';
			exit;
			*/
			if($inputs['type'] == 'country'){
				foreach($inputs['value'] as $country=>$value){
					$t = DB::select("SELECT * FROM `stat_house_sales` WHERE year=? and imonth=? and type=? and country=?",
						array($inputs['year'],$inputs['month'],$inputs['type'],$country));
					if(count($t)>0){
						DB::update("UPDATE `stat_house_sales` SET `value`=? WHERE id=?",array($value,$t[0]->id));
/*
echo "UPDATE `stat_house_sales` SET `value`=? WHERE year=? and month=? and type=? and country=?";
echo $value.','.$inputs['year'].','.$inputs['month'].','.$inputs['type'].','.$country;
exit;*/
					}else{
						DB::insert("INSERT INTO `stat_house_sales`(`year`,`country`, `country_ar`, `month`, `imonth`, `value`, `type`) 
						VALUES (?,?,?,?,?,?,?)",array($inputs['year'],$country,$this->get_country_ar($country),$this->get_month($inputs['month']),$inputs['month'],$value, 'country' ));
					}
				}
			}elseif($inputs['type'] == 'city'){
				foreach($inputs['value'] as $city=>$value){
					$t = DB::select("SELECT * FROM `stat_house_sales` WHERE year=? and imonth=? and type=? and city=?",
						array($inputs['year'],$inputs['month'],$inputs['type'],$city));
					if(count($t)>0){
						DB::update("UPDATE `stat_house_sales` SET `value`=? WHERE id=?",array($value,$t[0]->id));
					}else{
						DB::insert("INSERT INTO `stat_house_sales`(`year`, `city`, `city_ar`, `month`, `imonth`, `value`, `type`) 
						VALUES (?,?,?,?,?,?,?)",array($inputs['year'],$city,$this->get_city_ar($city),$this->get_month($inputs['month']),$inputs['month'],$value, 'city' ));
					}
				}
				//echo $city .' => '. $value.'<br>';
				
			}
			
			
			
			
			//$inputs['navigation'] = @$_COOKIE["navigation"];
            /*$inputs["manual_insert"] = 1;
            Helper::query("Whatsappmsg", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
            ]);*/
			// ZOHO CRM insert contact
				//$row = Helper::query("Whatsappmsg", "find", ['id' => $id]);
              return redirect()->back();  
            //return redirect()->route("admin.satatistics.index");
        }
        return view("admin.satatistics.index", compact("data","citys","countrys"));
    }
	
	
	public function get_country_ar($country){
		$t = DB::select("SELECT country_ar FROM `stat_house_sales` WHERE country=? limit 1",array($country));
		
		return @$t[0]->country_ar;
	}
	public function get_city_ar($city){
		$t = DB::select("SELECT city_ar FROM `stat_house_sales` WHERE city=? limit 1",array($city));
		
		return @$t[0]->city_ar;
	}
	public function get_month($imonth){
		$t = DB::select("SELECT month FROM `stat_house_sales` WHERE imonth=? limit 1",array($imonth));
		
		return @$t[0]->month;
	}
    /**
    * whatsapp_msg delete
    *
    * @param int $id
    * @return void
    */
    public function statistics_delete($id)
    {
        //return Helper::query("Whatsappmsg", "delete", ["id" => $id]);
    }
	public function backup_msg_delete($id)
    {
        return Helper::query("Message3", "delete", ["id" => $id]);
    }
    public function search_delete($id)
    {
        return Helper::query("Search", "delete", ["id" => $id]);
    }
    /**
    * search index
    *
    * @return void
    */
    public function search_index()
    {
        $rows = Helper::query("Search", "where", ["field" => "lang", "value" => $_GET['lang']])->orderBy($_GET['field'], $_GET['sort'])->paginate(Helper::ajax_change_paginate_number());
		//
		//$rows = Helper::query("Search", "paginate");
        
		
		return view("admin.search.index", compact("rows"));
    }
    public function wordsearch_delete($id)
    {
        return Helper::query("WordSearch", "delete", ["id" => $id]);
    }
    /**
    * search index
    *
    * @return void
    */
    public function wordsearch_index()
    {
        $rows = Helper::query("WordSearch", "paginate");
        return view("admin.wordsearch.index", compact("rows"));
    }
    public function redirectsearch_index()
    {
        $rows = Helper::query("RedirectSearch", "paginate");
        return view("admin.redirectsearch.index", compact("rows"));
    }
    /*public function redirectsearchprojects_index()
    {
        $rows = Helper::query("Redirectsearchprojects", "paginate");
        return view("admin.redirectsearchprojects.index", compact("rows"));
    }*/
    /**
    * whatsapp_msg download
    *
    * @param int $id
    * @return void
    */
    public function whatsapp_msg_download(Request $request)
    {
	$arrs = DB::select("SELECT id,ADDDATE(created_at, INTERVAL 6 HOUR) as 'created_date',page,gclid,download FROM `dms_whatsapp_msg` 
		WHERE download=0 and gclid!='' and manual_insert=1 and deleted=0
		ORDER BY `dms_whatsapp_msg`.`id` DESC",[]);
		
		
		
		$ar_csv = array(array('Google Click ID','Conversion Name','Conversion Time','Conversion Value','Conversion Currency'));
		
		foreach($arrs as $r){
			$t = array();
			$t[] = $r->gclid;
			$t[] = "whatsapp lead";
			$t[] = $r->created_date.' Etc/GMT';
			$t[] = '0';
			$t[] = 'TRY';
			$ar_csv[] = $t;
			
			//DB::update("update dms_whatsapp_msg set download = 1 where id=?",[$r->id]);
		}

		$this->array_to_csv_download($ar_csv,"whatsapp lead ".date('Y-m-d').".csv", ",");
		//return redirect()->back();
    }

    /**
    * whatsapp_msg delete
    *
    * @param int $id
    * @return void
    */
    public function whatsapp_msg_delete($id)
    {
		
		DB::update("update dms_whatsapp_msg set deleted = 1 where id=?",[$id]);
		session()->flash("flashmessage", ["typ" => "success", "message" => "تم الحذف بنجاح"]);
		return redirect()->back();
        //return Helper::query("Whatsappmsg", "delete", ["id" => $id]);
    }
	function array_to_csv_download($array, $filename = "export.csv", $delimiter=",") {
		header('Content-Type: application/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'";');

		$f = fopen('php://output', 'w');

		foreach ($array as $line) {
			fputcsv($f, $line, $delimiter);
		}
		
	}
	
    function insert_crm_contact($inputs = [],$backup_table=0,$crm='')
    {
		
		
		$is_src = false;
		foreach ( Helper::query("ClientSource", "orderBy", ["field" => "src", "value" => "DESC"])->get() as $row ) {
			if (strpos(strtolower(@$inputs["src"]), strtolower($row->src)) !== false) {
				$inputs['src'] = $row->code;
				$is_src = true;
				break;
			}
		}
		if(strpos(strtolower($inputs["src"]), 'ampproject') !== false)
			$inputs['src'] = 'Google AMP';
		elseif(strpos(strtolower($inputs["src"]), 'mail.google.com') !== false)
			$inputs['src'] = 'Gmail';
		elseif(trim($inputs["src"]) == 'دخول مباشر')
			$inputs['src'] = 'Direct';
		elseif(strpos(strtolower($inputs["src"]), 'google') !== false)
			$inputs['src'] = 'Google';
		elseif(strpos(strtolower($inputs["src"]), 'facebook') !== false)
			$inputs['src'] = 'Facebook';
		elseif(strpos(strtolower($inputs["src"]), 'youtube') !== false)
			$inputs['src'] = 'Youtube';
			
		/*$inputs['src'] = str_replace('wwww.','',$inputs['src']);
		if(in_array(substr($inputs['src'], -4) , ['.net','.com']))
			$inputs['src'] = substr($inputs['src'], 0,-4);*/
		
		
		
		
		if($inputs['src'] == 'Direct' && strpos(strtolower(@$inputs["page"]), 'damasturk') === false){

			$inputs['src'] = @$inputs["page"];
			
			if(strpos(strtolower($inputs["src"]), 'ampproject') !== false)
				$inputs['src'] = 'Google AMP';
			elseif(strpos(strtolower($inputs["src"]), 'mail.google.com') !== false)
				$inputs['src'] = 'Gmail';
			elseif(strpos(strtolower($inputs["src"]), 'google') !== false)
				$inputs['src'] = 'Google';
			elseif(strpos(strtolower($inputs["src"]), 'facebook') !== false)
				$inputs['src'] = 'Facebook';
			elseif(strpos(strtolower($inputs["src"]), 'instagram') !== false)
				$inputs['src'] = 'Instagram';
			elseif(strpos(strtolower($inputs["src"]), 'youtube') !== false)
				$inputs['src'] = 'Youtube';
			
		}
		
			$inputs['src'] = str_replace('wwww.','',$inputs['src']);
			if(in_array(substr($inputs['src'], -4) , ['.net','.com']))
				$inputs['src'] = substr($inputs['src'], 0,-4);
		
		
		
		$current_lang = $inputs['lang'];
		
		//$inputs['mobile'] = str_replace( "+","", $inputs['mobile']);
		$fame = $inputs["fame"]?:".";
		
		
		$inputs['name'] = $inputs['name'];
		$inputs['email'] = $inputs['email'];
		$inputs['mobile'] = $inputs['mobile'];
		$inputs['message'] = $inputs['message'];
		$inputs['page'] = str_replace('www-damas-net.cdn.ampproject.org/v/s/','',strtok($inputs['page'], '?'));
		$inputs['src'] = str_replace('www-damas-net.cdn.ampproject.org/v/s/','',strtok($inputs['src'], '?'));
		$inputs['country'] = Helper::code_to_country($inputs['country'],false);
		$inputs['navigation'] = strtok($inputs['navigation'], '?');
		
		
		//########### Insert to CRM ###################
		if(isset($inputs['is_damas_net']))
			$data['is_damas_net'] = $inputs['is_damas_net'];
		
		$data['name'] = $inputs['name'] . ' '.@$inputs["fame"];
		$data['mobile'] = Helper::faTOen(str_replace([' ','-','.'],'',$inputs['mobile']));/*'+',*/
		$data['email'] = $inputs['email'];
		$data['message'] = $inputs['message'];
		$data['source'] = $inputs['src'];
		$data['gadget'] = $inputs['device'];
		$data['code'] = $inputs['code'];
		
		if($backup_table==1)
			$data['backup_table'] = 1;
		
		
		$data['campaign'] = '';//Search,Display,Remarket
		$data['target'] = '';//keyword,target,placement
		
		$tgs = [];
		if($inputs['tags']!=''){
			$tgs = json_decode($inputs['tags'],true);
		}else{
			$t = explode('?',$inputs['page']);
			if(isset($t[1])){
				parse_str($t[1], $tgs);
			}
		}
		
		if(isset($tgs['campaign-name']) /*&& $tgs['utm_source']=='yektanet'*/){
			$data['campaign'] = $tgs['campaign-name'];
			$data['target'] = @$tgs['utm_content'];
		}elseif(isset($tgs['Search'])){
			$data['campaign'] = $tgs['Search'];
			$data['target'] = @$tgs['keyword'];
		}elseif(isset($tgs['Display'])){
			$data['campaign'] = $tgs['Display'];
			$data['target'] = isset($tgs['Target'])?$tgs['Target']:@$tgs['placement'];
		}elseif(isset($tgs['Remarket'])){
			$data['campaign'] = $tgs['Remarket'];
			$data['target'] = isset($tgs['Target'])?$tgs['Target']:@$tgs['placement'];
		}else{
			$data['campaign'] = @Helper::get_campaing($inputs['navigation']);
			$data['target'] = @Helper::get_target($inputs['page']);
		}
		
		
		
		$data['navigation'] = Helper::clean_navigation($inputs['navigation']);
		$data['country'] = $inputs['country'];
		$data['l_created_at'] = $inputs['created_at'];
		$data['l_updated_at'] = date('Y-m-d H:i');
		$data['l_created_by'] = 0;
		$data['l_updated_by'] = 0;
		if($backup_table==0)
			$data['whatsapp_code'] = $inputs['id'];
		
		//DB::table('messages')->where("whatsapp_id", $inputs['id']);
		$data["search_fields"] = $inputs["search_fields"];
		
		/*echo '<pre>';country
		print_r($data);
		echo '</pre>';
		exit();*/
		
        $insert_crm = DB::connection('mysql_crm'.$crm)->table('leads')->insert($data);
		$lead_id = DB::connection('mysql_crm'.$crm)->getPdo()->lastInsertId();
		if($backup_table==0)
			DB::table('messages')->where("id", $inputs['id'])->update(['insert_crm' => $insert_crm]);
		elseif($backup_table=='1')
			DB::table('messages3')->where("id", $inputs['id'])->update(['insert_crm' => 1,'name'=>$inputs['name'],'message'=>$inputs['message'],'mobile'=>$inputs['mobile']]);
		
		//insert task
		$task_data['task_owner'] = 0;
		$task_data['t_created_by'] = 0;
		$task_data['t_created_at'] = date('Y-m-d H:i');
		$task_data['due_date'] = date('Y-m-d');
		$task_data['task_type'] = 'Following';
		$task_data['task_name'] = 'First Call';//No Answer
		$task_data['lead'] = $lead_id;
		DB::connection('mysql_crm'.$crm)->table('tasks')->insert($task_data);
		
		
		//insert note
		$a_data['note'] = '"System" Created this lead';
		$a_data['type'] = 'created_by';
		$a_data['lead'] = $lead_id;
		$a_data['n_created_at'] = date('Y-m-d H:i');
		$a_data['n_created_by'] = 0;
		DB::connection('mysql_crm'.$crm)->table('notes')->insert($a_data);
		
		//insert notif
		$supervisors = Helper::getUserByRole('supervisor');
		$users=[];
		//$users[] = 0;//administrator
		foreach($supervisors as $rr)
			$users[] = $rr->id;
		Helper::add_notif('new client registered ("'.$data['name'].'")',$lead_id, '/app/leads/'.$lead_id.'/edit',$users,'green','new_lead_form');
		//########### End insert to CRM ###################
		return $insert_crm;
    }
	/*
    function zoho_insert_contact($inputs = [])
    {
		$is_src = false;
		foreach ( Helper::query("ClientSource", "orderBy", ["field" => "src", "value" => "DESC"])->get() as $row ) {
			if (strpos(strtolower(@$inputs["src"]), strtolower($row->src)) !== false) {
				$inputs['src'] = $row->code; 
				$is_src = true;
				break;
			}
		}
		if ( $is_src == false ) {
			//$inputs['src'] = "UNKNOWN";
		}
		
		$inputs['mobile'] = str_replace("+", "", $inputs['mobile']);
		$fame = $inputs["fame"]?:".";
		
		
		
		$inputs['name'] = strtok($inputs['name'], '?');
		$fame = strtok($fame, '?');
		$inputs['email'] = strtok($inputs['email'], '?');
		$inputs['mobile'] = strtok($inputs['mobile'], '?');
		$inputs['message'] = strtok($inputs['message'], '?');
		//$inputs['communication_time'] = strtok($inputs['communication_time'], '?');
		$inputs['page'] = strtok($inputs['page'], '?');
		$inputs['src'] = str_replace('www-damas-net.cdn.ampproject.org/v/s/','',strtok($inputs['src'], '?'));
		$inputs['country'] = Helper::code_to_country($inputs['country']);
		
		//$inputs['budget'] = strtok($inputs['budget'], '?');
		$inputs['navigation'] = strtok($inputs['navigation'], '?');
		
        $token = env("ZOHO_TOKEN");
        $xmldata = "<?xml version='1.0' encoding='UTF-8' ?><Leads><row no='1'>".
          "<FL val='First Name'>{$inputs['name']}</FL>".
		  "<FL val='Last Name'>{$fame}</FL>".
          "<FL val='Email'>{$inputs['email']}</FL>".
          "<FL val='Mobile'><![CDATA[%2B{$inputs['mobile']}]]></FL>".
          "<FL val='Message'>{$inputs['message']}</FL>".
          "<FL val='Landing Page'>{$inputs['page']}</FL>".
          "<FL val='Lead Source >>'>{$inputs['src']}</FL>".
          "<FL val='Country'>{$inputs['country']}</FL>".
          "<FL val='Navigation'>{$inputs['navigation']}</FL>".
          "</row></Leads>";
        
		
		$url = 'https://crm.zoho.com/crm/private/xml/Leads/insertRecords';
        $param= 'authtoken='.$token.'&scope=crmapi&newFormat=1&xmlData='.$xmldata;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($ch);
        curl_close($ch);

		$x = @simplexml_load_string( $result);
		return @$x->result->message[0];
    }*/

    
    /**
    * client source
    *
    * @return void
    */
    public function clientsource_index()
    {
        $rows = Helper::query("ClientSource", "paginate");
        return view("admin.clientsource.index", compact("rows"));
    }
    
    /**
    * client source edit
    *
    * @param int $id
    * @return void
    */
    public function clientsource_edit(Request $request, $id = null)
    {
        $row = Helper::query("ClientSource", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "src"   =>  "required",
                "code"   =>  "required",
            ]);
            $inputs = $request->all();
            Helper::query("ClientSource", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
            ]);
            return redirect()->route("admin.clientsource");
        }
        return view("admin.clientsource.edit", compact("row"));
    }
    
    /**
    * client source delete
    *
    * @param int $id
    * @return void
    */
    public function clientsource_delete($id)
    {
        return Helper::query("ClientSource", "delete", ["id" => $id]);
    }
    
    /**
    * cities index
    *
    * @return void
    */
    public function cities_index(Request $request)
    {
        $rows = Helper::query("City", "paginate");
        return view("admin.cities.index", compact("rows"));
    }
    
    /**
    * cities edit
    *
    * @param Illuminate\Http\Request $request
    * @param int $id
    * @return void
    */
    public function cities_edit(Request $request, $id = null)
    {
        $row = Helper::query("City", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "name_ar"  =>  "required",
                "name_en"  =>  "required",
                "slug"     =>  "required|alpha_dash|unique:{$row->table_name()},slug,$id",
                "country_id" => "required|integer",
            ]);
			$inputs = $request->all();
			if (array_key_exists('enable_district_page', $inputs)) {
				$inputs['enable_district_page'] = $inputs["enable_district_page"] ? 1 : 0;
			}
            $row = Helper::query("City", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
            ]);
            return Helper::form_redirect("admin.cities", $row, @$inputs['redirect_to_list']);
        }
        $countries = Helper::query("Country", "all");
        return view("admin.cities.edit", compact("row", "countries"));
    }
    
    /**
    * cities delete
    *
    * @param int $var
    * @return void
    */
    public function cities_delete($id)
    {
        return Helper::query("City", "delete", ["id" => $id]);
    }

    /**
    * countries index
    *
    * @return void
    */
    public function countries_index(Request $request)
    {
        $move = Input::get("move");
        if ($move) {
            $selected_row = Helper::query("Country", "find", ["id" => Input::get("id")]);
            switch ($move) {
                case 'first':
                    $index = $selected_row->placement;
                    $selected_row->update(["placement" => 1]);
                    Helper::query("Country", "where", ["field" => "id", "value" => $selected_row->id, "operation" => "<>"])
                        ->where("placement", "<", $index)
                        ->update(["placement" => \DB::raw("placement+1")]);
                    break;

                case 'last':
                    $index = $selected_row->max("placement") + 1;
                    $selected_row->update(["placement" => $index]);
                    break;

                case 'up':
                    $selected_row->update(["placement" => \DB::raw("placement-1")]);
                    break;

                case 'down':
                    $selected_row->update(["placement" => \DB::raw("placement+1")]);
                    break;
            }
            return redirect()->back();
        }
        if (!Input::get("field")) {
            Input::replace(['field' => 'placement', 'sort' => 'asc']);
        }

        $rows = Helper::query("Country", "paginate");
        return view("admin.countries.index", compact("rows"));
    }

    /**
    * countries edit
    *
    * @param Illuminate\Http\Request $request
    * @param int $id
    * @return void
    */
    public function countries_edit(Request $request, $id = null)
    {
        $row = Helper::query("Country", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "name_ar" => "required",
                "name_en" => "required",
                "slug"     => "required|alpha_dash|unique:{$row->table_name()},slug,$id",
                "code"     => "required|alpha_dash|unique:{$row->table_name()},code,$id",
                "whatsapp_number" => "max:30",
            ]);
            $inputs = $request->all();
            if (isset($inputs['whatsapp_number'])) {
                $inputs['whatsapp_number'] = preg_replace('/\D+/', '', $inputs['whatsapp_number']);
                if ($inputs['whatsapp_number'] === '') {
                    $inputs['whatsapp_number'] = null;
                }
            }
            foreach (array('media_id', 'media_en_id', 'placement') as $intField) {
                if (!isset($inputs[$intField]) || $inputs[$intField] === '' || $inputs[$intField] === null) {
                    $inputs[$intField] = 0;
                }
            }
            $inputs['show'] = !empty($inputs['show']) ? 1 : 0;
            $row = Helper::query("Country", "save", [
                "inputs" => $inputs,
                "id"     => $id,
            ]);
            return Helper::form_redirect("admin.countries", $row, @$inputs['redirect_to_list']);
        }
        return view("admin.countries.edit", compact("row"));
    }

    /**
    * countries delete
    *
    * @param int $id
    * @return void
    */
    public function countries_delete($id)
    {
        $row = Helper::query("Country", "find", ["id" => $id]);
        if ($row && $row->id && $row->cities()->count()) {
            session()->flash("flashmessage", [
                "typ" => "danger",
                "message" => "Cannot delete this country because it still has cities.",
            ]);
            return redirect()->back();
        }
        return Helper::query("Country", "delete", ["id" => $id]);
    }

	public function keywords2_edit(Request $request, $id = null)
    {
		$row = Helper::query("Keywords2", "find", ['id' => $id]);
		
		
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "url"  =>  "required",
            ]);
				
				$inputs = $request->all();
				$inputs['url'] = str_replace(['/ar/','/en/','/fr/','/fa/','/ru/'],'',$request->get('url'));
				$display = $request->get('display');
				
				$inputs['display'] = ';' . implode(";",$display) . ';';
				
				return Helper::query("Keywords2", "save", [
					"inputs"    =>  $inputs,
					"id"        =>  $id,
					"route"     =>  "admin.keywords2"
				]);

				
				//return redirect()->back()->with('flashmessage', ['typ' => 'success', 'message' => 'Successfully saved.']); 
				//return redirect()->route("admin.keywords2");
        }
        return view("admin.keywords2.edit", compact("row"));
    }
	
	/**
    * keywords2 index
    *
    * @return void
    */
    public function keywords2_index(Request $request)
    {
        $rows = Helper::query("Keywords2", "paginate");
        return view("admin.keywords2.index", compact("rows"));
    }
	
    /**
    * keywords2 delete
    *
    * @param int $var
    * @return void
    */
    public function keywords2_delete($id)
    {
        return Helper::query("Keywords2", "delete", ["id" => $id]);
    }
	
	
	/**
    * jobs index
    *
    * @return void
    */
    public function jobs_index(Request $request)
    {
        $rows = Helper::query("Job", "paginate");
        return view("admin.jobs.index", compact("rows"));
    }
	
	
    
    /**
    * jobs edit
    *
    * @param Illuminate\Http\Request $request
    * @param int $id
    * @return void
    */
    public function jobs_edit(Request $request, $id = null)
    {
        $row = Helper::query("Job", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "title_ar"  =>  "required",
                "slug"     =>  "required|alpha_dash|unique:{$row->table_name()},slug,$id",
            ]);
			$inputs = $request->all();
			
			
			Helper::Clear_cache([ 'https://damas.net/job/' . $inputs['slug'],'https://damas.net/jobs' ]);
			
            return Helper::query("Job", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
                "route"     =>  "admin.jobs",
            ]);
        }
        return view("admin.jobs.edit", compact("row"));
    }
    
    /**
    * jobs delete
    *
    * @param int $var
    * @return void
    */
    public function jobs_delete($id)
    {
        return Helper::query("Job", "delete", ["id" => $id]);
    }
	
	
	/**
     * export anchors as csv
     * @return csv
     */
    
    public function anchors_export(Request $request)
    {
        $posts = Helper::query("Post", "all");
        $anchors = [];
        $action_cta_exceptions = [
            'https://damas.net/whatsapp_share'
        ];
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
            $link_statuses[$link_status->link] = $link_status->status;
        }
        $content_field = $request->get('lang') == 'en' ? 'content_en' : 'content_ar';
        foreach ($posts as $post) {
            if ($request->get('country') == 'oman') {
                if ($post->country != 'oman') {
                    continue;
                }
            } elseif ($request->get('country') == 'turkey') {
                if ($post->country == 'oman') {
                    continue;
                }
            }
            if (empty($post->$content_field)) {
                continue;
            }
            $html = html_entity_decode($post->$content_field, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML('<?xml encoding="UTF-8">' . $html);
            libxml_clear_errors();
            foreach ($dom->getElementsByTagName('a') as $link) {
                $href = trim($link->getAttribute('href'));
                $link_type = $classify_link($href);
                if ($request->get('link_type') == 'internal' && $link_type != 'Internal') {
                    continue;
                }
                if ($request->get('link_type') == 'external' && $link_type != 'External') {
                    continue;
                }
                if ($request->get('link_type') == 'action_cta' && $link_type != 'Action / CTA') {
                    continue;
                }
                $anchors[] = [
                    'text' => trim($link->textContent),
                    'url' => $href,
                    'web_url' => $post->frontUrl(),
                    'admin_url' => url("damas-administrator/blog/{$post->id}/edit"),
                    'source_type' => '',
                    'link_type' => $link_type,
                    'status' => isset($link_statuses[$href]) ? $link_statuses[$href] : null,
                    'created_at' => date('d M Y', strtotime($post->created_at))
                ];
            }
        }
        $group_by = $request->get('group_by', 'none');
        $groupable_columns = ['text', 'url', 'web_url', 'link_type', 'status'];
        $display_rows = [];
        if ($group_by != 'none' && in_array($group_by, $groupable_columns)) {
            $groups = [];
            foreach ($anchors as $anchor) {
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
                $unique_link_types = [];
                $unique_statuses = [];
                $unique_dates = [];
                foreach ($items as $item) {
                    $unique_texts[(string) $item['text']] = true;
                    $unique_urls[(string) $item['url']] = true;
                    $unique_sources[(string) $item['web_url']] = true;
                    $unique_admin_urls[(string) $item['admin_url']] = true;
                    $unique_link_types[(string) $item['link_type']] = true;
                    $unique_statuses[$item['status'] === null ? '__NOT_CHECKED__' : (string) $item['status']] = true;
                    $unique_dates[(string) $item['created_at']] = true;
                }
                $display_rows[] = [
                    'count' => count($items),
                    'anchor' => $items[0],
                    'items' => $items,
                    'unique_texts' => count($unique_texts),
                    'unique_urls' => count($unique_urls),
                    'unique_sources' => count($unique_sources),
                    'unique_admin_urls' => count($unique_admin_urls),
                    'unique_link_types' => count($unique_link_types),
                    'unique_statuses' => count($unique_statuses),
                    'unique_dates' => count($unique_dates)
                ];
            }
        } else {
            foreach ($anchors as $anchor) {
                $display_rows[] = [
                    'count' => 1,
                    'anchor' => $anchor,
                    'items' => [$anchor],
                    'unique_texts' => 1,
                    'unique_urls' => 1,
                    'unique_sources' => 1,
                    'unique_admin_urls' => 1,
                    'unique_link_types' => 1,
                    'unique_statuses' => 1,
                    'unique_dates' => 1
                ];
            }
        }
        $filename = 'content-links-' . date('Y-m-d-H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        return response()->stream(function () use ($display_rows) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, [
                '#',
                'Count',
                'Target Query',
                'Target URL',
                'Source URL',
                'Edit / Admin',
                'Source Type',
                'Link Type',
                'Status',
                'Created At'
            ]);
            $number = 1;
            foreach ($display_rows as $row) {
                $anchor = $row['anchor'];
                fputcsv($handle, [
                    $number++,
                    $row['count'],
                    $row['unique_texts'] == 1 ? $anchor['text'] : $row['unique_texts'] . ' unique',
                    $row['unique_urls'] == 1 ? $anchor['url'] : $row['unique_urls'] . ' unique',
                    $row['unique_sources'] == 1 ? $anchor['web_url'] : $row['unique_sources'] . ' unique',
                    $row['unique_admin_urls'] == 1 ? $anchor['admin_url'] : $row['unique_admin_urls'] . ' unique',
                    '',
                    $row['unique_link_types'] == 1 ? $anchor['link_type'] : $row['unique_link_types'] . ' unique',
                    $row['unique_statuses'] == 1 ? ($anchor['status'] !== null ? $anchor['status'] : 'Not checked') : $row['unique_statuses'] . ' unique',
                    $row['unique_dates'] == 1 ? $anchor['created_at'] : $row['unique_dates'] . ' unique'
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }
	
	/**
	 * Anchors index
 	*/
	
	public function anchors_index(Request $request)
    {
        return view("admin.anchors.index");
    }
    
    /**
     * Metatag Tool index
     */
    
    public function metatagtool_index(Request $request)
    {
        return view("admin.metatag_tool.index");
    }
    
    /**
     * CTA index
     */
    
    public function cta_index(Request $request)
    {
        return view("admin.cta.index");
    }
	
	/**
    * competitors index
    *
    * @return void
    */
    public function competitors_index(Request $request)
    {
		
			$rows = Helper::query("Competitor", "paginate");
		if(isset($_GET['competitor'])){
			$comp = Helper::query("Competitor", "find", ['id' => $_GET['competitor']]);
			return view("admin.competitors.index", compact("rows","comp"));
		}else{
			$rows = Helper::query("Competitor", "paginate");
			return view("admin.competitors.index", compact("rows"));
		}
    }
	
	
    
    /**
    * competitors edit
    *
    * @param Illuminate\Http\Request $request
    * @param int $id
    * @return void
    */
    public function competitors_edit(Request $request, $id = null)
    {
        $row = Helper::query("Competitor", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "name"  =>  "required"
            ]);
			$inputs = $request->all();
			
			
			
            return Helper::query("Competitor", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
                "route"     =>  "admin.competitors",
            ]);
        }
        return view("admin.competitors.edit", compact("row"));
    }
    public function competitors_ads_edit(Request $request, $id = null)
    {
        $row = Helper::query("CompetitorAds", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "title"  =>  "required"
            ]);
			$inputs = $request->all();
			
			
			$saved = Helper::query("CompetitorAds", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id
            ]);
			
			$file = $request->file('image');
				if($file!=''){
					$path = 'media/ads/';
					$ext = $file->getClientOriginalExtension();
					$name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
					$new_name = str_slug($name).'_'.sha1(time());
					$filename = $new_name.".".$ext;
					$file->move(public_path($path), $filename);
					if($saved->image!=''){
						if(file_exists(public_path($saved->image)))
						@unlink(public_path($saved->image));
					}
					$saved->image = $path . $filename;
				}
				
				
				$saved->save();
			$ad = $saved;

			$html = '';
			if($id==null)
				$html = '<div class="col-md-6 "><div class="post_card tr_'.$ad->id.'" >';
			
			$html = '
				<a target="_blank" class="link" href="'. $ad->link .'">
					<img src="'. asset($ad->image) .'" alt="title" />
				</a>
				<h2>'. $ad->title .'</h2>
				<p class="ad_type">'. $ad->ad_type .'</p>
				<span class="tab_section" style="display: none;">
					'. $ad->tab_section .'
				</span>
				<a href="#" data-id="'. $ad->id .'" class="btn_edit_ads btn btn-primary btn-xs"  data-toggle="modal" data-target="#exampleModal"><i class="fa fa-edit"></i></a>
				<button data-id="'. $ad->id .'" class="btn_delete_ad btn btn-danger btn-xs " title="Delete"><i class="fa fa-trash"></i></button>';
			
			if($id==null)
				$html = $html.'</div></div>';
			
			
            return response()->json(['success' => true,'html'=>$html ]);
        }
        //return view("admin.competitors.edit", compact("row"));
    }
    
    /**
    * competitors delete
    *
    * @param int $var
    * @return void
    */
    public function competitors_ads_delete($id)
    {
        return Helper::query("CompetitorAds", "delete", ["id" => $id]);
    }
    public function competitors_delete($id)
    {
        return Helper::query("Competitor", "delete", ["id" => $id]);
    }
    
    /**
    * regions list
    *
    * @return void
    */
    public function regions_index()
    {
        $rows = Helper::query("Region", "paginate");
        return view("admin.regions.index", compact("rows"));
    }
    
    /**
    * region edit
    *
    * @param Illuminate\Http\Request $request
    * @param int $id
    * @return void
    */
    public function regions_edit(Request $request, $id = null)
    {
        $row = Helper::query("Region", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "name_ar"  =>  "required",
                "name_en"  =>  "required",
                "slug"     =>  "required|alpha_dash|unique:{$row->table_name()},slug,$id",
            ]);
			
			$inputs = $request->all();
			$inputs['show_on_districts_page'] = @$inputs["show_on_districts_page"] ? 1 : 0;
            $region = Helper::query("Region", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
                //"route"     =>  "admin.regions",
            ]);
			
            $region->syncRegionPhotos($request->get('region_photos', []));
			$region->save();
			
			return redirect()->route("admin.regions");
        }
        return view("admin.regions.edit", compact("row"));
    }
    
    /**
    * region delete
    *
    * @param int $var
    * @return void
    */
    public function regions_delete($id)
    {
        return Helper::query("Region", "delete", ["id" => $id]);
    }
    
    /**
    * video
    *
    * @return void
    */
    public function videos_index()
    {
		//$rows = Helper::query("Video", "paginate");
        $rows = Helper::query("Video","orderBy", ["field" => "id", "value" => "desc"])->paginate(Helper::ajax_change_paginate_number());
        return view("admin.videos.index", compact("rows"));
    }
    
    /**
    * sale video
    *
    * @param Illuminate\Http\Request $request
    * @param int $id
    * @return void
    */
    public function videos_edit(Request $request, $id = null)
    {
        $row = Helper::query("Video", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                /*"title"  =>  "required",*/
                "link"  =>  "required",
                "lang"  =>  "required",
            ]);
			$inputs = $request->all();
			
			if(isset($inputs["lang"])){
				$inputs["lang"] = implode(',',$inputs["lang"]);
			}
			$inputs['show_on_media'] = 0;
			/*$inputs['show_on_media'] = @$inputs["show_on_media"] ? 1 : 0;
			
			if(@$inputs['show_on_media']=='1'){
				DB::table('videos')->update(['show_on_media'=>false]);
			}*/

			if(trim($inputs['slug'])!=''){
				
			}else{ /*if(isset($inputs['projects'][0])){*/
				$p = Helper::query("Project", "find", ['id' => $inputs['projects'][0]]);
				if($p!=false)
					$inputs['slug'] = $p->slug;
			}
			if(isset($inputs['projects'][0])){
				$p = Helper::query("Project", "find", ['id' => $inputs['projects'][0]]);
				if($p!=false)
					$inputs['project_id'] = $p->id;
            }
			
			$res = Helper::query("Video", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id
            ]);
			
			
			DB::table('sectionvideo_video')->where('video_id',$res->id)->delete();
			DB::table('project_video')->where('video_id',$res->id)->delete();
			DB::table('post_video')->where('video_id',$res->id)->delete();
			
			$sections = $request->get('sections', []);
			$res->syncSections($sections);
			$projects = $request->get('projects', []);
			$res->syncProjects($projects);
			$posts = $request->get('posts', []);
			$res->syncPosts($posts);
			
			
			
			@Helper::update_youtube_video_only($res->id);
			return redirect()->route("admin.videos");
        }
        return view("admin.videos.edit", compact("row"));
    }
    
    /**
    * Video delete
    *
    * @param int $id
    * @return void
    */
    public function videos_delete($id)
    {
		
		DB::table('sectionvideo_video')->where('video_id',$id)->delete();
		DB::table('project_video')->where('video_id',$id)->delete();
		DB::table('post_video')->where('video_id',$id)->delete();
        return Helper::query("Video", "delete", ["id" => $id]);
    }

    /**
    * sale managers
    *
    * @return void
    */
    public function testimonials_index()
    {
        $rows = Helper::query("Testimonial", "paginate");
        return view("admin.testimonials.index", compact("rows"));
    }
    
    /**
    * sale manager edit
    *
    * @param Illuminate\Http\Request $request
    * @param int $id
    * @return void
    */
    public function testimonials_edit(Request $request, $id = null)
    {
        $row = Helper::query("Testimonial", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            /*$this->validate($request, [
                "name_ar"  =>  "required",
                "content_ar"  =>  "required",
            ]);*/
            return Helper::query("Testimonial", "save", [
                "inputs"    =>  $request->all(),
                "id"        =>  $id,
                "route"     =>  "admin.testimonials",
            ]);
			
        }
        return view("admin.testimonials.edit", compact("row"));
    }
    
    /**
    * sale manager delete
    *
    * @param int $id
    * @return void
    */
    public function testimonials_delete($id)
    {
        return Helper::query("Testimonial", "delete", ["id" => $id]);
    }
    /**
    * sale managers
    *
    * @return void
    */
    public function salesmanagers_index()
    {
        $rows = Helper::query("SaleManager", "paginate");
        return view("admin.salesmanagers.index", compact("rows"));
    }
    
    /**
    * sale manager edit
    *
    * @param Illuminate\Http\Request $request
    * @param int $id
    * @return void
    */
    public function salesmanagers_edit(Request $request, $id = null)
    {
        $row = Helper::query("SaleManager", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "name_ar"  =>  "required",
                "career"  =>  "required",
                "slug"  =>  "required",
                "email"  =>  "required",
                "phone"  =>  "required",
            ]);
			
			$inpts = $request->all();
			$inpts['slug'] = str_replace(' ','-',$request->get('slug'));

			
            return Helper::query("SaleManager", "save", [
                "inputs"    =>  $inpts,
                "id"        =>  $id,
                "route"     =>  "admin.salesmanagers",
            ]);
        }
        return view("admin.salesmanagers.edit", compact("row"));
    }
    
    /**
    * sale manager delete
    *
    * @param int $id
    * @return void
    */
    public function salesmanagers_delete($id)
    {
        return Helper::query("SaleManager", "delete", ["id" => $id]);
    }
	
	
	
	
	
	
    /**
    * sale managers
    *
    * @return void
    */
    public function salesmanagers_reviews_index()
    {
		$agent_name='';
		if(isset($_GET['agent'])){
		$rows = Helper::query("SaleManagerReview", "where", ["field" => "sale_manager_id", "value" => $_GET['agent']])->orderBy('id', 'DESC')->paginate(Helper::ajax_change_paginate_number());
        $agent_name = Helper::query("SaleManager", "find", ['id' => $_GET['agent']])->name_en;
		}else
		$rows = Helper::query("SaleManagerReview", "paginate");
        
		return view("admin.salesmanagers_reviews.index", compact("rows","agent_name"));
    }
    
    /**
    * sale manager edit
    *
    * @param Illuminate\Http\Request $request
    * @param int $id
    * @return void
    */
    public function salesmanagers_reviews_edit(Request $request, $id = null)
    {
        $row = Helper::query("SaleManagerReview", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "client_name"  =>  "required",
                "client_country"  =>  "required",
                "comment"  =>  "required",
            ]);
            return Helper::query("SaleManagerReview", "save", [
                "inputs"    =>  $request->all(),
                "id"        =>  $id,
                "route"     =>  "admin.salesmanagers_reviews",
            ]);
        }
        return view("admin.salesmanagers_reviews.edit", compact("row"));
    }
    
    /**
    * sale manager delete
    *
    * @param int $id
    * @return void
    */
    public function salesmanagers_reviews_delete($id)
    {
        return Helper::query("SaleManager", "delete", ["id" => $id]);
    }
    
	
	
	
	
    /**
    * branch index
    *
    * @return void
    */
    public function branch_index()
    {
        $rows = Helper::query("Branch", "paginate");
        return view("admin.branch.index", compact("rows"));
    }
    
    /**
    * branch edit
    *
    * @param Illuminate\Http\Request $request
    * @param int $id
    * @return void
    */
    public function branch_edit(Request $request, $id = null)
    {
        $row = Helper::query("Branch", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "name_ar"  =>  "required",
                "name_en"  =>  "required",
                "mobile"  =>  "required",
                "phone"  =>  "required",
                "email"  =>  "required",
                "address_ar"  =>  "required",
                "address_en"  =>  "required",
            ]);
            return Helper::query("Branch", "save", [
                "inputs"    =>  $request->all(),
                "id"        =>  $id,
                "route"     =>  "admin.branch",
            ]);
        }
        return view("admin.branch.edit", compact("row"));
    }
    
    /**
    * branch delete
    *
    * @param int $var
    * @return void
    */
    public function branch_delete($id)
    {
        return Helper::query("Branch", "delete", ["id" => $id]);
    }
    
    /**
    * landing page list
    *
    * @return void
    */
    public function landingpage_index()
    {
        $rows = Helper::query("LandingPage", "paginate");
        return view("admin.landingpage.index", compact("rows"));
    }
    
    /**
    * edit landing page
    *
    * @param int $var
    * @return void
    */
    public function landingpage_edit(Request $request, $id = null)
    {
        $row = Helper::query("LandingPage", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                //"name"  =>  "required",
                "lang"  =>  "required",
                //"slug"  =>  "required|alpha_dash|unique:{$row->table_name()},slug,$id",
                "project_id"  =>  "required",
            ]);
            $inputs = $request->all();
            $inputs["hide_whatsapp"] = @$inputs["hide_whatsapp"] ? 1 : 0;
            $inputs["hide_popup"] = @$inputs["hide_popup"] ? 1 : 0;
			
			$p = DB::table('projects')->where('id',$inputs["project_id"])->first();
			$inputs["name"] = $p->name_ar;
			$inputs["slug"] = $p->slug;
			
			
			if(isset($inputs["lang"])){
				$inputs["lang"] = implode(',',$inputs["lang"]);
			}
			
            $saved = Helper::query("LandingPage", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
            ]);
            // sliders
            //$saved->syncLandingSliders($request->get('landing_sliders', []));
            // infos
            Helper::query("LandingPageInfos", "where", ["field" => "landingpage_id", "value" => $saved->id])->delete();
            $infos = $request->get("infos_title", []);
            foreach ($infos as $k => $info) {
                if ( !$info ) continue;
                $arr = [
                    "landingpage_id"    =>  $saved->id,
                    "icon"    =>  @$inputs["infos_icon"][$k],
                    "title"    =>  $info,
                    "description"    =>  @$inputs["infos_description"][$k],
                ];
                Helper::query("LandingPageInfos", "save", ['inputs' => $arr]);
            }
            
            return Helper::form_redirect("admin.landingpage", $saved, $request->get('redirect_to_list', null));
        }
        return view("admin.landingpage.edit", compact("row"));
    }
    
    /**
    * delete landing page
    *
    * @param int $var
    * @return void
    */
    public function landingpage_delete($id)
    {
        return Helper::query("LandingPage", "delete", ["id" => $id]);
    }
    
    public function landingpage_initializeviews($id)
    {
        $row = Helper::query("LandingPage", "find", ['id' => $id]);
        $row->views = 0;
        $row->save();
        return redirect()->back();
    }
	
	
	/**
* landing page list
*
* @return void
*/
public function newlandingpage_index()
{
	$rows = Helper::query("NewLandingPage", "paginate");
	return view("admin.newlandingpage.index", compact("rows"));
}

/**
* edit landing page
*
* @param int $var
* @return void
*/
public function newlandingpage_edit(Request $request, $id = null)
{
	$row = Helper::query("NewLandingPage", "find", ['id' => $id]);
	if ( $request->isMethod('post') ) {
		$this->validate($request, [
			"title"  =>  "required",
			"slug"  =>  "required|alpha_dash|unique:{$row->table_name()},slug,$id"
		]);
		$inputs = $request->all();
		$saved = Helper::query("NewLandingPage", "save", [
			"inputs"    =>  $inputs,
			"id"        =>  $id,
		]);
		
		return Helper::form_redirect("admin.newlandingpage", $saved, $request->get('redirect_to_list', null));
	}
	return view("admin.newlandingpage.edit", compact("row"));
}

/**
* delete landing page
*
* @param int $var
* @return void
*/
public function newlandingpage_delete($id)
{
	return Helper::query("NewLandingPage", "delete", ["id" => $id]);
}

public function newlandingpage_initializeviews($id)
{
	$row = Helper::query("NewLandingPage", "find", ['id' => $id]);
	$row->views = 0;
	$row->save();
	return redirect()->back();
}
	
	
    
    /**
    * landing page list
    *
    * @return void
    */
    public function landing2_index()
    {
        $rows = Helper::query("Landing2", "paginate");
        return view("admin.landing2.index", compact("rows"));
    }
    
    /**
    * edit landing page
    *
    * @param int $var
    * @return void
    */
    public function landing2_edit(Request $request, $id = null)
    {
        $row = Helper::query("Landing2", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
			
            $this->validate($request, [
                //"name"  =>  "required",
                "lang"  =>  "required",
                //"slug"  =>  "required|alpha_dash|unique:{$row->table_name()},slug,$id",
                //"project_id"  =>  "required",
            ]);
            
			$inputs = $request->all();
			
			if(isset($inputs["lang"])){
				$inputs["lang"] = implode(',',$inputs["lang"]);
			}
			
            $saved = Helper::query("Landing2", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id
            ]);
			//exit;
			/*
            // sliders
            //$saved->syncLandingSliders($request->get('landing_sliders', []));
            // infos
            Helper::query("Landing2Infos", "where", ["field" => "landing2_id", "value" => $saved->id])->delete();
            $infos = $request->get("infos_title", []);
            foreach ($infos as $k => $info) {
                if ( !$info ) continue;
                $arr = [
                    "landing2_id"    =>  $saved->id,
                    "icon"    =>  @$inputs["infos_icon"][$k],
                    "title"    =>  $info,
                    "description"    =>  @$inputs["infos_description"][$k],
                ];
                Helper::query("Landing2Infos", "save", ['inputs' => $arr]);
            }
            */
			
			//$saved->syncOffers($request->get('landing2_offer', []));
			
			//type_project[]
			if($id != null)
			DB::table('landing2_resell_offer')->where('landing2_id',$row->id)->delete();
			
			$type_project = $request->get('type_project', []);
			$offer_id = $request->get('offer_id', []);
			$resale_id = $request->get('resale_id', []);
			$title = $request->get('title', []);
			$title_en = $request->get('ititle_en', []);
			$title_fr = $request->get('ititle_fr', []);
			$title_ru = $request->get('ititle_ru', []);
			$title_pe = $request->get('ititle_pe', []);
			$arrange = $request->get('arrange', []);
			
			for($i=0;$i<count($type_project);$i++){
				DB::table('landing2_resell_offer')->insert([
				'landing2_id'=>($id != null?$id:$saved->id),
				'type_project'=>$type_project[$i],
				'offer_id'=>$offer_id[$i],
				'resale_id'=>$resale_id[$i],
				'title'=>@$title[$i],
				'title_en'=>@$title_en[$i],
				'title_fr'=>@$title_fr[$i],
				'title_pe'=>@$title_pe[$i],
				'title_ru'=>@$title_ru[$i],
				'arrange'=> (int)$arrange[$i]
				
				]);
			}
			
			    return Helper::form_redirect("admin.landing2", $saved, $request->get('redirect_to_list', null));
        }

				$resells = \App\Models\Resellproject::where('offer_end_date','>=',DB::raw('date(NOW())'))->get();
				$offers = \App\Models\Land2offer::where('offer_end_date','>=',DB::raw('date(NOW())'))->get();
				$landing2_resell_offers = DB::select("SELECT * FROM `dms_landing2_resell_offer` WHERE `landing2_id`=?",[$row->id]);

				$offers_label = [];
				foreach($offers as $o){
					$tmn = 'O'. $o->name . $o->id .'-'. @$o->project->name_en .'-'. @$o->project->region->name_en .'-'. @$o->offertype->name_en . ( $o->pattern=='+'?'':'('.$o->pattern.')' );
					$offers_label[] = $tmn;
				}
				
				$resells2_label = [];
				foreach($resells as $o){
					$tmn = 'R'. $o->name . $o->id .'-'. @$o->city->name_en .'-'. @$o->region->name_en .'-'. @$o->type->name_en . ( @$o->room=='+'?'':'('.$o->room.')' );
					$resells2_label[] = $tmn;
				}
				


        return view("admin.landing2.edit", compact("row","resells","offers","landing2_resell_offers","offers_label","resells2_label"));
    }
    
    /**
    * delete landing page
    *
    * @param int $var
    * @return void
    */
    public function landing2_delete($id)
    {
        return Helper::query("Landing2", "delete", ["id" => $id]);
    }
    
    public function landing2_initializeviews($id)
    {
        $row = Helper::query("Landing2", "find", ['id' => $id]);
        $row->views = 0;
        $row->save();
        return redirect()->back();
    }

    /**
    * newsletter list
    *
    * @return void
    */
    public function newsletter_index(Request $request)
    {
        if ( $request->isMethod('post') ) {
			
			
            //$all = Helper::query("Newsletter", "all")->lists('email')->toArray();
			
			$where = "";
			if(isset($_GET['search']) && $_GET['search']!=''){
			$where = " where email like '%".$_GET['search']."%'";
			}
			$all = DB::select("select * from dms_messages ".$where);
			
			
			$filename = "Webinfopen.xls"; // File Name
// Download file
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

// Write data to file
$flag = false;
foreach ( $all as $row) {
	$l = [];
	$l['id'] = $row->id;
	$l['email'] = $row->email;
	$l['created_at'] = $row->created_at;
    if (!$flag) {
        // display field/column names as first row
        echo implode("\t", array_keys($l)) . "\r\n";
        $flag = true;
    }
    echo implode("\t", array_values($l)) . "\r\n";
}
			
			/*echo '<pre>';
			print_r($all);
			echo '</pre>';*/
			exit;
            /*$fileText = implode("\n", $all);
            $myName = "newsletter-".date("Ymd").".txt";
            $headers = [
                'Content-type'  =>  'text/plain',
                'test'  =>  'YoYo',
                'Content-Disposition'   =>  sprintf('attachment; filename="%s"', $myName),
                'X-BooYAH'  =>  'WorkyWorky',
                'Content-Length'    =>  strlen($fileText)
            ];
            return \Response::make($fileText, 200, $headers);*/
        }
		
		
        $where = [];
		if(isset($_GET['search']) && $_GET['search']!=''){
			$search = '%'.$_GET['search'].'%';
			$where[] = ["email", "like", $search];
			
			$rows = Helper::query("Newsletter", "paginate", $where,'or');
		}else{
		$rows = Helper::query("Newsletter", "paginate");
        }
		
		return view("admin.newsletter.index", compact("rows")); 
    }
    public function newsletter_edit($id,Request $request)
    {
        $row = Helper::query("Newsletter", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "email"  =>  "required",
            ]);
            return Helper::query("Newsletter", "save", [
                "inputs"    =>  $request->all(),
                "id"        =>  $id,
                "route"     =>  "admin.newsletter",
            ]);
        }
        return view("admin.newsletter.edit", compact("row"));
    }
    public function newsletter_delete($id)
    {
        return Helper::query("Newsletter", "delete", ["id" => $id]);
    }
    

    /**
    * medias index
    *
    * @return void
    */
    
//     public function medias_index(Request $request)
//     {
		
// 		//$time_start = microtime(true); 
		
//         $folder_id = \Input::get("folder_id");
//         if ( $folder_id ) {
//             $rows = Helper::query("Media", "where", ["field" => "folder_id", "value" => $folder_id])->orderBy('id', 'DESC')->paginate(Helper::ajax_change_paginate_number());
            
//         } else {
//             $rows = Helper::query("Media", "paginate");
//         }
//         if ( $request->ajax() ) {
//             $filter_folder = $request->get('filter_folder', null);
//             $inputs["ids"] = $request->get('ids', null);
//             $inputs["multiple"] = $request->get('multiple', 1);
//             $folder_id = $request->get('folder_id', null);
//             /*$folder_id = null;
//             if ( $filter_folder ) {
//             }*/
//             $q = Helper::query("Media", "orderBy", ["field" => "created_at", "value", "DESC"]);
//             if ( $folder_id > 0 ) {
//                 $q->where("folder_id", $folder_id); 
//             }
//             $rows = $q->paginate(20);
//             $inputs["folder_id"] = $folder_id;
//             return view('admin.medias.media_grid', ['rows' => $rows, "inputs" => $inputs])->render();  
//         }
		
		
// 		$folders  = DB::select("SELECT `dms_medias_folder`.`id`,name,count(`dms_medias`.`id`) as cnt_medias FROM `dms_medias_folder` left join dms_medias on dms_medias.folder_id=`dms_medias_folder`.`id` group by name");
		
// 		/*
// 		$time_end = microtime(true);
// 		//dividing with 60 will give the execution time in minutes otherwise seconds
// 		$execution_time = ($time_end - $time_start);
// 		//execution time of the script
// 		echo '<b>Total Execution Time:</b> '.$execution_time.' S';
// 		*/
//         return view("admin.medias.index", compact("rows", "folders"));
//     }

    public function medias_index(Request $request)
    {
        $folder_id = \Input::get("folder_id");
    
        /*
         * AJAX requests
         */
        if ($request->ajax()) {
    
            $filter_folder = $request->get('filter_folder', null);
            $inputs["ids"] = $request->get('ids', null);
            $inputs["multiple"] = $request->get('multiple', 1);
            $folder_id = $request->get('folder_id', null);
    
            $q = Helper::query("Media", "orderBy", [
                "field" => "created_at",
                "value" => "DESC"
            ]);
    
            if ($folder_id > 0) {
                $q->where("folder_id", $folder_id);
            }
    
            $rows = $q->paginate(20);
    
            $inputs["folder_id"] = $folder_id;
    
            return view(
                'admin.medias.media_grid',
                [
                    'rows' => $rows,
                    "inputs" => $inputs
                ]
            )->render();
        }
    
    
        /*
         * SIZE SORTING
         *
         * If the user clicked the Size column,
         * get ALL images and sort them in PHP.
         */
        if (Input::get("field") == "size") {
    
            if ($folder_id) {
    
                $rows = \App\Models\Media::where('folder_id', $folder_id)->get();
    
            } else {
    
                $rows = \App\Models\Media::all();
    
            }
    
            /*
             * Sort using the raw byte size.
             */
            $rows = $rows->sortBy(function ($media) {
                return $media->size_bytes;
            });
    
            /*
             * Reverse for descending order.
             */
            if (Input::get("sort") == "desc") {
                $rows = $rows->reverse();
            }
    
            $rows = $rows->values();
    
            /*
             * Manually paginate the sorted collection.
             */
            $page = Input::get("page", 1);
            $perPage = Helper::ajax_change_paginate_number();
    
            $rows = new \Illuminate\Pagination\LengthAwarePaginator(
                $rows->forPage($page, $perPage),
                $rows->count(),
                $perPage,
                $page,
                [
                    'path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath(),
                    'query' => Input::except('page')
                ]
            );
    
        } else {
    
            /*
             * NORMAL BEHAVIOR
             *
             * Leave the existing database pagination/sorting alone.
             */
            if ($folder_id) {
    
                $rows = Helper::query(
                    "Media",
                    "where",
                    [
                        "field" => "folder_id",
                        "value" => $folder_id
                    ]
                )->orderBy('id', 'DESC')
                 ->paginate(Helper::ajax_change_paginate_number());
    
            } else {
    
                $rows = Helper::query(
                    "Media",
                    "paginate"
                );
    
            }
        }
    
    
        /*
         * Image folders
         */
        $folders = DB::select("
            SELECT
                `dms_medias_folder`.`id`,
                name,
                count(`dms_medias`.`id`) as cnt_medias
            FROM `dms_medias_folder`
            LEFT JOIN dms_medias
                ON dms_medias.folder_id = `dms_medias_folder`.`id`
            GROUP BY name
        ");
    
    
        return view(
            "admin.medias.index",
            compact("rows", "folders")
        );
    }
    
    /**
    * media edit
    *
    * @param Illuminate\Http\Request $request
    * @param int $var
    * @return void
    */
    public function medias_edit(Request $request, $id = null)
    {
        $row = Helper::query("Media", "find", ['id' => $id]);
        
        $delmobile = Input::get("delmobile");
        if ( $delmobile ) {
            $filepath_mobile = public_path($row->path_mobile);
            $row->update([
                "filename_mobile"   =>  null,
                "path_mobile"   =>  null,
            ]);
            @unlink($filepath_mobile);
            return redirect()->back();
        }
        
        if ( $request->isMethod('post') ) {
            
            $inputs = $request->all();
            
            $insert_logo = @$inputs["insert_logo"] ? 1 : 0;
            $folder = $inputs["folder"];
            // save folder if not exist
            if ( $inputs["folder_id"] ) {
                $folder_row = Helper::query("MediaFolder", "find", ["id" => $inputs["folder_id"]]);
                $folder = $folder_row->name;
                $inputs["folder_id"] = $folder_row->id;
            } elseif ( $folder ) {
                $folder_row = Helper::query("MediaFolder", "where", ["field" => "name", "value" => $folder])->first();
                if ( !$folder_row ) {
                    $folder_row = Helper::query("MediaFolder", "save", ["inputs" => [
                        "name"  =>  $folder,
                        "slug"  =>  str_slug($folder),
                    ]]);
                }
                $inputs["folder_id"] = $folder_row->id;
            }
            //$path = @$folder_row ? "uploads/$folder_row->name/" : "uploads/";
            $path = "uploads/2023/";
            
            if ( !$id ) {
                $files = $request->file('files', []);
                $files_mobile = $request->file('files_mobile', []);
                foreach ($files as $kfile => $file) {
                    $file_mobile = @$files_mobile[$kfile];
                    
                    $ext = $file->getClientOriginalExtension();
                    $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $new_name = str_slug($name).MD5(time()).rand(10,999);
                    $filename = $new_name.".".$ext;
                    $filename_mobile = $new_name."_mobile.".$ext;
                    
                    if ( $insert_logo == 1 ) {
                        $img = Image::make($file->getRealPath());
                        $logo = Image::make(public_path("img/logo.png"))->opacity(20);
                        $img->insert($logo, 'center');
                        $img->save(public_path($path)."/$filename");
                        // mobile file
                        if ( $file_mobile ) {
                            $img = Image::make($file_mobile->getRealPath());
                            $logo = Image::make(public_path("img/logo.png"))->opacity(50);
                            $img->insert($logo, 'center');
                            $img->save(public_path($path)."/$filename_mobile");
                        }
                    } else {
                        $file->move(public_path($path), $filename);
                        // mobile file
                        if ( $file_mobile ) {
                            $file_mobile->move(public_path($path), $filename_mobile);
                        }
                    }
                    
                    // save
                    $input = [];
                    $kfile = sprintf("%02d", $kfile+1);
                    $name_ar = $inputs["name_ar"] ? $inputs["name_ar"] : $name;
                    $name_en = $inputs["name_en"] ? $inputs["name_en"] : $name;
                    $name_fr = $inputs["name_fr"] ? $inputs["name_fr"] : $name;
                    $name_fa = $inputs["name_fa"] ? $inputs["name_fa"] : $name;
                    $title_ar = $inputs["title_ar"] ? $inputs["title_ar"] : $name_ar;
                    $title_en = $inputs["title_en"] ? $inputs["title_en"] : $name_en;
                    $title_fa = $inputs["title_fa"] ? $inputs["title_fa"] : $name_fa;
                    $title_fr = $inputs["title_fr"] ? $inputs["title_fr"] : $name_fr;
                    $description_ar = $inputs["description_ar"] ? $inputs["description_ar"] : $name_ar;
                    $description_en = $inputs["description_en"] ? $inputs["description_en"] : $name_en;
                    $description_fr = $inputs["description_fr"] ? $inputs["description_fr"] : $name_fr;
                    $description_fa = $inputs["description_fa"] ? $inputs["description_fa"] : $name_fa;
                        
                    $input["name_ar"] = $name_ar." ".$kfile;
                    $input["name_en"] = $name_en." ".$kfile;
                    $input["name_fr"] = $name_fr." ".$kfile;
                    $input["name_fa"] = $name_fa." ".$kfile;
                    $input["title_ar"] = $title_ar." ".$kfile;
                    $input["title_en"] = $title_en." ".$kfile;
                    $input["title_fr"] = $title_fr." ".$kfile;
                    $input["title_fa"] = $title_fa." ".$kfile;
                    $input["description_ar"] = $description_ar." ".$kfile;
                    $input["description_en"] = $description_en." ".$kfile;
                    $input["description_fr"] = $description_fr." ".$kfile;
                    $input["description_fa"] = $description_fa." ".$kfile;
                    $input["folder_id"] = $inputs["folder_id"];
                    $input["filename"] = $filename;
                    $input['path'] = $path.$filename;
                    if ( $file_mobile ) {
                        $input["filename_mobile"] = $filename_mobile;
                        $input['path_mobile'] = $path.$filename_mobile;
                    }
                    $saved = Helper::query("Media", "save", [
                        "inputs"    =>  $input,
                    ]);
                    
                    $arr_saved[] = $saved->id;
                    
                }
                if ( $request->ajax() ) {
                    return response()->json([
                        "ids"   =>  implode(",", $arr_saved)
                    ]);
                }
                return Helper::form_redirect("admin.medias", $saved, @$inputs['redirect_to_list']);
                
            } else {
                
                $inputs['filename'] = $row->filename;
                if ( $request->hasFile("file") ) {
                    $file = $request->file('file');
                    $ext = $file->getClientOriginalExtension();
                    $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $filename = str_slug($name).MD5(time()).rand(10,999).".".$ext;
                    if ( $insert_logo == 1 ) {
                        $img = Image::make($file->getRealPath());
                        $logo = Image::make(public_path("img/logo.png"))->opacity(20);
                        $img->insert($logo, 'center');
                        $img->save(public_path($path)."/$filename");
                    } else {
                        $file->move(public_path($path), $filename);
                    }
                    $inputs['filename'] = $filename;
                }
                if ( $row->filename != $inputs['filename']  and @$file!='') {
                    @unlink(public_path($row->path));
                }
                $inputs['path'] = $path.$inputs['filename'];
                
                /*FileMobile*/
                $inputs['filename_mobile'] = $row->filename_mobile;
                if ( $request->hasFile("file_mobile") ) {
                    $file = $request->file('file_mobile', null);
                    
                    $ext = $file->getClientOriginalExtension();
                    $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
					sleep(1);
                    $new_name = str_slug($name).MD5(time()).rand(10,999);
                    $filename = $new_name.".".$ext;
                    if ( $insert_logo == 1 ) {
                        $img = Image::make($file->getRealPath());
                        $logo = Image::make(public_path("img/logo.png"))->opacity(50);
                        $img->insert($logo, 'center');
                        $img->save(public_path($path)."/$filename");
                    } else {
                        $file->move(public_path($path), $filename);
                    }
                    $inputs['filename_mobile'] = $filename;
                    
                    if ( $row->filename_mobile != $inputs['filename_mobile'] and $file!='') {
                        @unlink(public_path($row->path_mobile));
                    }
                    $inputs['path_mobile'] = $path.$inputs['filename_mobile'];
                }
                
                return Helper::query("Media", "save", [
                    "inputs"    =>  $inputs,
                    "id"        =>  $row->id,
                    "route"     =>  "admin.medias",
                ]);
            }
            
        }
        return view("admin.medias.edit", compact("row"));
    }
    
    /**
    * delete media
    *
    * @param int $var
    * @return void
    */
    public function medias_delete($id)
    {
		
        $media = Helper::query("Media", "find", ["id" => $id]);
		$path = $media->path;
		$path_m = $media->path_mobile;
		
		if($path!=''){
        $q1 = DB::select("SELECT * FROM dms_posts WHERE (content_ar LIKE '%$path%') or (content_en LIKE '%$path%' )",[]);
        $q2 = DB::select("SELECT * FROM dms_pages WHERE (content_ar LIKE '%$path%') or (content_en LIKE '%$path%' )");
        $q3 = DB::select("SELECT * FROM dms_regions WHERE (about_ar LIKE '%$path%') or (about_en LIKE '%$path%' )");
        $q4 = DB::select("SELECT * FROM dms_page_search WHERE (content LIKE '%$path%') or (content_en LIKE '%$path%' )");
        $q5 = DB::select("SELECT * FROM dms_cities WHERE (about_ar LIKE '%$path%') or (about_en LIKE '%$path%' )");
        }
		
		if($path_m!=''){
        $q01 = DB::select("SELECT * FROM dms_posts WHERE (content_ar LIKE '%$path_m%') or (content_en LIKE '%$path_m%' )",[]);
        $q02 = DB::select("SELECT * FROM dms_pages WHERE (content_ar LIKE '%$path_m%') or (content_en LIKE '%$path_m%' )");
        $q03 = DB::select("SELECT * FROM dms_regions WHERE (about_ar LIKE '%$path_m%') or (about_en LIKE '%$path_m%' )");
        $q04 = DB::select("SELECT * FROM dms_page_search WHERE (content LIKE '%$path_m%') or (content_en LIKE '%$path_m%' )");
        $q05 = DB::select("SELECT * FROM dms_cities WHERE (about_ar LIKE '%$path_m%') or (about_en LIKE '%$path_m%' )");
		}

		$arr = array();
		if($path!=''){
        if(count($q1)>0){
			$postRow = \App\Models\Post::where('slug', $q1[0]->slug)->first();
			$arr[] = $postRow ? $postRow->frontUrl() : route("front.blog.post", $q1[0]->slug);
		}
        if(count($q2)>0){
			$arr[] = 'https://www.damas.net/'.$q2[0]->slug;
		}
        if(count($q3)>0){
			$arr[] = 'https://www.damas.net/property-for-sale/turkey/'.$q3[0]->slug;
		}
        if(count($q4)>0){
			$arr[] = $q4[0]->link;
		}
        if(count($q5)>0){
			$arr[] = route("front.search", ['property-for-sale', $q5[0]->slug]);
		}
}
		
		if($path_m!=''){
        if(count($q01)>0){
			$postRow = \App\Models\Post::where('slug', $q01[0]->slug)->first();
			$arr[] = $postRow ? $postRow->frontUrl() : route("front.blog.post", $q01[0]->slug);
		}
        if(count($q02)>0){
			$arr[] = 'https://www.damas.net/'.$q02[0]->slug;
		}
        if(count($q03)>0){
			$arr[] = 'https://www.damas.net/property-for-sale/turkey/'.$q03[0]->slug;
		}
        if(count($q04)>0){
			$arr[] = $q04[0]->link;
		}
        if(count($q05)>0){
			$arr[] = route("front.search", ['property-for-sale', $q05[0]->slug]);
		}
		}



$i0 = DB::select("SELECT * FROM dms_cities where media_en_id=? or media_id=?",[$media->id,$media->id]);
if(count($i0)>0)
	$arr[] = 'dms_cities';
$i1 = DB::select("SELECT * FROM dms_page_search where media_en_id=? or media_id=?",[$media->id,$media->id]);
if(count($i1)>0)
	$arr[] = 'dms_page_search';
$i2 = DB::select("SELECT * FROM dms_posts  where media_id=?",[$media->id]);
if(count($i2)>0)
	$arr[] = 'dms_posts';
$i3 = DB::select("SELECT * FROM dms_landingpage_slider where media_id=?",[$media->id]);
if(count($i3)>0)
	$arr[] = 'dms_landingpage_slider';
$i4 = DB::select("SELECT * FROM dms_projects where card_photo_id=?",[$media->id]);
if(count($i4)>0)
	$arr[] = 'dms_projects';
$i5 = DB::select("SELECT * FROM dms_pages where media_id=?",[$media->id]);
if(count($i5)>0)
	$arr[] = 'dms_pages';
$i6 = DB::select("SELECT * FROM dms_project_photos where media_id=?",[$media->id]);
if(count($i6)>0)
	$arr[] = 'dms_project_photos';

$i7 = DB::select("SELECT * FROM dms_project_plan_photos where media_id=?",[$media->id]);
if(count($i7)>0)
	$arr[] = 'dms_project_plan_photos';
$i8 = DB::select("SELECT * FROM dms_testimonials where media_id=?",[$media->id]);
if(count($i8)>0)
	$arr[] = 'dms_testimonials';
$i9 = DB::select("SELECT * FROM dms_sliders where media_mobile_id=? or media_id=?",[$media->id,$media->id]);
if(count($i9)>0)
	$arr[] = 'dms_sliders';
$i10 = DB::select("SELECT * FROM dms_videos where media_id=?",[$media->id]);
if(count($i10)>0)
	$arr[] = 'dms_videos';



if(count($arr)>0){
	echo '<p style="    direction: rtl;
    font-family: Tahoma;
    text-align: center;
    color: white;
    background-color: red;
    padding: 9px 0;
    margin: 33px 0;">الحذف غير مسموح . هذه الصورة مستخدمة في '. count($arr) . ' صفحات</p>';
	
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
	exit;
}


        $filepath = public_path($media->path);
        @unlink($filepath);
        $filepath_mobile = public_path($media->path_mobile);
        @unlink($filepath_mobile);
        return Helper::query("Media", "delete", ["id" => $id]);
    }
    
    /**
    * media folders
    *
    * @return void
    */
    public function medias_folders_index()
    {
        $rows  = Helper::query("MediaFolder", "paginate");
        return view("admin.medias.folders_index", compact("rows"));
    }
    
    /**
    * media folder edit
    *
    * @param int $id
    * @return void
    */
    public function medias_folders_edit(Request $request, $id)
    {
        $row = Helper::query("MediaFolder", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "name"  =>  "required",
            ]);
            return Helper::query("MediaFolder", "save", [
                "inputs"    =>  $request->all(),
                "id"        =>  $id,
                "route"     =>  "admin.medias.folders",
            ]);
        }
        return view("admin.medias.folders_edit", compact("row"));
    }
    
    /**
    * media folder delete
    *
    * @param int $id
    * @return void
    */
    public function medias_folders_delete($id)
    {
        $folder = Helper::query("MediaFolder", "find", ['id' => $id]);
        $cnt = $folder->medias->count();
        if ( $cnt == 0 ) {
            return Helper::query("MediaFolder", "delete", ["id" => $id]);
        }
        return redirect()->back()->with("flashmessage", [
            "typ"       => "danger",
            "message"   => "المجلد يحتوي على ".$cnt." صورة، لا يمكنك حذفه."
        ]);   
    }
    
	 /**
    * rating params
    *
    * @return void
    */
    public function rating(Request $request)
    {
		
		$row = Helper::query("Rating", "find", ["id" => 1]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "off_msg_ar"  =>  "required",
                "fresh_msg_ar"  =>  "required",
            ]);
            $inputs = $request->all();
            $saved =  Helper::query("Rating", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $row->id,
            ]);
            return redirect()->back();
        }
        return view("admin.rating.params", compact("row"));
    }
    
    /**
    * pages
    *
    * @return void
    */
    public function pages_privacy(Request $request)
    {
        return $this->save_pages($request, "privacy", "Privacy Policy");
    }
	public function pages_resale(Request $request)
    {
        return $this->save_pages($request, "resale", "Resale Policy");
    }
	public function pages_turkey_guide(Request $request)
    {
        return $this->save_pages($request, "turkey_guide", "Turkey Guide");
    }
	public function pages_360(Request $request)
    {
        return $this->save_pages($request, "360", "Page 360");
    }
	public function pages_turkish_nationality(Request $request)
    {
        return $this->save_pages($request, "turkish-nationality", "Turkish Nationality");
    }
	public function pages_turkey_territories(Request $request)
    {
        return $this->save_pages($request, "turkey-territories", "Turkish Territories");
    }
	public function pages_rating(Request $request)
    {
        return $this->save_pages($request, "rating", "Rating");
    }
    public function pages_quiz(Request $request)
    {
        return $this->save_pages($request, "quiz", "Quiz");
    }
    public function pages_terms(Request $request)
    {
        return $this->save_pages($request, "terms", "Terms of Use");
    }
    public function pages_about_us(Request $request)
    {
        return $this->save_pages($request, "about-us", "About Use");
    }
    public function pages_turkish_citizenship(Request $request)
    {
        return $this->save_pages($request, "turkish-citizenship", "Turkish Citizenship");
    }
    public function pages_legal(Request $request)
    {
        return $this->save_pages($request, "legal", "Legal");
    }
    public function pages_faq(Request $request)
    {
        return $this->save_pages($request, "faq", "Faq");
    }
    public function pages_offers(Request $request)
    {
        return $this->save_pages($request, "offers", "Offers");
    }
    public function pages_investment(Request $request)
    {
        return $this->save_pages($request, "investment", "Investment");
    }
    public function pages_living_turkey(Request $request)
    {
        return $this->save_pages($request, "living_turkey", "Living Turkey");
    }
    public function pages_vacancies(Request $request)
    {
        return $this->save_pages($request, "jobs", "Jobs");
    }
    function save_pages($request, $slug = null, $app_title = null)
    {
		
        $row = Helper::query("Page", "where", ["field" => "slug", "value" => $slug])->first();
		
        if ( !$row ) $row = Helper::query("Page", "new");
		
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "name"  =>  "required",
            ]);
            $inputs = $request->all();
			if($slug=='turkish-citizenship'){
				$inputs["title_ar"] = htmlentities($inputs["seo_title_ar"]);
				$inputs["title_en"] = htmlentities($inputs["seo_title_en"]);
				
				$inputs["content_ar"] = htmlentities($inputs["content_ar"]);
				$inputs["content_en"] = htmlentities($inputs["content_en"]);
				$inputs["content_fr"] = htmlentities($inputs["content_fr"]);
				$inputs["content_fa"] = htmlentities($inputs["content_fa"]);
				//$inputs["content_ar"] = htmlentities($inputs["seo_description_ar"]);
				//$inputs["content_en"] = htmlentities($inputs["seo_description_en"]);
			}elseif($slug=='legal'){
				
			}elseif($slug=='investment'){
				
			}elseif($slug=='faq'){
				
				/*$q_ar = $request->get('q_ar', []);
				$r_ar = $request->get('r_ar', []);
				$q_fa = $request->get('q_fa', []);
				$r_fa = $request->get('r_fa', []);
				$q_fr = $request->get('q_fr', []);
				$r_fr = $request->get('r_fr', []);
				$q_en = $request->get('q_en', []);
				$r_en = $request->get('r_en', []);

				DB::table('faq')->delete();
				for($i=0;$i<count($q_ar);$i++){
					DB::table('faq')->insert([
					'q_ar'=>$q_ar[$i],
					'r_ar'=>$r_ar[$i],
					'q_en'=>$q_en[$i],
					'r_en'=>$r_en[$i],
					'q_fr'=>$q_fr[$i],
					'r_fr'=>$r_fr[$i],
					'q_fa'=>$q_fa[$i],
					'r_fa'=>$r_fa[$i]
					]);
				}*/
			}elseif($slug=='living_turkey'){
				
			}else{
				$inputs["content_ar"] = htmlentities($inputs["content_ar"]);
				$inputs["content_en"] = htmlentities($inputs["content_en"]);
			}
            $inputs["slug"] = $slug;
            $saved_page = Helper::query("Page", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $row->id,
            ]);
            
            // projects
            $saved_page->syncProjects($request->get('project_id', []));
			/*if($slug=='turkish-citizenship')
				$saved_page->syncProjects2($request->get('project_id2', []));*/
            
			
			
			Helper::Clear_cache([ 'https://damas.net/' . $saved_page->slug_link ]);
			
            return redirect()->back();
        }
		if($slug=='turkish-citizenship'){
			return view("admin.pages.turkish_citizenship_edit", compact("row", "slug", "app_title"));
		}elseif($slug=='legal'){
			return view("admin.pages.legal", compact("row", "slug", "app_title"));
		}elseif($slug=='faq'){
			
			return view("admin.pages.faq", compact("row", "slug", "app_title"));
			
		}elseif($slug=='investment'){
			return view("admin.pages.investment", compact("row", "slug", "app_title"));
		}elseif($slug=='living_turkey'){
			return view("admin.pages.living_turkey", compact("row", "slug", "app_title"));
		}elseif($slug=='about-us'){
			return view("admin.pages.about_us_edit", compact("row", "slug", "app_title"));
		}
		else
			return view("admin.pages.edit", compact("row", "slug", "app_title"));
    }
    public function pages_search()
    {
        $rows = Helper::query("PageSearch", "paginate");
        return view("admin.pages.search.index", compact("rows"));
    }
    public function pages_search_edit(Request $request, $id = null)
    {
        $row = Helper::query("PageSearch", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "name"  =>  "required",
                "link"  =>  "required",
            ]);
            return Helper::query("PageSearch", "save", [
                "inputs"    =>  $request->all(),
                "id"        =>  $id,
                "route"     =>  "admin.pages.search",
            ]);
        }
        return view("admin.pages.search.edit", compact("row"));
    }
	public function pages_search_delete($id)
    {
        return Helper::query("PageSearch", "delete", ["id" => $id]);
    }
	
	
	
	
    public function faqpost()
    {
		$move = Input::get("move");
        if ( $move ) {
            $pos = Input::get("pos");
            $selected_row = Helper::query("Faqpost", "find", ["id" => Input::get("id")]);
            switch ($move)
            {
                case 'first':
                    $index = $selected_row->placement;
                    $selected_row->update(["placement" => 1]);
                    Helper::query("Faqpost", "where", ["field" => "id", "value" => $selected_row->id, "operation" => "<>"])->where("placement", "<", $index)->update(["placement" => \DB::raw("placement+1")]);
                    break;
                    
                case 'last':
                    $index = $selected_row->max("placement")+1;
                    $selected_row->update(["placement" => $index]);
                    break;
                    
                case 'up':
                    $selected_row->update(["placement" => \DB::raw("placement-1")]);
                    break;
                    
                case 'down':
                    $selected_row->update(["placement" => \DB::raw("placement+1")]);
                    break;
                    
                default:
                    /*$target_row = Helper::query("Post", "find", ["id" => $pos]);
                    $index1 = $selected_row->placement;
                    $index2 = @$target_row->placement;                    
                    $selected_row->update(["placement" => $index2]);
                    $target_row->update(["placement" => $index1]);*/
                    break;                    
            }
            return redirect()->back();
        }
        if ( !Input::get("field") )
            Input::replace(['field' => 'placement', 'sort' => 'asc']);
		
        $rows = Helper::query("Faqpost", "paginate");
        return view("admin.faqpost.index", compact("rows"));
    }
    public function faqpost2($id=0)
    {
        
		$fap = Helper::query("Faqpost", "find", ["id" => $id]);
        $pgtitle = $fap->title_ar;
        
		
		
		$where = [];
		if(isset($_GET['search']) && $_GET['search']!=''){
			
			/*$where[] = ["faq_post", "=", $id];
			$where[] = ["q_ar", "like", $search];
			$where[] = ["q_fa", "like", $search];
			$where[] = ["q_fr", "like", $search];
			$where[] = ["q_ru", "like", $search];
			$where[] = ["q_en", "like", $search];
			$where[] = ["r_ar", "like", $search];
			$where[] = ["r_fa", "like", $search];
			$where[] = ["r_fr", "like", $search];
			$where[] = ["r_ru", "like", $search];
			$where[] = ["r_en", "like", $search];*/
			$rows = Helper::query("Faq", "where", ["field" => "faq_post", "value" => $id, "operation" => "="])
			->where(function($q) {
				$search = '%'.$_GET['search'].'%';
				$q->where("q_ar", "like", $search)
				->orWhere("q_en", "like", $search)
				->orWhere("q_fr", "like", $search)
				->orWhere("q_fa", "like", $search)
				->orWhere("q_ru", "like", $search)
				->orWhere("r_ar", "like", $search)
				->orWhere("r_en", "like", $search)
				->orWhere("r_fr", "like", $search)
				->orWhere("r_fa", "like", $search)
				->orWhere("r_ru", "like", $search);
			})
			->paginate();
			//Helper::query("Faq", "paginate", $where,'or');
		}else{
			$rows = Helper::query("Faq", "where", ["field" => "faq_post", "value" => $id, "operation" => "="])->paginate();
        }
		
		return view("admin.faqpost2.index", compact("rows","pgtitle","id"));
    }
	
    public function faqpost_create(Request $request, $id = null)
    {
        $row = Helper::query("Faqpost", "find", ['id' => $id]);
		$faqs = DB::select("select * from dms_faq where faq_post=? order by id asc",[$id]);
		
        if ( $request->isMethod('post') ) {
            /*$this->validate($request, [
                "title_ar"  =>  "required",
            ]);*/
			
			
            $faqpost = Helper::query("Faqpost", "save", [
                "inputs"    =>  $request->all(),
                "id"        =>  $id,
            ]);
			
				$str_posts = $request->get('str_posts', []);
				$q_ar = $request->get('q_ar', []);
				$r_ar = $request->get('r_ar', []);
				$q_fa = $request->get('q_fa', []);
				$r_fa = $request->get('r_fa', []);
				$q_fr = $request->get('q_fr', []);
				$r_fr = $request->get('r_fr', []);
				$q_en = $request->get('q_en', []);
				$r_en = $request->get('r_en', []);
				$q_ru = $request->get('q_ru', []);
				$r_ru = $request->get('r_ru', []);

				//DB::table('faq')->where('faq_post',$faqpost->id)->delete();
				for($i=0;$i<count($q_ar);$i++){
					DB::table('faq')->insert([
						'faq_post'=>$faqpost->id,
						'q_ar'=>$q_ar[$i],
						'r_ar'=>$r_ar[$i],
						'q_en'=>$q_en[$i],
						'r_en'=>$r_en[$i],
						'q_fr'=>$q_fr[$i],
						'r_fr'=>$r_fr[$i],
						'q_fa'=>$q_fa[$i],
						'r_fa'=>$r_fa[$i],
						'q_ru'=>$q_ru[$i],
						'r_ru'=>$r_ru[$i],
						'str_posts'=>$str_posts[$i]
					]);
				}
				
				return redirect()->route("admin.faqpost");
        }
        return view("admin.faqpost.create", compact("row","faqs"));
    }
    public function faqpost_edit(Request $request, $id = null)
    {
        $row = Helper::query("Faqpost", "find", ['id' => $id]);
		$faqs = DB::select("select * from dms_faq where faq_post=? order by id asc",[$id]);
		
        if ( $request->isMethod('post') ) {
            /*$this->validate($request, [
                "title_ar"  =>  "required",
            ]);*/
			
			
            $faqpost = Helper::query("Faqpost", "save", [
                "inputs"    =>  $request->all(),
                "id"        =>  $id,
            ]);
			/*
				$str_posts = $request->get('str_posts', []);
				$q_ar = $request->get('q_ar', []);
				$r_ar = $request->get('r_ar', []);
				$q_fa = $request->get('q_fa', []);
				$r_fa = $request->get('r_fa', []);
				$q_fr = $request->get('q_fr', []);
				$r_fr = $request->get('r_fr', []);
				$q_en = $request->get('q_en', []);
				$r_en = $request->get('r_en', []);
				$q_ru = $request->get('q_ru', []);
				$r_ru = $request->get('r_ru', []);

				DB::table('faq')->where('faq_post',$faqpost->id)->delete();
				for($i=0;$i<count($q_ar);$i++){
					DB::table('faq')->insert([
						'faq_post'=>$faqpost->id,
						'q_ar'=>$q_ar[$i],
						'r_ar'=>$r_ar[$i],
						'q_en'=>$q_en[$i],
						'r_en'=>$r_en[$i],
						'q_fr'=>$q_fr[$i],
						'r_fr'=>$r_fr[$i],
						'q_fa'=>$q_fa[$i],
						'r_fa'=>$r_fa[$i],
						'q_ru'=>$q_ru[$i],
						'r_ru'=>$r_ru[$i],
						'str_posts'=>$str_posts[$i]
					]);
				}*/
				
				return redirect()->route("admin.faqpost");
        }
        return view("admin.faqpost.edit", compact("row","faqs"));
    }
    public function faqpost2_edit(Request $request, $id = null)
    {
		//exit('r');
        $row = Helper::query("Faq", "find", ['id' => $id]);
		//$posts = DB::select("select * from dms_faq where faq_post=? order by id asc",[$id]);
		
        if ( $request->isMethod('post') ) {
            /*$this->validate($request, [
                "q_ar"  =>  "required",
                "r_ar"  =>  "required",
            ]);*/
			
			
            /*$faqpost = Helper::query("Faqpost", "save", [
                "inputs"    =>  $request->all(),
                "id"        =>  $id,
            ]);*/
			//if ( !$row ) $row = Helper::query("Faq", "new");
				$inputs = $request->all();
				$inputs['str_posts'] = ','.implode(',',$request->get('posts', [])).',';
				/*$inputs['q_ar'] = $request->get('q_ar');
				$inputs['r_ar'] = $request->get('r_ar');
				$inputs['q_fa'] = $request->get('q_fa');
				$inputs['r_fa'] = $request->get('r_fa');
				$inputs['q_fr'] = $request->get('q_fr');
				$inputs['r_fr'] = $request->get('r_fr');
				$inputs['q_en'] = $request->get('q_en');
				$inputs['r_en'] = $request->get('r_en');
				$inputs['q_ru'] = $request->get('q_ru');
				$inputs['r_ru'] = $request->get('r_ru');*/
				$inputs['faq_post'] = $request->get('category');
				if($_POST['create']==1)
					Helper::query("Faq", "save", [
						"inputs"    =>  $inputs
						]);
				else
					Helper::query("Faq", "save", [
						"inputs"    =>  $inputs,
						"id"        =>  $id,
					]);
				/*DB::table('faq')->where('faq_post',$faqpost->id)->delete();
				for($i=0;$i<count($q_ar);$i++){
					DB::table('faq')->insert([
						'faq_post'=>$faqpost->id,
						'q_ar'=>$q_ar[$i],
						'r_ar'=>$r_ar[$i],
						'q_en'=>$q_en[$i],
						'r_en'=>$r_en[$i],
						'q_fr'=>$q_fr[$i],
						'r_fr'=>$r_fr[$i],
						'q_fa'=>$q_fa[$i],
						'r_fa'=>$r_fa[$i],
						'q_ru'=>$q_ru[$i],
						'r_ru'=>$r_ru[$i],
						'str_posts'=>$str_posts[$i]
					]);
				}*/
				//exit(route("admin.faqpost2",['id'=>$_POST['category']]));
				return redirect()->route("admin.faqpost2",@$_POST['category']);
				//return redirect()->back();
        }
        return view("admin.faqpost2.edit", compact("row","id"));
    }
    public function faqpost_delete($id)
    {
		DB::table('faq')->where('faq_post',$id)->delete();
        return Helper::query("Faqpost", "delete", ["id" => $id]);
    }
    public function faqpost2_delete($id)
    {
		
        return Helper::query("Faq", "delete", ["id" => $id]);
    }
	
	
	
	
	
	
    public function livingcat()
    {
		$move = Input::get("move");
        if ( $move ) {
            $pos = Input::get("pos");
            $selected_row = Helper::query("Livingcat", "find", ["id" => Input::get("id")]);
            switch ($move)
            {
                case 'first':
                    $index = $selected_row->placement;
                    $selected_row->update(["placement" => 1]);
                    Helper::query("Livingcat", "where", ["field" => "id", "value" => $selected_row->id, "operation" => "<>"])->where("placement", "<", $index)->update(["placement" => \DB::raw("placement+1")]);
                    break;
                    
                case 'last':
                    $index = $selected_row->max("placement")+1;
                    $selected_row->update(["placement" => $index]);
                    break;
                    
                case 'up':
                    $selected_row->update(["placement" => \DB::raw("placement-1")]);
                    break;
                    
                case 'down':
                    $selected_row->update(["placement" => \DB::raw("placement+1")]);
                    break;
                    
                default:
                    /*$target_row = Helper::query("Post", "find", ["id" => $pos]);
                    $index1 = $selected_row->placement;
                    $index2 = @$target_row->placement;                    
                    $selected_row->update(["placement" => $index2]);
                    $target_row->update(["placement" => $index1]);*/
                    break;                    
            }
            return redirect()->back();
        }
        if ( !Input::get("field") )
            Input::replace(['field' => 'placement', 'sort' => 'asc']);
		
        $rows = Helper::query("Livingcat", "paginate");
        return view("admin.livingcat.index", compact("rows"));
    }
	
    public function livingcat_edit(Request $request, $id = null)
    {
        $row = Helper::query("Livingcat", "find", ['id' => $id]);
		$livingitems = DB::select("select * from dms_livingitem where livingcat_id=? order by id asc",[$id]);
		
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "title_ar"  =>  "required",
            ]);
			
			
            $livingcat = Helper::query("Livingcat", "save", [
                "inputs"    =>  $request->all(),
                "id"        =>  $id,
            ]);
			
				$name_ar = $request->get('name_ar', []);
				$name_en = $request->get('name_en', []);
				$name_fr = $request->get('name_fr', []);
				$name_fa = $request->get('name_fa', []);
				$name_ru = $request->get('name_ru', []);
				$price = $request->get('price', []);

				DB::table("livingitem")->where('livingcat_id',$livingcat->id)->delete();
				for($i=0;$i<count($name_ar);$i++){
					DB::table("livingitem")->insert([
						'livingcat_id'=>$livingcat->id,
						'name_ar'=>$name_ar[$i],
						'name_en'=>$name_en[$i],
						'name_fr'=>$name_fr[$i],
						'name_fa'=>$name_fa[$i],
						'name_ru'=>$name_ru[$i],
						'price'=>$price[$i]
					]);
				}
				
				return redirect()->route("admin.livingcat");
        }
        return view("admin.livingcat.edit", compact("row","livingitems"));
    }
    public function livingcat_delete($id)
    {
		DB::table("Livingitem")->where('livingcat_id',$id)->delete();
        return Helper::query("Livingcat", "delete", ["id" => $id]);
    }
	
	
	
	
	
	
    
    /**
    * roles index
    *
    * @return void
    */
    public function users_roles_index()
    {
		//exit;
		if(isset($_GET['ysf'])){
			$rows = Helper::query("Role", "where", ["field" => "slug", "operation" => "!=", "value" => "superadmin"])->paginate(30);
			return view("admin.users.roles_index", compact("rows"));
		}
    }
    
    /**
    * roles edit
    *
    * @param int $id
    * @return void
    */
    public function users_roles_edit(Request $request, $id = null)
    {
        $row = Helper::query("Role", "find", ['id' => $id]);
        $permissions = Helper::query("Permission", "all");
        if ( $request->isMethod('post') ) {
			
			echo '<pre>';
			print_r($request->get("permissions", []));
			echo '</pre>';
			exit;

			$this->validate($request, [
                "name"  =>  "required",
            ]);
            // save
            $inputs = $request->all();
            if ( !$id ) {
                $inputs["slug"] = str_slug($inputs["name"]).time();
            }
            $role = Helper::query("Role", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
            ]);
            // permissions
            $input_permissions = $request->get("permissions", []);
            foreach ($permissions as $permission) {
                if ( in_array($permission->slug, $input_permissions) ) {
                    $role->attachPermission($permission);
                } else {
                    $role->detachPermission($permission);
                }
            }
            return Helper::form_redirect("admin.users.roles", $role, @$inputs['redirect_to_list']);
        }
        return view("admin.users.roles_edit", compact("row", "permissions"));
    }
    /**
    * delete role
    *
    * @param int $var
    * @return void
    */
    public function users_roles_delete($id)
    {
        return Helper::query("Role", "delete", ["id" => $id]);
    }
    
    /**
    * users index
    *
    * @return void
    */
    public function users_index()
    {
        $rows = Helper::query("User", "paginate");
        return view("admin.users.index", compact("rows"));
    }
    
    /**
    * users edit
    *
    * @param Illuminate\Http\Request $request
    * @param int $var
    * @return void
    */
    public function users_edit(Request $request, $id = null)
    {
        $row = Helper::query("User", "find", ['id' => $id]);
        //$roles = Helper::query("Role", "all");
        $permissions = Helper::query("Permission", "all");
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "username"  =>  "required|alpha_dash|unique:{$row->table_name()},username,$id",
                "name"  =>  "required",
                "email"  =>  "required|unique:{$row->table_name()},email,$id",
                "role"  =>  "required",
            ]);
            $inputs = $request->all();
            
            $password = @$inputs["password"];
            if ( $password )
                $inputs["password"] = bcrypt($password);
            
            $user =  Helper::query("User", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
            ]);
            
            /*roles*/
            $role = $inputs["role"];
            $user->detachAllPermissions();
            $user->detachAllRoles();
            if ( $role == "superadmin" ) {
                $user->attachRole(1);
                $inputs["role_lib"] = "Administrator";
            } else {
                $input_permissions = $request->get("permissions", []);
                foreach ($permissions as $permission) {
                    if ( in_array($permission->slug, $input_permissions) ) {
                        $user->attachPermission($permission);
                    } else {
                        $user->detachPermission($permission);
                    }
                }
                $inputs["role_lib"] = implode(" - ", $user->permissions()->lists("name")->toArray());
                if ( in_array("admin.support", $input_permissions) ) {
                    $inputs["role_type"] = "support";
                }
            }
            $user->update([
                "role_lib" => $inputs["role_lib"],
                "role_type" => @$inputs["role_type"],
            ]);

            return Helper::form_redirect("admin.users", $user, @$inputs['redirect_to_list']);
        }
        return view("admin.users.edit", compact("row", "permissions"));
    }
    
    /**
    * delete user
    *
    * @param int $id
    * @return void
    */
    public function users_delete($id)
    {
        $admins = Helper::query("User", "where", ["field" => "role", "value" => "superadmin"])->get();
        if ( count($admins) > 0 ) 
            return Helper::query("User", "delete", ["id" => $id]);
        return redirect()->back();
    }
    
	
	
    public function clear_cache(Request $request, $id = null){
        if ($request->isMethod('post')) {
    
            if ($request->get('clear_all')) {
    
                Helper::Clear_all_cache();
    
                return redirect()->back()->with('flashmessage', [
                    'typ' => 'success',
                    'message' => 'Successfully cleared all cache.'
                ]);
    
            } 
            else {
    
                $this->validate($request, [
                    "urls" => "required",
                ]);
    
                $urls = $request->get('urls');
    
                $urls = explode("\n", $urls);
    
                Helper::Clear_cache($urls);
    
                return redirect()->back()->with('flashmessage', [
                    'typ' => 'success',
                    'message' => 'Successfully purged assets. Please allow up to 30 seconds for changes to take effect.'
                ]);
            }
        }
    
        return view("admin.cache.clear_cache");
    }
	/*public function keywords(Request $request, $id = null)
    {
		
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "urls"  =>  "required",
            ]);
			
				$urls = $request->get('urls');
				
				$urls = explode("\n",$urls);
				
				
				Helper::Clear_cache($urls);
				
				return redirect()->back()->with('flashmessage', ['typ' => 'success', 'message' => 'Successfully purged assets. Please allow up to 30 seconds for changes to take effect.']); 
				//return redirect()->route("admin.clear_cache");
        }
        return view("admin.keywords.edit");
    }*/
	
	
    /**
    * compte
    *
    * @return void
    */
    public function compte(Request $request)
    {
        $user = $request->user();
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "name"  =>  "required",
                "password"  =>  "required",
                "new_password"  =>  "confirmed",
            ]);
            $inputs = $request->all();
            if (\Hash::check($request->get('password'), $user->password)) {
                if ( $inputs["new_password"] ) {
                    $user->password = bcrypt($request->get('new_password'));
                }
                $user->name = $request->get('name');
                $user->save();
                $message = "تم التحديث بنجاح";
                $type = "success";
            } else {
                $message = "كلمة المرور الحالية غير صحيحة!";
                $type = "danger";
            }
            
            return redirect()->back()->with('flashmessage', ['typ' => $type, 'message' => $message]);            
        }
        return view("admin.compte.edit", compact("user"));
    }
    
    /**
    * stats
    *
    * @return void
    */
    public function stats_index()
    {
        Helper::query("VisitorTrack", "where", ["field" => "blocked", "value" => 0])->where(\DB::raw("DATEDIFF(NOW(), updated_at)"), ">", 3)->orWhere("deleted", 1)->delete();
        //Helper::query("VisitorTrack", "where", ["field" => "deleted", "value" => 1])->where("blocked", 0)->delete();
        /*filter*/
        $q = Helper::query("VisitorTrack", "where", ["field" => "id", "value" => 0, "operation" => ">"]);
        $ip = Input::get("ip");
        if ( $ip ) $q->where("ip", "like", "%$ip%");
        
        $date = Input::get("date");
        if ( $date ) $q->where("date_visit", "like", "%$date%");
        
        $country = Input::get("country");
        if ( $country ) $q->where("country", "like", "%$country%");
        
        $city = Input::get("city");
        if ( $city ) $q->where("city", "like", "%$city%");
        
        $field = Input::get("field") ? Input::get("field") : "updated_at";
        $sort = in_array(Input::get("sort"), ["asc", "desc"]) ? Input::get("sort") : "desc";
        $rows = $q->orderBy("$field", "$sort")->paginate(Helper::ajax_change_paginate_number());
        
        return view("admin.stats.index", compact("rows"));
    }
    
    /**
    * add ip
    *
    * @return void
    */
    public function stats_edit(Request $request, $id = null)
    {
        $row = Helper::query("VisitorTrack", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
            $this->validate($request, [
                "ip"  =>  "required",
            ]);
            // save
            $inputs = geoip()->getLocation($request->get("ip", null))->toArray();
            $inputs["blocked"] = 1;
            $inputs["page_views"] = 1;
            $saved = Helper::query("VisitorTrack", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id,
            ]);
            return redirect()->route("admin.stats");
        }
        return view("admin.stats.edit", compact("row"));
    }
    
    /**
    * delete stats
    *
    * @param int $id
    * @return void
    */
    public function stats_delete($id)
    {
        return Helper::query("VisitorTrack", "delete", ["id" => $id]);
    }
    
    /**
    * block ip
    *
    * @param int $id
    * @return void
    */
    public function stats_block($id)
    {
        $row = Helper::query("VisitorTrack", "find", ["id" => $id]);
        if ( $row->id ) {
            $row->blocked = $row->blocked == 1 ? 0 : 1;
            $row->save();
        }
        return redirect()->back();
    }
    
	
	
	
	
	
	
	
	
    /**
    * landing page list
    *
    * @return void
    */
    public function landing3_index()
    {
        $rows = Helper::query("Landing3", "paginate");
        return view("admin.landing3.index", compact("rows"));
    }
    
    /**
    * edit landing page
    *
    * @param int $var
    * @return void
    */
    public function landing3_edit(Request $request, $id = null)
    {
        $row = Helper::query("Landing3", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
			
            $this->validate($request, [
                //"name"  =>  "required",
                "lang"  =>  "required",
                //"slug"  =>  "required|alpha_dash|unique:{$row->table_name()},slug,$id",
                //"project_id"  =>  "required",
            ]);
            
			$inputs = $request->all();
			
			if(isset($inputs["lang"])){
				$inputs["lang"] = implode(',',$inputs["lang"]);
			}
			
            $saved = Helper::query("Landing3", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id
            ]);
			//exit;
			/*
            // sliders
            //$saved->syncLandingSliders($request->get('landing_sliders', []));
            // infos
            Helper::query("Landing3Infos", "where", ["field" => "landing3_id", "value" => $saved->id])->delete();
            $infos = $request->get("infos_title", []);
            foreach ($infos as $k => $info) {
                if ( !$info ) continue;
                $arr = [
                    "landing3_id"    =>  $saved->id,
                    "icon"    =>  @$inputs["infos_icon"][$k],
                    "title"    =>  $info,
                    "description"    =>  @$inputs["infos_description"][$k],
                ];
                Helper::query("Landing3Infos", "save", ['inputs' => $arr]);
            }
            */
			
			//$saved->syncOffers($request->get('landing3_offer', []));
			
			//type_project[]
			if($id != null)
			DB::table('landing3_resell_offer')->where('landing3_id',$row->id)->delete();
			
			$type_project = $request->get('type_project', []);
			$offer_id = $request->get('offer_id', []);
			$resale_id = $request->get('resale_id', []);
			$title = $request->get('title', []);
			$title_en = $request->get('ititle_en', []);
			$title_fr = $request->get('ititle_fr', []);
			$title_ru = $request->get('ititle_ru', []);
			$title_pe = $request->get('ititle_pe', []);
			$arrange = $request->get('arrange', []);
			
			for($i=0;$i<count($type_project);$i++){
				DB::table('landing3_resell_offer')->insert([
				'landing3_id'=>($id != null?$id:$saved->id),
				'type_project'=>$type_project[$i],
				'offer_id'=>$offer_id[$i],
				'resale_id'=>$resale_id[$i],
				'title'=>@$title[$i],
				'title_en'=>@$title_en[$i],
				'title_fr'=>@$title_fr[$i],
				'title_pe'=>@$title_pe[$i],
				'title_ru'=>@$title_ru[$i],
				'arrange'=> (int)$arrange[$i]
				
				]);
			}
			
			    return Helper::form_redirect("admin.landing3", $saved, $request->get('redirect_to_list', null));
        }

				$resells = \App\Models\Resellproject::where('offer_end_date','>=',DB::raw('date(NOW())'))->get();
				$offers = \App\Models\Land2offer::where('offer_end_date','>=',DB::raw('date(NOW())'))->get();
				
				
				
				$landing3_resell_offers = DB::select("SELECT * FROM `dms_landing3_resell_offer` WHERE `landing3_id`=?",[$row->id]);

				$offers_label = [];
				foreach($offers as $o){
					$tmn = 'O'. $o->name . $o->id .'-'. @$o->project->name_en .'-'. @$o->project->region->name_en .'-'. @$o->offertype->name_en . ( $o->pattern=='+'?'':'('.$o->pattern.')' );
					$offers_label[] = $tmn;
				}

				$resells2_label = [];
				foreach($resells as $o){
					$tmn = 'R'. $o->name . $o->id .'-'. @$o->city->name_en .'-'. @$o->region->name_en .'-'. @$o->type->name_en . ( @$o->room=='+'?'':'('.$o->room.')' );
					$resells2_label[] = $tmn;
				}



        return view("admin.landing3.edit", compact("row","resells","offers","landing3_resell_offers","offers_label","resells2_label"));
    }
    
    /**
    * delete landing page
    *
    * @param int $var
    * @return void
    */
    public function landing3_delete($id)
    {
        return Helper::query("Landing3", "delete", ["id" => $id]);
    }
    
    public function landing3_initializeviews($id)
    {
        $row = Helper::query("Landing3", "find", ['id' => $id]);
        $row->views = 0;
        $row->save();
        return redirect()->back();
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    /**
    * landing page list
    *
    * @return void
    */
    public function landing_tourism_index()
    {
        $rows = Helper::query("LandingTourism", "paginate");
        return view("admin.landing_tourism.index", compact("rows"));
    }

    /**
    * edit landing page
    *
    * @param int $var
    * @return void
    */
    public function landing_tourism_edit(Request $request, $id = null)
    {
        $row = Helper::query("LandingTourism", "find", ['id' => $id]);
        if ( $request->isMethod('post') ) {
			
            $this->validate($request, [
                "lang"  =>  "required",
            ]);
            
			$inputs = $request->all();
			
			if(isset($inputs["lang"])){
				$inputs["lang"] = implode(',',$inputs["lang"]);
			}
			
            $saved = Helper::query("LandingTourism", "save", [
                "inputs"    =>  $inputs,
                "id"        =>  $id
            ]);
			
			
			    return Helper::form_redirect("admin.landing_tourism", $saved, $request->get('redirect_to_list', null));
        }

        return view("admin.landing_tourism.edit", compact("row"));
    }

    /**
    * delete landing page
    *
    * @param int $var
    * @return void
    */
    public function landing_tourism_delete($id)
    {
        return Helper::query("LandingTourism", "delete", ["id" => $id]);
    }

    public function landing_tourism_initializeviews($id)
    {
        $row = Helper::query("LandingTourism", "find", ['id' => $id]);
        $row->views = 0;
        $row->save();
        return redirect()->back();
    }
}