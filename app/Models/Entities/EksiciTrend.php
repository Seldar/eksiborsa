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

/**
 * Class EksiciTrend
 * @package App\Models\Entities
 */
class EksiciTrend extends Model
{
    /**
     * @var string
     */
    protected $table = 'eksici_trend';
    /**
     * @var array
     */
    protected $fillable = [
        'eksici_id',
        'karma',
        'created_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function eksici()
    {
        return $this->belongsTo(Eksici::class, "eksici_id", "id");
    }
}