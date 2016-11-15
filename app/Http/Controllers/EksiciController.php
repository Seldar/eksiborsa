<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entities\Eksici;
use Auth;
use App\Models\Entities\EksiciTrend;
use App\Models\Repositories\EksiciTrend\EksiciTrendRepository;
use EksiciRep;
use EksiciTrendRep;

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
     * @param int        $limit
     * @param DataParser $dp
     *
     * @return void
     */
    public function updateEksici($limit = 9999, DataParser $dp)
    {
        set_time_limit(3600);
        $content = $dp->parse("http://sozlock.com/yazarlar");
        preg_match_all('/eksilogok.*?span> (.*?) </is', $content->body, $matches);
        $result = $matches[1];
        $cntResult = count($result);
        for ($i = 0; $i < $cntResult; $i++) {
            $this->updateKarmaByNick($matches[1][$i], 0);
            if (--$limit == 0) {
                break;
            }
        }
        $eksicis = EksiciRep::getAllEksici();
        foreach ($eksicis as $user) {
            $content = $dp->parse("https://eksisozluk.com/biri/" . rawurlencode($user->nick));
            if ($content) {
                preg_match('/user-badges.*?muted.*?\((.*?)\)/is', $content->body, $matches);
                preg_match('/entry-count-lastmonth.*?>(.*?)</is', $content->body, $lastMonth);
                if (isset($matches[1]) && $matches[1] > 250 && $lastMonth[1] > 0) {
                    $karma = $matches[1];
                    $eksici = $this->updateKarmaByNick($user->nick, $karma);

                    EksiciTrendRep::save(array(
                        "eksici_id" => isset($eksici->id) ? $eksici->id : 0,
                        "created_at" => date("Y-m-d"),
                        "karma" => $karma
                    ));
                }
            }
        }
        \DB::table('eksici')->where('karma', 0)->delete();
    }

    public function updateKarmaByNick($nick, $karma)
    {
        $eksici = EksiciRep::getByNick($nick);
        EksiciRep::updateKarma($karma, $nick, $eksici);
        return $eksici;
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
        $response = "";
        foreach ($result as $user) {
            $karma = round(($user->followers_count / 100000) + ($user->statuses_count / 100), 2);
            $eksici = $this->updateKarmaByNick($user->screen_name, $karma);
            EksiciTrendRep::save(array(
                "eksici_id" => isset($eksici->id) ? $eksici->id : 0,
                "created_at" => date("Y-m-d"),
                "karma" => $karma
            ));
            $response .= $user->name . ":  @" . $user->screen_name . ":" . (($user->followers_count / 100000) + ($user->statuses_count / 100)) . "<br>";
            if (--$limit == 0) {
                break;
            }

        }
        return $response;
    }

}
