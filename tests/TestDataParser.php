<?php

/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 14.11.2016
 * Time: 15:23
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */
namespace Tests;

use App\Http\Controllers\DataParser;

class TestDataParser extends DataParser
{
    public $body;

    public function parse($url)
    {
        $this->body = "eksilogok...span> casey <...eksilogok...span> travenian <...user-badges...muted...(500)...entry-count-lastmonth...>1<";
        return $this;
    }
}