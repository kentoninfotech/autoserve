@extends('layouts.theme')

@section('content')
<div class="container mt-5">
    <div class="panel shadow-lg border-0">
        <div class="panel-body">
            <a href="{{ route('accounts.index') }}" class="btn btn-outline-secondary float-right mb-3">Back</a>
            <div class="text-center mb-4">
                <h1 class="text-primary font-weight-bold">{{ $user->setting->company_name ?? 'N/A' }}</h1>
                <p class="text-muted">Company Profile</p>
            </div>
            <div class="row align-items-center">
                <div class="col-md-4 text-center">
                    <img src="{{ asset('images/default-profile.png') }}" alt="Profile Picture" class="rounded-circle mb-3" width="150">
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Owner Name:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Phone Number:</strong> {{ $user->phone_number }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Address:</strong> {{ $user->setting->address ?? 'N/A' }}</p>
                            <p><strong>Deployment Type:</strong> {{ $user->setting->deployment_type ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection