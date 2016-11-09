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


class EksiciRepositoryTest extends TestCase
{
    public function testGetAllEksici()
    {
        $repo = new EksiciRepository(new Eksici());
        $result = $repo->getAllEksici();
        $this->assertTrue(is_array($result));

    }
}
