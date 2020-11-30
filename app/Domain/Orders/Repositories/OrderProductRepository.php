<?php

namespace App\Domain\Orders\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Domain\Categories\Models\Category;
use App\Domain\Orders\Models\Order;
use App\Domain\Orders\Models\OrderProduct;
use App\Domain\Orders\Requests\StoreOrderProductRequest;
use App\Domain\Products\Models\Product;

class OrderProductRepository
{
    /**
     * @param int $order_id
     * @return array
     */
    public function createList(int $order_id)
    {
        $order = $order_id ? Order::active()->with('table')->findOrFail($order_id) : '';
        $categories = Category::active()->activeProducts()->get();

        return [$order, $categories];
    }

    /**
     * Get order product and fill orderProduct
     *
     * @param StoreOrderProductRequest $request
     * @return array
     */
    public function fillOrderProducts(StoreOrderProductRequest $request)
    {
        $products = Product::whereIn('id', array_column($request->get('products'), 'id'))
            ->get()->keyBy('id');

        foreach($request->get('products') as $item) {
            $product = $products[$item['id']];
            if($product && $product->remainder >= $item['quantity']){
                $orderProduct = new OrderProduct();

                $orderProduct->product_id = $product->id;
                $orderProduct->quantity = $item['quantity'];
                $orderProduct->amount = $item['quantity'] * $product->price;
                $orderProduct->income = ($item['quantity'] * $product->price) - ($item['quantity'] * $product->purchase_price);

                $orderProducts[] = $orderProduct;
                $products[$item['id']]->remainder -= $item['quantity'];
            }
            unset($product);
        }

        return [$products, $orderProducts ?? false];
    }

    /**
     * Get order or create for store order product
     *
     * @param StoreOrderProductRequest $request
     * @return Order|Order[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getOrderStore(StoreOrderProductRequest $request)
    {
        if($request->get('order_id')) {
            $order = Order::active()->findOrFail($request->get('order_id'));
        }
        else{
            $order = new Order();
            $order->user_id = auth()->id();
            $order->save();

        }
        return $order;
    }

    /**
     * Update collection products quantity with out event
     *
     * @param Collection $products
     * @return void
     */
    public function updateProductsQuantity(Collection $products):void
    {
        $products->each(function ($product) {
            $this->updateProductQuantity($product);
        });
    }

    /**
     * Update product quantity with out event
     *
     * @param Product $product
     * @return void
     */
    public function updateProductQuantity(Product $product):void
    {
        $product::withoutEvents(function ()use($product){
            $product->update();
        });
    }
}
