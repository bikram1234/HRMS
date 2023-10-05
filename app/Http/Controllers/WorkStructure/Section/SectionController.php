<?php

namespace App\Http\Controllers\WorkStructure\Section;

use App\Http\Controllers\Controller;
use App\Models\section;
use App\Models\department;
use App\Http\Requests\StoresectionRequest;
use App\Http\Requests\UpdatesectionRequest;
use Illuminate\Support\Facades\Gate;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Gate::allows('read: section')) {
            abort(403, 'Unauthorized action.');
        }
        $departments = department::all();
        $sections = section::all();
        return view('work_structure.section.section', compact('sections', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('create: section')) {
            abort(403, 'Unauthorized action.');
        }

        $departments = department::all();
        return view('work_structure.section', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoresectionRequest $request)
    {
        if (!Gate::allows('create: section')) {
            abort(403, 'Unauthorized action.');
        }

        Section::create($request->validated());
        
          //display the message 
          $notification = array(
            'message' => 'Section Added successfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(section $section)
    {
        if (!Gate::allows('update: section')) {
            abort(403, 'Unauthorized action.');
        }

        $departments = department::all();
        return view('work_structure.section', compact('departments', 'section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatesectionRequest $request, section $section)
    {
        if (!Gate::allows('update: section')) {
            abort(403, 'Unauthorized action.');
        }

        $section->update($request->validated());

            //display the message 
            $notification = array(
                'message' => 'Section Updated successfully',
                'alert-type' =>'success'
            );
            return redirect()->route('section.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(section $section)
    {
        if (!Gate::allows('delete: section')) {
            abort(403, 'Unauthorized action.');
        }

        $section->delete();
          //display the message 
          $notification = array(
            'message' => 'Section Deleted successfully',
            'alert-type' =>'success'
        );
        return redirect()->route('section.index')->with($notification);

    }

    public function getSectionsByDepartment($department)
    {
        $sections = Section::where('department', $department)->get();
        return response()->json(['sections' => $sections]); 
    }

}

