<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entities\Eksici;
use Auth;
use App\Models\Entities\EksiciTrend;
use App\Models\Repositories\EksiciTrend\EksiciTrendRepository;
use EksiciRep;

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
            return "You don't have enough Twithalers.";
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
     * @return void
     */
    public function updateEksici()
    {
        set_time_limit(3600);
        $content = file_get_contents("http://eksistats.com/index.php?page=yazar&list=fav");
        preg_match_all('/nick=(.*?)"/is', $content, $matches);
        $result = $matches[1];
        for ($i = 0; $i < count($result); $i++) {
            $eksici = EksiciRep::getByNick($matches[1][$i]);
            EksiciRep::updateKarma(0, $matches[1][$i], $eksici);

        }
        $eksicis = EksiciRep::getAllEksici();
        foreach ($eksicis as $user) {
            $content = file_get_contents("https://eksisozluk.com/biri/" . rawurlencode($user->nick));
            preg_match('/user-badges.*?muted.*?\((.*?)\)/is', $content, $matches);
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

    /**
     * Update Twitter data
     *
     * @return string
     */
    public function updateTwitter()
    {
        $twitterApi = new TwitterAPI();
        $result = $twitterApi->getTwitterData();

        $response = "";
        foreach ($result as $user) {
            $eksiciTrendRepository = new EksiciTrendRepository(new EksiciTrend());
            $eksici = EksiciRep::getByNick($user->screen_name);
            $karma = round(($user->followers_count / 100000) + ($user->statuses_count / 100), 2);
            $eksiciTrendRepository->save(array(
                "eksici_id" => $eksici->first()->id,
                "created_at" => date("Y-m-d"),
                "karma" => $karma
            ));
            EksiciRep::updateKarma($karma, $user->screen_name, $eksici);

            $response .= $user->name . ":  @" . $user->screen_name . ":" . (($user->followers_count / 100000) + ($user->statuses_count / 100)) . "<br>";

        }
        return $response;
    }
}
