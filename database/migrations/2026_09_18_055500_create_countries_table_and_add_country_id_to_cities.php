<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTableAndAddCountryIdToCities extends Migration
{
    /**
     * Run the migrations.
     *
     * Country becomes a real parent of City (language → country → city → district → project).
     * slug is the URL segment (turkiye / uae). code matches the legacy cities.country string (turkey / emirates).
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('countries')) {
            Schema::create('countries', function (Blueprint $table) {
                $table->increments('id');
                $table->string('code', 50)->unique();
                $table->string('slug', 100)->unique();
                $table->string('name_ar', 255);
                $table->string('name_en', 255);
                $table->string('h1_ar', 255)->nullable();
                $table->string('h1_en', 255)->nullable();
                $table->integer('media_id')->unsigned()->default(0);
                $table->integer('media_en_id')->unsigned()->default(0);
                $table->longText('content_ar')->nullable();
                $table->longText('content_en')->nullable();
                $table->string('seo_title_ar', 255)->nullable();
                $table->text('seo_description_ar')->nullable();
                $table->string('seo_title_en', 255)->nullable();
                $table->text('seo_description_en')->nullable();
                $table->integer('placement')->default(0);
                $table->timestamps();
            });
        }

        $seeds = array(
            array('slug' => 'turkiye', 'code' => 'turkey', 'name_ar' => 'تركيا', 'name_en' => 'Turkey', 'placement' => 1),
            array('slug' => 'oman', 'code' => 'oman', 'name_ar' => 'عمان', 'name_en' => 'Oman', 'placement' => 2),
            array('slug' => 'syria', 'code' => 'syria', 'name_ar' => 'سوريا', 'name_en' => 'Syria', 'placement' => 3),
            array('slug' => 'uae', 'code' => 'emirates', 'name_ar' => 'الإمارات', 'name_en' => 'Emirates', 'placement' => 4),
        );
        $now = date('Y-m-d H:i:s');
        foreach ($seeds as $seed) {
            if (!DB::table('countries')->where('code', $seed['code'])->exists()) {
                DB::table('countries')->insert($seed + array('created_at' => $now, 'updated_at' => $now));
            }
        }

        if (!Schema::hasColumn('cities', 'country_id')) {
            Schema::table('cities', function (Blueprint $table) {
                $table->integer('country_id')->unsigned()->nullable()->after('country');
                $table->index('country_id');
            });
        }

        foreach (DB::table('countries')->get() as $country) {
            DB::table('cities')->where('country', $country->code)->whereNull('country_id')->update(array(
                'country_id' => $country->id,
            ));
        }
    }

    /**
     * Reverse the migrations.
     *
     * Intentionally a no-op: on prod, countries and cities.country_id existed before
     * this migration, so dropping them on rollback would destroy live data.
     *
     * @return void
     */
    public function down()
    {
    }
}
