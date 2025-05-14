@extends('layouts.print-theme')

@section('content')
<style>
    @page { margin: 0px !important; }
    body { margin: 0px !important; }
    @page { margin-top: 10px !important; }
    table {
    border-collapse: collapse !important;
    }
    th, td {
        padding: 0 !important;
    }
    .page-break {
        page-break-before: always; 
    }
</style>

    @php

    $locale = 'en_US';
    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);

    @endphp

    <h3 class="page-title" style="text-align: center; font-weight: bold;">{{$title}}
        @if ($title=="INVOICE")
            <span style="position: absolute; right:40px; font-size:0.5em !important;">{{$title}} NO: {{$job->jid}}</span>
        @endif
    </h3>



                @if ($title=="RECEIPT")
                    @if($job!==null)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th >Customer Name:</th>
                                    <th>Organization:</th>
                                    <th>Job No:</th>
                                    <th>Date:</th>
                                </tr>
                                <tr>
                                    <td>{{$job->contact->name}}</td>
                                    <td>{{$job->contact->organization}}</td>
                                    <td>{{$job->invoiceno}}</td>
                                    <td>{{date("dS M, Y",strtotime($job->dated))}}</td>
                                    <!-- ,strtotime($job->dated))-->
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td colspan="4">
                                        Being payment for {{$job->title ? $job->title : "Invoice No: ".$job->invoiceno}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Amount Paid:</td>
                                    <td><del style="text-decoration-style: double;">N</del>{{number_format($job->amountpaid,2)}}</td>
                                    <td>Balance:</td>
                                    <td><del style="text-decoration-style: double;">N</del>{{number_format($job->amount - $job->jobs->payment->sum('amountpaid'),2)}}</td>
                                </tr>

                                <tr>
                                    <td>Amount paid in Words:</td>
                                    <td colspan="3" style="text-align: left; font-weight: bold;">
                                    @php

                                        if (strpos($job->amountpaid, '.') !== false) {
                                            $amountarray = explode(".",floatval($job->amountpaid));
                                            if(strlen($amountarray[1])==1){
                                                $amountarray[1]=$amountarray[1]*10;
                                            }
                                            if($amountarray[1]>0){
                                                if(isset($amountarray[0])){
                                                    echo ucwords(numfmt_format($fmt, $amountarray[0]))." Naira ".ucwords(numfmt_format($fmt, $amountarray[1]))." Kobo";
                                                }
                                            }
                                        }else{
                                            echo ucwords(numfmt_format($fmt, $job->amountpaid))." Naira Only";
                                        }
                                    @endphp

                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2"><br><br>
                                        _________________________<br>
                                        Customer's Signature</td>

                                    <td colspan="2" style="text-align: right;">
                                    <!-- <img  src="{{ asset('/images/signature.png') }}" alt="{{$settings->motto}}" style="width: auto; height: 150px; position: absolute; margin-top: -50px; z-index: 99999; right: 50"> -->
                                        <br><br>_____________________<br>Manager's Signature</td>
                                </tr>
                                <tr>
                                        <td colspan="4">
                                            <hr>
                                        {{-- <img  src="{{ asset('/images/aptfooter.jpg') }}" alt="{{ Auth::user()->settings->motto}}" style="width: 100%; height: 20px;"> --}}
                                        </td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <h3>No Payment yet. This reciept is not available.</h3>
                    @endif
                @else
                    <table style="font-size:0.7em !important; width:95%" class="table table-striped table-bordered  table-condensed" align="center" border="1">
                        <thead class="thead-inverse">
                            <tr>
                                <th style="text-align: right; font-weight: bold;">Customer Name/ID:</th>
                                <th>{{$job->contact->name}} / {{$job->customerid}}</th>
                                <th style="text-align: right; font-weight: bold;">Date:</th>
                                @php
                                if(null !== Session::get('newdate')){
                                    echo $date = Session::get('newdate');
                                }else{
                                    $date = $job->dated;
                                }
                                @endphp
                                <th>{{date("dS M, Y",strtotime($date))}}</th>
                                <!-- // date("dS M, Y",strtotime($job->dated)) -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row" style="text-align: right; font-weight: bold;">Organization:</td>
                                <td colspan="3">{{$job->contact->organization}}</td>
                            </tr>
                            <tr>
                                <td scope="row" style="text-align: right; font-weight: bold;">Phone Number:</td>
                                <td>{{$job->contact->telephoneno}}</td>
                                <td style="text-align: right; font-weight: bold;">E-mail:</td>
                                <td>{{$job->contact->email}}</td>
                            </tr>

                            <tr>
                                <td scope="row" style="text-align: right; font-weight: bold;">Address:</td>
                                <td colspan="3">{{$job->contact->address}}</td>

                            </tr>
                            @if($title!="SALES")
                                <tr>
                                    <td scope="row" style="text-align: right; font-weight: bold;">Vin/Chasis No:</td>
                                    <td>{{$vehicle ? $vehicle->chasisno : ''}}</td>
                                    <td style="text-align: right; font-weight: bold;">Mileage Reading:</td>
                                    <td>{{$job->odometer ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td scope="row" style="text-align: right; font-weight: bold;">Vehicle Make/Model</td>
                                    <td>{{$vehicle->modelname ?? '' }} / {{$vehicle->modelno ?? ''}}</td>
                                    <td style="text-align: right; font-weight: bold;">Reg. No:</td>
                                    <td>{{$vehicle->vregno ?? ''}}</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>

                    @isset($job->serviceorder)

                        <table width="100%" style="font-size: 0.9em !important; width:95%" class="table table-striped table-bordered  table-condensed" align="center">

                            <tr style="color: ">

                                <th>Service Name</th>
                                <th>Description</th>
                            </tr>

                            @foreach ($job->serviceorder as $service)

                                <tr>
                                    <td>{{$service->servicename}}</td>
                                    <td>{{$service->description}}</td>
                                </tr>

                            @endforeach
                        </table>

                    @endisset


                    <table width="100%" style="font-size: 0.9em !important; width:95%" class="table table-striped table-bordered  table-condensed" align="center">

                            <tr style="color: ">

                                <th>Parts Used (Decription)</th>
                                <th>Quantity</th>

                                @if(($title=="INVOICE") || ($title=="ESTIMATE") || ($title=="SALES"))
                                    <th>Rate</th>
                                    <th>Amount</th>
                                @endif
                            </tr>

                        <tbody>
                            @foreach ($job->sale as $sa)
                                @if ($sa->salesdesc!="Labour" && $job->partsorder->count()<1)
                                    <tr>
                                        <td>{{str_replace('-','',$sa->salesdesc)}}  {{ $po->partno!="-" && $po->partno!="" ? $po->partno : " "}}</td>
                                        <td>{{$sa->quantity}}
                                        </td>
                                        <td></td>
                                        @if(($title=="INVOICE") || ($title=="ESTIMATE") || ($title=="SALES"))

                                            <td>{{number_format($sa->amount/$sa->quantity,2)}}</td>
                                            <td><b>{{number_format($sa->amount,2)}}</b></td>
                                        @endif
                                    </tr>
                                @endif
                            @endforeach

                            @foreach ($job->partsorder as $po)
                                @if ($po->partsname!="Labour")
                                @php
                                if($po->amount>0){
                                    $rate = number_format($po->amount/$po->quantity,2);
                                }else{
                                    $rate = 0;
                                }
                                @endphp
                                    <tr>
                                        <td>{{str_replace('-','',$po->partsname)}}  {{ $po->partsno!="-" && $po->partsno!=""  ? $po->partsno : " "}}</td>
                                        <td>{{$po->quantity}}
                                        </td>
                                        @if(($title=="INVOICE") || ($title=="ESTIMATE") || ($title=="SALES"))
                                            <td>{{$rate}}</td>
                                            <td><b>{{number_format($po->amount,2)}}</b></td>
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                            @if(($title=="INVOICE") || ($title=="ESTIMATE")  || ($title=="SALES"))

                                <tr>
                                    <td colspan="3" style="font-weight: bold;">Labour:</td>
                                    <td>{{number_format($job->labour,2)}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="font-weight: bold;">Sundry:</td>
                                    <td>{{number_format($job->sundry,2)}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="font-weight: bold;">Discount:</td>
                                    <td>{{number_format($job->discount,2)}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="font-weight: bold;">Vat (7.5):</td>
                                    <td>{{number_format($job->vat,2)}}</td>
                                </tr>

                                <tr style="font-weight: bold;">
                                    <td colspan="3" style="font-weight: bold;">Total Amount: </td>
                                    <td><b><del style="text-decoration-style: double;">N</del>{{number_format($job->amount,2)}}</b></td>
                                </tr>
                                <tr>
                                    <td>VAT:</td><td></td>
                                </tr>

                                <tr>
                                    <td>Amount in Words:</td>
                                    <td colspan="3" style="text-align: left; font-weight: bold;">


                                    @php

                                            if (strpos($job->amount, '.') !== false) {
                                                $amountarray = explode(".",floatval($job->amount));
                                                if(strlen($amountarray[1])==1){
                                                    $amountarray[1]=$amountarray[1]*10;
                                                }
                                                if($amountarray[1]>0){
                                                    if(isset($amountarray[0])){
                                                        echo ucwords(numfmt_format($fmt, $amountarray[0]))." Naira ".ucwords(numfmt_format($fmt, $amountarray[1]))." Kobo";
                                                    }
                                                }
                                            }else{
                                                echo ucwords(numfmt_format($fmt, $job->amount))." Naira Only";
                                            }
                                        @endphp

                                    </td>
                                </tr>


                                <tr>
                                    <td colspan="2" style="text-align: left;">
                                    <!-- <img  src="{{ asset('/images/signature.png') }}" alt="{{$settings->motto}}" style="width: auto; height: 150px; position: absolute; margin-top: -50px; z-index: 99999; right: 50"> -->
                                    <br><br> ___________________________ <br> Manager's Signature</td>

                                    <td colspan="2" style="text-align: right;">
                                        <br><br> ___________________________ <br> Customer's Signature</td>
                                </tr>

                                <tr>
                                    <td colspan="4">
                                        <div style="text-align: left" style="height: 100%">
                                            @if(($title=="INVOICE"))
                                                <b>TERMS OF PAYMENT: </b>CASH OR CHEQUE/DRAFT IN FAVOUR OF <b>LAC AUTOS-SPARES LTD</b><br>
                                                <b>VALIDITY: </b>THIS INVOICE/ESTIMATE IS VALID FOR <b>7 DAYS</b> FROM DATE OF RECEIPT<br>
                                                <b>ACCOUNT DETAILS:</b><br>
                                                ACCOUNT NAME: <b>LAC AUTOS-SPARES LTD</b><br>
                                                ACCOUNT NUMBER: <b>5532927099</b><br>
                                                BANK NAME: <b>MONIEPOINT MFB Bank</b>

                                            @endif

                                            @if(($title=="ESTIMATE"))
                                                The above listed parts/items will be used to service the vehicle.
                                                <hr>
                                                <b>TERMS OF PAYMENT: </b>CASH OR CHEQUE/DRAFT IN FAVOUR OF <b>LAC AUTOS-SPARES LTD</b><br>
                                                <b>VALIDITY: </b>THIS INVOICE/ESTIMATE IS VALID FOR <b>7 DAYS</b> FROM DATE OF RECEIPT<br>
                                                <b>ACCOUNT DETAILS (1):</b><br>
                                                ACCOUNT NAME: <b>LAC AUTOS-SPARES LTD</b><br>
                                                ACCOUNT NUMBER: <b>5532927099</b><br>
                                                BANK NAME: <b>MONIEPOINT MFB Bank</b> <br>

                                            @endif

                                            @if(($title=="JOB INSTRUCTION"))
                                                Please service/repair this vehicle with the above listed parts. <hr>                       @endif

                                        </div>
                                    </td>
                                </tr>

                            @endif

                        </tbody>
                    </table>

                    @if(($title=="JOB INSTRUCTION"))

                        <table width="100%" style="font-size:9px !important; width:95%" class="table table-condensed" align="center" border="1">
                            <tr>
                                <td>
                                    {{$job->description}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {!! $job->diagnosis!="" ? "<p style='border-bottom: solid 1px grey'><b>Problems</b>: ".$job->diagnosis->problems."</p>" : '' !!}
                                    {!! $job->diagnosis!="" ? "<p style='border-bottom: solid 1px grey'><b>Causes</b>: ".$job->diagnosis->causes."</p>" : '' !!}
                                    {!! $job->diagnosis!="" ? "<p style='border-bottom: solid 1px grey'><b>Owner's Request</b>: ".$job->diagnosis->request."</p>" : '' !!}
                                    {!! $job->diagnosis!="" ? "<p style='border-bottom: solid 1px grey'><b>Instructions</b>: ".$job->diagnosis->instructions."</p>" : '' !!}
                                </td>
                            </tr>
                        </table>
                        <table width="100%" style="font-size:9px !important; width:95%" class="table table-condensed" align="center" border="1">
                            <tr>
                                <td colspan="2"><img src="{{ asset('/images/v.jpg') }}" alt="VEHICLE" width="200" height="120"></td>
                                <td colspan="3">
                                    <table cellspacing="0" cellpadding="0" style="font-size:7px !important; width:98%">
                                        <tr>
                                            <td align="right" width="50%">Additional Job Completionn : </td>
                                            <td width="50%"><input name="jobdetails2" id="jobdetails2" value="ok" type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td align="right">Value : </td>
                                            <td><input name="feeexp2" id="feeexp2" value="ok" type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td align="right">Project Estimatew/Explanationr: </td>
                                            <td><input name="resultconf2" id="resultconf2" value="ok" type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td align="right">Car Was Needed?  : </td>
                                            <td><input name="walkaround2" id="walkaround2" value="ok" type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td align="right">Replaced Part Keep: </td>
                                            <td><input name="walkaround22" id="walkaround22" value="ok" type="checkbox"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td width="43%"><table width="120" cellpadding="0" cellspacing="0" style="font-size:7px !important; width:98%">
                                <tr>
                                    <td>1</td>
                                    <td></td>
                                    <td>2</td>
                                </tr>
                                <tr>
                                    <td><input name="cleanness" value="ok" type="checkbox"></td>
                                    <td align="right" width="92%">
                                    Cleanness (Exterior/Interior): </td>
                                    <td width="8%"><input name="cleanness" value="ok" type="checkbox"></td>
                                </tr>
                                <tr>
                                    <td><input name="cleanness" value="ok" type="checkbox"></td>
                                    <td align="right">Courtesy Items Removal: </td>
                                    <td><input name="courtesy" value="ok" type="checkbox"></td>
                                </tr>
                                <tr>
                                    <td><input name="cleanness" value="ok" type="checkbox"></td>
                                    <td align="right">Outer Mirror Position / Seat Position: </td>
                                    <td><input name="position" value="ok" type="checkbox"></td>
                                </tr>
                                <tr>
                                    <td><input name="cleanness" value="ok" type="checkbox"></td>
                                    <td align="right">Clock Adjustment / Radio Sitting: </td>
                                    <td><input name="position" value="ok" type="checkbox"></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td align="right">Job Completion Notificxation:</td>
                                    <td><input name="position2" value="ok" type="checkbox"></td>
                                </tr>


                                </table>    </td>
                                <td width="11%">
                                </p> <small><em>Signed 1</em></small>
                                <p>Date:________<br>
                                Time: _______</p>

                                <small><em>Signed 2</em></small>
                                <p>Date:________<br>
                                Time: _______</p>
                                </td>
                                <td><table cellspacing="0" cellpadding="0" style="font-size:7px !important; width:98%">
                                <tr>
                                    <td align="right" width="93%">Job Details Explanation : </td>
                                    <td width="7%"><input name="jobdetails" id="jobdetails" value="ok" type="checkbox"></td>
                                </tr>
                                <tr>
                                    <td align="right">Fee Explanation : </td>
                                    <td><input name="feeexp" id="feeexp" value="ok" type="checkbox"></td>
                                </tr>
                                <tr>
                                    <td align="right">Result Confirmation with Customer: </td>
                                    <td><input name="resultconf" id="resultconf" value="ok" type="checkbox"></td>
                                </tr>
                                <tr>
                                    <td align="right">Walk-Around Check : </td>
                                    <td><input name="walkaround" id="walkaround" value="ok" type="checkbox"></td>
                                </tr>

                                </table>    </td>
                                <td>
                                <table width="179" style="font-size:7px !important; width:98%">
                                <tr>
                                    <td width="78%" align="right">Fixed:</td>
                                    <td width="22%"><input name="fixed" id="fixed" value="ok" type="checkbox"></td>
                                </tr>
                                <tr>
                                    <td align="right">Level Up: </td>
                                    <td><input name="fixed" id="fixed" value="ok" type="checkbox"></td>
                                </tr>
                                <tr>
                                    <td align="right">No Fixed: </td>
                                    <td><input name="nofixed" id="nofixed" value="ok" type="checkbox"></td>
                                </tr>
                                <tr>
                                    <td align="right">PSFU(Plan)</td>
                                    <td><input name="nofixed" id="nofixed" value="ok" type="checkbox"></td>
                                </table>	</td>
                                <td><p>Delivery: Dtae:______________</p>
                                <p>&nbsp;</p>
                                <p>Time:_________</p>
                                <p>Customer:___________________ </p>      </td>
                            </tr>

                            <tr>
                                <td colspan="2"><strong>Change of Delivery Time: </strong></td>
                                <td colspan="3"><strong>Job Time: </strong></td>
                            </tr>
                            <tr>
                                <td colspan="2" valign="bottom"><p>Additional Jobs /Job Stoppage/Others</p>
                                <p>Completion Changed: ______________________________</p></td>
                                <td colspan="3" valign="bottom"><p>Job Start: Date __________________ Time ______________ </p>
                                <p>Job Completion: Date: _______________ Time: ___________</p>
                                </td>
                            </tr>
                            <tr>
                                <td height="30" colspan="2" valign="bottom">Other Findings : </td>
                                <td width="28%" valign="bottom">Actual Hours Clocked: __________ </td>
                                <td width="8%" valign="bottom">Technician Name:<br>
                                <br>
                                __________________ </td>
                                <td width="10%" valign="bottom">Quality Control Staff: <br>
                                <br>
                                _________________ </td>
                                </tr>
                            <!--
                                <tr>
                                    <td colspan="5" valign="bottom">
                                    Pre-Delivery Conformation:
                                    <input type="checkbox" name="checkbox" value="checkbox">
                                    Cleanliness(Exterior/Interior)
                                    <input type="checkbox" name="checkbox2" value="checkbox">
                                    Courtesy Items Removal
                                    <input type="checkbox" name="checkbox3" value="checkbox">
                                    Outer Mirror Position / Seat Position
                                    <input type="checkbox" name="checkbox4" value="checkbox">
                                    Clock Adustment / Radio Setting </td>
                                </tr>
                            -->
                            <tr>
                                <td height="30" colspan="2" valign="bottom">Job Completion Notification: Date:___________ Time: ______________ </td>
                                <td colspan="3" valign="bottom">Delivered to Owner / Family / Other ( ______________ ) </td>
                            </tr>
                            <tr>
                                <td colspan="2" valign="bottom">P.S.F.U. (Plan): <br>
                                <br>
                                Date:
                                ____________ Time: ______________</td>
                                <td colspan="3" valign="bottom"><p>Contact Info: <br>
                                Telephone No: _______________________________ (Home/Business/Mobile) </p>
                                <p>Email: ___________________________________________ </p></td>
                            </tr>
                            <tr>
                                <td colspan="2" valign="bottom">P.S.F.U (Actual): <br>
                                <br>
                                Date: _________________ Time _____________________ </td>
                                <td colspan="3" valign="bottom">Customer:
                                Owner / Family / Other ( ____________________ ) </td>
                            </tr>
                            <tr>
                                <td colspan="2" valign="bottom"><p>P.S.F.U (GJ) :<br>
                                    <input type="checkbox" name="checkbox5" value="checkbox">
                                    Fixed
                                    <br>
                                    <input type="checkbox" name="checkbox6" value="checkbox">
                                    Followup Status (Follow up Again <br>
                                    <br>
                                    Date: ________________ Time: ______________________<br>
                                    <input type="checkbox" name="checkbox7" value="checkbox">
                                    Not Fixed (Appointment Date/Time) <br>
                                    <br>
                                    Date:________________ Time: ____________________</p>      </td>
                                <td colspan="3" valign="bottom">Staff Name: ______________________________________ <br>

                                <br>
                                Confirmed By: ______________________________________ <br>
                            <br>
                            Supplied By: ______________________________________ <br>
                            Issued By: ______________________________________ <br>
                            Order By: {{auth()->user()->name}}</td>
                            </tr>
                        </table>
                    @endif
                @endif

                <!-- @if(isset($pdf_url)) -->
                
                <div class="page-break"></div>

                @if(isset($job_images) && !empty($job_images))
                    <h2>Attached Images:</h2>
                    <div class="row">
                      @foreach($job_images as $image)
                        <div class="col-md-3">
                            <div class="thumbnail">                          
                                <img src="{{ asset('job_images/' . $job->jobno . '/' . $image->getFilename()) }}" alt="Image" class="img-responsive" style="width:100%; height: auto;">
                            </div>
                        </div>
                       @endforeach
                    </div>
                @endif

                {{$pdf_url}}
                <script>
                    window.onload = function() {
                        // Uncomment this for auto-download of the PDF 
                        // const link = document.createElement('a');
                        // link.href = "{{ $pdf_url }}";
                        // link.download = "{{ $type.'-'.$job->jobno.'.pdf' }}";
                        // document.body.appendChild(link);
                        // link.click();
                        // document.body.removeChild(link);
                    };

                    function sendToWhatsapp() {
                        const phoneNumber = "{{ $job->contact->telephoneno }}";
                        const formattedNumber = phoneNumber.startsWith('0')
                            ? '+234' + phoneNumber.substring(1)
                            : '+234' + phoneNumber;

                        const jobno = '{{ $job->jobno }}';
                        const type = '{{ $type }}';
                        const pdfUrl = `http://auto.serve/pdf/${type}-${jobno}.pdf`;
                        const galleryUrl = `http://auto.serve/job-gallery/${jobno}`;

                        // Check if the directory exists and has files
                        fetch(galleryUrl)
                            .then(response => {
                                let message = `🔧 ${type.toUpperCase()} for Job #${jobno}\n📄 Invoice: ${pdfUrl}`;

                                if (response.ok) {
                                    // Check if there are images in the directory
                                    fetch(`${galleryUrl}/`, { method: 'GET' })
                                        .then(res => res.text())
                                        .then(html => {
                                            const parser = new DOMParser();
                                            const doc = parser.parseFromString(html, 'text/html');
                                            const images = doc.querySelectorAll('img');

                                            if (images.length > 0) {
                                                message += `\n🖼️ Images: ${galleryUrl}`;
                                            }

                                            Swal.fire({
                                                title: 'Share invoice and images to WhatsApp?',
                                                icon: 'question',
                                                showCancelButton: true,
                                                confirmButtonText: 'Yes',
                                                cancelButtonText: 'No',
                                                confirmButtonColor: '#28a745',
                                                cancelButtonColor: '#dc3545'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    const whatsappUrl = `https://wa.me/${formattedNumber}?text=${encodeURIComponent(message)}`;
                                                    window.open(whatsappUrl, '_blank');
                                                }
                                            });
                                        });
                                } else {
                                    // If gallery does not exist, share only the PDF
                                    Swal.fire({
                                        title: 'Share invoice to WhatsApp?',
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonText: 'Yes',
                                        cancelButtonText: 'No',
                                        confirmButtonColor: '#28a745',
                                        cancelButtonColor: '#dc3545'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            const whatsappUrl = `https://wa.me/${formattedNumber}?text=${encodeURIComponent(message)}`;
                                            window.open(whatsappUrl, '_blank');
                                        }
                                    });
                                }
                            })
                            .catch(() => {
                                Swal.fire({
                                    title: 'Error checking gallery!',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#dc3545'
                                });
                            });
                    }

                    document.addEventListener('DOMContentLoaded', function() {
                        sendToWhatsapp();
                    });
                </script>
<!--           @endif -->


@endsection
