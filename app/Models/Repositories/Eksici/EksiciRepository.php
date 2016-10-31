<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 11.10.2016
 * Time: 16:13
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace App\Models\Repositories\Eksici;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Entities\Eksici;
use Auth;

/**
 * Class EksiciRepository
 * Repository to handle model to database interactions
 * @package App\Models\Repositories\Eksici
 */
class EksiciRepository implements EksiciInterface
{
    /**
     * @var Eksici
     */
    private $eksiciModel;
    /**
     * @var int
     */
    private $hisse_max = 100;

    /**
     * Setting our class $eksiciModel to the injected model
     *
     * @param Eksici $eksici
     */
    public function __construct(Eksici $eksici)
    {
        $this->eksiciModel = $eksici;
    }

    /**
     * getting all Eksici data
     *
     * @return array
     */
    public function getAllEksici()
    {
        $data = array();
        foreach ($this->eksiciModel->all()->sortByDesc('karma') as $eksici) {
            $data[$eksici->id] = $eksici;
            $data[$eksici->id]['boshisse'] = $this->hisse_max;
            foreach ($eksici->user()->getResults() as $user) {
                $data[$eksici->id]['boshisse'] -= $user->pivot->hisse;
                if (Auth::user() && Auth::user()->id == $user->id) {
                    $data[$eksici->id]['hissem'] = $user->pivot->hisse;
                }

            }
        }
        return $data;
    }

    /**
     * setter for Eksici model
     *
     * @param Eksici $eksici
     */
    public function setEksici(Eksici $eksici)
    {

        $this->eksiciModel = $eksici;
    }

    /**
     * getter for Eksici model
     *
     * @return Eksici
     */
    public function getEksici()
    {

        return $this->eksiciModel;
    }

    /**
     * getting stock data of current user
     *
     * @return integer
     */
    public function getStock()
    {

        if (isset($this->eksiciModel->user()->where("user_id", Auth::user()->id)->first()->pivot)) {
            $hissem = $this->eksiciModel->user()->where("user_id", Auth::user()->id)->first()->pivot->hisse;
        } else {
            $hissem = 0;
        }

        return $hissem;
    }

    /**
     * getting available stock data for current user, for current stock
     *
     * @return integer
     */
    public function getAvailableStock()
    {
        return $this->hisse_max - $this->eksiciModel->user()->sum("hisse");

    }

    /**
     * adding stock to current user and pay the price
     *
     * @param integer $newStock
     * @param integer $newCurrency
     */
    public function updateStock($newStock, $newCurrency)
    {
        if ($this->eksiciModel->user()->where("user_id", Auth::user()->id)->count()) {
            $this->eksiciModel->user()->where("user_id", Auth::user()->id)->updateExistingPivot(Auth::user()->id,
                ["hisse" => $newStock]);
        } else {
            $this->eksiciModel->user()->where("user_id", Auth::user()->id)->attach(Auth::user()->id,
                ['hisse' => $newStock]);
        }

        $this->eksiciModel->user()->where("user_id", Auth::user()->id)->update(["eksikurus" => $newCurrency]);
    }

    /**
     * get eksici data by nickname
     *
     * @param string $nick
     * @return mixed
     */
    public function getByNick($nick)
    {
        return $this->eksiciModel->where("nick", $nick);
    }

    /**
     * update users karma score
     *
     * @param int $karma
     * @param string $nick
     * @param Builder $eksici
     * @return int
     */
    public function updateKarma($karma, $nick, Builder $eksici)
    {
        if ($eksici->count() > 0) {
            $eksici->update(["karma" => $karma]);

        } else {
            $eksici = new Eksici(["nick" => $nick, "karma" => $karma]);
            $eksici->save();
        }
        return 1;
    }
}