<?php

/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 10.11.2016
 * Time: 14:58
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
            'id' => 1,
            'name' => "Volkan Ulukut",
            'email' => "test@gmail.com",
            'password' => Hash::make("12345"),
            'eksikurus' => rand(5000,10000)
        ]);

        DB::table('user_hisse')->truncate();

        DB::table('user_hisse')->insert([
            'user_id' => 1,
            'eksici_id' => 1,
            'hisse' => 33
        ]);
    }
}