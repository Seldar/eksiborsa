<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class UserHisse extends Model
{
    protected $table = 'user_hisse';
    protected $fillable = [
        'eksici_id', 'user_id','hisse'
    ];
}
