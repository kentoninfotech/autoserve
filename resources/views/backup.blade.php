@extends('layouts.theme')

@section('content')

<div class = "row" style="width:98%; margin:auto;">
    <div class="col s12 shadow-lg">
        <h3 class="page-title">Account Backups | <small style="color: green">All Records Backups</small></h3>

    <div class="container mt-5">
        <div class="justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header text-white text-center mb-2" style="background-color: {{ Auth::user()->settings->secondary_color }}; color: #ffffff ;padding: 5px; margin-bottom: 10px;">
                        <h1 class="h4">Backup All Records</h1>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('backup.all') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <select name="format" id="format" class="form-control">
                                    <option value="" selected disabled>Select Backup Format</option>
                                    <option value="sql">SQL</option>
                                    <option value="csv">CSV</option>
                                    <option value="json">JSON</option>
                                    <option value="zipped-sql">Zipped SQL</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100">Backup All Records</button>
                        </form>
                    </div>
                </div>

                <div class="card shadow-lg border-0 mt-4">
                    <div class="card-header text-white text-center" style="background-color: {{ Auth::user()->settings->secondary_color }}; color: #ffffff ;padding: 5px; margin-top: 20px;">
                        <h2 class="h4">All Records Backups</h2>
                    </div>
                    <div class="card-body" style="margin-top: 10px;">
                        @if($allBackups->isEmpty())
                            <p class="text-muted text-center">No backups available.</p>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allBackups as $backup)
                                        <tr>
                                            <td>{{ $backup }}</td>
                                            <td><span class="badge bg-success">Available</span></td>
                                            <td>
                                                <a href="{{ route('download.backup', $backup) }}" class="btn btn-primary btn-sm">Download</a>
                                                <form method="POST" action="{{ route('delete.backup', $backup) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this backup?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form[action="{{ route('backup.all') }}"]');
        const formatSelect = document.getElementById('format');

        form.addEventListener('submit', function (event) {
            if (!formatSelect.value) {
                event.preventDefault();
                alert('Please select a backup format (SQL, JSON, Zipped-sql).');
            }
        });
    });
</script>

@endsection