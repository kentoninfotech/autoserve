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
use Illuminate\Http\Request;
use DB;
use App\Scopes\SettingScope;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = contacts::select('id','customerid','name','organization','telephoneno','vat','sundry')->orderBy('name','ASC')->with(['vehicles'])->get();
        $users = User::query()->withGlobalScope('setting', new SettingScope)->select('name','id')->get();
        return view('contacts', compact('contacts','users'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\contacts  $contacts
     * @return \Illuminate\Http\Response
     */
    public function show(contacts $contacts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\contacts  $contacts
     * @return \Illuminate\Http\Response
     */
    public function edit($customerid)
    {
        $contact = contacts::where('customerid',$customerid)->first();
        return view('edit-customer', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\contacts  $contacts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $contact = contacts::where('customerid',$request->customerid)->first();

        $contact->name = $request->name;
        $contact->organization = $request->organization;
        $contact->telephoneno = $request->telephoneno;
        $contact->address = $request->address;
        $contact->email = $request->email;
        $contact->remarks = $request->remarks;
        $contact->sundry = $request->sundry;
        $contact->credit = $request->credit;
        $contact->vat = $request->vat;
        $contact->save();

        return redirect()->back()->with(['message'=>'The Customer '.$request->name.' has been updated successfully!']);
    }

    public function mergeContacts(Request $request){

        $mainaccountid = $request->mainaccount;

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        foreach($request->customerid as $cid){
            if($cid!=$mainaccountid){
                vehicle::where('customerid', $cid)->update(array('customerid' =>  $mainaccountid));
                jobs::where('customerid', $cid)->update(array('customerid' =>  $mainaccountid));
                serviceorder::where('customerid', $cid)->update(array('customerid' =>  $mainaccountid));
                partsorder::where('customerid', $cid)->update(array('customerid' =>  $mainaccountid));
                diagnosis::where('customerid', $cid)->update(array('customerid' =>  $mainaccountid));
                sale::where('customerid', $cid)->update(array('customerid' =>  $mainaccountid));
                payments::where('customerid', $cid)->update(array('customerid' =>  $mainaccountid));
                // DELETE NON MAIN
                contacts::where('customerid', $cid)->delete();
            }
            
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return redirect()->route('customers')->with(['message'=>'The Customer\'s Duplicate Accounts has been merged to one. Customer ID: '.$mainaccountid.'.']);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\contacts  $contacts
     * @return \Illuminate\Http\Response
     */
    public function destroy(contacts $contacts)
    {
        //
    }
}
