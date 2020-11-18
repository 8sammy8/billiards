<?php

namespace App\Domain\CategoryProducts\Models;

use App\Domain\Products\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Domain\CategoryProducts\Models\CategoryProduct
 *
 * @property int $id
 * @property string $name
 * @property bool $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryProduct newQuery()
 * @method static \Illuminate\Database\Query\Builder|CategoryProduct onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryProduct whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryProduct whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryProduct whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|CategoryProduct withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CategoryProduct withoutTrashed()
 * @mixin \Eloquent
 */
class CategoryProduct extends Model
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
     * @var string[]
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the products for the category product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
