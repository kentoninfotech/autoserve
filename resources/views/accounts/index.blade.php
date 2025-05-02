@extends('layouts.autoserve')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1>Auto Serve Accounts/Company Lists</h1>
            <span class="float-right">Total Users: {{ $users->count() }}</span>
            <table class="table">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Company Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Deployment Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->setting->company_name ?? 'N/A' }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>{{ $user->setting->deployment_type ?? 'N/A' }}</td>
                        <td>{{$user->setting->mode}}</td>
                        <td>
                            <a href="{{ route('accounts.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ route('accounts.show', $user->id) }}" class="btn btn-secondary">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection