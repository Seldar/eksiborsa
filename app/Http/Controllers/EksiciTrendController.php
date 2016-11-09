<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 21.10.2016
 * Time: 14:30
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace App\Http\Controllers;

use App\Models\Entities\EksiciTrend;
use App\Models\Repositories\EksiciTrend\EksiciTrendRepository;
use Illuminate\Http\Request;

/**
 * Class EksiciTrendController
 * Controller to handle trend requests
 *
 * @package App\Http\Controllers
 */
class EksiciTrendController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Returns trend list view
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showTrend(Request $request)
    {
        $eksiciTrendRepo = new EksiciTrendRepository(new EksiciTrend());
        $trends = $eksiciTrendRepo->getByDate($request->startDate, $request->endDate, $request->eksici, $request->topX);
        return view("trend_list", array("data" => $trends[0], "dates" => $trends[1], "karmaTrends" => $trends[2]));
    }
}