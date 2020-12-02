<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('admin.billiards')</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered text-center" id="main_service"
               data-start-time="{{ $order->orderTable->start_at }}"
               data-end-time="{{ $order->orderTable->end_at ?? "" }}"
               data-limit-time="{{ \Table::getTimeLimit($order) ?? "" }}"
               data-name-table="{{ $table->name }}"
               data-rate-price="{{ $rate->price }}"
        >
        <thead>
        <tr>
            <th>@lang('admin.game_started')</th>
            <th>@lang('admin.game_time')</th>
            <th>@lang('admin.end_of_game')</th>
            <th>@lang('admin.price')</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $order->orderTable->start_at->format('H:i') }}</td>
            <td id="limit-time">{{ \Table::getTimeLimit($order) ?? trans('admin.no') }}</td>
            <td id="end-time">{{ $order->orderTable->end_at ? $order->orderTable->end_at->format('H:i') : '' }}</td>
            <td> <span id="table-price" class="badge bg-danger">{{ money($order->orderTable->amount) }}</span></td>
        </tr>
        </tbody>
        </table>
    </div>
</div>
