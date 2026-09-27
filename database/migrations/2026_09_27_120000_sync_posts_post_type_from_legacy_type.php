<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Align post_type with legacy `type` for blog/news rows before the front used post_type.
 * Does not change developer/report post_type values.
 */
class SyncPostsPostTypeFromLegacyType extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        DB::table('posts')
            ->where('type', 'news')
            ->whereIn('post_type', array('blog', 'news'))
            ->update(array('post_type' => 'news'));

        DB::table('posts')
            ->where('type', 'blog')
            ->whereIn('post_type', array('blog', 'news'))
            ->update(array('post_type' => 'blog'));
    }

    /**
     * @return void
     */
    public function down()
    {
        // Irreversible: previous post_type values are not stored.
    }
}
