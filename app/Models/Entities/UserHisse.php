<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserHisse
 * @package App\Models\Entities
 */
class UserHisse extends Model
{
    /**
     * @var string
     */
    protected $table = 'user_hisse';
    /**
     * @var array
     */
    protected $fillable = [
        'eksici_id',
        'user_id',
        'hisse'
    ];
}
