@extends('layouts.theme')

@section('content')
@php $pagetype="report"; $sn=1; @endphp

    <h3 class="page-title">Personnel | <small style="color: green">Take Attendance</small></h3>
    <div style="text-align: right;"><a href="{{url('/attendances')}}" class="btn btn-primary"><i class="fa fa-eye"></i> View Attendance</a></div>

    <div class="row">
            <div class="panel">

                <div class="panel-body">
                    <table class="table  responsive-table" id="products" style="font-size: 0.9em !important">
                        <thead>
                            <tr style="color: ">

                                <th>Full Name</th>
                                <th>Designation</th>
                                <th>Department</th>

                                <th style="width: 15% !important;">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendances as $per)

                                <tr>

                                    <td><b>{{$per->surname.", ".$per->firstname." ".$per->othernames}}</b>
                                    </td>
                                    <td>{{$per->designation}}</td>
                                    <td>{{$per->department}}</td>

                                    <td>
                                        
                                        @php
                                            $record = \App\Models\Attendances::select('date_time','personnel_id')->where('personnel_id', $per->id)->whereDate('date_time', date('Y-m-d'))->first(); 
                                        @endphp
                                        @if(!isset($record))
                                            <form action="{{url('/present/'.$per->id)}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="personnel_id" value="{{$per->id}}">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <label for="date">Date</label>
                                                        <input name="date_time" id="date_time" class="form-control date" type="datetime-local" value="{{date('Y-m-d\TH:i:s')}}" placeholder="Choose Date">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label for="status">Status</label>
                                                        <select name="status" id="status" class="form-control">
                                                            <option value="Present" selected>Present</option>
                                                            <option value="Absent">Absent</option>
                                                            <option value="Late">Late</option>
                                                            <option value="Sick Leave">Sick Leave</option>
                                                            <option value="Leave">Leave</option>
                                                        </select>
                                                        </div>
                                                    <div class="col-md-5">
                                                        <button type="submit" class="label label-primary">Present</button>
                                                    </div>
                                                </div>

                                            </form>

                                            @else
                                            {{ $record->date_time }}
                                        @endif
                                    </td>

                                </tr>
                            @endforeach


                        </tbody>

                    </table>

                </div>
            </div>

    </div>





@endsection
