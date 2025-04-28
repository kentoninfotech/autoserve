@extends('layouts.theme')

@section('content')
@php $pagetype="report"; $sn=1; @endphp

    <h3 class="page-title">Jobs | <small style="color: green">Job Control Management</small></h3>

            <div class="row">
            <div class="panel">
                <div class="panel-body">
                    <table class="table  responsive-table" id="products" style="font-size: 0.9em !important">
                        <thead>
                            <tr>
                                <th>Job No</th>
                                <th>Technician</th>
                                <th>Details</th>
                                <th>Started At</th>
                                <th>Completed At</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($controls as $job)
                                <tr>
                                    <td>{{$job->jobno}}</td>
                                    <td>{{$job->technician}}</td>
                                    <td>{{$job->details}}</td>
                                    <td>{{$job->started_at}}</td>
                                    <td>{{$job->completed_at}}</td>
                                    <td>{{$job->status}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                               <th>Job No</th>
                                <th>Technician</th>
                                <th>Details</th>
                                <th>Started At</th>
                                <th>Completed At</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>

                    </table>


                </div>
            </div>

    </div>





@endsection
