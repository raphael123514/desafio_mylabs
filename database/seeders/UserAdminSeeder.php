<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'adm',
            'email' => 'adm@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
