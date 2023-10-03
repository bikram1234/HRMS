<?php

namespace App\Http\Controllers\Leave\Rule;

use App\Http\Controllers\Controller;
use App\Models\leave_rule;
use App\Http\Requests\Storeleave_ruleRequest;
use App\Http\Requests\Updateleave_ruleRequest;

class LeaveRuleController extends Controller
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
    public function store(Storeleave_ruleRequest $request)
    {
        leave_rule::create($request->validated());
        return redirect()->back()->with('success', 'LeaveRule added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(leave_rule $leave_rule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(leave_rule $leave_rule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateleave_ruleRequest $request, leave_rule $leave_rule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(leave_rule $leave_rule)
    {
        //
    }
}
