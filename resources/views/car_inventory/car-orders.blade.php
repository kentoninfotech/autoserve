@extends('layouts.theme')

@section('content')
@php $pagetype="report"; $sn=1; @endphp

    <h3 class="page-title">Car Orders | <small style="color: green">Sales</small></h3>
    <div class="row">
            <div class="panel">
                <a href="{{ url()->previous() }}" class="btn btn-primary pull-right" style="margin: 15px;">
                    <i class="fa fa-angle-left"></i> Back
                </a>

                <div class="panel-body">
                    <table class="table" id="products">
                        <thead>
                            <tr>
                                <th>Order Number</th>
                                <th>Cars</th>
                                <th>Customer</th>
                                <th>Sub Total</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Payment Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carOrder as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>
                                        @foreach($order->cars as $car)
                                         {{ $car->make ." ". $car->model }}
                                           @if (!$loop->last), @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $order->customer->name ?? ''}}
                                        (<span>{{ $order->customer->telephoneno ?? '' }}</span>)
                                    </td>
                                    <td>{{ $order->subtotal }}</td>
                                    <td>{{ $order->total }}</td>
                                    <td>{{ Str::headline($order->status) }}</td>
                                    <td>{{ Str::headline($order->payment_status) }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>
                                        <a href="{{url('/delete-sale/'.$order->id)}}" class="btn btn-danger btn-xs">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
@endsection
