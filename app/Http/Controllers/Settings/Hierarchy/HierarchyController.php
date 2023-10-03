<?php

namespace App\Http\Controllers\Settings\Hierarchy;

use App\Http\Controllers\Controller;
use App\Models\hierarchy;
use App\Models\level;
use App\Models\User;
use App\Http\Requests\StorehierarchyRequest;
use App\Http\Requests\StoreLevelRequest;
use App\Http\Requests\UpdatehierarchyRequest;
use Illuminate\Http\Request;

class HierarchyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hierarchies = Hierarchy::all();
        return view('settings.hierarchy.hierarchy', compact('hierarchies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('settings.hierarchy.hierarchyAdd', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHierarchyRequest $request, StoreLevelRequest $levelRequest)
        {
            // Validation for hierarchy data (StoreHierarchyRequest)
            $request->validated();

            // Validate and save the hierarchy data
            $hierarchy = Hierarchy::create([
                'name' => $request->input('name'),
            ]);

            $hierarchyId = $hierarchy->id;

            // Validation for level data (StoreLevelRequest)
            $levelRequest->validated();

            // Create a new level associated with the hierarchy
            $levelData = [
                'level' => $levelRequest->input('level'),
                'value' => $levelRequest->input('value'),
                'employee_id' => $levelRequest->input('employee_id'),
                'start_date' => $levelRequest->input('start_date'),
                'end_date' => $levelRequest->input('end_date'),
                'status' => $levelRequest->input('status'),
                'hierarchy_id' => $hierarchyId,
            ];

            $level = Level::create($levelData);

            return redirect()->back()->with('success', 'Hierarchy added successfully.');
        }

        public function storeLevel($hierarchyId, StoreLevelRequest $levelRequest)
        {
            // Validation for level data (StoreLevelRequest)
            $levelRequest->validated();

            // Create a new level associated with the hierarchy
            $levelData = [
                'level' => $levelRequest->input('level'),
                'value' => $levelRequest->input('value'),
                'employee_id' => $levelRequest->input('employee_id'),
                'start_date' => $levelRequest->input('start_date'),
                'end_date' => $levelRequest->input('end_date'),
                'status' => $levelRequest->input('status'),
                'hierarchy_id' => $hierarchyId,
            ];

            $level = Level::create($levelData);

            return redirect()->back()->with('success', 'Level added successfully to the hierarchy.');
}



    /**
     * Display the specified resource.
     */
    public function show($hierarchy_id)
    {
        $users = User::all();
        // Retrieve the hierarchy record by ID
        $hierarchy = Hierarchy::findOrFail($hierarchy_id);

        // Retrieve the related level data for the hierarchy
        $levels = Level::where('hierarchy_id', $hierarchy_id)->get();
    
        return view('settings.hierarchy.hierarchyShow', compact('hierarchy', 'levels', 'users'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(hierarchy $hierarchy)
    {
        return view('settings.hierarchy.hierarchyEdit', compact('hierarchy'));   
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatehierarchyRequest $request, hierarchy $hierarchy)
    {
        $hierarchy->update($request->validated());
        return redirect()->route('hierarchy.index')
        ->with('success', 'Hierarchy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(hierarchy $hierarchy)
    {
        $hierarchy->delete();
        return redirect()->route('hierarchy.index')->with('success', 'Hierarchy Deleted Successfully!!!');    
    }

    public function getLevels($hierarchyId)
    {
        // Retrieve levels associated with the selected hierarchy
        $levels = Level::where('hierarchy_id', $hierarchyId)->get();
        
        return response()->json($levels);
    }
}
