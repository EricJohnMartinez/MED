<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedicationRequest;
use App\Models\Medication;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    

    public function index( Request $request)
    {
        $medication = Medication::orderBy('created_at', 'desc')->get();

        if (request()->wantsJson()) {
            return response(
                Medication::all()
            );
        }
        $medication = Medication::where(function ($query) use ($request) {
            $query->when(!empty($request->query('query')), function ($query) use ($request) {
                $queryString = $request->query('query');

                $query->where('name', 'like', '%' . $queryString . '%')
                    ->orWhere('medicine', 'like', '%' . $queryString . '%')
                    ->orWhere('requested', 'like', '%' . $queryString . '%')
                    ->orWhere('dispensed', 'like', '%' . $queryString . '%')
                    ->orWhere('nurse', 'like', '%' . $queryString . '%')
                    ->orWhere('pharmacist', 'like', '%' . $queryString . '%')
                    ->orWhere('remarks', 'like', '%' . $queryString . '%');
            });
        })->latest()->paginate(10);
        return view('medication.index')->with([
            'dailymedications' => $medication,
            'medication' => $medication,
            'query' => $request->query('query') ?? null,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('medication.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMedicationRequest $request)
    {
        $medication = Medication::create([
            'name' => $request->name,
            'medicine' => $request->medicine,
            'requested' => $request->requested,
            'dispensed' => $request->dispensed,
            'nurse' => $request->nurse,
            'pharmacist' => $request->pharmacist,
            'remarks' => $request->remarks,
        ]);

        if (!$medication) {
            return redirect()->back()->with('error', 'Sorry, Something went wrong while creating customer.');
        }
        return redirect()->route('medication.index')->with('success', 'Success, New customer has been added successfully!');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Medication $medication)
    {
        // $nonrestricted=NonRestricted::class

        return view('medication.edit', compact('medication'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Medication $medication )
    {
        $medication->name = $request->name;
        $medication->medicine = $request->medicine;
        $medication->requested = $request->requested;
        $medication->dispensed = $request->dispensed;
        $medication->nurse = $request->nurse;
        $medication->pharmacist = $request->pharmacist;
        $medication->remarks = $request->remarks;

         if (!$medication->save()) {
            return redirect()->back()->with('error', 'Sorry, Something went wrong while updating the customer.');
        }
        return redirect()->route('medication.index')->with('success', 'Success, The customer has been updated.');
        }


        public function editreplicate(Medication $medication)
    {
        // $nonrestricted=NonRestricted::class

        return view('medication.replicate', compact('medication'));
    }
        public function replicate(Request $request, Medication $medication )
        {
            $medication->name = $request->name;
            $medication->medicine = $request->medicine;
            $medication->requested = $request->requested;
            $medication->dispensed = $request->dispensed;
            $medication->nurse = $request->nurse;
            $medication->pharmacist = $request->pharmacist;
            $medication->remarks = $request->remarks;
    
             if (!$medication->save()) {
                return redirect()->back()->with('error', 'Sorry, Something went wrong while updating the customer.');
            }
            return redirect()->route('medication.index')->with('success', 'Success, The customer has been updated.');
            }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medication $medication)
    {
        $medication->delete();

        return response()->json([
            'success' => true
        ]);
    }


}
