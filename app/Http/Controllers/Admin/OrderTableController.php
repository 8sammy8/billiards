<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domain\Orders\Models\Order;
use App\Domain\Orders\Models\OrderTable;
use App\Domain\Orders\Repositories\OrderTableRepository;
use App\Domain\Orders\Requests\StoreOrderTableRequest;

class OrderTableController extends Controller
{
    /**
     * @var OrderTableRepository
     */
    protected $repository;

    /**
     * OrderTableController constructor.
     * @param OrderTableRepository $orderTableRepository
     */
    public function __construct(OrderTableRepository $orderTableRepository)
    {
        $this->repository = $orderTableRepository;
    }

    /**
     * Display the entire list of active tables
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        list($hallGroups, $orders) = $this->repository->indexList();

        return view('admin.order-tables.index', compact('hallGroups', 'orders'));
    }

    /**
     * Show the form for creating an order for the table.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create($id)
    {
        list($table, $rates) = $this->repository->createList($id);

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
        $orderOpened = $this->repository->getOrderOpened((int)$request->get('table_id'));
        if ($orderOpened) {
            return redirect()->route('admin.order-tables.index')
                ->with('warning', 'The time is already open!');
        }

        $orderTable = $this->repository->fillOrderTableStore($request);

        $order = new Order();
        $order->user_id = auth()->id();
        $order->save();

        $order->orderTable()->save($orderTable);

        return redirect()->route('admin.order-tables.index')
            ->with('success', 'Open time');
    }

    /**
     * Display table by id
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(int $id)
    {
        list($order, $table, $rate) = $this->repository->showList($id);

        return view('admin.order-tables.show.show', compact('table', 'order', 'rate'));
    }

    /**
     * Checkout table by id
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout(int $id)
    {
        $order = Order::with('orderTable', 'orderProducts')->findOrFail($id);

        if ($order->status == Order::ORDER_STATUS_CLOSED) {
            return redirect()->route('admin.order-tables.index')
                ->with('error', 'Order is already closed!');
        }

        $amount = $order->orderTable->limit === OrderTable::LIMIT_FREE
            ? $this->repository->checkoutOrderTable($order)
            : $order->orderTable->amount;

        $order->total_amount = $amount + $order->orderProducts->sum('amount');
        $order->status = Order::ORDER_STATUS_CLOSED;

        $order->save();

        return redirect()->route('admin.order-tables.index')
            ->with('success', 'Order table closed')
            ->with('print', route('admin.order.print', $order->id));
    }
}
