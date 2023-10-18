<?php

namespace App\Http\Controllers\Expense\dsa_approval;
use App\Http\Controllers\Controller; // Import the Controller class

use Illuminate\Http\Request;
use App\Models\approvalRule;
use App\Models\approval_condition;
use App\Mail\LeaveApprovedMail;
use App\Mail\LeaveApplicationMail;
use App\Mail\ExpenseApplicationMail;
use App\Mail\ExpenseApprovedMail;
use App\Models\Designation;
use App\Models\level;
use App\Models\ExpenseType;
use App\Models\Policy;
use App\Models\Section;
use App\Models\User;
use App\Models\ExpenseApplication;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreatedMail;
use Illuminate\Support\Facades\Hash;
use App\Models\Advance;
use App\Models\SalaryAdvance;
use App\Models\DsaAdvance;
use App\Models\DsaSettlement;
use App\Models\DsaManualSettlement;
use App\Models\RateDefinition;
use App\Models\RateLimit;
use App\Models\Grade;
use App\Models\EnforcementOption;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;

class dsa_approval_Controller  extends Controller
{
    public function show_dsa_approval_application(Request $request){

        $designationId = auth()->user()->designation_id;
        $designationName = Designation::where('id', $designationId)->value('name');
        if($designationName == 'Section Head'){
            $sectionHeadId = auth()->user()->section_id;
            $expenseApplications = DsaSettlement::whereHas('user.section', function ($query) use ($sectionHeadId) {
                $query->where('id', $sectionHeadId);
            })->get();

            return view('Expense.dsa_approval.dsa_approval', compact('expenseApplications'));

        } else if($designationName == "Department Head"){
            $DepartmentHeadId = auth()->user()->department_id;

            // Query leave applications for the section head's section
            $AppliedApplications = DsaSettlement::whereHas('user.department', function ($query) use ($DepartmentHeadId) {
                $query->where('id', $DepartmentHeadId);
            })->get();

            $expenseApplications = $AppliedApplications->filter(function ($leaveApplication) {
                return $leaveApplication->level1 === 'approved' && $leaveApplication->status === 'pending';
            });

            return view('Expense.dsa_approval.dsa_approval', compact('expenseApplications'));
        } else if ($designationName == "Management") {
            $expenseApplications = DsaSettlement::where('level3', 'pending')
            ->where('status', 'pending')
            ->get();
            return view('Expense.dsa_approval.dsa_approval', compact('expenseApplications'));

        };     
        // $query = DsaSettlement::query();

        // $status = $request->input('status');
    
        // if ($status) {
        //     $query->where('status', $status);
        // }
    
        // $dsaSettlements = $query->get();
    
        // return view('Expense.dsa_approval.dsa_approval', compact('dsaSettlements'));
    
    }

    
    public function approvedsa(Request $request, $id){
        // Find the leave application by ID
        // dd($id);
        $expenseApplication = DsaSettlement::findOrFail($id);
        $expense_id = $expenseApplication->expensetype_id;
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
            return redirect()->back()->with('success', 'DSA application approved successfully.');
        
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
                return redirect()->back()->with('success', 'DSA application approved successfully.');
            }

        }else if($expenseApplication->level1==='approved' && $approvalType->MaxLevel === 'Level2') {
            $expenseApplication->update([
                'level2' => 'approved',
                'status' => 'approved',
            ]);
            Mail::to($Approvalrecipient)->send(new ExpenseApprovedMail($user));
        
            // Redirect back with a success message
            return redirect()->back()->with('success', 'DSA application approved successfully.');
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
                return redirect()->back()->with('success', 'DSA application approved successfully.');
            }
        } else if($expenseApplication->level1==='approved' &&$expenseApplication->level2==='approved' && $approvalType->MaxLevel === 'Level3') {
            $expenseApplication->update([
                'level3' => 'approved',
                'status' => 'approved',
            ]);
            Mail::to($Approvalrecipient)->send(new ExpenseApprovedMail($user));
        
            // Redirect back with a success message
            return redirect()->back()->with('success', 'DSA application approved successfully.');
        } else {
            // Handle cases where the leave application cannot be approved (e.g., it's not at the expected level or already approved)
            return redirect()->back()->with('success', 'DSA application cannot be approved.');
        }

    }

    public function view_DsaSettlement_detail($id){
                // Retrieve the specific DsaSettlement record by ID
            $dsaSettlement = DsaSettlement::find($id);

            if (!$dsaSettlement) {
                return abort(404); // Handle if the record is not found
            }

            // Check if the DsaSettlement has an advance number or not
            if ($dsaSettlement->advance_no === null) {
                $type = 'No Advance';
            } else {
                $type = 'With Advance';
            }

            // Retrieve associated DsaManualSettlement records for this DsaSettlement
            $dsaManualSettlements = $dsaSettlement->manualSettlements;

            return view('Expense.dsa_approval.view_dsa_approval_details', [
                'dsaSettlement' => $dsaSettlement,
                'type' => $type,
                'dsaManualSettlements' => $dsaManualSettlements,
            ]);
    }


}