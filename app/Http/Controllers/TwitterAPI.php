<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 11.10.2016
 * Time: 17:31
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace App\Http\Controllers;
use App\Http\Requests;
use Symfony\Component\HttpKernel\Tests\DataCollector\RequestDataCollectorTest;

class TwitterAPI
{


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

    public function getTwitterData(\Illuminate\Http\Request $request)
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
        return $result;
    }
}