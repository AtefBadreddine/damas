<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryCityDistrictContentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * Translated title/content (ar + en), same field pattern as page_search,
     * linked 1-to-1 with countries, cities, and regions (districts).
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countrycontent', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->unsigned();
            $table->string('title', 250)->nullable();
            $table->longText('content')->nullable();
            $table->string('title_en', 250)->nullable();
            $table->longText('content_en')->nullable();
            $table->timestamps();

            $table->unique('country_id');
        });

        Schema::create('citycontent', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('city_id')->unsigned();
            $table->string('title', 250)->nullable();
            $table->longText('content')->nullable();
            $table->string('title_en', 250)->nullable();
            $table->longText('content_en')->nullable();
            $table->timestamps();

            $table->unique('city_id');
        });

        Schema::create('districtcontent', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('region_id')->unsigned();
            $table->string('title', 250)->nullable();
            $table->longText('content')->nullable();
            $table->string('title_en', 250)->nullable();
            $table->longText('content_en')->nullable();
            $table->timestamps();

            $table->unique('region_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('districtcontent');
        Schema::drop('citycontent');
        Schema::drop('countrycontent');
    }
}
