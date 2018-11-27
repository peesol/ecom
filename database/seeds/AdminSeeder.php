<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
        'type' => 'admin',
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('adminsecret'),
      ]);
    }
}
