<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 11.10.2016
 * Time: 16:33
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
// Containing our eksiciRepository to make all our database calls to
    protected $eksiciRepo;

    /**
     * Loads our $eksiciRepo with the actual Repo associated with our eksiciInterface
     *
     * @param EksiciInterface $eksiciRepo
     * @return EksiciService
     */
    public function __construct(EksiciInterface $eksiciRepo)
    {
        $this->eksiciRepo = $eksiciRepo;
    }

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
     * setter for Eksici model
     *
     * @param Eksici $eksici
     */
    public function setEksici(Eksici $eksici)
    {

        $this->eksiciRepo->setEksici($eksici);
    }

    /**
     * getter for Eksici model
     *
     * @return Eksici
     */
    public function getEksici()
    {

        return  $this->eksiciRepo->getEksici();
    }

    /**
     * getting stock data of current user
     *
     * @return integer
     */
    public function getStock()
    {

        return $this->eksiciRepo->getStock();
    }

    /**
     * getting available stock data for current user, for current stock
     *
     * @return integer
     */
    public function getAvailableStock()
    {
        return $this->eksiciRepo->getAvailableStock();

    }

    /**
     * adding stock to current user and pay the price
     *
     * @param integer $newStock
     * @param integer $newCurrency
     */
    public function updateStock($newStock, $newCurrency)
    {
        $this->eksiciRepo->updateStock($newStock, $newCurrency);
    }

    /**
     * get eksici data by nickname
     *
     * @param string $nick
     * @return mixed
     */
    public function getByNick($nick)
    {
        return $this->eksiciRepo->getByNick($nick);
    }

    /**
     * update users karma score
     *
     * @param int $karma
     * @param string $nick
     * @param Builder $eksici
     */
    public function updateKarma($karma,$nick,Builder $eksici)
    {
        return $this->eksiciRepo->updateKarma($karma,$nick,$eksici);
    }
}