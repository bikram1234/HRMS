<?php

namespace App\Http\Controllers\Advance\advance_type;
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

class advance_type  extends Controller
{
       //Get Advance Form
       public function showAdvanceForm()
       {
           $expenseTypes = ExpenseType::all();
           $advances = Advance::all(); // Retrieve the list of advances
           return view('Advance.advance_type.Advancetype', compact('expenseTypes', 'advances'));
       }
       public function addAdvance(Request $request)
       {
           $validatedData = $request->validate([
               'name' => 'required|string|max:255',
               'expense_type_id' => 'nullable|exists:expense_types,id',
               'start_date' => 'nullable|date',
               'end_date' => 'nullable|date|after:start_date',
               'status' => 'required|in:draft,enforce',
           ]);
   
           // If expense_type_id, start_date, and end_date are not provided, set default values
           $validatedData['expense_type_id'] = $validatedData['expense_type_id'] ?? null;
           $validatedData['start_date'] = $validatedData['start_date'] ?? null;
           $validatedData['end_date'] = $validatedData['end_date'] ?? null;
   
           Advance::create($validatedData);
   
           return redirect()->route('show-advance-form')
               ->with('success', 'Advance added successfully');
       }
}