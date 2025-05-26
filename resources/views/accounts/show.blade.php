@extends('layouts.theme')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title">Accounts | <small style="color: green">{{ $user->setting->company_name }}'s profile</small></h3>
    <div class="panel shadow-lg border-0">
        <div class="panel-body">
            <a href="{{ route('accounts.index') }}" class="btn btn-outline-secondary float-right mb-3"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
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
                            <p><strong>Facility:</strong> {{ $user->facility ?? 'N/A' }}</p>
                            <p><strong>Address:</strong> {{ $user->setting->address ?? 'N/A' }}</p>
                            <p><strong>Deployment Type:</strong> {{ $user->setting->deployment_type ?? 'N/A' }}</p>
                            <p><strong>Account Status:</strong> {{ $user->setting->status}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="mt-4" style="text-align: right;">
                @if($user->setting->status == 'Active')
                    <form id="deactivateForm" action="{{ route('accounts.deactivate', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="button" class="btn btn-danger shadow-lg" onclick="confirmDeactivation()">Deactivate Account</button>
                    </form>
                @else
                    <form id="activateForm" action="{{ route('accounts.activate', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="button" class="btn btn-success shadow-lg" onclick="confirmActivation()">Activate Account</button>
                    </form>
                @endif
            </div>
            <script>
                function confirmDeactivation() {
                    if(confirm('Are you sure you want to Deactivate this Account?')) {
                        document.getElementById('deactivateForm').submit();
                    }
                }
                function confirmActivation() {
                    if(confirm('Are you sure you want to Activate this Account?')) {
                        document.getElementById('activateForm').submit();
                    }
                }
            </script>
        </div>
    </div>
</div>
</div>
</div>
@endsection