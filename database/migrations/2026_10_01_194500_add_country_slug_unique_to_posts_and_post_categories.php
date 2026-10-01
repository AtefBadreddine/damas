<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountrySlugUniqueToPostsAndPostCategories extends Migration
{
    /**
     * Unique slug per country for posts and post categories.
     * Empty post slugs become NULL so unpublished drafts can share a country.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('posts') && Schema::hasColumn('posts', 'slug')) {
            DB::table('posts')->where('slug', '')->update(array('slug' => null));
            $this->assertNoDuplicateCountrySlugs('posts');
            $this->addCountrySlugUnique('posts', 'posts_country_id_slug_unique');
            $this->addSlugIndex('posts', 'posts_slug_index');
        }

        if (Schema::hasTable('posts_categories') && Schema::hasColumn('posts_categories', 'slug')) {
            DB::table('posts_categories')->where('slug', '')->update(array('slug' => null));
            $this->assertNoDuplicateCountrySlugs('posts_categories');
            $this->addCountrySlugUnique('posts_categories', 'posts_categories_country_id_slug_unique');
            $this->addSlugIndex('posts_categories', 'posts_categories_slug_index');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropIndexIfExists('posts', 'posts_country_id_slug_unique', true);
        $this->dropIndexIfExists('posts', 'posts_slug_index', false);
        $this->dropIndexIfExists('posts_categories', 'posts_categories_country_id_slug_unique', true);
        $this->dropIndexIfExists('posts_categories', 'posts_categories_slug_index', false);
    }

    /**
     * @param string $table
     * @return void
     */
    protected function assertNoDuplicateCountrySlugs($table)
    {
        $dupes = DB::table($table)
            ->select('country_id', 'slug', DB::raw('COUNT(*) as cnt'))
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->groupBy('country_id', 'slug')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        if (count($dupes)) {
            $sample = $dupes[0];
            throw new \RuntimeException(
                "Cannot add unique (country_id, slug) on {$table}: duplicates exist, e.g. country_id={$sample->country_id} slug={$sample->slug}"
            );
        }
    }

    /**
     * Prefix unique on slug(191) so utf8/utf8mb4 InnoDB key length stays under 767 bytes.
     *
     * @param string $table
     * @param string $index
     * @return void
     */
    protected function addCountrySlugUnique($table, $index)
    {
        if ($this->hasIndex($table, $index)) {
            return;
        }

        $prefixed = DB::getTablePrefix() . $table;
        DB::statement('ALTER TABLE `' . $prefixed . '` ADD UNIQUE `' . $index . '` (`country_id`, `slug`(191))');
    }

    /**
     * @param string $table
     * @param string $index
     * @return void
     */
    protected function addSlugIndex($table, $index)
    {
        if ($this->hasIndex($table, $index)) {
            return;
        }

        Schema::table($table, function (Blueprint $blueprint) use ($index) {
            $blueprint->index('slug', $index);
        });
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
}
