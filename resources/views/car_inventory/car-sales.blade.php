@extends('layouts.theme')

@section('content')

<h3 class="page-title">Sell Car | <small style="color: green">New Car Sales (Cart)</small></h3>
<div class="row">
    <div class="panel">
        <a href="{{ route('car-inventory.index') }}" class="btn btn-primary pull-right" style="margin: 15px;">
            <i class="fa fa-plus"></i> Back
        </a>
        <div class="panel-body">
            <form action="{{ route('car-sales.checkout') }}" method="POST">
                @csrf
                @php
                    $total = 0;
                    foreach(session('cart', []) as $car) {
                        $total += $car['price'];
                    }
                @endphp
                <input type="hidden" name="subtotal" id="hidden_subtotal" value="{{ $total }}">
                <input type="hidden" name="grand_total" id="hidden_grand_total" value="{{ $total }}">
                <div class="row">
                    <div class="col-md-6">
                        <div id="cart-cars-list">
                            <!-- Selected cars will be listed here -->
                            @if(session('cart') && count(session('cart')) > 0)
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Price(₦)</th>
                                            <th>Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(session('cart') as $car)
                                        <tr>
                                            <td>
                                                @php
                                                    $carModel = $cars->firstWhere('id', $car['id']);
                                                    $thumbImage = null;
                                                    if ($carModel && $carModel->images && $carModel->images->count()) {
                                                        $thumb = $carModel->images->firstWhere('is_thumbnail', 1);
                                                        $thumbImage = $thumb ? $thumb->image : $carModel->images->first()->image;
                                                    }
                                                @endphp
                                                @if($thumbImage)
                                                    <img src="{{ asset('vehicle_images/'.$thumbImage) }}" width="60" class="img-thumbnail"/>
                                                @endif
                                            </td>
                                            <td class="lead">{{ $car['name'] ?? $car['model'] ?? 'Car' }}</td>
                                            <td class="lead">₦{{ number_format($car['price'], 0, '.', ',') }}</td>
                                            <td><a href="{{ route('car-sales.remove', $car['id']) }}" class="btn btn-danger btn-sm">Remove</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="alert alert-warning lead">No cars in cart.</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="add-car">Add Car:</label>
                            <select id="add-car" class="form-control select2" onchange="if(this.value) window.location.href=this.value;">
                                <option value="">Select a car to add</option>
                                @foreach($cars as $car)
                                    <option value="{{ route('car-sales.add', $car->id) }}">{{ $car->name ?? $car->model }} - {{ $car->price }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <h4>Customer Details</h4>
                            <label for="customer">Customer:</label>
                            <select name="customer_id" id="customer" class="form-control">
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ old('customer_id', $customer->id) }}">{{ $customer->name }} ({{ $customer->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <p>Or Enter New Customer Details</p>
                            <label for="customer_name">Customer Name/Organisation name:</label>
                            <input type="text" name="customer_name" value="{{ old('customer_name') }}" class="form-control" placeholder="Customer Name">
                            <label for="customer_email">Customer Email:</label>
                            <input type="email" name="customer_email" value="{{ old('customer_email') }}" class="form-control" placeholder="Customer Email">
                            <label for="customer_phone">Customer Phone:</label>
                            <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" class="form-control" placeholder="Customer Phone">
                            <label for="customer_address">Customer Address:</label>
                            <input type="text" name="customer_address" value="{{ old('customer_address') }}" class="form-control" placeholder="Customer Address">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4>Order</h4>
                        @if ($errors->any())
                            <div>
                                <ul class="list-group" style="margin-bottom:0;">
                                    @foreach ($errors->all() as $error)
                                        <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row form-row">
                            <div class="form-group col-md-6">
                                <label for="status">Order Status</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="pending" old('status') == 'pending' ? 'selected' : ''>Pending</option>
                                    <option value="completed" old('status') == 'completed' ? 'selected' : ''>Completed</option>
                                    <option value="cancelled" old('status') == 'cancelled' ? 'selected' : ''>Cancelled</option>
                                    <!-- <option value="refunded">Refunded</option> -->
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="payment_status">Payment Status</label>
                                <select name="payment_status" class="form-control" id="payment_status">
                                    <option value="paid">Paid</option>
                                    <option value="unpaid">Unpaid</option>
                                    <option value="partially_paid">Partially Paid</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-row">
                            <div class="form-group col-md-6">
                                <label for="ent_vat">Vat (in Percentage %)</label>
                                <input type="number" name="ent_vat" id="ent_vat" class="form-control" min="0" value="0" oninput="updateSummary()">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="vat">Vat (₦)</label>
                                <input type="number" name="vat_value" id="vat_value" class="form-control" min="0" value="0" readonly>
                            </div>
                        </div>
                        <div class="row form-row">
                            <div class="form-group col-md-6">
                                <label for="Ent_discount">Discount (in Percentage %)</label>
                                <input type="number" name="Ent_discount" id="Ent_discount" class="form-control" min="0" value="0" oninput="updateSummary()">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="discount_value">Discount (₦)</label>
                                <input type="number" name="discount_value" id="discount_value" class="form-control" min="0" value="0" readonly>
                            </div>
                        </div> 
                        <h4 class="lead">Order Summary</h4>
                        <ul class="list-group" id="order-summary">
                            <li class="list-group-item">Subtotal: <span class="pull-right" id="subtotal">₦{{ number_format($total, 2) }}</span></li>
                            <li class="list-group-item">Discount (<span id="discount_percent">0</span>%): <span class="pull-right text-danger" id="discount_display">-₦0.00</span></li>
                            <li class="list-group-item">VAT (<span id="vat_percent">0</span>%): <span class="pull-right text-info" id="vat_display">₦0.00</span></li>
                            <li class="list-group-item active">Total: <span class="pull-right" id="grand_total">₦{{ number_format($total, 2) }}</span></li>
                        </ul>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg pull-right">Checkout</button>
            </form>
        </div>
    </div>
</div>
@endsection

<style>
    td{
      vertical-align: middle !important;
    }
</style>
<script>
//   UNCOMMENT THIS BLOCK TO ENABLE LOCAL STORAGE
// Save discount/vat values in localStorage
// function saveOrderFields() {
//     localStorage.setItem('car_sales_discount', document.getElementById('Ent_discount').value);
//     localStorage.setItem('car_sales_vat', document.getElementById('ent_vat').value);
// }
// function loadOrderFields() {
//     if(localStorage.getItem('car_sales_discount')) {
//         document.getElementById('Ent_discount').value = localStorage.getItem('car_sales_discount');
//     }
//     if(localStorage.getItem('car_sales_vat')) {
//         document.getElementById('ent_vat').value = localStorage.getItem('car_sales_vat');
//     }
// }
function updateSummary() {
    var subtotal = parseFloat(document.getElementById('subtotal').innerText.replace(/[^\d.]/g, '')) || 0;
    var discountPercent = parseFloat(document.getElementById('Ent_discount').value) || 0;
    var vatPercent = parseFloat(document.getElementById('ent_vat').value) || 0;
    var discountValue = subtotal * discountPercent / 100;
    var vatValue = (subtotal - discountValue) * vatPercent / 100;
    var grandTotal = subtotal - discountValue + vatValue;
    document.getElementById('discount_value').value = discountValue.toFixed(2);
    document.getElementById('vat_value').value = vatValue.toFixed(2);
    document.getElementById('discount_percent').innerText = discountPercent;
    document.getElementById('vat_percent').innerText = vatPercent;
    document.getElementById('discount_display').innerText = '-₦' + discountValue.toLocaleString(undefined, {minimumFractionDigits:2});
    document.getElementById('vat_display').innerText = '₦' + vatValue.toLocaleString(undefined, {minimumFractionDigits:2});
    document.getElementById('grand_total').innerText = '₦' + grandTotal.toLocaleString(undefined, {minimumFractionDigits:2});
    document.getElementById('hidden_subtotal').value = subtotal.toFixed(2);
    document.getElementById('hidden_grand_total').value = grandTotal.toFixed(2);
    saveOrderFields();
}
//   UNCOMMENT THIS BLOCK TO ENABLE LOCAL STORAGE OF DISCOUNT/VAT VALUES
// window.addEventListener('DOMContentLoaded', function() {
//     loadOrderFields();
//     updateSummary();
//     document.getElementById('Ent_discount').addEventListener('input', saveOrderFields);
//     document.getElementById('ent_vat').addEventListener('input', saveOrderFields);
//     // If subtotal changes (car added/removed), re-calculate but keep discount/vat values
//     const observer = new MutationObserver(function() {
//         loadOrderFields();
//         updateSummary();
//     });
//     observer.observe(document.getElementById('subtotal'), { childList: true });
// });
</script>

