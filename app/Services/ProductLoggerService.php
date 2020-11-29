<?php

namespace App\Services;

use App\Domain\Products\Models\Product;

class ProductLoggerService
{
    /**
     * @var Product
     */
    private $product;

    /**
     * ProductLoggerService constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function productCreated()
    {
        \Log::channel('products')->info(
            'Product added ID: ' . $this->product->id
            . ' Product name: ' . $this->product->name
            . ' Product price: ' . $this->product->price
            . ' Product Code: ' . $this->product->code
            . ' Product purchase_price: ' . $this->product->purchase_price
            . ' Product remainder: ' . $this->product->remainder
            . ' Product status: ' . trans_choice('admin.product_status', $this->product->status)
        );
    }

    public function productUpdated()
    {
        \Log::channel('products')->info(
            'Product updated ID: ' . $this->product->id
            . ' Product name: ' . $this->product->name . '(' . $this->product->getOriginal('name') . ')'
            . ' Product Code: ' . $this->product->code . '(' . $this->product->getOriginal('code') . ')'
            . ' Product price: ' . $this->product->price . '(' . $this->product->getOriginal('price') . ')'
            . ' Product purchase_price: ' . $this->product->purchase_price . '(' . $this->product->getOriginal('purchase_price') . ')'
            . ' Product remainder: ' . $this->product->remainder . '(' . $this->product->getOriginal('remainder') . ')'
            . ' Product status: ' . trans_choice('admin.product_status', $this->product->status)
            . '(' . trans_choice('admin.product_status', $this->product->getOriginal('status'))  . ')'
        );
    }

    public function productDeleted()
    {
        \Log::channel('products')->warning(
            'Product deleted ID: ' . $this->product->id
            . ' Product name: ' . $this->product->name
            . ' Product Code: ' . $this->product->code
            . ' Product price: ' . $this->product->price
            . ' Product purchase_price: ' . $this->product->purchase_price
            . ' Product remainder: ' . $this->product->remainder
            . ' Product status: ' . trans_choice('admin.product_status', $this->product->status)
        );
    }

    public function productRefund()
    {
        \Log::channel('products')->info(
            'Product refunded ID: ' . $this->product->id
            . ' Product name: ' . $this->product->name . '(' . $this->product->getOriginal('name') . ')'
            . ' Product Code: ' . $this->product->code . '(' . $this->product->getOriginal('code') . ')'
            . ' Product price: ' . $this->product->price . '(' . $this->product->getOriginal('price') . ')'
            . ' Product purchase_price: ' . $this->product->purchase_price . '(' . $this->product->getOriginal('purchase_price') . ')'
            . ' Product remainder: ' . $this->product->remainder . '(' . $this->product->getOriginal('remainder') . ')'
            . ' Product status: ' . trans_choice('admin.product_status', $this->product->status)
            . '(' . trans_choice('admin.product_status', $this->product->getOriginal('status'))  . ')'
        );
    }
}
