<?php

namespace App\Domain\Orders\Models;

use App\Domain\Products\Models\Product;
use App\Domain\Tables\Models\Table;
use App\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
 * @method static Builder|Order active()
 * @method static Builder|Order activeTables()
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereCashbox($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereStatus($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order whereUserId($value)
 * @mixin \Eloquent
 * @property int $total_amount
 * @method static Builder|Order activeProducts()
 * @method static Builder|Order whereTotalAmount($value)
 */
class Order extends Model
{
    /**
     * Order status
     */
    public const ORDER_STATUS_OPEN = 0;
    public const ORDER_STATUS_CLOSED = 1;

    /**
     * The status of the user handing over to the admin
     */
    public const CASHBOX_OPEN = 0;
    public const CASHBOX_CLOSED = 1;

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
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order table for the order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function orderTable():HasOne
    {
        return $this->hasOne(OrderTable::class);
    }

    /**
     * Get the products of the order for the order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderProducts():HasMany
    {
        return $this->hasMany(OrderProduct::class)
            ->where('return_status', OrderProduct::NOT_REFUNDED);
    }

    /**
     * Get only active(opened) orders
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query):Builder
    {
        return $query->where(['status' => self::ORDER_STATUS_OPEN]);
    }

    /**
     * Get with active(opened) ordered tables
     *
     * @return Builder
     */
    public function scopeActiveTables():Builder
    {
        return $this->active()->with('orderTable');
    }

    /**
     * Get with active(opened) ordered products
     *
     * @return Builder
     */
    public function scopeActiveProducts():Builder
    {
        return $this->active()->with('orderProducts');
    }

    /**
     * Get the table for the order from order table
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function table()
    {
        return $this->hasOneThrough(Table::class, OrderTable::class, 'order_id','id', 'id', 'table_id');
    }

    /**
     * Get the products for the order from order products
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasManyThrough
     */
    public function products()
    {
        return $this->hasManyThrough(Product::class, OrderProduct::class, 'order_id','id', 'id', 'product_id')->where('return_status', OrderProduct::NOT_REFUNDED);
    }

    /**
     * Get with active(opened) ordered products
     *
     * @return Builder
     */
    public function scopeOrderProductsWithProducts():Builder
    {
        return $this->with('orderProducts')->with('products');
    }
}
