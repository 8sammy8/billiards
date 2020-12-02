@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('admin.order_products')</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <a href="{{ route('admin.order-products.create') }}">
                                    <button type="button" class="btn btn-block btn-primary btn-sm">
                                        <i class="fas fa-plus"></i>
                                        @lang('admin.add')
                                    </button>
                                </a>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover text-center">
                                <thead>
                                <tr>
                                    <th>@lang('admin.order_id')</th>
                                    <th>@lang('admin.product_name')</th>
                                    <th>@lang('admin.status')</th>
                                    <th>@lang('admin.price')</th>
                                    <th>@lang('admin.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    @if(!$order->orderTable && $order->orderProducts->isNotEmpty())
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td class="text-left">{{ $order->products->implode('name', ', ') }}</td>
                                            <td>{{ trans_choice('admin.order_status', $order->status) }}</td>
                                            <td>{{ money($order->orderProducts->sum('amount')) }}</td>
                                            <td>
                                                <a class="btn btn-info btn-sm mr-2" href="{{ route('admin.order-products.create', $order->id) }}">
                                                    <i class="fas fa-plus"></i>
                                                    @lang('admin.add')
                                                </a>
                                                <a class="btn btn-warning btn-sm mr-2" href="{{ route('admin.order-products.edit', $order->id) }}">
                                                    <i class="fas fa-backward"></i>
                                                    @lang('admin.refund')
                                                </a>
                                                <a class="btn btn-danger btn-sm" href="{{ route('admin.order-products.checkout', $order->id) }}">
                                                    <i class="fas fa-lock"></i>
                                                    @lang('admin.checkout')
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
