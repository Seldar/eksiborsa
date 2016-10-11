<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 11.10.2016
 * Time: 16:32
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace App\Models\Services\Eksici;
use Illuminate\Support\ServiceProvider;

/**
 * Register our eksici service with Laravel
 */

class EksiciServiceServiceProvider extends ServiceProvider
{
    /**
     * Registers the service in the IoC Container
     *
     */

    public function register()
    {
        // Binds 'pokemonService' to the result of the closure
        $this->app->bind('pokemonService', function($app)
        {
            return new EksiciService(
            // Inject in our class of pokemonInterface, this will be our repository
                $app->make('Repositories\Eksici\EksiciInterface')
            );
        });
    }

}