<?php

namespace App\Http\Controllers\Advance\advance_approval;
use App\Http\Controllers\Controller; // Import the Controller class


use App\Models\Advance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\SalaryAdvance;
use App\Models\DsaAdvance;
use App\Models\Designation;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveApprovedMail;
use App\Mail\ExpenseApprovedMail;
use App\Mail\LeaveApplicationMail;
use App\Mail\ExpenseApplicationMail;
use App\Models\AdvanceApplication;
use App\Models\AdvanceApprovalRule;
use App\Models\Advanceapproval_condition;
use App\Models\level;





class advance_approval_Controller extends Controller
{
//     public function advance_approval_show(Request $request)
// {
//     $designationId = auth()->user()->designation_id;
//     $designationName = Designation::where('id', $designationId)->value('name');
//     $query = DsaAdvance::query();
        
//     if ($designationName == 'Section Head') {
//         $sectionHeadId = auth()->user()->section_id;
//         $query->whereHas('user.section', function ($query) use ($sectionHeadId) {
//             $query->where('id', $sectionHeadId);
//         });
//     } else if ($designationName == "Department Head") {
//         $departmentHeadId = auth()->user()->department_id;
//         $query->whereHas('user.department', function ($query) use ($departmentHeadId) {
//             $query->where('id', $departmentHeadId);
//         })->where('level1', 'approved')->where('status', 'pending');
//     } else if ($designationName == "Management") {
//         $query->where(function ($query) {
//             $query->where('level3', 'pending')->where('status', 'pending');
//         });
//     }
    
//     $status = $request->input('status');
//     if ($status) {
//         $query->where('status', $status);
//     } else {
//         $query->whereIn('status', ['pending', 'approved']);
//     }
    
//     // Fetch SalaryAdvance records matching the status filter
//     $salaryAdvances = SalaryAdvance::with('advanceType')->where('status', $status)->get();
    
//     // Fetch DsaAdvance records matching the status filter
//     $dsaAdvances = DsaAdvance::with('advanceType')->where('status', $status)->get();
    
//     // Combine SalaryAdvance and DsaAdvance records into a single collection
//     $advances = $query->get()->concat($salaryAdvances)->concat($dsaAdvances);
    

//     return view('Advance.advance_approval.advance_approval_show', compact('advances'));
// }




// public function advance_approval_show(Request $request)
// {
//     $designationId = auth()->user()->designation_id;
//     $designationName = Designation::where('id', $designationId)->value('name');
//     $dsaQuery = DsaAdvance::query();
//     $salaryQuery = SalaryAdvance::query();

//     if ($designationName == 'Section Head') {
//         $sectionHeadId = auth()->user()->section_id;
//         $dsaQuery->whereHas('user.section', function ($query) use ($sectionHeadId) {
//             $query->where('id', $sectionHeadId);
//         })->where('level1', 'pending')->where('status', 'pending');
//         $salaryQuery->whereHas('user.section', function ($query) use ($sectionHeadId) {
//             $query->where('id', $sectionHeadId);
//         })->where('level1', 'pending')->where('status', 'pending');
//     } else if ($designationName == "Department Head") {
//         $departmentHeadId = auth()->user()->department_id;
//         $dsaQuery->whereHas('user.department', function ($query) use ($departmentHeadId) {
//             $query->where('id', $departmentHeadId);
//         })->where('level1', 'approved')->where('status', 'pending');
//         $salaryQuery->whereHas('user.department', function ($query) use ($departmentHeadId) {
//             $query->where('id', $departmentHeadId);
//         })->where('level1', 'approved')->where('status', 'pending');
//     } else if ($designationName == "Management") {
//         $dsaQuery->where(function ($query) {
//             $query->where('level2', 'approved')->where('status', 'pending');    
//         });
//         $salaryQuery->where(function ($query) {
//             $query->where('level2', '')->where('status', '');
//             });

//     } else if ($designationName == "Human Resource") {
//         $dsaQuery->where(function ($query) {
//             $query->where('level2', '')->where('status', '');    
//         });
//         $salaryQuery->where(function ($query) {
//             $query->where('level2', 'approved')->where('status', 'pending');
//             });
//     }
//     $status = $request->input('status');
//     if ($status) {
//         $dsaQuery->where('status', $status);
//         $salaryQuery->where('status', $status);
//     } else {
//         $dsaQuery->whereIn('status', ['pending', 'approved']);
//         $salaryQuery->whereIn('status', ['pending', 'approved']);
//     }

//     $dsaAdvances = $dsaQuery->with('advanceType')->get();
//     $salaryAdvances = $salaryQuery->with('advanceType')->get();

//     // Combine SalaryAdvance and DsaAdvance records into a single collection
//     $advances = $dsaAdvances->concat($salaryAdvances);

//     return view('Advance.advance_approval.advance_approval_show', compact('advances'));
// }

public function advance_approval_show(Request $request){
    $designationId = auth()->user()->designation_id;
    $designationName = Designation::where('id', $designationId)->value('name');
    $query = AdvanceApplication::with('advanceType');

    if ($designationName == 'Section Head') {
        $sectionHeadId = auth()->user()->section_id;
        $query->whereHas('user.section', function ($query) use ($sectionHeadId) {
            $query->where('id', $sectionHeadId);
        })->where('level1', 'pending')->where('status', 'pending');

        
    } else if ($designationName == "Department Head") {
        $DepartmentHeadId = auth()->user()->department_id;
        $query->whereHas('user.department', function ($query) use ($DepartmentHeadId) {
            $query->where('id', $DepartmentHeadId);
        })->where('level1', 'approved')->where('status', 'pending');
    } else if ($designationName == "Management") {
        $query->where('level3', 'pending')->where('level2', 'Approved')->where('status', 'pending');
    }

    $status = $request->input('status');
    if ($status) {
        $query->where('status', $status);
    } else {
        $query->whereIn('status', ['pending', 'approved']);
    }

    $advanceApplications = $query->get();

     return view('Advance.advance_approval.advance_approval_show', compact('advanceApplications'));

}

public function Advance_details ($id){
    $advance = AdvanceApplication::findOrFail($id); // Assuming Expense is the model for your expenses

    return view('Advance.advance_approval.details', compact('advance'));
}



public function approveadvance(Request $request, $id){
    // Find the leave application by ID
    $advanceApplications = AdvanceApplication::findOrFail($id);
    //$expenseApplications = SalaryAdvance::findOrFail($id);

    $expense_id = $advanceApplications->advance_type_id;
    $userID = $advanceApplications->user_id;
    $user = User::where('id', $userID)->first();
    $Approvalrecipient = $user->email;

    $approvalRuleId = AdvanceApprovalRule::where('type_id', $expense_id)->value('id');
    $approvalType = Advanceapproval_condition::where('approval_rule_id', $approvalRuleId)->first();
    $hierarchy_id = $approvalType->hierarchy_id;

    $departmentId = $user->department_id;
    $departmentHead = User::where('department_id', $departmentId)
    ->whereHas('designation', function ($query) {
        $query->where('name', 'Department Head');
    })
    ->first();

    if ($advanceApplications ->level1 === 'pending' && $approvalType->MaxLevel === 'Level1') {
        // Update the leave application fields
        $advanceApplications->update([
            'level1' => 'approved',
            'status' => 'approved',
        ]);
    
        Mail::to($Approvalrecipient)->send(new ExpenseApprovedMail($user));
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Expense application approved successfully.');
    
    } else if (
        $advanceApplications->level1 === 'pending' &&
        $advanceApplications->level2 === 'pending' &&
        ($approvalType->MaxLevel === 'Level2' || $approvalType->MaxLevel === 'Level3')
    ) { 
        $advanceApplications->update([
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

            Mail::to($recipient)->send(new ExpenseApplicationMail($approval, $currentUser));
            return redirect()->back()->with('success', 'Expense application approved successfully.');
        }

    }else if($advanceApplications->level1==='approved' && $approvalType->MaxLevel === 'Level2') {
        $advanceApplications->update([
            'level2' => 'approved',
            'status' => 'approved',
        ]);
        Mail::to($Approvalrecipient)->send(new LeaveApprovedMail($user));
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Expense application approved successfully.');
    } else if($advanceApplications->level1==='approved' &&$advanceApplications->level2==='pending' && $approvalType->MaxLevel === 'Level3') {
        $advanceApplications->update([
            'level2' => 'approved'
        ]);
        $expenseRecord = Level::where('hierarchy_id', $hierarchy_id)
        ->where('level', 3)
        ->first();

        if ($expenseRecord) {
            // Access the 'value' field from the level record
            $levelValue = $expenseRecord->value;
            $userID = $expenseRecord->employee_id;
            $approval = User::where('id', $userID)->first();
            // Determine the recipient based on the levelValue
            $recipient = $approval->email;

            // Check the levelValue and set the recipient accordingly
            if ($levelValue === "IS") {
                // Set the recipient to the section head's email address or user ID
                 // Replace with the actual field name
            }

            $currentUser = $user;

            Mail::to($recipient)->send(new ExpenseApplicationMail($approval, $currentUser));
            return redirect()->back()->with('success', 'Expense application approved successfully.');
        }
    } else if($advanceApplications->level1==='approved' && $advanceApplications->level2==='approved' && $approvalType->MaxLevel === 'Level3') {
        $advanceApplications->update([
            'level3' => 'approved',
            'status' => 'approved',
        ]);
        Mail::to($Approvalrecipient)->send(new ExpenseApprovedMail($user));
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Expense application approved successfully.');
    } else {
        // Handle cases where the leave application cannot be approved (e.g., it's not at the expected level or already approved)
        return redirect()->back()->with('success', 'Expense application cannot be approved.');
    }

}

public function rejectadvance(Request $request, $id) 
{
    // Validate the request data, ensuring the 'remark' field is present and not empty
    $request->validate([
        'remark' => 'required',
    ]);

    // Find the leave application by ID
    $advanceApplication = AdvanceApplication::findOrFail($id);
    $expense_id = $advanceApplication->advance_type_id;
    $userID = $advanceApplication->user_id;
    $user = User::where('id', $userID)->first();
    $Approvalrecipient = $user->email;

    $remark = $request->input('remark'); // Fetch the remark from the request

    $advanceApplication->update([
        'status' => 'rejected',
        'remark' => $remark, // Save the provided remark
    ]);

    // Update the status and remark based on conditions
    if ($advanceApplication->level1 === 'pending' && $advanceApplication->level2 === 'pending' && $advanceApplication->level3 === 'pending') {
        // All levels are approved, so update the status to 'rejected' and reset level1, level2, and level3.
        $advanceApplication->update([
            'status' => 'rejected',
            'remark' => $remark, // Save the provided remark
            'level1' => 'rejected',
        ]);
    } elseif ($advanceApplication->level1 === 'approved' && $advanceApplication->level2 === 'pending' && $advanceApplication->level3 === 'pending') {
        // Level1 is approved, update level2 to 'rejected' and reset level3.
        $advanceApplication->update([
            'status' => 'rejected',
            'remark' => $remark, // Save the provided remark
            'level2' => 'rejected',
        ]);
    } elseif ($advanceApplication->level1 === 'approved' && $advanceApplication->level2 === 'approved' && $advanceApplication->level3 === 'pending') {
        // Level1 and Level2 are approved, update level3 to 'rejected'.
        $advanceApplication->update([
            'status' => 'rejected',
            'remark' => $remark, // Save the provided remark
            'level3' => 'rejected',
        ]);
    } else {
        // If status is not approved, no further updates needed. Just update the remark.
        $advanceApplication->update([
            'remark' => $remark, // Save the provided remark
        ]);
    }
    
    $content = "The leave you applied for is Rejected. Remark: " . $remark;

    // Send mail to the recipient
    Mail::to($Approvalrecipient)->send(new ExpenseApprovedMail($user, $content));

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Expense application rejected successfully.');
}




}