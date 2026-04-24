<?php

namespace App\Http\Controllers;

use App\Models\parts;
use App\Models\supplies;
use App\Models\stock;

use Illuminate\Http\Request;

class PartsController extends Controller
{
    public function index()
    {
        $parts = parts::all();
        return view('parts', compact('parts'));
    }

    public function create()
    {
        return view('add-part');
    }

    public function store(Request $request)
    {
        // Validation logic here

        $part = parts::create($request->all());
        stock::create([
            'part_id'=>$part->id,
            'quantity_in_stock'=>0
        ]);

        return redirect()->route('parts')->with('message', 'Part created successfully.');
    }

    public function edit($partid)
    {
        $part = parts::where('id',$partid)->first();
        return view('edit-part', compact('part'));
    }

    public function update(Request $request)
    {
        // Validation logic here
        $part = parts::where('id',$request->id)->first();

        $part->update($request->all());

        return redirect()->route('parts')->with('message', 'Part updated successfully.');
    }

    public function destroy($partid)
    {
        parts::find($partid)->delete();

        return redirect()->route('parts')->with('message', 'Part deleted successfully.');
    }

    public function addSupply()
    {
        $parts = parts::select('id','part_name')->get();
        return view('add-supply', compact('parts'));
    }

    public function saveSupply(Request $request){
        // Validate request data
        $validated = $request->validate([
            'part_id' => 'required|exists:parts,id',
            'quantity_supplied' => 'required|numeric|min:0',
            'supplier_name' => 'required|string',
            'phone_number' => 'nullable|string',
            'date_supplied' => 'required|date',
            'batch_no' => 'nullable|string',
            'payment_made' => 'nullable|numeric|min:0',
        ]);

        // Increase stock
        $part = parts::where('id',$request->part_id)->first();
        supplies::create($validated);
        $part->stock()->increment('quantity_in_stock', $request->quantity_supplied);

        $supplies = supplies::all();

        return view('supplies', compact('supplies'))->with('message', 'Supply record saved successfully.');
    }

    public function partSupplies()
    {
        $supplies = supplies::all();
        return view('supplies', compact('supplies'));
    }

    public function deleteSupply($sid)
    {
        $supply = supplies::where('id',$sid)->first();
        // $partid = $supply->part_id;
        $qsupplied = $supply->quantity_supplied;
        $supply->part->stock()->decrement('quantity_in_stock', $qsupplied);
        return redirect()->back()->with(['message'=>'The Supply record has been deleted successfully']);
    }
}
