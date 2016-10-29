<?php namespace App\Models\Repositories\EksiciTrend;

/**
 * A simple interface to set the methods in our Eksici repository, nothing much happening here
 */
interface EksiciTrendInterface
{
    public function save($data);

    public function getByDate($startDate, $endDate);

}