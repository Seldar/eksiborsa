<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserHisse
 *
 * @package App\Models\Entities
 */
class UserHisse extends Model
{
    /**
     * Custom table name
     *
     * @var string
     */
    protected $table = 'user_hisse';
    /**
     * Fields that are mass settable.
     *
     * @var array
     */
    protected $fillable = [
        'eksici_id',
        'user_id',
        'hisse'
    ];
}
