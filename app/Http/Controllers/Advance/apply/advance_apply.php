<?php

namespace App\Http\Controllers\Advance\apply;
use App\Http\Controllers\Controller; // Import the Controller class

use Illuminate\Http\Request;
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
use App\Models\AdvanceapprovalRule;
use App\Models\Advanceapproval_condition;
use App\Models\level;
use App\Mail\ExpenseApplicationMail;

class advance_apply  extends Controller
{
    public function advance_details(){

        $user = Auth::user();
        // Fetch SalaryAdvance records for the current user
        $salaryAdvances = SalaryAdvance::with('advanceType')->where('user_id', $user->id)->get();

        // Fetch DsaAdvance records for the current user
        $dsaAdvances = DsaAdvance::with('advanceType')->where('user_id', $user->id)->get();

        // Combine SalaryAdvance and DsaAdvance records into a single collection
        $advances = $salaryAdvances->concat($dsaAdvances);

        return view('Advance.advance_apply.advanceloan_details', compact('advances'));

    }
     //Get Advance Application form
     public function showAdvance()
     {
         $advance_type= Advance :: all();
         //dd($advance_type);
         return view('Advance.advance_apply.advanceloan_form', compact('advance_type'));
     }
     // request for advance loan for DSA_Advance and Salary_Advance
     public function addAdvanceLoan(Request $request)
     {
         // Get the authenticated user's ID
         $user_id = Auth::id();
 
         DB::beginTransaction();
          //dd($request->all()); 
         try {
 
             if ($request->input('advance_type') === 'dsa_advance') {
 
                 $advanceType = Advance::where('name', 'DSA Advance')->first();
 
                 $validatedData = $request->validate([
                     'advance_type' => 'required|in:dsa_advance',
                     'mode_of_travel' => 'required|string|max:255',
                     'from_location' => 'required|string|max:255',
                     'to_location' => 'required|string|max:255',
                     'from_date' => 'required|date',
                     'to_date' => 'required|date|after_or_equal:from_date',
                     'amount' => 'required|numeric|min:0',
                     'purpose' => 'required|string|max:255',
                     'upload_file' => 'nullable|file|mimes:pdf|max:2048', // Max size of 2 MB
                 ]);
 
                //  \Log::info('Processing DSA Advance', ['data' => $validatedData]);
 
                 // Generate an advance number based on the current date and time
                 $currentDateTime = now();
                 $advanceNo = 'DSA' . $currentDateTime->format('YmdHis');
 
                 // Add the user_id and advance number to the validated data array
                 $validatedData['advance_type_id'] = $advanceType->id;
                 $validatedData['user_id'] = $user_id;
                 $validatedData['advance_no'] = $advanceNo;
                 $validatedData['status'] = 'pending'; // Set status to pending

                 $advance_id = $request->input('advance_type');

                 $sectionId = auth()->user()->section_id;
                 $sectionHead = User::where('section_id', $sectionId)
                 ->whereHas('designation', function($query) {
                     $query->where('name', 'Section Head');
                 })->first();

                 $departmentId = auth()->user()->department_id;
                 $departmentHead = User::where('department_id', $departmentId)
                 ->whereHas('designation', function ($query) {
                     $query->where('name', 'Department Head');
                 })
                 ->first();

                 $approvalRuleId = AdvanceapprovalRule::where('type_id', $advance_id)->value('id');
                 $approvalType = Advanceapproval_condition::where('approval_rule_id', $approvalRuleId)->first();
                 $hierarchy_id = $approvalType->hierarchy_id;
                 $currentUser = auth()->user();

                 if ($approvalType->approval_type == "Hierarchy") {
                    // Fetch the record from the levels table based on the $hierarchy_id
                    $levelRecord = Level::where('hierarchy_id', $hierarchy_id)->first();
        
                    if ($levelRecord) {
                        // Access the 'value' field from the level record
                        $levelValue = $levelRecord->value;
        
                        // Determine the recipient based on the levelValue
                        $recipient = '';
        
                        // Check the levelValue and set the recipient accordingly
                        if ($levelValue === "SH") {
                            // Set the recipient to the section head's email address or user ID
                            $recipient = $sectionHead->email; // Replace with the actual field name
                        }
                        $approval = $sectionHead;
        
                        Mail::to($recipient)->send(new ExpenseApplicationMail($approval, $currentUser));
                    }
                }


 
                 DsaAdvance::create($validatedData);
 
             } elseif ($request->input('advance_type') === 'salary_advance') {
 
                 $advanceType = Advance::where('name', 'Salary Advance')->first();
 
                 $validatedData = $request->validate([
                     'advance_type' => 'required|in:salary_advance',
                     'emi_count' => 'required|integer|min:1',
                     'deduction_period' => 'required|date',
                     'amount' => 'required|numeric|min:0',
                     'purpose' => 'required|string|max:255',
                     'upload_file' => 'nullable|file|mimes:pdf|max:2048', // Max size of 2 MB
                 ]);
 
                //  \Log::info('Processing Salary Advance', ['data' => $validatedData]);
 
                 // Generate an advance number based on the current date and time
                 $currentDateTime = now();
                 $advanceNo = 'SAL' . $currentDateTime->format('YmdHis');
 
                 // Add the user_id and advance number to the validated data array
                 $validatedData['advance_type_id'] = $advanceType->id;
                 $validatedData['user_id'] = $user_id;
                 $validatedData['advance_no'] = $advanceNo;
                 $validatedData['status'] = 'pending'; // Set status to pending


                 $advance_id = $request->input('advance_type');

                 $sectionId = auth()->user()->section_id;
                 $sectionHead = User::where('section_id', $sectionId)
                 ->whereHas('designation', function($query) {
                     $query->where('name', 'Section Head');
                 })->first();

                 $departmentId = auth()->user()->department_id;
                 $departmentHead = User::where('department_id', $departmentId)
                 ->whereHas('designation', function ($query) {
                     $query->where('name', 'Department Head');
                 })
                 ->first();

                 $approvalRuleId = AdvanceapprovalRule::where('type_id', $advance_id)->value('id');
                 $approvalType = Advanceapproval_condition::where('approval_rule_id', $approvalRuleId)->first();
                 $hierarchy_id = $approvalType->hierarchy_id;
                 $currentUser = auth()->user();

                 if ($approvalType->approval_type == "Hierarchy") {
                    // Fetch the record from the levels table based on the $hierarchy_id
                    $levelRecord = Level::where('hierarchy_id', $hierarchy_id)->first();
        
                    if ($levelRecord) {
                        // Access the 'value' field from the level record
                        $levelValue = $levelRecord->value;
        
                        // Determine the recipient based on the levelValue
                        $recipient = '';
        
                        // Check the levelValue and set the recipient accordingly
                        if ($levelValue === "SH") {
                            // Set the recipient to the section head's email address or user ID
                            $recipient = $sectionHead->email; // Replace with the actual field name
                        }
                        $approval = $sectionHead;
        
                        Mail::to($recipient)->send(new ExpenseApplicationMail($approval, $currentUser));
                    }
                }
 
                 SalaryAdvance::create($validatedData);
             }
 
             DB::commit();
 
             return redirect()->route('show-advance-loan')
                 ->with('success', 'Advance added successfully');
 
         } catch (\Exception $e) {
             \Log::error('Error:', ['message' => $e->getMessage()]);
             DB::rollBack();
             //return redirect()->route('show-advance-loan')
             return back()->withInput()
             ->with('success', 'An error occurred while adding the advance: ' . $e->getMessage());        }
     }
 
 
 
}