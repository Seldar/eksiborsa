<?php namespace App\Models\Repositories\Eksici;

use App\Models\Entities\Eksici;
use Illuminate\Database\Eloquent\Builder;

/**
 * A simple interface to set the methods in our Eksici repository, nothing much happening here
 */
interface EksiciInterface
{
    /**
     * @return mixed
     */
    public function getAllEksici();

    /**
     * @param Eksici $eksici
     * @return mixed
     */
    public function setEksici(Eksici $eksici);

    /**
     * @return mixed
     */
    public function getEksici();

    /**
     * @return mixed
     */
    public function getStock();

    /**
     * @return mixed
     */
    public function getAvailableStock();

    /**
     * @param $newStock
     * @param $newCurrency
     * @return mixed
     */
    public function updateStock($newStock, $newCurrency);

    /**
     * @param $nick
     * @return mixed
     */
    public function getByNick($nick);

    /**
     * @param $karma
     * @param $nick
     * @param Builder $eksici
     * @return mixed
     */
    public function updateKarma($karma, $nick, Builder $eksici);

}