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
        Schema::table('posts', function (Blueprint $table) {
            $table->integer('country_id')->unsigned()->nullable()->after('country');
            $table->index('country_id');
        });

        $countries = DB::table('countries')->get();
        foreach ($countries as $country) {
            DB::table('posts')->where('country', $country->code)->update(array(
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
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('country_id');
        });
    }
}
