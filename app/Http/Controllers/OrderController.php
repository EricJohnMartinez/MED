<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Product;


class OrderController extends Controller
{

    public function getOrderCount()
    {
        return response([
            'count' => Order::count(),
        ]);
    }

    public function index(Request $request)
{
    
    // $customers = new Customer();
    // if ($request->search) {
    //     $customers= $customers->Where('first_name', 'like', '%' . $request->search . '%');
    // }
    $orders = new Order();
    // Add a search parameter
    if ($request->search) {
        $orders = $orders->where('customer_id', 'like', '%' . $request->search . '%');
    }

    if ($request->start_date) {
        $orders = $orders->where('created_at', '>=', $request->start_date);
    }

    if ($request->end_date) {
        $orders = $orders->where('created_at', '<=', $request->end_date . ' 23:59:59');
    }

    $station = $request->query('station') ?? 1;

    $orders = $orders->where('station_id', '=', $station)
        ->with(['items', 'payments', 'customer'])
        ->latest()
        ->paginate(10);

    $total = $orders->map(function ($i) {
        return $i->total();
    })->sum();

    $receivedAmount = $orders->map(function ($i) {
        return $i->receivedAmount();
    })->sum();

    return view('orders.index', compact([
        'orders',
        'total',
        'receivedAmount',
        'station',
    ]));
}

    // public function index(Request $request)
    // {
       

    //     $orders = new Order();
    //     if ($request->start_date) {
    //         $orders = $orders->where('created_at', '>=', $request->start_date);
    //     }
    //     if ($request->end_date) {
    //         $orders = $orders->where('created_at', '<=', $request->end_date . ' 23:59:59');
    //     }
    //     $station = $request->query('station') ?? 1;

      
    //     $orders = $orders->where('station_id', '=', $station)
    //         ->with(['items', 'payments', 'customer'])
    //         ->latest()
    //         ->paginate(10);

    //     $total = $orders->map(function ($i) {
    //         return $i->total();
    //     })->sum();
    //     $receivedAmount = $orders->map(function ($i) {
    //         return $i->receivedAmount();
    //     })->sum();

    //     return view('orders.index', compact([
    //         'orders',
    //         'total',
    //         'receivedAmount',
    //         'station',
    //     ]));
    // }

    public function store(OrderStoreRequest $request)
    {
        $user = Customer::where('id', $request->customer_id)->first();

        if (!$user) {
            $name = null;
            $nurse = null;
            $room_number = null;
            $doctor = null;
        } else {
            $name = $user->first_name . ' ' . $user->last_name;
            $nurse = $user->name_of_nurse;
            $room_number = $user->room_number;
            $doctor = $user->doctor_name;
        }
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'user_id' => $request->user()->id,
            'station_id' => $request->station_id,
            'name' => $name,
            'nurse' => $nurse,
            'doctor' => $doctor,
            'room_number' => $room_number,
        ]);

        $cart = $request->user()->cart()->get();
        foreach ($cart as $item) {
            $product = Product::where('id', $item->id)->first();
            $order->items()->create([
                'price' => $item->price * $item->pivot->quantity,
                'quantity' => $item->pivot->quantity,
                'product_id' => $item->id,
                'name' =>  $name,
                'room_number' => $room_number,
                'doctor' => $doctor,
                'nurse' => $nurse,
                'product_name' => $product->name,
            ]);
            $item->quantity = $item->quantity - $item->pivot->quantity;
            $item->save();
        }
        $request->user()->cart()->detach();
        $order->payments()->create([
            'amount' => $request->amount,
            'user_id' => $request->user()->id,
        ]);
        return 'success';
    }

    public function viewReceipt(Order $order)
    {
        $order->load([
            'customer',
            'items',
            'items.product',
        ]);

        $pdf = Pdf::loadView('pdf.invoice', compact('order'));
        return $pdf->stream();
    }
}
