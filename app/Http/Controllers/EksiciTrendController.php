<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 21.10.2016
 * Time: 14:30
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace App\Http\Controllers;

use App\Models\Entities\EksiciTrend;
use App\Models\Repositories\EksiciTrend\EksiciTrendRepository;

class EksiciTrendController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function showTrend()
    {
        $eksiciTrendRepo = new EksiciTrendRepository(new EksiciTrend());
        $trends = $eksiciTrendRepo->getByDate();
        return view("trend_list",array("data" => $trends[0],"dates" => $trends[1],"karmaTrends" => $trends[2]));
    }
}