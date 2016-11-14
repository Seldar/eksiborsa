<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 20.10.2016
 * Time: 15:16
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace App\Models\Entities;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class EksiciTrend
 *
 * @package App\Models\Entities
 *
 * @property int $ekisic_id
 * @property int $karma
 * @property Carbon $created_at
 *
 * @method Builder whereBetween(string $column, array $values, string $boolean = 'and', boolean $not = false)
 * @method Builder orderBy(string $column, string $direction = 'asc')
 */
class EksiciTrend extends Model
{
    /**
     * Custom table name
     *
     * @var string
     */
    protected $table = 'eksici_trend';

    /**
     * Fields that are mass settable.
     *
     * @var array
     */
    protected $fillable = [
        'eksici_id',
        'karma',
        'created_at'
    ];

    /**
     * Defining BelongsTo relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function eksici()
    {
        return $this->belongsTo(Eksici::class, "eksici_id", "id");
    }
}