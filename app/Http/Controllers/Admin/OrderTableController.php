<?php

namespace App\Http\Controllers\Admin;

use App\Domain\HallGroups\Models\HallGroup;
use App\Domain\Orders\Models\Order;
use App\Domain\Orders\Models\OrderTable;
use App\Domain\Orders\Requests\StoreOrderTableRequest;
use App\Domain\Rates\Models\Rate;
use App\Domain\Tables\Models\Table;
use App\Http\Controllers\Controller;

class OrderTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $hallGroups = HallGroup::with('tables')->get();

        $orders = Order::activeTables()->get();

        return view('admin.order-tables.index', compact('hallGroups', 'orders'));
    }

    public function create($id)
    {
        $table = Table::with('rates')->findOrFail($id);
        $rates = [];
        if($table->rates->count()){
            $rates = $table->rates->map(function($rate) {
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

        return view('admin.order-tables.create', compact('table', 'rates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOrderTableRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreOrderTableRequest $request)
    {
        $orders = Order::activeTables()->get();
        $orderOpened = $orders->where('orderTable.table_id', $request->get('table_id'))->first();

        if ($orderOpened) {
            redirect()->route('admin.order-tables.index')
                ->with('warning', 'The time is already open!');
        }
        unset($orders, $orderOpened);

        $orderTable = new OrderTable();
        $orderTable->table_id = $request->get('table_id');
        $orderTable->start_at = now();

        if($request->get('limit') == OrderTable::LIMIT_TIME){
            $hour = (int)$request->get('limit_hour');
            if($hour){
                $hour*= 60;
            }
            $min = (int)$request->get('limit_min');
            $orderTable->end_at = now()->addMinutes($hour + $min);

            $rate = Rate::findOrFail($request->get('rate_id'));
            $orderTable->amount = intval($rate->price / 60 * ($hour + $min));
        }
        if($request->get('limit') == OrderTable::LIMIT_PRICE){
            $rate = Rate::findOrFail($request->get('rate_id'));
            $amount = (int)$request->get('limit_price');
            $orderTable->amount = $amount;
            $orderTable->end_at = now()->addMinutes($amount / $rate->price * 60);
        }

        $orderTable->limit = $request->get('limit');
        $orderTable->rate_id = $request->get('rate_id');

        $order = new Order();
        $order->user_id = auth()->id();
        $order->save();

        $order->orderTable()->save($orderTable);

        return redirect()->route('admin.order-tables.index')
            ->with('success', 'Open time');
    }

    public function show(int $id)
    {
        $order = Order::activeTables()->orderProductsWithProducts()->findOrFail($id);

        $table = Table::findOrFail($order->orderTable->table_id);
        $rate = Rate::findOrFail($order->orderTable->rate_id);

        return view('admin.order-tables.show.show', compact('table', 'order', 'rate'));
    }

    public function checkout(int $id)
    {
        $order = Order::with('orderTable', 'orderProducts')->findOrFail($id);

        if ($order->status == Order::ORDER_STATUS_CLOSED) {
            return redirect()->route('admin.order-tables.index')
                ->with('error', 'Order is already closed!');
        }

        if($order->orderTable->limit === OrderTable::LIMIT_FREE){
            $rate = Rate::findOrFail($order->orderTable->rate_id);

            $diffTime = \Table::getTimeDiffCarbon($order, now(), true);
            $minutes = ($diffTime->d > 0 ? $diffTime->d * 1440 : 0)
                + ($diffTime->hours > 0 ? $diffTime->hours * 60 : 0)
                + $diffTime->minutes;
            $tableAmount = \Table::moneyRound($rate->price / 60 * $minutes);
            $orderTable['end_at'] = now();
            $orderTable['amount'] = $tableAmount;
            $order->orderTable->update($orderTable);
        }

        $order->total_amount = $order->orderTable->amount + $order->orderProducts->sum('amount');
        $order->status = Order::ORDER_STATUS_CLOSED;

        $order->save();

        return redirect()->route('admin.order-tables.index')->with('Order closed');
    }
}
