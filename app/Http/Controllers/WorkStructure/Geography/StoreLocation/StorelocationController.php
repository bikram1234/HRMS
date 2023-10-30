<?php

namespace App\Http\Controllers\WorkStructure\Geography\StoreLocation;

use App\Http\Controllers\Controller;
use App\Models\storelocation;
use App\Models\dzongkhag; 
use App\Models\timezone;
use App\Http\Requests\StorestorelocationRequest;
use App\Http\Requests\UpdatestorelocationRequest;

class StorelocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dzongkhags = dzongkhag::all();
        $storelocations = storelocation::all();
        $timezones = timezone::all();
        return view('work_structure.geography.storelocation.storelocation', compact('storelocations', 'dzongkhags', 'timezones'));
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
    public function store(StorestorelocationRequest $request)
    {
        storelocation::create($request->validated());
        return redirect()->bacK()->with('success', 'Storelocation added succesfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(storelocation $storelocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(storelocation $storelocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatestorelocationRequest $request, storelocation $storelocation)
    {
        $storelocation->update($request->validated());
        return redirect()->bacK()->with('success', 'Storelocation updated succesfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(storelocation $storelocation)
    {
        $storelocation->delete();
        return redirect()->bacK()->with('success', 'Storelocation deleted succesfully');
    }
}
