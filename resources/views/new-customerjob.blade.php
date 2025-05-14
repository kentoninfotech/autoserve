@extends('layouts.theme')

@section('content')
    <h3 class="page-title">Job | <small style="color: green">Create/Edit Job</small></h3>
    <div class="row">
            <div class="panel">
                <div class="panel-heading">

                        <h4>New Job for Customer: {{$contact->name}}</h4>


                </div>
                <div class="panel-body">
                    @php
                            if(!isset($editjobno)){
                                    $editjobno = "";
                                }

                            if(!isset($job)){
                                $job = $new_job;

                                    if(isset($vehicleinfo)){
                                        $vehicle=$vehicleinfo;
                                    }else{
                                        $vehicle=[];
                                    }

                            }
                    @endphp

                       <form method="POST" action="{{ route('addnewcustomer') }}" enctype="multipart/form-data">

                            <input type="hidden" name="id" value="{{$job->id}}">
                            <input type="hidden" name="jobno" value="{{$jobno}}">
                            <input type="hidden" name="editjobno" value="{{$editjobno}}">
                            <input type="hidden" name="jobid" value="">
                            <input type="hidden" name="newcjob" value="newcjob">
                            <input type="hidden" name="old_diagnosis_file" value="{{$job->diagnosis ? $job->diagnosis->diagnosis : ""}}">


                        @csrf
                        <ul class="nav nav-tabs" id="jobordertabs">
                            <li class="active"><a href="#tab2" data-toggle="tab">Vehicle Details</a></li>
                            <li><a href="#tab3" data-toggle="tab">Service</a></li>
                            <li><a href="#tab4" data-toggle="tab">Vehicle  Diagnosis</a></li>
                            <li><a href="#tab5" data-toggle="tab">Parts / Cost</a></li>
                            <li><a href="#tab6" data-toggle="tab">Additional Confirmations</a></li>
                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane active" id="tab2">
                                <div class="row form-row">
                                    <div class="form-group col-md-4">
                                        <label for="customerid">Customer ID</label>
                                        <input type="text" name="customerid" id="customerid" class="form-control" placeholder="Customer ID" value="{{$contact->customerid}}" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="vregno">Vehicle Registration No</label>
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
                                            class="form-control" name="frameno" id="frameno" placeholder="Frame Number" value="{{$vehicle ? $vehicle->frameno:''}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-row">
                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                          <label for="vin">Current Mileage Reading</label>
                                          <input type="text"
                                            class="form-control" name="vin" id="vin" placeholder="Vin Number" value="{{$vehicle ? $vehicle->vin:''}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                          <label for="chasisno">VIN Number</label>
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

                                <a class="btn btn-primary btnNext" >Service</a>

                                <a class="btn btn-warning" id="gotodiagnosis">Vehicle Diagnosis</a>

                            </div>

                            <div class="tab-pane" id="tab3">

                                <datalist id="servicelist">
                                    @foreach ($services as $srv)
                                        <option value="{{$srv->servicename}}" data-sid="{{ $srv->id }}" data-servicecost="{{$srv->amount}}">
                                    @endforeach
                                </datalist>

                                <div id="services">
                                    @php
                                        $si = 1;
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="servicename">Service Name</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="description">Description</label>
                                        </div>
                                    </div>

                                    <div class="row form-row serviceslist" id="sl{{$si}}">
                                        <div class="form-group col-md-6">

                                            <div>
                                            <input list="servicelist" value="" placeholder="Routine Maintenance"
                                            name="servicename[]" class="form-control"  id="sn{{$si}}" onchange="getServiceCost({{$si}})">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <div>
                                            <input type="text" id="description" placeholder="Description"
                                            name="description[]" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div style="text-align: center !important;"><span class="btn btn-success" onclick="addService()">Add More Services</span></div>

                                <div class="row form-row">
                                    <div class="form-group col-md-3">
                                        <label for="mileage">Service Mileage</label>
                                        <div>

                                        <input type="text" id="mileage" placeholder="mileage"
                                        name="mileage" class="form-control" >
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="sdate">Service Date</label>
                                        <div>

                                        <input type="text" id="sdate" placeholder="sdate"
                                        name="sdate" class="form-control date" >
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="nextservicedate">Next Service Date</label>
                                        <div>

                                        <input type="text" id="nextservicedate" placeholder="nextservicedate"
                                        name="nextservicedate" class="form-control date" >
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="sstatus">Status</label>
                                        <div>
                                        <select name="sstatus" id="sstatus" class="pending">
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
                                          <textarea class="form-control" name="problems" id="problems" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                          <label for="causes">Causes</label>
                                          <textarea class="form-control" name="causes" id="causes" rows="3"></textarea>
                                        </div>
                                    </div>

                                </div>


                                <div class="row form-row">

                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                          <label for="request">Customer Requests</label>
                                          <textarea class="form-control" name="requests" id="request" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                          <label for="instructions">Instructions for Technician</label>
                                          <textarea class="form-control" name="instructions" id="instructions" rows="3"></textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="row form-row">
                                    <div class="form-group col-md-6">
                                        <label for="diagnosis">Upload Diagnosis Result</label>
                                        <div>

                                        <input type="file" id="diagnosis" name="diagnosis"  class="form-control" >
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="images">Upload Images</label>
                                        <div>

                                        <input type="file" id="images" name="images[]"  class="form-control" multiple>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-row">
                                    <div class="form-group col-md-3">
                                        <label for="ddate">Diagnosis Date</label>
                                        <div>

                                        <input type="text" id="ddate" value="" placeholder="Date"
                                        name="ddate" class="form-control date" >
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="deliverydate">Expected Delivery Date</label>
                                        <div>

                                        <input type="text" id="diagnosis" value="" placeholder="Expected Delivery Date"
                                        name="deliverydate"  class="form-control date" >
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="remarks">Remarks</label>
                                        <div>

                                        <input type="text" id="remarks" value="" placeholder="Remarks"
                                        name="status" class="form-control" >
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="status">Status</label>
                                        <div>
                                        <select name="status" id="status" class="pending">
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

                                        @php $pi = 1; @endphp
                                        <datalist id="productslist">
                                            @foreach ($parts as $pas)
                                                <option value="{{$pas->part_name}}" data-pid="{{ $pas->id }}" data-price="{{$pas->selling_price}}"  data-instock="{{ $pas->stock->quantity_in_stock ?? 0}}">
                                            @endforeach
                                        </datalist>
                                        <div class="row form-row partslist" id="{{$pi}}">

                                            <div class="form-group col-md-4">
                                                <div class="form-group">
                                                    <input list="productslist" id="pn{{$pi}}" onchange="updateId({{$pi}})" class="form-control partname" name="partname[]" placeholder="Product Name">
                                                    <input type="hidden" name="pnid[]" id="pnid{{$pi}}">
                                                    <span><small id="instock{{$pi}}"></small></span>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <div class="form-group">
                                                <input type="number" step="0.01" class="form-control quantity" id="q{{$pi}}" name="quantity[]" value="1">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <div class="form-group">
                                                <input type="number" step="0.01" class="form-control rate" id="r{{$pi}}" name="rate[]" value="1">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <div class="form-group">
                                                <input type="number" step="0.01" class="form-control amount" id="a{{$pi}}" name="amount[]" value="0">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-1">
                                                <span class="btn btn-xs btn-primary premover" onclick="removePl({{$pi}})">Remove</span>
                                            </div>
                                        </div>



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
                                        <input type="number" step="0.01" class="form-control" name="labour" id="labour" value="{{$job->labour ? $job->labour : 0}}">
                                        </div>
                                    </div>


                                </div>

                                <div class="row form-row">

                                    <div class="form-group col-md-3">
                                        <label>Sundry</label>
                                        <div>
                                            <input type="radio" id="Yes"  {{$contact ? $contact->sundry=='2500' ? 'checked':'' : '0'}}
                                            name="sundry" value="2500" class="sundry">
                                            <span for="Yes">Yes</span>

                                            <input type="radio" id="No"  {{$contact ? $contact->sundry!='2500' ? 'checked':'' : '0'}}
                                            name="sundry" value="0" class="sundry">
                                            <span for="No">No</span>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Vat</label>
                                        <div>
                                            <input type="radio" id="five"  {{$contact ? $contact->vat=='5' ? 'checked':'' : '0'}}
                                            name="vat" value="5" class="vat">
                                            <span for="five">5%</span>

                                            <input type="radio" id="sevenpointfive"  {{$contact ? $contact->vat=='7.5' ? 'checked':'' : '0'}}
                                            name="vat" value="7.5" class="vat">
                                            <span for="sevenpointfive">7.5 %</span>

                                            <input type="radio" id="0"  {{$contact ? $contact->vat=='0' ? 'checked':'' : '0'}}
                                            name="vat" value="0" class="vat">
                                            <span for="0"> No Vat</span>

                                        </div>

                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Credit</label>
                                        <div>
                                            <input type="radio" id="Yes"  {{$contact ? $contact->credit=='Yes' ? 'checked':'' : '0'}}
                                            name="credit" value="Yes">
                                            <span for="Yes">Yes</span>

                                            <input type="radio" id="No"  {{$contact ? $contact->credit=='No' ? 'checked':'' : '0'}}
                                            name="credit" value="No">
                                            <span for="No">No</span>
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
                                        <input type="number" step="0.01" class="form-control" name="sundrycost" id="sundrycost" value="{{$job->sundry ? $job->sundry : 0}}">
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
                                        <input type="number" step="0.01" class="form-control" name="discountpercent" id="discountpercent" value="0">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="form-group">
                                        <input type="number" step="0.01" class="form-control" name="discountcost" id="discountcost" value="{{$job->discount ? $job->discount : 0}}" readonly>
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

                                <a class="btn btn-warning btnPrevious" >Previous</a><button type="submit" class="btn btn-success btnNext" >Send Order</button>

                            </div>

                        </div>

                    </form>
                </div>
            </div>

    </div>
@endsection
