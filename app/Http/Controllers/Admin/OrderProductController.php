<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Categories\Models\Category;
use App\Domain\Orders\Models\Order;
use App\Domain\Orders\Models\OrderProduct;
use App\Domain\Orders\Requests\StoreOrderProductRequest;
use App\Domain\Products\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderProductController extends Controller
{
    /**
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $orders = Order::orderProductsWithProducts()->active()->get();

        return view('admin.order-products.index', compact('orders'));
    }

    /**
     * @param int|null $order_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(?int $order_id = null)
    {
        if (request()->ajax()) {
            $products = Product::active()->where('category_id', request()->category_id)->get();
            return view('admin.order-products._order-products', compact('products'));
        }

        $order = $order_id ? Order::active()->with('table')->findOrFail($order_id) : '';
        $categories = Category::active()->activeProducts()->get();

        return view('admin.order-products.create', compact('categories', 'order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOrderProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderProductRequest $request)
    {
        $products = Product::whereIn('id', array_column($request->get('products'), 'id'))
            ->get()->keyBy('id');

        foreach($request->get('products') as $item) {
            $product = $products[$item['id']];
            if($product && $product->remainder >= $item['quantity']){
                $orderProduct = new OrderProduct();

                $orderProduct->product_id = $product->id;
                $orderProduct->quantity = $item['quantity'];
                $orderProduct->amount = $item['quantity'] * $product->price;
                $orderProduct->income = ($item['quantity'] * $product->price) - ($item['quantity'] * $product->purchase_price);

                $orderProducts[] = $orderProduct;
                $products[$item['id']]->remainder -= $item['quantity'];
            }
            unset($product);
        }

        if (isset($orderProducts) && !empty($orderProducts)) {
             if($request->get('order_id')) {
                 $order = Order::active()->findOrFail($request->get('order_id'));
             }
             else{
                 $order = new Order();
                 $order->user_id = auth()->id();
                 $order->save();
             }

            $order->orderTable()->saveMany($orderProducts);

            $products->each(function ($item) {
                $item->save();
            });
        }
        $request->session()->flash('success', 'Products add to order');

        return response()->noContent();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $order_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $order_id)
    {
        $order = Order::active()->with('products', 'orderProducts')->findOrFail($order_id);

        return view('admin.order-products.edit', compact('order'));
    }


    public function refund(int $id)
    {
        $orderProduct = OrderProduct::with('order', 'product')->findOrFail($id);

        if($orderProduct->order === Order::ORDER_STATUS_CLOSED){
            return back()->with('error', 'Order is closed!');
        }
        $orderProduct->product->remainder += $orderProduct->quantity;
        $orderProduct->product->save();

        $orderProduct->return_status = OrderProduct::REFUNDED;
        $orderProduct->save();

        return back()->with('success', 'Product is refunded!');
    }


    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout(int $id)
    {
        $order = Order::activeProducts()->findOrFail($id);
        $order->total_amount = $order->orderProducts->sum('amount');
        $order->status = Order::ORDER_STATUS_CLOSED;
        $order->save();

        return redirect()->route('admin.order-products.index')->with('Order closed');
    }
}
