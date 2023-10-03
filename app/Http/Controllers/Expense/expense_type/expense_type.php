<?php

namespace App\Http\Controllers\Expense\expense_type;
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

class expense_type  extends Controller
{ 
        // Get Expense_type 
        public function showAddForm()
        {
            $expenseTypes = ExpenseType::all(); // Assuming ExpenseType is your model
            return view('Expense.expense_type.expensetype', compact('expenseTypes'));
        }
        //Add Expense_type Method 
        public function addExpenseType(Request $request)
        {
            try {
                 //dd($request->all()); 
            // Validate the input
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after:start_date',
                'status' => 'required|in:enforce,draft',
            ]);
    
            // Create a new expense type
            ExpenseType::create($validatedData);
    
            return redirect()->route('expense-types')
                ->with('success', 'Expense type added successfully');
    
            } catch (\Exception $e) {
                $errorMessage = 'An error occurred while saving the expense type';
                
                if ($e instanceof ValidationException) {
                    // Log validation errors
                    \Log::error($errorMessage . ': ' . json_encode($e->errors()), 400);
                } else {
                    // Log other exceptions
                    \Log::error($errorMessage . ': ' . $e->getMessage());
                    \Log::error('Stack Trace: ' . $e->getTraceAsString());
                }
            
                return response()->json(['error' => $errorMessage], 500);
            }
            
        }

 }