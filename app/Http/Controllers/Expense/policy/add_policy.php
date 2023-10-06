<?php

namespace App\Http\Controllers\Expense\policy;
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

class add_policy  extends Controller
{
     // Get Policy
     public function AddForm()
     {
         $expenseTypes = ExpenseType::all();
         // Get the expense_type_ids that exist in the policies table
$existingExpenseTypeIds = DB::table('policies')->pluck('expense_type_id');

// Filter the $expenseTypes collection to exclude those that exist in the policies table
$expenseTypes = $expenseTypes->reject(function ($expenseType) use ($existingExpenseTypeIds) {
    return $existingExpenseTypeIds->contains($expenseType->id);
});

         $policies = Policy::with('expenseType')->get(); // Fetch policies from the database
         return view('Expense.policy.add_policy.policy_add', compact('expenseTypes', 'policies'));
     }   
     // Add Policy Based on Expense_Type
     public function addPolicy(Request $request)
     {
         $validatedData = $request->validate([
             'expense_type_id' => 'required|exists:expense_types,id',
             'name' => 'required|string|max:255',
             'description' => 'nullable|string',
             'start_date' => 'required|date',
             'end_date' => 'nullable|date|after:start_date',
             'status' => 'required|in:draft,enforce', // Add the status validation
         ]);
 
         //Policy::create($validatedData);
         $policy = Policy::create($validatedData);
 
         // return redirect()->route('add-policy')
         return redirect()->route('add-rate-definition', ['policy' => $policy->id])
             ->with('success', 'Policy added successfully');
     }
 
 
     //Get Rate Definition
     public function addRateDefinition(Policy $policy)
     {
         // Retrieve rate limits associated with the current policy
        // $rateLimits = RateLimit::where('policy_id', $policy->id)->get();
        $rateLimits = RateLimit::where('policy_id', $policy->id)
        ->with('gradeName')
        ->paginate(10); // You can specify the number of records per page (e.g., 10)
 
     
         return view('Expense.policy.add_policy.rate_definition_add', compact('policy', 'rateLimits'));
     }
 
     public function storeRateDefinition(Request $request)
 {
     // Check if a rate definition with the same policy_id already exists
     $existingRateDefinition = RateDefinition::where('policy_id', $request->input('policy_id'))->first();
 
     if ($existingRateDefinition) {
         return redirect()->route('rate-limits.create', ['rateDefinition' => $existingRateDefinition->id])
             ->with('info', 'Rate definition for this policy already exists.');
     }
 
     $validatedData = $request->validate([
         'policy_id' => 'required|exists:policies,id',
         'attachment_required' => 'required|boolean',
         'travel_type' => 'required|in:domestic',
         'type' => 'required|in:Single Currency',
         'name' => 'required|in:Nu',
         'rate_limit' => 'required|in:daily,monthly,yearly',
     ]);
  
     // Create a new RateDefinition
     $rateDefinition = RateDefinition::create($validatedData);
 
     // Redirect to the createLimit view with rate_definition_id as a parameter
     return redirect()->route('rate-limits.create', ['rateDefinition' => $rateDefinition->id])
         ->with('success', 'Rate definition added successfully');
 }
 
 
 
     // Get Rate Limit
     public function createLimit(Request $request, RateDefinition $rateDefinition)
     {
         $grades = Grade::all(); // Fetch all grades from the Grade model
     
         return view('Expense.policy.add_policy.createlimit', compact('rateDefinition', 'grades'));
     }
 public function StoreLimit(Request $request, RateDefinition $rateDefinition)
 {
     try{
     // Validate other fields as before
     $validatedData = $request->validate([
         'grade' => 'required|array',
         'grade.*' => 'required|string',
         'region' => 'required|string',
         'limit_amount' => 'required|numeric',
         'start_date' => 'required|date',
         'end_date' => 'nullable|date|after:start_date',
         'status' => 'required|in:active,inactive',
     ]);
 
     // Retrieve an array of selected grades from the form
     $grades = $validatedData['grade'];
 
     // Loop through each selected grade and check for existing rate limits
     foreach ($grades as $grade) {
         $existingRateLimit = $rateDefinition->rateLimits()
             ->where('grade', $grade)
             ->where('region', $validatedData['region'])
             ->exists();
 
         if ($existingRateLimit) {
             return redirect()->route('rate-limits.create', ['rateDefinition' => $rateDefinition->id])
                 ->with('success', 'Rate limit for this grade and region already exists.');
         }
 
         // Create a new rate limit associated with the rate definition for each grade
         $rateLimitData = [
             'grade' => $grade,
             'region' => $validatedData['region'],
             'limit_amount' => $validatedData['limit_amount'],
             'start_date' => $validatedData['start_date'],
             'end_date' => $validatedData['end_date'],
             'status' => $validatedData['status'],
             'policy_id' => $rateDefinition->policy_id, // Store the policy_id
         ];
 
         // Create a new rate limit associated with the rate definition for each grade
         $rateDefinition->rateLimits()->create($rateLimitData);
     }
 
     return redirect()->route('add-rate-definition', ['policy' => $rateDefinition->policy->id])
         ->with('success', 'Rate limits added successfully');
 
     } catch (\Exception $e) {
         $errorMessage = 'An error occurred while saving the manual settlement';
         // Log or print the exception's stack trace for detailed information
         // Log the exception details
         \Log::error($errorMessage . ': ' . $e->getMessage());
         \Log::error('Stack Trace: ' . $e->getTraceAsString());
 
         return response()->json(['error' => $errorMessage], 500);
     }
 }
 
 public function policyEnforcement(Policy $policy)
 {
     // Check if a rate limit with the same policy_id exists
     $rateLimitExists = RateLimit::where('policy_id', $policy->id)->exists();
 
     if (!$rateLimitExists) {
         return redirect()->route('add-rate-definition', ['policy' => $policy->id])
             ->with('success', 'Rate limit for this policy does not exist. Please create a rate limit first.');
     }
     
 
     return view('Expense.policy.add_policy.policy_enforcement', compact('policy'));
 }
 public function storepolicyEnforement(Request $request, Policy $policy)
 {
     try {
         $validator = Validator::make($request->all(), [
             'enforcement_options' => [
                 'required',
                 'array',
                 Rule::in(['prevent_submission', 'display_warning', 'both']),
             ],
         ]);
 
         if ($validator->fails()) {
             return back()
                 ->withErrors($validator)
                 ->withInput();
         }
 
         // Process the selected enforcement options
         $selectedOptions = $request->input('enforcement_options');
 
         // Store the enforcement options and associate them with the policy
         $enforcementOptions = new EnforcementOption([
             'policy_id' => $policy->id,
             'prevent_submission' => in_array('prevent_submission', $selectedOptions),
             'display_warning' => in_array('display_warning', $selectedOptions),
         ]);
 
         $enforcementOptions->save();
 
         // return redirect()->route('policy-enforcement.index', ['policy' => $policy->id])
         //     ->with('success', 'Enforcement options updated successfully');
         return redirect()->route('policy.details.create', ['policy' => $policy->id])
         ->with('success', 'Enforcement options updated successfully');    
     
     } catch (\Exception $e) {
         \Log::error('Error:', ['message' => $e->getMessage()]);
         return back()->withInput()
             ->with('success', 'An error occurred while adding policy Enforcement: ' . $e->getMessage());
     }
 }
 
 public function createpolicy(Policy $policy)
 {
     // Retrieve policy details, rate definitions, rate limits, and policy enforcement
     // based on the provided $policy variable.
     $rateDefinitions = RateDefinition::where('policy_id', $policy->id)->get();
     $rateLimits = RateLimit::where('policy_id', $policy->id)
     ->with('gradeName')
     ->get();
     $policyEnforcements = EnforcementOption::where('policy_id', $policy->id)->first();
     $policyDetails = $policy; // Fetch policy details
 
     return view('Expense.policy.add_policy.policy_summary', compact('policy', 'rateDefinitions', 'rateLimits', 'policyEnforcements'));}
 
 public function saveorcanclepolicy(Request $request, Policy $policy)
 {
      try {
         if ($request->has('cancel')) {
             // Example of deleting related records
             RateDefinition::where('policy_id', $policy->id)->delete();
             RateLimit::where('policy_id', $policy->id)->delete();
             EnforcementOption::where('policy_id', $policy->id)->delete();
         
             // Delete the Policy record
             $policy->delete();
         
             return redirect()->route('add-policy')
                 ->with('success', 'Changes canceled');
         }
         
 
         // Handle saving changes here.
         // Update or create policy details, rate definitions, rate limits, and policy enforcement records.
         // You'll need to adjust this code based on your data structure.
 
         // Example of updating or creating policy enforcement options
         EnforcementOption::updateOrCreate(
             ['policy_id' => $policy->id],
             [
                 'prevent_submission' => $request->has('prevent_submission'),
                 'display_warning' => $request->has('display_warning'),
             ]
         );
 
         return redirect()->route('add-policy')
             ->with('success', 'Changes saved successfully');
 
     } catch (\Exception $e) {
         \Log::error('Error:', ['message' => $e->getMessage()]);
         return back()->withInput()
             ->with('success', 'An error occurred while handling changes: ' . $e->getMessage());
     }
 }
 
 }