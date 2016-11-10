<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 9.11.2016
 * Time: 16:37
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Tests\Repositories;

use App\Models\Repositories\Eksici\EksiciRepository;
use App\Models\Entities\Eksici;
use TestCase;
use Auth;
use App\User;

/**
 * Class EksiciRepositoryTest
 *
 * @package Tests\Repositories
 */
class EksiciRepositoryTest extends TestCase
{


    /**
     * Contains Eksici Repo
     *
     * @var EksiciRepository
     */
    private $repo;

    /**
     * Set up for tests
     */
    public function setUp()
    {
        parent::setUp();
        $this->seed('DatabaseSeeder');
        $this->repo = new EksiciRepository(new Eksici());
    }

    /**
     * Test getAllEksici Method
     */
    public function testGetAllEksici()
    {

        $result = $this->repo->getAllEksici();
        $this->assertTrue(is_array($result));

    }

    /**
     * Test getEksici Method
     */
    public function testGetEksici()
    {
        $result = $this->repo->getEksici();
        $this->assertInstanceOf("App\\Models\\Entities\\Eksici", $result);

    }

    /**
     * Test setEksici Method
     */
    public function testSetEksici()
    {
        $this->repo->setEksici(new Eksici(["nick" => "test"]));
        $result = $this->repo->getEksici();
        $this->assertSame("test", $result->nick);

    }

    public function testGetStock()
    {
        $this->loginWithFakeUser();
        $eksici = new Eksici();
        $this->repo->setEksici($eksici->find(1));
        $result = $this->repo->getStock();
        $this->assertSame(33, $result);

    }

    public function testGetAvailableStock()
    {
        $eksici = new Eksici();
        $this->repo->setEksici($eksici->find(1));
        $result = $this->repo->getAvailableStock();
        $this->assertSame(67, $result);
    }

    public function testUpdateStock()
    {
        $this->loginWithFakeUser();
        $eksici = new Eksici();
        $this->repo->setEksici($eksici->find(1));
        $this->repo->updateStock(30, 500);
        $result = $this->repo->getEksici();
        $this->assertSame(30, $result->user()->where("user_id", 1)->first()->pivot->hisse);
        $this->assertSame(500, (int)$result->user()->where("user_id", 1)->first()->eksikurus);
    }

    public function testGetByNick()
    {
        $eksici = new Eksici();
        $this->assertSame(1, $this->repo->getByNick($eksici->find(1)->nick)->id);
    }

    public function testUpdateKarma()
    {
        $eksici = new Eksici();
        $eksici = $eksici->find(1);
        $this->repo->updateKarma(600, $eksici->nick, $eksici);
        $this->assertSame(600, $this->repo->getByNick($eksici->nick)->karma);

        $this->repo->updateKarma(600, "test2", $this->repo->getByNick('test2'));
        $this->assertSame(600, $this->repo->getByNick('test2')->karma);
    }


    public function loginWithFakeUser()
    {
        $user = new User([
            'id' => 1
        ]);

        $this->be($user);
    }
}
