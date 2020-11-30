<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Orders\Models\Order;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Print a payment receipt.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function print(int $id)
    {
        $order = Order::closed()->findOrFail($id);
        $order->load('orderTable', 'orderProducts', 'table', 'orderTable.rate', 'products');

        return view('admin.order.print', compact('order'));
    }
}
