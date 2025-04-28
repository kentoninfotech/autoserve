@extends('layouts.theme')

@section('content')
@php $pagetype="report"; $sn=1; @endphp

    <h3 class="page-title">Jobs | <small style="color: green">Job Control Management</small></h3>

            <div class="row">
            <div class="panel">
                <div class="panel-body">

                    <a href="{{ url('/print-controls') }}" target="_blank" class="btn btn-primary btn-xs">Print Job Controls</a>
                    <table class="table  responsive-table" id="products" style="font-size: 0.9em !important">
                        <thead>
                            <tr style="color: ">

                                <th>Job Info</th>
                                <th>Job Assignment</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                        @php $sn=0; @endphp
                            @foreach ($controls as $job)

                                <tr>
                                    <td><b>Job No: {{$job->job->jobno}}</b><br>
                                        <b>V. Reg. No:</b> {{$job->job->vregno ? $job->job->vregno : ''}} <br>
                                        <b>Expectd Delivery Date:</b> {{$job->job->diagnosis ? $job->job->diagnosis->deliverydate : ''}}
                                    </td>

                                    <td>
                                            <form action="{{ route('assignedToTechnician') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$job->id}}">
                                                <input type="hidden" name="jobno" value="{{$job->jobno}}">
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <input list="technicians" name="technician" id="technician" value="{{$job->technician}}" placeholder="Technician" class="form-control">
                                                        <datalist id="technicians">

                                                            @foreach ($technicians as $user)
                                                                <option value="{{$user->name}}">
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <input type="text" name="details" id="details" value="{{$job->details}}" placeholder="Details/Comments" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-3">
                                                        <input type="text" name="started_at" id="started_at" class="form-control date" value="{{date('Y-m-d\TH:i:s', strtotime($job->started_at))}}">
                                                    </div>

                                                    <div class="col-md-3">
                                                        <input type="text" name="completed_at" id="completed_at" class="form-control date" value="{{date('Y-m-d\TH:i:s', strtotime($job->completed_at))}}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select name="status" id="status" class="form-control">
                                                            @if ($job->status=="")
                                                                <option value="">Select Status</option>
                                                            @else
                                                                <option value="{{$job->status}}">{{$job->status}}</option>
                                                            @endif
                                                            <option value="Pending">Pending</option>
                                                            <option value="Completed">Completed</option>
                                                            <option value="Cancelled">Cancelled</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button class="btn btn-primary btn-xs">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                    </td>

                                    <td>
                                        <a href="{{ url('/delete-control/'.$job->id)}}" class="label label-danger roledlink Super Admin"  onclick="return confirm('Are you sure you want to delete this record ?')">Delete</a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Job Info</th>
                                <th>Job Assignment</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>

                    </table>

                    <div style="text-align: right; color: #337ab7;">
                        <span>	&darr; Older Records Navigation | <small>each number contains 400 records</small></span>
                        {{$controls->links()}}
                    </div>
                </div>
            </div>

    </div>





@endsection
