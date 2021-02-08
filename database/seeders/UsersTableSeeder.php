<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'name' => 'Association',
            'email' => 'asso@gmail.com',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'role_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Traveller',
            'email' => 'traveller@gmail.com',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'role_id' => 2,
        ]);
    }
}
