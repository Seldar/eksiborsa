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

class EksiciTrendRepository
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
        print_r($data);
        $this->eksiciTrendModel->eksici_id = $data['eksici_id'];
        $this->eksiciTrendModel->karma = $data['karma'];
        $this->eksiciTrendModel->created_at = $data['created_at'];

        $this->eksiciTrendModel->save();
    }
}