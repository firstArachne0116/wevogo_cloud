<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'Lam Kin',
            'email' => 'lam.kin@gmail.com',
            'password' => bcrypt('wevo0123'),
        ]);

        DB::table('wevo_users')->insert([
            'wevo_user_id' => 1,
            'freepbx_id' => 1,
            'email' => 'lam@gmail.com',
            'display_name' => 'Lam Jin',
            'phone_number' => '+600123212103',
            'phone_id' => 0,
            'is_verified' => false,
            'username' => '900',
            'password' => '0123',
            'freepbx_domain' => 'http://113.23.226.22:1443/'
        ]);
    }
}
