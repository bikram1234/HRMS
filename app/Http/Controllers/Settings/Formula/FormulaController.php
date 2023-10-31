<?php

namespace App\Http\Controllers\Settings\Formula;

use App\Http\Controllers\Controller;
use App\Models\formula;
use App\Models\User;
use App\Http\Requests\StoreformulaRequest;
use App\Http\Requests\UpdateformulaRequest;

class FormulaController extends Controller
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

    public function createForApprovalCondition($approvalConditionId)
    {
        $users = User::all();
        $formulas = Formula::where('condition_id', $approvalConditionId)->get();
        // Logic for creating a formula for the given approval condition
        
        return view('settings.approval.formula.formulaAdd', compact('approvalConditionId', 'formulas', 'users'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreformulaRequest $request)
    {
        formula::create($request->validated());
         //display the message 
         $notification = array(
            'message' => 'Formula Added successfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(formula $formula)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(formula $formula)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateformulaRequest $request, formula $formula)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(formula $formula)
    {
        $formula->delete();
         //display the message 
         $notification = array(
            'message' => 'Formula Deleted successfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);
    }
}
