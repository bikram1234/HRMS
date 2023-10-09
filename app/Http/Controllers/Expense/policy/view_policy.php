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
class view_policy  extends Controller
{
    public function viewpolicy(Policy $policy)
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
 
}

