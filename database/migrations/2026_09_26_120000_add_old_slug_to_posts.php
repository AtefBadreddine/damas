<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOldSlugToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * Previous slug of a post; front routes 301 it to the current URL, same as projects.old_slug.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('posts', 'old_slug')) {
            return;
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->string('old_slug', 255)->nullable()->after('slug');
            $table->index('old_slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['old_slug']);
            $table->dropColumn('old_slug');
        });
    }
}
