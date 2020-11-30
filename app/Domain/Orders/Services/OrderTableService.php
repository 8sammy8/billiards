<?php

namespace App\Domain\Orders\Services;

use App\Domain\Orders\Requests\StoreOrderTableRequest;
use App\Domain\Rates\Models\Rate;

class OrderTableService
{
    /**
     * Get end time of game and calculate price
     *
     * @param StoreOrderTableRequest $request
     * @return array
     */
    public function calcLimitTime(StoreOrderTableRequest $request)
    {
        $hour = (int)$request->get('limit_hour');
        $hour = $hour ? (int)$hour * 60 : 0;
        $min = (int)$request->get('limit_min');

        $end_at = now()->addMinutes($hour + $min);

        $ratePrice = $this->getRatePriceById((int)$request->get('rate_id'));
        $amount = \Table::moneyRound($ratePrice / 60 * ($hour + $min));

        return [$end_at, $amount];
    }

    /**
     * Get price and calculate end time of game
     *
     * @param StoreOrderTableRequest $request
     * @return array
     */
    public function calcLimitPrice(StoreOrderTableRequest $request)
    {
        $ratePrice = $this->getRatePriceById((int)$request->get('rate_id'));
        $amount = (int)$request->get('limit_price');
        $end_at = now()->addMinutes($amount / $ratePrice * 60);

        return [$end_at, $amount];
    }

    /**
     * Calculate price for unlimited game
     *
     * @param $diffTime
     * @param int $rate_id
     * @return mixed
     */
    public function calcLimitFree($diffTime, int $rate_id)
    {
        $ratePrice = $this->getRatePriceById($rate_id);

        $minutes = ($diffTime->d > 0 ? $diffTime->d * 1440 : 0)
            + ($diffTime->hours > 0 ? $diffTime->hours * 60 : 0)
            + $diffTime->minutes;
        return \Table::moneyRound($ratePrice / 60 * $minutes);
    }

    /**
     * @param int $id
     * @return int
     */
    protected function getRatePriceById(int $id)
    {
        return (int)Rate::findOrFail($id)->price;
    }
}
