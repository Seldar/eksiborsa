<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eksici extends Model
{
    protected $table = 'eksici';
    protected $fillable = [
        'nick', 'karma'
    ];

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_hisse',"eksici_id","user_id")->withPivot('hisse');
    }
}
