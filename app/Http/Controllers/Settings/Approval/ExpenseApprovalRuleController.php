<?php

namespace App\Http\Controllers\Settings\Approval;

use App\Http\Controllers\Controller;
use App\Models\ExpenseApprovalRule;
use App\Models\Formula;
use Illuminate\Http\Request;
use App\Models\ExpenseType;
use App\Models\leavetype;
use App\Http\Requests\StoreExpenseApprovalRuleRequest;
use App\Http\Requests\UpdateExpenseApprovalRuleRequest;

class ExpenseApprovalRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = ExpenseType::all();
        $approvals = ExpenseApprovalRule::all();
        return view('settings.expenseApproval.approvalRule', compact('approvals','expenses')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $expenses = ExpenseType::all();
        $loans = [ ];
        return view('settings.expenseApproval.approvalRule', compact('leavetypes', 'expenses', 'loans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseApprovalRuleRequest $request)
    {
        ExpenseApprovalRule::create($request->validated());
        //display the message 
        $notification = array(
            'message' => 'Expense Approval Added successfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseApprovalRule $approvalRule)
    {
        // Retrieve the corresponding approval_rule record along with its related approval_conditions
        $approvalRuleRecord = ExpenseApprovalRule::with('approvalConditions')->find($approvalRule->id);
    
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
    
        return view('settings.expenseApproval.approvalShow', compact('approvalRule', 'approvalRuleRecord', 'specificConditions', 'formulas'));
    }
    
    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExpenseApprovalRule $approvalRule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * 
     */
    public function update(UpdateExpenseApprovalRuleRequest $request, ExpenseApprovalRule $approvalRule)
    {
        $approvalRule->update($request->validated());
        //display the message 
        $notification = array(
            'message' => 'Expense approval updated successfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseApprovalRule $approvalRule)
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
