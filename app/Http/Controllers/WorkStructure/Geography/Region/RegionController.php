<?php

namespace App\Http\Controllers\WorkStructure\Geography\Region;

use App\Http\Controllers\Controller;
use App\Models\region;
use App\Models\country;
use App\Http\Requests\StoreregionRequest;
use App\Http\Requests\UpdateregionRequest;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = country::all();
        $regions = region::all();
        return view('work_structure.geography.region.region', compact('regions', 'countries'));
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
    public function store(StoreregionRequest $request)
    {
        region::create($request->validated());
         //display the message 
         $notification = array(
            'message' => 'Region Added succesfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(region $region)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(region $region)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateregionRequest $request, region $region)
    {
        $region->update($request->validated());
         //display the message 
         $notification = array(
            'message' => 'Region Updated succesfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(region $region)
    {
        $region->delete();
         //display the message 
         $notification = array(
            'message' => 'Region Deleted succesfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);
    }
}
