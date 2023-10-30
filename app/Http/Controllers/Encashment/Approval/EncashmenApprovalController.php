<?php

namespace App\Http\Controllers\Encashment\Approval;

use App\Http\Controllers\Controller;
use App\Models\EncashmenApproval;
use App\Models\appliedEncashment;
use App\Models\leaveEncashmentApprovalRule;
use App\Models\leaveEncashmentApprovalCondition;
use App\Models\level;
use App\Models\User;
use App\Models\Designation;
use App\Models\leaveBalance;
use App\Http\Requests\StoreEncashmenApprovalRequest;
use App\Http\Requests\UpdateEncashmenApprovalRequest;
use Illuminate\Http\Request;
use App\Mail\LeaveApprovedMail;
use App\Mail\encashmentApplicationMail;
use Illuminate\Support\Facades\Mail;

class EncashmenApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {

        $this->middleware('auth');
        $leaveEncashmentApprovalCondition = leaveEncashmentApprovalCondition::first();

        $designationId = auth()->user()->designation_id;
        $designationName = Designation::where('id', $designationId)->value('name');
        if($leaveEncashmentApprovalCondition->approval_type == "Single User"){
            $currentUserID = auth()->user();
   
            if($currentUserID->id == $leaveEncashmentApprovalCondition->employee_id){
                $appliedencashments = appliedEncashment::all();
                return view('leave.approval.encashmentApproval', compact('appliedencashments')); 
            }
            
        }else{
            if($designationName == 'Section Head'){
                $sectionHeadId = auth()->user()->section_id;
    
                // Query leave applications for the section head's section
                $encashmentApplications = Applied_Leave::whereHas('user.section', function ($query) use ($sectionHeadId) {
                    $query->where('id', $sectionHeadId);
                })->where('level1', 'pending')->get();
    
            } else if($designationName == "Department Head"){
                $DepartmentHeadId = auth()->user()->department_id;
    
                // Query leave applications for the section head's section
                $AppliedApplications = Applied_Leave::whereHas('user.department', function ($query) use ($DepartmentHeadId) {
                    $query->where('id', $DepartmentHeadId);
                })->get();
    
                $encashmentApplications = $AppliedApplications->filter(function ($encashmentApplication) {
                    return $encashmentApplication->level1 === 'approved' && $encashmentApplication->status === 'pending';
                });
        
    
            } else if ($designationName == "Management") {
    
                $encashmentApplications = Applied_Leave::where('level3', 'pending')
                ->where('status', 'pending')
                ->get();

            };
              
            return view('leave.approval.leaveApproval', compact('encashmentApplications'));
           
        }
       
   

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
    public function store(StoreEncashmenApprovalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EncashmenApproval $encashmenApproval)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EncashmenApproval $encashmenApproval)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEncashmenApprovalRequest $request, EncashmenApproval $encashmenApproval)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EncashmenApproval $encashmenApproval)
    {
        //
    }

    public function approveEncashment(Request $request, $id)
    {
        // Find the leave application by ID
        $encashmentApplication = appliedEncashment::findOrFail($id);
        $userID = $encashmentApplication->user_id;
        $user = User::where('id', $userID)->first();
        $Approvalrecipient = $user->email;
        $leaveBalance = leaveBalance::where('user_id', $userID)->first();
        $earnedleaveBalance = $leaveBalance->earned_leave_balance;
        $appliedEncashmentDays = $encashmentApplication->number_of_days;
        $newEarnedLeaveBalance = $leaveBalance->earned_leave_balance - $appliedEncashmentDays;

        $leaveBalance->update([
            'earned_leave_balance' => $newEarnedLeaveBalance,
        ]);
        
        $approvalType = leaveEncashmentApprovalCondition::first();
        $hierarchy_id = $approvalType->hierarchy_id;

        $departmentId = $user->department_id;
        $departmentHead = User::where('department_id', $departmentId)
        ->whereHas('designation', function ($query) {
            $query->where('name', 'Department Head');
        })
        ->first();

        if($approvalType->approval_type == 'Single User'){
            $encashmentApplication->update([
                'status' => 'approved',
            ]);


            $content = "The Encashment you have applied for has been approved.";
        
            Mail::to($Approvalrecipient)->send(new LeaveApprovedMail($user, $content));
        
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Leave application approved successfully.');
        }else{
            if ($encashmentApplication->level1 === 'pending' && $approvalType->MaxLevel === 'Level1') {
                // Update the leave application fields
                $encashmentApplication->update([
                    'level1' => 'approved',
                    'status' => 'approved',
                ]);
    
                $this->fetchCasualLeaveBalance($leave_id,  $userID);
    
                $content = "The leave you have applied for has been approved.";
            
                Mail::to($Approvalrecipient)->send(new LeaveApprovedMail($user, $content));
            
                // Redirect back with a success message
                return redirect()->back()->with('success', 'Leave application approved successfully.');
            
            } else if (
                $encashmentApplication->level1 === 'pending' &&
                $encashmentApplication->level2 === 'pending' &&
                ($approvalType->MaxLevel === 'Level2' || $approvalType->MaxLevel === 'Level3')
            ) { 
                $encashmentApplication->update([
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
    
                    Mail::to($recipient)->send(new encashmentApplicationMail($approval, $currentUser));
                    return redirect()->back()->with('success', 'Leave application approved successfully.');
                }
    
            } else if($encashmentApplication->level1==='approved' && $approvalType->MaxLevel === 'Level2') {
                $encashmentApplication->update([
                    'level2' => 'approved',
                    'status' => 'approved',
                ]);
    
                $content = "The leave you have applied for has been approved.";
                Mail::to($Approvalrecipient)->send(new LeaveApprovedMail($user, $content));
            
                // Redirect back with a success message
                return redirect()->back()->with('success', 'Leave application approved successfully.');
            } else if($encashmentApplication->level1==='approved' &&$encashmentApplication->level2==='pending' && $approvalType->MaxLevel === 'Level3') {
                $encashmentApplication->update([
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
    
                    Mail::to($recipient)->send(new encashmentApplicationMail($approval, $currentUser));
                    return redirect()->back()->with('success', 'Leave application approved successfully.');
                }
            } else if($encashmentApplication->level1==='approved' &&$encashmentApplication->level2==='approved' && $approvalType->MaxLevel === 'Level3') {
                $encashmentApplication->update([
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

       
    }

    public function declineEncashment(Request $request, $id) 
    {
        // Find the leave application by ID
        $encashmentApplication = appliedEncashment  ::findOrFail($id);
        $userID = $encashmentApplication->user_id;
        $user = User::where('id', $userID)->first();
        $Approvalrecipient = $user->email;
        $approvalType = leaveEncashmentApprovalCondition::first();

        $remark = $request->input('remark');


        if($approvalType->approval_type == 'Single User'){
            $encashmentApplication->update([
                'status' => 'declined',
                'remark' => $remark,
            ]);
        }else{

            if ($encashmentApplication->level1 === 'pending' && $encashmentApplication->level2 === 'pending' && $encashmentApplication->level3 === 'pending') {
                // All levels are approved, so update the status to 'declined' and reset level1, level2, and level3.
                $encashmentApplication->update([
                    'status' => 'declined',
                    'level1' => 'declined',
                ]);
            } elseif ($encashmentApplication->level1 === 'approved' && $encashmentApplication->level2 === 'pending' && $encashmentApplication->level3 === 'pending') {
                // Level1 is approved, update level2 to 'declined' and reset level3.
                $encashmentApplication->update([
                    'status' => 'declined',
                    'level2' => 'declined',
                ]);
            } elseif ($encashmentApplication->level1 === 'approved' && $encashmentApplication->level2 === 'approved' && $encashmentApplication->level3 === 'pending') {
                // Level1 is pending, update level1 to 'declined' and reset level2 and level3.
                $encashmentApplication->update([
                    'status' => 'declined',
                    'level3' => 'declined',
                ]);
            } else {
                // If status is not approved, no further updates needed.
            }
        }

        
        $content = "The Encashment you applied for is Declined.";
    
        Mail::to($Approvalrecipient)->send(new LeaveApprovedMail($user, $content));
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Leave application Declined successfully.');

    }
}
