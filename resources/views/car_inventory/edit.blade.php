@extends('layouts.theme')

@section('content')
<div class="container-fluid" style="max-width: 700px; margin: 0 auto;">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 8px;">
                <div class="panel-heading btn-primary" style="color: #fff; border-radius: 8px 8px 0 0;">
                    <h3 class="panel-title" style="font-size: 1.5em; font-weight: 600;">Edit Car <small style="color: #e0e0e0; font-size: 0.7em;">Inventory</small></h3>
                </div>
                <div class="panel-body" style="background: #fafbfc;">
                    @if ($errors->any())
                        <div>
                            <ul class="list-group" style="margin-bottom:0;">
                                @foreach ($errors->all() as $error)
                                    <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('car-inventory.update', $car->id) }}" method="POST" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Make</label>
                            <div class="col-sm-9">
                                <input type="text" name="make" class="form-control input-lg" required placeholder="e.g. Toyota" value="{{ old('make', $car->make) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Model</label>
                            <div class="col-sm-9">
                                <input type="text" name="model" class="form-control input-lg" required placeholder="e.g. Corolla" value="{{ old('model', $car->model) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Year</label>
                            <div class="col-sm-9">
                                <input type="text" name="year" class="form-control input-lg" required placeholder="e.g. 2022" value="{{ old('year', $car->year) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">VIN</label>
                            <div class="col-sm-9">
                                <input type="text" name="vin" class="form-control input-lg" placeholder="Vehicle Identification Number" value="{{ old('vin', $car->vin) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Condition</label>
                            <div class="col-sm-9">
                                <select class="form-control input-lg" name="condition" id="condition">
                                    <option value="" disabled selected>Select Condition</option>
                                    <option value="new" {{ old('condition', $car->condition) == 'new' ? 'selected' : '' }}>New</option>
                                    <option value="used" {{ old('condition', $car->condition) == 'used' ? 'selected' : '' }}>Used</option>
                                    <option value="certified">Certified Pre-Owned</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-9">
                                <select class="form-control input-lg" name="status" id="status">
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="available" {{ old('status', $car->status) == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="sold" {{ old('status', $car->status) == 'sold' ? 'selected' : '' }}>Sold</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Mileage</label>
                            <div class="col-sm-9">
                                <input type="text" name="mileage" class="form-control input-lg" placeholder="Mileage" value="{{ old('mileage', $car->mileage) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">FUEL TYPE</label>
                            <div class="col-sm-9">
                                <select class="form-control input-lg" name="fuel_type" id="fuel_type">
                                    <option value="" disabled selected>Select Fuel Type</option>
                                    <option value="petrol" {{ old('fuel_type', $car->fuel_type) == 'petrol' ? 'selected' : '' }}>Petrol</option>
                                    <option value="diesel" {{ old('fuel_type', $car->fuel_type) == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                    <option value="electric" {{ old('fuel_type', $car->fuel_type) == 'electric' ? 'selected' : '' }}>Electric</option>
                                    <option value="hybrid" {{ old('fuel_type', $car->fuel_type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Drive TYPE</label>
                            <div class="col-sm-9">
                                <select class="form-control input-lg" name="drive_type" id="drive_type">
                                    <option value="" disabled selected>Select Drive Type</option>
                                    <option value="fwd" {{ old('drive_type', $car->drive_type) == 'fwd' ? 'selected' : '' }}>Front-Wheel Drive (FWD)</option>
                                    <option value="rwd" {{ old('drive_type', $car->drive_type) == 'rwd' ? 'selected' : '' }}>Rear-Wheel Drive (RWD)</option>
                                    <option value="awd" {{ old('drive_type', $car->drive_type) == 'awd' ? 'selected' : '' }}>All-Wheel Drive (AWD)</option>
                                    <option value="4wd" {{ old('drive_type', $car->drive_type) == '4wd' ? 'selected' : '' }}>Four-Wheel Drive (4WD)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">TRANSMISSION</label>
                            <div class="col-sm-9">
                                <select class="form-control input-lg" name="transmission" id="transmission">
                                    <option value="" disabled selected>Select Transmission</option>
                                    <option value="automatic" {{ old('transmission', $car->transmission) == 'automatic' ? 'selected' : '' }}>Automatic</option>
                                    <option value="manual" {{ old('transmission', $car->transmission) == 'manual' ? 'selected' : '' }}>Manual</option>
                                    <option value="semi-automatic" {{ old('transmission', $car->transmission) == 'semi-automatic' ? 'selected' : '' }}>Semi-Automatic</option>
                                    <option value="cvt" {{ old('transmission', $car->transmission) == 'cvt' ? 'selected' : '' }}>Continuously Variable Transmission (CVT)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Color</label>
                            <div class="col-sm-9">
                                <input type="text" name="color" class="form-control input-lg" placeholder="e.g. Red" value="{{ old('color', $car->color) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Price</label>
                            <div class="col-sm-9">
                                <input type="number" step="0.01" name="price" class="form-control input-lg" placeholder="e.g. 25000" value="{{ old('price', $car->price) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-9">
                                <textarea name="description" class="form-control input-lg" rows="3" placeholder="Optional details about the car">{{ old('description', $car->description) }}</textarea>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 30px;">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-primary btn-lg" style="min-width: 140px;">
                                    <i class="fa fa-save"></i> Update Car
                                </button>
                                <a href="{{ route('car-inventory.index') }}" class="btn btn-default btn-lg" style="margin-left: 10px;">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
