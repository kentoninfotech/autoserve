@extends('layouts.theme')

@section('content')

<h3 class="page-title">Cars Inventory | <small style="color: green">Add new car</small></h3>

<div class="container-fluid" style="box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 8px;">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="box-shadow: 0 8px 8px rgba(0,0,0,0.08); border-radius: 8px;">
                <div class="panel-heading btn-primary" style="color: #fff; border-radius: 8px 8px 0 0;">
                    <h3 class="panel-title" style="font-size: 1.5em; font-weight: 600;">Add New Car <small style="color: #e0e0e0; font-size: 0.7em;">Inventory</small></h3>
                </div>
                <div class="panel-body" style="background: #fafbfc; max-width: 700px; margin: 0 auto;">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin-bottom:0;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('car-inventory.store') }}" method="POST" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Make</label>
                            <div class="col-sm-9">
                                <input type="text" name="make" class="form-control input-lg" required placeholder="e.g. Toyota" value="{{ old('make') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Model</label>
                            <div class="col-sm-9">
                                <input type="text" name="model" class="form-control input-lg" required placeholder="e.g. Corolla" value="{{ old('model') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Year</label>
                            <div class="col-sm-9">
                                <input type="text" name="year" class="form-control input-lg" required placeholder="e.g. 2022" value="{{ old('year') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">VIN</label>
                            <div class="col-sm-9">
                                <input type="text" name="vin" class="form-control input-lg" placeholder="Vehicle Identification Number" value="{{ old('vin') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Condition</label>
                            <div class="col-sm-9">
                                <input type="text" name="condition" class="form-control input-lg" placeholder="e.g. New" value="{{ old('condition') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Mileage</label>
                            <div class="col-sm-9">
                                <input type="text" name="mileage" class="form-control input-lg" placeholder="e.g. 120km" value="{{ old('mileage') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Fuel Type</label>
                            <div class="col-sm-9">
                                <input type="text" name="fuel_type" class="form-control input-lg" placeholder="e.g. Diesel" value="{{ old('fuel_type') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Transmission</label>
                            <div class="col-sm-9">
                                <input type="text" name="transmission" class="form-control input-lg" placeholder="e.g. Automatic" value="{{ old('transmission') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Color</label>
                            <div class="col-sm-9">
                                <input type="text" name="color" class="form-control input-lg" placeholder="e.g. Red" value="{{ old('color') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Price</label>
                            <div class="col-sm-9">
                                <input type="number" step="0.01" name="price" class="form-control input-lg" placeholder="e.g. 25000" value="{{ old('price') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-9">
                                <textarea name="description" class="form-control input-lg" rows="3" placeholder="Optional details about the car">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Car Images</label>
                            <div class="col-sm-9">
                                <input type="file" name="images[]" class="form-control input-lg" multiple accept="image/*">
                                <p class="help-block">You can upload multiple images.</p>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 30px;">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-primary btn-lg" style="min-width: 140px;">
                                    <i class="fa fa-save"></i> Add Car
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
