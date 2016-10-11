<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 11.10.2016
 * Time: 16:13
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace App\Models\Repositories\Eksici;

use Illuminate\Database\Eloquent\Model;
use \stdClass;
use App\Models\Repositories\Eksici\EksiciInterface;
use Auth;


class EksiciRepository implements EksiciInterface
{
    protected $eksiciModel;
    protected $hisse_multiplier = 1;
    protected $hisse_max = 100;
    /**
     * Setting our class $eksiciModel to the injected model
     *
     * @param Model $eksici
     * @return Null
     */
    public function __construct(Model $eksici)
    {
        $this->eksiciModel = $eksici;
    }

    /**
     * getting all Eksici data
     *
     * @param Model $eksici
     * @return array
     */
    public function getAllEksici()
    {
        $data = array();
        foreach($this->eksiciModel->all() as $eksici)
        {
            $data[$eksici->id] = $eksici;
            $data[$eksici->id]['boshisse'] = $this->hisse_max;
            foreach($eksici->user()->getResults() as $user) {
                $data[$eksici->id]['boshisse'] -= $user->pivot->hisse;
                if(Auth::user() && Auth::user()->id == $user->id)
                {
                    $data[$eksici->id]['hissem'] = $user->pivot->hisse;
                }

            }
        }
        return $data;
    }

    public function setEksici(Eksici $eksici)
    {

        $this->eksiciModel = $eksici;
    }

    public function getEksici()
    {

        return $this->eksiciModel;
    }

    /**
     * getting stock data of current user
     *
     * @return array
     */
    public function getStock()
    {

        if(isset($this->eksiciModel->user()->where("user_id",Auth::user()->id)->first()->pivot))
            $hissem = $this->eksiciModel->user()->where("user_id",Auth::user()->id)->first()->pivot->hisse;
        else
            $hissem = 0;

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
    public function addStock($newStock,$newCurrency)
    {
        if($this->eksiciModel->user()->where("user_id",Auth::user()->id)->count())
            $this->eksiciModel->user()->where("user_id",Auth::user()->id)->updateExistingPivot(Auth::user()->id,["hisse" => $newStock]);
        else
            $this->eksiciModel->user()->where("user_id",Auth::user()->id)->attach(Auth::user()->id, ['hisse' => $newStock]);

        $this->eksiciModel->user()->where("user_id",Auth::user()->id)->update(["eksikurus" => $newCurrency]);
    }

    public function getByNick($nick)
    {
        return $this->eksiciModel->where("nick", $nick);
    }

    public function updateKarma($karma,$nick,$eksici)
    {
        if( $eksici->count() > 0)
        {
            $eksici->update(["karma" => $karma]);

        }
        else
        {
            $eksici = new Eksici(["nick" => $nick,"karma" => $karma]);
            $eksici->save();
        }
    }
}