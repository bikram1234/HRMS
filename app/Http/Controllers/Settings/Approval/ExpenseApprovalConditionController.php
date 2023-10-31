<?php

namespace App\Http\Controllers\Settings\Approval;

use App\Http\Controllers\Controller;
use App\Models\Expenseapproval_condition;
use App\Models\ExpenseApprovalRule;
use App\Models\hierarchy;
use App\Models\User;
use App\Models\Formula;
use App\Http\Requests\StoreExpenseapproval_conditionRequest;
use App\Http\Requests\UpdateExpenseapproval_conditionRequest;
use Illuminate\Http\Request;

class ExpenseApprovalConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create( $approval_rule_id)
    {
        $hierarchies = hierarchy::all();
        $users = User::all();
        // Use $approvalRuleId to fetch the relevant approval conditions
        return view('settings.expenseApproval.conditionAdd', compact('approval_rule_id', 'hierarchies', 'users'));
    }

    public function store(StoreExpenseapproval_conditionRequest $request)
{
    $newApprovalCondition = Expenseapproval_condition::create($request->validated());
    //display the message 
    $notification = array(
        'message' => 'Approval added successfully.',
        'alert-type' =>'success'
    );

    return redirect()->route('expense-approvalrule.index', ['approval_condition' => $newApprovalCondition])->with($notification);
}

    

    /**
     * Display the specified resource.
     */
    public function show(Expenseapproval_condition $approval_condition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expenseapproval_condition $approval_condition)
    {
        $hierarchies = hierarchy::all();
        $users = User::all();
        $condtion_id = $approval_condition->id;
        $formula = Formula::where('condition_id', $condtion_id)->get();
        return view('settings.expenseApproval.conditionEdit', compact('approval_condition', 'formula', 'hierarchies', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseapproval_conditionRequest $request, Expenseapproval_condition $approval_condition)
    {
        $approval_condition->update($request->validated());
         //display the message 
    $notification = array(
        'message' => 'Condition Updated successfully!!',
        'alert-type' =>'success'
    );
        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(approval_condition $approval_condition)
    {
        //
    }
}
