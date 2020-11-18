<?php

namespace App\Domain\HallGroups\Models;

use App\Domain\Rates\Models\Rate;
use App\Domain\Tables\Models\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Domain\HallGroups\Models\HallGroup
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Rate[] $rates
 * @property-read int|null $rates_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Table[] $tables
 * @property-read int|null $tables_count
 * @method static \Illuminate\Database\Eloquent\Builder|HallGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HallGroup newQuery()
 * @method static \Illuminate\Database\Query\Builder|HallGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|HallGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|HallGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HallGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HallGroup whereName($value)
 * @method static \Illuminate\Database\Query\Builder|HallGroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|HallGroup withoutTrashed()
 * @mixin \Eloquent
 */
class HallGroup extends Model
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the rates for the hall group.
     */
    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    /**
     * Get the tables for the hall group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tables()
    {
        return $this->hasMany(Table::class);
    }
}
