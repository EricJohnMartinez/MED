<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorOrderSheetRequest;
use App\Models\DoctorOrderSheet;
use Illuminate\Http\Request;

class DoctorOrderSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $doctorsordersheet = DoctorOrderSheet::orderBy('created_at', 'desc')->get();

        if (request()->wantsJson()) {
            return response(
                DoctorOrderSheet::all()
            );
        }
        $doctorsordersheet = DoctorOrderSheet::where(function ($query) use ($request) {
            $query->when(!empty($request->query('query')), function ($query) use ($request) {
                $queryString = $request->query('query');

                $query->where('name', 'like', '%' . $queryString . '%')
                ->orWhere('progress', 'like', '%' . $queryString . '%')
                ->orWhere('doctorsorder', 'like', '%' . $queryString . '%');
            });
        })->latest()->paginate(10);
        return view('doctorsordersheet.index')->with([
            'doctorsordersheet' => $doctorsordersheet,
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
        return view('doctorsordersheet.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDoctorOrderSheetRequest $request)
    {
        $doctorsordersheet = DoctorOrderSheet::create([
            'name' => $request->name,
            'progress' => $request->progress,
            'doctorsorder' => $request->doctorsorder,
        ]);

        if (!$doctorsordersheet) {
            return redirect()->back()->with('error', 'Sorry, Something went wrong while creating customer.');
        }
        return redirect()->route('doctorsordersheet.index')->with('success', 'Success, New customer has been added successfully!');
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
    public function edit(DoctorOrderSheet $doctorsordersheet)
    {
        return view('doctorsordersheet.edit', compact('doctorsordersheet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DoctorOrderSheet $doctorsordersheet )
    {
        $doctorsordersheet->name = $request->name;
        $doctorsordersheet->progress = $request->progress;
        $doctorsordersheet->doctorsorder = $request->doctorsorder;

         if (!$doctorsordersheet->save()) {
            return redirect()->back()->with('error', 'Sorry, Something went wrong while updating the customer.');
        }
        return redirect()->route('doctorsordersheet.index')->with('success', 'Success, The customer has been updated.');
        }

        public function editreplicate(DoctorOrderSheet $doctorsordersheet)
        {
            // $nonrestricted=NonRestricted::class
    
            return view('doctorsordersheet.replicate', compact('doctorsordersheet'));
        }

        public function replicate(Request $request, DoctorOrderSheet $doctorsordersheet )
        {
            $doctorsordersheet->name = $request->name;
            $doctorsordersheet->progress = $request->progress;
            $doctorsordersheet->doctorsorder = $request->doctorsorder;
    
             if (!$doctorsordersheet->save()) {
                return redirect()->back()->with('error', 'Sorry, Something went wrong while updating the customer.');
            }
            return redirect()->route('doctorsordersheet.index')->with('success', 'Success, The customer has been updated.');
            }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DoctorOrderSheet $doctorsordersheet)
    {
        $doctorsordersheet->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
