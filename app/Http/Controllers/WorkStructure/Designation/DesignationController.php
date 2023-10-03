<?php

namespace App\Http\Controllers\WorkStructure\Designation;

use App\Http\Controllers\Controller;
use App\Models\designation;
use App\Http\Requests\StoredesignationRequest;
use App\Http\Requests\UpdatedesignationRequest;
use Illuminate\Support\Facades\Gate;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Gate::allows('read: designation')) {
            abort(403, 'Unauthorized action.');
        }
        
        $designations = designation::all();
        return view('work_structure.designation.designation', compact('designations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('create: department')) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('work_structure.designation.designationAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoredesignationRequest $request)
    {
        if (!Gate::allows('create: designation')) {
            abort(403, 'Unauthorized action.');
        }
        
        Designation::create($request->validated());
        return redirect()->back()->with('success', 'Designation added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(designation $designation)
    {
        if (!Gate::allows('update: designation')) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('work_structure.designation.designationEdit', compact('designation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatedesignationRequest $request, designation $designation)
    {
        if (!Gate::allows('update: designation')) {
            abort(403, 'Unauthorized action.');
        }
        
        $designation->update($request->validated());
        return redirect()->route('designation.index')
        ->with('success', 'Designation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(designation $designation)
    {
        if (!Gate::allows('delete: designation')) {
            abort(403, 'Unauthorized action.');
        }
        
        $designation->delete();
        return redirect()->route('designation.index')->with('success', 'Designation Deleted Successfully!!!');
    }
}
