<?php

use Illuminate\Database\Migrations\Migration;

class ExpandMenusLang extends Migration
{
    /**
     * Allow comma-separated locales in the existing lang column.
     *
     * @return void
     */
    public function up()
    {
        if (!$this->menusTableHasLang()) {
            return;
        }

        $table = $this->menusTable();
        DB::statement('ALTER TABLE `' . $table . '` MODIFY `lang` VARCHAR(64) NULL');
    }

    /**
     * @return void
     */
    public function down()
    {
        if (!$this->menusTableHasLang()) {
            return;
        }

        $table = $this->menusTable();
        DB::statement('ALTER TABLE `' . $table . '` MODIFY `lang` VARCHAR(20) NULL');
    }

    /**
     * @return string
     */
    protected function menusTable()
    {
        return DB::getTablePrefix() . 'menus';
    }

    /**
     * @return bool
     */
    protected function menusTableHasLang()
    {
        $table = $this->menusTable();
        $like = str_replace(array('\\', '%', '_'), array('\\\\', '\\%', '\\_'), $table);
        $exists = DB::select("SHOW TABLES LIKE '" . str_replace("'", "''", $like) . "'");
        if (!count($exists)) {
            return false;
        }
        $langCol = DB::select('SHOW COLUMNS FROM `' . $table . "` WHERE Field = 'lang'");

        return count($langCol) > 0;
    }
}
