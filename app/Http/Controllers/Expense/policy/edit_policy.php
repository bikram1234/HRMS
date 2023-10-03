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

class edit_policy  extends Controller
{
//Edit policy
    public function editPolicy(Policy $policy)
    {
    return view('Expense.policy.edit_policy.policy_edit', compact('policy'));
    }
    public function updatePolicy(Request $request, Policy $policy)
    {
    // Start by fetching the current policy data
    $currentPolicy = Policy::find($policy->id);

    // Check if we are in the update step or summary step
    $isSummaryStep = $request->has('summary_step');

    // Create a draft policy with the current data
    $draftPolicy = $currentPolicy->replicate();

    // Update the draft policy with newly submitted data
    if (!$isSummaryStep) {
        // Define your validation rules here
        $validatedData = $request->validate([
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            // Add more fields as needed
        ]);

        $draftPolicy->fill($validatedData);

        // Store the draft policy data in the session
        $request->session()->put('draft_policy', $draftPolicy);
    }

    try {
        if ($isSummaryStep && $request->has('cancel')) {
            // If the user cancels, discard the draft data
            $request->session()->forget('draft_policy');
            return redirect()->route('add-policy');
        }

        if ($isSummaryStep && $request->has('save')) {
            // If the user saves, apply the changes to the main policy
            $currentPolicy->update($draftPolicy->toArray());
            $request->session()->forget('draft_policy');
            return redirect()->route('edit-rate-definition', ['policy' => $policy->id])
                ->with('success', 'Policy updated successfully');
        }

        // In the update step, continue as usual without affecting the main database
        return redirect()->route('edit-rate-definition', ['policy' => $policy->id])
        ->with('success', 'Policy updated successfully');
    }  catch (\Exception $e) {
        \Log::error('Error:', ['message' => $e->getMessage()]);
        return back()->withInput()
            ->with('success', 'An error occurred while handling changes: ' . $e->getMessage());
    }
    }




    //Edit Rate definition
    public function editRateDefinition(Policy $policy)
    {
        $rateLimits = RateLimit::where('policy_id', $policy->id)
        ->with('gradeName')
        ->paginate(10); // pagination up to 10 numbers of datas from database

        $rateDefinition = RateDefinition::where('policy_id', $policy->id)->first();
        $draftRateLimits = session('draft_rate_limits');
        //dd($draftRateLimits);
        $draftRateLimit = session('update_rate_limit'); 
        //dd($draftRateLimit);
        return view('Expense.policy.edit_policy.rate_definition_edit', compact('policy', 'rateDefinition', 'rateLimits','draftRateLimits','draftRateLimit'));
    }
// public function updateRateDefinition(Request $request, Policy $policy)
// {
//     // Start by fetching the current rate definition data
//     $currentRateDefinition = RateDefinition::where('policy_id', $policy->id)->first();

//     // Check if we are in the update step or summary step
//     $isSummaryStep = $request->has('summary_step');

//     // Create a draft rate definition with the current data
//     $draftRateDefinition = $currentRateDefinition->replicate();

//     // Update the draft rate definition with newly submitted data
//     if (!$isSummaryStep) {
//         // Define your validation rules here
//         $rules = [
//             // Define your validation rules for rate definition fields
//         ];

//         $validatedData = $request->validate($rules);

//         $draftRateDefinition->fill($validatedData);

//         // Store the draft rate definition data in the session
//         $request->session()->put('draft_rate_definition', $draftRateDefinition);
//     }

//     try {
//         if ($isSummaryStep && $request->has('cancel')) {
//             // If the user cancels, discard the draft data
//             $request->session()->forget('draft_rate_definition');
//             return redirect()->route('edit-policy', ['policy' => $policy->id]);
//         }

//         if ($isSummaryStep && $request->has('save')) {
//             // If the user saves, apply the changes to the main rate definition
//             $currentRateDefinition->update($draftRateDefinition->toArray());
//             $request->session()->forget('draft_rate_definition');
//             return redirect()->route('edit-rate-limits.create', ['rateDefinition' => $currentRateDefinition->id])
//                 ->with('success', 'Rate definition updated successfully');
//         }

//         // In the update step, continue as usual without affecting the main database

//         return redirect()->route('edit-rate-limits.create', ['rateDefinition' => $currentRateDefinition->id])
//         ->with('success', 'Rate definition updated successfully');
//     }  catch (\Exception $e) {
//         \Log::error('Error:', ['message' => $e->getMessage()]);
//         return back()->withInput()
//             ->with('success', 'An error occurred while handling changes: ' . $e->getMessage());
//     }
// }


    // Get Rate Limit after update
    public function createLimits(Request $request, RateDefinition $rateDefinition)
    {
        $grades = Grade::all(); // Fetch all grades from the Grade model
    
        return view('Expense.policy.edit_policy.createupdatelimit', compact('rateDefinition', 'grades'));
    }
    // public function StoreLimits(Request $request, RateDefinition $rateDefinition)
    // {
    //     try {
    //         // Validate other fields as before
    //         $validatedData = $request->validate([
    //             'grade' => 'required|array',
    //             'grade.*' => 'required|string',
    //             'region' => 'required|string',
    //             'limit_amount' => 'required|numeric',
    //             'start_date' => 'required|date',
    //             'end_date' => 'nullable|date|after:start_date',
    //             'status' => 'required|in:active,inactive',
    //             // Add missing validation rules here, if any
    //         ]);
    
    //         // Retrieve an array of selected grades from the form
    //         $grades = $validatedData['grade'];
    
    //         // Loop through each selected grade and check for existing rate limits
    //         foreach ($grades as $grade) {
    //             $existingRateLimit = $rateDefinition->rateLimits()
    //                 ->where('grade', $grade)
    //                 ->where('region', $validatedData['region'])
    //                 ->exists();
    
    //             if ($existingRateLimit) {
    //                 return redirect()->route('edit-rate-limits.create', ['rateDefinition' => $rateDefinition->id])
    //                     ->with('success', 'Rate limit for this grade and region already exists.');
    //             }
    //         }
    
    //         // Initialize an empty array for draft rate limits
    //         $draftRateLimits = [];
    
    //         // Loop through each selected grade and create a new rate limit
    //         foreach ($grades as $grade) {
    //             $rateLimitData = [
    //                 'grade' => $grade,
    //                 'region' => $validatedData['region'],
    //                 'limit_amount' => $validatedData['limit_amount'],
    //                 'start_date' => $validatedData['start_date'],
    //                 'end_date' => $validatedData['end_date'],
    //                 'status' => $validatedData['status'],
    //                 'policy_id' => $rateDefinition->policy_id, // Store the policy_id
    //                 'rate_definition_id' =>$rateDefinition->id,
    //             ];
    
    //             // Add the rate limit data to the draft array
    //             $draftRateLimits[] = $rateLimitData;
    //         }
    
    //         // Store the draft rate limits in the session
    //         $request->session()->put('draft_rate_limits', $draftRateLimits);
    
    //         return redirect()->route('edit-rate-definition', ['policy' => $rateDefinition->policy->id])
    //             ->with('success', 'Rate limits added to draft successfully');
    
    //     } catch (\Exception $e) {
    //         // Handle errors
    //         \Log::error('Error:', ['message' => $e->getMessage()]);
    //         return back()->withInput()
    //             ->with('error', 'An error occurred while handling changes: ' . $e->getMessage());
    //     }
    // }
    public function StoreLimits(Request $request, RateDefinition $rateDefinition)
    {
        try {
            // Validate other fields as before
            $validatedData = $request->validate([
                'grade' => 'required|array',
                'grade.*' => 'required|string',
                'region' => 'required|string',
                'limit_amount' => 'required|numeric',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after:start_date',
                'status' => 'required|in:active,inactive',
                // Add missing validation rules here, if any
            ]);
    
            // Retrieve an array of selected grades from the form
            $grades = $validatedData['grade'];
    
            // Initialize an array to store the draft rate limits
            $draftRateLimits = [];
    
            // Loop through each selected grade and check for existing rate limits
            foreach ($grades as $grade) {
                $existingRateLimit = $rateDefinition->rateLimits()
                    ->where('grade', $grade)
                    ->where('region', $validatedData['region'])
                    ->exists();
    
                if ($existingRateLimit) {
                    return redirect()->route('edit-rate-limits.create', ['rateDefinition' => $rateDefinition->id])
                        ->with('success', 'Rate limit for this grade and region already exists.');
                }
            }
    
            // Loop through each selected grade and create a new rate limit
            foreach ($grades as $grade) {
                $rateLimitData = [
                    'grade' => $grade,
                    'region' => $validatedData['region'],
                    'limit_amount' => $validatedData['limit_amount'],
                    'start_date' => $validatedData['start_date'],
                    'end_date' => $validatedData['end_date'],
                    'status' => $validatedData['status'],
                    'policy_id' => $rateDefinition->policy_id, // Store the policy_id
                    'rate_definition_id' => $rateDefinition->id,
                ];
    
                // Create the rate limit in the database
                $createdRateLimit = RateLimit::create($rateLimitData);
    
                // Fetch the ID of the created rate limit from the database
                $rateLimitId = $createdRateLimit->id;
    
                // Add the rate limit ID to the rate limit data
                $rateLimitData['id'] = $rateLimitId;
    
                // Add the rate limit data to the draft array
                $draftRateLimits[] = $rateLimitData;
            }
    
            // Store the draft rate limits in the session
            $request->session()->put('draft_rate_limits', $draftRateLimits);
    
            return redirect()->route('edit-rate-definition', ['policy' => $rateDefinition->policy->id])
                ->with('success', 'Rate limits added to draft and database successfully');
    
        } catch (\Exception $e) {
            // Handle errors
            \Log::error('Error:', ['message' => $e->getMessage()]);
            return back()->withInput()
                ->with('error', 'An error occurred while handling changes: ' . $e->getMessage());
        }
    }
    

    

    //Get Edit RateLimit
    public function editRateLimit(RateLimit $rateLimit, Request $request)
    {
       // Retrieve the existing rate limits data from the session, or initialize it as an empty array
$rateLimitsData = $request->session()->get('update_rate_limit', []);

// Get the current rate limit from the database
$currentRateLimit = RateLimit::findOrFail($rateLimit->id);

// Convert the rate limit model to an array if needed
$currentRateLimitArray = $currentRateLimit->toArray();

// Add the current rate limit data to the array of rate limits data
$rateLimitsData[] = $currentRateLimitArray;

// Store the updated array of rate limits data in the session
$request->session()->put('update_rate_limit', $rateLimitsData);

         //$request->session()->put('update_rate_limit', $currentRateLimit);


        $grades = Grade::all();
    
        return view('Expense.policy.edit_policy.rate_limit_edit', compact('rateLimit', 'grades'));
    }
// public function updateRateLimit(Request $request, RateLimit $rateLimit)
// {
//     try {
//         if ($request->has('cancel')) {
//             // Discard the draft data by removing it from the session
//             $request->session()->forget('update_rate_limit'); // Remove draft rate limit

//             // Redirect to the appropriate page or route after cancellation
//             return redirect()->route('edit-rate-limit', ['rateLimit' => $rateLimit->id])
//                 ->with('success', 'Changes canceled');
//         }

//         // Validate the submitted data
//         $validatedData = $request->validate([
//             'limit_amount' => 'required|numeric',
//             'start_date' => 'required|date',
//             'end_date' => 'nullable|date|after:start_date',
//         ]);

//         // Update the draft rate limit with the validated data
//         $draftRateLimit = $rateLimit;
//         $draftRateLimit->fill($validatedData);

//         // Store the draft rate limit in the session
//         $request->session()->put('update_rate_limit', $draftRateLimit);

//         return redirect()->route('edit-rate-definition', ['policy' => $rateLimit->rateDefinition->policy->id])
//             ->with('success', 'Rate limit draft updated successfully');
//     } catch (\Exception $e) {
//         // Handle errors
//         \Log::error('Error:', ['message' => $e->getMessage()]);
//         return back()->withInput()
//             ->with('error', 'An error occurred while handling changes: ' . $e->getMessage());
//     }
// }
    public function updateRateLimit(Request $request, RateLimit $rateLimit)
    {
        try {
        if ($request->has('cancel')) {
            // Discard the draft data by removing it from the session
            $request->session()->forget('update_rate_limit'); // Remove draft rate limit

            // Redirect to the appropriate page or route after cancellation
            return redirect()->route('edit-rate-limit', ['rateLimit' => $rateLimit->id])
                ->with('success', 'Changes canceled');
        }

         // Get the current rate limit from the database
         $currentRateLimit = RateLimit::findOrFail($rateLimit->id);

        // // Store the current rate limit in the session as draft (old data)
        // $request->session()->put('update_rate_limit', $currentRateLimit);

        // Validate the submitted data
        $validatedData = $request->validate([
            'limit_amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        // Update the rate limit in the database with the new data
        $currentRateLimit->update($validatedData);

        return redirect()->route('edit-rate-definition', ['policy' => $rateLimit->rateDefinition->policy->id])
            ->with('success', 'Rate limit draft updated successfully');
        } catch (\Exception $e) {
            // Handle errors
            \Log::error('Error:', ['message' => $e->getMessage()]);
            return back()->withInput()
                ->with('error', 'An error occurred while handling changes: ' . $e->getMessage());
        }
    }





    //Get Edit Policy Enforcement
    public function editPolicyEnforcement(Policy $policy)
    {
        $enforcementOptions = EnforcementOption::where('policy_id', $policy->id)->first();
        //dd($enforcementOptions);
        return view('Expense.policy.edit_policy.policy_enforcement_edit', compact('policy', 'enforcementOptions'));
    }
    public function updatePolicyEnforcement(Request $request, Policy $policy)
    {
        try {
            if ($request->has('cancel')) {
                // Discard the draft data by removing it from the session
                $request->session()->forget('update_policy_enforcement'); // Remove draft policy enforcement

                // Redirect back to the edit page with existing data
                return redirect()->route('edit-policy-enforcement', ['policy' => $policy->id]);
            }

            // Retrieve the existing policy enforcement options
            $enforcementOptions = EnforcementOption::firstOrNew(['policy_id' => $policy->id]);

            $validatedData = $request->validate([
                'enforcement_options' => [
                'array',
                Rule::in(['prevent_submission', 'display_warning', 'both']),
                ],
            ]);

            // Always update the policy enforcement options based on the form input
            $enforcementOptions->prevent_submission = in_array('prevent_submission', $validatedData['enforcement_options']);
            $enforcementOptions->display_warning = in_array('display_warning', $validatedData['enforcement_options']);

            // Store the draft policy enforcement in the session
            $request->session()->put('update_policy_enforcement', $enforcementOptions);

            // Redirect to the next page
            return redirect()->route('policy.summary', ['policy' => $policy->id])
                ->with('success', 'Policy enforcement draft updated successfully');
        } catch (\Exception $e) {
            \Log::error('Error:', ['message' => $e->getMessage()]);
            return back()->withInput()
                ->with('error', 'An error occurred while handling changes: ' . $e->getMessage());
        }
    }


    //Update Policy Summary
    // Method to fetch and display the policy summary
    public function getPolicySummary(Policy $policy, Request $request)
    {
        // Fetch policy details, rate definitions, rate limits, and policy enforcement
        $rateDefinitions = RateDefinition::where('policy_id', $policy->id)->get();
        $rateLimits = RateLimit::where('policy_id', $policy->id)
            ->with('gradeName')
            ->get();
        $policyEnforcements = EnforcementOption::where('policy_id', $policy->id)->first();
        $policyDetails = $policy; // Fetch policy details

        // Fetch the current rate definition and the draft rate definition
        //$currentRateDefinition = RateDefinition::where('policy_id', $policy->id)->first();
        // dd($currentRateDefinition);
        // $draftRateDefinition = session('draft_rate_definition');

        // Fetch the current policy and the draft policy
        $currentPolicy = Policy::find($policy->id);
        $draftPolicy = session('draft_policy');

        $draftRateLimits = session('draft_rate_limits');
        // dd($draftRateLimits);
        $draftRateLimit = session('update_rate_limit', []); // Provide an empty array as a default value
        //$draftRateLimit = session('update_rate_limits'); // Provide an empty array as a default value

       // dd($draftRateLimit);
   
        $draftPolicyEnforcement = session('update_policy_enforcement');
    

        return view('Expense.policy.edit_policy.policy_summary_update', compact('policy', 'currentPolicy', 'draftPolicy', 'rateDefinitions', 'rateLimits', 'policyEnforcements','draftRateLimit','draftRateLimits','draftPolicyEnforcement'));
    }

    // Method to handle the form submission to save or cancel changes for rate definition
    public function postPolicySummary(Request $request, Policy $policy)
    {
    try {
        $request->validate([
            // Define your validation rules here
        ]);

        if ($request->has('cancel')) {
            // Discard the draft rate definition data by removing it from the session
            $request->session()->forget('draft_policy');
           // Get the ID of the draft rate limit from the session
           $rateLimits = $request->session()->get('draft_rate_limits');
    
           // Check if there are rate limits in the session
           if ($rateLimits !== null) {
               foreach ($rateLimits as $rateLimit) {
                   $rateLimitId = $rateLimit['id'];
       
                   // Delete the rate limit from the database
                   RateLimit::find($rateLimitId)->delete();
               }
       
               // Remove the rate limits from the session
               $request->session()->forget('draft_rate_limits');
            }
            // // Restore the old rate limit data from session to the database
            // $draftRateLimit = $request->session()->get('update_rate_limit');
            // if ($draftRateLimit !== null) {
            //     $currentRateLimit = RateLimit::findOrFail($draftRateLimit['id']);
            //     $currentRateLimit->update($draftRateLimit); // Convert to array
            // }
            
            //$request->session()->forget('update_rate_limit');

           // Restore the old rate limit data from session to the database
$draftRateLimits = $request->session()->get('update_rate_limit', []);

if (!empty($draftRateLimits)) {
    foreach ($draftRateLimits as $draftRateLimit) {
        if (!empty($draftRateLimit['id'])) {
            $currentRateLimit = RateLimit::findOrFail($draftRateLimit['id']);

            // Update rate limit attributes from draft data
            $currentRateLimit->update($draftRateLimit);

            // Save the changes to the database
            $currentRateLimit->save();
        }
    }

    // Clear the session data for update_rate_limits
    $request->session()->forget('update_rate_limit');
}
        
            //$request->session()->forget('draft_rate_limits'); // Remove draft rate limits
          
            // Redirect to the appropriate page or route after cancellation
            return redirect()->route('edit-policy', ['policy' => $policy->id])
            ->with('success','Successfully Canceled');
        }

        if ($request->has('save')) {
                // Apply the changes from the draft to the main rate definition
                // $draftRateDefinition = $request->session()->get('draft_rate_definition');
                // $currentRateDefinition = RateDefinition::where('policy_id', $policy->id)->first();
            
                // if ($draftRateDefinition !== null) {
                //     $currentRateDefinition->update($draftRateDefinition->toArray());
                // }
           
                // Apply the changes from the draft to the main policy
                $draftPolicy = $request->session()->get('draft_policy');
                $currentPolicy = Policy::find($policy->id);
            
                if ($draftPolicy !== null) {
                    $currentPolicy->update($draftPolicy->toArray());
                }
            
                $request->session()->forget('draft_policy');

                // Apply the changes from the draft rate limits to the database
                $rateDefinitions = RateDefinition::where('policy_id', $policy->id)->get();
            
                // Apply the changes from the draft policy enforcement to the original policy enforcement
                $draftPolicyEnforcement = $request->session()->get('update_policy_enforcement');
                if ($draftPolicyEnforcement !== null) {
                     $policyEnforcements = EnforcementOption::firstOrNew(['policy_id' => $policy->id]);
                    $policyEnforcements->prevent_submission = $draftPolicyEnforcement->prevent_submission;
                    $policyEnforcements->display_warning = $draftPolicyEnforcement->display_warning;
                    $policyEnforcements->save();
                }

                // $request->session()->forget('draft_rate_definition'); // Remove draft rate definition
                $request->session()->forget('draft_rate_limits'); // Remove draft rate limits
                $request->session()->forget('update_rate_limit');
                $request->session()->forget('update_policy_enforcement');

                // Redirect to the appropriate page or route after saving
                return redirect()->route('edit-policy', ['policy' => $policy->id])
                    ->with('success', 'Policy and Rate definition updated successfully');
        }
    } catch (\Exception $e) {
        // Handle errors
        \Log::error('Error:', ['message' => $e->getMessage()]);
        return back()->withInput()
            ->with('error', 'An error occurred while handling changes: ' . $e->getMessage());
    }
}






}