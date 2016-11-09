<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\User;

/**
 * Class Eksici
 *
 * @package App\Models\Entities
 */
class Eksici extends Model
{
    /**
     * Custom table name
     *
     * @var string
     */
    protected $table = 'eksici';

    /**
     * Fields that are mass settable.
     *
     * @var array
     */
    protected $fillable = [
        'nick',
        'karma'
    ];

    /**
     * Defining belongsToMany relationship
     *
     * @return belongsToMany
     */
    public function user()
    {
        return $this->belongsToMany(User::class, 'user_hisse', "eksici_id", "user_id")->withPivot('hisse');
    }
}
