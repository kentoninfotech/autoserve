@extends('layouts.theme')

@section('content')
@php $pagetype="report"; $sn=1; @endphp

    <h3 class="page-title">Personnel | <small style="color: green">Attendance Records</small></h3>
    <div style="text-align: right;"><a href="{{url('/attendance')}}" class="btn btn-primary"><i class="fa fa-check"></i> Take Attendance</a></div>

    <div class="row">
            <div class="panel">


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
                            @foreach ($attendances as $per)

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
