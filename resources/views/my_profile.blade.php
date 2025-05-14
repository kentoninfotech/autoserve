@extends('layouts.theme')

@section('content')
<div class="container">
    <div class="row">
    <h3 class="page-title">Users | <small style="color: green">{{ $user->name }}'s profile</small></h3>
        <div class="col-md-3">
            <!-- User Profile Sidebar -->
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <img src="{{ asset('images/default-profile.png') }}" class="img-circle" alt="User Image" width="100">
                    <h4>{{ $user->name }}</h4>
                    <p>{{ $user->email }}</p>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item">Role: {{ $user->role == "Super" ? $user->role. " Admin":$user->role }}</li>
                        <li class="list-group-item">Phone: {{ $user->phone_number }}</li>
                        <li class="list-group-item">State: {{ $user->state }}</li>
                        <li class="list-group-item">Facility: {{ $user->facility }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <!-- User Posts Section -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>User Tasks</h4>
                </div>
                <div class="panel-body">
                    @if($tasks->isEmpty())
                        <p class="text-center">No tasks available.</p>
                    @else
                        @foreach($tasks as $task)
                            <div class="media">
                                <div class="media-left">
                                    <img src="{{ asset('images/default-profile.png') }}" class="media-object img-circle" alt="User Image" width="50">
                                </div>
                                <div class="media-body">
                                    <h5 class="media-heading">{{ $task->title }}</h5>
                                    <p>{{ $task->activities }}</p>
                                    <small class="text-muted">Created on {{ $task->created_at->format('M d, Y') }}</small>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection