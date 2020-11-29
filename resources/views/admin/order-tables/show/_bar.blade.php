<div class="card">
    <div class="card-header">
        <h3 class="card-title">Bar</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered text-center">
            <thead>
            <tr>
                <th>Product name</th>
                <th>Quantity</th>
                <th>Image</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->orderProducts as $orderProduct)
                <tr>
                    <td>{{ \Table::getColByOrderProduct('name', $orderProduct, $order->products) }}</td>
                    <td>{{ $orderProduct->quantity }}</td>
                    <td><img height="35%" src="{{ \Table::getColByOrderProduct('img', $orderProduct, $order->products) }}" ></td>
                    <td>{{ money($orderProduct->amount) }}</td>
                    <td>
                        <a href="{{ route('admin.order-products.refund', $orderProduct->id) }}"
                           onclick="confirm('Are you sure to refund the product?')">
                            <button class="btn btn-warning btn-sm">
                                <i class="fas fa-backward"></i>
                                Refund
                            </button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <a href="{{ route('admin.order-products.create', $order->id) }}">
            <button type="submit" class="btn btn-success">+ product</button>
        </a>
    </div>
</div>
