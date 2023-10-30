<?php

namespace App\Http\Controllers\Settings\Approval\Encashment;

use App\Http\Controllers\Controller;
use App\Models\leaveEncashmentApprovalCondition;
use App\Http\Requests\StoreleaveEncashmentApprovalConditionRequest;
use App\Http\Requests\UpdateleaveEncashmentApprovalConditionRequest;
use App\Models\User;
use App\Models\leaveEncashmentFormula;
use App\Models\hierarchy;

class LeaveEncashmentApprovalConditionController extends Controller
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
    public function create($encashment_approval_rule_id)
    {
        $hierarchies = hierarchy::all();
        $users = User::all();
        // Use $approvalRuleId to fetch the relevant approval conditions
        return view('settings.approval.Encashment.conditionEncashment', compact('encashment_approval_rule_id', 'hierarchies', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreleaveEncashmentApprovalConditionRequest $request)
    {
        $leave_encashment_approval_rule_id	 = $request->input('leave_encashment_approval_rule_id');
        leaveEncashmentApprovalCondition::create($request->validated());
        return redirect()->route('approval_encashment.show', ['leaveEncashmentApprovalRule'=>$leave_encashment_approval_rule_id])->with('success', 'Approval Condition added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(leaveEncashmentApprovalCondition $leaveEncashmentApprovalCondition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(leaveEncashmentApprovalCondition $leaveEncashmentApprovalCondition)
    {
        $hierarchies = hierarchy::all();
        $users = User::all();
        $condtion_id = $leaveEncashmentApprovalCondition->id;
        $formula = leaveEncashmentFormula::where('encashment_condition_id', $condtion_id)->get();
        return view('settings.approval.Encashment.conditionEncashmentEdit', compact('leaveEncashmentApprovalCondition', 'formula', 'hierarchies', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateleaveEncashmentApprovalConditionRequest $request, leaveEncashmentApprovalCondition $leaveEncashmentApprovalCondition)
    {
        $leaveEncashmentApprovalCondition->update($request->validated());
        return redirect()->back()->with('success', 'Condition Updated successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(leaveEncashmentApprovalCondition $leaveEncashmentApprovalCondition)
    {
        //
    }
}
