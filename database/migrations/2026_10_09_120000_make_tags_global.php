<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeTagsGlobal extends Migration
{
    /**
     * Merge duplicate tag slugs, then drop type/SEO and enforce global unique slug.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tags')) {
            return;
        }

        $this->mergeDuplicateTagSlugs();

        DB::table('tags')->where('slug', '')->update(array('slug' => null));

        $columnsToDrop = array(
            'country_id',
            'type',
            'seo_title_ar',
            'seo_description_ar',
            'seo_keywords_ar',
            'seo_title_en',
            'seo_description_en',
            'seo_keywords_en',
            'seo_title_fr',
            'seo_description_fr',
            'seo_keywords_fr',
            'seo_title_ru',
            'seo_description_ru',
            'seo_keywords_ru',
            'seo_title_fa',
            'seo_description_fa',
            'seo_keywords_fa',
        );

        foreach ($columnsToDrop as $column) {
            if (Schema::hasColumn('tags', $column)) {
                Schema::table('tags', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }

        $this->assertNoDuplicateSlugs('tags');
        $this->dropIndexIfExists('tags', 'slug', true);
        $this->dropIndexIfExists('tags', 'tags_slug_index', false);
        $this->addSlugUnique('tags', 'tags_slug_unique');
    }

    /**
     * @return void
     */
    protected function mergeDuplicateTagSlugs()
    {
        $pivotTable = 'post_tag';
        if (!Schema::hasTable($pivotTable)) {
            return;
        }

        $groups = DB::table('tags')
            ->select('slug', DB::raw('MIN(id) as keeper_id'), DB::raw('COUNT(*) as cnt'))
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->groupBy('slug')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($groups as $group) {
            $keeperId = (int) $group->keeper_id;
            $duplicateIds = DB::table('tags')
                ->where('slug', $group->slug)
                ->where('id', '!=', $keeperId)
                ->lists('id');

            foreach ($duplicateIds as $duplicateId) {
                $duplicateId = (int) $duplicateId;
                $pivotRows = DB::table($pivotTable)
                    ->where('tag_id', $duplicateId)
                    ->get();

                foreach ($pivotRows as $pivotRow) {
                    $exists = DB::table($pivotTable)
                        ->where('post_id', $pivotRow->post_id)
                        ->where('tag_id', $keeperId)
                        ->exists();

                    if ($exists) {
                        DB::table($pivotTable)
                            ->where('post_id', $pivotRow->post_id)
                            ->where('tag_id', $duplicateId)
                            ->delete();
                    } else {
                        DB::table($pivotTable)
                            ->where('post_id', $pivotRow->post_id)
                            ->where('tag_id', $duplicateId)
                            ->update(array('tag_id' => $keeperId));
                    }
                }

                DB::table('tags')->where('id', $duplicateId)->delete();
            }
        }
    }

    /**
     * @param string $table
     * @return void
     */
    protected function assertNoDuplicateSlugs($table)
    {
        $dupes = DB::table($table)
            ->select('slug', DB::raw('COUNT(*) as cnt'))
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->groupBy('slug')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        if (count($dupes)) {
            $sample = $dupes[0];
            throw new \RuntimeException(
                "Cannot add unique slug on {$table}: duplicates exist, e.g. slug={$sample->slug}"
            );
        }
    }

    /**
     * @param string $table
     * @param string $index
     * @return void
     */
    protected function addSlugUnique($table, $index)
    {
        if ($this->hasIndex($table, $index)) {
            return;
        }

        $prefixed = DB::getTablePrefix() . $table;
        DB::statement('ALTER TABLE `' . $prefixed . '` ADD UNIQUE `' . $index . '` (`slug`(191))');
    }

    /**
     * @param string $table
     * @param string $index
     * @param bool $unique
     * @return void
     */
    protected function dropIndexIfExists($table, $index, $unique)
    {
        if (!Schema::hasTable($table) || !$this->hasIndex($table, $index)) {
            return;
        }

        Schema::table($table, function (Blueprint $blueprint) use ($index, $unique) {
            if ($unique) {
                $blueprint->dropUnique($index);
            } else {
                $blueprint->dropIndex($index);
            }
        });
    }

    /**
     * @param string $table
     * @param string $index
     * @return bool
     */
    protected function hasIndex($table, $index)
    {
        $prefixed = DB::getTablePrefix() . $table;
        $rows = DB::select('SHOW INDEX FROM `' . $prefixed . '` WHERE Key_name = ?', array($index));

        return count($rows) > 0;
    }

    /**
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('tags')) {
            return;
        }

        $this->dropIndexIfExists('tags', 'tags_slug_unique', true);

        if (!Schema::hasColumn('tags', 'country_id')) {
            Schema::table('tags', function (Blueprint $table) {
                $table->integer('country_id')->unsigned()->nullable();
                $table->index('country_id');
            });
        }

        if (!Schema::hasColumn('tags', 'type')) {
            Schema::table('tags', function (Blueprint $table) {
                $table->string('type', 100)->nullable()->default('blog');
            });
        }

        $seoColumns = array(
            'seo_title_ar', 'seo_description_ar', 'seo_keywords_ar',
            'seo_title_en', 'seo_description_en', 'seo_keywords_en',
            'seo_title_fr', 'seo_description_fr', 'seo_keywords_fr',
            'seo_title_ru', 'seo_description_ru', 'seo_keywords_ru',
            'seo_title_fa', 'seo_description_fa', 'seo_keywords_fa',
        );

        foreach ($seoColumns as $column) {
            if (!Schema::hasColumn('tags', $column)) {
                Schema::table('tags', function (Blueprint $table) use ($column) {
                    if (strpos($column, 'description') !== false) {
                        $table->text($column)->nullable();
                    } else {
                        $table->string($column)->nullable();
                    }
                });
            }
        }
    }
}
