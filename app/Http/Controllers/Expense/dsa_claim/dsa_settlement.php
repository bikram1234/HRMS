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

class dsa_settlement  extends Controller
{
      //Get DsaSettlment Form
public function dsaSettlementForm() {
    
    $user = Auth::user();
   // Retrieve all advances from the user's dsaAdvances relationship with status "approved"
   $userAdvances = $user->dsaAdvances->where('status', 'approved')->pluck('advance_no', 'id');

   // Get the IDs of advances that exist in the dsa_settlements table
   $existingAdvanceIds = DB::table('dsa_settlements')->pluck('dsa_advance_id');

  // Filter the user's advances to include only those that do not exist in the dsa_settlements table
  $userAdvances = $userAdvances->filter(function ($advanceNo, $id) use ($existingAdvanceIds) {
    return !$existingAdvanceIds->contains($id);
});

    
    $advanceAmounts = $user->dsaAdvances->pluck('amount', 'id');
    //dd($advanceAmounts);
    
    // Find the ExpenseType with name "DSA Settlement"
    $expenseType = ExpenseType::where('name', 'DSA Settlement')->first();
    
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
    ]);
    }
    public function calculateDsaSettlement(Request $request)
    {
        try {
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
    
            $selectedAdvance = DsaAdvance::where('user_id', $user_id)
                ->where('advance_no', $advanceNumber)
                ->first();
    
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
                ]);
                
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
                ]);
            
                $selectedAdvance->dsaSettlement()->save($dsaSettlement);
            
                if ($request->hasFile('upload_file')) {
                    // Handle file upload here if needed
                }
                
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