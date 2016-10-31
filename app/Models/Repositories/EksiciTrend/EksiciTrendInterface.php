<?php namespace App\Models\Repositories\EksiciTrend;

/**
 * A simple interface to set the methods in our Eksici repository, nothing much happening here
 */
/**
 * Interface EksiciTrendInterface
 * @package App\Models\Repositories\EksiciTrend
 */
interface EksiciTrendInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function save($data);

    /**
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    public function getByDate($startDate, $endDate);

}