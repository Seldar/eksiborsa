<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Entities\Eksici;

/**
 * Class User
 * User Model
 * @package App
 */
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'eksikurus'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Defining belongsToMany relationship
     * @return BelongsToMany
     */
    public function eksici()
    {
        return $this->belongsToMany(Eksici::class, 'user_hisse',"user_id","eksici_id")->withPivot('hisse');
    }
}
