<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShowToCountries extends Migration
{
    /**
     * When show is 0, country (and its cities/districts) are omitted from front filters only.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('countries') && !Schema::hasColumn('countries', 'show')) {
            Schema::table('countries', function (Blueprint $table) {
                $table->boolean('show')->default(1)->after('placement');
            });
        }
    }

    /**
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('countries') && Schema::hasColumn('countries', 'show')) {
            Schema::table('countries', function (Blueprint $table) {
                $table->dropColumn('show');
            });
        }
    }
}
