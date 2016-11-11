<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 11.11.2016
 * Time: 14:11
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Tests\Controllers;

use App\Http\Controllers\EksiciController;
use App\User;
use App\Models\Entities\Eksici;
use DB;

class EksiciControllerTest extends \TestCase
{
    private $controller;

    public function setUp()
    {
        parent::setUp();
        $this->seed('DatabaseSeeder');
        $this->controller = new EksiciController();
        $this->loginWithFakeUser();
    }

    public function testListele()
    {
        $this->visit('/eksiciler')
            ->see('67%')
            ->see('33%');
    }

    public function testHisseal()
    {
        $this->post('/eksici/1/hisseal', ['hisse' => '1'])
            ->see('');

        $this->visit('/eksiciler')
            ->see('66%')
            ->see('34%');

        $this->post('/eksici/1/hisseal', ['hisse' => '100'])
            ->see('You don\'t have enough Eksikurus.');

        $this->post('/eksici/1/hisseal', ['hisse' => '67'])
            ->see('doesn\'t have that much stock available');
    }

    public function testHissesat()
    {
        $this->post('/eksici/1/hissesat', ['hisse' => '1'])
            ->see('');

        $this->visit('/eksiciler')
            ->see('68%')
            ->see('32%');

        $this->post('/eksici/1/hissesat', ['hisse' => '33'])
            ->see('You don\'t have that much stock available.');
    }

    /*public function testUpdateEksici()
    {
        DB::table('eksici')->truncate();
        $this->controller->updateEksici(5);
        $this->assertSame(5, Eksici::get()->count());
    }*/

    public function testUpdateTwitter()
    {
        DB::table('eksici')->truncate();
        $this->controller->updateTwitter(5);
        $this->assertSame(5, Eksici::get()->count());
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
