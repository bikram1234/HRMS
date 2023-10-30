<?php

namespace App\Http\Controllers\Settings\Approval\Encashment;

use App\Http\Controllers\Controller;
use App\Models\leaveEncashmentApprovalRule;
use App\Http\Requests\StoreleaveEncashmentApprovalRuleRequest;
use App\Http\Requests\UpdateleaveEncashmentApprovalRuleRequest;
use App\Models\LeaveEncashmentFormula;
class LeaveEncashmentApprovalRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $EncashmentApprovals = leaveEncashmentApprovalRule::all();
        return view('settings.approval.Encashment.ApprovalRuleEncashment', compact('EncashmentApprovals')); 
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
    public function store(StoreleaveEncashmentApprovalRuleRequest $request)
    {
        leaveEncashmentApprovalRule::create($request->validated());
        return redirect()->back()->with('success', 'Approval added successfully for Encashment.');
    }

    /**
     * Display the specified resource.
     */
    public function show(leaveEncashmentApprovalRule $leaveEncashmentApprovalRule)
    {
        // Retrieve the corresponding approval_rule record along with its related approval_conditions
        $approvalRuleRecord = leaveEncashmentApprovalRule::with('encashmentApprovalConditions')->find($leaveEncashmentApprovalRule->id);
       
        if (!$approvalRuleRecord) {
            // Handle the case where the record is not found, e.g., show an error message or redirect
            return redirect()->back()->with('error', 'Approval rule not found.');
        }
        
        // Filter specific conditions for the given approval_rule_id
        $specificConditions = $approvalRuleRecord->encashmentApprovalConditions->where('leave_encashment_approval_rule_id', $approvalRuleRecord->id);
        
        // Initialize an empty array to store formulas
        $formulas = [];
        
        // Loop through each specific condition to retrieve its associated formulas
        foreach ($specificConditions as $condition) {
            // Retrieve all the formulas associated with the condition
            $conditionFormulas = LeaveEncashmentFormula::where('encashment_condition_id', $condition->id)->get();
            
            // If formulas are found, add them to the array
            if ($conditionFormulas->isNotEmpty()) {
                $formulas[$condition->id] = $conditionFormulas;
            }
        } 
        
        return view('settings.approval.Encashment.approvalRuleEncashmentShow', compact('leaveEncashmentApprovalRule', 'approvalRuleRecord', 'specificConditions', 'formulas'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(leaveEncashmentApprovalRule $leaveEncashmentApprovalRule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateleaveEncashmentApprovalRuleRequest $request, leaveEncashmentApprovalRule $leaveEncashmentApprovalRule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(leaveEncashmentApprovalRule $leaveEncashmentApprovalRule)
    {
        //
    }
}
