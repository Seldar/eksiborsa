<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 11.10.2016
 * Time: 16:33
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace App\Models\Services\Eksici;

use App\Models\Repositories\Eksici\EksiciInterface;
use App\Models\Entities\Eksici;
use App\Models\Repositories\Eksici\EksiciRepository;
use Illuminate\Database\Eloquent\Builder;

/**
 * Our EksiciService, containing all useful methods for business logic around Eksici
 */
class EksiciService
{
    /**
     * Containing eksiciRepository to make all our database calls to
     *
     * @var EksiciInterface
     */
    protected $eksiciRepo;

    /**
     * Loads our $eksiciRepo with the actual Repo associated with our eksiciInterface
     *
     * @param EksiciInterface $eksiciRepo
     */
    public function __construct(EksiciInterface $eksiciRepo)
    {
        $this->eksiciRepo = $eksiciRepo;
    }

    /**
     * Setter for the Eksici Repository
     *
     * @param Eksici $eksici
     */
    public function setRepo(Eksici $eksici)
    {
        $this->eksiciRepo = new EksiciRepository($eksici);
    }

    /**
     * Method to get eksici data
     *
     * @return array
     */
    public function getAllEksici()
    {

        $eksicis = $this->eksiciRepo->getAllEksici();

        // If nothing found, return this simple string
        return $eksicis;
    }

    /**
     * Setter for Eksici model
     *
     * @param Eksici $eksici
     */
    public function setEksici(Eksici $eksici)
    {

        $this->eksiciRepo->setEksici($eksici);
    }

    /**
     * Getter for Eksici model
     *
     * @return Eksici
     */
    public function getEksici()
    {

        return $this->eksiciRepo->getEksici();
    }

    /**
     * Getting stock data of current user
     *
     * @return integer
     */
    public function getStock()
    {

        return $this->eksiciRepo->getStock();
    }

    /**
     * Getting available stock data for current user, for current stock
     *
     * @return integer
     */
    public function getAvailableStock()
    {
        return $this->eksiciRepo->getAvailableStock();

    }

    /**
     * Adding stock to current user and pay the price
     *
     * @param integer $newStock
     * @param integer $newCurrency
     */
    public function updateStock($newStock, $newCurrency)
    {
        $this->eksiciRepo->updateStock($newStock, $newCurrency);
    }

    /**
     * Get eksici data by nickname
     *
     * @param string $nick
     *
     * @return mixed
     */
    public function getByNick($nick)
    {
        return $this->eksiciRepo->getByNick($nick);
    }

    /**
     * Update users karma score
     *
     * @param int     $karma
     * @param string  $nick
     * @param Builder $eksici
     *
     * @return int
     */
    public function updateKarma($karma, $nick, Builder $eksici)
    {
        return $this->eksiciRepo->updateKarma($karma, $nick, $eksici);
    }
}