<?php

namespace Database\Seeders;

use App\Models\admin\User;
use Illuminate\Support\Str;
use App\Models\admin\UserGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_group =  UserGroup::create([
            'name' => 'Admin',
            'status' => 1,
        ]);
        User::create([
            'name' => 'dev',
            'code' => 'dev',
            'email' => 'darshan@dev.com',
            'password' => Hash::make('admin@123'),
            'status' => 1,
            'user_group_id' => 0,
            'remember_token' => Str::random(60),
        ]);
        User::create([
            'name' => 'Admin',
            'code' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@123'),
            'status' => 1,
            'user_group_id' => 0,
            'remember_token' => Str::random(60),
        ]);
    }
}
