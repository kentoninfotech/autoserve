@extends('layouts.theme')

@section('content')
@php $pagetype="report"; $sn=1; @endphp

    <h3 class="page-title">Car Inventory | <small style="color: green">All Cars</small></h3>
    <div class="row">
        <div class="panel">
            <div style="text-align: right; margin:10px;">
                <a href="{{ route('car-inventory.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Add New Car
                </a>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table responsive-table" id="car-inventory-table products" style="font-size: 0.9em !important">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Make</th>
                                <th>Model</th>
                                <th>Year</th>
                                <th>Mileage</th>
                                <th>Condition</th>
                                <th>Fuel Type</th>
                                <th>Transmission</th>
                                <th>Color</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cars as $car)
                            <tr>
                                <td>
                                    @php
                                        $thumb = $car->images->firstWhere('is_thumbnail', 1);
                                        $thumbImage = $thumb ? $thumb->image : ($car->images->count() ? $car->images->first()->image : null);
                                    @endphp
                                    @if($thumbImage)
                                        <img src="{{ asset('vehicle_images/'.$thumbImage) }}" width="80" class="img-thumbnail"/>
                                    @endif
                                </td>
                                <td>{{ $car->make }}</td>
                                <td>{{ $car->model }}</td>
                                <td>{{ $car->year }}</td>
                                <td><i class="fa fa-tachometer"></i> {{ $car->mileage }} km</td>
                                <td>{{ $car->condition }}</td>
                                <td><i class="fa fa-gas-pump"></i> {{ $car->fuel_type }}</td>
                                <td><i class="fa fa-cogs"></i> {{ $car->transmission }}</td>
                                <td>{{ $car->color }}</td>
                                <td>₦{{ number_format($car->price, 0, '.', ',') }}</td>
                                <td><span class="label label-{{ $car->status == 'available' ? 'success' : 'default' }}">{{ ucfirst($car->status) }}</span></td>
                                <td>
                                    <a href="{{ route('car-inventory.show', $car->id) }}" class="btn btn-info btn-xs">View</a>
                                    <a href="{{ route('car-inventory.edit', $car->id) }}" class="btn btn-warning btn-xs">Edit</a>
                                    <form action="{{ route('car-inventory.destroy', $car->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Delete this car?')">Delete</button>
                                    </form>
                                    @if($car->status == 'available')
                                    <form action="{{ route('car-inventory.sell', $car->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-xs" onclick="return confirm('Mark as sold?')">Sell</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <style>
        td{
            vertical-align: middle !important;
        }
    </style>
@endsection
