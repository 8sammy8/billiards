<?php

namespace App\Domain\Rates\Services;

use App\Domain\Orders\Models\Order;
use App\Domain\Rates\Models\Rate;
use Illuminate\Database\Eloquent\Builder;

class RateService
{
    /**
     * Check table busy rates
     *
     * @param Rate $rate
     * @return bool
     */
    public function canChange(Rate $rate):bool
    {
        $orders = Order::active()->whereHas('orderTable', function (Builder $query) use ($rate){
                $query->where('rate_id', $rate->id);
            })->get();

        return $orders->isEmpty();
    }
}
