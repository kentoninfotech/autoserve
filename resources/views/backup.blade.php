@extends('layouts.theme')

@section('content')

<h3 class="page-title">Account Backup | <small style="color: green">All Backups</small></h3>
<div class="panel panel-default">
<div class="container" style="max-width: 900px; margin-top: 40px;">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary shadow-lg" style="border-radius: 10px; overflow: hidden;">
                <div class="panel-heading text-center" style="background: #2563eb; color: #fff; font-size: 1.7em; font-weight: 600; letter-spacing: 1px; padding: 18px 0;">
                    <i class="glyphicon glyphicon-hdd" style="margin-right: 8px;"></i>Backup All Records
                </div>
                <div class="panel-body" style="padding: 32px 40px 24px 40px; background: #f8fafc;">
                    <form method="POST" action="{{ route('backup.all') }}" class="form-horizontal" id="backupForm">
                        @csrf
                        <div class="form-group">
                            <label for="format" class="col-sm-3 control-label" style="font-weight: 500; font-size: 1.1em;">Backup Format</label>
                            <div class="col-sm-9">
                                <select name="format" id="format" class="form-control input-lg" style="border-radius: 6px;">
                                    <option value="" selected disabled>Select Backup Format</option>
                                    <option value="sql">SQL</option>
                                    <option value="csv">CSV</option>
                                    <option value="json">JSON</option>
                                    <option value="zipped-sql">Zipped SQL</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 18px;">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-success btn-lg" style="width: 100%; font-size: 1.2em; font-weight: 600; letter-spacing: 1px; border-radius: 6px;">
                                    <i class="glyphicon glyphicon-cloud-upload"></i> Backup All Records
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 40px;">
        <div class="col-md-12">
            <div class="panel panel-default shadow-lg" style="border-radius: 10px; overflow: hidden;">
                <div class="panel-heading text-center" style="background: #0e1726; color: #fff; font-size: 1.3em; font-weight: 500; letter-spacing: 1px; padding: 14px 0;">
                    <i class="glyphicon glyphicon-list-alt" style="margin-right: 8px;"></i>All Records Backups
                </div>
                <div class="panel-body" style="background: #fff;">
                    @if($allBackups->isEmpty())
                        <div class="alert alert-info text-center" style="margin: 30px 0; font-size: 16px;">No backups available.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" style="background: #fafbfc;">
                                <thead style="background: #f1f1f1;">
                                    <tr style="font-size: 1.1em;">
                                        <th style="width: 60%;">Backup File</th>
                                        <th style="width: 15%;">Status</th>
                                        <th style="width: 25%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allBackups as $backup)
                                        <tr>
                                            <td style="vertical-align: middle; font-size: 15px; word-break: break-all;">{{ $backup }}</td>
                                            <td style="vertical-align: middle;"><span class="label label-success" style="font-size: 13px;">Available</span></td>
                                            <td style="vertical-align: middle;">
                                                <div class="btn-group" style="display: flex; justify-content: space-between;">
                                                    <a href="{{ route('download.backup', $backup) }}" class="btn btn-primary btn-xs" style="margin-right: 8px; border-radius: 3px; font-size: 13px;">
                                                        <i class="glyphicon glyphicon-download-alt"></i> Download
                                                    </a>
                                                    <form method="POST" action="{{ route('delete.backup', $backup) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this backup?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-xs" style="border-radius: 3px; font-size: 13px;">
                                                            <i class="glyphicon glyphicon-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var form = document.getElementById('backupForm');
        var formatSelect = document.getElementById('format');
        if(form && formatSelect) {
            form.addEventListener('submit', function (event) {
                if (!formatSelect.value) {
                    event.preventDefault();
                    alert('Please select a backup format (SQL, JSON, Zipped-sql).');
                }
            });
        }
    });
</script>

@endsection