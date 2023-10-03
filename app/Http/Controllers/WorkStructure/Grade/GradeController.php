<?php

namespace App\Http\Controllers\WorkStructure\Grade;

use App\Http\Controllers\Controller;
use App\Models\grade;
use App\Http\Requests\StoregradeRequest;
use App\Http\Requests\UpdategradeRequest;
use Illuminate\Support\Facades\Gate;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Gate::allows('read: grade')) {
            abort(403, 'Unauthorized action.');
        }

        $grades = grade::all();
        return view('work_structure.grade.grade', compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('create: grade')) {
            abort(403, 'Unauthorized action.');
        }

        return view('work_structure.grade.gradeAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoregradeRequest $request)
    {
        if (!Gate::allows('create: grade')) {
            abort(403, 'Unauthorized action.');
        }

        Grade::create($request->validated());
        return redirect()->back()->with('success', 'Grade added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(grade $grade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(grade $grade)
    {
        if (!Gate::allows('update: grade')) {
            abort(403, 'Unauthorized action.');
        }

        return view('work_structure.grade.gradeEdit', compact('grade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdategradeRequest $request, grade $grade)
    {
        if (!Gate::allows('update: grade')) {
            abort(403, 'Unauthorized action.');
        }

        $grade->update($request->validated());
        return redirect()->route('grade.index')->with('success', 'Grade added Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(grade $grade)
    {
        if (!Gate::allows('delete: grade')) {
            abort(403, 'Unauthorized action.');
        }

        $grade->delete();
        return redirect()->route('grade.index')->with('success', 'Grade Deleted Successfully');
    }
}
