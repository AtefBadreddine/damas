<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UnifyMenusLink extends Migration
{
    /**
     * Collapse per-locale link columns into a single locale-neutral link.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('menus')) {
            return;
        }

        $rows = DB::table('menus')->get();
        foreach ($rows as $row) {
            $source = $this->pickSourceLink($row);
            $normalized = $this->normalizeMenuLink($source);
            DB::table('menus')->where('id', $row->id)->update(array('link' => $normalized));
        }

        $columnsToDrop = array('link_en', 'link_fr', 'link_ru', 'link_fa');
        foreach ($columnsToDrop as $column) {
            if (Schema::hasColumn('menus', $column)) {
                Schema::table('menus', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }

    /**
     * @param object $row
     * @return string|null
     */
    protected function pickSourceLink($row)
    {
        foreach (array('link', 'link_en', 'link_fr', 'link_ru', 'link_fa') as $column) {
            if (!empty($row->$column)) {
                return $row->$column;
            }
        }

        return isset($row->link) ? $row->link : null;
    }

    /**
     * @param string|null $url
     * @return string
     */
    protected function normalizeMenuLink($url)
    {
        if ($url === null || $url === '' || $url === '#') {
            return $url === '#' ? '#' : '/';
        }

        $url = trim($url);
        $url = str_replace(
            array('https://www.damas.net', 'http://www.damas.net', 'https://damas.net', 'http://damas.net'),
            '',
            $url
        );

        if (preg_match('#^(https?:)?//#', $url)
            || strpos($url, 'mailto:') === 0
            || strpos($url, 'tel:') === 0
            || strpos($url, 'javascript:') === 0) {
            return $url;
        }

        $parts = parse_url($url);
        $path = isset($parts['path']) ? $parts['path'] : $url;
        $path = '/' . ltrim($path, '/');
        $segments = array_values(array_filter(explode('/', trim($path, '/')), 'strlen'));

        $localeKeys = array('ar', 'en', 'fr', 'pe', 'ru', 'fa');
        if (count($segments) && in_array($segments[0], $localeKeys, true)) {
            array_shift($segments);
        }

        if (count($segments) === 0) {
            $path = '/';
        } else {
            $path = '/' . implode('/', $segments);
        }

        if (!empty($parts['query'])) {
            $path .= '?' . $parts['query'];
        }
        if (!empty($parts['fragment'])) {
            $path .= '#' . $parts['fragment'];
        }

        return $path;
    }

    /**
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('menus')) {
            return;
        }

        $restore = array('link_en', 'link_fr', 'link_ru', 'link_fa');
        foreach ($restore as $column) {
            if (!Schema::hasColumn('menus', $column)) {
                Schema::table('menus', function (Blueprint $table) use ($column) {
                    $table->string($column)->nullable();
                });
            }
        }
    }
}
