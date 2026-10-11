<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DropPageSearchTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Old Listings (page_search) were replaced by the geo listing pages.
        Schema::dropIfExists('page_search');
        Schema::dropIfExists('geographic_listing_drafts');

        $permission = DB::table('permissions')->where('slug', 'admin.pages.search')->first();
        if (!$permission) {
            return;
        }

        DB::table('permission_user')->where('permission_id', $permission->id)->delete();
        DB::table('permission_role')->where('permission_id', $permission->id)->delete();
        DB::table('permissions')->where('id', $permission->id)->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Irreversible: the tables were dropped without a backup.
    }
}
