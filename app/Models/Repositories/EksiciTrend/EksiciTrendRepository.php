<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 20.10.2016
 * Time: 15:13
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace App\Models\Repositories\EksiciTrend;

use App\Models\Entities\EksiciTrend;

class EksiciTrendRepository implements EksiciTrendInterface
{
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

    public function save($data)
    {
        $this->eksiciTrendModel->eksici_id = $data['eksici_id'];
        $this->eksiciTrendModel->karma = $data['karma'];
        $this->eksiciTrendModel->created_at = $data['created_at'];

        $this->eksiciTrendModel->save();
    }

    public function getByDate($startDate = "",$endDate = "")
    {
        if(!$startDate)
            $startDate = "1970-01-01";
        if(!$endDate)
            $endDate = date("Y-m-d");
        $trends = $this->eksiciTrendModel->whereBetween('created_at',array($startDate,$endDate))->get();
        $result = array();
        $dates = array();
        foreach($trends as $i => $trend)
        {
            $result[$trend->eksici->nick][] = $trend->karma;
            $dates[$trend['created_at']->toDateTimeString()] = 1;
        }

        return array($result,$dates);
    }
}