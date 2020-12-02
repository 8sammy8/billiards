<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('admin.main_information')</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped text-center">
            <tbody>
            <thead>
            <tr>
                <th>@lang('admin.hall_group')</th>
                <th>@lang('admin.current_rate')</th>
                <th>@lang('admin.rate_price')</th>
                <th>@lang('admin.rate_time')</th>
            </tr>
            </thead>
            <tr>
                <td> {{ $rate->hallGroup->name }} </td>
                <td> {{ $rate->name }} </td>
                <td> <span class="badge bg-danger"> {{ money($rate->price) }} </span> </td>
                <td> {{ $rate->start_at->format('H:i') . " - " . $rate->end_at->format('H:i')  }} </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
