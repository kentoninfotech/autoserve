@extends('layouts.theme')

@section('content')
@php $pagetype="report"; $sn=1; @endphp

    <h3 class="page-title">Debtors | <small style="color: green">All Uncleared Payments</small></h3>
    <div class="row">
            <div class="panel">

                <div class="panel-body">
                    <table class="table  responsive-table" id="products" style="font-size: 0.9em !important">
                        <thead>
                            <tr style="color: ">

                                <th>Customer</th>
                                <th>Organization</th>
                                <th>Date</th>
                                <th>Invoice No</th>

                                <th>Amount Paid</th>
                                <th>Balance</th>
                                <th style="width: 15% !important;">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($debtors as $pay)
                                @if ($pay->amount-$pay->jobs->payment->sum('amountpaid')>0)
                                    <tr>

                                        <td><b>{{$pay->contact ? $pay->contact->name : $pay->customerid}}</b>
                                        </td>
                                        <td>{{$pay->contact ? $pay->contact->organization : ''}}</td>
                                        <td>{{$pay->dated}}</td>
                                        <td>{{$pay->invoiceno}}</td>

                                        <td><b>{{number_format($pay->amountpaid,2)}}</b></td>
                                        <td>{{$pay->amount-$pay->jobs->payment->sum('amountpaid')}}</td>

                                        <td>
                                            <a href="{{url('/invoice/'.$pay->jobno.'/invoice')}}" target="_blank" class="label label-info roledlink Finance Super">Invoice</a>
                                            <a href="{{url('/invoice/'.$pay->jobno.'/receipt')}}" target="_blank" class="label label-primary roledlink Finance Super">Receipt</a>
                                            <a href="{{url('/delete/'.$pay->id.'/payments')}}" class="label label-danger roledlink Super Admin"  onclick="return confirm('Are you sure you want to delete this record? {{$pay->description}}?')">Delete</a>
                                        </td>

                                    </tr>
                                @endif
                            @endforeach


                        </tbody>


                    </table>

                    <div style="text-align: right; color: #337ab7;">
                        <span>	&darr; Older Records Navigation | <small>each number contains 400 records</small></span>
                        {{$debtors->links()}}
                    </div>
                </div>
            </div>

    </div>





@endsection
