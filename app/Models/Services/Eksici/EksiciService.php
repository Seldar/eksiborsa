<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 11.10.2016
 * Time: 16:33
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace App\Models\Services\Eksici;

use App\Models\Repositories\Eksici\EksiciInterface;
/**
 * Our PokemonService, containing all useful methods for business logic around Pokemon
 */
class EksiciService
{
// Containing our eksiciRepository to make all our database calls to
    protected $eksiciRepo;

    /**
     * Loads our $eksiciRepo with the actual Repo associated with our eksiciInterface
     *
     * @param eksiciInterface $eksiciRepo
     * @return EksiciService
     */
    public function __construct(EksiciInterface $eksiciRepo)
    {
        $this->eksiciRepo = $eksiciRepo;
    }

    /**
     * Method to get eksici data
     *
     * @return array
     */
    public function getAllEksici()
    {

       $eksicis = $this->eksiciRepo->getAllEksici();

        // If nothing found, return this simple string
        return $eksicis;
    }
}