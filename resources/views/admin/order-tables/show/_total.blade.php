<div class="row">
    <div class="col-6">
    </div>
    <div class="col-6">
        <p class="lead">{{ trans('admin.amount_due') . ' ' . now()->format('d-m-Y') }}</p>

        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th style="width:50%">@lang('admin.billiards'):</th>
                    <td id="total-table" data-total-table-amount="{{ $order->orderTable->amount }}">
                        {{ money($order->orderTable->amount) }}
                    </td>
                </tr>
                <tr>
                    <th>@lang('admin.order_products'):</th>
                    <td id="total-bar" data-total-bar-amount="{{ $order->orderProducts->sum('amount') }}">{{ money($order->orderProducts->sum('amount')) }}</td>
                </tr>
                <tr>
                    <th>@lang('admin.total'):</th>
                    <td id="total-amount" data-total-amount=""></td>
                </tr>
            </table>
        </div>
    </div>
</div>
