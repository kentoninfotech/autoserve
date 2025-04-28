@extends('layouts.theme')

@section('content')
@php $pagename="namesearch"; $sn=1; @endphp
    <h3 class="page-title">Job | <small style="color: green">Create / Edit Job</small></h3>
    <div class="row">
            <div class="panel">
                <div class="panel-heading">
                        <h4>New Customer</h4>
                </div>
                <div class="panel-body">
                    @php
                        if(!isset($editjobno)){
                            $editjobno = "";
                        }
                        if(!isset($job)){

                                $job = $new_job;
                                $job->id = 0;
                                $job->jobno = $jobno;

                                $vehicle=[];
                                $job->serviceorder = [];
                                $job->diagnosis = [];
                                $job->sale = [];

                            $customerid = "TAS".strtoupper(substr(md5(uniqid(rand(1,6))), 0, 7));
                        }else{
                            $jobno = $job->id;
                            if(isset($job->vehicle)){
                            $vehicle = $job->vehicle;
                            echo $vehicle->vregno;
                            }
                        }
                        $users= \App\Models\User::select('id','name')->get();
                    @endphp

                    <form method="POST" action="{{ route('addnewcustomer') }}" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="{{$job->id}}">
                            <input type="hidden" name="jobno" value="{{$job->jobno}}">
                            <input type="hidden" name="editjobno" value="{{$editjobno}}">
                            <input type="hidden" name="jobid" value="{{$job->jobid}}">
                            <input type="hidden" id="oldtotalamount" value="{{$job->amount}}">
                            <input type="hidden" name="old_diagnosis_file" value="{{$job->diagnosis ? $job->diagnosis->diagnosis : ""}}">
                        @csrf
                        <ul class="nav nav-tabs" id="jobordertabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">Contact Information</a></li>
                            <li><a href="#tab2" data-toggle="tab">Vehicle Details</a></li>
                            <li><a href="#tab3" data-toggle="tab">Service</a></li>
                            <li><a href="#tab4" data-toggle="tab">Vehicle  Diagnosis</a></li>
                            <li><a href="#tab5" data-toggle="tab">Parts / Cost</a></li>
                            <li><a href="#tab6" data-toggle="tab">Additional Confirmations</a></li>
                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane active" id="tab1">
                                <div class="row form-row">
                                    <div class="form-group col-md-6">
                                    <label for="name">Full Name</label>
                                    <input type="text" name="name" id="name" list="names" class="form-control" placeholder="Customer Name" value="{!!$job->contact ? $job->contact->name:''!!}">
                                    <datalist id="names">
                                        @foreach ($allcontacts as $con)
                                            <option value="{!!$con->name!!}" data-customerid="{{$con->customerid}}">{!!$con->organization!!}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                                    <div class="form-group col-md-6">
                                        <label for="organization">Organization</label>
                                        <input type="text" name="organization" id="organization" class="form-control" placeholder="Organization Name"  value="{{$job->contact ? $job->contact->organization:''}}">
                                    </div>

                                </div>

                                <div class="row form-row">
                                    <div class="form-group col-md-12">
                                        <label for="address">Address</label>
                                        <input type="text" name="address" id="address" class="form-control" placeholder="Address" value="{{$job->contact ? $job->contact->address:''}}">
                                    </div>
                                </div>

                                <div class="row form-row">
                                    <div class="form-group col-md-6">
                                    <label for="telephoneno">Telephone No</label>
                                    <input type="text" name="telephoneno" id="telephoneno" class="form-control" placeholder="Phone Number" value="{{$job->contact ? $job->contact->telephoneno:''}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email" class="form-control" placeholder="E-mail Address" value="{{$job->contact ? $job->contact->email:''}}">
                                    </div>

                                </div>

                                <div class="row form-row">

                                    <div class="form-group col-md-3">
                                        <label>Sundry</label>
                                        <div>
                                            <input type="radio" id="Yes"  {{$job->contact ? $job->contact->sundry=='2500' ? 'checked':'' : ''}}
                                            name="sundry" value="2500">
                                            <span for="Yes">Yes</span>

                                            <input type="radio" id="No"  {{$job->contact ? $job->contact->sundry!='2500' ? 'checked':'' : ''}}
                                            name="sundry" value="0">
                                            <span for="No">No</span>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Vat</label>
                                        <div>
                                            <input type="radio" id="five"  {{$job->contact ? $job->contact->vat=='5' ? 'checked':'' : ''}}
                                            name="vat" value="5">
                                            <span for="five">5%</span>

                                            <input type="radio" id="sevenpointfive"  {{$job->contact ? $job->contact->vat=='7.5' ? 'checked':'' : ''}}
                                            name="vat" value="7.5">
                                            <span for="sevenpointfive">7.5 %</span>

                                            <input type="radio" id="0"  {{$job->contact ? $job->contact->vat=='0' ? 'checked':'' : ''}}
                                            name="vat" value="0">
                                            <span for="0"> No Vat</span>

                                        </div>

                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Credit</label>
                                        <div>
                                            <input type="radio" id="Yes"  {{$job->contact ? $job->contact->credit=='Yes' ? 'checked':'' : ''}}
                                            name="credit" value="Yes">
                                            <span for="Yes">Yes</span>

                                            <input type="radio" id="No"  {{$job->contact ? $job->contact->credit=='No' ? 'checked':'' : ''}}
                                            name="credit" value="No">
                                            <span for="No">No</span>
                                        </div>
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label for="remarks">Remarks</label>
                                        <input type="text" name="remarks" id="remarks" class="form-control" placeholder="Remarks" value="{{$job->contact ? $job->contact->remarks:''}}">
                                    </div>
                                </div>
                                <a class="btn btn-primary btnNext" >Next</a>
                            </div>

                            <div class="tab-pane" id="tab2">
                                <div class="row form-row">
                                    <div class="form-group col-md-4">
                                        <label for="customerid">Customer ID</label>
                                        <input type="text" name="customerid" id="customerid" class="form-control" placeholder="Customer ID" value="{{$job->contact ? $job->contact->customerid:$customerid}}" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="vregno">Vehicle Registration No:</label>
                                        <input type="text" name="vregno" id="vregno" class="form-control" placeholder="Vehicle Registration No" value="{{$vehicle ? $vehicle->vregno:''}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="regdate">Vehicle Reg. Date</label>
                                        <input type="text" name="regdate" id="regdate" class="form-control date" placeholder="First Visit Date" value="{{$vehicle ? $vehicle->regdate:''}}">
                                    </div>
                                </div>

                                <div class="row form-row">
                                    <h5>Vehicle Category</h5>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                          <label for="modelname">Model Name</label>
                                          <input type="text"
                                            class="form-control" name="modelname" id="modelname" placeholder="Model Name" value="{{$vehicle ? $vehicle->modelname:''}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                          <label for="modelno">Model Number</label>
                                          <input type="text"
                                            class="form-control" name="modelno" id="modelno" placeholder="Model Number/Year" value="{{$vehicle ? $vehicle->modelno:''}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                          <label for="frameno">Chasis Number</label>
                                          <input type="text"
                                            class="form-control" name="frameno" id="frameno" placeholder="Chasis Number" value="{{$vehicle ? $vehicle->frameno:''}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-row">
                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                          <label for="vin">Current Mileage Reading</label>
                                          <input type="text"
                                            class="form-control" name="vin" id="vin" placeholder="Mileage Reading" value="{{$vehicle ? $vehicle->vin:''}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                          <label for="chasisno">Chasis Number</label>
                                          <input type="text"
                                            class="form-control" name="chasisno" id="chasisno" placeholder="Chasis Number" value="{{$vehicle ? $vehicle->chasisno:''}}">
                                        </div>
                                    </div>

                                </div>

                                <div class="row form-row">
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                          <label for="color">Color</label>
                                          <input type="text"
                                            class="form-control" name="color" id="color" placeholder="Color" value="{{$vehicle ? $vehicle->color:''}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="vcondition">Vehicle Condition</label>
                                        <input type="text" name="vcondition" id="vcondition" class="form-control" placeholder="Vehicle Condition" value="{{$vehicle ? $vehicle->vcondition:''}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="daterecieved">Date Recieved</label>
                                        <input type="text" name="daterecieved" id="daterecieved" class="form-control date" placeholder="Date Recieved" value="{{$vehicle ? $vehicle->daterecieved:''}}">
                                    </div>

                                </div>

                                <a class="btn btn-primary btnPrevious">Previous</a><a class="btn btn-primary btnNext" >Select Service</a>

                                <a class="btn btn-warning" id="gotodiagnosis">Vehicle Diagnosis</a>

                            </div>

                            <div class="tab-pane" id="tab3">

                                <datalist id="servicelist">
                                    @foreach ($services as $srv)
                                        <option value="{{$srv->servicename}}" data-sid="{{ $srv->id }}" data-servicecost="{{$srv->amount}}">
                                    @endforeach
                                </datalist>

                               @if ($job->serviceorder!=[])
                                   @foreach ($job->serviceorder as $so)
                                        <div class="row form-row">
                                            <div class="form-group col-md-6">
                                                <input list="servicelist" value="{{$so ? $so->servicename:''}}" placeholder="Periodic Maintenance"
                                                name="servicename[]" class="form-control" id="sn{{$so->id}}"  onchange="getServiceCost({{$so->id}})">

                                            </div>

                                            <div class="form-group col-md-6">
                                                <div>
                                                <input type="text" value="{{$so ? $so->description:''}}" placeholder="Description"
                                                name="description[]" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                   @endforeach
                               @else
                                    <div id="services">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="servicename">Service Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="description">Description</label>
                                            </div>
                                        </div>
                                            @php
                                                $si = 1;
                                            @endphp
                                            <div class="row form-row serviceslist" id="{{$si}}">
                                                <div class="form-group col-md-6">

                                                    <div>

                                                    <input list="servicelist" value="" placeholder="Periodic Maintenance"
                                                    name="servicename[]" class="form-control" id="sn{{$si}}"  onchange="getServiceCost({{$si}})" >
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <div>

                                                    <input type="text" id="description" placeholder="Description"
                                                    name="description[]" class="form-control" value="" >
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                               @endif

                               <div style="text-align: center !important;"><span class="btn btn-success" onclick="addService()">Add More Services</span></div>


                                <div class="row form-row">
                                    <div class="form-group col-md-3">
                                        <label for="mileage">Service Mileage</label>
                                        <div>

                                        <input type="text" id="mileage" value="{{$job->serviceorder ? $job->serviceorder->first()->mileage ?? '' : ''}}" placeholder="mileage"
                                        name="mileage" class="form-control" >
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="sdate">Service Date</label>
                                        <div>

                                        <input type="text" id="sdate" value="{{$job->serviceorder ? $job->serviceorder->first()->sdate ?? '':''}}" placeholder="sdate"
                                        name="sdate" class="form-control date" >
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="nextservicedate">Next Service Date</label>
                                        <div>

                                        <input type="text" id="nextservicedate" value="{{$job->serviceorder ? $job->serviceorder->first()->nextservicedate ?? '':''}}" placeholder="nextservicedate"
                                        name="nextservicedate" class="form-control date" >
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="sstatus">Status</label>
                                        <div>
                                        <select name="sstatus" id="sstatus" class="pending">
                                            <option value="{{$job->serviceorder ? $job->serviceorder->first()->status ?? '':'Pending'}}" selected>{{$job->serviceorder ? $job->serviceorder->first()->status ?? '':'Pending'}}</option>
                                            <option value="Just Arrived">Just Arrived</option>
                                            <option value="Pending">Pending</option>
                                            <option value="In Progress">In Progress</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>

                                <a class="btn btn-warning btnPrevious" >Previous</a><a class="btn btn-primary btnNext" >Next</a>

                            </div>

                            <div class="tab-pane" id="tab4">
                                <h5>Vehicle Diagnosis</h5>
                                <div class="row form-row">

                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                          <label for="problems">Problems Found</label>
                                          <textarea class="form-control" name="problems" id="problems" rows="3">{{strip_tags($job->diagnosis ? $job->diagnosis->problems:'')}}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                          <label for="causes">Causes</label>
                                          <textarea class="form-control" name="causes" id="causes" rows="3">{{strip_tags($job->diagnosis ? $job->diagnosis->causes:'')}}</textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="row form-row">
                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                          <label for="request">Customer Requests</label>
                                          <textarea class="form-control" name="request" id="request" rows="3">{{strip_tags($job->diagnosis ? $job->diagnosis->request:'')}}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                          <label for="instructions">Instructions for Technician</label>
                                          <textarea class="form-control" name="instructions" id="instructions" rows="3">{{strip_tags($job->diagnosis ? $job->diagnosis->instructions:'')}}</textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="row form-row">
                                    <div class="form-group col-md-3">
                                        <label for="diagnosis">Upload Diagnosis Result</label>
                                        <div>

                                        <input type="file" id="diagnosis" name="diagnosis"  class="form-control" >
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-row">
                                    <div class="form-group col-md-3">
                                        <label for="ddate">Diagnosis Date</label>
                                        <div>

                                        <input type="text" id="ddate" value="{{$job->diagnosis ? $job->diagnosis->diagnosisdate:''}}" placeholder="Date"
                                        name="ddate" class="form-control date" >
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="deliverydate">Expected Delivery Date</label>
                                        <div>

                                        <input type="text" id="diagnosis" value="{{$job->diagnosis ? $job->diagnosis->deliverydate:''}}" placeholder="Expected Delivery Date"
                                        name="deliverydate"  class="form-control date" >
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="remarks">Remarks</label>
                                        <div>

                                        <input type="text" id="remarks" value="{{$job->diagnosis ? $job->diagnosis->remarks:''}}" placeholder="Remarks"
                                        name="status" class="form-control" >
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="status">Status</label>
                                        <div>

                                        <select name="status" id="status" class="form-control">
                                            <option value="{{$job->diagnosis ? $job->diagnosis->status:'Pending'}}" selected>{{$job->diagnosis ? $job->diagnosis->status:'Pending'}}</option>
                                            <option value="Just Arrived">Just Arrived</option>
                                            <option value="Pending">Pending</option>
                                            <option value="In Progress">In Progress</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>

                                <a class="btn btn-warning btnPrevious" >Previous</a><a class="btn btn-primary btnNext" >Next</a>

                            </div>

                            <div class="tab-pane" id="tab5">
                                <h4>Parts Needed</h4>
                                <div id="parts">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="partname">Part Name</label>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="quantity">Quantity</label>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="rate">Rate</label>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="amount">Amount</label>
                                        </div>

                                    </div>

                                    <datalist id="productslist">
                                        @foreach ($parts as $pas)
                                            <option value="{{$pas->part_name}}" data-pid="{{ $pas->id }}" data-price="{{$pas->selling_price}}"  data-instock="{{ $pas->stock->quantity_in_stock ?? 0 }}">
                                        @endforeach
                                    </datalist>

                                    @if(!empty($job->partsorder))

                                        @php $pi = 1; @endphp

                                        @foreach($job->partsorder as $part)

                                            @if(($part->partsname!="Labour") && ($part->partsname!="Discount"))

                                                <div class="row form-row partslist" id="{{$pi}}">

                                                    <div class="form-group col-md-4">
                                                        <div class="form-group">
                                                        <input type="text" class="form-control partname"  id="pn{{$pi}}" onchange="updateId({{$pi}})"  name="partname[]" placeholder="Part Name" value="{{$part->partsname}} - {{$part->partno}}">
                                                            <input type="hidden" name="pnid[]" id="pnid{{$pi}}" value="{{$part->pid}}">
                                                            <span><small id="instock{{$pi}}"></small></span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-2">
                                                        <div class="form-group">
                                                        <input type="number" class="form-control quantity" id="q{{$pi}}"  name="quantity[]"  value="{{$part->quantity}}">
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-2">
                                                        <div class="form-group">
                                                        <input type="number" class="form-control rate" name="rate[]"  id="r{{$pi}}" value="{{$part->quantity>0 ? $part->amount/$part->quantity : 0}}">
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <div class="form-group">
                                                        <input type="number" class="form-control amount" id="a{{$pi}}" name="amount[]" value="{{$part->amount}}">
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-1">
                                                        <span class="btn btn-xs btn-primary premover" onclick="removePl({{$pi}})">Remove</span>
                                                    </div>
                                                </div>
                                                @php $pi++; @endphp
                                            @endif
                                        @endforeach
                                    @else
                                        @php $pi = 1; @endphp

                                        <div class="row form-row partslist" id="{{$pi}}">

                                            <div class="form-group col-md-4">
                                                <div class="form-group">
                                                    <input list="productslist" id="pn{{$pi}}" onchange="updateId({{$pi}})" class="form-control partname" name="partname[]" placeholder="Part Name">
                                                    <input type="hidden" name="pnid[]" id="pnid{{$pi}}">
                                                    <span><small id="instock{{$pi}}"></small></span>

                                                </div>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <div class="form-group">
                                                <input type="number" class="form-control quantity" id="q{{$pi}}"  name="quantity[]" value="1">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <div class="form-group">
                                                <input type="number" class="form-control rate" id="r{{$pi}}" name="rate[]" value="1">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <div class="form-group">
                                                <input type="number" class="form-control amount" id="a{{$pi}}" name="amount[]" value="0">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-1">
                                                <span class="btn btn-xs btn-primary premover" onclick="removePl({{$pi}})">Remove</span>
                                            </div>
                                        </div>

                                    @endif

                                </div>


                                <div style="text-align: center !important;"><span class="btn btn-success" id="partsaddbtn" onclick="addPl()">Add Parts</span></div>


                                <div class="row form-row">

                                    <div class="form-group col-md-9">
                                        <div class="form-group" style="text-align: right; font-weight: bold;">
                                            Labour Cost
                                        </div>
                                    </div>


                                    <div class="form-group col-md-3">
                                        <div class="form-group">
                                        <input type="number" class="form-control" name="labour" id="labour" value="{{$job->labour ? $job->labour : 0}}">
                                        </div>
                                    </div>


                                </div>

                                <div class="row form-row">
                                    <div class="form-group col-md-9">
                                        <div class="form-group" style="text-align: right; font-weight: bold;">
                                            Vat <span id="vatview"></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="form-group">
                                        <input type="number" step="0.01" class="form-control" name="vatcost" id="vatcost" value="{{$job->vat ? $job->vat : 0}}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-row">
                                    <div class="form-group col-md-9">
                                        <div class="form-group" style="text-align: right; font-weight: bold;">
                                            Sundry
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="form-group">
                                        <input type="number" class="form-control" name="sundrycost" id="sundrycost" value="{{$job->sundry ? $job->sundry : 0}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-row">
                                    <div class="form-group col-md-6">
                                        <div class="form-group" style="text-align: right; font-weight: bold;">
                                            Discount (in Percentage %)
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="form-group">
                                        <input type="number" class="form-control" name="discountpercent" id="discountpercent" step="0.01" value="0">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="form-group">
                                        <input type="number" class="form-control" name="discountcost" id="discountcost" value="{{$job->discount ? $job->discount : 0}}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-row">
                                    <div class="form-group col-md-9">
                                        <div class="form-group" style="text-align: right; font-weight: bold;">
                                            TOTAL AMOUNT
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="form-group">
                                        <input type="number" step="0.01" class="form-control" name="totalamount" id="totalamount" value="{{$job->amount ? $job->amount : 0}}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <a class="btn btn-warning btnPrevious" >Previous</a><a class="btn btn-primary btnNext" >Next</a>

                            </div>

                            <div class="tab-pane" id="tab6">

                                <div class="row form-row">
                                    <h4>Additional Confirmations</h4>

                                        <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="valuables" id="valuables" value="Yes">
                                            Valuables in the Car?
                                        </label>
                                        </div>

                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="car_wash" id="car_wash" value="Yes">
                                            Car Wash Needed?
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="keep_rparts" id="keep_rparts" value="Yes">
                                            Keep Replaced Parts?
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="seat_cover" id="seat_cover" value="Yes">
                                            Car has Seat Cover?
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="floor_mat" id="floor_mat" value="Yes">
                                            Car has Floor Mat?
                                            </label>
                                        </div>


                                </div>

                                <a class="btn btn-warning btnPrevious" >Previous</a><button type="submit" class="btn btn-success btnNext" >Save Order</button>

                            </div>


                        </div>

                    </form>
                </div>
            </div>

    </div>
@endsection
