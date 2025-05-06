<?php

namespace App\Http\Controllers;

use App\Models\controls;
use App\Models\User;
use Illuminate\Http\Request;
use App\Scopes\SettingScope;

class ControlsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $controls = controls::paginate(50);
        $technicians = User::query()->withGlobalScope('setting', new SettingScope)->select('id','name')->get();
        return view('controls', compact('controls','technicians'));
    }

    public function printControls()
    {
        $controls = controls::all();
        return view('controls-print', compact('controls'));
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
        $control =controls::updateOrCreate(['jobno'=>$request->jobno], $request->except('started_at','completed_at'));
        $control->started_at = date('Y-m-d H:i:s', strtotime($request->started_at));
        $control->completed_at = date('Y-m-d H:i:s', strtotime($request->completed_at));
        $control->save();
        return redirect()->back()->with('message','Control added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\controls  $controls
     * @return \Illuminate\Http\Response
     */
    public function show(controls $controls)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\controls  $controls
     * @return \Illuminate\Http\Response
     */
    public function edit(controls $controls)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\controls  $controls
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, controls $controls)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\controls  $controls
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        controls::find($id)->delete();
        return redirect()->back()->with('message','Control deleted successfully');
    }
}
