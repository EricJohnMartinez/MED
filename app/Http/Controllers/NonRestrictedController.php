<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNonRestrictedRequest;
use App\Models\NonRestricted;
use App\Models\Restricted;
use Illuminate\Http\Request;

class NonRestrictedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
        $nonrestricted = NonRestricted::orderBy('created_at', 'desc')->get();

        if (request()->wantsJson()) {
            return response(
                NonRestricted::all()
            );
        }
        $nonrestricted = NonRestricted::where(function ($query) use ($request) {
            $query->when(!empty($request->query('query')), function ($query) use ($request) {
                $queryString = $request->query('query');

                $query->where('name', 'like', '%' . $queryString . '%')
                    ->orWhere('date', 'like', '%' . $queryString . '%')
                    ->orWhere('ward', 'like', '%' . $queryString . '%')
                    ->orWhere('drug', 'like', '%' . $queryString . '%')
                    ->orWhere('total', 'like', '%' . $queryString . '%')
                    ->orWhere('nurse', 'like', '%' . $queryString . '%')
                    ->orWhere('pharmacist', 'like', '%' . $queryString . '%')
                    ->orWhere('dosege', 'like', '%' . $queryString . '%');
            });
        })->latest()->paginate(10);
        return view('nonrestricted.index')->with([
            'nonrestricteddrugs' => $nonrestricted,
            'nonrestricted' => $nonrestricted,
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
        return view('nonrestricted.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNonRestrictedRequest $request)
    {
        $nonrestricted = NonRestricted::create([
            'name' => $request->name,
            'date' => $request->date,
            'ward' => $request->ward,
            'drug' => $request->drug,
            'dosege' => $request->dosege,
            'total' => $request->total,
            'nurse' => $request->nurse,
            'pharmacist' => $request->pharmacist,
        ]);

        if (!$nonrestricted) {
            return redirect()->back()->with('error', 'Sorry, Something went wrong while creating customer.');
        }
        return redirect()->route('nonrestricted.index')->with('success', 'Success, New customer has been added successfully!');
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
    public function edit(NonRestricted $nonrestricted)
    {
        // $nonrestricted=NonRestricted::class

        return view('nonrestricted.edit', compact('nonrestricted'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NonRestricted $nonrestricted )
    {
        $nonrestricted->name = $request->name;
        $nonrestricted->ward = $request->ward;
        $nonrestricted->drug = $request->drug;
        $nonrestricted->dosege = $request->dosege;
        $nonrestricted->total = $request->toral;
        $nonrestricted->nurse = $request->nurse;
        $nonrestricted->pharmacist = $request->pharmacist;

         if (!$nonrestricted->save()) {
            return redirect()->back()->with('error', 'Sorry, Something went wrong while updating the customer.');
        }
        return redirect()->route('nonrestricted.index')->with('success', 'Success, The customer has been updated.');
        }


        public function editreplicate(NonRestricted $nonrestricted)
    {
        // $nonrestricted=NonRestricted::class

        return view('nonrestricted.replicate', compact('nonrestricted'));
    }
        public function replicate(Request $request, NonRestricted $nonrestricted )
        {
            $nonrestricted->name = $request->name;
            $nonrestricted->ward = $request->ward;
            $nonrestricted->drug = $request->drug;
            $nonrestricted->dosege = $request->dosege;
            $nonrestricted->total = $request->total;
            $nonrestricted->nurse = $request->nurse;
            $nonrestricted->pharmacist = $request->pharmacist;
    
             if (!$nonrestricted->save()) {
                return redirect()->back()->with('error', 'Sorry, Something went wrong while updating the customer.');
            }
            return redirect()->route('nonrestricted.index')->with('success', 'Success, The customer has been updated.');
            }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(NonRestricted $nonrestricted)
    {
        $nonrestricted->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
