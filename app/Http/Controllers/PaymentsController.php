<?php

namespace App\Http\Controllers;

use App\Models\payments;
use App\Models\jobs;
use App\Models\partsorder;
use App\Models\serviceorder;

use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = payments::orderBy('dated','desc')->orderBy('invoiceno','desc')->paginate(400);
        return view('payments', compact('payments'));
    }

    public function debtors()
    {
        $debtors = payments::orderBy('dated','desc')->orderBy('invoiceno','desc')->paginate(400);
        return view('debtors', compact('debtors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        payments::create($request->all());

        jobs::where('jobno',$request->jobno)->update([
            'status'=>"Done"
        ]);

        partsorder::where('jobno',$request->jobno)->update([
            'status'=>"Done"
        ]);

        serviceorder::where('jobno',$request->jobno)->update([
            'status'=>"Done"
        ]);

        return redirect()->back()->with(['message'=>'The payment for invoice no: '.$request->invoiceno.' saved successfully! <br> <a href="/invoice/'.$request->jobno.'/receipt" class="btn btn-primary">Print Receipt</a>']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function show(payments $payments)
    {
        //
    }

    public function newPayment($invoiceno)
    {
        $job = jobs::where('jid',$invoiceno)->first();
        $amounttopay = $job->amount;
            if (isset($job->payment) && !empty($job->payment)){
                $amounttopay = $job->amount - $job->payment->sum('amountpaid');
            }


        return view('make-payment', compact('job','amounttopay'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function edit(payments $payments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, payments $payments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function destroy(payments $payments)
    {
        //
    }
}
