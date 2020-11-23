<?php

namespace App\Services;

use App\Domain\Products\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductImageService
{
    /**
     * @var Product
     */
    private $product;

    /**
     * ProductImageService constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Upload product image path
     *
     * @var string
     */
    protected $imagePath = 'uploads/products/';

    /**
     * @param UploadedFile $image
     * @return void
     */
    public function upload(UploadedFile $image):void
    {
        $extension = $image->getClientOriginalExtension();

        $filename = time() . Str::random('4');
        $imgSource = $filename . '_'
                        . config('settings.image.product.width')
                        .'x'
                        . config('settings.image.product.height')
                        .'.'
                        . $extension;

        $productImage = Image::make($image)
            ->fit(config('settings.image.product.width'), config('settings.image.product.height'))
            ->save();

        Storage::disk('public')->put($this->imagePath . $imgSource, $productImage);

        $this->product->img = $imgSource;
    }

    /**
     * @param UploadedFile $image
     * @return void
     */
    public function reUpload(UploadedFile $image):void
    {
        $this->remove();
        $this->upload($image);
    }
    /**
     * @return void
     */
    public function remove():void
    {
        $file = ($this->imagePath . $this->product->getRawOriginal('img'));
        Storage::disk('public')->delete($file);
    }
}
