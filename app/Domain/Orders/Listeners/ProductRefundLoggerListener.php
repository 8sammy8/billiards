<?php

namespace App\Domain\Orders\Listeners;

use App\Domain\Orders\Events\OrderProductRefundEvent;
use App\Domain\Orders\Services\OrderProductRefundLoggerService;

class ProductRefundLoggerListener
{
    /**
     * @var OrderProductRefundLoggerService
     */
    private $orderProductRefundLoggerService;

    /**
     * ProductRefundLoggerListener constructor.
     * @param OrderProductRefundLoggerService $orderProductRefundLoggerService
     */
    public function __construct(OrderProductRefundLoggerService $orderProductRefundLoggerService)
    {
        $this->orderProductRefundLoggerService = $orderProductRefundLoggerService;
    }

    public function handle(OrderProductRefundEvent $event)
    {
        $this->orderProductRefundLoggerService->productRefund($event->orderProduct);
    }
}
