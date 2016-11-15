<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 11.10.2016
 * Time: 16:32
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace App\Models\Services\EksiciTrend;

use Illuminate\Support\ServiceProvider;

/**
 * Register our eksiciTrend service with Laravel
 */
class EksiciTrendServiceServiceProvider extends ServiceProvider
{
    /**
     * Registers the service in the IoC Container
     */

    public function register()
    {
        // Binds 'eksiciTrendService' to the result of the closure
        $this->app->bind('eksiciTrendService', function ($app) {
            return new EksiciTrendService(
            // Inject in our class of eksiciTrendInterface, this will be our repository
                $app->make('App\Models\Repositories\EksiciTrend\EksiciTrendInterface')
            );
        });
    }

}