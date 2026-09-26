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

        // Rows created while AUTO_INCREMENT was missing get id = 0 and block further inserts.
        DB::table('posts')->where('id', 0)->delete();

        $maxId = (int) DB::table('posts')->max('id');
        $nextId = $maxId > 0 ? $maxId + 1 : 1;

        DB::statement(
            "ALTER TABLE `{$table}` MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT={$nextId}"
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
