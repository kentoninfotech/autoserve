<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarInventory;
use App\Models\CarInventoryImage;
use Illuminate\Support\Facades\Storage;

class CarInventoryController extends Controller
{
    // List all cars in inventory
    public function index()
    {
        $cars = CarInventory::all();
        return view('car_inventory.index', compact('cars'));
    }

    // Show form to add a new car
    public function create()
    {
        return view('car_inventory.create');
    }

    // Store a new car
    public function store(Request $request)
    {
        $data = $request->validate([
            'make'         => 'required|string',
            'model'        => 'required|string',
            'year'         => 'required|string',
            'vin'          => 'nullable|string',
            'mileage'      => 'nullable|string',
            'condition'    => 'nullable|string',
            'fuel_type'    => 'nullable|string',
            'transmission' => 'nullable|string',
            'color'        => 'nullable|string',
            'price'        => 'nullable|numeric',
            'description'  => 'nullable|string',
            'images.*'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);
        $car = CarInventory::create($data);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imageName = time().'_'.$index.'_'.$image->getClientOriginalName();
                $image->move('vehicle_images', $imageName);
                CarInventoryImage::create([
                    'car_inventory_id' => $car->id,
                    'image' => $imageName,
                    'is_thumbnail' => $index === 0, // first image as default thumbnail
                ]);
            }
        }
        return redirect()->route('car-inventory.index')->with('message', 'Car added to inventory.');
    }

    // Show a single car
    public function show($id)
    {
        $car = CarInventory::findOrFail($id);
        $car->load('images');
        return view('car_inventory.show', compact('car'));
    }

    // Show form to edit a car
    public function edit($id)
    {
        $car = CarInventory::findOrFail($id);
        $car->load('images');
        return view('car_inventory.edit', compact('car'));
    }

    // Update a car
    public function update(Request $request, $id)
    {
        $car = CarInventory::findOrFail($id);
        $data = $request->validate([
            'make'         => 'required|string',
            'model'        => 'required|string',
            'year'         => 'required|string',
            'vin'          => 'nullable|string',
            'mileage'      => 'nullable|string',
            'condition'    => 'nullable|string',
            'fuel_type'    => 'nullable|string',
            'transmission' => 'nullable|string',
            'color'        => 'nullable|string',
            'price'        => 'nullable|numeric',
            'description'  => 'nullable|string',
        ]);
        $car->update($data);
        return redirect()->route('car-inventory.index')->with('message', 'Car updated.');
    }

    // Delete a car
    public function destroy($id)
    {
        $car = CarInventory::findOrFail($id);
        foreach ($car->images as $img) {
            unlink('vehicle_images/' . $img->image);
            $img->delete();
        }
        $car->delete();
        return redirect()->route('car-inventory.index')->with('message', 'Car deleted.');
    }

    // Mark car as sold
    public function sell(Request $request, $id)
    {
        $car = CarInventory::findOrFail($id);
        $car->status = 'sold';
        $car->save();
        return redirect()->route('car-inventory.index')->with('message', 'Car marked as sold.');
    }

    // Upload car images (add to gallery, not just one)
    public function uploadImage(Request $request, $id)
    {
        $car = CarInventory::findOrFail($id);
        $request->validate([
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);
        $images = $request->file('image');
        if (!is_array($images)) {
            $images = [$images];
        }
        foreach ($images as $img) {
            $imageName = time().'_'.uniqid().'_'.$img->getClientOriginalName();
            $img->move('vehicle_images', $imageName);
            $isThumbnail = !$car->images()->where('is_thumbnail', true)->exists();
            CarInventoryImage::create([
                'car_inventory_id' => $car->id,
                'image' => $imageName,
                'is_thumbnail' => $isThumbnail,
            ]);
        }
        return back()->with('message', 'Image(s) uploaded.');
    }

    // Set thumbnail for a car image
    public function setThumbnail(Request $request, $carId, $imageId)
    {
        $car = CarInventory::findOrFail($carId);
        foreach ($car->images as $img) {
            $img->is_thumbnail = ($img->id == $imageId);
            $img->save();
        }
        return back()->with('message', 'Thumbnail updated.');
    }
}
