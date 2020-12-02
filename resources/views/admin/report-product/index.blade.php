@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('admin.product_reports')</h1>
                </div>
            </div>
        </div>
    </section>

    @foreach($orders->groupBy('user_id') as $operatorOrders)
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <h3>
                                        {{ $operatorOrders->first()->user->name }}
                                    </h3>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="example1"
                                               class="table table-bordered table-striped dataTable dtr-inline text-center"
                                               role="grid" aria-describedby="example1_info">
                                            <thead>
                                                <tr role="row">
                                                    <th>@lang('admin.date')</th>
                                                    <th>@lang('admin.order_id')</th>
                                                    <th width="15%">@lang('admin.products')</th>
                                                    @if (auth()->user()->isAdmin())
                                                        <th>@lang('admin.products_income')</th>
                                                    @endif
                                                    <th>@lang('admin.products_price')</th>
                                                    <th>@lang('admin.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($operatorOrders->sortDesc() as $order)
                                                <tr>
                                                    <td>{{ $order->created_at->format('d-m-y H:i') }}</td>
                                                    <td>{{ $order->id }}</td>
                                                    <td class="text-left">{{ $order->products->implode('name', ',') }}</td>
                                                    @if (auth()->user()->isAdmin())
                                                        <td>{{ money($order->orderProducts->sum('income')) }}</td>
                                                    @endif
                                                    <td>{{ money($order->total_amount) }}</td>
                                                    <td>
                                                        <a class="btn btn-warning btn-sm" href="{{ route('admin.order.print', $order->id) }}" target="_blank">
                                                            <i class="fas fa-print"></i>
                                                            @lang('admin.print')
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                                <th>@lang('admin.total'): {{ money($operatorOrders->sum('total_amount')) }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            @if (auth()->user()->isAdmin())
                <div class="row no-print mb-5">
                    <div class="col-12">
                        <a href="{{ route('admin.reports-table.pass', $operatorOrders->first()->user_id) }}">
                            <button type="button" class="btn btn-danger float-left">
                                <i class="far fa-credit-card"></i> @lang('admin.pass_of')
                            </button>
                        </a>
                    </div>
                </div>
            @endif
        </div>

    </section>
    @endforeach
@endsection
