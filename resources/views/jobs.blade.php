@extends('layouts.theme')

@section('content')
@php $pagetype="report"; $sn=1; @endphp

    <h3 class="page-title">Jobs | <small style="color: green">All Jobs</small></h3>

        <h6>Filter Jobs by Duration</h6>
        <form method="POST" action="{{ route('filterjobs') }}" class="row" style="width: 50%; margin: auto;">
            @csrf

                <div class="col-md-4">
                    <label for="from">From</label>
                    <input name="from" id="from" class="form-control" type="text" placeholder="Choose Date">
                </div>
                <div class="col-md-4">
                    <label for="to">To</label>
                    <input name="to" id="to" class="form-control" type="text" placeholder="Choose Date">
                </div>
                <div class="col-md-4">
                    <label for="">.</label>
                    <button class="form-control btn btn-primary" type="submit">Filter Jobs</button>
                </div>



        </form>

    <div style="text-align: right; margin-top:5px;"><a href="{{ url('/newjob')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Job</a></div>
    <div class="row">
            <div class="panel">
               <small style="margin-left: 25px;;">Last Invoice No: <b style="text-align: center; color: green;">{{$lastinvoiceno}}</b></small>
                <div class="panel-body">
                    <table class="table  responsive-table" id="products" style="font-size: 0.9em !important">
                        <thead>
                            <tr style="color: ">

                                <th>Customer/Organization</th>
                                <th>V. Reg No</th>
                                <th>Date</th>
                                <th>Job No</th>

                                <th>Amount</th>
                                <th>Status</th>
                                <th style="width: 25% !important;">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                        @php $sn=0; @endphp
                            @foreach ($jobs as $job)

                                <tr>
                                    <td><b>{{$job->contact ? $job->contact->name : $job->customerid}} / <br>{{$job->contact ? $job->contact->organization : ''}}</b>
                                    </td>
                                    <td>{{$job->vregno ? $job->vregno : ''}}</td>
                                    <td>{{$job->dated}}</td>
                                    <td>
                                        @if ($job->jid!="0")
                                            {{$job->jid}}


                                        @else
                                            <form action="{{ route('addjobno') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$job->id}}">
                                                <div class="col-md-8">
                                                    <input type="number" name="jid" id="jid" placeholder="Enter Job No" value="{{$lastinvoiceno+1}}">
                                                </div>
                                                <div class="col-md-4">
                                                    <button class="btn btn-primary btn-xs">Save</button>
                                                </div>
                                            </form>
                                        @endif

                                        </td>

                                    <td><b>{{$job->amount}}</b></td>
                                    <td>{{$job->status}}</td>

                                    <td>
                                        <a href="{{ url('/edit-job/'.$job->jobno)}}" class="label label-warning roledlink Admin AutoServe Super Front-Desk Spare-Parts">Edit</a>
                                        <a href="{{ url('/invoice/'.$job->jobno)}}/invoice" target="_blank" class="label label-success">Invoice</a>
                                        <a href="{{ url('/invoice/'.$job->jobno)}}/estimate" target="_blank" class="label label-info">Estimate</a>
                                        <a href="{{ url('/invoice/'.$job->jobno)}}/instruction" target="_blank" class="label label-info">Instruction</a>

                                            <a href="{{ url('/new-payment/'.$job->jid)}}" target="_blank" class="label label-primary roledlink Finance Admin AutoServe Super Front-Desk">Make Payment</a>

                                        <a href="{{ url('/invoice/'.$job->jobno)}}/receipt" target="_blank" class="label label-primary">Receipt</a>
                                        <a href="#"  data-toggle="modal" data-target="#invoicedate" id="{{$job->jobno}}" onClick="changeDate({{$job->jobno}})" class="label label-warning roledlink AutoServe Super Admin">Change Date</a>
                                        @if (isset($job->diagnosis) && ($job->diagnosis->diagnosis != ""))
                                            <a href="{{ url('/diagnosis-file/'.$job->jobno)}}" target="_blank" class="label label-info">Diagnosis File</a>
                                        @endif
                                        @php
                                             $image_path = public_path("job_images/$job->jobno");
                                             $image_files = $image_path && File::exists($image_path) ? File::files($image_path) : [];
                                        @endphp
                                        @if(File::exists($image_path) && count($image_files) > 0)
                                            <a href="{{ url('/job-gallery/'.$job->jobno)}}" target="_blank" class="label label-info">Job Gallery</a>
                                        @endif
                                        <a href="{{ url('/delete/'.$job->id)}}/jobs" class="label label-danger roledlink AutoServe Super Admin"  onclick="return confirm('Are you sure you want to delete this record? {{$job->description}}?')">Delete</a>
                                    </td>

                                </tr>
                            @endforeach


                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>

                    </table>

                    <div style="text-align: right; color: #337ab7;">
                        <span>	&darr; Older Records Navigation | <small>each number contains 400 records</small></span>
                        {{$jobs->links()}}
                    </div>
                </div>
            </div>

    </div>





@endsection
