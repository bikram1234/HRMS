<?php

namespace App\Http\Controllers\Expense\expense_approval;
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

class expense_approval_Controller  extends Controller
{
    // public function show_pending_expense_application()
    // {
    //     $expense_approval = ExpenseApplication::with('expenseType')
    //     ->whereIn('status', ['pending', 'approved'])
    //     ->get();
    
    //     return view('Expense.expense_approval.expense_approval', compact('expense_approval'));

    // }
    public function show_pending_expense_application(Request $request)
{
    $status = $request->input('status');

    $query = ExpenseApplication::with('expenseType');

    if ($status) {
        $query->where('status', $status);
    } else {
        $query->whereIn('status', ['pending', 'approved']);
    }

    $expense_approval = $query->get();

    return view('Expense.expense_approval.expense_approval', compact('expense_approval'));
}

}