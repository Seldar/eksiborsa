<?php namespace App\Models\Repositories\EksiciTrend;

/**
 * Interface EksiciTrendInterface
 *
 * @package App\Models\Repositories\EksiciTrend
 */
interface EksiciTrendInterface
{
    /**
     * Method to save array $data data to Eksici model
     *
     * @param $data
     *
     * @return mixed
     */
    public function save($data);

    /**
     * Get Eksici Trends by date filter
     *
     * @param string $startDate
     * @param string $endDate
     * @param string $eksici
     * @param int    $limit
     *
     * @return mixed
     */
    public function getByDate($startDate = "1970-01-01", $endDate = "", $eksici = "", $limit = 10);

}