<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 20.10.2016
 * Time: 15:16
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace App\Models\Entities;


use Illuminate\Database\Eloquent\Model;

class EksiciTrend extends Model
{
    protected $table = 'eksici_trend';
    protected $fillable = [
        'eksici_id', 'karma', 'created_at'
    ];

    public function eksici()
    {
        return $this->belongsTo(Eksici::class, "eksici_id","id");
    }
}