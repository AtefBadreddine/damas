<?php

use Illuminate\Database\Migrations\Migration;

class AddAdminCountriesPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $now = date('Y-m-d H:i:s');
        $exists = DB::table('permissions')->where('slug', 'admin.countries')->first();
        if ($exists) {
            return;
        }

        $permissionId = ((int) DB::table('permissions')->max('id')) + 1;
        DB::table('permissions')->insert(array(
            'id' => $permissionId,
            'name' => 'Countries',
            'slug' => 'admin.countries',
            'description' => '',
            'ordre' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ));

        $citiesPermission = DB::table('permissions')->where('slug', 'admin.cities')->first();
        if (!$citiesPermission) {
            return;
        }

        $userIds = DB::table('permission_user')->where('permission_id', $citiesPermission->id)->lists('user_id');
        $nextId = ((int) DB::table('permission_user')->max('id')) + 1;
        foreach ($userIds as $userId) {
            $already = DB::table('permission_user')
                ->where('permission_id', $permissionId)
                ->where('user_id', $userId)
                ->first();
            if ($already) {
                continue;
            }
            DB::table('permission_user')->insert(array(
                'id' => $nextId++,
                'permission_id' => $permissionId,
                'user_id' => $userId,
                'created_at' => $now,
                'updated_at' => $now,
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
        $permission = DB::table('permissions')->where('slug', 'admin.countries')->first();
        if (!$permission) {
            return;
        }

        DB::table('permission_user')->where('permission_id', $permission->id)->delete();
        DB::table('permission_role')->where('permission_id', $permission->id)->delete();
        DB::table('permissions')->where('id', $permission->id)->delete();
    }
}
