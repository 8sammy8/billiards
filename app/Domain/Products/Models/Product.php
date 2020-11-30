<?php

namespace App\Domain\Products\Models;

use App\Domain\Categories\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use App\Domain\Products\Observers\ProductObserver;

/**
 * App\Domain\Products\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property int|null $code
 * @property int|null $unit
 * @property int $price
 * @property int $purchase_price
 * @property int $remainder
 * @property bool $status
 * @property string|null $img
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Category $category
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePurchasePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRemainder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 * @mixin \Eloquent
 * @method static Builder|Product active()
 */
class Product extends Model
{
    use SoftDeletes;

    public const PRODUCT_STATUS_SHOW = TRUE;
    public const PRODUCT_STATUS_HIDE = FALSE;

    /**
     * @var string[]
     */
    protected $guarded = ['id', 'deleted_at', 'created_at' , 'updated_at'];

    /**
     * @var string[]
     */
    protected $casts = [
        'status' => 'boolean',
        'updated_at' => 'datetime:d-m-Y H:i',
    ];

    /**
     * @var string[]
     */
    protected $dispatchesEvents = [
        'created' => ProductObserver::class,
        'updated' => ProductObserver::class,
        'deleted' => ProductObserver::class,
    ];

    /**
     * Upload product image path
     *
     * @var string
     */
    protected $imagePath = 'uploads/products/';

    /**
     * The "boot" method of the model.
     * Register observer
     */
    public static function boot() {
        parent::boot();
        Product::observe(new ProductObserver());
    }

    /**
     * Get the category that owns the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get only active(opened) products
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query):Builder
    {
        return $query->where(['status' => self::PRODUCT_STATUS_SHOW]);
    }

    /**+
     * Get the product's image.
     *
     * @param ?string $value
     * @return string
     */
    public function getImgAttribute(?string $value):string
    {
        return $value ? Storage::url($this->imagePath) . $value : '';
    }
}
