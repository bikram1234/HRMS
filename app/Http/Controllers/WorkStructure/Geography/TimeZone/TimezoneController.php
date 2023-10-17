<?php

namespace App\Http\Controllers\WorkStructure\Geography\TimeZone;

use App\Http\Controllers\Controller;
use App\Models\timezone;
use App\Models\country;
use App\Http\Requests\StoretimezoneRequest;
use App\Http\Requests\UpdatetimezoneRequest;

class TimezoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = country::all();
        $timezones = timezone::all();
        return view('work_structure.geography.timezone.timezone', compact('timezones', 'countries'));
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
    public function store(StoretimezoneRequest $request)
    {
        timezone::create($request->validated());
         //display the message 
         $notification = array(
            'message' => 'Time zone added succesfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(timezone $timezone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(timezone $timezone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatetimezoneRequest $request, timezone $timezone)
    {
        $timezone->update($request->validated());
         //display the message 
         $notification = array(
            'message' => 'Time zone Updated succesfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(timezone $timezone)
    {
        $timezone->delete();
         //display the message 
         $notification = array(
            'message' => 'Time zone Deleted succesfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);
    }
}
