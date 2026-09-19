<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTableAndAddCountryIdToCities extends Migration
{
    /**
     * Run the migrations.
     *
     * Country becomes a real parent of City (language → country → city → district → project).
     * slug is the URL segment (turkiye). code matches the legacy cities.country string (turkey).
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug', 100);
            $table->string('code', 10);
            $table->string('title_ar', 250)->nullable();
            $table->string('title_en', 250)->nullable();
            $table->timestamps();

            $table->unique('slug');
            $table->unique('code');
        });

        $now = date('Y-m-d H:i:s');
        DB::table('countries')->insert(array(
            array(
                'slug' => 'turkiye',
                'code' => 'turkey',
                'title_ar' => 'تركيا',
                'title_en' => 'Turkey',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            array(
                'slug' => 'oman',
                'code' => 'oman',
                'title_ar' => 'عمان',
                'title_en' => 'Oman',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            array(
                'slug' => 'emirates',
                'code' => 'emirates',
                'title_ar' => 'الإمارات',
                'title_en' => 'Emirates',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            array(
                'slug' => 'syria',
                'code' => 'syria',
                'title_ar' => 'سوريا',
                'title_en' => 'Syria',
                'created_at' => $now,
                'updated_at' => $now,
            ),
        ));

        Schema::table('cities', function (Blueprint $table) {
            $table->integer('country_id')->unsigned()->nullable()->after('country');
            $table->index('country_id');
        });

        $countries = DB::table('countries')->get();
        foreach ($countries as $country) {
            DB::table('cities')->where('country', $country->code)->update(array(
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
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn('country_id');
        });

        Schema::drop('countries');
    }
}
