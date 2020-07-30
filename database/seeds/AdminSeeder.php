<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name'     => 'read'
        ]);
        DB::table('permissions')->insert([
            'name'     => 'write'
        ]);

        DB::table('roles')->insert([
            'name'     => 'Admin'
        ]);

        DB::table('permissions_roles')->insert([
            'permission_id'     => 1,
            'roles_id'  => 1
        ]);
        DB::table('permissions_roles')->insert([
            'permission_id'     => 2,
            'roles_id'  => 1
        ]);

        DB::table('users')->insert([
            'name'     => 'Admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('Admin123'),
            'gender'   => 'female',
            'status'   => 1,
            'type'     => 'admin',
            'roles_id' => 1
        ]);
    }
}
