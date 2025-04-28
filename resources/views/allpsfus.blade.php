@extends('layouts.theme')

<style>
    td input{
        font-size: 0.9em !important;
    }

    select {

        padding: 2px 5px; /* Adjust padding values as needed */

        font-size: 0.8em !important; /* Set desired text size */

    }
</style>
@section('content')
    @php $pagetype="report"; @endphp

    <h3 class="page-title">PSFU Reports | <small style="color: green">Customer Service</small></h3>
    <div class="row">
            <div class="panel">

                <div class="panel-body">
                    <table class="table  responsive-table" id="products" style="font-size: 12px !important; width: 100%">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Job No</th>
                                    <th>PSFU Date</th>
                                    <th>Satisfied</th>
                                    <th>Treatment</th>
                                    <th>Waited Long</th>
                                    <th>Explained</th>
                                    <th>Ready</th>
                                    <th>Time Score</th>
                                    <th>Impressed</th>
                                    <th>Recommend</th>
                                    <th>Outcome</th>
                                    <th>Discussion</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @foreach($allpsfus as $ps)
                                <tr>
                                    <td>{{$ps->jobs->contact->name}}</td>
                                    <td>{{$ps->jobs->jid}}</td>
                                    <td>{{$ps->psfudate}}</td>
                                    <td>{{$ps->satisfied}}</td>
                                    <td>{{$ps->treatment}}</td>
                                    <td>{{$ps->waitedlong}}</td>
                                    <td>{{$ps->explained}}</td>
                                    <td>{{$ps->ready}}</td>
                                    <td>{{$ps->timescore}}</td>
                                    <td>{{$ps->impressed}}</td>
                                    <td>{{$ps->recommend}}</td>
                                    <td>{{$ps->outcome}}</td>
                                    <td>{{$ps->discussion}}</td>
                                    <td>{{$ps->status}}</td>
                                    <td>
                                        <a href="/delete-psfu/{{$ps->psfuid}}" class="roledlink Super Admin btn btn-xs btn-danger"><i class="fa fa-remove"></i>Delete</a>
                                    </td>
                                </tr>

                            @endforeach
                    </table>
                </div>
            </div>

    </div>



@endsection
