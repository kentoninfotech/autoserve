@extends('layouts.autoserve')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <a href="{{ route('accounts.index') }}" class="btn btn-secondary float-right mb-3">Back</a>
            <h1>Edit Account</h1>
            <form action="{{ route('accounts.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ $user->phone_number }}" required>
                </div>

                <div class="form-group">
                    <label for="company_name">Company Name</label>
                    <input type="text" name="company_name" id="company_name" class="form-control" value="{{ $user->setting->company_name ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ $user->setting->address ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="deployment_type">Deployment Type</label>
                    <select name="deployment_type" id="deployment_type" class="form-control" required>
                        <option value="" disabled>Select Deployment Type</option>
                        <option value="online" {{ $user->setting->deployment_type === 'online' ? 'selected' : '' }}>Online</option>
                        <option value="subscription" {{ $user->setting->deployment_type === 'subscription' ? 'selected' : '' }}>Subscription</option>
                        <option value="on-premise" {{ $user->setting->deployment_type === 'on-premise' ? 'selected' : '' }}>On-Premise</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection