<?php

namespace App\Domain\Rates\Models;

use App\Domain\HallGroups\Models\HallGroup;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Domain\Rates\Models\Rate
 *
 * @property int $id
 * @property string $name
 * @property int $price
 * @property mixed|null $start_at
 * @property mixed|null $end_at
 * @property int $hall_group_id
 * @property mixed|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read HallGroup $hallGroup
 * @method static \Illuminate\Database\Eloquent\Builder|Rate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rate query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereHallGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Rate extends Model
{
    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $casts = [
        'start_at' => 'datetime:H:i',
        'end_at' => 'datetime:H:i',
        'created_at' => 'datetime:Y-m-d',
    ];

    /**
     * Get the hall group that owns the rate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hallGroup()
    {
        return $this->belongsTo(HallGroup::class);
    }
}
