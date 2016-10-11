<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Eksici;
use App\UserHisse;
use App\User;
use Auth;


class EksiciController extends Controller
{
    protected $hisse_multiplier = 1;
    protected $hisse_max = 100;
    public function listele()
    {
        foreach(Eksici::all() as $eksici)
        {
            $data[$eksici->id] = $eksici;
            $data[$eksici->id]['boshisse'] = $this->hisse_max;
            foreach($eksici->user()->getResults() as $user) {
                $data[$eksici->id]['boshisse'] -= $user->pivot->hisse;
                if(Auth::user() && Auth::user()->id == $user->id)
                {
                    $data[$eksici->id]['hissem'] = $user->pivot->hisse;
                }

            }
        }
        return view("eksici_list",array("eksiciler" => $data));
    }
    public function hisseal(Request $request,Eksici $eksici)
    {
        $boshisse = $this->hisse_max - $eksici->user()->sum("hisse");
        if(isset($eksici->user()->where("user_id",Auth::user()->id)->first()->pivot))
            $hissem = $eksici->user()->where("user_id",Auth::user()->id)->first()->pivot->hisse;
        else
            $hissem = 0;

        if(Auth::user()->eksikurus < $request->hisse * $eksici->karma)
            return "You don't have enough Twithalers.";
        if($boshisse < $request->hisse)
            return $eksici->nick . "' doesn't have that much stock available.";


        if($eksici->user()->where("user_id",Auth::user()->id)->count())
            $eksici->user()->where("user_id",Auth::user()->id)->updateExistingPivot(Auth::user()->id,["hisse" =>  $request->hisse + $hissem]);
        else
            $eksici->user()->where("user_id",Auth::user()->id)->attach(Auth::user()->id, ['hisse' => $request->hisse]);
        $eksici->user()->where("user_id",Auth::user()->id)->update(["eksikurus" => Auth::user()->eksikurus - $request->hisse * $eksici->karma]);
        return "";
        //return view("hisse_al",array("eksici" => $eksici));
    }

    public function hissesat(Eksici $eksici)
    {
        //return view("hisse_sat",array("eksici" => $eksici));
    }

    public function updateFollowers(Request $request)
    {
        if(!$request->session()->has('data')) {
            $twitteruser = "TwitStockMarket";
            $notweets = 100;
            $method = 'GET';
            //$path = '/1.1/followers/ids.json'; // api call path
            $path = '/1.1/friends/ids.json'; // api call path
            $query = '?screen_name=' . $twitteruser . '&count=' . $notweets;

            $result = json_decode($this->twitterApi($query, $path, $method));

            $path = '/1.1/users/lookup.json'; // api call path
            $query = '?user_id=' . implode(",", $result->ids);
            $request->session()->set('data',$this->twitterApi($query, $path, $method));
        }
        $result = json_decode($request->session()->get('data'));
        foreach($result as $user)
        {
            $eksici = Eksici::where("nick", $user->screen_name);
            $karma = round(($user->followers_count/100000) + ($user->statuses_count/100),2);
            if($eksici->count() > 0)
            {
                $eksici->update(["karma" => $karma]);

            }
            else
            {
                $eksici = new Eksici(["nick" => $user->screen_name,"karma" => $karma]);
                $eksici->save();
            }
            echo $user->screen_name . ":" . (($user->followers_count/100000) +  ($user->statuses_count/100)). "<br>";

        }

    }

    public function twitterApi($query,$path,$method)
    {
        $settings = array(
            'oauth_access_token' => "712957376341610496-FmFUWrk6aD5ZeHeTj6f9s4loCngqWvj",
            'oauth_access_token_secret' => "3N3vY2kY0W5e1s1fItjIqlIQ5g7sXfZjaJ6o71VBmwtmz",
            'consumer_key' => "AKVG1UoS53c1sEVDs8Js0E3Rn",
            'consumer_secret' => "sbDcdauLcV0jrj0O0phdJz4FDHFmR9nF8pwkz1C0fjPZrve5sR"
        );
        $url = 'https://api.twitter.com' . $path;
        $getfield = $query;
        $requestMethod = $method;

        $twitter = new TwitterAPIExchange($settings);
        return $twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();

    }

}
