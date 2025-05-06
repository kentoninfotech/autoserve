<?php

namespace App\Http\Controllers;

use App\Models\attendances;
use Illuminate\Http\Request;
use App\Models\personnel;

class AttendancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = personnel::paginate(50);
        return view('attendance', compact('attendances'));
    }

    public function Attendances()
    {
        $attendances = attendances::paginate(50);
        return view('attendances', compact('attendances'));
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
        attendances::create($request->all());

        return redirect()->back()->with('message','Attendance added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\attendances  $attendances
     * @return \Illuminate\Http\Response
     */
    public function show(attendances $attendances)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\attendances  $attendances
     * @return \Illuminate\Http\Response
     */
    public function edit(attendances $attendances)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\attendances  $attendances
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, attendances $attendances)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\attendances  $attendances
     * @return \Illuminate\Http\Response
     */
    public function destroy(attendances $attendances)
    {
        //
    }
}
