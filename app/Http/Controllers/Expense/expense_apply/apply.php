<?php

namespace App\Http\Controllers\Expense\expense_apply;
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
use App\Models\ExpenseApprovalRule;
use App\Models\Expenseapproval_condition;
use App\Models\level;
use App\Mail\LeaveApplicationMail;
use App\Mail\ExpenseApplicationMail;




class apply  extends Controller
{
   
    // Get the Expense Application Form
    public function showApplicationForm()
    {        
        
        $expenseTypes = ExpenseType::whereNotIn('name', ['DSA Settlement', 'Expense Fuel', 'Transfer Claim'])->get();
        $user = Auth::user(); // Get the authenticated user
        $userApplications = ExpenseApplication::with('expenseType')->where('user_id', $user->id)->get();
        
        return view('Expense.expense_apply.expense_form', compact('userApplications', 'expenseTypes'));
    }
    // Add expense Application Request
    // public function submitApplication(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'expense_type_id' => 'required|exists:expense_types,id',
    //         'total_amount' => 'required|numeric|min:0',
    //         'description' => 'required|string',
    //         'attachment' => 'nullable|mimes:pdf|max:2048', // Max 2 MB PDF file
    //     ], [
    //         'attachment.max' => 'The attachment file size must not exceed 2MB.',
    //     ]);
    
    //     if ($request->hasFile('attachment')) {
    //         $attachment = $request->file('attachment');
    //         if ($attachment->getSize() > 2048000) { // 2MB in bytes
    //             return redirect()->route('show-application-form')
    //                 ->withErrors(['attachment' => 'The attachment file size must not exceed 2MB.'])
    //                 ->withInput();
    //         }
    
    //         $attachmentPath = $attachment->store('attachments', 'public');
    //         $validatedData['attachment'] = $attachmentPath;
    //     }
    
    //     $validatedData['user_id'] = Auth::id(); // Assign the current user's ID
    //     $validatedData['application_date'] = now(); // Current date
    //     $validatedData['status'] = 'pending'; // Set status to pending
    
    //     ExpenseApplication::create($validatedData);
    
    //     return redirect()->route('show-application-form')
    //         ->with('success', 'Expense application submitted successfully.');
    // } 




    public function submitApplication(Request $request)
    {
        try{
        $validatedData = $request->validate([
            'expense_type_id' => 'required|exists:expense_types,id',
            'total_amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'attachment' => 'nullable|mimes:pdf|max:2048', // Max 2 MB PDF file
            'travel_type'=> 'nullable|string',
            'travel_mode'=> 'nullable|string',
            'travel_from_date'=>'nullable|date',
            'travel_to_date'=>'nullable|date|after:travel_from_date',
            'travel_from'=> 'nullable|string',
            'travel_to'=> 'nullable|string',


        ], [
            'attachment.max' => 'The attachment file size must not exceed 2MB.',
        ]);
    
        // Check if expense_type exists
        $expenseType = ExpenseType::find($validatedData['expense_type_id']);
        if (!$expenseType) {
            return redirect()->route('show-application-form')
                ->with('success', 'Invalid expense type.');
        }
    
        // Retrieve the associated policy for the selected expense type
        $policy = $expenseType->policies->first(); // Assuming you want the first associated policy
    
        if (!$policy) {
            return redirect()->route('show-application-form')
                ->with('success', 'There is no policy defined for this Expense Type.');
        }
    
        // Find the rate definition associated with the policy_id
        $rateDefinition = $policy->rateLimits->first()->rateDefinition; // Assuming you want the first associated rate definition
    
        if (!$rateDefinition) {
            return redirect()->route('show-application-form')
                ->with('success', 'This policy have not yet any Rate Definitions at all.');
        }
    
        // Check if attachment is required based on the rate definition
        if ($rateDefinition->attachment_required == 1) {
            // Attachment is required
            if (!$request->hasFile('attachment')) {
                return redirect()->route('show-application-form')
                    ->with('success', 'Attachment is required.');
            }
    
            $attachment = $request->file('attachment');
            if ($attachment->getSize() > 2048000) { // 2MB in bytes
                return redirect()->route('show-application-form')
                    ->withErrors(['attachment' => 'The attachment file size must not exceed 2MB.'])
                    ->withInput();
            }
    
            $attachmentPath = $attachment->store('attachments', 'public');
            $validatedData['attachment'] = $attachmentPath;
        } else {
            // Attachment is not required
            $validatedData['attachment'] = null;
        }
    
        $validatedData['user_id'] = Auth::id(); // Assign the current user's ID
        $validatedData['application_date'] = now(); // Current date
        $validatedData['status'] = 'pending'; // Set status to pending

        $expense_id = $request->input('expense_type_id');

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

        $approvalRuleId = ExpenseApprovalRule::where('type_id', $expense_id)->value('id');
        $approvalType = Expenseapproval_condition::where('approval_rule_id', $approvalRuleId)->first();
        if(!$approvalType || !$approvalType->hierarchy_id){
            return back()->withInput()
                ->with('success', 'There is no approval for this Advance type');  
        }
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



    
        ExpenseApplication::create($validatedData);
    
        return redirect()->route('show-application-form')
            ->with('success', 'Expense application submitted successfully.');

        } catch (\Exception $e) {
            $errorMessage = 'An error occurred while saving the settlement';
            \Log::error($errorMessage . ': ' . $e->getMessage());
            \Log::error('Stack Trace: ' . $e->getTraceAsString());
    
            return response()->json(['error' => $errorMessage], 500);
        }
    }





//     public function submitApplication(Request $request)
// {
//     $validatedData = $request->validate([
//         'expense_type_id' => 'required|exists:expense_types,id',
//         'total_amount' => 'required|numeric|min:0',
//         'description' => 'required|string',
//         'attachment' => 'nullable|mimes:pdf|max:2048', // Max 2 MB PDF file
//     ], [
//         'attachment.max' => 'The attachment file size must not exceed 2MB.',
//     ]);

//     // Check if expense_type exists
//     $expenseType = ExpenseType::find($validatedData['expense_type_id']);
//     if (!$expenseType) {
//         return redirect()->route('show-application-form')
//             ->with('success', 'Invalid expense type.');
//     }

//     // Retrieve the associated policy for the selected expense type
//     $policy = $expenseType->policies->first(); // Assuming you want the first associated policy

//     // Find the rate definition associated with the policy_id
//     $rateDefinition = $policy ? $policy->rateLimits->first()->rateDefinition : null; // Assuming you want the first associated rate definition

//     // Check if attachment is required based on the rate definition
//     if ($rateDefinition && $rateDefinition->attachment_required == 1) {
//         // Attachment is required
//         if (!$request->hasFile('attachment')) {
//             return redirect()->route('show-application-form')
//                 ->with('success', 'Attachment is required.');
//         }

//         $attachment = $request->file('attachment');
//         if ($attachment->getSize() > 2048000) { // 2MB in bytes
//             return redirect()->route('show-application-form')
//                 ->withErrors(['attachment' => 'The attachment file size must not exceed 2MB.'])
//                 ->withInput();
//         }

//         $attachmentPath = $attachment->store('attachments', 'public');
//         $validatedData['attachment'] = $attachmentPath;
//     } else {
//         // Attachment is not required
//         $validatedData['attachment'] = null;
//     }

//     $validatedData['user_id'] = Auth::id(); // Assign the current user's ID
//     $validatedData['application_date'] = now(); // Current date
//     $validatedData['status'] = 'pending'; // Set status to pending

//     ExpenseApplication::create($validatedData);

//     return redirect()->route('show-application-form')
//         ->with('success', 'Expense application submitted successfully.');
// }

    
    

}