<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarInventory;
use App\Models\contacts;
use App\Models\CarOrder;
use App\Models\CarOrderItem;

class CarSaleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $carOrder = CarOrder::all();
        return view('car_inventory.car-orders', compact('carOrder'));
    }

    // Show the cart page for new car sales
    public function cart(Request $request)
    {
        $cart = session('cart', []);
        $cars = CarInventory::all();
        $customers = contacts::all();
        return view('car_inventory.car-sales', compact('cart', 'cars', 'customers'));
    }

    // Add a car to the cart
    public function addToCart($carId)
    {
        $car = CarInventory::findOrFail($carId);
        $cart = session('cart', []);
        // Prevent duplicate
        if (!collect($cart)->pluck('id')->contains($car->id)) {
            $cart[] = [
                'id' => $car->id,
                'name' => $car->make . ' ' . $car->model,
                'price' => $car->price,
            ];
        }
        session(['cart' => $cart]);
        return redirect()->route('car-sales');
    }

    // Remove a car from the cart
    public function removeFromCart($carId)
    {
        $cart = session('cart', []);
        $cart = collect($cart)->reject(function($item) use ($carId) {
            return $item['id'] == $carId;
        })->values()->toArray();
        session(['cart' => $cart]);
        return redirect()->route('car-sales');
    }

    // Handle checkout
    public function checkout(Request $request)
    {
        // Validate customer selection or new customer
        $request->validate([
            'customer_id' => 'nullable|exists:contacts,id',
            'customer_name' => 'nullable|string',
            'customer_email' => 'nullable|email',
            'customer_address' => 'nullable|string',
            'customer_phone' => 'nullable|string',
            'ent_vat' => 'required|numeric|min:0',
            'Ent_discount' => 'required|numeric|min:0',
            'vat_value' => 'required|numeric',
            'discount_value' => 'required|numeric',
            'subtotal' => 'nullable',
            'grand_total' => 'nullable',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'No cars in cart.');
        }

        // If no customer_id but new customer details provided, create new contact
        if (!$request->customer_id && ($request->customer_name || $request->customer_email || $request->customer_phone)) {
            $contact = new contacts();
            $contact->name = $request->customer_name;
            $contact->email = $request->customer_email;
            $contact->telephoneno = $request->customer_phone;
            $contact->address = $request->customer_address;
            $contact->setting_id = auth()->user()->setting_id ?? null;
            // Generate unique customerid
            $company_abbr = Abbr_company_name();
            $contact->customerid = $company_abbr.strtoupper(substr(md5(uniqid(rand(1,6))), 0, 7));
            $contact->save();

        }

        // Prepare order data
        $orderData = [
            'customer_id' => $request->customer_id ?? $contact->id ?? null,
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'status' => $request->status ?? 'pending',
            'payment_status' => $request->payment_status ?? 'unpaid',
            // 'payment_method' => null,
            'subtotal' => str_replace(',', '', preg_replace('/[^\d.]/', '', $request->input('subtotal', 0))),
            'discount_percent' => $request->Ent_discount,
            'discount_value' => $request->discount_value,
            'vat_percent' => $request->ent_vat,
            'vat_value' => $request->vat_value,
            'total' => str_replace(',', '', preg_replace('/[^\d.]/', '', $request->input('grand_total', 0))),
            // 'order_date' => now(),
            // 'delivery_date' => null,
        ];

        $order = CarOrder::create($orderData);

        // Save order items
        foreach ($cart as $car) {
            CarOrderItem::create([
                'order_id' => $order->id,
                'car_id' => $car['id'],
                'price' => $car['price'],
            ]);
            // Mark car as sold
            if($request->status === 'completed' && $request->payment_status === 'paid'){
                $carModel = CarInventory::find($car['id']);
                if ($carModel) {
                    $carModel->status = 'sold';
                    $carModel->save();
                }
            }
            if($request->payment_status === 'partially_paid'){
                $carModel = CarInventory::find($car['id']);
                if ($carModel) {
                    $carModel->status = 'on-hold';
                    $carModel->save();
                }
            }
        }

        session()->forget('cart');

        if($order->status === 'completed'){
            return redirect()->route('car-orders')->with('message', 'Car sale processed! <a href="/car-orders/'. $order->id .'/print/invoice" target="_blank" class="btn btn-success">Print Invoice</a> OR <a href="/car-orders/'. $order->id .'/print/invoice" target="_blank" class="btn btn-primary">Print Receipt</a>');
        }
        return redirect()->route('car-orders')->with('message', 'Car sale processed! <a href="/car-orders/'. $order->id .'/print/invoice" target="_blank" class="btn btn-success">Print Invoice</a>');
    }

    public function updateOrder(Request $request, $id)
    {
        $order = CarOrder::findOrFail($id);
        $order->status = $request->status;
        $order->payment_status = $request->payment_status;
        $order->save();

        // Update car statuses based on order payment status
        $carItems = $order->items;
        if($order->payment_status === 'partially_paid'){
            foreach ($carItems as $item) {
                $car = CarInventory::find($item->car_id);
                if ($car) {
                    $car->status = 'on-hold';
                    $car->save();
                }
            }
        }
        // Update car statuses based on order status
        if ($order->status === 'completed' && $order->payment_status === 'paid') {
            foreach ($carItems as $item) {
                $car = CarInventory::find($item->car_id);
                if ($car) {
                    $car->status = 'sold';
                    $car->save();
                }
            }
        } elseif ($order->status === 'cancelled') {
            foreach ($carItems as $item) {
                $car = CarInventory::find($item->car_id);
                if ($car) {
                    $car->status = 'available';
                    $car->save();
                }
            }
        }

        if($order->status === 'completed'){
            return redirect()->route('car-orders')->with('message', $order->order_number .' Order updated successfully!   <a href="/car-orders/'. $order->id .'/print/invoice" target="_blank" class="btn btn-success">Print Invoice</a>  OR  <a href="/car-orders/'. $order->id .'/print/invoice" target="_blank" class="btn btn-primary">Print Receipt</a>');
        }
        return redirect()->route('car-orders')->with('message', $order->order_number .' Order updated successfully!   <a href="/car-orders/'. $order->id .'/print/invoice" target="_blank" class="btn btn-success">Print Invoice</a>');

    }


    public function deleteOrder($id)
    {
        $order = CarOrder::findOrFail($id);
        $order->delete();
        return redirect()->back()->with('message', $order->order_number . ' Order deleted successfully!');
    }


    public function printDocument($id, $type)
    {
        $order = CarOrder::with(['items', 'customer'])->findOrFail($id);
        return view('car_inventory.car-invoice', compact('order', 'type'));
    }


}
