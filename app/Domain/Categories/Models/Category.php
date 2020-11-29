<?php

namespace App\Domain\Categories\Models;

use App\Domain\Products\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Domain\Categories\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property bool $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Query\Builder|Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Category withoutTrashed()
 * @mixin \Eloquent
 * @method static Builder|Category active()
 * @method static Builder|Category activeProducts()
 */
class Category extends Model
{
    use SoftDeletes;

    public const CATEGORY_STATUS_ACTIVE = TRUE;
    public const CATEGORY_STATUS_BLOCK = FALSE;

    /**
     * @var string[]
     */
    protected $guarded = ['id', 'deleted_at'];

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
     * Get the products for the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get only active(opened) categories
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query):Builder
    {
        return $query->where(['status' => self::CATEGORY_STATUS_ACTIVE]);
    }

    /**
     * Get only active(opened) products
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActiveProducts(Builder $query):Builder
    {
        return $query->with('products', function ($query) {
            $query->active('active');
        });
    }
}
