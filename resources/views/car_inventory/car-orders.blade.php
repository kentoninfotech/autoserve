@extends('layouts.theme')

@section('content')
@php $pagetype="report"; $sn=1; @endphp

    <h3 class="page-title">Car Orders | <small style="color: green">Sales</small></h3>
    <div class="row">
            <div class="panel">
                <a href="{{ route('car-inventory.index') }}" class="btn btn-primary pull-right" style="margin: 15px;">
                    <i class="fa fa-angle-left"></i> Back
                </a>

                <div class="panel-body">
                    <table class="table" id="products">
                        <thead>
                            <tr>
                                <th>Order Number</th>
                                <th>Car(s)</th>
                                <th>Customer</th>
                                <th>Sub Total(₦)</th>
                                <th>Total(₦)</th>
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
                                    <td>₦{{ number_format($order->subtotal, 0, '.', ',') }}</td>
                                    <td>₦{{ number_format($order->total, 0, '.', ',') }}</td>
                                    <td>{{ Str::headline($order->status) }}</td>
                                    <td>{{ Str::headline($order->payment_status) }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#editOrderModal{{ $order->id }}">Edit</a>
                                            <a href="{{ route('car-orders.print', ['id' => $order->id, 'type' => 'invoice']) }}" class="btn btn-warning btn-xs" target="_blank">Invoice</a>
                                            @if($order->status === 'completed')
                                            <a href="{{ route('car-orders.print', ['id' => $order->id, 'type' => 'receipt']) }}" class="btn btn-success btn-xs" target="_blank">Receipt</a>
                                            @endif
                                            <form action="{{ route('car-orders.delete', $order->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Delete this order record?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit Order Modal -->
                                <div class="modal fade" id="editOrderModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="editOrderModalLabel{{ $order->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <form method="POST" action="{{ route('car-orders.update', $order->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="editOrderModalLabel{{ $order->id }}">Edit Order #{{ $order->order_number }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                        <div class="form-group">
                                            <label for="status">Order Status</label>
                                            <select name="status" class="form-control">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="payment_status">Payment Status</label>
                                            <select name="payment_status" class="form-control">
                                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                            <option value="partially_paid" {{ $order->payment_status == 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
@endsection


