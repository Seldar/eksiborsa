<?php namespace App\Models\Repositories\Eksici;

use App\Models\Entities\Eksici;
use Illuminate\Database\Eloquent\Builder;

/**
 * A simple interface to set the methods in our Eksici repository, nothing much happening here
 */
interface EksiciInterface
{
    /**
     * Method to get eksici data
     *
     * @return mixed
     */
    public function getAllEksici();

    /**
     * Setter for Eksici model
     *
     * @param Eksici $eksici
     *
     * @return mixed
     */
    public function setEksici(Eksici $eksici);

    /**
     * Getter for Eksici model
     *
     * @return mixed
     */
    public function getEksici();

    /**
     * Getting stock data of current user
     *
     * @return mixed
     */
    public function getStock();

    /**
     * Getting available stock data for current user, for current stock
     *
     * @return mixed
     */
    public function getAvailableStock();

    /**
     * Adding stock to current user and pay the price
     *
     * @param int $newStock
     * @param int $newCurrency
     *
     * @return mixed
     */
    public function updateStock($newStock, $newCurrency);

    /**
     * Get eksici data by nickname
     *
     * @param string $nick
     *
     * @return mixed
     */
    public function getByNick($nick);

    /**
     * Update users karma score
     *
     * @param int    $karma  karma rating to set to
     * @param string $nick   nick of the user
     * @param Eksici $eksici Eksici entity to update from
     *
     * @return mixed
     */
    public function updateKarma($karma, $nick, Eksici $eksici);

}