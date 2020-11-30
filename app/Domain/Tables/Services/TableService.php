<?php

namespace App\Domain\Tables\Services;

use App\Domain\Orders\Models\Order;
use App\Domain\Orders\Models\OrderProduct;
use App\Domain\Tables\Models\Table;
use Illuminate\Database\Eloquent\Collection;

class TableService
{
    /**
     * Get suitable table rates
     *
     * @param Collection $rates
     * @return array|Collection|\Illuminate\Support\Collection
     */
    public function getTableRates(Collection $rates)
    {
        $tableRates = [];

        if($rates && $rates->count()){
            $tableRates = $rates->map(function($rate) {
                $now = now();
                $start = $rate->start_at;
                $end = $rate->end_at;

                if($start == $end){
                    $end->addDay();
                }
                if($start->lte($now) && $end->gte($now)){
                    return $rate;
                }
            });
        }
        return $tableRates;
    }
    /**
     * Get table button css class for creating or showing an order
     *
     * @param Table $table
     * @param Collection $orders
     * @return string
     */
    public function getCssClass(Table $table, Collection $orders):string
    {
        /** @var Order $order */
        $order = $orders->where('orderTable.table_id', $table->id)->first();

        if ($order) {
            if ($order->orderTable->limit == config('settings.order_table_limits.LIMIT_FREE')) {
                return 'success';
            }
            if (now()->gte($order->orderTable->end_at)) {
                return 'danger';
            }
            return 'success';
        }
        return 'default';
    }

    /**
     * Get table url for creating or showing an order
     *
     * @param Table $table
     * @param Collection $orders
     * @return string
     */
    public function getUrl(Table $table, Collection $orders):string
    {
        /** @var Order $order */
        $order = $orders->where('orderTable.table_id', $table->id)->first();

        return $order ? route('admin.order-tables.show', $order->id) : route('admin.order-tables.create', $table->id);
    }

    /**
     * Get time ends for play other than unlimited time
     *
     * @param Table $table
     * @param Collection $orders
     * @return \Illuminate\Support\Carbon|mixed|null
     */
    public function getEndTime(Table $table, Collection $orders)
    {
        /** @var Order $order */
        $order = $orders->where('orderTable.table_id', $table->id)->first();

        if ($order) {
            if (!$order->orderTable->limit == config('settings.order_table_limits.LIMIT_FREE')) {
                return $order->orderTable->end_at;
            }
        }
    }

    /**
     * Get the difference as a CarbonInterval instance.
     *
     * @param Order $order
     * @param false $end_at
     * @param false $force
     * @return \Carbon\CarbonInterval
     */
    public function getTimeDiffCarbon(Order $order, $end_at = false, $force = false)
    {
        if (!$order->orderTable->limit == config('settings.order_table_limits.LIMIT_FREE') || $force) {
            $end_at = $end_at ? $end_at : $order->orderTable->end_at;
            return $end_at->diffAsCarbonInterval($order->orderTable->start_at);
        }
    }

    /**
     * Get time limit in 00:00 format
     *
     * @param Order $order
     * @return string|null
     */
    public function getTimeLimit(Order $order)
    {
        $diff = $this->getTimeDiffCarbon($order);

        return $diff ? $this->addZero($diff->hours) . ":" . $this->addZero($diff->minutes) : null;
    }

    /**
     * Add 0 if less than 10
     *
     * @param int $number
     * @return string
     */
    public function addZero(int $number):string
    {
        return $number < 10 ? '0'. $number : $number;
    }

    /**
     * Round off the price in hundredths to 500
     *
     * @param $amount
     * @return float|int
     */
    public function moneyRound($amount)
    {
        return (int)round(abs($amount) / 500, 0, PHP_ROUND_HALF_UP) * 500;
    }

    /**
     * Get column value of product through the order product
     *
     * @param string $col
     * @param OrderProduct $orderProduct
     * @param Collection $products
     * @return mixed
     */
    public function getColByOrderProduct(string $col, OrderProduct $orderProduct, Collection $products)
    {
        return $products->where('id', $orderProduct->product_id)->first()->$col;
    }
}
