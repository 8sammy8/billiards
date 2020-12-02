@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('admin.invoice_information'): {{ $table->name }} </h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    @include('admin.order-tables.show._main-service')

                    @include('admin.order-tables.show._bar')
                </div>

                <div class="col-md-6">
                    @include('admin.order-tables.show._main-information')

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('admin.time_limit'): <span class="text-danger">
                                    {{ \Table::getTimeLimit($order) ?? trans('admin.no') }}</span>
                            </h3>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('admin.time_over_lead'):
                                <span class="text-danger" id="left-time"> </span>
                            </h3>
                        </div>
                    </div>

                    <div class="invoice p-3 mb-3">

                        @include('admin.order-tables.show._total')

                        <div class="row no-print">
                            <div class="col-12">
                                <button type="button" class="btn btn-danger float-right" id="checkout"
                                        data-url="{{ route('admin.order-tables.checkout', $order->id) }}">
                                    <i class="far fa-credit-card"></i> @lang('admin.checkout')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/admin-lte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('money.js') }}"></script>
    <script>
        $(document).ready(function () {
                var alerted = false;
                var main_service = $('#main_service');
                var time_diff = 0;
                var table_price = 0;

                if (!main_service.data('end-time')) {

                    endNow();
                    var rate_price = main_service.data('rate-price');
                    var start_time = new Date(main_service.data('start-time'));
                    var rate_per_min = new Date(rate_price / 60);

                    setInterval(function () {
                        $('#limit-time').text(timeDiff(start_time));
                        table_price = Math.floor(time_diff / 1000 / 60)  * rate_per_min;
                        var table_price_amount = moneyFormat(moneyRound(table_price));
                        $('#table-price').text(table_price_amount);

                        $('#total-table').text(table_price_amount);

                        $('#total-table').data('total-table-amount', moneyRound(table_price));
                    }, 1000);
                    setInterval(function () {
                        totalCalculation()
                    }, 1000);
                }

                totalCalculation();

                function totalCalculation(){
                    var total_table_amount = $('#total-table').data('total-table-amount') ?? 0;
                    var total_bar_amount = $('#total-bar').data('total-bar-amount') ?? 0;
                    var total_amount = total_table_amount + total_bar_amount;

                    $('#total-amount').data('total-amount', total_amount);
                    $('#total-amount').text(moneyFormat(total_amount));
                }

                /** If free time  end */
                function endNow() {
                    var timeNode = document.getElementById('end-time');

                    function getCurrentTimeString() {
                        return new Date().toTimeString().replace(/ .*/, '');
                    }

                    setInterval(
                        () => timeNode.innerHTML = getCurrentTimeString(),
                        1000
                    );
                }

                if (main_service.data('end-time')) {
                    var end_date = new Date(main_service.data('end-time'));
                    doCountDown(end_date, main_service);
                    alerted = ((end_date.getTime() - new Date().getTime()) > 0) ? true : false;
                    if (!alerted) {
                        showTimeIsOutAlert(main_service.data('name-table'))
                    }
                }

                function doCountDown(target, main_service) {
                    window.setInterval(function () {
                        var left_time = timeDiff(target);
                        if (left_time === '00:00:00' && alerted === false) {
                            alerted = true;
                            showTimeIsOutAlert(main_service.data('name-table'))
                        }
                        $('#left-time').text(left_time);
                    }, 1000);

                    var lag = 1020 - (new Date() % 100);
                    setTimeout(function () {
                        doCountDown(target);
                    }, lag);
                }

                function showTimeIsOutAlert(table_name) {
                    window.setInterval(function () {
                        toastr.error('{{ __('admin.time_is_out') }}' + table_name + '!')
                    }, 15000);
                }

                function timeDiff(target) {
                    function z(n) {
                        return (n < 10 ? '0' : '') + n;
                    }

                    time_diff = target - (new Date());
                    var hours = Math.abs(time_diff / 3.6e6 | 0);
                    var minutes = Math.abs(time_diff % 3.6e6 / 6e4 | 0);
                    var seconds = Math.abs(time_diff % 6e4 / 1e3 | 0);

                    return z(hours) + ':' + z(minutes) + ':' + z(seconds);
                }

            $('#checkout').on('click', function () {
                var total_amount = $('#total-amount').data('total-amount') ?? 0;

                if (total_amount && confirm('Are you sure?')) {
                    return window.location.href = $('#checkout').data('url');
                }
                return false;
            });
            }
        )
    </script>
@endpush
