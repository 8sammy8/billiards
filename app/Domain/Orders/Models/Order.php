<?php

namespace App\Domain\Orders\Models;

use App\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Domain\Orders\Models\Order
 *
 * @property int $id
 * @property bool $status
 * @property bool $cashbox
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Domain\Orders\Models\OrderProduct[] $orderProducts
 * @property-read int|null $order_products_count
 * @property-read \App\Domain\Orders\Models\OrderTable|null $orderTable
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCashbox($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $casts = [
        'status' => 'boolean',
        'cashbox' => 'boolean',
    ];

    /**
     * Get the user that owns the order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order table for the order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function orderTable()
    {
        return $this->hasOne(OrderTable::class);
    }

    /**
     * Get the products of the order for the order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
