<?php

namespace App\Http\Controllers\WorkStructure\Geography\Dzongkhag;

use App\Http\Controllers\Controller;
use App\Models\dzongkhag;
use App\Models\country;
use App\Models\region;
use App\Http\Requests\StoredzongkhagRequest;
use App\Http\Requests\UpdatedzongkhagRequest;

class DzongkhagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dzongkhags = dzongkhag::all();
        $countries = country::all();
        $regions = region::all();
        return view('work_structure.geography.dzongkhag.dzongkhag', compact('dzongkhags', 'countries', 'regions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoredzongkhagRequest $request)
    {
        dzongkhag::create($request->validated());
        return redirect()->bacK()->with('success', 'Dzongkhag added succesfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(dzongkhag $dzongkhag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(dzongkhag $dzongkhag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatedzongkhagRequest $request, dzongkhag $dzongkhag)
    {
        $dzongkhag->update($request->validated());
        return redirect()->bacK()->with('success', 'Dzongkhag updated succesfully');  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(dzongkhag $dzongkhag)
    {
        $dzongkhag->delete();
        return redirect()->bacK()->with('success', 'Dzongkhag deleted succesfully');
    }

    public function getRegions($countryId)
    {
        // Fetch regions associated with the selected country
        $regions = Region::where('country_id', $countryId)->get();

        // Return the regions as JSON
        return response()->json($regions);
    }

}
