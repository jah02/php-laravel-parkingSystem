<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Jan Kowalski',
            'email' => 'user@email.com',
            'password' => bcrypt('1password!Q'),
        ]);
    }

}
