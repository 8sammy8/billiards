@extends('layouts.print')
<?php
/* @var App\Domain\Orders\Models\Order $order */
?>
@section('content')
{{--    @dump($order)--}}
<table>
    @if ($order->orderTable)
        <tr>
            <td>{{ $order->orderTable->end_at->format('d.m.Y') }}</td>
        </tr>
    @endif
        <tr>
            <td>*********** {{ env('APP_NAME', 'Billiards') }} *************</td>
        </tr>
        <tr>
            <td> Счет № {{ $order->id }}</td> <td> {{ $order->table->name ?? "" }}</td>
        </tr>
    @if ($order->orderTable)
        <tr>
            <td>Стоимость 1 час игры: </td><td> {{ money($order->orderTable->rate->price) }}</td>
        </tr>
        <tr>
            <td>Время начало игры: </td><td> {{ $order->orderTable->start_at->format('H:i') }}</td>
        </tr>
        <tr>
            <td>Окончание времени: </td><td> {{ $order->orderTable->end_at->format('H:i') }}</td>
        </tr>
    @endif

    <tr>
        <td>*****************   Бар   *****************</td>
    </tr>
    <tr>
        <td>Наименование: </td><td> Сумма</td>
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
        <td>*****************  Итого  *****************</td>
    </tr>
    <tr>
        <td>Сумма по бару: </td><td> {{ money($order->orderProducts->sum('amount')) }}</td>
    </tr>
    @if ($order->orderTable)
        <tr>
            <td>Сумма по бильярду: </td><td> {{ money($order->orderTable->amount) }}</td>
        </tr>
    @endif
    @if ($order->orderTable)
    <tr>
        <td>Сумма к оплате: </td><td> {{ money($order->orderProducts->sum('amount') + $order->orderTable->amount) }}</td>
    @else
        <tr>
            <td>Сумма к оплате: </td><td> {{ money($order->orderProducts->sum('amount')) }}</td>
    @endif

    </tr>

</table>
@endsection

@push('styles')
    <style>
        table {
            font-family: sans-serif;
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

