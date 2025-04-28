@extends('layouts.theme')

@section('content')
@php $pagetype="report"; $sn=1; @endphp

    <h3 class="page-title">Personnel | <small style="color: green">Take Attendance</small></h3>
    <div style="text-align: right;"><a href="{{url('/add-personnel')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Staff</a></div>

    <div class="row">
            <div class="panel">

                <div class="panel-heading">
                    <a href="{{ url('/attendances') }}" target="_blank" class="btn btn-primary btn-xs">View Attendance</a>
                </div>

                <div class="panel-body">
                    <table class="table  responsive-table" id="products" style="font-size: 0.9em !important">
                        <thead>
                            <tr style="color: ">

                                <th>Full Name</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Date and Time</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendance as $per)

                                <tr>

                                    <td><b>{{$per->personnel->surname.", ".$per->personnel->firstname." ".$per->othernames}}</b>
                                    </td>
                                    <td>{{$per->personnel->designation}}</td>
                                    <td>{{$per->personnel->department}}</td>
                                    <td>{{$per->date_time}}</td>
                                    <td>{{$per->status}}</td>

                                </tr>
                            @endforeach


                        </tbody>

                    </table>

                </div>
            </div>

    </div>





@endsection
