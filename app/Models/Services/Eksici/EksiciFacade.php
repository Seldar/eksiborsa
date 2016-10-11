<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 11.10.2016
 * Time: 16:38
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace App\Models\Services\Eksici;
use \Illuminate\Support\Facades\Facade;

/**
 * Facade class to be called whenever the class EksiciService is called
 */
class EksiciFacade extends Facade
{
    /**
     * Get the registered name of the component. This tells $this->app what record to return
     * (e.g. $this->app[‘eksiciService’])
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'eksiciService'; }
}