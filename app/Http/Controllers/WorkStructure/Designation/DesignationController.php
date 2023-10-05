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
        
        return view('work_structure.designation');
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
         //display the message 
         $notification = array(
            'message' => 'Designation Added successfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);
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
        return view('work_structure.designation', compact('designation'));
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

        //display the message 
        $notification = array(
            'message' => 'Designation Updated successfully',
            'alert-type' =>'success'
        );
        
        return redirect()->route('designation.index')->with($notification);
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
         //display the message 
         $notification = array(
            'message' => 'Designation Deleted successfully',
            'alert-type' =>'success'
        );
        
        return redirect()->route('designation.index')->with($notification);
    }
}
