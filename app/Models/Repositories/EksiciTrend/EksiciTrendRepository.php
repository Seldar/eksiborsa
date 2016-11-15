<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 20.10.2016
 * Time: 15:13
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace App\Models\Repositories\EksiciTrend;

use App\Models\Entities\EksiciTrend;
use EksiciRep;

/**
 * Class EksiciTrendRepository
 * Repository to handle model to database interactions
 *
 * @package App\Models\Repositories\EksiciTrend
 */
class EksiciTrendRepository implements EksiciTrendInterface
{
    /**
     * Contains EksiciTrend Model
     *
     * @var EksiciTrend
     */
    private $eksiciTrendModel;

    /**
     * Setting our class eksiciTrend Model to the injected model
     *
     * @param EksiciTrend $eksiciTrend
     */
    public function __construct(EksiciTrend $eksiciTrend)
    {
        $this->eksiciTrendModel = $eksiciTrend;
    }

    /**
     * Method to save array $data data to Eksici model
     *
     * @param $data
     *
     * @return void
     */
    public function save($data)
    {
        $this->eksiciTrendModel->eksici_id = $data['eksici_id'];
        $this->eksiciTrendModel->karma = $data['karma'];
        $this->eksiciTrendModel->created_at = $data['created_at'];

        $this->eksiciTrendModel->save();
    }

    /**
     * Get Eksici Trends by date filter
     *
     * @param string $startDate
     * @param string $endDate
     * @param string $eksici
     * @param int    $limit
     *
     * @return array
     */
    public function getByDate($startDate = "1970-01-01", $endDate = "", $eksici = "", $limit = 10)
    {
        if (!$startDate) {
            $startDate = "1970-01-01";
        }
        if (!$endDate) {
            $endDate = date("Y-m-d");
        }
        if (!$limit) {
            $limit = 10;
        }

        $trends = $this->eksiciTrendModel->whereBetween('created_at',
            array($startDate, $endDate))->orderBy('created_at', 'asc');


        $topKarmaList = [];
        if (!$eksici) {
            $top = $this->eksiciTrendModel->orderBy(\DB::raw('AVG(karma)'),
                "desc")->groupBy("eksici_id")->take($limit)->get();
            foreach ($top as $topKarma) {
                $topKarmaList[] = $topKarma->eksici->nick;
            }
            $trends = $trends->get();
        } else {
            $topKarmaList[] = $eksici;
            $eksiRow = EksiciRep::getByNick($eksici)->get();
            $trends = $trends->where('eksici_id', '=',
                $eksiRow[0]->id)->get();
        }

        $result = array();
        $dates = array();
        $karmaTrend = array();
        $initialKarma = array();
        foreach ($trends as $i => $trend) {
            if (!in_array($trend->eksici->nick, $topKarmaList)) {
                continue;
            }
            if (!isset($initialKarma[$trend->eksici->nick])) {
                $initialKarma[$trend->eksici->nick] = $trend->karma;
            }
            $result[$trend->eksici->nick][] = $trend->karma;
            $karmaTrend[$trend->eksici->nick][] = round(100 * ($trend->karma / $initialKarma[$trend->eksici->nick]), 2);
            $dates[$trend['created_at']->toDateString()] = 1;

        }

        return array($result, $dates, $karmaTrend);
    }
}