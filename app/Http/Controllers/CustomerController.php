<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            return response(
                Customer::all()
            );
        }
    
        $customers = Customer::where(function ($query) use ($request) {
            $query->when(!empty($request->query('query')), function ($query) use ($request) {
                $queryString = $request->query('query');
    
                $query->where('first_name', 'like', '%' . $queryString . '%')
                    ->orWhere('id', 'like', '%' . $queryString . '%')
                    ->orWhere('last_name', 'like', '%' . $queryString . '%')
                    ->orWhere('room_number', 'like', '%' . $queryString . '%')
                    ->orWhere('created_at', 'like', '%' . $queryString . '%');
            });
    
            $query->when(!empty($request->query('status')), function ($query) use ($request) {
                $query->where('is_discharged', $request->query('status'));
            });
            
        })->latest()->paginate(10);
    
        return view('customers.index')->with([
            'customers' => $customers,
            'query' => $request->query('query') ?? null,
            'selectedStatus' => $request->query('status') ?? null,
        ]);
    }

    public function medication(Request $request)
    {
    
        if (request()->wantsJson()) {
            return response(
                Customer::all()
            );
        }
        $customers = Customer::where(function ($query) use ($request) {
            $query->when(!empty($request->query('query')), function ($query) use ($request) {
                $queryString = $request->query('query');

                $query->where('first_name', 'like', '%' . $queryString . '%')
                    ->orWhere('id', 'like', '%' . $queryString . '%')
                    ->orWhere('last_name', 'like', '%' . $queryString . '%')
                    ->orWhere('medications', 'like', '%' . $queryString . '%')
                    ->orWhere('restricted_drugs', 'like', '%' . $queryString . '%');
            });
        })->latest()->paginate(10);
        return view('customers.medication')->with([
            'customers' => $customers,
            'query' => $request->query('query') ?? null,
        ]);
    }



    public function getDischarged(Customer $customer)
    {

        if (request()->wantsJson()) {
            return response(
                Customer::where('is_discharged', 1)->get()
            );
        }
        $customers = Customer::where('is_discharged', 1)
        ->latest()->paginate(10);
        return view('medical-history.index')->with([
            'customers' => $customers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerStoreRequest $request)
    {
        $avatar_path = '';

        if ($request->hasFile('avatar')) {
            $avatar_path = $request->file('avatar')->store('customers', 'public');
        }

        $customer = Customer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'nickname' => $request->nickname,
            'doctor_name' => $request->doctor_name,
            'name_of_nurse' => $request->name_of_nurse,
            'marital_status' => $request->marital_status,
            'sex' => $request->sex,
            'height' => $request->height,
            'weight' => $request->weight,
            'philhealth' => $request->philhealth,
            'date_of_birth' => $request->date_of_birth,
            'emergency' => $request->emergency,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'avatar' => $avatar_path,
            'user_id' => $request->user()->id,
            'room_number' => $request->room_number,
        ]);

        if (!$customer) {
            return redirect()->back()->with('error', 'Sorry, Something went wrong while creating customer.');
        }
        return redirect()->route('customers.index')->with('success', 'Success, New customer has been added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
       

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     * 
     * 
     */
    public function updatemedication(Request $request, Customer $customer)
    {   
        $customer->medicines_fluids = $request->medicines_fluids;
        $customer->requested = $request->requested;
        $customer->dispensed = $request->dispensed;
        $customer->pharmacist_duty = $request->pharmacist_duty;
        $customer->nurse_duty = $request->nurse_duty;
        $customer->daily_remarks = $request->daily_remarks;

        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($customer->avatar) {
                Storage::delete($customer->avatar);
            }
            // Store avatar
            $avatar_path = $request->file('avatar')->store('customers', 'public');
            // Save to Database
            $customer->avatar = $avatar_path;

         }
         if (!$customer->save()) {
            return redirect()->back()->with('error', 'Sorry, Something went wrong while updating the customer.');
        }
        return redirect()->route('customers.medication')->with('success', 'Success, The customer has been updated.');
        }

    public function editmedication(Request $request, Customer $customer)
    {
        // dd($customer->id);
        $orders = Order::where('customer_id', $customer->id)->get();
        // dd($order);
            return view('customers.editmedication', compact('customer', 'orders'));
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->medicines_fluids = $request->medicines_fluids;
        $customer->requested = $request->requested;
        $customer->dispensed = $request->dispensed;
        $customer->pharmacist_duty = $request->pharmacist_duty;
        $customer->nurse_duty = $request->nurse_duty;
        $customer->daily_remarks = $request->daily_remarks;

        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->nickname = $request->nickname;
        $customer->philhealth = $request->philhealth;
        $customer->sex = $request->sex;
        $customer->emergency = $request->emergency;
        $customer->date_of_birth = $request->date_of_birth;
        $customer->marital_status = $request->marital_status;
        $customer->room_number = $request->room_number;
        $customer->email = $request->email;
        $customer->height = $request->height;
        $customer->weight = $request->weight;
        $customer->phone = $request->phone;
        $customer->address = $request->address;

        $customer->medicines = $request->medicines;
        $customer->name_of_nurse = $request->name_of_nurse;
        $customer->progress_notes = $request->progress_notes;
        $customer->doctors_order = $request->doctors_order;
        $customer->remarks = $request->remarks;
        $customer->prepared_by = $request->prepared_by;
        $customer->medical_history = $request->medical_history;
        $customer->medications = $request->medications;
        $customer->restricted_drugs = $request->restricted_drugs;

        $customer->doctor_name = $request->doctor_name;
        $customer->is_discharged = $request->is_discharged;

        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($customer->avatar) {
                Storage::delete($customer->avatar);
            }
            // Store avatar
            $avatar_path = $request->file('avatar')->store('customers', 'public');
            // Save to Database
            $customer->avatar = $avatar_path;
        }

        if (!$customer->save()) {
            return redirect()->back()->with('error', 'Sorry, Something went wrong while updating the customer.');
        }
        return redirect()->route('customers.index')->with('success', 'Success, The customer has been updated.');
    }

    public function destroy(Customer $customer)
    {
        if ($customer->avatar) {
            Storage::delete($customer->avatar);
        }

        $customer->delete();

       return response()->json([
           'success' => true
       ]);
    }
}
