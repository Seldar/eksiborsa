<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 14.11.2016
 * Time: 10:55
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Tests\Controllers;


class EksiciTrendControllerTest extends \TestCase
{
    public function testShowTrend()
    {
        $this->visit('/trends')
            ->assertResponseOk();
    }
}
