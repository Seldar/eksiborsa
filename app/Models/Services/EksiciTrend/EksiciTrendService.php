<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 11.10.2016
 * Time: 16:33
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace App\Models\Services\EksiciTrend;

use App\Models\Repositories\EksiciTrend\EksiciTrendInterface;
use App\Models\Entities\EksiciTrend;
use App\Models\Repositories\EksiciTrend\EksiciTrendRepository;
use Illuminate\Database\Eloquent\Collection;

/**
 * Our EksiciService, containing all useful methods for business logic around Eksici
 */
class EksiciTrendService
{
    /**
     * Containing our eksiciRepository to make all our database calls to
     *
     * @var EksiciTrendInterface
     */
    protected $eksiciRepo;

    /**
     * Loads our $eksiciRepo with the actual Repo associated with our eksiciInterface
     *
     * @param EksiciTrendInterface $eksiciRepo
     */
    public function __construct(EksiciTrendInterface $eksiciRepo)
    {
        $this->eksiciRepo = $eksiciRepo;
    }

    /**
     * Setter for EksiciRepository
     *
     * @param EksiciTrend $eksici
     */
    public function setRepo(EksiciTrend $eksici)
    {
        $this->eksiciRepo = new EksiciTrendRepository($eksici);
    }

    /**
     * Method to save data
     *
     * @param array $data
     */
    public function save($data)
    {
        $this->eksiciRepo->save($data);
    }

    /**
     * Setter for Eksici model
     *
     * @param string $startDate
     * @param string $endDate
     *
     * @return Collection
     */
    public function getByDate($startDate, $endDate)
    {

        return $this->eksiciRepo->getByDate($startDate, $endDate);
    }

}