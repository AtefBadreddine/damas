<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountryIdToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * Posts keep the legacy country string (turkey/oman) and gain country_id
     * pointing at countries.id, same pattern as cities.
     *
     * @return void
     */
    public function up()
    {
        $hasCountry = Schema::hasColumn('posts', 'country');

        if (!Schema::hasColumn('posts', 'country_id')) {
            Schema::table('posts', function (Blueprint $table) use ($hasCountry) {
                $column = $table->integer('country_id')->unsigned()->nullable();
                if ($hasCountry) {
                    $column->after('country');
                }
                $table->index('country_id');
            });
        }

        if (!$hasCountry) {
            return;
        }
        foreach (DB::table('countries')->get() as $country) {
            DB::table('posts')->where('country', $country->code)->whereNull('country_id')->update(array(
                'country_id' => $country->id,
            ));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('posts', 'country_id')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('country_id');
            });
        }
    }
}
