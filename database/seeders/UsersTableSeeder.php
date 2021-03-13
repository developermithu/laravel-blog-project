<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; //include

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => '1',
            'userid' => 'admin105',
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
        ]);

        DB::table('users')->insert([
            'role_id' => '2',
            'userid' => 'user105',
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('user'),
        ]);
    }
}
