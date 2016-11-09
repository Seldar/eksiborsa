<?php

/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 9.11.2016
 * Time: 16:23
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

use Illuminate\Database\Seeder;

class EksiciSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('eksici')->truncate();

        DB::table('eksici')->insert([
            'nick' => str_random(10),
            'karma' => rand(500,1000)
        ]);
    }
}