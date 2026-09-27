<?php

use Illuminate\Database\Migrations\Migration;

class FixPostsIdAutoIncrement extends Migration
{
    /**
     * Restore AUTO_INCREMENT on posts.id (lost if the table was recreated without it).
     *
     * @return void
     */
    public function up()
    {
        $table = DB::getTablePrefix() . 'posts';

        $id = DB::selectOne("SHOW COLUMNS FROM `{$table}` WHERE Field = 'id'");
        if (stripos($id->Extra, 'auto_increment') !== false) {
            return;
        }

        // Rows created while AUTO_INCREMENT was missing get id = 0 and block further inserts.
        DB::table('posts')->where('id', 0)->delete();

        $nextId = (int) DB::table('posts')->max('id') + 1;
        $hasPrimary = count(DB::select("SHOW KEYS FROM `{$table}` WHERE Key_name = 'PRIMARY'")) > 0;

        DB::statement(
            "ALTER TABLE `{$table}` MODIFY `id` int NOT NULL AUTO_INCREMENT"
            . ($hasPrimary ? '' : ', ADD PRIMARY KEY (`id`)')
            . ", AUTO_INCREMENT={$nextId}"
        );
    }

    /**
     * @return void
     */
    public function down()
    {
        // Irreversible without risking duplicate ids on existing rows.
    }
}
