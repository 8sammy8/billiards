@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> {{ isset($order->id) ? 'Order refund ' . $order->id : '' }}</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Products</h3>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered table-hover text-center">
                                <thead>
                                <tr>
                                    <th>Product code</th>
                                    <th>Product name</th>
                                    <th>Image</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody id="cart-body">
                                @if($order->orderProducts->isNotEmpty())
                                    @foreach($order->orderProducts as $orderProduct)
                                        <tr>
                                            <td>{{ \Table::getColByOrderProduct('code', $orderProduct, $order->products) }}</td>
                                            <td>{{ \Table::getColByOrderProduct('name', $orderProduct, $order->products) }}</td>
                                            <td><img height="50%" src="{{ \Table::getColByOrderProduct('img', $orderProduct, $order->products) }}"/></td>
                                            <td>{{ $orderProduct->quantity }}</td>
                                            <td>{{ money($orderProduct->amount) }}</td>
                                            <td>
                                                <a href="{{ route('admin.order-products.refund', $orderProduct->id) }}"
                                                onclick="confirm('Are you sure to refund the product?')">
                                                    <button class="btn btn-warning">
                                                        <i class="fas fa-backward"></i>
                                                        Refund
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
