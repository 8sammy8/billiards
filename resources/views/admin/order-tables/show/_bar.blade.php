<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('admin.order_products')</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered text-center">
            <thead>
            <tr>
                <th>@lang('admin.product_name')</th>
                <th>@lang('admin.quantity')</th>
                <th>@lang('admin.image')</th>
                <th>@lang('admin.price')</th>
                <th>@lang('admin.action')</th>
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
                           onclick="if(!confirm('{{ trans('admin.sure_to_refund_product') }}')){ return false;}">
                            <button class="btn btn-warning btn-sm">
                                <i class="fas fa-backward"></i>
                                @lang('admin.refund')
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
            <button type="submit" class="btn btn-success">+ @lang('admin.product')</button>
        </a>
    </div>
</div>
