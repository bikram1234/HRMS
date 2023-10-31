<?php

namespace App\Http\Controllers\Settings\Approval;

use App\Http\Controllers\Controller;
use App\Models\AdvanceApprovalRule;
use App\Models\Formula;
use Illuminate\Http\Request;
use App\Models\ExpenseType;
use App\Models\Advance;
use App\Models\Advanceapproval_condition;
use App\Http\Requests\StoreAdvanceApprovalRuleRequest;
use App\Http\Requests\UpdateAdvanceApprovalRuleRequest;

class AdvanceApprovalRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans =Advance::all();
        $approvals = AdvanceApprovalRule::all();
        return view('settings.advanceApproval.approvalRule', compact('approvals','loans')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $loans =Advance::all();
        return view('settings.advanceApproval.approvalRule', compact( 'loans'));
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdvanceApprovalRuleRequest $request)
    {
        AdvanceApprovalRule::create($request->validated());
        //display the message 
        $notification = array(
            'message' => 'Advance Approval Added successfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(AdvanceApprovalRule $approvalRule)
    {
        // Retrieve the corresponding approval_rule record along with its related approval_conditions
        $approvalRuleRecord = AdvanceApprovalRule::with('approvalConditions')->find($approvalRule->id);
    
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
    
        return view('settings.advanceApproval.approvalShow', compact('approvalRule', 'approvalRuleRecord', 'specificConditions', 'formulas'));
    }
    
    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdvanceApprovalRule $approvalRule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * 
     */
    public function update(UpdateAdvanceApprovalRuleRequest $request, AdvanceApprovalRule $approvalRule)
    {
        $approvalRule->update($request->validated());
        //display the message 
        $notification = array(
            'message' => 'Advance Approval Updated successfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdvanceApprovalRule $approvalRule)
    {
        //
    }

    public function fetchTypes(Request $request, $for)
        {
            $selectedFor = $request->input('for');
            
            // Fetch types based on the selectedFor value
            if ($selectedFor === 'Loan') {
                $types = Advance::pluck('type')->toArray();
            } else {
                // Handle the default case
                $types = [];
            }
            

            return response()->json(['types' => $types]);
        }

}
