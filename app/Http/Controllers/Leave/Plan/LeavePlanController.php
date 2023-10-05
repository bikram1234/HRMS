<?php

namespace App\Http\Controllers\Leave\Plan;

use App\Http\Controllers\Controller;
use App\Models\leave_plan;
use App\Models\leave_rule;
use App\Models\grade;
use App\Http\Requests\Storeleave_planRequest;
use App\Http\Requests\Updateleave_planRequest;

class LeavePlanController extends Controller
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
    public function create($leave_id)
    {
        $leaveRules = leave_rule::all();
        $grades = grade::all();
        return view('leave.plan.leavePlanAdd', compact('leave_id', 'grades', 'leaveRules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storeleave_planRequest $request)
    {
        $data = $request->validated();
        $leave_id = $data['leave_id'];
    
        // Convert checkbox fields to boolean values
        $checkboxFields = [
            'attachment_required', 'include_public_holidays',
            'include_weekends', 'can_be_clubbed_with_el', 'can_be_clubbed_with_cl',
            'can_be_half_day', 'probation_period', 'regular_period',
            'contract_period', 'notice_period',
        ];
        
        foreach ($checkboxFields as $field) {
            $data[$field] = $request->has($field) ? 1 : 0;
        }
    
        leave_plan::create($data);
         //display the message 
         $notification = array(
            'message' => 'Leave Plan Added successfully',
            'alert-type' =>'success'
        );
        return redirect()->route('yearendprocessing.create', ['leave_id' => $leave_id])->with($notification);

    }

    /**
     * Display the specified resource.
     */
    public function show(leave_plan $leave_plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(leave_plan $leave_plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateleave_planRequest $request, leave_plan $leave_plan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(leave_plan $leave_plan)
    {
        //
    }
}
