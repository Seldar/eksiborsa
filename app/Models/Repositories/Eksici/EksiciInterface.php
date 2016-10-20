<?php namespace App\Models\Repositories\Eksici;

use App\Models\Entities\Eksici;
use Illuminate\Database\Eloquent\Builder;
/**
 * A simple interface to set the methods in our Eksici repository, nothing much happening here
 */
interface EksiciInterface
{
    public function getAllEksici();
    public function setEksici(Eksici $eksici);
    public function getEksici();
    public function getStock();
    public function getAvailableStock();
    public function updateStock($newStock, $newCurrency);
    public function getByNick($nick);
    public function updateKarma($karma,$nick,Builder $eksici);

}