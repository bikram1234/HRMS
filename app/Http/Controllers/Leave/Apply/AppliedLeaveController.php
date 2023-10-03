<?php

namespace App\Http\Controllers\Leave\Apply;

use App\Http\Controllers\Controller;
use App\Models\applied_leave;
use App\Models\leavetype;
use App\Models\leave_rule;
use App\Models\leave_plan;
use App\Models\User;
use App\Http\Requests\Storeapplied_leaveRequest;
use App\Http\Requests\Updateapplied_leaveRequest;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Carbon;

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

      /**
     * Calculate the number of days based on leave type and date range.
     *
     * @param \Carbon\Carbon $startDate
     * @param \Carbon\Carbon $endDate
     * @param string $leaveType
     * @return float
     */
    private function calculateNumberOfDays($startDate, $endDate, $leaveType)
    {
        $numberOfDays = 0;

        while ($startDate->lte($endDate)) {
            // Skip weekends (Saturday and Sunday)
            if ($startDate->isWeekend()) {
                $startDate->addDay();
                continue;
            }

            switch ($leaveType) {
                case 'full_day':
                    $numberOfDays += 1;
                    break;
                case 'before_half':
                    $numberOfDays += 0.5;
                    break;
                case 'after_half':
                    $numberOfDays += 0.5;
                    break;
                case 'shift':
                    // Customize this logic for 'shift' leave type as needed
                    // For example, you might check specific hours for 'shift'
                    break;
                // Add more leave type cases as needed
            }

            $startDate->addDay();
        }

        return $numberOfDays;
    }
    

    /**
     * Check if the user has provided an attachment in the form.
     */
    private function checkUserAttachment($request)
    {
        // Check if 'file_path' exists in the request and is not empty.
        if ($request->hasFile('file_path') && $request->file('file_path')->isValid()) {
            return true; // Attachment is provided and valid.
        }
    
        return false; // No attachment provided or invalid attachment.
    }
    
    public function checkLeavePlan(
        $leavePlanId,
        $userId,
        $userGender,
        $userIsInProbation,
        $userIsInContract,
        $userIsRegular,
        $userIsInNotice,
        $request
    ) {
        // Retrieve the leave plan based on its ID
        $leavePlan = leave_plan::find($leavePlanId);
    
        if (!$leavePlan) {
            // Leave plan not found
            return false;
        }
    
        // Check if attachment is required
        if ($leavePlan->attachment_required) {
            // Check if the user has provided an attachment
            $userHasAttachment = $this->checkUserAttachment($request);
    
            if (!$userHasAttachment || !$request->hasFile('file_path')) {
                // Attachment is required but not provided or invalid
                return 'attachment_required';
            }
    
            // Validate the uploaded file
            $validatedData = $request->validate([
                'file_path' => 'required|file|max:4096', // Adjust validation rules as needed
            ]);
    
            $file = $request->file('file_path');
            $filePath = $file->store('uploads'); // Store the file in the 'uploads' directory
        }
    
        // Check gender restrictions
        if ($leavePlan->gender !== 'A' && $leavePlan->gender !== $userGender) {
            return false; // Gender restriction not met
        }
    
        // Check other employment conditions
        if (
            ($leavePlan->probation_period && !$userIsInProbation) ||
            ($leavePlan->contract_period && !$userIsInContract) ||
            ($leavePlan->regular_period && !$userIsRegular) ||
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
        // Retrieve the employment_type of the user from the users table
        $userEmploymentType = User::where('id', $userId)->value('employment_type');
    
        // Map the representation of employment types
        $userIsInProbation = $userEmploymentType === 'probation_period';
        $userIsInContract = $userEmploymentType === 'contract_period';
        $userIsRegular = $userEmploymentType === 'regular_period';
        $userIsInNotice = $userEmploymentType === 'notice_period';
    
        // Check if the user is eligible for the leave plan
        $isEligible = $this->checkLeavePlan(
            $leavePlanId,
            $userId,
            $userGender,
            $userIsInProbation,
            $userIsInContract,
            $userIsRegular,
            $userIsInNotice,
            $request
        );
    
                
        if ($isEligible === 'attachment_required') {
            return redirect()->back()->with('error', 'Attachment is required for this leave plan.');
        } elseif (!$isEligible) {
            return redirect()->back()->with('error', 'You are not eligible for this leave plan.');
        }
        $appliedLeave = new applied_leave();
        $appliedLeave->fill($request->validated()); // Fill the attributes from the validated data
    
        if ($request->hasFile('file_path')) {
            $appliedLeave->file_path = $request->file('file_path')->store('uploads'); // Set the 'file_path' attribute
        }
    
        // Save the applied_leave record to the database
        $appliedLeave->save();
    
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
        $leaveRule = leave_rule::where('leave_id', $leaveTypeId)
        ->where('grade_id', auth()->user()->grade_id)
        ->first();

        if (!$leaveRule) {
            return response()->json(['error' => 'Leave rule not found']);
        }

        $leaveDuration = $leaveRule->duration;

        // 3. Calculate the leave balance by subtracting the applied days from the leave duration
        $leaveBalance = $leaveDuration - $totalAppliedDays;

        return response()->json(['balance' => $leaveBalance]);
    }

    public function fetchIncludeWeekends($leaveTypeId)
    {
        // Fetch the leave type by ID
        $leavePlan = leave_plan::where('leave_id', $leaveTypeId)->first();

        if (!$leavePlan) {
            // Handle the case where the leave plan is not found
            return response()->json(['error' => 'Leave plan not found'], 404);
        }

        // Return the include_weekends setting as JSON
        return response()->json(['include_weekends' => $leavePlan->include_weekends]);
    }
}
