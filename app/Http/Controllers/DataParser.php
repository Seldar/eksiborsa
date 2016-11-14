<?php

/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 14.11.2016
 * Time: 15:18
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace App\Http\Controllers;

use Laracurl;

/**
 * Class DataParser
 *
 * @package Tests
 */
class DataParser
{
    /**
     * Parse $url and return source
     *
     * @param string $url
     */
    public function parse($url)
    {
        return Laracurl::get($url);
    }
}