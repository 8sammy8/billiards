<?php

namespace App\Domain\Orders\Events;

use App\Domain\Orders\Models\OrderProduct;
use Illuminate\Foundation\Events\Dispatchable;

class OrderProductRefundEvent
{
    use Dispatchable;

    /**
     * @var OrderProduct
     */
    public $orderProduct;

    /**
     * OrderProductRefundEvent constructor.
     * @param OrderProduct $orderProduct
     */
    public function __construct(OrderProduct $orderProduct)
    {
        $this->orderProduct = $orderProduct;
    }
}
