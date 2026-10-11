<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountryIdAndUrlEnToKeywords2 extends Migration
{
    /**
     * Keywords2::forContext() matches rows by country and getUrl() reads an optional English URL.
     * Existing rows all point at Turkish pages, so they are assigned to Turkey.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('keywords2', 'country_id')) {
            Schema::table('keywords2', function (Blueprint $table) {
                $table->unsignedInteger('country_id')->nullable()->index();
            });
        }
        if (!Schema::hasColumn('keywords2', 'url_en')) {
            Schema::table('keywords2', function (Blueprint $table) {
                $table->string('url_en', 500)->nullable();
            });
        }

        $turkey = DB::table('countries')->where('code', 'turkey')->first();
        if ($turkey) {
            DB::table('keywords2')->whereNull('country_id')->update(array(
                'country_id' => $turkey->id,
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
        foreach (array('country_id', 'url_en') as $column) {
            if (Schema::hasColumn('keywords2', $column)) {
                Schema::table('keywords2', function (Blueprint $table) use ($column) {
                    if ($column === 'country_id') {
                        $table->dropIndex(array('country_id'));
                    }
                    $table->dropColumn($column);
                });
            }
        }
    }
}
