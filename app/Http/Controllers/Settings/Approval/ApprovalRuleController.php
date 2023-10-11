<?php

namespace App\Http\Controllers\Settings\Approval;

use App\Http\Controllers\Controller;
use App\Models\ApprovalRule;
use App\Models\Formula;
use Illuminate\Http\Request;
use App\Models\ExpenseType;
use App\Models\leavetype;
use App\Models\approval_condition;
use App\Http\Requests\StoreApprovalRuleRequest;
use App\Http\Requests\UpdateApprovalRuleRequest;

class ApprovalRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $approvals = ApprovalRule::all();
        return view('settings.approval.ApprovalRule', compact('approvals')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $leavetypes = leavetype::all();
        $expenses = ExpenseType::all();
        $loans = [ ];
        return view('settings.approval.ApprovalAdd', compact('leavetypes', 'expenses', 'loans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApprovalRuleRequest $request)
    {
        ApprovalRule::create($request->validated());
        return redirect()->back()->with('success', 'Approval added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ApprovalRule $approvalRule)
    {
        // Retrieve the corresponding approval_rule record along with its related approval_conditions
        $approvalRuleRecord = ApprovalRule::with('approvalConditions')->find($approvalRule->id);
    
        // Filter specific conditions for the given approval_rule_id
        $specificConditions = $approvalRuleRecord->approvalConditions->where('approval_rule_id', $approvalRuleRecord->id);
    
        // Initialize an empty array to store formulas
        $formulas = [];
    
        // Loop through each specific condition to retrieve its associated formulas
        foreach ($specificConditions as $condition) {
            // Retrieve all the formulas associated with the condition
            $conditionFormulas = Formula::where('condition_id', $condition->id)->get();
    
            // If formulas are found, add them to the array
            if ($conditionFormulas->isNotEmpty()) {
                $formulas[$condition->id] = $conditionFormulas;
            }
        } 
    
        return view('settings.approval.approvalShow', compact('approvalRule', 'approvalRuleRecord', 'specificConditions', 'formulas'));
    }
    
    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApprovalRule $approvalRule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * 
     */
    public function update(UpdateApprovalRuleRequest $request, ApprovalRule $approvalRule)
    {
        $approvalRule->update($request->validated());
        return redirect()->back()->with('success', 'Approval Updated Successfully');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApprovalRule $approvalRule)
    {
        //
    }

    public function fetchTypes(Request $request, $for)
        {
            $selectedFor = $request->input('for');
            
            // Fetch types based on the selectedFor value
            if ($selectedFor === 'Leave') {
                $types = LeaveTypes::pluck('type')->toArray();
            } elseif ($selectedFor === 'Expense') {
                $types = ExpenseTypes::pluck('type')->toArray();
            } elseif ($selectedFor === 'Loan') {
                $types = LoanTypes::pluck('type')->toArray();
            } else {
                // Handle the default case
                $types = [];
            }
            

            return response()->json(['types' => $types]);
        }

}
