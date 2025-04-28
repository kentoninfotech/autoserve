@extends('layouts.theme')

@section('content')
@php $pagetype="report"; $sn=1; @endphp

    <h3 class="page-title">Personnel | <small style="color: green">Take Attendance</small></h3>
    <div style="text-align: right;"><a href="{{url('/add-personnel')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Staff</a></div>

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
                            @foreach ($attendance as $per)

                                <tr>

                                    <td><b>{{$per->personnel->surname.", ".$per->personnel->firstname." ".$per->personnel->othernames}}</b>
                                    </td>
                                    <td>{{$per->personnel->designation}}</td>
                                    <td>{{$per->personnel->department}}</td>

                                    <td>
                                        
                                        @php
                                            $record = \App\Attendance::where('personnel_id', $per->id)->where('date_time', date('Y-m-d'))->first(); 
                                        @if(@isset($record)
                                            
                                        @endisset)
                                        <form action="{{url('/present/'.$per->id)}}">
                                            @csrf
                                            <input type="hidden" name="personnel_id" value="{{$per->id}}">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <label for="date">Date</label>
                                                    <input name="date" id="date_time" class="form-control date" type="datetime-local" value="{{date('Y-m-d\TH:i:s')}}" placeholder="Choose Date">
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="date">Status</label>
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
                                    </td>

                                </tr>
                            @endforeach


                        </tbody>

                    </table>

                </div>
            </div>

    </div>





@endsection
