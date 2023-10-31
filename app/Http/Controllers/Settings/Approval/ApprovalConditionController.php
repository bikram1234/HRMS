<?php

namespace App\Http\Controllers\Settings\Approval;

use App\Http\Controllers\Controller;
use App\Models\approval_condition;
use App\Models\hierarchy;
use App\Models\User;
use App\Models\Formula;
use App\Http\Requests\Storeapproval_conditionRequest;
use App\Http\Requests\Updateapproval_conditionRequest;
use Illuminate\Http\Request;

class ApprovalConditionController extends Controller
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
        return view('settings.approval.conditionAdd', compact('approval_rule_id', 'hierarchies', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storeapproval_conditionRequest $request)
    {
        $approval_condition = $request->input('approval_rule_id');
        approval_condition::create($request->validated());
        //display the message 
        $notification = array(
            'message' => 'Approval Condition Added successfully',
            'alert-type' =>'success'
        );
        return redirect()->route('approval.show', ['approvalRule'=>$approval_condition])->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(approval_condition $approval_condition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(approval_condition $approval_condition)
    {
        $hierarchies = hierarchy::all();
        $users = User::all();
        $condtion_id = $approval_condition->id;
        $formula = Formula::where('condition_id', $condtion_id)->get();
        return view('settings.approval.conditionEdit', compact('approval_condition', 'formula', 'hierarchies', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateapproval_conditionRequest $request, approval_condition $approval_condition)
    {
        $approval_condition->update($request->validated());
         //display the message 
         $notification = array(
            'message' => 'Condition Updated successfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with('success', 'Condition Updated successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(approval_condition $approval_condition)
    {
        //
    }
}
