<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 11.10.2016
 * Time: 16:24
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace App\Models\Repositories\EksiciTrend;

use Illuminate\Support\ServiceProvider;
use App\Models\Entities\EksiciTrend;

/**
 * Register our Repository with Laravel
 */
class EksiciTrendRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Registers the eksiciTrendInterface with Laravels IoC Container
     */
    public function register()
    {
        // Bind the returned class to the namespace 'Repositories\EksiciTrend\EksiciTrendInterface
        $this->app->bind('Repositories\EksiciTrend\EksiciTrendInterface', function () {
            return new EksiciTrendRepository(new EksiciTrend());
        });
    }
}