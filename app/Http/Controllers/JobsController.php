<?php

namespace App\Http\Controllers;

use App\Models\jobs;
use App\Models\vehicle;
use App\Models\contacts;
use App\Models\serviceorder;
use App\Models\sale;
use App\Models\diagnosis;
use App\Models\User;
use App\Models\partsorder;
use App\Models\payments;
use App\Models\parts;
use App\Models\stock;
use App\Models\psfu;
use App\Models\controls;
use Illuminate\Http\Request;
use App\Scopes\SettingScope;
// use PDF;

class Job {
    public $id = 0;
    public $jobno = 0;
    public $jobid=0;
    public $amount = 0;
    public $labour = 0;
    public $vat=0;
    public $sundry = 0;
    public $discount = 0;
    public $serviceorder = [];
    public $contact = [];
    public $partsorder = [];
    public $diagnosis = [];
    public $sale = [];
}

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = jobs::where('status','!=','Done')->orderBy('dated','desc')->paginate(400);
        $lastinvoiceno = jobs::max('jid');
        return view('jobs', compact('jobs','lastinvoiceno'));
    }

    public function completedJobs()
    {
        $jobs = jobs::where('status','Done')->orderBy('dated','desc')->paginate(400);
        $lastinvoiceno = jobs::max('jid');
        return view('jobs', compact('jobs','lastinvoiceno'));
    }

    public function customerJobs($customerid)
    {
        $jobs = jobs::where('customerid','=',$customerid)->orderBy('dated','desc')->orderBy('status','desc')->with(['contact'])->get();
        $lastinvoiceno = jobs::max('jid');
        return view('cjobs', compact('jobs','customerid','lastinvoiceno'));
    }

    public function vehicleJobs($vregno)
    {
        $jobs = jobs::where('vregno','=',$vregno)->orderBy('dated','desc')->orderBy('status','desc')->get();
        $lastinvoiceno = jobs::max('jid');
        return view('vjobs', compact('jobs','lastinvoiceno'));
    }

    public function editJob($jobno)
    {
        $job = jobs::where('jobno',$jobno)->first();
        $vehicle = vehicle::where('jobno',$jobno)->orWhere('vregno',$job->vregno)->first();
        $contacts = contacts::select('name')->get();

        $jobno = $job->jobno;
        $editjobno = $job->jobno;
        $parts = parts::select('id','part_name','selling_price')->with('stock')->get();
        $services = serviceorder::select('id','servicename','amount')->distinct('servicename')->orderBy('id', 'desc')->get()->unique('servicename');
        return view('new-customer', compact('job','vehicle','jobno','contacts','editjobno','parts','services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $jobno = jobs::select('jobno')->orderBy('id','desc')->first();
        if($jobno==null){
            $jobno = 0;
        }else{
            $jobno=$jobno->jobno+1;
        }
        $parts = parts::select('id','part_name','selling_price')->get();
        $services = serviceorder::select('id','servicename','amount')->distinct('servicename')->orderBy('id', 'desc')->get()->unique('servicename');
        $new_job = new Job();
        return view('new-customer', compact('jobno','new_job','parts','services'));
    }

    public function newSales()
    {
        $parts = parts::select('id','part_name','selling_price')->with('stock')->get();
        $vehicles = vehicle::select('id','vregno')->get();
        return view('new-sales', compact('parts','vehicles'));
    }

    public function addSales(Request $request)
    {

        if($request->customerid=="New"){
            $customerid = "LACS".strtoupper(substr(md5(uniqid(rand(1,6))), 0, 7));
            contacts::create([
                'name'=>$request->name,
                'organization'=>$request->organixation,
                'telephoneno'=>$request->telephoneno,
                'email'=>$request->email,
                'sundry'=>$request->sundry,
                'vat'=>$request->vat,
                'credit'=>$request->credit,
                'remarks'=>$request->remarks,
                'customerid'=>$customerid
            ]);
        }else{
            $customerid = $request->customerid;
        }

        $jno = jobs::select('jobno')->orderBy('id','desc')->first();

        if($jno==null){
            $jobno = 0;
        }else{
            $jobno = $jno->jobno+1;
        }

        $job =  jobs::create([
            'jobno'=>$jobno,
            'customerid'=>$customerid,
            'vregno'=>$request->veregno,
            'status'=>'Pending',
            'description'=>'SALES',
            'dated'=>$request->dated,
            'jid'=>$request->jid,
            'odometer'=>$request->vin,
            'next_due'=>$request->nextservicedate
        ]);

        $totalamount = 0;

        for ($i=0; $i < count($request->partname); $i++) {

            if($request->pnid[$i]==""){
                $part = parts::create([
                    'part_name'=>$request->partname[$i],
                    'selling_price'=>$request->amount[$i]/$request->quantity[$i],
                ]);
                $partid = $part->id;

                stock::create(['part_id'=>$partid,'quantity_in_stock'=>0]);
            }else{
                $partid = $request->pnid[$i];
            }


            partsorder::updateOrCreate(['jobno'=>$request->jobno, 'partsname'=>$request->partname[$i]],[
            'customerid'=>$customerid,
            'jobno'=>$jobno,
            'partsname'=>$request->partname[$i],
            'quantity'=>$request->quantity[$i],
            'pdate'=>date('Y-m-d'),
            'amount'=>$request->amount[$i],
            'pid'=>$partid
            ]);

            $totalamount+=$request->amount[$i];
        }

        $job->amount = $totalamount;
        $job->save();

        parts::select('id','part_name','selling_price')->get();

        return redirect()->route('sales')->with(['message'=>'The Product Sales was success, please, proceed to payment']);
    }

    public function newCustomerJob($customerid)
    {
        $jobcheck = jobs::select('jobno')->orderBy('id','desc')->get();
        if($jobcheck->count()==0){
            $jobno = 0;
        }else{
            $jobno = $jobcheck->first()->jobno;
        }
        $contact = contacts::select('name','customerid','vat','sundry','credit')->where('customerid',$customerid)->first();
        $parts = parts::select('id','part_name','selling_price')->get();
        $services = serviceorder::select('id','servicename','amount')->distinct('servicename')->orderBy('id', 'desc')->get()->unique('servicename');

        $jobno=$jobno+1;
        $new_job = new Job();
        return view('new-customerjob', compact('jobno','customerid','contact','new_job','parts','services'));
    }

    public function newVehicleJob($customerid,$vid)
    {
        $jobcheck = jobs::select('jobno')->orderBy('id','desc')->get();
        if(count($jobcheck)==0){
            $jobno = 0;
        }else{
            $jobno = $jobcheck->first()->jobno;
        }
        $vehicleinfo = vehicle::where('id',$vid)->first();
        $parts = parts::select('id','part_name','selling_price')->get();
        $services = serviceorder::select('id','servicename','amount')->distinct('servicename')->orderBy('id', 'desc')->get()->unique('servicename');

        $new_job = new Job();
        $contact = contacts::select('customerid','vat','sundry','credit')->where('customerid',$customerid)->first();
        $jobno=$jobno+1;
        return view('new-customerjob', compact('jobno','customerid','contact','vehicleinfo','new_job','parts','services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jno = jobs::select('jobno')->orderBy('id','desc')->first();
        if($jno==null){
            $jobno = 0;
        }else{
            $jobno = $jno->jobno+1;
        }

        if($request->editjobno!=''){
            $jobno = $request->editjobno;
        }

        if(!isset($request->newcjob)){

            contacts::updateOrCreate(['customerid'=>$request->customerid],
                $request->only(
                'name',
                'organization',
                'telephoneno',
                'email',
                'sundry',
                'vat',
                'credit',
                'remarks',
                'customerid'
            ));
        }

        if ($request->hasFile('diagnosis')) {
            $file = $request->file('diagnosis');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('/pdf');
            $file->move($destinationPath, $filename);
            $diagnosis_file = $filename;
        } else {
            $diagnosis_file = $request->old_diagnosis_file;
        }


            $veh = vehicle::updateOrCreate(['vregno'=>$request->vregno],$request->only(
                'customerid',
                'vregno',
                'regdate',
                'modelname',
                'modelno',
                'frameno',
                'vin',
                'chasisno',
                'color',
                'vcondition',
                'daterecieved',
                // 'jobno'
            ));

            $veh->jobno = $jobno;
            $veh->save();


        $job =  jobs::updateOrCreate(['jobno'=>$jobno],$request->only(
            'customerid',
            // 'jobno',
        ));


        if($request->servicename!==null){
            $description = $request->servicename[0];
            $status = $request->sstatus;
            $dated = $request->sdate!="" ? date('Y-m-d', strtotime($request->sdate)) : date('Y-m-d', strtotime($request->ddate));
        }else{
            $description = $request->problems;
            $status = $request->status;
            $dated = $request->ddate!="" ? date('Y-m-d', strtotime($request->ddate)) : date('Y-m-d', strtotime($request->sdate));
        }
        $job->vregno = $request->vregno;
        $job->description = $description;
        $job->status = $status;
        $job->dated = $dated;
        $job->amount = $request->totalamount;
        $job->vat = $request->vatcost;
        $job->labour = $request->labour;
        $job->sundry = $request->sundrycost;
        $job->discount = $request->discountcost;
        $job->jobno = $jobno;
        $job->jid = 0;
        $job->odometer = $request->vin;
        $job->save();

        if($request->servicename==""){
            $servicedate = $request->sdate!="" ? date('Y-m-d', strtotime($request->sdate)) : date('Y-m-d', strtotime($request->ddate));
            serviceorder::updateOrCreate(['jobno'=>$jobno],[
                'customerid'=>$request->customerid,
                'jobno'=>$jobno,
                'servicename'=>$request->diagnosis,
                'description'=>$description,
                'mileage'=>$request->vin,
                'amount'=>$request->labour,
                'sdate'=>$servicedate,
                'nextservicedate'=>date('Y-m-d', strtotime($request->ddate. ' + 90 days')),
                'status'=>$status
            ]);
        }else{
            $servicedate = $request->sdate!="" ? date('Y-m-d', strtotime($request->sdate)) : date('Y-m-d', strtotime($request->ddate));

            foreach($request->servicename as $key => $srv){
                serviceorder::updateOrCreate(['jobno'=>$jobno],[
                    'customerid'=>$request->customerid,
                    'jobno'=>$jobno,
                    'servicename'=>$request->servicename[$key],
                    'description'=>$request->description[$key],
                    'mileage'=>$request->mileage,
                    'amount'=>$request->labour,
                    'sdate'=>$servicedate,
                    'nextservicedate'=>date('Y-m-d',strtotime($request->nextservicedate)),
                    'status'=>$status
                ]);
            }
        }
        if($request->partname!==null){

            partsorder::where('jobno',$jobno)->delete();

            for ($i=0; $i < count($request->partname); $i++) {

                if($request->partname[$i]!=""){
                    if($request->pnid[$i]==""){
                        $part = parts::create([
                            'part_name'=>$request->partname[$i],
                            'selling_price'=>$request->amount[$i]/$request->quantity[$i],
                        ]);
                        $partid = $part->id;

                        stock::create(['part_id'=>$partid,'quantity_in_stock'=>0]);
                    }else{
                        $partid = $request->pnid[$i];
                    }
                    partsorder::updateOrCreate(['jobno'=>$jobno, 'partsname'=>$request->partname[$i]],[
                    'customerid'=>$request->customerid,
                    'jobno'=>$jobno,
                    'partsname'=>$request->partname[$i],
                    'quantity'=>$request->quantity[$i],
                    'pdate'=>date('Y-m-d'),
                    'amount'=>$request->amount[$i],
                    'pid'=>$partid
                    ]);
                }
            }
        }

        $diag = diagnosis::updateOrCreate(['jobno'=>$jobno],$request->only(
            'customerid',
            // 'jobno',
            // 'diagnosis',
            'problems',
            'causes',
            'request',
            'deliverydate',
            'dstatus',
            'instructions',
            'remarks'
        ));

        $diag->jobno = $jobno;
        $diag->diagnosis = $diagnosis_file;
        $diag->save();

        // save jobno to controls
        controls::updateOrCreate(['jobno'=>$jobno],$request->only('jobno'));



        return redirect()->route('newjob')->with(['message'=>'Order Saved Successfully! <br> <a href="/invoice/'.$jobno.'/estimate" class="btn btn-success">Print Job Estimate</a> OR <a href="/invoice/'.$jobno.'/instruction" class="btn btn-primary">Print Job Instruction</a>']);
    }

    public function addJobno(Request $request)
    {
        $jexist = jobs::where('jid', '=', $request->jid)->get()->first();
        if (!isset($jexist->partsorder)) {
            jobs::where('id',$request->id)->update(['jid'=>$request->jid]);

            $job = jobs::where('id',$request->id)->first();

            foreach($job->partsorder as $part){
                $part->stock()->decrement('quantity_in_stock', $part->quantity);
            }

            $message = 'Job Number Updated for: '.$request->jid;
        }else{
            $message = 'Error! The Job No already exist in the ERP';
        }

        return redirect()->back()->with(['message'=>$message]);

    }


    public static function getCurrency2(float $num)
    {
        $decones = array(
            '01' => "One",
            '02' => "Two",
            '03' => "Three",
            '04' => "Four",
            '05' => "Five",
            '06' => "Six",
            '07' => "Seven",
            '08' => "Eight",
            '09' => "Nine",
            10 => "Ten",
            11 => "Eleven",
            12 => "Twelve",
            13 => "Thirteen",
            14 => "Fourteen",
            15 => "Fifteen",
            16 => "Sixteen",
            17 => "Seventeen",
            18 => "Eighteen",
            19 => "Nineteen"
        );
        $ones = array(
                0 => " ",
                1 => "One",
                2 => "Two",
                3 => "Three",
                4 => "Four",
                5 => "Five",
                6 => "Six",
                7 => "Seven",
                8 => "Eight",
                9 => "Nine",
                10 => "Ten",
                11 => "Eleven",
                12 => "Twelve",
                13 => "Thirteen",
                14 => "Fourteen",
                15 => "Fifteen",
                16 => "Sixteen",
                17 => "Seventeen",
                18 => "Eighteen",
                19 => "Nineteen"
                );
        $tens = array(
                0 => " ",
                1 => " ",
                2 => "Twenty",
                3 => "Thirty",
                4 => "Forty",
                5 => "Fifty",
                6 => "Sixty",
                7 => "Seventy",
                8 => "Eighty",
                9 => "Ninety",
                );
        $hundreds = array(
                "Hundred",
                "Thousand",
                "Million",
                "Billion",
                "Trillion",
                "Quadrillion"
                ); //limit t quadrillion
        $num = number_format($num,2,".",",");
        $num_arr = explode(".",$num);
        $wholenum = $num_arr[0];
        $decnum = $num_arr[1];
        $whole_arr = array_reverse(explode(",",$wholenum));
        krsort($whole_arr);
        $rettxt = "";
        foreach($whole_arr as $key => $i){
        if($i < 20){
            if($i==000 || $i==00){
                $rettxt .= " ";
            }else{
                $rettxt .= $ones[$i];
            }

        }
        elseif($i < 100){
            $rettxt .= $tens[substr($i,0,1)];
            $rettxt .= " ".$ones[substr($i,1,1)];
        }
        else{
            $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0];
            $rettxt .= " ".$tens[substr($i,1,1)];
            $rettxt .= " ".$ones[substr($i,2,1)];
        }
        if($key > 0){
            $rettxt .= " ".$hundreds[$key]." ";
        }

        }
        $rettxt = $rettxt." Naira";

        if($decnum > 0){
        $rettxt .= " and ";
        if($decnum < 20){
            $rettxt .= $decones[$decnum];
        }
        elseif($decnum < 100){
            $rettxt .= $tens[substr($decnum,0,1)];
            $rettxt .= " ".$ones[substr($decnum,1,1)];
        }
        $rettxt = $rettxt." Kobo";
        }
        return $rettxt;
    }

    public function printInvoice($jobno,$type)
    {

        $job = jobs::where('jobno',$jobno)->first();
        $vregno = $job->vregno;
        $jobtype = $job->description;

        // if(strlen($vregno)!="NA"){
        //     $vcheck = diagnosis::select('remarks')->where('jobno',$jobno)->first();
        //     $vregno = $vcheck->remarks;
        // }

        if($type=="receipt"){

            $job = payments::where('jobno',$jobno)->orderBy('id','desc')->first();

            $vregno = "";
        }

        if(strlen($vregno)!="NA"){
            $vehicle = vehicle::where('vregno',$vregno)->orderBy('updated_at','desc')->first();
        }else{
            $vehicle = [];
        }

        if($type=='invoice'){
            $title = "INVOICE";
        }else if($type=='receipt'){
            $title = "RECEIPT";
        }else if($type=='estimate'){
            $title = "ESTIMATE";
        }else if($type=='instruction'){
            $title = "JOB INSTRUCTION";
        }else if($type=='sales'){
            $title = "SALES";
        }

            $pdf_doc = \PDF::loadView('invoice', compact('job','vehicle','title'));

            // return $pdf_doc->save('public/pdf/'.$type.'-'.$jobno.'.pdf')->stream($type.'-'.$jobno.'.pdf');

        return view('invoice', compact('job','vehicle','title'));
    }

    public function diagnosisFile($jobno)
    {
        $diagnosis_file = diagnosis::where('jobno',$jobno)->first()->diagnosis;

        return response()->file(public_path('pdf/'.$diagnosis_file));
    }

    public function jobSearch(request $request)
    {
        $keyword = $request->keyword; // you could also $request->has('query')
        $lastinvoiceno = jobs::max('jid');
        if(is_numeric($keyword)){

            $jobs = jobs::where('jid', 'like', '%' . $keyword . '%')->paginate(400);

          return view('jobs', compact('jobs','lastinvoiceno'));

        }else{
            // $jobs = jobs::where('jid', $keyword)->orWhere('customerid', 'like', '%' . $keyword . '%')->paginate(400);
            $contacts = contacts::where('name',  'like', '%' . $keyword . '%')->orWhere('organization', 'like', '%' . $keyword . '%')->orWhere('customerid', 'like', '%' . $keyword . '%')->paginate(400);

            return view('contactsearch', compact('contacts'));
        }

    }

    public function filterJobs(request $request)
    {
        $from = date('Y-m-d', strtotime($request->from));
        $to = date('Y-m-d', strtotime($request->to));
        $lastinvoiceno = jobs::max('jid');

        // $jobs = jobs::where('jid', $keyword)->orWhere('customerid', 'like', '%' . $keyword . '%')->paginate(400);
        $jobs = jobs::whereBetween('dated',  [$from, $to])->orderBy('dated','desc')->paginate(400);

      return view('jobs', compact('jobs','lastinvoiceno'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function show(jobs $jobs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function edit(jobs $jobs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, jobs $jobs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function destroy(jobs $jobs)
    {
        //
    }

    public function genericDelete($id,$table)
    {
        if($table=="payments"){
            payments::findOrFail($id)->delete();
        }
        if($table=="jobs"){
            jobs::findOrFail($id)->delete();
        }

        if($table=="contacts"){
            contacts::findOrFail($id)->delete();
        }

        if($table=="serviceorder"){
            serviceorder::findOrFail($id)->delete();
        }

        if($table=="sale"){
            sale::findOrFail($id)->delete();
        }

        if($table=="partsorder"){
            partsorder::findOrFail($id)->delete();
        }

        if($table=="user"){
            User::query()->withGlobalScope('setting', new SettingScope)->findOrFail($id)->delete();
        }
        $message = 'The record has been deleted!';
        return redirect()->route('home')->with(['message'=>$message]);
    }

    public function changedate(Request $request)
    {
        return redirect('invoice/'.$request->jobno.'/invoice')->with('newdate', $request->changedate);
    }
}
