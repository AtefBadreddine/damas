<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountryIdToBlogParamsFooterLinksAndFotterprojects extends Migration
{
    /**
     * Point featured posts and footer rows at countries.id instead of legacy turkey/oman strings.
     *
     * @return void
     */
    public function up()
    {
        $this->addCountryIdColumn('blog_params');
        $this->addCountryIdColumn('footer_links', 'country');
        $this->addCountryIdColumn('fotterprojects', 'country');

        $idsByCode = array();
        foreach (DB::table('countries')->get() as $country) {
            $idsByCode[$country->code] = $country->id;
        }

        $legacyBlogParams = array(
            1 => 'turkey',
            3 => 'oman',
            4 => 'syria',
        );
        foreach ($legacyBlogParams as $paramId => $code) {
            if (!isset($idsByCode[$code])) {
                continue;
            }
            DB::table('blog_params')->where('id', $paramId)->whereNull('country_id')->update(array(
                'country_id' => $idsByCode[$code],
            ));
        }

        $this->backfillFromCountryString('footer_links', $idsByCode);
        $this->backfillFromCountryString('fotterprojects', $idsByCode);

        $this->dropLegacyCountryColumn('footer_links');
        $this->dropLegacyCountryColumn('fotterprojects');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (array('footer_links', 'fotterprojects') as $tableName) {
            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'country')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->string('country', 50)->nullable();
                });
            }
        }

        foreach (array('blog_params', 'footer_links', 'fotterprojects') as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'country_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('country_id');
                });
            }
        }
    }

    /**
     * @param string $tableName
     * @param string|null $afterColumn
     * @return void
     */
    protected function addCountryIdColumn($tableName, $afterColumn = null)
    {
        if (!Schema::hasTable($tableName) || Schema::hasColumn($tableName, 'country_id')) {
            return;
        }

        $hasAfter = $afterColumn && Schema::hasColumn($tableName, $afterColumn);
        Schema::table($tableName, function (Blueprint $table) use ($hasAfter, $afterColumn) {
            $column = $table->integer('country_id')->unsigned()->nullable();
            if ($hasAfter) {
                $column->after($afterColumn);
            }
            $table->index('country_id');
        });
    }

    /**
     * @param string $tableName
     * @param array $idsByCode
     * @return void
     */
    protected function backfillFromCountryString($tableName, array $idsByCode)
    {
        if (!Schema::hasTable($tableName) || !Schema::hasColumn($tableName, 'country')) {
            return;
        }

        foreach ($idsByCode as $code => $countryId) {
            DB::table($tableName)->where('country', $code)->whereNull('country_id')->update(array(
                'country_id' => $countryId,
            ));
        }
    }

    /**
     * @param string $tableName
     * @return void
     */
    protected function dropLegacyCountryColumn($tableName)
    {
        if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'country')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('country');
            });
        }
    }
}
