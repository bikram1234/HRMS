<?php

namespace App\Http\Controllers\Expense\Fuel_approval;
use App\Http\Controllers\Controller; // Import the Controller class


use App\Models\Fuel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Designation;
use App\Models\User;
use App\Models\approvalRule;
use App\Models\approval_condition;
use App\Mail\LeaveApprovedMail;
use App\Mail\ExpenseApprovedMail;
use App\Mail\LeaveApplicationMail;
use App\Mail\ExpenseApplicationMail;
use App\Models\level;
use Illuminate\Support\Facades\Mail;





class fuel_approval_Controller extends Controller
{
    public function fuel_approval(Request $request){
        $designationId = auth()->user()->designation_id;
        $designationName = Designation::where('id', $designationId)->value('name');
        $query = Fuel::with('expenseType');
    
        if ($designationName == 'Section Head') {
            $sectionHeadId = auth()->user()->section_id;
            $query->whereHas('user.section', function ($query) use ($sectionHeadId) {
                $query->where('id', $sectionHeadId);
            })->where('level1', 'pending')->where('status', 'pending');
    
            $expenseApplications = $query->get();
            return view('Expense.Fuel_approval.fuel_approval_show', compact('expenseApplications'));
    
        } else if ($designationName == "Department Head") {
            $DepartmentHeadId = auth()->user()->department_id;
            $query->whereHas('user.department', function ($query) use ($DepartmentHeadId) {
                $query->where('id', $DepartmentHeadId);
            })->where('level1', 'approved')->where('level2','pending')->where('status', 'pending');
    
            $expenseApplications = $query->get();
            return view('Expense.Fuel_approval.fuel_approval_show', compact('expenseApplications'));
    
        } else if ($designationName == "Management") {
            $query->where('level3', 'pending')->where('level2', 'Approved')->where('status', 'pending');
            
            $expenseApplications = $query->get();
            return view('Expense.Fuel_approval.fuel_approval_show', compact('expenseApplications'));
        }
    
        $status = $request->input('status');
        if ($status) {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['pending', 'approved']);
        }
    
    //     $expenseApplications = $query->get();

    // return view('Expense.Fuel_approval.fuel_approval_show', compact('expenseApplications'));
    }

    public function show_details ($id){
        $fuel = Fuel::findOrFail($id); // Assuming Expense is the model for your expenses
    
        return view('Expense.Fuel_approval.details', compact('fuel'));
    }


    public function approvefuel(Request $request, $id){
        // Find the leave application by ID
        $expenseApplication = Fuel::findOrFail($id);
        $expense_id = $expenseApplication->expense_type_id;
        $userID = $expenseApplication->user_id;
        $user = User::where('id', $userID)->first();
        $Approvalrecipient = $user->email;

        $approvalRuleId = approvalRule::where('type_id', $expense_id)->value('id');
        $approvalType = approval_condition::where('approval_rule_id', $approvalRuleId)->first();
        $hierarchy_id = $approvalType->hierarchy_id;

        $departmentId = $user->department_id;
        $departmentHead = User::where('department_id', $departmentId)
        ->whereHas('designation', function ($query) {
            $query->where('name', 'Department Head');
        })
        ->first();

        if ($expenseApplication->level1 === 'pending' && $approvalType->MaxLevel === 'Level1') {
            // Update the leave application fields
            $expenseApplication->update([
                'level1' => 'approved',
                'status' => 'approved',
            ]);
        
            Mail::to($Approvalrecipient)->send(new ExpenseApprovedMail($user));
        
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Fuel application approved successfully.');
        
        } else if (
            $expenseApplication->level1 === 'pending' &&
            $expenseApplication->level2 === 'pending' &&
            ($approvalType->MaxLevel === 'Level2' || $approvalType->MaxLevel === 'Level3')
        ) { 
            $expenseApplication->update([
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
                return redirect()->back()->with('success', 'Fuel application approved successfully.');
            }

        }else if($expenseApplication->level1==='approved' && $approvalType->MaxLevel === 'Level2') {
            $expenseApplication->update([
                'level2' => 'approved',
                'status' => 'approved',
            ]);
            Mail::to($Approvalrecipient)->send(new LeaveApprovedMail($user));
        
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Fuel application approved successfully.');
        } else if($expenseApplication->level1==='approved' &&$expenseApplication->level2==='pending' && $approvalType->MaxLevel === 'Level3') {
            $expenseApplication->update([
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
                return redirect()->back()->with('success', 'Fuel application approved successfully.');
            }
        } else if($expenseApplication->level1==='approved' &&$expenseApplication->level2==='approved' && $approvalType->MaxLevel === 'Level3') {
            $expenseApplication->update([
                'level3' => 'approved',
                'status' => 'approved',
            ]);
            Mail::to($Approvalrecipient)->send(new ExpenseApprovedMail($user));
        
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Fuel application approved successfully.');
        } else {
            // Handle cases where the leave application cannot be approved (e.g., it's not at the expected level or already approved)
            return redirect()->back()->with('success', 'Fuel application cannot be approved.');
        }

    }


    public function rejectfuel(Request $request, $id) 
    {
        // Validate the request data, ensuring the 'remark' field is present and not empty
        $request->validate([
            'remark' => 'required',
        ]);
    
        // Find the leave application by ID
        $expenseApplication = Fuel::findOrFail($id);
        $expense_id = $expenseApplication->expensetype_id;
        $userID = $expenseApplication->user_id;
        $user = User::where('id', $userID)->first();
        $Approvalrecipient = $user->email;
    
        $remark = $request->input('remark'); // Fetch the remark from the request
    
        $expenseApplication->update([
            'status' => 'rejected',
            'remark' => $remark, // Save the provided remark
        ]);
    
        // Update the status and remark based on conditions
        if ($expenseApplication->level1 === 'pending' && $expenseApplication->level2 === 'pending' && $expenseApplication->level3 === 'pending') {
            // All levels are approved, so update the status to 'rejected' and reset level1, level2, and level3.
            $expenseApplication->update([
                'status' => 'rejected',
                'remark' => $remark, // Save the provided remark
                'level1' => 'rejected',
            ]);
        } elseif ($expenseApplication->level1 === 'approved' && $expenseApplication->level2 === 'pending' && $expenseApplication->level3 === 'pending') {
            // Level1 is approved, update level2 to 'rejected' and reset level3.
            $expenseApplication->update([
                'status' => 'rejected',
                'remark' => $remark, // Save the provided remark
                'level2' => 'rejected',
            ]);
        } elseif ($expenseApplication->level1 === 'approved' && $expenseApplication->level2 === 'approved' && $expenseApplication->level3 === 'pending') {
            // Level1 and Level2 are approved, update level3 to 'rejected'.
            $expenseApplication->update([
                'status' => 'rejected',
                'remark' => $remark, // Save the provided remark
                'level3' => 'rejected',
            ]);
        } else {
            // If status is not approved, no further updates needed. Just update the remark.
            $expenseApplication->update([
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