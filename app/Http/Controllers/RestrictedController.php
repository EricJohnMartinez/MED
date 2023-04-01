<?php

namespace App\Http\Controllers;

use App\Models\Restricted;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRestrictedRequest;

class RestrictedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $restricted = Restricted::orderBy('created_at', 'desc')->get();

        if (request()->wantsJson()) {
            return response(
                Restricted::all()
            );
        }
        $restricted = Restricted::where(function ($query) use ($request) {
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
        return view('restricted.index')->with([
            'restricteddrugs' => $restricted,
            'restricted' => $restricted,
            'query' => $request->query('query') ?? null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editreplicate(Restricted $restricted)
    {
        // $nonrestricted=NonRestricted::class

        return view('restricted.replicate', compact('restricted'));
    }
    public function create()
    {
        return view('restricted.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRestrictedRequest $request)
    {
        $restricted = Restricted::create([
            'name' => $request->name,
            'date' => $request->date,
            'ward' => $request->ward,
            'drug' => $request->drug,
            'dosege' => $request->dosege,
            'total' => $request->total,
            'nurse' => $request->nurse,
            'pharmacist' => $request->pharmacist,
        ]);

        if (!$restricted) {
            return redirect()->back()->with('error', 'Sorry, Something went wrong while creating customer.');
        }
        return redirect()->route('restricted.index')->with('success', 'Success, New customer has been added successfully!');
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
    public function edit(Restricted $restricted)
    {
        // $nonrestricted=NonRestricted::class

        return view('restricted.edit', compact('restricted'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restricted $restricted )
    {
        $restricted->name = $request->name;
        $restricted->ward = $request->ward;
        $restricted->drug = $request->drug;
        $restricted->dosege = $request->dosege;
        $restricted->total = $request->total;
        $restricted->nurse = $request->nurse;
        $restricted->pharmacist = $request->pharmacist;

         if (!$restricted->save()) {
            return redirect()->back()->with('error', 'Sorry, Something went wrong while updating the customer.');
        }
        return redirect()->route('nonrestricted.index')->with('success', 'Success, The customer has been updated.');
        }

        public function replicate(Request $request, Restricted $restricted )
        {
            $restricted->name = $request->name;
            $restricted->ward = $request->ward;
            $restricted->drug = $request->drug;
            $restricted->dosege = $request->dosege;
            $restricted->total = $request->total;
            $restricted->nurse = $request->nurse;
            $restricted->pharmacist = $request->pharmacist;
    
             if (!$restricted->save()) {
                return redirect()->back()->with('error', 'Sorry, Something went wrong while updating the customer.');
            }
            return redirect()->route('restricted.index')->with('success', 'Success, The customer has been updated.');
            }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restricted $restricted)
    {
        $restricted->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
