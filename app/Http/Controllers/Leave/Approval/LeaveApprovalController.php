<?php

namespace App\Http\Controllers\Leave\Approval;

use App\Http\Controllers\Controller;
use App\Models\applied_leave;
use App\Models\approvalRule;
use App\Models\approval_condition;
use App\Models\level;
use App\Models\User;
use App\Models\Designation;
use App\Models\LeaveBalance;
use App\Models\leave_rule;
use App\Http\Requests\StoreleaveApprovalRequest;
use App\Http\Requests\UpdateleaveApprovalRequest;
use Illuminate\Http\Request;
use App\Mail\LeaveApprovedMail;
use App\Mail\LeaveApplicationMail;
use Illuminate\Support\Facades\Mail;

class LeaveApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designationId = auth()->user()->designation_id;
        $designationName = Designation::where('id', $designationId)->value('name');
        if($designationName == 'Section Head'){
            $sectionHeadId = auth()->user()->section_id;

            // Query leave applications for the section head's section
            $leaveApplications = Applied_Leave::whereHas('user.section', function ($query) use ($sectionHeadId) {
                $query->where('id', $sectionHeadId);
            })->where('level1', 'pending')->get();
    
    
            return view('leave.approval.leaveApproval', compact('leaveApplications'));
        } else if($designationName == "Department Head"){
            $DepartmentHeadId = auth()->user()->department_id;

            // Query leave applications for the section head's section
            $AppliedApplications = Applied_Leave::whereHas('user.department', function ($query) use ($DepartmentHeadId) {
                $query->where('id', $DepartmentHeadId);
            })->get();

            $leaveApplications = $AppliedApplications->filter(function ($leaveApplication) {
                return $leaveApplication->level1 === 'approved' && $leaveApplication->status === 'pending';
            });
    
            return view('leave.approval.leaveApproval', compact('leaveApplications'));

        } else if ($designationName == "Management") {

            $leaveApplications = Applied_Leave::where('level3', 'pending')
            ->where('status', 'pending')
            ->get();

            return view('leave.approval.leaveApproval', compact('leaveApplications')); 
        } ;
       

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
    public function store(StoreleaveApprovalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(leaveApproval $leaveApproval)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(leaveApproval $leaveApproval)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateleaveApprovalRequest $request, leaveApproval $leaveApproval)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(leaveApproval $leaveApproval)
    {
        //
    }

    public function approveLeave(Request $request, $id)
    {
        // Find the leave application by ID
        $leaveApplication = applied_leave::findOrFail($id);
        $leave_id = $leaveApplication->leave_id;
        $userID = $leaveApplication->user_id;
        $user = User::where('id', $userID)->first();
        $Approvalrecipient = $user->email;

        $approvalRuleId = approvalRule::where('type_id', $leave_id)->value('id');
        $approvalType = approval_condition::where('approval_rule_id', $approvalRuleId)->first();
        $hierarchy_id = $approvalType->hierarchy_id;

        $departmentId = $user->department_id;
        $departmentHead = User::where('department_id', $departmentId)
        ->whereHas('designation', function ($query) {
            $query->where('name', 'Department Head');
        })
        ->first();

        if ($leaveApplication->level1 === 'pending' && $approvalType->MaxLevel === 'Level1') {
            // Update the leave application fields
            $leaveApplication->update([
                'level1' => 'approved',
                'status' => 'approved',
            ]);

            $this->fetchCasualLeaveBalance($leave_id,  $userID);

            $content = "The leave you have applied for has been approved.";
        
            Mail::to($Approvalrecipient)->send(new LeaveApprovedMail($user, $content));
        
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Leave application approved successfully.');
        
        } else if (
            $leaveApplication->level1 === 'pending' &&
            $leaveApplication->level2 === 'pending' &&
            ($approvalType->MaxLevel === 'Level2' || $approvalType->MaxLevel === 'Level3')
        ) { 
            $leaveApplication->update([
                'level1' => 'approved'
            ]);
            $levelRecord = Level::where('hierarchy_id', $hierarchy_id)
            ->where('level', 2)
            ->first();

            if ($levelRecord) {
                // Access the 'value' field from the level record
                $levelValue = $levelRecord->value;

                // Determine the recipient based on the levelValue
                $recipient = '';

                // Check the levelValue and set the recipient accordingly
                if ($levelValue === "DH") {
                    // Set the recipient to the section head's email address or user ID
                    $recipient = $departmentHead->email; // Replace with the actual field name
                }
                $approval = $departmentHead;
                $currentUser = $user;

                Mail::to($recipient)->send(new LeaveApplicationMail($approval, $currentUser));
                return redirect()->back()->with('success', 'Leave application approved successfully.');
            }

        } else if($leaveApplication->level1==='approved' && $approvalType->MaxLevel === 'Level2') {
            $leaveApplication->update([
                'level2' => 'approved',
                'status' => 'approved',
            ]);

            $content = "The leave you have applied for has been approved.";
            Mail::to($Approvalrecipient)->send(new LeaveApprovedMail($user, $content));
        
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Leave application approved successfully.');
        } else if($leaveApplication->level1==='approved' &&$leaveApplication->level2==='pending' && $approvalType->MaxLevel === 'Level3') {
            $leaveApplication->update([
                'level2' => 'approved'
            ]);
            $levelRecord = Level::where('hierarchy_id', $hierarchy_id)
            ->where('level', 3)
            ->first();

            if ($levelRecord) {
                // Access the 'value' field from the level record
                $levelValue = $levelRecord->value;
                $userID = $levelRecord->employee_id;
                $approval = User::where('id', $userID)->first();
                // Determine the recipient based on the levelValue
                $recipient = $approval->email;

                // Check the levelValue and set the recipient accordingly
                if ($levelValue === "IS") {
                    // Set the recipient to the section head's email address or user ID
                     // Replace with the actual field name
                }
  
                $currentUser = $user;

                Mail::to($recipient)->send(new LeaveApplicationMail($approval, $currentUser));
                return redirect()->back()->with('success', 'Leave application approved successfully.');
            }
        } else if($leaveApplication->level1==='approved' &&$leaveApplication->level2==='approved' && $approvalType->MaxLevel === 'Level3') {
            $leaveApplication->update([
                'level3' => 'approved',
                'status' => 'approved',
            ]);
            $content = "The leave you have applied for has been approved.";
            Mail::to($Approvalrecipient)->send(new LeaveApprovedMail($user, $content));
        
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Leave application approved successfully.');
        } else {
            // Handle cases where the leave application cannot be approved (e.g., it's not at the expected level or already approved)
            return redirect()->back()->with('error', 'Leave application cannot be approved.');
        }
    }

    public function declineLeave(Request $requeset, $id) 
    {
        // Find the leave application by ID
        $leaveApplication = applied_leave::findOrFail($id);
        $leave_id = $leaveApplication->leave_id;
        $userID = $leaveApplication->user_id;
        $user = User::where('id', $userID)->first();
        $Approvalrecipient = $user->email;

        $leaveApplication->update([
            'status' => 'declined',
        ]);

        if ($leaveApplication->level1 === 'pending' && $leaveApplication->level2 === 'pending' && $leaveApplication->level3 === 'pending') {
            // All levels are approved, so update the status to 'declined' and reset level1, level2, and level3.
            $leaveApplication->update([
                'status' => 'declined',
                'level1' => 'declined',
            ]);
        } elseif ($leaveApplication->level1 === 'approved' && $leaveApplication->level2 === 'pending' && $leaveApplication->level3 === 'pending') {
            // Level1 is approved, update level2 to 'declined' and reset level3.
            $leaveApplication->update([
                'status' => 'declined',
                'level2' => 'declined',
            ]);
        } elseif ($leaveApplication->level1 === 'approved' && $leaveApplication->level2 === 'approved' && $leaveApplication->level3 === 'pending') {
            // Level1 is pending, update level1 to 'declined' and reset level2 and level3.
            $leaveApplication->update([
                'status' => 'declined',
                'level3' => 'declined',
            ]);
        } else {
            // If status is not approved, no further updates needed.
        }
        
        $content = "The leave you applied for is Declined.";
    
        Mail::to($Approvalrecipient)->send(new LeaveApprovedMail($user, $content));
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Leave application approved successfully.');

    }

    public function cancelLeave(Request $requeset, $id)
    {
        $leaveApplication = applied_leave::findOrFail($id);
        $leave_id = $leaveApplication->leave_id;
        $userID = $leaveApplication->user_id;

        $leaveApplication->update([
            'status' => 'cancelled',
        ]);
        return redirect()->back()->with('success', 'Leave application cancelled successfully.');
    }

    private function fetchCasualLeaveBalance($leave_id,  $userID)
    {
        $user = User::where('id', $userID)->first();
        $totalAppliedDays = applied_leave::where('user_id', $userID)
        ->where('leave_id', $leave_id)
        ->where('status', 'approved')
        ->sum('number_of_days');

        // 2. Find the leave duration from the leave_rules table for the specified leave type
        $leaveRule = leave_rule::where('leave_id', $leave_id)
        ->where('grade_id', $user->grade_id)
        ->first();

        if (!$leaveRule) {
            return redirect()->back()->with('error', 'Leave rule not found');
        }

        $leaveDuration = $leaveRule->duration;

        // 3. Calculate the leave balance by subtracting the applied days from the leave duration
        $leaveBalanceNow = $leaveDuration - $totalAppliedDays;

        $leaveBalanceRecord = LeaveBalance::where('user_id', $userID)
        ->first();

        if ($leaveBalanceRecord) {
            // Update the existing leave balance record
            $leaveBalanceRecord->casual_leave_balance = $leaveBalanceNow;
            $leaveBalanceRecord->save();
        } else {
            // Create a new leave balance record if it doesn't exist
            LeaveBalance::create([
                'user_id' => $userID, 
                'casual_leave_balance' => $leaveBalanceNow,
            ]);
        }
    }
    
}
