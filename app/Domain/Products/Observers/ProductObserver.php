<?php

namespace App\Domain\Products\Observers;

use App\Domain\Products\Models\Product;
use App\Services\ProductLoggerService;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param  Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        $loggerService = new ProductLoggerService($product);
        $loggerService->productCreated();
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        $loggerService = new ProductLoggerService($product);
        $loggerService->productUpdated();
    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param  Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        $loggerService = new ProductLoggerService($product);
        $loggerService->productDeleted();

        if($product->img){
            $product::withoutEvents(function () use($product){
                $product->img = '';
                return $product->update();
            });
        }
    }
}
