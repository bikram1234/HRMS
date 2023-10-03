<?php

namespace App\Http\Controllers\Leave\Type;

use App\Http\Controllers\Controller;
use App\Models\leavetype;
use App\Http\Requests\StoreleavetypeRequest;
use App\Http\Requests\UpdateleavetypeRequest;

class LeavetypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leavetypes = leavetype::all();
        return view('leave.type.leaveType', compact('leavetypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leave.type.leaveTypeAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreleavetypeRequest $request)
    {
        leavetype::create($request->validated());
        return redirect()->back()->with('success', 'LeaveType added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(leavetype $leavetype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(leavetype $leavetype)
    {
        return view('leave.type.leaveTypeEdit', compact('leavetype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateleavetypeRequest $request, leavetype $leavetype)
    {
        // Retrieve the specific leavetype instance
        $leavetypeInstance = leavetype::find($leavetype->id);
    
        // Check if the instance exists
        if (!$leavetypeInstance) {
            return redirect()->back()->with('error', 'LeaveType not found.');
        }
    
        // Update the attributes using the validated request data
        $leavetypeInstance->update($request->validated());
    
        return redirect()->route('leavetype.index')->with('success', 'LeaveType Updated successfully.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(leavetype $leavetype)
    {
        //
    }

}
