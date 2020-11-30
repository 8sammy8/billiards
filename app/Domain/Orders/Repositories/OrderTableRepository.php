<?php

namespace App\Domain\Orders\Repositories;

use App\Domain\HallGroups\Models\HallGroup;
use App\Domain\Orders\Models\Order;
use App\Domain\Orders\Models\OrderTable;
use App\Domain\Orders\Requests\StoreOrderTableRequest;
use App\Domain\Orders\Services\OrderTableService;
use App\Domain\Rates\Models\Rate;
use App\Domain\Tables\Models\Table;

class OrderTableRepository
{
    /**
     * @return array
     */
    public function indexList()
    {
        $hallGroups = HallGroup::with('tables')->get();
        $orders = Order::activeTables()->get();

        return [$hallGroups, $orders];
    }

    /**
     * @param int $id
     * @return array
     */
    public function createList(int $id)
    {
        /** @var Table $table */
        $table = Table::with('rates')->findOrFail($id);
        $rates = \Table::getTableRates($table->rates);

        return [$table, $rates];
    }

    /**
     * @param int $id
     * @return bool
     */
    public function getOrderOpened(int $id)
    {
        $orders = Order::activeTables()->get();
        $orderOpened = $orders->where('orderTable.table_id', $id)->first();

        return $orderOpened ? true : false;
    }

    /**
     * Get filled order table
     *
     * @param StoreOrderTableRequest $request
     * @return OrderTable
     */
    public function fillOrderTableStore(StoreOrderTableRequest $request)
    {
        $orderTable = new OrderTable();
        $tableService = new OrderTableService();

        if($request->get('limit') == OrderTable::LIMIT_TIME){
            list($end_at, $amount) = $tableService->calcLimitTime($request);
        }

        if($request->get('limit') == OrderTable::LIMIT_PRICE){
            list($end_at, $amount) = $tableService->calcLimitPrice($request);
        }

        $orderTable->end_at = $end_at ?? null;
        $orderTable->amount = $amount ?? 0;
        $orderTable->table_id = $request->get('table_id');
        $orderTable->start_at = now();
        $orderTable->limit = $request->get('limit');
        $orderTable->rate_id = $request->get('rate_id');

        return $orderTable;
    }

    /**
     * @param int $id
     * @return array
     */
    public function showList(int $id)
    {
        $order = Order::activeTables()->orderProductsWithProducts()->findOrFail($id);
        $table = Table::findOrFail($order->orderTable->table_id);
        $rate = Rate::findOrFail($order->orderTable->rate_id);

        return [$order, $table, $rate];
    }

    /**
     * Update order table for checkout
     *
     * @param Order $order
     * @return mixed
     */
    public function checkoutOrderTable(Order $order)
    {
        $tableService = new OrderTableService();

        $diffTime = \Table::getTimeDiffCarbon($order, now(), true);
        $amount = $tableService->calcLimitFree($diffTime, $order->orderTable->rate_id);

        $order->orderTable->update([
            'end_at' => now(),
            'amount' => $amount
        ]);

        return $amount;
    }
}
