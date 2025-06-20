@extends('layouts.print-theme')

@section('content')

    <!-- <title>{{-- ucfirst($type) --}} - Order #{{-- $order->order_number --}}</title> -->

<style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    .header, .footer { text-align: center; }
    .customer-info, .order-info { margin-bottom: 15px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px;}
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left;}
    th { background: #f5f5f5; }
    .totals { float: right; width: 300px; }
    .totals td { border: none; }
    .print-btn { margin-top: 20px; }
</style>


<div class="header">
    <h1>{{ strtoupper($type) }}</h1>
</div>

<div class="customer-info">
    <strong>Customer Information</strong><br>
    Name: {{ $order->customer->name ?? '' }}<br>
    Email: {{ $order->customer->email ?? '' }}<br>
    Phone: {{ $order->customer->telephoneno ?? '' }}<br>
    Address: {{ $order->customer->address ?? '' }}
</div>

<div class="order-info">
    <strong>Order Number:</strong> #{{ $order->order_number }}<br>
    <strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}<br>
    <strong>Status:</strong> {{ ucfirst($order->status) }}<br>
    <strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}<br><br>
    <strong>Date:</strong> {{ \Carbon\Carbon::parse(now())->format('d M Y') }}<br>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Car(s)</th>
            <th>Price(₦)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>
                    {{ $item->car->make ?? '' }} {{ $item->car->model ?? '' }}
                    @if(isset($item->car->year)) ({{ $item->car->year }}) @endif
                </td>
                <td>₦{{ number_format($item->price, 0, '.', ',') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<table class="totals">
    <tr>
        <td>Subtotal:</td>
        <td>₦{{ number_format($order->subtotal, 0, '.', ',') }}</td>
    </tr>
    <tr>
        <td>Discount ({{ $order->discount_percent }}%):</td>
        <td>-₦{{ number_format($order->discount_value, 0, '.', ',') }}</td>
    </tr>
    <tr>
        <td>VAT ({{ $order->vat_percent }}%):</td>
        <td>₦{{ number_format($order->vat_value, 0, '.', ',') }}</td>
    </tr>
    <tr>
        <th>Total:</th>
        <th>₦{{ number_format($order->total, 0, '.', ',') }}</th>
    </tr>
</table>

@if($type === 'receipt')
    <div>
        <strong>Amount Paid:</strong> ${{ number_format($order->total, 0, '.', ',') }}<br>
        <strong>Payment Method:</strong> {{ ucfirst($order->payment_method ?? 'N/A') }}<br>
    </div>
@endif

<div class="footer">
    <p>Thank you for your patronage!</p>
    <!-- <button class="print-btn" onclick="window.print()">Print {{-- ucfirst($type) --}}</button> -->
</div>

@endsection