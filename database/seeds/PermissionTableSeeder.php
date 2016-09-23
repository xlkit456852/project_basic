<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_manage_id = DB::table('permissions')->insertGetId([
            'name' => '系统权限管理',
            'slug' => 'admin_manage',
            'parent_id' => 0,
            'is_show' => 1,
            'url' => '',
            'icon' => 'fa fa-cogs',
            'sort_order' => '0',
            'is_admin' => '1',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);

        DB::table('permissions')->insertGetId([
            'name' => '管理员列表',
            'slug' => 'admin_view',
            'parent_id' => $admin_manage_id,
            'is_show' => 1,
            'url' => 'user',
            'icon' => '',
            'sort_order' => '0',
            'is_admin' => '0',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);

        DB::table('permissions')->insertGetId([
            'name' => '管理员编辑',
            'slug' => 'admin_edit',
            'parent_id' => $admin_manage_id,
            'is_show' => 0,
            'url' => '',
            'icon' => '',
            'sort_order' => '0',
            'is_admin' => '1',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);

        DB::table('permissions')->insertGetId([
            'name' => '管理员删除',
            'slug' => 'admin_del',
            'parent_id' => $admin_manage_id,
            'is_show' => 0,
            'url' => '',
            'icon' => '',
            'sort_order' => '0',
            'is_admin' => '1',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);

        DB::table('permissions')->insertGetId([
            'name' => '角色管理',
            'slug' => 'role_manage',
            'parent_id' => $admin_manage_id,
            'is_show' => 1,
            'url' => 'role',
            'icon' => '',
            'sort_order' => '0',
            'is_admin' => '1',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);

        DB::table('permissions')->insertGetId([
            'name' => '角色编辑',
            'slug' => 'role_edit',
            'parent_id' => $admin_manage_id,
            'is_show' => 0,
            'url' => '',
            'icon' => '',
            'sort_order' => '0',
            'is_admin' => '1',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);

        DB::table('permissions')->insertGetId([
            'name' => '角色删除',
            'slug' => 'role_del',
            'parent_id' => $admin_manage_id,
            'is_show' => 0,
            'url' => '',
            'icon' => '',
            'sort_order' => '0',
            'is_admin' => '1',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);

        DB::table('permissions')->insertGetId([
            'name' => '权限管理',
            'slug' => 'permission_manage',
            'parent_id' => $admin_manage_id,
            'is_show' => 1,
            'url' => 'permission',
            'icon' => '',
            'sort_order' => '0',
            'is_admin' => '1',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);

        DB::table('permissions')->insertGetId([
            'name' => '权限编辑',
            'slug' => 'permission_edit',
            'parent_id' => $admin_manage_id,
            'is_show' => 0,
            'url' => '',
            'icon' => '',
            'sort_order' => '0',
            'is_admin' => '1',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);

        DB::table('permissions')->insertGetId([
            'name' => '权限删除',
            'slug' => 'permission_del',
            'parent_id' => $admin_manage_id,
            'is_show' => 0,
            'url' => '',
            'icon' => '',
            'sort_order' => '0',
            'is_admin' => '1',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);

        DB::table('permissions')->insertGetId([
            'name' => '管理员角色',
            'slug' => 'admin_role',
            'parent_id' => $admin_manage_id,
            'is_show' => 0,
            'url' => '',
            'icon' => '',
            'sort_order' => '0',
            'is_admin' => '1',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);

        DB::table('permissions')->insertGetId([
            'name' => '角色权限',
            'slug' => 'permission_role',
            'parent_id' => $admin_manage_id,
            'is_show' => 0,
            'url' => '',
            'icon' => '',
            'sort_order' => '0',
            'is_admin' => '1',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);





    }
}
