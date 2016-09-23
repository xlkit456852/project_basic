<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_id = DB::table('users')->insertGetId([
            'name' => 'admin',
            'password' => bcrypt('123456')

        ]);

        $role_id = DB::table('roles')->insertGetId([
            'name' => '超级管理员',
            'slug' => 'super.admin',
            'level' => 100,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);

        DB::table('role_user')->insertGetId([
            'role_id' => $role_id,
            'user_id' => $user_id,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);



    }
}
