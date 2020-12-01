@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Table reports</h1>
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
                                                    <th>Date</th>
                                                    <th>Order Id</th>
                                                    <th>Table name</th>
                                                    <th width="15%">Products</th>
                                                    <th>Start time</th>
                                                    <th>End time</th>
                                                    <th>During time</th>
                                                    <th>Table price</th>
                                                    <th>Products price</th>
                                                    <th>Total price</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($operatorOrders->sortDesc() as $order)
                                                <tr>
                                                    <td>{{ $order->created_at->format('d-m-y') }}</td>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->table->name }}</td>
                                                    <td class="text-left">{{ $order->products->implode('name', ',') }}</td>
                                                    <td>{{ $order->orderTable->start_at->format('H:i') }}</td>
                                                    <td>{{ $order->orderTable->end_at->format('H:i') }}</td>
                                                    <td>{{ \Table::getTimeLimit($order) }}</td>
                                                    <td>{{ $order->orderTable->amount }}</td>
                                                    <td>{{ $order->orderProducts ? $order->orderProducts->sum('amount') :'' }}</td>
                                                    <td>{{ money($order->total_amount) }}</td>
                                                    <td>
                                                        <a class="btn btn-warning btn-sm" href="{{ route('admin.order.print', $order->id) }}" target="_blank">
                                                            <i class="fas fa-print"></i>
                                                            Print
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
                                <th>Total: {{ money($operatorOrders->sum('total_amount')) }}</th>
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
                                <i class="far fa-credit-card"></i> Pass of
                            </button>
                        </a>
                    </div>
                </div>
            @endif
        </div>

    </section>
    @endforeach
@endsection
