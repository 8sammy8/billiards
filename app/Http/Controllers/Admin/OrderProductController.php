<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Orders\Events\OrderProductRefundEvent;
use App\Domain\Orders\Models\Order;
use App\Domain\Orders\Models\OrderProduct;
use App\Domain\Orders\Repositories\OrderProductRepository;
use App\Domain\Orders\Requests\StoreOrderProductRequest;
use App\Domain\Products\Models\Product;
use App\Http\Controllers\Controller;

class OrderProductController extends Controller
{
    /**
     * @var OrderProductRepository
     */
    protected $productRepository;

    /**
     * OrderProductController constructor.
     * @param OrderProductRepository $productRepository
     */
    public function __construct(OrderProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display order products
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $orders = Order::orderProductsWithProducts()->active()->get();

        return view('admin.order-products.index', compact('orders'));
    }

    /**
     * Display form for order products
     *
     * @param int|null $order_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(?int $order_id = null)
    {
        if (request()->ajax() && request()->has('category_id')) {
            $products = Product::active()->where('category_id', (int)request()->get('category_id'))->get();
            return view('admin.order-products._order-products', compact('products'));
        }

        list($order, $categories) = $this->productRepository->createList((int)$order_id);

        return view('admin.order-products.create', compact('categories', 'order'));
    }

    /**
     * Store a newly created order products in storage.
     *
     * @param StoreOrderProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderProductRequest $request)
    {
        list($products, $orderProducts) = $this->productRepository->fillOrderProducts($request);

        if ($products && $orderProducts) {

            $order = $this->productRepository->getOrderStore($request);
            $order->orderTable()->saveMany($orderProducts);

            $this->productRepository->updateProductsQuantity($products);
        }
        $request->session()->flash('success', trans('admin.product_added_to_order'));

        return response()->noContent();
    }

    /**
     * Display form for refund
     *
     * @param int $order_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $order_id)
    {
        $order = Order::active()->with('products', 'orderProducts')->findOrFail($order_id);

        return view('admin.order-products.edit', compact('order'));
    }

    /**
     * Refund product
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refund(int $id)
    {
        $orderProduct = OrderProduct::with('order', 'product')->findOrFail($id);

        if($orderProduct->order->status === Order::ORDER_STATUS_CLOSED){
            return back()->with('error', trans('admin.order_already_closed'));
        }

        $orderProduct->return_status = OrderProduct::REFUNDED;
        $orderProduct->save();

        $orderProduct->product->remainder += $orderProduct->quantity;
        $this->productRepository->updateProductQuantity($orderProduct->product);

        event(new OrderProductRefundEvent($orderProduct));

        return back()->with('success', trans('admin.product_refunded'));
    }


    /**
     * Checkout for order products
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout(int $id)
    {
        $order = Order::activeProducts()->findOrFail($id);
        $order->total_amount = $order->orderProducts->sum('amount');
        $order->status = Order::ORDER_STATUS_CLOSED;
        $order->save();

        return redirect()->route('admin.order-products.index')
            ->with('success', trans('admin.order_closed'))
            ->with('print', route('admin.order.print', $order->id));
    }
}
