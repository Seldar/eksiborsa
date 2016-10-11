<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 11.10.2016
 * Time: 16:24
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace App\Models\Repositories\Eksici;
use Illuminate\Support\ServiceProvider;
use App\Models\Repositories\Eksici\EksiciRepository;
use App\Models\Entities\Eksici;
/**
 * Register our Repository with Laravel
 */
class EksiciRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Registers the eksiciInterface with Laravels IoC Container
     *
     */
    public function register()
    {
        // Bind the returned class to the namespace 'Repositories\PokemonInterface
        $this->app->bind('Repositories\Pokemon\PokemonInterface', function($app)
        {
            return new EksiciRepository(new Eksici());
        });
    }
}