<?php

namespace App\Http\Controllers\Leave\Apply;

use App\Http\Controllers\Controller;
use App\Models\applied_leave;
use App\Models\leavetype;
use App\Models\leave_rule;
use App\Models\leave_plan;
use App\Http\Requests\Storeapplied_leaveRequest;
use App\Http\Requests\Updateapplied_leaveRequest;

class AppliedLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leave_types = leavetype::all();
        $leaveHistory = applied_leave::all();
        return view('leave.apply.leaveHistory', compact('leaveHistory', 'leave_types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $leave_types = leavetype::all();
        return view('leave.apply.applyLeave', compact('leave_types'));
    }

    public function checkLeavePlan($leavePlanId, $userId, $userGender, $isPublicHoliday, $isWeekend, $userIsInProbation, $userIsRegular, $userIsInContract, $userIsInNotice)
    {
        // Retrieve the leave plan based on its ID
        $leavePlan = LeavePlan::find($leavePlanId);
    
        if (!$leavePlan) {
            // Leave plan not found
            return false;
        }
    
        // Check if attachment is required
        if ($leavePlan->attachment_required) {
            // Check if the user has provided an attachment
            $userHasAttachment = $this->checkUserAttachment($userId); // Implement this function
    
            if (!$userHasAttachment) {
                return false; // Attachment is required but not provided
            }
        }
    
        // Check gender restrictions
        if ($leavePlan->gender !== 'All' && $leavePlan->gender !== $userGender) {
            return false; // Gender restriction not met
        }
    
        // Check public holidays
        if (!$leavePlan->include_public_holidays && $isPublicHoliday) {
            return false; // Public holidays are not allowed
        }
    
        // Check weekends
        if (!$leavePlan->include_weekends && $isWeekend) {
            return false; // Weekends are not allowed
        }
    
        // Check availability in various periods
        if (
            ($leavePlan->probation_period && !$userIsInProbation) ||
            ($leavePlan->regular_period && !$userIsRegular) ||
            ($leavePlan->contract_period && !$userIsInContract) ||
            ($leavePlan->notice_period && !$userIsInNotice)
        ) {
            return false; // User does not meet availability conditions
        }
    
        // All conditions met, user can apply for this leave plan
        return true;
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storeapplied_leaveRequest $request)
    {
        // Get the user's ID (assuming the user is authenticated)
        $userId = auth()->user()->id;

        // Extract the leave_plan_id from the request
        $leave_id = $request->input('leave_id');
        $userGender = $request->input('gender');
        $leavePlanId = leave_plan::where('leave_id', $leave_id)->value('id');

        // Check if the user is eligible for the leave plan
        $isEligible = $this->checkLeavePlan( $leavePlanId,
        $userId,
        $userGender,
        $isPublicHoliday,
        $isWeekend,
        $userIsInProbation,
        $userIsRegular,
        $userIsInContract,
        $userIsInNotice);

        if (!$isEligible) {
            return redirect()->back()->with('error', 'You are not eligible for this leave plan.');
        }

        // Proceed to store the applied_leave data
        applied_leave::create($request->validated());

        return redirect()->back()->with('success', 'Leave Applied successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(applied_leave $applied_leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(applied_leave $applied_leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateapplied_leaveRequest $request, applied_leave $applied_leave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(applied_leave $applied_leave)
    {
        //
    }

    public function fetchLeaveBalance($leaveTypeId)
    {
        $userId = auth()->user()->id;

        $totalAppliedDays = applied_leave::where('user_id', $userId)
        ->where('leave_id', $leaveTypeId)
        ->sum('number_of_days');

        // 2. Find the leave duration from the leave_rules table for the specified leave type
        $leaveRule = leave_rule::where('leave_id', $leaveTypeId)->first();

        if (!$leaveRule) {
            return response()->json(['error' => 'Leave rule not found']);
        }

        $leaveDuration = $leaveRule->duration;

        // 3. Calculate the leave balance by subtracting the applied days from the leave duration
        $leaveBalance = $leaveDuration - $totalAppliedDays;

        return response()->json(['balance' => $leaveBalance]);
    }

}


