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
            'email' => 'test1@gmail.com',
            'display_name' => 'Test1',
            'phone_number' => '+85590748240',
            'phone_id' => 0,
            'is_verified' => false,
            'username' => 'test1',
            'password' => 'test1123',
            'freepbx_domain' => 'wevo.pbx.org'
        ]);
    }
}
