@extends('layouts.print')
<?php
/* @var App\Domain\Orders\Models\Order $order */
?>
@section('content')
<table>
    @if ($order->orderTable)
        <tr>
            <td>{{ $order->orderTable->end_at->format('d.m.Y') }}</td>
        </tr>
    @endif
        <tr>
            <td>***** {{ env('APP_NAME', 'Billiards') }} *****</td>
        </tr>
        <tr>
            <td> {{ config('settings.print.bill') }} № {{ $order->id }}</td> <td> {{ $order->table->name ?? "" }}</td>
        </tr>
    @if ($order->orderTable)
        <tr>
            <td>{{ config('settings.print.cost_1_hour') }}: </td><td> {{ money($order->orderTable->rate->price) }}</td>
        </tr>
        <tr>
            <td>{{ config('settings.print.game_start_time') }}: </td><td> {{ $order->orderTable->start_at->format('H:i') }}</td>
        </tr>
        <tr>
            <td>{{ config('settings.print.game_end_time') }}:</td><td> {{ $order->orderTable->end_at->format('H:i') }}</td>
        </tr>
    @endif

    <tr>
        <td>*****   {{ config('settings.print.bar') }}   *****</td>
    </tr>
    <tr>
        <td>{{ config('settings.print.name') }} : </td><td> {{ config('settings.print.amount') }}</td>
    </tr>
    @if ($order->orderProducts->isNotEmpty())
        @foreach($order->orderProducts as $orderProduct)
        <tr>
            <td>{{ \Table::getColByOrderProduct('name', $orderProduct, $order->products )}} x {{ $orderProduct->quantity }}</td>
            <td> {{ money($orderProduct->amount) }}</td>
        </tr>
        @endforeach
    @endif
    <tr>
        <td>*****  {{ config('settings.print.total') }}  *****</td>
    </tr>
    <tr>
        <td>{{ config('settings.print.bar_amount') }}: </td><td> {{ money($order->orderProducts->sum('amount')) }}</td>
    </tr>
    @if ($order->orderTable)
        <tr>
            <td>{{ config('settings.print.billiards_amount') }} : </td><td> {{ money($order->orderTable->amount) }}</td>
        </tr>
    @endif
    @if ($order->orderTable)
    <tr>
        <td>{{ config('settings.print.total_amount') }}: </td><td> {{ money($order->orderProducts->sum('amount') + $order->orderTable->amount) }}</td>
    @else
        <tr>
            <td>{{ config('settings.print.total_amount') }}:</td><td> {{ money($order->orderProducts->sum('amount')) }}</td>
    @endif

    </tr>

</table>
@endsection

@push('styles')
    <style>
        table {
            font-family: sans-serif;
            font-size: 12px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function () {
           window.print()
        })
    </script>
@endpush

