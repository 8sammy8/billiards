<div class="card">
    <div class="card-header">
        <h3 class="card-title">Main information</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped text-center">
            <tbody>
            <thead>
            <tr>
                <th>Hall group</th>
                <th>Current rate</th>
                <th>Rate price</th>
                <th>Rate time</th>
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
