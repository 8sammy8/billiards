<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Orders\Models\Order;
use App\Http\Controllers\Controller;

class ReportTableController extends Controller
{
    /**
     * List of cash desks by operators.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $orders = Order::orderTableWithTable()
            ->has('orderTable')
            ->closed()
            ->notReceipted()
            ->with('orderProducts' ,'products', 'user')
            ->get();

        return view('admin.report-table.index', compact('orders'));
    }

    /**
     * Cash withdrawal.
     *
     * @param int $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pass(int $user_id)
    {
        $orders = Order::orderTableWithTable()
            ->has('orderTable')
            ->closed()
            ->notReceipted()
            ->where('user_id', $user_id)
            ->get();

        if ($orders) {
            $orders->each(function ($order) {
                $order->cashbox = Order::CASHBOX_CLOSED;
                $order->save();
            });
        }

        return redirect()->route('admin.home')->with('success', trans('admin.checkout_withdrawn'));
    }
}
