<?php
  
namespace App\Http\Controllers\Expense\transfer_claim_approval;
use App\Http\Controllers\Controller; // Import the Controller class

  
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\BasicPay;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use App\Models\User;
use App\Models\Designation;
use App\Models\approvalRule;
use App\Models\approval_condition;
use App\Mail\LeaveApprovedMail;
use App\Mail\ExpenseApprovedMail;
use App\Mail\LeaveApplicationMail;
use App\Mail\ExpenseApplicationMail;
use App\Models\level;
use Illuminate\Support\Facades\Mail;
  
class transfer_claim_approval_Controller extends Controller
{
    public function transfer_claim_approval_show(Request $request){
        $designationId = auth()->user()->designation_id;
        $designationName = Designation::where('id', $designationId)->value('name');
        $query = Product::with('expenseType');
    
        if ($designationName == 'Section Head') {
            $sectionHeadId = auth()->user()->section_id;
            $query->whereHas('user.section', function ($query) use ($sectionHeadId) {
                $query->where('id', $sectionHeadId);
            });
        } else if ($designationName == "Department Head") {
            $DepartmentHeadId = auth()->user()->department_id;
            $query->whereHas('user.department', function ($query) use ($DepartmentHeadId) {
                $query->where('id', $DepartmentHeadId);
            })->where('level1', 'approved')->where('status', 'pending');
        } else if ($designationName == "Human Resource") {
            $query->where('level3', 'pending')->where('status', 'pending');
        }
    
        $status = $request->input('status');
        if ($status) {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['pending', 'approved']);
        }
    
        $expenseApplications = $query->get();

    return view('Expense.transfer_claim_approval.transfer_claim_approval_show', compact('expenseApplications'));
    }


    public function approvetransfer(Request $request, $id){
        // Find the leave application by ID
        $expenseApplication = Product::findOrFail($id);
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
            return redirect()->back()->with('success', 'Transfer application approved successfully.');
        
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
                return redirect()->back()->with('success', 'Transfer application approved successfully.');
            }

        }else if($expenseApplication->level1==='approved' && $approvalType->MaxLevel === 'Level2') {
            $expenseApplication->update([
                'level2' => 'approved',
                'status' => 'approved',
            ]);
            Mail::to($Approvalrecipient)->send(new LeaveApprovedMail($user));
        
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Transfer application approved successfully.');
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
                return redirect()->back()->with('success', 'Transfer application approved successfully.');
            }
        } else if($expenseApplication->level1==='approved' &&$expenseApplication->level2==='approved' && $approvalType->MaxLevel === 'Level3') {
            $expenseApplication->update([
                'level3' => 'approved',
                'status' => 'approved',
            ]);
            Mail::to($Approvalrecipient)->send(new ExpenseApprovedMail($user));
        
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Transfer application approved successfully.');
        } else {
            // Handle cases where the leave application cannot be approved (e.g., it's not at the expected level or already approved)
            return redirect()->back()->with('success', 'Transfer application cannot be approved.');
        }

    }
    
}