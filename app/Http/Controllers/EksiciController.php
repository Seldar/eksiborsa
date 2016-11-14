<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entities\Eksici;
use Auth;
use App\Models\Entities\EksiciTrend;
use App\Models\Repositories\EksiciTrend\EksiciTrendRepository;
use EksiciRep;
use Laracurl;

/**
 * Class EksiciController
 * Controller to handle Eksici related requests
 *
 * @package App\Http\Controllers
 */
class EksiciController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Returns eksici list view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listele()
    {
        $data = EksiciRep::getAllEksici();
        return view("eksici_list", array("eksiciler" => $data));
    }

    /**
     * Spend eksikurus and add new stock(s) to user
     *
     * @param Request $request
     * @param Eksici  $eksici
     *
     * @return string
     */
    public function hisseal(Request $request, Eksici $eksici)
    {

        EksiciRep::setRepo($eksici);
        $availableStock = EksiciRep::getAvailableStock();
        $myStock = EksiciRep::getStock();
        if (Auth::user()->eksikurus < $request->hisse * $eksici->karma) {
            return "You don't have enough Eksikurus.";
        }
        if ($availableStock < $request->hisse) {
            return $eksici->nick . "' doesn't have that much stock available.";
        }

        $newStock = $request->hisse + $myStock;
        $newCurrency = Auth::user()->eksikurus - $request->hisse * $eksici->karma;

        EksiciRep::updateStock($newStock, $newCurrency);

        return "";
    }

    /**
     * Remove stock(s) from user and add eksikurus to user
     *
     * @param Request $request
     * @param Eksici  $eksici
     *
     * @return string
     */
    public function hissesat(Request $request, Eksici $eksici)
    {
        EksiciRep::setRepo($eksici);
        $myStock = EksiciRep::getStock();

        if ($myStock < $request->hisse) {
            return "You don't have that much stock available.";
        }

        $newStock = $myStock - $request->hisse;
        $newCurrency = Auth::user()->eksikurus + $request->hisse * $eksici->karma;
        EksiciRep::updateStock($newStock, $newCurrency);

        return "";
    }

    /**
     * Update Eksici data
     *
     * @param int $limit
     *
     * @return void
     */
    public function updateEksici($limit = 9999)
    {
        set_time_limit(3600);
        $content = Laracurl::get("http://sozlock.com/yazarlar");
        preg_match_all('/eksilogok.*?span> (.*?) </is', $content, $matches);
        $result = $matches[1];
        $cntResult = count($result);
        for ($i = 0; $i < $cntResult; $i++) {
            $eksici = EksiciRep::getByNick($matches[1][$i]);
            EksiciRep::updateKarma(0, $matches[1][$i], $eksici);
            if (--$limit == 0) {
                break;
            }
        }
        $eksicis = EksiciRep::getAllEksici();
        foreach ($eksicis as $user) {
            $content = Laracurl::get("https://eksisozluk.com/biri/" . rawurlencode($user->nick));
            if ($content) {
                preg_match('/user-badges.*?muted.*?\((.*?)\)/is', $content->body, $matches);
                preg_match('/entry-count-lastmonth.*?>(.*?)</is', $content->body, $lastMonth);
                if (isset($matches[1]) && $matches[1] > 250 && $lastMonth[1] > 0) {
                    echo $user->nick . ":" . $matches[1] . ":" . $lastMonth[1];
                    $karma = $matches[1];
                    $eksici = EksiciRep::getByNick($user->nick);
                    EksiciRep::updateKarma($karma, $user->nick, $eksici);

                    $eksiciTrendRepository = new EksiciTrendRepository(new EksiciTrend());
                    $eksiciTrendRepository->save(array(
                        "eksici_id" => $eksici->first()->id,
                        "created_at" => date("Y-m-d"),
                        "karma" => $karma
                    ));
                }
            }
        }
        \DB::table('eksici')->where('karma', 0)->delete();
    }

    /**
     * Update Twitter data
     *
     * @param int $limit
     *
     * @return string
     */
    public function updateTwitter($limit = 9999)
    {
        $twitterApi = new TwitterAPI();
        $result = $twitterApi->getTwitterData();
        $eksiciTrendRepository = new EksiciTrendRepository(new EksiciTrend());
        $response = "";
        foreach ($result as $user) {
            $eksici = EksiciRep::getByNick($user->screen_name);
            $karma = round(($user->followers_count / 100000) + ($user->statuses_count / 100), 2);
            if ($eksici) {
                $eksiciTrendRepository->save(array(
                    "eksici_id" => $eksici->id,
                    "created_at" => date("Y-m-d"),
                    "karma" => $karma
                ));

                EksiciRep::updateKarma($karma, $user->screen_name, $eksici);
                $response .= $user->name . ":  @" . $user->screen_name . ":" . (($user->followers_count / 100000) + ($user->statuses_count / 100)) . "<br>";
                if (--$limit == 0) {
                    break;
                }
            }
        }
        return $response;
    }
}
