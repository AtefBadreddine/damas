<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountryIdToPostsCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * Categories keep the legacy country string (turkey/oman) and gain country_id
     * pointing at countries.id, same pattern as posts and cities.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts_categories', function (Blueprint $table) {
            $table->integer('country_id')->unsigned()->nullable()->after('country');
            $table->index('country_id');
        });

        $countries = DB::table('countries')->get();
        foreach ($countries as $country) {
            DB::table('posts_categories')->where('country', $country->code)->update(array(
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
        Schema::table('posts_categories', function (Blueprint $table) {
            $table->dropColumn('country_id');
        });
    }
}
