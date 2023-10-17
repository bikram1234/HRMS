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

class apply  extends Controller
{
   
    // Get the Expense Application Form
    public function showApplicationForm()
    {        
        
        $expenseTypes = ExpenseType::all();
        $user = Auth::user(); // Get the authenticated user
        $userApplications = ExpenseApplication::where('user_id', $user->id)->get(); // Fetch user's applications
        
        return view('Expense.expense_apply.expense_form', compact('userApplications', 'expenseTypes'));
    }
    // Add expense Application Request
    public function submitApplication(Request $request)
    {
        try {
        
        $validatedData = $request->validate([
            'expense_type_id' => 'required|exists:expense_types,id',
            'total_amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'attachment' => 'nullable|mimes:pdf|max:2048', // Max 2 MB PDF file
        ], [
            'attachment.max' => 'The attachment file size must not exceed 2MB.',
        ]);
    
        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            if ($attachment->getSize() > 2048000) { // 2MB in bytes
                return redirect()->route('show-application-form')
                    ->withErrors(['attachment' => 'The attachment file size must not exceed 2MB.'])
                    ->withInput();
            }
    
            $attachmentPath = $attachment->store('attachments', 'public');
            $validatedData['attachment'] = $attachmentPath;
        }
    
        $validatedData['user_id'] = Auth::id(); // Assign the current user's ID
        $validatedData['application_date'] = now(); // Current date
        $validatedData['status'] = 'pending'; // Set status to pending
    
        ExpenseApplication::create($validatedData);
            //display the message 
            $notification = array(
                'message' => 'Expense application submitted successfully.',
                'alert-type' =>'success'
            );
    
        return redirect()->route('show-application-form')->with($notification);

        } catch (\Exception $e) {
            $errorMessage = 'An error occurred while saving the settlement';
            \Log::error($errorMessage . ': ' . $e->getMessage());
            \Log::error('Stack Trace: ' . $e->getTraceAsString());
    
            return response()->json(['error' => $errorMessage], 500);
        }
    } 
    
}