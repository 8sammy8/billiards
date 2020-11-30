<?php

namespace App\Domain\Orders\Services;

use App\Domain\Orders\Models\OrderProduct;

class OrderProductRefundLoggerService
{
    public function productRefund(OrderProduct $orderProduct)
    {
        \Log::channel('products')->info(
            'Product refunded ID: ' . $orderProduct->product_id
            . ' Product name: ' . $orderProduct->product->name
            . ' Product Code: ' . $orderProduct->product->code
            . ' Refund quantity: ' . $orderProduct->quantity
            . ' Refund amount: ' . $orderProduct->amount
            . ' Refund income: ' . $orderProduct->income
        );
    }
}
