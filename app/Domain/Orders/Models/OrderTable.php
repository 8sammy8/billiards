<?php

namespace App\Domain\Orders\Models;

use App\Domain\Tables\Models\Table;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Domain\Orders\Models\OrderTable
 *
 * @property int $id
 * @property int $order_id
 * @property int $table_id
 * @property mixed $start_at
 * @property mixed|null $end_at
 * @property mixed|null $time_at
 * @property int $amount
 * @property-read \App\Domain\Orders\Models\Order $order
 * @property-read Table $table
 * @method static \Illuminate\Database\Eloquent\Builder|OrderTable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderTable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderTable query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderTable whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderTable whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderTable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderTable whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderTable whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderTable whereTableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderTable whereTimeAt($value)
 * @mixin \Eloquent
 */
class OrderTable extends Model
{
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
        'start_at' => 'datetime:Y-m-d H:i:s',
        'end_at' => 'datetime:Y-m-d H:i:s',
        'time_at' => 'datetime:H:i',
    ];

    /**
     * Get the order that owns the ordered table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the table that owns the ordered table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
