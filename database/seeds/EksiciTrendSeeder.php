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

class EksiciTrendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('eksici_trend')->truncate();

        $datetime = new DateTime(date("Y-m-d"));
        DB::table('eksici_trend')->insert(['eksici_id' => 1, 'karma' => 300, 'created_at' => $datetime->format
        ('Y-m-d')]);
        $datetime->modify('-1 day');
        DB::table('eksici_trend')->insert(['eksici_id' => 1, 'karma' => 400, 'created_at' => $datetime->format('Y-m-d')]);
        $datetime->modify('-1 day');
        DB::table('eksici_trend')->insert(['eksici_id' => 1, 'karma' => 500, 'created_at' => $datetime->format
        ('Y-m-d')]);
    }
}