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

use App\User;

class EksiciTrendControllerTest extends \TestCase
{
    public function testShowTrend()
    {
        $this->loginWithFakeUser();
        $this->visit('/trends')
            ->assertResponseOk();
    }

    public function loginWithFakeUser()
    {
        $user = new User([
            'id' => 1,
            'eksikurus' => 40000
        ]);

        $this->be($user);
    }
}
