<?php

namespace App\Http\Controllers\Expense\dsa_claim;
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
use App\Models\approvalRule;
use App\Models\approval_condition;
use App\Models\AdvanceApplication;
use App\Models\level;
use App\Mail\LeaveApplicationMail;
use App\Mail\ExpenseApplicationMail;


class dsa_settlement  extends Controller
{
      //Get DsaSettlment Form
public function dsaSettlementForm() {
    
    $user = Auth::user();
   // Retrieve all advances from the user's dsaAdvances relationship with status "approved"
   //$userAdvances = $user->dsaAdvances->where('status', 'approved')->pluck('advance_no', 'id');
   $userAdvances = AdvanceApplication::whereHas('advanceType', function ($query) {
    $query->where('name', 'DSA Advance');
    })
    ->where('status', 'approved')
    ->where('user_id', $user->id) // Assuming user_id is the column in the AdvanceApplication table that corresponds to the user
    ->pluck('advance_no', 'id');
    //dd($userAdvances);

   // Get the IDs of advances that exist in the dsa_settlements table
   $existingAdvanceIds = DB::table('dsa_settlements')->pluck('advance_application_id');

  // Filter the user's advances to include only those that do not exist in the dsa_settlements table
  $userAdvances = $userAdvances->filter(function ($advanceNo, $id) use ($existingAdvanceIds) {
    return !$existingAdvanceIds->contains($id);
});

    
    $advanceAmounts = AdvanceApplication::whereHas('advanceType', function ($query) {
        $query->where('name', 'DSA Advance');
        })
        ->where('status', 'approved')
        ->where('user_id', $user->id) // Assuming user_id is the column in the AdvanceApplication table that corresponds to the user
        ->pluck('amount', 'id');
    //dd($advanceAmounts);
    
    // Find the ExpenseType with name "DSA Settlement"
    $expenseType = ExpenseType::where('name', 'DSA Settlement')->first();
    if ($expenseType) {
        $expenseTypeId = $expenseType->id;
        // Use the $expenseTypeId as needed
        echo $expenseTypeId; // or return $expenseTypeId; if you're in a function
    } else {
        // Handle the case where the expense type does not exist
        echo "Expense type not found.";
    }
    //dd($expenseTypeId);
    
    if ($expenseType) {
        // Find the Policies associated with the ExpenseType
        $policies = $expenseType->policies;
        
    
        // Get policy IDs
        $policyIds = $policies->pluck('id')->toArray();
    
        // Find the RateLimits with the same policy ID and user's grade
        $rateLimits = RateLimit::whereIn('policy_id', $policyIds)
            ->where('grade', $user->grade_id)
            ->get();
            //dd($rateLimits);
    
        // Check if there are matching rate limits
        if ($rateLimits->isEmpty()) {
            $daAmountFromBackend = 0; // Handle the case where rate limits with the user's grade don't exist
        } else {
            // You can choose how to handle multiple rate limits here; for now, let's take the first one
            $rateLimit = $rateLimits->first();
            $daAmountFromBackend = $rateLimit->limit_amount;
        }
    } else {
        $daAmountFromBackend = 0; // Handle the case where the DSA policy doesn't exist
    }
    
    return view('Expense.dsa_claim.dsa_settlement_form', [
        'userAdvances' => $userAdvances,
        'advanceAmounts' => $advanceAmounts,
        'daAmountFromBackend' => $daAmountFromBackend,
        'expenseTypeId'=>$expenseTypeId,
    ]);
    }
    public function calculateDsaSettlement(Request $request)
    {
        try {
            $expenseType = ExpenseType::where('name', 'DSA Settlement')->first();
            if ($expenseType) {
                $expenseTypeId = $expenseType->id;
                // Use the $expenseTypeId as needed
                echo $expenseTypeId; // or return $expenseTypeId; if you're in a function
            } else {
                // Handle the case where the expense type does not exist
                echo "Expense type not found.";
            }
        //dd($request->all()); 
            $validatedData = $request->validate([
                'advance_number' => 'sometimes|required|string', // Use 'sometimes' to conditionally require the field.
                'manual_ta' => $request->has('advance_number') ? 'nullable|array' : 'required_if:advance_number,null|array', // Set to null when 'advance_number' is present.
                'manual_from_date' => $request->has('advance_number') ? 'nullable|array' : 'required|array',
                'manual_from_date.*' => $request->has('advance_number') ? 'nullable|date' : 'required|date',
                'manual_from_location' => $request->has('advance_number') ? 'nullable|array' : 'required|array',
                'manual_from_location.*' => $request->has('advance_number') ? 'nullable|string' : 'required|string',
                'manual_to_date' => $request->has('advance_number') ? 'nullable|array' : 'required|array',
                'manual_to_date.*' => $request->has('advance_number') ? 'nullable|date' : 'required|date',
                'manual_to_location' => $request->has('advance_number') ? 'nullable|array' : 'required|array',
                'manual_to_location.*' => $request->has('advance_number') ? 'nullable|string' : 'required|string',
                'manual_total_amount' => $request->has('advance_number') ? 'nullable|array' : 'required|array',
                'manual_total_amount.*' => $request->has('advance_number') ? 'nullable|numeric' : 'required|string',
                'manual_remark' => $request->has('advance_number') ? 'nullable|array' : 'required|array',
                'manual_remark.*' => $request->has('advance_number') ? 'nullable|string' : 'required|string',
                'dsa_settlement' => 'required_if:advance_number,null|array',           
               // Conditionally require DSA settlement fields only when 'advance_number' is null
        'dsa_settlement.dsa_amount' => 'required_if:advance_number,null|numeric',
        'dsa_settlement.net_payable_amount' => 'required_if:advance_number,null|numeric',
        'dsa_settlement.balance_amount' => 'required_if:advance_number,null|numeric',
        'dsa_settlement.status' => 'required_if:advance_number,null|string',
        'dsa_settlement.upload_file' => 'nullable|mimes:pdf|max:2048', // Max 2 MB PDF file

            ]);
            
            if ($request->has('advance_number')) {
                $advanceNumber = $request->input('advance_number');
            } else {
                $manualTa = $request->input('manual_ta');
            }
    
    
             //Calculate total days between from_date and to_date
                $fromDate = Carbon::parse($request->input('manual_from_date')[0]); // Assuming the date is an array
                $toDate = Carbon::parse($request->input('manual_to_date')[0]); // Assuming the date is an array
                
                // Calculate the total days difference
                $totalDays = $fromDate->diffInDays($toDate) + 1;
    
    
            $user_id = Auth::id();
            $advanceNumber = $request->input('advance_number');
    
            $selectedAdvance = AdvanceApplication::where('user_id', $user_id)
                ->where('advance_no', $advanceNumber)
                ->first();
            // $selectedAdvance = AdvanceApplication::whereHas('advanceType', function ($query) {
            //     $query->where('name', 'DSA Advance');
            //     })
            //     ->where('status', 'approved')
            //     ->where('user_id', $user_id) // Assuming user_id is the column in the AdvanceApplication table that corresponds to the user
            //     ->where('advance_no', $advanceNumber)
            //     ->first();

            if (!$selectedAdvance || !$advanceNumber) {
                $manualTa = $request->input('manual_ta', []);
                $manualFromDate = $request->input('manual_from_date', []);
                $manualFromLocation = $request->input('manual_from_location', []);
                $manualToDate = $request->input('manual_to_date', []);
                $manualToLocation = $request->input('manual_to_location', []);
                $manualTotalAmount = $request->input('manual_total_amount', []);
    
                if (
                    empty($manualTa) || empty($manualFromDate) ||
                    empty($manualFromLocation) || empty($manualToDate) ||
                    empty($manualToLocation) || empty($manualTotalAmount)
                ) {
                    return redirect()->route('dsa-settlement-form')
                        ->with('success', 'Invalid or empty manual settlement data');
                }
    
                $daAmount = 0; // Initialize DA amount
                $manualRemark = $request->input('manual_remark', []); // Initialize $manualRemark
                $dsaSettlement = new DsaSettlement([
                    'user_id' => $user_id,
                    'advance_no' => null,
                    'advance_amount' => 0,
                    'total_amount_adjusted' => array_sum($manualTotalAmount),
                    'net_payable_amount' => array_sum($manualTotalAmount),
                    'balance_amount' => 0,
                    'status' => 'pending',
                    'upload_file' => $request->file('upload_file'), // Max 2 MB PDF file


                ]);
                            // Check if expense_type exists
                             $expenseType = ExpenseType::find($expenseTypeId);
                             if (!$expenseType) {
                                 return redirect()->back()
                                     ->with('success', 'Invalid expense type.');
                             }
                                         // Retrieve the associated policy for the selected expense type
                             $policy = $expenseType->policies->first(); // Assuming you want the first associated policy
                         
                             if (!$policy) {
                                 return redirect()->back()
                                     ->with('success', 'There is no policy defined for this Expense Type.');
                             }
                                         // Find the rate definition associated with the policy_id
                             $rateDefinition = $policy->rateLimits->first()->rateDefinition; // Assuming you want the first associated rate definition
                         
                             if (!$rateDefinition) {
                                 return redirect()->back()
                                     ->with('success', 'This policy have not yet any Rate Definitions at all.');
                             }
                             // Check if attachment is required based on the rate definition
                             if ($rateDefinition->attachment_required == 1) {
                                 // Attachment is required
                                 if (!$request->hasFile('upload_file')) {
                                     return redirect()->back()
                                         ->with('success', 'Attachment is required.');
                                 }
                                     $attachment = $request->file('upload_file');
                                 if ($attachment->getSize() > 2048000) { // 2MB in bytes
                                     return redirect()->back()
                                         ->with('success', 'The attachment file size must not exceed 2MB.');
                                 } 
                                 $attachmentPath = $attachment->storeAs('uploads', $attachment->getClientOriginalName(), 'local');
                                 $validatedData['upload_file'] = $attachmentPath;
                                 
                             }
                
                $dsaSettlement->save();
                
                // Initialize an array to store DsaManualSettlement records
                $manualSettlements = [];
                
                foreach ($manualTa as $index => $ta) {
                    // Find the ExpenseType with name "DSA Settlement"
                    $expenseType = ExpenseType::where('name', 'DSA Settlement')->first();
                    
                    if ($expenseType) {
                        // Find the Policies associated with the ExpenseType
                        $policies = $expenseType->policies;
                        
                        // Get policy IDs
                        $policyIds = $policies->pluck('id')->toArray();
                        
                        // Find the RateLimits with the same policy ID and user's grade
                        $rateLimits = RateLimit::whereIn('policy_id', $policyIds)
                            ->where('grade', Auth::user()->grade_id)
                            ->get();
                        
                        // Check if there are matching rate limits
                        if ($rateLimits->isEmpty()) {
                            $da = 0; // Handle the case where rate limits with the user's grade don't exist
                        } else {
                            // You can choose how to handle multiple rate limits here; for now, let's take the first one
                            $rateLimit = $rateLimits->first();
                            $da = $rateLimit->limit_amount;
                        }
                    } else {
                        $da = 0; // Handle the case where the DSA policy doesn't exist
                    }
                    
                    // Calculate total days between from_date and to_date
                    $fromDate = Carbon::parse($manualFromDate[$index]);
                    $toDate = Carbon::parse($manualToDate[$index]);
                    $totalDays = $fromDate->diffInDays($toDate) + 1;
                
                    $manualSettlement = [
                        'user_id' => $user_id,
                        'from_date' => $manualFromDate[$index],
                        'from_location' => $manualFromLocation[$index],
                        'to_date' => $manualToDate[$index],
                        'to_location' => $manualToLocation[$index],
                        'total_days' => $totalDays,
                        'da' => $da,
                        'ta' => $ta,
                        'total_amount' => ($da * $totalDays) + $ta,
                        'remark' => $manualRemark[$index],
                    ];
                    $expense_id = $expenseTypeId;
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

                    $approvalRuleId = approvalRule::where('type_id', $expense_id)->value('id');
                    $approvalType = approval_condition::where('approval_rule_id', $approvalRuleId)->first();
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

                
                    // Insert DsaManualSettlement records and associate them with DsaSettlement
                    $dsaManualSettlement = new DsaManualSettlement($manualSettlement);
                    $dsaSettlement->manualSettlements()->save($dsaManualSettlement);
                }
                
                if ($request->hasFile('upload_file')) {
                    // Handle file upload here if needed
                }
                
                return redirect()->route('dsa-settlement-form')
                    ->with('success', 'DSA Settlement added successfully');
                
            }
            if ($selectedAdvance && $advanceNumber) {
                $advanceAmount = $selectedAdvance->amount;
            
                $dsaSettlement = new DsaSettlement([
                    'user_id' => $user_id,
                    'advance_no' => $advanceNumber,
                    'advance_amount' => $advanceAmount,
                    'total_amount_adjusted' => $advanceAmount,
                    'net_payable_amount' => $advanceAmount,
                    'balance_amount' => 0,
                    'status' => 'pending',
                    'upload_file' => $request->file('upload_file'), // Max 2 MB PDF file



                ]);
                $expenseType = ExpenseType::find($expenseTypeId);
                if (!$expenseType) {
                    return redirect()->back()
                        ->with('success', 'Invalid expense type.');
                }
                            // Retrieve the associated policy for the selected expense type
                $policy = $expenseType->policies->first(); // Assuming you want the first associated policy
            
                if (!$policy) {
                    return redirect()->back()
                        ->with('success', 'There is no policy defined for this Expense Type.');
                }
                            // Find the rate definition associated with the policy_id
                $rateDefinition = $policy->rateLimits->first()->rateDefinition; // Assuming you want the first associated rate definition
            
                if (!$rateDefinition) {
                    return redirect()->back()
                        ->with('success', 'This policy have not yet any Rate Definitions at all.');
                }
                // Check if attachment is required based on the rate definition
                if ($rateDefinition->attachment_required == 1) {
                    // Attachment is required
                    if (!$request->hasFile('upload_file')) {
                        return redirect()->back()
                            ->with('success', 'Attachment is required.');
                    }
                        $attachment = $request->file('upload_file');
                    if ($attachment->getSize() > 2048000) { // 2MB in bytes
                        return redirect()->back()
                            ->with('success', 'The attachment file size must not exceed 2MB.');
                    } 
                    $attachmentPath = $attachment->storeAs('uploads', $attachment->getClientOriginalName(), 'local');
                    $dsaSettlement['upload_file'] = $attachmentPath;
                    

                }
                $selectedAdvance->dsaSettlement()->save($dsaSettlement);
        
                
                // Set the fields in the "dsa_manual_settlements" table to null
                // Based on your table structure, update these fields as needed
                $dsaManualSettlementAttributes = [
                    'user_id' => $user_id,
                    'from_date' => null,
                    'from_location' => null,
                    'to_date' => null,
                    'to_location' => null,
                    'total_days' => null,
                    'total_amount' => null,
                    'remark' => null,
                ];
                $expense_id = $expenseTypeId;
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

                $approvalRuleId = approvalRule::where('type_id', $expense_id)->value('id');
                $approvalType = approval_condition::where('approval_rule_id', $approvalRuleId)->first();
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
            
                // Insert DsaManualSettlement records and associate them with DsaSettlement
                $dsaSettlement->manualSettlements()->create($dsaManualSettlementAttributes);
            
                return redirect()->route('dsa-settlement-form')
                    ->with('success', 'DSA Settlement added successfully');
            }
            
            
        } catch (\Exception $e) {
            $errorMessage = 'An error occurred while saving the settlement';
            \Log::error($errorMessage . ': ' . $e->getMessage());
            \Log::error('Stack Trace: ' . $e->getTraceAsString());
    
            return response()->json(['error' => $errorMessage], 500);
        }
    }
    
    
    public function DSAretrieveData()
    {
        $user_id = Auth::id();
    
        // Retrieve all DsaSettlement records for the user
        $dsaSettlements = DsaSettlement::where('user_id', $user_id)->get();
    
        // Initialize an array to store the data
        $data = [];
    
        foreach ($dsaSettlements as $dsaSettlement) {
            // Check if the DsaSettlement has an advance number or not
            if ($dsaSettlement->advance_no === null) {
                $type = 'No Advance';
            } else {
                $type = 'With Advance';
            }
    
            // Retrieve associated DsaManualSettlement records for this DsaSettlement
            $dsaManualSettlements = $dsaSettlement->manualSettlements;
    
            // Add data for this DsaSettlement and its associated DsaManualSettlements
            $data[] = [
                'dsaSettlement' => $dsaSettlement,
                'type' => $type,
                'dsaManualSettlements' => $dsaManualSettlements,
            ];
        }
    
        return view('Expense.dsa_claim.dsalist', [
            'data' => $data,
        ]);
    }
    
}