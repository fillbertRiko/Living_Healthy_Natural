<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo tài khoản Super Admin
        DB::table('users')->insert([
            'name'       => 'Super Admin',
            'email'      => 'superadmin@example.com',
            'password'   => Hash::make('supersecretpassword'), // Đổi mật khẩu theo nhu cầu
            'role'       => 'super_admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Tạo tài khoản Admin
        DB::table('users')->insert([
            'name'       => 'Admin',
            'email'      => 'admin@example.com',
            'password'   => Hash::make('adminpassword'), // Đổi mật khẩu theo nhu cầu
            'role'       => 'admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}