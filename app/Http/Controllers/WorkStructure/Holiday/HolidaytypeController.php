<?php

namespace App\Http\Controllers\WorkStructure\Holiday;

use App\Http\Controllers\Controller;
use App\Models\holidaytype;
use App\Http\Requests\StoreholidaytypeRequest;
use App\Http\Requests\UpdateholidaytypeRequest;

class HolidaytypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreholidaytypeRequest $request)
    {
        holidaytype::create($request->validated());
        return redirect()->back()->with('success', 'Holiday Type Added succesfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(holidaytype $holidaytype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(holidaytype $holidaytype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateholidaytypeRequest $request, holidaytype $holidaytype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(holidaytype $holidaytype)
    {
        $holidaytype->delete();
        
    }
}
