@extends('layouts.theme')

@section('content')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <div class="card-header bg-primary text-white text-center">
                        <h1 class="h4">Backup All Records</h1>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('backup.all') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg w-100">Backup All Records</button>
                        </form>
                    </div>
                </div>

                <div class="card shadow-lg border-0 mt-4" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <div class="card-header bg-secondary text-white text-center">
                        <h2 class="h5">All Records Backups</h2>
                    </div>
                    <div class="card-body">
                        @if($allBackups->isEmpty())
                            <p class="text-muted text-center">No backups available.</p>
                        @else
                            <ul class="list-group">
                                @foreach($allBackups as $backup)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="{{ url($backup) }}" class="btn btn-link">Download {{ $backup }}</a>
                                        <span class="badge bg-success">Available</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection