<?php

use Illuminate\Database\Migrations\Migration;

class UpdatePostsPostTypeEnum extends Migration
{
    /**
     * Legacy post_type "posts" becomes "blog"; "news" stays "news".
     * Column is then stored as ENUM(blog, developer, report, news).
     *
     * @return void
     */
    public function up()
    {
        $table = DB::getTablePrefix() . 'posts';

        DB::table('posts')->where('post_type', 'posts')->update(array(
            'post_type' => 'blog',
        ));

        DB::table('posts')->whereNull('post_type')->update(array(
            'post_type' => 'blog',
        ));

        DB::table('posts')->whereNotIn('post_type', array('blog', 'developer', 'report', 'news'))->update(array(
            'post_type' => 'blog',
        ));

        DB::statement(
            "ALTER TABLE `{$table}` MODIFY `post_type` ENUM('blog','developer','report','news') NULL DEFAULT 'blog'"
        );
    }

    /**
     * @return void
     */
    public function down()
    {
        $table = DB::getTablePrefix() . 'posts';

        DB::statement(
            "ALTER TABLE `{$table}` MODIFY `post_type` VARCHAR(50) NULL DEFAULT NULL"
        );

        DB::table('posts')->where('post_type', 'blog')->update(array(
            'post_type' => 'posts',
        ));
    }
}
