<?php

namespace App\Http\Controllers\WorkStructure\Geography\Country;

use App\Http\Controllers\Controller;
use App\Models\country;
use App\Http\Requests\StorecountryRequest;
use App\Http\Requests\UpdatecountryRequest;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = country::all();
        return view('work_structure.geography.country.country', compact('countries'));
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
    public function store(StorecountryRequest $request)
    {
        country::create($request->validated());
         //display the message 
         $notification = array(
            'message' => 'Country Added successfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecountryRequest $request, country $country)
    {
       $country->update($request->validated());
        //display the message 
        $notification = array(
            'message' => 'Country Updated successfully',
            'alert-type' =>'success'
        );
       return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(country $country)
    {
        $country->delete();
         //display the message 
         $notification = array(
            'message' => 'Country Deleted successfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);
    }
}
