<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 11.11.2016
 * Time: 12:47
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Tests\Repositories;

use App\Models\Repositories\EksiciTrend\EksiciTrendRepository;
use App\Models\Entities\EksiciTrend;
use App\Models\Entities\Eksici;
use DateTime;

class EksiciTrendRepositoryTest extends \TestCase
{
    /**
     * Contains Eksici Repo
     *
     * @var EksiciTrendRepository
     */
    private $repo;

    /**
     * Set up for tests
     */
    public function setUp()
    {
        parent::setUp();
        $this->seed('DatabaseSeeder');
        $this->repo = new EksiciTrendRepository(new EksiciTrend());
    }

    public function testSave()
    {
        $now = date("Y-m-d H:i:s");
        $this->repo->save(['eksici_id' => 1, 'karma' => 600, 'created_at' => $now]);
        $trend = EksiciTrend::find(4);
        $this->assertSame(['eksici_id' => 1, 'karma' => 600, 'created_at' => $now], [
            'eksici_id' => $trend->eksici_id,
            'karma' => $trend->karma,
            'created_at' => (string)$trend->created_at
        ]);
    }

    public function testGetByDate()
    {
        $now = date("Y-m-d H:i:s");
        $datetime = new DateTime(date("Y-m-d"));
        $today = $datetime->format('Y-m-d');
        $datetime->modify('-1 day');
        $yesterday = $datetime->format('Y-m-d');
        $datetime->modify('-1 day');
        $thedaybefore = $datetime->format('Y-m-d');
        $eksici = Eksici::find(1);
        $result = $this->repo->getByDate("1970-01-01", $now, $eksici->nick, 10);
        reset($result[0]);
        $this->assertSame([500, 400, 300], current($result[0]));
        $this->assertSame([
            $thedaybefore => 1,
            $yesterday => 1,
            $today => 1
        ], $result[1]);
        reset($result[2]);
        $this->assertSame([
            0 => 100.0,
            1 => 80.0,
            2 => 60.0
        ], current($result[2]));
    }
}
