<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Entities\Eksici;
use App\Models\Repositories\Eksici\EksiciRepository;
use Auth;


class EksiciController extends Controller
{
    protected $hisse_multiplier = 1;
    protected $hisse_max = 100;


    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listele()
    {
        $repository = new EksiciRepository(new Eksici());
        $data = $repository->getAllEksici();

        return view("eksici_list",array("eksiciler" => $data));
    }
    public function hisseal(Request $request,Eksici $eksici)
    {
        $repository = new EksiciRepository($eksici);
        $availableStock = $repository->getAvailableStock();
        $myStock = $repository->getStock();

        if(Auth::user()->eksikurus < $request->hisse * $eksici->karma)
            return "You don't have enough Twithalers.";
        if($availableStock < $request->hisse)
            return $eksici->nick . "' doesn't have that much stock available.";

        $newStock = $request->hisse + $myStock;
        $newCurrency = Auth::user()->eksikurus - $request->hisse * $eksici->karma;
        $repository->updateStock($newStock,$newCurrency);

        return "";
        //return view("hisse_al",array("eksici" => $eksici));
    }

    public function hissesat(Request $request,Eksici $eksici)
    {
        $repository = new EksiciRepository($eksici);
        $availableStock = $repository->getAvailableStock();
        $myStock = $repository->getStock();

        if($myStock < $request->hisse)
            return "You don't have that much stock available.";

        $newStock = $myStock - $request->hisse;
        $newCurrency = Auth::user()->eksikurus + $request->hisse * $eksici->karma;
        $repository->updateStock($newStock,$newCurrency);

        return "";
        //return view("hisse_sat",array("eksici" => $eksici));
    }

    public function updateFollowers()
    {
        $twitterApi = new TwitterAPI();
        $result = $twitterApi->getTwitterData();

        $repository = new EksiciRepository(new Eksici());
        $response = "";
        foreach($result as $user)
        {
            $eksici = $repository->getByNick($user->screen_name);
            $karma = round(($user->followers_count/100000) + ($user->statuses_count/100),2);
            $repository->updateKarma($karma,$user->screen_name,$eksici);

            $response .= $user->screen_name . ":" . (($user->followers_count/100000) +  ($user->statuses_count/100)). "<br>";

        }
        return $response;
    }

}
