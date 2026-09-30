<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropLegacyCountryFromCitiesPostsAndCategories extends Migration
{
    /**
     * Drop the legacy country string (turkey/oman) now that country_id is the source of truth.
     *
     * @return void
     */
    public function up()
    {
        $tables = array('cities', 'posts', 'posts_categories');
        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'country')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('country');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = array('cities', 'posts', 'posts_categories');
        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'country')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->string('country', 50)->nullable();
                });
            }
        }
    }
}
