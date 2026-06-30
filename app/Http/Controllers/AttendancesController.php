<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
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
        $attendances = Attendance::paginate(50);
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
        Attendance::create($request->all());

        return redirect()->back()->with('message','Attendance added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendances
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendances)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendances
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendances)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendances
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendances)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendances
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendances)
    {
        //
    }
}
