<?php

namespace App\Domain\Tables\Models;

use App\Domain\HallGroups\Models\HallGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Domain\Tables\Models\Table
 *
 * @property int $id
 * @property string $name
 * @property bool $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $hall_group_id
 * @property-read HallGroup $hallGroup
 * @method static \Illuminate\Database\Eloquent\Builder|Table newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Table newQuery()
 * @method static \Illuminate\Database\Query\Builder|Table onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Table query()
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereHallGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|Table withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Table withoutTrashed()
 * @mixin \Eloquent
 */
class Table extends Model
{
    use SoftDeletes;

    public const TABLE_STATUS_SHOW = TRUE;
    public const TABLE_STATUS_HIDE = FALSE;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the hall group that owns the table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hallGroup()
    {
        return $this->belongsTo(HallGroup::class);
    }
}
