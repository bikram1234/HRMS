<?php

namespace App\Http\Controllers\Settings\Formula\Encashment;

use App\Http\Controllers\Controller;
use App\Models\leaveEncashmentFormula;
use App\Models\User;
use App\Http\Requests\StoreleaveEncashmentFormulaRequest;
use App\Http\Requests\UpdateleaveEncashmentFormulaRequest;

class LeaveEncashmentFormulaController extends Controller
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

    public function createForEncashmentApprovalCondition($encashmentApprovalConditionId)
    {
        $users = User::all();
        $formulas = leaveEncashmentFormula::where('encashment_condition_id', $encashmentApprovalConditionId)->get();
        // Logic for creating a formula for the given approval condition
        return view('settings.approval.formula.encashment.encashmentFormula', compact('encashmentApprovalConditionId', 'formulas', 'users'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreleaveEncashmentFormulaRequest $request)
    {
        leaveEncashmentFormula::create($request->validated());
        return redirect()->back()->with('success', 'Formula added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(leaveEncashmentFormula $leaveEncashmentFormula)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(leaveEncashmentFormula $leaveEncashmentFormula)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateleaveEncashmentFormulaRequest $request, leaveEncashmentFormula $leaveEncashmentFormula)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(leaveEncashmentFormula $leaveEncashmentFormula)
    {
        $leaveEncashmentFormula->delete();
        return redirect()->back()->with('success', 'Deletion Success');
    }
}
