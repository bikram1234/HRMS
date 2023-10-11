<?php

namespace App\Http\Controllers\Expense\dsa_approval;
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

class dsa_approval_Controller  extends Controller
{
    public function show_dsa_approval_application(Request $request){
        
        $query = DsaSettlement::query();

        $status = $request->input('status');
    
        if ($status) {
            $query->where('status', $status);
        }
    
        $dsaSettlements = $query->get();
    
        return view('Expense.dsa_approval.dsa_approval', compact('dsaSettlements'));
    
    }

    public function view_DsaSettlement_detail($id){
         // Retrieve the specific DsaSettlement record by ID
    $dsaSettlement = DsaSettlement::find($id);

    if (!$dsaSettlement) {
        return abort(404); // Handle if the record is not found
    }

    // Check if the DsaSettlement has an advance number or not
    if ($dsaSettlement->advance_no === null) {
        $type = 'No Advance';
    } else {
        $type = 'With Advance';
    }

    // Retrieve associated DsaManualSettlement records for this DsaSettlement
    $dsaManualSettlements = $dsaSettlement->manualSettlements;

    return view('Expense.dsa_approval.view_dsa_approval_details', [
        'dsaSettlement' => $dsaSettlement,
        'type' => $type,
        'dsaManualSettlements' => $dsaManualSettlements,
    ]);
    }

}